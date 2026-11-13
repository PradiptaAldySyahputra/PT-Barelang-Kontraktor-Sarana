<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Enums\StatusSpk;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Support\NotifikasiOperasional;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class NotifikasiOperasionalHeaderTest extends TestCase
{
    use RefreshDatabase;

    public function test_notifikasi_menghitung_spk_lewat_dan_mendekati_tenggat(): void
    {
        // 1. SPK lewat tenggat
        Spk::factory()->create([
            'tanggal_akhir' => now()->subDays(5),
            'status_spk' => StatusSpk::Berjalan,
        ]);

        // 2. SPK mendekati tenggat
        Spk::factory()->create([
            'tanggal_akhir' => now()->addDays(5),
            'status_spk' => StatusSpk::Berjalan,
        ]);

        NotifikasiOperasional::segarkan();
        $hasil = NotifikasiOperasional::ambil();

        $this->assertGreaterThanOrEqual(2, $hasil['jumlah']['pekerjaan']);
        $this->assertSame(2, $hasil['total']);
        $this->assertNotEmpty($hasil['daftar']);
    }

    public function test_cache_notifikasi_berfungsi_dan_dapat_disegarkan(): void
    {
        NotifikasiOperasional::segarkan();

        $dataAwal = NotifikasiOperasional::ambil();
        $this->assertTrue(Cache::has('bks_header_notifikasi_operasional'));

        NotifikasiOperasional::segarkan();
        $this->assertFalse(Cache::has('bks_header_notifikasi_operasional'));
    }

    public function test_komponen_dropdown_header_dirender_dengan_sukses(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);

        $this->actingAs($admin)
            ->get(route('panel.dashboard'))
            ->assertOk()
            ->assertSee('Notifikasi');
    }
}
