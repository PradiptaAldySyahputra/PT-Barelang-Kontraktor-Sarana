<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\KategoriMitra;
use App\Filament\Resources\Mitras\MitraResource;
use App\Filament\Resources\Mitras\Pages\CreateMitra;
use App\Filament\Resources\Mitras\Pages\EditMitra;
use App\Filament\Resources\Mitras\Pages\ListMitras;
use App\Models\Mitra;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * CRUD MITRA — celah cakupan tes (survei 10 Okt 2026: hanya 1 tes).
 *
 * Mitra adalah master data inti (pemberi kerja & subkon) yang dipakai SPK &
 * transaksi. Berkas ini menguji alur lengkap: tambah, ubah, kategori Enum,
 * validasi unik/format, dan pembatasan peran (Direktur hanya lihat).
 */
class MitraCrudTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create(['email' => 'admin-mitra@bks.test']);
        $this->actingAs($this->admin);
    }

    public function test_admin_bisa_menambah_mitra(): void
    {
        Livewire::test(CreateMitra::class)
            ->fillForm([
                'nama' => 'PT Uji Mitra',
                'kategori' => KategoriMitra::Mitra->value,
                'kontak' => '081234567890',
                'alamat' => 'Batam',
                'is_aktif' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('mitra', [
            'nama' => 'PT Uji Mitra',
            'kategori' => KategoriMitra::Mitra->value,
        ]);
    }

    public function test_kategori_mitra_disimpan_sebagai_enum(): void
    {
        Livewire::test(CreateMitra::class)
            ->fillForm([
                'nama' => 'CV Subkon Uji',
                'kategori' => KategoriMitra::Subkon->value,
                'is_aktif' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $mitra = Mitra::where('nama', 'CV Subkon Uji')->firstOrFail();
        $this->assertSame(KategoriMitra::Subkon, $mitra->kategori);
    }

    public function test_nama_mitra_wajib(): void
    {
        Livewire::test(CreateMitra::class)
            ->fillForm([
                'nama' => '',
                'kategori' => KategoriMitra::Mitra->value,
            ])
            ->call('create')
            ->assertHasFormErrors(['nama']);
    }

    public function test_admin_bisa_mengubah_mitra(): void
    {
        $mitra = Mitra::factory()->mitra()->create(['nama' => 'Nama Lama']);

        Livewire::test(EditMitra::class, ['record' => $mitra->getRouteKey()])
            ->fillForm(['nama' => 'Nama Baru'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('Nama Baru', $mitra->fresh()->nama);
    }

    public function test_admin_bisa_membuka_daftar_mitra(): void
    {
        Mitra::factory()->count(3)->create();

        Livewire::test(ListMitras::class)->assertSuccessful();
    }

    public function test_direktur_tidak_boleh_crud_mitra(): void
    {
        $direktur = Pengguna::factory()->direktur()->create();

        $this->actingAs($direktur);

        $this->assertFalse(MitraResource::canCreate());
        $this->assertFalse(MitraResource::canEdit(Mitra::factory()->create()));
        $this->assertFalse(MitraResource::canDelete(Mitra::factory()->create()));
    }
}
