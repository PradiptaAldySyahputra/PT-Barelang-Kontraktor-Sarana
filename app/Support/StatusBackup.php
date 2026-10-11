<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

/**
 * Status berkas backup database (B1-4).
 *
 * ⚠️ KENAPA PERLU:
 * Temuan audit: backup terjadwal TIDAK PERNAH menghasilkan berkas, dan tidak
 * ada cara memantau dari aplikasi. Non-teknisi (Direktur) tidak bisa tahu
 * apakah data perusahaan benar-benar ter-backup. Kelas ini membaca folder
 * backup dan merangkumnya untuk halaman "Backup & Restore".
 *
 * Tidak menulis/mengubah apa pun — hanya membaca.
 */
final class StatusBackup
{
    /**
     * Daftar berkas backup, terbaru lebih dulu.
     *
     * @return list<array{nama: string, ukuran: int, ukuran_teks: string, waktu: Carbon, umur_hari: int}>
     */
    public static function daftar(): array
    {
        $dir = self::direktori();

        if (! File::isDirectory($dir)) {
            return [];
        }

        $berkas = collect(File::files($dir))
            ->filter(fn (\SplFileInfo $f): bool => in_array($f->getExtension(), ['gz', 'sql'], true))
            ->map(function (\SplFileInfo $f): array {
                $ukuran = $f->getSize();
                $waktu = Carbon::createFromTimestamp($f->getMTime());

                return [
                    'nama' => $f->getFilename(),
                    'ukuran' => $ukuran,
                    'ukuran_teks' => self::formatUkuran($ukuran),
                    'waktu' => $waktu,
                    'umur_hari' => (int) $waktu->diffInDays(now()),
                ];
            })
            ->sortByDesc(fn (array $b): int => $b['waktu']->getTimestamp())
            ->values()
            ->all();

        return $berkas;
    }

    /**
     * Ringkasan: jumlah, total ukuran, waktu backup terakhir.
     *
     * @return array{jumlah: int, total_ukuran: int, total_ukuran_teks: string, terakhir: Carbon|null, umur_hari: int|null, sehat: bool}
     */
    public static function ringkasan(): array
    {
        $daftar = self::daftar();

        if ($daftar === []) {
            return [
                'jumlah' => 0,
                'total_ukuran' => 0,
                'total_ukuran_teks' => '0 B',
                'terakhir' => null,
                'umur_hari' => null,
                'sehat' => false,
            ];
        }

        $total = array_sum(array_column($daftar, 'ukuran'));
        $terakhir = $daftar[0]['waktu'];
        $umur = (int) $terakhir->diffInDays(now());

        return [
            'jumlah' => count($daftar),
            'total_ukuran' => $total,
            'total_ukuran_teks' => self::formatUkuran($total),
            // "Sehat" = ada backup dalam 2 hari terakhir (jadwal harian, kasih toleransi).
            'sehat' => $umur <= 2,
            'terakhir' => $terakhir,
            'umur_hari' => $umur,
        ];
    }

    public static function direktori(): string
    {
        return storage_path('app/backup');
    }

    public static function formatUkuran(int $bytes): string
    {
        return match (true) {
            $bytes >= 1073741824 => round($bytes / 1073741824, 2).' GB',
            $bytes >= 1048576 => round($bytes / 1048576, 2).' MB',
            $bytes >= 1024 => round($bytes / 1024, 2).' KB',
            default => $bytes.' B',
        };
    }

    /**
     * Ambil berkas backup berdasarkan nama (untuk unduh) — DENGAN penjagaan
     * path traversal: nama harus benar-benar salah satu berkas di folder backup.
     */
    public static function pathAman(string $nama): ?string
    {
        $nama = basename($nama);

        foreach (self::daftar() as $b) {
            if ($b['nama'] === $nama) {
                return self::direktori().DIRECTORY_SEPARATOR.$nama;
            }
        }

        return null;
    }
}
