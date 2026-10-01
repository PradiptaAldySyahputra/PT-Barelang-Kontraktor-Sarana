<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\StatusSpk;
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
 * SPK DIBATALKAN TIDAK MENERIMA TRANSAKSI BARU.
 *
 * ⚠️ SUMBER ATURAN (`docs/Rules.md` §5 butir 3):
 *   "SPK yang dipilih harus valid — SPK berstatus `Dibatalkan` tidak menerima
 *    transaksi baru kecuali ada override khusus oleh Admin."
 *
 * ⚠️ KENAPA PENTING:
 * SPK dibatalkan = pekerjaan tidak dilanjutkan. Kalau transaksi masih bisa
 * masuk ke situ, laporan piutang jadi salah: perusahaan terlihat masih punya
 * piutang atas pekerjaan yang sudah batal. Bagian pajak pun akan melihat
 * penerimaan atas pekerjaan yang tidak pernah ada.
 *
 * ⚠️ TEMUAN AUDIT (29 Sep 2026):
 * `StatusSpk::bolehTransaksiBaru()` SUDAH ADA dan sudah diuji di
 * `tests/Unit/EnumTest.php` — tetapi TIDAK DIPANGGIL di form transaksi.
 * Jadi aturannya tertulis tapi tidak dijalankan. Berkas ini menutup celah itu.
 */
class SpkDibatalkanTidakTerimaTransaksiTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-batal@bks.test',
        ]);

        $this->actingAs($this->admin);
    }

    private function spkDibatalkan(): Spk
    {
        return Spk::factory()->pln()->create([
            'nomor_spk' => 'BATAL-001',
            'nama_pekerjaan' => 'Pekerjaan Dibatalkan',
            'nilai_spk' => 50_000_000,
            'status_spk' => StatusSpk::Dibatalkan,
        ]);
    }

    private function spkBerjalan(): Spk
    {
        return Spk::factory()->pln()->create([
            'nomor_spk' => 'JALAN-001',
            'nama_pekerjaan' => 'Pekerjaan Berjalan',
            'nilai_spk' => 50_000_000,
            'status_spk' => StatusSpk::Berjalan,
        ]);
    }

    // ---------------------------------------------------------------
    // UANG MASUK
    // ---------------------------------------------------------------

    public function test_uang_masuk_ditolak_untuk_spk_dibatalkan(): void
    {
        $spk = $this->spkDibatalkan();

        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'spk_id' => $spk->id,
                'tanggal' => now()->toDateString(),
                'jumlah' => 1_000_000,
            ])
            ->call('create')
            ->assertHasFormErrors(['spk_id']);

        $this->assertSame(
            0,
            UangMasuk::count(),
            'Uang masuk TIDAK boleh masuk ke SPK Dibatalkan (Rules §5 butir 3).',
        );
    }

    public function test_uang_masuk_tetap_diterima_untuk_spk_berjalan(): void
    {
        $spk = $this->spkBerjalan();

        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'spk_id' => $spk->id,
                'tanggal' => now()->toDateString(),
                'jumlah' => 1_000_000,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(1, UangMasuk::count());
    }

    // ---------------------------------------------------------------
    // UANG KELUAR
    // ---------------------------------------------------------------

    public function test_uang_keluar_ditolak_untuk_spk_dibatalkan(): void
    {
        $spk = $this->spkDibatalkan();

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    [
                        'tanggal' => now()->toDateString(),
                        'jumlah' => 500_000,
                        'kategori' => 'material',
                        'spk_id' => $spk->id,
                        'keterangan' => 'Uji SPK dibatalkan',
                    ],
                ],
            ])
            ->call('create')
            ->assertHasFormErrors();

        $this->assertSame(
            0,
            UangKeluar::count(),
            'Uang keluar TIDAK boleh dikaitkan ke SPK Dibatalkan (Rules §5 butir 3).',
        );
    }

    public function test_uang_keluar_tanpa_spk_tetap_diterima(): void
    {
        /*
         * ⚠️ PENTING: pengeluaran operasional kantor TIDAK punya SPK
         * (`spk_id` NULL). Aturan SPK Dibatalkan tidak boleh ikut memblokir
         * pengeluaran yang memang tidak terkait SPK mana pun.
         */
        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    [
                        'tanggal' => now()->toDateString(),
                        'jumlah' => 250_000,
                        'kategori' => 'operasional',
                        'keterangan' => 'ATK kantor — tanpa SPK',
                    ],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(1, UangKeluar::count());
    }

    public function test_uang_keluar_tetap_diterima_untuk_spk_berjalan(): void
    {
        $spk = $this->spkBerjalan();

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    [
                        'tanggal' => now()->toDateString(),
                        'jumlah' => 500_000,
                        'kategori' => 'material',
                        'spk_id' => $spk->id,
                        'keterangan' => 'Material pekerjaan berjalan',
                    ],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(1, UangKeluar::count());
    }
}
