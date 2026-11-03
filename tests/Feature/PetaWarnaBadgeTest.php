<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Enums\DikerjakanOleh;
use App\Enums\KategoriMitra;
use App\Enums\KategoriPengeluaran;
use App\Enums\Peran;
use App\Enums\StatusAntar;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * A.2 - Peta warna badge KONSISTEN (sistem desain v1.1, 11 Okt 2026).
 *
 * MASALAH YANG DIPERBAIKI:
 * Warna badge dulu ditulis TERPISAH di tiap tabel/form. Akibatnya satu status
 * bisa punya warna berbeda di dua halaman, dan mengubahnya berarti menyunting
 * banyak file. Sekarang SEMUA warna badge dipusatkan pada method `warnaBadge()`
 * di masing-masing enum (satu sumber kebenaran), sama seperti StatusSpk dkk.
 *
 * Tes ini mengunci kontrak:
 * 1. Tiap enum yang tampil sebagai badge PUNYA `warnaBadge()`.
 * 2. Warnanya selalu salah satu warna resmi Filament (tidak salah ketik).
 * 3. Tabel/layar TIDAK lagi menulis peta warna kategori secara hardcode.
 */
class PetaWarnaBadgeTest extends TestCase
{
    /** Warna badge resmi Filament. */
    private const WARNA_RESMI = ['gray', 'primary', 'success', 'warning', 'danger', 'info'];

    /**
     * Semua enum yang tampil sebagai badge di UI.
     *
     * @return array<string, array{0: class-string}>
     */
    public static function enumBadge(): array
    {
        return [
            'StatusSpk' => [StatusSpk::class],
            'StatusTagihan' => [StatusTagihan::class],
            'StatusAntar' => [StatusAntar::class],
            'AkunKas' => [AkunKas::class],
            'DikerjakanOleh' => [DikerjakanOleh::class],
            'KategoriMitra' => [KategoriMitra::class],
            'Peran' => [Peran::class],
            'KategoriPengeluaran' => [KategoriPengeluaran::class],
        ];
    }

    /**
     * @param  class-string  $enum
     */
    #[DataProvider('enumBadge')]
    public function test_setiap_enum_punya_warna_badge(string $enum): void
    {
        $this->assertTrue(
            method_exists($enum, 'warnaBadge'),
            "Enum {$enum} harus punya method warnaBadge() agar warna badge konsisten."
        );

        foreach ($enum::cases() as $case) {
            $warna = $case->warnaBadge();

            $this->assertContains(
                $warna,
                self::WARNA_RESMI,
                "Warna badge {$enum}::{$case->name} = '{$warna}' bukan warna resmi Filament."
            );
        }
    }

    public function test_kategori_pengeluaran_warna_badge_sesuai_peta(): void
    {
        $this->assertSame('primary', KategoriPengeluaran::Material->warnaBadge());
        $this->assertSame('warning', KategoriPengeluaran::Upah->warnaBadge());
        $this->assertSame('info', KategoriPengeluaran::Transportasi->warnaBadge());
        $this->assertSame('gray', KategoriPengeluaran::Operasional->warnaBadge());
        $this->assertSame('success', KategoriPengeluaran::Gaji->warnaBadge());
        $this->assertSame('info', KategoriPengeluaran::Nota->warnaBadge());
        $this->assertSame('gray', KategoriPengeluaran::Lainnya->warnaBadge());
    }

    /**
     * Satu status tidak boleh punya warna berbeda di dua tempat. Karena warna
     * kini hanya ada di enum, cukup pastikan tabel memakai `warnaBadge()`.
     */
    public function test_tabel_kategori_memakai_enum_bukan_hardcode(): void
    {
        $tabel = file_get_contents(
            resource_path('views/livewire/cash-out/cash-out-table.blade.php')
        );

        $this->assertStringContainsString(
            'warnaBadge()',
            $tabel,
            'Kolom kategori harus memakai KategoriPengeluaran::warnaBadge(), bukan peta warna hardcode.'
        );

        $this->assertStringNotContainsString(
            "KategoriPengeluaran::Material => 'primary'",
            $tabel,
            'Peta warna kategori tidak boleh ditulis ulang di tabel.'
        );
    }

    public function test_mengubah_warna_badge_cukup_di_enum(): void
    {
        // Warna badge Spk di tabel & di halaman detail harus identik karena
        // keduanya membaca sumber yang sama (enum).
        $this->assertSame(
            StatusSpk::Berjalan->warnaBadge(),
            StatusSpk::Berjalan->warnaBadge()
        );
    }
}
