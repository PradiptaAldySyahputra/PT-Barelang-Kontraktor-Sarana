<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\Spks\Schemas\SpkForm;
use App\Filament\Resources\UangMasuks\Schemas\UangMasukForm;
use Tests\TestCase;

/**
 * Tata letak form sesuai brief UI/UX (8 Okt 2026).
 *
 * Uji ini memeriksa SUMBER form (bukan render penuh) supaya tahan terhadap
 * perubahan markup Filament — yang dipastikan di sini: keputusan tata letak
 * (kolom, inline, lebar penuh) benar-benar diterapkan di kode.
 */
class TataLetakBriefFormTest extends TestCase
{
    private function baca(string $kelas): string
    {
        $refleksi = new \ReflectionClass($kelas);
        $berkas = $refleksi->getFileName();

        $this->assertIsString($berkas, "Berkas $kelas tidak ditemukan");

        return (string) file_get_contents($berkas);
    }

    // =========================================================
    // SPK — GRID 2 KOLOM BERBASIS KARTU
    // =========================================================

    public function test_form_spk_memakai_grid_dua_kolom(): void
    {
        $sumber = $this->baca(SpkForm::class);

        $this->assertMatchesRegularExpression(
            '/->columns\(2\)/',
            $sumber,
            'Form SPK harus memakai grid 2 kolom pada layar lebar',
        );
    }

    public function test_unggahan_dokumen_spk_lebar_penuh_di_bawah(): void
    {
        $sumber = $this->baca(SpkForm::class);

        // Section dokumen harus columnSpanFull (satu area luas).
        $this->assertStringContainsString('Dokumen SPK', $sumber);
        $this->assertStringContainsString('columnSpanFull()', $sumber);
    }

    public function test_status_spk_tetap_hanya_tampil(): void
    {
        $sumber = $this->baca(SpkForm::class);

        // Keputusan user (dipertahankan): status TIDAK bisa diubah dari form ini.
        $this->assertStringContainsString('hanya tampil', $sumber);
        $this->assertStringContainsString('Placeholder::make', $sumber);
    }

    public function test_spk_tidak_menghitung_retensi(): void
    {
        $sumber = $this->baca(SpkForm::class);

        // NO RETENTION — jangan sampai elemen retensi muncul lagi.
        $this->assertStringNotContainsString('persen_retensi', $sumber);
        $this->assertStringNotContainsString('nilai_retensi', $sumber);
        $this->assertStringNotContainsString('Retensi', $sumber);
    }

    // =========================================================
    // UANG MASUK — PEMILIH MODE HORIZONTAL
    // =========================================================

    public function test_mode_uang_masuk_horizontal(): void
    {
        $sumber = $this->baca(UangMasukForm::class);

        // Segmented/horizontal: Radio dengan ->inline().
        $this->assertStringContainsString("Radio::make('mode')", $sumber);
        $this->assertMatchesRegularExpression(
            '/Radio::make\(\'mode\'\)(.*?)\->inline\(\)/s',
            $sumber,
            'Pemilih mode harus horizontal (->inline())',
        );
    }

    public function test_kedua_mode_uang_masuk_ada(): void
    {
        $sumber = $this->baca(UangMasukForm::class);

        $this->assertStringContainsString('Berdasarkan SPK', $sumber);
        $this->assertStringContainsString('Manual / Luar SPK', $sumber);
    }
}
