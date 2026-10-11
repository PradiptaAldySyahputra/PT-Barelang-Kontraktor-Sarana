<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Ringkasan kesehatan sistem (B2-10) untuk halaman "Status Sistem".
 *
 * ⚠️ KENAPA PERLU:
 * Non-teknisi (Direktur) butuh SATU halaman untuk tahu apakah sistem sehat:
 * queue worker jalan, backup terbaru, penyimpanan tidak penuh. Tanpa ini,
 * masalah hanya ketahuan saat sudah fatal.
 *
 * Semua pengecekan hanya MEMBACA — tidak mengubah apa pun.
 */
final class StatusSistem
{
    /**
     * @return list<array{kunci: string, label: string, nilai: string, keterangan: string, sehat: bool|null}>
     */
    public static function semua(): array
    {
        return [
            self::database(),
            self::queue(),
            self::backup(),
            self::penyimpanan(),
            self::versiAplikasi(),
        ];
    }

    /**
     * @return array{kunci: string, label: string, nilai: string, keterangan: string, sehat: bool|null}
     */
    private static function database(): array
    {
        try {
            DB::connection()->getPdo();
            $nama = (string) config('database.connections.'.config('database.default').'.database');

            return [
                'kunci' => 'database',
                'label' => 'Database',
                'nilai' => 'Terhubung',
                'keterangan' => 'Database: '.$nama,
                'sehat' => true,
            ];
        } catch (\Throwable $e) {
            return [
                'kunci' => 'database',
                'label' => 'Database',
                'nilai' => 'GAGAL',
                'keterangan' => $e->getMessage(),
                'sehat' => false,
            ];
        }
    }

    /**
     * Queue worker: periksa jumlah job yang menunggu + apakah ada job gagal.
     */
    private static function queue(): array
    {
        try {
            $menunggu = DB::table('jobs')->count();
            $gagal = DB::table('failed_jobs')->count();

            $sehat = $gagal === 0;

            return [
                'kunci' => 'queue',
                'label' => 'Queue Worker',
                'nilai' => $menunggu === 0 ? 'Kosong' : $menunggu.' menunggu',
                'keterangan' => $gagal === 0
                    ? 'Tidak ada job gagal.'
                    : $gagal.' job GAGAL — periksa log.',
                'sehat' => $sehat,
            ];
        } catch (\Throwable $e) {
            return [
                'kunci' => 'queue',
                'label' => 'Queue Worker',
                'nilai' => 'Tidak diketahui',
                'keterangan' => $e->getMessage(),
                'sehat' => null,
            ];
        }
    }

    /**
     * @return array{kunci: string, label: string, nilai: string, keterangan: string, sehat: bool|null}
     */
    private static function backup(): array
    {
        $r = StatusBackup::ringkasan();

        return [
            'kunci' => 'backup',
            'label' => 'Backup Database',
            'nilai' => $r['terakhir']?->translatedFormat('d M Y, H:i') ?? 'Belum ada',
            'keterangan' => $r['jumlah'].' berkas · total '.$r['total_ukuran_teks'],
            'sehat' => $r['sehat'],
        ];
    }

    /**
     * @return array{kunci: string, label: string, nilai: string, keterangan: string, sehat: bool|null}
     */
    private static function penyimpanan(): array
    {
        $path = storage_path('app');

        try {
            $bebas = disk_free_space($path);
            $total = disk_total_space($path);

            if ($bebas === false || $total === false || $total == 0) {
                return [
                    'kunci' => 'penyimpanan',
                    'label' => 'Penyimpanan',
                    'nilai' => 'Tidak diketahui',
                    'keterangan' => 'Tidak bisa membaca kapasitas disk.',
                    'sehat' => null,
                ];
            }

            $persenPakai = ($total - $bebas) / $total * 100;
            $sehat = $persenPakai < 90;

            return [
                'kunci' => 'penyimpanan',
                'label' => 'Penyimpanan',
                'nilai' => StatusBackup::formatUkuran((int) $bebas).' bebas',
                'keterangan' => round($persenPakai, 1).'% terpakai dari '.StatusBackup::formatUkuran((int) $total),
                'sehat' => $sehat,
            ];
        } catch (\Throwable $e) {
            return [
                'kunci' => 'penyimpanan',
                'label' => 'Penyimpanan',
                'nilai' => 'Tidak diketahui',
                'keterangan' => $e->getMessage(),
                'sehat' => null,
            ];
        }
    }

    /**
     * @return array{kunci: string, label: string, nilai: string, keterangan: string, sehat: bool|null}
     */
    private static function versiAplikasi(): array
    {
        return [
            'kunci' => 'aplikasi',
            'label' => 'Versi Aplikasi',
            'nilai' => 'PHP '.PHP_VERSION,
            'keterangan' => 'Laravel '.app()->version().' · '.config('app.env'),
            'sehat' => true,
        ];
    }
}
