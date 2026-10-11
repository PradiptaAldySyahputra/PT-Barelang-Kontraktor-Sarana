<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Pages\ImporDataPage;
use App\Models\Pengguna;
use App\Models\UangMasuk;
use App\Support\PembacaImpor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * HALAMAN & PEMBACA IMPOR (B3-13).
 *
 * ⚠️ KENAPA DIUJI:
 * Halaman impor mengubah data keuangan massal → harus dibatasi Admin, membaca
 * CSV dengan header yang benar, dan memproses lewat service yang append-only.
 */
class ImporDataPageTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    private function direktur(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Direktur]);
    }

    public function test_halaman_hanya_untuk_admin(): void
    {
        $this->actingAs($this->direktur());
        $this->assertFalse(ImporDataPage::canAccess(), 'Direktur tidak boleh mengimpor.');

        $this->actingAs($this->admin());
        $this->assertTrue(ImporDataPage::canAccess(), 'Admin boleh mengimpor.');
    }

    public function test_halaman_bisa_dibuka_admin(): void
    {
        $this->actingAs($this->admin());

        Livewire::test(ImporDataPage::class)
            ->assertOk()
            ->assertSee('Impor Data')
            ->assertSee('Mulai Impor');
    }

    public function test_pembaca_csv_memakai_header_sebagai_kunci(): void
    {
        Storage::fake('local');

        $csv = "tanggal,jumlah,akun,keterangan\n"
            ."2026-01-05,1500000,Kas,Setoran awal\n"
            ."2026-01-06,2500000,Bank,Transfer\n";

        $path = Storage::disk('local')->path('impor/uji.csv');
        @mkdir(dirname($path), 0777, true);
        file_put_contents($path, $csv);

        $baris = PembacaImpor::baca($path);

        $this->assertCount(2, $baris);
        $this->assertSame('2026-01-05', $baris[0]['tanggal']);
        $this->assertSame('1500000', $baris[0]['jumlah']);
        $this->assertSame('Kas', $baris[0]['akun']);
        $this->assertSame('Setoran awal', $baris[0]['keterangan']);
    }

    public function test_proses_impor_menambah_data(): void
    {
        Storage::fake('local');

        $csv = "tanggal,jumlah,akun,keterangan\n"
            ."2026-02-01,1000000,Kas,Impor A\n";

        $path = Storage::disk('local')->path('impor/data.csv');
        @mkdir(dirname($path), 0777, true);
        file_put_contents($path, $csv);

        $this->actingAs($this->admin());

        Livewire::test(ImporDataPage::class)
            ->fillForm(['jenis' => 'masuk', 'berkas' => 'impor/data.csv'])
            ->call('proses')
            ->assertOk();

        $this->assertSame(1, UangMasuk::count());
        $this->assertSame('1000000.00', UangMasuk::first()->jumlah);
    }
}
