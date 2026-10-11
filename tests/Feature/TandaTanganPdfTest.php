<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Actions\EksporPdf;
use App\Filament\Exports\SpkExporter;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Support\TandaTangan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * TANDA TANGAN DI PDF — permintaan user 10 Okt 2026.
 *
 * Blok "Disetujui oleh" pada PDF sebelumnya hanya titik-titik kosong.
 * Sekarang, bila Direktur sudah mengunggah tanda tangan di Profil Saya,
 * gambarnya ditempel di kolom "Disetujui oleh".
 *
 * ⚠️ YANG DIUJI:
 *   - Gambar tanda tangan benar-benar muncul (sebagai data URI / base64).
 *   - Kalau belum ada tanda tangan, PDF tetap terbit (tidak error) dan
 *     memakai garis titik-titik seperti semula.
 *   - Tanda tangan diambil dari akun ber-peran Direktur.
 */
class TandaTanganPdfTest extends TestCase
{
    use RefreshDatabase;

    private function bikinDirekturDenganTtd(): Pengguna
    {
        Storage::fake('nota');

        $ttd = 'tanda-tangan/direktur.png';
        // PNG valid (dibuat dengan GD: garis diagonal di atas latar putih).
        Storage::disk('nota')->put($ttd, base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAACgAAAAUCAIAAABwJOjsAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAbUlEQVRIicXWUQqAMAwD0FR2/ytXUBn7mNqtbZoLPEJ+IqqKihwlKviwXAHQmCSAvmzjkwx4SibCt/dGpsAfFbNgOxkGr5Je2DJkMCxbFV1wCLkGB5Im2DnkDizRFf/hbHICc0iMMJN8xKrrcwLSTjZH3Ie8OgAAAABJRU5ErkJggg=='
        ));

        return Pengguna::factory()->create([
            'nama' => 'Bapak Direktur',
            'peran' => Peran::Direktur,
            'tanda_tangan' => $ttd,
        ]);
    }

    public function test_pdf_menyertakan_gambar_tanda_tangan_direktur(): void
    {
        $this->bikinDirekturDenganTtd();
        Spk::factory()->count(2)->create();

        $html = EksporPdf::htmlUntukUji(SpkExporter::class, Spk::all(), 'Daftar SPK');

        $this->assertStringContainsString('Disetujui oleh', $html);
        // Gambar tanda tangan disematkan sebagai data URI base64.
        $this->assertStringContainsString('data:image/png;base64,', $html);
        $this->assertStringContainsString('Bapak Direktur', $html);
    }

    /**
     * ⚠️ UJI RENDER PDF SUNGGUHAN — memastikan gambar benar-benar TERTANAM
     * di berkas PDF (bukan hanya ada di HTML). Inilah yang menjamin dompdf
     * tidak diam-diam membuang gambarnya.
     */
    public function test_dompdf_benar_benar_menanamkan_gambar_tanda_tangan(): void
    {
        $this->bikinDirekturDenganTtd();

        $pdf = Pdf::loadView('filament.exports.tabel-pdf', [
            'judul' => 'Uji',
            'header' => ['A'],
            'baris' => [[1]],
            'tandaTangan' => TandaTangan::untukPdf(),
        ])->setPaper('a4', 'landscape');

        $isi = $pdf->output();

        $this->assertStringStartsWith('%PDF', $isi);
        // Objek gambar harus ada di dalam berkas PDF.
        $this->assertMatchesRegularExpression('~/Subtype\s*/Image~', $isi);
    }

    public function test_pdf_tetap_terbit_bila_belum_ada_tanda_tangan(): void
    {
        Storage::fake('nota');
        // Direktur ada tapi belum unggah tanda tangan.
        Pengguna::factory()->create([
            'peran' => Peran::Direktur,
            'tanda_tangan' => null,
        ]);
        Spk::factory()->count(1)->create();

        $html = EksporPdf::htmlUntukUji(SpkExporter::class, Spk::all(), 'Daftar SPK');

        $this->assertStringContainsString('Disetujui oleh', $html);
        $this->assertStringNotContainsString('data:image/png;base64,', $html);
        // Fallback: garis titik-titik tetap ada.
        $this->assertStringContainsString('(....................', $html);
    }

    /**
     * ⚠️ View PDF laporan (halaman Laporan) memakai blade TERPISAH dari
     * view tabel. Keduanya harus ikut menyematkan tanda tangan — kalau tidak,
     * PDF dari menu Laporan akan tetap kosong walau Profil sudah diisi.
     */
    public function test_view_laporan_pdf_menyertakan_tanda_tangan(): void
    {
        $this->bikinDirekturDenganTtd();

        $html = view('filament.pages.laporan-pdf', [
            'judul' => 'Laporan Uang Masuk',
            'header' => ['Tanggal', 'Jumlah'],
            'baris' => [['2026-10-10', 1_000_000]],
            'periode' => 'Oktober 2026',
            'tandaTangan' => TandaTangan::untukPdf(),
        ])->render();

        $this->assertStringContainsString('data:image/png;base64,', $html);
        $this->assertStringContainsString('Bapak Direktur', $html);
    }
}
