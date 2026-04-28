<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class SalesPageGenerator
{
    protected string $provider;

    public function __construct()
    {
        $this->provider = strtolower((string) config('services.ai.provider', 'gemini'));
    }

    /**
     * Generate a structured sales page from product input.
     */
    public function generate(array $input): array
    {
        $input = $this->normalize($input);

        try {
            return match ($this->provider) {
                'anthropic' => $this->callAnthropic($input),
                'gemini' => $this->callGemini($input),
                default => throw new RuntimeException("Unknown AI provider: {$this->provider}"),
            };
        } catch (\Throwable $e) {
            Log::warning('SalesPageGenerator: API call failed, using fallback.', [
                'provider' => $this->provider,
                'error' => $e->getMessage(),
            ]);
            $fallback = $this->fallback($input);
            $fallback['_error'] = "AI service ({$this->provider}) unavailable: ".$e->getMessage().' (showing template-based draft)';
            return $fallback;
        }
    }

    protected function normalize(array $input): array
    {
        $features = $input['features'] ?? [];
        if (is_string($features)) {
            $features = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $features))));
        }

        return [
            'product_name' => trim($input['product_name'] ?? ''),
            'description' => trim($input['description'] ?? ''),
            'features' => array_values(array_filter($features)),
            'target_audience' => trim($input['target_audience'] ?? ''),
            'price' => isset($input['price']) ? trim((string) $input['price']) : '',
            'unique_selling_points' => trim((string) ($input['unique_selling_points'] ?? '')),
            'tone' => $input['tone'] ?? 'persuasive',
            'template' => $input['template'] ?? 'modern',
        ];
    }

    protected function caBundle(): string|bool
    {
        $caBundle = storage_path('certs/cacert.pem');
        return is_file($caBundle) ? $caBundle : true;
    }

    protected function callAnthropic(array $input): array
    {
        $apiKey = config('services.anthropic.key');
        if (empty($apiKey)) {
            throw new RuntimeException('ANTHROPIC_API_KEY is not configured.');
        }

        $model = config('services.anthropic.model', 'claude-haiku-4-5-20251001');
        $baseUrl = rtrim(config('services.anthropic.base_url', 'https://api.anthropic.com/v1'), '/');
        $prompt = $this->buildPrompt($input);

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            'anthropic-version' => '2023-06-01',
            'content-type' => 'application/json',
        ])->withOptions(['verify' => $this->caBundle()])->timeout(60)->post($baseUrl.'/messages', [
            'model' => $model,
            'max_tokens' => 2048,
            'temperature' => 0.7,
            'system' => $this->systemPrompt(),
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        if (!$response->successful()) {
            throw new RuntimeException('Anthropic API returned HTTP '.$response->status().': '.$response->body());
        }

        $body = $response->json();
        $text = collect($body['content'] ?? [])->firstWhere('type', 'text')['text'] ?? '';
        if ($text === '') {
            throw new RuntimeException('Anthropic API returned empty content.');
        }

        return $this->validate($this->extractJson($text));
    }

    protected function callGemini(array $input): array
    {
        $apiKey = config('services.gemini.key');
        if (empty($apiKey)) {
            throw new RuntimeException('GEMINI_API_KEY is not configured.');
        }

        $primary = config('services.gemini.model', 'gemini-2.5-flash');
        // Fallback chain — when the primary returns 503/429 (overloaded/rate-limited),
        // try progressively cheaper / less-busy models. The user's primary always comes first.
        $candidates = array_values(array_unique([
            $primary,
            'gemini-2.5-flash-lite',
            'gemini-2.0-flash',
            'gemini-2.0-flash-lite',
        ]));

        $baseUrl = rtrim(config('services.gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta'), '/');
        $payload = [
            'systemInstruction' => ['parts' => [['text' => $this->systemPrompt()]]],
            'contents' => [['role' => 'user', 'parts' => [['text' => $this->buildPrompt($input)]]]],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 4096,
                'responseMimeType' => 'application/json',
                'thinkingConfig' => ['thinkingBudget' => 0],
            ],
        ];

        $lastError = '';
        foreach ($candidates as $idx => $model) {
            // Up to 2 attempts per model with short backoff for transient errors.
            for ($attempt = 1; $attempt <= 2; $attempt++) {
                $endpoint = $baseUrl.'/models/'.$model.':generateContent?key='.urlencode($apiKey);
                try {
                    $response = Http::withHeaders(['content-type' => 'application/json'])
                        ->withOptions(['verify' => $this->caBundle()])
                        ->timeout(60)
                        ->post($endpoint, $payload);
                } catch (\Throwable $e) {
                    $lastError = $e->getMessage();
                    Log::warning("Gemini network error on {$model} attempt {$attempt}: ".$lastError);
                    if ($attempt < 2) { usleep(750_000); }
                    continue;
                }

                if ($response->successful()) {
                    $body = $response->json();
                    $text = $body['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    if ($text !== '') {
                        return $this->validate($this->extractJson($text));
                    }
                    $lastError = "Empty content from {$model}";
                    Log::warning($lastError);
                    continue 2; // try next model
                }

                $status = $response->status();
                $lastError = "Gemini {$model} HTTP {$status}: ".$response->body();
                Log::warning("Gemini {$model} attempt {$attempt} failed: {$lastError}");

                // Retryable: 429 (rate limited), 500/502/503/504 (overloaded/transient).
                if (in_array($status, [429, 500, 502, 503, 504], true)) {
                    if ($attempt < 2) {
                        usleep(750_000); // 0.75 s backoff
                        continue;
                    }
                    // Exhausted attempts on this model → cascade to the next candidate.
                    continue 2;
                }

                // Non-retryable (400/401/403 etc.) → no point trying other models with same key.
                throw new RuntimeException($lastError);
            }
        }

        throw new RuntimeException('All Gemini fallback models failed. Last error: '.$lastError);
    }

    protected function systemPrompt(): string
    {
        return <<<'PROMPT'
You are a senior direct-response copywriter and conversion specialist. Your job is to turn raw product data
into a complete, persuasive sales-page copy structure.

You ALWAYS respond with a single valid JSON object — no prose, no markdown fences, no commentary outside JSON.

The JSON object MUST conform to this exact schema:
{
  "headline": "string — 8-14 word benefit-led headline",
  "sub_headline": "string — 1 sentence supporting promise",
  "description": "string — 2-3 short paragraphs of compelling product narrative",
  "benefits": [{"title": "string", "body": "string"}, ... 3-5 items],
  "features_breakdown": [{"title": "string", "body": "string"}, ... 3-6 items],
  "social_proof": [{"quote": "string", "author": "string", "role": "string"}, ... 2-3 items],
  "pricing_display": {"label": "string", "price": "string", "note": "string"},
  "cta": {"primary": "string (action verb, <= 5 words)", "secondary": "string", "urgency": "string"}
}

Use the requested tone consistently. Make every line specific to the product — never generic. The
social_proof testimonials are realistic placeholders; mark them as illustrative by using plausible names
and roles relevant to the target audience.
PROMPT;
    }

    protected function buildPrompt(array $input): string
    {
        $features = empty($input['features']) ? '(none provided)' : '- '.implode("\n- ", $input['features']);

        return <<<PROMPT
Generate a sales page for the following product. Respond with the JSON object only.

PRODUCT NAME: {$input['product_name']}
DESCRIPTION: {$input['description']}
KEY FEATURES:
{$features}
TARGET AUDIENCE: {$input['target_audience']}
PRICE: {$input['price']}
UNIQUE SELLING POINTS: {$input['unique_selling_points']}
DESIRED TONE: {$input['tone']}
DESIGN TEMPLATE: {$input['template']}
PROMPT;
    }

    protected function extractJson(string $text): array
    {
        $text = trim($text);
        if (preg_match('/```(?:json)?\s*(.+?)\s*```/s', $text, $m)) {
            $text = $m[1];
        }
        $start = strpos($text, '{');
        $end = strrpos($text, '}');
        if ($start === false || $end === false || $end <= $start) {
            throw new RuntimeException('No JSON object found in model response.');
        }
        $json = substr($text, $start, $end - $start + 1);
        $decoded = json_decode($json, true);
        if (!is_array($decoded)) {
            throw new RuntimeException('Failed to parse JSON: '.json_last_error_msg());
        }
        return $decoded;
    }

    protected function validate(array $data): array
    {
        $required = ['headline', 'sub_headline', 'description', 'benefits', 'features_breakdown', 'social_proof', 'pricing_display', 'cta'];
        foreach ($required as $key) {
            if (!array_key_exists($key, $data)) {
                throw new RuntimeException("Generated content missing required key: {$key}");
            }
        }
        return $data;
    }

    protected function fallback(array $input): array
    {
        $name = $input['product_name'] ?: 'Your Product';
        $audience = $input['target_audience'] ?: 'modern professionals';
        $tone = $input['tone'] ?: 'persuasive';
        $features = $input['features'] ?: ['Premium quality', 'Fast results', 'Reliable support'];
        $price = $input['price'] ?: 'Contact us';
        $usp = $input['unique_selling_points'] ?: 'Built specifically for '.$audience.'.';
        $desc = $input['description'] ?: "{$name} helps {$audience} achieve more with less effort.";

        $headline = match ($tone) {
            'formal' => "{$name}: A Considered Solution for {$audience}",
            'casual' => "Meet {$name} — the easier way for {$audience}",
            'urgent' => "Stop Settling. {$name} Is Built for {$audience}.",
            default => "Transform Your Results with {$name}",
        };

        $benefits = collect($features)->take(4)->map(fn ($f, $i) => [
            'title' => 'Benefit '.($i + 1).': '.\Illuminate\Support\Str::limit($f, 40),
            'body' => "Designed so {$audience} can capture the value of \"{$f}\" without the usual learning curve.",
        ])->values()->all();

        if (count($benefits) < 3) {
            $benefits[] = ['title' => 'Save time every week', 'body' => "Cut hours of busywork with workflows tuned for {$audience}."];
            $benefits[] = ['title' => 'Confidence built-in', 'body' => 'Sensible defaults, clear guidance, and predictable outcomes.'];
            $benefits[] = ['title' => 'Grows with you', 'body' => 'Whether you are starting out or scaling up, the experience stays simple.'];
            $benefits = array_slice($benefits, 0, 4);
        }

        $featuresBreakdown = collect($features)->map(fn ($f) => [
            'title' => \Illuminate\Support\Str::limit($f, 60),
            'body' => "A focused capability that addresses a specific need of {$audience}.",
        ])->values()->all();

        $socialProof = [
            ['quote' => "{$name} replaced three tools and saved my team a full day each week.", 'author' => 'Alex Morgan', 'role' => 'Operations Lead'],
            ['quote' => 'Setup took ten minutes. Results showed up the same week.', 'author' => 'Priya Shah', 'role' => 'Founder'],
            ['quote' => "Honestly the best investment we've made this quarter.", 'author' => 'Daniel Reyes', 'role' => 'Marketing Director'],
        ];

        return [
            'headline' => $headline,
            'sub_headline' => $usp,
            'description' => "{$desc}\n\nWith {$name}, you stop juggling tools and start shipping outcomes. Every detail is designed around how {$audience} actually work — fewer clicks, fewer surprises, more wins you can point at.",
            'benefits' => $benefits,
            'features_breakdown' => $featuresBreakdown,
            'social_proof' => $socialProof,
            'pricing_display' => [
                'label' => 'One-time investment',
                'price' => $price,
                'note' => 'Includes onboarding and standard support.',
            ],
            'cta' => [
                'primary' => 'Get Started Now',
                'secondary' => 'Talk to Our Team',
                'urgency' => 'Limited launch pricing — review the details before committing.',
            ],
        ];
    }
}
