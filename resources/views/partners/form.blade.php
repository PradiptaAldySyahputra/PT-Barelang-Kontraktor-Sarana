{{--
    Form Tambah / Ubah Mitra (/panel/partners/create & /panel/partners/{mitra}/edit).
--}}
@php
    $modeUbah = $mitra !== null;
    $aksi = $modeUbah ? route('panel.partners.update', $mitra) : route('panel.partners.store');
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan" :kembali="$kembali ?? route('panel.partners.index')">
    <div class="mx-auto max-w-2xl">
        <form method="POST" action="{{ $aksi }}"
            class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">
            @csrf
            @if ($modeUbah)
                @method('PUT')
            @endif

            <div class="space-y-5">
                <div>
                    <label for="nama" class="block text-theme-sm font-medium text-gray-700 dark:text-gray-200">
                        Nama Mitra <span class="text-error-600">*</span>
                    </label>
                    <input id="nama" name="nama" type="text" required maxlength="200"
                        value="{{ old('nama', $mitra?->nama) }}" placeholder="PT PLN Batam"
                        class="mt-1.5 h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-theme-sm text-gray-900 focus:border-brand-400 focus:ring-2 focus:ring-brand-500/20 focus:outline-none dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                    @error('nama')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="kategori" class="block text-theme-sm font-medium text-gray-700 dark:text-gray-200">
                            Kategori <span class="text-error-600">*</span>
                        </label>
                        <select id="kategori" name="kategori" required
                            class="mt-1.5 h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-theme-sm text-gray-900 focus:border-brand-400 focus:outline-none dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                            @foreach ($opsiKategori as $nilai => $label)
                                <option value="{{ $nilai }}"
                                    @selected(old('kategori', $mitra?->kategori?->value ?? 'mitra') === $nilai)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                            Mitra = pemberi kerja (termasuk PLN). Subkon = penerima pekerjaan dari kita.
                        </p>
                        @error('kategori')
                            <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col justify-center pt-2">
                        <input type="hidden" name="is_aktif" value="0">
                        <label class="inline-flex cursor-pointer items-center gap-2.5">
                            <input type="checkbox" name="is_aktif" value="1"
                                @checked((bool) old('is_aktif', $mitra?->is_aktif ?? true))
                                class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 dark:border-gray-700">
                            <span class="text-theme-sm font-medium text-gray-700 dark:text-gray-200">Mitra Aktif</span>
                        </label>
                        <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                            Nonaktifkan mitra yang sudah tidak dipakai.
                        </p>
                    </div>
                </div>

                <div>
                    <label for="kontak" class="block text-theme-sm font-medium text-gray-700 dark:text-gray-200">
                        Kontak
                    </label>
                    <input id="kontak" name="kontak" type="text" maxlength="255"
                        value="{{ old('kontak', $mitra?->kontak) }}" placeholder="Nama PIC / telepon / email"
                        class="mt-1.5 h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-theme-sm text-gray-900 focus:border-brand-400 focus:ring-2 focus:ring-brand-500/20 focus:outline-none dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                    @error('kontak')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="alamat" class="block text-theme-sm font-medium text-gray-700 dark:text-gray-200">
                        Alamat
                    </label>
                    <textarea id="alamat" name="alamat" rows="3" maxlength="500"
                        class="mt-1.5 w-full rounded-lg border border-gray-300 bg-white p-3 text-theme-sm text-gray-900 focus:border-brand-400 focus:ring-2 focus:ring-brand-500/20 focus:outline-none dark:border-gray-700 dark:bg-gray-950 dark:text-white">{{ old('alamat', $mitra?->alamat) }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end border-t border-gray-100 pt-4 dark:border-gray-800">
                <button type="submit"
                    class="inline-flex h-9 items-center rounded-lg bg-brand-600 px-4 text-theme-sm font-semibold text-white hover:bg-brand-700">
                    {{ $modeUbah ? 'Simpan Perubahan' : 'Simpan Mitra' }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
