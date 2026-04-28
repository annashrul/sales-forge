<nav x-data="{ open: false }" class="bg-white/85 backdrop-blur-xl border-b border-zinc-950/[0.06] sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                    <div class="relative">
                        <div class="absolute inset-0 bg-[#FF5A36] blur-md opacity-50 group-hover:opacity-80 transition"></div>
                        <div class="relative w-9 h-9 rounded-xl bg-zinc-950 flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#FF5A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="hidden sm:flex flex-col leading-none">
                        <span class="font-black tracking-tight text-zinc-950">SalesForge</span>
                        <span class="text-[9px] uppercase tracking-[0.18em] text-zinc-500 font-bold mt-0.5">AI Sales Pages</span>
                    </div>
                </a>

                <div class="hidden sm:flex sm:ms-10 sm:items-center sm:gap-1">
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold transition
                              @if(request()->routeIs('dashboard')) bg-zinc-950 text-stone-50 @else text-zinc-600 hover:text-zinc-950 hover:bg-zinc-950/[0.04] @endif">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12 12 2.25 21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('sales-pages.index') }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold transition
                              @if(request()->routeIs('sales-pages.index') || request()->routeIs('sales-pages.show') || request()->routeIs('sales-pages.edit')) bg-zinc-950 text-stone-50 @else text-zinc-600 hover:text-zinc-950 hover:bg-zinc-950/[0.04] @endif">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/></svg>
                        My Pages
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <a href="{{ route('sales-pages.create') }}"
                   class="group relative inline-flex items-center gap-2 pl-3.5 pr-2 py-1.5 bg-[#FF5A36] hover:bg-[#FF6B49] text-white text-sm font-bold rounded-lg shadow-lg shadow-[#FF5A36]/30 hover:shadow-xl hover:shadow-[#FF5A36]/40 hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Generate
                    <span class="ml-0.5 px-1.5 py-0.5 rounded-md bg-white/20 text-[10px] font-bold uppercase tracking-wider">AI</span>
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-1.5 py-1 rounded-lg text-sm text-zinc-700 hover:bg-zinc-950/[0.04] transition">
                            <div class="relative">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-zinc-900 to-zinc-700 text-stone-50 flex items-center justify-center text-xs font-black ring-2 ring-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                            </div>
                            <span class="hidden md:inline font-semibold">{{ \Illuminate\Support\Str::limit(Auth::user()->name, 14) }}</span>
                            <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-zinc-100">
                            <div class="text-sm font-semibold text-zinc-950">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-zinc-500 truncate">{{ Auth::user()->email }}</div>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">Profile settings</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">Sign out</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-zinc-500 hover:text-zinc-700 hover:bg-zinc-950/[0.04] transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-zinc-950/[0.06] bg-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('sales-pages.index')" :active="request()->routeIs('sales-pages.index')">My Pages</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('sales-pages.create')" :active="request()->routeIs('sales-pages.create')">Generate</x-responsive-nav-link>
        </div>
        <div class="pt-4 pb-3 border-t border-zinc-950/[0.06]">
            <div class="px-4">
                <div class="font-semibold text-zinc-900">{{ Auth::user()->name }}</div>
                <div class="text-sm text-zinc-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">Sign out</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
