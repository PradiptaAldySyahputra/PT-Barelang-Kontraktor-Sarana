<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Schemas\UangKeluarForm;
use Tests\TestCase;

/**
 * DRAF ISI NOTA → BARIS FORM (permintaan user 8 Okt 2026).
 *
 * User: "user mau di crop atau dipotong untuk setiap nota jadi ketika ada
 * 25 nota berarti ada 25 form berdasarkan nota yang di crop" — dan isi tiap
 * nota (nominal dll) dibaca OCR lalu DIISI OTOMATIS sebagai DRAF.
 *
 * ⚠️ PRINSIP PALING PENTING YANG DIUJI DI SINI
 * Draf OCR TIDAK BOLEH menimpa isian admin. Nota banyak yang tulisan tangan
 * dan bisa salah baca; kalau draf menimpa ketikan admin, laporan keuangan
 * bisa rusak diam-diam. Karena itu urutan penggabungan di `susunBaris()`:
 * struktur → draf OCR → isian admin (admin menang).
 */
class DrafIsiNotaKeBarisTest extends TestCase
{
    /**
     * Draf OCR mengisi baris saat admin BELUM mengisi apa pun.
     */
    public function test_draf_ocr_mengisi_baris_kosong(): void
    {
        $path = 'uang_keluar/empat.pdf';

        $petaIsi = [
            $path => [
                ['nominal' => 150000, 'tanggal' => '2026-03-15', 'penerima' => 'Toko Jaya', 'kategori' => 'material', 'keterangan' => 'Semen 3 sak'],
                ['nominal' => 75000, 'tanggal' => null, 'penerima' => null, 'kategori' => 'upah', 'keterangan' => null],
            ],
        ];

        $baris = UangKeluarForm::susunBaris(
            [['file' => [$path], 'jumlah_nota' => 2, 'mode' => 'rinci']],
            [],
            [],
            [],
            $petaIsi,
        );

        $this->assertCount(2, $baris);
        $this->assertSame(150000, $baris[0]['jumlah']);
        $this->assertSame('Toko Jaya', $baris[0]['penerima']);
        $this->assertSame('material', $baris[0]['kategori']);
        $this->assertSame(75000, $baris[1]['jumlah']);
        $this->assertSame('upah', $baris[1]['kategori']);
        $this->assertArrayNotHasKey('penerima', $baris[1], 'Field kosong draf tidak dipaksa terisi');
    }

    /**
     * ⚠️ TES PALING PENTING — isian ADMIN menang atas draf OCR.
     */
    public function test_isian_admin_menang_atas_draf_ocr(): void
    {
        $path = 'uang_keluar/satu.pdf';

        $lama = [
            'k1' => [
                'bukti' => [$path],
                'nota_ke' => 1,
                'jumlah' => 999999,   // admin sudah mengetik ini
                'kategori' => 'gaji', // admin sudah memilih ini
                'penerima' => 'Penerima Pilihan Admin',
            ],
        ];

        $petaIsi = [
            $path => [
                ['nominal' => 150000, 'penerima' => 'Toko Jaya', 'kategori' => 'material'],
            ],
        ];

        $baris = UangKeluarForm::susunBaris(
            [['file' => [$path], 'jumlah_nota' => 1, 'mode' => 'rinci']],
            [],
            [],
            $lama,
            $petaIsi,
        );

        $this->assertSame(999999, $baris[0]['jumlah'], 'Draf OCR TIDAK boleh menimpa jumlah isian admin');
        $this->assertSame('gaji', $baris[0]['kategori'], 'Draf OCR TIDAK boleh menimpa kategori isian admin');
        $this->assertSame('Penerima Pilihan Admin', $baris[0]['penerima'], 'Draf OCR TIDAK boleh menimpa penerima isian admin');
    }

    /**
     * Kategori draf yang tidak valid tidak dipakai (dropdown tidak terisi asing).
     */
    public function test_kategori_draf_tidak_valid_diabaikan(): void
    {
        $path = 'uang_keluar/dua.pdf';

        $baris = UangKeluarForm::susunBaris(
            [['file' => [$path], 'jumlah_nota' => 1, 'mode' => 'rinci']],
            [],
            [],
            [],
            [$path => [['nominal' => 10000, 'kategori' => 'kategori-ngawur']]],
        );

        $this->assertArrayNotHasKey('kategori', $baris[0]);
    }

    /**
     * Tanpa draf OCR, baris tetap disusun (perilaku lama tidak rusak).
     */
    public function test_tanpa_draf_ocr_baris_tetap_dibuat(): void
    {
        $baris = UangKeluarForm::susunBaris([
            ['file' => ['uang_keluar/tiga.pdf'], 'jumlah_nota' => 3, 'mode' => 'rinci'],
        ]);

        $this->assertCount(3, $baris);
    }

    /**
     * 25 nota → 25 baris (permintaan user: "kalau ada 25 nota berarti ada 25 form").
     */
    public function test_dua_puluh_lima_nota_menghasilkan_dua_puluh_lima_baris(): void
    {
        $baris = UangKeluarForm::susunBaris([
            ['file' => ['uang_keluar/bulan.pdf'], 'jumlah_nota' => 25, 'mode' => 'rinci'],
        ]);

        $this->assertCount(25, $baris, '25 nota harus menghasilkan 25 baris (batas 50)');
    }
}
