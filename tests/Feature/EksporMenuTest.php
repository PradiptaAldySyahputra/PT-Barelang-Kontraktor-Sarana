<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Setiap menu harus bisa mengekspor datanya (permintaan pengguna).
 *
 * ⚠️ KENAPA PENTING: saat bagian pajak meminta "tanggal sekian, bulan
 * sekian", admin memfilter lalu menekan Ekspor — bukan mencatat manual.
 *
 * CATATAN: menu Pengguna hanya boleh dilihat DIREKTUR (aturan sistem),
 * jadi tes untuk menu itu memakai akun direktur — kalau memakai admin
 * akan dapat 403 dan bukan menguji ekspornya.
 */
class EksporMenuTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return list<array{0: string, 1: string}>
     */
    public static function menuProvider(): array
    {
        return [
            ['/admin/spks', 'admin'],
            ['/admin/monitoring-spk/status-spks', 'admin'],
            ['/admin/monitoring-spk/tagihan-spks', 'admin'],
            ['/admin/monitoring-spk/tagihan-selesai-spks', 'admin'],
            ['/admin/uang-masuks', 'admin'],
            ['/admin/uang-keluars', 'admin'],
            ['/admin/mitras', 'admin'],
            ['/admin/penggunas', 'direktur'],
        ];
    }

    /**
     * PHPUnit 12 memakai ATRIBUT, bukan anotasi @dataProvider.
     */
    #[DataProvider('menuProvider')]
    public function test_menu_punya_tombol_ekspor(string $url, string $peran): void
    {
        $pengguna = Pengguna::factory()->{$peran}()->create();
        $this->actingAs($pengguna);

        $html = $this->get($url)->assertSuccessful()->getContent();

        $this->assertStringContainsString('Ekspor', $html, "Menu {$url} harus punya tombol Ekspor.");
    }
}
