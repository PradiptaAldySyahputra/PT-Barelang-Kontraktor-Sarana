{{--
    ============================================================
    HALAMAN EKSPOR & UNDUHAN (peta menu C)
    ============================================================

    Riwayat ekspor (Excel/CSV). Data dari tabel `exports` Filament.
    Variabel: $riwayat (Collection)
--}}
<x-filament-panels::page>

    <x-filament::section>
        <x-slot name="heading">Riwayat Ekspor</x-slot>
        <x-slot name="description">
            Berkas ekspor yang pernah dibuat. Klik <strong>Unduh</strong> untuk mengunduh ulang.
            Ekspor besar diproses di belakang layar (queue worker) — statusnya muncul di sini.
        </x-slot>

        @if ($riwayat->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Belum ada riwayat ekspor. Gunakan tombol <strong>Ekspor Excel</strong> pada menu
                SPK, Uang Masuk, atau Uang Keluar.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-500 dark:border-gray-700 dark:text-gray-400">
                            <th class="px-3 py-2">Waktu</th>
                            <th class="px-3 py-2">Jenis Data</th>
                            <th class="px-3 py-2">Status</th>
                            <th class="px-3 py-2">Baris</th>
                            <th class="px-3 py-2">Berkas</th>
                            <th class="px-3 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $r)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-3 py-2 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                    {{ $r['waktu']?->format('d/m/Y H:i') ?? '—' }}
                                </td>
                                <td class="px-3 py-2 text-gray-700 dark:text-gray-300">{{ $r['jenis'] }}</td>
                                <td class="px-3 py-2">
                                    <span @class([
                                        'inline-flex items-center rounded px-2 py-0.5 text-xs font-medium',
                                        'bg-success-50 text-success-700 dark:bg-success-950 dark:text-success-400' => $r['warna'] === 'success',
                                        'bg-warning-50 text-warning-700 dark:bg-warning-950 dark:text-warning-400' => $r['warna'] === 'warning',
                                        'bg-danger-50 text-danger-700 dark:bg-danger-950 dark:text-danger-400' => $r['warna'] === 'danger',
                                    ])>
                                        {{ $r['status_label'] }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-gray-600 dark:text-gray-400 tabular-nums">
                                    {{ $r['baris_sukses'] }}/{{ $r['total_baris'] }}
                                    @if ($r['baris_gagal'] > 0)
                                        <span class="text-danger-600 dark:text-danger-400">({{ $r['baris_gagal'] }} gagal)</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 font-mono text-xs text-gray-600 dark:text-gray-400">
                                    {{ $r['nama_berkas'] }}
                                </td>
                                <td class="px-3 py-2 text-right whitespace-nowrap">
                                    @if ($r['bisa_unduh'])
                                        <x-filament::button
                                            size="xs"
                                            color="gray"
                                            tag="a"
                                            :href="route('ekspor.unduh', ['ekspor' => $r['id']])"
                                        >
                                            Unduh
                                        </x-filament::button>
                                    @else
                                        <span class="text-xs text-gray-400">
                                            {{ $r['selesai'] ? 'Berkas tidak tersedia' : 'Menunggu proses' }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::section>

</x-filament-panels::page>
