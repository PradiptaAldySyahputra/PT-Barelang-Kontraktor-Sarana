<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Pages\CreateUangKeluar;
use App\Filament\Resources\UangMasuks\Pages\CreateUangMasuk;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * VALIDASI TANGGAL TRANSAKSI — `Rules.md` §5 butir 1:
 *
 *   "Tanggal transaksi tidak boleh lebih dari hari ini
 *    (kecuali input transaksi terlambat yang harus disertai catatan)."
 *
 * ⚠️ KENAPA PENTING:
 * Tanpa batas ini, admin bisa salah ketik tahun (mis. 2062 alih-alih 2026).
 * Transaksi itu lalu **tidak muncul** di filter bulan mana pun yang wajar,
 * saldo jadi tidak cocok, dan laporan ke bagian pajak salah. Kesalahan seperti
 * ini tidak terlihat sampai ada yang membandingkan dengan buku kas fisik.
 *
 * ⚠️ KENAPA HANYA UANG MASUK & UANG KELUAR YANG DIUJI:
 * Form SPK sudah punya `maxDate(now())`. Yang belum punya justru dua form
 * transaksi inilah — dan transaksi yang salah tanggal paling merusak laporan.
 */
class ValidasiTanggalTransaksiTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    private Spk $spk;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-tanggal@bks.test',
        ]);

        $this->spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'TANGGAL-001',
            'nilai_spk' => 100_000_000,
        ]);
    }

    // ---------------------------------------------------------------
    // UANG MASUK
    // ---------------------------------------------------------------

    public function test_uang_masuk_menolak_tanggal_masa_depan(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'spk_id' => $this->spk->id,
                'tanggal' => now()->addYear()->toDateString(),
                'jumlah' => 1_000_000,
            ])
            ->call('create')
            ->assertHasFormErrors(['tanggal']);

        $this->assertSame(
            0,
            UangMasuk::count(),
            'Uang masuk bertanggal masa depan TIDAK boleh tersimpan — laporan akan salah.',
        );
    }

    public function test_uang_masuk_menerima_tanggal_hari_ini(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'spk_id' => $this->spk->id,
                'tanggal' => now()->toDateString(),
                'jumlah' => 1_000_000,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(1, UangMasuk::count());
    }

    public function test_uang_masuk_menerima_tanggal_lampau(): void
    {
        // Input transaksi terlambat (nota lama baru dicatat) HARUS tetap boleh.
        $this->actingAs($this->admin);

        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'spk_id' => $this->spk->id,
                'tanggal' => now()->subMonths(3)->toDateString(),
                'jumlah' => 1_000_000,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(1, UangMasuk::count());
    }

    // ---------------------------------------------------------------
    // UANG KELUAR
    // ---------------------------------------------------------------

    public function test_uang_keluar_menolak_tanggal_masa_depan(): void
    {
        $this->actingAs($this->admin);

        /*
         * Form Uang Keluar memakai REPEATER `pengeluaran` — tiap baris punya
         * field sendiri. Jadi tanggal diuji di dalam baris, bukan di root.
         */
        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    [
                        'tanggal' => now()->addYear()->toDateString(),
                        'jumlah' => 500_000,
                        'kategori' => 'operasional',
                        'keterangan' => 'Uji tanggal masa depan',
                    ],
                ],
            ])
            ->call('create')
            ->assertHasFormErrors();

        $this->assertSame(
            0,
            UangKeluar::count(),
            'Uang keluar bertanggal masa depan TIDAK boleh tersimpan — laporan akan salah.',
        );
    }

    public function test_uang_keluar_menerima_tanggal_lampau(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    [
                        'tanggal' => now()->subMonths(2)->toDateString(),
                        'jumlah' => 500_000,
                        'kategori' => 'operasional',
                        'keterangan' => 'Uji tanggal lampau',
                    ],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(1, UangKeluar::count());
    }
}
