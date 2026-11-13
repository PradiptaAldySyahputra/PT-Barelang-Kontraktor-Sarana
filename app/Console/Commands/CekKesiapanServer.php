<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

/**
 * Perintah Artisan Diagnosa Kesiapan Server Intranet BKS.
 *
 * Memeriksa kesiapan PC server kantor (Database, Penyimpanan, Antrean, dan Lingkungan PHP)
 * sebelum dijalankan secara operasional penuh.
 */
class CekKesiapanServer extends Command
{
    protected $signature = 'bks:cek-server
                            {--json : Keluarkan hasil dalam format JSON}';

    protected $description = 'Periksa diagnosa kesiapan PC server kantor sebelum operasional penuh';

    /**
     * @var list<array{kategori: string, komponen: string, status: string, detail: string, kritis: bool}>
     */
    protected array $hasilDiagnosa = [];

    public function handle(): int
    {
        $this->hasilDiagnosa = [];

        $this->cekDatabase();
        $this->cekPenyimpanan();
        $this->cekQueue();
        $this->cekLingkunganPhp();
        $this->cekOptimasi();

        $adaKegagalanKritis = collect($this->hasilDiagnosa)->contains(
            fn (array $item) => $item['status'] === 'GAGAL' && $item['kritis']
        );

        if ($this->option('json')) {
            $this->outputJson($adaKegagalanKritis);

            return $adaKegagalanKritis ? self::FAILURE : self::SUCCESS;
        }

        $this->outputTabelAscii($adaKegagalanKritis);

        return $adaKegagalanKritis ? self::FAILURE : self::SUCCESS;
    }

    protected function cekDatabase(): void
    {
        $koneksi = config('database.default', 'mysql');

        try {
            $pdo = DB::connection()->getPdo();
            $versiDb = $pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);
            $namaDb = (string) config("database.connections.{$koneksi}.database");

            $this->catat(
                'Database',
                'Koneksi Database',
                'OK',
                "Terhubung ke {$koneksi} [{$namaDb}] v{$versiDb}",
                kritis: true
            );
        } catch (\Throwable $e) {
            $this->catat(
                'Database',
                'Koneksi Database',
                'GAGAL',
                'Koneksi gagal: '.$e->getMessage(),
                kritis: true
            );

            // Jika koneksi gagal, tabel pasti tidak dapat dicek
            $this->catat(
                'Database',
                'Tabel Domain Utama',
                'GAGAL',
                'Tidak dapat mengecek tabel karena koneksi database gagal',
                kritis: true
            );

            return;
        }

        $tabelWajib = ['spk', 'uang_masuk', 'uang_keluar', 'mitra', 'pengguna'];
        $tabelHilang = [];

        foreach ($tabelWajib as $tabel) {
            if (! Schema::hasTable($tabel)) {
                $tabelHilang[] = $tabel;
            }
        }

