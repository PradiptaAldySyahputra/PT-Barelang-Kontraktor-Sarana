<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Uji PENGALIHAN rute lama -> Panel Blade baru.
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
            'login lama' => ['/login', '/panel/login'],
            'dashboard lama' => ['/dashboard', '/panel'],
            'home' => ['/home', '/panel'],
            'admin' => ['/admin', '/panel'],
            'admin dashboard' => ['/admin/dashboard', '/panel'],
            'admin login' => ['/admin/login', '/panel/login'],
            'beranda' => ['/', '/panel'],
        ];
    }

    #[DataProvider('ruteLamaProvider')]
    public function test_rute_lama_mengalihkan_dengan_benar(string $dari, string $ke): void
    {
        $this->get($dari)->assertRedirect($ke);
    }

    public function test_halaman_login_panel_bisa_dibuka(): void
    {
        $this->get('/panel/login')->assertOk();
    }

    public function test_pengguna_sudah_login_dialihkan_dari_login_ke_dashboard(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/panel/login')
            ->assertRedirect('/dashboard');
    }

    public function test_url_yang_benar_benar_tidak_ada_tetap_404(): void
    {
        $this->get('/halaman-yang-tidak-ada')->assertNotFound();
    }

    public function test_semua_halaman_utama_panel_dapat_dijangkau(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        foreach ([
            '/panel',
            '/panel/spk',
            '/panel/partners',
            '/panel/cash-in',
            '/panel/cash-out',
            '/panel/reports',
        ] as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
    }

    public function test_rute_lama_tidak_bisa_dipakai_masuk_tanpa_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/panel');
        $this->get('/panel')->assertRedirect('/panel/login');
    }
}
