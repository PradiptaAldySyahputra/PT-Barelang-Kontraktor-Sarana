{{--
    Pesan hasil OCR.

    Ditampilkan setelah berkas nota diunggah, supaya admin tahu:
      - berapa nota yang terdeteksi OCR, ATAU
      - OCR gagal membaca (admin harus isi jumlah nota manual).

    ⚠️ PEROMBAKAN DESAIN (8 Okt 2026) — hilangkan "AI slop":
    Versi lama memakai kotak besar berwarna (success/warning) dengan ikon
    sparkles. Terlalu ramai. Versi baru: satu baris tenang dengan titik status,
    profesional dan mudah dipindai.

    Variabel:
        $pesan : teks pesan
        $gagal : true kalau OCR gagal membaca
--}}
@php $gagal = (bool) ($gagal ?? false); @endphp

<div class="flex items-start gap-2.5 rounded-lg border px-3.5 py-2.5
    @if ($gagal) border-amber-300 bg-amber-50 dark:border-amber-700/60 dark:bg-amber-950/40
    @else border-gray-200 bg-gray-50 dark:border-white/10 dark:bg-white/5 @endif">
    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full
        @if ($gagal) bg-amber-500 @else bg-emerald-500 @endif"></span>

    <div class="min-w-0 text-xs leading-relaxed">
        <p class="font-medium @if ($gagal) text-amber-900 dark:text-amber-200 @else text-gray-800 dark:text-gray-100 @endif">
            {{ $pesan }}
        </p>
        <p class="mt-0.5 @if ($gagal) text-amber-800/90 dark:text-amber-300/80 @else text-gray-500 dark:text-gray-400 @endif">
            @if ($gagal)
                Isi <strong>Jumlah nota</strong> manual sesuai yang Anda lihat di berkas.
            @else
                Tiap baris menampilkan potongan notanya dan diisi <strong>draf hasil baca OCR</strong>.
                Periksa &amp; koreksi dulu sebelum menyimpan — nota tulisan tangan bisa salah baca.
            @endif
        </p>
    </div>
</div>
