<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\AkunKas;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * SALDO BERJALAN KAS & BANK.
 *
 * ⚠️ KENAPA DIPISAH KE KELAS SENDIRI:
 * Perhitungan saldo dipakai di beberapa tempat (dashboard, laporan). Ditaruh
 * satu tempat supaya tidak ada dua versi rumus yang bisa berbeda diam-diam.
 *
 * RUMUS:  saldo = Σ uang MASUK − Σ uang KELUAR, untuk akun tertentu.
 *
 * ⚠️ TIDAK MENAMBAH TABEL: saldo dihitung on-the-fly dari transaksi yang sudah
 * ada (aturan skema Rules.md §1). Data ter-soft-delete otomatis dikecualikan
 * karena model memakai SoftDeletes.
 *
 * ⚠️ SALDO BISA NEGATIF: itu SAH dan justru penting terlihat - artinya
 * pengeluaran melebihi penerimaan pada akun tersebut (mis. kas diambil dari
 * bank tanpa tercatat sebagai uang masuk). Jangan dibulatkan ke 0.
 */
final class SaldoKas
{
    /**
     * Saldo satu akun (kas atau bank) sampai tanggal tertentu (default: semua).
     *
     * @param  AkunKas|string  $akun  'kas' | 'bank'
     * @param  Carbon|null  $sampai  Batas atas tanggal (inklusif). Null = semua.
     */
    public static function saldo(AkunKas|string $akun, ?Carbon $sampai = null): float
    {
        $nilai = $akun instanceof AkunKas ? $akun->value : $akun;

        $masuk = UangMasuk::query()
            ->where('akun', $nilai)
            ->when($sampai, fn ($q) => $q->where('tanggal', '<=', $sampai->toDateString()))
            ->sum('jumlah');

        $keluar = UangKeluar::query()
            ->where('akun', $nilai)
            ->when($sampai, fn ($q) => $q->where('tanggal', '<=', $sampai->toDateString()))
            ->sum('jumlah');

        return (float) $masuk - (float) $keluar;
    }

    /**
     * Ringkasan saldo kedua akun + totalnya.
     *
     * @return array{kas: float, bank: float, total: float}
     */
    public static function ringkasan(?Carbon $sampai = null): array
    {
        $kas = self::saldo(AkunKas::Kas, $sampai);
        $bank = self::saldo(AkunKas::Bank, $sampai);

        return [
            'kas' => $kas,
            'bank' => $bank,
            'total' => $kas + $bank,
        ];
    }

    /**
     * Saldo berjalan per bulan untuk satu akun - untuk grafik/daftar tren.
     *
     * Mengembalikan koleksi urut menaik: [['bulan' => '2026-01', 'masuk' => …,
     * 'keluar' => …, 'saldo' => …], …]. `saldo` adalah saldo AKHIR bulan tsb.
     *
     * @return Collection<int, array{bulan: string, label: string, masuk: float, keluar: float, saldo: float}>
     */
    public static function perBulan(AkunKas|string $akun, int $bulan = 12): Collection
    {
        $nilai = $akun instanceof AkunKas ? $akun->value : $akun;

        $awal = now()->subMonths($bulan - 1)->startOfMonth();

        $masuk = UangMasuk::query()
            ->where('akun', $nilai)
            ->where('tanggal', '>=', $awal)
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(jumlah) as total")
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $keluar = UangKeluar::query()
            ->where('akun', $nilai)
            ->where('tanggal', '>=', $awal)
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(jumlah) as total")
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // Saldo AWAL sebelum periode (agar saldo berjalan benar, bukan cuma
        // selisih di dalam periode).
        $saldoAwal = self::saldo($nilai, $awal->copy()->subDay());

        return collect(range($bulan - 1, 0))
            ->map(function (int $i) use ($masuk, $keluar): array {
                $b = now()->subMonths($i)->startOfMonth();
                $kunci = $b->format('Y-m');

                return [
                    'bulan' => $kunci,
                    'label' => $b->translatedFormat('M Y'),
                    'masuk' => (float) ($masuk[$kunci] ?? 0),
                    'keluar' => (float) ($keluar[$kunci] ?? 0),
                ];
            })
            ->reduce(function (Collection $acc, array $baris) use ($saldoAwal): Collection {
                // Saldo akhir bulan = saldo akhir bulan sebelumnya + mutasi bulan ini.
                $saldo = ($acc->last()['saldo'] ?? $saldoAwal) + $baris['masuk'] - $baris['keluar'];
                $acc->push([
                    'bulan' => $baris['bulan'],
                    'label' => $baris['label'],
                    'masuk' => $baris['masuk'],
                    'keluar' => $baris['keluar'],
                    'saldo' => $saldo,
                ]);

                return $acc;
            }, collect());
    }
}
