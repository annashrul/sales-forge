<x-app-layout>
    <x-slot:title>Dashboard</x-slot:title>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-zinc-100 text-zinc-700 text-[10px] font-bold uppercase tracking-wider">Workspace</span>
                <h2 class="text-base font-black tracking-tight text-zinc-950">Hi, {{ \Illuminate\Support\Str::words(Auth::user()->name, 1, '') }} <span class="inline-block animate-pulse">👋</span></h2>
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

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- KPI cards row --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Total — featured / coral --}}
                <div class="relative rounded-2xl bg-zinc-950 text-stone-50 p-6 overflow-hidden ring-1 ring-zinc-950">
                    <div class="absolute -top-12 -right-12 w-40 h-40 rounded-full bg-[#FF5A36] opacity-30 blur-2xl"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-stone-400 font-bold">Total pages</p>
                            <div class="w-9 h-9 rounded-xl bg-[#FF5A36] flex items-center justify-center" style="box-shadow: 0 0 16px rgba(255,90,54,0.5)">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                            </div>
                        </div>
                        <p class="mt-3 text-5xl font-black tracking-tight">{{ $totalPages ?? 0 }}</p>
                        <p class="mt-1 text-xs text-stone-400">Across all design templates</p>
                    </div>
                </div>

                {{-- Ready --}}
                <div class="rounded-2xl bg-white p-6 ring-1 ring-zinc-950/[0.06] hover:ring-zinc-950/15 hover:-translate-y-0.5 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-zinc-500 font-bold">Ready to share</p>
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75 10.5 18l9-13.5"/></svg>
                        </div>
                    </div>
                    <p class="mt-3 text-5xl font-black tracking-tight text-zinc-950">{{ $readyPages ?? 0 }}</p>
                    <p class="mt-1 text-xs text-zinc-500">Generated successfully</p>
                </div>

                {{-- AI Provider --}}
                <div class="rounded-2xl bg-white p-6 ring-1 ring-zinc-950/[0.06] hover:ring-zinc-950/15 hover:-translate-y-0.5 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-zinc-500 font-bold">AI engine</p>
                        <div class="w-9 h-9 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/></svg>
                        </div>
                    </div>
                    <p class="mt-3 text-2xl font-black tracking-tight text-zinc-950 capitalize">{{ config('services.ai.provider') }}</p>
                    <div class="flex items-center gap-1.5 mt-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <p class="text-xs text-zinc-500">{{ config('services.gemini.model') }}</p>
                    </div>
                </div>
            </div>

            {{-- Quick actions row --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <a href="{{ route('sales-pages.create') }}" class="group flex items-center gap-3 p-4 bg-white rounded-xl ring-1 ring-zinc-950/[0.06] hover:ring-[#FF5A36]/40 hover:-translate-y-0.5 transition-all duration-200">
                    <div class="w-10 h-10 rounded-lg bg-[#FFE4DC] text-[#FF5A36] flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-sm text-zinc-950">Generate new page</div>
                        <div class="text-xs text-zinc-500">From product info → ~30s</div>
                    </div>
                    <svg class="w-4 h-4 text-zinc-300 group-hover:text-[#FF5A36] transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
                <a href="{{ route('sales-pages.index') }}" class="group flex items-center gap-3 p-4 bg-white rounded-xl ring-1 ring-zinc-950/[0.06] hover:ring-zinc-950/30 hover:-translate-y-0.5 transition-all duration-200">
                    <div class="w-10 h-10 rounded-lg bg-zinc-100 text-zinc-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6Z"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-sm text-zinc-950">Browse all pages</div>
                        <div class="text-xs text-zinc-500">Search · edit · delete</div>
                    </div>
                    <svg class="w-4 h-4 text-zinc-300 group-hover:text-zinc-700 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
                <a href="{{ route('profile.edit') }}" class="group flex items-center gap-3 p-4 bg-white rounded-xl ring-1 ring-zinc-950/[0.06] hover:ring-zinc-950/30 hover:-translate-y-0.5 transition-all duration-200">
                    <div class="w-10 h-10 rounded-lg bg-zinc-100 text-zinc-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-sm text-zinc-950">Account settings</div>
                        <div class="text-xs text-zinc-500">Profile · password</div>
                    </div>
                    <svg class="w-4 h-4 text-zinc-300 group-hover:text-zinc-700 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
            </div>

            {{-- Recent generations --}}
            <div class="bg-white rounded-2xl ring-1 ring-zinc-950/[0.06] overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-950/[0.06]">
                    <div>
                        <h3 class="text-base font-black tracking-tight text-zinc-950">Recent generations</h3>
                        <p class="text-xs text-zinc-500 mt-0.5">Your last 5 sales pages</p>
                    </div>
                    <a href="{{ route('sales-pages.index') }}" class="text-sm font-bold text-[#FF5A36] hover:text-[#C44425] inline-flex items-center gap-0.5">
                        View all
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                </div>
                <div class="divide-y divide-zinc-950/[0.06]">
                    @forelse ($recentPages ?? [] as $page)
                        <a href="{{ route('sales-pages.show', $page) }}" class="flex items-center justify-between px-6 py-4 hover:bg-zinc-50 transition group">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-11 h-11 rounded-xl shrink-0 relative overflow-hidden ring-1 ring-zinc-950/10 {{ match($page->template) {
                                    'modern' => 'bg-gradient-to-br from-[#FF5A36] to-[#FFB088]',
                                    'classic' => 'bg-gradient-to-br from-stone-700 via-amber-500 to-amber-300',
                                    'bold' => 'bg-gradient-to-br from-rose-400 via-pink-400 to-yellow-300',
                                    default => 'bg-zinc-200',
                                } }}">
                                    <span class="absolute inset-0 flex items-center justify-center text-white font-black text-base">{{ strtoupper(substr($page->product_name, 0, 1)) }}</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-zinc-950 truncate">{{ $page->product_name }}</p>
                                    <p class="text-xs text-zinc-500 truncate">{{ $page->target_audience }} · {{ ucfirst($page->tone) }} · {{ ucfirst($page->template) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="hidden sm:inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] font-bold uppercase tracking-wider {{ match($page->status) {
                                    'ready' => 'bg-emerald-50 text-emerald-700',
                                    'generating' => 'bg-amber-50 text-amber-700',
                                    'failed' => 'bg-rose-50 text-rose-700',
                                    default => 'bg-zinc-100 text-zinc-600',
                                } }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ match($page->status) {
                                        'ready' => 'bg-emerald-500',
                                        'generating' => 'bg-amber-500',
                                        'failed' => 'bg-rose-500',
                                        default => 'bg-zinc-400',
                                    } }}"></span>
                                    {{ $page->status }}
                                </span>
                                <span class="text-xs text-zinc-400 hidden sm:inline">{{ $page->created_at->diffForHumans(short: true) }}</span>
                                <svg class="w-4 h-4 text-zinc-300 group-hover:text-[#FF5A36] group-hover:translate-x-0.5 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-16 text-center">
                            <div class="w-16 h-16 mx-auto rounded-2xl bg-stone-100 flex items-center justify-center text-zinc-400">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/></svg>
                            </div>
                            <p class="mt-4 text-zinc-950 font-bold">No sales pages yet</p>
                            <p class="text-sm text-zinc-500 mt-1">Generate your first page in under a minute.</p>
                            <a href="{{ route('sales-pages.create') }}" class="inline-flex items-center gap-1.5 mt-5 px-5 py-2.5 bg-[#FF5A36] hover:bg-[#FF6B49] text-white text-sm font-bold rounded-xl shadow-lg shadow-[#FF5A36]/30 transition">
                                Get started
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
