<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use App\Support\BukuKasBank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * BUKU KAS/BANK (B2-11) — format persis template atasan.
 *
 * ⚠️ KENAPA DIUJI:
 * Laporan akhir perusahaan memakai kolom TANGGAL/REF/KETERANGAN/DEBET/KREDIT/
 * SALDO berjalan. Salah menghitung saldo berjalan = laporan keuangan salah.
 */
class BukuKasBankTest extends TestCase
{
    use RefreshDatabase;

    public function test_saldo_berjalan_dihitung_kumulatif(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 10_000_000, 'tanggal' => '2026-08-01']);
        UangKeluar::factory()->create(['akun' => 'kas', 'jumlah' => 3_000_000, 'tanggal' => '2026-08-02']);
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 2_000_000, 'tanggal' => '2026-08-03']);

        $buku = BukuKasBank::susun(AkunKas::Kas, Carbon::parse('2026-08-01'), Carbon::parse('2026-08-31'));

        $this->assertCount(3, $buku['baris']);
        $this->assertSame(10_000_000.0, $buku['baris'][0]['saldo']);
        $this->assertSame(7_000_000.0, $buku['baris'][1]['saldo']);
        $this->assertSame(9_000_000.0, $buku['baris'][2]['saldo']);
        $this->assertSame(9_000_000.0, $buku['saldo_akhir']);
    }

    public function test_saldo_awal_dari_transaksi_sebelum_periode(): void
    {
        // Transaksi SEBELUM periode (jadi saldo awal).
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 5_000_000, 'tanggal' => '2026-07-15']);

        // Transaksi DALAM periode.
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 1_000_000, 'tanggal' => '2026-08-05']);

        $buku = BukuKasBank::susun(AkunKas::Kas, Carbon::parse('2026-08-01'), Carbon::parse('2026-08-31'));

        $this->assertSame(5_000_000.0, $buku['saldo_awal']);
        $this->assertCount(1, $buku['baris']);
        $this->assertSame(6_000_000.0, $buku['baris'][0]['saldo']);
    }

    public function test_bank_terpisah_dari_kas(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 1_000_000, 'tanggal' => '2026-08-01']);
        UangMasuk::factory()->create(['akun' => 'bank', 'jumlah' => 9_000_000, 'tanggal' => '2026-08-01']);

        $kas = BukuKasBank::susun(AkunKas::Kas);
        $bank = BukuKasBank::susun(AkunKas::Bank);

        $this->assertSame(1_000_000.0, $kas['saldo_akhir']);
        $this->assertSame(9_000_000.0, $bank['saldo_akhir']);
    }

    public function test_debet_adalah_masuk_kredit_adalah_keluar(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 4_000_000, 'tanggal' => '2026-08-01']);
        UangKeluar::factory()->create(['akun' => 'kas', 'jumlah' => 1_500_000, 'tanggal' => '2026-08-02']);

        $buku = BukuKasBank::susun(AkunKas::Kas);

        $this->assertSame(4_000_000.0, $buku['total_debet']);
        $this->assertSame(1_500_000.0, $buku['total_kredit']);
    }

    public function test_ekspor_punya_baris_saldo_awal_dan_total(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 2_000_000, 'tanggal' => '2026-08-01']);

        $buku = BukuKasBank::susun(AkunKas::Kas, Carbon::parse('2026-08-01'), Carbon::parse('2026-08-31'));
        [$header, $baris] = BukuKasBank::untukEkspor($buku);

        $this->assertSame(['Tanggal', 'Ref', 'Keterangan', 'Debet (Masuk)', 'Kredit (Keluar)', 'Saldo'], $header);

        // Baris pertama = SALDO AWAL, baris terakhir = TOTAL.
        $this->assertSame('SALDO AWAL', $baris[0][2]);
        $this->assertSame('TOTAL', $baris[count($baris) - 1][2]);
    }

    public function test_urutan_baris_menaik_per_tanggal(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 1_000_000, 'tanggal' => '2026-08-03']);
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 1_000_000, 'tanggal' => '2026-08-01']);

        $buku = BukuKasBank::susun(AkunKas::Kas);

        $this->assertTrue(
            $buku['baris'][0]['tanggal']->lessThan($buku['baris'][1]['tanggal'])
        );
    }
}
