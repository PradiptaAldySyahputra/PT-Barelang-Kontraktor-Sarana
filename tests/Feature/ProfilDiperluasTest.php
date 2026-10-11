<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Pages\ProfilAkun;
use App\Models\Pengguna;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * PROFIL SAYA — perluasan 10 Okt 2026.
 *
 * Menambah: foto profil, tanda tangan, dan info akun (peran + login terakhir)
 * di atas form bawaan (nama, email, ganti password).
 */
class ProfilDiperluasTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    public function test_halaman_profil_dapat_dibuka_dan_memuat_field_baru(): void
    {
        $this->actingAs($this->admin());

        Livewire::test(ProfilAkun::class)
            ->assertOk()
            ->assertFormFieldExists('nama')
            ->assertFormFieldExists('email')
            ->assertFormFieldExists('avatar')
            ->assertFormFieldExists('tanda_tangan')
            ->assertFormFieldExists('password');
    }

    public function test_menyimpan_nama_baru_tersimpan_ke_kolom_nama(): void
    {
        $user = $this->admin();
        $this->actingAs($user);

        Livewire::test(ProfilAkun::class)
            ->fillForm([
                'nama' => 'Nama Diubah',
                'email' => $user->email,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('pengguna', [
            'id' => $user->id,
            'nama' => 'Nama Diubah',
        ]);
    }

    public function test_event_login_mencatat_waktu_terakhir_masuk(): void
    {
        $user = $this->admin();

        $this->assertNull($user->terakhir_masuk);

        Event::dispatch(new Login('web', $user, false));

        $this->assertNotNull($user->fresh()->terakhir_masuk);
    }

    public function test_terakhir_masuk_ditampilkan_di_profil(): void
    {
        $user = $this->admin();
        $user->forceFill(['terakhir_masuk' => now()])->save();
        $this->actingAs($user);

        Livewire::test(ProfilAkun::class)
            ->assertOk()
            ->assertSee('Login terakhir');
    }
}
