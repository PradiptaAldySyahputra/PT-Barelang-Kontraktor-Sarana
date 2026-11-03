{{--
    Pusat Ekspor & Unduhan (/panel/exports):
    Menyediakan unduhan langsung seluruh dokumen resmi PT BKS (Excel & PDF ber-kop surat resmi)
    serta riwayat berkas ekspor terdahulu.
--}}
@php
    $kelasKartu = 'overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs';

    $kelasBadge = [
        'gray' => 'bg-gray-100 text-gray-700 dark:bg-white/10 dark:text-gray-300',
        'success' => 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500',
        'warning' => 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-500',
        'danger' => 'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-500',
    ];
    $badge = static fn (?string $warna): string => $kelasBadge[$warna ?? 'gray'] ?? $kelasBadge['gray'];

    $periode = $periode ?? 12;
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <div class="space-y-6">
        {{-- Hero Card: Paket Bundel Laporan Lengkap (ZIP) --}}
        <div class="relative overflow-hidden rounded-2xl border border-brand-200 bg-gradient-to-br from-brand-50/80 via-white to-brand-50/30 p-5 sm:p-6 dark:border-brand-500/20 dark:from-brand-500/10 dark:via-gray-900 dark:to-gray-900 shadow-theme-xs">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-1.5 rounded-full bg-brand-100 px-2.5 py-0.5 text-theme-xs font-semibold text-brand-800 dark:bg-brand-500/20 dark:text-brand-300">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                        Paket Dokumen Komprehensif
                    </div>
                    <h3 class="mt-2 text-base font-semibold text-gray-900 dark:text-white">
                        Bundel Seluruh Laporan Keuangan (1-Klik ZIP)
                    </h3>
                    <p class="mt-1 text-theme-xs leading-relaxed text-gray-600 dark:text-gray-300">
                        Unduh seluruh laporan keuangan sekaligus (Buku Kas, Buku Bank, Piutang SPK, Tenggat SPK, dan Master SPK) dalam 1 berkas arsip ZIP. Seluruh berkas berformat Excel (.xlsx) dengan Kop Surat resmi PT Barelang Kontraktor Sarana dan lembar tanda tangan Direktur Utama & Admin Keuangan.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-2.5">
                    <a href="{{ route('laporan.bundel', ['periode' => $periode]) }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-theme-sm font-medium text-white shadow-theme-xs hover:bg-brand-700 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh Bundel Lengkap (.ZIP)
                    </a>
                    <a href="{{ route('panel.backup') }}"
                       class="inline-flex items-center gap-1.5 rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition">
                        <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                        Cadangan Database
                    </a>
                </div>
            </div>
        </div>

        {{-- Grid Kartu Ekspor Langsung --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            {{-- 1. Buku Kas Operasional --}}
            <div class="{{ $kelasKartu }} flex flex-col justify-between p-5">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </span>
                        <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[11px] font-semibold text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-300">Kas Tunai</span>
                    </div>
                    <h3 class="mt-3 text-theme-sm font-semibold text-gray-900 dark:text-white">Buku Kas Operasional</h3>
                    <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                        Mutasi kas kecil harian kantor dengan kalkulasi saldo berjalan debit/kredit.
                    </p>
                </div>
                <div class="mt-4 flex items-center gap-2 border-t border-gray-100 pt-3 dark:border-gray-800">
                    <a href="{{ route('laporan.ekspor', ['jenis' => 'buku-kas', 'format' => 'xlsx', 'periode' => $periode]) }}"
                        class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-success-200 bg-success-50 px-3 py-1.5 text-theme-xs font-medium text-success-700 hover:bg-success-100 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Excel (XLSX)
                    </a>
                    <a href="{{ route('laporan.ekspor', ['jenis' => 'buku-kas', 'format' => 'pdf', 'periode' => $periode]) }}"
                        class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-error-200 bg-error-50 px-3 py-1.5 text-theme-xs font-medium text-error-700 hover:bg-error-100 dark:border-error-500/20 dark:bg-error-500/10 dark:text-error-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        PDF Resmi
                    </a>
                </div>
            </div>

            {{-- 2. Buku Bank --}}
            <div class="{{ $kelasKartu }} flex flex-col justify-between p-5">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                        </span>
                        <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[11px] font-semibold text-blue-800 dark:bg-blue-500/20 dark:text-blue-300">Rekening Giro</span>
                    </div>
                    <h3 class="mt-3 text-theme-sm font-semibold text-gray-900 dark:text-white">Buku Bank (Rekening PLN)</h3>
                    <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                        Catatan mutasi rekening perbankan untuk transaksi termin SPK dan vendor material.
                    </p>
                </div>
                <div class="mt-4 flex items-center gap-2 border-t border-gray-100 pt-3 dark:border-gray-800">
                    <a href="{{ route('laporan.ekspor', ['jenis' => 'buku-bank', 'format' => 'xlsx', 'periode' => $periode]) }}"
                        class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-success-200 bg-success-50 px-3 py-1.5 text-theme-xs font-medium text-success-700 hover:bg-success-100 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Excel (XLSX)
                    </a>
                    <a href="{{ route('laporan.ekspor', ['jenis' => 'buku-bank', 'format' => 'pdf', 'periode' => $periode]) }}"
                        class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-error-200 bg-error-50 px-3 py-1.5 text-theme-xs font-medium text-error-700 hover:bg-error-100 dark:border-error-500/20 dark:bg-error-500/10 dark:text-error-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        PDF Resmi
                    </a>
                </div>
            </div>

            {{-- 3. Laporan Piutang SPK --}}
            <div class="{{ $kelasKartu }} flex flex-col justify-between p-5">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                        <span class="rounded-full bg-amber-100 px-2 py-0.5 text-[11px] font-semibold text-amber-800 dark:bg-amber-500/20 dark:text-amber-300">Piutang PLN</span>
                    </div>
                    <h3 class="mt-3 text-theme-sm font-semibold text-gray-900 dark:text-white">Laporan Piutang SPK</h3>
                    <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                        Daftar SPK yang belum lunas (sisa tagihan, status penagihan, dan nilai SPK).
                    </p>
                </div>
                <div class="mt-4 flex items-center gap-2 border-t border-gray-100 pt-3 dark:border-gray-800">
                    <a href="{{ route('laporan.ekspor', ['jenis' => 'piutang', 'format' => 'xlsx', 'periode' => $periode]) }}"
                        class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-success-200 bg-success-50 px-3 py-1.5 text-theme-xs font-medium text-success-700 hover:bg-success-100 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Excel (XLSX)
                    </a>
                    <a href="{{ route('laporan.ekspor', ['jenis' => 'piutang', 'format' => 'pdf', 'periode' => $periode]) }}"
                        class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-error-200 bg-error-50 px-3 py-1.5 text-theme-xs font-medium text-error-700 hover:bg-error-100 dark:border-error-500/20 dark:bg-error-500/10 dark:text-error-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        PDF Resmi
                    </a>
                </div>
            </div>

            {{-- 4. Laporan Tenggat SPK --}}
            <div class="{{ $kelasKartu }} flex flex-col justify-between p-5">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <span class="rounded-full bg-rose-100 px-2 py-0.5 text-[11px] font-semibold text-rose-800 dark:bg-rose-500/20 dark:text-rose-300">Timeline Proyek</span>
                    </div>
                    <h3 class="mt-3 text-theme-sm font-semibold text-gray-900 dark:text-white">Laporan Tenggat & Jatuh Tempo</h3>
                    <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                        Daftar SPK yang telah lewat jatuh tempo dan yang mendekati tenggat pengerjaan.
                    </p>
                </div>
                <div class="mt-4 flex items-center gap-2 border-t border-gray-100 pt-3 dark:border-gray-800">
                    <a href="{{ route('laporan.ekspor', ['jenis' => 'tenggat', 'format' => 'xlsx', 'periode' => $periode]) }}"
                        class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-success-200 bg-success-50 px-3 py-1.5 text-theme-xs font-medium text-success-700 hover:bg-success-100 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Excel (XLSX)
                    </a>
                    <a href="{{ route('laporan.ekspor', ['jenis' => 'tenggat', 'format' => 'pdf', 'periode' => $periode]) }}"
                        class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-error-200 bg-error-50 px-3 py-1.5 text-theme-xs font-medium text-error-700 hover:bg-error-100 dark:border-error-500/20 dark:bg-error-500/10 dark:text-error-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        PDF Resmi
                    </a>
                </div>
            </div>

            {{-- 5. Rekap SPK Komprehensif --}}
            <div class="{{ $kelasKartu }} flex flex-col justify-between p-5">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </span>
                        <span class="rounded-full bg-indigo-100 px-2 py-0.5 text-[11px] font-semibold text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-300">Master SPK</span>
                    </div>
                    <h3 class="mt-3 text-theme-sm font-semibold text-gray-900 dark:text-white">Daftar Seluruh SPK</h3>
                    <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                        Rekapitulasi lengkap seluruh kontrak pekerjaan SPK, nilai, dan status tagihannya.
                    </p>
                </div>
                <div class="mt-4 flex items-center gap-2 border-t border-gray-100 pt-3 dark:border-gray-800">
                    <a href="{{ route('laporan.ekspor', ['jenis' => 'spk', 'format' => 'xlsx', 'periode' => $periode]) }}"
                        class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-success-200 bg-success-50 px-3 py-1.5 text-theme-xs font-medium text-success-700 hover:bg-success-100 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Excel (XLSX)
                    </a>
                    <a href="{{ route('laporan.ekspor', ['jenis' => 'spk', 'format' => 'pdf', 'periode' => $periode]) }}"
                        class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-error-200 bg-error-50 px-3 py-1.5 text-theme-xs font-medium text-error-700 hover:bg-error-100 dark:border-error-500/20 dark:bg-error-500/10 dark:text-error-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        PDF Resmi
                    </a>
                </div>
            </div>

            {{-- 6. Paket Berkas Arsip Nota (ZIP) --}}
            <div class="{{ $kelasKartu }} flex flex-col justify-between p-5">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-500/10 dark:text-purple-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </span>
                        <span class="rounded-full bg-purple-100 px-2 py-0.5 text-[11px] font-semibold text-purple-800 dark:bg-purple-500/20 dark:text-purple-300">Lampiran Bukti</span>
                    </div>
                    <h3 class="mt-3 text-theme-sm font-semibold text-gray-900 dark:text-white">Paket Arsip Nota Transaksi</h3>
                    <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                        Unduh seluruh foto bukti nota dan kuitansi uang masuk/keluar dalam berkas ZIP terkompresi.
                    </p>
                </div>
                <div class="mt-4 flex items-center gap-2 border-t border-gray-100 pt-3 dark:border-gray-800">
                    <a href="{{ route('arsip-nota.zip') }}"
                        class="inline-flex w-full items-center justify-center gap-1.5 rounded-lg border border-purple-200 bg-purple-50 px-3 py-1.5 text-theme-xs font-medium text-purple-700 hover:bg-purple-100 dark:border-purple-500/20 dark:bg-purple-500/10 dark:text-purple-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh Paket ZIP Nota
                    </a>
                </div>
            </div>
        </div>

        {{-- Tabel Riwayat Berkas Ekspor --}}
        <section class="{{ $kelasKartu }}">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                <div>
                    <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Riwayat Pembuatan Berkas</h2>
                    <p class="text-theme-xs text-gray-500 dark:text-gray-400">Daftar proses ekspor yang tercatat di sistem</p>
                </div>
                <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-theme-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                    {{ $daftar->count() }} catatan
                </span>
            </div>

            @if ($daftar->isEmpty())
                <div class="px-5 py-12 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                    <p>Belum ada catatan riwayat ekspor.</p>
                    <p class="mt-1 text-theme-xs text-gray-400">Gunakan tombol ekspor di atas untuk mengunduh dokumen secara langsung.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-theme-xs text-gray-500 dark:border-gray-800 dark:text-gray-400">
                                <th class="w-[160px] px-5 py-2.5 font-medium">Waktu</th>
                                <th class="w-[140px] px-3 py-2.5 font-medium">Jenis</th>
                                <th class="px-5 py-2.5 font-medium">Nama Berkas</th>
                                <th class="w-[140px] px-3 py-2.5 font-medium">Progres Baris</th>
                                <th class="w-[140px] px-3 py-2.5 font-medium">Status Berkas</th>
                                <th class="w-[130px] px-5 py-2.5 text-right font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-theme-sm dark:divide-gray-800">
                            @foreach ($daftar as $baris)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02]">
                                    <td class="px-5 py-2.5 whitespace-nowrap text-theme-xs text-gray-700 dark:text-gray-300">
                                        {{ $baris['waktu']?->format('d/m/Y H:i') ?? '—' }}
                                    </td>
                                    <td class="px-3 py-2.5 font-medium text-gray-900 dark:text-gray-100">
                                        {{ $baris['jenis'] }}
                                    </td>
                                    <td class="px-5 py-2.5">
                                        <span class="block truncate text-theme-xs font-mono text-gray-700 dark:text-gray-300" title="{{ $baris['nama_berkas'] }}">
                                            {{ $baris['nama_berkas'] }}
                                        </span>
                                        @if ($baris['pengguna'])
                                            <span class="text-[11px] text-gray-500 dark:text-gray-400">oleh {{ $baris['pengguna'] }}</span>
                                        @endif
                                    </td>
                                    <td class="angka px-3 py-2.5 text-theme-xs text-gray-700 dark:text-gray-300">
                                        {{ $baris['baris_sukses'] }}/{{ $baris['total_baris'] }}
                                        @if ($baris['baris_gagal'] > 0)
                                            <span class="text-[11px] text-error-600 dark:text-error-500 font-semibold">({{ $baris['baris_gagal'] }} gagal)</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2.5">
                                        @if ($baris['bisa_unduh'])
                                            <span class="inline-flex rounded-md px-2 py-0.5 text-theme-xs font-medium {{ $badge($baris['warna']) }}">
                                                {{ $baris['status_label'] }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-md bg-gray-100 px-2 py-0.5 text-[11px] font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400" title="Berkas fisik lama sudah dibersihkan dari server storage">
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Kedaluwarsa
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-2.5 text-right">
                                        @if ($baris['bisa_unduh'])
                                            <a href="{{ route('ekspor.unduh', $baris['id']) }}"
                                                class="inline-flex items-center gap-1 rounded-lg border border-brand-200 bg-brand-50 px-2.5 py-1 text-theme-xs font-medium text-brand-700 hover:bg-brand-100 dark:border-brand-500/20 dark:bg-brand-500/10 dark:text-brand-400">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                Unduh
                                            </a>
                                        @elseif (!empty($baris['ekspor_baru_url']))
                                            <a href="{{ $baris['ekspor_baru_url'] }}"
                                                class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-2 py-1 text-theme-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700" title="Unduh ulang data terbaru">
                                                <svg class="h-3 w-3 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                Baru
                                            </a>
                                        @else
                                            <span class="text-theme-xs text-gray-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</x-layouts.app>
