<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Enums\Peran;
use App\Enums\StatusSpk;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Modul Uang Masuk pada panel Blade.
 *
 * Aturan bisnis yang diuji (Rules.md §5):
 *   - tanggal transaksi tidak boleh melewati hari ini
 *   - uang masuk tidak boleh melebihi piutang SPK
 *   - SPK Dibatalkan tidak menerima transaksi baru
 *   - nomor SPK & nama pekerjaan diambil dari SPK, bukan isian bebas
 *   - hanya Admin yang boleh mencatat
 */
class CashInPanelTest extends TestCase
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
    private function isian(Spk $spk, array $ubah = []): array
    {
        return array_merge([
            'mode' => 'spk',
            'akun' => AkunKas::Kas->value,
            'spk_id' => $spk->id,
            'tanggal' => now()->format('Y-m-d'),
            'jumlah' => '1000000',
        ], $ubah);
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $this->get('/panel/cash-in')->assertRedirect('/panel/login');
    }

    public function test_direktur_sebagai_super_admin_boleh_melihat_dan_menambah(): void
    {
        $direktur = $this->pengguna(Peran::Direktur);
        $spk = Spk::factory()->create(['nilai_spk' => 10_000_000]);

        $this->actingAs($direktur)
            ->get('/panel/cash-in')
            ->assertOk();

        $this->actingAs($direktur)
            ->post('/panel/cash-in', $this->isian($spk, ['jumlah' => '1.000.000']))
            ->assertRedirect(route('panel.cash-in.index'));

        $this->assertDatabaseHas('uang_masuk', [
            'spk_id' => $spk->id,
            'jumlah' => '1000000.00',
        ]);
    }

    public function test_admin_mencatat_uang_masuk_dan_nomor_spk_terisi_otomatis(): void
    {
        $spk = Spk::factory()->create([
            'nomor_spk' => 'SPK-MASUK-001',
            'nama_pekerjaan' => 'Pekerjaan Uji Masuk',
            'nilai_spk' => 10_000_000,
        ]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->post('/panel/cash-in', $this->isian($spk, ['jumlah' => '2.500.000']))
            ->assertRedirect(route('panel.cash-in.index'));

        $masuk = UangMasuk::query()->latest('id')->firstOrFail();

        $this->assertSame($spk->id, $masuk->spk_id);
        $this->assertSame('SPK-MASUK-001', $masuk->nomor_spk);
        $this->assertSame('Pekerjaan Uji Masuk', $masuk->nama_pekerjaan);
        $this->assertSame(2_500_000.0, (float) $masuk->jumlah);
    }

    public function test_uang_masuk_melebihi_piutang_ditolak(): void
    {
        $spk = Spk::factory()->create(['nilai_spk' => 5_000_000]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->post('/panel/cash-in', $this->isian($spk, ['jumlah' => '6.000.000']))
            ->assertSessionHasErrors('jumlah');

        $this->assertSame(0, UangMasuk::query()->count());
    }

    public function test_sisa_piutang_menyusut_setelah_pembayaran_sebelumnya(): void
    {
        $spk = Spk::factory()->create(['nilai_spk' => 5_000_000]);
        UangMasuk::factory()->create(['spk_id' => $spk->id, 'jumlah' => 4_000_000]);

        // Sisa piutang 1 juta → 2 juta harus ditolak.
        $this->actingAs($this->pengguna(Peran::Admin))
            ->post('/panel/cash-in', $this->isian($spk, ['jumlah' => '2.000.000']))
            ->assertSessionHasErrors('jumlah');
    }

    public function test_spk_dibatalkan_menolak_transaksi_baru(): void
    {
        $spk = Spk::factory()->create([
            'nilai_spk' => 5_000_000,
            'status_spk' => StatusSpk::Dibatalkan,
        ]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->post('/panel/cash-in', $this->isian($spk))
            ->assertSessionHasErrors('spk_id');
    }

    public function test_tanggal_besok_ditolak(): void
    {
        $spk = Spk::factory()->create(['nilai_spk' => 5_000_000]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->post('/panel/cash-in', $this->isian($spk, ['tanggal' => now()->addDay()->format('Y-m-d')]))
            ->assertSessionHasErrors('tanggal');
    }

    public function test_mode_manual_tidak_menyimpan_spk(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin))
            ->post('/panel/cash-in', [
                'mode' => 'manual',
                'akun' => AkunKas::Bank->value,
                'nomor_spk' => 'REF-LUAR-1',
                'nama_pekerjaan' => 'Penjualan sisa material',
                'tanggal' => now()->format('Y-m-d'),
                'jumlah' => '750000',
            ])
            ->assertRedirect(route('panel.cash-in.index'));

        $masuk = UangMasuk::query()->latest('id')->firstOrFail();

        $this->assertNull($masuk->spk_id);
        $this->assertSame('REF-LUAR-1', $masuk->nomor_spk);
        $this->assertSame('Penjualan sisa material', $masuk->nama_pekerjaan);
    }

    public function test_mode_spk_wajib_memilih_spk(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin))
            ->post('/panel/cash-in', [
                'mode' => 'spk',
                'akun' => AkunKas::Kas->value,
                'tanggal' => now()->format('Y-m-d'),
                'jumlah' => '1000000',
            ])
            ->assertSessionHasErrors('spk_id');
    }

    public function test_hapus_lalu_pulihkan(): void
    {
        $admin = $this->pengguna(Peran::Admin);
        $masuk = UangMasuk::factory()->create(['jumlah' => 1_000_000]);

        $this->actingAs($admin)->delete(route('panel.cash-in.destroy', $masuk));
        $this->assertSoftDeleted($masuk);

        $this->actingAs($admin)->post(route('panel.cash-in.restore', $masuk->id));
        $this->assertNotSoftDeleted($masuk);
    }
}