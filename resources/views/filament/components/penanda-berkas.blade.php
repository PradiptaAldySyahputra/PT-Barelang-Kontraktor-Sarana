{{--
    Penanda asal berkas — MEMBEDAKAN baris mana milik berkas mana.

    Permintaan user:
      "bisa diberi pembeda untuk setiap bukti atau nota ... admin tidak ada
       navigasi yang jelas untuk membedakanya"

    ⚠️ PEROMBAKAN DESAIN (8 Okt 2026) — hilangkan "AI slop":
    Versi lama memakai badge 8 WARNA BERPUTAR (emerald, sky, violet, amber,
    rose, teal, indigo, orange) + garis kiri 6px warna-warni. Terlalu ramai,
    terasa seperti template generik, dan tidak profesional untuk aplikasi
    keuangan.

    Versi baru: MONOKROM. Pembedanya adalah TEKS yang jelas ("Nota 3 / 50")
    plus nama berkas — bukan warna. Satu-satunya warna adalah indikator status
    tipis (belum diisi / belum lengkap / lengkap) yang benar-benar bermakna.

    Variabel:
        $berkasKe   : nomor berkas (1, 2, 3, ...)
        $berkasDari : total berkas
        $notaKe     : nomor nota di dalam berkas
        $notaDari   : total nota di dalam berkas
        $nama       : nama berkas (opsional)
        $lengkap    : apakah baris ini sudah lengkap (bool)
        $adaIsi     : apakah baris ini sudah ada isian sebagian (bool)
--}}
@php
    $adaBerkas = filled($nama ?? null);
    $lengkap = (bool) ($lengkap ?? false);
    $adaIsi = (bool) ($adaIsi ?? false);

    // Label nota — teks, bukan warna.
    if (($mode ?? '') === 'total') {
        $labelNota = 'TOTAL '.($notaDari ?? 1).' nota';
    } elseif (($notaDari ?? 1) > 1) {
        $labelNota = 'Nota '.($notaKe ?? 1).' / '.($notaDari ?? 1);
    } else {
        $labelNota = 'Nota 1';
    }
@endphp

<div class="flex flex-wrap items-center gap-x-3 gap-y-1.5">
    @if ($adaBerkas)
        {{-- Nomor nota: teks tegas, monokrom --}}
        <span class="text-sm font-semibold tabular-nums text-gray-900 dark:text-gray-100">
            {{ $labelNota }}
        </span>

        @if (($berkasDari ?? 1) > 1)
            <span class="text-xs text-gray-400 dark:text-gray-500">
                berkas {{ $berkasKe }}/{{ $berkasDari }}
            </span>
        @endif

        {{-- Status: satu titik kecil + teks. Tanpa kotak berwarna besar. --}}
        <span class="inline-flex items-center gap-1.5 text-xs font-medium
            @if ($lengkap) text-emerald-700 dark:text-emerald-400
            @elseif ($adaIsi) text-amber-700 dark:text-amber-400
            @else text-gray-400 dark:text-gray-500 @endif">
            <span class="h-1.5 w-1.5 rounded-full
                @if ($lengkap) bg-emerald-500
                @elseif ($adaIsi) bg-amber-500
                @else bg-gray-300 dark:bg-gray-600 @endif"></span>
            @if ($lengkap) Lengkap
            @elseif ($adaIsi) Belum lengkap
            @else Belum diisi @endif
        </span>

        {{-- Nama berkas: kecil, abu, dipotong --}}
        <span class="truncate text-xs text-gray-400 dark:text-gray-500" title="{{ $nama }}">
            {{ $nama }}
        </span>
    @else
        <span class="text-xs text-gray-400 dark:text-gray-500">
            Nota belum ditentukan — unggah berkas di bagian 1.
        </span>
    @endif
</div>
