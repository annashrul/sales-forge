<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? trim($title).' · '.config('app.name', 'SalesForge') : config('app.name', 'SalesForge') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.svg') }}">
    <meta name="theme-color" content="#09090b">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes spin-slow { to { transform: rotate(360deg); } }
        @keyframes spin-slower { to { transform: rotate(-360deg); } }
        @keyframes floaty { 0%,100%{transform:translate3d(0,0,0)} 50%{transform:translate3d(0,-10px,0)} }
        .anim-spin-slow { animation: spin-slow 40s linear infinite; }
        .anim-spin-slower { animation: spin-slower 60s linear infinite; }
        .anim-floaty { animation: floaty 7s ease-in-out infinite; }
        .grain-dark { background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' /%3E%3CfeColorMatrix values='0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.18 0'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' /%3E%3C/svg%3E"); }
        .glass { background: rgba(255,255,255,0.04); backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px); }
        .glow-cta { box-shadow: 0 0 0 1px rgba(255,255,255,0.06), 0 18px 60px -12px rgba(255,90,54,0.65), 0 8px 24px -8px rgba(255,90,54,0.45); }
    </style>
</head>
<body class="font-sans text-zinc-950 antialiased bg-stone-50 h-screen overflow-hidden">
    <div class="h-screen grid grid-cols-1 lg:grid-cols-12">

        {{-- ═════════  BRAND PANEL (left, dark cinematic)  ═════════ --}}
        <aside class="hidden lg:flex lg:col-span-5 xl:col-span-6 relative bg-zinc-950 text-stone-50 overflow-hidden flex-col p-10 xl:p-12">
            {{-- Backdrop --}}
            <div class="absolute inset-0 -z-10 pointer-events-none">
                <div class="absolute inset-0 grain-dark opacity-30"></div>
                <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full bg-gradient-to-br from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8] opacity-30 blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-teal-500 opacity-15 blur-3xl"></div>
                <svg class="absolute right-0 top-0 w-full h-full opacity-[0.06]" viewBox="0 0 600 600" fill="none" preserveAspectRatio="xMidYMid slice">
                    <circle cx="450" cy="300" r="180" stroke="white" stroke-width="0.6"/>
                    <circle cx="450" cy="300" r="260" stroke="white" stroke-width="0.6"/>
                    <circle cx="450" cy="300" r="340" stroke="white" stroke-width="0.6"/>
                </svg>
                <svg class="absolute inset-0 w-full h-full opacity-50" viewBox="0 0 600 800" preserveAspectRatio="none">
                    @foreach ([['80','120','1.5'],['180','340','1'],['260','520','2'],['340','220','1.2'],['480','440','1.5'],['540','620','1'],['100','680','1.2'],['400','680','1']] as $p)
                        <circle cx="{{ $p[0] }}" cy="{{ $p[1] }}" r="{{ $p[2] }}" fill="white" opacity="0.5"/>
                    @endforeach
                </svg>
            </div>

            {{-- Top: brand --}}
            <a href="/" class="relative flex items-center gap-2.5 group z-10">
                <div class="relative">
                    <div class="absolute inset-0 bg-[#FF5A36] blur-md opacity-50 group-hover:opacity-80 transition"></div>
                    <div class="relative w-9 h-9 rounded-xl bg-zinc-900 ring-1 ring-stone-50/10 flex items-center justify-center">
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

            {{-- Center: orb + value prop --}}
            <div class="relative flex-1 flex flex-col justify-center max-w-md z-10">
                {{-- 3D orb decoration --}}
                <div class="relative w-44 h-44 mb-12">
                    <div class="absolute inset-0 rounded-full border border-stone-50/10 anim-spin-slow"></div>
                    <div class="absolute inset-3 rounded-full border border-stone-50/10 anim-spin-slower"></div>
                    <div class="absolute inset-6 rounded-full bg-gradient-to-br from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8]" style="box-shadow: 0 30px 80px -10px rgba(255,90,54,0.55), inset -10px -15px 30px rgba(0,0,0,0.25), inset 8px 10px 20px rgba(255,255,255,0.35);">
                        <div class="absolute top-3 left-6 w-12 h-12 rounded-full bg-white/40 blur-xl"></div>
                        <div class="absolute inset-0 rounded-full ring-1 ring-inset ring-white/30"></div>
                    </div>
                </div>

                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full glass ring-1 ring-stone-50/10 text-[11px] font-bold uppercase tracking-[0.18em] mb-6 self-start">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Powered by Gemini 2.5
                </div>

                <h2 class="text-balance text-4xl xl:text-5xl font-black tracking-[-0.04em] leading-[0.95]">
                    Sales pages,
                    <span class="block italic font-serif font-light bg-gradient-to-r from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8] bg-clip-text text-transparent">drafted by AI.</span>
                </h2>
                <p class="mt-6 text-base text-stone-400 leading-relaxed">
                    Drop in product info. Pick a tone and template. Get a complete, persuasive sales page in 30 seconds.
                </p>

                {{-- Trust bullets --}}
                <ul class="mt-8 space-y-3">
                    @foreach (['3 design templates · Modern, Classic, Bold', 'Live preview & one-click HTML export', 'Free forever for personal use'] as $bullet)
                        <li class="flex items-center gap-3 text-sm text-stone-200">
                            <span class="w-5 h-5 rounded-full bg-[#FF5A36]/20 ring-1 ring-[#FF5A36]/40 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-[#FF5A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75 10.5 18l9-13.5"/></svg>
                            </span>
                            {{ $bullet }}
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Bottom: footer --}}
            <div class="relative z-10 flex items-center justify-between text-[10px] uppercase tracking-[0.18em] text-stone-500 font-bold">
                <span>© {{ date('Y') }} SalesForge</span>
                <span>Built with Laravel</span>
            </div>
        </aside>

        {{-- ═════════  FORM PANEL (right, light)  ═════════ --}}
        <main class="lg:col-span-7 xl:col-span-6 flex flex-col h-screen overflow-hidden">
            {{-- Mobile-only top bar --}}
            <div class="lg:hidden shrink-0 flex items-center justify-between px-6 py-3 border-b border-zinc-950/[0.06]">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-zinc-950 ring-1 ring-zinc-950/20 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#FF5A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/>
                        </svg>
                    </div>
                    <span class="font-black text-zinc-950 text-sm">SalesForge</span>
                </a>
                <a href="/" class="text-xs text-zinc-500 hover:text-zinc-950 font-semibold flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                    Home
                </a>
            </div>

            {{-- Form area: vertically center, internal scroll only if needed --}}
            <div class="flex-1 min-h-0 flex items-center justify-center overflow-y-auto px-6 sm:px-10 lg:px-12 xl:px-16">
                <div class="w-full max-w-md py-6">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
