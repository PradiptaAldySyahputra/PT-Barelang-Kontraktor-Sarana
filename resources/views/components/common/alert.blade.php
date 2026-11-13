@props([
    'tipe' => 'info',
    'judul' => null,
    'dapatDitutup' => true,
])

@php
    $gaya = [
        'sukses' => [
            'kotak' => 'border-success-200 bg-success-50 text-success-700 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-300',
            'ikon' => 'bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-300',
            'label' => $judul ?? 'Berhasil',
            'path' => 'M4.5 12.75l6 6 9-13.5',
        ],
        'gagal' => [
            'kotak' => 'border-error-200 bg-error-50 text-error-700 dark:border-error-500/20 dark:bg-error-500/10 dark:text-error-300',
            'ikon' => 'bg-error-100 text-error-600 dark:bg-error-500/20 dark:text-error-300',
            'label' => $judul ?? 'Gagal',
            'path' => 'M6 18L18 6M6 6l12 12',
        ],
        'peringatan' => [
            'kotak' => 'border-warning-200 bg-warning-50 text-warning-700 dark:border-warning-500/20 dark:bg-warning-500/10 dark:text-warning-300',
            'ikon' => 'bg-warning-100 text-warning-700 dark:bg-warning-500/20 dark:text-warning-300',
            'label' => $judul ?? 'Perhatian',
            'path' => 'M12 9v3.75m0 3h.008M12 3.75 2.25 20.25h19.5L12 3.75Z',
        ],
        'info' => [
            'kotak' => 'border-brand-200 bg-brand-50 text-brand-700 dark:border-brand-500/20 dark:bg-brand-500/10 dark:text-brand-300',
            'ikon' => 'bg-brand-100 text-brand-600 dark:bg-brand-500/20 dark:text-brand-300',
            'label' => $judul ?? 'Informasi',
            'path' => 'M12 9v.01M12 12.75v3.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
        ],
    ][$tipe] ?? null;
@endphp

@if ($gaya)
    <div x-data="{ tampil: true }" x-show="tampil" x-transition.opacity
        role="{{ $tipe === 'gagal' ? 'alert' : 'status' }}"
        class="mb-5 flex items-start gap-3 rounded-xl border p-4 shadow-theme-xs {{ $gaya['kotak'] }}">
        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ $gaya['ikon'] }}">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $gaya['path'] }}" />
            </svg>
        </span>
        <div class="min-w-0 flex-1">
            <p class="text-theme-sm font-semibold">{{ $gaya['label'] }}</p>
            <div class="mt-0.5 text-theme-sm opacity-90">{{ $slot }}</div>
            {{ $aksi ?? '' }}
        </div>
        @if ($dapatDitutup)
            <button type="button" @click="tampil = false" aria-label="Tutup pesan"
                class="shrink-0 rounded-lg p-1 opacity-60 transition hover:bg-black/5 hover:opacity-100 dark:hover:bg-white/10">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>
@endif
