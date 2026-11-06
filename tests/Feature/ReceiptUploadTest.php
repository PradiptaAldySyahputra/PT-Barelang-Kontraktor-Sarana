<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Enums\Peran;
use App\Enums\StatusSpk;
use App\Livewire\Receipt\ReceiptUploadForm;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Pengujian fitur Unggah & Ekstraksi Nota Mandiri.
 */
class ReceiptUploadTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    public function test_komponen_unggah_nota_dapat_dimount(): void
    {
        Livewire::actingAs($this->admin())
            ->test(ReceiptUploadForm::class)
            ->assertOk()
            ->assertSet('daftarNota', []);
    }

    public function test_admin_bisa_tambah_kartu_nota_manual_dan_simpan(): void
    {
        $admin = $this->admin();
        $spk = Spk::factory()->create();

        $komponen = Livewire::actingAs($admin)
            ->test(ReceiptUploadForm::class)
            ->call('tambahNotaManual')
            ->assertCount('daftarNota', 1);

        $komponen->set('daftarNota.0.tanggal', now()->toDateString());
        $komponen->set('daftarNota.0.nominal', 250000);
        $komponen->set('daftarNota.0.akun', AkunKas::Kas->value);
        $komponen->set('daftarNota.0.kategori', KategoriPengeluaran::Material->value);
        $komponen->set('daftarNota.0.penerima', 'Toko Bangunan Jaya');
        $komponen->set('daftarNota.0.keterangan', 'Beli semen 5 sak');
        $komponen->set('daftarNota.0.spk_id', $spk->id);

        $komponen->call('simpanSemua')
            ->assertHasNoErrors()
            ->assertRedirect('/panel/receipts');

        $this->assertDatabaseHas('uang_keluar', [
            'jumlah' => '250000.00',
            'kategori' => KategoriPengeluaran::Material->value,
            'penerima' => 'Toko Bangunan Jaya',
            'spk_id' => $spk->id,
        ]);
    }

    public function test_validasi_nominal_dan_tanggal_nota_diperlukan(): void
    {
        $komponen = Livewire::actingAs($this->admin())
            ->test(ReceiptUploadForm::class)
            ->call('tambahNotaManual');

        $komponen->set('daftarNota.0.tanggal', now()->addDays(2)->toDateString()); // masa depan
        $komponen->set('daftarNota.0.nominal', -5000); // minus

        $komponen->call('simpanSemua')
            ->assertHasErrors([
                'daftarNota.0.tanggal',
                'daftarNota.0.nominal',
            ]);

        $this->assertSame(0, UangKeluar::query()->count());
    }

    public function test_kategori_lainnya_wajib_isi_keterangan_dan_spk_dibatalkan_ditolak(): void
    {
        $spkBatal = Spk::factory()->create(['status_spk' => StatusSpk::Dibatalkan]);

        $komponen = Livewire::actingAs($this->admin())
            ->test(ReceiptUploadForm::class)
            ->call('tambahNotaManual');

        $komponen->set('daftarNota.0.tanggal', now()->toDateString());
        $komponen->set('daftarNota.0.nominal', 100000);
        $komponen->set('daftarNota.0.kategori', KategoriPengeluaran::Lainnya->value);
        $komponen->set('daftarNota.0.keterangan', '');

        $komponen->call('simpanSemua')
            ->assertHasErrors(['daftarNota.0.keterangan']);

        $komponen->set('daftarNota.0.keterangan', 'Biaya parkir proyek');
        $komponen->set('daftarNota.0.spk_id', $spkBatal->id);

        $komponen->call('simpanSemua')
            ->assertHasErrors(['berkasNota']);

        $this->assertSame(0, UangKeluar::query()->count());
    }
}
