<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Enums\StatusSpk;
use App\Filament\Resources\Spks\Pages\CreateSpk;
use App\Filament\Resources\Spks\Pages\ListSpks;
use App\Filament\Resources\Spks\SpkResource;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use Filament\Auth\Pages\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Uji panel Filament: akses panel, login, CRUD SPK, dan hak akses peran.
 *
 * Filament memakai Livewire, jadi pengujian dilakukan lewat Livewire::test()
 * — bukan HTTP POST biasa.
 */
class FilamentTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    private Pengguna $direktur;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'nama' => 'Admin Uji',
            'email' => 'admin-fil@bks.test',
            'password' => 'rahasia123',
        ]);

        $this->direktur = Pengguna::factory()->direktur()->create([
            'nama' => 'Direktur Uji',
            'email' => 'dir-fil@bks.test',
            'password' => 'rahasia123',
        ]);
    }

    // ---------------------------------------------------------
    // Akses panel
    // ---------------------------------------------------------

    public function test_admin_boleh_masuk_panel(): void
    {
        $this->assertTrue($this->admin->canAccessPanel(filament()->getPanel('admin')));
    }

    public function test_direktur_boleh_masuk_panel(): void
    {
        $this->assertTrue($this->direktur->canAccessPanel(filament()->getPanel('admin')));
    }

    public function test_akun_nonaktif_tidak_boleh_masuk_panel(): void
    {
        $nonaktif = Pengguna::factory()->admin()->nonaktif()->create();

        $this->assertFalse($nonaktif->canAccessPanel(filament()->getPanel('admin')));
    }

    public function test_tamu_diarahkan_ke_login_filament(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    // ---------------------------------------------------------
    // Login lewat Filament (Livewire)
    // ---------------------------------------------------------

    public function test_login_filament_berhasil_dengan_kredensial_benar(): void
    {
        Livewire::test(Login::class)
            ->fillForm([
                'email' => 'admin-fil@bks.test',
                'password' => 'rahasia123',
            ])
            ->call('authenticate')
            ->assertHasNoFormErrors();

        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_login_filament_gagal_dengan_password_salah(): void
    {
        Livewire::test(Login::class)
            ->fillForm([
                'email' => 'admin-fil@bks.test',
                'password' => 'ngawur',
            ])
            ->call('authenticate')
            ->assertHasFormErrors();

        $this->assertGuest();
    }

    // ---------------------------------------------------------
    // Hak akses resource (Rules.md §4)
    // ---------------------------------------------------------

    public function test_admin_boleh_tambah_ubah_hapus_spk(): void
    {
        $this->actingAs($this->admin);

        $this->assertTrue(SpkResource::canCreate());
        $this->assertTrue(SpkResource::canEdit(new Spk));
        $this->assertTrue(SpkResource::canDelete(new Spk));
    }

    public function test_direktur_tidak_boleh_tambah_ubah_hapus_spk(): void
    {
        $this->actingAs($this->direktur);

        $this->assertFalse(SpkResource::canCreate(), 'Direktur TIDAK boleh menambah SPK');
        $this->assertFalse(SpkResource::canEdit(new Spk), 'Direktur TIDAK boleh mengubah SPK');
        $this->assertFalse(SpkResource::canDelete(new Spk), 'Direktur TIDAK boleh menghapus SPK');
    }

    public function test_direktur_tetap_boleh_melihat_daftar_spk(): void
    {
        $this->actingAs($this->direktur);

        $this->assertTrue(SpkResource::canViewAny());
    }

    // ---------------------------------------------------------
    // Halaman daftar SPK
    // ---------------------------------------------------------

    public function test_admin_bisa_buka_daftar_spk(): void
    {
        $spk = Spk::factory()->create([
            'nomor_spk' => 'UJI-LIST-001',
            'nama_pekerjaan' => 'Pekerjaan Uji',
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(ListSpks::class)
            ->assertOk()
            ->assertCanSeeTableRecords([$spk]);
    }

    public function test_direktur_bisa_buka_daftar_spk(): void
    {
        $spk = Spk::factory()->create([
            'nomor_spk' => 'UJI-LIST-002',
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->direktur);

        Livewire::test(ListSpks::class)
            ->assertOk()
            ->assertCanSeeTableRecords([$spk]);
    }

    // ---------------------------------------------------------
    // Buat SPK lewat form Filament
    // ---------------------------------------------------------

    public function test_admin_bisa_membuat_spk_lewat_form(): void
    {
        $mitra = Mitra::factory()->pln()->create(['nama' => 'PT PLN Batam']);
        $this->actingAs($this->admin);

        Livewire::test(CreateSpk::class)
            ->fillForm([
                'nomor_spk' => 'FORM-UJI-001',
                'tanggal_spk' => '2026-08-01',
                'tanggal_akhir' => '2026-12-31',
                'nama_pekerjaan' => 'Pekerjaan dari form',
                'lokasi' => 'Batam',
                'nilai_spk' => 150000000,
                'status_spk' => StatusSpk::Terbit->value,
                'mitra_id' => $mitra->id,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('spk', [
            'nomor_spk' => 'FORM-UJI-001',
            'nama_pekerjaan' => 'Pekerjaan dari form',
            'status_spk' => StatusSpk::Terbit->value,
            'dibuat_oleh' => $this->admin->id,
        ]);
    }

    public function test_form_spk_menolak_nomor_duplikat(): void
    {
        Spk::factory()->create([
            'nomor_spk' => 'DUPLIKAT-001',
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(CreateSpk::class)
            ->fillForm([
                'nomor_spk' => 'DUPLIKAT-001',
                'nama_pekerjaan' => 'Duplikat',
                'nilai_spk' => 1000000,
                'status_spk' => StatusSpk::Draft->value,
            ])
            ->call('create')
            ->assertHasFormErrors(['nomor_spk']);
    }

    public function test_form_spk_menolak_status_ngawur(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateSpk::class)
            ->fillForm([
                'nomor_spk' => 'STATUS-NGAWUR-001',
                'nama_pekerjaan' => 'Uji status',
                'nilai_spk' => 1000000,
                'status_spk' => 'status_ngawur',
            ])
            ->call('create')
            ->assertHasFormErrors(['status_spk']);
    }

    // ---------------------------------------------------------
    // Retensi otomatis lewat form
    // ---------------------------------------------------------

    public function test_retensi_dihitung_otomatis_dari_form(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateSpk::class)
            ->fillForm([
                'nomor_spk' => 'RETENSI-FORM-001',
                'nama_pekerjaan' => 'SPK subkon',
                'nilai_spk' => 100000000,
                'persen_retensi' => 5,
                'status_spk' => StatusSpk::Berjalan->value,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $spk = Spk::where('nomor_spk', 'RETENSI-FORM-001')->first();

        $this->assertNotNull($spk, 'SPK gagal dibuat');
        $this->assertEquals(5_000_000, (float) $spk->nilai_retensi);
    }

    // ---------------------------------------------------------
    // Filter & tab
    // ---------------------------------------------------------

    public function test_filter_status_spk_bekerja(): void
    {
        $berjalan = Spk::factory()->berjalan()->create([
            'nomor_spk' => 'FILTER-BERJALAN',
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);
        $lunas = Spk::factory()->lunas()->create([
            'nomor_spk' => 'FILTER-LUNAS',
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(ListSpks::class)
            ->filterTable('status_spk', StatusSpk::Berjalan->value)
            ->assertCanSeeTableRecords([$berjalan])
            ->assertCanNotSeeTableRecords([$lunas]);
    }

    public function test_pencarian_nomor_spk_bekerja(): void
    {
        $dicari = Spk::factory()->create([
            'nomor_spk' => 'CARI-SAYA-999',
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);
        $lain = Spk::factory()->create([
            'nomor_spk' => 'BUKAN-INI-111',
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(ListSpks::class)
            ->searchTable('CARI-SAYA')
            ->assertCanSeeTableRecords([$dicari])
            ->assertCanNotSeeTableRecords([$lain]);
    }

    // ---------------------------------------------------------
    // Semua resource bisa dibuka
    // ---------------------------------------------------------

    /**
     * Semua halaman resource bisa dibuka Admin.
     *
     * (PHPUnit 12 memakai atribut, bukan anotasi @dataProvider.)
     */
    #[DataProvider('halamanResourceProvider')]
    public function test_semua_halaman_resource_bisa_dibuka_admin(string $url): void
    {
        $this->actingAs($this->admin)
            ->get($url)
            ->assertSuccessful();
    }

    public static function halamanResourceProvider(): array
    {
        return [
            'spk' => ['/admin/spks'],
            'mitra' => ['/admin/mitras'],
            'uang masuk' => ['/admin/uang-masuks'],
            'uang keluar' => ['/admin/uang-keluars'],
            'pengguna' => ['/admin/penggunas'],
        ];
    }

    public function test_dashboard_filament_bisa_dibuka_admin(): void
    {
        $this->actingAs($this->admin)->get('/admin')->assertSuccessful();
    }

    public function test_dashboard_filament_bisa_dibuka_direktur(): void
    {
        $this->actingAs($this->direktur)->get('/admin')->assertSuccessful();
    }

    public function test_peran_enum_dipakai_di_panel(): void
    {
        $this->assertSame(Peran::Admin, $this->admin->peran);
        $this->assertTrue($this->admin->bolehInput());
        $this->assertFalse($this->direktur->bolehInput());
    }
}
