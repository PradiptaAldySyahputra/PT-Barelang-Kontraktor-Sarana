<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

/**
 * Backup database harian.
 *
 * ⚠️ KENAPA INI PENTING:
 * Deployment lokal — PC Direktur adalah SERVER. Kalau hardisknya rusak,
 * seluruh data SPK & keuangan perusahaan HILANG. Backup bukan "nice to have".
 *
 * Hasil: storage/app/backup/bks-YYYY-MM-DD-HHMMSS.sql.gz
 * Retensi: backup lebih tua dari `--hari` (default 30) dihapus otomatis.
 */
class BackupDatabase extends Command
{
    protected $signature = 'bks:backup
                            {--hari=30 : Hapus backup lebih tua dari N hari}
                            {--simpan : Tetap simpan meski gagal (untuk uji)}';

    protected $description = 'Backup database MySQL/MariaDB ke file .sql.gz';

    public function handle(): int
    {
        $dir = storage_path('app/backup');

        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $nama = sprintf(
            '%s-%s.sql.gz',
            config('database.connections.mysql.database'),
            now()->format('Y-m-d-His')
        );

        $tujuan = $dir.DIRECTORY_SEPARATOR.$nama;

        $perintah = [
            'mysqldump',
            '--host='.config('database.connections.mysql.host'),
            '--port='.config('database.connections.mysql.port'),
            '--user='.config('database.connections.mysql.username'),
            '--single-transaction',
            '--routines',
            '--triggers',
            '--no-tablespaces',
            config('database.connections.mysql.database'),
        ];

        $env = [];
        $password = config('database.connections.mysql.password');

        if (filled($password)) {
            $env['MYSQL_PWD'] = $password;
        }

        /*
         * ⚠️ MEMAKAI FACADE `Process` (bukan `new Symfony\Process`) — agar bisa
         * diuji dengan `Process::fake()`. Sebelumnya perintah ini memakai
         * objek Symfony langsung sehingga `bks:backup` TIDAK BISA diuji tanpa
         * mysqldump nyata; akibatnya fitur kritikal ini nol tes (temuan survei
         * 10 Okt 2026). Dengan facade, tes `BackupDatabaseTest` memalsukan
         * hasil dump dan memverifikasi logika kita (berkas, retensi, --simpan).
         */
        $hasil = Process::timeout(600)
            ->env($env)
            ->run($perintah);

        if (! $hasil->successful()) {
            $this->error('Backup GAGAL: '.trim($hasil->errorOutput()));

            if (! $this->option('simpan')) {
                return self::FAILURE;
            }
        }

        $sql = $hasil->output();

        if (blank($sql) && ! $this->option('simpan')) {
            $this->error('Backup GAGAL: mysqldump tidak menghasilkan data. Pastikan `mysqldump` terpasang.');

            return self::FAILURE;
        }

        // Kompres dengan gzencode (tanpa butuh binary gzip)
        File::put($tujuan, gzencode($sql, 9));

        $ukuran = File::size($tujuan);

        $this->info(sprintf(
            'Backup OK: %s (%s)',
            $nama,
            $this->formatUkuran($ukuran)
        ));

        $this->bersihkanBackupLama($dir);

        return self::SUCCESS;
    }

    /**
     * Hapus backup yang lebih tua dari batas hari.
     */
    protected function bersihkanBackupLama(string $dir): void
    {
        $hari = (int) $this->option('hari');

        if ($hari <= 0) {
            return;
        }

        $batas = now()->subDays($hari)->getTimestamp();
        $terhapus = 0;

        foreach (File::files($dir) as $file) {
            if ($file->getExtension() === 'gz' && $file->getMTime() < $batas) {
                File::delete($file->getPathname());
                $terhapus++;
            }
        }

        if ($terhapus > 0) {
            $this->line("  {$terhapus} backup lama dihapus (> {$hari} hari).");
        }
    }

    protected function formatUkuran(int $bytes): string
    {
        return match (true) {
            $bytes >= 1048576 => round($bytes / 1048576, 2).' MB',
            $bytes >= 1024 => round($bytes / 1024, 2).' KB',
            default => $bytes.' B',
        };
    }
}
