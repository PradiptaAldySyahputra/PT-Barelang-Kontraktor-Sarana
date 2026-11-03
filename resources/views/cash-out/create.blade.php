{{--
    Tambah Uang Keluar (/panel/cash-out/create) - beberapa baris sekaligus.
--}}
<x-layouts.app :judul="$judul" :keterangan="$keterangan" :kembali="route('panel.cash-out.index')">
    <div class="mx-auto max-w-5xl">
        <livewire:cash-out.cash-out-form />
    </div>
</x-layouts.app>