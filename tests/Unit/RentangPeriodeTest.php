<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Support\RentangPeriode;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class RentangPeriodeTest extends TestCase
{
    public function test_hitung_rentang_hari_ini(): void
    {
        $acuan = Carbon::parse('2026-11-08 14:30:00');
        $hasil = RentangPeriode::hitung('hari_ini', $acuan);

        $this->assertSame('2026-11-08', $hasil['dari']);
        $this->assertSame('2026-11-08', $hasil['sampai']);
    }

    public function test_hitung_rentang_bulan_ini(): void
    {
        $acuan = Carbon::parse('2026-11-08 14:30:00');
        $hasil = RentangPeriode::hitung('bulan_ini', $acuan);

        $this->assertSame('2026-11-01', $hasil['dari']);
        $this->assertSame('2026-11-30', $hasil['sampai']);
    }

    public function test_hitung_rentang_bulan_lalu_berpindah_tahun_dengan_aman(): void
    {
        // Uji batas tahun: Januari 2026 mundur ke Desember 2025
        $acuan = Carbon::parse('2026-01-15 10:00:00');
        $hasil = RentangPeriode::hitung('bulan_lalu', $acuan);

        $this->assertSame('2025-12-01', $hasil['dari']);
        $this->assertSame('2025-12-31', $hasil['sampai']);
    }

    public function test_hitung_rentang_tahun_ini(): void
    {
        $acuan = Carbon::parse('2026-11-08 14:30:00');
        $hasil = RentangPeriode::hitung('tahun_ini', $acuan);

        $this->assertSame('2026-01-01', $hasil['dari']);
        $this->assertSame('2026-12-31', $hasil['sampai']);
    }

    public function test_hitung_rentang_semua_waktu(): void
    {
        $hasil = RentangPeriode::hitung('semua');

        $this->assertNull($hasil['dari']);
        $this->assertNull($hasil['sampai']);
    }
}
