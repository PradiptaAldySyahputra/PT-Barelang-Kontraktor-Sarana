<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Exports\SpkExporter;
use App\Models\Pengguna;
use App\Models\Spk;
use Filament\Actions\Exports\Jobs\ExportCompletion;
use Filament\Actions\Exports\Models\Export;
use Filament\Notifications\DatabaseNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

/**
 * EKSPOR SPK END-TO-END + NOTIFIKASI (B1-3).
 *
 * ⚠️ KENAPA DIUJI KHUSUS:
 * "BUG-03": di repo lama ekspor yang selesai GAGAL memberi notifikasi karena
 * tabel `notifications` tidak ada. Akibatnya admin tidak tahu file siap
 * diunduh. Test ini mengunci rantai lengkapnya:
 *   - ada record `exports` untuk user yang benar;
 *   - job `ExportCompletion` benar-benar mengirim notifikasi DATABASE
 *     (bukan hanya notifikasi live yang hilang saat halaman ditutup);
 *   - notifikasi tersimpan di tabel `notifications` milik user.
 */
class EksporSpkEndToEndTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    public function test_record_export_terhubung_ke_pengguna_yang_benar(): void
    {
        $admin = $this->admin();

        $export = Export::create([
            'completed_at' => now(),
            'file_disk' => 'local',
            'file_name' => 'spk.xlsx',
            'exporter' => SpkExporter::class,
            'processed_rows' => 1,
            'total_rows' => 1,
            'successful_rows' => 1,
            'user_id' => $admin->id,
        ]);

        // Relasi user harus menunjuk model Pengguna (bukan App\Models\User).
        $this->assertInstanceOf(Pengguna::class, $export->user);
        $this->assertSame($admin->id, $export->user->id);
    }

    public function test_export_completion_menjadwalkan_notifikasi_database(): void
    {
        Queue::fake();

        // ⚠️ Produksi memakai QUEUE_CONNECTION=database (lihat .env.example).
        // Pada mode itu, ExportCompletion mengirim notifikasi DATABASE lewat
        // antrean (Filament DatabaseNotification = ShouldQueue). Tes ini
        // mengunci bahwa notifikasi BENAR-BENAR diantrekan ke user — bukan
        // hanya notifikasi live yang hilang saat halaman ditutup.
        config(['queue.default' => 'database']);

        $admin = $this->admin();

        $export = Export::create([
            'completed_at' => null,
            'file_disk' => 'local',
            'file_name' => 'spk.xlsx',
            'exporter' => SpkExporter::class,
            'processed_rows' => 1,
            'total_rows' => 1,
            'successful_rows' => 1,
            'user_id' => $admin->id,
        ]);

        (new ExportCompletion($export, ['nomor_spk' => 'Nomor SPK'], [], [], 'web'))->handle();

        // Notifikasi database diantrekan (butuh queue worker — memang jalan di produksi).
        Queue::assertPushed(SendQueuedNotifications::class, function ($job) use ($admin): bool {
            return $job->notifiables->contains(fn ($n): bool => $n->is($admin));
        });

        // completed_at diisi (bukti job selesai).
        $this->assertNotNull($export->fresh()->completed_at);
    }

    /**
     * ⚠️ Notifikasi database (Filament) = ShouldQueue. Saat antrean benar-benar
     * diproses (queue worker produksi), notifikasi TERSIMPAN di tabel.
     * Dijalankan dengan driver `sync` agar langsung diproses dalam tes.
     */
    public function test_notifikasi_database_tersimpan_setelah_antrean_diproses(): void
    {
        $admin = $this->admin();

        // Driver sync -> SendQueuedNotifications dijalankan langsung.
        config(['queue.default' => 'sync']);

        $admin->notify(new DatabaseNotification([
            'title' => 'Ekspor SPK selesai',
            'body' => 'File siap diunduh',
        ]));

        $this->assertSame(1, $admin->fresh()->notifications()->count());
        $this->assertSame('Ekspor SPK selesai', $admin->fresh()->notifications()->first()->data['title']);
    }
}
