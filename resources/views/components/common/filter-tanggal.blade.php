@props([
    'id' => 'filter-tanggal',
    'tanggal' => '',
    'mode' => 'get',
    'otomatis' => false,
    'lebar' => 'sm:w-44',
])

{{-- Satu kotak tanggal: satu tanggal, satu filter. Menghilangkan ikon kalender ganda --}}
<div class="relative min-w-0" x-data>
    <label for="{{ $id }}" class="sr-only">Tanggal</label>
    <input id="{{ $id }}" type="date" title="Tanggal"
        value="{{ $tanggal }}"
        @if ($mode === 'livewire') wire:model.live="tanggal" @else name="tanggal" @endif
        @if ($otomatis) onchange="this.form.requestSubmit()" @endif
        class="h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800 cursor-pointer {{ $lebar }}">
</div>
