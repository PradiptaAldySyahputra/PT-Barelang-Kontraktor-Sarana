{{--
    Halaman Unggah & Ekstraksi Nota Mandiri (/panel/receipts/upload)
--}}
<x-layouts.app :judul="$judul" :keterangan="$keterangan" :kembali="route('panel.receipts')">
    <div class="mx-auto max-w-5xl">
        <livewire:receipt.receipt-upload-form />
    </div>
</x-layouts.app>
