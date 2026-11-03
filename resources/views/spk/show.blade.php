{{--
    Detail / Preview SPK (FR-SPK-005): Pusat kontrol pekerjaan & finansial SPK
--}}
@use('App\Support\Format')
@use('App\Support\Nota')
@use('App\Enums\StatusSpk')
@use('App\Enums\StatusTagihan')

@php
    $kelasKartu = 'rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs';
    $kelasLabel = 'text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400';
    $kelasNilai = 'mt-1 text-base font-bold text-gray-900 dark:text-white';

    $kelasBadge = [
        'gray' => 'bg-gray-100 text-gray-700 dark:bg-white/10 dark:text-gray-300',
        'info' => 'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300',
        'primary' => 'bg-brand-50 text-brand-700 dark:bg-brand-500/15 dark:text-brand-300',
        'success' => 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500',
        'warning' => 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-500',
        'danger' => 'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-500',
    ];
    $badge = static fn (?string $warna): string => $kelasBadge[$warna ?? 'gray'] ?? $kelasBadge['gray'];

    $sisa = $spk->sisaTagih();
    $diterima = $spk->totalPenerimaan();
    $totalKeluar = (float) $uangKeluar->sum('jumlah');

    // Stepper alur pekerjaan
    $urutanStatusSpk = [
        StatusSpk::Draft->value => 1,
        StatusSpk::Terbit->value => 2,
        StatusSpk::Berjalan->value => 3,
        StatusSpk::Selesai->value => 4,
        StatusSpk::SudahDitagihkan->value => 4,
    ];
    $dibatalkan = $spk->status_spk === StatusSpk::Dibatalkan;
    $posisiStatus = $dibatalkan ? 0 : ($urutanStatusSpk[$spk->status_spk?->value ?? 'draft'] ?? 1);

    // Alur tagihan
    $urutanTagihan = [
        StatusTagihan::BelumDitagihkan->value => 1,
        StatusTagihan::SudahDitagihkan->value => 2,
        StatusTagihan::RevisiDokumen->value => 2,
        StatusTagihan::MenungguPembayaran->value => 3,
        StatusTagihan::Dibayar->value => 4,
    ];
    $posisiTagihan = $urutanTagihan[$spk->status_tagihan?->value ?? 'belum_ditagihkan'] ?? 1;

    $nilaiKontrak = (float) $spk->nilai_spk;
    $rasioBiaya = $nilaiKontrak > 0 ? min(100, round(($totalKeluar / $nilaiKontrak) * 100, 1)) : 0;
    $persenBiayaAsli = $nilaiKontrak > 0 ? round(($totalKeluar / $nilaiKontrak) * 100, 1) : 0;
    $warnaText = $persenBiayaAsli > 100 ? 'text-error-600 dark:text-error-400' : ($persenBiayaAsli > 80 ? 'text-warning-600 dark:text-warning-400' : 'text-success-600 dark:text-success-400');
    $warnaBar = $persenBiayaAsli > 100 ? 'bg-error-500' : ($persenBiayaAsli > 80 ? 'bg-warning-500' : 'bg-success-500');
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan" :kembali="$kembali ?? route('panel.spk.index')">
    <div class="space-y-6">

        {{-- 1. Header Toolbar & Tindakan Cepat Navigasi --}}
        <div class="{{ $kelasKartu }} p-5 md:p-6">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="flex flex-wrap items-center gap-2.5">
                        <span class="angka text-xl md:text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $spk->nomor_spk }}
                        </span>
                        <span class="inline-flex rounded-lg px-2.5 py-0.5 text-xs font-semibold {{ $badge($spk->status_spk?->warnaBadge()) }}">
                            {{ $spk->status_spk?->label() ?? 'Draft' }}
                        </span>
                        <span class="inline-flex rounded-lg px-2.5 py-0.5 text-xs font-semibold {{ $badge($spk->status_tagihan?->warnaBadge()) }}">
                            {{ $spk->status_tagihan?->label() ?? 'Belum Ditagihkan' }}
                        </span>
                    </div>
                    <p class="mt-1.5 text-theme-sm text-gray-600 dark:text-gray-300">
                        {{ $spk->nama_pekerjaan }} &middot; <strong class="text-gray-800 dark:text-white">{{ $spk->mitra?->nama ?? 'Tanpa Mitra' }}</strong>
                    </p>
                </div>

                @if ($bolehUbah)
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('panel.spk.edit', ['spk' => $spk, 'asal' => 'show']) }}"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition">
                            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                            Ubah SPK
                        </a>
                        <a href="{{ route('panel.spk.status', ['spk' => $spk, 'asal' => 'show']) }}"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-amber-200 bg-amber-50 px-3.5 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-100 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-400 transition"
                            title="Ubah tahapan pengerjaan">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                            Ubah Status Pekerjaan
                        </a>
                        <a href="{{ route('panel.spk.bast', $spk) }}" target="_blank"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300 transition"
                            title="Cetak Berita Acara Serah Terima (BAST) Resmi">
                            <svg class="h-3.5 w-3.5 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            Cetak BAST
                        </a>

                        <a href="{{ route('panel.spk.billing', ['spk' => $spk, 'asal' => 'show']) }}"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-brand-200 bg-brand-50 px-3.5 py-2 text-xs font-semibold text-brand-700 hover:bg-brand-100 dark:border-brand-500/30 dark:bg-brand-500/10 dark:text-brand-400 transition"
                            title="Ubah status penagihan & pembayaran">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6H2.25m0 0v8.25m0 0a60.073 60.073 0 0 0 15.797 2.101c.727.198 1.453-.342 1.453-1.096V6.75A.75.75 0 0 0 18.75 6H18m-1.5-1.5H3.75" />
                            </svg>
                            Ubah Status Tagihan
                        </a>
                        <form method="POST" action="{{ route('panel.spk.destroy', $spk) }}"
                            onsubmit="return konfirmasiAksi(this, 'Hapus SPK {{ addslashes($spk->nomor_spk) }}? Data akan dipindahkan ke tempat sampah dan dapat dipulihkan kapan saja.');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-1 rounded-xl px-2.5 py-2 text-xs font-semibold text-error-600 hover:bg-error-50 dark:text-error-400 dark:hover:bg-error-500/10 transition"
                                title="Hapus SPK ini">
                                Hapus
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Alur Status Visual (Workflow Progress) --}}
            <div class="mt-6 pt-5 border-t border-gray-100 dark:border-gray-800">
                <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 block mb-3">
                    Alur Progres Pekerjaan
                </span>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    @foreach (['draft' => '1. Draft', 'terbit' => '2. Terbit', 'berjalan' => '3. Berjalan', 'selesai' => '4. Selesai'] as $key => $lbl)
                        @php
                            $stepNum = $urutanStatusSpk[$key] ?? 1;
                            $isCurrent = $spk->status_spk?->value === $key;
                            $isDone = $posisiStatus >= $stepNum;
                        @endphp
                        <div class="flex items-center gap-2 p-2.5 rounded-xl border text-xs font-semibold transition {{ $isCurrent ? 'border-brand-500 bg-brand-50/50 text-brand-700 dark:border-brand-400 dark:bg-brand-500/10 dark:text-brand-300' : ($isDone ? 'border-gray-200 bg-gray-50 text-gray-800 dark:border-gray-800 dark:bg-white/[0.02] dark:text-gray-300' : 'border-dashed border-gray-200 text-gray-400 dark:border-gray-800') }}">
                            <span class="flex h-5 w-5 items-center justify-center rounded-full text-[10px] {{ $isDone ? 'bg-brand-500 text-white' : 'bg-gray-200 text-gray-600 dark:bg-gray-800 dark:text-gray-400' }}">
                                {{ $isDone ? '✓' : $stepNum }}
                            </span>
                            <span>{{ $lbl }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 2. Ringkasan Finansial Utama (4 Kartu Stat TailAdmin) --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="{{ $kelasKartu }} p-5">
                <span class="{{ $kelasLabel }}">Nilai Pagu SPK</span>
                <h4 class="{{ $kelasNilai }} angka text-gray-900 dark:text-white">
                    {{ Format::rupiah((float) $spk->nilai_spk) }}
                </h4>
                <span class="mt-1 block text-theme-xs text-gray-500 dark:text-gray-400">Total nilai kontrak</span>
            </div>

            <div class="{{ $kelasKartu }} p-5">
                <span class="{{ $kelasLabel }}">Sudah Diterima</span>
                <h4 class="{{ $kelasNilai }} angka text-success-600 dark:text-success-500">
                    {{ Format::rupiah($diterima) }}
                </h4>
                <span class="mt-1 block text-theme-xs text-gray-500 dark:text-gray-400">Penerimaan dari PLN/Mitra</span>
            </div>

            <div class="{{ $kelasKartu }} p-5">
                <span class="{{ $kelasLabel }}">Sisa Piutang</span>
                <h4 class="{{ $kelasNilai }} angka {{ $sisa > 0.01 ? 'text-warning-600 dark:text-warning-500' : 'text-success-600 dark:text-success-500' }}">
                    {{ Format::rupiah($sisa) }}
                </h4>
                <span class="mt-1 block text-theme-xs text-gray-500 dark:text-gray-400">Belum dibayarkan</span>
            </div>

            <div class="{{ $kelasKartu }} p-5">
                <span class="{{ $kelasLabel }}">Pengeluaran Lapangan</span>
                <h4 class="{{ $kelasNilai }} angka text-error-600 dark:text-error-500">
                    {{ Format::rupiah($totalKeluar) }}
                </h4>
                <span class="mt-1 block text-theme-xs text-gray-500 dark:text-gray-400">Biaya material & subkon</span>
            </div>
        </div>

        {{-- 3. Monitoring Biaya Lapangan vs Nilai Kontrak --}}
        <section class="{{ $kelasKartu }} p-5">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                <div>
                    <h3 class="text-theme-sm font-semibold text-gray-800 dark:text-white/90">
                        Monitoring Biaya Lapangan vs Nilai Kontrak
                    </h3>
                    <p class="text-theme-xs text-gray-500 dark:text-gray-400">
                        Kontrol realisasi pengeluaran material & subkon terhadap pagu SPK
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-theme-sm font-bold {{ $warnaText }}">
                        {{ $persenBiayaAsli }}%
                    </span>
                    <span class="text-theme-xs text-gray-400">terpakai</span>
                </div>
            </div>

            <div class="h-2.5 w-full rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                <div class="h-full rounded-full transition-all duration-500 {{ $warnaBar }}"
                    style="width: {{ $rasioBiaya }}%"></div>
            </div>

            <div class="mt-3 flex flex-wrap items-center justify-between gap-4 text-theme-xs">
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Total Biaya Dikeluarkan:</span>
                    <strong class="font-bold text-gray-800 dark:text-white angka">{{ Format::rupiah($totalKeluar) }}</strong>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Pagu Kontrak SPK:</span>
                    <strong class="font-bold text-gray-800 dark:text-white angka">{{ Format::rupiah($nilaiKontrak) }}</strong>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Sisa Pagu Anggaran:</span>
                    <strong class="font-bold {{ $nilaiKontrak - $totalKeluar < 0 ? 'text-error-600 dark:text-error-400' : 'text-gray-800 dark:text-white' }} angka">
                        {{ Format::rupiah(max(0, $nilaiKontrak - $totalKeluar)) }}
                    </strong>
                </div>
            </div>
        </section>

        {{-- 4. Detail Data SPK & Informasi Administrasi --}}
        <div class="grid gap-6 xl:grid-cols-3">
            <section class="{{ $kelasKartu }} p-5 xl:col-span-2">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white border-b border-gray-100 pb-3 dark:border-gray-800">
                    Informasi Kontrak & Lokasi
                </h3>

                <dl class="mt-4 grid gap-4 sm:grid-cols-3">
                    <div>
                        <dt class="{{ $kelasLabel }}">Nomor SPK</dt>
                        <dd class="{{ $kelasNilai }} angka">{{ $spk->nomor_spk }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="{{ $kelasLabel }}">Nama Pekerjaan</dt>
                        <dd class="{{ $kelasNilai }}">{{ $spk->nama_pekerjaan }}</dd>
                    </div>
                    <div>
                        <dt class="{{ $kelasLabel }}">Pemberi Kerja / Mitra</dt>
                        <dd class="{{ $kelasNilai }}">{{ $spk->mitra?->nama ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="{{ $kelasLabel }}">Lokasi Pekerjaan</dt>
                        <dd class="{{ $kelasNilai }}">{{ $spk->lokasi ?: '—' }}</dd>
                    </div>
                    <div>
                        <dt class="{{ $kelasLabel }}">Pelaksana Pekerjaan</dt>
                        <dd class="mt-1">
                            <span class="{{ $badge($spk->dikerjakan_oleh?->warnaBadge()) }} inline-flex rounded px-2 py-0.5 text-xs font-semibold">
                                {{ $spk->dikerjakan_oleh?->label() ?? '—' }}
                            </span>
                            @if ($spk->subkon)
                                <p class="mt-1 text-theme-xs font-medium text-gray-600 dark:text-gray-300">
                                    Subkon: {{ $spk->subkon->nama }}
                                </p>
                            @endif
                        </dd>
                    </div>
                </dl>
            </section>

            {{-- Dokumen & Jadwal Tenggat --}}
            <section class="{{ $kelasKartu }} p-5 flex flex-col justify-between">
                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white border-b border-gray-100 pb-3 dark:border-gray-800">
                        Jadwal & Berkas
                    </h3>

                    <dl class="mt-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <dt class="{{ $kelasLabel }}">Tanggal Mulai</dt>
                            <dd class="text-theme-sm font-semibold text-gray-800 dark:text-white">
                                {{ $spk->tanggal_spk?->format('d/m/Y') ?? '—' }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="{{ $kelasLabel }}">Batas Waktu (Tenggat)</dt>
                            <dd class="text-theme-sm font-bold {{ $spk->tanggal_akhir < now()->startOfDay() && ! $spk->sudahSelesai() ? 'text-error-600 dark:text-error-400' : 'text-gray-800 dark:text-white' }}">
                                {{ $spk->tenggatEfektif()?->format('d/m/Y') ?? '—' }}
                            </dd>
                        </div>
                    </dl>

                    @if ($spk->dokumen)
                        <div class="mt-5 border-t border-gray-100 pt-4 dark:border-gray-800">
                            <p class="{{ $kelasLabel }}">Dokumen SPK Tersimpan ({{ count($spk->dokumen) }})</p>
                            <ul class="mt-2 space-y-2">
                                @foreach ($spk->dokumen as $path)
                                    <li>
                                        <a href="{{ Nota::url($path) }}" target="_blank" rel="noopener"
                                            class="inline-flex items-center gap-2 truncate text-theme-xs font-semibold text-brand-600 hover:underline dark:text-brand-400"
                                            title="{{ basename($path) }}">
                                            <svg class="h-4 w-4 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                                            </svg>
                                            <span class="truncate">{{ basename($path) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </section>
        </div>

        {{-- 5. Dua Tabel Riwayat Keuangan: Uang Masuk & Uang Keluar --}}
        <div class="grid gap-6 xl:grid-cols-2">
            {{-- Uang Masuk --}}
            <section class="{{ $kelasKartu }} overflow-hidden">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Riwayat Uang Masuk</h3>
                        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                            {{ $uangMasuk->count() }} transaksi &middot; Total {{ Format::rupiah($diterima) }}
                        </p>
                    </div>
                    @if ($bolehUbah)
                        <a href="{{ route('panel.cash-in.create', ['spk_id' => $spk->id]) }}"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-success-200 bg-success-50 px-3 py-1.5 text-xs font-semibold text-success-700 hover:bg-success-100 dark:border-success-500/30 dark:bg-success-500/10 dark:text-success-400 transition">
                            + Uang Masuk
                        </a>
                    @endif
                </div>

                @if ($uangMasuk->isEmpty())
                    <p class="px-5 py-8 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                        Belum ada uang masuk untuk SPK ini.
                    </p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-theme-sm">
                            <thead>
                                <tr class="border-b border-gray-100 text-theme-xs uppercase text-gray-500 dark:border-gray-800 dark:text-gray-400 bg-gray-50/50 dark:bg-white/[0.01]">
                                    <th class="px-4 py-2.5">Tanggal</th>
                                    <th class="px-3 py-2.5">Akun</th>
                                    <th class="px-3 py-2.5">Keterangan</th>
                                    <th class="px-4 py-2.5 text-right">Jumlah</th>
                                    <th class="w-20 px-3 py-2.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($uangMasuk as $masuk)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02]">
                                        <td class="px-4 py-2.5 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                            {{ $masuk->tanggal?->format('d/m/Y') ?? '—' }}
                                        </td>
                                        <td class="px-3 py-2.5 text-gray-700 dark:text-gray-300">{{ $masuk->akun?->label() ?? '—' }}</td>
                                        <td class="px-3 py-2.5 text-gray-600 dark:text-gray-400">{{ $masuk->keterangan ?: '—' }}</td>
                                        <td class="px-4 py-2.5 text-right font-bold angka text-success-600 dark:text-success-500">
                                            + {{ Format::rupiah($masuk->jumlah) }}
                                        </td>
                                        <td class="px-3 py-2.5 text-right">
                                            <a href="{{ route('panel.cash-in.kuitansi', $masuk) }}"
                                                class="inline-flex items-center gap-1 rounded-lg border border-brand-200 bg-brand-50 px-2 py-1 text-[11px] font-semibold text-brand-700 hover:bg-brand-100 dark:border-brand-500/30 dark:bg-brand-500/10 dark:text-brand-400 transition"
                                                title="Cetak Kuitansi Resmi PDF">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.076-.641-2.127-1.19-3.134a9.75 9.75 0 0 1-.77-2.327A5.99 5.99 0 0 1 12 3c1.78 0 3.376.777 4.48 2.02.44.498.81 1.05 1.09 1.648.55 1.007.95 2.058 1.19 3.134m-12.04 0c.34 1.52.88 2.97 1.59 4.31m8.86-4.31c.34 1.52.88 2.97 1.59 4.31M12 18.75a3 3 0 0 0 3-3V12a3 3 0 0 0-6 0v3.75a3 3 0 0 0 3 3Z" />
                                                </svg>
                                                Kuitansi
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            {{-- Uang Keluar --}}
            <section class="{{ $kelasKartu }} overflow-hidden">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Riwayat Uang Keluar</h3>
                        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                            {{ $uangKeluar->count() }} transaksi &middot; Total {{ Format::rupiah($totalKeluar) }}
                        </p>
                    </div>
                    @if ($bolehUbah)
                        <a href="{{ route('panel.cash-out.create') }}"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-error-200 bg-error-50 px-3 py-1.5 text-xs font-semibold text-error-700 hover:bg-error-100 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-400 transition">
                            + Uang Keluar
                        </a>
                    @endif
                </div>

                @if ($uangKeluar->isEmpty())
                    <p class="px-5 py-8 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                        Belum ada uang keluar tercatat untuk SPK ini.
                    </p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-theme-sm">
                            <thead>
                                <tr class="border-b border-gray-100 text-theme-xs uppercase text-gray-500 dark:border-gray-800 dark:text-gray-400 bg-gray-50/50 dark:bg-white/[0.01]">
                                    <th class="px-4 py-2.5">Tanggal</th>
                                    <th class="px-3 py-2.5">Kategori</th>
                                    <th class="px-3 py-2.5">Penerima</th>
                                    <th class="px-4 py-2.5 text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($uangKeluar as $keluar)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02]">
                                        <td class="px-4 py-2.5 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                            {{ $keluar->tanggal?->format('d/m/Y') ?? '—' }}
                                        </td>
                                        <td class="px-3 py-2.5 text-gray-700 dark:text-gray-300">{{ $keluar->detail_kategori ?: ($keluar->kategori ?: '—') }}</td>
                                        <td class="px-3 py-2.5 text-gray-600 dark:text-gray-400">{{ $keluar->penerima ?: '—' }}</td>
                                        <td class="px-4 py-2.5 text-right font-bold angka text-error-600 dark:text-error-500">
                                            − {{ Format::rupiah($keluar->jumlah) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </div>

    </div>
</x-layouts.app>