        if (empty($tabelHilang)) {
            $this->catat(
                'Database',
                'Tabel Domain Utama',
                'OK',
                'Semua 5 tabel domain (spk, uang_masuk, uang_keluar, mitra, pengguna) lengkap',
                kritis: true
            );
        } else {
            $this->catat(
                'Database',
                'Tabel Domain Utama',
                'GAGAL',
                'Tabel domain tidak ditemukan: '.implode(', ', $tabelHilang),
                kritis: true
            );
        }
    }

    protected function cekPenyimpanan(): void
    {
        $pathNota = (string) (config('filesystems.disks.nota.root') ?: storage_path('app/nota'));
        $pathBackup = (string) (config('filesystems.backup_path') ?: storage_path('app/backup'));

        $this->cekDirektoriWritable(
            'Direktori Nota',
            $pathNota,
            'storage/app/nota',
            kritis: true
        );

        $this->cekDirektoriWritable(
            'Direktori Backup',
            $pathBackup,
            'storage/app/backup',
            kritis: true
        );

        $this->cekSymlinkStorage();
    }

    protected function cekDirektoriWritable(string $nama, string $path, string $labelRelatif, bool $kritis): void
    {
        if (! File::isDirectory($path)) {
            $this->catat(
                'Penyimpanan',
                $nama,
                'GAGAL',
                "Direktori {$labelRelatif} tidak ditemukan",
                kritis: $kritis
            );

            return;
        }

        if (! is_writable($path)) {
            $this->catat(
                'Penyimpanan',
                $nama,
                'GAGAL',
                "Direktori {$labelRelatif} tidak dapat ditulisi (non-writable)",
                kritis: $kritis
            );

            return;
        }

        $this->catat(
            'Penyimpanan',
            $nama,
            'OK',
            "Direktori {$labelRelatif} ada dan memiliki izin tulis (writable)",
            kritis: $kritis
        );
    }

    protected function cekSymlinkStorage(): void
    {
        $publicStorage = public_path('storage');

        if (! file_exists($publicStorage)) {
            $this->catat(
                'Penyimpanan',
                'Symlink Storage',
                'GAGAL',
                'Symlink public/storage tidak ditemukan (jalankan php artisan storage:link)',
                kritis: true
            );

            return;
        }

        if (! is_link($publicStorage)) {
            $this->catat(
                'Penyimpanan',
                'Symlink Storage',
                'PERINGATAN',
                'public/storage ada tetapi bukan symbolic link',
                kritis: false
            );

            return;
        }

        $target = @readlink($publicStorage);
        $targetAsli = storage_path('app/public');

        if ($target === false || (realpath($publicStorage) !== realpath($targetAsli))) {
            $this->catat(
                'Penyimpanan',
                'Symlink Storage',
                'GAGAL',
                'Symlink public/storage rusak atau menunjuk ke path yang salah',
                kritis: true
            );

            return;
        }

        $this->catat(
            'Penyimpanan',
            'Symlink Storage',
            'OK',
            'Symlink public/storage terhubung ke storage/app/public dengan benar',
            kritis: true
        );
    }

    protected function cekQueue(): void
    {
        try {
            $adaTabelJobs = Schema::hasTable('jobs');
            $adaTabelFailedJobs = Schema::hasTable('failed_jobs');

            if (! $adaTabelJobs || ! $adaTabelFailedJobs) {
                $hilang = [];
                if (! $adaTabelJobs) {
                    $hilang[] = 'jobs';
                }
                if (! $adaTabelFailedJobs) {
                    $hilang[] = 'failed_jobs';
                }

                $this->catat(
                    'Antrean (Queue)',
                    'Tabel Antrean',
                    'GAGAL',
                    'Tabel queue tidak ditemukan: '.implode(', ', $hilang),
                    kritis: true
                );

                return;
            }

            $this->catat(
                'Antrean (Queue)',
                'Tabel Antrean',
                'OK',
                'Tabel jobs dan failed_jobs dapat diakses',
                kritis: true
            );

            $pending = DB::table('jobs')->count();
            $failed = DB::table('failed_jobs')->count();

            if ($failed > 0) {
                $this->catat(
                    'Antrean (Queue)',
                    'Status Antrean',
                    'PERINGATAN',
                    "{$pending} job pending, {$failed} job GAGAL (periksa failed_jobs)",
                    kritis: false
                );
            } else {
                $this->catat(
                    'Antrean (Queue)',
                    'Status Antrean',
                    'OK',
                    "{$pending} job pending, 0 job gagal",
                    kritis: false
                );
            }
        } catch (\Throwable $e) {
            $this->catat(
                'Antrean (Queue)',
                'Koneksi Antrean',
                'GAGAL',
                'Gagal memeriksa antrean database: '.$e->getMessage(),
                kritis: true
            );
        }
    }

    protected function cekLingkunganPhp(): void
    {
        // 1. Ekstensi PHP
        $ekstensiWajib = ['pdo_mysql', 'zip', 'mbstring'];
        foreach ($ekstensiWajib as $ext) {
            $terpasang = extension_loaded($ext);
            $this->catat(
                'Lingkungan PHP',
                "Ekstensi {$ext}",
                $terpasang ? 'OK' : 'GAGAL',
                $terpasang ? "Ekstensi {$ext} aktif" : "Ekstensi {$ext} belum terpasang",
                kritis: true
            );
        }

        // Cek gd atau imagick
        $gd = extension_loaded('gd');
        $imagick = extension_loaded('imagick');
        if ($gd || $imagick) {
            $aktif = $gd && $imagick ? 'gd & imagick' : ($gd ? 'gd' : 'imagick');
            $this->catat(
                'Lingkungan PHP',
                'Ekstensi Grafis (gd/imagick)',
                'OK',
                "Ekstensi manipulasi grafis aktif ({$aktif})",
                kritis: true
            );
        } else {
            $this->catat(
                'Lingkungan PHP',
                'Ekstensi Grafis (gd/imagick)',
                'GAGAL',
                'Tidak ada ekstensi gd maupun imagick yang terpasang',
                kritis: true
            );
        }

        // 2. Versi PHP >= 8.2
        $versi = PHP_VERSION;
        $versiOk = version_compare($versi, '8.2.0', '>=');
        $this->catat(
            'Lingkungan PHP',
            'Versi PHP',
            $versiOk ? 'OK' : 'GAGAL',
            "PHP v{$versi}".($versiOk ? ' (memenuhi syarat >= 8.2)' : ' (di bawah rekomendasi minimum 8.2)'),
            kritis: true
        );

        // 3. Memory Limit (rekomendasi >= 256M)
        $memoryLimit = (string) ini_get('memory_limit');
        $bytes = $this->parseBytes($memoryLimit);
        $minBytes = 256 * 1024 * 1024; // 256 MB

        // -1 berarti unlimited
        $isMemoryOk = ($bytes === -1) || ($bytes >= $minBytes);

        $this->catat(
            'Lingkungan PHP',
            'Batas Memori (memory_limit)',
            $isMemoryOk ? 'OK' : 'PERINGATAN',
            "memory_limit: {$memoryLimit}".($isMemoryOk ? ' (cukup untuk ekspor/OCR)' : ' (rekomendasi >= 256M)'),
            kritis: false
        );
    }

    /**
     * Audit 12 Nov 2026 (D-2): pemeriksaan sebelumnya hanya melihat PHP,
     * database, dan antrean. Server bisa "lulus" padahal berjalan tanpa
     * OPcache dan tanpa cache produksi, atau memakai APP_ENV=local.
     */
    protected function cekOptimasi(): void
    {
        $produksi = app()->environment('production');
        $env = (string) config('app.env');

        $this->catat(
            'Optimasi & Produksi',
            'Mode Aplikasi (APP_ENV)',
            $produksi ? 'OK' : 'PERINGATAN',
            "APP_ENV={$env}".($produksi ? '' : ' (belum production - jangan dipakai untuk go-live)'),
            kritis: false
        );

        // OPcache: di CLI, nilai opcache.enable milik FPM tidak terbaca.
        // Karena itu statusnya informatif, bukan gerbang kritis.
        $opcacheAda = extension_loaded('Zend OPcache');
        $opcacheAktif = (bool) ini_get('opcache.enable');
        $this->catat(
            'Optimasi & Produksi',
            'OPcache',
            $opcacheAda ? 'OK' : 'PERINGATAN',
            $opcacheAda
                ? 'Ekstensi OPcache terpasang; opcache.enable='.($opcacheAktif ? '1' : '0').' (pastikan aktif di php.ini FPM)'
                : 'Ekstensi OPcache tidak terpasang - halaman akan lebih lambat',
            kritis: false
        );

        // Cache produksi
        $cacheKonfig = is_file(base_path('bootstrap/cache/config.php'));
        $cacheRute = count(glob(base_path('bootstrap/cache/routes-*.php')) ?: []) > 0;
        $cacheView = count(glob(storage_path('framework/views/*.php')) ?: []) > 0;

        $this->catat(
            'Optimasi & Produksi',
            'Cache Konfigurasi & Rute',
            ($cacheKonfig && $cacheRute) ? 'OK' : 'PERINGATAN',
            'config:'.($cacheKonfig ? 'ada' : 'belum').', rute:'.($cacheRute ? 'ada' : 'belum').', view:'.($cacheView ? 'ada' : 'belum')
                .' (jalankan php artisan optimize setelah deploy)',
            kritis: false
        );

        // Backup harus di HDD data, bukan SSD sistem (temuan D-1).
        $lokasi = (string) config('filesystems.backup_path');
        if (blank($lokasi)) {
            $this->catat(
                'Optimasi & Produksi',
                'Lokasi Backup Data',
                $produksi ? 'GAGAL' : 'PERINGATAN',
                'STORAGE_BACKUP_PATH belum diset - backup menumpuk di SSD sistem',
                kritis: $produksi
            );

            return;
        }

        $ada = is_dir($lokasi);
        $bisaTulis = $ada && is_writable($lokasi);

        $this->catat(
            'Optimasi & Produksi',
            'Lokasi Backup Data',
            $bisaTulis ? 'OK' : 'GAGAL',
            $ada
                ? "{$lokasi}".($bisaTulis ? ' (bisa ditulis)' : ' (TIDAK bisa ditulis)')
                : "{$lokasi} tidak ada - buat direktori lalu beri izin tulis",
            kritis: true
        );
    }

    protected function parseBytes(string $val): int
    {
        $val = trim($val);
        if ($val === '-1') {
            return -1;
        }

        $last = strtolower($val[strlen($val) - 1] ?? '');
        $num = (int) $val;

        return match ($last) {
            'g' => $num * 1024 * 1024 * 1024,
            'm' => $num * 1024 * 1024,
            'k' => $num * 1024,
            default => (int) $val,
        };
    }

    protected function catat(string $kategori, string $komponen, string $status, string $detail, bool $kritis): void
    {
        $this->hasilDiagnosa[] = [
            'kategori' => $kategori,
            'komponen' => $komponen,
            'status' => $status,
            'detail' => $detail,
            'kritis' => $kritis,
        ];
    }

    protected function outputJson(bool $adaKegagalanKritis): void
    {
        $output = [
            'waktu' => now()->toIso8601String(),
            'siap_operasional' => ! $adaKegagalanKritis,
            'kesimpulan' => ! $adaKegagalanKritis ? 'SERVER SIAP OPERASIONAL' : 'TERDAPAT KEGAGALAN KRITIS PADA SERVER',
            'hasil' => $this->hasilDiagnosa,
        ];

        $this->line(json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    protected function outputTabelAscii(bool $adaKegagalanKritis): void
    {
        $this->newLine();
        $this->info('======================================================================');
        $this->info('          DIAGNOSA KESIAPAN SERVER INTRANET BKS (bks:cek-server)       ');
        $this->info('======================================================================');

        $barisTabel = array_map(function (array $item) {
            $statusFormatted = match ($item['status']) {
                'OK' => '<fg=green;options=bold>OK</>',
                'PERINGATAN' => '<fg=yellow;options=bold>PERINGATAN</>',
                'GAGAL' => '<fg=red;options=bold>GAGAL</>',
                default => $item['status'],
            };

            return [
                $item['kategori'],
                $item['komponen'],
                $statusFormatted,
                $item['detail'],
            ];
        }, $this->hasilDiagnosa);

        $this->table(
            ['Kategori', 'Komponen', 'Status', 'Detail'],
            $barisTabel
        );

        $this->newLine();

        if (! $adaKegagalanKritis) {
            $this->info('======================================================================');
            $this->info('  KESIMPULAN: SERVER SIAP OPERASIONAL ✅                              ');
            $this->info('  Seluruh pemeriksaan kritis terpenuhi dengan baik.                   ');
            $this->info('======================================================================');
        } else {
            $this->error('======================================================================');
            $this->error('  KESIMPULAN: SERVER BELUM SIAP OPERASIONAL ❌                         ');
            $this->error('  Ditemukan kegagalan kritis yang wajib diperbaiki sebelum online:    ');
            $this->error('======================================================================');

            foreach ($this->hasilDiagnosa as $item) {
                if ($item['status'] === 'GAGAL' && $item['kritis']) {
                    $this->line(" - <fg=red>[{$item['kategori']}] {$item['komponen']}:</> {$item['detail']}");
                }
            }
        }
        $this->newLine();
    }
}
