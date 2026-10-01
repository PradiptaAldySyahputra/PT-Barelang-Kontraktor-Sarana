<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\Spks\SpkResource;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * FILTER MENU SPK tidak boleh ADA YANG DUPLIKAT.
 *
 * ⚠️ TEMUAN UX (26 Sep 2026) — keluhan pengguna "filter masih bernatatan
 * [bertumpuk], terlalu banyak dan panjang":
 *
 * Menu SPK punya 7 filter, dan DUA di antaranya mengatur kolom yang SAMA:
 *   - `Disubkonkan` (toggle)  → dikerjakan_oleh = 'subkon'
 *   - `Pelaksana` (dropdown)  → dikerjakan_oleh = 'sendiri' | 'subkon'
 *
 * Itu duplikat: admin bisa menyalakan "Disubkonkan" TAPI memilih Pelaksana
 * "Dikerjakan Sendiri" → hasilnya kosong tanpa penjelasan. Ini pola yang
 * sama dengan masalah di Uang Keluar/Uang Masuk/Mitra yang sudah dibersihkan.
 *
 * Perbaikan: filter `Disubkonkan` dihapus — cukup pakai `Pelaksana`.
 */
class FilterSpkTest extends TestCase
{
    /*
     * ⚠️ WAJIB pakai RefreshDatabase: tes ini membuat data Pengguna. Tanpa
     * trait ini, data bocor ke tes lain dan membuat tes seeder gagal
     * ("harus ada 2 akun" → terbaca 3). Ini kesalahan yang pernah terjadi.
     */
    use RefreshDatabase;

    public function test_filter_disubkonkan_sudah_dihapus(): void
    {
        $isi = file_get_contents(app_path('Filament/Resources/Spks/Tables/SpksTable.php'));

        $this->assertStringNotContainsString(
            "Filter::make('disubkonkan')",
            $isi,
            'Filter "Disubkonkan" duplikat dengan filter "Pelaksana" (kolom dikerjakan_oleh sama) — harus dihapus.',
        );
    }

    public function test_filter_pelaksana_tetap_ada(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        $html = $this->actingAs($admin)
            ->get(SpkResource::getUrl('index'))
            ->assertSuccessful()
            ->getContent();

        // Filter yang BENAR tetap tersedia.
        $this->assertStringContainsString('Pelaksana', $html);
    }

    public function test_jumlah_filter_spk_tidak_berlebihan(): void
    {
        $isi = file_get_contents(app_path('Filament/Resources/Spks/Tables/SpksTable.php'));

        // Ambil HANYA bagian filter, lalu buang komentar — supaya komentar
        // yang menyebut nama filter tidak ikut terhitung.
        $awal = strpos($isi, '->filters(');
        $akhir = strpos($isi, '->recordActions(');
        $segmen = substr($isi, $awal, $akhir - $awal);

        $segmen = (string) preg_replace('#/\*.*?\*/#s', '', $segmen);
        $segmen = (string) preg_replace('#//[^\n]*#', '', $segmen);

        $jumlah = preg_match_all(
            '/(SelectFilter|Filter|TernaryFilter|TrashedFilter)::make\(/',
            $segmen,
        );

        /*
         * Sebelum pembersihan ada 8 filter (termasuk `Disubkonkan` yang
         * duplikat). Setelah dihapus tersisa 7. Batas 7 dipakai supaya
         * penambahan filter baru di masa depan harus disengaja.
         */
        $this->assertLessThanOrEqual(
            7,
            $jumlah,
            "Filter menu SPK terlalu banyak ({$jumlah}) — permintaan pengguna: filter jangan panjang.",
        );
    }
}
