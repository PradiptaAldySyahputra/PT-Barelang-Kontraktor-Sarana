@php
    $pengguna = auth()->user();
    $avatarUrl = $pengguna?->urlAvatar()
        ?? ($pengguna?->peran->value === 'direktur' ? '/images/user/owner.png' : '/images/user/user-01.jpg');
@endphp

{{--
    User Dropdown - TailAdmin Pro Exact Native Component
--}}
<div class="relative" x-data="{
    isOpen: false,
    hoverTimeout: null,
    init() {
        this.$watch(() => Alpine.store('panelMenu')?.aktif, (aktif) => {
            if (aktif && aktif !== 'profil') { clearTimeout(this.hoverTimeout); this.isOpen = false; }
        });
    },
    openMenu() {
        clearTimeout(this.hoverTimeout);
        this.isOpen = true;
        const store = Alpine.store('panelMenu');
        if (store) { store.aktif = 'profil'; }
    },
    closeMenuWithDelay() {
        this.hoverTimeout = setTimeout(() => {
            this.isOpen = false;
            const store = Alpine.store('panelMenu');
            if (store && store.aktif === 'profil') { store.aktif = null; }
        }, 250);
    },
    toggleDropdown() {
        this.isOpen = !this.isOpen;
        const store = Alpine.store('panelMenu');
        if (this.isOpen && store) { store.aktif = 'profil'; }
        if (!this.isOpen && store && store.aktif === 'profil') { store.aktif = null; }
    },
    closeDropdown() {
        clearTimeout(this.hoverTimeout);
        this.isOpen = false;
        const store = Alpine.store('panelMenu');
        if (store && store.aktif === 'profil') { store.aktif = null; }
    }
}" @mouseenter="openMenu()" @mouseleave="closeMenuWithDelay()" @click.outside="closeDropdown()">

    <!-- User Trigger Button -->
    <button
        class="flex items-center text-gray-700 dark:text-gray-400 group"
        type="button"
        @click="toggleDropdown()"
        aria-label="Menu profil pengguna"
    >
        <span class="mr-3 overflow-hidden rounded-full h-11 w-11 rtl:mr-0 rtl:ml-3 bg-brand-50 dark:bg-brand-500/15 flex items-center justify-center border border-gray-200 dark:border-gray-800 shadow-theme-xs">
            <img src="{{ $avatarUrl }}" alt="{{ $pengguna?->nama ?? 'Pengguna' }}" class="h-full w-full object-cover rounded-full" />
        </span>

        <div class="hidden sm:block text-left mr-2 rtl:mr-0 rtl:ml-2">
            <span class="block font-semibold text-sm text-gray-800 dark:text-white/90 leading-tight">{{ $pengguna?->nama }}</span>
            <span class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 capitalize">{{ $pengguna?->peran->label() }}</span>
        </div>

        <!-- Chevron Down Icon -->
        <svg
            :class="isOpen ? 'rotate-180' : ''"
            class="transition-transform duration-200 stroke-gray-500 group-hover:stroke-gray-700 dark:stroke-gray-400 dark:group-hover:stroke-gray-200"
            width="18"
            height="18"
            viewBox="0 0 18 18"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M4.5 6.75L9 11.25L13.5 6.75"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
    </button>

    <!-- Dropdown Menu TailAdmin Pro Style -->
    <div
        x-show="isOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute ltr:right-0 rtl:left-0 mt-[17px] flex w-[280px] flex-col rounded-2xl border border-gray-200 bg-white p-3.5 shadow-theme-lg dark:border-gray-800 dark:bg-gray-900 z-50"
    >
        <!-- User Info Header -->
        <div class="pb-3 border-b border-gray-100 dark:border-gray-800 px-1">
            <div class="flex items-center gap-3">
                <span class="overflow-hidden rounded-full h-10 w-10 shrink-0 border border-gray-200 dark:border-gray-800">
                    <img src="{{ $avatarUrl }}" alt="{{ $pengguna?->nama }}" class="h-full w-full object-cover" />
                </span>
                <div class="min-w-0 flex-1">
                    <span class="block font-bold text-sm text-gray-800 dark:text-white/90 truncate">{{ $pengguna?->nama }}</span>
                    <span class="block text-xs text-gray-500 dark:text-gray-400 truncate">{{ $pengguna?->email }}</span>
                </div>
            </div>
            <div class="mt-2.5 flex items-center gap-2">
                <span class="inline-flex items-center rounded-md bg-brand-50 px-2 py-0.5 text-[11px] font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                    {{ $pengguna?->peran->label() }}
                </span>
                <span class="text-[11px] text-gray-400">&bull;</span>
                <span class="text-[11px] text-success-600 dark:text-success-400 font-semibold flex items-center gap-1">
                    <span class="h-1.5 w-1.5 rounded-full bg-success-500"></span> Aktif
                </span>
            </div>
        </div>

        <!-- Menu Links TailAdmin Pro Style -->
        <ul class="flex flex-col gap-1 py-2 border-b border-gray-100 dark:border-gray-800 text-xs">
            <li>
                <a
                    href="{{ route('panel.profile') }}"
                    class="flex items-center gap-3 px-3 py-2 font-medium text-gray-700 rounded-xl hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white transition-colors"
                >
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span>Profil Pengguna</span>
                </a>
            </li>

            @if ($pengguna?->peran->value === 'direktur')
                <li>
                    <a
                        href="{{ route('panel.users.index') }}"
                        class="flex items-center gap-3 px-3 py-2 font-medium text-gray-700 rounded-xl hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white transition-colors"
                    >
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                        <span>Manajemen Akun</span>
                    </a>
                </li>
            @endif

            <li>
                <a
                    href="{{ route('panel.reports') }}"
                    class="flex items-center gap-3 px-3 py-2 font-medium text-gray-700 rounded-xl hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white transition-colors"
                >
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    <span>Laporan & Pembukuan</span>
                </a>
            </li>
        </ul>

        <!-- Logout Action -->
        <div class="pt-2">
            <form method="POST" action="{{ route('panel.logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold text-error-600 dark:text-error-400 rounded-xl hover:bg-error-50 dark:hover:bg-error-500/10 w-full text-left transition-colors">
                    <svg class="w-4 h-4 text-error-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    <span>Keluar dari Aplikasi</span>
                </button>
            </form>
        </div>
    </div>
</div>
