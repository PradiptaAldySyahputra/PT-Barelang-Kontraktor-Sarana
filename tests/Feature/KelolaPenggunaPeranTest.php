<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Resources\Penggunas\Pages\CreatePengguna;
use App\Filament\Resources\Penggunas\Pages\ListPenggunas;
use App\Filament\Resources\Penggunas\PenggunaResource;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * KELOLA PENGGUNA — HANYA DIREKTUR.
 *
 * Permintaan pengguna: "bagian pengguna hanya direktur yang bisa lihat" dan
 * "direktur bisa menambah user".
 *
 * Berkas ini MEMBUKTIKAN alur ujung-ke-ujung (bukan sekadar memeriksa flag):
 *   - Direktur  : menu muncul, boleh tambah/ubah/hapus (kecuali akun sendiri).
 *   - Admin     : menu TIDAK muncul, dan halaman langsung 403 bila diakses.
 */
class KelolaPenggunaPeranTest extends TestCase
{
    use RefreshDatabase;

    // ---------------------------------------------------------------
    // DIREKTUR — boleh kelola pengguna
    // ---------------------------------------------------------------

    public function test_direktur_melihat_menu_pengguna(): void
    {
        $direktur = Pengguna::factory()->direktur()->create();

        $this->actingAs($direktur);

        $this->assertTrue(PenggunaResource::shouldRegisterNavigation());
        $this->assertTrue(PenggunaResource::canViewAny());
    }

    public function test_direktur_bisa_membuka_daftar_pengguna(): void
    {
        $direktur = Pengguna::factory()->direktur()->create();

        $this->actingAs($direktur);

        Livewire::test(ListPenggunas::class)->assertSuccessful();
    }

    public function test_direktur_bisa_membuka_form_tambah_pengguna(): void
    {
        $direktur = Pengguna::factory()->direktur()->create();

        $this->actingAs($direktur);

        Livewire::test(CreatePengguna::class)->assertSuccessful();
    }

    public function test_direktur_bisa_benar_benar_menambah_pengguna(): void
    {
        $direktur = Pengguna::factory()->direktur()->create(['email' => 'dir@bks.test']);
        $this->actingAs($direktur);

        Livewire::test(CreatePengguna::class)
            ->fillForm([
                'nama' => 'Admin Baru',
                'email' => 'admin-baru@bks.test',
                'peran' => Peran::Admin->value,
                'is_aktif' => true,
                'password' => 'rahasia123',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('pengguna', [
            'email' => 'admin-baru@bks.test',
            'nama' => 'Admin Baru',
            'peran' => Peran::Admin->value,
        ]);
    }

    public function test_direktur_bisa_mengubah_pengguna_lain(): void
    {
        $direktur = Pengguna::factory()->direktur()->create();
        $lain = Pengguna::factory()->admin()->create();

        $this->actingAs($direktur);

        $this->assertTrue(PenggunaResource::canEdit($lain));
    }

    public function test_direktur_tidak_bisa_mengubah_atau_menghapus_akun_sendiri(): void
    {
        $direktur = Pengguna::factory()->direktur()->create();
        $this->actingAs($direktur);

        // Pengaman sistem terkunci: cegah Direktur mengunci dirinya sendiri.
        $this->assertFalse(PenggunaResource::canEdit($direktur));
        $this->assertFalse(PenggunaResource::canDelete($direktur));
    }

    // ---------------------------------------------------------------
    // ADMIN — TIDAK boleh kelola pengguna
    // ---------------------------------------------------------------

    public function test_admin_tidak_melihat_menu_pengguna(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        $this->actingAs($admin);

        $this->assertFalse(PenggunaResource::shouldRegisterNavigation());
        $this->assertFalse(PenggunaResource::canViewAny());
    }

    public function test_admin_ditolak_403_saat_buka_daftar_pengguna(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        $this->get(PenggunaResource::getUrl('index'))->assertForbidden();
    }

    public function test_admin_ditolak_403_saat_buka_form_tambah_pengguna(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        $this->get(PenggunaResource::getUrl('create'))->assertForbidden();
    }
}
