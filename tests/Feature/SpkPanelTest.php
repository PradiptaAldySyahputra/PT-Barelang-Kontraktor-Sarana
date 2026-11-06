<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\DikerjakanOleh;
use App\Enums\Peran;
use App\Enums\StatusAntar;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Livewire\Spk\MonitoringTable;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Modul SPK pada panel Blade: form, detail, dua form status, monitoring.
 *
 * Yang diuji adalah aturan bisnis yang paling mahal kalau salah:
 *   - SPK baru selalu Draft + Belum Ditagihkan
 *   - `Dibayar` ditolak selama masih ada piutang (temuan audit A1)
 *   - SPK yang sudah punya transaksi tidak bisa dihapus
 *   - Direktur hanya membaca
 */
class SpkPanelTest extends TestCase
{
    use RefreshDatabase;

    private function pengguna(Peran $peran): Pengguna
    {
        return Pengguna::factory()->create(['peran' => $peran]);
    }

    /**
     * @param  array<string, mixed>  $ubah
     * @return array<string, mixed>
     */
    private function isian(array $ubah = []): array
    {
        return array_merge([
            'nomor_spk' => 'SPK-'.$this->acak(),
            'nama_pekerjaan' => 'Pekerjaan Uji Panel',
            'nilai_spk' => '10000000',
            'status_antar' => StatusAntar::Belum->value,
            'dikerjakan_oleh' => DikerjakanOleh::Sendiri->value,
        ], $ubah);
    }

    private function acak(): string
    {
        return (string) random_int(1000, 9999);
    }

    /* =====================================================
       Akses & daftar
       ===================================================== */

    public function test_tamu_diarahkan_ke_login(): void
    {
        $this->get('/panel/spk')->assertRedirect('/panel/login');
    }

