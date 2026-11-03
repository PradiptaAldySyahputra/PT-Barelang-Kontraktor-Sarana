{{--
    Dashboard Admin (operasional) - TailAdmin Harmonized Design
--}}
@use('App\Support\Format')
@php
    $nadaKpi = [
        'netral' => 'text-gray-900 dark:text-white',
        'aman' => 'text-success-600 dark:text-success-500',
        'perhatian' => 'text-warning-600 dark:text-warning-500',
        'bahaya' => 'text-error-600 dark:text-error-500',
    ];

    $trenLabels = array_map(fn($t) => $t['label'], $data['tren'] ?? []);
    $trenMasuk = array_map(fn($t) => (float) $t['masuk'], $data['tren'] ?? []);
    $trenKeluar = array_map(fn($t) => (float) $t['keluar'], $data['tren'] ?? []);

    $spkLabels = array_map(fn($s) => $s['label'], $data['sebaranSpk'] ?? []);
    $spkJumlah = array_map(fn($s) => (int) $s['jumlah'], $data['sebaranSpk'] ?? []);
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">

    {{-- Baris 1: 4 Stat KPI Cards (Grid TailAdmin Seragam) --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-4">
        {{-- Card 1: Saldo Kas --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs">
            <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                Saldo Kas
            </span>
            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white angka">
                        {{ Format::rupiah($data['saldo']['kas']) }}
                    </h4>
                    <span class="mt-1 block text-theme-xs text-gray-500 dark:text-gray-400">
                        Penerimaan tunai fisik
                    </span>
                </div>
            </div>
        </div>

        {{-- Card 2: Saldo Bank --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs">
            <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                Saldo Bank
            </span>
            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white angka">
                        {{ Format::rupiah($data['saldo']['bank']) }}
                    </h4>
                    <span class="mt-1 block text-theme-xs text-gray-500 dark:text-gray-400">
                        Rekening operasional
                    </span>
                </div>
            </div>
        </div>

        {{-- Card 3: Total Saldo Siap Pakai --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs">
            <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                Total Saldo Siap Pakai
            </span>
            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-2xl font-bold angka {{ $data['saldo']['total'] < 0 ? 'text-error-600 dark:text-error-500' : 'text-brand-500 dark:text-brand-400' }}">
                        {{ Format::rupiah($data['saldo']['total']) }}
                    </h4>
                    <span class="mt-1 block text-theme-xs text-gray-500 dark:text-gray-400">
                        Kas + Bank terverifikasi
                    </span>
                </div>
            </div>
        </div>

        {{-- Card 4: SPK Berjalan Aktif --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs">
            <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                SPK Berjalan Aktif
            </span>
            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white angka">
                        {{ $data['spkBerjalanCount'] }} SPK
                    </h4>
                    <span class="mt-1 block text-theme-xs text-gray-500 dark:text-gray-400">
                        Pekerjaan sedang berlangsung
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Baris 2: Ringkasan Bulan Ini & Aksi Cepat Operasional --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-12 items-stretch">
        {{-- Ringkasan Kas Bulan Ini --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs xl:col-span-7">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Arus Kas Bulan Ini</h3>
                <span class="text-theme-xs text-gray-400">{{ now()->translatedFormat('F Y') }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 rounded-xl bg-success-50/50 dark:bg-success-500/5 border border-success-100 dark:border-success-500/10">
                    <span class="text-theme-xs text-gray-500 dark:text-gray-400">Masuk ({{ $data['bulanIni']['jumlahMasuk'] }} transaksi)</span>
                    <p class="mt-1 text-xl font-bold text-success-600 dark:text-success-400 angka">
                        {{ Format::rupiah($data['bulanIni']['masuk']) }}
                    </p>
                </div>
                <div class="p-4 rounded-xl bg-error-50/50 dark:bg-error-500/5 border border-error-100 dark:border-error-500/10">
                    <span class="text-theme-xs text-gray-500 dark:text-gray-400">Keluar ({{ $data['bulanIni']['jumlahKeluar'] }} transaksi)</span>
                    <p class="mt-1 text-xl font-bold text-error-600 dark:text-error-400 angka">
                        {{ Format::rupiah($data['bulanIni']['keluar']) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Aksi Cepat Input & Mutasi Kas Hari Ini --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs xl:col-span-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Aksi Cepat Operasional</h3>
                        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">Pintasan pencatatan transaksi & berkas</p>
                    </div>
                    <span class="rounded-full bg-brand-50 px-2 py-0.5 text-[10px] font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                        Hari Ini
                    </span>
                </div>

                {{-- Baris Mini Mutasi Hari Ini --}}
                <div class="mb-4 grid grid-cols-2 gap-2 rounded-xl bg-gray-50/80 p-2.5 dark:bg-gray-800/60 border border-gray-100 dark:border-gray-800 text-xs">
                    <div>
                        <span class="text-[11px] text-gray-400 block">Masuk Hari Ini</span>
                        <span class="font-bold text-success-600 dark:text-success-400 angka">
                            {{ Format::rupiah($data['hariIni']['masuk'] ?? 0) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-[11px] text-gray-400 block">Keluar Hari Ini</span>
                        <span class="font-bold text-error-600 dark:text-error-400 angka">
                            {{ Format::rupiah($data['hariIni']['keluar'] ?? 0) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                <a href="{{ route('panel.spk.create') }}"
                    class="inline-flex items-center justify-center font-medium gap-2 rounded-xl transition px-3.5 py-2 text-xs bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    SPK Baru
                </a>
                <a href="{{ route('panel.cash-in.create') }}"
                    class="inline-flex items-center justify-center font-medium gap-2 rounded-xl transition px-3.5 py-2 text-xs bg-white text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700 dark:hover:bg-gray-700">
                    <svg class="h-4 w-4 text-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>
                    Uang Masuk
                </a>
                <a href="{{ route('panel.cash-out.create') }}"
                    class="inline-flex items-center justify-center font-medium gap-2 rounded-xl transition px-3.5 py-2 text-xs bg-white text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700 dark:hover:bg-gray-700">
                    <svg class="h-4 w-4 text-error-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                    </svg>
                    Uang Keluar
                </a>
                <a href="{{ route('panel.receipts.upload') }}"
                    class="inline-flex items-center justify-center font-medium gap-2 rounded-xl transition px-3.5 py-2 text-xs bg-white text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700 dark:hover:bg-gray-700">
                    <svg class="h-4 w-4 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                    </svg>
                    Unggah Nota
                </a>
            </div>
        </div>
    </div>

    {{-- Baris 3: Grafik Analisis (ApexCharts) --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-12 items-stretch">
        {{-- Chart 1: Arus Kas 6 Bulan --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs xl:col-span-8">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Grafik Arus Kas Operasional</h3>
                    <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                        Perbandingan uang masuk vs uang keluar 6 bulan terakhir
                    </p>
                </div>
                <div class="flex items-center gap-4 text-theme-xs">
                    <span class="flex items-center gap-1.5 font-medium text-gray-700 dark:text-gray-300">
                        <span class="h-3 w-3 rounded-full bg-brand-500"></span> Masuk
                    </span>
                    <span class="flex items-center gap-1.5 font-medium text-gray-700 dark:text-gray-300">
                        <span class="h-3 w-3 rounded-full bg-error-500"></span> Keluar
                    </span>
                </div>
            </div>

            <div id="chartArusKasAdmin" class="w-full h-[290px]"></div>
        </div>

        {{-- Chart 2: Komposisi Status SPK --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs xl:col-span-4 flex flex-col justify-between">
            <div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Sebaran Status SPK</h3>
                <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                    Distribusi seluruh SPK dalam sistem
                </p>
                <div id="chartStatusSpkAdmin" class="w-full flex items-center justify-center my-4 min-h-[220px]"></div>
            </div>

            <div class="space-y-2 pt-3 border-t border-gray-100 dark:border-gray-800 text-theme-xs">
                @foreach ($data['sebaranSpk'] as $st)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-400">{{ $st['label'] }}</span>
                        <span class="font-bold text-gray-900 dark:text-white angka">{{ $st['jumlah'] }} SPK ({{ $st['persen'] }}%)</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Baris 4: Dua Kolom Operasional (Transaksi Terbaru & SPK Berjalan) --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-2 items-stretch">

        {{-- Transaksi Terbaru --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 shadow-theme-xs overflow-hidden flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Transaksi Terbaru</h3>
                    <a href="{{ route('panel.reports') }}" class="text-theme-xs font-semibold text-brand-500 hover:text-brand-600 dark:text-brand-400">
                        Lihat Semua &rarr;
                    </a>
                </div>

                @if ($data['terbaru'] === [])
                    <div class="p-8 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                        Belum ada transaksi tercatat.
                    </div>
                @else
                    <div class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($data['terbaru'] as $trx)
                            <div class="flex items-center gap-3.5 px-5 py-3 hover:bg-gray-50/60 dark:hover:bg-white/[0.02] transition-colors">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $trx['jenis'] === 'masuk' ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-400' : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-400' }}">
                                    @if ($trx['jenis'] === 'masuk')
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    @else
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                        </svg>
                                    @endif
                                </span>

                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-xs font-semibold text-gray-800 dark:text-white/90">
                                        {{ $trx['label'] }}
                                    </p>
                                    <p class="truncate text-[11px] text-gray-500 dark:text-gray-400">
                                        {{ $trx['keterangan'] ?: '—' }} &middot; {{ $trx['tanggal']?->format('d/m/Y') }}
                                    </p>
                                </div>

                                <div class="text-right shrink-0">
                                    <p class="text-xs font-bold angka {{ $trx['jenis'] === 'masuk' ? 'text-success-600 dark:text-success-400' : 'text-error-600 dark:text-error-400' }}">
                                        {{ $trx['jenis'] === 'masuk' ? '+' : '−' }} {{ Format::rupiah($trx['jumlah']) }}
                                    </p>
                                    <span class="text-[10px] uppercase tracking-wider text-gray-400">
                                        {{ $trx['jenis'] === 'masuk' ? 'MASUK' : 'KELUAR' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Kolom Kanan: SPK Berjalan --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 shadow-theme-xs overflow-hidden flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">SPK Berjalan</h3>
                    <a href="{{ route('panel.spk.index') }}" class="text-theme-xs font-semibold text-brand-500 hover:text-brand-600 dark:text-brand-400">
                        Lihat Semua &rarr;
                    </a>
                </div>

                @if ($data['spkBerjalan'] === [])
                    <div class="p-8 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                        Tidak ada SPK aktif saat ini.
                    </div>
                @else
                    <div class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($data['spkBerjalan'] as $spk)
                            <div class="flex items-center justify-between gap-4 px-5 py-3 hover:bg-gray-50/60 dark:hover:bg-white/[0.02] transition-colors">
                                <div class="min-w-0 flex-1">
                                    <a href="{{ route('panel.spk.show', $spk['id']) }}"
                                        class="truncate text-xs font-semibold text-brand-600 hover:underline dark:text-brand-400 block">
                                        {{ $spk['nomor_spk'] }}
                                    </a>
                                    <p class="truncate text-[11px] text-gray-500 dark:text-gray-400">
                                        {{ $spk['mitra'] }} &middot; {{ $spk['pekerjaan'] }}
                                    </p>
                                </div>

                                <div class="text-right shrink-0">
                                    <p class="text-xs font-bold text-gray-900 dark:text-white angka">
                                        {{ Format::rupiah($spk['nilai']) }}
                                    </p>
                                    <span class="text-[10px] {{ $spk['lewat'] ? 'text-error-600 dark:text-error-400 font-semibold' : 'text-gray-400' }}">
                                        {{ $spk['label_tenggat'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        (function() {
            function initAdminCharts() {
                if (typeof window.ApexCharts === 'undefined') return;

                // Chart Arus Kas Admin
                const elArusKas = document.querySelector('#chartArusKasAdmin');
                if (elArusKas && !elArusKas.dataset.rendered) {
                    elArusKas.dataset.rendered = 'true';
                    const optionsArusKas = {
                        series: [
                            { name: 'Uang Masuk', data: @json($trenMasuk) },
                            { name: 'Uang Keluar', data: @json($trenKeluar) }
                        ],
                        colors: ['#465fff', '#f04438'],
                        chart: {
                            fontFamily: 'Outfit, sans-serif',
                            type: 'bar',
                            height: 290,
                            toolbar: { show: false }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '40%',
                                borderRadius: 6,
                                borderRadiusApplication: 'end'
                            }
                        },
                        dataLabels: { enabled: false },
                        stroke: { show: true, width: 4, colors: ['transparent'] },
                        xaxis: {
                            categories: @json($trenLabels),
                            axisBorder: { show: false },
                            axisTicks: { show: false }
                        },
                        yaxis: {
                            labels: {
                                formatter: function(val) {
                                    if (val >= 1000000000) return 'Rp ' + (val / 1000000000).toFixed(1) + ' M';
                                    if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(0) + ' jt';
                                    return 'Rp ' + val.toLocaleString('id-ID');
                                }
                            }
                        },
                        legend: { show: false },
                        grid: { yaxis: { lines: { show: true } } },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return 'Rp ' + val.toLocaleString('id-ID');
                                }
                            }
                        }
                    };
                    new window.ApexCharts(elArusKas, optionsArusKas).render();
                }

                // Chart Sebaran Status SPK
                const elStatus = document.querySelector('#chartStatusSpkAdmin');
                if (elStatus && !elStatus.dataset.rendered) {
                    elStatus.dataset.rendered = 'true';
                    const optionsStatus = {
                        series: @json($spkJumlah),
                        labels: @json($spkLabels),
                        colors: ['#9cb9ff', '#465fff', '#f79009', '#12b76a', '#f04438'],
                        chart: {
                            fontFamily: 'Outfit, sans-serif',
                            type: 'donut',
                            height: 220
                        },
                        dataLabels: { enabled: false },
                        legend: { show: false },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '65%',
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            label: 'Total SPK',
                                            formatter: function(w) {
                                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    };
                    new window.ApexCharts(elStatus, optionsStatus).render();
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initAdminCharts);
            } else {
                initAdminCharts();
            }
        })();
    </script>
    @endpush

</x-layouts.app>
