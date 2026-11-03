{{--
    Halaman List SPK - kerangka saja; isi tabel ada di komponen Livewire
    `spk.spk-table` supaya pencarian/penyaring/paginasi bekerja tanpa
    memuat ulang halaman.
--}}
<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <livewire:spk.spk-table />
</x-layouts.app>
