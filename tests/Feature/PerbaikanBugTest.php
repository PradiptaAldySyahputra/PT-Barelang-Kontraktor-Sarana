<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Console\Commands\BersihkanPotonganOcr;
use App\Filament\Resources\UangKeluars\Schemas\UangKeluarForm;
use App\Services\PenyimpanBerkas;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * PERBAIKAN BUG — regresi untuk temuan audit.
 *
 * Setiap tes di sini mewakili BUG NYATA yang ditemukan saat audit, bukan
 * sekadar menambah cakupan. Kalau tes ini gagal, berarti bug-nya kembali.
 */
class PerbaikanBugTest extends TestCase
{
    /**
     * BUG 1 — URL berkas memakai APP_URL absolut.
     *
     * Aplikasi diakses dari DUA alamat: ngrok (pengembangan) dan IP LAN server
     * kantor (pemakaian admin). Kalau URL berkas diikat ke satu host saja,
     * maka di host lain SEMUA gambar & PDF nota RUSAK.
     *
     * Perbaikan: URL disk 'public' dibuat RELATIF ('/storage'), supaya
     * otomatis mengikuti alamat yang sedang dibuka admin.
     */
    public function test_url_berkas_relatif_tidak_terikat_satu_host(): void
    {
        $url = Storage::disk('public')->url('uang_keluar/nota-contoh.jpg');

        $this->assertStringStartsWith(
            '/storage/',
            $url,
            'URL berkas harus RELATIF supaya tidak rusak saat diakses dari host lain (ngrok vs LAN). '
            .'URL absolut = gambar nota rusak begitu host berubah. Didapat: '.$url,
        );

        // Tidak boleh mengandung host absolut apa pun.
        $this->assertStringNotContainsString('http://', $url, 'URL berkas tidak boleh absolut');
        $this->assertStringNotContainsString('https://', $url, 'URL berkas tidak boleh absolut');
    }

    /**
     * BUG 2 — mode RINCI diam-diam memotong nota.
     *
     * Contoh nyata: 1 PDF berisi 12 nota. Di mode rinci, admin berharap 12
     * baris. Sebelumnya sistem diam-diam hanya membuat 10 baris (batas
     * MAKS_NOTA_PER_BERKAS) TANPA memberi tahu — 2 nota hilang dari laporan.
     *
     * Perbaikan: batas per berkas disamakan dengan batas total baris
     * (MAKS_BARIS), jadi 12 nota benar-benar menghasilkan 12 baris.
     */
    public function test_mode_rinci_tidak_memotong_nota_di_bawah_batas_baris(): void
    {
        foreach ([11, 12, 15, 20] as $jumlah) {
            $baris = UangKeluarForm::susunBaris([
                'b1' => [
                    'file' => 'uang_keluar/nota.pdf',
                    'jumlah_nota' => $jumlah,
                    'mode' => 'rinci',
                ],
            ]);

            $this->assertCount(
                $jumlah,
                $baris,
                "Mode rinci dengan {$jumlah} nota harus menghasilkan {$jumlah} baris "
                .'(selama tidak melebihi MAKS_BARIS='.UangKeluarForm::MAKS_BARIS.').',
            );
        }
    }

    /**
     * Kalau jumlah nota BENAR-BENAR melebihi batas pengaman, sistem harus
     * memberi tahu admin — bukan diam-diam memotong.
     */
    public function test_pemotongan_baris_ditandai_bukan_diam_diam(): void
    {
        // Jumlah nota SENGAJA di atas batas pengaman supaya pemotongan terjadi.
        $melebihi = UangKeluarForm::MAKS_BARIS + 10;

        $baris = UangKeluarForm::susunBaris([
            'b1' => [
                'file' => 'uang_keluar/nota-sebulan.pdf',
                'jumlah_nota' => $melebihi,
                'mode' => 'rinci',
            ],
        ]);

        $this->assertCount(UangKeluarForm::MAKS_BARIS, $baris, 'Total baris tetap dibatasi pengaman');

        // Setidaknya satu baris menandai bahwa barisnya TERPOTONG, supaya
        // admin tahu ada nota yang belum tercatat — bukan dikira sudah semua.
        $adaPenanda = collect($baris)->contains(fn ($b): bool => ($b['terpotong'] ?? false) === true);

        $this->assertTrue(
            $adaPenanda,
            'Saat baris dipotong batas pengaman, baris harus ditandai `terpotong` = true '
            .'supaya admin diberi tahu — jangan diam-diam menghilangkan nota.',
        );
    }