    public function test_admin_melihat_tombol_spk_baru(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin))
            ->get('/panel/spk')
            ->assertOk()
            ->assertSee('SPK Baru');
    }

    public function test_direktur_sebagai_super_admin_boleh_membuat_spk(): void
    {
        $this->actingAs($this->pengguna(Peran::Direktur))
            ->post('/panel/spk', $this->isian())
            ->assertRedirect();
    }

    /* =====================================================
       Simpan SPK
       ===================================================== */

    public function test_admin_membuat_spk_baru_berstatus_draft_dan_belum_ditagihkan(): void
    {
        $admin = $this->pengguna(Peran::Admin);

        $this->actingAs($admin)
            ->post('/panel/spk', $this->isian(['nomor_spk' => 'SPK-BARU-001', 'nilai_spk' => '250.000.000']))
            ->assertRedirect();

        $spk = Spk::query()->where('nomor_spk', 'SPK-BARU-001')->firstOrFail();

        $this->assertSame(StatusSpk::Draft, $spk->status_spk);
        $this->assertSame(StatusTagihan::BelumDitagihkan, $spk->status_tagihan);
        $this->assertSame($admin->id, $spk->dibuat_oleh);
        $this->assertSame(250000000.0, (float) $spk->nilai_spk);
    }

    public function test_nomor_spk_harus_unik(): void
    {
        Spk::factory()->create(['nomor_spk' => 'SPK-KEMBAR']);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->post('/panel/spk', $this->isian(['nomor_spk' => 'SPK-KEMBAR']))
            ->assertSessionHasErrors('nomor_spk');
    }

    public function test_subkon_wajib_dipilih_bila_dikerjakan_subkon(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin))
            ->post('/panel/spk', $this->isian([
                'dikerjakan_oleh' => DikerjakanOleh::Subkon->value,
                'subkon_id' => null,
            ]))
            ->assertSessionHasErrors('subkon_id');
    }

    public function test_subkon_dikosongkan_otomatis_bila_dikerjakan_sendiri(): void
    {
        $subkon = Mitra::factory()->create(['kategori' => 'subkon']);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->post('/panel/spk', $this->isian([
                'nomor_spk' => 'SPK-BERSIH-SUBKON',
                'dikerjakan_oleh' => DikerjakanOleh::Sendiri->value,
                'subkon_id' => $subkon->id,
            ]));

        $this->assertNull(Spk::query()->where('nomor_spk', 'SPK-BERSIH-SUBKON')->value('subkon_id'));
    }

    /* =====================================================
       Detail
       ===================================================== */

    public function test_detail_spk_menampilkan_nilai_dan_transaksi(): void
    {
        $spk = Spk::factory()->create(['nomor_spk' => 'SPK-DETAIL-777', 'nilai_spk' => 50_000_000]);
        UangMasuk::factory()->create(['spk_id' => $spk->id, 'jumlah' => 12_500_000]);

        $this->actingAs($this->pengguna(Peran::Direktur))
            ->get(route('panel.spk.show', $spk))
            ->assertOk()
            ->assertSee('SPK-DETAIL-777')
            ->assertSee('Rp 50.000.000')
            ->assertSee('Rp 12.500.000');
    }

    /* =====================================================
       Status pekerjaan & tagihan
       ===================================================== */

    public function test_admin_mengubah_status_pekerjaan(): void
    {
        $spk = Spk::factory()->create(['status_spk' => StatusSpk::Draft]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->put(route('panel.spk.status.update', $spk), ['status_spk' => StatusSpk::Berjalan->value])
            ->assertRedirect(route('panel.spk.index'));

        $this->assertSame(StatusSpk::Berjalan, $spk->fresh()?->status_spk);
    }

    public function test_status_tagihan_dibayar_ditolak_selama_masih_ada_piutang(): void
    {
        $spk = Spk::factory()->create([
            'nilai_spk' => 10_000_000,
            'status_tagihan' => StatusTagihan::MenungguPembayaran,
        ]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->put(route('panel.spk.billing.update', $spk), ['status_tagihan' => StatusTagihan::Dibayar->value])
            ->assertSessionHasErrors('status_tagihan');

        $this->assertSame(StatusTagihan::MenungguPembayaran, $spk->fresh()?->status_tagihan);
    }

    public function test_status_tagihan_dibayar_boleh_setelah_lunas(): void
    {
        $spk = Spk::factory()->create([
            'nilai_spk' => 10_000_000,
            'status_tagihan' => StatusTagihan::MenungguPembayaran,
        ]);
        UangMasuk::factory()->create(['spk_id' => $spk->id, 'jumlah' => 10_000_000]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->put(route('panel.spk.billing.update', $spk), ['status_tagihan' => StatusTagihan::Dibayar->value])
            ->assertRedirect(route('panel.spk.index'));

        $this->assertSame(StatusTagihan::Dibayar, $spk->fresh()?->status_tagihan);
    }

    /* =====================================================
       Hapus
       ===================================================== */

    public function test_spk_dengan_transaksi_tidak_bisa_dihapus(): void
    {
        $spk = Spk::factory()->create();
        UangMasuk::factory()->create(['spk_id' => $spk->id]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->delete(route('panel.spk.destroy', $spk));

        $this->assertNotSoftDeleted($spk);
    }

    public function test_spk_tanpa_transaksi_bisa_dihapus(): void
    {
        $spk = Spk::factory()->create();

        $this->actingAs($this->pengguna(Peran::Admin))
            ->delete(route('panel.spk.destroy', $spk));

        $this->assertSoftDeleted($spk);
    }

    /* =====================================================
       Monitoring
       ===================================================== */

    public function test_tagihan_spk_hanya_menampilkan_yang_belum_lunas(): void
    {
        Spk::factory()->create(['nomor_spk' => 'SPK-BELUM-LUNAS', 'status_tagihan' => StatusTagihan::SudahDitagihkan]);
        Spk::factory()->create(['nomor_spk' => 'SPK-SUDAH-LUNAS', 'status_tagihan' => StatusTagihan::Dibayar]);

        Livewire::test(MonitoringTable::class, ['mode' => 'billing'])
            ->assertSee('SPK-BELUM-LUNAS')
            ->assertDontSee('SPK-SUDAH-LUNAS');
    }

    public function test_tagihan_selesai_hanya_menampilkan_yang_lunas(): void
    {
        Spk::factory()->create(['nomor_spk' => 'SPK-BELUM-LUNAS', 'status_tagihan' => StatusTagihan::SudahDitagihkan]);
        Spk::factory()->create(['nomor_spk' => 'SPK-SUDAH-LUNAS', 'status_tagihan' => StatusTagihan::Dibayar]);

        Livewire::test(MonitoringTable::class, ['mode' => 'completed'])
            ->assertSee('SPK-SUDAH-LUNAS')
            ->assertDontSee('SPK-BELUM-LUNAS');
    }

    public function test_status_spk_menampilkan_semua(): void
    {
        Spk::factory()->create(['nomor_spk' => 'SPK-STATUS-A', 'status_tagihan' => StatusTagihan::SudahDitagihkan]);
        Spk::factory()->create(['nomor_spk' => 'SPK-STATUS-B', 'status_tagihan' => StatusTagihan::Dibayar]);

        Livewire::test(MonitoringTable::class, ['mode' => 'status'])
            ->assertSee('SPK-STATUS-A')
            ->assertSee('SPK-STATUS-B');
    }

    public function test_ubah_nilai_spk_di_bawah_pembayaran_yang_sudah_masuk_ditolak(): void
    {
        $spk = Spk::factory()->create(['nilai_spk' => 20_000_000]);
        UangMasuk::factory()->create(['spk_id' => $spk->id, 'jumlah' => 15_000_000]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->put(route('panel.spk.update', $spk), $this->isian([
                'nomor_spk' => $spk->nomor_spk,
                'nilai_spk' => '10.000.000',
            ]))
            ->assertSessionHasErrors('nilai_spk');

        $this->assertSame(20_000_000.0, (float) $spk->fresh()?->nilai_spk);
    }

    public function test_menaikkan_nilai_spk_yang_sudah_lunas_mengembalikan_status_menunggu_pembayaran(): void
    {
        $spk = Spk::factory()->create(['nilai_spk' => 10_000_000]);
        UangMasuk::factory()->create(['spk_id' => $spk->id, 'jumlah' => 10_000_000]);

        $this->assertSame(StatusTagihan::Dibayar, $spk->fresh()?->status_tagihan);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->put(route('panel.spk.update', $spk), $this->isian([
                'nomor_spk' => $spk->nomor_spk,
                'nilai_spk' => '25.000.000',
            ]))
            ->assertSessionHasNoErrors();

        $this->assertSame(StatusTagihan::MenungguPembayaran, $spk->fresh()?->status_tagihan);
    }
}
