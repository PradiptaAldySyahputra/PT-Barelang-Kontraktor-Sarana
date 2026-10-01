<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Spk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * PERPANJANGAN TENGGAT SPK.
 *
 * ⚠️ PERMINTAAN PENGGUNA (26 Sep 2026):
 * "perpanjangan tenggat SPK tidak bergantung tenggat waktu awal, bisa
 *  diperpanjang sesuai kesepakatan (berapa bulan / perjanjian)"
 *
 * MASALAH SEBELUMNYA: `tanggal_akhir` hanya satu tanggal. Kalau SPK
 * diperpanjang lewat adendum, admin mengubah tanggalnya LANGSUNG — sehingga
 * **jejak tenggat awal HILANG** dan tidak ada catatan berapa kali diperpanjang.
 *
 * SOLUSI (tetap 5 tabel): riwayat perpanjangan disimpan di kolom JSON
 * `spk.perpanjangan`; `tanggal_akhir` menjadi **tenggat efektif** terbaru.
 */
class PerpanjanganTenggatTest extends TestCase
{
    use RefreshDatabase;

    public function test_spk_tanpa_perpanjangan_pakai_tanggal_akhir(): void
    {
        $spk = Spk::factory()->create(['tanggal_akhir' => '2026-12-31']);

        $this->assertSame('2026-12-31', $spk->tenggatEfektif()->toDateString());
        $this->assertSame(0, $spk->jumlahPerpanjangan());
        $this->assertFalse($spk->pernahDiperpanjang());
    }

    public function test_perpanjangan_pertama_menggeser_tenggat(): void
    {
        $spk = Spk::factory()->create(['tanggal_akhir' => '2026-08-01']);

        $spk->catatPerpanjangan('2026-11-01', 'kesepakatan adendum');

        $spk->refresh();

        // Tenggat efektif = tanggal baru.
        $this->assertSame('2026-11-01', $spk->tenggatEfektif()->toDateString());
        $this->assertSame(1, $spk->jumlahPerpanjangan());
        $this->assertTrue($spk->pernahDiperpanjang());

        // tanggal_akhir ikut diperbarui (dipakai perhitungan tenggat).
        $this->assertSame('2026-11-01', $spk->tanggal_akhir->toDateString());

        // Riwayat menyimpan tanggal LAMA — supaya jejaknya tidak hilang.
        $riwayat = $spk->perpanjangan;
        $this->assertCount(1, $riwayat);
        $this->assertSame('2026-08-01', $riwayat[0]['dari']);
        $this->assertSame('2026-11-01', $riwayat[0]['ke']);
        $this->assertSame('kesepakatan adendum', $riwayat[0]['alasan']);
    }

    public function test_perpanjangan_berkali_kali_menyimpan_seluruh_riwayat(): void
    {
        $spk = Spk::factory()->create(['tanggal_akhir' => '2026-08-01']);

        $spk->catatPerpanjangan('2026-11-01', 'adendum 1');
        $spk->refresh();
        $spk->catatPerpanjangan('2027-02-01', 'adendum 2');
        $spk->refresh();

        $this->assertSame(2, $spk->jumlahPerpanjangan());
        $this->assertSame('2027-02-01', $spk->tenggatEfektif()->toDateString());

        $riwayat = $spk->perpanjangan;
        $this->assertSame('2026-08-01', $riwayat[0]['dari']);
        $this->assertSame('2026-11-01', $riwayat[0]['ke']);
        // Perpanjangan kedua mulai dari tenggat hasil perpanjangan pertama.
        $this->assertSame('2026-11-01', $riwayat[1]['dari']);
        $this->assertSame('2027-02-01', $riwayat[1]['ke']);
    }

    public function test_perpanjangan_tidak_mengubah_tanggal_akhir_lama_di_riwayat(): void
    {
        // Jejak tenggat awal WAJIB tetap ada, walaupun tanggal_akhir berubah.
        $spk = Spk::factory()->create(['tanggal_akhir' => '2026-08-01']);

        $spk->catatPerpanjangan('2027-01-01', 'perpanjangan panjang');
        $spk->refresh();

        $this->assertSame(
            '2026-08-01',
            $spk->perpanjangan[0]['dari'],
            'Tenggat AWAL harus tersimpan di riwayat, bukan hilang.',
        );
    }
}
