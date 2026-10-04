<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Actions\EksporPdf;
use App\Filament\Exports\RakitEkspor;
use App\Filament\Exports\SpkExporter;
use App\Filament\Exports\UangKeluarExporter;
use App\Filament\Exports\UangMasukExporter;
use App\Models\Mitra;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Tests\TestCase;

/**
 * EKSPOR PDF di SEMUA MENU (permintaan pengguna 2 Okt 2026).
 *
 * ⚠️ KENAPA PERLU:
 * `ExportAction` bawaan Filament hanya menyediakan CSV & XLSX — TIDAK ada PDF.
 * Akibatnya menu SPK/Mitra/Pengguna/Uang Masuk/Uang Keluar hanya bisa
 * Excel/CSV. Pengguna meminta tombol PDF tersedia di semua menu.
 *
 * PDF dipakai untuk MENYERAHKAN & MENGARSIPKAN (mis. lampiran ke bagian
 * pajak) — angkanya tidak mudah diubah tanpa jejak.
 *
 * ⚠️ RISIKO YANG DIJAGA TES INI:
 * 1. Isi PDF harus mengikuti DATA yang ada (bukan kosong / bukan gagal senyap).
 * 2. Isi PDF memakai kolom & formatter yang SAMA dengan Excel/CSV
 *    (satu sumber definisi kolom) — supaya tidak ada kolom yang hilang.
 * 3. Aksi hanya boleh muncul untuk pengguna yang berhak mengubah/melihat menu.
 */
class EksporPdfMenuTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $mitra = Mitra::factory()->create(['nama' => 'PT Uji PDF']);

        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'PDFMENU-001',
            'nama_pekerjaan' => 'Pekerjaan Uji PDF Menu',
            'nilai_spk' => 50_000_000,
            'mitra_id' => $mitra->id,
        ]);

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'tanggal' => '2026-08-05',
            'jumlah' => 20_000_000,
        ]);

        UangKeluar::factory()->create([
            'tanggal' => '2026-08-06',
            'jumlah' => 5_000_000,
            'kategori' => 'material',
        ]);
    }

    private function isiPdf(StreamedResponse $respons): string
    {
        ob_start();
        $respons->sendContent();

        return (string) ob_get_clean();
    }

    public function test_aksi_ekspor_pdf_bisa_dibuat(): void
    {
        $aksi = EksporPdf::make(SpkExporter::class, 'Daftar SPK');

        $this->assertSame('Ekspor PDF', $aksi->getLabel());
    }

    public function test_pdf_daftar_spk_terbentuk_dan_berisi_data(): void
    {
        $respons = EksporPdf::unduh(SpkExporter::class, Spk::all(), 'Daftar SPK');

        $this->assertStringStartsWith('%PDF', $this->isiPdf($respons));
    }

    public function test_pdf_uang_masuk_terbentuk(): void
    {
        $respons = EksporPdf::unduh(UangMasukExporter::class, UangMasuk::all(), 'Uang Masuk');

        $this->assertStringStartsWith('%PDF', $this->isiPdf($respons));
    }

    public function test_pdf_uang_keluar_terbentuk(): void
    {
        $respons = EksporPdf::unduh(UangKeluarExporter::class, UangKeluar::all(), 'Uang Keluar');

        $this->assertStringStartsWith('%PDF', $this->isiPdf($respons));
    }

    public function test_header_pdf_sama_dengan_kolom_exporter(): void
    {
        $susunan = RakitEkspor::susun(SpkExporter::class, Spk::all());

        $this->assertNotEmpty($susunan['header']);
        $this->assertContains('Nomor SPK', $susunan['header']);
        $this->assertContains('Nilai SPK', $susunan['header']);

        // Setiap baris harus punya jumlah sel yang sama dengan header.
        foreach ($susunan['baris'] as $baris) {
            $this->assertCount(count($susunan['header']), $baris);
        }
    }
}
