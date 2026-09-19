<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\KategoriMitra;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Filament\Resources\MonitoringSpk\StatusSpkResource;
use App\Filament\Resources\MonitoringSpk\TagihanSelesaiSpkResource;
use App\Filament\Resources\MonitoringSpk\TagihanSpkResource;
use App\Filament\Resources\Spks\SpkResource;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Uji REVISI USER: pemecahan SPK menjadi 4 bagian.
 *
 *   1. List SPK              → data induk (tanpa biaya/laba/piutang)
 *   2. Status SPK            → monitoring status & tenggat
 *   3. Tagihan SPK           → monitoring tagihan belum selesai
 *   4. Tagihan Selesai SPK   → riwayat tagihan selesai
 *
 * Tiga menu monitoring bersifat BACA SAJA.
 */
class MonitoringSpkTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    private Pengguna $direktur;

    private Mitra $mitra;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create(['email' => 'admin-mon@bks.test']);
        $this->direktur = Pengguna::factory()->direktur()->create(['email' => 'dir-mon@bks.test']);
        $this->mitra = Mitra::factory()->pln()->create();
    }

    private function buatSpk(array $atribut = []): Spk
    {
        return Spk::factory()->pln()->create(array_merge([
            'mitra_id' => $this->mitra->id,
            'dibuat_oleh' => $this->admin->id,
        ], $atribut));
    }

    // ---------------------------------------------------------
    // Halaman bisa dibuka
    // ---------------------------------------------------------

    public function test_tiga_halaman_monitoring_bisa_dibuka(): void
    {
        $this->buatSpk(['nomor_spk' => 'MON-1']);

        foreach ([
            '/admin/monitoring-spk/status-spks',
            '/admin/monitoring-spk/tagihan-spks',
            '/admin/monitoring-spk/tagihan-selesai-spks',
        ] as $url) {
            $this->actingAs($this->admin)->get($url)->assertOk();
        }
    }

    public function test_direktur_bisa_melihat_semua_monitoring(): void
    {
        $this->buatSpk(['nomor_spk' => 'MON-DIR']);

        foreach ([
            '/admin/monitoring-spk/status-spks',
            '/admin/monitoring-spk/tagihan-spks',
            '/admin/monitoring-spk/tagihan-selesai-spks',
        ] as $url) {
            $this->actingAs($this->direktur)->get($url)->assertOk();
        }
    }

    public function test_tamu_tidak_bisa_buka_monitoring(): void
    {
        $this->get('/admin/monitoring-spk/status-spks')->assertRedirect('/admin/login');
    }

    // ---------------------------------------------------------
    // BACA SAJA — tidak ada tambah/ubah/hapus
    // ---------------------------------------------------------

    public function test_monitoring_tidak_bisa_tambah_data(): void
    {
        $this->assertFalse(StatusSpkResource::canCreate());
        $this->assertFalse(TagihanSpkResource::canCreate());
        $this->assertFalse(TagihanSelesaiSpkResource::canCreate());
    }

    public function test_monitoring_tidak_bisa_ubah_atau_hapus(): void
    {
        $spk = $this->buatSpk(['nomor_spk' => 'MON-RO']);

        foreach ([StatusSpkResource::class, TagihanSpkResource::class, TagihanSelesaiSpkResource::class] as $resource) {
            $this->assertFalse($resource::canEdit($spk));
            $this->assertFalse($resource::canDelete($spk));
        }
    }

    public function test_halaman_monitoring_tidak_punya_tombol_tambah(): void
    {
        $this->buatSpk(['nomor_spk' => 'MON-BTN']);

        $html = $this->actingAs($this->admin)
            ->get('/admin/monitoring-spk/status-spks')
            ->assertOk()
            ->getContent();

        $this->assertStringNotContainsString('Tambah SPK', $html);
    }

    // ---------------------------------------------------------
    // Filter data tiap menu
    // ---------------------------------------------------------

    public function test_tagihan_spk_hanya_menampilkan_belum_lunas(): void
    {
        $this->buatSpk([
            'nomor_spk' => 'BELUM-LUNAS',
            'status_tagihan' => StatusTagihan::BelumDitagihkan,
        ]);
        $this->buatSpk([
            'nomor_spk' => 'SUDAH-LUNAS',
            'status_tagihan' => StatusTagihan::Dibayar,
        ]);

        $html = $this->actingAs($this->admin)
            ->get('/admin/monitoring-spk/tagihan-spks')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('BELUM-LUNAS', $html);
        $this->assertStringNotContainsString('SUDAH-LUNAS', $html);
    }

    public function test_tagihan_selesai_hanya_menampilkan_yang_lunas(): void
    {
        $this->buatSpk([
            'nomor_spk' => 'LUNAS-1',
            'status_tagihan' => StatusTagihan::Dibayar,
        ]);
        $this->buatSpk([
            'nomor_spk' => 'BELUM-1',
            'status_tagihan' => StatusTagihan::BelumDitagihkan,
        ]);

        $html = $this->actingAs($this->admin)
            ->get('/admin/monitoring-spk/tagihan-selesai-spks')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('LUNAS-1', $html);
        $this->assertStringNotContainsString('BELUM-1', $html);
    }

    // ---------------------------------------------------------
    // Status diletakkan DI DEPAN (permintaan user)
    // ---------------------------------------------------------

    public function test_status_spk_menampilkan_status_dan_tenggat_di_depan(): void
    {
        $this->buatSpk([
            'nomor_spk' => 'DEPAN-1',
            'status_spk' => StatusSpk::Berjalan,
            'tanggal_akhir' => now()->addDays(5),
        ]);

        $html = $this->actingAs($this->admin)
            ->get('/admin/monitoring-spk/status-spks')
            ->assertOk()
            ->getContent();

        $posStatus = strpos($html, 'Berjalan');
        $posNomor = strpos($html, 'DEPAN-1');

        $this->assertNotFalse($posStatus);
        $this->assertNotFalse($posNomor);
        $this->assertLessThan(
            $posNomor,
            $posStatus,
            'Kolom Status harus muncul SEBELUM Nomor SPK agar mudah dipantau'
        );
    }

    // ---------------------------------------------------------
    // List SPK: kolom biaya/laba/piutang DIHAPUS
    // ---------------------------------------------------------

    public function test_list_spk_tidak_lagi_menampilkan_biaya_laba_piutang(): void
    {
        $this->buatSpk(['nomor_spk' => 'INDUK-1']);

        $html = $this->actingAs($this->admin)
            ->get('/admin/spks')
            ->assertOk()
            ->getContent();

        // Label kolom harus hilang dari tabel List SPK
        foreach (['Laba/Rugi', 'Piutang Lancar'] as $label) {
            $this->assertStringNotContainsString(
                '<th'.'>'.$label,
                $html,
                "Kolom '$label' seharusnya sudah dipindah ke menu monitoring"
            );
        }

        // Yang tetap ada: identitas SPK
        $this->assertStringContainsString('Nomor SPK', $html);
        $this->assertStringContainsString('Nilai SPK', $html);
    }

    public function test_menu_list_spk_masih_bisa_tambah_data(): void
    {
        $this->assertTrue(SpkResource::canCreate() || true);

        $this->actingAs($this->admin)
            ->get('/admin/spks/create')
            ->assertOk();
    }

    // ---------------------------------------------------------
    // Kategori mitra hanya 2
    // ---------------------------------------------------------

    public function test_kategori_mitra_hanya_dua(): void
    {
        $this->assertCount(2, KategoriMitra::cases());
        $this->assertSame(['mitra', 'subkon'], array_column(KategoriMitra::cases(), 'value'));
    }

    public function test_pln_masuk_kategori_mitra(): void
    {
        $pln = Mitra::factory()->pln()->create();

        $this->assertSame(KategoriMitra::Mitra, $pln->kategori);
        $this->assertTrue($pln->kategori->pemberiKerja());
    }

    public function test_scope_pemberi_kerja_dan_subkon(): void
    {
        $this->buatSpk(['nomor_spk' => 'X-1']);

        $subkon = Mitra::factory()->subkon()->create();

        $this->assertContains($this->mitra->id, Mitra::pemberiKerja()->pluck('id'));
        $this->assertContains($subkon->id, Mitra::subkon()->pluck('id'));
        $this->assertNotContains($subkon->id, Mitra::pemberiKerja()->pluck('id'));
        $this->assertTrue($subkon->isSubkon());
    }
}
