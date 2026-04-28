<x-app-layout>
    <x-slot:title>My Sales Pages</x-slot:title>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-zinc-100 text-zinc-700 text-[10px] font-bold uppercase tracking-wider">Library</span>
                <h2 class="text-base font-black tracking-tight text-zinc-950">My Sales Pages</h2>
                <span class="hidden sm:inline text-xs text-zinc-400 font-medium">{{ $pages->total() }} total · {{ $pages->where('status', 'ready')->count() }} ready</span>
            </div>
            <a href="{{ route('sales-pages.create') }}"
               class="group inline-flex items-center gap-1.5 pl-3 pr-1.5 py-1.5 bg-[#FF5A36] hover:bg-[#FF6B49] text-white text-sm font-bold rounded-lg shadow-md shadow-[#FF5A36]/30 hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Generate
                <span class="ml-0.5 w-6 h-6 rounded-md bg-white/20 flex items-center justify-center group-hover:translate-x-0.5 transition-transform">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-10" x-data="{
        confirm: { open: false, action: '', name: '' },
        askDelete(action, name) { this.confirm.action = action; this.confirm.name = name; this.confirm.open = true; },
        closeDelete() { this.confirm.open = false; },
    }" @keydown.escape.window="closeDelete">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            <form method="GET" action="{{ route('sales-pages.index') }}" class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                <input type="text" name="q" value="{{ $search }}" placeholder="Search by product, audience, or description…"
                       class="w-full rounded-2xl border-zinc-950/[0.08] bg-white pl-11 pr-28 py-3.5 shadow-sm focus:border-[#FF5A36] focus:ring-[#FF5A36]/20 text-sm font-medium">
                <div class="absolute right-2 top-1/2 -translate-y-1/2 flex gap-1">
                    @if ($search)
                        <a href="{{ route('sales-pages.index') }}" class="px-3 py-1.5 text-xs text-zinc-600 hover:text-zinc-900 rounded-lg hover:bg-zinc-100 font-medium">Clear</a>
                    @endif
                    <button type="submit" class="px-4 py-2 bg-zinc-950 hover:bg-zinc-800 text-white text-xs font-bold rounded-xl">Search</button>
                </div>
            </form>

            @if ($pages->isEmpty())
                <div class="bg-white ring-1 ring-zinc-950/[0.06] rounded-2xl p-16 text-center">
                    <div class="w-16 h-16 mx-auto rounded-2xl bg-stone-100 flex items-center justify-center text-zinc-400">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6Z"/></svg>
                    </div>
                    <p class="mt-4 text-zinc-950 font-black text-lg">{{ $search ? 'No matches found' : 'No sales pages yet' }}</p>
                    <p class="mt-1 text-sm text-zinc-500">{{ $search ? 'Try a different keyword.' : 'Generate your first sales page in under a minute.' }}</p>
                    @unless($search)
                        <a href="{{ route('sales-pages.create') }}" class="inline-flex items-center gap-2 mt-6 px-5 py-2.5 bg-[#FF5A36] hover:bg-[#FF6B49] text-white text-sm font-bold rounded-xl shadow-lg shadow-[#FF5A36]/30 transition">
                            Get started
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </a>
                    @endunless
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($pages as $page)
                        <div class="group bg-white rounded-2xl ring-1 ring-zinc-950/[0.06] hover:ring-zinc-950/15 hover:-translate-y-1 hover:shadow-xl hover:shadow-zinc-950/5 transition-all duration-300 flex flex-col overflow-hidden">
                            <a href="{{ route('sales-pages.show', $page) }}" class="block">
                                <div class="h-32 relative overflow-hidden {{ match($page->template) {
                                    'modern' => 'bg-gradient-to-br from-[#FF5A36] via-[#FF8B65] to-[#FFD4B8]',
                                    'classic' => 'bg-gradient-to-br from-stone-800 via-stone-700 to-amber-500',
                                    'bold' => 'bg-gradient-to-br from-rose-500 via-pink-500 to-yellow-400',
                                    default => 'bg-zinc-200',
                                } }}">
                                    {{-- Decorative noise / sheen --}}
                                    <div class="absolute inset-0 opacity-25"
                                         style="background-image: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.5), transparent 60%);"></div>

                                    {{-- Big initial --}}
                                    <span class="absolute bottom-3 left-4 text-white font-black text-2xl tracking-tight drop-shadow">{{ strtoupper(substr($page->product_name, 0, 1)) }}</span>
                                    <span class="absolute bottom-3 right-4 text-white text-[10px] font-bold uppercase tracking-[0.18em] opacity-80">{{ $page->template }}</span>

                                    <div class="absolute top-3 right-3">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold backdrop-blur-md text-white {{ match($page->status) {
                                            'ready' => 'bg-emerald-500/40',
                                            'generating' => 'bg-amber-500/40',
                                            'failed' => 'bg-rose-500/40',
                                            default => 'bg-white/20',
                                        } }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ ucfirst($page->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h3 class="font-black text-zinc-950 line-clamp-1 group-hover:text-[#FF5A36] transition tracking-tight">{{ $page->product_name }}</h3>
                                    <p class="mt-2 text-sm text-zinc-600 line-clamp-2 leading-relaxed">{{ $page->generated_content['headline'] ?? $page->description }}</p>
                                    <div class="mt-4 flex items-center gap-2 text-xs text-zinc-500">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                                            <span class="truncate max-w-[120px] font-medium">{{ $page->target_audience }}</span>
                                        </span>
                                        <span class="text-zinc-300">·</span>
                                        <span class="font-medium">{{ ucfirst($page->tone) }}</span>
                                        <span class="ml-auto text-zinc-400">{{ $page->created_at->diffForHumans(short: true) }}</span>
                                    </div>
                                </div>
                            </a>
                            <div class="border-t border-zinc-950/[0.06] px-5 py-3 flex items-center justify-between bg-stone-50/60">
                                <div class="flex gap-3 text-sm">
                                    <a href="{{ route('sales-pages.edit', $page) }}" class="text-zinc-700 hover:text-[#FF5A36] font-bold inline-flex items-center gap-1 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                                        Regenerate
                                    </a>
                                    @if ($page->isReady())
                                        <a href="{{ route('sales-pages.export', $page) }}" class="text-zinc-700 hover:text-[#FF5A36] font-bold inline-flex items-center gap-1 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                            Export
                                        </a>
                                    @endif
                                </div>
                                <button type="button"
                                        @click="askDelete({{ json_encode(route('sales-pages.destroy', $page)) }}, {{ json_encode($page->product_name) }})"
                                        class="text-zinc-400 hover:text-rose-600 transition" title="Delete">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div>{{ $pages->links() }}</div>
            @endif
        </div>

        {{-- ════════════════════════  DELETE CONFIRM MODAL  ════════════════════════ --}}
        <div x-show="confirm.open" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center px-4"
             x-transition.opacity>
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-zinc-950/60 backdrop-blur-sm"
                 @click="closeDelete"></div>

            {{-- Modal card --}}
            <div class="relative w-full max-w-md rounded-2xl bg-white ring-1 ring-zinc-950/[0.08] shadow-[0_30px_80px_-20px_rgba(0,0,0,0.4)] overflow-hidden"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                <div class="p-6 sm:p-8">
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-xl bg-rose-50 ring-1 ring-rose-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-lg font-black tracking-tight text-zinc-950">Delete sales page?</h3>
                            <p class="mt-1.5 text-sm text-zinc-600 leading-relaxed">
                                You're about to permanently delete <span class="font-bold text-zinc-950" x-text="confirm.name"></span>. This cannot be undone — generated content, settings, and exports will all be removed.
                            </p>
                        </div>
                    </div>

                    <div class="mt-7 flex items-center gap-2 justify-end">
                        <button type="button" @click="closeDelete"
                                class="px-4 py-2.5 rounded-xl text-sm font-bold text-zinc-700 hover:bg-zinc-100 transition">
                            Cancel
                        </button>
                        <form method="POST" :action="confirm.action" class="inline-flex">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-lg shadow-rose-600/30 hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397"/></svg>
                                Delete permanently
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
