{{--
    Dashboard Admin (operasional) - TailAdmin Harmonized Design
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

    $spkLabels = array_map(fn($s) => $s['label'], $data['sebaranSpk'] ?? []);
    $spkJumlah = array_map(fn($s) => (int) $s['jumlah'], $data['sebaranSpk'] ?? []);
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <x-common.antrean-ocr />


    {{-- Baris 1: 4 Stat KPI Cards (Grid TailAdmin Seragam dengan Ikon Aksen) --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-4">
        {{-- Card 1: Saldo Kas --}}
        <div class="min-w-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    Saldo Kas
                </span>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-success-50 text-success-600 dark:bg-success-500/10 dark:text-success-400 shadow-theme-xs">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-4">
                <h4 class="break-words text-xl font-bold angka text-gray-900 dark:text-white sm:text-2xl">
                    {{ Format::rupiah($data['saldo']['kas']) }}
                </h4>
                <span class="mt-1 block text-theme-xs text-gray-500 dark:text-gray-400">
                    Penerimaan tunai fisik
                </span>
            </div>
        </div>

        {{-- Card 2: Saldo Bank --}}
        <div class="min-w-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    Saldo Bank
                </span>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 shadow-theme-xs">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </span>
            </div>
            <div class="mt-4">
                <h4 class="break-words text-xl font-bold angka text-gray-900 dark:text-white sm:text-2xl">
                    {{ Format::rupiah($data['saldo']['bank']) }}
                </h4>
                <span class="mt-1 block text-theme-xs text-gray-500 dark:text-gray-400">
                    Rekening operasional
                </span>
            </div>
        </div>

        {{-- Card 3: Total Saldo Siap Pakai --}}
        <div class="min-w-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    Total Saldo Siap Pakai
                </span>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-500/10 dark:text-purple-400 shadow-theme-xs">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-4">
                <h4 class="break-words text-xl font-bold angka sm:text-2xl {{ $data['saldo']['total'] < 0 ? 'text-error-600 dark:text-error-400 dark:text-error-500' : 'text-brand-600 dark:text-brand-400' }}">
                    {{ Format::rupiah($data['saldo']['total']) }}
                </h4>
                <span class="mt-1 block text-theme-xs text-gray-500 dark:text-gray-400">
                    Kas + Bank terverifikasi
                </span>
            </div>
        </div>

        {{-- Card 4: SPK Berjalan Aktif --}}
        <div class="min-w-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    SPK Berjalan Aktif
                </span>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 shadow-theme-xs">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
            </div>
            <div class="mt-4">
                <h4 class="break-words text-xl font-bold angka text-gray-900 dark:text-white sm:text-2xl">
                    {{ $data['spkBerjalanCount'] }} SPK
                </h4>
                <span class="mt-1 block text-theme-xs text-gray-500 dark:text-gray-400">
                    Pekerjaan sedang berlangsung
                </span>
            </div>
        </div>
    </div>

    {{-- Baris Antrean Tindakan Operasional (Actionable Task Pulse) --}}
    @if (($data['antrean'] ?? []) !== [])
        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
            @foreach ($data['antrean'] as $item)
                @php
                    $warnaBg = match ($item['nada']) {
                        'bahaya' => 'bg-error-50/70 border-error-200 dark:bg-error-500/10 dark:border-error-500/20 text-error-700 dark:text-error-400',
                        'perhatian' => 'bg-warning-50/70 border-warning-200 dark:bg-warning-500/10 dark:border-warning-500/20 text-warning-700 dark:text-warning-400',
                        default => 'bg-gray-50/80 border-gray-200 dark:bg-gray-800/60 dark:border-gray-800 text-gray-700 dark:text-gray-300',
                    };
                    $ruteTarget = match ($item['label']) {
                        'SPK belum ditagihkan' => route('panel.spk.monitoring', 'billing'),
                        'Mendekati tenggat' => route('panel.spk.calendar'),
                        'Lewat tenggat' => route('panel.spk.monitoring', 'status'),
                        default => route('panel.spk.index'),
                    };
                @endphp
                <a href="{{ $ruteTarget }}" class="flex items-center justify-between rounded-xl border p-4 transition-all hover:shadow-sm {{ $warnaBg }}">
                    <div>
                        <span class="text-theme-xs font-semibold block">{{ $item['label'] }}</span>
                        <span class="text-[11px] opacity-80 block mt-0.5">{{ $item['ket'] }}</span>
                    </div>
                    <span class="text-2xl font-bold angka">
                        {{ $item['jumlah'] }}
                    </span>
                </a>
            @endforeach
        </div>
    @endif

    {{-- Baris 2: Ringkasan Bulan Ini & Aksi Cepat Operasional --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-12 items-stretch">
        {{-- Ringkasan Kas Bulan Ini --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 md:p-6 shadow-theme-xs xl:col-span-7 flex flex-col justify-between">
            <div>
                <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Arus Kas Bulan Ini</h3>
                        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">Pemasukan, pengeluaran & selisih bersih</p>
                    </div>
                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-theme-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        {{ now()->translatedFormat('F Y') }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-success-50/50 dark:bg-success-500/5 border border-success-200 dark:border-success-500/20 border-l-4 border-l-success-600 shadow-theme-xs">
                        <span class="text-theme-xs text-gray-500 dark:text-gray-400">Masuk ({{ $data['bulanIni']['jumlahMasuk'] }} transaksi)</span>
                        <p class="mt-1 break-words text-xl font-bold text-success-700 dark:text-success-400 angka">
                            {{ Format::rupiah($data['bulanIni']['masuk']) }}
                        </p>
                        @if (! empty($data['bulanIni']['bandingMasuk']))
                            <p class="mt-1.5 inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $data['bulanIni']['bandingMasuk']['arah'] === 'turun' ? 'bg-error-50 text-error-700 dark:bg-error-500/10 dark:text-error-400' : 'bg-success-50 text-success-700 dark:bg-success-500/10 dark:text-success-400' }}">
                                {{ $data['bulanIni']['bandingMasuk']['teks'] }}
                            </p>
                        @endif
                    </div>
                    <div class="p-4 rounded-xl bg-error-50/50 dark:bg-error-500/5 border border-error-200 dark:border-error-500/20 border-l-4 border-l-error-600 shadow-theme-xs">
                        <span class="text-theme-xs text-gray-500 dark:text-gray-400">Keluar ({{ $data['bulanIni']['jumlahKeluar'] }} transaksi)</span>
                        <p class="mt-1 break-words text-xl font-bold text-error-600 dark:text-error-400 angka">
                            {{ Format::rupiah($data['bulanIni']['keluar']) }}
                        </p>
                        @if (! empty($data['bulanIni']['bandingKeluar']))
                            <p class="mt-1.5 inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $data['bulanIni']['bandingKeluar']['arah'] === 'naik' ? 'bg-warning-50 text-warning-700 dark:bg-warning-500/10 dark:text-warning-400' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                                {{ $data['bulanIni']['bandingKeluar']['teks'] }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kartu Saldo Bersih (Net Cashflow) Pengisi Ruang Bawah Agar Simetris --}}
            @php
                $selisihBulanIni = (float) $data['bulanIni']['masuk'] - (float) $data['bulanIni']['keluar'];
                $isDefisit = $selisihBulanIni < 0;
            @endphp
            <div class="mt-4 pt-3.5 border-t border-gray-100 dark:border-gray-800 flex flex-wrap items-center justify-between gap-3 bg-gray-50/70 dark:bg-gray-800/40 p-3 rounded-xl border border-gray-200/60 dark:border-gray-800">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $isDefisit ? 'bg-error-50 text-error-600 dark:bg-error-500/10 dark:text-error-400' : 'bg-success-50 text-success-700 dark:bg-success-500/10 dark:text-success-400' }}">
                        @if ($isDefisit)
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                            </svg>
                        @else
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        @endif
                    </span>
                    <div>
                        <span class="text-xs font-semibold text-gray-800 dark:text-white/90 block">
                            {{ $isDefisit ? 'Defisit Bersih Bulan Ini' : 'Surplus Bersih Bulan Ini' }}
                        </span>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400">Total penerimaan dikurangi seluruh pengeluaran</span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-base font-bold angka {{ $isDefisit ? 'text-error-600 dark:text-error-400' : 'text-success-700 dark:text-success-400' }}">
                        {{ Format::rupiah($selisihBulanIni) }}
                    </span>
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
                        <span class="text-[11px] text-gray-500 dark:text-gray-400 block">Masuk Hari Ini</span>
                        <span class="font-bold text-success-700 dark:text-success-400 angka">
                            {{ Format::rupiah($data['hariIni']['masuk'] ?? 0) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400 block">Keluar Hari Ini</span>
                        <span class="font-bold text-error-600 dark:text-error-400 angka">
                            {{ Format::rupiah($data['hariIni']['keluar'] ?? 0) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('panel.spk.create') }}"
                    class="group flex flex-col justify-between rounded-xl border border-gray-200 bg-white p-3 shadow-theme-xs transition-all hover:-translate-y-0.5 hover:border-brand-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-800/80 dark:hover:border-brand-500/30">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-gray-800 group-hover:text-brand-600 dark:text-gray-200 dark:group-hover:text-brand-400">
                            SPK Baru
                        </span>
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </span>
                    </div>
                    <span class="mt-2 text-[11px] text-gray-500 dark:text-gray-400">Input kontrak</span>
                </a>

                <a href="{{ route('panel.cash-in.create') }}"
                    class="group flex flex-col justify-between rounded-xl border border-gray-200 bg-white p-3 shadow-theme-xs transition-all hover:-translate-y-0.5 hover:border-success-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-800/80 dark:hover:border-success-500/30">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-gray-800 group-hover:text-success-700 dark:text-gray-200 dark:group-hover:text-success-400">
                            Uang Masuk
                        </span>
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </span>
                    </div>
                    <span class="mt-2 text-[11px] text-gray-500 dark:text-gray-400">Termin/dana cair</span>
                </a>

                <a href="{{ route('panel.cash-out.create') }}"
                    class="group flex flex-col justify-between rounded-xl border border-gray-200 bg-white p-3 shadow-theme-xs transition-all hover:-translate-y-0.5 hover:border-error-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-800/80 dark:hover:border-error-500/30">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-gray-800 group-hover:text-error-600 dark:text-gray-200 dark:group-hover:text-error-400">
                            Uang Keluar
                        </span>
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                        </span>
                    </div>
                    <span class="mt-2 text-[11px] text-gray-500 dark:text-gray-400">Biaya operasional</span>
                </a>

                <a href="{{ route('panel.receipts.upload') }}"
                    class="group flex flex-col justify-between rounded-xl border border-gray-200 bg-white p-3 shadow-theme-xs transition-all hover:-translate-y-0.5 hover:border-purple-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-800/80 dark:hover:border-purple-500/30">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-gray-800 group-hover:text-purple-600 dark:text-gray-200 dark:group-hover:text-purple-400">
                            Unggah Nota
                        </span>
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </span>
                    </div>
                    <span class="mt-2 text-[11px] text-gray-500 dark:text-gray-400">Ekstraksi OCR</span>
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
                @foreach (array_filter($data['sebaranSpk'], fn($s) => $s['jumlah'] > 0) as $st)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-400">{{ $st['label'] }}</span>
                        <span class="font-bold text-gray-900 dark:text-white angka">{{ $st['jumlah'] }} SPK ({{ $st['persen'] }}%)</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Baris 4: Dua Kolom Operasional (Transaksi Terbaru & SPK Berjalan) --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-2">

        {{-- Transaksi Terbaru --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 shadow-theme-xs overflow-hidden">
            <div>
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Transaksi Terbaru</h3>
                        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">Arus kas masuk & keluar terakhir</p>
                    </div>
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
                        @foreach (array_slice($data['terbaru'], 0, 6) as $trx)
                            <div class="flex items-center gap-3.5 px-5 py-3 hover:bg-gray-50/60 dark:hover:bg-white/[0.02] transition-colors">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $trx['jenis'] === 'masuk' ? 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-400' : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-400' }}">
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
                                        {{ $trx['keterangan'] ?: '-' }} &middot; {{ $trx['tanggal']?->format('d/m/Y') }}
                                    </p>
                                </div>

                                <div class="text-right shrink-0">
                                    <p class="text-xs font-bold angka {{ $trx['jenis'] === 'masuk' ? 'text-success-700 dark:text-success-400' : 'text-error-600 dark:text-error-400' }}">
                                        {{ $trx['jenis'] === 'masuk' ? '+' : '−' }} {{ Format::rupiah($trx['jumlah']) }}
                                    </p>
                                    <span class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-gray-400">
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
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 shadow-theme-xs overflow-hidden">
            <div>
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">SPK Berjalan Aktif</h3>
                        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">Pekerjaan lapangan sedang berlangsung</p>
                    </div>
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
                        @foreach (array_slice($data['spkBerjalan'], 0, 6) as $spk)
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
                                    <span class="text-[10px] {{ $spk['lewat'] ? 'text-error-600 dark:text-error-400 font-semibold' : 'text-gray-500 dark:text-gray-400' }}">
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
            const isDark = () => document.documentElement.classList.contains('dark');
            const charts = {};

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
                            fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif",
                            type: 'bar',
                            height: 290,
                            background: 'transparent',
                            toolbar: { show: false }
                        },
                        theme: { mode: isDark() ? 'dark' : 'light' },
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
                    charts.arusKas = new window.ApexCharts(elArusKas, optionsArusKas);
                    charts.arusKas.render();
                }

                // Chart Sebaran Status SPK
                const elStatus = document.querySelector('#chartStatusSpkAdmin');
                if (elStatus && !elStatus.dataset.rendered) {
                    elStatus.dataset.rendered = 'true';
                    const optionsStatus = {
                        series: @json($spkJumlah),
                        labels: @json($spkLabels),
                        colors: ['#98a2b3', '#0ba5ec', '#f79009', '#12b76a', '#0F4C81', '#f04438'],
                        chart: {
                            fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif",
                            type: 'donut',
                            height: 230,
                            background: 'transparent'
                        },
                        theme: { mode: isDark() ? 'dark' : 'light' },
                        stroke: { colors: [isDark() ? '#111827' : '#ffffff'], width: 2 },
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
                                            label: 'Total SPK',
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
                    charts.status = new window.ApexCharts(elStatus, optionsStatus);
                    charts.status.render();
                }
            }

            // Sinkronkan warna chart saat tema di-toggle
            function syncTheme() {
                const dark = isDark();
                const mode = dark ? 'dark' : 'light';
                charts.arusKas?.updateOptions({
                    theme: { mode },
                    grid: { borderColor: dark ? '#1F2A37' : '#E5E7EB' },
                    tooltip: { theme: mode }
                });
                charts.status?.updateOptions({
                    theme: { mode },
                    stroke: { colors: [dark ? '#111827' : '#ffffff'], width: 2 },
                    plotOptions: { pie: { donut: { labels: {
                        value: { color: dark ? '#F8FAFC' : '#1D2939' },
                        total: { color: dark ? '#98A2B3' : '#64748B' }
                    } } } }
                });
            }
            new MutationObserver(syncTheme).observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class', 'data-color-scheme']
            });

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initAdminCharts);
            } else {
                initAdminCharts();
            }
        })();
    </script>
    @endpush

</x-layouts.app>
