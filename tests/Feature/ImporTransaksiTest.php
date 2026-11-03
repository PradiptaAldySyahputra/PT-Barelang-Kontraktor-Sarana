<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\StatusSpk;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use App\Support\ImporTransaksi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * IMPOR TRANSAKSI (B3-13) - append-only + cegah duplikat.
 *
 * ⚠️ KENAPA DIUJI:
 * Impor data massal berbahaya: kalau salah, data keuangan bisa tergandakan
 * atau tertimpa. Tes ini mengunci dua janji:
 *   1. impor TIDAK mengubah/menghapus data lama (append-only);
 *   2. impor ulang berkas yang sama TIDAK menggandakan (cegah duplikat).
 */
class ImporTransaksiTest extends TestCase
{
    use RefreshDatabase;

    // Uang masuk

    public function test_impor_uang_masuk_menambah_baris(): void
    {
        $hasil = ImporTransaksi::uangMasuk([
            ['tanggal' => '2026-01-05', 'jumlah' => '1.500.000', 'akun' => 'Kas', 'keterangan' => 'Setoran awal'],
            ['tanggal' => '2026-01-06', 'jumlah' => 2500000, 'akun' => 'Bank', 'keterangan' => 'Transfer'],
        ]);

        $this->assertSame(2, $hasil['ditambah']);
        $this->assertSame(0, $hasil['dilewati']);
        $this->assertSame(2, UangMasuk::count());
        $this->assertSame(1_500_000.0, (float) UangMasuk::first()->jumlah);
    }

    public function test_impor_ulang_tidak_menggandakan(): void
    {
        $baris = [
            ['tanggal' => '2026-01-05', 'jumlah' => 1_500_000, 'akun' => 'Kas', 'keterangan' => 'Setoran awal'],
        ];

        $pertama = ImporTransaksi::uangMasuk($baris);
        $kedua = ImporTransaksi::uangMasuk($baris);

        $this->assertSame(1, $pertama['ditambah']);
        $this->assertSame(0, $kedua['ditambah']);
        $this->assertSame(1, $kedua['dilewati']);
        $this->assertSame(1, UangMasuk::count(), 'Impor ulang tidak boleh menggandakan.');
    }

    public function test_impor_append_only_tidak_menyentuh_data_lama(): void
    {
        $lama = UangMasuk::factory()->create(['jumlah' => 9_000_000, 'keterangan' => 'Data lama']);

        ImporTransaksi::uangMasuk([
            ['tanggal' => '2026-02-01', 'jumlah' => 100_000, 'akun' => 'Kas', 'keterangan' => 'Baru'],
        ]);

        $lama->refresh();
        $this->assertSame('9000000.00', $lama->jumlah, 'Data lama tidak boleh berubah.');
        $this->assertSame('Data lama', $lama->keterangan);
        $this->assertSame(2, UangMasuk::count());
    }

    public function test_baris_tidak_valid_dilaporkan_dan_dilewati(): void
    {
        $hasil = ImporTransaksi::uangMasuk([
            ['tanggal' => '', 'jumlah' => '', 'akun' => 'Kas'],
            ['tanggal' => '2026-01-05', 'jumlah' => 1_000_000, 'akun' => 'Kas', 'keterangan' => 'Valid'],
        ]);

        $this->assertSame(1, $hasil['ditambah']);
        $this->assertCount(1, $hasil['gagal']);
        $this->assertSame(1, UangMasuk::count());
    }

    // Uang keluar

    public function test_impor_uang_keluar_dengan_kategori(): void
    {
        $hasil = ImporTransaksi::uangKeluar([
            ['tanggal' => '2026-03-01', 'jumlah' => 500_000, 'akun' => 'Kas', 'kategori' => 'material', 'penerima' => 'Toko A', 'keterangan' => 'Beli semen'],
        ]);

        $this->assertSame(1, $hasil['ditambah']);
        $this->assertSame(1, UangKeluar::count());
        $this->assertSame('material', UangKeluar::first()->kategori->value);
    }

    public function test_impor_uang_keluar_cegah_duplikat(): void
    {
        $baris = [
            ['tanggal' => '2026-03-01', 'jumlah' => 500_000, 'akun' => 'Kas', 'kategori' => 'material', 'keterangan' => 'Beli semen'],
        ];

        ImporTransaksi::uangKeluar($baris);
        $kedua = ImporTransaksi::uangKeluar($baris);

        $this->assertSame(0, $kedua['ditambah']);
        $this->assertSame(1, $kedua['dilewati']);
        $this->assertSame(1, UangKeluar::count());
    }

