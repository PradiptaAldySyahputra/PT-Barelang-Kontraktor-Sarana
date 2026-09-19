<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\StatusTagihan;
use App\Filament\Resources\UangMasuks\Pages\CreateUangMasuk;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Uji BATAS UANG MASUK terhadap piutang SPK.
 *
 * ⚠️ KENAPA PENTING:
 * Tanpa batas ini, untuk SPK Rp 100 juta bisa diinput Rp 500 juta dan
 * angka laba-rugi langsung rusak tanpa peringatan.
 */
class BatasUangMasukTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    private Spk $spk;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-batas@bks.test',
        ]);

        $this->spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'BATAS-001',
            'nilai_spk' => 100_000_000,
            'status_tagihan' => StatusTagihan::BelumDitagihkan,
            'mitra_id' => Mitra::factory()->pln()->create(['nama' => 'PT PLN Batam'])->id,
            'dibuat_oleh' => $this->admin->id,
        ]);
    }

    public function test_uang_masuk_dalam_batas_diterima(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'spk_id' => $this->spk->id,
                'tanggal' => now()->toDateString(),
                'jumlah' => 50_000_000,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(
            50_000_000.0,
            (float) UangMasuk::where('spk_id', $this->spk->id)->sum('jumlah')
        );
    }

    public function test_uang_masuk_melebihi_piutang_ditolak(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'spk_id' => $this->spk->id,
                'tanggal' => now()->toDateString(),
                'jumlah' => 150_000_000, // melebihi nilai SPK 100jt
            ])
            ->call('create')
            ->assertHasFormErrors(['jumlah']);

        $this->assertSame(0, UangMasuk::where('spk_id', $this->spk->id)->count());
    }

    public function test_batas_memperhitungkan_pembayaran_sebelumnya(): void
    {
        $this->actingAs($this->admin);

        UangMasuk::factory()->create([
            'spk_id' => $this->spk->id,
            'jumlah' => 90_000_000,
            'mitra_id' => null,
        ]);

        // Sisa hanya 10jt -> 20jt harus DITOLAK
        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'spk_id' => $this->spk->id,
                'tanggal' => now()->toDateString(),
                'jumlah' => 20_000_000,
            ])
            ->call('create')
            ->assertHasFormErrors(['jumlah']);

        // 10jt harus DITERIMA
        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'spk_id' => $this->spk->id,
                'tanggal' => now()->toDateString(),
                'jumlah' => 10_000_000,
            ])
            ->call('create')
            ->assertHasNoFormErrors();
    }

    public function test_batas_memperhitungkan_retensi(): void
    {
        $this->actingAs($this->admin);

        $this->spk->terapkanRetensi(5.00)->save();

        // Nilai tagih = 95jt. Bayar 96jt harus DITOLAK.
        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'spk_id' => $this->spk->id,
                'tanggal' => now()->toDateString(),
                'jumlah' => 96_000_000,
            ])
            ->call('create')
            ->assertHasFormErrors(['jumlah']);

        // Bayar 95jt harus DITERIMA (lunas, retensi ditahan)
        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'spk_id' => $this->spk->id,
                'tanggal' => now()->toDateString(),
                'jumlah' => 95_000_000,
            ])
            ->call('create')
            ->assertHasNoFormErrors();
    }

    public function test_uang_masuk_luar_spk_tidak_dibatasi(): void
    {
        $this->actingAs($this->admin);

        // Mode MANUAL -> spk_id boleh kosong, jumlah tidak dibatasi
        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'mode' => 'manual',
                'spk_id' => null,
                'nomor_spk' => 'Penjualan sisa material',
                'nama_pekerjaan' => 'Penjualan sisa material',
                'tanggal' => now()->toDateString(),
                'jumlah' => 500_000_000,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(
            500_000_000.0,
            (float) UangMasuk::whereNull('spk_id')->sum('jumlah')
        );
    }

    public function test_mode_spk_wajib_memilih_spk(): void
    {
        $this->actingAs($this->admin);

        // Mode SPK tanpa memilih SPK -> harus ditolak
        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'mode' => 'spk',
                'spk_id' => null,
                'tanggal' => now()->toDateString(),
                'jumlah' => 1_000_000,
            ])
            ->call('create')
            ->assertHasFormErrors(['spk_id']);
    }
}
