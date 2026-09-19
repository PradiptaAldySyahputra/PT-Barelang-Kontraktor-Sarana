<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\KategoriMitra;
use App\Enums\KategoriPengeluaran;
use App\Enums\Peran;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tests\TestCase;

/**
 * Uji PHP Enum — pengganti tabel master.
 *
 * Enum ini WAJIB dipakai untuk memvalidasi status/kategori, karena schema
 * hanya 5 tabel (kolom berupa teks). Lihat Schema.md §7 & Rules.md §2 butir 10.
 *
 * Memakai Tests\TestCase (bukan PHPUnit\Framework\TestCase) karena butuh
 * Validator facade untuk menguji Rule::enum().
 */
class EnumTest extends TestCase
{
    // ---------------------------------------------------------
    // Peran
    // ---------------------------------------------------------

    public function test_peran_punya_dua_nilai(): void
    {
        $this->assertCount(2, Peran::cases());
        $this->assertSame('admin', Peran::Admin->value);
        $this->assertSame('direktur', Peran::Direktur->value);
    }

    public function test_hanya_admin_yang_boleh_input(): void
    {
        $this->assertTrue(Peran::Admin->bolehInput());
        $this->assertFalse(Peran::Direktur->bolehInput());
    }

    // ---------------------------------------------------------
    // StatusSpk
    // ---------------------------------------------------------

    public function test_status_spk_punya_enam_nilai(): void
    {
        $this->assertCount(6, StatusSpk::cases());
    }

    public function test_status_spk_memiliki_label(): void
    {
        $this->assertSame('Draft', StatusSpk::Draft->label());
        $this->assertSame('Sudah Ditagihkan', StatusSpk::SudahDitagihkan->label());
        $this->assertSame('Dibatalkan', StatusSpk::Dibatalkan->label());
    }

    public function test_status_dibatalkan_tidak_menerima_transaksi_baru(): void
    {
        // Rules.md §5 butir 3
        $this->assertFalse(StatusSpk::Dibatalkan->bolehTransaksiBaru());
        $this->assertTrue(StatusSpk::Berjalan->bolehTransaksiBaru());
        $this->assertTrue(StatusSpk::Terbit->bolehTransaksiBaru());
    }

    public function test_status_akhir(): void
    {
        $this->assertTrue(StatusSpk::Selesai->isAkhir());
        $this->assertTrue(StatusSpk::SudahDitagihkan->isAkhir());
        $this->assertTrue(StatusSpk::Dibatalkan->isAkhir());
        $this->assertFalse(StatusSpk::Berjalan->isAkhir());
    }

    public function test_opsi_status_spk_untuk_dropdown(): void
    {
        $opsi = StatusSpk::opsi();

        $this->assertIsArray($opsi);
        $this->assertCount(6, $opsi);
        $this->assertArrayHasKey('berjalan', $opsi);
        $this->assertSame('Berjalan', $opsi['berjalan']);
    }

    // ---------------------------------------------------------
    // StatusTagihan
    // ---------------------------------------------------------

    public function test_status_tagihan_punya_lima_nilai(): void
    {
        $this->assertCount(5, StatusTagihan::cases());
    }

    public function test_hanya_dibayar_yang_bukan_piutang(): void
    {
        $this->assertFalse(StatusTagihan::Dibayar->isPiutang());
        $this->assertTrue(StatusTagihan::BelumDitagihkan->isPiutang());
        $this->assertTrue(StatusTagihan::MenungguPembayaran->isPiutang());
    }

    // ---------------------------------------------------------
    // KategoriPengeluaran
    // ---------------------------------------------------------

    public function test_kategori_pengeluaran_punya_tujuh_nilai(): void
    {
        $this->assertCount(7, KategoriPengeluaran::cases());
    }

    public function test_kelompok_kategori(): void
    {
        $this->assertSame('Biaya Proyek', KategoriPengeluaran::Material->kelompok());
        $this->assertSame('Biaya Kantor', KategoriPengeluaran::Operasional->kelompok());
        $this->assertSame('Lain-lain', KategoriPengeluaran::Lainnya->kelompok());
    }

    // ---------------------------------------------------------
    // KategoriMitra
    // ---------------------------------------------------------

    public function test_kategori_mitra_punya_empat_nilai(): void
    {
        $this->assertCount(2, KategoriMitra::cases()); // revisi user: mitra & subkon saja
    }

    public function test_pln_dan_pelanggan_adalah_pemberi_kerja(): void
    {
        // Revisi user: PLN masuk ke `mitra`, jadi hanya `mitra` yang pemberi kerja.
        $this->assertTrue(KategoriMitra::Mitra->pemberiKerja());
        $this->assertFalse(KategoriMitra::Subkon->pemberiKerja());
    }

    // ---------------------------------------------------------
    // Validasi Rule::enum — INTI mitigasi risiko
    // ---------------------------------------------------------

    public function test_rule_enum_menolak_status_ngawur(): void
    {
        $validator = Validator::make(
            ['status_spk' => 'status_ngawur'],
            ['status_spk' => [Rule::enum(StatusSpk::class)]],
        );

        $this->assertTrue($validator->fails(), 'Status ngawur seharusnya ditolak');
    }

    public function test_rule_enum_menerima_status_valid(): void
    {
        $validator = Validator::make(
            ['status_spk' => 'berjalan'],
            ['status_spk' => [Rule::enum(StatusSpk::class)]],
        );

        $this->assertTrue($validator->passes(), 'Status valid seharusnya diterima');
    }

    public function test_rule_enum_menolak_kategori_typo(): void
    {
        // Inilah yang mencegah laporan terpecah: "Material Bangunan" ditolak,
        // hanya "material" yang diterima.
        $validator = Validator::make(
            ['kategori' => 'Material Bangunan'],
            ['kategori' => [Rule::enum(KategoriPengeluaran::class)]],
        );

        $this->assertTrue($validator->fails(), 'Kategori typo seharusnya ditolak');
    }

    public function test_rule_enum_menerima_semua_nilai_kategori(): void
    {
        foreach (KategoriPengeluaran::cases() as $kategori) {
            $validator = Validator::make(
                ['kategori' => $kategori->value],
                ['kategori' => [Rule::enum(KategoriPengeluaran::class)]],
            );

            $this->assertTrue(
                $validator->passes(),
                "Kategori {$kategori->value} seharusnya diterima"
            );
        }
    }
}
