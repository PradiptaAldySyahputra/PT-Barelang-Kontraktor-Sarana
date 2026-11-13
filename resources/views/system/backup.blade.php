{{--
    Backup Database (/panel/backup) - HANYA Admin.
    Unduhan memakai rute backup.unduh yang sudah ada.
--}}
@php
    $kelasKartu = 'rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs';
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <div class="space-y-4">

        {{-- Banner Tombol Cepat Unduh ke Flashdisk Setelah Backup Berhasil --}}
        @if (session('backup_baru'))
            <div class="rounded-2xl border border-success-200 bg-success-50/80 p-4 dark:border-success-500/20 dark:bg-success-500/10 flex flex-col sm:flex-row items-center justify-between gap-3 shadow-xs">
                <div class="flex items-center gap-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                    </span>
                    <div>
                        <h4 class="text-xs font-bold text-success-900 dark:text-success-200">Snapshot Backup Berhasil Dibuat!</h4>
                        <p class="text-[11px] text-success-700 dark:text-success-300">Amankan salinan offsite ke media penyimpanan fisik luar server kantor.</p>
                    </div>
                </div>
                <a href="{{ route('backup.unduh', session('backup_baru')) }}"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-success-600 px-4 py-2 text-xs font-semibold text-white shadow-xs hover:bg-success-700 transition shrink-0">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Unduh ke Flashdisk Sekarang</span>
                </a>
            </div>
        @endif

        <section class="{{ $kelasKartu }} overflow-hidden">
            <h2 class="border-b border-gray-100 px-5 py-4 text-theme-sm font-semibold text-gray-900 dark:border-gray-800 dark:text-white">
                Status Cadangan
            </h2>
            <div class="flex flex-wrap items-start justify-between gap-4 p-5">
                <dl class="grid min-w-0 gap-x-8 gap-y-3 sm:grid-cols-3">
                    <div>
                        <dt class="text-theme-xs text-gray-500 dark:text-gray-400">Jumlah backup</dt>
                        <dd class="angka mt-0.5 text-lg font-semibold text-gray-900 dark:text-white">{{ $ringkasan['jumlah'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-theme-xs text-gray-500 dark:text-gray-400">Total ukuran</dt>
                        <dd class="mt-0.5 text-lg font-semibold text-gray-900 dark:text-white">{{ $ringkasan['total_ukuran_teks'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-theme-xs text-gray-500 dark:text-gray-400">Terakhir</dt>
                        <dd class="mt-0.5 text-theme-sm font-semibold {{ $ringkasan['sehat'] ? 'text-success-700 dark:text-success-500' : 'text-warning-700 dark:text-warning-500' }}">
                            {{ $ringkasan['terakhir']?->format('d/m/Y H:i') ?? 'Belum pernah' }}
                            @if ($ringkasan['umur_hari'] !== null)
                                <span class="font-normal text-gray-500 dark:text-gray-400">({{ $ringkasan['umur_hari'] }} hari lalu)</span>
                            @endif
                        </dd>
                    </div>
                </dl>

                <form method="POST" action="{{ route('panel.backup.run') }}"
                    onsubmit="return konfirmasiAksi(this, { title: 'Pencadangan Database', message: 'Buat snapshot cadangan database sekarang? Proses ini akan mengompres data ke dalam format ZIP.', confirmText: 'Mulai Backup', isDanger: false });">
                    @csrf
                    <button type="submit"
                        class="inline-flex h-9 items-center rounded-lg bg-brand-600 px-4 text-theme-sm font-semibold text-white hover:bg-brand-700">
                        Buat Backup Sekarang
                    </button>
                </form>
            </div>
        </section>

        {{-- Petunjuk Otomatisasi Jadwal Cadangan (Cronjob Intranet) --}}
        <section class="{{ $kelasKartu }} p-5">
            <div class="flex items-start gap-3.5">
                <div class="rounded-xl bg-brand-50 p-2.5 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 shrink-0">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Jadwal Pencadangan Otomatis Intranet</h3>
                    <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                        Pencadangan basis data berjalan otomatis setiap hari pada pukul <strong>02:00 WIB</strong> via cron daemon internal server (<code class="font-mono text-gray-800 dark:text-gray-200">php artisan app:backup-database</code>). Berkas disimpan lokal di <code class="font-mono text-gray-800 dark:text-gray-200">storage/app/backup/</code> dan disinkronkan ke flashdisk eksternal harian.
                    </p>
                </div>
            </div>
        </section>

        <section class="{{ $kelasKartu }} overflow-hidden">
            <h2 class="border-b border-gray-100 px-5 py-4 text-theme-sm font-semibold text-gray-900 dark:border-gray-800 dark:text-white">
                Berkas Backup
            </h2>

            @if ($daftar === [])
                <p class="px-5 py-12 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                    Belum ada berkas backup di folder penyimpanan.
                </p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[560px] text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-theme-xs text-gray-500 dark:border-gray-800 dark:text-gray-400">
                                <th class="px-5 py-2 font-medium">Berkas</th>
                                <th class="w-[110px] px-3 py-2 text-right font-medium">Ukuran</th>
                                <th class="w-[150px] px-3 py-2 font-medium">Waktu</th>
                                <th class="w-[120px] px-3 py-2 font-medium">Umur</th>
                                <th class="w-[90px] px-5 py-2 text-right font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-theme-sm dark:divide-gray-800">
                            @foreach ($daftar as $berkas)
                                <tr>
                                    <td class="px-5 py-2">
                                        <span class="block truncate text-gray-900 dark:text-white" title="{{ $berkas['nama'] }}">
                                            {{ $berkas['nama'] }}
                                        </span>
                                    </td>
                                    <td class="angka px-3 py-2 text-right text-gray-700 dark:text-gray-300">{{ $berkas['ukuran_teks'] }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                        {{ $berkas['waktu']?->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-3 py-2 text-gray-600 dark:text-gray-400">{{ $berkas['umur_hari'] }} hari</td>
                                    <td class="px-5 py-2 text-right">
                                        <a href="{{ route('backup.unduh', $berkas['nama']) }}"
                                            class="text-theme-xs font-medium text-brand-600 hover:underline dark:text-brand-400">
                                            Unduh
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</x-layouts.app>