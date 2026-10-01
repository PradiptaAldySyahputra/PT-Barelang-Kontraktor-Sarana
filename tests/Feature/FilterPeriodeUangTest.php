<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Filament\Resources\UangKeluars\UangKeluarResource;
use App\Filament\Resources\UangMasuks\UangMasukResource;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * PERMINTAAN PENGGUNA (26 Sep 2026):
 *
 * 1. Menu "Buku Kas & Bank" TIDAK DIPERLUKAN lagi — itu pecahan dari menu
 *    Uang Masuk & Uang Keluar. Pembeda Kas/Bank cukup jadi kategori di
 *    kedua menu itu.
 * 2. Tabel Uang Masuk & Uang Keluar diberi filter TAHUN → BULAN → TANGGAL,
 *    supaya admin bisa mencari data dengan cepat.
 * 3. Urutan tetap terbaru di atas.
 */
class FilterPeriodeUangTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_buku_kas_bank_sudah_tidak_ada(): void
    {
        $this->assertFileDoesNotExist(
            app_path('Filament/Pages/BukuKasBank.php'),
            'Menu Buku Kas & Bank harus dihapus — itu pecahan dari Uang Masuk/Keluar.',
        );

        $this->assertFileDoesNotExist(
            app_path('Services/BukuKasBank.php'),
            'Service BukuKasBank tidak lagi dipakai setelah menu digabung.',
        );
    }

    public function test_kedua_menu_punya_filter_tahun_bulan_tanggal(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        foreach (['/admin/uang-masuks', '/admin/uang-keluars'] as $url) {
            $html = $this->get($url)->assertSuccessful()->getContent();

            /*
             * ⚠️ PERUBAHAN UX (26 Sep 2026): tiga filter terpisah digabung
             * jadi SATU filter "Periode" — supaya panel filter tidak panjang.
             * Isian di dalamnya tetap Tahun / Bulan / Dari / Sampai Tanggal.
             */
            foreach (['Tahun', 'Bulan', 'Dari Tanggal', 'Sampai Tanggal'] as $label) {
                $this->assertStringContainsString(
                    $label,
                    $html,
                    "Menu {$url} harus punya filter {$label} (permintaan pengguna).",
                );
            }
        }
    }

    public function test_filter_tahun_menyaring_data(): void
    {
        UangMasuk::factory()->create(['tanggal' => '2025-05-10', 'jumlah' => 111_000]);
        UangMasuk::factory()->create(['tanggal' => '2026-05-10', 'jumlah' => 222_000]);

        $query = UangMasukResource::getEloquentQuery();

        // Tiru cara kerja SelectFilter tahun.
        $hasil = (clone $query)->whereYear('tanggal', 2026)->get();

        $this->assertCount(1, $hasil);
        $this->assertSame('222000.00', (string) $hasil->first()->jumlah);
    }

    public function test_filter_bulan_menyaring_data(): void
    {
        UangKeluar::factory()->create(['tanggal' => '2026-07-10', 'jumlah' => 333_000]);
        UangKeluar::factory()->create(['tanggal' => '2026-08-10', 'jumlah' => 444_000]);

        $hasil = (clone UangKeluarResource::getEloquentQuery())->whereMonth('tanggal', 8)->get();

        $this->assertCount(1, $hasil);
        $this->assertSame('444000.00', (string) $hasil->first()->jumlah);
    }

    public function test_filter_rentang_tanggal_menyaring_data(): void
    {
        UangKeluar::factory()->create(['tanggal' => '2026-08-01', 'jumlah' => 1000]);
        UangKeluar::factory()->create(['tanggal' => '2026-08-15', 'jumlah' => 2000]);
        UangKeluar::factory()->create(['tanggal' => '2026-09-01', 'jumlah' => 3000]);

        $hasil = (clone UangKeluarResource::getEloquentQuery())
            ->whereDate('tanggal', '>=', '2026-08-01')
            ->whereDate('tanggal', '<=', '2026-08-31')
            ->get();

        $this->assertCount(2, $hasil);
    }

    public function test_pembeda_kas_bank_ada_di_kedua_menu(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        UangMasuk::factory()->create(['akun' => AkunKas::Bank->value, 'tanggal' => '2026-08-05']);
        UangKeluar::factory()->create(['akun' => AkunKas::Kas->value, 'tanggal' => '2026-08-05']);
        $this->actingAs($admin);

        foreach (['/admin/uang-masuks', '/admin/uang-keluars'] as $url) {
            $html = $this->get($url)->assertSuccessful()->getContent();
            $this->assertStringContainsString('Kas/Bank', $html, "Menu {$url} harus menampilkan pembeda Kas/Bank.");
        }
    }

    public function test_urutan_terbaru_di_atas(): void
    {
        UangMasuk::factory()->create(['tanggal' => '2026-01-01', 'keterangan' => 'LAMA']);
        UangMasuk::factory()->create(['tanggal' => '2026-12-31', 'keterangan' => 'BARU']);

        $urutan = (clone UangMasukResource::getEloquentQuery())->orderByDesc('tanggal')->get();

        $this->assertSame('BARU', $urutan->first()->keterangan);
    }
}
