@props([
    'id' => 'filter-tanggal',
    'tanggal' => '',
    'mode' => 'get',
    'otomatis' => false,
    'lebar' => 'sm:w-44',
])

{{-- Satu kotak tanggal: satu tanggal, satu filter. --}}
<div class="relative min-w-0">
    <label for="{{ $id }}" class="sr-only">Tanggal</label>
    <svg class="pointer-events-none absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-gray-500 dark:text-gray-400 dark:text-gray-500"
        fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
    </svg>
    <input id="{{ $id }}" type="date" title="Tanggal"
        value="{{ $tanggal }}"
        @if ($mode === 'livewire') wire:model.live="tanggal" @else name="tanggal" @endif
        @if ($otomatis) onchange="this.form.requestSubmit()" @endif
        class="h-10 w-full rounded-lg border border-gray-300 bg-white pr-3 pl-9 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800 {{ $lebar }}">
</div>
