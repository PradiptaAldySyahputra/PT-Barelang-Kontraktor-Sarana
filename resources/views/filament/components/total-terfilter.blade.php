{{--
    BARIS TOTAL TERFILTER — DI ATAS TABEL.

    ⚠️ SARAN USER (9 Okt 2026):
    "Tampilkan total sesuai filter aktif ... Letakkan di ATAS tabel
     (summary bar, terlihat tanpa scroll) — bukan cuma di bawah.
     Idealnya: total + rincian per kategori dalam satu baris ringkasan."

    ⚠️ MASALAH YANG DIPERBAIKI:
    Total bawaan Filament hanya muncul di BAWAH tabel, jadi admin harus
    menggulir ke bawah untuk melihatnya — padahal itu angka yang paling
    sering ditanya. Baris ini menaruhnya di ATAS, selalu terlihat, dan
    SELALU mengikuti filter aktif (bulan, kategori, dst).

    Props:
      - judul    : label singkat, mis. "Total Uang Masuk"
      - total    : nominal (float/int)
      - catatan  : keterangan kecil di kanan, mis. "dari 42 transaksi"
      - rincian  : array [label => nominal] untuk pecahan per kategori
      - nada     : 'masuk' (hijau) | 'keluar' (merah) | 'netral'
--}}
@props([
    'judul' => 'Total',
    'total' => 0,
    'catatan' => null,
    'rincian' => [],
    'nada' => 'netral',
])

@php
    $warna = match ($nada) {
        'masuk' => 'text-emerald-600 dark:text-emerald-400',
        'keluar' => 'text-rose-600 dark:text-rose-400',
        default => 'text-gray-900 dark:text-gray-100',
    };
@endphp

<div class="fi-ta-total-terfilter mb-3 flex flex-wrap items-center gap-x-4 gap-y-2 rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-white/10 dark:bg-white/5">
    <span class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
        {{ $judul }}
    </span>

    <span class="text-base font-semibold {{ $warna }}">
        {{ \App\Support\Format::rupiah($total) }}
    </span>

    @if ($catatan)
        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $catatan }}</span>
    @endif

    @if (! empty($rincian))
        <span class="hidden h-4 w-px bg-gray-300 dark:bg-white/15 sm:inline-block"></span>
        <span class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-600 dark:text-gray-300">
            @foreach ($rincian as $label => $nilai)
                <span>
                    {{ $label }}
                    <span class="font-medium text-gray-900 dark:text-gray-100">
                        {{ \App\Support\Format::rupiah($nilai) }}
                    </span>
                </span>
            @endforeach
        </span>
    @endif
</div>
