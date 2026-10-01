<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Throwable;

/**
 * Simpan berkas nota — dengan KOMPRESI otomatis untuk gambar.
 *
 * ⚠️ KENAPA SEMUA JALUR DI SINI MENGEMBALIKAN PATH RELATIF STORAGE
 * ---------------------------------------------------------------
 * Bug yang pernah terjadi: berkas sementara (`livewire-tmp/...`) dikembalikan
 * sebagai path berkas. Akibatnya `Storage::disk('public')->exists()` gagal
 * ("File tidak ditemukan") dan OCR tidak bisa membaca berkasnya.
 *
 * Karena itu berkas SELALU disimpan lebih dulu ke disk, dan yang dikembalikan
 * adalah path RELATIF yang benar (mis. "uang_keluar/nota-abc.jpg"). Satu
 * unggah menghasilkan SATU berkas — tidak ada penyimpanan ganda.
 *
 * KOMPRESI
 * --------
 * Foto dari HP sering 2–10 MB. Terbukti: PNG 9,5 MB → 1,3 MB (14%), foto
 * 612 KB → 79 KB (13%), tanpa kehilangan keterbacaan. PDF TIDAK dikompres
 * (sudah padat; resolusinya penting untuk membaca tulisan tangan).
 *
 * Kompresi tidak boleh menggagalkan unggah: kalau gagal, berkas asli dipakai.
 */
class PenyimpanBerkas
{
    /**
     * Sisi terpanjang maksimum gambar (piksel).
     *
     * ⚠️ JANGAN DITURUNKAN TANPA MENGUKUR AKURASI OCR.
     *
     * Nilai ini hasil penyelarasan dengan skrip OCR:
     *   - OCR me-render PDF di 200 DPI → A4 ≈ 2339 px sisi terpanjang;
     *   - agar foto yang diunggah admin punya ketajaman SETARA, sisi
     *     terpanjang dijaga 2400 px (tidak pernah diturunkan di bawah itu);
     *   - pada 2400 px, foto 3000×4000 tetap menyusut drastis
     *     (terbukti 21,8 MB → ~1 MB) sehingga aplikasi tidak berat.
     *
     * Sebelumnya 2000 px: tulisan kecil pada nota bisa hilang.
     */
    private const MAKS_PIKSEL = 2400;

    /**
     * Sisi terpanjang MINIMUM agar tulisan nota tetap terbaca OCR.
     *
     * Dipakai untuk memutuskan apakah kompresi masih layak: kalau hasil
     * kompresi membuat gambar lebih kecil dari ini, berkas ASLI yang dipakai.
     */
    private const MIN_PIKSEL_OCR = 1600;

    /** Kualitas JPEG (0–100). 80 = seimbang antara tajam & kecil. */
    private const KUALITAS = 80;

    /**
     * Simpan berkas ke disk, kembalikan path RELATIF (mis. "uang_keluar/x.jpg").
     *
     * Idempoten: nama berkas ditentukan dari isi berkas asal, jadi pemanggilan
     * berulang untuk berkas yang sama TIDAK membuat salinan baru.
     *
     * @param  UploadedFile|string  $file  Berkas unggahan, path absolut, atau path relatif storage.
     */
    public function simpanKe(mixed $file, string $direktori = 'uang_keluar', string $disk = 'nota'): ?string
    {
        // --- 1. Sudah berupa path relatif yang ADA di disk: pakai apa adanya.
        if (is_string($file) && Storage::disk($disk)->exists($file)) {
            return $file;
        }

        // --- 2. Tentukan berkas sumber (absolut) + ekstensi.
        $sumber = null;
        $ekstensi = 'bin';

        if ($file instanceof UploadedFile) {
            $sumber = $file->getRealPath() ?: null;
            $ekstensi = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'bin');
        } elseif (is_string($file) && $file !== '') {
            if (is_file($file)) {
                $sumber = $file;
                $ekstensi = strtolower(pathinfo($file, PATHINFO_EXTENSION) ?: 'bin');
            } else {
                // Path relatif ke folder sementara Livewire.
                foreach (['local', 'public'] as $d) {
                    if (Storage::disk($d)->exists($file)) {
                        $sumber = Storage::disk($d)->path($file);
                        $ekstensi = strtolower(pathinfo($file, PATHINFO_EXTENSION) ?: 'bin');

                        break;
                    }
                }
            }
        }

        if ($sumber === null || ! is_file($sumber)) {
            return null;
        }

