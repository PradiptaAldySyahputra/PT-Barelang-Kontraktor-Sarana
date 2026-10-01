<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tabel uang masuk & keluar menampilkan pembeda Kas/Bank + bisa difilter.
 *
 * ⚠️ CATATAN: label kolom diubah 'Akun' → 'Kas/Bank' (permintaan pengguna
 * 26 Sep 2026) supaya admin langsung paham pembedanya adalah Kas atau Bank.
 */
class TabelAkunTest extends TestCase
{
    use RefreshDatabase;

    public function test_tabel_uang_masuk_menampilkan_akun(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        UangMasuk::factory()->create(['akun' => 'bank', 'keterangan' => 'Setoran bank']);
        $this->actingAs($admin);

        $html = $this->get('/admin/uang-masuks')->assertSuccessful()->getContent();

        $this->assertStringContainsString('Kas/Bank', $html);
    }

    public function test_tabel_uang_keluar_menampilkan_akun(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        UangKeluar::factory()->create(['akun' => 'kas', 'keterangan' => 'Belanja material']);
        $this->actingAs($admin);

        $html = $this->get('/admin/uang-keluars')->assertSuccessful()->getContent();

        $this->assertStringContainsString('Kas/Bank', $html);
    }
}