    /**
     * BUG 3 — OCR berat bisa dimatikan oleh max_execution_time PHP.
     *
     * Berkas 57 nota butuh ~38 detik. php.ini web punya max_execution_time=30.
     * Kalau OCR dijalankan di server produksi, proses bisa dimatikan di tengah
     * jalan sehingga admin melihat error, padahal berkasnya sah.
     *
     * Perbaikan: sebelum memanggil proses Python, batas waktu PHP dilepas
     * (`set_time_limit(0)`), dan pembatasan diserahkan ke timeout OCR sendiri.
     */
    public function test_ocr_melepas_batas_waktu_php(): void
    {
        $isi = file_get_contents(app_path('Services/PembacaNota.php'));

        $this->assertStringContainsString(
            'set_time_limit',
            $isi,
            'PembacaNota harus memanggil set_time_limit(0) sebelum menjalankan OCR, '
            .'supaya berkas besar (57 nota, ~38 detik) tidak dimatikan max_execution_time PHP.',
        );
    }

    /**
     * BUG 4 — potongan OCR menumpuk tanpa pembersihan.
     *
     * Terbukti di mesin pengembangan: folder potongan mencapai 177 MB / 36
     * folder, sebagian besar sudah tidak dipakai (berkas sumbernya hilang).
     * Lama-lama disk server penuh.
     *
     * Perbaikan: ada perintah artisan `ocr:bersihkan` untuk membuang potongan
     * yatim, plus potongan dibersihkan saat record pengeluaran dihapus.
     */
    public function test_ada_perintah_bersihkan_potongan_ocr(): void
    {
        $this->assertTrue(
            class_exists(BersihkanPotonganOcr::class),
            'Harus ada perintah artisan untuk membersihkan potongan OCR yang menumpuk.',
        );

        $this->artisan('ocr:bersihkan --help')->assertSuccessful();
    }

    /**
     * Potongan milik berkas yang sudah tidak ada harus bisa dideteksi & dibuang.
     */
    public function test_potongan_yatim_dibuang(): void
    {
        Storage::fake('public');

        // Potongan YATIM: tidak ada berkas sumbernya.
        Storage::disk('public')->put('uang_keluar/potongan/'.md5('uang_keluar/hilang.pdf').'/nota_1.png', 'x');

        // Potongan yang masih dipakai: berkas sumbernya ada.
        Storage::disk('public')->put('uang_keluar/ada.pdf', 'x');
        Storage::disk('public')->put('uang_keluar/potongan/'.md5('uang_keluar/ada.pdf').'/nota_1.png', 'x');

        $this->artisan('ocr:bersihkan')->assertSuccessful();

        $this->assertFalse(
            Storage::disk('public')->exists('uang_keluar/potongan/'.md5('uang_keluar/hilang.pdf').'/nota_1.png'),
            'Potongan yatim harus dibuang.',
        );

        $this->assertTrue(
            Storage::disk('public')->exists('uang_keluar/potongan/'.md5('uang_keluar/ada.pdf').'/nota_1.png'),
            'Potongan yang masih dipakai TIDAK boleh dibuang.',
        );
    }

