<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Support\Carbon;

/**
 * IMPOR TRANSAKSI (B3-13) - append-only + cegah duplikat + TEGAKKAN ATURAN BISNIS.
 *
 * ⚠️ KENAPA PERLU:
 * Migrasi data awal / input massal dari Excel. Aturan penting:
 *   - **APPEND-ONLY**: impor hanya MENAMBAH baris; tidak pernah mengubah
 *     atau menghapus data lama.
 *   - **CEGAH DUPLIKAT**: baris yang sudah ada (sidik jari sama) DILEWATI.
 *   - **ATURAN BISNIS SAMA DENGAN FORM** (perbaikan BUG-2, 11 Okt 2026):
 *     dulu impor diam-diam melewati validasi yang ditegakkan form, sehingga
 *     data uang bisa korup. Sekarang tiap baris divalidasi:
 *       (a) uang masuk ≤ sisa piutang SPK,
 *       (b) SPK `Dibatalkan` menolak transaksi baru,
 *       (c) tanggal transaksi ≤ hari ini.
 *     Baris yang melanggar masuk daftar `gagal` dengan pesan jelas.
 *
 * ⚠️ TIDAK ADA TABEL BARU - sidik jari dihitung on-the-fly dari kolom yang ada.
 *
 * ⚠️ KINERJA (perbaikan BUG-1, 11 Okt 2026):
 * Dulu `sudahAda()` memuat SELURUH tabel (`withTrashed()->get()`) untuk SETIAP
 * baris impor → O(n²), lambat & boros memori. Sekarang sidik jari seluruh tabel
 * dihitung SEKALI per jenis (di luar loop), lalu tiap baris cukup dicek ke
 * himpunan (Set) itu.
 */
final class ImporTransaksi
{
    private const BATAS_NOMINAL = 10_000_000_000;

