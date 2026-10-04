{{--
    Halaman Laporan.

    ⚠️ KEPUTUSAN USER: laba/rugi, piutang, aging, dan retensi DIHAPUS.
    Laporan hanya memuat data yang BENAR-BENAR ADA & DIINPUT.

    SUSUNAN (dari yang paling penting):
      1. Ringkasan         — 4 angka utama
      2. Uang Masuk/Keluar — per bulan (satu tabel gabungan)
      3. Pengeluaran       — per kategori
      4. Piutang           — SPK belum diterima penuh (PRD FR-RPT-005)
      5. Daftar SPK        — nilai & status
      6. Tenggat SPK       — yang lewat / mendekati

    ⚠️ CATATAN: laba/rugi, aging, dan retensi DIHAPUS (tidak ada datanya).
    PIUTANG tetap ada — datanya nyata (nilai SPK − uang masuk) dan
    diwajibkan PRD FR-RPT-005.

    Setiap bagian punya JUDUL + PENJELASAN singkat dan tombol EKSPOR
    sendiri (Excel/PDF/CSV) di header-nya, supaya admin tidak perlu
    menggulir ke atas untuk mengekspor bagian tertentu.
--}}
<x-filament-panels::page>
    {{-- ============================================================
         PEMILIH PERIODE
         ============================================================
         ⚠️ PERBAIKAN UI (2 Okt 2026) — keluhan pengguna:
           "kenapa digabung menjadi satu memanjang begitu, tidak bisa
            dipisah?"

         Dulu di sini ada SATU dropdown "Ekspor" berisi 5 laporan × 3 format
         = 15 baris menumpuk, jauh dari data yang diekspor. Sekarang tombol
         ekspor dipindah ke header MASING-MASING bagian laporan (lihat
         partials/ekspor-laporan.blade.php), jadi selalu di dekat datanya.

         Sisa di atas halaman hanya pemilih periode.
         ============================================================ --}}
    <div class="flex flex-wrap items-center gap-3">
        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Periode:</span>

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
                ['Nilai SPK', \App\Support\Format::rupiah($nilaiSpk), $jumlahSpk.' SPK tercatat', 'gray'],
                ['Uang Masuk', \App\Support\Format::rupiah($totalMasuk), \App\Support\Format::rupiah($masukDariSpk).' dari SPK · '.\App\Support\Format::rupiah($masukLuarSpk).' luar SPK', 'success'],
                ['Uang Keluar', \App\Support\Format::rupiah($totalKeluar), 'Pengeluaran periode ini', 'danger'],
                ['Belum Diterima', \App\Support\Format::rupiah($belumDiterima), 'Nilai SPK − sudah diterima', 'warning'],
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
            <span class="flex items-center gap-2">
                {{-- ⚠️ PEMBARUAN (2 Okt 2026): status eksplisit supaya admin tidak
                     perlu menafsirkan warna angka sendiri. --}}
                <x-filament::badge :color="$selisih >= 0 ? 'success' : 'danger'" size="sm">
                    {{ $selisih >= 0 ? 'Surplus' : 'Defisit' }}
                </x-filament::badge>
                <span @class([
                    'text-base font-semibold tabular-nums',
                    'text-emerald-600 dark:text-emerald-400' => $selisih >= 0,
                    'text-rose-600 dark:text-rose-400' => $selisih < 0,
                ])>
                    {{ \App\Support\Format::rupiah($selisih) }}
                </span>
            </span>
        </div>

        {{-- Konteks jumlah data — angka di atas berasal dari berapa banyak data. --}}
        <div class="mt-3 flex flex-wrap gap-x-5 gap-y-1 text-xs text-gray-500 dark:text-gray-400">
            <span><span class="font-semibold text-gray-700 dark:text-gray-300">{{ $jumlahSpk }}</span> SPK</span>
            <span><span class="font-semibold text-gray-700 dark:text-gray-300">{{ $jumlahMitra }}</span> Mitra</span>
            <span><span class="font-semibold text-gray-700 dark:text-gray-300">{{ $jumlahMasuk + $jumlahKeluar }}</span> Transaksi</span>
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
        <x-slot name="afterHeader">
            @include('filament.pages.partials.ekspor-laporan', ['jenis' => 'masuk'])
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
                                    {{ \App\Support\Format::rupiah($r['masuk']) }}
                                </td>
                                <td class="py-2 pr-3 text-right tabular-nums text-rose-600 dark:text-rose-400">
                                    {{ \App\Support\Format::rupiah($r['keluar']) }}
                                </td>
                                <td @class([
                                    'py-2 pr-3 text-right font-medium tabular-nums',
                                    'text-emerald-600 dark:text-emerald-400' => $r['selisih'] >= 0,
                                    'text-rose-600 dark:text-rose-400' => $r['selisih'] < 0,
                                ])>
                                    {{ \App\Support\Format::rupiah($r['selisih']) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::section>

    {{-- ============================================================
         2b. TREN ARUS UANG — batang CSS sederhana (tanpa pustaka chart)
         ============================================================
         ⚠️ PEMBARUAN (2 Okt 2026) — permintaan user: "tampilan dan fiturnya
         masih kurang". Angka bulanan sulit dibandingkan tanpa gambaran visual.
         Batang murni CSS (tanpa dependensi baru), memakai data $perBulan yang
         sudah ada.
         ============================================================ --}}
    @if ($perBulan->isNotEmpty())
        @php
            $tren = $perBulan->take(6)->reverse()->values();
            $skalaTren = max(1, $tren->max(fn ($r) => max($r['masuk'], $r['keluar'])));
        @endphp
        <x-filament::section collapsible collapsed>
            <x-slot name="heading">Tren Arus Uang</x-slot>
            <x-slot name="description">
                Perbandingan uang masuk (hijau) dan keluar (merah) 6 bulan terakhir.
            </x-slot>

            <div class="flex items-end gap-4 overflow-x-auto pb-2" style="min-height: 160px;">
                @foreach ($tren as $r)
                    <div class="flex min-w-[64px] flex-1 flex-col items-center gap-1">
                        <div class="flex h-32 w-full items-end justify-center gap-1">
                            <div class="w-1/3 rounded-t bg-emerald-500"
                                 style="height: {{ max(2, round($r['masuk'] / $skalaTren * 100)) }}%"
                                 title="Masuk: {{ \App\Support\Format::rupiah($r['masuk']) }}"></div>
                            <div class="w-1/3 rounded-t bg-rose-500"
                                 style="height: {{ max(2, round($r['keluar'] / $skalaTren * 100)) }}%"
                                 title="Keluar: {{ \App\Support\Format::rupiah($r['keluar']) }}"></div>
                        </div>
                        <span class="text-[11px] font-medium text-gray-600 dark:text-gray-400">
                            {{ \Illuminate\Support\Str::of($r['label'])->substr(0, 3) }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="mt-2 flex gap-4 text-xs text-gray-500 dark:text-gray-400">
                <span class="flex items-center gap-1"><span class="inline-block h-2 w-2 rounded-sm bg-emerald-500"></span> Uang Masuk</span>
                <span class="flex items-center gap-1"><span class="inline-block h-2 w-2 rounded-sm bg-rose-500"></span> Uang Keluar</span>
            </div>
        </x-filament::section>
    @endif

    {{-- ============================================================
         3. PENGELUARAN PER KATEGORI
         ============================================================ --}}
    <x-filament::section collapsible>
        <x-slot name="heading">Pengeluaran per Kategori</x-slot>
        <x-slot name="description">
            Ke mana uang keluar digunakan — material, upah, operasional, dan lainnya.
        </x-slot>
        <x-slot name="afterHeader">
            @include('filament.pages.partials.ekspor-laporan', ['jenis' => 'keluar'])
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
                                {{ \App\Support\Format::rupiah($r['total']) }}
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
         4. PIUTANG — SPK yang belum diterima penuh (PRD FR-RPT-005)
         ============================================================
         ⚠️ Dulu ada ekspor 'piutang' tapi TIDAK ADA bagiannya di halaman,
         jadi datanya terhitung tapi tak pernah terlihat admin. Sekarang
         ditampilkan supaya ekspornya ada sumbernya.
         ============================================================ --}}
    <x-filament::section collapsible collapsed>
        <x-slot name="heading">Piutang (Belum Diterima)</x-slot>
        <x-slot name="description">
            SPK yang uangnya belum diterima penuh, diurutkan dari piutang terbesar. SPK lunas tidak muncul.
        </x-slot>
        <x-slot name="afterHeader">
            @include('filament.pages.partials.ekspor-laporan', ['jenis' => 'piutang'])
        </x-slot>

        @if ($daftarPiutang->isEmpty())
            <p class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                Semua SPK sudah diterima penuh.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left dark:border-gray-700">
                            <th class="py-2 pr-3 font-semibold">Nomor SPK</th>
                            <th class="py-2 pr-3 font-semibold">Pekerjaan</th>
                            <th class="py-2 pr-3 text-right font-semibold">Nilai SPK</th>
                            <th class="py-2 pr-3 text-right font-semibold">Sudah Diterima</th>
                            <th class="py-2 pr-3 text-right font-semibold">Belum Diterima</th>
                            <th class="py-2 pr-3 font-semibold">Tenggat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($daftarPiutang as $s)
                            @php $totalMasuk = (float) ($s->total_masuk ?? 0); @endphp
                            <tr>
                                <td class="py-2 pr-3 font-medium">{{ $s->nomor_spk }}</td>
                                <td class="py-2 pr-3">
                                    {{ \Illuminate\Support\Str::limit($s->nama_pekerjaan, 60) }}
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">
                                        {{ $s->mitra?->nama ?? '—' }}
                                    </span>
                                </td>
                                <td class="py-2 pr-3 text-right tabular-nums">{{ \App\Support\Format::rupiah((float) $s->nilai_spk) }}</td>
                                <td class="py-2 pr-3 text-right tabular-nums text-emerald-600 dark:text-emerald-400">
                                    {{ \App\Support\Format::rupiah($s->totalPenerimaan()) }}
                                </td>
                                <td class="py-2 pr-3 text-right font-medium tabular-nums text-amber-600 dark:text-amber-400">
                                    {{ \App\Support\Format::rupiah($s->piutangDari($totalMasuk)) }}
                                </td>
                                <td class="py-2 pr-3 tabular-nums">
                                    {{ $s->tanggal_akhir?->format('d/m/Y') ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::section>

    {{-- ============================================================
         5. DAFTAR SPK
         ============================================================ --}}
    <x-filament::section collapsible collapsed>
        <x-slot name="heading">Daftar SPK</x-slot>
        <x-slot name="description">
            Seluruh SPK beserta nilai dan statusnya. "Belum Diterima" = nilai SPK − sudah diterima.
        </x-slot>
        <x-slot name="afterHeader">
            @include('filament.pages.partials.ekspor-laporan', ['jenis' => 'spk'])
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
                                <td class="py-2 pr-3 text-right tabular-nums">{{ \App\Support\Format::rupiah($r['nilai_spk']) }}</td>
                                <td class="py-2 pr-3 text-right tabular-nums text-emerald-600 dark:text-emerald-400">
                                    {{ \App\Support\Format::rupiah($r['diterima']) }}
                                </td>
                                <td class="py-2 pr-3 text-right font-medium tabular-nums text-amber-600 dark:text-amber-400">
                                    {{ \App\Support\Format::rupiah($r['belum_diterima']) }}
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
        <x-slot name="afterHeader">
            @include('filament.pages.partials.ekspor-laporan', ['jenis' => 'tenggat'])
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
                                    {{ \App\Support\Format::rupiah((float) $s->nilai_spk) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::section>
</x-filament-panels::page>
