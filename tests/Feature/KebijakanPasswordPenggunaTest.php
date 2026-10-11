<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Resources\Penggunas\Pages\CreatePengguna;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * KEBIJAKAN PASSWORD HARUS SERAGAM di SEMUA tempat.
 *
 * `AppServiceProvider` memusatkan aturan: min 8, huruf + angka. Tetapi form
 * Pengguna memakai `->minLength(8)` SENDIRI — bukan `Password::default()` —
 * sehingga password lemah seperti "12345678" (angka saja) LOLOS dari form
 * pengguna, padahal ditolak di halaman Profil / Lupa Password.
 *
 * Ini celah keamanan: Direktur bisa membuat akun berpassword lemah.
 */
class KebijakanPasswordPenggunaTest extends TestCase
{
    use RefreshDatabase;

    private function direktur(): Pengguna
    {
        return Pengguna::factory()->direktur()->create([
            'email' => 'dir-pw@bks.test',
        ]);
    }

    public function test_password_hanya_angka_ditolak_di_form_pengguna(): void
    {
        $this->actingAs($this->direktur());

        Livewire::test(CreatePengguna::class)
            ->fillForm([
                'nama' => 'Akun Lemah',
                'email' => 'lemah@bks.test',
                'peran' => Peran::Admin->value,
                'is_aktif' => true,
                'password' => '12345678',
            ])
            ->call('create')
            ->assertHasFormErrors(['password']);
    }

    public function test_password_kuat_diterima_di_form_pengguna(): void
    {
        $this->actingAs($this->direktur());

        Livewire::test(CreatePengguna::class)
            ->fillForm([
                'nama' => 'Akun Kuat',
                'email' => 'kuat@bks.test',
                'peran' => Peran::Admin->value,
                'is_aktif' => true,
                'password' => 'rahasia123',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('pengguna', ['email' => 'kuat@bks.test']);
    }
}
