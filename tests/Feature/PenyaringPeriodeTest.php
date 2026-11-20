<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenyaringPeriodeTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => 'admin']);
    }

    public function test_lima_tabel_menampilkan_preset_periode_tanpa_pagination(): void
    {
        $admin = $this->admin();

        $halaman = [
            '/panel/cash-in' => 'Uang Masuk',
            '/panel/cash-out' => 'Uang Keluar',
            '/panel/spk' => 'SPK',
            '/panel/spk/monitoring/status' => 'Monitoring SPK',
            '/panel/receipts' => 'Arsip Nota',
        ];

        foreach ($halaman as $url => $nama) {
            $respon = $this->actingAs($admin)->get($url);
            $respon->assertStatus(200);

            $html = $respon->getContent();

            $this->assertStringContainsString('7 Hari', $html, "{$nama}: preset 7 Hari tidak tampil");
            $this->assertStringContainsString('Bulan Ini', $html, "{$nama}: preset Bulan Ini tidak tampil");
            $this->assertStringContainsString('Tahun Ini', $html, "{$nama}: preset Tahun Ini tidak tampil");

            // Pagination (ellipsis / link halaman) tidak boleh tampil lagi.
            $this->assertStringNotContainsString('paginators', $html, "{$nama}: masih ada pagination");
        }
    }

    public function test_arsip_nota_menormalkan_preset_periode_ke_rentang_tanggal(): void
    {
        $admin = $this->admin();

        $respon = $this->actingAs($admin)->get('/panel/receipts?periode=bulan');
        $respon->assertStatus(200);
        $this->assertStringContainsString('Periode', $respon->getContent());
    }
}
