{{--
    Form TERPISAH: hanya status PEKERJAAN.
    Data lain hanya tampil sebagai konteks supaya tidak salah ubah.
--}}
@php
    use App\Support\Format;

    $kelasKartu = 'rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900';
    $kelasLabel = 'text-theme-xs text-gray-500 dark:text-gray-400';
    $kelasNilai = 'mt-0.5 text-theme-sm font-semibold text-gray-900 dark:text-white';
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan" :kembali="$kembali ?? route('panel.spk.monitoring', 'status')">
    <div class="mx-auto max-w-3xl space-y-5">

        <section class="{{ $kelasKartu }}">
            <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Konteks SPK</h2>
            <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                Data ini hanya tampilan — untuk mengubahnya, buka List SPK.
            </p>

            <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <dt class="{{ $kelasLabel }}">Nomor SPK</dt>
                    <dd class="{{ $kelasNilai }} angka">{{ $spk->nomor_spk }}</dd>
                </div>
                <div>
                    <dt class="{{ $kelasLabel }}">Nilai SPK</dt>
                    <dd class="{{ $kelasNilai }} angka">{{ Format::rupiah((float) $spk->nilai_spk) }}</dd>
                </div>
                <div>
                    <dt class="{{ $kelasLabel }}">Status Tagihan (sekarang)</dt>
                    <dd class="{{ $kelasNilai }}">{{ $spk->status_tagihan?->label() ?? 'Belum Ditagihkan' }}</dd>
                </div>
                <div>
                    <dt class="{{ $kelasLabel }}">Tenggat</dt>
                    <dd class="{{ $kelasNilai }}">{{ $spk->tanggal_akhir?->format('d/m/Y') ?? '—' }}</dd>
                </div>
            </dl>
        </section>

        <form method="POST" action="{{ route('panel.spk.status.update', ['spk' => $spk, 'asal' => $asal]) }}"
            class="{{ $kelasKartu }}">
            @csrf
            @method('PUT')

            <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Status Pekerjaan</h2>
            <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                Tahapan: Draft → Terbit → Berjalan → Selesai → Sudah Ditagihkan. Dibatalkan untuk SPK yang batal.
            </p>

            <div class="mt-4">
                <label for="status_spk" class="block text-theme-sm font-medium text-gray-700 dark:text-gray-200">
                    Status Pekerjaan <span class="text-error-600">*</span>
                </label>
                <select id="status_spk" name="status_spk" required
                    class="mt-1.5 h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-theme-sm text-gray-900 focus:border-brand-400 focus:outline-none dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                    @foreach ($opsiStatus as $nilai => $label)
                        <option value="{{ $nilai }}" @selected(old('status_spk', $spk->status_spk?->value ?? 'draft') === $nilai)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                    Ini status PROGRES PEKERJAAN, bukan status tagihan/pembayaran.
                </p>
                @error('status_spk')
                    <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex items-center justify-end border-t border-gray-100 pt-4 dark:border-gray-800">
                <button type="submit"
                    class="inline-flex h-9 items-center rounded-lg bg-brand-600 px-4 text-theme-sm font-semibold text-white hover:bg-brand-700">
                    Simpan Status Pekerjaan
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>