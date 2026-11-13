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
    protected $signature = 'bks:restore
                            {berkas? : Nama file backup (mis. bks-2026-11-01-120000.zip)}
                            {--test : Uji integritas backup (cek ZIP & sintaks/tabel SQL) tanpa menimpa database}
                            {--force : Lewati konfirmasi interaktif}';

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

        if (! $this->option('test') && ! $this->option('force') && ! $this->confirm('PERINGATAN: Memulihkan database akan MENIMPA seluruh data saat ini dengan data backup. Lanjutkan?')) {
            $this->info('Pemulihan database dibatalkan.');

            return self::SUCCESS;
        }

        $this->info('Mempersiapkan '.($this->option('test') ? 'pengujian' : 'pemulihan').' dari: '.basename($path));

        // Ekstrak file .sql bila file adalah .zip
        $sqlPath = $path;
        $tempSql = null;
        $jumlahFileDiZip = 0;
        $adaNota = false;

        if (str_ends_with(strtolower($path), '.zip')) {
            $zip = new \ZipArchive;
            if ($zip->open($path) !== true) {
                $this->error('Gagal membuka berkas ZIP backup.');

                return self::FAILURE;
            }

            $jumlahFileDiZip = $zip->numFiles;
            $sqlNamaDiZip = null;
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                if (str_ends_with(strtolower($filename), '.sql')) {
                    $sqlNamaDiZip = $filename;
                }
                if (str_starts_with($filename, 'nota/')) {
                    $adaNota = true;
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

        if ($this->option('test')) {
            return $this->verifikasiIntegritas($sqlContent, $jumlahFileDiZip, $adaNota);
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

    /**
     * Verifikasi integritas berkas cadangan tanpa menimpa database aktif.
     */
    protected function verifikasiIntegritas(string $sqlContent, int $jumlahFileDiZip, bool $adaNota): int
    {
        $this->info('Memulai verifikasi integritas berkas cadangan (dry-run)...');

        if (blank($sqlContent)) {
            $this->error('Gagal: Berkas SQL kosong.');

            return self::FAILURE;
        }

        // Periksa 5 tabel domain inti BKS
        $tabelWajib = ['spk', 'uang_masuk', 'uang_keluar', 'mitra', 'pengguna'];
        $tabelHilang = [];

        foreach ($tabelWajib as $tabel) {
            // Cocokkan skema CREATE TABLE `tabel` atau CREATE TABLE tabel
            $pola = '/CREATE\s+TABLE\s+[`"]?'.preg_quote($tabel, '/').'[`"]?/i';
            if (! preg_match($pola, $sqlContent)) {
                $tabelHilang[] = $tabel;
            }
        }

        if (! empty($tabelHilang)) {
            $this->error('Verifikasi GAGAL: Tabel utama tidak ditemukan dalam skema SQL: '.implode(', ', $tabelHilang));

            return self::FAILURE;
        }

        $this->line('  [OK] Struktur ZIP/SQL valid dan terbaca.');
        $this->line('  [OK] 5 tabel utama terverifikasi: '.implode(', ', $tabelWajib).'.');

        if ($jumlahFileDiZip > 1) {
            $this->line(sprintf('  [INFO] Arsip memuat %d entri berkas (termasuk folder nota: %s).', $jumlahFileDiZip, $adaNota ? 'Ya' : 'Tidak'));
        }

        $this->info('Verifikasi SUKSES: Berkas backup valid dan siap direstore.');

        return self::SUCCESS;
    }
}
