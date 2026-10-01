<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Pages\Laporan;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * LAPORAN PIUTANG — daftar SPK yang uangnya belum diterima penuh.
 *
 * ⚠️ KENAPA INI PERLU:
 * PRD `FR-RPT-005` (prioritas High) meminta "Laporan SPK Belum Dibayar
 * (piutang)". Datanya SUDAH ada di sistem (`Spk::piutang()`), tetapi
 * belum punya halaman/laporan tersendiri — admin hanya bisa melihatnya
 * per-baris di daftar SPK.
 *
 * Ini kebutuhan nyata admin: "siapa saja yang masih berutang ke kita,
 * dan berapa?" — tanpa harus membuka SPK satu per satu.
 */
class LaporanPiutangTest extends TestCase
{
    use RefreshDatabase;

    private function siapkan(): Pengguna
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        return $admin;
    }

    public function test_piutang_menghitung_sisa_per_spk(): void
    {
        $spk = Spk::factory()->pln()->create(['nilai_spk' => 10_000_000]);

        UangMasuk::create([
            'spk_id' => $spk->id,
            'tanggal' => '2026-09-01',
            'jumlah' => 4_000_000,
            'keterangan' => 'Termin 1',
        ]);

        $this->assertSame(6_000_000.0, $spk->fresh()->piutang());
        $this->assertSame(6_000_000.0, $spk->fresh()->sisaTagih());
    }

    public function test_spk_lunas_tidak_masuk_piutang(): void
    {
        $spk = Spk::factory()->pln()->create(['nilai_spk' => 5_000_000]);

        UangMasuk::create([
            'spk_id' => $spk->id,
            'tanggal' => '2026-09-01',
            'jumlah' => 5_000_000,
            'keterangan' => 'Pelunasan',
        ]);

        $this->assertTrue($spk->fresh()->sudahLunas());
        $this->assertSame(0.0, $spk->fresh()->sisaTagih());
    }

    public function test_halaman_laporan_menyediakan_ekspor_piutang(): void
    {
        $this->siapkan();

        $html = $this->get(Laporan::getUrl())->assertSuccessful()->getContent();

        // Tombol ekspor piutang harus tersedia (PRD FR-RPT-005 + FR-RPT-007).
        $this->assertStringContainsString(
            'piutang',
            $html,
            'Halaman Laporan harus menyediakan ekspor "piutang".',
        );
    }

    public function test_ekspor_piutang_menghasilkan_berkas(): void
    {
        $this->siapkan();

        $spk = Spk::factory()->pln()->create([
            'nilai_spk' => 20_000_000,
            'nama_pekerjaan' => 'Pekerjaan Uji Piutang',
        ]);

        UangMasuk::create([
            'spk_id' => $spk->id,
            'tanggal' => '2026-09-01',
            'jumlah' => 8_000_000,
            'keterangan' => 'DP',
        ]);

        $respons = $this->get(route('laporan.ekspor', 'piutang'));

        $respons->assertSuccessful();
        $respons->assertHeader('content-type', 'text/csv; charset=UTF-8');

        $isi = $respons->streamedContent();

        $this->assertStringContainsString('Nomor SPK', $isi);
        $this->assertStringContainsString('Belum Diterima', $isi);
        // SPK dengan sisa harus muncul di laporan.
        $this->assertStringContainsString('Pekerjaan Uji Piutang', $isi);
    }

    public function test_spk_lunas_tidak_muncul_di_ekspor_piutang(): void
    {
        $this->siapkan();

        $spk = Spk::factory()->pln()->create([
            'nilai_spk' => 3_000_000,
            'nama_pekerjaan' => 'Sudah Lunas Sekali',
        ]);

        UangMasuk::create([
            'spk_id' => $spk->id,
            'tanggal' => '2026-09-01',
            'jumlah' => 3_000_000,
            'keterangan' => 'Lunas',
        ]);

        $isi = $this->get(route('laporan.ekspor', 'piutang'))->streamedContent();

        $this->assertStringNotContainsString(
            'Sudah Lunas Sekali',
            $isi,
            'SPK yang sudah lunas TIDAK boleh muncul di laporan piutang.',
        );
    }
}
