<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * PERINTAH `app:buat-admin` - bagian checklist hardening (B1-5).
 *
 * ⚠️ KENAPA PERLU:
 * Seeder lama menanam akun `admin@bks.test` / `password` LANGSUNG di repo.
 * Siapa pun yang punya akses repo tahu password default server. Seeder hanya
 * boleh dipakai di pengembangan; di server, admin pertama dibuat lewat perintah
 * interaktif yang MEMINTA password (tidak ada default di kode).
 */
class BuatAdminCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_membuat_admin_dengan_password_yang_diberikan(): void
    {
        $this->artisan('app:buat-admin')
            ->expectsQuestion('Nama lengkap', 'Admin Baru')
            ->expectsQuestion('Email', 'admin.baru@bks.test')
            ->expectsQuestion('Password (min 8 karakter, huruf & angka)', 'Rahasia123')
            ->expectsQuestion('Ulangi password', 'Rahasia123')
            ->assertSuccessful();

        $user = Pengguna::where('email', 'admin.baru@bks.test')->first();

        $this->assertNotNull($user);
        $this->assertSame('Admin Baru', $user->nama);
        $this->assertSame(Peran::Admin, $user->peran);
        $this->assertTrue($user->is_aktif);
        $this->assertTrue(Hash::check('Rahasia123', $user->password));
    }

    public function test_menolak_password_lemah(): void
    {
        $this->artisan('app:buat-admin')
            ->expectsQuestion('Nama lengkap', 'Admin Lemah')
            ->expectsQuestion('Email', 'lemah@bks.test')
            ->expectsQuestion('Password (min 8 karakter, huruf & angka)', '12345678')
            ->assertFailed();

        $this->assertDatabaseMissing('pengguna', ['email' => 'lemah@bks.test']);
    }

    public function test_menolak_email_duplikat(): void
    {
        Pengguna::factory()->create(['email' => 'sudah@bks.test']);

        $this->artisan('app:buat-admin')
            ->expectsQuestion('Nama lengkap', 'Admin Ganda')
            ->expectsQuestion('Email', 'sudah@bks.test')
            ->assertFailed();

        $this->assertSame(1, Pengguna::where('email', 'sudah@bks.test')->count());
    }

    public function test_bisa_membuat_direktur(): void
    {
        $this->artisan('app:buat-admin --direktur')
            ->expectsQuestion('Nama lengkap', 'Direktur Baru')
            ->expectsQuestion('Email', 'dirut@bks.test')
            ->expectsQuestion('Password (min 8 karakter, huruf & angka)', 'Rahasia123')
            ->expectsQuestion('Ulangi password', 'Rahasia123')
            ->assertSuccessful();

        $this->assertSame(
            Peran::Direktur,
            Pengguna::where('email', 'dirut@bks.test')->first()->peran
        );
    }
}
