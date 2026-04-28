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
    </head>
    <body class="font-sans antialiased text-zinc-950" style="font-feature-settings: 'cv11','ss03';">
        <div class="min-h-screen bg-stone-50 relative">
            {{-- Subtle ambient glow --}}
            <div class="absolute top-0 inset-x-0 h-96 -z-0 pointer-events-none overflow-hidden">
                <div class="absolute -top-32 left-1/4 w-[500px] h-[500px] rounded-full bg-[#FF5A36]/[0.04] blur-3xl"></div>
                <div class="absolute -top-20 right-0 w-[400px] h-[400px] rounded-full bg-amber-300/[0.08] blur-3xl"></div>
            </div>

            <div class="relative">
                @include('layouts.navigation')

                @isset($header)
                    <header class="bg-white/80 backdrop-blur-md border-b border-zinc-950/[0.06] sticky top-16 z-20">
                        <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
