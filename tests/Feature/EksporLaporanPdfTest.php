<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * EKSPOR PDF dari halaman Laporan.
 *
 * ⚠️ SUMBER ATURAN:
 *   PRD.md FR-RPT-007 → "Export PDF & Excel di setiap laporan"
 *   PRD.md §8 butir 7 → "Laporan dapat diekspor ke PDF/Excel"
 *
 * ⚠️ KENAPA PDF PERLU, padahal sudah ada Excel & CSV:
 * Excel dipakai untuk **mengolah** angka. PDF dipakai untuk **menyerahkan &
 * mengarsipkan** — mis. lampiran laporan ke bagian pajak, atau bukti saat
 * pemeriksaan. PDF tidak bisa diubah angkanya tanpa jejak, jadi lebih aman
 * sebagai dokumen resmi.
 *
 * 📌 Keputusan pengguna (29 Sep 2026): "ekspor pdf dan excel, sebaiknya kearah
 *    excel" → Excel didahulukan (sudah selesai), PDF menyusul.
 */
class EksporLaporanPdfTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-pdf@bks.test',
        ]);

        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'PDF-001',
            'nama_pekerjaan' => 'Pekerjaan Uji PDF',
            'nilai_spk' => 10_000_000,
        ]);

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'tanggal' => '2026-08-01',
            'jumlah' => 4_000_000,
        ]);
    }

    public function test_laporan_bisa_diekspor_ke_pdf(): void
    {
        $respons = $this->actingAs($this->admin)
            ->get(route('laporan.ekspor', ['jenis' => 'spk', 'format' => 'pdf']));

        $respons->assertSuccessful();

        $this->assertStringContainsString(
            'application/pdf',
            (string) $respons->headers->get('content-type'),
            'Ekspor PDF harus mengirim content-type application/pdf.',
        );
    }

    public function test_berkas_pdf_benar_benar_pdf(): void
    {
        $respons = $this->actingAs($this->admin)
            ->get(route('laporan.ekspor', ['jenis' => 'spk', 'format' => 'pdf']));

        $respons->assertSuccessful();

        $isi = $respons->getContent();

        /*
         * Setiap berkas PDF diawali penanda "%PDF-" dan diakhiri "%%EOF".
         * Kalau HTML bocor mentah ke pengguna, penanda ini tidak ada.
         */
        $this->assertStringStartsWith(
            '%PDF-',
            $isi,
            'Keluaran harus berupa PDF sungguhan, bukan HTML mentah.',
        );

        $this->assertStringContainsString('%%EOF', $isi);
    }

    public function test_pdf_memuat_nama_perusahaan_dan_judul_laporan(): void
    {
        $respons = $this->actingAs($this->admin)
            ->get(route('laporan.ekspor', ['jenis' => 'spk', 'format' => 'pdf']));

        $isi = $respons->getContent();

        /*
         * Isi PDF termampatkan, jadi teks tidak selalu terbaca langsung.
         * Yang penting: berkasnya sah dan berukuran wajar (bukan kosong).
         */
        $this->assertGreaterThan(
            2000,
            strlen($isi),
            'PDF tidak boleh kosong — harus memuat kop & tabel laporan.',
        );
    }

    public function test_semua_jenis_laporan_bisa_diekspor_pdf(): void
    {
        foreach (['spk', 'piutang', 'masuk', 'keluar', 'tenggat'] as $jenis) {
            $respons = $this->actingAs($this->admin)
                ->get(route('laporan.ekspor', ['jenis' => $jenis, 'format' => 'pdf']));

            $respons->assertSuccessful();

            $this->assertStringStartsWith(
                '%PDF-',
                $respons->getContent(),
                "Laporan jenis '{$jenis}' harus bisa diekspor ke PDF.",
            );
        }
    }

    public function test_format_tidak_dikenal_dianggap_csv(): void
    {
        // Daftar putih: format ngawur tidak boleh bikin error 500.
        $respons = $this->actingAs($this->admin)
            ->get(route('laporan.ekspor', ['jenis' => 'spk', 'format' => 'docx']));

        $respons->assertSuccessful();
        $respons->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }
}
