{{--
    Penanda asal berkas — MEMBEDAKAN baris mana milik berkas mana.

    Permintaan user:
      "bisa diberi pembeda untuk setiap bukti atau nota karna anda hanya buat
       pengeluaran 1 sampai selanjutnya itu bergabung dengan nota yang lain
       jadi admin tidak ada navigasi yang jelas untuk membedakanya"

    Solusi: badge BERWARNA per berkas (warna berputar otomatis), plus nomor
    berkas & nomor nota. Jadi admin bisa membedakan baris dengan sekali lihat,
    bukan harus membaca nama berkas yang panjang.

    Ditambah IKON STATUS: ✓ kalau baris sudah lengkap, ⚠ kalau belum —
    supaya admin tahu baris mana yang masih perlu diisi.

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
    // Palet warna — berputar sesuai nomor berkas. Setiap warna punya
    // pasangan mode terang & gelap agar tetap terbaca di keduanya.
    $palet = [
        ['bg-emerald-100', 'text-emerald-800', 'border-emerald-300', 'dark:bg-emerald-900', 'dark:text-emerald-100', 'dark:border-emerald-700'],
        ['bg-sky-100', 'text-sky-800', 'border-sky-300', 'dark:bg-sky-900', 'dark:text-sky-100', 'dark:border-sky-700'],
        ['bg-violet-100', 'text-violet-800', 'border-violet-300', 'dark:bg-violet-900', 'dark:text-violet-100', 'dark:border-violet-700'],
        ['bg-amber-100', 'text-amber-800', 'border-amber-300', 'dark:bg-amber-900', 'dark:text-amber-100', 'dark:border-amber-700'],
        ['bg-rose-100', 'text-rose-800', 'border-rose-300', 'dark:bg-rose-900', 'dark:text-rose-100', 'dark:border-rose-700'],
        ['bg-teal-100', 'text-teal-800', 'border-teal-300', 'dark:bg-teal-900', 'dark:text-teal-100', 'dark:border-teal-700'],
        ['bg-indigo-100', 'text-indigo-800', 'border-indigo-300', 'dark:bg-indigo-900', 'dark:text-indigo-100', 'dark:border-indigo-700'],
        ['bg-orange-100', 'text-orange-800', 'border-orange-300', 'dark:bg-orange-900', 'dark:text-orange-100', 'dark:border-orange-700'],
    ];

    $warna = $palet[((int) ($berkasKe ?? 1) - 1) % count($palet)];
    $kelas = implode(' ', $warna);

    $adaBerkas = filled($nama ?? null);
    $lengkap = (bool) ($lengkap ?? false);
    $adaIsi = (bool) ($adaIsi ?? false);
@endphp

<div class="flex flex-wrap items-center gap-2">
    @if ($adaBerkas)
        {{--
            Badge warna: pembeda utama antar berkas.

            Kelas `penanda-berkas-N` dipakai CSS `:has()` pada baris repeater
            untuk mewarnai GARIS KIRI baris itu (lihat theme.css). Jadi admin
            bisa membedakan berkas dari warna garis, tanpa membaca teks.
        --}}
        <span class="penanda-berkas-{{ (int) ($berkasKe ?? 1) }} inline-flex items-center gap-1.5 rounded-md border px-2.5 py-1 text-xs font-semibold {{ $kelas }}">
            <x-filament::icon icon="heroicon-m-document" class="h-3.5 w-3.5" />
            @if (($berkasDari ?? 1) > 1)
                BERKAS {{ $berkasKe }}/{{ $berkasDari }}
            @else
                BERKAS 1
            @endif
        </span>

        {{--
            Nomor nota di dalam berkas.

            Mode total: baris ini adalah TOTAL dari sekian nota, jadi jangan
            ditulis "Nota 0 dari 57" — itu membingungkan (seolah tidak ada
            notanya). Tulis jelas: "TOTAL 57 nota".
        --}}
        <span class="inline-flex items-center rounded-md border border-gray-300 bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200">
            @if (($mode ?? '') === 'total')
                TOTAL {{ $notaDari ?? 1 }} nota
            @elseif (($notaDari ?? 1) > 1)
                Nota {{ $notaKe }} dari {{ $notaDari }}
            @else
                Nota 1 dari 1
            @endif
        </span>

        {{-- IKON STATUS: langsung terlihat baris mana yang belum lengkap --}}
        @if ($lengkap)
            <span class="inline-flex items-center gap-1 rounded-md border border-success-300 bg-success-50 px-2 py-1 text-xs font-semibold text-success-700 dark:border-success-700 dark:bg-success-950 dark:text-success-300">
                <x-filament::icon icon="heroicon-m-check-circle" class="h-3.5 w-3.5" />
                Lengkap
            </span>
        @elseif ($adaIsi)
            <span class="inline-flex items-center gap-1 rounded-md border border-warning-300 bg-warning-50 px-2 py-1 text-xs font-semibold text-warning-700 dark:border-warning-700 dark:bg-warning-950 dark:text-warning-300">
                <x-filament::icon icon="heroicon-m-exclamation-triangle" class="h-3.5 w-3.5" />
                Belum lengkap
            </span>
        @else
            <span class="inline-flex items-center gap-1 rounded-md border border-gray-300 bg-white px-2 py-1 text-xs font-medium text-gray-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-400">
                <x-filament::icon icon="heroicon-m-minus-circle" class="h-3.5 w-3.5" />
                Belum diisi
            </span>
        @endif

        {{-- Nama berkas --}}
        <span class="truncate text-xs text-gray-500 dark:text-gray-400" title="{{ $nama }}">
            {{ $nama }}
        </span>
    @else
        <span class="text-xs text-gray-500 dark:text-gray-400">
            Nota belum ditentukan — unggah berkas di bagian 1.
        </span>
    @endif
</div>
