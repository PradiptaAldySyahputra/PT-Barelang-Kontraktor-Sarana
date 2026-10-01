<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use OpenSpout\Reader\XLSX\Reader as XlsxReader;
use Tests\TestCase;

/**
 * EKSPOR EXCEL (XLSX) dari halaman Laporan.
 *
 * ⚠️ SUMBER ATURAN:
 *   PRD.md FR-RPT-007 → "Export PDF & Excel di setiap laporan"
 *
 * ⚠️ KENAPA EXCEL DIDAHULUKAN (keputusan pengguna 29 Sep 2026):
 *   "ekspor pdf dan excel, sebaiknya kearah excel"
 *
 * Perusahaan sudah bekerja dengan Excel (mis. `BKS - Format Kas & Bank`).
 * Berkas CSV **tidak cukup** karena:
 *   - kolom angka bisa terbaca sebagai teks (tidak bisa dijumlahkan langsung),
 *   - nama berkas & jenis berkas berbeda dari yang biasa dipakai kantor,
 *   - bagian pajak meminta berkas yang bisa langsung dibuka & disaring.
 *
 * 📌 Yang sudah ada: tombol "Ekspor CSV" di halaman Laporan (6 jenis).
 *    Yang diuji di sini: opsi **XLSX** di halaman yang sama.
 */
class EksporLaporanXlsxTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-xlsx@bks.test',
        ]);

        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'XLSX-001',
            'nama_pekerjaan' => 'Pekerjaan Uji Excel',
            'nilai_spk' => 10_000_000,
        ]);

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'tanggal' => '2026-08-01',
            'jumlah' => 4_000_000,
            'keterangan' => 'DP uji excel',
        ]);
    }

    public function test_laporan_bisa_diekspor_ke_xlsx(): void
    {
        $respons = $this->actingAs($this->admin)
            ->get(route('laporan.ekspor', ['jenis' => 'spk', 'format' => 'xlsx']));

        $respons->assertSuccessful();

        $this->assertStringContainsString(
            'spreadsheet',
            (string) $respons->headers->get('content-type'),
            'Ekspor Excel harus mengirim content-type spreadsheet.',
        );
    }

    public function test_berkas_xlsx_berisi_judul_dan_data(): void
    {
        $respons = $this->actingAs($this->admin)
            ->get(route('laporan.ekspor', ['jenis' => 'spk', 'format' => 'xlsx']));

        $respons->assertSuccessful();

        // Tulis ke berkas sementara supaya bisa dibaca ulang oleh openspout.
        $path = tempnam(sys_get_temp_dir(), 'xlsx').'.xlsx';
        file_put_contents($path, $respons->streamedContent());

        try {
            $reader = new XlsxReader;
            $reader->open($path);

            $teks = [];

            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {
                    foreach ($row->getCells() as $cell) {
                        $teks[] = (string) $cell->getValue();
                    }
                }
            }

            $reader->close();
        } finally {
            @unlink($path);
        }

        $gabung = implode(' | ', $teks);

        $this->assertStringContainsString('XLSX-001', $gabung, 'Nomor SPK harus ada di berkas Excel.');
        $this->assertStringContainsString('Pekerjaan Uji Excel', $gabung, 'Nama pekerjaan harus ada.');
    }

    public function test_angka_di_xlsx_tersimpan_sebagai_angka_bukan_teks(): void
    {
        $respons = $this->actingAs($this->admin)
            ->get(route('laporan.ekspor', ['jenis' => 'spk', 'format' => 'xlsx']));

        $path = tempnam(sys_get_temp_dir(), 'xlsx').'.xlsx';
        file_put_contents($path, $respons->streamedContent());

        $nilaiNumerik = [];

        try {
            $reader = new XlsxReader;
            $reader->open($path);

            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {
                    foreach ($row->getCells() as $cell) {
                        if (is_int($cell->getValue()) || is_float($cell->getValue())) {
                            $nilaiNumerik[] = $cell->getValue();
                        }
                    }
                }
            }

            $reader->close();
        } finally {
            @unlink($path);
        }

        /*
         * ⚠️ KENAPA PENTING: kalau nominal tersimpan sebagai TEKS, admin tidak
         * bisa langsung menjumlahkan di Excel — dan itulah alasan utama
         * memilih XLSX daripada CSV.
         */
        $this->assertNotEmpty(
            $nilaiNumerik,
            'Nominal harus tersimpan sebagai ANGKA di XLSX, bukan teks — agar bisa dijumlahkan di Excel.',
        );
    }

    public function test_csv_masih_tetap_tersedia(): void
    {
        // Regresi: menambah XLSX tidak boleh menghapus CSV yang sudah dipakai.
        $respons = $this->actingAs($this->admin)
            ->get(route('laporan.ekspor', 'spk'));

        $respons->assertSuccessful();
        $respons->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }
}
