<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Filament\Resources\MonitoringSpk\Pages\ListTagihanSpk;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * BUG — "Catat Pembayaran" tetap bisa dipakai pada SPK DIBATALKAN.
 *
 * Rules.md §5 butir 3: SPK `Dibatalkan` TIDAK menerima transaksi baru.
 * Form Uang Masuk & Uang Keluar sudah dijaga (`SpkDibatalkanTidakTerimaTransaksiTest`),
 * TETAPI aksi `CatatPembayaran` membuat `UangMasuk::create()` LANGSUNG —
 * melewati validasi form. Akibatnya admin bisa mencatat pembayaran untuk
 * pekerjaan yang sudah batal → piutang/laporan pajak menyesatkan.
 */
class BugCatatPembayaranSpkDibatalkanTest extends TestCase
{
    use RefreshDatabase;

    public function test_catat_pembayaran_tidak_tersedia_untuk_spk_dibatalkan(): void
    {
        $admin = Pengguna::factory()->admin()->create(['email' => 'admin-catat-batal@bks.test']);
        $this->actingAs($admin);

        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'CATAT-BATAL-001',
            'nilai_spk' => 10_000_000,
            'status_spk' => StatusSpk::Dibatalkan,
            'status_tagihan' => StatusTagihan::MenungguPembayaran,
        ]);

        Livewire::test(ListTagihanSpk::class)
            ->mountAction(TestAction::make('view')->table($spk))
            ->assertActionHidden('catatPembayaran');
    }

    public function test_aksi_menolak_pembayaran_untuk_spk_dibatalkan(): void
    {
        $admin = Pengguna::factory()->admin()->create(['email' => 'admin-catat-batal2@bks.test']);
        $this->actingAs($admin);

        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'CATAT-BATAL-002',
            'nilai_spk' => 10_000_000,
            'status_spk' => StatusSpk::Dibatalkan,
            'status_tagihan' => StatusTagihan::MenungguPembayaran,
        ]);

        /*
         * Tombol sudah disembunyikan → Filament MENOLAK memanggilnya. Kita
         * pastikan percobaan panggilan itu tidak menghasilkan baris uang masuk
         * apa pun (penjaga dua lapis: `visible()` + guard di dalam action).
         */
        try {
            Livewire::test(ListTagihanSpk::class)
                ->mountAction(TestAction::make('view')->table($spk))
                ->callAction('catatPembayaran', data: [
                    'jumlah' => 1_000_000,
                    'tanggal' => now()->toDateString(),
                    'keterangan' => 'Percobaan bayar SPK batal',
                ]);
        } catch (\Throwable) {
            // Aksi tersembunyi tidak bisa dipanggil — memang diharapkan.
        }

        $this->assertSame(
            0,
            UangMasuk::where('spk_id', $spk->id)->count(),
            'Pembayaran TIDAK boleh tercatat untuk SPK Dibatalkan (Rules §5 butir 3).',
        );
    }
}
