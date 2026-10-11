<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Pages\BackupRestore;
use App\Models\Pengguna;
use App\Support\StatusBackup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * HALAMAN BACKUP & RESTORE (B1-4) + helper StatusBackup.
 *
 * ⚠️ KENAPA DIUJI:
 * Backup kritikal (data keuangan perusahaan). Temuan audit: backup terjadwal
 * tidak pernah menghasilkan berkas dan tidak terpantau. Test ini mengunci:
 *   - helper membaca folder backup dengan benar;
 *   - halaman hanya bisa diakses Admin (Direktur ditolak);
 *   - unduh berkas dilindungi (Admin saja) & menolak path traversal.
 */
class BackupRestoreTest extends TestCase
{
    use RefreshDatabase;

    private string $dir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dir = storage_path('app/backup');

        if (! File::isDirectory($this->dir)) {
            File::makeDirectory($this->dir, 0755, true);
        }
    }

    protected function tearDown(): void
    {
        // Bersihkan berkas uji.
        foreach (glob($this->dir.'/uji-*.gz') ?: [] as $f) {
            @unlink($f);
        }

        parent::tearDown();
    }

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    public function test_ringkasan_kosong_saat_belum_ada_backup(): void
    {
        // Pastikan tidak ada berkas.
        foreach (glob($this->dir.'/*.gz') ?: [] as $f) {
            @unlink($f);
        }

        $r = StatusBackup::ringkasan();

        $this->assertSame(0, $r['jumlah']);
        $this->assertFalse($r['sehat']);
        $this->assertNull($r['terakhir']);
    }

    public function test_ringkasan_membaca_berkas_backup(): void
    {
        File::put($this->dir.'/uji-2026-10-11.sql.gz', gzencode('SELECT 1;', 9));

        $r = StatusBackup::ringkasan();

        $this->assertSame(1, $r['jumlah']);
        $this->assertGreaterThan(0, $r['total_ukuran']);
        $this->assertTrue($r['sehat']); // baru saja dibuat
        $this->assertNotNull($r['terakhir']);
    }

    public function test_path_aman_menolak_traversal(): void
    {
        $this->assertNull(StatusBackup::pathAman('../../.env'));
        $this->assertNull(StatusBackup::pathAman('/etc/passwd'));
        $this->assertNull(StatusBackup::pathAman('tidak-ada.gz'));
    }

    public function test_path_aman_mengembalikan_berkas_yang_ada(): void
    {
        File::put($this->dir.'/uji-ada.sql.gz', gzencode('x', 9));

        $path = StatusBackup::pathAman('uji-ada.sql.gz');

        $this->assertNotNull($path);
        $this->assertTrue(is_file($path));
    }

    public function test_admin_bisa_membuka_halaman(): void
    {
        $this->actingAs($this->admin());

        Livewire::test(BackupRestore::class)
            ->assertOk()
            ->assertSee('Status Backup');
    }

    public function test_direktur_tidak_bisa_membuka_halaman(): void
    {
        $direktur = Pengguna::factory()->create(['peran' => Peran::Direktur]);
        $this->actingAs($direktur);

        $this->assertFalse(BackupRestore::canAccess());
    }

    public function test_admin_bisa_unduh_berkas_backup(): void
    {
        File::put($this->dir.'/uji-unduh.sql.gz', gzencode('SELECT 1;', 9));

        $this->actingAs($this->admin())
            ->get(route('backup.unduh', ['nama' => 'uji-unduh.sql.gz']))
            ->assertOk()
            ->assertDownload('uji-unduh.sql.gz');
    }

    public function test_direktur_tidak_bisa_unduh_backup(): void
    {
        File::put($this->dir.'/uji-rahasia.sql.gz', gzencode('SELECT 1;', 9));

        $direktur = Pengguna::factory()->create(['peran' => Peran::Direktur]);

        $this->actingAs($direktur)
            ->get(route('backup.unduh', ['nama' => 'uji-rahasia.sql.gz']))
            ->assertForbidden();
    }
}
