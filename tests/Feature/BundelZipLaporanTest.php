<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BundelZipLaporanTest extends TestCase
{
    use RefreshDatabase;

    public function test_tamu_tidak_bisa_mengunduh_bundel_zip(): void
    {
        $this->get(route('laporan.bundel'))->assertRedirect(route('panel.login'));
    }

    public function test_admin_dan_direktur_bisa_mengunduh_bundel_zip_laporan(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);

        $response = $this->actingAs($admin)
            ->get(route('laporan.bundel', ['periode' => 1]));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/zip');
        $this->assertStringContainsString('.zip', (string) $response->headers->get('content-disposition'));
    }
}
