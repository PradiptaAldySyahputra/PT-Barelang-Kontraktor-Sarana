<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Uji PENGALIHAN rute lama -> Filament.
 *
 * ⚠️ BUG YANG DICEGAH:
 * Di v3.5 halaman Blade lama dihapus, TAPI rute /login tidak disisakan
 * pengalihannya. Akibatnya membuka /login menghasilkan 404 — membingungkan
 * karena sebelumnya di situ ada halaman login.
 *
 * Test ini memastikan semua URL lama tetap mengarah ke tempat yang benar.
 */
class PengalihanRuteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{string, string}>
     */
    public static function ruteLamaProvider(): array
    {
        return [
            'login lama' => ['/login', '/admin/login'],
            'dashboard lama' => ['/dashboard', '/admin'],
            'home' => ['/home', '/admin'],
            'admin dashboard' => ['/admin/dashboard', '/admin'],
            'beranda' => ['/', '/admin'],
        ];
    }

    #[DataProvider('ruteLamaProvider')]
    public function test_rute_lama_mengalihkan_dengan_benar(string $dari, string $ke): void
    {
        $this->get($dari)->assertRedirect($ke);
    }

    public function test_halaman_login_filament_bisa_dibuka(): void
    {
        $this->get('/admin/login')->assertOk();
    }

    public function test_pengguna_sudah_login_dialihkan_dari_login_ke_dashboard(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        // /login -> /admin/login -> /admin (oleh Filament)
        $this->actingAs($admin)
            ->get('/admin/login')
            ->assertRedirect('/admin');
    }

    public function test_url_yang_benar_benar_tidak_ada_tetap_404(): void
    {
        // Pengalihan TIDAK boleh menelan semua URL — halaman ngawur tetap 404
        $this->get('/halaman-yang-tidak-ada')->assertNotFound();
    }

    public function test_semua_halaman_utama_dapat_dijangkau(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        foreach ([
            '/admin',
            '/admin/spks',
            '/admin/mitras',
            '/admin/uang-masuks',
            '/admin/uang-keluars',
            '/admin/penggunas',
            '/admin/laporan',
        ] as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
    }

    public function test_rute_lama_tidak_bisa_dipakai_masuk_tanpa_login(): void
    {
        // /dashboard mengarah ke /admin, yang lalu minta login.
        $this->get('/dashboard')->assertRedirect('/admin');
        $this->get('/admin')->assertRedirect('/admin/login');
    }
}
