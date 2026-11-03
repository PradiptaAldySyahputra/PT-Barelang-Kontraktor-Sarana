{{--
    Form Catat / Ubah Uang Masuk.

    Mode "Berdasarkan SPK" mengisi nomor & nama pekerjaan otomatis dari SPK
    (server-side, bukan dari isian bebas) supaya laporan tidak terpecah.
--}}
@php
    use App\Support\Nota;

    $modeUbah = $uangMasuk !== null;
    $aksi = $modeUbah ? route('panel.cash-in.update', $uangMasuk) : route('panel.cash-in.store');
    $modeAwal = old('mode', $modeUbah ? ($uangMasuk->spk_id ? 'spk' : 'manual') : ($spkTerpilih ? 'spk' : 'spk'));
    $buktiLama = $modeUbah ? ($uangMasuk->bukti ?? []) : [];

    $kelasInput = 'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800';
    $kelasLabel = 'block text-theme-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-2';
    $kelasKartu = 'rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs md:p-6';
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan" :kembali="$kembali ?? route('panel.cash-in.index')">
    <form method="POST" action="{{ $aksi }}" enctype="multipart/form-data" class="mx-auto max-w-3xl space-y-5"
        x-data="{ mode: '{{ $modeAwal }}' }">
        @csrf
        @if ($modeUbah)
            @method('PUT')
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-error-100 bg-error-50 px-4 py-3 text-theme-sm text-error-700 dark:border-error-600/30 dark:bg-error-600/10 dark:text-error-500">
                Ada isian yang perlu diperbaiki. Periksa tanda merah di bawah.
            </div>
        @endif

        <section class="{{ $kelasKartu }}">
            <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Sumber Penerimaan</h2>
            <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                Pilih "Berdasarkan SPK" jika uang masuk dari penagihan SPK. Pilih "Manual" untuk penerimaan di luar SPK
                (mis. penjualan sisa material).
            </p>

            <div class="mt-4 space-y-4">
                <fieldset>
                    <legend class="sr-only">Mode input</legend>
                    <div class="flex flex-wrap gap-4">
                        <label class="inline-flex cursor-pointer items-center gap-2">
                            <input type="radio" name="mode" value="spk" x-model="mode" required
                                class="h-4 w-4 border-gray-300 text-brand-600 focus:ring-brand-500 dark:border-gray-700">
                            <span class="text-theme-sm text-gray-700 dark:text-gray-200">Berdasarkan SPK</span>
                        </label>
                        <label class="inline-flex cursor-pointer items-center gap-2">
                            <input type="radio" name="mode" value="manual" x-model="mode" required
                                class="h-4 w-4 border-gray-300 text-brand-600 focus:ring-brand-500 dark:border-gray-700">
                            <span class="text-theme-sm text-gray-700 dark:text-gray-200">Manual / Luar SPK</span>
                        </label>
                    </div>
                    @error('mode')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </fieldset>

                <div>
                    <label for="akun" class="{{ $kelasLabel }}">Kas/Bank <span class="text-error-600">*</span></label>
                    <select id="akun" name="akun" required class="mt-1.5 {{ $kelasInput }}">
                        @foreach ($opsiAkun as $nilai => $label)
                            <option value="{{ $nilai }}" @selected(old('akun', $uangMasuk?->akun?->value ?? 'kas') === $nilai)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('akun')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        {{-- Mode SPK --}}
        <section class="{{ $kelasKartu }}" x-show="mode === 'spk'" x-cloak>
            <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Data SPK</h2>

            <div class="mt-4">
                <label for="spk_id" class="{{ $kelasLabel }}">Pilih SPK <span class="text-error-600">*</span></label>
                <div class="mt-1.5">
                    <x-form.spk-select
                        name="spk_id"
                        :options="$daftarSpk"
                        :selected="old('spk_id', $uangMasuk?->spk_id ?? $spkTerpilih?->id)"
                        placeholder="Pilih atau cari SPK..."
                    />
                </div>
                <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                    Nomor SPK &amp; nama pekerjaan terisi otomatis dari SPK yang dipilih.
                </p>
                @error('spk_id')
                    <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                @enderror
            </div>
        </section>

        {{-- Mode manual --}}
        <section class="{{ $kelasKartu }}" x-show="mode === 'manual'" x-cloak>
            <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Data Manual (Luar SPK)</h2>

            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="nomor_spk" class="{{ $kelasLabel }}">Nomor Referensi</label>
                    <input id="nomor_spk" name="nomor_spk" type="text" maxlength="150"
                        value="{{ old('nomor_spk', $uangMasuk?->nomor_spk) }}" class="mt-1.5 {{ $kelasInput }}">
                    @error('nomor_spk')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="nama_pekerjaan" class="{{ $kelasLabel }}">Keterangan Pekerjaan / Sumber</label>
                    <input id="nama_pekerjaan" name="nama_pekerjaan" type="text" maxlength="255"
                        value="{{ old('nama_pekerjaan', $uangMasuk?->nama_pekerjaan) }}" class="mt-1.5 {{ $kelasInput }}">
                    @error('nama_pekerjaan')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        {{-- Detail penerimaan --}}
        <section class="{{ $kelasKartu }}">
            <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Detail Penerimaan</h2>

            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="tanggal" class="{{ $kelasLabel }}">Tanggal Masuk <span class="text-error-600">*</span></label>
                    <input id="tanggal" name="tanggal" type="date" required max="{{ now()->format('Y-m-d') }}"
                        value="{{ old('tanggal', $uangMasuk?->tanggal?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                        class="mt-1.5 {{ $kelasInput }}">
                    <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Tidak boleh melewati hari ini.</p>
                    @error('tanggal')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="jumlah" class="{{ $kelasLabel }}">Jumlah (Rp) <span class="text-error-600">*</span></label>
                    <input id="jumlah" name="jumlah" type="text" inputmode="numeric" required
                        value="{{ old('jumlah', \App\Support\Format::untukInputUang($uangMasuk?->jumlah)) }}" placeholder="0"
                        class="mt-1.5 {{ $kelasInput }} angka">
                    <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                        Tidak boleh melebihi sisa piutang SPK.
                    </p>
                    @error('jumlah')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="mitra_id" class="{{ $kelasLabel }}">Mitra / Pengirim</label>
                    <select id="mitra_id" name="mitra_id" class="mt-1.5 {{ $kelasInput }}">
                        <option value="">— Tanpa mitra —</option>
                        @foreach ($daftarMitra as $id => $nama)
                            <option value="{{ $id }}" @selected((string) old('mitra_id', $uangMasuk?->mitra_id) === (string) $id)>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('mitra_id')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="keterangan" class="{{ $kelasLabel }}">Keterangan</label>
                    <input id="keterangan" name="keterangan" type="text" maxlength="255"
                        value="{{ old('keterangan', $uangMasuk?->keterangan) }}"
                        placeholder="mis. termin 1" class="mt-1.5 {{ $kelasInput }}">
                    @error('keterangan')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        {{-- Bukti --}}
        <section class="{{ $kelasKartu }}">
            <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Bukti Penerimaan</h2>

            @if ($buktiLama !== [])
                <ul class="mt-4 divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($buktiLama as $path)
                        <li class="flex items-center justify-between gap-3 py-2">
                            <a href="{{ Nota::url($path) }}" target="_blank" rel="noopener"
                                class="truncate text-theme-sm font-medium text-brand-600 hover:underline dark:text-brand-400">
                                {{ basename($path) }}
                            </a>
                            <label class="inline-flex shrink-0 cursor-pointer items-center gap-1.5 text-theme-xs text-gray-600 dark:text-gray-400">
                                <input type="checkbox" name="hapus_bukti[]" value="{{ $path }}"
                                    class="h-3.5 w-3.5 rounded border-gray-300 text-error-600 focus:ring-error-500 dark:border-gray-700">
                                Hapus
                            </label>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="mt-4">
                <label for="bukti" class="{{ $kelasLabel }}">Tambah Berkas</label>
                <input id="bukti" name="bukti[]" type="file" multiple
                    accept="application/pdf,image/jpeg,image/png,image/webp"
                    class="mt-1.5 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-theme-sm text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-1.5 file:text-theme-xs file:font-medium dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:file:bg-white/10">
                <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">JPG, PNG, WEBP, atau PDF.</p>
                @error('bukti.*')
                    <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                @enderror
            </div>
        </section>

        <div class="flex items-center justify-end">
            <button type="submit"
                class="inline-flex h-9 items-center rounded-lg bg-brand-600 px-4 text-theme-sm font-semibold text-white hover:bg-brand-700">
                {{ $modeUbah ? 'Simpan Perubahan' : 'Simpan Uang Masuk' }}
            </button>
        </div>
    </form>
</x-layouts.app>