    /**
     * BUG 5 (PALING MENGGANGGU ADMIN) — isian admin HILANG saat baris disusun
     * ulang, sehingga muncul alert "Masih ada N baris belum lengkap" padahal
     * barisnya sudah diisi lengkap.
     *
     * Penyebab: `susunBaris()` dipanggil ULANG setiap berkas berubah (mis. OCR
     * selesai 40 detik setelah admin mulai mengetik), dan dulu selalu membuat
     * baris BARU KOSONG.
     *
     * Perbaikan: baris lama dipertahankan lewat parameter `$lama`.
     */
    public function test_isian_admin_dipertahankan_saat_baris_disusun_ulang(): void
    {
        $path = 'uang_keluar/nota-agustus.pdf';

        // Baris yang SUDAH diisi lengkap admin.
        $lama = [[
            'bukti' => [$path],
            'sumber' => $path,
            'berkas_ke' => 1,
            'berkas_dari' => 1,
            'nota_ke' => 0,
            'nota_dari' => 4,
            'mode' => 'total',
            'tanggal' => '2026-08-01',
            'jumlah' => 1_500_000,
            'kategori' => 'material',
            'penerima' => 'Toko Jaya',
        ]];

        // Baris disusun ULANG (mis. OCR selesai).
        $baru = UangKeluarForm::susunBaris(
            [['file' => [$path], 'mode' => 'total', 'jumlah_nota' => 4]],
            [],
            [$path => 4],
            $lama,
        );

        $this->assertSame(
            1_500_000,
            (int) ($baru[0]['jumlah'] ?? 0),
            'Jumlah isian admin HILANG saat baris disusun ulang — ini penyebab '
            .'alert "belum lengkap" palsu.',
        );
        $this->assertSame('material', $baru[0]['kategori'] ?? null, 'Kategori isian admin harus bertahan');
        $this->assertSame('2026-08-01', $baru[0]['tanggal'] ?? null, 'Tanggal isian admin harus bertahan');
        $this->assertSame('Toko Jaya', $baru[0]['penerima'] ?? null, 'Penerima isian admin harus bertahan');

        // Struktur tetap dari sistem, bukan dari baris lama.
        $this->assertSame('total', $baru[0]['mode']);
        $this->assertSame(0, $baru[0]['nota_ke']);
    }

    /**
     * Mode rinci: isian per nota harus bertahan di baris yang benar, walau
     * jumlah nota berubah.
     */
    public function test_isian_per_nota_bertahan_di_baris_yang_benar(): void
    {
        $path = 'uang_keluar/empat.pdf';

        $lama = [];
        foreach (range(1, 4) as $n) {
            $lama[] = [
                'bukti' => [$path],
                'sumber' => $path,
                'nota_ke' => $n,
                'nota_dari' => 4,
                'mode' => 'rinci',
                'tanggal' => '2026-08-0'.$n,
                'jumlah' => $n * 100_000,
                'kategori' => 'material',
            ];
        }

        $baru = UangKeluarForm::susunBaris(
            [['file' => [$path], 'mode' => 'rinci', 'jumlah_nota' => 4]],
            [],
            [$path => 4],
            $lama,
        );

        $this->assertCount(4, $baru);

        foreach (range(1, 4) as $n) {
            $this->assertSame(
                $n * 100_000,
                (int) ($baru[$n - 1]['jumlah'] ?? 0),
                "Isian nota ke-{$n} harus bertahan di barisnya sendiri.",
            );
        }
    }

    /**
     * Kalau barisnya KOSONG, jangan isi tanggal palsu yang membuat baris
     * tampak "sudah diisi" lalu ikut tersimpan tanpa sengaja.
     */
    public function test_baris_kosong_tetap_kosong(): void
    {
        $baru = UangKeluarForm::susunBaris(
            [['file' => ['uang_keluar/x.pdf'], 'mode' => 'total', 'jumlah_nota' => 1]],
            [],
            ['uang_keluar/x.pdf' => 1],
            [],
        );

        $this->assertEmpty($baru[0]['jumlah'] ?? null, 'Baris tanpa isian admin harus tetap kosong');
        $this->assertEmpty($baru[0]['kategori'] ?? null, 'Baris tanpa isian admin harus tetap kosong');
    }

    // =========================================================
    // KOMPRESI BERKAS SAAT UNGGAH
    // =========================================================

