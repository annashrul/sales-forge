@php
    $content = $page->generated_content ?? [];
    $benefits = $content['benefits'] ?? [];
    $features = $content['features_breakdown'] ?? [];
    $reviews = $content['social_proof'] ?? [];
    $cta = $content['cta'] ?? ['primary' => 'Get Started', 'secondary' => 'Learn More', 'urgency' => ''];
    $pricing = $content['pricing_display'] ?? ['label' => 'Pricing', 'price' => $page->price ?: 'Contact', 'note' => ''];

    $headlineRaw = trim($content['headline'] ?? $page->product_name);
    $headlineMain = $headlineRaw;
    $headlineAccent = '';
    if (preg_match('/^(.+?)\s*[:—–-]\s*(.+)$/u', $headlineRaw, $m)) {
        $headlineMain = trim($m[1]);
        $headlineAccent = trim($m[2]);
    }
@endphp

<div class="bg-[#FAF7F0] text-stone-900 selection:bg-amber-200 selection:text-stone-900 antialiased" style="font-family: 'Cormorant Garamond', Georgia, 'Times New Roman', serif;">

    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:400,500,600,700|inter:400,500,600,700&display=swap" rel="stylesheet">

    <style>
        .editorial-serif { font-family: 'Cormorant Garamond', Georgia, serif; }
        .editorial-sans { font-family: 'Inter', system-ui, sans-serif; }
        .drop-cap::first-letter {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 5rem;
            line-height: 0.8;
            float: left;
            margin: 0.4rem 0.6rem 0 0;
            font-weight: 700;
            color: #B45309;
        }
        .editorial-rule { background: linear-gradient(to right, #92400E 0 35%, transparent 35% 100%); height: 1px; }
        @keyframes drift { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .anim-drift { animation: drift 6s ease-in-out infinite; }
        .text-balance { text-wrap: balance; }
    </style>

    {{-- ════════════════════════  MASTHEAD  ════════════════════════ --}}
    <header class="border-b-2 border-stone-900 px-6 py-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="editorial-sans text-[10px] uppercase tracking-[0.22em] text-stone-600 font-semibold">{{ now()->format('l, F j Y') }}</div>
            <div class="editorial-sans text-[10px] uppercase tracking-[0.22em] text-stone-600 font-semibold">Vol. 01 · Edition I</div>
        </div>
        <div class="max-w-6xl mx-auto mt-2 flex items-center justify-between">
            <div class="text-3xl font-bold tracking-tight">{{ $page->product_name }}</div>
            <div class="editorial-sans text-[10px] uppercase tracking-[0.22em] text-amber-700 font-bold">A Considered Introduction</div>
        </div>
    </header>

    {{-- ════════════════════════  HERO — editorial cover  ════════════════════════ --}}
    <section class="px-6 py-20 sm:py-28">
        <div class="max-w-5xl mx-auto text-center">
            <div class="inline-flex items-center gap-3 mb-10">
                <span class="h-px w-12 bg-stone-900"></span>
                <span class="editorial-sans text-[10px] uppercase tracking-[0.28em] text-stone-700 font-bold">For {{ \Illuminate\Support\Str::limit($page->target_audience, 40) }}</span>
                <span class="h-px w-12 bg-stone-900"></span>
            </div>

            <h1 class="text-balance text-3xl sm:text-5xl lg:text-6xl font-medium leading-[1] tracking-tight text-stone-900">
                {{ $headlineMain }}
                @if ($headlineAccent)
                    <span class="block mt-3 italic font-light text-amber-700">{{ $headlineAccent }}</span>
                @endif
            </h1>

            @if (!empty($content['sub_headline']))
                <p class="mt-10 text-xl sm:text-2xl text-stone-600 max-w-2xl mx-auto leading-relaxed font-light italic">
                    "{{ $content['sub_headline'] }}"
                </p>
            @endif

            <div class="editorial-sans mt-12 flex flex-wrap items-center justify-center gap-3">
                <a href="#pricing" class="inline-flex items-center gap-2 px-7 py-3.5 bg-stone-900 hover:bg-stone-800 text-stone-50 font-semibold text-sm tracking-wide transition-all hover:-translate-y-0.5">
                    {{ $cta['primary'] }}
                    <span class="text-amber-400">→</span>
                </a>
                @if (!empty($cta['secondary']))
                    <a href="#features" class="inline-flex items-center px-7 py-3.5 bg-transparent border-2 border-stone-900 text-stone-900 hover:bg-stone-900 hover:text-stone-50 font-semibold text-sm tracking-wide transition-all">
                        {{ $cta['secondary'] }}
                    </a>
                @endif
            </div>

            <div class="mt-16 grid grid-cols-3 max-w-2xl mx-auto border-t-2 border-stone-900 pt-6">
                <div class="text-center border-r border-stone-300">
                    <div class="text-3xl font-bold">I.</div>
                    <div class="editorial-sans text-[10px] uppercase tracking-widest text-stone-600 mt-1">The Premise</div>
                </div>
                <div class="text-center border-r border-stone-300">
                    <div class="text-3xl font-bold">II.</div>
                    <div class="editorial-sans text-[10px] uppercase tracking-widest text-stone-600 mt-1">The Detail</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">III.</div>
                    <div class="editorial-sans text-[10px] uppercase tracking-widest text-stone-600 mt-1">The Verdict</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════════════════  THE PREMISE — description with drop cap  ════════════════════════ --}}
    @if (!empty($content['description']))
        <section class="px-6 py-20 border-t border-stone-300">
            <div class="max-w-3xl mx-auto">
                <div class="editorial-sans text-[10px] uppercase tracking-[0.28em] text-amber-700 font-bold mb-8 flex items-center gap-3">
                    <span>I — The Premise</span>
                    <span class="flex-1 h-px bg-stone-300"></span>
                </div>
                <div class="text-xl sm:text-2xl text-stone-800 leading-[1.55] font-light drop-cap whitespace-pre-line">{{ $content['description'] }}</div>
            </div>
        </section>
    @endif

    @if (!empty($benefits))
        {{-- ════════════════════════  THE DETAIL — benefits as numbered article  ════════════════════════ --}}
        <section class="px-6 py-20 border-t border-stone-300 bg-[#F4EFE3]">
            <div class="max-w-5xl mx-auto">
                <div class="editorial-sans text-[10px] uppercase tracking-[0.28em] text-amber-700 font-bold mb-8 flex items-center gap-3">
                    <span>II — The Detail</span>
                    <span class="flex-1 h-px bg-stone-400"></span>
                </div>

                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-medium leading-[1.05] tracking-tight max-w-3xl">
                    What you stand <span class="italic font-light text-amber-700">to gain.</span>
                </h2>

                <div class="mt-16 space-y-12 max-w-3xl">
                    @foreach ($benefits as $i => $benefit)
                        <article class="grid grid-cols-12 gap-6 pb-12 {{ $loop->last ? '' : 'border-b border-stone-300' }}">
                            <div class="col-span-2 sm:col-span-1">
                                <div class="text-4xl font-light text-amber-700 italic">§{{ $i + 1 }}</div>
                            </div>
                            <div class="col-span-10 sm:col-span-11">
                                <h3 class="text-2xl sm:text-3xl font-medium leading-tight">{{ $benefit['title'] ?? '' }}</h3>
                                @if (!empty($benefit['body']))
                                    <p class="mt-3 text-lg text-stone-600 leading-relaxed font-light">{{ $benefit['body'] }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (!empty($features))
        {{-- ════════════════════════  THE FEATURES — two-column pamphlet  ════════════════════════ --}}
        <section class="px-6 py-20 border-t border-stone-300">
            <div class="max-w-6xl mx-auto">
                <div class="editorial-sans text-[10px] uppercase tracking-[0.28em] text-amber-700 font-bold mb-8 flex items-center gap-3">
                    <span>An Inventory of Capabilities</span>
                    <span class="flex-1 h-px bg-stone-300"></span>
                </div>

                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-medium leading-[1.05] tracking-tight max-w-3xl mb-12">
                    Each part, <span class="italic font-light text-amber-700">considered.</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-12">
                    @foreach ($features as $i => $feature)
                        <article class="border-t-2 border-stone-900 pt-5">
                            <div class="flex items-baseline gap-3 mb-2">
                                <span class="editorial-sans text-[10px] uppercase tracking-[0.22em] text-amber-700 font-bold">No. {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <h3 class="text-2xl font-medium leading-tight tracking-tight">{{ $feature['title'] ?? '' }}</h3>
                            @if (!empty($feature['body']))
                                <p class="mt-3 text-base text-stone-600 leading-relaxed font-light">{{ $feature['body'] }}</p>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (!empty($reviews))
        {{-- ════════════════════════  CORRESPONDENCE — testimonials as letters  ════════════════════════ --}}
        <section class="px-6 py-20 border-t border-stone-300 bg-[#F4EFE3]">
            <div class="max-w-4xl mx-auto">
                <div class="editorial-sans text-[10px] uppercase tracking-[0.28em] text-amber-700 font-bold mb-8 flex items-center gap-3">
                    <span>Correspondence</span>
                    <span class="flex-1 h-px bg-stone-400"></span>
                </div>

                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-medium leading-[1.05] tracking-tight mb-12">
                    From <span class="italic font-light text-amber-700">our readers.</span>
                </h2>

                <div class="space-y-12">
                    @foreach ($reviews as $i => $review)
                        <figure class="grid grid-cols-12 gap-6">
                            <div class="col-span-2 sm:col-span-1 pt-2">
                                <span class="editorial-serif text-5xl font-bold text-amber-700 leading-none">"</span>
                            </div>
                            <div class="col-span-10 sm:col-span-11">
                                <blockquote class="text-2xl sm:text-3xl leading-snug text-stone-800 font-light italic">
                                    {{ $review['quote'] ?? '' }}
                                </blockquote>
                                <figcaption class="editorial-sans mt-5 flex items-center gap-3 text-sm">
                                    <span class="font-bold text-stone-900 uppercase tracking-wider">— {{ $review['author'] ?? '' }}</span>
                                    @if (!empty($review['role']))
                                        <span class="text-stone-500">{{ $review['role'] }}</span>
                                    @endif
                                </figcaption>
                            </div>
                        </figure>
                    @endforeach
                </div>
                <p class="editorial-sans text-[10px] text-stone-500 italic mt-10">Testimonials are illustrative placeholders.</p>
            </div>
        </section>
    @endif

    {{-- ════════════════════════  THE VERDICT — pricing  ════════════════════════ --}}
    <section id="pricing" class="px-6 py-20 border-t border-stone-300">
        <div class="max-w-3xl mx-auto">
            <div class="editorial-sans text-[10px] uppercase tracking-[0.28em] text-amber-700 font-bold mb-8 flex items-center gap-3">
                <span>III — The Verdict</span>
                <span class="flex-1 h-px bg-stone-300"></span>
            </div>

            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-medium leading-[1.05] tracking-tight mb-12">
                A fair <span class="italic font-light text-amber-700">proposition.</span>
            </h2>

            <div class="border-2 border-stone-900 bg-stone-50 p-10">
                <div class="text-center pb-8 border-b-2 border-stone-900">
                    <div class="editorial-sans text-[10px] uppercase tracking-[0.22em] text-amber-700 font-bold mb-3">{{ $pricing['label'] ?? 'Plan' }}</div>
                    <div class="text-7xl sm:text-8xl font-medium tracking-tight text-stone-900 leading-none">{{ $pricing['price'] }}</div>
                    @if (!empty($pricing['note']))
                        <p class="mt-4 text-base text-stone-600 italic font-light">{{ $pricing['note'] }}</p>
                    @endif
                </div>

                @if (!empty($features))
                    <div class="pt-8">
                        <div class="editorial-sans text-[10px] uppercase tracking-[0.22em] text-stone-700 font-bold mb-5">Included with your subscription</div>
                        <ul class="space-y-2.5">
                            @foreach (array_slice($features, 0, 8) as $feature)
                                <li class="flex items-start gap-3 text-base text-stone-800 font-light">
                                    <span class="text-amber-700 font-bold mt-0.5">✓</span>
                                    <span>{{ $feature['title'] ?? '' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="editorial-sans mt-10 space-y-3">
                    <a href="#" class="block w-full px-5 py-4 bg-stone-900 hover:bg-stone-800 text-stone-50 font-semibold text-sm text-center tracking-wide transition-all">
                        {{ $cta['primary'] }} <span class="text-amber-400">→</span>
                    </a>
                    @if (!empty($cta['secondary']))
                        <a href="#" class="block w-full px-5 py-3 border border-stone-300 text-stone-700 hover:border-stone-900 hover:text-stone-900 font-semibold text-sm text-center tracking-wide transition-all">
                            {{ $cta['secondary'] }}
                        </a>
                    @endif
                </div>

                @if (!empty($cta['urgency']))
                    <p class="editorial-sans text-center text-xs text-stone-500 italic mt-6">{{ $cta['urgency'] }}</p>
                @endif
            </div>
        </div>
    </section>

    {{-- ════════════════════════  EPILOGUE — final CTA  ════════════════════════ --}}
    <section class="px-6 py-20 border-t-2 border-stone-900 bg-stone-900 text-stone-50">
        <div class="max-w-4xl mx-auto text-center">
            <div class="editorial-sans text-[10px] uppercase tracking-[0.28em] text-amber-400 font-bold mb-6">Epilogue</div>
            <h2 class="text-balance text-5xl sm:text-6xl lg:text-7xl font-medium leading-[1.02] tracking-tight">
                The next chapter
                <span class="italic font-light text-amber-400">begins with you.</span>
            </h2>
            @if (!empty($content['sub_headline']))
                <p class="mt-8 text-xl text-stone-300 max-w-2xl mx-auto font-light italic leading-relaxed">"{{ \Illuminate\Support\Str::limit($content['sub_headline'], 130) }}"</p>
            @endif
            <div class="editorial-sans mt-10 flex flex-wrap items-center justify-center gap-3">
                <a href="#pricing" class="inline-flex items-center gap-2 px-8 py-4 bg-amber-400 hover:bg-amber-300 text-stone-900 font-bold text-sm tracking-wide transition-all hover:-translate-y-0.5">
                    {{ $cta['primary'] }} →
                </a>
                @if (!empty($cta['secondary']))
                    <a href="#" class="inline-flex items-center px-8 py-4 border-2 border-stone-50/30 text-stone-50 hover:bg-stone-50/10 font-bold text-sm tracking-wide transition-all">
                        {{ $cta['secondary'] }}
                    </a>
                @endif
            </div>
            @if (!empty($cta['urgency']))
                <p class="mt-6 text-xs text-stone-400 italic">{{ $cta['urgency'] }}</p>
            @endif
        </div>
        <div class="max-w-6xl mx-auto mt-16 pt-6 border-t border-stone-50/10 flex items-center justify-between text-[10px] uppercase tracking-[0.22em] text-stone-500 editorial-sans font-bold">
            <span>{{ $page->product_name }}</span>
            <span>{{ now()->format('Y') }} · A Volume of One</span>
        </div>
    </section>
</div>
