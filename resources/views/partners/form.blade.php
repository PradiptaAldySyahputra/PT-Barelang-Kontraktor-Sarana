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
                        Nama Mitra <span class="text-error-600 dark:text-error-400">*</span>
                    </label>
                    <input id="nama" name="nama" type="text" required maxlength="200"
                        value="{{ old('nama', $mitra?->nama) }}" placeholder="PT PLN Batam"
                        class="mt-1.5 h-11 w-full rounded-lg border border-gray-300 bg-white px-3.5 text-theme-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500 dark:focus:border-brand-500">
                    @error('nama')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-400 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="kategori" class="block text-theme-sm font-medium text-gray-700 dark:text-gray-200">
                            Kategori <span class="text-error-600 dark:text-error-400">*</span>
                        </label>
                        <select id="kategori" name="kategori" required
                            class="mt-1.5 h-11 w-full rounded-lg border border-gray-300 bg-white px-3.5 text-theme-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500 dark:focus:border-brand-500">
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
                            <p class="mt-1 text-theme-xs text-error-600 dark:text-error-400 dark:text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col justify-center pt-2">
                        <input type="hidden" name="is_aktif" value="0">
                        <label class="inline-flex cursor-pointer items-center gap-2.5">
                            <input type="checkbox" name="is_aktif" value="1"
                                @checked((bool) old('is_aktif', $mitra?->is_aktif ?? true))
                                class="h-4 w-4 rounded border-gray-300 bg-white text-brand-600 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900">
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
                        class="mt-1.5 h-11 w-full rounded-lg border border-gray-300 bg-white px-3.5 text-theme-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500 dark:focus:border-brand-500">
                    @error('kontak')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-400 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="alamat" class="block text-theme-sm font-medium text-gray-700 dark:text-gray-200">
                        Alamat
                    </label>
                    <textarea id="alamat" name="alamat" rows="3" maxlength="500"
                        class="mt-1.5 w-full rounded-lg border border-gray-300 bg-white p-3 text-theme-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500 dark:focus:border-brand-500">{{ old('alamat', $mitra?->alamat) }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-400 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end border-t border-gray-100 pt-4 dark:border-gray-800">
                <button type="submit"
                    class="inline-flex h-10 items-center rounded-lg bg-brand-600 px-4 text-theme-sm font-semibold text-white transition-colors hover:bg-brand-700 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20">
                    {{ $modeUbah ? 'Simpan Perubahan' : 'Simpan Mitra' }}
                </button>
            </div>
        </form>
    </div>

    @if ($modeUbah && isset($spkAktif) && $spkAktif->isNotEmpty())
        <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-3">
                Daftar SPK Terkait (10 Terakhir)
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-theme-sm">
                    <thead>
                        <tr class="border-b border-gray-100 text-theme-xs uppercase text-gray-500 dark:border-gray-800 dark:text-gray-400">
                            <th class="py-2.5 px-3">Nomor SPK</th>
                            <th class="py-2.5 px-3">Pekerjaan</th>
                            <th class="py-2.5 px-3 text-right">Nilai Kontrak</th>
                            <th class="py-2.5 px-3 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($spkAktif as $spkItem)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02]">
                                <td class="py-2.5 px-3 font-semibold">
                                    <a href="{{ route('panel.spk.show', $spkItem) }}" class="text-brand-600 hover:underline dark:text-brand-400">
                                        {{ $spkItem->nomor_spk }}
                                    </a>
                                </td>
                                <td class="py-2.5 px-3 max-w-xs truncate text-gray-700 dark:text-gray-300">
                                    {{ $spkItem->nama_pekerjaan }}
                                </td>
                                <td class="py-2.5 px-3 text-right font-semibold angka text-gray-900 dark:text-white">
                                    {{ \App\Support\Format::rupiah($spkItem->nilai_spk) }}
                                </td>
                                <td class="py-2.5 px-3 text-right">
                                    <span class="inline-flex rounded px-2 py-0.5 text-xs font-semibold {{ $spkItem->sudahSelesai() ? 'bg-success-50 text-success-700 dark:bg-success-500/20 dark:text-success-400' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                                        {{ $spkItem->status_spk?->label() ?? 'Draft' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</x-layouts.app>
