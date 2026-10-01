<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\PenyimpanBerkas;
use Tests\TestCase;

/**
 * Kompresi HARUS tetap terbaca OCR.
 *
 * ⚠️ PERMINTAAN PENGGUNA (26 Sep 2026):
 * "jangan buat aplikasi jadi berat dengan penambahan ocr disesuaikan ketika
 *  user upload berkas atau file itu dikompres tetapi tetap bisa terbaca oleh ocr"
 *
 * Jadi kompresi punya DUA syarat yang harus dipenuhi bersamaan:
 *   1. berkas jadi jauh lebih kecil (aplikasi tidak berat);
 *   2. resolusi masih cukup untuk OCR membaca tulisan nota.
 *
 * Acuan resolusi: skrip OCR me-render PDF di 200 DPI. Untuk kertas A4
 * (8,27" × 11,69") itu ≈ 1654 × 2339 piksel. Jadi sisi terpanjang hasil
 * kompresi TIDAK BOLEH jauh di bawah itu, atau tulisan kecil akan hilang.
 */
class KompresiUntukOcrTest extends TestCase
{
    private function gambarUji(int $lebar, int $tinggi): string
    {
        if (! function_exists('imagecreatetruecolor')) {
            $this->markTestSkipped('Ekstensi GD tidak tersedia.');
        }

        /*
         * Gambar MIRIP FOTO NOTA: gradien kertas + garis tulisan + noise.
         *
         * ⚠️ Kenapa tidak cukup garis di atas putih: PNG mengompres bidang
         * rata dengan sangat baik, sehingga hasil kompresi tampak "tidak
         * mengecil" dan tes jadi menyesatkan. Noise meniru foto asli dari HP.
         */
        $img = imagecreatetruecolor($lebar, $tinggi);

        for ($y = 0; $y < $tinggi; $y++) {
            $t = (int) (230 - 25 * ($y / $tinggi));
            $c = imagecolorallocate($img, $t, $t, max(0, $t - 5));
            imageline($img, 0, $y, $lebar, $y, $c);
        }

        // Garis tulisan.
        for ($i = 0; $i < 500; $i++) {
            $c = imagecolorallocate($img, random_int(0, 60), random_int(0, 60), random_int(0, 60));
            imageline(
                $img,
                random_int(100, $lebar - 100),
                random_int(100, $tinggi - 100),
                random_int(100, $lebar - 100),
                random_int(100, $tinggi - 100),
                $c,
            );
        }

        // Noise ringan (meniru tekstur foto).
        for ($i = 0; $i < 20000; $i++) {
            $g = random_int(200, 255);
            $c = imagecolorallocate($img, $g, $g, $g);
            imagesetpixel($img, random_int(0, $lebar - 1), random_int(0, $tinggi - 1), $c);
        }

        $tmp = tempnam(sys_get_temp_dir(), 'nota').'.png';
        imagepng($img, $tmp);
        imagedestroy($img);

        return $tmp;
    }

    public function test_sisi_terpanjang_hasil_kompresi_cukup_untuk_ocr(): void
    {
        if (! function_exists('imagecreatefromstring')) {
            $this->markTestSkipped('Ekstensi GD tidak tersedia.');
        }

        // Foto HP besar (4000 px) — kasus paling umum.
        $tmp = $this->gambarUji(3000, 4000);

        $hasil = app(PenyimpanBerkas::class)->kompres($tmp, 'png');

        $this->assertNotNull($hasil, 'Foto besar harus dikompres.');
        [$isi, $ekstensi] = $hasil;

        $gambar = imagecreatefromstring($isi);
        $this->assertNotFalse($gambar);

        $sisiMaks = max(imagesx($gambar), imagesy($gambar));
        imagedestroy($gambar);

        // Acuan OCR (200 DPI, A4) ≈ 2339 px. Beri toleransi: minimal 1600 px.
        $this->assertGreaterThanOrEqual(
            1600,
            $sisiMaks,
            "Sisi terpanjang hasil kompresi ({$sisiMaks}px) terlalu kecil — "
            .'tulisan nota bisa tidak terbaca OCR. Minimal 1600px.',
        );

        $this->assertLessThanOrEqual(
            2400,
            $sisiMaks,
            'Sisi terpanjang terlalu besar — aplikasi jadi berat tanpa manfaat OCR.',
        );

        $this->assertSame('jpg', $ekstensi);

        @unlink($tmp);
    }

    public function test_kompresi_benar_benar_mengecilkan_berkas(): void
    {
        $tmp = $this->gambarUji(3000, 4000);
        $ukuranAsli = filesize($tmp);

        $hasil = app(PenyimpanBerkas::class)->kompres($tmp, 'png');

        $this->assertNotNull($hasil);
        [$isi] = $hasil;

        $this->assertLessThan(
            $ukuranAsli,
            strlen($isi),
            'Hasil kompresi harus lebih kecil dari aslinya.',
        );

        @unlink($tmp);
    }

    public function test_gambar_kecil_tidak_diperbesar(): void
    {
        // Gambar yang sudah kecil jangan dinaikkan resolusinya (hanya jadi berat).
        $tmp = $this->gambarUji(800, 600);

        $hasil = app(PenyimpanBerkas::class)->kompres($tmp, 'png');

        if ($hasil !== null) {
            $gambar = imagecreatefromstring($hasil[0]);
            $this->assertLessThanOrEqual(800, max(imagesx($gambar), imagesy($gambar)));
            imagedestroy($gambar);
        }

        @unlink($tmp);
    }

    public function test_pdf_tidak_dikompres(): void
    {
        $tmp = tempnam(sys_get_temp_dir(), 'nota').'.pdf';
        file_put_contents($tmp, '%PDF-1.4 isi');

        $this->assertNull(
            app(PenyimpanBerkas::class)->kompres($tmp, 'pdf'),
            'PDF tidak boleh dikompres — resolusinya penting untuk OCR tulisan tangan.',
        );

        @unlink($tmp);
    }
}
