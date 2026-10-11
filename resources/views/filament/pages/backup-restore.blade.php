{{--
    ============================================================
    HALAMAN BACKUP & RESTORE (B1-4)
    ============================================================

    Menampilkan: status backup terakhir, daftar berkas, tombol unduh.
    Hanya Admin yang bisa mengakses (dijaga di BackupRestore::canAccess()).

    Variabel: $ringkasan, $daftar
--}}
<x-filament-panels::page>

    {{-- ================= STATUS RINGKASAN ================= --}}
    <x-filament::section>
        <x-slot name="heading">Status Backup</x-slot>
        <x-slot name="description">
            Backup database berisi seluruh data SPK & keuangan. Simpan salinannya di tempat lain (flashdisk/server lain).
        </x-slot>

        @if ($ringkasan['jumlah'] === 0)
            <div class="rounded-lg border border-amber-300 bg-amber-50 p-4 dark:border-amber-700 dark:bg-amber-950">
                <p class="font-semibold text-amber-800 dark:text-amber-200">⚠️ Belum ada backup</p>
                <p class="mt-1 text-sm text-amber-700 dark:text-amber-300">
                    Belum ada berkas backup sama sekali. Klik <strong>Buat Backup Sekarang</strong> di kanan atas,
                    lalu pastikan scheduler berjalan agar backup otomatis harian aktif.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Backup Terakhir</p>
                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $ringkasan['terakhir']?->translatedFormat('d F Y, H:i') ?? '—' }}
                    </p>
                    <p class="mt-0.5 text-xs {{ $ringkasan['sehat'] ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                        {{ $ringkasan['umur_hari'] }} hari lalu · {{ $ringkasan['sehat'] ? 'Sehat' : 'PERLU DIPERIKSA' }}
                    </p>
                </div>

                <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Jumlah Berkas</p>
                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $ringkasan['jumlah'] }}</p>
                    <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">retensi 30 hari</p>
                </div>

                <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Total Ukuran</p>
                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $ringkasan['total_ukuran_teks'] }}</p>
                    <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">semua berkas backup</p>
                </div>
            </div>
        @endif
    </x-filament::section>

    {{-- ================= DAFTAR BERKAS ================= --}}
    <x-filament::section collapsible>
        <x-slot name="heading">Daftar Berkas Backup</x-slot>

        @if (empty($daftar))
            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada berkas backup.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-500 dark:border-gray-700 dark:text-gray-400">
                            <th class="px-3 py-2">Nama Berkas</th>
                            <th class="px-3 py-2">Waktu</th>
                            <th class="px-3 py-2 text-right">Ukuran</th>
                            <th class="px-3 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftar as $b)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-3 py-2 font-mono text-xs text-gray-700 dark:text-gray-300">{{ $b['nama'] }}</td>
                                <td class="px-3 py-2 text-gray-600 dark:text-gray-400">{{ $b['waktu']->translatedFormat('d/m/Y H:i') }}</td>
                                <td class="px-3 py-2 text-right tabular-nums text-gray-700 dark:text-gray-300">{{ $b['ukuran_teks'] }}</td>
                                <td class="px-3 py-2 text-right">
                                    <x-filament::button
                                        size="xs"
                                        color="gray"
                                        tag="a"
                                        :href="route('backup.unduh', ['nama' => $b['nama']])"
                                    >
                                        Unduh
                                    </x-filament::button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::section>

</x-filament-panels::page>
