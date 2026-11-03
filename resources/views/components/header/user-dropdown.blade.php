@php
    $pengguna = auth()->user();
@endphp

<div class="relative" x-data="{
    isOpen: false,
    toggleDropdown() {
        this.isOpen = !this.isOpen;
    },
    closeDropdown() {
        this.isOpen = false;
    }
}" @click.outside="closeDropdown()">
    <!-- User Trigger -->
    <button
        class="flex items-center text-gray-700 dark:text-gray-400 group"
        type="button"
        @click="toggleDropdown()"
    >
        <span class="mr-3 overflow-hidden rounded-full h-11 w-11 rtl:mr-0 rtl:ml-3 bg-brand-50 dark:bg-brand-500/15 flex items-center justify-center font-bold text-brand-600 dark:text-brand-400 border border-brand-200 dark:border-brand-500/20 text-sm">
            @if ($pengguna?->urlAvatar())
                <img src="{{ $pengguna->urlAvatar() }}" alt="{{ $pengguna->nama }}" class="h-full w-full object-cover rounded-full" />
            @else
                {{ strtoupper(mb_substr((string) ($pengguna?->nama ?? 'U'), 0, 1)) }}
            @endif
        </span>

        <span class="block mr-1 font-medium text-theme-sm rtl:mr-0 rtl:ml-1 text-gray-800 dark:text-white/90">{{ $pengguna?->nama }}</span>

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

    <!-- Dropdown Menu -->
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute ltr:right-0 rtl:left-0 mt-[17px] flex w-[260px] flex-col rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg dark:border-gray-800 dark:bg-gray-900 z-50"
        style="display: none;"
    >
        <!-- User Info -->
        <div class="pb-3 border-b border-gray-100 dark:border-gray-800 px-2">
            <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $pengguna?->nama }}</span>
            <span class="mt-0.5 block text-theme-xs text-gray-500 dark:text-gray-400 truncate">{{ $pengguna?->email }}</span>
            <span class="mt-1.5 inline-block text-[10px] font-semibold uppercase px-2 py-0.5 rounded-full bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                {{ $pengguna?->peran->label() }}
            </span>
        </div>

        <!-- Menu Items -->
        <ul class="flex flex-col gap-1 pt-3 pb-2 border-b border-gray-100 dark:border-gray-800">
            <li>
                <a
                    href="{{ route('panel.profile') }}"
                    class="flex items-center gap-3 px-3 py-2 font-medium text-gray-700 rounded-lg group text-theme-sm hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 transition-colors"
                >
                    <span class="text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 14.1526 4.3002 16.1184 5.61936 17.616C6.17279 15.3096 8.24852 13.5955 10.7246 13.5955H13.2746C15.7509 13.5955 17.8268 15.31 18.38 17.6167C19.6996 16.119 20.5 14.153 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5ZM17.0246 18.8566V18.8455C17.0246 16.7744 15.3457 15.0955 13.2746 15.0955H10.7246C8.65354 15.0955 6.97461 16.7744 6.97461 18.8455V18.856C8.38223 19.8895 10.1198 20.5 12 20.5C13.8798 20.5 15.6171 19.8898 17.0246 18.8566ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9991 7.25C10.8847 7.25 9.98126 8.15342 9.98126 9.26784C9.98126 10.3823 10.8847 11.2857 11.9991 11.2857C13.1135 11.2857 14.0169 10.3823 14.0169 9.26784C14.0169 8.15342 13.1135 7.25 11.9991 7.25ZM8.48126 9.26784C8.48126 7.32499 10.0563 5.75 11.9991 5.75C13.9419 5.75 15.5169 7.32499 15.5169 9.26784C15.5169 11.2107 13.9419 12.7857 11.9991 12.7857C10.0563 12.7857 8.48126 11.2107 8.48126 9.26784Z" fill="currentColor" />
                        </svg>
                    </span>
                    Profil Akun
                </a>
            </li>
        </ul>

        <!-- Logout Button -->
        <div class="pt-2">
            <form method="POST" action="{{ route('panel.logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2 font-medium text-error-600 rounded-lg group text-theme-sm hover:bg-error-50 dark:text-error-500 dark:hover:bg-error-500/10 w-full text-left transition-colors">
                    <svg class="w-5 h-5 text-error-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</div>
