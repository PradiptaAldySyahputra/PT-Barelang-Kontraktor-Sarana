<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\KategoriPengeluaran;
use App\Filament\Resources\Spks\Pages\ListSpks;
use App\Filament\Resources\Spks\Pages\ViewSpk;
use App\Filament\Resources\Spks\RelationManagers\UangKeluarRelationManager;
use App\Filament\Resources\Spks\RelationManagers\UangMasukRelationManager;
use App\Filament\Resources\Spks\SpkResource;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * DETAIL SPK (FR-SPK-005, prioritas High).
 *
 * ⚠️ SUMBER (PRD.md FR-SPK-005):
 *   "Sistem menampilkan detail SPK: data lengkap, uang masuk terkait,
 *    pengeluaran terkait."
 *
 * ⚠️ MASALAH SEBELUMNYA (temuan AUDIT-MENU-DAN-ALUR.md T-2):
 * Tidak ada halaman detail SPK. Yang ada hanya angka TOTAL lewat `withSum`,
 * bukan DAFTAR transaksi. Untuk melihat transaksi mana saja milik satu SPK,
 * admin harus membuka menu Uang Masuk lalu memfilter SPK — tidak dari SPK-nya.
 *
 * SOLUSI:
 * Halaman Detail SPK menampilkan data lengkap + dua panel read-only berisi
 * daftar uang masuk & uang keluar milik SPK tersebut.
 */
class DetailSpkTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    private Pengguna $direktur;

    private Mitra $mitra;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create(['email' => 'admin-detail@bks.test']);
        $this->direktur = Pengguna::factory()->direktur()->create(['email' => 'dir-detail@bks.test']);
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

    public function test_halaman_detail_spk_bisa_dibuka(): void
    {
        $spk = $this->buatSpk(['nomor_spk' => 'DETAIL-001']);

        $this->actingAs($this->admin)
            ->get(SpkResource::getUrl('view', ['record' => $spk]))
            ->assertOk();
    }

    public function test_direktur_bisa_melihat_detail_spk(): void
    {
        $spk = $this->buatSpk(['nomor_spk' => 'DETAIL-DIR']);

        $this->actingAs($this->direktur)
            ->get(SpkResource::getUrl('view', ['record' => $spk]))
            ->assertOk();
    }

    public function test_tamu_tidak_bisa_buka_detail_spk(): void
    {
        $spk = $this->buatSpk(['nomor_spk' => 'DETAIL-TAMU']);

        $this->get(SpkResource::getUrl('view', ['record' => $spk]))
            ->assertRedirect('/admin/login');
    }

    // ---------------------------------------------------------
    // Data lengkap SPK tampil
    // ---------------------------------------------------------

    public function test_detail_spk_menampilkan_data_utama(): void
    {
        $spk = $this->buatSpk([
            'nomor_spk' => 'DATA-LENGKAP-9',
            'nama_pekerjaan' => 'Pekerjaan Detail Uji',
            'nilai_spk' => 150_000_000,
        ]);

        Livewire::test(ViewSpk::class, ['record' => $spk->id])
            ->assertOk()
            ->assertSee('DATA-LENGKAP-9')
            ->assertSee('Pekerjaan Detail Uji');
    }

    // ---------------------------------------------------------
    // Uang masuk & keluar PER SPK
    // ---------------------------------------------------------

    public function test_panel_uang_masuk_menampilkan_transaksi_spk_ini(): void
    {
        $spk = $this->buatSpk(['nomor_spk' => 'MASUK-1', 'nilai_spk' => 500_000_000]);
        $masuk = UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'mitra_id' => $this->mitra->id,
            'jumlah' => 12_345_678,
            'keterangan' => 'termin pertama',
        ]);

        Livewire::test(UangMasukRelationManager::class, [
            'ownerRecord' => $spk,
            'pageClass' => ViewSpk::class,
        ])
            ->assertOk()
            ->assertCanSeeTableRecords([$masuk]);
    }

    public function test_panel_uang_keluar_menampilkan_transaksi_spk_ini(): void
    {
        $spk = $this->buatSpk(['nomor_spk' => 'KELUAR-1']);
        $keluar = UangKeluar::factory()->create([
            'spk_id' => $spk->id,
            'kategori' => KategoriPengeluaran::Material,
            'jumlah' => 7_654_321,
        ]);

        Livewire::test(UangKeluarRelationManager::class, [
            'ownerRecord' => $spk,
            'pageClass' => ViewSpk::class,
        ])
            ->assertOk()
            ->assertCanSeeTableRecords([$keluar]);
    }

    public function test_panel_tidak_menampilkan_transaksi_spk_lain(): void
    {
        $spkA = $this->buatSpk(['nomor_spk' => 'SPK-A', 'nilai_spk' => 500_000_000]);
        $spkB = $this->buatSpk(['nomor_spk' => 'SPK-B', 'nilai_spk' => 500_000_000]);

        $masukA = UangMasuk::factory()->create(['spk_id' => $spkA->id, 'mitra_id' => $this->mitra->id]);
        $masukB = UangMasuk::factory()->create(['spk_id' => $spkB->id, 'mitra_id' => $this->mitra->id]);

        Livewire::test(UangMasukRelationManager::class, [
            'ownerRecord' => $spkA,
            'pageClass' => ViewSpk::class,
        ])
            ->assertCanSeeTableRecords([$masukA])
            ->assertCanNotSeeTableRecords([$masukB]);
    }

    // ---------------------------------------------------------
    // Aksi di tabel SPK
    // ---------------------------------------------------------

    public function test_tabel_spk_punya_aksi_lihat_detail(): void
    {
        $spk = $this->buatSpk(['nomor_spk' => 'AKSI-DETAIL']);

        $this->actingAs($this->admin);

        Livewire::test(ListSpks::class)
            ->assertTableActionExists('view', record: $spk);
    }

    // ---------------------------------------------------------
    // Panel read-only — tidak ada tombol tambah/ubah transaksi
    // ---------------------------------------------------------

    public function test_panel_transaksi_read_only(): void
    {
        $spk = $this->buatSpk(['nomor_spk' => 'READONLY-1']);

        Livewire::test(UangMasukRelationManager::class, [
            'ownerRecord' => $spk,
            'pageClass' => ViewSpk::class,
        ])->assertTableActionDoesNotExist('create');
    }

    // ---------------------------------------------------------
    // Verifikasi halaman penuh (render HTML) — kedua panel ada
    // ---------------------------------------------------------

    public function test_halaman_detail_menampilkan_kedua_panel_transaksi(): void
    {
        $spk = $this->buatSpk(['nomor_spk' => 'PANEL-1']);

        $html = $this->actingAs($this->admin)
            ->get(SpkResource::getUrl('view', ['record' => $spk]))
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('Uang Masuk (Penerimaan)', $html);
        $this->assertStringContainsString('Uang Keluar (Pengeluaran)', $html);
    }
}
