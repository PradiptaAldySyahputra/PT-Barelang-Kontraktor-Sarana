<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\KategoriPengeluaran;
use App\Enums\Peran;
use App\Livewire\CashOut\CashOutForm;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Form Uang Keluar: beberapa baris sekaligus, satu baris = satu record.
 * OCR tidak diuji di sini (butuh Python + berkas nyata); yang diuji adalah
 * penyimpanan, validasi, dan penambahan/penghapusan baris.
 */
class CashOutFormTest extends TestCase
{
    use RefreshDatabase;

    private function pengguna(Peran $peran): Pengguna
    {
        return Pengguna::factory()->create(['peran' => $peran]);
    }

    /**
     * Isi satu baris pada komponen.
     */
    private function isiBaris(mixed $komponen, string $kunci, array $ubah = []): void
    {
        $komponen
            ->set("baris.$kunci.tanggal", $ubah['tanggal'] ?? now()->format('Y-m-d'))
            ->set("baris.$kunci.jumlah", $ubah['jumlah'] ?? '1500000')
            ->set("baris.$kunci.kategori", $ubah['kategori'] ?? KategoriPengeluaran::Material->value);
    }

    public function test_halaman_tambah_terbuka_untuk_admin(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin))
            ->get(route('panel.cash-out.create'))
            ->assertOk()
            ->assertSee('Tambah Baris');
    }

    public function test_direktur_sebagai_super_admin_boleh_membuka_form(): void
    {
        $this->actingAs($this->pengguna(Peran::Direktur))
            ->get(route('panel.cash-out.create'))
            ->assertOk();
    }

    public function test_menyimpan_satu_baris(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin));

        $komponen = Livewire::test(CashOutForm::class);
        $kunci = array_key_first($komponen->get('baris'));

        $this->isiBaris($komponen, $kunci, ['jumlah' => '1.500.000']);
        $komponen->call('simpan')->assertHasNoErrors();

        $this->assertSame(1, UangKeluar::query()->count());
        $this->assertSame(1_500_000.0, (float) UangKeluar::query()->value('jumlah'));
    }

    public function test_menyimpan_dua_baris_sekaligus(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin));

        $komponen = Livewire::test(CashOutForm::class);
        $komponen->call('tambahBaris');

        $kunci = array_keys($komponen->get('baris'));
        $this->assertCount(2, $kunci);

        $this->isiBaris($komponen, $kunci[0], ['jumlah' => '1000000']);
        $this->isiBaris($komponen, $kunci[1], ['jumlah' => '250000', 'kategori' => KategoriPengeluaran::Gaji->value]);

        $komponen->call('simpan')->assertHasNoErrors();

        $this->assertSame(2, UangKeluar::query()->count());
        $this->assertSame(1_250_000.0, (float) UangKeluar::query()->sum('jumlah'));
    }

    public function test_hapus_baris_menyisakan_satu(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin));

        $komponen = Livewire::test(CashOutForm::class);
        $komponen->call('tambahBaris');

        $kunci = array_keys($komponen->get('baris'));
        $komponen->call('hapusBaris', $kunci[1]);

        $this->assertCount(1, $komponen->get('baris'));
    }

    public function test_baris_tanpa_kategori_ditolak(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin));

        $komponen = Livewire::test(CashOutForm::class);
        $kunci = array_key_first($komponen->get('baris'));

        $komponen
            ->set("baris.$kunci.tanggal", now()->format('Y-m-d'))
            ->set("baris.$kunci.jumlah", '100000')
            ->set("baris.$kunci.kategori", '')
            ->call('simpan')
            ->assertHasErrors();

        $this->assertSame(0, UangKeluar::query()->count());
    }

    public function test_tanggal_besok_ditolak(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin));

        $komponen = Livewire::test(CashOutForm::class);
        $kunci = array_key_first($komponen->get('baris'));

        $this->isiBaris($komponen, $kunci, ['tanggal' => now()->addDay()->format('Y-m-d')]);
        $komponen->call('simpan')->assertHasErrors();

        $this->assertSame(0, UangKeluar::query()->count());
    }

    public function test_baris_kosong_diabaikan_saat_menyimpan(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin));

        $komponen = Livewire::test(CashOutForm::class);
        $komponen->call('tambahBaris');

        $kunci = array_keys($komponen->get('baris'));
        $this->isiBaris($komponen, $kunci[0], ['jumlah' => '900000']);
        // Baris kedua sengaja dibiarkan kosong.

        $komponen->call('simpan')->assertHasNoErrors();

        $this->assertSame(1, UangKeluar::query()->count());
        $this->assertSame(900_000.0, (float) UangKeluar::query()->value('jumlah'));
    }

    public function test_tanpa_baris_terisi_menampilkan_pesan(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin));

        Livewire::test(CashOutForm::class)
            ->call('simpan')
            ->assertHasErrors('baris');

        $this->assertSame(0, UangKeluar::query()->count());
    }

    public function test_ubah_record_tidak_membuat_record_baru(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin));

        $trx = UangKeluar::factory()->create([
            'jumlah' => 100_000,
            'kategori' => KategoriPengeluaran::Material,
        ]);

        $komponen = Livewire::test(CashOutForm::class, ['record' => $trx]);
        $kunci = array_key_first($komponen->get('baris'));

        $komponen->set("baris.$kunci.jumlah", '275000')->call('simpan')->assertHasNoErrors();

        $this->assertSame(1, UangKeluar::query()->count());
        $this->assertSame(275_000.0, (float) $trx->fresh()?->jumlah);
    }
}