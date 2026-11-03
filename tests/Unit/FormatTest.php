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
}
