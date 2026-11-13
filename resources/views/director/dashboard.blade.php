{{--
    Dashboard Direktur - TailAdmin Harmonized Design
--}}
@use('App\Support\Format')
@php
    $nadaKpi = [
        'netral' => 'text-gray-900 dark:text-white',
        'aman' => 'text-success-700 dark:text-success-500',
        'perhatian' => 'text-warning-700 dark:text-warning-500',
        'bahaya' => 'text-error-600 dark:text-error-400 dark:text-error-500',
    ];

    $trenLabels = array_map(fn($t) => $t['label'], $data['tren'] ?? []);
    $trenMasuk = array_map(fn($t) => (float) $t['masuk'], $data['tren'] ?? []);
    $trenKeluar = array_map(fn($t) => (float) $t['keluar'], $data['tren'] ?? []);

    $tagihanLabels = array_map(fn($t) => $t['label'], $data['sebaranTagihan'] ?? []);
    $tagihanJumlah = array_map(fn($t) => (int) $t['jumlah'], $data['sebaranTagihan'] ?? []);
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <x-common.antrean-ocr />


    {{-- Baris 1: 4 KPI Cards (TailAdmin Grid Seragam dengan Ikon Aksen) --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-4">
        @foreach ($data['kpi'] as $idx => $kpi)
            @php
                $aksenIkon = match ($idx) {
                    0 => ['bg' => 'bg-brand-50 dark:bg-brand-500/10', 'text' => 'text-brand-600 dark:text-brand-400', 'svg' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    1 => ['bg' => 'bg-warning-50 dark:bg-warning-500/10', 'text' => 'text-warning-700 dark:text-warning-400', 'svg' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    2 => ['bg' => 'bg-success-50 dark:bg-success-500/10', 'text' => 'text-success-600 dark:text-success-400', 'svg' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    default => ['bg' => 'bg-purple-50 dark:bg-purple-500/10', 'text' => 'text-purple-600 dark:text-purple-400', 'svg' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                };
            @endphp
            <div class="min-w-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        {{ $kpi['label'] }}
                    </span>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl {{ $aksenIkon['bg'] }} {{ $aksenIkon['text'] }} shadow-theme-xs">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $aksenIkon['svg'] }}" />
                        </svg>
                    </span>
                </div>
                <div class="mt-4">
                    <h4 class="break-words text-xl font-bold angka sm:text-2xl {{ $nadaKpi[$kpi['nada']] ?? $nadaKpi['netral'] }}">
                        {{ $kpi['nilai'] }}
                    </h4>
                    <span class="mt-1 block text-theme-xs text-gray-500 dark:text-gray-400">
                        {{ $kpi['ket'] }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Baris 2: Ringkasan Arus Kas Bulan Ini & Realisasi Penagihan Kontrak --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-12 items-stretch">
        {{-- Ringkasan Bulan Ini (7 grid) --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs xl:col-span-7 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Arus Kas Bulan Ini</h3>
                        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">Mutasi penerimaan & pengeluaran bulan berjalan</p>
                    </div>
                    <span class="text-theme-xs text-gray-500 dark:text-gray-400">{{ now()->translatedFormat('F Y') }}</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800">
                        <span class="text-theme-xs text-gray-500 dark:text-gray-400">Uang Masuk Bulan Ini</span>
                        <h4 class="mt-1 break-words text-xl font-bold text-gray-900 dark:text-white angka">
                            {{ Format::rupiah($data['bulanIni']['masuk']) }}
                        </h4>
                        <p class="mt-0.5 text-theme-xs {{ $data['bulanIni']['bandingMasuk']['arah'] === 'turun' ? 'text-error-600 dark:text-error-400' : 'text-success-700 dark:text-success-400' }}">
                            {{ $data['bulanIni']['bandingMasuk']['teks'] }}
                        </p>
                    </div>
                    <div class="p-4 rounded-xl bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800">
                        <span class="text-theme-xs text-gray-500 dark:text-gray-400">Uang Keluar Bulan Ini</span>
                        <h4 class="mt-1 break-words text-xl font-bold text-gray-900 dark:text-white angka">
                            {{ Format::rupiah($data['bulanIni']['keluar']) }}
                        </h4>
                        <p class="mt-0.5 text-theme-xs {{ $data['bulanIni']['bandingKeluar']['arah'] === 'naik' ? 'text-warning-700 dark:text-warning-400' : 'text-gray-500 dark:text-gray-400' }}">
                            {{ $data['bulanIni']['bandingKeluar']['teks'] }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 flex flex-wrap items-center justify-between gap-2 text-xs text-gray-500 dark:text-gray-400">
                <span>Mutasi Hari Ini ({{ now()->format('d/m/Y') }}):</span>
                <div class="flex items-center gap-3 angka">
                    <span class="font-semibold text-success-700 dark:text-success-400">+ {{ Format::rupiah($data['hariIni']['masuk'] ?? 0) }}</span>
                    <span>&middot;</span>
                    <span class="font-semibold text-error-600 dark:text-error-400">&minus; {{ Format::rupiah($data['hariIni']['keluar'] ?? 0) }}</span>
                </div>
            </div>
        </div>

        {{-- Progres Realisasi Penagihan Kontrak & Pintasan Eksekutif (5 grid) --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs xl:col-span-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Realisasi Penerimaan SPK</h3>
                        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">Pencairan termin terhadap nilai kontrak</p>
                    </div>
                    <span class="rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 angka">
                        {{ $data['tertagih']['persen'] ?? 0 }}%
                    </span>
                </div>

                <div class="h-2.5 w-full rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden mb-3">
                    <div class="h-full rounded-full bg-brand-500 transition-all duration-500"
                        style="width: {{ min(100, (float) ($data['tertagih']['persen'] ?? 0)) }}%"></div>
                </div>

                <div class="grid grid-cols-2 gap-2 rounded-xl bg-gray-50/80 p-3 dark:bg-gray-800/60 border border-gray-100 dark:border-gray-800 text-xs">
                    <div>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400 block">Sudah Diterima</span>
                        <span class="font-bold text-success-700 dark:text-success-400 angka">
                            {{ Format::rupiah($data['tertagih']['diterima'] ?? 0) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400 block">Total Nilai SPK</span>
                        <span class="font-bold text-gray-900 dark:text-white angka">
                            {{ Format::rupiah($data['tertagih']['nilai'] ?? 0) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-2 gap-2.5">
                <a href="{{ route('panel.reports') }}"
                    class="inline-flex items-center justify-center font-medium gap-1.5 rounded-xl transition px-3.5 py-2 text-xs bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600">
                    Laporan Keuangan
                </a>
                <a href="{{ route('panel.users.index') }}"
                    class="inline-flex items-center justify-center font-medium gap-1.5 rounded-xl transition px-3.5 py-2 text-xs bg-white text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700 dark:hover:bg-gray-700">
                    Manajemen Akun
                </a>
            </div>
        </div>
    </div>

    {{-- Baris 3: Grafik Analisis (ApexCharts) --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-12">
        {{-- Arus Kas 6 Bulan (ApexCharts) --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs xl:col-span-8">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Arus Kas 6 Bulan</h3>
                    <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                        Perbandingan uang masuk vs keluar 6 bulan terakhir
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

            <div id="chartArusKasDirektur" class="w-full h-[290px]"></div>
        </div>

        {{-- Tahapan Tagihan SPK & Realisasi --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs xl:col-span-4 flex flex-col justify-between">
            <div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Tahapan Tagihan SPK</h3>
                <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">Sebaran status penagihan saat ini</p>
                <div id="chartTagihanDirektur" class="w-full flex items-center justify-center my-4 min-h-[220px]"></div>
            </div>

            <div class="space-y-2 pt-3 border-t border-gray-100 dark:border-gray-800 text-theme-xs">
                @foreach (array_filter($data['sebaranTagihan'], fn($t) => $t['jumlah'] > 0) as $tagihan)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-400">{{ $tagihan['label'] }}</span>
                        <span class="font-bold text-gray-900 dark:text-white angka">{{ $tagihan['jumlah'] }} SPK ({{ $tagihan['persen'] }}%)</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Baris 4: SPK Prioritas Pantauan (TailAdmin Table) --}}
    <div class="mt-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 shadow-theme-xs overflow-hidden">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 px-5 py-4 dark:border-gray-800">
            <div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">SPK Prioritas Pantauan</h3>
                <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                    Diurutkan dari yang telah melewati tenggat, disusul sisa piutang terbesar
                </p>
            </div>
            <a href="{{ route('panel.spk.index') }}"
                class="text-theme-xs font-semibold text-brand-500 hover:text-brand-600 dark:text-brand-400">
                Lihat Semua SPK
            </a>
        </div>

        @if ($data['spkPrioritas'] === [])
            <div class="p-8 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                Semua SPK sudah lunas. Tidak ada tagihan tertunda.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[720px] text-left">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-white/[0.02]">
                            <th class="px-5 py-3 text-start font-medium text-gray-500 text-theme-xs uppercase tracking-wider dark:text-gray-400">SPK / Pekerjaan</th>
                            <th class="px-4 py-3 text-start font-medium text-gray-500 text-theme-xs uppercase tracking-wider dark:text-gray-400">Mitra</th>
                            <th class="px-4 py-3 text-end font-medium text-gray-500 text-theme-xs uppercase tracking-wider dark:text-gray-400">Nilai Kontrak</th>
                            <th class="px-4 py-3 text-end font-medium text-gray-500 text-theme-xs uppercase tracking-wider dark:text-gray-400">Sisa Piutang</th>
                            <th class="px-4 py-3 text-start font-medium text-gray-500 text-theme-xs uppercase tracking-wider dark:text-gray-400">Tenggat</th>
                            <th class="px-5 py-3 text-start font-medium text-gray-500 text-theme-xs uppercase tracking-wider dark:text-gray-400">Status Tagihan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($data['spkPrioritas'] as $spk)
                            <tr class="hover:bg-gray-50/60 dark:hover:bg-white/[0.02] transition-colors">
                                <td class="px-5 py-4">
                                    <a href="{{ route('panel.spk.show', $spk['id']) }}" class="block group">
                                        <span class="font-semibold text-theme-sm text-gray-900 dark:text-white group-hover:text-brand-500">
                                            {{ $spk['nomor_spk'] }}
                                        </span>
                                        <span class="block truncate text-theme-xs text-gray-500 dark:text-gray-400 max-w-xs">
                                            {{ $spk['pekerjaan'] }}
                                        </span>
                                    </a>
                                </td>
                                <td class="px-4 py-4 text-theme-sm text-gray-700 dark:text-gray-300 font-medium">
                                    {{ $spk['mitra'] }}
                                </td>
                                <td class="px-4 py-4 text-end text-theme-sm text-gray-700 dark:text-gray-300 angka font-medium">
                                    {{ Format::rupiah($spk['nilai']) }}
                                </td>
                                <td class="px-4 py-4 text-end text-theme-sm font-bold text-gray-900 dark:text-white angka">
                                    {{ Format::rupiah($spk['sisa']) }}
                                </td>
                                <td class="px-4 py-4 text-theme-sm">
                                    <span class="block text-gray-700 dark:text-gray-300 font-medium">{{ $spk['tenggat'] }}</span>
                                    <span class="block text-theme-xs {{ $spk['lewat'] ? 'font-semibold text-error-600 dark:text-error-400' : 'text-gray-500 dark:text-gray-400' }}">
                                        {{ $spk['label_tenggat'] }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                                        {{ $spk['status_tagihan'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        (function() {
            const isDark = () => document.documentElement.classList.contains('dark');
            let chartArusKas = null, chartTagihan = null;

            function initDirekturCharts() {
                if (typeof window.ApexCharts === 'undefined') return;

                // Chart Arus Kas Direktur
                const elArusKas = document.querySelector('#chartArusKasDirektur');
                if (elArusKas && !elArusKas.dataset.rendered) {
                    elArusKas.dataset.rendered = 'true';
                    const optionsArusKas = {
                        series: [
                            { name: 'Uang Masuk', data: @json($trenMasuk) },
                            { name: 'Uang Keluar', data: @json($trenKeluar) }
                        ],
                        colors: ['#465fff', '#f04438'],
                        theme: { mode: isDark() ? 'dark' : 'light' },
                        chart: {
                            background: 'transparent',
                            fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif",
                            type: 'area',
                            height: 290,
                            toolbar: { show: false }
                        },
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 3 },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.45,
                                opacityTo: 0.05,
                                stops: [20, 100]
                            }
                        },
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
                        grid: { borderColor: isDark() ? '#1F2A37' : '#E5E7EB', yaxis: { lines: { show: true } } },
                        tooltip: {
                            theme: isDark() ? 'dark' : 'light',
                            y: {
                                formatter: function(val) {
                                    return 'Rp ' + val.toLocaleString('id-ID');
                                }
                            }
                        }
                    };
                    chartArusKas = new window.ApexCharts(elArusKas, optionsArusKas);
                    chartArusKas.render();
                }

                // Chart Sebaran Tagihan Direktur
                const elTagihan = document.querySelector('#chartTagihanDirektur');
                if (elTagihan && !elTagihan.dataset.rendered) {
                    elTagihan.dataset.rendered = 'true';
                    const optionsTagihan = {
                        series: @json($tagihanJumlah),
                        labels: @json($tagihanLabels),
                        colors: ['#465fff', '#7a5af8', '#f79009', '#0ba5ec', '#12b76a'],
                        theme: { mode: isDark() ? 'dark' : 'light' },
                        stroke: { colors: [isDark() ? '#111827' : '#ffffff'], width: 2 },
                        chart: {
                            background: 'transparent',
                            fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif",
                            type: 'donut',
                            height: 230
                        },
                        dataLabels: { enabled: false },
                        legend: { show: false },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '72%',
                                    labels: {
                                        show: true,
                                        value: {
                                            color: isDark() ? '#F8FAFC' : '#1D2939',
                                            fontSize: '22px',
                                            fontWeight: 700
                                        },
                                        total: {
                                            show: true,
                                            label: 'Tagihan',
                                            color: isDark() ? '#98A2B3' : '#64748B',
                                            fontSize: '12px',
                                            fontWeight: 600,
                                            formatter: function(w) {
                                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    };
                    chartTagihan = new window.ApexCharts(elTagihan, optionsTagihan);
                    chartTagihan.render();
                }
            }

            function syncTema() {
                const d = isDark();
                chartTagihan?.updateOptions({
                    theme: { mode: d ? 'dark' : 'light' },
                    stroke: { colors: [d ? '#111827' : '#ffffff'], width: 2 },
                    plotOptions: { pie: { donut: { labels: {
                        value: { color: d ? '#F8FAFC' : '#1D2939' },
                        total: { color: d ? '#98A2B3' : '#64748B' }
                    } } } }
                });
                chartArusKas?.updateOptions({
                    theme: { mode: d ? 'dark' : 'light' },
                    grid: { borderColor: d ? '#1F2A37' : '#E5E7EB' },
                    tooltip: { theme: d ? 'dark' : 'light' }
                });
            }
            new MutationObserver(syncTema).observe(document.documentElement, {
                attributes: true, attributeFilter: ['class', 'data-color-scheme']
            });

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initDirekturCharts);
            } else {
                initDirekturCharts();
            }
        })();
    </script>
    @endpush

</x-layouts.app>
