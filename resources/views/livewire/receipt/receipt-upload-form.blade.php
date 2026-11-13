@php
    $kelasInput = 'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-3.5 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-500 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-500';
    $kelasLabel = 'mb-1.5 block text-theme-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300';
    $kelasKartu = 'rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] md:p-6';
@endphp

<div class="space-y-5" @if ($sedangProses) wire:poll.2s="periksaHasilOcr" @endif>

    {{-- Keadaan antrean OCR (audit O-2/O-3): worker mati tidak lagi tak terlihat --}}
    @php($antrean = \App\Support\AntreanOcr::ringkasan())
    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
            <p class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Antrean OCR</p>
            <dl class="flex flex-wrap items-center gap-x-5 gap-y-1 text-theme-xs">
                <div class="flex items-baseline gap-1.5">
                    <dt class="text-gray-500 dark:text-gray-400">Menunggu</dt>
                    <dd class="angka font-semibold text-gray-900 dark:text-white">{{ $antrean['menunggu'] }}</dd>
                </div>
                <div class="flex items-baseline gap-1.5">
                    <dt class="text-gray-500 dark:text-gray-400">Gagal</dt>
                    <dd class="angka font-semibold {{ $antrean['gagal'] > 0 ? 'text-error-600 dark:text-error-400' : 'text-gray-900 dark:text-white' }}">{{ $antrean['gagal'] }}</dd>
                </div>
                @if ($antrean['tertua_menit'] !== null)
                    <div class="flex items-baseline gap-1.5">
                        <dt class="text-gray-500 dark:text-gray-400">Tertua</dt>
                        <dd class="angka font-semibold text-gray-900 dark:text-white">{{ $antrean['tertua_menit'] }} menit</dd>
                    </div>
                @endif
            </dl>
        </div>
        @if ($antrean['tertahan'] > 0)
            <p class="mt-2 text-theme-xs font-medium text-error-600 dark:text-error-400">
                {{ $antrean['tertahan'] }} pekerjaan tertahan lebih dari {{ \App\Support\AntreanOcr::BATAS_TERTAHAN_MENIT }} menit.
                Pastikan layanan antrean (bks-queue) hidup di server.
            </p>
        @endif
    </div>


    {{-- Kotak Unggah Berkas Utama & Pemilih Jenis Transaksi --}}
    <div class="{{ $kelasKartu }}">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0 max-w-prose">
                <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">
                    Unggah Berkas Nota &amp; Bukti Transaksi
                </h2>
                <p class="mt-1.5 text-theme-xs leading-relaxed text-gray-500 dark:text-gray-400">
                    PDF, JPG, PNG, atau WEBP, maksimal 20MB. Nota satuan maupun beberapa nota dalam satu PDF dibaca otomatis.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:shrink-0">
                <button type="button" wire:click="tambahNotaManual" wire:loading.attr="disabled"
                    class="inline-flex h-11 items-center justify-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3.5 text-theme-xs font-semibold text-gray-700 shadow-theme-xs transition hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Input Manual Tanpa OCR</span>
                </button>
                <label class="inline-flex h-11 cursor-pointer items-center justify-center gap-2 rounded-lg bg-brand-600 px-4 text-theme-xs font-semibold text-white shadow-theme-xs transition hover:bg-brand-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    <span>Pilih Berkas Nota (OCR)</span>
                    <input type="file" wire:model="berkasNota" accept=".pdf,image/*" class="sr-only">
                </label>
            </div>
        </div>

        {{-- Tujuan Pembukuan: satu baris sendiri agar kartu tidak padat --}}
        <div class="mt-5 flex flex-col gap-2.5 border-t border-gray-100 pt-4 dark:border-gray-800 sm:flex-row sm:items-center sm:gap-3">
            <span class="text-theme-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Tujuan Pembukuan</span>
            <div class="inline-flex w-full rounded-lg bg-gray-100 p-1 text-theme-xs font-medium dark:bg-gray-800 sm:w-auto">
                <button type="button" wire:click="$set('jenisTransaksi', 'keluar')" aria-pressed="{{ $jenisTransaksi === 'keluar' ? 'true' : 'false' }}"
                    class="rounded-md px-3.5 py-3.5 transition {{ $jenisTransaksi === 'keluar' ? 'bg-white font-semibold text-gray-900 shadow-theme-xs dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                    Uang Keluar
                </button>
                <button type="button" wire:click="$set('jenisTransaksi', 'masuk')" aria-pressed="{{ $jenisTransaksi === 'masuk' ? 'true' : 'false' }}"
                    class="rounded-md px-3.5 py-3.5 transition {{ $jenisTransaksi === 'masuk' ? 'bg-white font-semibold text-gray-900 shadow-theme-xs dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                    Uang Masuk
                </button>
            </div>
        </div>

        {{-- Status Proses: satu blok, satu keadaan, tanpa emoji --}}
        @if ($sedangProses)
            <div class="mt-4 rounded-lg border border-brand-200 bg-brand-50 p-4 dark:border-brand-500/20 dark:bg-brand-500/10">
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-4 w-4 shrink-0 animate-spin text-brand-600 dark:text-brand-400" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <div class="min-w-0">
                        <p class="text-theme-sm font-semibold text-brand-800 dark:text-brand-300">OCR sedang berjalan</p>
                        <p class="mt-0.5 text-theme-xs text-brand-700 dark:text-brand-400">
                            Berkas sudah diterima server. Hasil ekstraksi muncul otomatis di bawah; halaman boleh ditinggal tanpa membatalkan proses.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div wire:loading wire:target="berkasNota" class="mt-4 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-2.5 text-theme-xs font-medium text-gray-700 dark:text-gray-300">
                <svg class="h-4 w-4 animate-spin text-brand-600 dark:text-brand-400" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Mengunggah berkas nota ke server…</span>
            </div>
        </div>

        @if ($pesanStatus && ! $sedangProses)
            <div class="mt-4 flex items-start gap-2.5 rounded-lg border border-gray-200 bg-gray-50 p-3.5 text-theme-xs text-gray-700 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300">
                <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ $pesanStatus }}</span>
            </div>
        @endif

        @error('berkasNota')
            <p class="mt-2 text-theme-xs text-error-600 dark:text-error-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Daftar Kartu Nota yang Terdeteksi / Form Input Dinamis --}}
    @if (count($daftarNota) > 0)
        <div class="space-y-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="min-w-0">
                    <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">
                        Hasil Ekstraksi &amp; Isian Nota ({{ count($daftarNota) }} nota)
                    </h2>
                    <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                        Periksa kembali nominal, tanggal, dan nama toko hasil pembacaan sebelum disimpan.
                    </p>
                </div>

                <button type="button" wire:click="tambahNotaManual"
                    class="inline-flex h-10 shrink-0 items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3.5 text-theme-xs font-semibold text-gray-700 shadow-theme-xs transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Kartu Nota</span>
                </button>
            </div>

            <div class="grid grid-cols-1 gap-5">
                @foreach ($daftarNota as $idx => $nota)
                    <div wire:key="nota-item-{{ $nota['id'] }}" class="{{ $kelasKartu }}" x-data="{ perbesar: false }">
                        <div class="mb-4 flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 pb-3 dark:border-gray-800">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center rounded-lg bg-gray-100 px-2.5 py-1 text-theme-xs font-semibold text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                                    Nota #{{ $nota['ke'] ?? ($idx + 1) }}
                                </span>
                                <span class="inline-flex items-center rounded-lg px-2 py-1 text-[11px] font-medium {{ count($daftarNota) > 1 ? 'bg-brand-50 text-brand-700 dark:bg-brand-500/10 dark:text-brand-300' : 'bg-success-50 text-success-700 dark:bg-success-500/10 dark:text-success-400' }}">
                                    {{ count($daftarNota) > 1 ? 'dari berkas tumpuk' : 'nota satuan' }}
                                </span>
                            </div>

                            <button type="button" wire:click="hapusBaris({{ $idx }})"
                                class="inline-flex items-center gap-1 text-theme-xs font-medium text-error-600 dark:text-error-400 transition hover:underline dark:text-error-500">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus
                            </button>
                        </div>

                        <div class="grid grid-cols-1 gap-5 lg:grid-cols-12">
                            {{-- Pratinjau potongan nota: tidak ada <img> tanpa src, gambar dipasang lewat JS --}}
                            <div class="flex flex-col items-center justify-center gap-3 rounded-lg border border-gray-200 bg-gray-50 p-3 lg:col-span-5 dark:border-gray-800 dark:bg-gray-950/40">
                                @if (! empty($nota['potongan']))
                                    <button type="button" @click="perbesar = true"
                                        class="group block w-full rounded-lg border border-gray-200 bg-white p-1 dark:border-gray-800 dark:bg-gray-900"
                                        title="Perbesar potongan nota">
                                        <img src="{{ $nota['potongan'] }}" alt="Potongan nota {{ $nota['ke'] ?? ($idx + 1) }}" loading="lazy"
                                            class="mx-auto max-h-[360px] w-full rounded-md object-contain">
                                    </button>
                                    <div class="flex w-full items-center justify-between px-1 text-[11px]">
                                        <span class="text-gray-500 dark:text-gray-400">Klik untuk memperbesar</span>
                                        <a href="{{ $nota['potongan'] }}" target="_blank" rel="noopener"
                                            class="font-semibold text-brand-600 hover:underline dark:text-brand-400">
                                            Buka ukuran penuh
                                        </a>
                                    </div>

                                    <div x-show="perbesar" x-cloak x-transition.opacity
                                        class="fixed inset-0 z-99999 flex items-center justify-center bg-gray-900/70 p-4 backdrop-blur-xs"
                                        @click.self="perbesar = false" @keydown.escape.window="perbesar = false">
                                        <template x-if="perbesar">
                                            <img :src="@js($nota['potongan'])" alt="Potongan nota {{ $nota['ke'] ?? ($idx + 1) }}"
                                                class="max-h-[88vh] max-w-full rounded-lg object-contain shadow-2xl">
                                        </template>
                                        <button type="button" @click="perbesar = false"
                                            class="absolute right-4 top-4 inline-flex h-9 items-center rounded-lg bg-white px-3 text-theme-xs font-semibold text-gray-700 shadow-theme-xs dark:bg-gray-800 dark:text-gray-200">
                                            Tutup
                                        </button>
                                    </div>
                                @else
                                    <div class="px-6 py-8 text-center">
                                        <svg class="mx-auto h-10 w-10 text-gray-500 dark:text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="mt-2 block text-theme-xs text-gray-500 dark:text-gray-400">
                                            Potongan nota tidak tersedia — berkas utama tetap tersimpan sebagai lampiran.
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Isian Data Form Nota --}}
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:col-span-7">
                                <div>
                                    <label class="{{ $kelasLabel }}">
                                        Nominal Rupiah (Rp) <span class="text-error-600 dark:text-error-400 dark:text-error-500">*</span>
                                    </label>
                                    <input type="text" inputmode="numeric" autocomplete="off" placeholder="0"
                                        wire:model.defer="daftarNota.{{ $idx }}.nominal"
                                        x-init="$el.value = ($el.value || '').replace(/\D+/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"
                                        x-on:input="$el.value = $el.value.replace(/\D+/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"
                                        class="{{ $kelasInput }} angka font-semibold">
                                    @error('daftarNota.'.$idx.'.nominal')
                                        <span class="mt-1 block text-theme-xs text-error-600 dark:text-error-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="{{ $kelasLabel }}">
                                        Tanggal Transaksi <span class="text-error-600 dark:text-error-400 dark:text-error-500">*</span>
                                    </label>
                                    <input type="date" wire:model.defer="daftarNota.{{ $idx }}.tanggal" class="{{ $kelasInput }}">
                                    @error('daftarNota.'.$idx.'.tanggal')
                                        <span class="mt-1 block text-theme-xs text-error-600 dark:text-error-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="{{ $kelasLabel }}">
                                        {{ $jenisTransaksi === 'masuk' ? 'Pemberi Dana / Penyetor' : 'Toko / Penerima' }}
                                    </label>
                                    <input type="text" wire:model.defer="daftarNota.{{ $idx }}.penerima"
                                        placeholder="{{ $jenisTransaksi === 'masuk' ? 'Nama pihak penyetor / pelanggan' : 'Nama toko, penyedia material, atau suplier' }}"
                                        class="{{ $kelasInput }}">
                                </div>

                                @if ($jenisTransaksi === 'keluar')
                                    <div>
                                        <label class="{{ $kelasLabel }}">
                                            Kategori Pengeluaran <span class="text-error-600 dark:text-error-400 dark:text-error-500">*</span>
                                        </label>
                                        <select wire:model.defer="daftarNota.{{ $idx }}.kategori" class="{{ $kelasInput }}">
                                            @foreach ($opsiKategori as $val => $label)
                                                <option value="{{ $val }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div>
                                    <label class="{{ $kelasLabel }}">
                                        Sumber Akun Kas <span class="text-error-600 dark:text-error-400 dark:text-error-500">*</span>
                                    </label>
                                    <select wire:model.defer="daftarNota.{{ $idx }}.akun" class="{{ $kelasInput }}">
                                        @foreach ($opsiAkun as $val => $label)
                                            <option value="{{ $val }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="{{ $kelasLabel }}">Terkait SPK (Opsional)</label>
                                    <x-form.spk-select
                                        :options="$daftarSpk"
                                        :selected="$nota['spk_id'] ?? null"
                                        wireModel="daftarNota.{{ $idx }}.spk_id"
                                        placeholder="Pilih atau cari SPK..."
                                    />
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="{{ $kelasLabel }}">Keterangan / Rincian Barang</label>
                                    <input type="text" wire:model.defer="daftarNota.{{ $idx }}.keterangan"
                                        placeholder="Keterangan pembelian barang atau belanja operasional"
                                        class="{{ $kelasInput }}">
                                    @error('daftarNota.'.$idx.'.keterangan')
                                        <span class="mt-1 block text-theme-xs text-error-600 dark:text-error-400">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Tombol Aksi Simpan & Loading State --}}
            <div class="flex flex-col items-stretch gap-3 border-t border-gray-100 pt-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">
                <div class="min-w-0 text-theme-xs text-gray-500 dark:text-gray-400">
                    <span wire:loading.remove wire:target="simpanSemua">
                        Pastikan seluruh nominal dan tanggal transaksi sudah sesuai.
                    </span>
                    <span wire:loading wire:target="simpanSemua" class="inline-flex items-center gap-2 font-semibold text-brand-600 dark:text-brand-400">
                        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Membukukan dan mengarsipkan nota ke sistem…
                    </span>
                </div>

                <button type="button" wire:click="simpanSemua" wire:loading.attr="disabled" wire:target="simpanSemua, berkasNota"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-brand-600 px-5 text-theme-sm font-semibold text-white shadow-theme-xs transition hover:bg-brand-700 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20 disabled:opacity-50">
                    <svg wire:loading.remove wire:target="simpanSemua" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span wire:loading.remove wire:target="simpanSemua">
                        Simpan {{ count($daftarNota) }} Nota {{ $jenisTransaksi === 'masuk' ? 'Uang Masuk' : 'Uang Keluar' }} ke Arsip &amp; Sistem
                    </span>
                    <span wire:loading wire:target="simpanSemua">Menyimpan…</span>
                </button>
            </div>
        </div>
    @endif
</div>