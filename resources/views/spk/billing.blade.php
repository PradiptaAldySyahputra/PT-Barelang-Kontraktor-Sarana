{{--
    Form TERPISAH: hanya status TAGIHAN.

    Aturan: "Dibayar" hanya boleh kalau piutang sudah 0 - divalidasi di
    controller, bukan hanya di tampilan.
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

<x-layouts.app :judul="$judul" :keterangan="$keterangan" :kembali="$kembali ?? route('panel.spk.monitoring', 'billing')">
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
                    <dt class="{{ $kelasLabel }}">Status Pekerjaan (sekarang)</dt>
                    <dd class="{{ $kelasNilai }}">{{ $spk->status_spk?->label() ?? '—' }}</dd>
                </div>
                <div class="min-w-0">
                    <dt class="{{ $kelasLabel }}">Sudah Diterima</dt>
                    <dd class="{{ $kelasNilai }} angka">{{ Format::rupiah($spk->totalPenerimaan()) }}</dd>
                </div>
            </dl>
        </section>

        <form method="POST" action="{{ route('panel.spk.billing.update', ['spk' => $spk, 'asal' => $asal]) }}"
            class="{{ $kelasKartu }}">
            @csrf
            @method('PUT')

            <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Status Tagihan</h2>
            <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                Tahapan penagihan sampai pembayaran diterima. Bisa diubah kembali kalau ada salah input.
            </p>

            <div class="mt-4">
                <label for="status_tagihan" class="{{ $kelasLabelField }}">
                    Status Tagihan <span class="text-error-600 dark:text-error-400">*</span>
                </label>
                <select id="status_tagihan" name="status_tagihan" required
                    class="{{ $kelasInput }}">
                    @foreach ($opsiStatus as $nilai => $label)
                        <option value="{{ $nilai }}" @selected(old('status_tagihan', $spk->status_tagihan?->value ?? 'belum_ditagihkan') === $nilai)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1.5 text-theme-xs text-gray-500 dark:text-gray-400">
                    Kalau diubah ke "Dibayar", SPK pindah ke menu Tagihan Selesai SPK.
                </p>
                @error('status_tagihan')
                    <p class="{{ $kelasError }}">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex items-center justify-end border-t border-gray-100 pt-4 dark:border-gray-800">
                <button type="submit"
                    class="inline-flex h-11 items-center justify-center rounded-lg bg-brand-600 px-5 text-sm font-semibold text-white transition-colors hover:bg-brand-700 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20">
                    Simpan Tahapan Tagihan
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>