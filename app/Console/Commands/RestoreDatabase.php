<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Support\StatusBackup;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

/**
 * RESTORE DATABASE DARI BERKAS BACKUP.
 *
 * Mengembalikan database MySQL/MariaDB dari berkas .zip atau .sql hasil backup.
 */
class RestoreDatabase extends Command
{
    protected $signature = 'bks:restore {berkas? : Nama file backup (mis. bks-2026-11-01-120000.zip)} {--force : Lewati konfirmasi interaktif}';

    protected $description = 'Restore database MySQL/MariaDB dari berkas cadangan .zip atau .sql';

    public function handle(): int
    {
        $nama = $this->argument('berkas');

        if (blank($nama)) {
            $daftar = StatusBackup::daftar();
            if (empty($daftar)) {
                $this->error('Tidak ada berkas backup di folder penyimpanan.');

                return self::FAILURE;
            }

            $nama = $this->choice(
                'Pilih berkas backup yang ingin dipulihkan:',
                array_column($daftar, 'nama'),
                0
            );
        }

        $path = StatusBackup::pathAman((string) $nama);

        if ($path === null || ! is_file($path)) {
            $this->error('Berkas backup tidak ditemukan atau path tidak sah: '.$nama);

            return self::FAILURE;
        }

        if (! $this->option('force') && ! $this->confirm('PERINGATAN: Memulihkan database akan MENIMPA seluruh data saat ini dengan data backup. Lanjutkan?')) {
            $this->info('Pemulihan database dibatalkan.');

            return self::SUCCESS;
        }

        $this->info('Mempersiapkan pemulihan dari: '.basename($path));

        // Ekstrak file .sql bila file adalah .zip
        $sqlPath = $path;
        $tempSql = null;

        if (str_ends_with(strtolower($path), '.zip')) {
            $zip = new \ZipArchive;
            if ($zip->open($path) !== true) {
                $this->error('Gagal membuka berkas ZIP backup.');

                return self::FAILURE;
            }

            $sqlNamaDiZip = null;
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                if (str_ends_with(strtolower($filename), '.sql')) {
                    $sqlNamaDiZip = $filename;
                    break;
                }
            }

            if ($sqlNamaDiZip === null) {
                $zip->close();
                $this->error('Tidak ditemukan berkas .sql di dalam file ZIP backup.');

                return self::FAILURE;
            }

            $sqlKontenMentah = $zip->getFromName($sqlNamaDiZip);
            $zip->close();

            if ($sqlKontenMentah === false) {
                $this->error('Gagal membaca berkas .sql dari dalam file ZIP backup.');

                return self::FAILURE;
            }

            $sqlContent = $sqlKontenMentah;
        } else {
            $sqlContent = File::get($sqlPath);
        }

        $perintah = [
            'mysql',
            '--host='.config('database.connections.mysql.host'),
            '--port='.config('database.connections.mysql.port'),
            '--user='.config('database.connections.mysql.username'),
            config('database.connections.mysql.database'),
        ];

        $env = [];
        $password = config('database.connections.mysql.password');
        if (filled($password)) {
            $env['MYSQL_PWD'] = $password;
        }

        $hasil = Process::timeout(600)
            ->env($env)
            ->input($sqlContent)
            ->run($perintah);

        if ($tempSql !== null) {
            File::deleteDirectory($tempSql);
        }

        if (! $hasil->successful()) {
            $this->error('Restore GAGAL: '.trim($hasil->errorOutput()));

            return self::FAILURE;
        }

        $this->info('Restore BERHASIL: Database telah dipulihkan dari '.basename($path));

        return self::SUCCESS;
    }
}
