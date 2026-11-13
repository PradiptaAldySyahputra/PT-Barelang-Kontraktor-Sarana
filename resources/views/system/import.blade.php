{{--
    Impor Data (/panel/import) - HANYA Admin.
    Baca berkas: PembacaImpor; simpan: ImporTransaksi (duplikat dicegah).
--}}
@php
    $kelasKartu = 'rounded-2xl border border-gray-200 bg-white p-6 md:p-8 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs';
    $kelasLabel = 'block text-theme-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300';
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <div class="mx-auto max-w-3xl space-y-4">

        <form method="POST" action="{{ route('panel.import.store') }}" enctype="multipart/form-data" class="{{ $kelasKartu }}">
            @csrf

            <fieldset>
                <legend class="{{ $kelasLabel }}">Jenis Data</legend>
                <div class="mt-2 flex flex-wrap gap-4">
                    <label class="inline-flex cursor-pointer items-center gap-2">
                        <input type="radio" name="jenis" value="spk" required @checked(old('jenis') === 'spk')
                            class="h-4 w-4 border-gray-300 text-brand-600 focus:ring-brand-500 dark:border-gray-700">
                        <span class="text-theme-sm text-gray-700 dark:text-gray-200">Daftar SPK</span>
                    </label>
                    <label class="inline-flex cursor-pointer items-center gap-2">
                        <input type="radio" name="jenis" value="masuk" required @checked(old('jenis', 'masuk') === 'masuk')
                            class="h-4 w-4 border-gray-300 text-brand-600 focus:ring-brand-500 dark:border-gray-700">
                        <span class="text-theme-sm text-gray-700 dark:text-gray-200">Uang Masuk</span>
                    </label>
                    <label class="inline-flex cursor-pointer items-center gap-2">
                        <input type="radio" name="jenis" value="keluar" required @checked(old('jenis') === 'keluar')
                            class="h-4 w-4 border-gray-300 text-brand-600 focus:ring-brand-500 dark:border-gray-700">
                        <span class="text-theme-sm text-gray-700 dark:text-gray-200">Uang Keluar</span>
                    </label>
                </div>
                @error('jenis')
                    <p class="mt-1 text-theme-xs text-error-600 dark:text-error-400 dark:text-error-500">{{ $message }}</p>
                @enderror
            </fieldset>

            <div class="mt-4">
                <label for="berkas" class="{{ $kelasLabel }}">Berkas CSV / Excel</label>
                <input id="berkas" name="berkas" type="file" required accept=".csv,.txt,.xlsx"
                    class="mt-2 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-theme-sm text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-1.5 file:text-theme-xs file:font-medium focus:border-brand-500 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:file:bg-white/10">
                @error('berkas')
                    <p class="mt-1 text-theme-xs text-error-600 dark:text-error-400 dark:text-error-500">{{ $message }}</p>
                @enderror

                {{-- Panduan kolom ringkas: dua format didampingkan, bukan paragraf panjang --}}
                <div class="mt-3 grid gap-2 sm:grid-cols-2">
                    <div class="rounded-lg bg-gray-50 p-2.5 text-theme-xs text-gray-600 dark:bg-white/[0.03] dark:text-gray-400">
                        <p class="font-semibold text-gray-800 dark:text-gray-200">Kolom SPK</p>
                        <p class="mt-0.5 break-words font-mono text-[11px] leading-relaxed">
                            nomor_spk &middot; tanggal_spk &middot; nama_pekerjaan &middot; lokasi &middot; nilai_spk &middot; mitra &middot; keterangan
                        </p>
                    </div>
                    <div class="rounded-lg bg-gray-50 p-2.5 text-theme-xs text-gray-600 dark:bg-white/[0.03] dark:text-gray-400">
                        <p class="font-semibold text-gray-800 dark:text-gray-200">Kolom Transaksi</p>
                        <p class="mt-0.5 break-words font-mono text-[11px] leading-relaxed">
                            tanggal &middot; jumlah &middot; akun &middot; nomor_spk (opsional) &middot; kategori &middot; penerima &middot; keterangan
                        </p>
                    </div>
                </div>
                <div class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-theme-xs">
                    <a href="{{ route('panel.import.template', ['jenis' => 'spk']) }}"
                        class="font-medium text-brand-600 hover:underline dark:text-brand-400">Unduh template SPK</a>
                    <span class="text-gray-300 dark:text-gray-600" aria-hidden="true">&middot;</span>
                    <a href="{{ route('panel.import.template') }}"
                        class="font-medium text-brand-600 hover:underline dark:text-brand-400">Unduh template Transaksi</a>
                </div>
            </div>

            <div class="mt-5 flex items-center justify-end border-t border-gray-100 pt-4 dark:border-gray-800">
                <button type="submit"
                    class="inline-flex h-10 items-center rounded-lg bg-brand-600 px-4 text-theme-sm font-semibold text-white transition-colors hover:bg-brand-700 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20">
                    Proses Impor
                </button>
            </div>
        </form>

        @if ($hasil)
            <section class="{{ $kelasKartu }}">
                <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Hasil Impor</h2>
                <dl class="mt-3 grid gap-3 sm:grid-cols-3">
                    <div>
                        <dt class="text-theme-xs text-gray-500 dark:text-gray-400">Ditambah</dt>
                        <dd class="angka mt-0.5 text-lg font-semibold text-success-700 dark:text-success-500">{{ $hasil['ditambah'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-theme-xs text-gray-500 dark:text-gray-400">Dilewati (duplikat)</dt>
                        <dd class="angka mt-0.5 text-lg font-semibold text-gray-900 dark:text-white">{{ $hasil['dilewati'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-theme-xs text-gray-500 dark:text-gray-400">Gagal</dt>
                        <dd class="angka mt-0.5 text-lg font-semibold text-error-600 dark:text-error-400 dark:text-error-500">{{ count($hasil['gagal']) }}</dd>
                    </div>
                </dl>

                @if ($hasil['gagal'] !== [])
                    <ul class="mt-4 max-h-64 space-y-1 overflow-y-auto border-t border-gray-100 pt-3 text-theme-xs text-error-600 dark:text-error-400 dark:border-gray-800 dark:text-error-500">
                        @foreach ($hasil['gagal'] as $pesan)
                            <li>{{ is_array($pesan) ? implode(' · ', array_map('strval', $pesan)) : $pesan }}</li>
                        @endforeach
                    </ul>
                @endif
            </section>
        @endif
    </div>
</x-layouts.app>