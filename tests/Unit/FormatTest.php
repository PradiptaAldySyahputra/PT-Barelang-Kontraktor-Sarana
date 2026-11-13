<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Support\Format;
use PHPUnit\Framework\TestCase;

final class FormatTest extends TestCase
{
    public function test_bersihkan_uang_dari_berbagai_format_input(): void
    {
        $this->assertSame(15000000.0, Format::bersihkanUang('15.000.000'));
        $this->assertSame(15000000.0, Format::bersihkanUang('Rp 15.000.000'));
        $this->assertSame(15000000.0, Format::bersihkanUang('Rp. 15.000.000,-'));
        $this->assertSame(15000000.5, Format::bersihkanUang('15.000.000,50'));
        $this->assertSame(500000.0, Format::bersihkanUang('500000'));
        $this->assertSame(250000.0, Format::bersihkanUang(250000));
        $this->assertSame(0.0, Format::bersihkanUang(''));
        $this->assertSame(0.0, Format::bersihkanUang(null));
    }

    public function test_format_rupiah_dan_terbilang_akurasi_tinggi(): void
    {
        $this->assertSame('Rp 2.500.000', Format::rupiah(2500000));
        $this->assertSame('Rp 0', Format::rupiah(0));
        $this->assertSame('dua juta lima ratus ribu rupiah', Format::terbilang(2500000));
        $this->assertSame('nol rupiah', Format::terbilang(0));
    }
}
