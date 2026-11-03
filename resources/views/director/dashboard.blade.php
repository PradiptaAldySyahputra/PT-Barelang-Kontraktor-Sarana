{{--
    Dashboard Direktur - TailAdmin Harmonized Design
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

    $tagihanLabels = array_map(fn($t) => $t['label'], $data['sebaranTagihan'] ?? []);
    $tagihanJumlah = array_map(fn($t) => (int) $t['jumlah'], $data['sebaranTagihan'] ?? []);
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">

    {{-- Baris 1: 4 KPI Cards (TailAdmin Grid Seragam) --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-4">
        @foreach ($data['kpi'] as $kpi)
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs">
                <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    {{ $kpi['label'] }}
                </span>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-2xl font-bold angka {{ $nadaKpi[$kpi['nada']] ?? $nadaKpi['netral'] }}">
                            {{ $kpi['nilai'] }}
                        </h4>
                        <span class="mt-1 block text-theme-xs text-gray-500 dark:text-gray-400">
                            {{ $kpi['ket'] }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Baris 2: Ringkasan Arus Kas Bulan Ini --}}
    <div class="mt-6">
        {{-- Ringkasan Bulan Ini --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Arus Kas Bulan Ini</h3>
                <span class="text-theme-xs text-gray-400">{{ now()->translatedFormat('F Y') }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 rounded-xl bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800">
                    <span class="text-theme-xs text-gray-500 dark:text-gray-400">Uang Masuk Bulan Ini</span>
                    <h4 class="mt-1 text-xl font-bold text-gray-900 dark:text-white angka">
                        {{ Format::rupiah($data['bulanIni']['masuk']) }}
                    </h4>
                    <p class="mt-0.5 text-theme-xs {{ $data['bulanIni']['bandingMasuk']['arah'] === 'turun' ? 'text-error-600 dark:text-error-400' : 'text-success-600 dark:text-success-400' }}">
                        {{ $data['bulanIni']['bandingMasuk']['teks'] }}
                    </p>
                </div>
                <div class="p-4 rounded-xl bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800">
                    <span class="text-theme-xs text-gray-500 dark:text-gray-400">Uang Keluar Bulan Ini</span>
                    <h4 class="mt-1 text-xl font-bold text-gray-900 dark:text-white angka">
                        {{ Format::rupiah($data['bulanIni']['keluar']) }}
                    </h4>
                    <p class="mt-0.5 text-theme-xs {{ $data['bulanIni']['bandingKeluar']['arah'] === 'naik' ? 'text-warning-600 dark:text-warning-400' : 'text-gray-500 dark:text-gray-400' }}">
                        {{ $data['bulanIni']['bandingKeluar']['teks'] }}
                    </p>
                </div>
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
                @foreach ($data['sebaranTagihan'] as $tagihan)
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
                        chart: {
                            fontFamily: 'Outfit, sans-serif',
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

                // Chart Sebaran Tagihan Direktur
                const elTagihan = document.querySelector('#chartTagihanDirektur');
                if (elTagihan && !elTagihan.dataset.rendered) {
                    elTagihan.dataset.rendered = 'true';
                    const optionsTagihan = {
                        series: @json($tagihanJumlah),
                        labels: @json($tagihanLabels),
                        colors: ['#465fff', '#7a5af8', '#f79009', '#0ba5ec', '#12b76a'],
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
                                            label: 'Tagihan',
                                            formatter: function(w) {
                                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    };
                    new window.ApexCharts(elTagihan, optionsTagihan).render();
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initDirekturCharts);
            } else {
                initDirekturCharts();
            }
        })();
    </script>
    @endpush

</x-layouts.app>
