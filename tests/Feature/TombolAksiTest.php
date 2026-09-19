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
 * Uji REGRESI: tombol aksi harus HILANG untuk Direktur.
 *
 * ⚠️ BUG YANG DICEGAH:
 * Filament HANYA memakai Resource::canCreate()/canEdit()/canDelete() untuk
 * menolak akses halaman (abort 403). Filament TIDAK otomatis menyembunyikan
 * tombolnya. Jadi tanpa `->visible()`, Direktur tetap melihat tombol
 * "Tambah / Edit / Hapus" — aman dari kebocoran data, tapi menyesatkan.
 *
 * Test ini memastikan DUA LAPIS bekerja:
 *   1. Tombol TIDAK tampil di HTML (UI)
 *   2. Akses halaman create tetap DITOLAK 403 (otorisasi)
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
     * @return array<string, array{string}>
     */
    public static function halamanDaftarProvider(): array
    {
        return [
            'spk' => ['/admin/spks'],
            'mitra' => ['/admin/mitras'],
            'uang masuk' => ['/admin/uang-masuks'],
            'uang keluar' => ['/admin/uang-keluars'],
            'pengguna' => ['/admin/penggunas'],
        ];
    }

    // =========================================================
    // Tombol TIDAK tampil untuk Direktur
    // =========================================================

    #[DataProvider('halamanDaftarProvider')]
    public function test_tombol_tambah_tidak_tampil_untuk_direktur(string $url): void
    {
        $html = $this->actingAs($this->direktur)->get($url)->assertOk()->getContent();

        $this->assertDoesNotMatchRegularExpression(
            '/href="[^"]*\/create"/',
            $html,
            "Tombol/link create seharusnya TIDAK ada di $url untuk Direktur"
        );
    }

    #[DataProvider('halamanDaftarProvider')]
    public function test_tombol_edit_tidak_tampil_untuk_direktur(string $url): void
    {
        $html = $this->actingAs($this->direktur)->get($url)->assertOk()->getContent();

        $this->assertDoesNotMatchRegularExpression(
            '/href="[^"]*\/edit"/',
            $html,
            "Tombol/link edit seharusnya TIDAK ada di $url untuk Direktur"
        );
    }

    // =========================================================
    // Tombol TETAP tampil untuk Admin
    // =========================================================

    #[DataProvider('halamanDaftarProvider')]
    public function test_tombol_tambah_tetap_tampil_untuk_admin(string $url): void
    {
        $html = $this->actingAs($this->admin)->get($url)->assertOk()->getContent();

        $this->assertMatchesRegularExpression(
            '/href="[^"]*\/create"/',
            $html,
            "Tombol create seharusnya ADA di $url untuk Admin"
        );
    }

    // =========================================================
    // Lapis kedua: akses halaman create tetap DITOLAK
    // =========================================================

    #[DataProvider('halamanDaftarProvider')]
    public function test_direktur_tetap_ditolak_403_saat_paksa_buka_form_create(string $url): void
    {
        $this->actingAs($this->direktur)
            ->get($url.'/create')
            ->assertForbidden();
    }

    // =========================================================
    // Helper bolehUbahData()
    // =========================================================

    public function test_helper_boleh_ubah_data_benar(): void
    {
        $this->actingAs($this->admin);
        $this->assertTrue(SpkResource::bolehUbahData());
        $this->assertTrue(MitraResource::bolehUbahData());
        $this->assertTrue(UangMasukResource::bolehUbahData());
        $this->assertTrue(UangKeluarResource::bolehUbahData());
        $this->assertTrue(PenggunaResource::bolehUbahData());

        $this->actingAs($this->direktur);
        $this->assertFalse(SpkResource::bolehUbahData());
        $this->assertFalse(MitraResource::bolehUbahData());
        $this->assertFalse(UangMasukResource::bolehUbahData());
        $this->assertFalse(UangKeluarResource::bolehUbahData());
        $this->assertFalse(PenggunaResource::bolehUbahData());
    }

    public function test_tanpa_login_boleh_ubah_data_false(): void
    {
        $this->assertFalse(SpkResource::bolehUbahData());
    }

    // =========================================================
    // Direktur tetap bisa MELIHAT data
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
