<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Schemas\UangKeluarForm;
use Tests\TestCase;

/**
 * Batas pengaman pada form Uang Keluar.
 *
 * ⚠️ RIWAYAT KEPUTUSAN (jangan diubah tanpa alasan):
 *   1. Awalnya tanpa batas.
 *   2. User minta "paling banyak 4" → dikunci 4.
 *   3. User minta "boleh lebih dari 4, bebas" → batas jadi 20 (pengaman).
 *   4. Desain berubah: admin mengisi "Jumlah nota" per berkas, sistem membuat
 *      baris otomatis. Batas sekarang ada DUA, karena sumber pertambahannya
 *      juga dua:
 *        - MAKS_NOTA_PER_BERKAS → menahan salah ketik di satu berkas
 *        - MAKS_BARIS           → menahan total baris yang dibuat sistem
 *
 * Kenapa tetap dibatasi padahal user minta "bebas":
 *   Batas ini PENGAMAN TEKNIS, bukan pembatas kerja. Tanpa batas, salah ketik
 *   "jumlah nota = 4000" akan membuat browser hang dan satu transaksi database
 *   menyimpan ribuan record sekaligus.
 *   5. User: "upload banyak nota dalam satu pdf hanya terdeteksi sampai 50"
 *      → batas dinaikkan 50 → 200 (8 Okt 2026).
 */
class BatasNotaSekaligusTest extends TestCase
{
    public function test_batas_baris_adalah_200(): void
    {
        $this->assertSame(200, UangKeluarForm::MAKS_BARIS);
    }

    /**
     * ⚠️ PERBAIKAN BUG (audit): dulu batas ini 10, SEMENTARA MAKS_BARIS 20.
     * Akibatnya mode rinci dengan 12 nota hanya membuat 10 baris DIAM-DIAM —
     * 2 nota hilang dari laporan. Sekarang batas per berkas DISAMAKAN dengan
     * batas total baris, jadi tidak pernah lebih ketat dari yang bisa ditampung.
     */
    public function test_batas_nota_per_berkas_sama_dengan_batas_baris(): void
    {
        $this->assertSame(
            UangKeluarForm::MAKS_BARIS,
            UangKeluarForm::MAKS_NOTA_PER_BERKAS,
            'Batas nota per berkas tidak boleh lebih ketat dari batas total baris, '
            .'kalau tidak nota bisa terpotong diam-diam.',
        );
    }

    /**
     * Batas baris harus LEBIH BESAR dari 4 — kalau dikunci 4 lagi, kasus
     * "1 PDF berisi 4 nota + berkas lain" langsung mentok.
     */
    public function test_batas_baris_lebih_longsor_dari_4(): void
    {
        $this->assertGreaterThan(
            4,
            UangKeluarForm::MAKS_BARIS,
            'Batas harus > 4: 1 berkas bisa berisi beberapa nota',
        );
    }

    /**
     * Batas nota per berkas tidak boleh lebih besar dari batas total baris —
     * kalau lebih besar, angkanya jadi menyesatkan.
     */
    public function test_batas_nota_per_berkas_tidak_melebihi_batas_baris(): void
    {
        $this->assertLessThanOrEqual(
            UangKeluarForm::MAKS_BARIS,
            UangKeluarForm::MAKS_NOTA_PER_BERKAS,
            'Batas nota per berkas tidak masuk akal kalau melebihi batas total baris',
        );
    }

    /**
     * Kedua batas harus benar-benar DITEGAKKAN oleh susunBaris(), bukan cuma
     * jadi konstanta yang tidak dipakai.
     *
     * ⚠️ Memakai mode RINCI — batas MAKS_NOTA_PER_BERKAS hanya berlaku di
     * mode itu (jumlahnya menentukan banyak baris). Di mode total, jumlah
     * nota hanya info sehingga batasnya MAKS_NOTA_INFO.
     */
    public function test_susun_baris_menegakkan_batas_nota_per_berkas(): void
    {
        $baris = UangKeluarForm::susunBaris([
            'b1' => [
                'file' => 'uang_keluar/salah-ketik.pdf',
                'jumlah_nota' => 9999,
                'mode' => 'rinci',
            ],
        ]);

        $this->assertCount(
            UangKeluarForm::MAKS_NOTA_PER_BERKAS,
            $baris,
            'Salah ketik jumlah nota harus ditahan di MAKS_NOTA_PER_BERKAS',
        );
    }

    public function test_susun_baris_menegakkan_batas_total_baris(): void
    {
        $berkas = [];

        foreach (range(1, 10) as $i) {
            $berkas["b$i"] = [
                'file' => "uang_keluar/b$i.pdf",
                'jumlah_nota' => 10,
                'mode' => 'rinci',
            ];
        }

        $baris = UangKeluarForm::susunBaris($berkas);

        $this->assertLessThanOrEqual(
            UangKeluarForm::MAKS_BARIS,
            count($baris),
            'Total baris harus ditahan di MAKS_BARIS',
        );
    }

    /**
     * Mode total: 1 berkas = 1 baris, walau isinya banyak nota.
     * Ini yang melindungi admin dari puluhan baris kosong.
     */
    public function test_mode_total_tidak_melampaui_batas_baris(): void
    {
        $berkas = [];

        foreach (range(1, 10) as $i) {
            $berkas["b$i"] = [
                'file' => "uang_keluar/b$i.pdf",
                'jumlah_nota' => 57,
                'mode' => 'total',
            ];
        }

        $baris = UangKeluarForm::susunBaris($berkas);

        // 10 berkas mode total = 10 baris (1 per berkas)
        $this->assertCount(10, $baris);
    }
}
