<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Filament\Resources\Spks\Pages\ListSpks;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * REGRESSION — aksi "Catat Pembayaran" (dari halaman SPK) HARUS menolak
 * pembayaran melebihi sisa tagihan, sama seperti form Uang Masuk.
 *
 * ⚠️ BUG (temuan 9 Okt 2026):
 * Form Uang Masuk sudah memvalidasi batas piutang, TAPI aksi Catat
 * Pembayaran tidak. Akibatnya pembayaran Rp 500 juta untuk SPK Rp 100 juta
 * lolos → piutang negatif & laporan rusak.
 *
 * Perbaikan: field `jumlah` di aksi kini memakai rule yang sama.
 */
class CatatPembayaranBatasTest extends TestCase
{
    use RefreshDatabase;

    private function spk(): Spk
    {
        return Spk::factory()->create([
            'nilai_spk' => 100_000_000,
            'status_spk' => StatusSpk::Berjalan->value,
            'status_tagihan' => StatusTagihan::BelumDitagihkan->value,
        ]);
    }

    public function test_menolak_pembayaran_melebihi_sisa_tagihan(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        $spk = $this->spk();

        Livewire::test(ListSpks::class)
            ->callAction(
                TestAction::make('catatPembayaran')->table($spk),
                data: [
                    'jumlah' => 500_000_000,
                    'tanggal' => now()->toDateString(),
                    'persen' => null,
                    'keterangan' => 'Coba overpay',
                ],
            )
            ->assertHasActionErrors(['jumlah']);

        $this->assertSame(
            0.0,
            (float) UangMasuk::where('spk_id', $spk->id)->sum('jumlah'),
            'Pembayaran melebihi sisa tagihan TIDAK boleh tersimpan.',
        );
    }

    public function test_menerima_pembayaran_dalam_batas(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        $spk = $this->spk();

        Livewire::test(ListSpks::class)
            ->callAction(
                TestAction::make('catatPembayaran')->table($spk),
                data: [
                    'jumlah' => 50_000_000,
                    'tanggal' => now()->toDateString(),
                    'persen' => null,
                    'keterangan' => 'DP 50%',
                ],
            )
            ->assertHasNoActionErrors();

        $this->assertSame(
            50_000_000.0,
            (float) UangMasuk::where('spk_id', $spk->id)->sum('jumlah'),
        );
    }
}
