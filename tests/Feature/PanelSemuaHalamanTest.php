<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PanelSemuaHalamanTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;
    private Pengguna $direktur;
    private Spk $spk;
    private UangMasuk $uangMasuk;
    private UangKeluar $uangKeluar;
    private Mitra $mitra;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->create([
            'nama' => 'Admin Operasional BKS',
            'email' => 'admin.audit@bks.test',
            'peran' => Peran::Admin,
            'is_aktif' => true,
        ]);

        $this->direktur = Pengguna::factory()->create([
            'nama' => 'Direktur Eksekutif BKS',
            'email' => 'direktur.audit@bks.test',
            'peran' => Peran::Direktur,
            'is_aktif' => true,
        ]);

        $this->mitra = Mitra::factory()->create(['nama' => 'PT Mitra PLN Batam']);

        $this->spk = Spk::factory()->create([
            'nomor_spk' => 'SPK-AUDIT-2026-001',
            'nama_pekerjaan' => 'Pemasangan Kabel Distribusi Batam Center',
            'mitra_id' => $this->mitra->id,
            'nilai_spk' => 150_000_000,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->uangMasuk = UangMasuk::factory()->create([
            'spk_id' => $this->spk->id,
            'jumlah' => 50_000_000,
            'mitra_id' => null,
        ]);

        $this->uangKeluar = UangKeluar::factory()->create([
            'spk_id' => $this->spk->id,
            'jumlah' => 12_000_000,
        ]);
    }

    public function test_semua_halaman_admin_dapat_diakses_bebas_error_dan_slop(): void
    {
        $halamanAdmin = [
            '/panel',
            '/panel/spk',
            '/panel/spk/calendar',
            '/panel/spk/create',
            '/panel/spk/' . $this->spk->id,
            '/panel/spk/' . $this->spk->id . '/edit',
            '/panel/spk/' . $this->spk->id . '/status',
            '/panel/spk/' . $this->spk->id . '/billing',
            '/panel/spk/monitoring/status',
            '/panel/spk/monitoring/billing',
            '/panel/spk/monitoring/completed',
            '/panel/cash-in',
            '/panel/cash-in/create',
            '/panel/cash-in/' . $this->uangMasuk->id . '/edit',
            '/panel/cash-out',
            '/panel/cash-out/create',
            '/panel/cash-out/' . $this->uangKeluar->id . '/edit',
            '/panel/receipts',
            '/panel/reports',
            '/panel/partners',
            '/panel/partners/create',
            '/panel/partners/' . $this->mitra->id . '/edit',
            '/panel/status',
            '/panel/backup',
            '/panel/import',
            '/panel/profile',
        ];

        foreach ($halamanAdmin as $url) {
            $response = $this->actingAs($this->admin)->get($url);

            $this->assertSame(200, $response->getStatusCode(), "Gagal mengakses {$url} sebagai Admin");

            // Pastikan bebas dari data dummy bawaan template
            $response->assertDontSee('Musharof');
            $response->assertDontSee('pimjo.com');
            $response->assertDontSee('Nganter App');
            $response->assertDontSee('tailadmin.com');
            $response->assertDontSee('Terry Franci');

            // Pastikan identitas proyek BKS muncul
            $response->assertSee('Barelang KS');
            $response->assertSee('BKS');
        }
    }

    public function test_semua_halaman_direktur_dapat_diakses_bebas_error_dan_slop(): void
    {
        $halamanDirektur = [
            '/panel',
            '/panel/spk',
            '/panel/spk/calendar',
            '/panel/spk/' . $this->spk->id,
            '/panel/spk/monitoring/status',
            '/panel/spk/monitoring/billing',
            '/panel/spk/monitoring/completed',
            '/panel/cash-in',
            '/panel/cash-out',
            '/panel/receipts',
            '/panel/reports',
            '/panel/partners',
            '/panel/users',
            '/panel/users/create',
            '/panel/users/' . $this->admin->id . '/edit',
            '/panel/status',
            '/panel/backup',
            '/panel/import',
            '/panel/profile',
        ];

        foreach ($halamanDirektur as $url) {
            $response = $this->actingAs($this->direktur)->get($url);

            $this->assertSame(200, $response->getStatusCode(), "Gagal mengakses {$url} sebagai Direktur");

            // Bebas slop
            $response->assertDontSee('Musharof');
            $response->assertDontSee('pimjo.com');
            $response->assertDontSee('Nganter App');

            // Identitas BKS
            $response->assertSee('Barelang KS');
        }
    }
}
