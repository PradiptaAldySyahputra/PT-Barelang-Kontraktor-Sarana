<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\UangKeluar;
use App\Models\UangMasuk;
use App\Support\SaldoKas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * SALDO BERJALAN KAS/BANK - fitur T2 (permintaan user 10 Okt 2026).
 *
 * ⚠️ KENAPA PERLU:
 * Sistem sudah bisa memisahkan transaksi per akun (kas | bank), tetapi belum
 * pernah menunjukkan SALDO - berapa uang yang sebenarnya ada di kas & di bank.
 * Tanpa saldo, admin tidak tahu posisi uang berjalan; laporan hanya menampilkan
 * total masuk/keluar tanpa memperhitungkan AKUN.
 *
 * Saldo = total uang MASUK − total uang KELUAR untuk akun tersebut.
 *
 * ⚠️ UANG BUKAN ENTITAS BARU: saldo dihitung on-the-fly dari transaksi yang
 * sudah ada (tidak menambah tabel - aturan skema Rules.md §1).
 */
class SaldoKasTest extends TestCase
{
    use RefreshDatabase;

    public function test_saldo_kas_adalah_masuk_dikurangi_keluar(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 10_000_000]);
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 5_000_000]);
        UangKeluar::factory()->create(['akun' => 'kas', 'jumlah' => 3_000_000]);

        $this->assertSame(12_000_000.0, SaldoKas::saldo('kas'));
    }

    public function test_saldo_bank_terpisah_dari_kas(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 1_000_000]);
        UangMasuk::factory()->create(['akun' => 'bank', 'jumlah' => 50_000_000]);
        UangKeluar::factory()->create(['akun' => 'bank', 'jumlah' => 20_000_000]);

        $this->assertSame(1_000_000.0, SaldoKas::saldo('kas'));
        $this->assertSame(30_000_000.0, SaldoKas::saldo('bank'));
    }

    public function test_saldo_bisa_negatif_bila_keluar_melebihi_masuk(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 1_000_000]);
        UangKeluar::factory()->create(['akun' => 'kas', 'jumlah' => 4_000_000]);

        $this->assertSame(-3_000_000.0, SaldoKas::saldo('kas'));
    }

    public function test_ringkasan_menjumlahkan_kas_dan_bank(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 2_000_000]);
        UangMasuk::factory()->create(['akun' => 'bank', 'jumlah' => 8_000_000]);
        UangKeluar::factory()->create(['akun' => 'kas', 'jumlah' => 500_000]);

        $r = SaldoKas::ringkasan();

        $this->assertSame(1_500_000.0, $r['kas']);
        $this->assertSame(8_000_000.0, $r['bank']);
        $this->assertSame(9_500_000.0, $r['total']);
    }

    public function test_saldo_sampai_tanggal_tertentu_mengabaikan_transaksi_setelahnya(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 5_000_000, 'tanggal' => '2026-01-10']);
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 9_000_000, 'tanggal' => '2026-03-10']);

        $this->assertSame(5_000_000.0, SaldoKas::saldo('kas', Carbon::parse('2026-01-31')));
        $this->assertSame(14_000_000.0, SaldoKas::saldo('kas', Carbon::parse('2026-03-31')));
    }

    public function test_saldo_tidak_menghitung_data_terhapus(): void
    {
        $masuk = UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 7_000_000]);
        $masuk->delete(); // soft delete

        $this->assertSame(0.0, SaldoKas::saldo('kas'));
    }
}
