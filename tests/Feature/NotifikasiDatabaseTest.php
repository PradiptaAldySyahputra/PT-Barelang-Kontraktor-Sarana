<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * TABEL `notifications` (B1-2) — prasyarat notifikasi unduhan ekspor.
 *
 * ⚠️ KENAPA DIUJI:
 * Di repo lama, tabel ini tidak ada sejak awal. Akibatnya ekspor yang selesai
 * di background gagal memberi notifikasi (job error). Test ini mengunci agar
 * tabel + kemampuan notifikasi database benar-benar tersedia.
 */
class NotifikasiDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_tabel_notifications_ada(): void
    {
        $this->assertTrue(
            Schema::hasTable('notifications'),
            'Tabel notifications wajib ada (B1-2)'
        );

        foreach (['id', 'type', 'notifiable_type', 'notifiable_id', 'data', 'read_at'] as $kolom) {
            $this->assertTrue(
                Schema::hasColumn('notifications', $kolom),
                "Kolom notifications.$kolom wajib ada"
            );
        }
    }

    public function test_pengguna_bisa_menerima_notifikasi_database(): void
    {
        $user = Pengguna::factory()->create(['peran' => Peran::Admin]);

        $user->notify(new class extends Notification
        {
            /** @return list<string> */
            public function via(object $notifiable): array
            {
                return ['database'];
            }

            /** @return array<string, mixed> */
            public function toArray(object $notifiable): array
            {
                return ['judul' => 'Ekspor selesai', 'pesan' => 'File siap diunduh'];
            }
        });

        $this->assertSame(1, $user->notifications()->count());
        $this->assertSame('Ekspor selesai', $user->notifications()->first()->data['judul']);
        $this->assertSame(1, $user->unreadNotifications()->count());
    }
}
