{{--
    Pesan hasil OCR.

    Ditampilkan setelah berkas nota diunggah, supaya admin tahu:
      - berapa nota yang terdeteksi OCR, ATAU
      - OCR gagal membaca (admin harus isi jumlah nota manual).

    Penting: OCR ini BANTUAN. Pesan ini menegaskan bahwa angka rupiah tetap
    diisi admin — supaya tidak ada yang mengira nominalnya dibaca otomatis.

    Variabel:
        $pesan : teks pesan
        $gagal : true kalau OCR gagal membaca
--}}
<div @class([
    'flex items-start gap-2 rounded-lg border p-3',
    'border-warning-300 bg-warning-50 dark:border-warning-700 dark:bg-warning-950' => $gagal ?? false,
    'border-success-300 bg-success-50 dark:border-success-700 dark:bg-success-950' => ! ($gagal ?? false),
])>
    @if ($gagal ?? false)
        <x-filament::icon icon="heroicon-m-exclamation-triangle" class="mt-0.5 h-5 w-5 shrink-0 text-warning-600 dark:text-warning-400" />
        <div class="text-xs text-warning-800 dark:text-warning-200">
            <p class="font-semibold">{{ $pesan }}</p>
            <p class="mt-0.5">Isi <strong>Jumlah nota</strong> manual sesuai yang Anda lihat di berkas.</p>
        </div>
    @else
        <x-filament::icon icon="heroicon-m-sparkles" class="mt-0.5 h-5 w-5 shrink-0 text-success-600 dark:text-success-400" />
        <div class="text-xs text-success-800 dark:text-success-200">
            <p class="font-semibold">{{ $pesan }}</p>
            <p class="mt-0.5">
                Baris rincian sudah dibuat otomatis, dan tiap baris menampilkan
                <strong>potongan notanya sendiri</strong>. Nominal tetap diisi manual —
                OCR tidak membaca angka.
            </p>
        </div>
    @endif
</div>
