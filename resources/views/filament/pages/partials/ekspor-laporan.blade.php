{{--
    ============================================================
    TOMBOL EKSPOR PER LAPORAN (partial)
    ============================================================

    Dipakai di halaman Laporan, tepat di header tiap bagian laporan.

    ⚠️ KENAPA DIPISAH PER BAGIAN:
    Dulu SATU dropdown berisi 5 laporan × 3 format = 15 baris memanjang
    dalam satu daftar. Admin harus menggulir jauh dan mudah salah klik.
    Sekarang tiap laporan punya tombol sendiri, di dekat datanya.

    Param: $jenis (string) — kunci laporan di Laporan::ekspor()
--}}
@php
    $formatEkspor = [
        'xlsx' => ['label' => 'Excel (.xlsx)', 'ket' => 'diolah', 'ikon' => 'heroicon-m-table-cells'],
        'pdf' => ['label' => 'PDF (.pdf)', 'ket' => 'arsip', 'ikon' => 'heroicon-m-document-text'],
        'csv' => ['label' => 'CSV (.csv)', 'ket' => 'tukar data', 'ikon' => 'heroicon-m-document-arrow-down'],
    ];
@endphp

<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::button color="gray" size="xs" icon="heroicon-m-arrow-down-tray">
            Ekspor
        </x-filament::button>
    </x-slot>

    <x-filament::dropdown.list>
        @foreach ($formatEkspor as $format => $info)
            <x-filament::dropdown.list.item
                tag="a"
                :href="route('laporan.ekspor', ['jenis' => $jenis, 'format' => $format])"
                :icon="$info['ikon']"
            >
                {{ $info['label'] }}
                <span class="text-xs text-gray-500">— {{ $info['ket'] }}</span>
            </x-filament::dropdown.list.item>
        @endforeach
    </x-filament::dropdown.list>
</x-filament::dropdown>
