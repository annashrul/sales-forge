<x-guest-layout>
    <x-slot:title>Create account</x-slot:title>
    <div class="mb-6">
        <div class="text-[10px] uppercase tracking-[0.22em] text-zinc-500 font-bold mb-1.5">Create account</div>
        <h1 class="text-balance text-2xl sm:text-3xl font-black tracking-[-0.025em] leading-[1.05] text-zinc-950">
            Start drafting
            <span class="italic font-serif font-light text-[#FF5A36]">in seconds.</span>
        </h1>
        <p class="mt-2 text-sm text-zinc-500">Free forever for personal use · No credit card required.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-2">Full name <span class="text-[#FF5A36]">*</span></label>
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Sarah Chen"
                       class="block w-full pl-10 rounded-xl border-zinc-950/[0.08] shadow-sm focus:border-[#FF5A36] focus:ring-[#FF5A36]/20 text-sm font-medium">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-2">Email <span class="text-[#FF5A36]">*</span></label>
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@company.com"
                       class="block w-full pl-10 rounded-xl border-zinc-950/[0.08] shadow-sm focus:border-[#FF5A36] focus:ring-[#FF5A36]/20 text-sm font-medium">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div x-data="{ show: false }">
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-2">Password <span class="text-[#FF5A36]">*</span></label>
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                <input id="password" name="password" :type="show ? 'text' : 'password'" required autocomplete="new-password" placeholder="At least 8 characters"
                       class="block w-full pl-10 pr-10 rounded-xl border-zinc-950/[0.08] shadow-sm focus:border-[#FF5A36] focus:ring-[#FF5A36]/20 text-sm font-medium">
                <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-zinc-400 hover:text-zinc-700 transition" tabindex="-1">
                    <svg x-show="!show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                    <svg x-show="show" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.244 7.244L21 21m-3.878-3.878-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-2">Confirm password <span class="text-[#FF5A36]">*</span></label>
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Re-enter password"
                       class="block w-full pl-10 rounded-xl border-zinc-950/[0.08] shadow-sm focus:border-[#FF5A36] focus:ring-[#FF5A36]/20 text-sm font-medium">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <button type="submit"
                class="group relative inline-flex w-full items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#FF5A36] hover:bg-[#FF6B49] text-white text-sm font-black tracking-wide glow-cta hover:-translate-y-0.5 transition-all duration-200 mt-1">
            Create my account
            <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        </button>
    </form>

    <p class="mt-4 text-center text-sm text-zinc-500">
        Already a member?
        <a href="{{ route('login') }}" class="font-bold text-[#FF5A36] hover:text-[#C44425] transition">Sign in</a>
    </p>
</x-guest-layout>
