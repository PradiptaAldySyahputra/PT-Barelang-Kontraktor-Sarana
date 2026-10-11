<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Support\Carbon;

/**
 * IMPOR TRANSAKSI (B3-13) — append-only + cegah duplikat.
 *
 * ⚠️ KENAPA PERLU:
 * Migrasi data awal / input massal dari Excel. Aturan penting:
 *   - **APPEND-ONLY**: impor hanya MENAMBAH baris; tidak pernah mengubah
 *     atau menghapus data lama.
 *   - **CEGAH DUPLIKAT**: baris yang sudah ada (sidik jari sama) DILEWATI,
 *     supaya impor ulang berkas yang sama tidak menggandakan data.
 *
 * ⚠️ TIDAK ADA TABEL BARU — sidik jari dihitung on-the-fly dari kolom yang ada
 * (tanggal + jumlah + akun + keterangan + spk).
 */
final class ImporTransaksi
{
    /**
     * Impor baris uang masuk.
     *
     * @param  list<array<string, mixed>>  $baris
     * @return array{ditambah: int, dilewati: int, gagal: list<string>}
     */
    public static function uangMasuk(array $baris, bool $cegahDuplikat = true): array
    {
        $hasil = ['ditambah' => 0, 'dilewati' => 0, 'gagal' => []];

        foreach ($baris as $i => $b) {
            $nomorBaris = $i + 1;

            try {
                $tanggal = self::tanggal($b['tanggal'] ?? null);
                $jumlah = self::jumlah($b['jumlah'] ?? null);

                if ($tanggal === null || $jumlah === null) {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: tanggal/jumlah tidak valid.";

                    continue;
                }

                $akun = self::akun($b['akun'] ?? null);

                $sidik = self::sidik('masuk', $tanggal, $jumlah, $akun, $b['keterangan'] ?? null, $b['spk_id'] ?? null);

                if ($cegahDuplikat && self::sudahAda('masuk', $sidik)) {
                    $hasil['dilewati']++;

                    continue;
                }

                UangMasuk::create([
                    'spk_id' => self::spkId($b['spk_id'] ?? null),
                    'nomor_spk' => $b['nomor_spk'] ?? null,
                    'nama_pekerjaan' => $b['nama_pekerjaan'] ?? null,
                    'tanggal' => $tanggal,
                    'akun' => $akun,
                    'jumlah' => $jumlah,
                    'keterangan' => $b['keterangan'] ?? null,
                ]);

                $hasil['ditambah']++;
            } catch (\Throwable $e) {
                $hasil['gagal'][] = "Baris {$nomorBaris}: ".$e->getMessage();
            }
        }

        return $hasil;
    }

    /**
     * Impor baris uang keluar.
     *
     * @param  list<array<string, mixed>>  $baris
     * @return array{ditambah: int, dilewati: int, gagal: list<string>}
     */
    public static function uangKeluar(array $baris, bool $cegahDuplikat = true): array
    {
        $hasil = ['ditambah' => 0, 'dilewati' => 0, 'gagal' => []];

        foreach ($baris as $i => $b) {
            $nomorBaris = $i + 1;

            try {
                $tanggal = self::tanggal($b['tanggal'] ?? null);
                $jumlah = self::jumlah($b['jumlah'] ?? null);

                if ($tanggal === null || $jumlah === null) {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: tanggal/jumlah tidak valid.";

                    continue;
                }

                $akun = self::akun($b['akun'] ?? null);
                $kategori = self::kategori($b['kategori'] ?? null);

                $sidik = self::sidik('keluar', $tanggal, $jumlah, $akun, $b['keterangan'] ?? null, $b['spk_id'] ?? null);

                if ($cegahDuplikat && self::sudahAda('keluar', $sidik)) {
                    $hasil['dilewati']++;

                    continue;
                }

                UangKeluar::create([
                    'spk_id' => self::spkId($b['spk_id'] ?? null),
                    'tanggal' => $tanggal,
                    'akun' => $akun,
                    'jumlah' => $jumlah,
                    'kategori' => $kategori,
                    'penerima' => $b['penerima'] ?? null,
                    'keterangan' => $b['keterangan'] ?? null,
                ]);

                $hasil['ditambah']++;
            } catch (\Throwable $e) {
                $hasil['gagal'][] = "Baris {$nomorBaris}: ".$e->getMessage();
            }
        }

        return $hasil;
    }

