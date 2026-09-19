@php
    use App\Enums\KategoriPengeluaran;
@endphp

<x-filament-panels::page>

    {{-- =========================================================
         TOOLBAR: periode + ekspor
         Dibuat responsif: menumpuk di layar kecil, sejajar di layar lebar
         ========================================================= --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        {{-- Filter periode --}}
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Periode</span>

            <div class="inline-flex rounded-lg bg-gray-100 p-0.5 dark:bg-white/5">
                @foreach ([1 => 'Bulan Ini', 3 => '3 Bulan', 12 => '12 Bulan', 0 => 'Semua'] as $nilai => $label)
                    <button
                        type="button"
                        wire:click="setPeriode({{ $nilai }})"
                        @class([
                            'rounded-md px-3 py-1.5 text-sm font-medium transition',
                            'bg-white text-gray-900 shadow-sm dark:bg-white/10 dark:text-white' => $periode === $nilai,
                            'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' => $periode !== $nilai,
                        ])
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Ekspor --}}
        <x-filament::dropdown placement="bottom-end" teleport>
            <x-slot name="trigger">
                <x-filament::button size="sm" color="gray" icon="heroicon-m-arrow-down-tray" class="w-full sm:w-auto">
                    Ekspor CSV
                </x-filament::button>
            </x-slot>

            <x-filament::dropdown.list>
                @foreach ([
                    'spk' => 'Daftar SPK',
                    'laba_rugi' => 'Laba-Rugi per SPK',
                    'piutang' => 'Piutang SPK',
                    'cashflow' => 'Arus Kas per Bulan',
                    'kategori' => 'Pengeluaran per Kategori',
                ] as $jenis => $label)
                    <x-filament::dropdown.list.item
                        :href="route('laporan.ekspor', $jenis)"
                        icon="heroicon-m-document-arrow-down"
                        tag="a"
                    >
                        {{ $label }}
                    </x-filament::dropdown.list.item>
                @endforeach
            </x-filament::dropdown.list>
        </x-filament::dropdown>
    </div>

    {{-- =========================================================
         KARTU RINGKASAN — 1 kolom (HP) → 2 (tablet) → 4 (desktop)
         ========================================================= --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Uang Masuk --}}
        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
            <div class="flex items-center justify-between gap-3">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Uang Masuk
                </span>
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-success-50 dark:bg-success-500/10">
                    <x-filament::icon icon="heroicon-m-arrow-trending-up" class="h-4 w-4 text-success-600 dark:text-success-400" />
                </span>
            </div>
            <div class="mt-3 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ number_format($totalMasuk, 0, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Rupiah</div>
            <div class="mt-3 space-y-1 border-t border-gray-100 pt-3 text-xs dark:border-white/10">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Dari SPK</span>
                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ number_format($masukDariSpk, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Luar SPK</span>
                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ number_format($masukLuarSpk, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Uang Keluar --}}
        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
            <div class="flex items-center justify-between gap-3">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Uang Keluar
                </span>
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-danger-50 dark:bg-danger-500/10">
                    <x-filament::icon icon="heroicon-m-arrow-trending-down" class="h-4 w-4 text-danger-600 dark:text-danger-400" />
                </span>
            </div>
            <div class="mt-3 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ number_format($totalKeluar, 0, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Rupiah</div>
            <div class="mt-3 border-t border-gray-100 pt-3 text-xs dark:border-white/10">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Jumlah kategori</span>
                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $perKategori->count() }}</span>
                </div>
            </div>
        </div>

        {{-- Saldo Bersih --}}
        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
            <div class="flex items-center justify-between gap-3">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Saldo Bersih
                </span>
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">
                    <x-filament::icon icon="heroicon-m-banknotes" class="h-4 w-4 text-gray-600 dark:text-gray-300" />
                </span>
            </div>
            <div @class([
                'mt-3 text-2xl font-bold tracking-tight',
                'text-gray-900 dark:text-white' => $saldo >= 0,
                'text-danger-600 dark:text-danger-400' => $saldo < 0,
            ])>
                {{ number_format($saldo, 0, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Rupiah</div>
            <div class="mt-3 border-t border-gray-100 pt-3 text-xs dark:border-white/10">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Uang masuk − keluar</span>
                    <span @class([
                        'font-semibold',
                        'text-success-600 dark:text-success-400' => $saldo >= 0,
                        'text-danger-600 dark:text-danger-400' => $saldo < 0,
                    ])>{{ $saldo >= 0 ? 'Surplus' : 'Defisit' }}</span>
                </div>
            </div>
        </div>

        {{-- Piutang --}}
        <div class="rounded-xl bg-warning-50 p-5 shadow-sm ring-1 ring-warning-200 dark:bg-warning-500/10 dark:ring-warning-500/30">
            <div class="flex items-center justify-between gap-3">
                <span class="text-xs font-semibold uppercase tracking-wide text-warning-700 dark:text-warning-400">
                    Total Piutang
                </span>
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-warning-100 dark:bg-warning-500/20">
                    <x-filament::icon icon="heroicon-m-clock" class="h-4 w-4 text-warning-700 dark:text-warning-400" />
                </span>
            </div>
            <div class="mt-3 text-2xl font-bold tracking-tight text-warning-900 dark:text-warning-300">
                {{ number_format($totalPiutang, 0, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-warning-700 dark:text-warning-400">Rupiah</div>
            <div class="mt-3 border-t border-warning-200/60 pt-3 text-xs dark:border-warning-500/20">
                <div class="flex items-center justify-between">
                    <span class="text-warning-700 dark:text-warning-400">SPK belum lunas</span>
                    <span class="font-semibold text-warning-900 dark:text-warning-300">{{ $piutang->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- =========================================================
         ARUS KAS PER BULAN
         ========================================================= --}}
    <x-filament::section
        icon="heroicon-o-arrows-right-left"
        collapsible
    >
        <x-slot name="heading">Arus Kas per Bulan</x-slot>
        <x-slot name="description">Uang masuk, uang keluar, dan selisihnya per bulan</x-slot>

        @if ($perBulan->isEmpty())
            <x-filament::empty-state
                icon="heroicon-o-inbox"
                heading="Belum ada transaksi"
                description="Tidak ada transaksi pada periode yang dipilih."
            />
        @else
            {{-- Tabel untuk layar sedang ke atas --}}
            <div class="hidden overflow-x-auto md:block">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-500 dark:border-white/10 dark:text-gray-400">
                            <th class="py-3 pr-4 font-semibold">Bulan</th>
                            <th class="py-3 pr-4 text-center font-semibold">Transaksi</th>
                            <th class="py-3 pr-4 text-right font-semibold">Masuk</th>
                            <th class="py-3 pr-4 text-right font-semibold">Keluar</th>
                            <th class="py-3 text-right font-semibold">Selisih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @foreach ($perBulan as $b)
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="py-3 pr-4 font-medium text-gray-900 dark:text-white">
                                    {{ $b['label'] }}
                                </td>
                                <td class="py-3 pr-4">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <x-filament::badge color="success" size="sm">{{ $b['jumlah_masuk'] }} masuk</x-filament::badge>
                                        <x-filament::badge color="danger" size="sm">{{ $b['jumlah_keluar'] }} keluar</x-filament::badge>
                                    </div>
                                </td>
                                <td class="py-3 pr-4 text-right font-medium tabular-nums text-success-600 dark:text-success-400">
                                    {{ number_format($b['masuk'], 0, ',', '.') }}
                                </td>
                                <td class="py-3 pr-4 text-right font-medium tabular-nums text-danger-600 dark:text-danger-400">
                                    {{ number_format($b['keluar'], 0, ',', '.') }}
                                </td>
                                <td @class([
                                    'py-3 text-right font-semibold tabular-nums',
                                    'text-success-700 dark:text-success-400' => $b['selisih'] >= 0,
                                    'text-danger-700 dark:text-danger-400' => $b['selisih'] < 0,
                                ])>
                                    {{ $b['selisih'] >= 0 ? '+' : '−' }}{{ number_format(abs($b['selisih']), 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Kartu untuk layar kecil --}}
            <div class="space-y-3 md:hidden">
                @foreach ($perBulan as $b)
                    <div class="rounded-lg border border-gray-200 p-3 dark:border-white/10">
                        <div class="mb-2 flex items-center justify-between">
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $b['label'] }}</span>
                            <span @class([
                                'text-sm font-semibold tabular-nums',
                                'text-success-600 dark:text-success-400' => $b['selisih'] >= 0,
                                'text-danger-600 dark:text-danger-400' => $b['selisih'] < 0,
                            ])>
                                {{ $b['selisih'] >= 0 ? '+' : '−' }}{{ number_format(abs($b['selisih']), 0, ',', '.') }}
                            </span>
                        </div>
                        <dl class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Masuk</dt>
                                <dd class="font-medium tabular-nums text-success-600 dark:text-success-400">
                                    {{ number_format($b['masuk'], 0, ',', '.') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Keluar</dt>
                                <dd class="font-medium tabular-nums text-danger-600 dark:text-danger-400">
                                    {{ number_format($b['keluar'], 0, ',', '.') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                @endforeach
            </div>
        @endif
    </x-filament::section>

    {{-- =========================================================
         LABA-RUGI PER SPK
         ========================================================= --}}
    <x-filament::section
        icon="heroicon-o-chart-bar-square"
        collapsible
    >
        <x-slot name="heading">Laba-Rugi per SPK</x-slot>
        <x-slot name="description">Penerimaan dikurangi biaya tiap SPK</x-slot>

        @if ($labaRugiSpk->isEmpty())
            <x-filament::empty-state
                icon="heroicon-o-document-text"
                heading="Belum ada SPK"
                description="Tambahkan SPK terlebih dahulu untuk melihat laba-rugi."
            />
        @else
            <div class="hidden overflow-x-auto lg:block">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-500 dark:border-white/10 dark:text-gray-400">
                            <th class="py-3 pr-3 font-semibold">SPK</th>
                            <th class="py-3 pr-3 text-right font-semibold">Nilai SPK</th>
                            <th class="py-3 pr-3 text-right font-semibold">Penerimaan</th>
                            <th class="py-3 pr-3 text-right font-semibold">Biaya</th>
                            <th class="py-3 pr-3 text-right font-semibold">Laba/Rugi</th>
                            <th class="py-3 text-right font-semibold">Piutang</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @foreach ($labaRugiSpk as $r)
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="py-3 pr-3">
                                    <div class="font-mono text-xs text-gray-700 dark:text-gray-300">{{ $r['nomor_spk'] }}</div>
                                    <div class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $r['pekerjaan'] }}
                                    </div>
                                </td>
                                <td class="py-3 pr-3 text-right tabular-nums text-gray-600 dark:text-gray-400">
                                    {{ number_format($r['nilai_spk'], 0, ',', '.') }}
                                </td>
                                <td class="py-3 pr-3 text-right tabular-nums text-success-600 dark:text-success-400">
                                    {{ number_format($r['penerimaan'], 0, ',', '.') }}
                                </td>
                                <td class="py-3 pr-3 text-right tabular-nums text-danger-600 dark:text-danger-400">
                                    {{ number_format($r['biaya'], 0, ',', '.') }}
                                </td>
                                <td @class([
                                    'py-3 pr-3 text-right font-semibold tabular-nums',
                                    'text-success-700 dark:text-success-400' => $r['laba'] >= 0,
                                    'text-danger-700 dark:text-danger-400' => $r['laba'] < 0,
                                ])>
                                    {{ $r['laba'] >= 0 ? '+' : '−' }}{{ number_format(abs($r['laba']), 0, ',', '.') }}
                                </td>
                                <td class="py-3 text-right tabular-nums text-warning-600 dark:text-warning-400">
                                    {{ number_format($r['piutang'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Kartu untuk layar kecil --}}
            <div class="space-y-3 lg:hidden">
                @foreach ($labaRugiSpk as $r)
                    <div class="rounded-lg border border-gray-200 p-3 dark:border-white/10">
                        <div class="font-mono text-xs text-gray-500 dark:text-gray-400">{{ $r['nomor_spk'] }}</div>
                        <div class="mt-0.5 text-sm font-medium text-gray-900 dark:text-white">{{ $r['pekerjaan'] }}</div>
                        <dl class="mt-2 grid grid-cols-2 gap-x-3 gap-y-2 text-xs">
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Nilai SPK</dt>
                                <dd class="tabular-nums text-gray-700 dark:text-gray-300">{{ number_format($r['nilai_spk'], 0, ',', '.') }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Penerimaan</dt>
                                <dd class="tabular-nums text-success-600 dark:text-success-400">{{ number_format($r['penerimaan'], 0, ',', '.') }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Biaya</dt>
                                <dd class="tabular-nums text-danger-600 dark:text-danger-400">{{ number_format($r['biaya'], 0, ',', '.') }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Piutang</dt>
                                <dd class="tabular-nums text-warning-600 dark:text-warning-400">{{ number_format($r['piutang'], 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                        <div class="mt-2 flex items-center justify-between border-t border-gray-100 pt-2 dark:border-white/10">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Laba/Rugi</span>
                            <span @class([
                                'text-sm font-bold tabular-nums',
                                'text-success-600 dark:text-success-400' => $r['laba'] >= 0,
                                'text-danger-600 dark:text-danger-400' => $r['laba'] < 0,
                            ])>
                                {{ $r['laba'] >= 0 ? '+' : '−' }}{{ number_format(abs($r['laba']), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-filament::section>

    {{-- =========================================================
         PENGELUARAN PER KATEGORI
         ========================================================= --}}
    <x-filament::section
        icon="heroicon-o-tag"
        collapsible
        collapsed
    >
        <x-slot name="heading">Pengeluaran per Kategori</x-slot>
        <x-slot name="description">Kategori konsisten karena divalidasi PHP Enum</x-slot>

        @php $maksKategori = max(1, (float) ($perKategori->max('total') ?? 1)); @endphp

        @if ($perKategori->isEmpty())
            <x-filament::empty-state
                icon="heroicon-o-inbox"
                heading="Belum ada pengeluaran"
                description="Tidak ada pengeluaran pada periode yang dipilih."
            />
        @else
            <div class="space-y-4">
                @foreach ($perKategori as $k)
                    @php
                        $kategori = $k->kategori;
                        $labelKategori = $kategori instanceof KategoriPengeluaran
                            ? $kategori->label()
                            : ($kategori ?: 'Tanpa kategori');
                        $persen = round((float) $k->total / $maksKategori * 100, 2);
                    @endphp
                    <div>
                        <div class="mb-1.5 flex items-baseline justify-between gap-3 text-sm">
                            <span class="font-medium text-gray-700 dark:text-gray-300">
                                {{ $labelKategori }}
                                <span class="ml-1 text-xs font-normal text-gray-400">({{ $k->jumlah_transaksi }}×)</span>
                            </span>
                            <span class="shrink-0 font-semibold tabular-nums text-gray-900 dark:text-white">
                                {{ number_format((float) $k->total, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="h-2 overflow-hidden rounded-full bg-gray-100 dark:bg-white/10">
                            <div class="h-full rounded-full bg-gradient-to-r from-danger-400 to-danger-600"
                                 style="width: {{ $persen }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-filament::section>

    {{-- =========================================================
         PIUTANG SPK
         ========================================================= --}}
    <x-filament::section
        icon="heroicon-o-clock"
        collapsible
        collapsed
    >
        <x-slot name="heading">Piutang SPK</x-slot>
        <x-slot name="description">SPK yang penerimaannya masih kurang dari nilai SPK</x-slot>

        @if ($piutang->isEmpty())
            <x-filament::empty-state
                icon="heroicon-o-check-circle"
                heading="Tidak ada piutang"
                description="Semua SPK sudah lunas."
            />
        @else
            <div class="hidden overflow-x-auto sm:block">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-500 dark:border-white/10 dark:text-gray-400">
                            <th class="py-3 pr-3 font-semibold">SPK</th>
                            <th class="py-3 pr-3 font-semibold">Status Tagihan</th>
                            <th class="py-3 pr-3 text-right font-semibold">Nilai SPK</th>
                            <th class="py-3 pr-3 text-right font-semibold">Diterima</th>
                            <th class="py-3 text-right font-semibold">Sisa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @foreach ($piutang as $r)
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="py-3 pr-3">
                                    <div class="font-mono text-xs text-gray-700 dark:text-gray-300">{{ $r['nomor_spk'] }}</div>
                                    <div class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">{{ $r['pekerjaan'] }}</div>
                                </td>
                                <td class="py-3 pr-3">
                                    <x-filament::badge color="gray" size="sm">{{ $r['status_tagihan'] }}</x-filament::badge>
                                </td>
                                <td class="py-3 pr-3 text-right tabular-nums text-gray-600 dark:text-gray-400">
                                    {{ number_format($r['nilai_spk'], 0, ',', '.') }}
                                </td>
                                <td class="py-3 pr-3 text-right tabular-nums text-success-600 dark:text-success-400">
                                    {{ number_format($r['diterima'], 0, ',', '.') }}
                                </td>
                                <td class="py-3 text-right font-semibold tabular-nums text-warning-700 dark:text-warning-400">
                                    {{ number_format($r['sisa'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Kartu untuk layar kecil --}}
            <div class="space-y-3 sm:hidden">
                @foreach ($piutang as $r)
                    <div class="rounded-lg border border-gray-200 p-3 dark:border-white/10">
                        <div class="font-mono text-xs text-gray-500 dark:text-gray-400">{{ $r['nomor_spk'] }}</div>
                        <div class="mt-0.5 text-sm font-medium text-gray-900 dark:text-white">{{ $r['pekerjaan'] }}</div>
                        <div class="mt-2">
                            <x-filament::badge color="gray" size="sm">{{ $r['status_tagihan'] }}</x-filament::badge>
                        </div>
                        <dl class="mt-2 grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Nilai SPK</dt>
                                <dd class="tabular-nums text-gray-700 dark:text-gray-300">{{ number_format($r['nilai_spk'], 0, ',', '.') }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Diterima</dt>
                                <dd class="tabular-nums text-success-600 dark:text-success-400">{{ number_format($r['diterima'], 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                        <div class="mt-2 flex items-center justify-between border-t border-gray-100 pt-2 dark:border-white/10">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Sisa</span>
                            <span class="text-sm font-bold tabular-nums text-warning-700 dark:text-warning-400">
                                {{ number_format($r['sisa'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-filament::section>

</x-filament-panels::page>
