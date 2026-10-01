<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Model & form: pilihan akun Kas/Bank.
 */
class FormAkunTest extends TestCase
{
    use RefreshDatabase;

    public function test_model_mengembalikan_enum(): void
    {
        $masuk = UangMasuk::factory()->create(['akun' => 'bank']);
        $keluar = UangKeluar::factory()->create(['akun' => 'kas']);

        $this->assertSame(AkunKas::Bank, $masuk->fresh()->akun);
        $this->assertSame(AkunKas::Kas, $keluar->fresh()->akun);
    }

    public function test_form_uang_masuk_memuat_pilihan_akun(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        $html = $this->get('/admin/uang-masuks/create')->assertSuccessful()->getContent();

        $this->assertStringContainsString('Kas', $html);
        $this->assertStringContainsString('Bank', $html);
    }

    public function test_form_uang_keluar_memuat_pilihan_akun(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        $html = $this->get('/admin/uang-keluars/create')->assertSuccessful()->getContent();

        $this->assertStringContainsString('Kas', $html);
        $this->assertStringContainsString('Bank', $html);
    }
}
