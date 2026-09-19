<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\StatusSpk;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Uji perhitungan sisa & piutang SEDERHANA, serta tenggat SPK.
 *
 * ⚠️ KEPUTUSAN USER (19 Sep 2026): RETENSI DIHAPUS.
 * Sistem murni mencatat data yang diinput. Tidak ada retensi, laba/rugi,
 * pajak, atau aging piutang.
 *
 * Yang tersisa:
 *   piutang = nilai_spk − sudah_diterima
 */
class PiutangDanTenggatTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create(['email' => 'admin-piutang@bks.test']);
    }

    private function buatSpk(array $atribut = []): Spk
    {
        return Spk::factory()->pln()->create(array_merge([
            'nomor_spk' => 'UJI-001',
            'nama_pekerjaan' => 'Pekerjaan Uji',
            'nilai_spk' => 100_000_000,
            'mitra_id' => Mitra::factory()->pln()->create(['nama' => 'PT PLN Batam'])->id,
            'dibuat_oleh' => $this->admin->id,
        ], $atribut));
    }

    // =========================================================
    // PIUTANG SEDERHANA
    // =========================================================

    public function test_piutang_adalah_nilai_spk_dikurangi_diterima(): void
    {
        $spk = $this->buatSpk(['nilai_spk' => 100_000_000]);

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 45_000_000,
            'tanggal' => now(),
        ]);

        // 100jt − 45jt = 55jt (tanpa retensi lagi)
        $this->assertSame(55_000_000.0, $spk->fresh()->piutang());
    }

    public function test_piutang_nol_kalau_belum_ada_penerimaan_dan_nilai_nol(): void
    {
        $spk = $this->buatSpk(['nilai_spk' => 0]);

        $this->assertSame(0.0, $spk->piutang());
    }

    public function test_piutang_negatif_kalau_penerimaan_melebihi_nilai(): void
    {
        $spk = $this->buatSpk(['nilai_spk' => 10_000_000]);

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 15_000_000,
            'tanggal' => now(),
        ]);

        // Negatif = tanda kelebihan input, bukan dipaksa 0.
        $this->assertSame(-5_000_000.0, $spk->fresh()->piutang());
    }

    public function test_sisa_tagih_tidak_pernah_negatif(): void
    {
        $spk = $this->buatSpk(['nilai_spk' => 10_000_000]);

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 15_000_000,
            'tanggal' => now(),
        ]);

        $this->assertSame(0.0, $spk->fresh()->sisaTagih());
    }

    public function test_sudah_lunas_saat_piutang_nol_atau_negatif(): void
    {
        $spk = $this->buatSpk(['nilai_spk' => 10_000_000]);
        $this->assertFalse($spk->sudahLunas());

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 10_000_000,
            'tanggal' => now(),
        ]);

        $this->assertTrue($spk->fresh()->sudahLunas());
    }

    public function test_piutang_dari_penerimaan_yang_diketahui(): void
    {
        $spk = $this->buatSpk(['nilai_spk' => 100_000_000]);

        $this->assertSame(60_000_000.0, $spk->piutangDari(40_000_000));
    }

    // =========================================================
    // TENGGAT
    // =========================================================

    public function test_scope_lewat_tenggat(): void
    {
        // ⚠️ Scope lewatTenggat() hanya berlaku untuk SPK yang MASIH BERJALAN.
        // SPK yang sudah selesai TIDAK dihitung — supaya tidak muncul alarm
        // palsu (pernah terjadi: 67 dari 90 SPK asli dianggap lewat tenggat).
        $this->buatSpk([
            'nomor_spk' => 'L-1',
            'tanggal_akhir' => now()->subDays(3),
            'status_spk' => StatusSpk::Berjalan,
        ]);
        $this->buatSpk([
            'nomor_spk' => 'L-2',
            'tanggal_akhir' => now()->addDays(30),
            'status_spk' => StatusSpk::Berjalan,
        ]);
        $this->buatSpk([
            'nomor_spk' => 'L-3',
            'tanggal_akhir' => now()->subDays(30),
            'status_spk' => StatusSpk::Selesai,
        ]);

        $hasil = Spk::lewatTenggat()->pluck('nomor_spk');

        $this->assertContains('L-1', $hasil);
        $this->assertNotContains('L-2', $hasil);
        $this->assertNotContains('L-3', $hasil, 'SPK selesai tidak boleh dianggap lewat tenggat');
    }

    public function test_scope_mendekati_tenggat(): void
    {
        $this->buatSpk([
            'nomor_spk' => 'M-1',
            'tanggal_akhir' => now()->addDays(5),
            'status_spk' => StatusSpk::Berjalan,
        ]);
        $this->buatSpk([
            'nomor_spk' => 'M-2',
            'tanggal_akhir' => now()->addDays(60),
            'status_spk' => StatusSpk::Berjalan,
        ]);

        $hasil = Spk::mendekatiTenggat()->pluck('nomor_spk');

        $this->assertContains('M-1', $hasil);
        $this->assertNotContains('M-2', $hasil);
    }

    public function test_label_tenggat(): void
    {
        $lewat = $this->buatSpk(['nomor_spk' => 'T-1', 'tanggal_akhir' => now()->subDays(5)]);
        $mendekati = $this->buatSpk(['nomor_spk' => 'T-2', 'tanggal_akhir' => now()->addDays(3)]);
        $jauh = $this->buatSpk(['nomor_spk' => 'T-3', 'tanggal_akhir' => now()->addDays(60)]);

        $this->assertStringContainsString('Lewat', (string) $lewat->labelTenggat());
        $this->assertStringContainsString('hari lagi', (string) $mendekati->labelTenggat());
        $this->assertStringContainsString('hari lagi', (string) $jauh->labelTenggat());
    }

    public function test_sudah_selesai(): void
    {
        $berjalan = $this->buatSpk(['nomor_spk' => 'S-1', 'status_spk' => StatusSpk::Berjalan]);
        $selesai = $this->buatSpk(['nomor_spk' => 'S-2', 'status_spk' => StatusSpk::Selesai]);
        $batal = $this->buatSpk(['nomor_spk' => 'S-3', 'status_spk' => StatusSpk::Dibatalkan]);

        $this->assertFalse($berjalan->sudahSelesai());
        $this->assertTrue($selesai->sudahSelesai());
        $this->assertTrue($batal->sudahSelesai());
    }

    public function test_spk_tanpa_tanggal_tidak_dihitung_lewat_tenggat(): void
    {
        $spk = $this->buatSpk([
            'nomor_spk' => 'TANPA-TANGGAL',
            'tanggal_spk' => null,
            'tanggal_akhir' => null,
            'status_spk' => StatusSpk::Berjalan,
        ]);

        $this->assertNull($spk->sisaTenggatHari());
        $this->assertNull($spk->labelTenggat());
        $this->assertNotContains('TANPA-TANGGAL', Spk::lewatTenggat()->pluck('nomor_spk'));
    }
}
