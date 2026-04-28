@php
    $content = $page->generated_content ?? [];
    $template = $page->template ?? 'modern';

    /*
     | Cinematic, premium identity per template.
     | Bold accent + soft black + bone neutral. Strong glow + depth.
     */
    $accents = [
        'modern' => [
            'name' => 'coral', 'hex' => '#FF5A36', 'rgb' => '255,90,54',
            'btn' => 'bg-[#FF5A36] hover:bg-[#FF6B49] text-white',
            'text' => 'text-[#FF5A36]',
            'soft' => 'bg-[#FF5A36]/10 text-[#FF5A36] ring-[#FF5A36]/30',
            'soft_strong' => 'bg-[#FFE4DC] text-[#C44425] ring-[#FF5A36]/20',
            'glow' => 'from-[#FF5A36] via-[#FF8A65] to-[#FFB088]',
            'orb' => 'from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8]',
            'accent2_class' => 'bg-teal-500',
            'accent2_text' => 'text-teal-400',
        ],
        'classic' => [
            'name' => 'electric', 'hex' => '#3B82F6', 'rgb' => '59,130,246',
            'btn' => 'bg-[#3B82F6] hover:bg-[#2563EB] text-white',
            'text' => 'text-[#3B82F6]',
            'soft' => 'bg-[#3B82F6]/10 text-[#3B82F6] ring-[#3B82F6]/30',
            'soft_strong' => 'bg-[#DBE3F8] text-[#1E40AF] ring-[#3B82F6]/20',
            'glow' => 'from-[#3B82F6] via-[#60A5FA] to-[#93C5FD]',
            'orb' => 'from-[#3B82F6] via-[#60A5FA] to-[#BFDBFE]',
            'accent2_class' => 'bg-amber-400',
            'accent2_text' => 'text-amber-400',
        ],
        'bold' => [
            'name' => 'teal', 'hex' => '#2DD4BF', 'rgb' => '45,212,191',
            'btn' => 'bg-[#0D9488] hover:bg-[#0F8A7E] text-white',
            'text' => 'text-[#2DD4BF]',
            'soft' => 'bg-[#0D9488]/10 text-[#0D9488] ring-[#0D9488]/30',
            'soft_strong' => 'bg-[#CCEFEA] text-[#0F766E] ring-[#0D9488]/20',
            'glow' => 'from-[#0D9488] via-[#2DD4BF] to-[#99F6E4]',
            'orb' => 'from-[#0D9488] via-[#2DD4BF] to-[#CFF7F0]',
            'accent2_class' => 'bg-[#FF5A36]',
            'accent2_text' => 'text-[#FF5A36]',
        ],
    ];
    $a = $accents[$template] ?? $accents['modern'];

    $benefits = $content['benefits'] ?? [];
    $features = $content['features_breakdown'] ?? [];
    $reviews = $content['social_proof'] ?? [];
    $cta = $content['cta'] ?? ['primary' => 'Get Started', 'secondary' => 'Learn More', 'urgency' => ''];
    $pricing = $content['pricing_display'] ?? ['label' => 'Pricing', 'price' => $page->price ?: 'Contact', 'note' => ''];

    /*
     | Smart headline split: italicize the clause after a colon, em-dash, or "—",
     | otherwise italicize the last 1-2 words for emphasis. Falls back to whole.
     */
    $headlineRaw = trim($content['headline'] ?? $page->product_name);
    $headlineMain = $headlineRaw;
    $headlineAccent = '';
    if (preg_match('/^(.+?)\s*[:—–-]\s*(.+)$/u', $headlineRaw, $m)) {
        $headlineMain = trim($m[1]);
        $headlineAccent = trim($m[2]);
    } else {
        $words = preg_split('/\s+/', $headlineRaw);
        if (count($words) >= 5) {
            $tail = max(2, (int) floor(count($words) / 4));
            $headlineMain = implode(' ', array_slice($words, 0, count($words) - $tail));
            $headlineAccent = implode(' ', array_slice($words, count($words) - $tail));
        }
    }

    // Pull a USP/promise to use as eyebrow micro-copy if present
    $eyebrowPromise = $page->unique_selling_points
        ? \Illuminate\Support\Str::limit(trim($page->unique_selling_points), 60)
        : ($content['sub_headline'] ?? '');
@endphp

