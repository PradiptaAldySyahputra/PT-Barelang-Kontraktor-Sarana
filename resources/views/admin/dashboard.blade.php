{{--
    Dashboard Admin (operasional) - TailAdmin Harmonized Design
--}}
@use('App\Support\Format')

@php
    $trenLabels = array_map(fn($t) => $t['label'], $data['tren'] ?? []);
    $trenMasuk = array_map(fn($t) => (float) $t['masuk'], $data['tren'] ?? []);
    $trenKeluar = array_map(fn($t) => (float) $t['keluar'], $data['tren'] ?? []);
    $warnaHex = [
        'primary' => '#465FFF', 'success' => '#12B76A', 'warning' => '#F79009',
        'danger' => '#F04438', 'info' => '#0BA5EC', 'gray' => '#98A2B3',
    ];
    $spkStatus = array_values(array_filter($data['sebaranSpk'] ?? [], fn($s) => (int) $s['jumlah'] > 0));
    $spkStatus = array_map(static function ($s) use ($warnaHex) {
        $s['warna'] = $warnaHex[$s['warna']] ?? '#98A2B3';
        return $s;
    }, $spkStatus);
    $spkStatusLabels = array_map(fn($s) => $s['label'], $spkStatus);
    $spkStatusJumlah = array_map(fn($s) => (int) $s['jumlah'], $spkStatus);
    $spkStatusWarna = array_map(fn($s) => $s['warna'], $spkStatus);
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <x-common.antrean-ocr />

    {{-- Salam Operasional & Ringkasan Tanggal (TailAdmin Header Banner Style) --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 shadow-theme-xs">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white/90">
                    Halo, {{ auth()->user()->nama ?? 'Admin Operasional' }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Ringkasan kas, pekerjaan lapangan, dan agenda penagihan hari ini.
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2 sm:justify-end">
            <span class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-gray-50 px-3 py-1.5 text-xs font-semibold text-gray-700 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                {{ now()->translatedFormat('l, d F Y') }}
            </span>
            <div x-data="{ openTransfer: false, dari: 'bank', ke: 'kas' }" class="inline-flex">
                <button type="button" @click="openTransfer = true"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition">
                    <svg class="h-4 w-4 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                    <span>Pindah Dana</span>
                </button>

                {{-- Modal Pindah Dana Kas <-> Bank --}}
                <div x-show="openTransfer" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center bg-gray-900/50 p-4 backdrop-blur-xs">
                    <div @click.outside="openTransfer = false" class="w-full max-w-md rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xl dark:border-gray-800 dark:bg-gray-900">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white">Pindah Dana (Kas &harr; Bank)</h3>
                            <button type="button" @click="openTransfer = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">&times;</button>
                        </div>
                        <form method="POST" action="{{ route('panel.cash-transfer.store') }}" class="mt-4 space-y-4">
                            @csrf
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Dari Akun</label>
                                    <select name="dari_akun" x-model="dari" @change="ke = (dari === 'kas' ? 'bank' : 'kas')"
                                        class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                        <option value="bank">Bank (Rekening)</option>
                                        <option value="kas">Kas (Tunai)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Ke Akun</label>
                                    <select name="ke_akun" x-model="ke" @change="dari = (ke === 'kas' ? 'bank' : 'kas')"
                                        class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                        <option value="kas">Kas (Tunai)</option>
                                        <option value="bank">Bank (Rekening)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Nominal (Rp)</label>
                                    <input type="number" name="jumlah" min="1" step="1" required placeholder="Contoh: 5000000"
                                        class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal</label>
                                    <input type="date" name="tanggal" value="{{ now()->toDateString() }}" required
                                        class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Catatan (Opsional)</label>
                                <input type="text" name="keterangan" maxlength="255" placeholder="Contoh: Tarik tunai operasional / Setor tunai"
                                    class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="openTransfer = false"
                                    class="rounded-lg border border-gray-200 px-3.5 py-1.5 text-xs font-semibold text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="rounded-lg bg-brand-500 px-4 py-1.5 text-xs font-semibold text-white hover:bg-brand-600 transition">
                                    Simpan Pindah Dana
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <a href="{{ route('panel.receipts.upload') }}"
                class="inline-flex items-center gap-1.5 rounded-lg bg-brand-500 px-3.5 py-1.5 text-xs font-semibold text-white shadow-theme-xs hover:bg-brand-600 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Unggah Nota OCR</span>
            </a>
        </div>
    </div>


    {{-- Baris 1: 4 Stat KPI Cards (TailAdmin Pro Metrics Standard) --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-4">
        {{-- Card 1: Saldo Kas --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 flex flex-col justify-between shadow-theme-xs">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-400 shadow-theme-xs">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <a href="{{ route('panel.cash-in.create', ['akun' => 'kas']) }}"
                    class="text-[11px] font-semibold text-gray-400 hover:text-success-600 dark:text-gray-500 dark:hover:text-success-400 transition">
                    Sesuaikan &rarr;
                </a>
            </div>
            <div class="mt-5">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Saldo Kas</span>
                    <span class="inline-flex shrink-0 items-center rounded-lg bg-success-50 px-2 py-0.5 text-xs font-semibold text-success-700 dark:bg-success-500/15 dark:text-success-400">
                        Tunai Fisik
                    </span>
                </div>
                <h4 class="mt-2 text-lg sm:text-xl font-bold angka break-words {{ $data['saldo']['kas'] < 0 ? 'text-error-600 dark:text-error-400' : ($data['saldo']['kas'] > 0 ? 'text-success-600 dark:text-success-400' : 'text-gray-900 dark:text-white') }}">
                    {{ Format::rupiah($data['saldo']['kas']) }}
                </h4>
            </div>
        </div>

        {{-- Card 2: Saldo Bank --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 flex flex-col justify-between shadow-theme-xs">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 shadow-theme-xs">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <a href="{{ route('panel.cash-in.create', ['akun' => 'bank']) }}"
                    class="text-[11px] font-semibold text-gray-400 hover:text-brand-600 dark:text-gray-500 dark:hover:text-brand-400 transition">
                    Sesuaikan &rarr;
                </a>
            </div>
            <div class="mt-5">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Saldo Bank</span>
                    <span class="inline-flex shrink-0 items-center rounded-lg bg-brand-50 px-2 py-0.5 text-xs font-semibold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                        Rekening
                    </span>
                </div>
                <h4 class="mt-2 text-lg sm:text-xl font-bold angka break-words {{ $data['saldo']['bank'] < 0 ? 'text-error-600 dark:text-error-400' : ($data['saldo']['bank'] > 0 ? 'text-success-600 dark:text-success-400' : 'text-gray-900 dark:text-white') }}">
                    {{ Format::rupiah($data['saldo']['bank']) }}
                </h4>
            </div>
        </div>

        {{-- Card 3: Total Saldo Siap Pakai --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 flex flex-col justify-between shadow-theme-xs">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400 shadow-theme-xs">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="mt-5">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Saldo Siap Pakai</span>
                    <span class="inline-flex shrink-0 items-center rounded-lg bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        Kas + Bank
                    </span>
                </div>
                <h4 class="mt-2 text-lg sm:text-xl font-bold angka break-words {{ $data['saldo']['total'] < 0 ? 'text-error-600 dark:text-error-400' : ($data['saldo']['total'] > 0 ? 'text-success-600 dark:text-success-400' : 'text-gray-900 dark:text-white') }}">
                    {{ Format::rupiah($data['saldo']['total']) }}
                </h4>
            </div>
        </div>

        {{-- Card 4: SPK Berjalan Aktif --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 flex flex-col justify-between shadow-theme-xs">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400 shadow-theme-xs">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">SPK Berjalan Aktif</span>
                    <h4 class="mt-2 text-lg font-bold angka text-gray-900 dark:text-white sm:text-xl">
                        {{ $data['spkBerjalanCount'] }} SPK
                    </h4>
                </div>
                <span class="inline-flex items-center rounded-lg bg-amber-50 px-2 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                    Lapangan
                </span>
            </div>
        </div>
    </div>

    {{-- Baris 2: Tren Arus Kas + Status Pengerjaan SPK (ApexCharts) --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-12">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 shadow-theme-xs xl:col-span-7">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Pergerakan Arus Kas</h3>
                    <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Uang masuk vs keluar 6 bulan terakhir</p>
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
            <div id="chartArusKasAdmin" class="w-full h-[290px]"></div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 shadow-theme-xs xl:col-span-5">
            <div class="mb-4">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Status Pengerjaan SPK</h3>
                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Sebaran status penyelesaian pekerjaan</p>
            </div>
            <div id="chartStatusSpkAdmin" class="w-full flex items-center justify-center my-3 min-h-[220px]"></div>
            <ul class="mt-2 space-y-2">
                @foreach ($spkStatus as $s)
                    @php
                        $ruteStatus = match ($s['label']) {
                            'Sudah Ditagihkan' => route('panel.spk.monitoring', 'billing'),
                            'Berjalan', 'Revisi Dokumen' => route('panel.spk.monitoring', 'status'),
                            default => route('panel.spk.index'),
                        };
                    @endphp
                    <li>
                        <a href="{{ $ruteStatus }}" class="flex items-center justify-between gap-2 group">
                            <span class="flex items-center gap-2.5 min-w-0">
                                <span class="h-2.5 w-2.5 shrink-0 rounded-full" style="background-color: {{ $s['warna'] }}"></span>
                                <span class="truncate text-sm text-gray-700 dark:text-gray-300 group-hover:text-brand-600 dark:group-hover:text-brand-400">{{ $s['label'] }}</span>
                            </span>
                            <span class="font-bold text-gray-900 dark:text-white angka shrink-0">{{ $s['jumlah'] }} SPK ({{ $s['persen'] }}%)</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Baris 3: Ringkasan Bulan Ini & Aksi Cepat Operasional --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-12 items-stretch">
        {{-- Ringkasan Kas Bulan Ini --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 shadow-theme-xs xl:col-span-7 flex flex-col justify-between">
            <div>
                <div class="mb-5 flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Arus Kas Bulan Ini</h3>
                        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Pemasukan, pengeluaran & selisih bersih operasional</p>
                    </div>
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        {{ now()->translatedFormat('F Y') }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-success-50/40 dark:bg-success-500/5 border border-success-200/80 dark:border-success-500/20 shadow-theme-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Uang Masuk Bulan Ini ({{ $data['bulanIni']['jumlahMasuk'] }} transaksi)</span>
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-2 break-words text-xl font-bold text-success-700 dark:text-success-400 angka">
                            {{ Format::rupiah($data['bulanIni']['masuk']) }}
                        </p>
                        @if (! empty($data['bulanIni']['bandingMasuk']))
                            <div class="mt-2.5">
                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $data['bulanIni']['bandingMasuk']['arah'] === 'turun' ? 'bg-error-50 text-error-700 dark:bg-error-500/10 dark:text-error-400' : 'bg-success-100/70 text-success-800 dark:bg-success-500/20 dark:text-success-300' }}">
                                    {{ $data['bulanIni']['bandingMasuk']['teks'] }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="p-4 rounded-xl bg-error-50/40 dark:bg-error-500/5 border border-error-200/80 dark:border-error-500/20 shadow-theme-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Uang Keluar Bulan Ini ({{ $data['bulanIni']['jumlahKeluar'] }} transaksi)</span>
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-error-100 text-error-700 dark:bg-error-500/20 dark:text-error-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-2 break-words text-xl font-bold text-error-600 dark:text-error-400 angka">
                            {{ Format::rupiah($data['bulanIni']['keluar']) }}
                        </p>
                        @if (! empty($data['bulanIni']['bandingKeluar']))
                            <div class="mt-2.5">
                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $data['bulanIni']['bandingKeluar']['arah'] === 'naik' ? 'bg-warning-50 text-warning-700 dark:bg-warning-500/10 dark:text-warning-400' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                                    {{ $data['bulanIni']['bandingKeluar']['teks'] }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kartu Saldo Bersih (Net Cashflow) Pengisi Ruang Bawah Agar Simetris --}}
            @php
                $selisihBulanIni = (float) $data['bulanIni']['masuk'] - (float) $data['bulanIni']['keluar'];
                $isDefisit = $selisihBulanIni < 0;
            @endphp
            <div class="mt-4 pt-3.5 border-t border-gray-100 dark:border-gray-800 flex flex-wrap items-center justify-between gap-3 bg-gray-50/70 dark:bg-white/[0.02] p-3.5 rounded-xl border border-gray-200/60 dark:border-gray-800">
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
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3 shadow-theme-xs xl:col-span-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Aksi Cepat Operasional</h3>
                        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Pintasan pencatatan transaksi & berkas</p>
                    </div>
                    <span class="rounded-full bg-brand-50 px-2.5 py-0.5 text-[11px] font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                        Hari Ini
                    </span>
                </div>

                {{-- Baris Mini Mutasi Hari Ini --}}
                <div class="mb-4 grid grid-cols-2 gap-2.5 rounded-xl bg-gray-50/80 p-3 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 text-xs">
                    <div>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400 block font-medium">Masuk Hari Ini</span>
                        <span class="text-sm font-bold text-success-700 dark:text-success-400 angka">
                            {{ Format::rupiah($data['hariIni']['masuk'] ?? 0) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400 block font-medium">Keluar Hari Ini</span>
                        <span class="text-sm font-bold text-error-600 dark:text-error-400 angka">
                            {{ Format::rupiah($data['hariIni']['keluar'] ?? 0) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('panel.spk.create') }}"
                    class="group flex flex-col justify-between rounded-xl border border-gray-200 bg-white p-3.5 shadow-theme-xs transition-all duration-200 hover:-translate-y-0.5 hover:border-brand-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-800/80 dark:hover:border-brand-500/30">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-800 group-hover:text-brand-600 dark:text-gray-200 dark:group-hover:text-brand-400">
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
                    class="group flex flex-col justify-between rounded-xl border border-gray-200 bg-white p-3.5 shadow-theme-xs transition-all duration-200 hover:-translate-y-0.5 hover:border-success-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-800/80 dark:hover:border-success-500/30">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-800 group-hover:text-success-700 dark:text-gray-200 dark:group-hover:text-success-400">
                            Uang Masuk
                        </span>
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </span>
                    </div>
                    <span class="mt-2 text-[11px] text-gray-500 dark:text-gray-400">Termin / pencairan</span>
                </a>

                <a href="{{ route('panel.cash-out.create') }}"
                    class="group flex flex-col justify-between rounded-xl border border-gray-200 bg-white p-3.5 shadow-theme-xs transition-all duration-200 hover:-translate-y-0.5 hover:border-error-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-800/80 dark:hover:border-error-500/30">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-800 group-hover:text-error-600 dark:text-gray-200 dark:group-hover:text-error-400">
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
                    class="group flex flex-col justify-between rounded-xl border border-gray-200 bg-white p-3.5 shadow-theme-xs transition-all duration-200 hover:-translate-y-0.5 hover:border-purple-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-800/80 dark:hover:border-purple-500/30">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-800 group-hover:text-purple-600 dark:text-gray-200 dark:group-hover:text-purple-400">
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

    {{-- Baris 4: Dua Kolom Operasional (Transaksi Terbaru & SPK Berjalan) - TailAdmin Card Table Style --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-2">

        {{-- Transaksi Terbaru --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3 shadow-theme-xs overflow-hidden flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Transaksi Terbaru</h3>
                        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Arus kas masuk & keluar terakhir</p>
                    </div>
                    <a href="{{ route('panel.reports') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                        <span>Lihat Semua</span>
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>

                @if ($data['terbaru'] === [])
                    <div class="p-8 text-center text-sm text-gray-500 dark:text-gray-400">
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
                                    <span class="inline-flex items-center rounded px-1.5 py-0.2 text-[9px] font-bold uppercase tracking-wider {{ $trx['jenis'] === 'masuk' ? 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-400' : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-400' }}">
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
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3 shadow-theme-xs overflow-hidden flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">SPK Berjalan Aktif</h3>
                        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Pekerjaan lapangan sedang berlangsung</p>
                    </div>
                    <a href="{{ route('panel.spk.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                        <span>Lihat Semua</span>
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>

                @if ($data['spkBerjalan'] === [])
                    <div class="p-8 text-center text-sm text-gray-500 dark:text-gray-400">
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
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $spk['lewat'] ? 'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' }}">
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
    {{-- Baris 5: SPK Mendesak & Perlu Tindak Lanjut --}}
    @if (! empty($data['spkPerluPerhatian']))
        <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-12 items-stretch">
            {{-- Tabel SPK Perlu Tindak Lanjut --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3 shadow-theme-xs overflow-hidden xl:col-span-12 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                        <div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">SPK Mendesak & Perlu Tindak Lanjut</h3>
                            <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Prioritas operasional: pekerjaan lewat tenggat, revisi berkas, atau siap ditagihkan</p>
                        </div>
                        <a href="{{ route('panel.spk.monitoring', 'status') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                            <span>Monitoring</span>
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>

                    @if (($data['spkPerluPerhatian'] ?? []) === [])
                        <div class="p-8 text-center text-sm text-gray-500 dark:text-gray-400">
                            Tidak ada SPK mendesak saat ini. Semua pekerjaan aman.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-white/[0.02]">
                                        <th class="px-5 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">SPK & Mitra</th>
                                        <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status Lapangan</th>
                                        <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tenggat Waktu</th>
                                        <th class="px-5 py-3 text-end text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nilai SPK</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs">
                                    @foreach ($data['spkPerluPerhatian'] as $perhatian)
                                        <tr class="hover:bg-gray-50/60 dark:hover:bg-white/[0.02] transition-colors">
                                            <td class="px-5 py-3.5">
                                                <a href="{{ route('panel.spk.show', $perhatian['id']) }}" class="font-semibold text-brand-600 hover:underline dark:text-brand-400 block">
                                                    {{ $perhatian['nomor_spk'] }}
                                                </a>
                                                <span class="text-[11px] text-gray-500 dark:text-gray-400 truncate block max-w-xs">
                                                    {{ $perhatian['mitra'] }} &middot; {{ $perhatian['pekerjaan'] }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3.5">
                                                <span class="inline-flex items-center rounded-lg px-2 py-0.5 text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                                    {{ $perhatian['status_spk'] }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3.5">
                                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $perhatian['lewat'] ? 'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-400' : 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-400' }}">
                                                    {{ $perhatian['label_tenggat'] }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-3.5 text-end font-bold text-gray-900 dark:text-white angka">
                                                {{ Format::rupiah($perhatian['nilai']) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif



    @push('scripts')
    <script>
        (function() {
            const isDark = () => document.documentElement.classList.contains('dark');
            let chartArusKas = null;
            let chartStatusSpk = null;

            function initAdminCharts() {
                if (typeof window.ApexCharts === 'undefined') return;

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
                            fontFamily: "Outfit, sans-serif",
                            type: 'line',
                            height: 290,
                            background: 'transparent',
                            toolbar: { show: false },
                            zoom: { enabled: false }
                        },
                        theme: { mode: isDark() ? 'dark' : 'light' },
                        stroke: {
                            curve: 'smooth',
                            width: 3
                        },
                        markers: {
                            size: 5,
                            strokeWidth: 3,
                            hover: { size: 6 }
                        },
                        dataLabels: { enabled: false },
                        fill: { type: 'solid', opacity: 1 },
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

                const elStatusSpk = document.querySelector('#chartStatusSpkAdmin');
                if (elStatusSpk && !elStatusSpk.dataset.rendered) {
                    elStatusSpk.dataset.rendered = 'true';
                    const optionsStatusSpk = {
                        series: @json($spkStatusJumlah),
                        labels: @json($spkStatusLabels),
                        colors: @json($spkStatusWarna),
                        chart: {
                            fontFamily: "Outfit, sans-serif",
                            type: 'donut',
                            height: 230,
                            background: 'transparent'
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
                                            fontWeight: 700,
                                            fontFamily: 'Outfit, sans-serif'
                                        },
                                        total: {
                                            show: true,
                                            label: 'Total SPK',
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
                        },
                        stroke: { colors: [isDark() ? '#111827' : '#ffffff'], width: 2 },
                        tooltip: {
                            theme: isDark() ? 'dark' : 'light',
                            y: { formatter: (val) => val + ' SPK' }
                        }
                    };
                    chartStatusSpk = new window.ApexCharts(elStatusSpk, optionsStatusSpk);
                    chartStatusSpk.render();
                }
            }

            function syncTema() {
                const dark = isDark();
                const mode = dark ? 'dark' : 'light';
                chartArusKas?.updateOptions({
                    theme: { mode },
                    grid: { borderColor: dark ? '#1E2640' : '#F3F4F6' },
                    tooltip: { theme: mode }
                });
                chartStatusSpk?.updateOptions({
                    theme: { mode },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    value: { color: dark ? '#F8FAFC' : '#1D2939' },
                                    total: { color: dark ? '#98A2B3' : '#64748B' }
                                }
                            }
                        }
                    },
                    stroke: { colors: [dark ? '#111827' : '#ffffff'], width: 2 },
                    tooltip: { theme: mode }
                });
            }
            new MutationObserver(syncTema).observe(document.documentElement, {
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