<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\Mitras\MitraResource;
use App\Filament\Resources\Spks\SpkResource;
use App\Filament\Resources\UangKeluars\UangKeluarResource;
use App\Filament\Resources\UangMasuks\UangMasukResource;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * PENCARIAN GLOBAL (topbar "Cari").
 *
 * ⚠️ MASALAH YANG DIPERBAIKI:
 * Topbar sudah menampilkan kotak "Cari", tetapi Resource hanya mengindeks
 * SATU kolom (judul). Akibatnya admin tidak bisa menemukan transaksi lewat
 * nominal, keterangan, atau nomor SPK — padahal itu cara kerja sehari-hari:
 * "cari yang nominalnya 5 juta", "cari keterangan 'sewa alat'".
 *
 * Aturan bisnis terkait (Rules §):
 *   - Pencarian global TIDAK boleh membocorkan data milik peran lain.
 *   - Tetap menghormati soft delete (baris terhapus tidak muncul).
 */
class PencarianGlobalTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-cari@bks.test',
        ]);

        $this->actingAs($this->admin);
    }

    // =========================================================
    // Atribut yang diindeks
    // =========================================================

    public function test_spk_bisa_dicari_lewat_nomor_nama_dan_lokasi(): void
    {
        $atribut = SpkResource::getGloballySearchableAttributes();

        $this->assertContains('nomor_spk', $atribut);
        $this->assertContains('nama_pekerjaan', $atribut);
        $this->assertContains('lokasi', $atribut);
    }

    public function test_uang_masuk_bisa_dicari_lewat_nomor_spk_dan_keterangan(): void
    {
        $atribut = UangMasukResource::getGloballySearchableAttributes();

        $this->assertContains('nomor_spk', $atribut);
        $this->assertContains('nama_pekerjaan', $atribut);
        $this->assertContains('keterangan', $atribut);
    }

    public function test_uang_keluar_bisa_dicari_lewat_penerima_dan_keterangan(): void
    {
        $atribut = UangKeluarResource::getGloballySearchableAttributes();

        $this->assertContains('penerima', $atribut);
        $this->assertContains('keterangan', $atribut);
    }

    public function test_mitra_bisa_dicari_lewat_nama(): void
    {
        $this->assertContains('nama', MitraResource::getGloballySearchableAttributes());
    }

    // =========================================================
    // Hasil pencarian nyata (bukan sekadar method ada)
    // =========================================================

    public function test_cari_spk_lewat_nomor_menghasilkan_hasil(): void
    {
        $spk = Spk::factory()->pln()->create(['nomor_spk' => 'CARI-UNIK-7788']);

        $hasil = SpkResource::getGlobalSearchResults('CARI-UNIK-7788');

        $this->assertTrue(
            $hasil->contains(fn ($r): bool => str_contains((string) $r->title, 'CARI-UNIK-7788')),
            'Pencarian global harus menemukan SPK lewat nomornya.',
        );
    }

    public function test_cari_uang_keluar_lewat_keterangan_menghasilkan_hasil(): void
    {
        UangKeluar::factory()->create(['keterangan' => 'SEWA-ALAT-BERAT-9911']);

        $hasil = UangKeluarResource::getGlobalSearchResults('SEWA-ALAT-BERAT-9911');

        $this->assertGreaterThan(0, $hasil->count(), 'Pencarian harus menemukan uang keluar lewat keterangan.');
    }

    public function test_cari_mitra_lewat_nama_menghasilkan_hasil(): void
    {
        Mitra::factory()->create(['nama' => 'PT-SINAR-MITRA-4455']);

        $hasil = MitraResource::getGlobalSearchResults('PT-SINAR-MITRA-4455');

        $this->assertGreaterThan(0, $hasil->count());
    }

    public function test_hasil_pencarian_membawa_detail_konteks(): void
    {
        $spk = Spk::factory()->pln()->create(['nomor_spk' => 'DETAIL-1000']);

        $hasil = SpkResource::getGlobalSearchResults('DETAIL-1000');
        $pertama = $hasil->first();

        $this->assertNotNull($pertama);
        $this->assertNotEmpty($pertama->details, 'Hasil pencarian harus menampilkan detail (mitra/nilai/status), bukan hanya judul.');
    }

    public function test_data_terhapus_tidak_muncul_di_pencarian(): void
    {
        $spk = Spk::factory()->pln()->create(['nomor_spk' => 'HAPUS-2000']);
        $spk->delete();

        $hasil = SpkResource::getGlobalSearchResults('HAPUS-2000');

        $this->assertCount(0, $hasil, 'SPK yang di-soft-delete tidak boleh muncul di pencarian global.');
    }

    public function test_uang_masuk_bisa_dicari_lewat_nomor_spk_terkait(): void
    {
        $spk = Spk::factory()->pln()->create(['nomor_spk' => 'TERKAIT-3000']);
        UangMasuk::factory()->create(['spk_id' => $spk->id, 'nomor_spk' => 'TERKAIT-3000']);

        $hasil = UangMasukResource::getGlobalSearchResults('TERKAIT-3000');

        $this->assertGreaterThan(0, $hasil->count());
    }
}
