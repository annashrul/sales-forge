<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SalesForge — AI sales pages, in 30 seconds.</title>
    <meta name="description" content="Turn raw product info into a complete, persuasive sales page — headline, benefits, social proof, CTA — drafted by AI, ready to ship.">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.svg') }}">
    <meta name="theme-color" content="#09090b">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes floaty { 0%,100%{transform:translate3d(0,0,0)} 50%{transform:translate3d(0,-14px,0)} }
        @keyframes floaty-rev { 0%,100%{transform:translate3d(0,0,0)} 50%{transform:translate3d(0,10px,0)} }
        @keyframes spin-slow { to { transform: rotate(360deg); } }
        @keyframes spin-slower { to { transform: rotate(-360deg); } }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(255,90,54,0.55), 0 25px 60px -15px rgba(0,0,0,0.55); }
            50% { box-shadow: 0 0 0 22px rgba(255,90,54,0), 0 25px 60px -15px rgba(0,0,0,0.55); }
        }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes drift-up { 0% { transform: translateY(20px); opacity: 0; } 100% { transform: translateY(0); opacity: 1; } }
        @keyframes marquee { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }
        .anim-floaty { animation: floaty 7s ease-in-out infinite; }
        .anim-floaty-rev { animation: floaty-rev 8s ease-in-out infinite; }
        .anim-spin-slow { animation: spin-slow 40s linear infinite; }
        .anim-spin-slower { animation: spin-slower 60s linear infinite; }
        .anim-pulse-glow { animation: pulse-glow 2.6s ease-in-out infinite; }
        .anim-drift-up { animation: drift-up 0.7s cubic-bezier(0.16,1,0.3,1) both; }
        .anim-marquee { animation: marquee 35s linear infinite; }
        .grain-dark { background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' /%3E%3CfeColorMatrix values='0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.18 0'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' /%3E%3C/svg%3E"); }
        .text-balance { text-wrap: balance; }
        .glow-cta { box-shadow: 0 0 0 1px rgba(255,255,255,0.06), 0 18px 60px -12px rgba(255,90,54,0.65), 0 8px 24px -8px rgba(255,90,54,0.45); }
        .glow-card { box-shadow: 0 30px 80px -20px rgba(0,0,0,0.45), 0 8px 24px -8px rgba(255,90,54,0.15); }
        .glass { background: rgba(255,255,255,0.04); backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px); }
    </style>
