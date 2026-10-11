<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Widgets\GrafikArusKas;
use App\Filament\Widgets\RingkasanDirektur;
use App\Filament\Widgets\RingkasanKeuangan;
use App\Filament\Widgets\SpkBerjalan;
use App\Filament\Widgets\SpkPerStatus;
use App\Filament\Widgets\StatusTagihanChart;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * DASHBOARD KHUSUS DIREKTUR (B3-12).
 *
 * ⚠️ KENAPA PERLU:
 * Dashboard lama menampilkan SEMUA widget (cocok untuk Admin yang menginput).
 * Direktur hanya butuh ANGKA KUNCI — tidak perlu grafik rinci & tabel panjang.
 * Jadi:
 *   - Direktur  → HANYA `RingkasanDirektur` (angka kunci, ringkas).
 *   - Admin     → dashboard lengkap seperti sekarang.
 *
 * ⚠️ Yang diuji: widget mana yang BISA DILIHAT per peran (`canView()`), dan
 * angka kunci Direktur benar. Bukan sekadar "halaman terbuka".
 */
class DashboardDirekturTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    private function direktur(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Direktur]);
    }

    // ---------------------------------------------------------
    // Visibilitas widget per peran
    // ---------------------------------------------------------

    public function test_direktur_hanya_melihat_ringkasan_direktur(): void
    {
        $this->actingAs($this->direktur());

        $this->assertTrue(RingkasanDirektur::canView(), 'Direktur harus melihat Ringkasan Direktur.');

        // Widget rinci TIDAK untuk Direktur.
        $this->assertFalse(RingkasanKeuangan::canView(), 'Ringkasan lengkap bukan untuk Direktur.');
        $this->assertFalse(GrafikArusKas::canView(), 'Grafik arus kas bukan untuk Direktur.');
        $this->assertFalse(SpkPerStatus::canView(), 'SPK per status bukan untuk Direktur.');
        $this->assertFalse(StatusTagihanChart::canView(), 'Status tagihan chart bukan untuk Direktur.');
        $this->assertFalse(SpkBerjalan::canView(), 'Tabel SPK berjalan bukan untuk Direktur.');
    }

    public function test_admin_tidak_melihat_ringkasan_direktur(): void
    {
        $this->actingAs($this->admin());

        $this->assertFalse(RingkasanDirektur::canView(), 'Ringkasan Direktur khusus Direktur.');
        $this->assertTrue(RingkasanKeuangan::canView(), 'Admin tetap melihat ringkasan lengkap.');
        $this->assertTrue(GrafikArusKas::canView());
        $this->assertTrue(SpkBerjalan::canView());
    }

    // ---------------------------------------------------------
    // Angka kunci Direktur
    // ---------------------------------------------------------

    public function test_ringkasan_direktur_menampilkan_angka_kunci(): void
    {
        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'DIREKTUR-001',
            'nilai_spk' => 200_000_000,
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin()->id,
        ]);

        UangMasuk::factory()->create(['spk_id' => $spk->id, 'jumlah' => 120_000_000, 'mitra_id' => null]);
        UangKeluar::factory()->create(['spk_id' => $spk->id, 'jumlah' => 65_000_000]);

        $this->actingAs($this->direktur());

        $html = Livewire::test(RingkasanDirektur::class)->html();

        // Angka kunci: nilai SPK, diterima, belum diterima, uang keluar.
        $this->assertStringContainsString('200.000.000', $html, 'Nilai SPK salah');
        $this->assertStringContainsString('120.000.000', $html, 'Sudah diterima salah');
        $this->assertStringContainsString('80.000.000', $html, 'Belum diterima salah');
        $this->assertStringContainsString('65.000.000', $html, 'Uang keluar salah');
    }

    public function test_ringkasan_direktur_punya_saldo_kas_dan_bank(): void
    {
        $this->actingAs($this->direktur());

        $html = Livewire::test(RingkasanDirektur::class)->html();

        // Direktur cukup melihat SATU kartu saldo (Total) dengan rincian
        // Kas & Bank di keterangannya — lebih ringkas dari 3 kartu Admin.
        $this->assertStringContainsString('Total Saldo', $html);
        $this->assertStringContainsString('Kas', $html);
        $this->assertStringContainsString('Bank', $html);
    }

    public function test_ringkasan_direktur_menyoroti_spk_lewat_tenggat(): void
    {
        Spk::factory()->berjalan()->create([
            'nomor_spk' => 'DIREKTUR-TELAT',
            'tanggal_akhir' => now()->subDays(10)->toDateString(),
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin()->id,
        ]);

        $this->actingAs($this->direktur());

        $html = Livewire::test(RingkasanDirektur::class)->html();

        $this->assertStringContainsString('Lewat Tenggat', $html);
    }

    public function test_dashboard_tetap_bisa_dibuka_direktur(): void
    {
        $this->actingAs($this->direktur())->get('/admin')->assertOk();
    }
}
