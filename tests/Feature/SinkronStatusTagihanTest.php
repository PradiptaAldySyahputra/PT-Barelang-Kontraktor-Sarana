<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\StatusTagihan;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Uji SINKRONISASI STATUS TAGIHAN otomatis.
 *
 * ⚠️ KENAPA PENTING:
 * Sebelumnya `status_tagihan` diisi MANUAL. Risikonya: tertulis "Dibayar"
 * padahal uangnya belum masuk — laporan jadi bohong.
 *
 * Sekarang status disinkronkan dari pembayaran nyata lewat observer.
 */
class SinkronStatusTagihanTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-sinkron@bks.test',
        ]);
    }

    private function buatSpk(array $atribut = []): Spk
    {
        return Spk::factory()->pln()->create(array_merge([
            'nomor_spk' => 'SYNC-001',
            'nilai_spk' => 100_000_000,
            'status_tagihan' => StatusTagihan::BelumDitagihkan,
            'mitra_id' => Mitra::factory()->pln()->create(['nama' => 'PT PLN Batam'])->id,
            'dibuat_oleh' => $this->admin->id,
        ], $atribut));
    }

    public function test_pembayaran_sebagian_menjadikan_menunggu_pembayaran(): void
    {
        $spk = $this->buatSpk();

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 40_000_000,
            'mitra_id' => null,
        ]);

        $this->assertSame(
            StatusTagihan::MenungguPembayaran,
            $spk->fresh()->status_tagihan
        );
    }

    public function test_pembayaran_penuh_menjadikan_dibayar(): void
    {
        $spk = $this->buatSpk();

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 100_000_000,
            'mitra_id' => null,
        ]);

        $this->assertSame(StatusTagihan::Dibayar, $spk->fresh()->status_tagihan);
    }

    public function test_tanpa_pembayaran_status_tidak_ditimpa(): void
    {
        // Admin sudah menandai "Sudah Ditagihkan" — sistem TIDAK boleh menimpa
        // selama belum ada pembayaran.
        $spk = $this->buatSpk(['status_tagihan' => StatusTagihan::SudahDitagihkan]);

        $this->assertSame(StatusTagihan::SudahDitagihkan, $spk->fresh()->status_tagihan);
    }

    public function test_menghapus_pembayaran_mengembalikan_status(): void
    {
        $spk = $this->buatSpk();

        $masuk = UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 100_000_000,
            'mitra_id' => null,
        ]);

        $this->assertSame(StatusTagihan::Dibayar, $spk->fresh()->status_tagihan);

        // Hapus pembayaran -> tidak lagi lunas
        $masuk->delete();

        $this->assertNotSame(StatusTagihan::Dibayar, $spk->fresh()->status_tagihan);
    }

    public function test_uang_masuk_luar_spk_tidak_mengubah_status(): void
    {
        $spk = $this->buatSpk();

        // Uang masuk tanpa spk_id (penjualan sisa material)
        UangMasuk::factory()->create([
            'spk_id' => null,
            'jumlah' => 50_000_000,
            'mitra_id' => null,
        ]);

        $this->assertSame(
            StatusTagihan::BelumDitagihkan,
            $spk->fresh()->status_tagihan,
            'Uang masuk luar SPK tidak boleh mengubah status SPK'
        );
    }

    public function test_memindahkan_pembayaran_ke_spk_lain_menghitung_ulang_keduanya(): void
    {
        $spkA = $this->buatSpk(['nomor_spk' => 'SYNC-A']);
        $spkB = $this->buatSpk(['nomor_spk' => 'SYNC-B']);

        $masuk = UangMasuk::factory()->create([
            'spk_id' => $spkA->id,
            'jumlah' => 100_000_000,
            'mitra_id' => null,
        ]);

        $this->assertSame(StatusTagihan::Dibayar, $spkA->fresh()->status_tagihan);

        // Pindahkan pembayaran ke SPK B
        $masuk->update(['spk_id' => $spkB->id]);

        $this->assertSame(StatusTagihan::Dibayar, $spkB->fresh()->status_tagihan);
        $this->assertNotSame(
            StatusTagihan::Dibayar,
            $spkA->fresh()->status_tagihan,
            'SPK A harus dihitung ulang setelah pembayarannya dipindah'
        );
    }

    public function test_beberapa_pembayaran_dijumlahkan(): void
    {
        $spk = $this->buatSpk();

        UangMasuk::factory()->create(['spk_id' => $spk->id, 'jumlah' => 30_000_000, 'mitra_id' => null]);
        $this->assertSame(StatusTagihan::MenungguPembayaran, $spk->fresh()->status_tagihan);

        UangMasuk::factory()->create(['spk_id' => $spk->id, 'jumlah' => 70_000_000, 'mitra_id' => null]);
        $this->assertSame(StatusTagihan::Dibayar, $spk->fresh()->status_tagihan);
    }

    // =========================================================
    // BUG: SPK NILAI 0 TIDAK BOLEH OTOMATIS "DIBAYAR"
    // =========================================================

    /**
     * ⚠️ BUG YANG PERNAH TERJADI:
     * SPK dengan nilai_spk = 0 punya piutang 0 − 0 = 0, sehingga dianggap
     * LUNAS dan langsung berstatus "Dibayar" begitu ada transaksi apa pun.
     * Itu salah — nilai 0 berarti data belum diisi, bukan sudah dibayar.
     */
    public function test_spk_nilai_nol_tidak_otomatis_dibayar(): void
    {
        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'NOL-001',
            'nilai_spk' => 0,
            'status_tagihan' => StatusTagihan::BelumDitagihkan,
            'dibuat_oleh' => $this->admin->id,
        ]);

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'tanggal' => now(),
            'jumlah' => 0.01,
        ]);

        $this->assertNotSame(
            StatusTagihan::Dibayar,
            $spk->fresh()->status_tagihan,
            'SPK nilai 0 tidak boleh dianggap lunas'
        );
    }

    public function test_spk_nilai_nol_status_tagihan_tidak_disentuh(): void
    {
        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'NOL-002',
            'nilai_spk' => 0,
            'status_tagihan' => StatusTagihan::RevisiDokumen,
            'dibuat_oleh' => $this->admin->id,
        ]);

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'tanggal' => now(),
            'jumlah' => 1_000_000,
        ]);

        // Status manual Admin tidak boleh ditimpa sistem untuk SPK nilai 0.
        $this->assertSame(StatusTagihan::RevisiDokumen, $spk->fresh()->status_tagihan);
    }
}