</head>
<body class="font-sans antialiased bg-zinc-950 text-stone-50 selection:bg-stone-50 selection:text-zinc-950 overflow-x-hidden">

    {{-- ════════════════════════  NAV BAR  ════════════════════════ --}}
    <nav class="fixed top-0 inset-x-0 z-50 px-6 py-3.5 bg-zinc-950/80 backdrop-blur-xl border-b border-stone-50/[0.06]">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5 group">
                <div class="relative">
                    <div class="absolute inset-0 bg-[#FF5A36] blur-md opacity-50 group-hover:opacity-80 transition"></div>
                    <div class="relative w-9 h-9 rounded-xl bg-zinc-950 ring-1 ring-stone-50/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#FF5A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-black tracking-tight text-stone-50">SalesForge</span>
                    <span class="text-[9px] uppercase tracking-[0.18em] text-stone-500 font-bold mt-0.5">AI Sales Pages</span>
                </div>
            </a>
            <div class="flex items-center gap-3 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-[#FF5A36] hover:bg-[#FF6B49] text-white font-bold glow-cta hover:-translate-y-0.5 transition-all duration-200">
                        Open dashboard
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex px-3 py-2 text-stone-300 hover:text-stone-50 font-semibold transition">Sign in</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-[#FF5A36] hover:bg-[#FF6B49] text-white font-bold glow-cta hover:-translate-y-0.5 transition-all duration-200">
                        Get started free
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ════════════════════════  HERO  ════════════════════════ --}}
    <section class="relative px-6 pt-32 pb-32 sm:pt-40 sm:pb-44 overflow-hidden">
        {{-- Backdrop --}}
        <div class="absolute inset-0 -z-10 pointer-events-none">
            <div class="absolute top-1/4 right-[-10%] w-[820px] h-[820px] rounded-full bg-gradient-to-br from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8] opacity-30 blur-[140px]"></div>
            <div class="absolute -top-32 -left-40 w-[640px] h-[640px] rounded-full bg-stone-50/5 blur-[120px]"></div>
            <svg class="absolute right-0 top-0 w-3/4 h-full opacity-[0.05]" viewBox="0 0 600 600" fill="none" preserveAspectRatio="xMidYMid slice">
                <circle cx="500" cy="300" r="200" stroke="white" stroke-width="0.6"/>
                <circle cx="500" cy="300" r="280" stroke="white" stroke-width="0.6"/>
                <circle cx="500" cy="300" r="360" stroke="white" stroke-width="0.6"/>
                <circle cx="500" cy="300" r="440" stroke="white" stroke-width="0.6"/>
            </svg>
            <svg class="absolute inset-0 w-full h-full opacity-50" viewBox="0 0 1200 800" preserveAspectRatio="none">
                @foreach ([['80','120','1.5'],['180','340','1'],['320','520','2'],['540','220','1.2'],['820','440','1.5'],['960','620','1'],['1080','180','1.8'],['260','680','1'],['460','660','1.4'],['660','120','1'],['920','280','1.2']] as $p)
                    <circle cx="{{ $p[0] }}" cy="{{ $p[1] }}" r="{{ $p[2] }}" fill="white" opacity="0.5"/>
                @endforeach
            </svg>
            <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-zinc-950 to-transparent"></div>
        </div>

        <div class="relative max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-6 items-start">
                {{-- LEFT: copy --}}
                <div class="lg:col-span-7 relative">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full glass ring-1 ring-stone-50/10 text-[11px] font-bold uppercase tracking-[0.18em] mb-8">
                        <span class="relative flex w-1.5 h-1.5">
                            <span class="absolute inset-0 rounded-full bg-emerald-400 animate-ping"></span>
                            <span class="relative w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        </span>
                        Powered by Gemini 2.5
                    </div>

                    <h1 class="text-balance text-5xl sm:text-6xl lg:text-7xl xl:text-[5.5rem] font-black tracking-[-0.045em] leading-[0.92] text-stone-50">
                        <span class="block anim-drift-up" style="animation-delay:0.05s">Sales pages,</span>
                        <span class="block italic font-serif font-light bg-gradient-to-r from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8] bg-clip-text text-transparent anim-drift-up" style="animation-delay:0.18s">drafted by AI.</span>
                        <span class="block anim-drift-up" style="animation-delay:0.32s">In 30 seconds.</span>
                    </h1>

                    <p class="mt-9 text-lg sm:text-xl text-stone-300 max-w-xl leading-relaxed font-light">
                        Drop in your product details. Pick a tone and template. Get a complete, persuasive landing page — headline, benefits, social proof, pricing, CTA — ready to preview and export.
                    </p>

                    <div class="mt-12 flex flex-wrap items-center gap-3">
                        @auth
                            <a href="{{ route('sales-pages.create') }}" class="group relative inline-flex items-center gap-2.5 pl-7 pr-3 py-3 rounded-full font-bold text-base bg-[#FF5A36] hover:bg-[#FF6B49] text-white glow-cta hover:-translate-y-0.5 transition-all duration-300">
                                <span class="absolute inset-0 rounded-full bg-gradient-to-r from-white/0 via-white/30 to-white/0 opacity-0 group-hover:opacity-100 transition-opacity" style="background-size:200% 100%;animation:shimmer 1.6s linear infinite"></span>
                                <span class="relative">Generate a sales page</span>
                                <span class="relative w-9 h-9 rounded-full bg-white/15 backdrop-blur-sm flex items-center justify-center group-hover:translate-x-0.5 transition-transform">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                                </span>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="group relative inline-flex items-center gap-2.5 pl-7 pr-3 py-3 rounded-full font-bold text-base bg-[#FF5A36] hover:bg-[#FF6B49] text-white glow-cta hover:-translate-y-0.5 transition-all duration-300">
                                <span class="absolute inset-0 rounded-full bg-gradient-to-r from-white/0 via-white/30 to-white/0 opacity-0 group-hover:opacity-100 transition-opacity" style="background-size:200% 100%;animation:shimmer 1.6s linear infinite"></span>
                                <span class="relative">Try it free</span>
                                <span class="relative w-9 h-9 rounded-full bg-white/15 backdrop-blur-sm flex items-center justify-center group-hover:translate-x-0.5 transition-transform">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                                </span>
                            </a>
                            <a href="#how" class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-sm text-stone-100 glass ring-1 ring-stone-50/10 hover:ring-stone-50/30 hover:-translate-y-0.5 transition-all duration-300">
                                <span class="w-7 h-7 rounded-full bg-stone-50/10 flex items-center justify-center">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </span>
                                See it work
                            </a>
                        @endauth
                    </div>

                    <p class="mt-5 text-xs text-stone-400 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75 10.5 18l9-13.5"/></svg>
                        Free forever for personal use · No credit card · 3 design templates
                    </p>
                </div>

                {{-- RIGHT: 3D orb composition --}}
                <div class="lg:col-span-5 relative h-[480px] sm:h-[560px] lg:h-[600px]">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="absolute w-[420px] h-[420px] rounded-full border border-stone-50/10 anim-spin-slow">
                            <span class="absolute -top-1.5 left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-[#FF5A36]" style="box-shadow:0 0 24px rgba(255,90,54,0.8)"></span>
                            <span class="absolute -bottom-1 left-12 w-2 h-2 rounded-full bg-stone-50/60"></span>
                            <span class="absolute top-1/4 -right-1 w-2 h-2 rounded-full bg-teal-400"></span>
                        </div>
                        <div class="absolute w-[320px] h-[320px] rounded-full border border-stone-50/10 anim-spin-slower">
                            <span class="absolute top-12 -left-1.5 w-3 h-3 rotate-45 bg-teal-500"></span>
                            <span class="absolute bottom-8 right-4 w-2 h-2 rounded-full bg-[#FF5A36]"></span>
                        </div>

                        {{-- Main orb --}}
                        <div class="relative w-[260px] h-[260px] rounded-full bg-gradient-to-br from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8]" style="box-shadow: 0 60px 120px -20px rgba(255,90,54,0.55), inset -20px -30px 60px rgba(0,0,0,0.25), inset 15px 20px 40px rgba(255,255,255,0.35);">
                            <div class="absolute top-6 left-12 w-28 h-28 rounded-full bg-white/40 blur-2xl"></div>
                            <div class="absolute bottom-10 right-8 w-32 h-32 rounded-full bg-white/15 blur-3xl"></div>
                            <div class="absolute inset-0 rounded-full ring-1 ring-inset ring-white/30"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-20 h-20 text-white/70 mix-blend-overlay" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Floating glass: AI generation --}}
                        <div class="absolute top-2 left-0 sm:left-2 w-56 rounded-2xl glass ring-1 ring-stone-50/15 p-4 anim-floaty" style="box-shadow: 0 30px 80px -20px rgba(0,0,0,0.5);">
                            <div class="flex items-center gap-2 mb-2.5">
                                <div class="w-7 h-7 rounded-xl bg-[#FF5A36] flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-stone-400">Drafting page</div>
                                    <div class="text-sm font-bold text-stone-50">28.4s</div>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <div class="h-1.5 w-full rounded-full bg-stone-50/10 overflow-hidden">
                                    <div class="h-full w-[78%] rounded-full bg-gradient-to-r from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8]"></div>
                                </div>
                                <div class="text-[10px] text-stone-400">Headline · Benefits · CTA</div>
                            </div>
                        </div>

                        {{-- Floating: 3 templates available --}}
                        <div class="absolute top-1/3 right-0 sm:-right-4 w-44 rounded-2xl bg-zinc-900/90 ring-1 ring-stone-50/10 p-4 anim-floaty-rev" style="box-shadow: 0 30px 80px -20px rgba(0,0,0,0.6);">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-stone-400 mb-2">Templates</div>
                            <div class="grid grid-cols-3 gap-1.5">
                                <div class="aspect-square rounded-md bg-gradient-to-br from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8]"></div>
                                <div class="aspect-square rounded-md bg-gradient-to-br from-stone-700 via-amber-500 to-amber-300"></div>
                                <div class="aspect-square rounded-md bg-gradient-to-br from-rose-400 via-pink-400 to-yellow-300"></div>
                            </div>
                            <div class="mt-2.5 text-[10px] text-stone-300 font-medium">Modern · Classic · Bold</div>
                        </div>

                        {{-- Floating: feature export --}}
                        <div class="absolute bottom-2 left-2 sm:-left-2 w-60 rounded-2xl glass ring-1 ring-stone-50/15 p-4 anim-floaty" style="box-shadow: 0 30px 80px -20px rgba(0,0,0,0.5); animation-delay: -1.5s;">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-7 h-7 rounded-xl bg-emerald-400/20 ring-1 ring-emerald-400/40 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-stone-400">Exported</div>
                                    <div class="text-sm font-bold text-stone-50">my-product.html</div>
                                </div>
                            </div>
                            <div class="text-[10px] text-stone-400">Standalone HTML · 18 KB · Tailwind via CDN</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom stat strip --}}
            <div class="mt-24 sm:mt-28 relative">
                <div class="rounded-2xl glass ring-1 ring-stone-50/10 overflow-hidden">
                    <div class="flex items-stretch divide-x divide-stone-50/10">
                        @foreach ([['<60s', 'To draft'], ['3', 'Templates'], ['8', 'Sections / page'], ['1-click', 'HTML export'], ['100%', 'Editable']] as $stat)
                            <div class="flex-1 px-4 sm:px-8 py-5 text-center">
                                <div class="text-2xl sm:text-3xl font-black tracking-tight text-stone-50">{{ $stat[0] }}</div>
                                <div class="text-[10px] uppercase tracking-[0.16em] text-stone-400 font-semibold mt-1">{{ $stat[1] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════════════════  PROBLEM (typographic statement)  ════════════════════════ --}}
    <section class="relative px-6 py-32 sm:py-40 overflow-hidden">
        <div class="absolute inset-0 -z-10 grain-dark opacity-30 pointer-events-none"></div>
        <div class="absolute -top-32 right-0 w-96 h-96 rounded-full bg-gradient-to-br from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8] opacity-15 blur-3xl pointer-events-none"></div>

        <div class="relative max-w-6xl mx-auto">
            <div class="flex items-center gap-4 mb-12">
                <span class="text-[10px] uppercase tracking-[0.22em] text-stone-500 font-bold">Chapter 01</span>
                <div class="flex-1 h-px bg-stone-50/10"></div>
                <span class="text-[10px] uppercase tracking-[0.22em] text-teal-400 font-bold">The problem</span>
            </div>

            <h2 class="text-balance text-4xl sm:text-6xl lg:text-7xl font-black tracking-[-0.04em] leading-[0.95] max-w-5xl">
                Building sales pages by hand
                <span class="italic font-serif font-light bg-gradient-to-r from-stone-300 via-stone-500 to-stone-300 bg-clip-text text-transparent">eats your week.</span>
            </h2>
            <p class="mt-8 text-lg sm:text-xl text-stone-400 max-w-2xl leading-relaxed">
                You stare at a blank doc. You copy competitors. You wait for a designer. You ship something generic. And then it doesn't convert.
            </p>

            <div class="mt-20 grid grid-cols-1 sm:grid-cols-3 gap-12 sm:gap-6">
                @foreach ([
                    ['8h', '+', 'spent per page', 'Wireframe, copy, design, review loops — all repeated for every product launch.'],
                    ['62', '%', 'pages converting <2%', 'Most landing pages never get the headline-benefit-CTA structure right.'],
                    ['3', 'wks', 'avg launch time', 'Designer queue. Copy review. Stakeholder edits. Repeat.'],
                ] as $stat)
                    <div class="group">
                        <div class="flex items-baseline gap-1">
                            <span class="text-7xl sm:text-8xl lg:text-9xl font-black tracking-[-0.05em] bg-gradient-to-br from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8] bg-clip-text text-transparent group-hover:scale-105 origin-left transition-transform duration-500 inline-block">{{ $stat[0] }}</span>
                            <span class="text-3xl sm:text-4xl font-bold text-stone-500">{{ $stat[1] }}</span>
                        </div>
                        <div class="mt-3 text-base font-semibold text-stone-200">{{ $stat[2] }}</div>
                        <p class="mt-2 text-sm text-stone-500 leading-relaxed">{{ $stat[3] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-b from-zinc-950 via-zinc-950/80 to-stone-50 pointer-events-none"></div>
    </section>

    {{-- ════════════════════════  HOW IT WORKS (3 steps, light)  ════════════════════════ --}}
    <section id="how" class="px-6 py-32 sm:py-40 bg-stone-50 text-zinc-950">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center gap-4 mb-10">
                <span class="text-[10px] uppercase tracking-[0.22em] text-stone-500 font-bold">Chapter 02</span>
                <div class="flex-1 h-px bg-zinc-950/10"></div>
                <span class="text-[10px] uppercase tracking-[0.22em] text-[#FF5A36] font-bold">How it works</span>
            </div>

            <h2 class="text-balance text-4xl sm:text-6xl lg:text-7xl font-black tracking-[-0.04em] leading-[0.92] max-w-4xl text-zinc-950">
                Three inputs.
                <span class="italic font-serif font-light text-[#FF5A36]">One sales page.</span>
            </h2>

            <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-6 relative">
                {{-- Connecting line --}}
                <div class="hidden md:block absolute top-12 left-[16.66%] right-[16.66%] h-px bg-gradient-to-r from-transparent via-zinc-950/20 to-transparent"></div>

                @foreach ([
                    ['01', 'Describe the product', 'Drop in name, description, key features, target audience, price, and unique selling points.', 'M16.862 4.487 18.549 2.799a2.121 2.121 0 1 1 3 3L5.12 22.227a4.5 4.5 0 0 1-1.897 1.13l-3.36.99a.563.563 0 0 1-.692-.692l.99-3.36a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Zm0 0L19.5 7.125'],
                    ['02', 'Pick voice & template', 'Choose tone (persuasive, formal, casual, urgent, inspirational) and design template (Modern, Classic, Bold).', 'M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z'],
                    ['03', 'Preview & export', 'Live-preview as a styled landing page. Regenerate sections, switch templates, or export standalone HTML.', 'M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3'],
                ] as $step)
                    <div class="relative">
                        <div class="relative w-24 h-24 mx-auto mb-6">
                            <div class="absolute inset-0 rounded-full bg-[#FFE4DC] ring-4 ring-stone-50"></div>
                            <div class="absolute inset-2 rounded-full bg-zinc-950 flex items-center justify-center">
                                <span class="text-2xl font-black text-[#FF5A36]">{{ $step[0] }}</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-black tracking-tight text-zinc-950">{{ $step[1] }}</h3>
                            <p class="mt-3 text-sm text-zinc-600 leading-relaxed max-w-xs mx-auto">{{ $step[2] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ════════════════════════  TEMPLATES SHOWCASE  ════════════════════════ --}}
    <section class="relative px-6 py-32 sm:py-40 bg-zinc-950 text-stone-50 overflow-hidden">
        <div class="absolute inset-0 grain-dark opacity-25 pointer-events-none"></div>
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[800px] h-[800px] rounded-full bg-gradient-to-br from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8] opacity-10 blur-3xl pointer-events-none"></div>

        <div class="relative max-w-6xl mx-auto">
            <div class="flex items-center gap-4 mb-10">
                <span class="text-[10px] uppercase tracking-[0.22em] text-stone-500 font-bold">Chapter 03</span>
                <div class="flex-1 h-px bg-stone-50/10"></div>
                <span class="text-[10px] uppercase tracking-[0.22em] text-teal-400 font-bold">Three templates</span>
            </div>

            <h2 class="text-balance text-4xl sm:text-6xl lg:text-7xl font-black tracking-[-0.04em] leading-[0.92] max-w-4xl">
                One page,
                <span class="italic font-serif font-light bg-gradient-to-r from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8] bg-clip-text text-transparent">three personalities.</span>
            </h2>
            <p class="mt-8 text-lg text-stone-400 max-w-2xl leading-relaxed">
                Each template has its own typography, color system, and layout — same content, completely different feel.
            </p>

            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach ([
                    ['Modern', 'Cinematic dark', 'Premium SaaS — coral accent, 3D orb hero, glass cards.', 'bg-gradient-to-br from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8]'],
                    ['Classic', 'Editorial light', 'Magazine cover — serif typography, drop caps, Roman numerals.', 'bg-gradient-to-br from-stone-800 via-stone-700 to-amber-500'],
                    ['Bold', 'Playful sticker', 'Memphis-style — chunky borders, sticker shadows, vibrant pastels.', 'bg-gradient-to-br from-rose-500 via-pink-500 to-yellow-400'],
                ] as $i => $tpl)
                    <div class="group rounded-3xl bg-zinc-900 ring-1 ring-stone-50/10 overflow-hidden hover:ring-[#FF5A36]/40 hover:-translate-y-1 transition-all duration-300">
                        <div class="h-44 relative overflow-hidden {{ $tpl[3] }}">
                            <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.5), transparent 60%);"></div>
                            <span class="absolute bottom-4 left-5 text-white font-black text-3xl tracking-tight drop-shadow-lg">{{ $tpl[0] }}</span>
                            <span class="absolute top-4 right-4 inline-flex items-center px-2 py-0.5 rounded-md bg-white/20 backdrop-blur text-white text-[10px] font-bold uppercase tracking-widest">0{{ $i + 1 }}</span>
                        </div>
                        <div class="p-6">
                            <div class="text-[10px] uppercase tracking-[0.18em] text-stone-400 font-bold mb-2">{{ $tpl[1] }}</div>
                            <p class="text-sm text-stone-300 leading-relaxed">{{ $tpl[2] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ════════════════════════  WHAT YOU GET (sections breakdown)  ════════════════════════ --}}
    <section class="px-6 py-32 sm:py-40 bg-stone-50 text-zinc-950">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center gap-4 mb-10">
                <span class="text-[10px] uppercase tracking-[0.22em] text-stone-500 font-bold">Chapter 04</span>
                <div class="flex-1 h-px bg-zinc-950/10"></div>
                <span class="text-[10px] uppercase tracking-[0.22em] text-[#FF5A36] font-bold">What you get</span>
            </div>

            <h2 class="text-balance text-4xl sm:text-6xl lg:text-7xl font-black tracking-[-0.04em] leading-[0.92] max-w-4xl">
                Eight sections.
                <span class="italic font-serif font-light text-[#FF5A36]">All written.</span>
            </h2>

            <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                @foreach ([
                    ['Headline', 'Benefit-led, 8-14 word'],
                    ['Sub-headline', '1-sentence promise'],
                    ['Description', '2-3 paragraph narrative'],
                    ['Benefits', '3-5 outcome-driven'],
                    ['Features', '3-6 detailed breakdown'],
                    ['Social proof', '2-3 testimonials'],
                    ['Pricing', 'Label · price · note'],
                    ['CTA', 'Primary · secondary · urgency'],
                ] as $i => $section)
                    <div class="group bg-white ring-1 ring-zinc-950/[0.06] rounded-2xl p-5 hover:ring-[#FF5A36]/40 hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-[10px] uppercase tracking-[0.18em] text-zinc-400 font-bold">0{{ $i + 1 }}</div>
                            <svg class="w-4 h-4 text-[#FF5A36] opacity-0 group-hover:opacity-100 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75 10.5 18l9-13.5"/></svg>
                        </div>
                        <div class="text-base font-black text-zinc-950">{{ $section[0] }}</div>
                        <div class="text-xs text-zinc-500 mt-1">{{ $section[1] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ════════════════════════  TESTIMONIAL (illustrative)  ════════════════════════ --}}
    <section class="relative px-6 py-32 sm:py-40 bg-zinc-950 text-stone-50 overflow-hidden">
        <div class="absolute inset-0 grain-dark opacity-25 pointer-events-none"></div>
        <div class="absolute -top-40 right-1/4 w-[500px] h-[500px] rounded-full bg-gradient-to-br from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8] opacity-15 blur-3xl pointer-events-none"></div>

        <div class="relative max-w-4xl mx-auto">
            <div class="flex items-center gap-4 mb-10">
                <span class="text-[10px] uppercase tracking-[0.22em] text-stone-500 font-bold">Chapter 05</span>
                <div class="flex-1 h-px bg-stone-50/10"></div>
                <span class="text-[10px] uppercase tracking-[0.22em] text-teal-400 font-bold">Voice from the field</span>
            </div>

            <svg class="w-12 h-12 text-[#FF5A36] opacity-70 mb-6" fill="currentColor" viewBox="0 0 32 32">
                <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36 1 24.6 4.456 28 8.224 28c3.456 0 6.024-2.752 6.024-6.024 0-3.272-2.272-5.656-5.272-5.656-.6 0-1.4.12-1.6.2.52-3.512 3.84-7.656 7.16-9.752L9.352 4Zm15.32 0c-4.84 3.456-8.296 9.12-8.296 15.36 0 5.24 3.456 8.64 7.224 8.64 3.4 0 6.024-2.752 6.024-6.024 0-3.272-2.32-5.656-5.32-5.656-.6 0-1.352.12-1.552.2.52-3.512 3.792-7.656 7.112-9.752L24.672 4Z"/>
            </svg>

            <blockquote class="text-balance text-3xl sm:text-4xl lg:text-5xl font-medium leading-[1.15] tracking-[-0.02em] text-stone-100">
                "Drafted three sales pages in under five minutes — one of them is now our highest-converting funnel."
            </blockquote>

            <figcaption class="mt-10 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8] flex items-center justify-center text-base font-black text-zinc-950 shrink-0">S</div>
                <div>
                    <div class="text-base font-bold text-stone-50">Sarah Chen</div>
                    <div class="text-sm text-stone-400">Head of Growth</div>
                </div>
                <div class="hidden sm:flex items-center gap-0.5 ml-auto">
                    @for ($s = 0; $s < 5; $s++)
                        <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
            </figcaption>
            <p class="text-[11px] text-stone-600 mt-8">Testimonial is illustrative.</p>
        </div>
    </section>

    {{-- ════════════════════════  FINAL CTA  ════════════════════════ --}}
    <section class="relative px-6 py-32 sm:py-40 bg-zinc-950 text-stone-50 overflow-hidden">
        <div class="absolute inset-0 grain-dark opacity-30 pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-zinc-950 via-zinc-900 to-zinc-950 -z-10"></div>
        <div class="absolute -top-40 -right-40 w-[700px] h-[700px] rounded-full bg-gradient-to-br from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8] opacity-30 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] rounded-full bg-teal-500 opacity-15 blur-3xl pointer-events-none"></div>

        <svg class="absolute inset-0 w-full h-full opacity-40 pointer-events-none" viewBox="0 0 1200 800" preserveAspectRatio="none">
            @foreach ([['100','120','1.5'],['260','340','1'],['540','520','2'],['820','220','1.2'],['1080','440','1.5'],['960','620','1'],['180','680','1.2'],['460','660','1.4'],['660','120','1']] as $p)
                <circle cx="{{ $p[0] }}" cy="{{ $p[1] }}" r="{{ $p[2] }}" fill="white" opacity="0.45"/>
            @endforeach
        </svg>

        <div class="relative max-w-5xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full glass ring-1 ring-stone-50/15 text-[11px] font-bold uppercase tracking-[0.18em] mb-10">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                Free forever for personal use
            </div>
            <h2 class="text-balance text-5xl sm:text-7xl lg:text-[7rem] font-black tracking-[-0.045em] leading-[0.9] max-w-5xl mx-auto">
                Ship the page.
                <span class="block italic font-serif font-light bg-gradient-to-r from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8] bg-clip-text text-transparent">Skip the week.</span>
            </h2>
            <p class="mt-10 text-lg sm:text-xl text-stone-300 max-w-xl mx-auto leading-relaxed font-light">
                Sign up free. Generate your first sales page in under 60 seconds.
            </p>

            <div class="mt-12 flex flex-wrap items-center justify-center gap-3">
                @auth
                    <a href="{{ route('sales-pages.create') }}" class="group relative inline-flex items-center gap-2.5 pl-8 pr-3 py-3.5 rounded-full font-bold text-base bg-[#FF5A36] hover:bg-[#FF6B49] text-white glow-cta hover:-translate-y-0.5 transition-all duration-300">
                        Generate sales page
                        <span class="w-9 h-9 rounded-full bg-white/15 backdrop-blur-sm flex items-center justify-center group-hover:translate-x-0.5 transition-transform">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </span>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="group relative inline-flex items-center gap-2.5 pl-8 pr-3 py-3.5 rounded-full font-bold text-base bg-[#FF5A36] hover:bg-[#FF6B49] text-white glow-cta hover:-translate-y-0.5 transition-all duration-300">
                        Get started free
                        <span class="w-9 h-9 rounded-full bg-white/15 backdrop-blur-sm flex items-center justify-center group-hover:translate-x-0.5 transition-transform">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </span>
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center px-7 py-3.5 rounded-full font-bold text-base text-stone-100 glass ring-1 ring-stone-50/15 hover:ring-stone-50/30 hover:-translate-y-0.5 transition-all duration-300">
                        I already have an account
                    </a>
                @endauth
            </div>
            <p class="mt-6 text-xs text-stone-500">No credit card · 3 design templates · Export HTML anytime</p>
        </div>
    </section>

    {{-- ════════════════════════  FOOTER  ════════════════════════ --}}
    <footer class="px-6 py-12 bg-zinc-950 text-stone-50 border-t border-stone-50/[0.06]">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-zinc-900 ring-1 ring-stone-50/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#FF5A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/></svg>
                </div>
                <span class="font-black text-stone-50">SalesForge</span>
                <span class="text-stone-500 text-sm">— AI Sales Pages</span>
            </div>
            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-stone-400">
                <a href="{{ route('login') }}" class="hover:text-stone-50 transition">Sign in</a>
                <a href="{{ route('register') }}" class="hover:text-stone-50 transition">Create account</a>
                <span class="text-stone-600">·</span>
                <span class="text-stone-500">© {{ date('Y') }} · Built with Laravel & Gemini</span>
            </div>
        </div>
    </footer>
</body>
</html>
