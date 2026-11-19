{{--
    Dashboard Direktur - TailAdmin Pro Executive Finance Design
--}}
@use('App\Support\Format')
@php
    $trenLabels = array_map(fn($t) => $t['label'], $data['tren'] ?? []);
    $trenMasuk = array_map(fn($t) => (float) $t['masuk'], $data['tren'] ?? []);
    $trenKeluar = array_map(fn($t) => (float) $t['keluar'], $data['tren'] ?? []);

    $tagihanLabels = array_map(fn($t) => $t['label'], $data['sebaranTagihan'] ?? []);
    $tagihanJumlah = array_map(fn($t) => (int) $t['jumlah'], $data['sebaranTagihan'] ?? []);

    $saldoTotal = (float) ($data['saldo']['total'] ?? 0);
    $saldoKas = (float) ($data['saldo']['kas'] ?? 0);
    $saldoBank = (float) ($data['saldo']['bank'] ?? 0);
    $isSaldoDefisit = $saldoTotal < 0;

    $selisihBulanIni = (float) $data['bulanIni']['masuk'] - (float) $data['bulanIni']['keluar'];
    $isNetDefisit = $selisihBulanIni < 0;
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <x-common.antrean-ocr />

    {{-- Banner Salam Eksekutif TailAdmin Pro (Header dengan Shape Grid Decor) --}}
    <div class="relative mb-6 overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 shadow-theme-xs">
        <div class="absolute -right-10 -bottom-10 pointer-events-none opacity-5 dark:opacity-10 hidden sm:block">
            <img src="/images/shape/grid-01.svg" alt="decor" class="w-64 h-64" />
        </div>

        <div class="relative z-10 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 shadow-theme-xs">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white sm:text-2xl">
                            Halo, {{ auth()->user()->nama ?? 'Direktur' }}
                        </h2>
                        <span class="inline-flex items-center rounded-md bg-brand-50 px-2 py-0.5 text-[11px] font-bold text-brand-700 dark:bg-brand-500/15 dark:text-brand-400">
                            Eksekutif
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Ikhtisar posisi keuangan kas & bank, penagihan kontrak, dan pemantauan proyek.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                <span class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2 text-xs font-semibold text-gray-700 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
                <a href="{{ route('panel.reports') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2 text-xs font-semibold text-white shadow-theme-xs hover:bg-brand-600 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span>Laporan Keuangan</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Baris 1: Hero Saldo Overview (TailAdmin Finance Pro) --}}
    <div class="grid grid-cols-1 gap-5 xl:grid-cols-12 items-stretch">
        {{-- Total Balance Hero Card (Full Width) --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 shadow-theme-xs xl:col-span-12 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Total Saldo Likuiditas</span>
                        <h4 class="text-xs text-gray-400 mt-0.5">Posisi kas tunai dan rekening bank saat ini</h4>
                    </div>
                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $isSaldoDefisit ? 'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-400' : 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-400' }}">
                        <span class="h-1.5 w-1.5 rounded-full {{ $isSaldoDefisit ? 'bg-error-500' : 'bg-success-500' }}"></span>
                        {{ $isSaldoDefisit ? 'Posisi Defisit Kumulatif' : 'Likuiditas Aman' }}
                    </span>
                </div>

                <div class="my-4">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 block mb-1">Total Saldo Kumulatif:</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold angka {{ $isSaldoDefisit ? 'text-error-600 dark:text-error-400' : 'text-purple-600 dark:text-purple-400' }}">
                        {{ Format::rupiah($saldoTotal) }}
                    </h3>
                </div>

                {{-- Breakdown Kas & Bank Dual-Pill Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    <div class="rounded-xl border border-gray-200/80 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-white/[0.02]">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Saldo Kas (Fisik)</span>
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-2 text-base font-bold angka {{ $saldoKas < 0 ? 'text-error-600 dark:text-error-400' : ($saldoKas > 0 ? 'text-success-600 dark:text-success-400' : 'text-gray-900 dark:text-white') }}">
                            {{ Format::rupiah($saldoKas) }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-200/80 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-white/[0.02]">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Saldo Bank (Rekening)</span>
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-2 text-base font-bold angka {{ $saldoBank < 0 ? 'text-error-600 dark:text-error-400' : ($saldoBank > 0 ? 'text-success-600 dark:text-success-400' : 'text-gray-900 dark:text-white') }}">
                            {{ Format::rupiah($saldoBank) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                <span>Dihitung otomatis dari catatan uang masuk dikurangi uang keluar</span>
                <a href="{{ route('panel.reports') }}" class="font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-400">
                    Buku Kas & Bank &rarr;
                </a>
            </div>
        </div>
    </div>

    {{-- Baris 2: Ringkasan KPI Eksekutif (data penting) --}}
    <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($data['kpi'] ?? [] as $kpi)
            @php
                $nadaStyle = match ($kpi['nada'] ?? 'netral') {
                    'bahaya' => 'text-error-600 dark:text-error-400',
                    'aman' => 'text-success-700 dark:text-success-400',
                    default => 'text-gray-900 dark:text-white',
                };
                $ikon = match ($kpi['label'] ?? '') {
                    'Nilai Pekerjaan' => 'M7.5 21V4.5A1.5 1.5 0 019 3h9a1.5 1.5 0 011.5 1.5V21m-12 0a1.5 1.5 0 01-1.5-1.5v-3h4.5V19.5A1.5 1.5 0 017.5 21zm9-9h3m-3-3h3m-3-3h3',
                    'Belum Diterima' => 'M12 6v6l4 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z',
                    'Lewat Tenggat' => 'M12 9v3.75m0 3v.008m9-3.758a9 9 0 11-18 0 9 9 0 0118 0z',
                    default => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',
                };
            @endphp
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/3 shadow-theme-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ $kpi['label'] }}</span>
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $ikon }}" />
                        </svg>
                    </span>
                </div>
                <p class="mt-3 break-words text-xl font-bold angka {{ $nadaStyle }}">{{ $kpi['nilai'] }}</p>
                <p class="mt-1 text-[11px] text-gray-500 dark:text-gray-400">{{ $kpi['ket'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Baris 3: Ringkasan Arus Kas Bulan Ini & Realisasi Penagihan Kontrak (Grid 7 : 5) --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-12 items-start">
        {{-- Ringkasan Bulan Ini (7 grid) --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 shadow-theme-xs xl:col-span-7 flex flex-col justify-between">
            <div>
                <div class="mb-5 flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Arus Kas Bulan Ini</h3>
                        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Mutasi penerimaan & pengeluaran operasional bulan berjalan</p>
                    </div>
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        {{ now()->translatedFormat('F Y') }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Uang Masuk --}}
                    <div class="p-4 rounded-xl bg-success-50/40 dark:bg-success-500/5 border border-success-200/80 dark:border-success-500/20 shadow-theme-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Uang Masuk Bulan Ini</span>
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            </span>
                        </div>
                        <h4 class="mt-2 break-words text-xl font-bold text-gray-900 dark:text-white angka">
                            {{ Format::rupiah($data['bulanIni']['masuk']) }}
                        </h4>
                        <div class="mt-2.5">
                            <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $data['bulanIni']['bandingMasuk']['arah'] === 'turun' ? 'bg-error-50 text-error-700 dark:bg-error-500/10 dark:text-error-400' : 'bg-success-100/70 text-success-800 dark:bg-success-500/20 dark:text-success-300' }}">
                                {{ $data['bulanIni']['bandingMasuk']['teks'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Uang Keluar --}}
                    <div class="p-4 rounded-xl bg-error-50/40 dark:bg-error-500/5 border border-error-200/80 dark:border-error-500/20 shadow-theme-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Uang Keluar Bulan Ini</span>
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-error-100 text-error-700 dark:bg-error-500/20 dark:text-error-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                            </span>
                        </div>
                        <h4 class="mt-2 break-words text-xl font-bold text-gray-900 dark:text-white angka">
                            {{ Format::rupiah($data['bulanIni']['keluar']) }}
                        </h4>
                        <div class="mt-2.5">
                            <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $data['bulanIni']['bandingKeluar']['arah'] === 'naik' ? 'bg-warning-50 text-warning-700 dark:bg-warning-500/10 dark:text-warning-400' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                                {{ $data['bulanIni']['bandingKeluar']['teks'] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Surplus / Defisit Bersih Eksekutif & Mutasi Hari Ini --}}
            <div class="mt-4 pt-3.5 border-t border-gray-100 dark:border-gray-800 space-y-3">
                <div class="flex flex-wrap items-center justify-between gap-3 bg-gray-50/70 dark:bg-white/[0.02] p-3.5 rounded-xl border border-gray-200/60 dark:border-gray-800">
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $isNetDefisit ? 'bg-error-50 text-error-600 dark:bg-error-500/10 dark:text-error-400' : 'bg-success-50 text-success-700 dark:bg-success-500/10 dark:text-success-400' }}">
                            @if ($isNetDefisit)
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
                                {{ $isNetDefisit ? 'Defisit Bersih Bulan Ini' : 'Surplus Bersih Bulan Ini' }}
                            </span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">Penerimaan dikurangi seluruh pengeluaran bulan ini</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-base font-bold angka {{ $isNetDefisit ? 'text-error-600 dark:text-error-400' : 'text-success-700 dark:text-success-400' }}">
                            {{ Format::rupiah($selisihBulanIni) }}
                        </span>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-2 px-1 text-xs text-gray-500 dark:text-gray-400">
                    <span>Mutasi Hari Ini ({{ now()->format('d/m/Y') }}):</span>
                    <div class="flex items-center gap-3 angka">
                        <span class="font-semibold text-success-700 dark:text-success-400">+ {{ Format::rupiah($data['hariIni']['masuk'] ?? 0) }}</span>
                        <span>&middot;</span>
                        <span class="font-semibold text-error-600 dark:text-error-400">&minus; {{ Format::rupiah($data['hariIni']['keluar'] ?? 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Progres Realisasi Penagihan Kontrak & Pintasan Eksekutif (5 grid) --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 shadow-theme-xs xl:col-span-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Realisasi Penerimaan SPK</h3>
                        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Pencairan termin terhadap komitmen kontrak</p>
                    </div>
                    <span class="rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 angka">
                        {{ $data['tertagih']['persen'] ?? 0 }}%
                    </span>
                </div>

                <div class="h-2.5 w-full rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden mb-3">
                    <div class="h-full rounded-full bg-brand-500 transition-all duration-500"
                        style="width: {{ min(100, (float) ($data['tertagih']['persen'] ?? 0)) }}%"></div>
                </div>

                <div class="grid grid-cols-2 gap-2 rounded-xl bg-gray-50/80 p-3 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 text-xs">
                    <div>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400 block font-medium">Sudah Diterima</span>
                        <span class="font-bold text-success-700 dark:text-success-400 angka">
                            {{ Format::rupiah($data['tertagih']['diterima'] ?? 0) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400 block font-medium">Total Nilai Kontrak</span>
                        <span class="font-bold text-gray-900 dark:text-white angka">
                            {{ Format::rupiah($data['tertagih']['nilai'] ?? 0) }}
                        </span>
                    </div>
                </div>

                @php
                    $sisaPiutang = max(0.0, (float) ($data['tertagih']['nilai'] ?? 0) - (float) ($data['tertagih']['diterima'] ?? 0));
                @endphp
                <div class="mt-2 flex items-center justify-between rounded-xl bg-error-50/40 dark:bg-error-500/5 border border-error-200/70 dark:border-error-500/20 px-3 py-2.5 text-xs">
                    <span class="text-[11px] text-gray-500 dark:text-gray-400 block font-medium">Sisa Piutang</span>
                    <span class="font-bold text-error-700 dark:text-error-400 angka">
                        {{ Format::rupiah($sisaPiutang) }}
                    </span>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-2 gap-2.5">
                <a href="{{ route('panel.reports') }}"
                    class="inline-flex items-center justify-center font-semibold gap-1.5 rounded-xl transition px-3.5 py-2.5 text-xs bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span>Laporan Keuangan</span>
                </a>
                <a href="{{ route('panel.users.index') }}"
                    class="inline-flex items-center justify-center font-medium gap-1.5 rounded-xl transition px-3.5 py-2.5 text-xs bg-white text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700 dark:hover:bg-gray-700">
                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    <span>Manajemen Akun</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Baris 3: Grafik Analisis Eksekutif (ApexCharts) --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-12 items-stretch">
        {{-- Arus Kas 6 Bulan (ApexCharts) --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 shadow-theme-xs xl:col-span-8 flex flex-col justify-between">
            <div>
                <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Arus Kas 6 Bulan</h3>
                        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                            Perbandingan uang masuk vs keluar 6 bulan terakhir
                        </p>
                    </div>
                    <div class="flex items-center gap-4 text-xs">
                        <span class="flex items-center gap-1.5 font-medium text-gray-700 dark:text-gray-300">
                            <span class="h-3 w-3 rounded-full bg-[#465fff]"></span> Masuk
                        </span>
                        <span class="flex items-center gap-1.5 font-medium text-gray-700 dark:text-gray-300">
                            <span class="h-3 w-3 rounded-full bg-[#f04438]"></span> Keluar
                        </span>
                    </div>
                </div>

                <div id="chartArusKasDirektur" class="w-full h-[290px]"></div>
            </div>
        </div>

        {{-- Tahapan Tagihan SPK & Realisasi --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 shadow-theme-xs xl:col-span-4 flex flex-col justify-between">
            <div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Tahapan Tagihan SPK</h3>
                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Sebaran status penagihan saat ini</p>
                <div id="chartTagihanDirektur" class="w-full flex items-center justify-center my-3 min-h-[220px]"></div>
            </div>

            <div class="space-y-2 pt-3 border-t border-gray-100 dark:border-gray-800 text-xs">
                @foreach (array_filter($data['sebaranTagihan'], fn($t) => $t['jumlah'] > 0) as $tagihan)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full" style="background-color: {{ match($tagihan['label']) {
                                'Belum Ditagihkan' => '#98a2b3',
                                'Menunggu Pembayaran' => '#f79009',
                                'Dibayar Sebagian' => '#0ba5ec',
                                'Dibayar' => '#12b76a',
                                default => '#0F4C81'
                            } }}"></span>
                            <span class="text-gray-600 dark:text-gray-400">{{ $tagihan['label'] }}</span>
                        </div>
                        <span class="font-bold text-gray-900 dark:text-white angka">{{ $tagihan['jumlah'] }} SPK ({{ $tagihan['persen'] }}%)</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Baris 5: Prioritas Piutang Eksekutif (SPK prioritas & top mitra piutang) --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-12 items-stretch">
        {{-- SPK Prioritas Pantauan --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3 shadow-theme-xs overflow-hidden xl:col-span-8 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">SPK Prioritas Pantauan</h3>
                        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Lewat tenggat dulu, lalu sisa piutang terbesar</p>
                    </div>
                    <a href="{{ route('panel.spk.monitoring', 'status') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                        <span>Monitoring</span>
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>

                @if (($data['spkPrioritas'] ?? []) === [])
                    <div class="p-8 text-center text-sm text-gray-500 dark:text-gray-400">
                        Tidak ada SPK yang perlu dipantau. Semua piutang aman.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-white/[0.02]">
                                    <th class="px-5 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">SPK & Mitra</th>
                                    <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status Tagihan</th>
                                    <th class="px-4 py-3 text-end text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sisa Piutang</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs">
                                @foreach ($data['spkPrioritas'] as $prioritas)
                                    <tr class="hover:bg-gray-50/60 dark:hover:bg-white/[0.02] transition-colors">
                                        <td class="px-5 py-3.5">
                                            <a href="{{ route('panel.spk.show', $prioritas['id']) }}" class="font-semibold text-brand-600 hover:underline dark:text-brand-400 block">
                                                {{ $prioritas['nomor_spk'] }}
                                            </a>
                                            <span class="text-[11px] text-gray-500 dark:text-gray-400 truncate block max-w-xs">
                                                {{ $prioritas['mitra'] }} &middot; {{ $prioritas['pekerjaan'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <span class="inline-flex items-center rounded-lg px-2 py-0.5 text-[11px] font-semibold {{ $prioritas['lewat'] ? 'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-400' : 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-400' }}">
                                                {{ $prioritas['status_tagihan'] }} &middot; {{ $prioritas['label_tenggat'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3.5 text-end font-bold text-gray-900 dark:text-white angka">
                                            {{ Format::rupiah($prioritas['sisa']) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Top Mitra Piutang --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 shadow-theme-xs xl:col-span-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Top Mitra Piutang</h3>
                        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Mitra dengan sisa tagihan terbesar</p>
                    </div>
                </div>

                @if (($data['topMitraPiutang'] ?? []) === [])
                    <div class="p-6 text-center text-sm text-gray-500 dark:text-gray-400">
                        Belum ada piutang tercatat.
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach ($data['topMitraPiutang'] as $mitra)
                            <div class="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50/70 px-3.5 py-3 dark:border-gray-800 dark:bg-white/[0.02]">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-xs font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                                    {{ mb_substr($mitra['mitra'], 0, 1) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-xs font-semibold text-gray-800 dark:text-white/90">{{ $mitra['mitra'] }}</p>
                                    <p class="truncate text-[11px] text-gray-500 dark:text-gray-400">Sisa tagihan</p>
                                </div>
                                <span class="shrink-0 text-sm font-bold text-error-600 dark:text-error-400 angka">
                                    {{ Format::rupiah($mitra['sisa']) }}
                                </span>
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
                        chart: {
                            fontFamily: "Outfit, sans-serif",
                            type: 'area',
                            height: 290,
                            background: 'transparent',
                            toolbar: { show: false },
                            zoom: { enabled: false }
                        },
                        theme: { mode: isDark() ? 'dark' : 'light' },
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
                            axisTicks: { show: false },
                            labels: {
                                style: {
                                    fontSize: '12px',
                                    fontFamily: 'Outfit, sans-serif',
                                    colors: isDark() ? '#94A3B8' : '#6B7280'
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    fontSize: '12px',
                                    fontFamily: 'Outfit, sans-serif',
                                    colors: isDark() ? '#94A3B8' : '#6B7280'
                                },
                                formatter: function(val) {
                                    if (val >= 1000000000) return 'Rp ' + (val / 1000000000).toFixed(1) + ' M';
                                    if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(0) + ' jt';
                                    return 'Rp ' + val.toLocaleString('id-ID');
                                }
                            }
                        },
                        legend: { show: false },
                        grid: {
                            borderColor: isDark() ? '#1E2640' : '#F3F4F6',
                            strokeDashArray: 0,
                            xaxis: { lines: { show: false } },
                            yaxis: { lines: { show: true } }
                        },
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
                        colors: ['#98a2b3', '#f79009', '#0ba5ec', '#12b76a', '#0F4C81'],
                        chart: {
                            fontFamily: "Outfit, sans-serif",
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
                                            fontWeight: 700,
                                            fontFamily: 'Outfit, sans-serif'
                                        },
                                        total: {
                                            show: true,
                                            label: 'Total Tagihan',
                                            color: isDark() ? '#98A2B3' : '#64748B',
                                            fontSize: '12px',
                                            fontWeight: 600,
                                            fontFamily: 'Outfit, sans-serif',
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
                const dark = isDark();
                const mode = dark ? 'dark' : 'light';
                chartTagihan?.updateOptions({
                    theme: { mode },
                    stroke: { colors: [dark ? '#111827' : '#ffffff'], width: 2 },
                    plotOptions: { pie: { donut: { labels: {
                        value: { color: dark ? '#F8FAFC' : '#1D2939' },
                        total: { color: dark ? '#98A2B3' : '#64748B' }
                    } } } }
                });
                chartArusKas?.updateOptions({
                    theme: { mode },
                    grid: { borderColor: dark ? '#1E2640' : '#F3F4F6' },
                    tooltip: { theme: mode }
                });
            }
            new MutationObserver(syncTema).observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class', 'data-color-scheme']
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