<div class="bg-zinc-950 text-stone-50 selection:bg-stone-50 selection:text-zinc-950 antialiased font-sans overflow-x-hidden">

    <style>
        @keyframes floaty { 0%,100%{transform:translate3d(0,0,0)} 50%{transform:translate3d(0,-14px,0)} }
        @keyframes floaty-rev { 0%,100%{transform:translate3d(0,0,0)} 50%{transform:translate3d(0,10px,0)} }
        @keyframes spin-slow { to { transform: rotate(360deg); } }
        @keyframes spin-slower { to { transform: rotate(-360deg); } }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba({{ $a['rgb'] }}, 0.55), 0 25px 60px -15px rgba(0,0,0,0.55); }
            50% { box-shadow: 0 0 0 22px rgba({{ $a['rgb'] }}, 0), 0 25px 60px -15px rgba(0,0,0,0.55); }
        }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes drift-up { 0% { transform: translateY(20px); opacity: 0; } 100% { transform: translateY(0); opacity: 1; } }
        .anim-floaty { animation: floaty 7s ease-in-out infinite; }
        .anim-floaty-rev { animation: floaty-rev 8s ease-in-out infinite; }
        .anim-spin-slow { animation: spin-slow 40s linear infinite; }
        .anim-spin-slower { animation: spin-slower 60s linear infinite; }
        .anim-pulse-glow { animation: pulse-glow 2.6s ease-in-out infinite; }
        .anim-drift-up { animation: drift-up 0.7s cubic-bezier(0.16,1,0.3,1) both; }
        .grain-dark { background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' /%3E%3CfeColorMatrix values='0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.18 0'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' /%3E%3C/svg%3E"); }
        .text-balance { text-wrap: balance; }
        .glow-cta { box-shadow: 0 0 0 1px rgba(255,255,255,0.06), 0 18px 60px -12px rgba({{ $a['rgb'] }}, 0.65), 0 8px 24px -8px rgba({{ $a['rgb'] }}, 0.45); }
        .glow-card { box-shadow: 0 30px 80px -20px rgba(0,0,0,0.45), 0 8px 24px -8px rgba({{ $a['rgb'] }}, 0.15); }
        .glass { background: rgba(255,255,255,0.04); backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px); }
    </style>

    {{-- ════════════════════════  HERO  ════════════════════════ --}}
    <section class="relative px-6 pt-16 pb-32 sm:pt-24 sm:pb-40 overflow-hidden">

        {{-- Backdrop --}}
        <div class="absolute inset-0 -z-10 pointer-events-none">
            <div class="absolute top-1/4 right-[-10%] w-[820px] h-[820px] rounded-full bg-gradient-to-br {{ $a['orb'] }} opacity-30 blur-[140px]"></div>
            <div class="absolute -top-32 -left-40 w-[640px] h-[640px] rounded-full bg-stone-50/5 blur-[120px]"></div>
            <svg class="absolute right-0 top-0 w-3/4 h-full opacity-[0.05]" viewBox="0 0 600 600" fill="none" preserveAspectRatio="xMidYMid slice">
                <circle cx="500" cy="300" r="200" stroke="white" stroke-width="0.6"/>
                <circle cx="500" cy="300" r="280" stroke="white" stroke-width="0.6"/>
                <circle cx="500" cy="300" r="360" stroke="white" stroke-width="0.6"/>
                <circle cx="500" cy="300" r="440" stroke="white" stroke-width="0.6"/>
            </svg>
            <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-zinc-950 to-transparent"></div>
        </div>

        <div class="relative max-w-7xl mx-auto">
            {{-- Eyebrow --}}
            <div class="flex flex-wrap items-center gap-3 mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full glass ring-1 ring-stone-50/10 text-[11px] font-bold uppercase tracking-[0.18em]">
                    <span class="relative flex w-1.5 h-1.5">
                        <span class="absolute inset-0 rounded-full {{ $a['accent2_class'] }} animate-ping"></span>
                        <span class="relative w-1.5 h-1.5 rounded-full {{ $a['accent2_class'] }}"></span>
                    </span>
                    {{ $page->product_name }}
                </div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full glass ring-1 ring-stone-50/10 text-[11px] font-medium text-stone-300">
                    <span class="text-stone-500">For</span>
                    <span class="font-semibold text-stone-100">{{ \Illuminate\Support\Str::limit($page->target_audience, 50) }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-6 items-start">

                {{-- Headline + copy --}}
                <div class="lg:col-span-7 relative">
                    <h1 class="text-balance text-4xl sm:text-5xl lg:text-6xl font-black tracking-[-0.04em] leading-[0.95] text-stone-50">
                        <span class="block anim-drift-up" style="animation-delay:0.05s">{{ $headlineMain }}</span>
                        @if ($headlineAccent)
                            <span class="block italic font-serif font-light bg-gradient-to-r {{ $a['glow'] }} bg-clip-text text-transparent anim-drift-up" style="animation-delay:0.18s">{{ $headlineAccent }}</span>
                        @endif
                    </h1>

                    @if (!empty($content['sub_headline']))
                        <p class="mt-9 text-lg sm:text-xl text-stone-300 max-w-xl leading-relaxed font-light">
                            {{ $content['sub_headline'] }}
                        </p>
                    @endif

                    {{-- CTA --}}
                    <div class="mt-12 flex flex-wrap items-center gap-3">
                        <a href="#pricing" class="group relative inline-flex items-center gap-2.5 pl-7 pr-3 py-3 rounded-full font-bold text-base {{ $a['btn'] }} glow-cta hover:-translate-y-0.5 transition-all duration-300">
                            <span class="absolute inset-0 rounded-full bg-gradient-to-r from-white/0 via-white/30 to-white/0 opacity-0 group-hover:opacity-100 transition-opacity" style="background-size:200% 100%;animation:shimmer 1.6s linear infinite"></span>
                            <span class="relative">{{ $cta['primary'] }}</span>
                            <span class="relative w-9 h-9 rounded-full bg-white/15 backdrop-blur-sm flex items-center justify-center group-hover:translate-x-0.5 transition-transform">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </span>
                        </a>
                        @if (!empty($cta['secondary']))
                            <a href="#features" class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-sm text-stone-100 glass ring-1 ring-stone-50/10 hover:ring-stone-50/30 hover:-translate-y-0.5 transition-all duration-300">
                                {{ $cta['secondary'] }}
                            </a>
                        @endif
                    </div>

                    @if (!empty($cta['urgency']))
                        <p class="mt-5 text-xs text-stone-400 max-w-md">
                            {{ $cta['urgency'] }}
                        </p>
                    @endif
                </div>

                {{-- 3D orb composition --}}
                <div class="lg:col-span-5 relative h-[420px] sm:h-[500px] lg:h-[580px]">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="absolute w-[400px] h-[400px] rounded-full border border-stone-50/10 anim-spin-slow">
                            <span class="absolute -top-1.5 left-1/2 -translate-x-1/2 w-3 h-3 rounded-full {{ $a['btn'] }}" style="box-shadow:0 0 24px rgba({{ $a['rgb'] }},0.8)"></span>
                            <span class="absolute -bottom-1 left-12 w-2 h-2 rounded-full bg-stone-50/60"></span>
                            <span class="absolute top-1/4 -right-1 w-2 h-2 rounded-full {{ $a['accent2_class'] }}"></span>
                        </div>
                        <div class="absolute w-[300px] h-[300px] rounded-full border border-stone-50/10 anim-spin-slower">
                            <span class="absolute top-12 -left-1.5 w-3 h-3 rotate-45 {{ $a['accent2_class'] }}"></span>
                            <span class="absolute bottom-8 right-4 w-2 h-2 rounded-full {{ $a['btn'] }}"></span>
                        </div>

                        {{-- Main orb --}}
                        <div class="relative w-[240px] h-[240px] rounded-full bg-gradient-to-br {{ $a['orb'] }}" style="box-shadow: 0 60px 120px -20px rgba({{ $a['rgb'] }}, 0.55), inset -20px -30px 60px rgba(0,0,0,0.25), inset 15px 20px 40px rgba(255,255,255,0.35);">
                            <div class="absolute top-6 left-12 w-24 h-24 rounded-full bg-white/40 blur-2xl"></div>
                            <div class="absolute bottom-10 right-8 w-28 h-28 rounded-full bg-white/15 blur-3xl"></div>
                            <div class="absolute inset-0 rounded-full ring-1 ring-inset ring-white/30"></div>
                            {{-- Product initial inside orb --}}
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-7xl font-black text-white/60 mix-blend-overlay">{{ strtoupper(mb_substr($page->product_name, 0, 1)) }}</span>
                            </div>
                        </div>

                        {{-- Floating glass: top — first benefit --}}
                        @if (isset($benefits[0]))
                            <div class="absolute top-2 left-0 sm:left-2 w-56 rounded-2xl glass ring-1 ring-stone-50/15 p-4 anim-floaty" style="box-shadow: 0 30px 80px -20px rgba(0,0,0,0.5);">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-stone-400 mb-1.5">Top benefit</div>
                                <div class="text-sm font-bold text-stone-50 leading-snug">{{ \Illuminate\Support\Str::limit($benefits[0]['title'] ?? '', 60) }}</div>
                            </div>
                        @endif

                        {{-- Floating glass: right — pricing snippet --}}
                        @if (!empty($pricing['price']))
                            <div class="absolute top-1/3 right-0 sm:-right-4 w-44 rounded-2xl bg-zinc-900/90 ring-1 ring-stone-50/10 p-4 anim-floaty-rev" style="box-shadow: 0 30px 80px -20px rgba(0,0,0,0.6);">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-stone-400 mb-1">{{ $pricing['label'] ?? 'Price' }}</div>
                                <div class="text-2xl font-black tracking-tight text-stone-50 leading-tight">{{ \Illuminate\Support\Str::limit($pricing['price'], 14) }}</div>
                                @if (!empty($pricing['note']))
                                    <div class="text-[10px] text-stone-400 mt-1.5 leading-snug">{{ \Illuminate\Support\Str::limit($pricing['note'], 50) }}</div>
                                @endif
                            </div>
                        @endif

                        {{-- Floating glass: bottom — review --}}
                        @if (isset($reviews[0]))
                            <div class="absolute bottom-2 left-2 sm:-left-2 w-60 rounded-2xl glass ring-1 ring-stone-50/15 p-4 anim-floaty" style="box-shadow: 0 30px 80px -20px rgba(0,0,0,0.5); animation-delay: -1.5s;">
                                <div class="flex items-center gap-0.5 mb-2">
                                    @for ($s = 0; $s < 5; $s++)
                                        <svg class="w-3 h-3 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <p class="text-xs text-stone-200 leading-snug font-medium">"{{ \Illuminate\Support\Str::limit(($reviews[0]['quote'] ?? ''), 70) }}"</p>
                                <div class="mt-2.5 flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-gradient-to-br {{ $a['orb'] }}"></div>
                                    <span class="text-[10px] font-semibold text-stone-300">{{ $reviews[0]['author'] ?? '' }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════════════════  DESCRIPTION (storytelling intro)  ════════════════════════ --}}
    <section class="relative px-6 py-32 sm:py-40 overflow-hidden">
        <div class="absolute inset-0 grain-dark opacity-25 pointer-events-none"></div>
        <div class="absolute -top-32 right-0 w-96 h-96 rounded-full bg-gradient-to-br {{ $a['orb'] }} opacity-15 blur-3xl pointer-events-none"></div>

        <div class="relative max-w-5xl mx-auto">
            <div class="flex items-center gap-4 mb-10">
                <span class="text-[10px] uppercase tracking-[0.22em] text-stone-500 font-bold">Overview</span>
                <div class="flex-1 h-px bg-stone-50/10"></div>
                <span class="text-[10px] uppercase tracking-[0.22em] {{ $a['accent2_text'] }} font-bold">{{ $page->product_name }}</span>
            </div>

            <h2 class="text-balance text-4xl sm:text-6xl lg:text-7xl font-black tracking-[-0.04em] leading-[0.95] max-w-4xl">
                Built for
                <span class="italic font-serif font-light bg-gradient-to-r {{ $a['glow'] }} bg-clip-text text-transparent">{{ \Illuminate\Support\Str::limit($page->target_audience, 60) }}.</span>
            </h2>

            @if (!empty($content['description']))
                <div class="mt-10 max-w-3xl text-lg sm:text-xl text-stone-300 leading-relaxed font-light whitespace-pre-line">{{ $content['description'] }}</div>
            @endif
        </div>

        <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-b from-zinc-950 via-zinc-950/80 to-stone-50 pointer-events-none"></div>
    </section>

    @if (!empty($benefits))
        {{-- ════════════════════════  BENEFITS — story-driven, no card grid  ════════════════════════ --}}
        <section id="features" class="relative px-6 py-32 sm:py-40 bg-stone-50 text-zinc-950 overflow-hidden">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center gap-4 mb-10">
                    <span class="text-[10px] uppercase tracking-[0.22em] text-stone-500 font-bold">Why it matters</span>
                    <div class="flex-1 h-px bg-zinc-950/10"></div>
                    <span class="text-[10px] uppercase tracking-[0.22em] {{ $a['text'] }} font-bold">Benefits</span>
                </div>

                <h2 class="text-balance text-4xl sm:text-6xl lg:text-7xl font-black tracking-[-0.04em] leading-[0.95] max-w-4xl text-zinc-950">
                    What you'll
                    <span class="italic font-serif font-light {{ $a['text'] }}">actually get.</span>
                </h2>

                {{-- Featured benefit (full-width hero card) --}}
                <div class="mt-20 relative rounded-[2rem] overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-zinc-900 to-zinc-950 -z-10"></div>
                    <div class="absolute -top-40 -right-20 w-[500px] h-[500px] rounded-full bg-gradient-to-br {{ $a['orb'] }} opacity-30 blur-3xl pointer-events-none"></div>
                    <div class="absolute inset-0 ring-1 ring-stone-50/10 rounded-[2rem] pointer-events-none"></div>

                    <div class="relative p-10 sm:p-16 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                        <div class="lg:col-span-8">
                            <div class="text-[10px] uppercase tracking-[0.22em] {{ $a['accent2_text'] }} font-bold mb-4">Headline benefit</div>
                            <h3 class="text-balance text-3xl sm:text-4xl lg:text-5xl font-black tracking-[-0.03em] leading-[0.95] text-stone-50">{{ $benefits[0]['title'] ?? '' }}</h3>
                            @if (!empty($benefits[0]['body']))
                                <p class="mt-6 text-lg text-stone-300 leading-relaxed max-w-xl">{{ $benefits[0]['body'] }}</p>
                            @endif
                        </div>
                        <div class="lg:col-span-4 flex justify-center lg:justify-end">
                            <div class="w-32 h-32 rounded-3xl bg-gradient-to-br {{ $a['orb'] }} flex items-center justify-center text-zinc-950 font-black text-5xl" style="box-shadow: 0 30px 60px -15px rgba({{ $a['rgb'] }}, 0.5)">01</div>
                        </div>
                    </div>
                </div>

                {{-- Stacked benefits (typographic list, no boxes) --}}
                @if (count($benefits) > 1)
                    <div class="mt-20 space-y-16">
                        @foreach (array_slice($benefits, 1) as $i => $benefit)
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-baseline group border-t border-zinc-950/10 pt-12">
                                <div class="lg:col-span-2">
                                    <div class="text-[10px] uppercase tracking-[0.22em] text-stone-500 font-bold">0{{ $i + 2 }}</div>
                                    <div class="mt-2 text-3xl sm:text-4xl font-black tracking-tight bg-gradient-to-br {{ $a['glow'] }} bg-clip-text text-transparent">→</div>
                                </div>
                                <div class="lg:col-span-10">
                                    <h3 class="text-balance text-3xl sm:text-4xl font-black tracking-[-0.03em] leading-tight text-zinc-950 group-hover:translate-x-1 transition-transform duration-500">{{ $benefit['title'] ?? '' }}</h3>
                                    @if (!empty($benefit['body']))
                                        <p class="mt-4 text-base sm:text-lg text-zinc-600 leading-relaxed max-w-2xl">{{ $benefit['body'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @endif

    @if (!empty($features))
        {{-- ════════════════════════  FEATURES — cinematic zigzag  ════════════════════════ --}}
        <section class="px-6 py-32 sm:py-44 bg-zinc-950 text-stone-50 overflow-hidden relative">
            <div class="absolute inset-0 grain-dark opacity-25 pointer-events-none"></div>

            <div class="relative max-w-7xl mx-auto">
                <div class="flex items-center gap-4 mb-10 max-w-6xl mx-auto">
                    <span class="text-[10px] uppercase tracking-[0.22em] text-stone-500 font-bold">What's inside</span>
                    <div class="flex-1 h-px bg-stone-50/10"></div>
                    <span class="text-[10px] uppercase tracking-[0.22em] {{ $a['accent2_text'] }} font-bold">Capabilities</span>
                </div>

                <h2 class="max-w-6xl mx-auto text-balance text-4xl sm:text-6xl lg:text-7xl font-black tracking-[-0.04em] leading-[0.95]">
                    Everything you need,
                    <span class="italic font-serif font-light bg-gradient-to-r {{ $a['glow'] }} bg-clip-text text-transparent">nothing you don't.</span>
                </h2>

                <div class="mt-24 space-y-32">
                    @foreach (array_slice($features, 0, 4) as $i => $feature)
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center max-w-6xl mx-auto {{ $i % 2 === 1 ? 'lg:[&>*:first-child]:order-2' : '' }}">
                            <div class="lg:col-span-6">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full glass ring-1 ring-stone-50/15 text-[11px] font-bold uppercase tracking-wider mb-6">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $a['btn'] }}"></span>
                                    Feature · 0{{ $i + 1 }}
                                </div>
                                <h3 class="text-balance text-3xl sm:text-4xl lg:text-5xl font-black tracking-[-0.03em] leading-[0.95] text-stone-50">{{ $feature['title'] ?? '' }}</h3>
                                @if (!empty($feature['body']))
                                    <p class="mt-6 text-base sm:text-lg text-stone-300 leading-relaxed">{{ $feature['body'] }}</p>
                                @endif
                            </div>

                            {{-- Visual mock --}}
                            <div class="lg:col-span-6 relative">
                                <div class="absolute -inset-12 rounded-[3rem] bg-gradient-to-br {{ $a['orb'] }} opacity-25 blur-3xl -z-10"></div>
                                <div class="absolute inset-x-12 inset-y-6 rounded-3xl {{ $a['accent2_class'] }} opacity-90 -z-10 transform {{ $i % 2 === 0 ? 'rotate-2' : '-rotate-2' }}"></div>
                                <div class="relative rounded-3xl bg-stone-50 ring-1 ring-zinc-950/10 p-7 transform {{ $i % 2 === 0 ? '-rotate-1' : 'rotate-1' }} hover:rotate-0 transition-transform duration-700" style="box-shadow: 0 60px 100px -30px rgba(0,0,0,0.5);">
                                    <div class="flex items-center justify-between pb-5 border-b border-zinc-100">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-9 h-9 rounded-xl {{ $a['btn'] }} flex items-center justify-center text-white" style="box-shadow: 0 8px 16px -4px rgba({{ $a['rgb'] }}, 0.4)">
                                                <span class="text-xs font-black">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                            </div>
                                            <div>
                                                <div class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">Feature</div>
                                                <div class="text-sm font-bold text-zinc-950 truncate max-w-[200px]">{{ \Illuminate\Support\Str::limit($feature['title'] ?? '', 32) }}</div>
                                            </div>
                                        </div>
                                        <div class="flex gap-1.5">
                                            <div class="w-2 h-2 rounded-full bg-zinc-200"></div>
                                            <div class="w-2 h-2 rounded-full bg-zinc-200"></div>
                                            <div class="w-2 h-2 rounded-full {{ $a['btn'] }}"></div>
                                        </div>
                                    </div>
                                    <div class="mt-5 space-y-3">
                                        <div class="flex gap-3">
                                            <div class="w-12 h-12 rounded-2xl {{ $a['soft'] }} ring-1 shrink-0"></div>
                                            <div class="flex-1 space-y-1.5">
                                                <div class="h-3 w-3/4 rounded-full bg-zinc-200"></div>
                                                <div class="h-2 w-1/2 rounded-full bg-zinc-100"></div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 gap-2">
                                            <div class="h-20 rounded-xl bg-stone-100"></div>
                                            <div class="h-20 rounded-xl {{ $a['soft'] }} ring-1"></div>
                                            <div class="h-20 rounded-xl bg-stone-100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Remaining features as a clean list --}}
                @if (count($features) > 4)
                    <div class="mt-32 max-w-4xl mx-auto">
                        <h3 class="text-2xl font-black tracking-tight mb-8">Plus everything else:</h3>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
                            @foreach (array_slice($features, 4) as $f)
                                <li class="flex items-start gap-3">
                                    <span class="w-5 h-5 rounded-full {{ $a['btn'] }} flex items-center justify-center shrink-0 mt-1" style="box-shadow: 0 0 12px rgba({{ $a['rgb'] }}, 0.5)">
                                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75 10.5 18l9-13.5"/></svg>
                                    </span>
                                    <div>
                                        <div class="text-base font-semibold text-stone-50">{{ $f['title'] ?? '' }}</div>
                                        @if (!empty($f['body']))
                                            <div class="text-sm text-stone-400 mt-1">{{ $f['body'] }}</div>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </section>
    @endif

    @if (!empty($reviews))
        {{-- ════════════════════════  TESTIMONIALS  ════════════════════════ --}}
        <section class="relative px-6 py-32 sm:py-40 bg-stone-50 text-zinc-950 overflow-hidden">
            <div class="relative max-w-6xl mx-auto">
                <div class="flex items-center gap-4 mb-10">
                    <span class="text-[10px] uppercase tracking-[0.22em] text-stone-500 font-bold">Customer voices</span>
                    <div class="flex-1 h-px bg-zinc-950/10"></div>
                    <span class="text-[10px] uppercase tracking-[0.22em] {{ $a['text'] }} font-bold">Reviews</span>
                </div>

                <h2 class="text-balance text-4xl sm:text-6xl lg:text-7xl font-black tracking-[-0.04em] leading-[0.95] max-w-4xl">
                    Don't take
                    <span class="italic font-serif font-light {{ $a['text'] }}">our word for it.</span>
                </h2>

                {{-- Featured huge quote --}}
                @if (isset($reviews[0]))
                    <figure class="mt-20 max-w-4xl">
                        <svg class="w-12 h-12 {{ $a['text'] }} opacity-40 mb-4" fill="currentColor" viewBox="0 0 32 32">
                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36 1 24.6 4.456 28 8.224 28c3.456 0 6.024-2.752 6.024-6.024 0-3.272-2.272-5.656-5.272-5.656-.6 0-1.4.12-1.6.2.52-3.512 3.84-7.656 7.16-9.752L9.352 4Zm15.32 0c-4.84 3.456-8.296 9.12-8.296 15.36 0 5.24 3.456 8.64 7.224 8.64 3.4 0 6.024-2.752 6.024-6.024 0-3.272-2.32-5.656-5.32-5.656-.6 0-1.352.12-1.552.2.52-3.512 3.792-7.656 7.112-9.752L24.672 4Z"/>
                        </svg>
                        <blockquote class="text-balance text-3xl sm:text-4xl lg:text-5xl font-medium leading-[1.15] tracking-[-0.02em] text-zinc-900">
                            "{{ $reviews[0]['quote'] ?? '' }}"
                        </blockquote>
                        <figcaption class="mt-8 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br {{ $a['orb'] }} flex items-center justify-center text-base font-black text-zinc-950 shrink-0">
                                {{ strtoupper(mb_substr($reviews[0]['author'] ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-base font-bold text-zinc-950">{{ $reviews[0]['author'] ?? '' }}</div>
                                <div class="text-sm text-zinc-500">{{ $reviews[0]['role'] ?? '' }}</div>
                            </div>
                            <div class="hidden sm:flex items-center gap-0.5 ml-auto">
                                @for ($s = 0; $s < 5; $s++)
                                    <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                        </figcaption>
                    </figure>
                @endif

                @if (count($reviews) > 1)
                    <div class="mt-20 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-16 max-w-5xl border-t border-zinc-950/10 pt-16">
                        @foreach (array_slice($reviews, 1) as $review)
                            <figure>
                                <div class="flex items-center gap-0.5 mb-4">
                                    @for ($s = 0; $s < 5; $s++)
                                        <svg class="w-3.5 h-3.5 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <blockquote class="text-lg text-zinc-800 leading-relaxed font-medium">
                                    "{{ $review['quote'] ?? '' }}"
                                </blockquote>
                                <figcaption class="mt-5 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br {{ $a['orb'] }} flex items-center justify-center text-xs font-black text-zinc-950 shrink-0">
                                        {{ strtoupper(mb_substr($review['author'] ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-zinc-950">{{ $review['author'] ?? '' }}</div>
                                        <div class="text-xs text-zinc-500">{{ $review['role'] ?? '' }}</div>
                                    </div>
                                </figcaption>
                            </figure>
                        @endforeach
                    </div>
                @endif

                <p class="text-[11px] text-zinc-400 mt-16">Testimonials are illustrative placeholders.</p>
            </div>
        </section>
    @endif

    {{-- ════════════════════════  PRICING  ════════════════════════ --}}
    <section id="pricing" class="relative px-6 py-32 sm:py-40 bg-zinc-950 text-stone-50 overflow-hidden">
        <div class="absolute inset-0 grain-dark opacity-25 pointer-events-none"></div>
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[800px] h-[800px] rounded-full bg-gradient-to-br {{ $a['orb'] }} opacity-15 blur-3xl pointer-events-none"></div>

        <div class="relative max-w-3xl mx-auto">
            <div class="flex items-center gap-4 mb-10">
                <span class="text-[10px] uppercase tracking-[0.22em] text-stone-500 font-bold">Pricing</span>
                <div class="flex-1 h-px bg-stone-50/10"></div>
                <span class="text-[10px] uppercase tracking-[0.22em] {{ $a['accent2_text'] }} font-bold">{{ $page->product_name }}</span>
            </div>

            <h2 class="text-balance text-4xl sm:text-6xl lg:text-7xl font-black tracking-[-0.04em] leading-[0.95]">
                Simple
                <span class="italic font-serif font-light bg-gradient-to-r {{ $a['glow'] }} bg-clip-text text-transparent">pricing.</span>
            </h2>

            {{-- Pricing card --}}
            <div class="mt-16 relative">
                <div class="absolute -inset-6 rounded-[2.5rem] bg-gradient-to-br {{ $a['orb'] }} opacity-40 blur-3xl -z-10"></div>

                <div class="relative rounded-3xl bg-gradient-to-br from-zinc-900 via-zinc-950 to-zinc-900 ring-1 ring-stone-50/10 overflow-hidden glow-card">
                    <div class="absolute inset-0 grain-dark opacity-30 pointer-events-none"></div>
                    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-gradient-to-br {{ $a['orb'] }} opacity-30 blur-3xl pointer-events-none"></div>

                    <div class="relative p-8 sm:p-12">
                        <div class="text-xs uppercase tracking-[0.16em] text-stone-400 font-bold mb-3">{{ $pricing['label'] ?? 'Plan' }}</div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-6xl sm:text-7xl font-black tracking-[-0.04em] bg-gradient-to-br from-stone-50 to-stone-300 bg-clip-text text-transparent">{{ $pricing['price'] }}</span>
                        </div>
                        @if (!empty($pricing['note']))
                            <p class="mt-4 text-stone-300">{{ $pricing['note'] }}</p>
                        @endif

                        @if (!empty($features))
                            <div class="mt-8 pt-8 border-t border-stone-50/10">
                                <div class="text-[11px] uppercase tracking-[0.14em] text-stone-400 font-bold mb-5">What's included</div>
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-3.5">
                                    @foreach (array_slice($features, 0, 8) as $feature)
                                        <li class="flex items-start gap-2.5">
                                            <span class="w-5 h-5 rounded-full {{ $a['btn'] }} flex items-center justify-center shrink-0 mt-0.5" style="box-shadow: 0 0 10px rgba({{ $a['rgb'] }}, 0.5)">
                                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75 10.5 18l9-13.5"/></svg>
                                            </span>
                                            <span class="text-sm text-stone-100 leading-snug">{{ $feature['title'] ?? '' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mt-10 space-y-3">
                            <a href="#" class="group block w-full px-5 py-4 rounded-2xl font-bold text-base {{ $a['btn'] }} text-center anim-pulse-glow hover:-translate-y-0.5 transition-all">
                                {{ $cta['primary'] }} →
                            </a>
                            @if (!empty($cta['secondary']))
                                <a href="#" class="block w-full px-5 py-3 rounded-2xl font-semibold text-sm text-stone-300 glass ring-1 ring-stone-50/10 hover:ring-stone-50/30 text-center transition-all">
                                    {{ $cta['secondary'] }}
                                </a>
                            @endif
                            @if (!empty($cta['urgency']))
                                <p class="text-center text-xs text-stone-400 pt-2">{{ $cta['urgency'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════════════════  FINAL CTA  ════════════════════════ --}}
    <section class="relative px-6 py-32 sm:py-40 bg-zinc-950 text-stone-50 overflow-hidden">
        <div class="absolute inset-0 grain-dark opacity-30 pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-zinc-950 via-zinc-900 to-zinc-950 -z-10"></div>
        <div class="absolute -top-40 -right-40 w-[700px] h-[700px] rounded-full bg-gradient-to-br {{ $a['orb'] }} opacity-30 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] rounded-full {{ $a['accent2_class'] }} opacity-15 blur-3xl pointer-events-none"></div>

        <div class="relative max-w-5xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full glass ring-1 ring-stone-50/15 text-[11px] font-bold uppercase tracking-[0.18em] mb-10">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                {{ $page->product_name }}
            </div>

            <h2 class="text-balance text-5xl sm:text-7xl lg:text-[8rem] font-black tracking-[-0.045em] leading-[0.88] max-w-5xl mx-auto">
                Ready to
                <span class="block italic font-serif font-light bg-gradient-to-r {{ $a['glow'] }} bg-clip-text text-transparent">{{ \Illuminate\Support\Str::limit(strtolower($cta['primary']), 26) }}?</span>
            </h2>

            @if (!empty($content['sub_headline']))
                <p class="mt-10 text-lg sm:text-xl text-stone-300 max-w-xl mx-auto leading-relaxed font-light">
                    {{ \Illuminate\Support\Str::limit($content['sub_headline'], 140) }}
                </p>
            @endif

            <div class="mt-12 flex flex-wrap items-center justify-center gap-3">
                <a href="#pricing" class="group relative inline-flex items-center gap-2.5 pl-8 pr-3 py-3.5 rounded-full font-bold text-base {{ $a['btn'] }} glow-cta hover:-translate-y-0.5 transition-all duration-300">
                    {{ $cta['primary'] }}
                    <span class="w-9 h-9 rounded-full bg-white/15 backdrop-blur-sm flex items-center justify-center group-hover:translate-x-0.5 transition-transform">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </span>
                </a>
                @if (!empty($cta['secondary']))
                    <a href="#" class="inline-flex items-center px-7 py-3.5 rounded-full font-bold text-base text-stone-100 glass ring-1 ring-stone-50/15 hover:ring-stone-50/30 hover:-translate-y-0.5 transition-all duration-300">
                        {{ $cta['secondary'] }}
                    </a>
                @endif
            </div>
            @if (!empty($cta['urgency']))
                <p class="mt-6 text-xs text-stone-500 max-w-md mx-auto">{{ $cta['urgency'] }}</p>
            @endif
        </div>
    </section>
</div>
