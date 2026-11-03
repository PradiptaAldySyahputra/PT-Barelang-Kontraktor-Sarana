<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Support\Perbandingan;
use Tests\TestCase;

/**
 * PERBANDINGAN DENGAN BULAN LALU pada KPI dashboard.
 *
 * ⚠️ SARAN USER (9 Okt 2026):
 * "Hindari angka mentah tanpa konteks - selalu pasangkan dengan perbandingan
 *  (bulan lalu, target)."
 */
class PerbandinganKpiTest extends TestCase
{
    public function test_kenaikan_dihitung_benar(): void
    {
        $hasil = Perbandingan::bulanLalu(1_200_000, 1_000_000);

        $this->assertSame('naik', $hasil['arah']);
        $this->assertSame(20.0, $hasil['persen']);
        $this->assertStringContainsString('20', $hasil['teks']);
        $this->assertStringContainsString('bulan lalu', $hasil['teks']);
    }

    public function test_penurunan_dihitung_benar(): void
    {
        $hasil = Perbandingan::bulanLalu(750_000, 1_000_000);

        $this->assertSame('turun', $hasil['arah']);
        $this->assertSame(-25.0, $hasil['persen']);
    }

    public function test_sama_ditandai_sama(): void
    {
        $hasil = Perbandingan::bulanLalu(1_000_000, 1_000_000);

        $this->assertSame('sama', $hasil['arah']);
        $this->assertSame('sama dengan bulan lalu', $hasil['teks']);
    }

    public function test_bulan_lalu_nol_dan_ada_data_ditandai_baru(): void
    {
        $hasil = Perbandingan::bulanLalu(500_000, 0);

        $this->assertSame('baru', $hasil['arah']);
        $this->assertNull($hasil['persen']);
        $this->assertStringContainsString('baru', $hasil['teks']);
    }

    public function test_keduanya_nol_ditandai_sama(): void
    {
        $hasil = Perbandingan::bulanLalu(0, 0);

        $this->assertSame('sama', $hasil['arah']);
    }
}
