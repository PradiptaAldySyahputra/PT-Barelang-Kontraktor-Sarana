@php
    use App\Enums\KategoriPengeluaran;
@endphp

<x-filament-panels::page>

    {{-- ================= FILTER PERIODE + EKSPOR ================= --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        {{-- Periode --}}
        <div class="flex items-center gap-2">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Periode</span>
            <div class="inline-flex rounded-lg bg-gray-100 p-0.5 dark:bg-gray-800">
                @foreach ([1 => 'Bulan Ini', 3 => '3 Bulan', 12 => '12 Bulan', 0 => 'Semua'] as $nilai => $label)
                    <button
                        wire:click="setPeriode({{ $nilai }})"
                        @class([
                            'rounded-md px-3 py-1.5 text-sm font-medium transition',
                            'bg-white text-gray-900 shadow-sm dark:bg-gray-700 dark:text-white' => $periode === $nilai,
                            'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' => $periode !== $nilai,
                        ])
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Ekspor (dropdown) --}}
        <x-filament::dropdown placement="bottom-end">
            <x-slot name="trigger">
                <x-filament::button size="sm" color="gray" icon="heroicon-m-arrow-down-tray">
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
                        wire:click="ekspor('{{ $jenis }}')"
                        icon="heroicon-m-document-text"
                    >
                        {{ $label }}
                    </x-filament::dropdown.list.item>
                @endforeach
            </x-filament::dropdown.list>
        </x-filament::dropdown>
    </div>

    {{-- ================= RINGKASAN ================= --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Uang Masuk</div>
                    <div class="mt-1.5 text-xl font-semibold text-success-600 dark:text-success-400">
                        Rp {{ number_format($totalMasuk, 0, ',', '.') }}
                    </div>
                </div>
                <x-filament::icon icon="heroicon-o-arrow-trending-up"
                    class="h-5 w-5 text-success-500/70" />
            </div>
            <div class="mt-2 border-t border-gray-100 pt-2 text-xs text-gray-500 dark:border-white/5 dark:text-gray-400">
                Dari SPK <span class="font-medium text-gray-700 dark:text-gray-300">Rp {{ number_format($masukDariSpk, 0, ',', '.') }}</span>
                · Luar <span class="font-medium text-gray-700 dark:text-gray-300">Rp {{ number_format($masukLuarSpk, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Uang Keluar</div>
                    <div class="mt-1.5 text-xl font-semibold text-danger-600 dark:text-danger-400">
                        Rp {{ number_format($totalKeluar, 0, ',', '.') }}
                    </div>
                </div>
                <x-filament::icon icon="heroicon-o-arrow-trending-down"
                    class="h-5 w-5 text-danger-500/70" />
            </div>
            <div class="mt-2 border-t border-gray-100 pt-2 text-xs text-gray-500 dark:border-white/5 dark:text-gray-400">
                Tersebar di <span class="font-medium text-gray-700 dark:text-gray-300">{{ $perKategori->count() }} kategori</span>
            </div>
        </div>

        <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Saldo Bersih</div>
                    <div class="mt-1.5 text-xl font-semibold {{ $saldo >= 0 ? 'text-gray-900 dark:text-white' : 'text-danger-600 dark:text-danger-400' }}">
                        Rp {{ number_format($saldo, 0, ',', '.') }}
                    </div>
                </div>
                <x-filament::icon icon="heroicon-o-banknotes" class="h-5 w-5 text-gray-400" />
            </div>
            <div class="mt-2 border-t border-gray-100 pt-2 text-xs text-gray-500 dark:border-white/5 dark:text-gray-400">
                Uang masuk − uang keluar
            </div>
        </div>

        <div class="rounded-xl bg-warning-50 p-4 shadow-sm ring-1 ring-warning-200 dark:bg-warning-500/10 dark:ring-warning-500/30">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-xs font-medium uppercase tracking-wide text-warning-700 dark:text-warning-400">Total Piutang</div>
                    <div class="mt-1.5 text-xl font-semibold text-warning-900 dark:text-warning-300">
                        Rp {{ number_format($totalPiutang, 0, ',', '.') }}
                    </div>
                </div>
                <x-filament::icon icon="heroicon-o-clock" class="h-5 w-5 text-warning-500/70" />
            </div>
            <div class="mt-2 border-t border-warning-200/60 pt-2 text-xs text-warning-700 dark:border-warning-500/20 dark:text-warning-400">
                {{ $piutang->count() }} SPK belum lunas
            </div>
        </div>
    </div>

    {{-- ================= ARUS KAS PER BULAN ================= --}}
    <x-filament::section
        heading="Arus Kas per Bulan"
        description="Uang masuk, uang keluar, dan selisihnya"
        icon="heroicon-o-arrows-right-left"
        collapsible
    >
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-500 dark:border-white/10 dark:text-gray-400">
                        <th class="py-2.5 pr-4 font-medium">Bulan</th>
                        <th class="py-2.5 pr-4 text-center font-medium">Transaksi</th>
                        <th class="py-2.5 pr-4 text-right font-medium">Uang Masuk</th>
                        <th class="py-2.5 pr-4 text-right font-medium">Uang Keluar</th>
                        <th class="py-2.5 text-right font-medium">Selisih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($perBulan as $b)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                            <td class="py-2.5 pr-4 font-medium text-gray-900 dark:text-white">{{ $b['label'] }}</td>
                            <td class="py-2.5 pr-4 text-center">
                                <span class="inline-flex items-center gap-1.5 text-xs">
                                    <span class="rounded bg-success-50 px-1.5 py-0.5 font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                                        {{ $b['jumlah_masuk'] }} masuk
                                    </span>
                                    <span class="rounded bg-danger-50 px-1.5 py-0.5 font-medium text-danger-700 dark:bg-danger-500/10 dark:text-danger-400">
                                        {{ $b['jumlah_keluar'] }} keluar
                                    </span>
                                </span>
                            </td>
                            <td class="py-2.5 pr-4 text-right tabular-nums text-success-600 dark:text-success-400">
                                {{ number_format($b['masuk'], 0, ',', '.') }}
                            </td>
                            <td class="py-2.5 pr-4 text-right tabular-nums text-danger-600 dark:text-danger-400">
                                {{ number_format($b['keluar'], 0, ',', '.') }}
                            </td>
                            <td @class([
                                'py-2.5 text-right font-semibold tabular-nums',
                                'text-success-700 dark:text-success-400' => $b['selisih'] >= 0,
                                'text-danger-700 dark:text-danger-400' => $b['selisih'] < 0,
                            ])>
                                {{ $b['selisih'] >= 0 ? '+' : '−' }}{{ number_format(abs($b['selisih']), 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                Belum ada transaksi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>

    {{-- ================= PENGELUARAN PER KATEGORI ================= --}}
    <x-filament::section
        heading="Pengeluaran per Kategori"
        description="Kategori konsisten karena divalidasi PHP Enum"
        icon="heroicon-o-tag"
        collapsible
        collapsed
    >
        @php $maksKategori = max(1, (float) ($perKategori->max('total') ?? 1)); @endphp

        <div class="space-y-4">
            @forelse ($perKategori as $k)
                @php
                    $kategori = $k->kategori;
                    $labelKategori = $kategori instanceof KategoriPengeluaran
                        ? $kategori->label()
                        : ($kategori ?: 'Tanpa kategori');
                    $persen = round((float) $k->total / $maksKategori * 100, 2);
                @endphp
                <div>
                    <div class="mb-1.5 flex items-baseline justify-between text-sm">
                        <span class="font-medium text-gray-700 dark:text-gray-300">
                            {{ $labelKategori }}
                            <span class="ml-1 text-xs font-normal text-gray-400">{{ $k->jumlah_transaksi }}× transaksi</span>
                        </span>
                        <span class="font-semibold tabular-nums text-gray-900 dark:text-white">
                            Rp {{ number_format((float) $k->total, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="h-1.5 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                        <div class="h-full rounded-full bg-gradient-to-r from-danger-400 to-danger-600"
                             style="width: {{ $persen }}%"></div>
                    </div>
                </div>
            @empty
                <p class="py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                    Belum ada pengeluaran pada periode ini.
                </p>
            @endforelse
        </div>
    </x-filament::section>

    {{-- ================= LABA-RUGI PER SPK ================= --}}
    <x-filament::section
        heading="Laba-Rugi per SPK"
        description="Penerimaan dikurangi biaya tiap SPK"
        icon="heroicon-o-chart-bar-square"
        collapsible
    >
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-500 dark:border-white/10 dark:text-gray-400">
                        <th class="py-2.5 pr-3 font-medium">SPK</th>
                        <th class="py-2.5 pr-3 text-right font-medium">Nilai SPK</th>
                        <th class="py-2.5 pr-3 text-right font-medium">Penerimaan</th>
                        <th class="py-2.5 pr-3 text-right font-medium">Biaya</th>
                        <th class="py-2.5 pr-3 text-right font-medium">Laba/Rugi</th>
                        <th class="py-2.5 text-right font-medium">Piutang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($labaRugiSpk as $r)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                            <td class="py-2.5 pr-3">
                                <div class="font-mono text-xs text-gray-700 dark:text-gray-300">{{ $r['nomor_spk'] }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $r['pekerjaan'] }} · {{ $r['mitra'] ?? 'tanpa mitra' }}
                                </div>
                            </td>
                            <td class="py-2.5 pr-3 text-right tabular-nums text-gray-600 dark:text-gray-400">
                                {{ number_format($r['nilai_spk'], 0, ',', '.') }}
                            </td>
                            <td class="py-2.5 pr-3 text-right tabular-nums text-success-600 dark:text-success-400">
                                {{ number_format($r['penerimaan'], 0, ',', '.') }}
                            </td>
                            <td class="py-2.5 pr-3 text-right tabular-nums text-danger-600 dark:text-danger-400">
                                {{ number_format($r['biaya'], 0, ',', '.') }}
                            </td>
                            <td @class([
                                'py-2.5 pr-3 text-right font-semibold tabular-nums',
                                'text-success-700 dark:text-success-400' => $r['laba'] >= 0,
                                'text-danger-700 dark:text-danger-400' => $r['laba'] < 0,
                            ])>
                                {{ $r['laba'] >= 0 ? '+' : '−' }}{{ number_format(abs($r['laba']), 0, ',', '.') }}
                            </td>
                            <td class="py-2.5 text-right tabular-nums text-warning-600 dark:text-warning-400">
                                {{ number_format($r['piutang'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                Belum ada SPK.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>

    {{-- ================= PIUTANG ================= --}}
    <x-filament::section
        heading="Piutang SPK"
        description="SPK yang penerimaannya masih kurang dari nilai SPK"
        icon="heroicon-o-clock"
        collapsible
        collapsed
    >
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-500 dark:border-white/10 dark:text-gray-400">
                        <th class="py-2.5 pr-3 font-medium">SPK</th>
                        <th class="py-2.5 pr-3 font-medium">Status Tagihan</th>
                        <th class="py-2.5 pr-3 text-right font-medium">Nilai SPK</th>
                        <th class="py-2.5 pr-3 text-right font-medium">Diterima</th>
                        <th class="py-2.5 text-right font-medium">Sisa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($piutang as $r)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                            <td class="py-2.5 pr-3">
                                <div class="font-mono text-xs text-gray-700 dark:text-gray-300">{{ $r['nomor_spk'] }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $r['pekerjaan'] }} · {{ $r['mitra'] ?? 'tanpa mitra' }}
                                </div>
                            </td>
                            <td class="py-2.5 pr-3">
                                <x-filament::badge color="gray" size="sm">
                                    {{ $r['status_tagihan'] }}
                                </x-filament::badge>
                            </td>
                            <td class="py-2.5 pr-3 text-right tabular-nums text-gray-600 dark:text-gray-400">
                                {{ number_format($r['nilai_spk'], 0, ',', '.') }}
                            </td>
                            <td class="py-2.5 pr-3 text-right tabular-nums text-success-600 dark:text-success-400">
                                {{ number_format($r['diterima'], 0, ',', '.') }}
                            </td>
                            <td class="py-2.5 text-right font-semibold tabular-nums text-warning-700 dark:text-warning-400">
                                {{ number_format($r['sisa'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tidak ada piutang — semua SPK sudah lunas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>

</x-filament-panels::page>
