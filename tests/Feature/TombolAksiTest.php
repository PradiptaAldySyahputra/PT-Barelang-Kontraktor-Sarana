<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\Mitras\MitraResource;
use App\Filament\Resources\Penggunas\PenggunaResource;
use App\Filament\Resources\Spks\SpkResource;
use App\Filament\Resources\UangKeluars\UangKeluarResource;
use App\Filament\Resources\UangMasuks\UangMasukResource;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Uji REGRESI: tombol aksi harus HILANG untuk yang tidak berhak.
 *
 * ⚠️ BUG YANG DICEGAH:
 * Filament HANYA memakai Resource::canCreate()/canEdit()/canDelete() untuk
 * menolak akses halaman (abort 403). Filament TIDAK otomatis menyembunyikan
 * tombolnya. Jadi tanpa `->visible()`, pengguna tetap melihat tombol
 * "Tambah / Edit / Hapus" — aman dari kebocoran data, tapi menyesatkan.
 *
 * ⚠️ REVISI USER (19 Sep 2026):
 * Menu **Pengguna** sekarang HANYA untuk **Direktur** — kebalikan dari
 * resource lain. Jadi ada DUA kelompok hak akses:
 *
 *   A. Data operasional (SPK, Mitra, Uang Masuk/Keluar):
 *      Admin boleh ubah · Direktur hanya lihat
 *   B. Akun Pengguna:
 *      Direktur boleh ubah · Admin tidak melihat menu sama sekali
 */
class TombolAksiTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    private Pengguna $direktur;

    private Spk $spk;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-tombol@bks.test',
        ]);
        $this->direktur = Pengguna::factory()->direktur()->create([
            'email' => 'dir-tombol@bks.test',
        ]);

        $mitra = Mitra::factory()->create(['nama' => 'Mitra Tombol']);
        $this->spk = Spk::factory()->create([
            'nomor_spk' => 'TOMBOL-001',
            'mitra_id' => $mitra->id,
            'dibuat_oleh' => $this->admin->id,
        ]);
        UangMasuk::factory()->create(['spk_id' => $this->spk->id, 'mitra_id' => null]);
        UangKeluar::factory()->create(['spk_id' => $this->spk->id]);
    }

    /**
     * Data operasional — Admin boleh, Direktur hanya lihat.
     *
     * @return array<string, array{string}>
     */
    public static function halamanOperasionalProvider(): array
    {
        return [
            'spk' => ['/admin/spks'],
            'mitra' => ['/admin/mitras'],
            'uang masuk' => ['/admin/uang-masuks'],
            'uang keluar' => ['/admin/uang-keluars'],
        ];
    }

    // =========================================================
    // A. DATA OPERASIONAL — Direktur TIDAK boleh ubah
    // =========================================================

    #[DataProvider('halamanOperasionalProvider')]
    public function test_tombol_tambah_tidak_tampil_untuk_direktur(string $url): void
    {
        $html = $this->actingAs($this->direktur)->get($url)->assertOk()->getContent();

        $this->assertDoesNotMatchRegularExpression(
            '/href="[^"]*\/create"/',
            $html,
            "Tombol/link create seharusnya TIDAK ada di $url untuk Direktur"
        );
    }

    #[DataProvider('halamanOperasionalProvider')]
    public function test_tombol_edit_tidak_tampil_untuk_direktur(string $url): void
    {
        $html = $this->actingAs($this->direktur)->get($url)->assertOk()->getContent();

        $this->assertDoesNotMatchRegularExpression(
            '/href="[^"]*\/edit"/',
            $html,
            "Tombol/link edit seharusnya TIDAK ada di $url untuk Direktur"
        );
    }

    #[DataProvider('halamanOperasionalProvider')]
    public function test_tombol_tambah_tetap_tampil_untuk_admin(string $url): void
    {
        $html = $this->actingAs($this->admin)->get($url)->assertOk()->getContent();

        $this->assertMatchesRegularExpression(
            '/href="[^"]*\/create"/',
            $html,
            "Tombol create seharusnya ADA di $url untuk Admin"
        );
    }

    #[DataProvider('halamanOperasionalProvider')]
    public function test_direktur_tetap_ditolak_403_saat_paksa_buka_form_create(string $url): void
    {
        $this->actingAs($this->direktur)
            ->get($url.'/create')
            ->assertForbidden();
    }

    // =========================================================
    // B. MENU PENGGUNA — hanya Direktur
    // =========================================================

    public function test_admin_tidak_melihat_menu_pengguna(): void
    {
        $this->actingAs($this->admin);

        $this->assertFalse(PenggunaResource::canViewAny());
        $this->assertFalse(PenggunaResource::shouldRegisterNavigation());
        $this->get('/admin/penggunas')->assertForbidden();
        $this->get('/admin/penggunas/create')->assertForbidden();
    }

    public function test_direktur_bisa_buka_menu_pengguna(): void
    {
        $this->actingAs($this->direktur);

        $this->assertTrue(PenggunaResource::canViewAny());
        $this->assertTrue(PenggunaResource::shouldRegisterNavigation());
        $this->get('/admin/penggunas')->assertOk();
        $this->get('/admin/penggunas/create')->assertOk();
    }

    public function test_direktur_tidak_bisa_hapus_akun_sendiri(): void
    {
        $this->actingAs($this->direktur);

        $this->assertFalse(
            PenggunaResource::canDelete($this->direktur),
            'CELAH: Direktur bisa menghapus akunnya sendiri'
        );
        $this->assertFalse(PenggunaResource::canEdit($this->direktur));
    }

    // =========================================================
    // Helper bolehUbahData() — untuk resource operasional
    // =========================================================

    public function test_helper_boleh_ubah_data_benar(): void
    {
        $this->actingAs($this->admin);
        $this->assertTrue(SpkResource::bolehUbahData());
        $this->assertTrue(MitraResource::bolehUbahData());
        $this->assertTrue(UangMasukResource::bolehUbahData());
        $this->assertTrue(UangKeluarResource::bolehUbahData());

        $this->actingAs($this->direktur);
        $this->assertFalse(SpkResource::bolehUbahData());
        $this->assertFalse(MitraResource::bolehUbahData());
        $this->assertFalse(UangMasukResource::bolehUbahData());
        $this->assertFalse(UangKeluarResource::bolehUbahData());
    }

    public function test_tanpa_login_boleh_ubah_data_false(): void
    {
        $this->assertFalse(SpkResource::bolehUbahData());
    }

    // =========================================================
    // Direktur tetap bisa MELIHAT data operasional
    // =========================================================

    public function test_direktur_tetap_bisa_melihat_data_spk(): void
    {
        $html = $this->actingAs($this->direktur)
            ->get('/admin/spks')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('TOMBOL-001', $html, 'Direktur harus tetap bisa melihat data SPK');
    }
}
