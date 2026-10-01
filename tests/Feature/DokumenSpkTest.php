<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Spk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * UPLOAD DOKUMEN SPK (BAST, scan SPK, kuitansi).
 *
 * ⚠️ KENAPA INI PERLU:
 * PRD `FR-SPK-007` + PRD §9 no.2 menyebut kebutuhan ini, dan pengguna
 * mengonfirmasi: dokumen SPK (BAST, scan SPK) **tidak punya tempat** karena
 * tabel bukti dihapus dan `bukti` hanya ada di uang masuk/keluar.
 *
 * ⚠️ TETAP 5 TABEL: dokumen disimpan sebagai KOLOM JSON `spk.dokumen`
 * (pola sama seperti `bukti` di uang masuk/keluar & `perpanjangan`).
 * Banyak berkas per SPK didukung (bukan satu berkas saja).
 */
class DokumenSpkTest extends TestCase
{
    use RefreshDatabase;

    public function test_kolom_dokumen_ada_dan_json(): void
    {
        $this->assertTrue(
            Schema::hasColumn('spk', 'dokumen'),
            'Kolom `dokumen` harus ada untuk menyimpan berkas SPK (BAST, scan).',
        );

        $tipe = collect(\DB::select('SHOW COLUMNS FROM spk'))
            ->firstWhere('Field', 'dokumen');

        $this->assertNotNull($tipe);

        /*
         * MySQL/MariaDB menyimpan tipe JSON sebagai `longtext` dengan
         * CHECK constraint JSON_VALID. Jadi `longtext` itu BENAR — yang
         * penting adalah cast `array` di model bekerja (diuji di bawah).
         */
        $this->assertContains(
            strtolower((string) $tipe->Type),
            ['json', 'longtext'],
            'Kolom dokumen harus bertipe JSON/longtext.',
        );

        // Bukti nyata bahwa cast array bekerja: simpan & baca kembali.
        $spk = Spk::factory()->create(['dokumen' => ['spk/uji.pdf']]);
        $this->assertIsArray($spk->fresh()->dokumen);
    }

    public function test_bisa_menyimpan_banyak_dokumen(): void
    {
        $spk = Spk::factory()->create([
            'dokumen' => [
                'spk/bast-001.pdf',
                'spk/scan-spk-001.pdf',
            ],
        ]);

        $spk->refresh();

        $this->assertIsArray($spk->dokumen);
        $this->assertCount(2, $spk->dokumen);
        $this->assertSame('spk/bast-001.pdf', $spk->dokumen[0]);
    }

    public function test_spk_tanpa_dokumen_tidak_error(): void
    {
        $spk = Spk::factory()->create(['dokumen' => null]);

        $this->assertNull($spk->dokumen);
        $this->assertSame(0, $spk->jumlahDokumen());
    }

    public function test_jumlah_dokumen_dihitung(): void
    {
        $spk = Spk::factory()->create(['dokumen' => ['a.pdf', 'b.pdf', 'c.pdf']]);

        $this->assertSame(3, $spk->jumlahDokumen());
    }
}
