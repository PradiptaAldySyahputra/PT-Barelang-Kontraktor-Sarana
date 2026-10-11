<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Pages\ListUangKeluars;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * BARIS "TOTAL TERFILTER" TIDAK BOLEH MENGHITUNG DATA YANG SUDAH DIHAPUS.
 *
 * `UangKeluarResource::getEloquentQuery()` melepas `SoftDeletingScope` (untuk
 * kolom "Data Terhapus"). Total di header tabel dihitung dari
 * `getFilteredTableQuery()` — kalau scope tidak dikembalikan, transaksi yang
 * sudah di-soft-delete ikut terjumlah → angka total di layar LEBIH BESAR dari
 * data yang benar-benar ada. Ini jenis bug yang sama dengan salah hitung
 * nominal: laporan jadi tidak bisa dipercaya.
 */
class BugTotalTerfilterSoftDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_total_header_mengabaikan_data_terhapus(): void
    {
        $admin = Pengguna::factory()->admin()->create(['email' => 'admin-total-hapus@bks.test']);
        $this->actingAs($admin);

        $aktif = UangKeluar::factory()->create([
            'jumlah' => 1_000_000,
            'tanggal' => now()->toDateString(),
        ]);

        $terhapus = UangKeluar::factory()->create([
            'jumlah' => 5_000_000,
            'tanggal' => now()->toDateString(),
        ]);

        $terhapus->delete();

        $komponen = Livewire::test(ListUangKeluars::class);

        // Query terfilter yang dipakai header harus mengabaikan baris terhapus.
        $total = (clone $komponen->instance()->getFilteredTableQuery())->sum('jumlah');

        $this->assertSame(
            1_000_000.0,
            (float) $total,
            'Total terfilter tidak boleh memasukkan transaksi yang sudah dihapus.',
        );
    }
}