    // ---------------------------------------------------------
    // Sidik jari (deteksi duplikat) — tanpa tabel baru.
    // ---------------------------------------------------------

    private static function sidik(string $jenis, string $tanggal, float $jumlah, ?string $akun, ?string $keterangan, mixed $spkId): string
    {
        return md5(implode('|', [
            $jenis,
            $tanggal,
            number_format($jumlah, 2, '.', ''),
            (string) $akun,
            mb_strtolower(trim((string) $keterangan)),
            (string) self::spkId($spkId),
        ]));
    }

    private static function sudahAda(string $jenis, string $sidik): bool
    {
        $model = $jenis === 'masuk' ? UangMasuk::class : UangKeluar::class;

        // Bandingkan terhadap SEMUA baris (termasuk yang ter-soft-delete),
        // supaya baris yang pernah dihapus tidak "kembali" saat impor ulang.
        return $model::withTrashed()->get()->contains(function ($r) use ($jenis, $sidik): bool {
            $keterangan = $r->keterangan ?? null;
            $spkId = $r->spk_id ?? null;

            return self::sidik(
                $jenis,
                Carbon::parse($r->tanggal)->toDateString(),
                (float) $r->jumlah,
                $r->akun instanceof AkunKas ? $r->akun->value : $r->akun,
                $keterangan,
                $spkId,
            ) === $sidik;
        });
    }

    // ---------------------------------------------------------
    // Normalisasi nilai
    // ---------------------------------------------------------

    private static function tanggal(mixed $nilai): ?string
    {
        if ($nilai === null || $nilai === '') {
            return null;
        }

        try {
            return Carbon::parse($nilai)->toDateString();
        } catch (\Throwable) {
            return null;
        }
    }

    private static function jumlah(mixed $nilai): ?float
    {
        if ($nilai === null || $nilai === '') {
            return null;
        }

        // Terima format "1.500.000", "2,500,000", "1500000", "1 500 000".
        $bersih = preg_replace('/[^0-9,.\-]/', '', (string) $nilai);

        if ($bersih === null || $bersih === '' || $bersih === '-') {
            return null;
        }

        $adaTitik = str_contains($bersih, '.');
        $adaKoma = str_contains($bersih, ',');

        if ($adaTitik && $adaKoma) {
            // Keduanya ada → yang TERAKHIR adalah pemisah desimal.
            if (strrpos($bersih, ',') > strrpos($bersih, '.')) {
                // Format Indonesia: titik ribuan, koma desimal.
                $bersih = str_replace('.', '', $bersih);
                $bersih = str_replace(',', '.', $bersih);
            } else {
                // Format Inggris: koma ribuan, titik desimal.
                $bersih = str_replace(',', '', $bersih);
            }
        } elseif ($adaKoma) {
            // Hanya koma: banyak koma = ribuan; satu koma = desimal.
            $bersih = substr_count($bersih, ',') > 1
                ? str_replace(',', '', $bersih)
                : str_replace(',', '.', $bersih);
        } elseif ($adaTitik && substr_count($bersih, '.') > 1) {
            // Banyak titik = pemisah ribuan.
            $bersih = str_replace('.', '', $bersih);
        } elseif ($adaTitik) {
            // Satu titik. Format Indonesia "1.500" (3 digit di belakang) =
            // pemisah ribuan; selain itu anggap desimal.
            if (preg_match('/^\d{1,3}(\.\d{3})+$/', $bersih) === 1) {
                $bersih = str_replace('.', '', $bersih);
            }
        }

        $angka = (float) $bersih;

        return $angka > 0 ? $angka : null;
    }

    private static function akun(mixed $nilai): ?string
    {
        $v = strtolower(trim((string) $nilai));

        return match (true) {
            str_contains($v, 'bank') => AkunKas::Bank->value,
            str_contains($v, 'kas') => AkunKas::Kas->value,
            default => null,
        };
    }

    private static function kategori(mixed $nilai): ?string
    {
        $v = strtolower(trim((string) $nilai));

        if ($v === '') {
            return null;
        }

        foreach (KategoriPengeluaran::cases() as $k) {
            if ($v === $k->value || str_contains($v, $k->value)) {
                return $k->value;
            }
        }

        return null;
    }

    private static function spkId(mixed $nilai): ?int
    {
        if ($nilai === null || $nilai === '') {
            return null;
        }

        return is_numeric($nilai) ? (int) $nilai : null;
    }
}
