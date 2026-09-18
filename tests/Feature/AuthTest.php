<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * Uji autentikasi & pembatasan akses berbasis peran.
 *
 * Sesuai Rules.md §4: "Authorization wajib memakai middleware role —
 * BUKAN hanya menyembunyikan menu."
 *
 * Jadi test ini memastikan request yang tidak berhak DITOLAK (403),
 * bukan sekadar menunya tidak tampil.
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;

    // ---------------------------------------------------------
    // Halaman login
    // ---------------------------------------------------------

    public function test_halaman_login_bisa_dibuka_tamu(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('SIAKAD SPK');
    }

    public function test_tamu_diarahkan_ke_login_saat_buka_dashboard(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_tamu_yang_buka_beranda_akhirnya_sampai_di_login(): void
    {
        // Beranda mengarahkan ke dashboard, lalu middleware auth
        // mengarahkan tamu ke halaman login (2 hop).
        $this->get('/')->assertRedirect(route('dashboard'));

        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    // ---------------------------------------------------------
    // Proses login
    // ---------------------------------------------------------

    public function test_admin_bisa_login_dengan_kredensial_benar(): void
    {
        $admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-login@bks.test',
            'password' => 'rahasia123',
        ]);

        $this->post(route('login.proses'), [
            'email' => 'admin-login@bks.test',
            'password' => 'rahasia123',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_direktur_bisa_login(): void
    {
        Pengguna::factory()->direktur()->create([
            'email' => 'dir-login@bks.test',
            'password' => 'rahasia123',
        ]);

        $this->post(route('login.proses'), [
            'email' => 'dir-login@bks.test',
            'password' => 'rahasia123',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
    }

    public function test_login_gagal_dengan_password_salah(): void
    {
        Pengguna::factory()->create([
            'email' => 'salah@bks.test',
            'password' => 'benar123',
        ]);

        $this->post(route('login.proses'), [
            'email' => 'salah@bks.test',
            'password' => 'ngawur',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_gagal_kalau_email_tidak_terdaftar(): void
    {
        $this->post(route('login.proses'), [
            'email' => 'tidak-ada@bks.test',
            'password' => 'apa-saja',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_butuh_email_dan_password(): void
    {
        $this->post(route('login.proses'), [])
            ->assertSessionHasErrors(['email', 'password']);

        $this->assertGuest();
    }

    public function test_akun_nonaktif_tidak_bisa_login(): void
    {
        Pengguna::factory()->nonaktif()->create([
            'email' => 'nonaktif@bks.test',
            'password' => 'rahasia123',
        ]);

        $this->post(route('login.proses'), [
            'email' => 'nonaktif@bks.test',
            'password' => 'rahasia123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_pengguna_sudah_login_tidak_bisa_buka_halaman_login(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('login'))
            ->assertRedirect(route('dashboard'));
    }

    // ---------------------------------------------------------
    // Logout
    // ---------------------------------------------------------

    public function test_pengguna_bisa_logout(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    // ---------------------------------------------------------
    // Akses dashboard
    // ---------------------------------------------------------

    public function test_admin_bisa_buka_dashboard(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Total Nilai SPK');
    }

    public function test_direktur_bisa_buka_dashboard(): void
    {
        $direktur = Pengguna::factory()->direktur()->create();

        $this->actingAs($direktur)
            ->get(route('dashboard'))
            ->assertOk();
    }

    // ---------------------------------------------------------
    // Middleware peran — INTI Rules.md §4
    // ---------------------------------------------------------

    public function test_middleware_peran_menolak_peran_yang_tidak_berhak(): void
    {
        // Daftarkan route uji yang hanya boleh Admin
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
}
