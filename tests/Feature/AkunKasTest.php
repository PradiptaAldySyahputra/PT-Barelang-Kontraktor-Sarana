<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use Tests\TestCase;

/**
 * Enum akun kas/bank.
 *
 * Dipakai untuk memisahkan buku KAS dan BANK — permintaan pengguna agar
 * laporan keuangan bisa disajikan terpisah seperti Excel perusahaan.
 */
class AkunKasTest extends TestCase
{
    public function test_nilai_enum_hanya_kas_dan_bank(): void
    {
        $this->assertSame(
            ['kas', 'bank'],
            array_map(fn (AkunKas $a): string => $a->value, AkunKas::cases()),
        );
    }

    public function test_label_dan_opsi(): void
    {
        $this->assertSame('Kas', AkunKas::Kas->label());
        $this->assertSame('Bank', AkunKas::Bank->label());

        $this->assertSame(
            ['kas' => 'Kas', 'bank' => 'Bank'],
            AkunKas::opsi(),
        );
    }
}
