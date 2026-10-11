<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Schemas\UangKeluarForm;
use Tests\TestCase;

/**
 * SALIN ISIAN KE BARIS KOSONG (duplikat baris).
 *
 * ⚠️ SARAN USER (9 Okt 2026):
 * "Duplikat baris — tombol 'salin baris ini' untuk nota sejenis (beda nominal
 *  saja)."
 *
 * ⚠️ KENAPA "KE BARIS KOSONG", bukan menambah baris baru:
 * Repeater `pengeluaran` sengaja TIDAK bisa tambah/hapus manual — barisnya
 * disusun otomatis dari jumlah nota tiap berkas (`susunBaris()`). Menambah baris
 * manual justru menghasilkan baris tanpa nota. Jadi yang benar adalah menyalin
 * isian ke baris yang SUDAH ada tapi masih kosong.
 */
class SalinBarisUangKeluarTest extends TestCase
{
    public function test_menyalin_isian_ke_baris_kosong(): void
    {
        $items = [
            'a' => ['jumlah' => 50000, 'kategori' => 'material', 'penerima' => 'Toko Jaya', 'spk_id' => 7],
            'b' => ['jumlah' => null, 'kategori' => null],
            'c' => ['jumlah' => null, 'kategori' => null],
        ];

        $hasil = UangKeluarForm::salinIsianKeBarisKosong($items, 'a');

        $this->assertSame(2, $hasil['jumlah']);
        $this->assertSame('material', $hasil['items']['b']['kategori']);
        $this->assertSame('Toko Jaya', $hasil['items']['b']['penerima']);
        $this->assertSame(7, $hasil['items']['b']['spk_id']);
        $this->assertSame('material', $hasil['items']['c']['kategori']);
    }

    public function test_nominal_tidak_ikut_disalin(): void
    {
        $items = [
            'a' => ['jumlah' => 50000, 'kategori' => 'material'],
            'b' => ['jumlah' => null],
        ];

        $hasil = UangKeluarForm::salinIsianKeBarisKosong($items, 'a');

        $this->assertNull(
            $hasil['items']['b']['jumlah'] ?? null,
            'Nominal harus tetap kosong — itu yang berbeda antar nota sejenis.',
        );
    }

    public function test_baris_yang_sudah_terisi_tidak_ditimpa(): void
    {
        $items = [
            'a' => ['jumlah' => 50000, 'kategori' => 'material'],
            'b' => ['jumlah' => 99999, 'kategori' => 'upah'],
        ];

        $hasil = UangKeluarForm::salinIsianKeBarisKosong($items, 'a');

        $this->assertSame(0, $hasil['jumlah']);
        $this->assertSame('upah', $hasil['items']['b']['kategori']);
        $this->assertSame(99999, $hasil['items']['b']['jumlah']);
    }

    public function test_indeks_tidak_valid_tidak_merusak(): void
    {
        $items = ['a' => ['jumlah' => 1]];

        $hasil = UangKeluarForm::salinIsianKeBarisKosong($items, 'zzz');

        $this->assertSame(0, $hasil['jumlah']);
        $this->assertSame($items, $hasil['items']);
    }

    public function test_kolom_kosong_pada_sumber_tidak_menimpa(): void
    {
        $items = [
            'a' => ['jumlah' => 1000, 'kategori' => 'material', 'penerima' => null],
            'b' => ['jumlah' => null, 'penerima' => 'Sudah Ada'],
        ];

        $hasil = UangKeluarForm::salinIsianKeBarisKosong($items, 'a');

        $this->assertSame('material', $hasil['items']['b']['kategori']);
        $this->assertSame(
            'Sudah Ada',
            $hasil['items']['b']['penerima'],
            'Penerima yang sudah diisi tidak boleh ditimpa nilai kosong dari sumber.',
        );
    }
}
