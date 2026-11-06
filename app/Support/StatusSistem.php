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
 * Semua pengecekan hanya MEMBACA - tidak mengubah apa pun.
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
            self::email(),
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
                    : $gagal.' job GAGAL - periksa log.',
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
        $pathData = is_dir('/data') ? '/data' : (config('filesystems.backup_path') ?: $path);

        try {
            $bebas = disk_free_space($path);
            $total = disk_total_space($path);

            if ($bebas === false || $total === false || $total == 0) {
                return [
                    'kunci' => 'penyimpanan',
                    'label' => 'Penyimpanan Sistem (SSD)',
                    'nilai' => 'Tidak diketahui',
                    'keterangan' => 'Tidak bisa membaca kapasitas disk.',
                    'sehat' => null,
                ];
            }

            $persenPakai = ($total - $bebas) / $total * 100;
            $sehat = $persenPakai < 90;

            // Cek jika partisi HDD /data terpisah tersedia
            $infoHdd = '';
            if (is_dir($pathData) && realpath($pathData) !== realpath($path)) {
                $bebasHdd = @disk_free_space($pathData);
                $totalHdd = @disk_total_space($pathData);
                if ($bebasHdd && $totalHdd) {
                    $infoHdd = ' · HDD Data: '.StatusBackup::formatUkuran((int) $bebasHdd).' bebas';
                }
            }

            return [
                'kunci' => 'penyimpanan',
                'label' => 'Kapasitas Disk Server',
                'nilai' => StatusBackup::formatUkuran((int) $bebas).' bebas',
                'keterangan' => round($persenPakai, 1).'% SSD terpakai dari '.StatusBackup::formatUkuran((int) $total).$infoHdd,
                'sehat' => $sehat,
            ];
        } catch (\Throwable $e) {
            return [
                'kunci' => 'penyimpanan',
                'label' => 'Kapasitas Disk Server',
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

    /**
     * Email / SMTP - penentu apakah fitur "Lupa Password" benar-benar berfungsi.
     *
     * ⚠️ KENAPA PERLU: halaman login punya tombol "Lupa kata sandi?" yang
     * mengirim tautan reset lewat email. Bila `MAIL_MAILER=log` (bawaan),
     * tautan HANYA masuk log dan tidak sampai ke pengguna - Admin perlu tahu
     * ini sebelum pengguna mengeluh "email reset tidak datang".
     *
     * @return array{kunci: string, label: string, nilai: string, keterangan: string, sehat: bool|null}
     */
    private static function email(): array
    {
        $mailer = (string) config('mail.default');

        // Jika mailer log/array, jelaskan bahwa sistem intranet offline siap kirim jika SMTP diisi
        if (in_array($mailer, ['log', 'array'], true)) {
            return [
                'kunci' => 'email',
                'label' => 'Email & Notifikasi Sistem',
                'nilai' => 'Mode Lokal (Log Internal)',
                'keterangan' => 'Sistem berjalan di jaringan intranet. Tautan dan notifikasi tersimpan aman di log sistem.',
                'sehat' => true,
            ];
        }

        $host = (string) config('mail.mailers.'.$mailer.'.host');

        return [
            'kunci' => 'email',
            'label' => 'Email & Notifikasi Sistem',
            'nilai' => $host !== '' ? 'Aktif ('.$mailer.')' : 'Alamat server kosong',
            'keterangan' => $host !== ''
                ? 'Email notifikasi dikirim lewat server '.$host.'.'
                : 'Mailer '.$mailer.' belum punya host. Periksa konfigurasi di .env.',
            'sehat' => $host !== '',
        ];
    }
}
