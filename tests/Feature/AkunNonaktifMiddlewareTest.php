<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * AKUN NONAKTIF LANGSUNG KEHILANGAN AKSES — VERIFIKASI (9 Okt 2026).
 *
 * ⚠️ KOREKSI TEMUAN AUDIT:
 * Awalnya dikira akun nonaktif masih bisa memakai sesi yang sedang aktif
 * sampai logout/kedaluwarsa. Setelah ditelusuri, ternyata TIDAK:
 * `Filament\Http\Middleware\Authenticate::authenticate()` memanggil
 * `$user->canAccessPanel($panel)` pada SETIAP request (bukan hanya saat login),
 * dan `canAccessPanel()` menolak `is_aktif = false`. Jadi akses langsung
 * ditolak 403 begitu akun dinonaktifkan — perilaku sudah BENAR.
 *
 * Tes ini mengunci perilaku tersebut supaya tidak berubah diam-diam bila
 * Filament naik versi mayor.
 */
class AkunNonaktifMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_akun_yang_dinonaktifkan_saat_login_langsung_ditolak(): void
    {
        $admin = Pengguna::factory()->admin()->create([
            'email' => 'dinonaktifkan@bks.test',
            'is_aktif' => true,
        ]);

        // Login dulu selagi aktif.
        $this->actingAs($admin)->get('/admin')->assertSuccessful();

        // Direktur menonaktifkan akun (di DB).
        $admin->update(['is_aktif' => false]);

        // Request berikutnya HARUS ditolak (403), bukan tetap 200.
        $this->actingAs($admin->fresh())
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_akun_aktif_tetap_bisa_memakai_panel(): void
    {
        $admin = Pengguna::factory()->admin()->create([
            'email' => 'masih-aktif@bks.test',
            'is_aktif' => true,
        ]);

        $this->actingAs($admin)->get('/admin')->assertSuccessful();
    }
}
