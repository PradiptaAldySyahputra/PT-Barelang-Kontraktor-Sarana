<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Spk;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * UNIT TEST — PERHITUNGAN TENGGAT SPK.
 *
 * ⚠️ KENAPA INI PENTING (`docs/Rules.md` §2 butir 17):
 *   Lewat tenggat   → badge MERAH
 *   ≤ 14 hari lagi  → badge KUNING
 *
 * Kalau perhitungan hari salah, alarm tenggat memunculkan peringatan PALSU —
 * dan itu pernah terjadi: 67 dari 90 SPK asli dianggap lewat tenggat, padahal
 * sebagian sudah selesai. Peringatan palsu membuat admin mengabaikan alarm
 * yang sebenarnya penting.
 *
 * ⚠️ KENAPA UNIT TEST (tanpa DB): `sisaTenggatHari()`, `labelTenggat()`,
 * `sudahLewatTenggat()`, dan `isMendekatiTenggat()` hanya membaca satu
 * atribut tanggal. Tidak perlu database.
 *
 * ⚠️ WAKTU DIKUNCI: tes ini memakai `Carbon::setTestNow()` supaya hasilnya
 * SAMA setiap hari dijalankan. Tanpa itu, tes bisa lulus hari ini dan gagal
 * besok — tes yang tidak bisa dipercaya.
 */
class TenggatSpkTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    private function spkDenganTenggat(?string $tanggalAkhir): Spk
    {
        $spk = new Spk;
        $spk->tanggal_akhir = $tanggalAkhir === null ? null : Carbon::parse($tanggalAkhir);

        return $spk;
    }

    // ---------------------------------------------------------------
    // sisaTenggatHari()
    // ---------------------------------------------------------------

    /**
     * @return list<array{0: string|null, 1: int|null}>
     */
    public static function providerSisaHari(): array
    {
        return [
            'tenggat 10 hari lagi' => ['2026-06-20', 10],
            'tenggat hari ini' => ['2026-06-10', 0],
            'lewat 5 hari' => ['2026-06-05', -5],
            'lewat 30 hari' => ['2026-05-11', -30],
            'tenggat jauh' => ['2026-12-31', 204],
            'tanpa tenggat' => [null, null],
        ];
    }

    #[DataProvider('providerSisaHari')]
    public function test_sisa_tenggat_dihitung_dalam_hari(
        ?string $tanggalAkhir,
        ?int $diharapkan,
    ): void {
        // Waktu dikunci: 10 Juni 2026
        Carbon::setTestNow(Carbon::parse('2026-06-10 09:30:00'));

        $this->assertSame($diharapkan, $this->spkDenganTenggat($tanggalAkhir)->sisaTenggatHari());
    }

    public function test_sisa_tenggat_tidak_terpengaruh_jam(): void
    {
        /*
         * ⚠️ KENAPA DIUJI: kalau perhitungan memakai selisih JAM (bukan hari),
         * tenggat "hari ini" bisa terbaca -1 saat sudah lewat tengah hari.
         * Itu akan memunculkan badge merah di hari yang sebenarnya masih tepat.
         */
        Carbon::setTestNow(Carbon::parse('2026-06-10 23:59:00'));

        $spk = $this->spkDenganTenggat('2026-06-10');

        $this->assertSame(
            0,
            $spk->sisaTenggatHari(),
            'Tenggat hari ini harus 0 sepanjang hari, tidak berubah jadi -1 saat malam.',
        );
    }

    // ---------------------------------------------------------------
    // sudahLewatTenggat()
    // ---------------------------------------------------------------

    public function test_belum_lewat_saat_tenggat_hari_ini(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-06-10 12:00:00'));

        $this->assertFalse(
            $this->spkDenganTenggat('2026-06-10')->sudahLewatTenggat(),
            'Tenggat hari ini BELUM lewat — badge merah baru muncul besok.',
        );
    }

    public function test_lewat_setelah_tenggat_berlalu(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-06-11 08:00:00'));

        $this->assertTrue($this->spkDenganTenggat('2026-06-10')->sudahLewatTenggat());
    }

    public function test_tanpa_tenggat_tidak_pernah_dianggap_lewat(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-06-10'));

        $this->assertFalse(
            $this->spkDenganTenggat(null)->sudahLewatTenggat(),
            'SPK tanpa tanggal akhir tidak boleh dianggap lewat tenggat (menghindari alarm palsu).',
        );
    }

    // ---------------------------------------------------------------
    // isMendekatiTenggat() — ambang 14 hari (Rules §2 butir 17)
    // ---------------------------------------------------------------

    /**
     * @return list<array{0: string, 1: bool}>
     */
    public static function providerMendekati(): array
    {
        return [
            'hari ini (0 hari)' => ['2026-06-10', true],
            '7 hari lagi' => ['2026-06-17', true],
            'tepat 14 hari' => ['2026-06-24', true],
            '15 hari (di luar ambang)' => ['2026-06-25', false],
            '30 hari lagi' => ['2026-07-10', false],
            'sudah lewat' => ['2026-06-01', false],
        ];
    }

    #[DataProvider('providerMendekati')]
    public function test_mendekati_tenggat_ambang_14_hari(string $tanggal, bool $diharapkan): void
    {
        Carbon::setTestNow(Carbon::parse('2026-06-10'));

        $this->assertSame(
            $diharapkan,
            $this->spkDenganTenggat($tanggal)->isMendekatiTenggat(),
            "Tenggat {$tanggal} harus ".($diharapkan ? 'MASUK' : 'DI LUAR').' ambang 14 hari.',
        );
    }

    public function test_ambang_mendekati_tenggat_bisa_diubah(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-06-10'));

        $spk = $this->spkDenganTenggat('2026-06-25'); // 15 hari lagi

        $this->assertFalse($spk->isMendekatiTenggat(14));
        $this->assertTrue(
            $spk->isMendekatiTenggat(20),
            'Ambang harus bisa disesuaikan (mis. 20 hari) tanpa mengubah kode.',
        );
    }

    // ---------------------------------------------------------------
    // labelTenggat() — teks untuk badge
    // ---------------------------------------------------------------

    /**
     * @return list<array{0: string|null, 1: string|null}>
     */
    public static function providerLabel(): array
    {
        return [
            'lewat 5 hari' => ['2026-06-05', 'Lewat 5 hari'],
            'lewat 1 hari' => ['2026-06-09', 'Lewat 1 hari'],
            'hari ini' => ['2026-06-10', 'Hari ini'],
            'besok' => ['2026-06-11', '1 hari lagi'],
            '10 hari lagi' => ['2026-06-20', '10 hari lagi'],
            'tanpa tenggat' => [null, null],
        ];
    }

    #[DataProvider('providerLabel')]
    public function test_label_tenggat_berbahasa_indonesia(
        ?string $tanggal,
        ?string $diharapkan,
    ): void {
        Carbon::setTestNow(Carbon::parse('2026-06-10'));

        $this->assertSame($diharapkan, $this->spkDenganTenggat($tanggal)->labelTenggat());
    }
}