    /**
     * Gambar besar harus dikecilkan otomatis supaya unggah tidak berat.
     * Terbukti: foto 612 KB menyusut jadi ~79 KB (13%) tanpa kehilangan
     * keterbacaan teks.
     */
    public function test_gambar_besar_dikompres(): void
    {
        if (! function_exists('imagecreatetruecolor')) {
            $this->markTestSkipped('Ekstensi GD tidak tersedia.');
        }

        // Buat gambar MIRIP FOTO: gradien lembut (kertas) + garis tulisan +
        // noise ringan. Pola bergaris justru TERLALU terkompresi oleh PNG,
        // sehingga perbandingannya menyesatkan.
        $lebar = 3000;
        $tinggi = 4000;
        $img = imagecreatetruecolor($lebar, $tinggi);

        for ($y = 0; $y < $tinggi; $y++) {
            $t = (int) (230 - 25 * ($y / $tinggi));
            $c = imagecolorallocate($img, $t, $t, max(0, $t - 5));
            imageline($img, 0, $y, $lebar, $y, $c);
        }

        for ($i = 0; $i < 2000; $i++) {
            $c = imagecolorallocate($img, random_int(0, 60), random_int(0, 60), random_int(0, 60));
            imageline($img, random_int(100, $lebar - 100), random_int(100, $tinggi - 100), random_int(100, $lebar - 100), random_int(100, $tinggi - 100), $c);
        }

        for ($i = 0; $i < 20000; $i++) {
            $g = random_int(200, 255);
            $c = imagecolorallocate($img, $g, $g, $g);
            imagesetpixel($img, random_int(0, $lebar - 1), random_int(0, $tinggi - 1), $c);
        }

        $tmp = tempnam(sys_get_temp_dir(), 'nota').'.png';
        imagepng($img, $tmp);
        imagedestroy($img);

        $ukuranAsli = filesize($tmp);

        $hasil = app(PenyimpanBerkas::class)->kompres($tmp, 'png');

        $this->assertNotNull($hasil, 'Gambar besar harus dikompres, bukan dilewati.');
        [$isi, $ekstensi] = $hasil;

        $this->assertSame('jpg', $ekstensi, 'Hasil kompresi disimpan sebagai JPEG (jauh lebih kecil).');
        $this->assertLessThan(
            $ukuranAsli,
            strlen($isi),
            'Hasil kompresi harus lebih kecil dari aslinya.',
        );

        // Harus benar-benar terasa. Dengan pengecilan ke 2000px, hasilnya
        // jauh di bawah setengah ukuran asli.
        $this->assertLessThan(
            $ukuranAsli * 0.5,
            strlen($isi),
            'Kompresi harus signifikan (<50% ukuran asli), bukan sekadar sedikit. '
            .'Asli: '.round($ukuranAsli / 1024).' KB, hasil: '.round(strlen($isi) / 1024).' KB.',
        );

        @unlink($tmp);
    }

    /**
     * PDF TIDAK dikompres — resolusinya penting untuk membaca nota, dan PDF
     * hasil scan umumnya sudah padat.
     */
    public function test_pdf_tidak_dikompres(): void
    {
        $tmp = tempnam(sys_get_temp_dir(), 'nota').'.pdf';
        file_put_contents($tmp, '%PDF-1.4 data palsu');

        $hasil = app(PenyimpanBerkas::class)->kompres($tmp, 'pdf');

        $this->assertNull($hasil, 'PDF tidak boleh dikompres di sini.');

        @unlink($tmp);
    }

    /**
     * Berkas rusak / bukan gambar: kompresi harus MENOLAK dengan aman
     * (kembalikan null), bukan melempar exception yang menggagalkan unggah.
     */
    public function test_berkas_rusak_tidak_menggagalkan_unggah(): void
    {
        $tmp = tempnam(sys_get_temp_dir(), 'rusak').'.jpg';
        file_put_contents($tmp, 'ini bukan gambar sama sekali');

        $hasil = app(PenyimpanBerkas::class)->kompres($tmp, 'jpg');

        $this->assertNull($hasil, 'Berkas rusak harus ditolak dengan aman (null), bukan error.');

        @unlink($tmp);
    }
}
