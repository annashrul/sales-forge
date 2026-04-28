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

    // Rotating pastel surface palette for cards/sections
    $pastels = ['bg-rose-200', 'bg-amber-200', 'bg-emerald-200', 'bg-sky-200', 'bg-violet-200', 'bg-orange-200'];
    $pastelInks = ['text-rose-900', 'text-amber-900', 'text-emerald-900', 'text-sky-900', 'text-violet-900', 'text-orange-900'];
@endphp

<div class="bg-[#FFF8E8] text-stone-900 selection:bg-pink-300 selection:text-stone-900 antialiased font-sans overflow-x-hidden">

    <link href="https://fonts.bunny.net/css?family=fraunces:600,700,800,900|inter:400,500,600,700,800,900&display=swap" rel="stylesheet">

    <style>
        .display { font-family: 'Fraunces', Georgia, serif; font-variation-settings: "SOFT" 80, "WONK" 1; }
        body, .body-sans { font-family: 'Inter', system-ui, sans-serif; }
        @keyframes wiggle { 0%,100%{transform:rotate(-2deg)} 50%{transform:rotate(2deg)} }
        @keyframes bouncey { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        @keyframes floatRotate { 0%,100%{transform:rotate(-6deg) translateY(0)} 50%{transform:rotate(-6deg) translateY(-12px)} }
        @keyframes spin-slow { to { transform: rotate(360deg); } }
        .anim-wiggle { animation: wiggle 4s ease-in-out infinite; }
        .anim-bouncey { animation: bouncey 5s ease-in-out infinite; }
        .anim-spin-slow { animation: spin-slow 30s linear infinite; }
        .anim-float-r { animation: floatRotate 6s ease-in-out infinite; }
        .text-balance { text-wrap: balance; }
        .sticker-shadow { box-shadow: 6px 6px 0 0 #1c1917; }
        .sticker-shadow-pink { box-shadow: 6px 6px 0 0 #ec4899; }
        .sticker-shadow-yellow { box-shadow: 6px 6px 0 0 #fde047; }
        .sticker-shadow-sky { box-shadow: 6px 6px 0 0 #38bdf8; }
        .heavy-border { border: 3px solid #1c1917; }
    </style>

    {{-- ════════════════════════  HERO — punchy poster  ════════════════════════ --}}
    <section class="relative px-6 pt-12 pb-24 overflow-hidden">
        {{-- Floating decorative shapes --}}
        <svg class="absolute top-10 right-10 w-24 h-24 anim-spin-slow text-pink-500 opacity-90 hidden sm:block" viewBox="0 0 100 100" fill="currentColor">
            <path d="M50 0 L60 35 L95 50 L60 65 L50 100 L40 65 L5 50 L40 35 Z"/>
        </svg>
        <div class="absolute top-32 left-8 w-16 h-16 rounded-full bg-emerald-400 anim-bouncey heavy-border hidden sm:block"></div>
        <div class="absolute bottom-20 right-1/4 w-12 h-12 anim-wiggle hidden sm:block">
            <div class="w-full h-full bg-sky-400 heavy-border rotate-45"></div>
        </div>

        <div class="relative max-w-6xl mx-auto">
            {{-- Top sticker bar --}}
            <div class="flex flex-wrap items-center gap-3 mb-12">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-pink-300 heavy-border text-stone-900 text-[11px] font-black uppercase tracking-wider rotate-[-2deg] sticker-shadow">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-pulse"></span>
                    {{ $page->product_name }}
                </span>
                <span class="inline-flex items-center px-3 py-1.5 bg-yellow-300 heavy-border text-stone-900 text-[11px] font-black uppercase tracking-wider rotate-[1deg] sticker-shadow">
                    For {{ \Illuminate\Support\Str::limit($page->target_audience, 36) }}
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                {{-- LEFT: punch headline --}}
                <div class="lg:col-span-7">
                    <h1 class="display text-balance text-4xl sm:text-5xl lg:text-6xl font-black leading-[0.95] tracking-[-0.025em] text-stone-900">
                        <span class="block">{{ $headlineMain }}</span>
                        @if ($headlineAccent)
                            <span class="block italic text-rose-600">{{ $headlineAccent }}</span>
                        @endif
                    </h1>

                    {{-- Underline scribble --}}
                    <svg class="mt-3 h-3 w-48 text-rose-500" viewBox="0 0 200 12" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round">
                        <path d="M5 8 C 30 2, 70 12, 100 6 S 170 2, 195 8" />
                    </svg>

                    @if (!empty($content['sub_headline']))
                        <p class="mt-9 text-xl sm:text-2xl text-stone-700 max-w-lg leading-snug font-medium">
                            {{ $content['sub_headline'] }}
                        </p>
                    @endif

                    {{-- Big chunky CTA --}}
                    <div class="mt-10 flex flex-wrap items-center gap-4">
                        <a href="#pricing" class="group relative inline-flex items-center gap-3 px-7 py-4 bg-rose-500 hover:bg-rose-600 text-white font-black text-base heavy-border sticker-shadow rotate-[-1deg] hover:rotate-0 hover:translate-y-1 transition-all duration-200 uppercase tracking-wider">
                            {{ $cta['primary'] }}
                            <span class="text-2xl">→</span>
                        </a>
                        @if (!empty($cta['secondary']))
                            <a href="#features" class="inline-flex items-center px-6 py-3.5 bg-yellow-300 hover:bg-yellow-200 text-stone-900 font-black text-sm heavy-border sticker-shadow-pink rotate-[1deg] hover:rotate-0 hover:translate-y-1 transition-all duration-200 uppercase tracking-wider">
                                {{ $cta['secondary'] }}
                            </a>
                        @endif
                    </div>

                    @if (!empty($cta['urgency']))
                        <p class="mt-6 text-sm text-stone-700 max-w-md font-semibold">⚡ {{ $cta['urgency'] }}</p>
                    @endif
                </div>

                {{-- RIGHT: chunky stacked sticker preview --}}
                <div class="lg:col-span-5 relative h-[460px] lg:h-[540px]">
                    {{-- Big rotated card behind --}}
                    @if (isset($benefits[0]))
                        <div class="absolute top-4 right-0 w-72 sm:w-80 p-6 bg-emerald-300 heavy-border rotate-[6deg] anim-bouncey sticker-shadow">
                            <div class="text-[10px] uppercase tracking-widest font-black text-emerald-900 mb-2">Top Win</div>
                            <div class="text-xl font-black leading-tight">{{ \Illuminate\Support\Str::limit($benefits[0]['title'] ?? '', 70) }}</div>
                        </div>
                    @endif

                    {{-- Pricing chip --}}
                    @if (!empty($pricing['price']))
                        <div class="absolute top-44 left-0 w-56 p-5 bg-pink-300 heavy-border rotate-[-4deg] anim-float-r sticker-shadow-yellow">
                            <div class="text-[10px] uppercase tracking-widest font-black text-rose-900 mb-1">{{ $pricing['label'] ?? 'Price' }}</div>
                            <div class="display text-4xl font-black leading-none text-stone-900">{{ \Illuminate\Support\Str::limit($pricing['price'], 12) }}</div>
                            @if (!empty($pricing['note']))
                                <div class="text-[11px] text-rose-900 font-semibold mt-2 leading-snug">{{ \Illuminate\Support\Str::limit($pricing['note'], 50) }}</div>
                            @endif
                        </div>
                    @endif

                    {{-- Review chip --}}
                    @if (isset($reviews[0]))
                        <div class="absolute bottom-2 right-4 w-72 p-5 bg-yellow-300 heavy-border rotate-[3deg] anim-bouncey sticker-shadow-sky" style="animation-delay: -1s;">
                            <div class="flex gap-0.5 mb-2">
                                @for ($s = 0; $s < 5; $s++)
                                    <svg class="w-3.5 h-3.5 text-stone-900 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <p class="text-sm font-bold leading-snug text-stone-900">"{{ \Illuminate\Support\Str::limit(($reviews[0]['quote'] ?? ''), 80) }}"</p>
                            <div class="mt-3 text-[10px] uppercase tracking-widest font-black text-stone-700">— {{ $reviews[0]['author'] ?? '' }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if (!empty($content['description']))
        {{-- ════════════════════════  ABOUT  ════════════════════════ --}}
        <section class="px-6 py-20 bg-rose-100 heavy-border border-x-0">
            <div class="max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-stone-900 text-yellow-300 text-[10px] font-black uppercase tracking-widest mb-6 -rotate-1 sticker-shadow-pink heavy-border">
                    The Story
                </div>
                <h2 class="display text-4xl sm:text-5xl lg:text-6xl font-black leading-[0.95] tracking-tight mb-8">
                    Built for <span class="italic text-rose-600">{{ \Illuminate\Support\Str::limit($page->target_audience, 40) }}</span>.
                </h2>
                <div class="text-xl text-stone-800 leading-relaxed font-medium whitespace-pre-line">{{ $content['description'] }}</div>
            </div>
        </section>
    @endif

    @if (!empty($benefits))
        {{-- ════════════════════════  BENEFITS — sticker grid  ════════════════════════ --}}
        <section id="features" class="px-6 py-24">
            <div class="max-w-6xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-stone-900 text-yellow-300 text-[10px] font-black uppercase tracking-widest mb-6 rotate-1 sticker-shadow-pink heavy-border">
                    Why You'll Love It
                </div>
                <h2 class="display text-balance text-5xl sm:text-6xl lg:text-7xl font-black leading-[0.92] tracking-tight max-w-3xl">
                    Real wins. <span class="italic text-rose-600">Real fast.</span>
                </h2>

                @php
                    // Cap to 3 or 6 so the 3-col grid stays balanced (no orphan card).
                    $benefitCount = count($benefits);
                    $benefitsToShow = $benefitCount >= 6 ? array_slice($benefits, 0, 6) : array_slice($benefits, 0, 3);
                @endphp
                <div class="mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($benefitsToShow as $i => $benefit)
                        @php
                            $bg = $pastels[$i % count($pastels)];
                            $ink = $pastelInks[$i % count($pastelInks)];
                            $rot = ['-rotate-1', 'rotate-1', '-rotate-2', 'rotate-2', '-rotate-1', 'rotate-1'][$i % 6];
                        @endphp
                        <div class="group p-6 {{ $bg }} heavy-border sticker-shadow {{ $rot }} hover:rotate-0 hover:translate-y-1 transition-all duration-200">
                            <div class="display text-6xl font-black {{ $ink }} mb-3 leading-none">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                            <h3 class="text-xl font-black leading-tight {{ $ink }}">{{ $benefit['title'] ?? '' }}</h3>
                            @if (!empty($benefit['body']))
                                <p class="mt-3 text-sm text-stone-800 font-medium leading-relaxed">{{ $benefit['body'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (!empty($features))
        {{-- ════════════════════════  FEATURES — alternating sticker rows  ════════════════════════ --}}
        <section class="px-6 py-24 bg-yellow-100 heavy-border border-x-0">
            <div class="max-w-6xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-stone-900 text-pink-300 text-[10px] font-black uppercase tracking-widest mb-6 -rotate-1 sticker-shadow heavy-border">
                    What's Inside
                </div>
                <h2 class="display text-balance text-5xl sm:text-6xl lg:text-7xl font-black leading-[0.92] tracking-tight max-w-3xl">
                    Packed <span class="italic text-rose-600">to the brim.</span>
                </h2>

                <div class="mt-16 space-y-16">
                    @foreach (array_slice($features, 0, 4) as $i => $feature)
                        @php
                            $bg = $pastels[($i + 1) % count($pastels)];
                            $ink = $pastelInks[($i + 1) % count($pastelInks)];
                        @endphp
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center {{ $i % 2 === 1 ? 'lg:[&>*:first-child]:order-2' : '' }}">
                            <div class="lg:col-span-7">
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-stone-900 text-yellow-300 text-[10px] font-black uppercase tracking-widest mb-4 sticker-shadow-pink heavy-border">
                                    No. {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                </div>
                                <h3 class="display text-balance text-3xl sm:text-4xl lg:text-5xl font-black leading-[0.95] tracking-tight">{{ $feature['title'] ?? '' }}</h3>
                                @if (!empty($feature['body']))
                                    <p class="mt-5 text-lg text-stone-700 leading-relaxed font-medium">{{ $feature['body'] }}</p>
                                @endif
                            </div>
                            <div class="lg:col-span-5 relative">
                                <div class="aspect-square max-w-sm mx-auto p-8 {{ $bg }} heavy-border sticker-shadow {{ $i % 2 === 0 ? 'rotate-2' : '-rotate-2' }} flex flex-col justify-between">
                                    <div class="display text-8xl font-black {{ $ink }} leading-none">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                    <div class="space-y-2">
                                        <div class="h-3 w-3/4 bg-white/60 heavy-border"></div>
                                        <div class="h-3 w-1/2 bg-white/60 heavy-border"></div>
                                        <div class="h-10 bg-white heavy-border flex items-center justify-center font-black text-stone-900 text-sm uppercase tracking-wider">{{ $cta['primary'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if (count($features) > 4)
                    <div class="mt-20 grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-4xl mx-auto">
                        @foreach (array_slice($features, 4) as $i => $f)
                            @php
                                $bg = $pastels[($i + 3) % count($pastels)];
                                $rot = ['-rotate-1', 'rotate-1', '-rotate-2', 'rotate-2'][$i % 4];
                            @endphp
                            <div class="p-5 bg-white heavy-border sticker-shadow {{ $rot }}">
                                <div class="font-black text-base mb-1">→ {{ $f['title'] ?? '' }}</div>
                                @if (!empty($f['body']))
                                    <div class="text-sm text-stone-600 font-medium">{{ $f['body'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @endif

    @if (!empty($reviews))
        {{-- ════════════════════════  TESTIMONIALS — chunky sticker quotes  ════════════════════════ --}}
        <section class="px-6 py-24">
            <div class="max-w-6xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-stone-900 text-pink-300 text-[10px] font-black uppercase tracking-widest mb-6 rotate-1 sticker-shadow-yellow heavy-border">
                    People Are Talking
                </div>
                <h2 class="display text-balance text-5xl sm:text-6xl lg:text-7xl font-black leading-[0.92] tracking-tight max-w-3xl">
                    Voices from <span class="italic text-rose-600">the wild.</span>
                </h2>

                <div class="mt-16 grid grid-cols-1 md:grid-cols-{{ min(3, count($reviews)) }} gap-6">
                    @foreach ($reviews as $i => $review)
                        @php
                            $bg = $pastels[$i % count($pastels)];
                            $ink = $pastelInks[$i % count($pastelInks)];
                            $rot = ['rotate-2', '-rotate-1', 'rotate-1'][$i % 3];
                        @endphp
                        <figure class="p-6 {{ $bg }} heavy-border sticker-shadow {{ $rot }} hover:rotate-0 hover:translate-y-1 transition-all duration-200">
                            <div class="flex gap-0.5 mb-4">
                                @for ($s = 0; $s < 5; $s++)
                                    <svg class="w-4 h-4 text-stone-900 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <blockquote class="display text-2xl font-black leading-tight {{ $ink }}">"{{ $review['quote'] ?? '' }}"</blockquote>
                            <figcaption class="mt-5 pt-4 border-t-2 border-stone-900 flex items-center gap-3">
                                <div class="w-10 h-10 bg-white heavy-border flex items-center justify-center font-black text-base">
                                    {{ strtoupper(mb_substr($review['author'] ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black uppercase tracking-wider">{{ $review['author'] ?? '' }}</div>
                                    <div class="text-[10px] text-stone-700 uppercase tracking-widest font-bold">{{ $review['role'] ?? '' }}</div>
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
                <p class="text-[10px] text-stone-500 mt-8 italic">Testimonials are illustrative placeholders.</p>
            </div>
        </section>
    @endif

    {{-- ════════════════════════  PRICING — chunky main card  ════════════════════════ --}}
    <section id="pricing" class="px-6 py-24 bg-sky-100 heavy-border border-x-0">
        <div class="max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-stone-900 text-yellow-300 text-[10px] font-black uppercase tracking-widest mb-6 -rotate-1 sticker-shadow-pink heavy-border">
                Get In On It
            </div>
            <h2 class="display text-balance text-5xl sm:text-6xl lg:text-7xl font-black leading-[0.92] tracking-tight mb-12">
                One <span class="italic text-rose-600">simple</span> price.
            </h2>

            <div class="relative">
                {{-- Sticker badge --}}
                <div class="absolute -top-4 -right-4 z-10 px-4 py-2 bg-pink-500 text-white heavy-border text-xs font-black uppercase tracking-wider rotate-6 sticker-shadow">
                    Best Deal ✨
                </div>

                <div class="bg-white heavy-border sticker-shadow p-8 sm:p-12">
                    <div class="text-center pb-8 border-b-3 border-stone-900" style="border-bottom-width:3px">
                        <div class="text-[10px] uppercase tracking-widest font-black text-rose-600 mb-3">{{ $pricing['label'] ?? 'Plan' }}</div>
                        <div class="display text-7xl sm:text-8xl font-black tracking-tight leading-none">{{ $pricing['price'] }}</div>
                        @if (!empty($pricing['note']))
                            <p class="mt-4 text-base text-stone-700 font-semibold">{{ $pricing['note'] }}</p>
                        @endif
                    </div>

                    @if (!empty($features))
                        <div class="pt-8">
                            <div class="text-[10px] uppercase tracking-widest font-black text-stone-700 mb-5">What you get →</div>
                            <ul class="space-y-3">
                                @foreach (array_slice($features, 0, 8) as $feature)
                                    <li class="flex items-start gap-3 text-base font-bold text-stone-900">
                                        <span class="w-6 h-6 bg-emerald-300 heavy-border flex items-center justify-center shrink-0 mt-0.5 rotate-3">
                                            <svg class="w-3 h-3 text-stone-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75 10.5 18l9-13.5"/></svg>
                                        </span>
                                        <span>{{ $feature['title'] ?? '' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mt-10 space-y-3">
                        <a href="#" class="block w-full px-5 py-4 bg-rose-500 hover:bg-rose-600 text-white font-black text-base text-center heavy-border sticker-shadow uppercase tracking-wider hover:translate-y-1 transition-transform">
                            {{ $cta['primary'] }} →
                        </a>
                        @if (!empty($cta['secondary']))
                            <a href="#" class="block w-full px-5 py-3 bg-yellow-300 text-stone-900 font-black text-sm text-center heavy-border sticker-shadow-pink uppercase tracking-wider hover:translate-y-1 transition-transform">
                                {{ $cta['secondary'] }}
                            </a>
                        @endif
                    </div>

                    @if (!empty($cta['urgency']))
                        <p class="text-center text-sm text-stone-700 font-semibold mt-6">⚡ {{ $cta['urgency'] }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════════════════  FINAL CTA — big poster  ════════════════════════ --}}
    <section class="px-6 py-24 bg-stone-900 text-yellow-300 relative overflow-hidden">
        {{-- decorative shapes --}}
        <div class="absolute top-12 left-12 w-20 h-20 anim-spin-slow bg-pink-500 heavy-border" style="border-color:#fde047"></div>
        <div class="absolute bottom-16 right-16 w-16 h-16 rounded-full bg-emerald-400 heavy-border anim-bouncey" style="border-color:#fde047"></div>
        <div class="absolute top-1/2 left-1/4 w-12 h-12 anim-wiggle bg-sky-400 heavy-border rotate-45" style="border-color:#fde047"></div>

        <div class="relative max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-yellow-300 text-stone-900 text-[10px] font-black uppercase tracking-widest mb-8 rotate-[-2deg] heavy-border">
                Last Chance ⚡
            </div>
            <h2 class="display text-balance text-6xl sm:text-7xl lg:text-[7rem] font-black leading-[0.88] tracking-tight">
                Don't <span class="italic text-pink-400">overthink it.</span>
            </h2>
            @if (!empty($content['sub_headline']))
                <p class="mt-8 text-xl text-yellow-100 max-w-xl mx-auto font-bold leading-snug">
                    {{ \Illuminate\Support\Str::limit($content['sub_headline'], 130) }}
                </p>
            @endif
            <div class="mt-12 flex flex-wrap items-center justify-center gap-4">
                <a href="#pricing" class="group inline-flex items-center gap-3 px-8 py-4 bg-pink-500 hover:bg-pink-600 text-white font-black text-base heavy-border sticker-shadow-yellow rotate-[-1deg] hover:rotate-0 hover:translate-y-1 transition-all duration-200 uppercase tracking-wider">
                    {{ $cta['primary'] }} <span class="text-2xl">→</span>
                </a>
                @if (!empty($cta['secondary']))
                    <a href="#" class="inline-flex items-center px-8 py-4 bg-emerald-400 hover:bg-emerald-300 text-stone-900 font-black text-base heavy-border sticker-shadow-pink rotate-[1deg] hover:rotate-0 hover:translate-y-1 transition-all duration-200 uppercase tracking-wider">
                        {{ $cta['secondary'] }}
                    </a>
                @endif
            </div>
            @if (!empty($cta['urgency']))
                <p class="mt-8 text-sm text-yellow-100 font-bold">⚡ {{ $cta['urgency'] }}</p>
            @endif
        </div>
    </section>
</div>
