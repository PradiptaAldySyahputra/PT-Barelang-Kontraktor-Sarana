{{--
    Progres pengisian + ringkasan total.

    Permintaan user:
      "sekarang desain atau tampilan memang polos saya ingin tetap pertahankan
       tetapi diperbarui dengan navigasi yang jelas juga, di button, alert,
       icon, atau bagian yang membantu user dan admin dalam menggunakan sistem"

    ⚠️ PEROMBAKAN DESAIN (8 Okt 2026) — hilangkan "AI slop":
    Versi lama menumpuk 4 KOTAK BERWARNA (progres + alert merah + alert kuning
    + ringkasan) sehingga tampilan terasa penuh dan norak. Versi baru memakai
    SATU baris status ringkas + satu baris peringatan HANYA bila ada masalah.
    Tetap informatif, tapi tenang dan profesional.

    Tetap gaya polos: border tipis, monokrom, tanpa warna norak.
--}}
@php
    $baris = collect(is_array($pengeluaran ?? null) ? $pengeluaran : [])
        ->filter(fn ($r): bool => is_array($r));

    $total = $baris->count();

    // Baris dianggap TERISI kalau jumlah + kategori + tanggal lengkap.
    $lengkap = $baris->filter(fn ($r): bool => filled($r['jumlah'] ?? null)
        && filled($r['kategori'] ?? null)
        && filled($r['tanggal'] ?? null));

    $jumlahLengkap = $lengkap->count();
    $sisa = $total - $jumlahLengkap;

    $totalRupiah = (float) $lengkap->sum(fn ($r): float => (float) ($r['jumlah'] ?? 0));

    $persen = $total > 0 ? (int) round($jumlahLengkap / $total * 100) : 0;

    // Ada baris yang terpotong batas pengaman? (jumlah nota > MAKS_BARIS)
    $adaTerpotong = $baris->contains(fn ($r): bool => ($r['terpotong'] ?? false) === true);
@endphp

@if ($total > 0)
    {{-- SATU baris status: progres + jumlah + total. Ringkas, tanpa kotak menumpuk. --}}
    <div class="rounded-lg border border-gray-200 bg-white px-4 py-3 dark:border-white/10 dark:bg-gray-900">
        <div class="flex flex-wrap items-center justify-between gap-x-6 gap-y-2">
            <div class="flex items-center gap-3 min-w-0">
                <span class="text-sm font-semibold tabular-nums text-gray-900 dark:text-gray-100">
                    {{ $jumlahLengkap }}<span class="text-gray-400 dark:text-gray-500">/{{ $total }}</span>
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    @if ($sisa === 0) semua baris lengkap @else baris lengkap @endif
                </span>
            </div>

            @if ($jumlahLengkap > 0)
                <span class="shrink-0 whitespace-nowrap text-sm font-semibold tabular-nums text-gray-900 dark:text-gray-50">
                    Rp {{ number_format($totalRupiah, 0, ',', '.') }}
                </span>
            @endif
        </div>

        {{-- Bar progres tipis --}}
        <div class="mt-2.5 h-1 w-full overflow-hidden rounded-full bg-gray-150 dark:bg-white/10" style="background-color:#f4f4f5">
            <div class="h-full rounded-full transition-all duration-300 {{ $sisa === 0 ? 'bg-emerald-600' : 'bg-gray-800 dark:bg-gray-200' }}"
                style="width: {{ $persen }}%"></div>
        </div>
    </div>

    {{-- PERINGATAN hanya bila ADA masalah — satu baris, tidak menumpuk --}}
    @if ($adaTerpotong)
        <div class="flex items-start gap-2 rounded-lg border border-amber-300 bg-amber-50 px-4 py-3 dark:border-amber-700/60 dark:bg-amber-950/40">
            <x-filament::icon icon="heroicon-m-exclamation-triangle" class="mt-0.5 h-4 w-4 shrink-0 text-amber-600 dark:text-amber-400" />
            <p class="text-xs text-amber-900 dark:text-amber-200">
                Berkas berisi lebih dari {{ \App\Filament\Resources\UangKeluars\Schemas\UangKeluarForm::MAKS_BARIS }} nota —
                hanya {{ \App\Filament\Resources\UangKeluars\Schemas\UangKeluarForm::MAKS_BARIS }} baris pertama dibuat.
                <strong>Catat sisanya di halaman Tambah terpisah.</strong>
            </p>
        </div>
    @elseif ($sisa > 0)
        <div class="flex items-start gap-2 rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-white/10 dark:bg-white/5">
            <x-filament::icon icon="heroicon-m-information-circle" class="mt-0.5 h-4 w-4 shrink-0 text-gray-400" />
            <p class="text-xs text-gray-600 dark:text-gray-300">
                {{ $sisa }} baris belum lengkap dan <strong>tidak akan tersimpan</strong>.
                Lengkapi tanggal, jumlah, dan kategori.
            </p>
        </div>
    @endif
@endif
