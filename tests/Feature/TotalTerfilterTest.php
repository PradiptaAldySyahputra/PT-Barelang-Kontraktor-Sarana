<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\KategoriPengeluaran;
use App\Filament\Resources\UangKeluars\Pages\ListUangKeluars;
use App\Filament\Resources\UangMasuks\Pages\ListUangMasuks;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * BARIS TOTAL TERFILTER DI ATAS TABEL.
 *
 * ⚠️ SARAN USER (9 Okt 2026):
 * "Tampilkan total sesuai filter aktif ... Letakkan di ATAS tabel (summary bar,
 *  terlihat tanpa scroll) ... total + rincian per kategori dalam satu baris."
 *
 * ⚠️ MASALAH YANG DIPERBAIKI:
 * Total hanya ada di BAWAH tabel → admin harus scroll. Baris baru menaruhnya di
 * ATAS dan mengikuti filter.
 */
class TotalTerfilterTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-total@bks.test',
        ]);

        $this->actingAs($this->admin);
    }

    public function test_uang_masuk_menampilkan_total_di_atas_tabel(): void
    {
        UangMasuk::factory()->create(['tanggal' => '2026-08-01', 'jumlah' => 1_000_000]);
        UangMasuk::factory()->create(['tanggal' => '2026-08-02', 'jumlah' => 2_500_000]);

        Livewire::test(ListUangMasuks::class)
            ->assertSee('Total Uang Masuk (terfilter)')
            ->assertSee('Rp 3.500.000');
    }

    public function test_total_uang_masuk_mengikuti_filter_tahun(): void
    {
        UangMasuk::factory()->create(['tanggal' => '2025-05-01', 'jumlah' => 10_000_000]);
        UangMasuk::factory()->create(['tanggal' => '2026-05-01', 'jumlah' => 4_000_000]);

        Livewire::test(ListUangMasuks::class)
            ->filterTable('periode', ['tahun' => '2026'])
            ->assertSee('Rp 4.000.000');
    }

    public function test_uang_keluar_menampilkan_rincian_per_kategori(): void
    {
        UangKeluar::factory()->create([
            'tanggal' => '2026-08-01',
            'jumlah' => 3_000_000,
            'kategori' => KategoriPengeluaran::Material->value,
        ]);
        UangKeluar::factory()->create([
            'tanggal' => '2026-08-02',
            'jumlah' => 1_500_000,
            'kategori' => KategoriPengeluaran::Upah->value,
        ]);

        Livewire::test(ListUangKeluars::class)
            ->assertSee('Total Uang Keluar (terfilter)')
            ->assertSee('Rp 4.500.000')
            ->assertSee('Material')
            ->assertSee('Upah');
    }

    public function test_rincian_kategori_mengikuti_filter(): void
    {
        UangKeluar::factory()->create([
            'tanggal' => '2026-08-01',
            'jumlah' => 7_000_000,
            'kategori' => KategoriPengeluaran::Material->value,
        ]);
        UangKeluar::factory()->create([
            'tanggal' => '2026-09-01',
            'jumlah' => 2_000_000,
            'kategori' => KategoriPengeluaran::Gaji->value,
        ]);

        Livewire::test(ListUangKeluars::class)
            ->filterTable('periode', ['bulan' => '9', 'tahun' => '2026'])
            ->assertSee('Rp 2.000.000');
    }
}
