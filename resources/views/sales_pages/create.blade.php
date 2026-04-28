<x-app-layout>
    <x-slot:title>{{ $page->exists ? 'Regenerate · '.$page->product_name : 'New Sales Page' }}</x-slot:title>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2.5 min-w-0">
                <a href="{{ route('sales-pages.index') }}" class="p-1.5 -ml-1.5 rounded-lg text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 transition shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                </a>
                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-[#FFE4DC] text-[#C44425] text-[10px] font-bold uppercase tracking-wider">{{ $page->exists ? 'Regenerate' : 'New page' }}</span>
                <h2 class="text-base font-black tracking-tight text-zinc-950 truncate">{{ $page->exists ? 'Refine the prompt' : 'Tell the AI about your product' }}</h2>
            </div>
        </div>
    </x-slot>

    <div class="py-10" x-data="{ submitting: false, tone: '{{ old('tone', $page->tone ?: 'persuasive') }}', template: '{{ old('template', $page->template ?: 'modern') }}' }">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ $formAction }}" @submit="submitting = true" class="space-y-5">
                @csrf
                @if ($formMethod !== 'POST')
                    @method($formMethod)
                @endif

                {{-- Section 1 — Product basics --}}
                <section class="bg-white rounded-2xl ring-1 ring-zinc-950/[0.06] overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-950/[0.06] flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-zinc-950 text-[#FF5A36] flex items-center justify-center text-xs font-black">01</div>
                        <div class="flex-1">
                            <h3 class="text-sm font-black text-zinc-950">Product basics</h3>
                            <p class="text-xs text-zinc-500">What you're selling and why people should care.</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <label for="product_name" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-2">Product / service name <span class="text-[#FF5A36]">*</span></label>
                            <input id="product_name" name="product_name" type="text" required maxlength="120"
                                   value="{{ old('product_name', $page->product_name) }}"
                                   placeholder="e.g. FocusFlow Pro"
                                   class="block w-full rounded-xl border-zinc-950/[0.08] shadow-sm focus:border-[#FF5A36] focus:ring-[#FF5A36]/20 text-sm font-medium">
                            @error('product_name')<p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-2">Description <span class="text-[#FF5A36]">*</span></label>
                            <textarea id="description" name="description" rows="4" required minlength="20" maxlength="2000"
                                      placeholder="What does it do? Who is it for? What problem does it solve?"
                                      class="block w-full rounded-xl border-zinc-950/[0.08] shadow-sm focus:border-[#FF5A36] focus:ring-[#FF5A36]/20 text-sm">{{ old('description', $page->description) }}</textarea>
                            @error('description')<p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="features" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-2">Key features <span class="text-[#FF5A36]">*</span></label>
                            <textarea id="features" name="features" rows="4" required maxlength="2000"
                                      placeholder="One per line, or comma-separated&#10;e.g. AI time estimation&#10;Calendar auto-blocking"
                                      class="block w-full rounded-xl border-zinc-950/[0.08] shadow-sm focus:border-[#FF5A36] focus:ring-[#FF5A36]/20 text-sm font-mono">{{ old('features', is_array($page->features) ? implode("\n", $page->features) : '') }}</textarea>
                            @error('features')<p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </section>

                {{-- Section 2 — Audience & price --}}
                <section class="bg-white rounded-2xl ring-1 ring-zinc-950/[0.06] overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-950/[0.06] flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xs font-black ring-1 ring-emerald-200">02</div>
                        <div class="flex-1">
                            <h3 class="text-sm font-black text-zinc-950">Who & how much</h3>
                            <p class="text-xs text-zinc-500">Help the AI tailor language and positioning.</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="target_audience" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-2">Target audience <span class="text-[#FF5A36]">*</span></label>
                                <input id="target_audience" name="target_audience" type="text" required maxlength="160"
                                       value="{{ old('target_audience', $page->target_audience) }}"
                                       placeholder="e.g. busy founders of B2B SaaS startups"
                                       class="block w-full rounded-xl border-zinc-950/[0.08] shadow-sm focus:border-[#FF5A36] focus:ring-[#FF5A36]/20 text-sm">
                                @error('target_audience')<p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="price" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-2">Price</label>
                                <input id="price" name="price" type="text" maxlength="80"
                                       value="{{ old('price', $page->price) }}"
                                       placeholder="e.g. $49 / month"
                                       class="block w-full rounded-xl border-zinc-950/[0.08] shadow-sm focus:border-[#FF5A36] focus:ring-[#FF5A36]/20 text-sm">
                                @error('price')<p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label for="unique_selling_points" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-2">Unique selling points</label>
                            <textarea id="unique_selling_points" name="unique_selling_points" rows="2" maxlength="1000"
                                      placeholder="What makes this different from alternatives?"
                                      class="block w-full rounded-xl border-zinc-950/[0.08] shadow-sm focus:border-[#FF5A36] focus:ring-[#FF5A36]/20 text-sm">{{ old('unique_selling_points', $page->unique_selling_points) }}</textarea>
                            @error('unique_selling_points')<p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </section>

                {{-- Section 3 — Voice & visual --}}
                <section class="bg-white rounded-2xl ring-1 ring-zinc-950/[0.06] overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-950/[0.06] flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-violet-50 text-violet-700 flex items-center justify-center text-xs font-black ring-1 ring-violet-200">03</div>
                        <div class="flex-1">
                            <h3 class="text-sm font-black text-zinc-950">Voice & visual</h3>
                            <p class="text-xs text-zinc-500">Pick the personality and design template.</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-3">Tone</label>
                            <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
                                @foreach (['persuasive' => '🎯', 'formal' => '🎓', 'casual' => '☕', 'urgent' => '⚡', 'inspirational' => '🚀'] as $value => $emoji)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="tone" value="{{ $value }}" class="sr-only" x-model="tone">
                                        <div class="px-3 py-3 rounded-xl border-2 text-center text-sm transition"
                                             :class="tone === '{{ $value }}' ? 'border-[#FF5A36] bg-[#FFE4DC] text-[#C44425] font-black ring-2 ring-[#FF5A36]/20' : 'border-zinc-200 hover:border-zinc-300 text-zinc-600'">
                                            <div class="text-xl mb-1">{{ $emoji }}</div>
                                            <div class="text-xs capitalize font-bold">{{ $value }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-3">Design template</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach ([
                                    'modern' => ['name' => 'Modern', 'bg' => 'bg-gradient-to-br from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8]', 'desc' => 'Cinematic dark · Coral accent'],
                                    'classic' => ['name' => 'Classic', 'bg' => 'bg-gradient-to-br from-stone-800 via-stone-700 to-amber-500', 'desc' => 'Editorial light · Serif typography'],
                                    'bold' => ['name' => 'Bold', 'bg' => 'bg-gradient-to-br from-rose-500 via-pink-500 to-yellow-400', 'desc' => 'Playful sticker · Chunky fun'],
                                ] as $value => $info)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="template" value="{{ $value }}" class="sr-only" x-model="template">
                                        <div class="rounded-2xl border-2 overflow-hidden transition"
                                             :class="template === '{{ $value }}' ? 'border-[#FF5A36] ring-2 ring-[#FF5A36]/20 -translate-y-0.5 shadow-lg shadow-[#FF5A36]/10' : 'border-zinc-200 hover:border-zinc-300'">
                                            <div class="h-20 {{ $info['bg'] }} relative">
                                                <span class="absolute bottom-2 left-3 text-white font-black text-sm tracking-wide drop-shadow">{{ $info['name'] }}</span>
                                            </div>
                                            <div class="p-3 bg-white">
                                                <div class="text-xs font-bold text-zinc-500">{{ $info['desc'] }}</div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Sticky submit bar --}}
                <div class="sticky bottom-4 z-10">
                    <div class="bg-zinc-950 text-stone-50 ring-1 ring-zinc-950 rounded-2xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.4)] p-3 flex items-center justify-between gap-3">
                        <div class="hidden sm:flex items-center gap-3 text-xs ml-3">
                            <div class="flex -space-x-1.5">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-[#FF5A36] to-[#FFB088] ring-2 ring-zinc-950"></div>
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 ring-2 ring-zinc-950"></div>
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-violet-400 to-violet-600 ring-2 ring-zinc-950"></div>
                            </div>
                            <div>
                                <div x-show="!submitting" class="font-bold text-stone-200">AI will write all sections.</div>
                                <div x-show="submitting" x-cloak class="text-[#FF5A36] font-bold flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#FF5A36] animate-ping"></span>
                                    Generating · 10–20 seconds…
                                </div>
                                <div class="text-stone-500 text-[10px]">Headline · Benefits · Features · CTA · Pricing</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 ml-auto">
                            <a href="{{ route('sales-pages.index') }}" class="px-4 py-2.5 text-sm font-bold text-stone-300 hover:bg-stone-50/10 rounded-xl transition">Cancel</a>
                            <button type="submit" :disabled="submitting"
                                    class="group inline-flex items-center gap-2 pl-5 pr-2 py-2.5 bg-[#FF5A36] hover:bg-[#FF6B49] text-white text-sm font-black rounded-xl shadow-lg shadow-[#FF5A36]/40 transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed hover:-translate-y-0.5">
                                <svg x-show="submitting" x-cloak class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <svg x-show="!submitting" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/></svg>
                                <span x-text="submitting ? 'Generating…' : '{{ $submitLabel }}'">{{ $submitLabel }}</span>
                                <span class="ml-0.5 w-7 h-7 rounded-lg bg-white/20 flex items-center justify-center group-hover:translate-x-0.5 transition-transform">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
