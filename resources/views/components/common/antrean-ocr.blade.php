@php($antrean = \App\Support\AntreanOcr::ringkasan())

@if ($antrean['tertahan'] > 0 || $antrean['gagal'] > 0)
    <div class="mb-5 rounded-2xl border border-error-500 bg-error-50 p-4 dark:border-error-500/30 dark:bg-error-500/15 shadow-theme-xs">
        <div class="flex items-start gap-3">
            <div class="shrink-0 -mt-0.5 text-error-600 dark:text-error-400">
                <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.6501 12.0001C3.6501 7.38852 7.38852 3.6501 12.0001 3.6501C16.6117 3.6501 20.3501 7.38852 20.3501 12.0001C20.3501 16.6117 16.6117 20.3501 12.0001 20.3501C7.38852 20.3501 3.6501 16.6117 3.6501 12.0001ZM12.0001 1.8501C6.39441 1.8501 1.8501 6.39441 1.8501 12.0001C1.8501 17.6058 6.39441 22.1501 12.0001 22.1501C17.6058 22.1501 22.1501 17.6058 22.1501 12.0001C22.1501 6.39441 17.6058 1.8501 12.0001 1.8501ZM10.9992 7.52517C10.9992 8.07746 11.4469 8.52517 11.9992 8.52517H12.0002C12.5525 8.52517 13.0002 8.07746 13.0002 7.52517C13.0002 6.97289 12.5525 6.52517 12.0002 6.52517H11.9992C11.4469 6.52517 10.9992 6.97289 10.9992 7.52517ZM12.0002 17.3715C11.586 17.3715 11.2502 17.0357 11.2502 16.6215V10.945C11.2502 10.5308 11.586 10.195 12.0002 10.195C12.4144 10.195 12.7502 10.5308 12.7502 10.945V16.6215C12.7502 17.0357 12.4144 17.3715 12.0002 17.3715Z" fill="currentColor"></path>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <h4 class="text-sm font-semibold text-gray-800 dark:text-white/90">Antrean OCR Perlu Diperiksa</h4>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                    {{ $antrean['tertahan'] }} berkas nota tertahan lebih dari {{ \App\Support\AntreanOcr::BATAS_TERTAHAN_MENIT }} menit,
                    {{ $antrean['gagal'] }} berkas gagal diproses. Silakan buka halaman
                    <a href="{{ route('panel.receipts.upload') }}" class="font-semibold text-brand-600 underline dark:text-brand-400">Unggah Nota</a>
                    dan pastikan layanan antrean aktif.
                </p>
            </div>
        </div>
    </div>
@endif
