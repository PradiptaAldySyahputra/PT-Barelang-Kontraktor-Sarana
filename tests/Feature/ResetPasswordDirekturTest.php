<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Pengujian fitur Reset Password Staf langsung oleh Direktur.
 *
 * Sangat krusial untuk server internal yang berjalan offline tanpa SMTP email.
 */
class ResetPasswordDirekturTest extends TestCase
{
    use RefreshDatabase;

    private function pengguna(Peran $peran): Pengguna
    {
        return Pengguna::factory()->create([
            'peran' => $peran,
            'password' => 'password-lama-123',
            'is_aktif' => true,
        ]);
    }

    public function test_tamu_ditolak_saat_mencoba_reset_password(): void
    {
        $staf = $this->pengguna(Peran::Admin);

        $this->post(route('panel.users.reset-password', $staf), [
            'password' => 'password-baru-123',
        ])->assertRedirect('/panel/login');
    }

    public function test_admin_ditolak_403_saat_mencoba_reset_password_staf_lain(): void
    {
        $admin = $this->pengguna(Peran::Admin);
        $staf = $this->pengguna(Peran::Admin);

        $this->actingAs($admin)
            ->post(route('panel.users.reset-password', $staf), [
                'password' => 'password-baru-123',
            ])->assertForbidden();
    }

    public function test_direktur_berhasil_mereset_password_staf_lain(): void
    {
        $direktur = $this->pengguna(Peran::Direktur);
        $staf = $this->pengguna(Peran::Admin);

        $response = $this->actingAs($direktur)
            ->post(route('panel.users.reset-password', $staf), [
                'password' => 'password-baru-123',
            ]);

        $response->assertRedirect(route('panel.users.index'))
            ->assertSessionHas('berhasil', "Kata sandi untuk pengguna {$staf->nama} berhasil direset.");

        $staf->refresh();
        $this->assertTrue(Hash::check('password-baru-123', $staf->password));
    }

    public function test_password_baru_dapat_digunakan_staf_untuk_login(): void
    {
        $direktur = $this->pengguna(Peran::Direktur);
        $staf = $this->pengguna(Peran::Admin);

        $this->actingAs($direktur)
            ->post(route('panel.users.reset-password', $staf), [
                'password' => 'sandibaru999',
            ]);

        // Coba login sebagai staf dengan password baru (tanpa intended URL dari request actingAs sebelumnya)
        $this->app['auth']->forgetGuards();
        $this->flushSession();

        $this->post('/panel/login', [
            'email' => $staf->email,
            'password' => 'sandibaru999',
        ])->assertRedirect(route('panel.dashboard'));

        $this->assertAuthenticatedAs($staf);
    }

    public function test_sesi_lama_staf_otomatis_terputus_setelah_reset_password(): void
    {
        $direktur = $this->pengguna(Peran::Direktur);
        $staf = $this->pengguna(Peran::Admin);

        // Simulasi baris sesi staf di tabel sessions
        DB::table('sessions')->insert([
            'id' => 'sesi-lama-staf-123',
            'user_id' => $staf->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0',
            'payload' => 'dummy',
            'last_activity' => time(),
        ]);

        $this->assertDatabaseHas('sessions', ['user_id' => $staf->id]);

        $this->actingAs($direktur)
            ->post(route('panel.users.reset-password', $staf), [
                'password' => 'password-baru-123',
            ]);

        // Sesi staf di tabel sessions harus sudah terhapus
        $this->assertDatabaseMissing('sessions', ['user_id' => $staf->id]);
    }

    public function test_direktur_tidak_bisa_mereset_akun_sendiri_lewat_rute_ini(): void
    {
        $direktur = $this->pengguna(Peran::Direktur);

        $response = $this->actingAs($direktur)
            ->post(route('panel.users.reset-password', $direktur), [
                'password' => 'password-baru-123',
            ]);

        $response->assertRedirect(route('panel.users.index'))
            ->assertSessionHas('gagal', 'Tidak bisa mereset password akun sendiri lewat rute ini. Silakan ubah password lewat menu Profil.');

        $direktur->refresh();
        $this->assertTrue(Hash::check('password-lama-123', $direktur->password));
    }

    public function test_validasi_password_minimal_dan_wajib(): void
    {
        $direktur = $this->pengguna(Peran::Direktur);
        $staf = $this->pengguna(Peran::Admin);

        $this->actingAs($direktur)
            ->post(route('panel.users.reset-password', $staf), [
                'password' => 'pendek',
            ])->assertSessionHasErrors('password');

        $this->actingAs($direktur)
            ->post(route('panel.users.reset-password', $staf), [
                'password' => '',
            ])->assertSessionHasErrors('password');
    }
}
