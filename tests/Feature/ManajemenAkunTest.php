<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Pages\LupaPassword;
use App\Filament\Pages\ProfilAkun;
use App\Models\Pengguna;
use Filament\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Filament\Auth\Pages\PasswordReset\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * MANAJEMEN AKUN — Profil, Ubah Password, Lupa Password.
 *
 * Permintaan user (9 Okt 2026):
 *   1. Halaman Profil (nama, email) — validasi email unik + notifikasi sukses.
 *   2. Ubah Password — verifikasi password lama, konfirmasi, min 8 huruf+angka,
 *      lalu putus sesi lain.
 *   3. Lupa Password — tautan di login, token kedaluwarsa maks 60 menit.
 *   4. Rate limit 5x/menit untuk login & reset; anti-enumerasi email.
 */
class ManajemenAkunTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'akun-admin@bks.test',
            'password' => 'rahasia123',
        ]);
    }

    // =========================================================
    // 1. HALAMAN PROFIL
    // =========================================================

    public function test_halaman_profil_bisa_dibuka_pengguna_login(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/profile')
            ->assertSuccessful()
            ->assertSee('Profil Saya');
    }

    public function test_tamu_tidak_bisa_buka_halaman_profil(): void
    {
        $this->get('/admin/profile')->assertRedirect('/admin/login');
    }

    public function test_profil_menyimpan_perubahan_nama_dan_email(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ProfilAkun::class)
            ->fillForm([
                'nama' => 'Nama Baru',
                'email' => 'email-baru@bks.test',
                // Mengubah email = perubahan sensitif → password saat ini wajib.
                'currentPassword' => 'rahasia123',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->admin->refresh();

        $this->assertSame('Nama Baru', $this->admin->nama);
        $this->assertSame('email-baru@bks.test', $this->admin->email);
    }

    public function test_profil_menolak_email_yang_sudah_dipakai_akun_lain(): void
    {
        Pengguna::factory()->create(['email' => 'sudah-dipakai@bks.test']);

        Livewire::actingAs($this->admin)
            ->test(ProfilAkun::class)
            ->fillForm([
                'nama' => 'Nama',
                'email' => 'sudah-dipakai@bks.test',
                'currentPassword' => 'rahasia123',
            ])
            ->call('save')
            ->assertHasFormErrors(['email']);

        $this->assertSame('akun-admin@bks.test', $this->admin->fresh()->email);
    }

    // =========================================================
    // 2. UBAH PASSWORD
    // =========================================================

    public function test_ubah_password_berhasil_dengan_password_lama_yang_benar(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ProfilAkun::class)
            ->fillForm([
                'currentPassword' => 'rahasia123',
                'password' => 'baru12345',
                'passwordConfirmation' => 'baru12345',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertTrue(
            Hash::check('baru12345', $this->admin->fresh()->password),
            'Password baru harus tersimpan setelah verifikasi password lama.',
        );
    }

    public function test_ubah_password_gagal_kalau_password_lama_salah(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ProfilAkun::class)
            ->fillForm([
                'currentPassword' => 'salah-sekali',
                'password' => 'baru12345',
                'passwordConfirmation' => 'baru12345',
            ])
            ->call('save')
            ->assertHasFormErrors(['currentPassword']);

        $this->assertTrue(
            Hash::check('rahasia123', $this->admin->fresh()->password),
            'Password LAMA tidak boleh berubah kalau verifikasi gagal.',
        );
    }

    public function test_password_baru_wajib_minimal_8_karakter(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ProfilAkun::class)
            ->fillForm([
                'currentPassword' => 'rahasia123',
                'password' => 'a1b2',
                'passwordConfirmation' => 'a1b2',
            ])
            ->call('save')
            ->assertHasFormErrors(['password']);
    }

    public function test_password_baru_wajib_kombinasi_huruf_dan_angka(): void
    {
        // Hanya huruf — harus ditolak (aturan: huruf & angka).
        Livewire::actingAs($this->admin)
            ->test(ProfilAkun::class)
            ->fillForm([
                'currentPassword' => 'rahasia123',
                'password' => 'hanyahurufsaja',
                'passwordConfirmation' => 'hanyahurufsaja',
            ])
            ->call('save')
            ->assertHasFormErrors(['password']);
    }

    public function test_password_baru_harus_sama_dengan_konfirmasi(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ProfilAkun::class)
            ->fillForm([
                'currentPassword' => 'rahasia123',
                'password' => 'baru12345',
                'passwordConfirmation' => 'beda12345',
            ])
            ->call('save')
            ->assertHasFormErrors(['password']);
    }

    // =========================================================
    // 3. LUPA PASSWORD
    // =========================================================

    public function test_halaman_lupa_password_bisa_dibuka_tamu(): void
    {
        $this->get('/admin/password-reset/request')
            ->assertSuccessful();
    }

    public function test_tautan_lupa_password_ada_di_halaman_login(): void
    {
        $this->get('/admin/login')
            ->assertSuccessful()
            ->assertSee('Lupa');
    }

    public function test_lupa_password_mengirim_notifikasi_untuk_email_terdaftar(): void
    {
        Notification::fake();

        Livewire::test(LupaPassword::class)
            ->fillForm(['email' => 'akun-admin@bks.test'])
            ->call('request')
            ->assertHasNoFormErrors();

        Notification::assertSentTo($this->admin, ResetPasswordNotification::class);
    }

    /**
     * ⚠️ ANTI-ENUMERASI: hasil untuk email TIDAK terdaftar harus SAMA
     * (tidak ada error, pesan generik) supaya penyerang tidak bisa menebak
     * email mana yang terdaftar.
     */
    public function test_lupa_password_tidak_membocorkan_email_tak_terdaftar(): void
    {
        Notification::fake();

        Livewire::test(LupaPassword::class)
            ->fillForm(['email' => 'tidak-ada@bks.test'])
            ->call('request')
            ->assertHasNoFormErrors();

        Notification::assertNothingSent();
    }

    public function test_token_reset_kedaluwarsa_maksimal_60_menit(): void
    {
        $this->assertSame(
            60,
            (int) config('auth.passwords.users.expire'),
            'Token reset password harus kedaluwarsa maksimal 60 menit.',
        );
    }

    public function test_reset_password_memakai_token_yang_sah(): void
    {
        $token = Password::broker()->createToken($this->admin);

        Livewire::test(ResetPassword::class, [
            'email' => 'akun-admin@bks.test',
            'token' => $token,
        ])
            ->fillForm([
                'password' => 'passwordbaru1',
                'passwordConfirmation' => 'passwordbaru1',
            ])
            ->call('resetPassword');

        $this->assertTrue(
            Hash::check('passwordbaru1', $this->admin->fresh()->password),
            'Reset password dengan token sah harus mengubah password.',
        );
    }
}
