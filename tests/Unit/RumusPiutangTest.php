<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Spk;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * UNIT TEST — RUMUS PIUTANG & SISA TAGIH.
 *
 * ⚠️ KENAPA INI DIPISAH SEBAGAI UNIT TEST (tanpa database):
 * Rumus ini adalah **inti keuangan** sistem. Setiap rupiah yang ditampilkan di
 * dashboard & laporan melewatinya. Kalau rumusnya salah, seluruh laporan salah
 * — dan itu baru ketahuan saat ada yang membandingkan dengan buku kas fisik.
 *
 * Unit test murni (tanpa DB) membuat pengujian ini:
 *   - cepat (tidak perlu migrate),
 *   - jelas (langsung menguji aritmatika),
 *   - aman (tidak menyentuh database sama sekali).
 *
 * ⚠️ ATURAN YANG DIUJI (`docs/Rules.md` §2 butir 2 & 3):
 *   piutang = nilai_spk − sudah_diterima     ← RETENSI TIDAK DIKURANGI
 *
 *   "DILARANG mengurangi piutang dengan retensi 5%. Melakukan itu akan membuat
 *    piutang lebih kecil dari kenyataan sebesar 5% — padahal klien membayar penuh."
 *
 *   Laba-rugi juga TIDAK dihitung — sistem murni mencatat.
 */
class RumusPiutangTest extends TestCase
{
    /**
     * Buat instance Spk tanpa menyentuh database.
     *
     * `piutangDari()` dan `sisaTagih()` hanya membaca atribut di memori,
     * jadi tidak butuh koneksi database sama sekali.
     */
    private function spkDenganNilai(float $nilaiSpk): Spk
    {
        $spk = new Spk;
        $spk->nilai_spk = $nilaiSpk;

        return $spk;
    }

    // ---------------------------------------------------------------
    // piutangDari() — rumus inti
    // ---------------------------------------------------------------

    /**
     * @return list<array{0: float, 1: float, 2: float}>
     */
    public static function providerPiutang(): array
    {
        return [
            'belum ada penerimaan' => [100_000_000.0, 0.0, 100_000_000.0],
            'penerimaan sebagian' => [100_000_000.0, 40_000_000.0, 60_000_000.0],
            'penerimaan tepat penuh' => [100_000_000.0, 100_000_000.0, 0.0],
            'penerimaan melebihi (kelebihan input)' => [100_000_000.0, 150_000_000.0, -50_000_000.0],
            'nilai desimal tidak hilang presisi' => [1_234_567.89, 234_567.89, 1_000_000.0],
            'nilai nol' => [0.0, 0.0, 0.0],
        ];
    }

    #[DataProvider('providerPiutang')]
    public function test_piutang_adalah_nilai_spk_dikurangi_penerimaan(
        float $nilaiSpk,
        float $penerimaan,
        float $diharapkan,
    ): void {
        $spk = $this->spkDenganNilai($nilaiSpk);

        $this->assertEqualsWithDelta(
            $diharapkan,
            $spk->piutangDari($penerimaan),
            0.001,
            'piutang = nilai_spk − sudah_diterima (TANPA retensi — Rules §2)',
        );
    }

    /**
     * ⚠️ UJI KHUSUS ANTI-RETENSI.
     *
     * Aturan lama (sudah dihapus) mengurangi piutang 5% sebagai "dana ditahan".
     * Uji ini memastikan itu TIDAK terjadi lagi: klien membayar penuh, jadi
     * piutang harus nol — bukan 5% dari nilai SPK.
     */
    public function test_piutang_tidak_dikurangi_retenksi_lima_persen(): void
    {
        $spk = $this->spkDenganNilai(100_000_000.0);

        $piutang = $spk->piutangDari(100_000_000.0);

        $this->assertSame(
            0.0,
            $piutang,
            'Klien membayar 100% → piutang harus 0. Retensi 5% SUDAH TIDAK DIPAKAI (Rules §2).',
        );

        // Kalau retensi masih dipakai, hasilnya 5.000.000 — pastikan BUKAN itu.
        $this->assertNotEqualsWithDelta(
            5_000_000.0,
            $piutang,
            0.001,
            'Piutang TIDAK BOLEH menyisakan 5% — itu aturan lama yang sudah dihapus.',
        );
    }

    // ---------------------------------------------------------------
    // sisaTagih() — versi tampilan, tidak pernah negatif
    // ---------------------------------------------------------------
    //
    // ⚠️ CATATAN: `sisaTagih()` TIDAK diuji di sini karena memanggil
    // `piutang()` → `totalPenerimaan()` yang membaca relasi `uangMasuk`
    // (butuh database). Pengujiannya ada di `tests/Feature/PiutangDanTenggatTest.php`
    // yang memang memakai database. Unit test ini sengaja TIDAK menyentuh DB.
}
