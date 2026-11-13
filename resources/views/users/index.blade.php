{{--
    Halaman Manajemen Akun (/panel/users). Hanya Direktur.
--}}
<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <div class="mb-4 flex justify-end">
        <a href="{{ route('panel.users.sesi') }}"
           class="inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-3.5 text-theme-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Sesi aktif
        </a>
    </div>
    <livewire:user.user-table />
</x-layouts.app>
