<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Resources\Spks\SpkResource;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * Uji autentikasi & pembatasan akses berbasis peran.
 *
 * Sejak v3.5, SELURUH antarmuka memakai panel Filament di /admin.
 * Halaman Blade lama (login & dashboard custom) sudah dihapus.
 *
 * Untuk uji login lewat Filament (Livewire), lihat FilamentTest.
 *
 * Sesuai Rules.md §4: pembatasan dilakukan di level otorisasi,
 * bukan sekadar menyembunyikan menu.
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;

    // ---------------------------------------------------------
    // Pintu masuk
    // ---------------------------------------------------------

    public function test_beranda_mengarahkan_ke_panel_filament(): void
    {
        $this->get('/')->assertRedirect('/admin');
    }

    public function test_tamu_diarahkan_ke_login_filament(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_halaman_login_filament_bisa_dibuka_tamu(): void
    {
        $this->get('/admin/login')->assertOk();
    }

    public function test_pengguna_sudah_login_tidak_bisa_buka_halaman_login(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/admin/login')
            ->assertRedirect('/admin');
    }

    // ---------------------------------------------------------
    // Akses panel
    // ---------------------------------------------------------

    public function test_admin_bisa_buka_dashboard_panel(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        $this->actingAs($admin)->get('/admin')->assertOk();
    }

    public function test_direktur_bisa_buka_dashboard_panel(): void
    {
        $direktur = Pengguna::factory()->direktur()->create();

        $this->actingAs($direktur)->get('/admin')->assertOk();
    }

    public function test_akun_nonaktif_tidak_bisa_masuk_panel(): void
    {
        $nonaktif = Pengguna::factory()->admin()->nonaktif()->create();

        $this->assertFalse($nonaktif->canAccessPanel(filament()->getPanel('admin')));
    }

    // ---------------------------------------------------------
    // Middleware peran — INTI Rules.md §4
    // ---------------------------------------------------------

    public function test_middleware_peran_menolak_peran_yang_tidak_berhak(): void
    {
        Route::middleware(['web', 'auth', 'peran:admin'])
            ->get('/uji-hanya-admin', fn (): string => 'rahasia admin');

        $direktur = Pengguna::factory()->direktur()->create();

        $this->actingAs($direktur)
            ->get('/uji-hanya-admin')
            ->assertForbidden();   // 403 — DITOLAK, bukan sekadar menu disembunyikan
    }

    public function test_middleware_peran_mengizinkan_peran_yang_berhak(): void
    {
        Route::middleware(['web', 'auth', 'peran:admin'])
            ->get('/uji-hanya-admin-2', fn (): string => 'rahasia admin');

        $admin = Pengguna::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/uji-hanya-admin-2')
            ->assertOk()
            ->assertSee('rahasia admin');
    }

    public function test_middleware_peran_menerima_beberapa_peran(): void
    {
        Route::middleware(['web', 'auth', 'peran:admin,direktur'])
            ->get('/uji-dua-peran', fn (): string => 'boleh berdua');

        $admin = Pengguna::factory()->admin()->create();
        $direktur = Pengguna::factory()->direktur()->create();

        $this->actingAs($admin)->get('/uji-dua-peran')->assertOk();
        $this->actingAs($direktur)->get('/uji-dua-peran')->assertOk();
    }

    public function test_akun_nonaktif_ditolak_oleh_middleware_peran(): void
    {
        Route::middleware(['web', 'auth', 'peran:admin'])
            ->get('/uji-nonaktif', fn (): string => 'rahasia');

        $nonaktif = Pengguna::factory()->admin()->nonaktif()->create();

        $this->actingAs($nonaktif)
            ->get('/uji-nonaktif')
            ->assertForbidden();
    }

    // ---------------------------------------------------------
    // Helper peran di model
    // ---------------------------------------------------------

    public function test_helper_boleh_input(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $direktur = Pengguna::factory()->direktur()->create();

        $this->assertTrue($admin->bolehInput());
        $this->assertFalse($direktur->bolehInput());
    }

    public function test_peran_di_cast_ke_enum(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $direktur = Pengguna::factory()->direktur()->create();

        $this->assertSame(Peran::Admin, $admin->peran);
        $this->assertSame(Peran::Direktur, $direktur->peran);
    }

    public function test_hak_akses_resource_mengikuti_peran(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $direktur = Pengguna::factory()->direktur()->create();

        $this->actingAs($admin);
        $this->assertTrue(SpkResource::canCreate());

        $this->actingAs($direktur);
        $this->assertFalse(SpkResource::canCreate());
    }
}