    // Normalisasi angka

    public function test_format_angka_indonesia_dinormalisasi(): void
    {
        ImporTransaksi::uangMasuk([
            ['tanggal' => '2026-04-01', 'jumlah' => 'Rp 1.500.000', 'akun' => 'Kas', 'keterangan' => 'A'],
            ['tanggal' => '2026-04-02', 'jumlah' => '2,500,000', 'akun' => 'Kas', 'keterangan' => 'B'],
            ['tanggal' => '2026-04-03', 'jumlah' => '1500000', 'akun' => 'Kas', 'keterangan' => 'C'],
        ]);

        $jumlah = UangMasuk::orderBy('tanggal')->pluck('jumlah')->map(fn ($j) => (float) $j)->all();

        $this->assertSame([1_500_000.0, 2_500_000.0, 1_500_000.0], $jumlah);
    }

    public function test_cegah_duplikat_bisa_dimatikan(): void
    {
        $baris = [
            ['tanggal' => '2026-05-01', 'jumlah' => 100_000, 'akun' => 'Kas', 'keterangan' => 'X'],
        ];

        ImporTransaksi::uangMasuk($baris);
        $kedua = ImporTransaksi::uangMasuk($baris, cegahDuplikat: false);

        $this->assertSame(1, $kedua['ditambah']);
        $this->assertSame(2, UangMasuk::count());
    }

    // BUG-2: impor WAJIB menegakkan aturan bisnis yang sama dengan form.

    public function test_impor_uang_masuk_melebihi_piutang_ditolak(): void
    {
        $spk = Spk::factory()->pln()->berjalan()->create(['nilai_spk' => 100_000_000]);

        $hasil = ImporTransaksi::uangMasuk([
            ['tanggal' => '2026-01-05', 'jumlah' => 150_000_000, 'akun' => 'Kas', 'spk_id' => $spk->id, 'keterangan' => 'Terlalu besar'],
        ]);

        $this->assertSame(0, $hasil['ditambah'], 'Melebihi piutang harus ditolak.');
        $this->assertCount(1, $hasil['gagal']);
        $this->assertStringContainsString('melebihi nilai SPK', $hasil['gagal'][0]);
        $this->assertSame(0, UangMasuk::count());
    }

    public function test_impor_uang_masuk_sampai_sisa_piutang_diterima(): void
    {
        $spk = Spk::factory()->pln()->berjalan()->create(['nilai_spk' => 100_000_000]);

        // Tepat sama dengan nilai SPK → masih boleh (batas toleransi 0.01).
        $hasil = ImporTransaksi::uangMasuk([
            ['tanggal' => '2026-01-05', 'jumlah' => 100_000_000, 'akun' => 'Kas', 'spk_id' => $spk->id],
        ]);

        $this->assertSame(1, $hasil['ditambah']);
        $this->assertSame([], $hasil['gagal']);
    }

    public function test_impor_uang_masuk_akumulasi_batch_tidak_melebihi_piutang(): void
    {
        $spk = Spk::factory()->pln()->berjalan()->create(['nilai_spk' => 100_000_000]);

        // Dua baris ke SPK yang SAMA; masing-masing 60jt → total 120jt > 100jt.
        // Baris pertama lolos, baris kedua HARUS ditolak (akumulasi dalam batch).
        $hasil = ImporTransaksi::uangMasuk([
            ['tanggal' => '2026-01-05', 'jumlah' => 60_000_000, 'akun' => 'Kas', 'spk_id' => $spk->id, 'keterangan' => 'A'],
            ['tanggal' => '2026-01-06', 'jumlah' => 60_000_000, 'akun' => 'Kas', 'spk_id' => $spk->id, 'keterangan' => 'B'],
        ]);

        $this->assertSame(1, $hasil['ditambah'], 'Hanya baris pertama yang boleh masuk.');
        $this->assertCount(1, $hasil['gagal']);
        $this->assertSame(1, UangMasuk::count());
    }

