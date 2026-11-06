<div class="space-y-6" @if ($sedangProses) wire:poll.2s="periksaHasilOcr" @endif>
    {{-- Kotak Unggah Berkas Utama --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                    Unggah Berkas Nota (Satuan atau Scan Tumpuk)
                </h3>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Format didukung: <strong>PDF, JPG, PNG, WEBP</strong> (Maks. 20MB). Sistem otomatis mendeteksi nota satuan tunggal maupun memotong multi-nota dalam 1 PDF gabungan.
                </p>
            </div>

            <div class="shrink-0">
                <label class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-xs font-semibold text-white shadow-theme-xs hover:bg-brand-700 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    <span>Pilih Berkas Nota</span>
                    <input type="file" wire:model="berkasNota" accept=".pdf,image/*" class="sr-only">
                </label>
            </div>
        </div>

        {{-- Status / Notifikasi OCR --}}
        <div @if (! $sedangProses) wire:loading wire:target="berkasNota" @endif class="mt-4 flex items-center gap-2 text-xs text-brand-600 dark:text-brand-400 font-medium">
            <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>{{ $sedangProses ? 'OCR berjalan di latar belakang — kartu nota muncul otomatis, halaman boleh ditinggal.' : 'Sedang mengunggah berkas nota...' }}</span>
        </div>

        @if ($pesanStatus && !$sedangProses)
            <div class="mt-4 rounded-xl bg-brand-50 p-3.5 text-xs text-brand-800 dark:bg-brand-500/10 dark:text-brand-300 border border-brand-200 dark:border-brand-500/20 flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ $pesanStatus }}</span>
            </div>
        @endif

        @error('berkasNota')
            <p class="mt-2 text-xs text-error-600 dark:text-error-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Daftar Kartu Nota yang Terdeteksi / Form Input Dinamis --}}
    @if (count($daftarNota) > 0)
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-bold text-gray-800 dark:text-white/90">
                        Hasil Ekstraksi & Isian Nota ({{ count($daftarNota) }} Nota)
                    </h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Periksa kembali angka nominal, tanggal, dan nama toko hasil pembacaan sebelum disimpan.
                    </p>
                </div>

                <button type="button" wire:click="tambahNotaManual"
                    class="inline-flex items-center gap-1.5 rounded-xl border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Kartu Nota</span>
                </button>
            </div>

            <div class="grid grid-cols-1 gap-5">
                @foreach ($daftarNota as $idx => $nota)
                    <div wire:key="nota-item-{{ $nota['id'] }}"
                        class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4 dark:border-gray-800">
                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                                <span>Nota #{{ $nota['ke'] ?? ($idx + 1) }}</span>
                                @if (count($daftarNota) > 1)
                                    <span class="text-[10px] text-brand-600 dark:text-brand-400 font-normal">(dari berkas scan tumpuk)</span>
                                @else
                                    <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-normal">(nota satuan)</span>
                                @endif
                            </span>

                            <button type="button" wire:click="hapusBaris({{ $idx }})"
                                class="text-xs font-medium text-error-600 hover:text-error-700 dark:text-error-400 transition"
                                title="Hapus nota ini dari daftar simpan">
                                Hapus
                            </button>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                            {{-- Pratinjau Potongan Nota (Crop) Besar & Jelas --}}
                            <div class="lg:col-span-5 flex flex-col items-center justify-center rounded-2xl border border-gray-200 p-3 dark:border-gray-800 bg-gray-50 dark:bg-gray-950/40 min-h-[260px]">
                                @if (!empty($nota['potongan']))
                                    <div class="w-full flex flex-col items-center">
                                        <img src="{{ $nota['potongan'] }}" alt="Potongan Nota {{ $nota['ke'] }}"
                                            class="w-full max-h-[380px] rounded-xl object-contain shadow-theme-xs border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 cursor-zoom-in"
                                            onclick="window.open('{{ $nota['potongan'] }}', '_blank')">
                                        <div class="mt-2 flex items-center justify-between w-full px-1 text-[11px]">
                                            <span class="text-gray-400">Klik gambar untuk zoom</span>
                                            <a href="{{ $nota['potongan'] }}" target="_blank" class="font-semibold text-brand-600 hover:underline dark:text-brand-400">
                                                Buka Ukuran Penuh &nearr;
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center p-6">
                                        <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="mt-2 block text-xs text-gray-400">Pratinjau berkas utama</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Isian Data Form Nota --}}
                            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        Nominal Rupiah (Rp) <span class="text-error-500">*</span>
                                    </label>
                                    <input type="text" inputmode="numeric" wire:model.defer="daftarNota.{{ $idx }}.nominal"
                                        placeholder="Contoh: 150000"
                                        class="h-9 w-full rounded-xl border border-gray-300 bg-white px-3 text-xs font-bold text-gray-900 focus:border-brand-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                    @error('daftarNota.'.$idx.'.nominal')
                                        <span class="text-[10px] text-error-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        Tanggal Transaksi <span class="text-error-500">*</span>
                                    </label>
                                    <input type="date" wire:model.defer="daftarNota.{{ $idx }}.tanggal"
                                        class="h-9 w-full rounded-xl border border-gray-300 bg-white px-3 text-xs text-gray-900 focus:border-brand-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                    @error('daftarNota.'.$idx.'.tanggal')
                                        <span class="text-[10px] text-error-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        Toko / Penerima
                                    </label>
                                    <input type="text" wire:model.defer="daftarNota.{{ $idx }}.penerima"
                                        placeholder="Nama toko, penyedia material, atau suplier"
                                        class="h-9 w-full rounded-xl border border-gray-300 bg-white px-3 text-xs text-gray-900 focus:border-brand-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        Kategori Pengeluaran <span class="text-error-500">*</span>
                                    </label>
                                    <select wire:model.defer="daftarNota.{{ $idx }}.kategori"
                                        class="h-9 w-full rounded-xl border border-gray-300 bg-white px-3 text-xs text-gray-900 focus:border-brand-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                        @foreach ($opsiKategori as $val => $label)
                                            <option value="{{ $val }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        Sumber Akun Kas <span class="text-error-500">*</span>
                                    </label>
                                    <select wire:model.defer="daftarNota.{{ $idx }}.akun"
                                        class="h-9 w-full rounded-xl border border-gray-300 bg-white px-3 text-xs text-gray-900 focus:border-brand-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                        @foreach ($opsiAkun as $val => $label)
                                            <option value="{{ $val }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        Terkait SPK (Opsional)
                                    </label>
                                    <x-form.spk-select
                                        :options="$daftarSpk"
                                        :selected="$nota['spk_id'] ?? null"
                                        wireModel="daftarNota.{{ $idx }}.spk_id"
                                        placeholder="Pilih atau cari SPK..."
                                    />
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        Keterangan / Rincian Barang
                                    </label>
                                    <input type="text" wire:model.defer="daftarNota.{{ $idx }}.keterangan"
                                        placeholder="Keterangan pembelian barang atau belanja operasional"
                                        class="h-9 w-full rounded-xl border border-gray-300 bg-white px-3 text-xs text-gray-900 focus:border-brand-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                    @error('daftarNota.'.$idx.'.keterangan')
                                        <span class="text-[10px] text-error-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Tombol Aksi Simpan & Loading State --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-3 border-t border-gray-100 dark:border-gray-800">
                <div class="text-xs text-gray-500">
                    <span wire:loading.remove wire:target="simpanSemua">
                        Pastikan seluruh nominal dan tanggal transaksi sudah sesuai.
                    </span>
                    <span wire:loading wire:target="simpanSemua" class="inline-flex items-center gap-2 text-brand-600 font-semibold">
                        <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Sedang membukukan dan mengarsipkan nota ke sistem... Mohon tunggu.
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('panel.receipts') }}"
                        class="rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition">
                        Batal
                    </a>

                    <button type="button" wire:click="simpanSemua" wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-5 py-2.5 text-xs font-semibold text-white shadow-theme-xs hover:bg-brand-700 transition disabled:opacity-50">
                        <svg wire:loading.remove wire:target="simpanSemua" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span wire:loading.remove wire:target="simpanSemua">Simpan {{ count($daftarNota) }} Nota ke Arsip & Sistem</span>
                        <span wire:loading wire:target="simpanSemua">Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
