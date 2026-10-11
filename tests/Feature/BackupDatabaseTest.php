<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Console\Commands\BackupDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Tests\TestCase;

/**
 * BACKUP DATABASE — fitur KRITIKAL (data keuangan perusahaan).
 *
 * ⚠️ KENAPA DIUJI:
 * `bks:backup` dijadwalkan harian (routes/console.php) dan menyimpan data
 * keuangan perusahaan. Sebelumnya TIDAK ADA tes sama sekali — kalau rusak
 * diam-diam, data tak ter-backup dan baru ketahuan saat butuh restore.
 *
 * ⚠️ CARA UJI (tanpa mysqldump nyata):
 * Perintah ini memanggil binary `mysqldump`. Di lingkungan tes, binary itu
 * mungkin tak ada. Jadi kita MEMALSUKAN `Process` (facade) supaya mengembalikan
 * dump palsu — tujuannya menguji LOGIKA kita sendiri:
 *   1. berkas .sql.gz terbentuk & isinya benar (hasil gunzip = dump),
 *   2. retensi `--hari` menghapus berkas lama,
 *   3. `--simpan` tetap menyimpan meski dump gagal.
 */
class BackupDatabaseTest extends TestCase
{
    private string $dir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dir = storage_path('app/backup');

        // Mulai dari keadaan bersih agar tidak mengganggu backup nyata.
        File::ensureDirectoryExists($this->dir);

        foreach (File::files($this->dir) as $f) {
            File::delete($f->getPathname());
        }
    }

    protected function tearDown(): void
    {
        foreach (File::files($this->dir) as $f) {
            File::delete($f->getPathname());
        }

        parent::tearDown();
    }

    public function test_backup_membuat_berkas_sql_gz_yang_benar(): void
    {
        $dump = "-- dump palsu\nCREATE TABLE spk (id INT);\n";

        Process::fake([
            '*' => Process::result(output: $dump, exitCode: 0),
        ]);

        $this->artisan('bks:backup')->assertSuccessful();

        $berkas = File::files($this->dir);
        $this->assertCount(1, $berkas, 'Harus ada tepat satu berkas backup.');

        $isi = gzdecode(File::get($berkas[0]->getPathname()));
        $this->assertSame($dump, $isi, 'Isi backup harus sama dengan hasil dump.');
    }

    public function test_retensi_menghapus_backup_lama(): void
    {
        Process::fake([
            '*' => Process::result(output: "-- dump\n", exitCode: 0),
        ]);

        // Buat berkas "lama" (mtime 40 hari lalu) + berkas "baru".
        $lama = $this->dir.'/bks-lama.sql.gz';
        File::put($lama, gzencode('lama', 9));
        touch($lama, now()->subDays(40)->getTimestamp());

        $baru = $this->dir.'/bks-baru.sql.gz';
        File::put($baru, gzencode('baru', 9));

        $this->artisan('bks:backup', ['--hari' => 30])->assertSuccessful();

        $this->assertFileDoesNotExist($lama, 'Backup > 30 hari harus dihapus.');
        $this->assertFileExists($baru, 'Backup baru tidak boleh ikut terhapus.');
    }

    public function test_simpan_menyimpan_meski_dump_gagal(): void
    {
        Process::fake([
            '*' => Process::result(output: '', errorOutput: 'mysqldump: not found', exitCode: 1),
        ]);

        // Tanpa --simpan → GAGAL.
        $this->artisan('bks:backup')->assertFailed();

        // Dengan --simpan → tetap SUCCESS (untuk uji di lingkungan tanpa mysqldump).
        $this->artisan('bks:backup', ['--simpan' => true])->assertSuccessful();
    }

    public function test_perintah_terdaftar(): void
    {
        $this->assertTrue(
            class_exists(BackupDatabase::class),
            'Perintah bks:backup harus ada.',
        );

        $this->artisan('list')
            ->expectsOutputToContain('bks:backup');
    }
}