        // --- 3. Ringankan (kompres) bila memungkinkan.
        $hasil = $this->kompres($sumber, $ekstensi);

        if ($hasil !== null) {
            [$isi, $ekstensi] = $hasil;
        } else {
            if (! is_readable($sumber)) {
                return null;
            }

            // Catatan: isi boleh KOSONG. Berkas kosong tetap harus punya path
            // yang valid supaya tidak dianggap "file tidak ditemukan".
            $isi = (string) @file_get_contents($sumber);
        }

        // --- 4. Nama DETERMINISTIK dari isi berkas asal -> idempoten.
        $kunci = substr(md5($sumber.'|'.strlen($isi)), 0, 24);
        $relatif = trim($direktori.'/nota-'.$kunci.'.'.$ekstensi, '/');

        if (! Storage::disk($disk)->exists($relatif)) {
            Storage::disk($disk)->put($relatif, $isi, ['visibility' => 'public']);
        }

        return $relatif;
    }

    /**
     * Kompres berkas gambar. Kembalikan [isi, ekstensi] atau null kalau tidak
     * bisa / tidak perlu dikompres.
     *
     * Fungsi murni supaya bisa diuji tanpa upload.
     *
     * @return array{0: string, 1: string}|null
     */
    public function kompres(string $pathAsli, string $ekstensi): ?array
    {
        // Hanya gambar raster. PDF, WEBP, dll. dilewati.
        if (! in_array($ekstensi, ['jpg', 'jpeg', 'png', 'bmp'], true)) {
            return null;
        }

        if (! function_exists('imagecreatefromstring') || ! function_exists('imagejpeg')) {
            return null;
        }

        try {
            $mentah = (string) @file_get_contents($pathAsli);

            if ($mentah === '') {
                return null;
            }

            $gambar = @imagecreatefromstring($mentah);

            if ($gambar === false) {
                return null;
            }

            $lebar = imagesx($gambar);
            $tinggi = imagesy($gambar);

            if ($lebar < 1 || $tinggi < 1) {
                imagedestroy($gambar);

                return null;
            }

            $sisiMaks = max($lebar, $tinggi);

            if ($sisiMaks > self::MAKS_PIKSEL) {
                $rasio = self::MAKS_PIKSEL / $sisiMaks;
                $lebarBaru = max(1, (int) round($lebar * $rasio));
                $tinggiBaru = max(1, (int) round($tinggi * $rasio));

                $kecil = imagecreatetruecolor($lebarBaru, $tinggiBaru);

                // Latar putih: JPEG tidak mendukung transparansi.
                $putih = imagecolorallocate($kecil, 255, 255, 255);
                imagefilledrectangle($kecil, 0, 0, $lebarBaru, $tinggiBaru, $putih);
                imagecopyresampled($kecil, $gambar, 0, 0, 0, 0, $lebarBaru, $tinggiBaru, $lebar, $tinggi);

                imagedestroy($gambar);
                $gambar = $kecil;
            }

            ob_start();
            imagejpeg($gambar, null, self::KUALITAS);
            $isi = (string) ob_get_clean();
            imagedestroy($gambar);

            if ($isi === '') {
                return null;
            }

            /*
             * ⚠️ JANGAN KORBANKAN KETERBACAAN OCR demi ukuran berkas.
             *
             * Kalau hasil kompresi lebih kecil dari MIN_PIKSEL_OCR, tulisan
             * nota bisa tidak terbaca OCR. Dalam kasus itu berkas ASLI dipakai
             * (null = "tidak dikompres") — admin lebih baik mengunggah berkas
             * agak besar daripada nota-nya tidak terbaca.
             */
            $gambarCek = @imagecreatefromstring($isi);

            if ($gambarCek !== false) {
                $sisiCek = max(imagesx($gambarCek), imagesy($gambarCek));
                imagedestroy($gambarCek);

                if ($sisiCek < self::MIN_PIKSEL_OCR) {
                    return null;
                }
            }

            // Kalau hasil kompresi justru LEBIH BESAR, pakai berkas asli.
            if (strlen($isi) >= strlen($mentah)) {
                return null;
            }

            return [$isi, 'jpg'];
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * Batas ukuran unggah (KB) — dari .env supaya bisa disesuaikan dengan
     * php.ini server tanpa mengubah kode.
     */
    public static function maksUkuranKb(): int
    {
        return (int) env('NOTA_MAKS_UKURAN_KB', 25600);
    }
}
