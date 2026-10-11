<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Pages\Laporan;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use OpenSpout\Reader\XLSX\Reader as XlsxReader;
use Tests\TestCase;

/**
 * EKSPOR BUKU KAS/BANK (B2-11) dari halaman Laporan.
 *
 * ⚠️ KENAPA DIUJI:
 * Ekspor harus benar-benar menghasilkan berkas XLSX berisi kolom
 * Debet/Kredit/Saldo berjalan, dan halaman menampilkan buku tsb.
 */
class BukuKasBankEksporTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    public function test_halaman_laporan_menampilkan_buku_kas_dan_bank(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 1_000_000, 'tanggal' => now()]);
        $this->actingAs($this->admin());

        Livewire::test(Laporan::class)
            ->assertOk()
            ->assertSee('Buku Kas')
            ->assertSee('Buku Bank');
    }

    public function test_ekspor_buku_kas_menghasilkan_xlsx(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 5_000_000, 'tanggal' => now()]);
        UangKeluar::factory()->create(['akun' => 'kas', 'jumlah' => 2_000_000, 'tanggal' => now()]);

        $this->actingAs($this->admin());

        $response = $this->get(route('laporan.ekspor', ['jenis' => 'buku-kas', 'format' => 'xlsx']));
        $response->assertOk();

        // Baca isi XLSX untuk memastikan kolom Debet/Kredit/Saldo ada.
        $path = tempnam(sys_get_temp_dir(), 'buku').'.xlsx';
        file_put_contents($path, $response->streamedContent());

        $reader = new XlsxReader;
        $reader->open($path);

        $teks = '';
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                foreach ($row->getCells() as $cell) {
                    $teks .= ' '.(string) $cell->getValue();
                }
            }
        }
        $reader->close();
        @unlink($path);

        $this->assertStringContainsString('Debet', $teks);
        $this->assertStringContainsString('Kredit', $teks);
        $this->assertStringContainsString('Saldo', $teks);
        $this->assertStringContainsString('SALDO AWAL', $teks);
    }

    public function test_ekspor_buku_bank_diizinkan(): void
    {
        $this->actingAs($this->admin());

        $this->get(route('laporan.ekspor', ['jenis' => 'buku-bank', 'format' => 'csv']))
            ->assertOk();
    }
}
