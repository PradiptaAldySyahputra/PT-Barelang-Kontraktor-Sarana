<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\StatusTagihan;
use App\Filament\Resources\MonitoringSpk\Pages\ListStatusSpk;
use App\Filament\Resources\MonitoringSpk\Pages\ListTagihanSelesaiSpk;
use App\Filament\Resources\MonitoringSpk\Pages\ListTagihanSpk;
use App\Filament\Resources\Spks\Pages\ListSpks;
use App\Filament\Resources\Spks\Pages\ViewSpk;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * PREVIEW SPK (Fase C).
 *
 * ⚠️ PERMINTAAN USER (2 Okt 2026):
 *   "di list spk kenapa ada dua preview detail itu ketika di klik spk dan di
 *    klik button detail ... maksud saya satu slide menampilkan data ... kalau
 *    ingin lihat detail bisa di direct ke halaman detail, tapi bisa lakukan
 *    preview terlebih dahulu ... apakah button detail masih diperlukan kalau
 *    data diklik langsung bisa preview?"
 *
 * KEPUTUSAN DESAIN:
 *   - SATU jalan masuk: KLIK BARIS → preview. Tombol "Detail" terpisah
 *     DIHAPUS karena duplikat (dulu: klik baris → halaman detail, tombol →
 *     modal = dua jalur berbeda).
 *   - Preview = SLIDE-OVER (panel samping), bukan modal lebar tengah, supaya
 *     tata letak rapi & tidak memanjang ke samping.
 *   - Di dalam preview ada tombol "Buka Halaman Detail" menuju halaman detail
 *     penuh (hanya menu List SPK yang punya halaman itu).
 *   - Aksi Ubah/Hapus/Kelola ada DI DALAM preview (Admin saja).
 */
class PreviewSpkTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    private Pengguna $direktur;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create(['email' => 'admin-prev@bks.test']);
        $this->direktur = Pengguna::factory()->direktur()->create(['email' => 'dir-prev@bks.test']);
    }

    private function spk(array $atribut = []): Spk
    {
        return Spk::factory()->pln()->create(array_merge([
            'nomor_spk' => 'PREV-1',
            'nama_pekerjaan' => 'Pekerjaan Preview',
            'nilai_spk' => 10_000_000,
            'status_tagihan' => StatusTagihan::BelumDitagihkan,
            'dibuat_oleh' => $this->admin->id,
        ], $atribut));
    }

    // ---------------------------------------------------------
    // SATU jalan masuk: klik baris = preview (bukan halaman detail)
    // ---------------------------------------------------------

    public function test_klik_baris_list_spk_membuka_preview_bukan_halaman_detail(): void
    {
        $spk = $this->spk();

        $this->actingAs($this->admin);

        $table = Livewire::test(ListSpks::class)->instance()->getTable();

        $this->assertNull(
            $table->getRecordUrl($spk),
            'Klik baris TIDAK boleh langsung ke halaman detail — itu jalur kedua yang membingungkan.'
        );

        $this->assertSame(
            'view',
            $table->getRecordAction($spk),
            'Klik baris harus membuka preview (aksi bernama "view").'
        );
    }

    public function test_klik_baris_menu_monitoring_membuka_preview(): void
    {
        $spk = $this->spk();

        $this->actingAs($this->admin);

        foreach ([ListStatusSpk::class, ListTagihanSpk::class] as $halaman) {
            $table = Livewire::test($halaman)->instance()->getTable();

            $this->assertNull($table->getRecordUrl($spk), $halaman.' tidak boleh punya jalur halaman detail.');
            $this->assertSame('view', $table->getRecordAction($spk), $halaman.' harus membuka preview saat baris diklik.');
        }
    }

    public function test_tombol_detail_terpisah_dihilangkan_dari_baris(): void
    {
        $spk = $this->spk();

        $this->actingAs($this->admin);

        $table = Livewire::test(ListSpks::class)->instance()->getTable();

        $this->assertTrue(
            $table->getAction('view')->isHidden(),
            'Tombol "Detail" tidak lagi ditampilkan di baris — klik baris sudah cukup.'
        );
    }

    // ---------------------------------------------------------
    // Preview = slide-over, bukan modal lebar tengah
    // ---------------------------------------------------------

    public function test_preview_memakai_slide_over(): void
    {
        $spk = $this->spk();

        $this->actingAs($this->admin);

        $table = Livewire::test(ListSpks::class)->instance()->getTable();

        $this->assertTrue(
            $table->getAction('view')->isModalSlideOver(),
            'Preview harus berupa slide-over (panel samping), bukan modal lebar tengah.'
        );
    }

    // ---------------------------------------------------------
    // Tombol menuju halaman detail ADA DI DALAM preview
    // ---------------------------------------------------------

    public function test_preview_punya_tombol_buka_halaman_detail(): void
    {
        $spk = $this->spk();

        $this->actingAs($this->admin);

        Livewire::test(ListSpks::class)
            ->mountAction(TestAction::make('view')->table($spk))
            ->assertActionVisible('bukaDetail')
            ->assertActionHasUrl('bukaDetail', ViewSpk::getUrl(['record' => $spk]));
    }

    // ---------------------------------------------------------
    // Preview berisi data lengkap
    // ---------------------------------------------------------

    public function test_preview_menampilkan_data_lengkap_spk(): void
    {
        $spk = $this->spk([
            'nomor_spk' => 'LENGKAP-9',
            'nama_pekerjaan' => 'Pekerjaan Lengkap',
            'nilai_spk' => 50_000_000,
        ]);

        UangMasuk::factory()->create(['spk_id' => $spk->id, 'jumlah' => 20_000_000]);

        $this->actingAs($this->admin);

        Livewire::test(ListSpks::class)
            ->mountAction(TestAction::make('view')->table($spk))
            ->assertSee('LENGKAP-9')
            ->assertSee('Pekerjaan Lengkap')
            ->assertSee('50.000.000')
            ->assertSee('20.000.000');
    }

    // ---------------------------------------------------------
    // Tombol aksi DI DALAM preview
    // ---------------------------------------------------------

    public function test_preview_punya_tombol_ubah_dan_hapus_untuk_admin(): void
    {
        $spk = $this->spk();

        $this->actingAs($this->admin);

        Livewire::test(ListSpks::class)
            ->mountAction(TestAction::make('view')->table($spk))
            ->assertActionVisible('ubah')
            ->assertActionVisible('hapus');
    }

    public function test_preview_tidak_punya_tombol_aksi_untuk_direktur(): void
    {
        $spk = $this->spk();

        $this->actingAs($this->direktur);

        Livewire::test(ListSpks::class)
            ->mountAction(TestAction::make('view')->table($spk))
            ->assertActionHidden('ubah')
            ->assertActionHidden('hapus');
    }

    public function test_preview_tagihan_punya_aksi_kelola(): void
    {
        $spk = $this->spk(['status_tagihan' => StatusTagihan::BelumDitagihkan]);

        $this->actingAs($this->admin);

        Livewire::test(ListTagihanSpk::class)
            ->mountAction(TestAction::make('view')->table($spk))
            ->assertActionVisible('catatPembayaran');
    }

    public function test_semua_menu_spk_punya_aksi_preview(): void
    {
        $belum = $this->spk(['nomor_spk' => 'PREV-BELUM']);
        $lunas = $this->spk([
            'nomor_spk' => 'PREV-LUNAS',
            'status_tagihan' => StatusTagihan::Dibayar,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(ListSpks::class)->assertTableActionExists('view', record: $belum);
        Livewire::test(ListStatusSpk::class)->assertTableActionExists('view', record: $belum);
        Livewire::test(ListTagihanSpk::class)->assertTableActionExists('view', record: $belum);
        Livewire::test(ListTagihanSelesaiSpk::class)->assertTableActionExists('view', record: $lunas);
    }
}
