<x-app-layout>
    <x-slot:title>{{ $page->product_name }}</x-slot:title>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2.5 min-w-0">
                <a href="{{ route('sales-pages.index') }}" class="p-1.5 -ml-1.5 rounded-lg text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 transition shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                </a>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md font-bold uppercase tracking-wider text-[10px] {{ match($page->status) {
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
                <h2 class="text-base font-black tracking-tight text-zinc-950 truncate">{{ $page->product_name }}</h2>
                <span class="hidden md:inline text-xs text-zinc-400 font-medium shrink-0">{{ ucfirst($page->template) }} · {{ ucfirst($page->tone) }}</span>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('sales-pages.edit', $page) }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white ring-1 ring-zinc-950/[0.08] hover:ring-zinc-950/30 rounded-xl text-sm font-bold text-zinc-700 hover:-translate-y-0.5 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                    Regenerate
                </a>
                @if ($page->isReady())
                    <a href="{{ route('sales-pages.export', $page) }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-zinc-950 hover:bg-zinc-800 text-white rounded-xl text-sm font-bold hover:-translate-y-0.5 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        Export HTML
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            @if ($page->error)
                <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl text-sm flex items-start gap-2">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                    <div><strong class="font-bold">Notice:</strong> {{ $page->error }}</div>
                </div>
            @endif

            @if ($page->status === 'failed')
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-sm">
                    Generation failed. Try regenerating.
                </div>
            @elseif (!$page->isReady())
                <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl text-sm">
                    No generated content yet.
                </div>
            @else
                <div class="rounded-2xl overflow-hidden ring-1 ring-zinc-950/10 shadow-2xl shadow-zinc-950/10 bg-white">
                    {{-- Browser-style chrome --}}
                    <div class="px-4 py-3 bg-zinc-100 border-b border-zinc-200 flex items-center gap-2">
                        <div class="flex gap-1.5">
                            <div class="w-3 h-3 rounded-full bg-rose-400"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                        </div>
                        <div class="flex-1 mx-4 px-3 py-1.5 bg-white border border-zinc-200 rounded-lg text-xs text-zinc-500 truncate flex items-center gap-2">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v.756a49.106 49.106 0 0 1 9.152 1 .75.75 0 0 1-.152 1.485 47.685 47.685 0 0 0-1.118-.142v3.75a4.5 4.5 0 1 1-9 0V5.099c-.493.039-.985.087-1.476.144a.75.75 0 0 1-.171-1.49 49.13 49.13 0 0 1 9.152-1V3a.75.75 0 0 1 .75-.75ZM4.97 6.97a.75.75 0 0 1 1.06 0L9 9.94l2.97-2.97a.75.75 0 1 1 1.06 1.06L10.06 11l2.97 2.97a.75.75 0 1 1-1.06 1.06L9 12.06l-2.97 2.97a.75.75 0 0 1-1.06-1.06L7.94 11 4.97 8.03a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                            <span class="truncate">{{ url('/preview/'.\Illuminate\Support\Str::slug($page->product_name)) }}</span>
                        </div>
                        <span class="text-[10px] uppercase tracking-widest text-zinc-500 font-bold hidden sm:inline">Live preview</span>
                    </div>
                    @include('sales_pages.partials.landing', ['page' => $page])
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
