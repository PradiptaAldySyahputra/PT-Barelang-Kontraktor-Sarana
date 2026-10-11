<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\Mitras\Pages\CreateMitra;
use App\Filament\Resources\Mitras\Pages\EditMitra;
use App\Filament\Resources\Spks\Pages\CreateSpk;
use App\Filament\Resources\Spks\Pages\EditSpk;
use App\Filament\Resources\Spks\Pages\UbahStatusSpk;
use App\Filament\Resources\Spks\Pages\UbahStatusTagihan;
use App\Filament\Resources\UangKeluars\Pages\CreateUangKeluar;
use App\Filament\Resources\UangKeluars\Pages\EditUangKeluar;
use App\Filament\Resources\UangMasuks\Pages\CreateUangMasuk;
use App\Filament\Resources\UangMasuks\Pages\EditUangMasuk;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * STICKY ACTION BAR.
 *
 * ⚠️ MASALAH YANG DIPERBAIKI:
 * Form SPK & Uang Keluar panjang (8+ section). Setelah mengisi field terbawah,
 * admin harus SCROLL ke atas untuk menemukan tombol "Simpan" — atau sebaliknya,
 * scroll ke bawah dulu baru sadar tombolnya ada. Ini memakan waktu tiap entri.
 *
 * Perbaikan: tombol Simpan/Batal menempel (sticky) di bawah viewport, selalu
 * terlihat tanpa scroll.
 *
 * ⚠️ CATATAN IMPLEMENTASI:
 * Ini perilaku bawaan Filament (`stickyFormActions()` → `$formActionsAreSticky`).
 * Tes ini mengunci bahwa kita BENAR-BENAR menyalakannya, agar tidak mati diam-diam
 * saat Filament naik versi.
 */
class StickyActionBarTest extends TestCase
{
    /**
     * Semua halaman form Create/Edit yang harus punya action bar menempel.
     *
     * @return array<string, array{class-string}>
     */
    public static function halamanFormProvider(): array
    {
        return [
            'SPK Create' => [CreateSpk::class],
            'SPK Edit' => [EditSpk::class],
            'SPK Ubah Status' => [UbahStatusSpk::class],
            'SPK Ubah Tagihan' => [UbahStatusTagihan::class],
            'Uang Masuk Create' => [CreateUangMasuk::class],
            'Uang Masuk Edit' => [EditUangMasuk::class],
            'Uang Keluar Create' => [CreateUangKeluar::class],
            'Uang Keluar Edit' => [EditUangKeluar::class],
            'Mitra Create' => [CreateMitra::class],
            'Mitra Edit' => [EditMitra::class],
        ];
    }

    /**
     * @param  class-string  $halaman
     */
    #[DataProvider('halamanFormProvider')]
    public function test_form_actions_menempel(string $halaman): void
    {
        $instance = new $halaman;

        $this->assertTrue(
            $instance->areFormActionsSticky(),
            "Halaman {$halaman} harus mengaktifkan sticky form actions.",
        );
    }
}
