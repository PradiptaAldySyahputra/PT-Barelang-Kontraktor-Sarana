<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Pages\StatusSistemPage;
use App\Models\Pengguna;
use App\Support\StatusSistem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * HALAMAN STATUS SISTEM (B2-10).
 *
 * ⚠️ KENAPA DIUJI:
 * Halaman pemantauan kesehatan. Test mengunci: helper mengembalikan struktur
 * yang benar, halaman bisa dibuka Admin, dan Direktur ditolak.
 */
class StatusSistemTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    public function test_helper_mengembalikan_lima_pengecekan(): void
    {
        $status = StatusSistem::semua();

        $this->assertCount(5, $status);

        $kunci = array_column($status, 'kunci');
        foreach (['database', 'queue', 'backup', 'penyimpanan', 'aplikasi'] as $k) {
            $this->assertContains($k, $kunci);
        }

        foreach ($status as $s) {
            $this->assertArrayHasKey('label', $s);
            $this->assertArrayHasKey('nilai', $s);
            $this->assertArrayHasKey('keterangan', $s);
            $this->assertArrayHasKey('sehat', $s);
        }
    }

    public function test_database_dilaporkan_terhubung(): void
    {
        $db = collect(StatusSistem::semua())->firstWhere('kunci', 'database');

        $this->assertTrue($db['sehat']);
        $this->assertSame('Terhubung', $db['nilai']);
    }

    public function test_admin_bisa_membuka_halaman(): void
    {
        $this->actingAs($this->admin());

        Livewire::test(StatusSistemPage::class)
            ->assertOk()
            ->assertSee('Kesehatan Sistem')
            ->assertSee('Database');
    }

    public function test_direktur_tidak_bisa_membuka_halaman(): void
    {
        $direktur = Pengguna::factory()->create(['peran' => Peran::Direktur]);
        $this->actingAs($direktur);

        $this->assertFalse(StatusSistemPage::canAccess());
    }
}
