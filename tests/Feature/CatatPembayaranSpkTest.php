<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\StatusTagihan;
use App\Filament\Resources\MonitoringSpk\Pages\ListTagihanSpk;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * CATAT PEMBAYARAN SPK — termasuk pembayaran SEBAGIAN (50%, 95%, dst).
 *
 * ⚠️ PERMINTAAN PENGGUNA (26 Sep 2026):
 * "dibagian spk juga belum anda update bagian tagihan atau bagian spk kalau
 *  sudah bayar setengah atau berapa persen untuk update nilai atau uangnya
 *  tidak ada jadi dari hasil yang belum diterima bagaimana kalau sudah ada
 *  yang bayar setengah, dari mana hasil potongan uang terima kalau tidak ada
 *  uang dibayar"
 *
 * Masalah nyata: "Sudah Diterima" dihitung dari Uang Masuk, TAPI tidak ada
 * jalan mencatat pembayaran dari halaman SPK. Admin harus mencari menu
 * Uang Masuk secara manual dan mengisi `spk_id` sendiri — merepotkan dan
 * mudah salah.
 *
 * Solusi: aksi "Catat Pembayaran" di menu Tagihan SPK. Admin cukup memasukkan
 * jumlah (atau memilih persen 50%/95%), dan SISTEM membuat Uang Masuk yang
 * benar + status tagihan ikut tersinkron otomatis.
 */
class CatatPembayaranSpkTest extends TestCase
{
    use RefreshDatabase;

    private function spk(float $nilai = 10_000_000): Spk
    {
        return Spk::factory()->pln()->create([
            'nilai_spk' => $nilai,
            'status_tagihan' => StatusTagihan::MenungguPembayaran,
        ]);
    }

    public function test_pembayaran_sebagian_50_persen_membuat_uang_masuk(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $spk = $this->spk(10_000_000);

        $this->actingAs($admin);

        // Catat pembayaran 50% = 5.000.000
        UangMasuk::create([
            'spk_id' => $spk->id,
            'tanggal' => '2026-09-26',
            'jumlah' => 5_000_000,
            'mitra_id' => $spk->mitra_id,
            'keterangan' => 'Pembayaran sebagian 50%',
        ]);

        $spk->refresh();

        // Uang masuk tercatat
        $this->assertSame(1, $spk->uangMasuk()->count());
        $this->assertSame(5_000_000.0, $spk->totalPenerimaan());

        // Sisa masih ada
        $this->assertSame(5_000_000.0, $spk->sisaTagih());

        // Status: ada bayaran tapi belum lunas → Menunggu Pembayaran
        $this->assertSame(StatusTagihan::MenungguPembayaran, $spk->status_tagihan);
    }

    public function test_pelunasan_mengubah_status_menjadi_dibayar(): void
    {
        $spk = $this->spk(10_000_000);

        UangMasuk::create([
            'spk_id' => $spk->id, 'tanggal' => '2026-09-26',
            'jumlah' => 5_000_000, 'keterangan' => 'Termin 1',
        ]);

        UangMasuk::create([
            'spk_id' => $spk->id, 'tanggal' => '2026-10-26',
            'jumlah' => 5_000_000, 'keterangan' => 'Termin 2 (pelunasan)',
        ]);

        $spk->refresh();

        $this->assertSame(10_000_000.0, $spk->totalPenerimaan());
        $this->assertSame(0.0, $spk->sisaTagih());
        $this->assertSame(StatusTagihan::Dibayar, $spk->status_tagihan);
        $this->assertTrue($spk->sudahLunas());
    }

    public function test_persen_pembayaran_dihitung_dari_nilai_spk(): void
    {
        $spk = $this->spk(8_000_000);

        // 95% dari 8.000.000 = 7.600.000
        UangMasuk::create([
            'spk_id' => $spk->id, 'tanggal' => '2026-09-26',
            'jumlah' => 7_600_000, 'keterangan' => 'Pembayaran 95%',
        ]);

        $spk->refresh();

        $this->assertSame(7_600_000.0, $spk->totalPenerimaan());
        $this->assertSame(400_000.0, $spk->sisaTagih());
        $this->assertSame(StatusTagihan::MenungguPembayaran, $spk->status_tagihan);
    }

    public function test_aksi_catat_pembayaran_tersedia_di_tagihan_spk(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $spk = $this->spk(10_000_000);

        $this->actingAs($admin);

        /*
         * ⚠️ PERUBAHAN (2 Okt 2026): "Catat Pembayaran" tidak lagi jadi tombol
         * langsung di baris tabel. Sesuai permintaan pengguna, aksi (termasuk
         * kelola) dipindah KE DALAM preview SPK. Jadi diperiksa di dalam
         * preview — bukan sebagai aksi tabel.
         */
        Livewire::test(ListTagihanSpk::class)
            ->mountAction(TestAction::make('view')->table($spk))
            ->assertActionVisible('catatPembayaran');
    }

    public function test_hapus_pembayaran_mengembalikan_status(): void
    {
        $spk = $this->spk(10_000_000);

        $masuk = UangMasuk::create([
            'spk_id' => $spk->id, 'tanggal' => '2026-09-26',
            'jumlah' => 10_000_000, 'keterangan' => 'Lunas',
        ]);

        $this->assertSame(StatusTagihan::Dibayar, $spk->fresh()->status_tagihan);

        $masuk->delete();

        // Pembayaran dihapus → status kembali (bukan Dibayar lagi).
        $this->assertNotSame(StatusTagihan::Dibayar, $spk->fresh()->status_tagihan);
        $this->assertSame(0.0, $spk->fresh()->totalPenerimaan());
    }
}
