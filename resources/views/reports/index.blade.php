{{--
    Laporan Keuangan & Buku Kas/Bank (/panel/reports)
    Disusun ringkas dengan Tab Navigasi agar tidak scroll panjang ke bawah.
--}}
@use('App\Support\Format')

@php
    $kelasKartu = 'rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs';
    $kelasLabel = 'text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400';
    $kelasNilai = 'mt-1 break-words text-xl font-bold angka text-gray-900 dark:text-white sm:text-2xl';

    $jenisEkspor = [
        'buku-kas' => 'Buku Kas (Running Balance)',
        'buku-bank' => 'Buku Bank (Running Balance)',
        'spk' => 'Daftar SPK Keseluruhan',
        'masuk' => 'Uang Masuk per Bulan',
        'keluar' => 'Uang Keluar per Kategori',
        'piutang' => 'Piutang & Tagihan Tertunda',
        'tenggat' => 'Tenggat SPK',
    ];

    $paramPeriode = array_filter([
        'periode' => $periode,
        'mulai' => $tanggalMulai ?? null,
        'selesai' => $tanggalSelesai ?? null,
    ], static fn ($v) => $v !== null && $v !== '');

    $tabSah = ['ringkasan', 'buku-kas', 'buku-bank', 'arus-kas', 'piutang', 'tenggat'];
    $tabAwal = in_array(request()->query('tab'), $tabSah, true) ? request()->query('tab') : 'ringkasan';
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <div class="space-y-6" x-data="{ activeTab: @js($tabAwal) }">

        {{-- Baris Filter Periode & Dropdown Ekspor Dokumen --}}
        <section class="{{ $kelasKartu }} p-4 md:p-5">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                {{-- Periode Filter --}}
                <div class="flex flex-col gap-2.5 sm:flex-row sm:items-center">
                    <form method="GET" action="{{ route('panel.reports') }}"
                        class="flex min-w-0 flex-wrap items-center gap-2" role="group" aria-label="Periode laporan">
                        <input type="hidden" name="periode" value="{{ $periode }}">

                        <x-common.filter-tanggal id="tanggal-laporan" mode="get" :otomatis="true" :tanggal="(string) ($tanggalMulai ?? '')" :lebar="'sm:w-44'" />
                    </form>

                    {{-- Tombol Presets Periode Cepat --}}
                    <div class="flex flex-wrap items-center gap-1 text-xs">
                        <a href="{{ route('panel.reports', ['periode' => 1]) }}"
                            class="rounded-lg border px-2.5 py-1.5 text-theme-xs font-semibold shadow-theme-xs transition {{ $periode === 1 && empty($tanggalMulai) ? 'border-brand-500 bg-brand-50 text-brand-700 dark:border-brand-500 dark:bg-brand-500/15 dark:text-brand-300' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                            Bulan Ini
                        </a>
                        <a href="{{ route('panel.reports', ['periode' => 3]) }}"
                            class="rounded-lg border px-2.5 py-1.5 text-theme-xs font-semibold shadow-theme-xs transition {{ $periode === 3 && empty($tanggalMulai) ? 'border-brand-500 bg-brand-50 text-brand-700 dark:border-brand-500 dark:bg-brand-500/15 dark:text-brand-300' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                            3 Bulan
                        </a>
                        <a href="{{ route('panel.reports', ['periode' => 12]) }}"
                            class="rounded-lg border px-2.5 py-1.5 text-theme-xs font-semibold shadow-theme-xs transition {{ $periode === 12 && empty($tanggalMulai) ? 'border-brand-500 bg-brand-50 text-brand-700 dark:border-brand-500 dark:bg-brand-500/15 dark:text-brand-300' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                            1 Tahun
                        </a>
                        <a href="{{ route('panel.reports', ['periode' => 0]) }}"
                            class="rounded-lg border px-2.5 py-1.5 text-theme-xs font-semibold shadow-theme-xs transition {{ $periode === 0 && empty($tanggalMulai) ? 'border-brand-500 bg-brand-50 text-brand-700 dark:border-brand-500 dark:bg-brand-500/15 dark:text-brand-400' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                            Semua
                        </a>
                        @if ($tanggalMulai)
                            <a href="{{ route('panel.reports', ['periode' => 1]) }}"
                                title="Reset filter tanggal"
                                class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-2 py-1.5 text-theme-xs font-semibold text-error-600 hover:bg-error-50 dark:border-gray-700 dark:bg-gray-800 dark:text-error-400">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Reset
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Dropdown Ekspor Laporan Resmi PT BKS --}}
                <div class="relative shrink-0" x-data="{ openExport: false }" @click.outside="openExport = false">
                    <button type="button" @click="openExport = !openExport"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-xs font-semibold text-white transition-colors hover:bg-brand-600 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20 sm:w-auto">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        <span>Unduh Dokumen Laporan</span>
                        <svg class="h-3.5 w-3.5 transition-transform" :class="openExport ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <div x-show="openExport" x-transition
                        class="absolute right-0 mt-2 w-[min(18rem,calc(100vw-2.5rem))] rounded-xl border border-gray-200 bg-white p-3 shadow-theme-lg dark:border-gray-800 dark:bg-gray-900 z-50 divide-y divide-gray-100 dark:divide-gray-800"
                        style="display: none;">
                        <div class="px-2 pb-2">
                            <p class="text-xs font-bold text-gray-800 dark:text-white">Format Standar Perusahaan</p>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400">Dilengkapi KOP & Tanda Tangan Direktur</p>
                        </div>
                        <div class="py-2 space-y-1">
                            @foreach ($jenisEkspor as $kunci => $label)
                                <div class="flex items-center justify-between rounded-lg px-2.5 py-1.5 hover:bg-gray-50 dark:hover:bg-white/[0.03] text-xs">
                                    <span class="font-medium text-gray-700 dark:text-gray-300 truncate max-w-[150px]" title="{{ $label }}">
                                        {{ $label }}
                                    </span>
                                    <div class="inline-flex items-center gap-1.5 shrink-0">
                                        <a href="{{ route('laporan.ekspor', array_merge(['jenis' => $kunci, 'format' => 'xlsx'], $paramPeriode)) }}"
                                            class="font-bold text-success-700 hover:underline dark:text-success-400" title="Unduh Excel">
                                            XLSX
                                        </a>
                                        <span class="text-gray-300 dark:text-gray-700">&middot;</span>
                                        <a href="{{ route('laporan.ekspor', array_merge(['jenis' => $kunci, 'format' => 'pdf'], $paramPeriode)) }}"
                                            class="font-bold text-error-600 hover:underline dark:text-error-400" title="Unduh PDF">
                                            PDF
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="pt-2 px-1">
                            <a href="{{ route('laporan.bundel', $paramPeriode) }}" class="flex items-center justify-between rounded-lg p-2 text-theme-xs font-semibold text-brand-700 bg-brand-50 hover:bg-brand-100 dark:bg-brand-500/10 dark:text-brand-300 dark:hover:bg-brand-500/20 transition">
                                <span class="flex items-center gap-1.5">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Unduh Bundel Lengkap (.ZIP)
                                </span>
                                <span class="rounded bg-brand-200/60 dark:bg-brand-500/30 px-1.5 py-0.5 text-[10px]">5 Berkas</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab Segmented Navigasi Kategori Laporan --}}
            <div class="mt-4 flex flex-wrap items-center gap-1.5 border-t border-gray-100 pt-4 dark:border-gray-800"
                role="tablist" aria-label="Bagian laporan">
                @foreach ([
                    'ringkasan' => 'Ringkasan Eksekutif',
                    'buku-kas' => 'Buku Kas',
                    'buku-bank' => 'Buku Bank',
                    'arus-kas' => 'Arus Kas & Pengeluaran',
                    'piutang' => 'Piutang SPK',
                    'tenggat' => 'Tenggat SPK',
                ] as $kunciTab => $labelTab)
                    <button type="button" role="tab" aria-controls="tab-{{ $kunciTab }}"
                        :aria-selected="activeTab === '{{ $kunciTab }}'"
                        @click="activeTab = '{{ $kunciTab }}'; $nextTick(() => { window.dispatchEvent(new Event('resize')); window.bksGrafikLaporan && window.bksGrafikLaporan(); })"
                        :class="activeTab === '{{ $kunciTab }}' ? 'bg-brand-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'"
                        class="inline-flex h-9 items-center rounded-lg px-3.5 text-xs font-semibold transition-colors focus:outline-hidden focus:ring-2 focus:ring-brand-500/20">
                        {{ $labelTab }}
                    </button>
                @endforeach
            </div>
        </section>

        {{-- TAB 1: RINGKASAN EKSEKUTIF (Ringkas, Padat, Tidak Scroll Panjang) --}}
        <div id="tab-ringkasan" role="tabpanel" class="space-y-6" x-show="activeTab === 'ringkasan'">
            {{-- Metrik Utama --}}
            <section class="{{ $kelasKartu }} p-5">
                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 pb-3 dark:border-gray-800">
                    <div class="min-w-0">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Ringkasan Finansial Periode</h3>
                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">Gambaran menyeluruh kesehatan kas, bank, dan piutang kontrak</p>
                    </div>
                    <span class="rounded-full bg-brand-50 px-2.5 py-0.5 text-theme-xs font-semibold text-brand-700 dark:bg-brand-500/10 dark:text-brand-300">
                        @if (filled($tanggalMulai))
                            {{ \Illuminate\Support\Carbon::parse($tanggalMulai)->translatedFormat('d F Y') }}
                        @else
                            {{ $opsiPeriode[$periode] ?? 'Periode Ini' }}
                        @endif
                    </span>
                </div>

                <dl class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    {{-- 1. Total Masuk --}}
                    <div class="min-w-0 overflow-hidden rounded-xl bg-gray-50/60 p-4 dark:bg-white/[0.02]">
                        <dt class="{{ $kelasLabel }}">Total Uang Masuk</dt>
                        <dd class="{{ $kelasNilai }} text-success-700 dark:text-success-500">{{ Format::rupiah($data['totalMasuk']) }}</dd>
                        <dd class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                            SPK: {{ Format::rupiah($data['masukDariSpk']) }}
                        </dd>
                    </div>

                    {{-- 2. Total Keluar --}}
                    <div class="min-w-0 overflow-hidden rounded-xl bg-gray-50/60 p-4 dark:bg-white/[0.02]">
                        <dt class="{{ $kelasLabel }}">Total Uang Keluar</dt>
                        <dd class="{{ $kelasNilai }} text-error-600 dark:text-error-400">{{ Format::rupiah($data['totalKeluar']) }}</dd>
                        <dd class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Biaya operasional & proyek</dd>
                    </div>

                    {{-- 3. Surplus / Defisit --}}
                    <div class="min-w-0 overflow-hidden rounded-xl bg-gray-50/60 p-4 dark:bg-white/[0.02]">
                        <dt class="{{ $kelasLabel }}">Surplus / Defisit</dt>
                        <dd class="{{ $kelasNilai }} {{ $data['selisih'] < 0 ? 'text-error-600 dark:text-error-400' : 'text-success-700 dark:text-success-500' }}">
                            {{ Format::rupiah($data['selisih']) }}
                        </dd>
                        <dd class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Net selisih arus kas</dd>
                    </div>

                    {{-- 4. Saldo Kas & Bank --}}
                    <div class="min-w-0 overflow-hidden rounded-xl bg-gray-50/60 p-4 dark:bg-white/[0.02]">
                        <dt class="{{ $kelasLabel }}">Total Saldo Likuiditas</dt>
                        <dd class="{{ $kelasNilai }} text-brand-600 dark:text-brand-400">{{ Format::rupiah($data['saldoTotal']) }}</dd>
                        <dd class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                            Kas: {{ Format::rupiah($data['saldoKas']) }} &middot; Bank: {{ Format::rupiah($data['saldoBank']) }}
                        </dd>
                    </div>

                    {{-- 5. Pagu Kontrak --}}
                    <div class="min-w-0 overflow-hidden rounded-xl bg-gray-50/60 p-4 dark:bg-white/[0.02]">
                        <dt class="{{ $kelasLabel }}">Total Pagu Kontrak SPK</dt>
                        <dd class="mt-1 break-words text-xl font-bold angka text-gray-900 dark:text-white">{{ Format::rupiah($data['nilaiSpk']) }}</dd>
                        <dd class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">{{ Format::angka($data['jumlahSpk']) }} kontrak terdaftar</dd>
                    </div>

                    {{-- 6. Sisa Piutang --}}
                    <div class="min-w-0 overflow-hidden rounded-xl bg-gray-50/60 p-4 dark:bg-white/[0.02]">
                        <dt class="{{ $kelasLabel }}">Sisa Piutang Berjalan</dt>
                        <dd class="mt-1 break-words text-xl font-bold angka text-warning-700 dark:text-warning-500">{{ Format::rupiah($data['belumDiterima']) }}</dd>
                        <dd class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                            {{ $data['daftarPiutang']->count() }} SPK belum lunas
                        </dd>
                    </div>

                    {{-- 7. Realisasi Penerimaan --}}
                    <div class="min-w-0 overflow-hidden rounded-xl bg-gray-50/60 p-4 dark:bg-white/[0.02]">
                        <dt class="{{ $kelasLabel }}">Realisasi SPK</dt>
                        @php
                            $persen = $data['nilaiSpk'] > 0 ? round(($data['masukDariSpk'] / $data['nilaiSpk']) * 100, 1) : 0;
                        @endphp
                        <dd class="mt-1 break-words text-xl font-bold angka text-gray-900 dark:text-white">{{ $persen }}%</dd>
                        <dd class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Dari total kontrak terdaftar</dd>
                    </div>

                    {{-- 8. Statistik Transaksi --}}
                    <div class="min-w-0 overflow-hidden rounded-xl bg-gray-50/60 p-4 dark:bg-white/[0.02]">
                        <dt class="{{ $kelasLabel }}">Aktivitas Transaksi</dt>
                        <dd class="mt-1 text-base font-bold text-gray-800 dark:text-gray-200">
                            {{ Format::angka($data['jumlahMasuk']) }} Masuk &middot; {{ Format::angka($data['jumlahKeluar']) }} Keluar
                        </dd>
                        <dd class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">{{ Format::angka($data['jumlahMitra']) }} mitra rekanan</dd>
                    </div>
                </dl>
            </section>

            {{-- Komparasi Buku Kas vs Buku Bank (Ringkas) --}}
            <div class="grid gap-6 lg:grid-cols-2">
                {{-- Card Ringkasan Kas --}}
                <div class="{{ $kelasKartu }} p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                            <div class="flex items-center gap-2.5">
                                <span class="h-3 w-3 rounded-full bg-success-500"></span>
                                <h4 class="text-base font-semibold text-gray-900 dark:text-white">Buku Kas (Operasional)</h4>
                            </div>
                            <button type="button" @click="activeTab = 'buku-kas'"
                                class="text-theme-xs font-semibold text-brand-600 hover:underline dark:text-brand-400">
                                Buka Mutasi Lengkap &rarr;
                            </button>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-3 text-theme-xs">
                            <div class="rounded-lg bg-gray-50 p-2.5 dark:bg-white/[0.02]">
                                <span class="text-gray-500 dark:text-gray-400">Saldo Awal</span>
                                <p class="mt-0.5 text-sm font-bold angka text-gray-900 dark:text-white">{{ Format::rupiah($data['bukuKas']['saldo_awal']) }}</p>
                            </div>
                            <div class="rounded-lg bg-success-50/60 p-2.5 dark:bg-success-500/10">
                                <span class="text-success-700 dark:text-success-300">Total Masuk</span>
                                <p class="mt-0.5 text-sm font-bold angka text-success-600 dark:text-success-400">+ {{ Format::rupiah($data['bukuKas']['total_debet']) }}</p>
                            </div>
                            <div class="rounded-lg bg-error-50/60 p-2.5 dark:bg-error-500/10">
                                <span class="text-error-700 dark:text-error-300">Total Keluar</span>
                                <p class="mt-0.5 text-sm font-bold angka text-error-600 dark:text-error-400">- {{ Format::rupiah($data['bukuKas']['total_kredit']) }}</p>
                            </div>
                            <div class="rounded-lg bg-brand-50/60 p-2.5 dark:bg-brand-500/10">
                                <span class="text-brand-700 dark:text-brand-300">Saldo Akhir</span>
                                <p class="mt-0.5 text-sm font-bold angka text-brand-600 dark:text-brand-400">{{ Format::rupiah($data['bukuKas']['saldo_akhir']) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between text-theme-xs text-gray-500 dark:text-gray-400">
                        <span>{{ $data['bukuKas']['baris']->count() }} transaksi tercatat</span>
                        <a href="{{ route('laporan.ekspor', array_merge(['jenis' => 'buku-kas', 'format' => 'xlsx'], $paramPeriode)) }}"
                            class="font-medium text-success-700 hover:underline dark:text-success-400">Unduh Excel</a>
                    </div>
                </div>

                {{-- Card Ringkasan Bank --}}
                <div class="{{ $kelasKartu }} p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                            <div class="flex items-center gap-2.5">
                                <span class="h-3 w-3 rounded-full bg-blue-500"></span>
                                <h4 class="text-base font-semibold text-gray-900 dark:text-white">Buku Bank (Rekening Perusahaan)</h4>
                            </div>
                            <button type="button" @click="activeTab = 'buku-bank'"
                                class="text-theme-xs font-semibold text-brand-600 hover:underline dark:text-brand-400">
                                Buka Mutasi Lengkap &rarr;
                            </button>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-3 text-theme-xs">
                            <div class="rounded-lg bg-gray-50 p-2.5 dark:bg-white/[0.02]">
                                <span class="text-gray-500 dark:text-gray-400">Saldo Awal</span>
                                <p class="mt-0.5 text-sm font-bold angka text-gray-900 dark:text-white">{{ Format::rupiah($data['bukuBank']['saldo_awal']) }}</p>
                            </div>
                            <div class="rounded-lg bg-success-50/60 p-2.5 dark:bg-success-500/10">
                                <span class="text-success-700 dark:text-success-300">Total Masuk</span>
                                <p class="mt-0.5 text-sm font-bold angka text-success-600 dark:text-success-400">+ {{ Format::rupiah($data['bukuBank']['total_debet']) }}</p>
                            </div>
                            <div class="rounded-lg bg-error-50/60 p-2.5 dark:bg-error-500/10">
                                <span class="text-error-700 dark:text-error-300">Total Keluar</span>
                                <p class="mt-0.5 text-sm font-bold angka text-error-600 dark:text-error-400">- {{ Format::rupiah($data['bukuBank']['total_kredit']) }}</p>
                            </div>
                            <div class="rounded-lg bg-brand-50/60 p-2.5 dark:bg-brand-500/10">
                                <span class="text-brand-700 dark:text-brand-300">Saldo Akhir</span>
                                <p class="mt-0.5 text-sm font-bold angka text-brand-600 dark:text-brand-400">{{ Format::rupiah($data['bukuBank']['saldo_akhir']) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between text-theme-xs text-gray-500 dark:text-gray-400">
                        <span>{{ $data['bukuBank']['baris']->count() }} transaksi rekening</span>
                        <a href="{{ route('laporan.ekspor', array_merge(['jenis' => 'buku-bank', 'format' => 'xlsx'], $paramPeriode)) }}"
                            class="font-medium text-success-700 hover:underline dark:text-success-400">Unduh Excel</a>
                    </div>
                </div>
            </div>

            {{-- Arus Kas Bulanan & Pengeluaran Top Kategori --}}
            <div class="grid gap-6 lg:grid-cols-2">
                {{-- Arus Kas Bulanan Ringkas --}}
                <div class="{{ $kelasKartu }} p-5">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">Arus Kas Bulanan</h4>
                        <button type="button" @click="activeTab = 'arus-kas'" class="text-theme-xs font-semibold text-brand-600 hover:underline dark:text-brand-400">
                            Rincian &rarr;
                        </button>
                    </div>
                    @if ($data['perBulan']->isEmpty())
                        <p class="py-6 text-center text-theme-sm text-gray-500 dark:text-gray-400">Belum ada transaksi pada periode ini.</p>
                    @else
                        <div class="mt-3 overflow-x-auto">
                            <table class="w-full text-left text-theme-xs">
                                <thead>
                                    <tr class="border-b border-gray-100 text-gray-500 dark:border-gray-800">
                                        <th class="py-2 font-medium">Bulan</th>
                                        <th class="py-2 text-right font-medium">Masuk</th>
                                        <th class="py-2 text-right font-medium">Keluar</th>
                                        <th class="py-2 text-right font-medium">Net</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach ($data['perBulan']->take(6) as $bulan)
                                        <tr>
                                            <td class="py-2 font-medium text-gray-900 dark:text-gray-100">{{ $bulan['label'] }}</td>
                                            <td class="angka py-2 text-right text-success-700 dark:text-success-400">{{ Format::rupiah($bulan['masuk']) }}</td>
                                            <td class="angka py-2 text-right text-error-600 dark:text-error-400">{{ Format::rupiah($bulan['keluar']) }}</td>
                                            <td class="angka py-2 text-right font-semibold {{ $bulan['selisih'] < 0 ? 'text-error-600 dark:text-error-400' : 'text-success-700 dark:text-success-400' }}">
                                                {{ Format::rupiah($bulan['selisih']) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                {{-- Pengeluaran per Kategori Ringkas --}}
                <div class="{{ $kelasKartu }} p-5">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">Alokasi Pengeluaran</h4>
                        <button type="button" @click="activeTab = 'arus-kas'" class="text-theme-xs font-semibold text-brand-600 hover:underline dark:text-brand-400">
                            Rincian &rarr;
                        </button>
                    </div>
                    @if ($data['perKategori']->isEmpty())
                        <p class="py-6 text-center text-theme-sm text-gray-500 dark:text-gray-400">Belum ada pengeluaran pada periode ini.</p>
                    @else
                        <div class="mt-3 overflow-hidden">
                            <table class="w-full text-left text-theme-xs">
                                <thead>
                                    <tr class="border-b border-gray-100 text-gray-500 dark:border-gray-800">
                                        <th class="py-2 font-medium">Kategori</th>
                                        <th class="py-2 text-right font-medium">Transaksi</th>
                                        <th class="py-2 text-right font-medium">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach ($data['perKategori']->take(6) as $kat)
                                        <tr>
                                            <td class="py-2 font-medium text-gray-900 dark:text-gray-100">{{ $kat['label'] }}</td>
                                            <td class="angka py-2 text-right text-gray-500 dark:text-gray-400">{{ Format::angka($kat['jumlah_transaksi']) }}x</td>
                                            <td class="angka py-2 text-right font-semibold text-gray-900 dark:text-white">{{ Format::rupiah($kat['total']) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Quick Links ke Rincian Piutang & Tenggat --}}
            <div class="grid gap-6 lg:grid-cols-2">
                {{-- Piutang Terbesar --}}
                <div class="{{ $kelasKartu }} p-5 min-w-0 overflow-hidden">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">Piutang SPK Berjalan</h4>
                        <button type="button" @click="activeTab = 'piutang'" class="text-theme-xs font-semibold text-brand-600 hover:underline dark:text-brand-400">
                            Semua ({{ $data['daftarPiutang']->count() }}) &rarr;
                        </button>
                    </div>
                    @if ($data['daftarPiutang']->isEmpty())
                        <p class="py-6 text-center text-theme-sm text-gray-500 dark:text-gray-400">Semua SPK sudah lunas.</p>
                    @else
                        <ul class="mt-3 divide-y divide-gray-100 text-theme-xs dark:divide-gray-800">
                            @foreach ($data['daftarPiutang']->take(4) as $spk)
                                @php
                                    $diterima = (float) ($spk->total_masuk ?? 0);
                                    $sisa = $spk->piutangDari($diterima);
                                @endphp
                                <li class="py-2.5 flex items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <a href="{{ route('panel.spk.show', $spk) }}" class="font-semibold text-brand-600 hover:underline dark:text-brand-400">
                                            {{ $spk->nomor_spk }}
                                        </a>
                                        <p class="truncate text-[11px] text-gray-500 dark:text-gray-400">{{ $spk->nama_pekerjaan }}</p>
                                    </div>
                                    <span class="angka font-bold text-warning-700 dark:text-warning-500 shrink-0">
                                        {{ Format::rupiah($sisa) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- Status Tenggat Waktu --}}
                <div class="{{ $kelasKartu }} p-5 min-w-0 overflow-hidden">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">Perhatian Tenggat Waktu</h4>
                        <button type="button" @click="activeTab = 'tenggat'" class="text-theme-xs font-semibold text-brand-600 hover:underline dark:text-brand-400">
                            Rincian &rarr;
                        </button>
                    </div>
                    @php
                        $lewatCount = $data['spkLewatTenggat']->count();
                        $dekatCount = $data['spkMendekatiTenggat']->count();
                    @endphp
                    @if ($lewatCount === 0 && $dekatCount === 0)
                        <p class="py-6 text-center text-theme-sm text-success-700 dark:text-success-400">Seluruh SPK berjalan sesuai jadwal pengerjaan.</p>
                    @else
                        <div class="mt-3 space-y-2">
                            @if ($lewatCount > 0)
                                <div class="flex items-center justify-between rounded-xl bg-error-50/70 p-3 text-theme-xs dark:bg-error-500/10">
                                    <div class="flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-error-500"></span>
                                        <span class="font-semibold text-error-700 dark:text-error-300">Lewat Tenggat Waktu</span>
                                    </div>
                                    <span class="font-bold text-error-700 dark:text-error-300">{{ $lewatCount }} SPK</span>
                                </div>
                            @endif
                            @if ($dekatCount > 0)
                                <div class="flex items-center justify-between rounded-xl bg-amber-50/70 p-3 text-theme-xs dark:bg-amber-500/10">
                                    <div class="flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                        <span class="font-semibold text-amber-700 dark:text-amber-300">Mendekati Batas Akhir (&le; 14 hari)</span>
                                    </div>
                                    <span class="font-bold text-amber-700 dark:text-amber-300">{{ $dekatCount }} SPK</span>
                                </div>
                            @endif
                            <div class="pt-2 text-center">
                                <button type="button" @click="activeTab = 'tenggat'" class="text-theme-xs text-gray-500 hover:text-gray-700 dark:text-gray-400">
                                    Klik untuk memeriksa daftar detail &rarr;
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- TAB 2: BUKU KAS (Mutasi Debit/Kredit Saldo Berjalan Kas) --}}
        <div id="tab-buku-kas" role="tabpanel" class="space-y-4" x-show="activeTab === 'buku-kas'">
            @php $buku = $data['bukuKas']; @endphp
            <section class="{{ $kelasKartu }} overflow-hidden">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Buku Kas Operasional (Kas Tunai)</h3>
                        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">Mutasi pengeluaran kas kecil kantor dan setoran kas masuk</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-theme-xs text-gray-600 dark:text-gray-400">
                            Saldo awal <strong class="angka font-bold text-gray-900 dark:text-white">{{ Format::rupiah($buku['saldo_awal']) }}</strong>
                            &middot; akhir <strong class="angka font-bold text-brand-600 dark:text-brand-400">{{ Format::rupiah($buku['saldo_akhir']) }}</strong>
                        </span>
                        <a href="{{ route('laporan.ekspor', array_merge(['jenis' => 'buku-kas', 'format' => 'xlsx'], $paramPeriode)) }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg border border-success-200 bg-success-50 text-success-700 hover:bg-success-100 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-400">
                            Unduh Excel
                        </a>
                    </div>
                </div>

                @if ($buku['baris']->isEmpty())
                    <p class="px-5 py-8 text-center text-theme-sm text-gray-500 dark:text-gray-400">Tidak ada mutasi kas pada periode ini.</p>
                @else
                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                        <table class="w-full text-left text-theme-sm">
                            <thead class="sticky top-0 bg-gray-50 dark:bg-gray-800/90 backdrop-blur z-10 border-b border-gray-200 dark:border-gray-700">
                                <tr class="text-theme-xs uppercase text-gray-500 dark:text-gray-400">
                                    <th class="w-28 px-4 py-2.5 font-medium">Tanggal</th>
                                    <th class="px-3 py-2.5 font-medium">Keterangan & Ref</th>
                                    <th class="w-36 px-3 py-2.5 text-right font-medium">Debet (Masuk)</th>
                                    <th class="w-36 px-3 py-2.5 text-right font-medium">Kredit (Keluar)</th>
                                    <th class="w-40 px-4 py-2.5 text-right font-medium">Saldo Berjalan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($buku['baris']->take($batasBaris ?? $buku['baris']->count()) as $baris)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02]">
                                        <td class="px-4 py-2.5 whitespace-nowrap text-theme-xs text-gray-700 dark:text-gray-300">
                                            {{ $baris['tanggal']?->format('d/m/Y') }}
                                        </td>
                                        <td class="px-3 py-2.5">
                                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ $baris['keterangan'] }}</span>
                                            @if (filled($baris['ref']))
                                                <span class="block text-theme-xs text-gray-500 dark:text-gray-400 dark:text-gray-500">{{ $baris['ref'] }}</span>
                                            @endif
                                        </td>
                                        <td class="angka px-3 py-2.5 text-right font-semibold text-success-700 dark:text-success-400">
                                            {{ $baris['debet'] > 0 ? '+ ' . Format::rupiah($baris['debet']) : '—' }}
                                        </td>
                                        <td class="angka px-3 py-2.5 text-right font-semibold text-error-600 dark:text-error-400">
                                            {{ $baris['kredit'] > 0 ? '− ' . Format::rupiah($baris['kredit']) : '—' }}
                                        </td>
                                        <td class="angka px-4 py-2.5 text-right font-bold text-gray-900 dark:text-white">
                                            {{ Format::rupiah($baris['saldo']) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="sticky bottom-0 bg-gray-50 dark:bg-gray-800/90 font-bold border-t border-gray-200 dark:border-gray-700">
                                <tr>
                                    <td class="px-4 py-3" colspan="2">Total Mutasi Kas</td>
                                    <td class="angka px-3 py-3 text-right text-success-700 dark:text-success-400">{{ Format::rupiah($buku['total_debet']) }}</td>
                                    <td class="angka px-3 py-3 text-right text-error-600 dark:text-error-400">{{ Format::rupiah($buku['total_kredit']) }}</td>
                                    <td class="angka px-4 py-3 text-right text-brand-600 dark:text-brand-400">{{ Format::rupiah($buku['saldo_akhir']) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @include('reports.partials.batas-baris', ['buku' => $buku, 'batasBaris' => $batasBaris, 'tab' => 'buku-kas'])
                @endif
            </section>
        </div>

        {{-- TAB 3: BUKU BANK (Mutasi Rekening Giro PLN) --}}
        <div id="tab-buku-bank" role="tabpanel" class="space-y-4" x-show="activeTab === 'buku-bank'">
            @php $buku = $data['bukuBank']; @endphp
            <section class="{{ $kelasKartu }} overflow-hidden">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Buku Bank (Rekening Perusahaan)</h3>
                        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">Mutasi penerimaan termin kontrak SPK dan pembayaran vendor besar</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-theme-xs text-gray-600 dark:text-gray-400">
                            Saldo awal <strong class="angka font-bold text-gray-900 dark:text-white">{{ Format::rupiah($buku['saldo_awal']) }}</strong>
                            &middot; akhir <strong class="angka font-bold text-brand-600 dark:text-brand-400">{{ Format::rupiah($buku['saldo_akhir']) }}</strong>
                        </span>
                        <a href="{{ route('laporan.ekspor', array_merge(['jenis' => 'buku-bank', 'format' => 'xlsx'], $paramPeriode)) }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg border border-success-200 bg-success-50 text-success-700 hover:bg-success-100 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-400">
                            Unduh Excel
                        </a>
                    </div>
                </div>

                @if ($buku['baris']->isEmpty())
                    <p class="px-5 py-8 text-center text-theme-sm text-gray-500 dark:text-gray-400">Tidak ada mutasi rekening bank pada periode ini.</p>
                @else
                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                        <table class="w-full text-left text-theme-sm">
                            <thead class="sticky top-0 bg-gray-50 dark:bg-gray-800/90 backdrop-blur z-10 border-b border-gray-200 dark:border-gray-700">
                                <tr class="text-theme-xs uppercase text-gray-500 dark:text-gray-400">
                                    <th class="w-28 px-4 py-2.5 font-medium">Tanggal</th>
                                    <th class="px-3 py-2.5 font-medium">Keterangan & Ref</th>
                                    <th class="w-36 px-3 py-2.5 text-right font-medium">Debet (Masuk)</th>
                                    <th class="w-36 px-3 py-2.5 text-right font-medium">Kredit (Keluar)</th>
                                    <th class="w-40 px-4 py-2.5 text-right font-medium">Saldo Berjalan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($buku['baris']->take($batasBaris ?? $buku['baris']->count()) as $baris)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02]">
                                        <td class="px-4 py-2.5 whitespace-nowrap text-theme-xs text-gray-700 dark:text-gray-300">
                                            {{ $baris['tanggal']?->format('d/m/Y') }}
                                        </td>
                                        <td class="px-3 py-2.5">
                                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ $baris['keterangan'] }}</span>
                                            @if (filled($baris['ref']))
                                                <span class="block text-theme-xs text-gray-500 dark:text-gray-400 dark:text-gray-500">{{ $baris['ref'] }}</span>
                                            @endif
                                        </td>
                                        <td class="angka px-3 py-2.5 text-right font-semibold text-success-700 dark:text-success-400">
                                            {{ $baris['debet'] > 0 ? '+ ' . Format::rupiah($baris['debet']) : '—' }}
                                        </td>
                                        <td class="angka px-3 py-2.5 text-right font-semibold text-error-600 dark:text-error-400">
                                            {{ $baris['kredit'] > 0 ? '− ' . Format::rupiah($baris['kredit']) : '—' }}
                                        </td>
                                        <td class="angka px-4 py-2.5 text-right font-bold text-gray-900 dark:text-white">
                                            {{ Format::rupiah($baris['saldo']) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="sticky bottom-0 bg-gray-50 dark:bg-gray-800/90 font-bold border-t border-gray-200 dark:border-gray-700">
                                <tr>
                                    <td class="px-4 py-3" colspan="2">Total Mutasi Bank</td>
                                    <td class="angka px-3 py-3 text-right text-success-700 dark:text-success-400">{{ Format::rupiah($buku['total_debet']) }}</td>
                                    <td class="angka px-3 py-3 text-right text-error-600 dark:text-error-400">{{ Format::rupiah($buku['total_kredit']) }}</td>
                                    <td class="angka px-4 py-3 text-right text-brand-600 dark:text-brand-400">{{ Format::rupiah($buku['saldo_akhir']) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @include('reports.partials.batas-baris', ['buku' => $buku, 'batasBaris' => $batasBaris, 'tab' => 'buku-bank'])
                @endif
            </section>
        </div>

        {{-- TAB 4: ARUS KAS BULANAN & KATEGORI PENGELUARAN --}}
        <div id="tab-arus-kas" role="tabpanel" class="grid gap-6 xl:grid-cols-2" x-show="activeTab === 'arus-kas'">
            {{-- Visualisasi Donut Pengeluaran per Kategori --}}
            <section class="{{ $kelasKartu }} p-5">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4 dark:border-gray-800">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Proporsi Kategori Biaya</h3>
                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">Komposisi pengeluaran pada periode ini</p>
                    </div>
                </div>

                @if ($data['perKategori']->isEmpty())
                    <p class="py-12 text-center text-theme-sm text-gray-500 dark:text-gray-400">Belum ada data pengeluaran untuk divisualisasikan.</p>
                @else
                    <div id="chartPengeluaranKategori" class="w-full flex items-center justify-center min-h-[240px]"></div>
                @endif
            </section>
            {{-- Per bulan --}}
            <section class="{{ $kelasKartu }} overflow-hidden">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Uang Masuk & Keluar per Bulan</h3>
                    <a href="{{ route('laporan.ekspor', array_merge(['jenis' => 'masuk', 'format' => 'xlsx'], $paramPeriode)) }}"
                        class="text-theme-xs font-semibold text-success-700 hover:underline dark:text-success-400">Unduh Excel</a>
                </div>
                @if ($data['perBulan']->isEmpty())
                    <p class="px-5 py-8 text-center text-theme-sm text-gray-500 dark:text-gray-400">Belum ada transaksi pada periode ini.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-theme-sm">
                            <thead>
                                <tr class="border-b border-gray-100 text-theme-xs uppercase text-gray-500 dark:border-gray-800 dark:text-gray-400 bg-gray-50/50 dark:bg-white/[0.01]">
                                    <th class="px-4 py-2.5 font-medium">Bulan</th>
                                    <th class="px-3 py-2.5 text-right font-medium">Masuk</th>
                                    <th class="px-3 py-2.5 text-right font-medium">Keluar</th>
                                    <th class="px-4 py-2.5 text-right font-medium">Selisih</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($data['perBulan'] as $bulan)
                                    <tr>
                                        <td class="px-4 py-2.5 font-medium text-gray-900 dark:text-gray-100">{{ $bulan['label'] }}</td>
                                        <td class="angka px-3 py-2.5 text-right text-success-700 dark:text-success-500">{{ Format::rupiah($bulan['masuk']) }}</td>
                                        <td class="angka px-3 py-2.5 text-right text-error-600 dark:text-error-400">{{ Format::rupiah($bulan['keluar']) }}</td>
                                        <td class="angka px-4 py-2.5 text-right font-bold {{ $bulan['selisih'] < 0 ? 'text-error-600 dark:text-error-400' : 'text-success-700 dark:text-success-500' }}">
                                            {{ Format::rupiah($bulan['selisih']) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            {{-- Per kategori pengeluaran --}}
            <section class="{{ $kelasKartu }} overflow-hidden">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Pengeluaran per Kategori</h3>
                    <a href="{{ route('laporan.ekspor', array_merge(['jenis' => 'keluar', 'format' => 'xlsx'], $paramPeriode)) }}"
                        class="text-theme-xs font-semibold text-success-700 hover:underline dark:text-success-400">Unduh Excel</a>
                </div>
                @if ($data['perKategori']->isEmpty())
                    <p class="px-5 py-8 text-center text-theme-sm text-gray-500 dark:text-gray-400">Belum ada pengeluaran pada periode ini.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-theme-sm">
                            <thead>
                                <tr class="border-b border-gray-100 text-theme-xs uppercase text-gray-500 dark:border-gray-800 dark:text-gray-400 bg-gray-50/50 dark:bg-white/[0.01]">
                                    <th class="px-4 py-2.5 font-medium">Kategori</th>
                                    <th class="px-3 py-2.5 text-right font-medium">Transaksi</th>
                                    <th class="px-4 py-2.5 text-right font-medium">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($data['perKategori'] as $kat)
                                    <tr>
                                        <td class="px-4 py-2.5 font-medium text-gray-900 dark:text-gray-100">{{ $kat['label'] }}</td>
                                        <td class="angka px-3 py-2.5 text-right text-gray-500 dark:text-gray-400">{{ Format::angka($kat['jumlah_transaksi']) }}</td>
                                        <td class="angka px-4 py-2.5 text-right font-bold text-gray-900 dark:text-white">{{ Format::rupiah($kat['total']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </div>

        {{-- TAB 5: PIUTANG SPK (Daftar Kontrak Belum Lunas) --}}
        <div id="tab-piutang" role="tabpanel" class="space-y-4" x-show="activeTab === 'piutang'">
            <section class="{{ $kelasKartu }} overflow-hidden">
                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Piutang Belum Tertagih per SPK</h3>
                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">
                            {{ $data['daftarPiutang']->count() }} SPK belum lunas
                        </p>
                    </div>
                    <a href="{{ route('laporan.ekspor', array_merge(['jenis' => 'piutang', 'format' => 'xlsx'], $paramPeriode)) }}"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg border border-success-200 bg-success-50 text-success-700 hover:bg-success-100 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-400">
                        Unduh Excel (Piutang)
                    </a>
                </div>

                @if ($data['daftarPiutang']->isEmpty())
                    <p class="px-5 py-8 text-center text-theme-sm text-gray-500 dark:text-gray-400">Semua SPK sudah lunas.</p>
                @else
                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                        <table class="w-full text-left text-theme-sm">
                            <thead class="sticky top-0 bg-gray-50 dark:bg-gray-800/90 backdrop-blur z-10 border-b border-gray-200 dark:border-gray-700">
                                <tr class="text-theme-xs uppercase text-gray-500 dark:text-gray-400">
                                    <th class="px-4 py-2.5 font-medium">SPK & Pekerjaan</th>
                                    <th class="px-3 py-2.5 font-medium">Mitra</th>
                                    <th class="px-3 py-2.5 text-right font-medium">Nilai Kontrak</th>
                                    <th class="px-3 py-2.5 text-right font-medium">Diterima</th>
                                    <th class="px-4 py-2.5 text-right font-medium">Sisa Piutang</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($data['daftarPiutang'] as $spk)
                                    @php
                                        $diterima = (float) ($spk->total_masuk ?? 0);
                                        $sisa = $spk->piutangDari($diterima);
                                    @endphp
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02]">
                                        <td class="px-4 py-2.5">
                                            <a href="{{ route('panel.spk.show', $spk) }}"
                                                class="angka font-semibold text-brand-600 hover:underline dark:text-brand-400">
                                                {{ $spk->nomor_spk }}
                                            </a>
                                            <span class="block truncate text-theme-xs text-gray-500 dark:text-gray-400 max-w-sm">{{ $spk->nama_pekerjaan }}</span>
                                        </td>
                                        <td class="px-3 py-2.5 text-gray-700 dark:text-gray-300 font-medium">{{ $spk->mitra?->nama ?? '—' }}</td>
                                        <td class="angka px-3 py-2.5 text-right text-gray-700 dark:text-gray-300">{{ Format::rupiah((float) $spk->nilai_spk) }}</td>
                                        <td class="angka px-3 py-2.5 text-right text-success-700 dark:text-success-500 font-medium">{{ Format::rupiah($diterima) }}</td>
                                        <td class="angka px-4 py-2.5 text-right font-bold text-warning-700 dark:text-warning-500">{{ Format::rupiah($sisa) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </div>

        {{-- TAB 6: TENGGAT SPK (Lewat & Mendekati) --}}
        <div id="tab-tenggat" role="tabpanel" class="grid gap-6 xl:grid-cols-2" x-show="activeTab === 'tenggat'">
            @foreach ([
                'spkLewatTenggat' => ['Lewat Batas Waktu', 'text-error-600 dark:text-error-400'],
                'spkMendekatiTenggat' => ['Mendekati Batas Waktu (≤ 14 hari)', 'text-warning-700 dark:text-warning-500'],
            ] as $kunci => [$judulTenggat, $warna])
                <section class="{{ $kelasKartu }} overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <span>{{ $judulTenggat }}</span>
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                {{ $data[$kunci]->count() }}
                            </span>
                        </h3>
                        <a href="{{ route('laporan.ekspor', array_merge(['jenis' => 'tenggat', 'format' => 'xlsx'], $paramPeriode)) }}"
                            class="text-theme-xs font-semibold text-success-700 hover:underline dark:text-success-400">Unduh Excel</a>
                    </div>

                    @if ($data[$kunci]->isEmpty())
                        <p class="px-5 py-8 text-center text-theme-sm text-gray-500 dark:text-gray-400">Tidak ada SPK.</p>
                    @else
                        <ul class="divide-y divide-gray-100 dark:divide-gray-800 max-h-[500px] overflow-y-auto">
                            @foreach ($data[$kunci] as $spk)
                                <li class="px-5 py-3 hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                                    <div class="flex items-baseline justify-between gap-3">
                                        <a href="{{ route('panel.spk.show', $spk) }}"
                                            class="angka font-semibold text-brand-600 hover:underline dark:text-brand-400">
                                            {{ $spk->nomor_spk }}
                                        </a>
                                        <span class="shrink-0 text-theme-xs font-semibold {{ $warna }}">
                                            {{ $spk->labelTenggat() }}
                                        </span>
                                    </div>
                                    <p class="truncate text-theme-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $spk->mitra?->nama ?? 'Tanpa mitra' }} &middot; {{ $spk->nama_pekerjaan }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </section>
            @endforeach
        </div>

    </div>

    @push('scripts')
    <script>
        (function() {
            function initLaporanChart() {
                if (typeof window.ApexCharts === 'undefined') return;
                const el = document.querySelector('#chartPengeluaranKategori');
                if (!el || el.dataset.rendered) return;

                const isDark = () => document.documentElement.classList.contains('dark');
                const labels = @json($data['perKategori']->pluck('label'));
                const series = @json($data['perKategori']->pluck('total'));

                if (!series.length) return;

                // Tab Arus Kas tersembunyi saat halaman dimuat: tunggu sampai
                // kontainer punya lebar nyata agar donut tidak dirender 0px.
                if (el.clientWidth === 0) {
                    let sisa = 240;
                    const tunggu = setInterval(() => {
                        if (el.clientWidth > 0 || sisa-- <= 0) {
                            clearInterval(tunggu);
                            if (el.clientWidth > 0) initLaporanChart();
                        }
                    }, 250);
                    return;
                }

                el.dataset.rendered = 'true';
                const options = {
                    series: series,
                    labels: labels,
                    colors: ['#465fff', '#0ba5ec', '#f79009', '#12b76a', '#7a5af8', '#f04438', '#98a2b3'],
                    chart: {
                        fontFamily: "Outfit, sans-serif",
                        type: 'donut',
                        height: 250,
                        background: 'transparent'
                    },
                    theme: {
                        mode: isDark() ? 'dark' : 'light'
                    },
                    stroke: {
                        colors: [isDark() ? '#111827' : '#ffffff'],
                        width: 2
                    },
                    dataLabels: { enabled: false },
                    legend: {
                        position: 'bottom',
                        fontSize: '12px',
                        labels: {
                            colors: isDark() ? '#94A3B8' : '#64748B'
                        }
                    },
                    tooltip: {
                        theme: isDark() ? 'dark' : 'light',
                        y: {
                            formatter: function(val) {
                                return 'Rp ' + Number(val).toLocaleString('id-ID');
                            }
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '72%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: 'Total Biaya',
                                        color: isDark() ? '#98A2B3' : '#64748B',
                                        fontSize: '12px',
                                        fontWeight: 600,
                                        formatter: function(w) {
                                            const tot = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                            if (tot >= 1000000000) return (tot / 1000000000).toFixed(1) + ' M';
                                            if (tot >= 1000000) return (tot / 1000000).toFixed(0) + ' jt';
                                            return 'Rp ' + tot.toLocaleString('id-ID');
                                        }
                                    },
                                    value: {
                                        color: isDark() ? '#F8FAFC' : '#1D2939',
                                        fontSize: '18px',
                                        fontWeight: 700,
                                        formatter: function(val) {
                                            return 'Rp ' + Number(val).toLocaleString('id-ID');
                                        }
                                    }
                                }
                            }
                        }
                    }
                };

                const chart = new window.ApexCharts(el, options);
                chart.render();

                const observer = new MutationObserver(() => {
                    const dark = isDark();
                    chart.updateOptions({
                        theme: { mode: dark ? 'dark' : 'light' },
                        stroke: { colors: [dark ? '#111827' : '#ffffff'] },
                        legend: { labels: { colors: dark ? '#94A3B8' : '#64748B' } },
                        tooltip: { theme: dark ? 'dark' : 'light' },
                        plotOptions: {
                            pie: {
                                donut: {
                                    labels: {
                                        total: { color: dark ? '#98A2B3' : '#64748B' },
                                        value: { color: dark ? '#F8FAFC' : '#1D2939' }
                                    }
                                }
                            }
                        }
                    });
                });
                observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class', 'data-color-scheme'] });
            }

            window.bksGrafikLaporan = initLaporanChart;

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initLaporanChart);
            } else {
                initLaporanChart();
            }
        })();
    </script>
    @endpush
</x-layouts.app>