    public function test_impor_uang_masuk_ke_spk_dibatalkan_ditolak(): void
    {
        $spk = Spk::factory()->pln()->create([
            'nilai_spk' => 100_000_000,
            'status_spk' => StatusSpk::Dibatalkan,
        ]);

        $hasil = ImporTransaksi::uangMasuk([
            ['tanggal' => '2026-01-05', 'jumlah' => 1_000_000, 'akun' => 'Kas', 'spk_id' => $spk->id],
        ]);

        $this->assertSame(0, $hasil['ditambah']);
        $this->assertCount(1, $hasil['gagal']);
        $this->assertStringContainsString('Dibatalkan', $hasil['gagal'][0]);
        $this->assertSame(0, UangMasuk::count());
    }

    public function test_impor_uang_keluar_ke_spk_dibatalkan_ditolak(): void
    {
        $spk = Spk::factory()->pln()->create([
            'nilai_spk' => 100_000_000,
            'status_spk' => StatusSpk::Dibatalkan,
        ]);

        $hasil = ImporTransaksi::uangKeluar([
            ['tanggal' => '2026-01-05', 'jumlah' => 1_000_000, 'akun' => 'Kas', 'kategori' => 'material', 'spk_id' => $spk->id],
        ]);

        $this->assertSame(0, $hasil['ditambah']);
        $this->assertCount(1, $hasil['gagal']);
        $this->assertSame(0, UangKeluar::count());
    }

    public function test_impor_tanggal_masa_depan_ditolak(): void
    {
        $besok = now()->addDay()->toDateString();

        $hasil = ImporTransaksi::uangMasuk([
            ['tanggal' => $besok, 'jumlah' => 1_000_000, 'akun' => 'Kas', 'keterangan' => 'Masa depan'],
        ]);

        $this->assertSame(0, $hasil['ditambah']);
        $this->assertCount(1, $hasil['gagal']);
        $this->assertStringContainsString('melebihi hari ini', $hasil['gagal'][0]);
        $this->assertSame(0, UangMasuk::count());
    }

    public function test_impor_uang_keluar_tanpa_spk_tetap_boleh(): void
    {
        // Biaya operasional (tanpa SPK) tidak dibatasi piutang.
        $hasil = ImporTransaksi::uangKeluar([
            ['tanggal' => '2026-01-05', 'jumlah' => 5_000_000, 'akun' => 'Kas', 'kategori' => 'operasional'],
        ]);

        $this->assertSame(1, $hasil['ditambah']);
        $this->assertSame([], $hasil['gagal']);
    }

    // BUG-1: kinerja - sidik jari dihitung SEKALI, bukan O(n²).

    public function test_impor_banyak_baris_cepat_dan_tanpa_duplikat(): void
    {
        // 500 baris unik.
        $baris = [];

        for ($i = 1; $i <= 500; $i++) {
            $baris[] = [
                'tanggal' => '2026-01-'.str_pad((string) (($i % 28) + 1), 2, '0', STR_PAD_LEFT),
                'jumlah' => 100_000 + $i,
                'akun' => 'Kas',
                'keterangan' => 'Baris '.$i,
            ];
        }

        $mulai = microtime(true);
        $hasil = ImporTransaksi::uangMasuk($baris);
        $durasi = microtime(true) - $mulai;

        $this->assertSame(500, $hasil['ditambah']);
        $this->assertSame(500, UangMasuk::count());

        // Dengan O(n²) (500×500 = 250.000 kali parse), ini akan jauh lebih
        // lambat. Batas longgar 5 detik cukup untuk menangkap regresi berat.
        $this->assertLessThan(5.0, $durasi, 'Impor 500 baris tidak boleh lambat (regresi O(n²)?).');
    }

    public function test_impor_batch_berisi_baris_kembar_tidak_menggandakan(): void
    {
        // Dua baris IDENTIK di dalam satu batch - hanya satu yang masuk.
        $hasil = ImporTransaksi::uangMasuk([
            ['tanggal' => '2026-01-05', 'jumlah' => 1_000_000, 'akun' => 'Kas', 'keterangan' => 'Kembar'],
            ['tanggal' => '2026-01-05', 'jumlah' => 1_000_000, 'akun' => 'Kas', 'keterangan' => 'Kembar'],
        ]);

        $this->assertSame(1, $hasil['ditambah']);
        $this->assertSame(1, $hasil['dilewati']);
        $this->assertSame(1, UangMasuk::count());
    }
}
