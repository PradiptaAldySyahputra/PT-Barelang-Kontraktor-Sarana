{{--
    Backup Database (/panel/backup) - HANYA Admin.
    Unduhan memakai rute backup.unduh yang sudah ada.
--}}
@php
    $kelasKartu = 'rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs';
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <div class="space-y-4">

        <section class="{{ $kelasKartu }} p-5">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <dl class="grid gap-x-8 gap-y-3 sm:grid-cols-3">
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
                        <dd class="mt-0.5 text-theme-sm font-semibold {{ $ringkasan['sehat'] ? 'text-success-600 dark:text-success-500' : 'text-warning-600 dark:text-warning-500' }}">
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

        <section class="{{ $kelasKartu }}">
            <h2 class="border-b border-gray-100 px-5 py-4 text-theme-sm font-semibold text-gray-900 dark:border-gray-800 dark:text-white">
                Berkas Backup
            </h2>

            @if ($daftar === [])
                <p class="px-5 py-12 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                    Belum ada berkas backup di folder penyimpanan.
                </p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
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