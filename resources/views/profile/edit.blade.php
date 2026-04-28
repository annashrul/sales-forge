<x-app-layout>
    <x-slot:title>Profile settings</x-slot:title>
    <x-slot name="header">
        <div class="flex items-center gap-2.5 min-w-0">
            <a href="{{ route('dashboard') }}" class="p-1.5 -ml-1.5 rounded-lg text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 transition shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
            </a>
            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-zinc-100 text-zinc-700 text-[10px] font-bold uppercase tracking-wider">Settings</span>
            <h2 class="text-base font-black tracking-tight text-zinc-950">Profile</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-5">
            <section class="bg-white rounded-2xl ring-1 ring-zinc-950/[0.06] overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-950/[0.06] flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-zinc-950 text-[#FF5A36] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-zinc-950">Profile information</h3>
                        <p class="text-xs text-zinc-500">Update your name and email.</p>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-2xl ring-1 ring-zinc-950/[0.06] overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-950/[0.06] flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center ring-1 ring-emerald-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-zinc-950">Password</h3>
                        <p class="text-xs text-zinc-500">Use a long random password to keep things safe.</p>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </section>

            <section class="bg-rose-50/40 rounded-2xl ring-1 ring-rose-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-rose-200 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center ring-1 ring-rose-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-rose-900">Danger zone</h3>
                        <p class="text-xs text-rose-700">Permanently delete your account and all data.</p>
                    </div>
                </div>
                <div class="p-6 sm:p-8 bg-white">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
