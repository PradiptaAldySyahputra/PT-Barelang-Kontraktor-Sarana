<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Support\PembacaIsiNota;
use PHPUnit\Framework\TestCase;

/**
 * PEMBACA ISI NOTA (PHP) — mengurai teks OCR jadi draf field.
 *
 * ⚠️ KENAPA PARSER DIPISAH & DIUJI DI SINI
 * Nota proyek ini banyak TULISAN TANGAN, jadi OCR sering salah baca
 * (contoh nyata dari berkas asli: "580m", "y59r000", "42 8a0"). Parser karena
 * itu dirancang TOLERAN: ia mengambil angka terbesar di baris "Total", bukan
 * menuntut format sempurna. Hasilnya selalu DRAF — admin WAJIB konfirmasi.
 *
 * Tes ini mengunci perilaku parser memakai teks OCR NYATA (dari berkas
 * 57-nota) supaya perbaikan tidak menurunkan kualitas baca.
 */
class PembacaIsiNotaTest extends TestCase
{
    public function test_mengurai_nominal_dari_baris_total(): void
    {
        $hasil = PembacaIsiNota::urai([
            'NOTA No. :',
            'BANYAK URAIAN HARGA JUMLAH',
            'Semen 50-00 3.375.000',
            'Total Rp. 3.375.000',
        ]);

        $this->assertSame(3375000, $hasil['nominal']);
    }

    public function test_mengambil_angka_setelah_label_total(): void
    {
        // Kasus nyata: label "Total Rp." di satu baris, angkanya di baris lain.
        $hasil = PembacaIsiNota::urai([
            'Kepada Yth:',
            'Total Rp.',
            '13.900',
        ]);

        $this->assertSame(13900, $hasil['nominal']);
    }

    public function test_fallback_ke_angka_terbesar(): void
    {
        // Tanpa label "Total", ambil angka terbesar yang wajar.
        $hasil = PembacaIsiNota::urai([
            'Semen 50-00',
            'Batu 80-000',
        ]);

        $this->assertSame(80000, $hasil['nominal']);
    }

    public function test_mengurai_tanggal(): void
    {
        $hasil = PembacaIsiNota::urai([
            'NOTA No. :',
            'Tanggal 15/03/2026',
        ]);

        $this->assertSame('2026-03-15', $hasil['tanggal']);
    }

    public function test_mengurai_penerima_setelah_kepada_yth(): void
    {
        $hasil = PembacaIsiNota::urai([
            'Kepada Yth:',
            'Toko Bangunan Jaya',
            'NOTA No. :',
        ]);

        $this->assertSame('Toko Bangunan Jaya', $hasil['penerima']);
    }

    public function test_menyarankan_kategori_material(): void
    {
        $hasil = PembacaIsiNota::urai([
            'Semen 3 sak',
            'Pasir 1 truk',
        ]);

        $this->assertSame('material', $hasil['kategori']);
    }

    public function test_menyarankan_kategori_upah(): void
    {
        $hasil = PembacaIsiNota::urai([
            'Upah tukang 3 hari',
        ]);

        $this->assertSame('upah', $hasil['kategori']);
    }

    public function test_keyakinan_tinggi_kalau_lengkap(): void
    {
        $hasil = PembacaIsiNota::urai([
            'Kepada Yth:',
            'Toko Material Contoh',
            'Tanggal 01/02/2026',
            'Total Rp. 1.500.000',
        ]);

        $this->assertSame('tinggi', $hasil['keyakinan']);
    }

    public function test_keyakinan_rendah_kalau_tidak_ada_apa_apa(): void
    {
        $hasil = PembacaIsiNota::urai(['---']);

        $this->assertSame('rendah', $hasil['keyakinan']);
        $this->assertNull($hasil['nominal']);
    }

    public function test_terima_teks_berbentuk_array_koordinat(): void
    {
        // Bentuk asli dari skrip Python: daftar {"teks": ..., "x": ..., "y": ...}.
        $hasil = PembacaIsiNota::urai([
            ['teks' => 'Kepada Yth:', 'x' => 10, 'y' => 10],
            ['teks' => 'Toko Maju', 'x' => 10, 'y' => 20],
            ['teks' => 'Total Rp. 250.000', 'x' => 10, 'y' => 30],
        ]);

        $this->assertSame('Toko Maju', $hasil['penerima']);
        $this->assertSame(250000, $hasil['nominal']);
    }

    public function test_aman_untuk_input_kosong(): void
    {
        $hasil = PembacaIsiNota::urai([]);

        $this->assertNull($hasil['nominal']);
        $this->assertNull($hasil['tanggal']);
        $this->assertNull($hasil['penerima']);
        $this->assertNull($hasil['kategori']);
        $this->assertSame('rendah', $hasil['keyakinan']);
    }
}
