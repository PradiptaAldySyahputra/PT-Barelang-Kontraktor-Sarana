{{--
    Progres pengisian + ringkasan total.

    Permintaan user:
      "sekarang desain atau tampilan memang polos saya ingin tetap pertahankan
       tetapi diperbarui dengan navigasi yang jelas juga, di button, alert,
       icon, atau bagian yang membantu user dan admin dalam menggunakan sistem
       karna ini berkaitan dengan data penting"

    Tujuan: admin tahu SEBELUM klik Simpan — sudah berapa baris terisi, mana
    yang belum lengkap, dan berapa totalnya. Tanpa ini admin baru sadar ada
    yang kurang saat menyimpan.

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

    // Setengah terisi: ada nominal tapi belum lengkap.
    $sebagian = $baris->filter(fn ($r): bool => (filled($r['jumlah'] ?? null) || filled($r['kategori'] ?? null))
        && ! (filled($r['jumlah'] ?? null) && filled($r['kategori'] ?? null) && filled($r['tanggal'] ?? null)));

    $jumlahLengkap = $lengkap->count();
    $jumlahSebagian = $sebagian->count();
    $sisa = $total - $jumlahLengkap;

    $totalRupiah = (float) $lengkap->sum(fn ($r): float => (float) ($r['jumlah'] ?? 0));

    $persen = $total > 0 ? (int) round($jumlahLengkap / $total * 100) : 0;

    // Ada baris yang terpotong batas pengaman? (jumlah nota > MAKS_BARIS)
    $adaTerpotong = $baris->contains(fn ($r): bool => ($r['terpotong'] ?? false) === true);
@endphp

<div class="w-full space-y-3">
    {{-- PROGRES: berapa baris sudah lengkap --}}
    @if ($total > 0)
        <div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    @if ($sisa === 0)
                        <x-filament::icon icon="heroicon-m-check-circle" class="h-5 w-5 text-success-600 dark:text-success-400" />
                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                            Semua baris sudah lengkap
                        </span>
                    @else
                        <x-filament::icon icon="heroicon-m-clipboard-document-list" class="h-5 w-5 text-gray-500 dark:text-gray-400" />
                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                            Progres pengisian
                        </span>
                    @endif
                </div>

                <span class="text-sm font-medium tabular-nums text-gray-700 dark:text-gray-300">
                    {{ $jumlahLengkap }} dari {{ $total }} baris lengkap
                </span>
            </div>

            {{-- Bar progres --}}
            <div class="mt-3 h-2 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                <div
                    class="h-full rounded-full transition-all duration-300 {{ $sisa === 0 ? 'bg-success-600' : 'bg-gray-800 dark:bg-gray-200' }}"
                    style="width: {{ $persen }}%"
                ></div>
            </div>

            {{-- Rincian status --}}
            <div class="mt-3 flex flex-wrap gap-x-4 gap-y-1 text-xs">
                <span class="text-gray-600 dark:text-gray-400">
                    <span class="font-semibold text-success-700 dark:text-success-400">{{ $jumlahLengkap }}</span> lengkap
                </span>
                @if ($jumlahSebagian > 0)
                    <span class="text-gray-600 dark:text-gray-400">
                        <span class="font-semibold text-warning-700 dark:text-warning-400">{{ $jumlahSebagian }}</span> belum lengkap
                    </span>
                @endif
                @if ($total - $jumlahLengkap - $jumlahSebagian > 0)
                    <span class="text-gray-600 dark:text-gray-400">
                        <span class="font-semibold">{{ $total - $jumlahLengkap - $jumlahSebagian }}</span> kosong
                    </span>
                @endif
            </div>
        </div>
    @endif

    {{-- ALERT: baris TERPOTONG batas pengaman -> jangan diam-diam --}}
    @if ($adaTerpotong)
        <div class="rounded-lg border border-danger-300 bg-danger-50 p-3 dark:border-danger-700 dark:bg-danger-950">
            <div class="flex items-start gap-2">
                <x-filament::icon icon="heroicon-m-scissors" class="mt-0.5 h-5 w-5 shrink-0 text-danger-600 dark:text-danger-400" />
                <div class="text-xs text-danger-800 dark:text-danger-200">
                    <p class="font-semibold">Baris dibatasi {{ \App\Filament\Resources\UangKeluars\Schemas\UangKeluarForm::MAKS_BARIS }} — ada nota yang belum tercatat</p>
                    <p class="mt-0.5">
                        Jumlah nota melebihi batas pengaman, jadi sebagian baris tidak dibuat.
                        <strong>Catat sisanya di halaman Tambah Uang Keluar terpisah</strong> supaya tidak ada pengeluaran yang hilang dari laporan.
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- ALERT: ada yang belum lengkap -> beri tahu SEBELUM klik Simpan --}}
    @if ($total > 0 && $sisa > 0)
        <div class="rounded-lg border border-warning-300 bg-warning-50 p-3 dark:border-warning-700 dark:bg-warning-950">
            <div class="flex items-start gap-2">
                <x-filament::icon icon="heroicon-m-exclamation-triangle" class="mt-0.5 h-5 w-5 shrink-0 text-warning-600 dark:text-warning-400" />
                <div class="text-xs text-warning-800 dark:text-warning-200">
                    <p class="font-semibold">Masih ada {{ $sisa }} baris belum lengkap</p>
                    <p class="mt-0.5">
                        Baris yang belum lengkap TIDAK akan tersimpan. Lengkapi
                        <strong>tanggal</strong>, <strong>jumlah</strong>, dan <strong>kategori</strong>
                        supaya ikut tercatat.
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- RINGKASAN: total yang akan tersimpan --}}
    @if ($jumlahLengkap > 0)
        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Total yang akan tersimpan
                </span>
                <span class="text-lg font-bold tabular-nums text-gray-900 dark:text-gray-50">
                    Rp {{ number_format($totalRupiah, 0, ',', '.') }}
                </span>
            </div>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Dari {{ $jumlahLengkap }} baris lengkap. Periksa sekali lagi sebelum menyimpan —
                data keuangan tidak boleh salah.
            </p>
        </div>
    @endif
</div>
