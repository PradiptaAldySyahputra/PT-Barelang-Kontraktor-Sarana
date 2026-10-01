<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Exports\UangKeluarExporter;
use App\Filament\Exports\UangMasukExporter;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Format berkas ekspor harus RAPI — bukan nilai mentah.
 *
 * ⚠️ TEMUAN AUDIT (26 Sep 2026):
 * Berkas ekspor berisi nilai mentah: tanggal `2026-09-25 00:00:00` dan
 * akun `kas` (huruf kecil). Berkas ini diserahkan ke bagian pajak / pihak
 * luar, jadi harus langsung enak dibaca: `25/09/2026` dan `Kas`.
 */
class FormatEksporTest extends TestCase
{
    use RefreshDatabase;

    private function nilaiKolom(string $exporter, string $kolom, mixed $record): mixed
    {
        $kolomObj = collect($exporter::getColumns())
            ->first(fn ($k): bool => $k->getName() === $kolom);

        $this->assertNotNull($kolomObj, "Kolom {$kolom} harus ada di exporter.");

        // Panggil formatter seperti yang dilakukan Filament saat mengekspor.
        $refleksi = new \ReflectionClass($kolomObj);
        $prop = $refleksi->getProperty('formatStateUsing');
        $prop->setAccessible(true);
        $callback = $prop->getValue($kolomObj);

        if ($callback === null) {
            return data_get($record, $kolom);
        }

        return $callback($kolom === 'akun' ? $record->akun : data_get($record, $kolom), $record);
    }

    public function test_tanggal_uang_keluar_diformat_dd_mm_yyyy(): void
    {
        $record = UangKeluar::factory()->create(['tanggal' => '2026-09-25', 'akun' => 'kas']);

        $nilai = $this->nilaiKolom(UangKeluarExporter::class, 'tanggal', $record);

        $this->assertSame('25/09/2026', $nilai, 'Tanggal harus dd/mm/yyyy, bukan nilai mentah.');
    }

    public function test_akun_uang_keluar_berlabel_kapital(): void
    {
        $record = UangKeluar::factory()->create(['akun' => 'kas']);

        $nilai = $this->nilaiKolom(UangKeluarExporter::class, 'akun', $record);

        $this->assertSame('Kas', $nilai, 'Akun harus berlabel "Kas", bukan "kas".');
    }

    public function test_tanggal_dan_akun_uang_masuk_diformat(): void
    {
        $record = UangMasuk::factory()->create(['tanggal' => '2026-08-05', 'akun' => 'bank']);

        $this->assertSame('05/08/2026', $this->nilaiKolom(UangMasukExporter::class, 'tanggal', $record));
        $this->assertSame('Bank', $this->nilaiKolom(UangMasukExporter::class, 'akun', $record));
    }
}
