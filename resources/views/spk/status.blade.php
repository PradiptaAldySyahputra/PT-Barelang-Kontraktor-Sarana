{{--
    Form TERPISAH: hanya status PEKERJAAN.
    Data lain hanya tampil sebagai konteks supaya tidak salah ubah.
--}}
@php
    use App\Support\Format;

    $kelasKartu = 'rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs';
    $kelasLabel = 'text-theme-xs text-gray-500 dark:text-gray-400';
    $kelasNilai = 'mt-0.5 text-theme-sm font-semibold text-gray-900 dark:text-white break-words';
    $kelasLabelField = 'mb-1.5 block text-theme-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300';
    $kelasInput = 'h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-500 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-500';
    $kelasError = 'mt-1.5 block text-xs text-error-500 dark:text-error-400';
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan" :kembali="$kembali ?? route('panel.spk.monitoring', 'status')">
    <div class="mx-auto max-w-3xl space-y-6">

        <section class="{{ $kelasKartu }}">
            <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Konteks SPK</h2>
            <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                Data ini hanya tampilan (buka List SPK untuk mengubah rincian pekerjaan).
            </p>

            <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                <div class="min-w-0">
                    <dt class="{{ $kelasLabel }}">Nomor SPK</dt>
                    <dd class="{{ $kelasNilai }} angka break-all">{{ $spk->nomor_spk }}</dd>
                </div>
                <div class="min-w-0">
                    <dt class="{{ $kelasLabel }}">Nilai SPK</dt>
                    <dd class="{{ $kelasNilai }} angka">{{ Format::rupiah((float) $spk->nilai_spk) }}</dd>
                </div>
                <div class="min-w-0">
                    <dt class="{{ $kelasLabel }}">Status Tagihan (sekarang)</dt>
                    <dd class="{{ $kelasNilai }}">{{ $spk->status_tagihan?->label() ?? 'Belum Ditagihkan' }}</dd>
                </div>
                <div class="min-w-0">
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
                Tahapan berurutan: Draft, Terbit, Berjalan, Selesai, lalu Sudah Ditagihkan. Dibatalkan untuk SPK yang batal.
            </p>

            <div class="mt-4" x-data="{ status: '{{ old('status_spk', $spk->status_spk?->value ?? 'draft') }}' }">
                <label for="status_spk" class="{{ $kelasLabelField }}">
                    Status Pekerjaan <span class="text-error-600 dark:text-error-400">*</span>
                </label>
                <select id="status_spk" name="status_spk" required x-model="status"
                    class="{{ $kelasInput }}">
                    @foreach ($opsiStatus as $nilai => $label)
                        <option value="{{ $nilai }}" @selected(old('status_spk', $spk->status_spk?->value ?? 'draft') === $nilai)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1.5 text-theme-xs text-gray-500 dark:text-gray-400">
                    Ini status PROGRES PEKERJAAN, bukan status tagihan/pembayaran.
                </p>
                @error('status_spk')
                    <p class="{{ $kelasError }}">{{ $message }}</p>
                @enderror

                {{-- Kolom Alasan jika Dibatalkan --}}
                <div x-show="status === 'dibatalkan'" x-cloak class="mt-4 rounded-xl border border-error-200 bg-error-50/50 p-4 dark:border-error-500/20 dark:bg-error-500/5">
                    <label for="keterangan" class="mb-1.5 block text-theme-sm font-medium text-error-700 dark:text-error-400">
                        Alasan Pembatalan SPK <span class="text-error-600 dark:text-error-400">*</span>
                    </label>
                    <textarea id="keterangan" name="keterangan" rows="3"
                        placeholder="Contoh: Pekerjaan dialihkan / dibatalkan oleh pihak PLN Batam karena perubahan trase"
                        class="w-full rounded-lg border border-error-300 bg-white p-3 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-error-500 focus:outline-hidden focus:ring-2 focus:ring-error-500/20 dark:border-error-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">{{ old('keterangan', $spk->keterangan) }}</textarea>
                    <p class="mt-1 text-xs text-error-600 dark:text-error-400">
                        Wajib diisi agar alasan pembatalan tercatat resmi pada arsip pengawasan.
                    </p>
                    @error('keterangan')
                        <p class="{{ $kelasError }} font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end border-t border-gray-100 pt-4 dark:border-gray-800">
                <button type="submit"
                    class="inline-flex h-11 items-center justify-center rounded-lg bg-brand-600 px-5 text-sm font-semibold text-white transition-colors hover:bg-brand-700 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20">
                    Simpan Status
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>