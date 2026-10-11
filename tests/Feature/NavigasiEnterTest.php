<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * NAVIGASI KEYBOARD — Enter pindah ke field berikutnya.
 *
 * ⚠️ SARAN USER (9 Okt 2026):
 * "Navigasi keyboard — Enter pindah ke field berikutnya; ini mempercepat input
 *  2–3× lipat dibanding klik mouse terus."
 *
 * ⚠️ CATATAN: perilaku aktual (fokus berpindah) terjadi di browser. Tes ini
 * mengunci bahwa SKRIP-nya benar-benar dimuat di panel — supaya tidak hilang
 * diam-diam saat panel diubah. Verifikasi perilaku ada di uji browser.
 */
class NavigasiEnterTest extends TestCase
{
    use RefreshDatabase;

    public function test_skrip_enter_dimuat_di_halaman_admin(): void
    {
        $admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-enter@bks.test',
        ]);

        $html = $this->actingAs($admin)
            ->get('/admin')
            ->assertSuccessful()
            ->getContent();

        $this->assertStringContainsString(
            'bks-enter-berikutnya',
            $html,
            'Panel harus memuat skrip navigasi Enter (render hook body.end).',
        );
    }

    public function test_skrip_tidak_mengambil_alih_textarea(): void
    {
        $html = view('filament.enter-navigasi')->render();

        $this->assertStringContainsString(
            "el.tagName === 'TEXTAREA'",
            $html,
            'Enter di textarea harus tetap membuat baris baru.',
        );
    }
}
