<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\KategoriPengeluaran;
use App\Enums\Peran;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Uji model Eloquent: relasi, cast Enum, dan kolom turunan.
 *
 * Kolom turunan (totalPenerimaan, totalBiaya, labaRugi, piutang) dihitung
 * on-the-fly — lihat Schema.md §6.
 */
class ModelTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'nama' => 'Admin Uji',
            'email' => 'admin-uji@bks.test',
        ]);
    }

    // ---------------------------------------------------------
    // Cast Enum
    // ---------------------------------------------------------

    public function test_status_spk_di_cast_ke_enum(): void
    {
        $spk = Spk::factory()->berjalan()->create([
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->assertInstanceOf(StatusSpk::class, $spk->fresh()->status_spk);
        $this->assertSame(StatusSpk::Berjalan, $spk->fresh()->status_spk);
        $this->assertSame('Berjalan', $spk->fresh()->status_spk->label());
    }

    public function test_status_tagihan_di_cast_ke_enum(): void
    {
        $spk = Spk::factory()->create([
            'status_tagihan' => StatusTagihan::Dibayar,
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->assertSame(StatusTagihan::Dibayar, $spk->fresh()->status_tagihan);
        $this->assertFalse($spk->fresh()->status_tagihan->isPiutang());
    }

    public function test_kategori_uang_keluar_di_cast_ke_enum(): void
    {
        $keluar = UangKeluar::factory()->create([
            'kategori' => KategoriPengeluaran::Material,
        ]);

        $this->assertInstanceOf(KategoriPengeluaran::class, $keluar->fresh()->kategori);
        $this->assertSame('Material', $keluar->fresh()->kategori->label());
    }

    public function test_peran_di_cast_ke_enum(): void
    {
        $this->assertSame(Peran::Admin, $this->admin->fresh()->peran);
        $this->assertTrue($this->admin->isAdmin());
        $this->assertFalse($this->admin->isDirektur());
        $this->assertTrue($this->admin->bolehInput());
    }

    public function test_direktur_tidak_boleh_input(): void
    {
        $direktur = Pengguna::factory()->direktur()->create();

        $this->assertTrue($direktur->isDirektur());
        $this->assertFalse($direktur->bolehInput());
    }

    // ---------------------------------------------------------
    // Retensi — auto-hitung saat simpan
    // ---------------------------------------------------------

    public function test_retensi_dihitung_otomatis_saat_simpan(): void
    {
        $spk = Spk::factory()->subkon()->create([
            'nomor_spk' => 'SUBKON-UJI-001',
            'nilai_spk' => 100_000_000,
            'nama_pekerjaan' => 'Uji retensi',
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->assertEquals(5_000_000, (float) $spk->fresh()->nilai_retensi);
        $this->assertEquals(95_000_000, $spk->fresh()->nilaiBersih());
    }

    public function test_retensi_ikut_berubah_saat_nilai_spk_diubah(): void
    {
        $spk = Spk::factory()->subkon()->create([
            'nomor_spk' => 'SUBKON-UJI-002',
            'nilai_spk' => 100_000_000,
            'nama_pekerjaan' => 'Uji retensi berubah',
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->assertEquals(5_000_000, (float) $spk->fresh()->nilai_retensi);

        $spk->nilai_spk = 200_000_000;
        $spk->save();

        $this->assertEquals(10_000_000, (float) $spk->fresh()->nilai_retensi);
    }

    public function test_spk_tanpa_retensi_tidak_punya_nilai_retensi(): void
    {
        $spk = Spk::factory()->pln()->create([
            'persen_retensi' => null,
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->assertNull($spk->fresh()->nilai_retensi);
    }

    // ---------------------------------------------------------
    // Relasi
    // ---------------------------------------------------------

    public function test_spk_berelasi_ke_mitra_dan_pembuat(): void
    {
        $mitra = Mitra::factory()->pln()->create();
        $spk = Spk::factory()->create([
            'mitra_id' => $mitra->id,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->assertInstanceOf(Mitra::class, $spk->mitra);
        $this->assertSame($mitra->id, $spk->mitra->id);
        $this->assertInstanceOf(Pengguna::class, $spk->pembuat);
        $this->assertSame($this->admin->id, $spk->pembuat->id);
    }

    public function test_mitra_punya_banyak_spk(): void
    {
        $mitra = Mitra::factory()->create();

        Spk::factory()->count(3)->create([
            'mitra_id' => $mitra->id,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->assertCount(3, $mitra->spk);
    }

    public function test_uang_masuk_dan_keluar_berelasi_ke_spk(): void
    {
        $spk = Spk::factory()->create([
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        UangMasuk::factory()->count(2)->create([
            'spk_id' => $spk->id,
            'mitra_id' => null,
        ]);
        UangKeluar::factory()->count(3)->create(['spk_id' => $spk->id]);

        $this->assertCount(2, $spk->uangMasuk);
        $this->assertCount(3, $spk->uangKeluar);
    }

    // ---------------------------------------------------------
    // Kolom turunan
    // ---------------------------------------------------------

    public function test_perhitungan_laba_rugi_dan_piutang(): void
    {
        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'UJI-HITUNG-001',
            'nilai_spk' => 200_000_000,
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        UangMasuk::factory()->create(['spk_id' => $spk->id, 'jumlah' => 120_000_000, 'mitra_id' => null]);
        UangKeluar::factory()->create(['spk_id' => $spk->id, 'jumlah' => 40_000_000]);
        UangKeluar::factory()->create(['spk_id' => $spk->id, 'jumlah' => 25_000_000]);

        $this->assertEquals(120_000_000, $spk->totalPenerimaan());
        $this->assertEquals(65_000_000, $spk->totalBiaya());
        $this->assertEquals(55_000_000, $spk->labaRugi());
        $this->assertEquals(80_000_000, $spk->piutang());
    }

    // ---------------------------------------------------------
    // Uang masuk: sumber disimpulkan dari spk_id
    // ---------------------------------------------------------

    public function test_sumber_uang_masuk_disimpulkan_dari_spk_id(): void
    {
        $spk = Spk::factory()->create([
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $dariSpk = UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'mitra_id' => null,
        ]);
        $dariLuar = UangMasuk::factory()->create([
            'spk_id' => null,
            'nama_pekerjaan' => 'Penjualan sisa',
            'mitra_id' => null,
        ]);

        $this->assertTrue($dariSpk->isDariSpk());
        $this->assertSame('Dari SPK', $dariSpk->labelSumber());

        $this->assertFalse($dariLuar->isDariSpk());
        $this->assertSame('Luar SPK', $dariLuar->labelSumber());
    }

    public function test_scope_uang_masuk(): void
    {
        $spk = Spk::factory()->create([
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        UangMasuk::factory()->count(2)->create(['spk_id' => $spk->id, 'mitra_id' => null]);
        UangMasuk::factory()->create(['spk_id' => null, 'mitra_id' => null]);

        $this->assertSame(2, UangMasuk::dariSpk()->count());
        $this->assertSame(1, UangMasuk::dariLuarSpk()->count());
    }

    // ---------------------------------------------------------
    // Bukti JSON — jumlah file bebas
    // ---------------------------------------------------------

    public function test_bukti_menampung_jumlah_file_bebas(): void
    {
        $satu = UangMasuk::factory()->denganBukti(1)->create(['mitra_id' => null]);
        $tiga = UangMasuk::factory()->denganBukti(3)->create(['mitra_id' => null]);
        $lima = UangKeluar::factory()->denganBukti(5)->create();

        $this->assertSame(1, $satu->fresh()->jumlahFileBukti());
        $this->assertSame(3, $tiga->fresh()->jumlahFileBukti());
        $this->assertSame(5, $lima->fresh()->jumlahFileBukti());
    }

    public function test_bukti_null_artinya_belum_ada_file(): void
    {
        $tanpa = UangMasuk::factory()->create(['bukti' => null, 'mitra_id' => null]);

        $this->assertNull($tanpa->fresh()->bukti);
        $this->assertSame(0, $tanpa->fresh()->jumlahFileBukti());
    }

    // ---------------------------------------------------------
    // Soft delete
    // ---------------------------------------------------------

    public function test_spk_memakai_soft_delete(): void
    {
        $spk = Spk::factory()->create([
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $spk->delete();

        $this->assertSoftDeleted('spk', ['id' => $spk->id]);
        $this->assertSame(0, Spk::count());
        $this->assertSame(1, Spk::withTrashed()->count());
    }
}
