{{--
    Halaman Laporan.

    ⚠️ KEPUTUSAN USER: laba/rugi, piutang, aging, dan retensi DIHAPUS.
    Laporan hanya memuat data yang BENAR-BENAR ADA & DIINPUT.

    SUSUNAN (dari yang paling penting):
      1. Ringkasan         — 4 angka utama
      2. Uang Masuk/Keluar — per bulan (satu tabel gabungan)
      3. Pengeluaran       — per kategori
      4. Daftar SPK        — nilai & status
      5. Tenggat SPK       — yang lewat / mendekati

    Setiap bagian punya JUDUL + PENJELASAN singkat supaya jelas apa yang
    disampaikan (keluhan user: "informasi apa yang ingin di kasih lihat
    terlihat berantakan").
--}}
<x-filament-panels::page>
    @php
        $rp = fn (float $n): string => 'Rp '.number_format($n, 0, ',', '.');
    @endphp

    {{-- ============================================================
         PEMILIH PERIODE + EKSPOR
         ============================================================ --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="inline-flex rounded-lg border border-gray-200 p-0.5 dark:border-gray-700">
            @foreach ([1 => 'Bulan Ini', 3 => '3 Bulan', 12 => '12 Bulan', 0 => 'Semua'] as $nilai => $label)
                <button
                    type="button"
                    wire:click="setPeriode({{ $nilai }})"
                    @class([
                        'rounded-md px-3 py-1.5 text-xs font-medium transition',
                        'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' => $periode === $nilai,
                        'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' => $periode !== $nilai,
                    ])
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <x-filament::dropdown>
            <x-slot name="trigger">
                <x-filament::button color="gray" size="sm" icon="heroicon-m-arrow-down-tray">
                    Ekspor CSV
                </x-filament::button>
            </x-slot>

            <x-filament::dropdown.list>
                @foreach ([
                    'spk' => 'Daftar SPK',
                    'masuk' => 'Uang Masuk per Bulan',
                    'keluar' => 'Pengeluaran per Kategori',
                    'tenggat' => 'Tenggat SPK',
                ] as $jenis => $label)
                    <x-filament::dropdown.list.item
                        tag="a"
                        href="{{ route('laporan.ekspor', $jenis) }}"
                    >
                        {{ $label }}
                    </x-filament::dropdown.list.item>
                @endforeach
            </x-filament::dropdown.list>
        </x-filament::dropdown>
    </div>

    {{-- ============================================================
         1. RINGKASAN
         ============================================================ --}}
    <x-filament::section>
        <x-slot name="heading">Ringkasan</x-slot>
        <x-slot name="description">
            Angka utama periode terpilih. "Belum Diterima" = nilai SPK dikurangi uang masuk yang terkait SPK.
        </x-slot>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['Nilai SPK', $rp($nilaiSpk), $jumlahSpk.' SPK tercatat', 'gray'],
                ['Uang Masuk', $rp($totalMasuk), $rp($masukDariSpk).' dari SPK · '.$rp($masukLuarSpk).' luar SPK', 'success'],
                ['Uang Keluar', $rp($totalKeluar), 'Pengeluaran periode ini', 'danger'],
                ['Belum Diterima', $rp($belumDiterima), 'Nilai SPK − sudah diterima', 'warning'],
            ] as [$judul, $angka, $ket, $warna])
                <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ $judul }}</p>
                    <p class="mt-1 text-lg font-semibold tabular-nums text-gray-900 dark:text-gray-100">{{ $angka }}</p>
                    <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">{{ $ket }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-4 flex items-center justify-between rounded-lg bg-gray-50 px-4 py-3 dark:bg-gray-800">
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Selisih (Masuk − Keluar)</span>
            <span @class([
                'text-base font-semibold tabular-nums',
                'text-emerald-600 dark:text-emerald-400' => $selisih >= 0,
                'text-rose-600 dark:text-rose-400' => $selisih < 0,
            ])>
                {{ $rp($selisih) }}
            </span>
        </div>
    </x-filament::section>

    {{-- ============================================================
         2. UANG MASUK & KELUAR PER BULAN
         ============================================================ --}}
    <x-filament::section collapsible>
        <x-slot name="heading">Arus Uang per Bulan</x-slot>
        <x-slot name="description">
            Uang masuk dan keluar tiap bulan, beserta selisihnya. Maksimal 12 bulan terakhir.
        </x-slot>

        @if ($perBulan->isEmpty())
            <p class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                Belum ada transaksi uang masuk pada periode ini.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left dark:border-gray-700">
                            <th class="py-2 pr-3 font-semibold">Bulan</th>
                            <th class="py-2 pr-3 text-right font-semibold">Uang Masuk</th>
                            <th class="py-2 pr-3 text-right font-semibold">Uang Keluar</th>
                            <th class="py-2 pr-3 text-right font-semibold">Selisih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($perBulan as $r)
                            <tr>
                                <td class="py-2 pr-3">
                                    {{ $r['label'] }}
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">
                                        {{ $r['jumlah_masuk'] }} masuk · {{ $r['jumlah_keluar'] }} keluar
                                    </span>
                                </td>
                                <td class="py-2 pr-3 text-right tabular-nums text-emerald-600 dark:text-emerald-400">
                                    {{ $rp($r['masuk']) }}
                                </td>
                                <td class="py-2 pr-3 text-right tabular-nums text-rose-600 dark:text-rose-400">
                                    {{ $rp($r['keluar']) }}
                                </td>
                                <td @class([
                                    'py-2 pr-3 text-right font-medium tabular-nums',
                                    'text-emerald-600 dark:text-emerald-400' => $r['selisih'] >= 0,
                                    'text-rose-600 dark:text-rose-400' => $r['selisih'] < 0,
                                ])>
                                    {{ $rp($r['selisih']) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::section>

    {{-- ============================================================
         3. PENGELUARAN PER KATEGORI
         ============================================================ --}}
    <x-filament::section collapsible>
        <x-slot name="heading">Pengeluaran per Kategori</x-slot>
        <x-slot name="description">
            Ke mana uang keluar digunakan — material, upah, operasional, dan lainnya.
        </x-slot>

        @if ($perKategori->isEmpty())
            <p class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                Belum ada pengeluaran pada periode ini.
            </p>
        @else
            <div class="space-y-3">
                @php $terbesar = max(1, $perKategori->max('total')); @endphp
                @foreach ($perKategori as $r)
                    <div>
                        <div class="flex items-baseline justify-between gap-3">
                            <span class="text-sm font-medium">{{ $r['label'] }}</span>
                            <span class="text-sm tabular-nums">
                                {{ $rp($r['total']) }}
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    ({{ $r['jumlah_transaksi'] }}x)
                                </span>
                            </span>
                        </div>
                        <div class="mt-1 h-1.5 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                            <div class="h-full rounded-full bg-zinc-900 dark:bg-zinc-100"
                                 style="width: {{ round($r['total'] / $terbesar * 100) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-filament::section>

    {{-- ============================================================
         4. DAFTAR SPK
         ============================================================ --}}
    <x-filament::section collapsible collapsed>
        <x-slot name="heading">Daftar SPK</x-slot>
        <x-slot name="description">
            Seluruh SPK beserta nilai dan statusnya. "Belum Diterima" = nilai SPK − sudah diterima.
        </x-slot>

        @if ($daftarSpk->isEmpty())
            <p class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                Belum ada data SPK.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left dark:border-gray-700">
                            <th class="py-2 pr-3 font-semibold">Nomor SPK</th>
                            <th class="py-2 pr-3 font-semibold">Pekerjaan</th>
                            <th class="py-2 pr-3 text-right font-semibold">Nilai SPK</th>
                            <th class="py-2 pr-3 text-right font-semibold">Diterima</th>
                            <th class="py-2 pr-3 text-right font-semibold">Belum Diterima</th>
                            <th class="py-2 pr-3 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($daftarSpk as $r)
                            <tr>
                                <td class="py-2 pr-3 font-medium">{{ $r['nomor_spk'] }}</td>
                                <td class="py-2 pr-3">
                                    {{ \Illuminate\Support\Str::limit($r['pekerjaan'], 60) }}
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">
                                        {{ $r['mitra'] ?? '—' }}
                                    </span>
                                </td>
                                <td class="py-2 pr-3 text-right tabular-nums">{{ $rp($r['nilai_spk']) }}</td>
                                <td class="py-2 pr-3 text-right tabular-nums text-emerald-600 dark:text-emerald-400">
                                    {{ $rp($r['diterima']) }}
                                </td>
                                <td class="py-2 pr-3 text-right font-medium tabular-nums text-amber-600 dark:text-amber-400">
                                    {{ $rp($r['belum_diterima']) }}
                                </td>
                                <td class="py-2 pr-3">
                                    <x-filament::badge color="gray" size="sm">{{ $r['status_spk'] }}</x-filament::badge>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::section>

    {{-- ============================================================
         5. TENGGAT SPK
         ============================================================ --}}
    <x-filament::section collapsible collapsed>
        <x-slot name="heading">Tenggat SPK</x-slot>
        <x-slot name="description">
            Pekerjaan yang sudah lewat tenggat atau akan jatuh tempo dalam 14 hari.
        </x-slot>

        @php
            $semuaTenggat = $spkLewatTenggat->map(fn ($s) => ['spk' => $s, 'lewat' => true])
                ->concat($spkMendekatiTenggat->map(fn ($s) => ['spk' => $s, 'lewat' => false]));
        @endphp

        @if ($semuaTenggat->isEmpty())
            <p class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                Tidak ada SPK yang lewat atau mendekati tenggat.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left dark:border-gray-700">
                            <th class="py-2 pr-3 font-semibold">Nomor SPK</th>
                            <th class="py-2 pr-3 font-semibold">Pekerjaan</th>
                            <th class="py-2 pr-3 font-semibold">Tenggat</th>
                            <th class="py-2 pr-3 font-semibold">Keterangan</th>
                            <th class="py-2 pr-3 text-right font-semibold">Nilai SPK</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($semuaTenggat as $item)
                            @php $s = $item['spk']; @endphp
                            <tr>
                                <td class="py-2 pr-3 font-medium">{{ $s->nomor_spk }}</td>
                                <td class="py-2 pr-3">
                                    {{ \Illuminate\Support\Str::limit($s->nama_pekerjaan, 50) }}
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">
                                        {{ $s->mitra?->nama ?? '—' }}
                                    </span>
                                </td>
                                <td class="py-2 pr-3 tabular-nums">
                                    {{ $s->tanggal_akhir?->format('d/m/Y') ?? '—' }}
                                </td>
                                <td class="py-2 pr-3">
                                    <x-filament::badge :color="$item['lewat'] ? 'danger' : 'warning'" size="sm">
                                        {{ $s->labelTenggat() }}
                                    </x-filament::badge>
                                </td>
                                <td class="py-2 pr-3 text-right tabular-nums">
                                    {{ $rp((float) $s->nilai_spk) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::section>
</x-filament-panels::page>
