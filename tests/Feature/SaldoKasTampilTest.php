<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Pages\Laporan;
use App\Filament\Widgets\RingkasanKeuangan;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * SALDO KAS/BANK MUNCUL DI DASHBOARD & LAPORAN — fitur T2.
 *
 * Memastikan angka saldo benar-benar ditampilkan, bukan hanya dihitung.
 */
class SaldoKasTampilTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    public function test_widget_dashboard_menampilkan_saldo_kas_dan_bank(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 4_000_000]);
        UangKeluar::factory()->create(['akun' => 'kas', 'jumlah' => 1_000_000]);
        UangMasuk::factory()->create(['akun' => 'bank', 'jumlah' => 20_000_000]);

        $this->actingAs($this->admin());

        Livewire::test(RingkasanKeuangan::class)
            ->assertOk()
            ->assertSee('Saldo Kas')
            ->assertSee('Saldo Bank')
            ->assertSee('Total Saldo')
            ->assertSee('Rp 3.000.000')   // saldo kas
            ->assertSee('Rp 20.000.000')  // saldo bank
            ->assertSee('Rp 23.000.000'); // total
    }

    public function test_halaman_laporan_menampilkan_saldo(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'jumlah' => 6_000_000]);
        UangMasuk::factory()->create(['akun' => 'bank', 'jumlah' => 9_000_000]);

        $this->actingAs($this->admin());

        Livewire::test(Laporan::class)
            ->assertOk()
            ->assertSee('Saldo Kas')
            ->assertSee('Saldo Bank')
            ->assertSee('Total Saldo')
            ->assertSee('Rp 15.000.000');
    }
}
