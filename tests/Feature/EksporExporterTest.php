<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Exports\MitraExporter;
use App\Filament\Exports\PenggunaExporter;
use App\Filament\Exports\RakitEkspor;
use App\Filament\Exports\SpkExporter;
use App\Filament\Exports\UangKeluarExporter;
use App\Filament\Exports\UangMasukExporter;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Setiap exporter HARUS benar-benar bisa menghasilkan baris.
 *
 * ⚠️ BUG YANG DITEMUKAN (2 Okt 2026):
 * `SpkExporter` memakai `ExportColumn::make('totalPenerimaan')` dan
 * `make('sisaTagih')`. Keduanya METHOD pada model Spk, bukan kolom/relasi.
 * Filament membaca state lewat `data_get()`, Laravel mengira itu RELASI, dan
 * melempar:
 *   "App\Models\Spk::totalPenerimaan must return a relationship instance."
 *
 * Akibatnya **SELURUH ekspor Excel menu SPK GAGAL** (bukan cuma satu kolom
 * kosong) — dan tidak ada tes yang menangkapnya, karena tes lama hanya
 * memeriksa `getColumns()` ada, tanpa benar-benar memanggil exporter-nya.
 *
 * Pelajaran: uji exporter dengan MEMANGGIL-nya pada record nyata.
 */
class EksporExporterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return list<array{0: class-string, 1: class-string}>
     */
    public static function exporterProvider(): array
    {
        return [
            [SpkExporter::class, Spk::class],
            [UangMasukExporter::class, UangMasuk::class],
            [UangKeluarExporter::class, UangKeluar::class],
            [MitraExporter::class, Mitra::class],
            [PenggunaExporter::class, Pengguna::class],
        ];
    }

    /**
     * @param  class-string  $exporterClass
     * @param  class-string  $modelClass
     */
    #[DataProvider('exporterProvider')]
    public function test_exporter_menghasilkan_baris_untuk_record_nyata(string $exporterClass, string $modelClass): void
    {
        // Pastikan ada data: kalau factory tidak menyediakan, buat minimal satu.
        $record = $modelClass::query()->first() ?? $this->buatRecord($modelClass);

        $kolom = $exporterClass::getVisibleColumns();
        $map = [];

        foreach ($kolom as $k) {
            $map[$k->getName()] = $k->getLabel();
        }

        $exporter = new $exporterClass(new Export, $map, []);
        $baris = $exporter($record);

        $this->assertCount(
            count($map),
            $baris,
            "Exporter {$exporterClass} harus menghasilkan satu nilai per kolom.",
        );
    }

    public function test_spk_exporter_menghitung_sudah_dan_belum_diterima(): void
    {
        $spk = Spk::factory()->pln()->create(['nilai_spk' => 10_000_000]);
        UangMasuk::factory()->create(['spk_id' => $spk->id, 'jumlah' => 4_000_000]);

        $susunan = RakitEkspor::susun(SpkExporter::class, [$spk->fresh()]);

        $header = $susunan['header'];
        $baris = $susunan['baris'][0];

        $nilaiPerKolom = array_combine($header, $baris);

        $this->assertEqualsWithDelta(4_000_000, (float) $nilaiPerKolom['Sudah Diterima'], 0.01);
        $this->assertEqualsWithDelta(6_000_000, (float) $nilaiPerKolom['Belum Diterima'], 0.01);
    }

    private function buatRecord(string $modelClass): object
    {
        return match ($modelClass) {
            Spk::class => Spk::factory()->pln()->create(),
            UangMasuk::class => UangMasuk::factory()->create(),
            UangKeluar::class => UangKeluar::factory()->create(),
            Mitra::class => Mitra::factory()->create(),
            Pengguna::class => Pengguna::factory()->admin()->create(),
        };
    }
}
