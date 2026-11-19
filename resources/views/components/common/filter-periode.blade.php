@props([
    'periode' => '',
    'mode' => 'livewire',
    'label' => 'Periode',
])

@php
    $preset = [
        'hari-ini' => 'Hari Ini',
        '7-hari' => '7 Hari',
        'bulan' => 'Bulan Ini',
        'tahun' => 'Tahun Ini',
        '' => 'Semua',
    ];
    $kelasDasar = 'rounded-lg border px-2.5 py-1.5 text-theme-xs font-semibold shadow-theme-xs transition';
    $kelasAktif = $kelasDasar.' border-brand-500 bg-brand-50 text-brand-700 dark:border-brand-500 dark:bg-brand-500/15 dark:text-brand-300';
    $kelasIdle = $kelasDasar.' border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300';
@endphp

<div class="flex flex-wrap items-center gap-1 text-xs">
    <span class="mr-1 text-theme-xs font-medium text-gray-500 dark:text-gray-400">{{ $label }}</span>
    @foreach ($preset as $nilai => $teks)
        @if ($mode === 'get')
            <a href="{{ route(request()->route()->getName(), array_merge(request()->query(), ['periode' => $nilai])) }}"
                class="{{ $periode === $nilai ? $kelasAktif : $kelasIdle }}">
                {{ $teks }}
            </a>
        @else
            <button type="button" wire:click="$set('periode', '{{ $nilai }}')"
                class="{{ $periode === $nilai ? $kelasAktif : $kelasIdle }}">
                {{ $teks }}
            </button>
        @endif
    @endforeach
</div>
