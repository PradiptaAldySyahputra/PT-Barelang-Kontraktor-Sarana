<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengguna_bisa_mengakses_dan_mengubah_profil_sendiri(): void
    {
        Storage::fake('nota');

        $user = Pengguna::factory()->create([
            'nama' => 'Nama Lama',
            'email' => 'lama@bks.test',
            'peran' => Peran::Admin,
            'is_aktif' => true,
        ]);

        $this->actingAs($user)
            ->get(route('panel.profile'))
            ->assertOk()
            ->assertSee('Profil Saya');

        $fileAvatar = UploadedFile::fake()->image('avatar.jpg', 150, 150);

        $response = $this->actingAs($user)
            ->put(route('panel.profile.update'), [
                'nama' => 'Nama Baru BKS',
                'email' => 'baru@bks.test',
                'avatar' => $fileAvatar,
            ]);

        $response->assertRedirect(route('panel.profile'));
        $response->assertSessionHas('berhasil');

        $user->refresh();
        $this->assertSame('Nama Baru BKS', $user->nama);
        $this->assertSame('baru@bks.test', $user->email);
        $this->assertNotNull($user->avatar);
    }

    public function test_pengguna_bisa_mengganti_kata_sandi_dan_memutus_sesi_lain(): void
    {
        $user = Pengguna::factory()->create([
            'password' => Hash::make('password123'),
            'peran' => Peran::Admin,
            'is_aktif' => true,
        ]);

        // Simulasikan sesi lain di tabel sessions
        DB::table('sessions')->insert([
            'id' => 'sesi_komputer_kantor_lain',
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 Chrome',
            'payload' => base64_encode('dummy_session_data'),
            'last_activity' => time(),
        ]);

        $this->assertSame(1, DB::table('sessions')->where('id', 'sesi_komputer_kantor_lain')->count());

        $response = $this->actingAs($user)
            ->put(route('panel.profile.password'), [
                'password_lama' => 'password123',
                'password' => 'PasswordBaru#2026',
                'password_confirmation' => 'PasswordBaru#2026',
            ]);

        $response->assertRedirect(route('panel.profile'));
        $response->assertSessionHas('berhasil');

        $user->refresh();
        $this->assertTrue(Hash::check('PasswordBaru#2026', $user->password));

        // Pastikan sesi lain terhapus
        $this->assertSame(0, DB::table('sessions')->where('id', 'sesi_komputer_kantor_lain')->count());
    }

    public function test_ganti_kata_sandi_gagal_jika_sandi_lama_salah(): void
    {
        $user = Pengguna::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user)
            ->put(route('panel.profile.password'), [
                'password_lama' => 'password_salah',
                'password' => 'PasswordBaru#2026',
                'password_confirmation' => 'PasswordBaru#2026',
            ]);

        $response->assertSessionHasErrors(['password_lama']);
    }
}
