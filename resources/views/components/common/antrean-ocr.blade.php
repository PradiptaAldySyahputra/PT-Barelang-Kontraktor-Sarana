@php($antrean = \App\Support\AntreanOcr::ringkasan())

@if ($antrean['tertahan'] > 0 || $antrean['gagal'] > 0)
    <div class="mb-5 rounded-xl border border-error-200 bg-error-50 px-4 py-3 dark:border-error-500/30 dark:bg-error-500/10">
        <p class="text-theme-sm font-semibold text-error-700 dark:text-error-300">Antrean OCR perlu diperiksa</p>
        <p class="mt-1 text-theme-xs leading-relaxed text-error-600 dark:text-error-400">
            {{ $antrean['tertahan'] }} pekerjaan tertahan lebih dari {{ \App\Support\AntreanOcr::BATAS_TERTAHAN_MENIT }} menit,
            {{ $antrean['gagal'] }} gagal. Periksa halaman
            <a href="{{ route('panel.receipts.upload') }}" class="font-semibold underline">Unggah Nota</a>
            dan pastikan layanan antrean hidup.
        </p>
    </div>
@endif
