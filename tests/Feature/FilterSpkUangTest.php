<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Pages\ListUangKeluars;
use App\Filament\Resources\UangMasuks\Pages\ListUangMasuks;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * FILTER SPK di menu Uang Masuk & Uang Keluar.
 *
 * ⚠️ SUMBER ATURAN:
 *   PRD.md FR-IN-004  → "Filter & pencarian uang masuk per periode/SPK"
 *   PRD.md FR-OUT-004 → "Filter & pencarian uang keluar per periode/kategori/SPK"
 *
 * ⚠️ KENAPA PENTING:
 * Satu SPK bisa punya puluhan transaksi. Saat ada selisih atau bagian pajak
 * meminta rincian satu pekerjaan, admin harus bisa menyaring **hanya SPK itu**
 * — tanpa memilah manual di Excel. Tanpa filter ini, admin menyaring dengan
 * mata, dan itu sumber salah rekap.
 *
 * 📌 Saat ini kedua menu HANYA punya filter: periode, akun, mitra/kategori,
 *    data terhapus — **belum ada filter SPK**.
 */
class FilterSpkUangTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-filter-spk@bks.test',
        ]);

        $this->actingAs($this->admin);
    }

    /**
     * Filter harus bisa dipakai lewat query string `?tableFilters[spk_id][value]=…`
     * karena itu cara Filament menyimpan keadaan filter.
     */
    public function test_uang_masuk_bisa_disaring_per_spk(): void
    {
        $spkA = Spk::factory()->pln()->create(['nomor_spk' => 'FILTER-A']);
        $spkB = Spk::factory()->pln()->create(['nomor_spk' => 'FILTER-B']);

        UangMasuk::factory()->create([
            'spk_id' => $spkA->id,
            'tanggal' => '2026-08-01',
            'jumlah' => 1_000_000,
        ]);

        UangMasuk::factory()->create([
            'spk_id' => $spkB->id,
            'tanggal' => '2026-08-02',
            'jumlah' => 2_000_000,
        ]);

        Livewire::test(ListUangMasuks::class)
            ->filterTable('spk_id', $spkA->id)
            ->assertCanSeeTableRecords(UangMasuk::where('spk_id', $spkA->id)->get())
            ->assertCanNotSeeTableRecords(UangMasuk::where('spk_id', $spkB->id)->get());
    }

    public function test_uang_keluar_bisa_disaring_per_spk(): void
    {
        $spkA = Spk::factory()->pln()->create(['nomor_spk' => 'FILTER-C']);
        $spkB = Spk::factory()->pln()->create(['nomor_spk' => 'FILTER-D']);

        UangKeluar::factory()->create([
            'spk_id' => $spkA->id,
            'tanggal' => '2026-08-01',
            'jumlah' => 100_000,
            'kategori' => 'material',
        ]);

        UangKeluar::factory()->create([
            'spk_id' => $spkB->id,
            'tanggal' => '2026-08-02',
            'jumlah' => 200_000,
            'kategori' => 'material',
        ]);

        Livewire::test(ListUangKeluars::class)
            ->filterTable('spk_id', $spkA->id)
            ->assertCanSeeTableRecords(UangKeluar::where('spk_id', $spkA->id)->get())
            ->assertCanNotSeeTableRecords(UangKeluar::where('spk_id', $spkB->id)->get());
    }

    /**
     * Filter SPK harus ditulis di kode tabel — bukan hanya bisa dipanggil.
     * Ini menjaga agar tidak terhapus tanpa sengaja saat tabel disunting.
     */
    public function test_filter_spk_terdaftar_di_kedua_tabel(): void
    {
        foreach ([
            'Filament/Resources/UangMasuks/Tables/UangMasuksTable.php',
            'Filament/Resources/UangKeluars/Tables/UangKeluarsTable.php',
        ] as $berkas) {
            $isi = file_get_contents(app_path($berkas));

            $this->assertStringContainsString(
                "SelectFilter::make('spk_id')",
                $isi,
                "Filter SPK wajib ada di {$berkas} (PRD FR-IN-004 / FR-OUT-004).",
            );
        }
    }
}
