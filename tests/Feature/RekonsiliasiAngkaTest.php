<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Pages\Laporan;
use App\Filament\Widgets\RingkasanKeuangan;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * REKONSILIASI ANGKA — dashboard & laporan HARUS sama dengan database.
 *
 * ⚠️ KENAPA PENTING:
 * Laporan keuangan yang salah lebih berbahaya daripada tidak ada laporan.
 * Tes ini membandingkan angka yang DITAMPILKAN dengan hasil hitung langsung
 * dari tabel — bukan sekadar "widget tampil".
 *
 * ⚠️ FOKUS TAMBAHAN: transaksi yang sudah di-soft-delete TIDAK boleh ikut
 * terjumlah. Kalau ikut, total di layar lebih besar dari kenyataan.
 */
class RekonsiliasiAngkaTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create(['email' => 'admin-rekon@bks.test']);
        $this->actingAs($this->admin);
    }

    public function test_kartu_dashboard_sama_dengan_hitung_database(): void
    {
        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'REKON-001',
            'nilai_spk' => 500_000_000,
            'dibuat_oleh' => $this->admin->id,
        ]);

        UangMasuk::factory()->create(['spk_id' => $spk->id, 'jumlah' => 150_000_000, 'tanggal' => now()]);
        UangMasuk::factory()->create(['spk_id' => null, 'jumlah' => 10_000_000, 'tanggal' => now()]);
        UangKeluar::factory()->create(['spk_id' => $spk->id, 'jumlah' => 75_000_000, 'tanggal' => now()]);

        $masukDb = (float) UangMasuk::sum('jumlah');
        $keluarDb = (float) UangKeluar::sum('jumlah');

        $html = Livewire::test(RingkasanKeuangan::class)->html();

        // Bandingkan dengan format tampilan (tanpa desimal, pemisah titik).
        $this->assertStringContainsString(number_format($masukDb, 0, ',', '.'), $html, 'Sudah Diterima ≠ DB');
        $this->assertStringContainsString(number_format($keluarDb, 0, ',', '.'), $html, 'Uang Keluar ≠ DB');
    }

    public function test_transaksi_terhapus_tidak_ikut_terhitung_di_dashboard(): void
    {
        $aktif = UangMasuk::factory()->create(['spk_id' => null, 'jumlah' => 10_000_000, 'tanggal' => now()]);
        $terhapus = UangMasuk::factory()->create(['spk_id' => null, 'jumlah' => 90_000_000, 'tanggal' => now()]);

        $terhapus->delete(); // soft delete

        // DB (dengan scope default) hanya menghitung yang aktif.
        $this->assertSame(10_000_000.0, (float) UangMasuk::sum('jumlah'));

        $html = Livewire::test(RingkasanKeuangan::class)->html();

        $this->assertStringContainsString('10.000.000', $html, 'Penerimaan aktif harus tampil');
        $this->assertStringNotContainsString('90.000.000', $html, 'Transaksi terhapus TIDAK boleh terhitung');
    }

    public function test_laporan_selisih_sama_dengan_masuk_dikurangi_keluar(): void
    {
        UangMasuk::factory()->create(['spk_id' => null, 'jumlah' => 40_000_000, 'tanggal' => now()]);
        UangKeluar::factory()->create(['spk_id' => null, 'jumlah' => 25_000_000, 'tanggal' => now()]);

        $masuk = (float) UangMasuk::sum('jumlah');
        $keluar = (float) UangKeluar::sum('jumlah');
        $selisih = $masuk - $keluar; // 15.000.000

        $komponen = Livewire::test(Laporan::class)->instance();

        // `getViewData()` bersifat protected → panggil lewat refleksi (tanpa
        // mengubah kode produksi hanya demi tes).
        $metode = new \ReflectionMethod($komponen, 'getViewData');
        $metode->setAccessible(true);
        $data = $metode->invoke($komponen);

        $this->assertSame($masuk, $data['totalMasuk'], 'Total masuk laporan ≠ DB');
        $this->assertSame($keluar, $data['totalKeluar'], 'Total keluar laporan ≠ DB');
        $this->assertSame($selisih, $data['selisih'], 'Selisih laporan ≠ masuk − keluar');
    }

    public function test_laporan_piutang_sama_dengan_rumus(): void
    {
        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'REKON-PIUTANG-001',
            'nilai_spk' => 100_000_000,
            'dibuat_oleh' => $this->admin->id,
        ]);

        UangMasuk::factory()->create(['spk_id' => $spk->id, 'jumlah' => 30_000_000, 'tanggal' => now()]);

        $spk->refresh();

        // piutang = nilai_spk − sudah_diterima
        $this->assertSame(70_000_000.0, $spk->piutang());
        $this->assertSame(70_000_000.0, $spk->sisaTagih());
    }
}
