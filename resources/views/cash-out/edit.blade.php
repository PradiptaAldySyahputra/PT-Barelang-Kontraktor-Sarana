{{--
    Ubah Uang Keluar (/panel/cash-out/{uangKeluar}/edit) - satu record.
--}}
<x-layouts.app :judul="$judul" :keterangan="$keterangan" :kembali="$kembali ?? route('panel.cash-out.index')">
    <div class="mx-auto max-w-5xl">
        <livewire:cash-out.cash-out-form :record="$uangKeluar" />
    </div>
</x-layouts.app>