    /**
     * Impor baris uang masuk.
     *
     * @param  list<array<string, mixed>>  $baris
     * @return array{ditambah: int, dilewati: int, gagal: list<string>}
     */
    public static function uangMasuk(array $baris, bool $cegahDuplikat = true): array
    {
        $hasil = ['ditambah' => 0, 'dilewati' => 0, 'gagal' => []];

        // BUG-1: hitung sidik jari tabel SEKALI, bukan per baris.
        $sidikAda = $cegahDuplikat ? self::sidikTersimpan('masuk') : [];

        // Akumulasi uang masuk per SPK (termasuk baris yang baru ditambah dalam
        // batch ini) supaya aturan "≤ sisa piutang" benar walau 1 SPK diimpor
        // beberapa baris sekaligus.
        $terimaPerSpk = [];

        foreach ($baris as $i => $b) {
            $nomorBaris = $i + 1;

            try {
                $tanggal = self::tanggal($b['tanggal'] ?? null);
                $jumlah = self::jumlah($b['jumlah'] ?? null);

                if ($tanggal === null || $jumlah === null) {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: tanggal/jumlah tidak valid.";

                    continue;
                }

                // (c) Tanggal ≤ hari ini.
                if ($tanggal > now()->toDateString()) {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: tanggal {$tanggal} melebihi hari ini.";

                    continue;
                }

                $akun = self::akun($b['akun'] ?? null);
                $spkId = self::spkId($b['spk_id'] ?? null);

                // (b) SPK Dibatalkan menolak transaksi baru.
                $spk = $spkId !== null ? Spk::find($spkId) : null;

                if ($spk !== null && $spk->status_spk !== null && ! $spk->status_spk->bolehTransaksiBaru()) {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: SPK {$spk->nomor_spk} berstatus Dibatalkan - tidak bisa menerima transaksi baru.";

                    continue;
                }

                // (a) Uang masuk ≤ sisa piutang SPK.
                if ($spk !== null) {
                    $sudah = $terimaPerSpk[$spk->id] ?? (float) $spk->uangMasuk()->sum('jumlah');
                    $batas = (float) $spk->nilai_spk - $sudah;

                    if ($jumlah > $batas + 0.01) {
                        $hasil['gagal'][] = sprintf(
                            'Baris %d: melebihi nilai SPK %s. Sisa yang boleh diterima Rp %s, diminta Rp %s.',
                            $nomorBaris,
                            $spk->nomor_spk,
                            number_format(max(0, $batas), 0, ',', '.'),
                            number_format($jumlah, 0, ',', '.'),
                        );

                        continue;
                    }
                }

                $sidik = self::sidik('masuk', $tanggal, $jumlah, $akun, $b['keterangan'] ?? null, $spkId);

                if ($cegahDuplikat && isset($sidikAda[$sidik])) {
                    $hasil['dilewati']++;

                    continue;
                }

                UangMasuk::create([
                    'spk_id' => $spkId,
                    'nomor_spk' => $b['nomor_spk'] ?? null,
                    'nama_pekerjaan' => $b['nama_pekerjaan'] ?? null,
                    'tanggal' => $tanggal,
                    'akun' => $akun,
                    'jumlah' => $jumlah,
                    'keterangan' => $b['keterangan'] ?? null,
                ]);

                // Catat untuk pengecekan baris berikutnya + cegah duplikat
                // DI DALAM batch yang sama (mis. 2 baris kembar di berkas).
                if ($spk !== null) {
                    $terimaPerSpk[$spk->id] = ($terimaPerSpk[$spk->id] ?? (float) $spk->uangMasuk()->sum('jumlah')) + $jumlah;
                }

                $sidikAda[$sidik] = true;
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

        // BUG-1: hitung sidik jari tabel SEKALI.
        $sidikAda = $cegahDuplikat ? self::sidikTersimpan('keluar') : [];

        foreach ($baris as $i => $b) {
            $nomorBaris = $i + 1;

            try {
                $tanggal = self::tanggal($b['tanggal'] ?? null);
                $jumlah = self::jumlah($b['jumlah'] ?? null);

                if ($tanggal === null || $jumlah === null) {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: tanggal/jumlah tidak valid.";

                    continue;
                }

                // (c) Tanggal ≤ hari ini.
                if ($tanggal > now()->toDateString()) {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: tanggal {$tanggal} melebihi hari ini.";

                    continue;
                }

                $akun = self::akun($b['akun'] ?? null);
                $kategori = self::kategori($b['kategori'] ?? null);
                $spkId = self::spkId($b['spk_id'] ?? null);

                // (b) SPK Dibatalkan menolak transaksi baru.
                $spk = $spkId !== null ? Spk::find($spkId) : null;

                if ($spk !== null && $spk->status_spk !== null && ! $spk->status_spk->bolehTransaksiBaru()) {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: SPK {$spk->nomor_spk} berstatus Dibatalkan - tidak bisa menerima transaksi baru.";

                    continue;
                }

                $sidik = self::sidik('keluar', $tanggal, $jumlah, $akun, $b['keterangan'] ?? null, $spkId);

                if ($cegahDuplikat && isset($sidikAda[$sidik])) {
                    $hasil['dilewati']++;

                    continue;
                }

                UangKeluar::create([
                    'spk_id' => $spkId,
                    'tanggal' => $tanggal,
                    'akun' => $akun,
                    'jumlah' => $jumlah,
                    'kategori' => $kategori,
                    'detail_kategori' => $b['detail_kategori'] ?? null,
                    'penerima' => $b['penerima'] ?? null,
                    'keterangan' => $b['keterangan'] ?? null,
                ]);

                $sidikAda[$sidik] = true;
                $hasil['ditambah']++;
            } catch (\Throwable $e) {
                $hasil['gagal'][] = "Baris {$nomorBaris}: ".$e->getMessage();
            }
        }

        return $hasil;
    }

    // Sidik jari (deteksi duplikat) - tanpa tabel baru.

    /**
     * Himpunan sidik jari SELURUH baris tersimpan (termasuk ter-soft-delete).
     *
     * ⚠️ BUG-1: dipanggil SEKALI per impor, BUKAN per baris. Ini yang mengubah
     * O(n²) jadi O(n).
     *
     * @return array<string, true>
     */
    private static function sidikTersimpan(string $jenis): array
    {
        $model = $jenis === 'masuk' ? UangMasuk::class : UangKeluar::class;

        $himpunan = [];

        // Bandingkan terhadap SEMUA baris (termasuk yang ter-soft-delete),
        // supaya baris yang pernah dihapus tidak "kembali" saat impor ulang.
        foreach ($model::withTrashed()->get() as $r) {
            $himpunan[self::sidik(
                $jenis,
                Carbon::parse($r->tanggal)->toDateString(),
                (float) $r->jumlah,
                $r->akun instanceof AkunKas ? $r->akun->value : $r->akun,
                $r->keterangan ?? null,
                $r->spk_id ?? null,
            )] = true;
        }

        return $himpunan;
    }

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

    // Normalisasi nilai

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

        return ($angka > 0 && $angka <= self::BATAS_NOMINAL) ? $angka : null;
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
