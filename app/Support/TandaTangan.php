<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\Peran;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Storage;

/**
 * Penyiap tanda tangan untuk blok "Disetujui oleh" pada PDF.
 *
 * ⚠️ KENAPA DIPISAH KE KELAS SENDIRI:
 * Logika "cari Direktur, ambil gambarnya, ubah ke data URI" dipakai di beberapa
 * tempat (PDF laporan & PDF tabel). Ditaruh di satu tempat supaya tidak ada
 * dua versi yang bisa berbeda diam-diam.
 *
 * ⚠️ KENAPA DATA URI (base64), BUKAN URL:
 * dompdf menjalankan render di sisi server TANPA sesi login. Kalau memakai URL
 * ber-otentikasi `/admin/nota/...`, gambarnya akan gagal dimuat (401). Dengan
 * menempelkan isi gambar sebagai data URI, PDF selalu bisa dirender - sekaligus
 * TIDAK membuat berkas tanda tangan bisa diunduh publik.
 */
final class TandaTangan
{
    /**
     * Siapkan data tanda tangan Direktur untuk dirender di Blade.
     *
     * @return array{gambar: string|null, nama: string, jabatan: string}
     */
    public static function untukPdf(): array
    {
        $direktur = self::direktur();

        return [
            'gambar' => self::dataUri($direktur?->tanda_tangan),
            'nama' => $direktur?->nama ?? '(............................)',
            'jabatan' => 'Direktur',
        ];
    }

    /**
     * Direktur aktif pertama (bila ada).
     */
    private static function direktur(): ?Pengguna
    {
        return Pengguna::query()
            ->where('peran', Peran::Direktur)
            ->orderBy('id')
            ->first();
    }

    /**
     * Ubah berkas gambar di disk privat `nota` menjadi data URI base64.
     *
     * Mengembalikan null bila path kosong, berkas tidak ada, atau isinya gagal
     * dibaca - supaya PDF tetap bisa terbit tanpa gambar.
     */
    private static function dataUri(?string $path): ?string
    {
        if (! Nota::ada($path)) {
            return null;
        }

        $bersih = ltrim(str_replace('\\', '/', (string) $path), '/');

        try {
            $disk = Storage::disk('nota');
            $isi = $disk->get($bersih);
            $mime = $disk->mimeType($bersih) ?: 'image/png';
        } catch (\Throwable) {
            return null;
        }

        if ($isi === null || $isi === '') {
            return null;
        }

        return 'data:'.$mime.';base64,'.base64_encode($isi);
    }
}
