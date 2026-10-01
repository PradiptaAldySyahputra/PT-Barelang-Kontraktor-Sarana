<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Schemas\UangKeluarForm;
use App\Services\PembacaNota;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * OCR NOTA — pembagian tanggung jawab.
 *
 * Permintaan user: "coba lanjutkan ke ocr karna pc server nanti agak kencang
 * speknya".
 *
 * YANG DIOKUSI DI SINI
 * --------------------
 * OCR dipakai HANYA untuk:
 *   1. Menghitung jumlah nota di dalam satu berkas.
 *   2. Menentukan posisi tiap nota (potongan pratinjau).
 *
 * OCR TIDAK membaca nominal rupiah. Ini keputusan sadar: salah hitung jumlah
 * nota ringan (admin ubah angkanya), salah baca nominal bisa langsung masuk
 * laporan keuangan.
 *
 * PRINSIP PALING PENTING YANG DIUJI DI SINI:
 * OCR adalah BANTUAN. Kalau OCR mati atau gagal, form HARUS tetap berfungsi —
 * admin mengisi jumlah nota manual seperti sebelumnya. Sistem tidak boleh
 * ikut rusak hanya karena Python belum terpasang di server.
 */
class OcrNotaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('nota');
    }

    // =========================================================
    // 1. OCR MATI -> SISTEM TETAP JALAN (paling penting)
    // =========================================================

    /**
     * ⚠️ TES PALING PENTING.
     *
     * Server yang belum dipasangi Python harus tetap bisa memakai sistem.
     * Kalau tes ini gagal, artinya OCR membuat sistem bergantung pada Python —
     * dan itu tidak boleh.
     */
    public function test_ocr_default_mati(): void
    {
        $this->assertFalse(
            config('ocr.aktif'),
            'OCR harus default MATI supaya server tanpa Python tetap jalan',
        );
    }

    public function test_pembaca_nota_mengembalikan_gagal_saat_ocr_mati(): void
    {
        config(['ocr.aktif' => false]);

        $hasil = app(PembacaNota::class)->baca('uang_keluar/apa-saja.pdf');

        $this->assertFalse($hasil['ok'], 'OCR mati harus mengembalikan ok=false');
        $this->assertSame(1, $hasil['jumlah_nota'], 'Fallback: 1 nota supaya form tetap jalan');
        $this->assertIsArray($hasil['potongan']);
    }

    /**
     * Kegagalan OCR tidak boleh melempar exception ke form.
     */
    public function test_pembaca_nota_tidak_melempar_exception_kalau_berkas_hilang(): void
    {
        config(['ocr.aktif' => true]);

        $hasil = app(PembacaNota::class)->baca('uang_keluar/tidak-ada.pdf');

        $this->assertFalse($hasil['ok']);
        $this->assertStringContainsString('tidak ditemukan', strtolower((string) $hasil['alasan']));
    }

    public function test_pembaca_nota_tangani_path_kosong(): void
    {
        config(['ocr.aktif' => true]);

        $hasil = app(PembacaNota::class)->baca('');

        $this->assertFalse($hasil['ok']);
        $this->assertArrayHasKey('alasan', $hasil);
    }

    // =========================================================
    // 2. KONFIGURASI
    // =========================================================

    public function test_konfigurasi_ocr_ada(): void
    {
        $this->assertIsBool(config('ocr.aktif'));
        $this->assertIsString(config('ocr.python'));
        $this->assertIsInt(config('ocr.timeout'));
        $this->assertStringEndsWith('ocr_nota.py', (string) config('ocr.skrip'));
    }

    public function test_skrip_ocr_benar_benar_ada(): void
    {
        $this->assertFileExists(
            config('ocr.skrip'),
            'Skrip Python OCR harus ada di python/ocr_nota.py',
        );
    }

    /**
     * Skrip OCR harus SELALU mengeluarkan JSON, tidak pernah exception mentah.
     * Ini yang membuat sisi PHP bisa memperlakukan kegagalan dengan aman.
     */
    public function test_skrip_ocr_selalu_mengeluarkan_json(): void
    {
        $skrip = (string) file_get_contents(config('ocr.skrip'));

        $this->assertStringContainsString('json.dumps', $skrip);
        $this->assertStringContainsString('"ok": False', $skrip);
        // Semua jalur keluar lewat fungsi keluaran() -> selalu JSON.
        $this->assertStringContainsString('def keluaran', $skrip);
        $this->assertStringContainsString('def gagal', $skrip);
    }

    /**
     * Skrip OCR TIDAK boleh membaca nominal rupiah.
     *
     * Ini batas keselamatan yang disepakati: salah baca nominal bisa langsung
     * masuk laporan keuangan. Kalau ada yang menambahkan pembacaan nominal
     * tanpa sengaja, tes ini menangkapnya.
     *
     * CATATAN: komentar & docstring sengaja DIBUANG dulu, karena di sana kata
     * "nominal" justru muncul untuk menjelaskan bahwa OCR TIDAK membacanya.
     */
    public function test_skrip_ocr_tidak_membaca_nominal_rupiah(): void
    {
        $mentah = (string) file_get_contents(config('ocr.skrip'));

        // Buang docstring (""" ... """) lalu buang komentar (# ...).
        $kode = (string) preg_replace('/""".*?"""/s', '', $mentah);
        $kode = (string) preg_replace('/#.*$/m', '', $kode);

        foreach (['jumlah_rp', 'nominal', 'total_rupiah', 'harga'] as $terlarang) {
            $this->assertStringNotContainsString(
                $terlarang,
                strtolower($kode),
                "Kode OCR tidak boleh membaca '$terlarang' — nominal diisi admin",
            );
        }
    }

    /**
     * Keluaran JSON skrip tidak boleh memuat kolom nominal.
     */
    public function test_keluaran_json_tidak_memuat_nominal(): void
    {
        $skrip = (string) file_get_contents(config('ocr.skrip'));

        foreach (['"jumlah_rp"', '"nominal"', '"total"'] as $kunci) {
            $this->assertStringNotContainsString(
                $kunci,
                $skrip,
                "Keluaran OCR tidak boleh memuat kunci $kunci",
            );
        }
    }

    // =========================================================
    // 3. POTONGAN NOTA -> TIAP BARIS PUNYA NOTANYA SENDIRI
    // =========================================================

    /**
     * Ini yang menyelesaikan masalah lama: 1 PDF 4 nota -> 4 baris
     * menampilkan gambar yang SAMA. Sekarang tiap baris dapat potongannya.
     *
     * Potongan dikirim lewat parameter `$petaPotongan` (path berkas -> daftar
     * potongan), BUKAN dari dalam item repeater. Ini penting: menyimpan
     * potongan di dalam item repeater pernah menyebabkan hasil OCR terhapus
     * oleh re-entrancy `afterStateUpdated` (lihat catatan di repeaterBerkas()).
     */
    public function test_potongan_diteruskan_ke_tiap_baris(): void
    {
        $path = 'uang_keluar/empat.pdf';

        $peta = [
            $path => [
                'uang_keluar/potongan/x/nota_1.png',
                'uang_keluar/potongan/x/nota_2.png',
                'uang_keluar/potongan/x/nota_3.png',
            ],
        ];

        $baris = UangKeluarForm::susunBaris([
            ['file' => [$path], 'jumlah_nota' => 3, 'mode' => 'rinci'],
        ], $peta);

        $this->assertCount(3, $baris);

        foreach ([0, 1, 2] as $i) {
            $this->assertSame(
                'uang_keluar/potongan/x/nota_'.($i + 1).'.png',
                $baris[$i]['potongan'],
                'Tiap baris harus dapat potongan notanya sendiri',
            );
        }
    }

    /**
     * REGRESI: potongan di dalam item repeater tetap dihormati.
     *
     * Ini jalur cadangan (mis. dipanggil dari tempat lain yang belum punya
     * peta potongan). Kalau cadangan ini hilang, potongan bisa lenyap lagi.
     */
    public function test_potongan_dari_item_repeater_tetap_dipakai(): void
    {
        $baris = UangKeluarForm::susunBaris([
            [
                'file' => ['uang_keluar/dua.pdf'],
                'jumlah_nota' => 2,
                'mode' => 'rinci',
                'potongan' => [
                    'uang_keluar/potongan/y/nota_1.png',
                    'uang_keluar/potongan/y/nota_2.png',
                ],
            ],
        ]);

        $this->assertCount(2, $baris);
        $this->assertSame('uang_keluar/potongan/y/nota_1.png', $baris[0]['potongan']);
        $this->assertSame('uang_keluar/potongan/y/nota_2.png', $baris[1]['potongan']);
    }

    /**
     * Peta potongan MENANG atas item repeater kalau keduanya ada.
     *
     * Karena peta adalah state terbaru (hasil OCR paling akhir), sedangkan
     * item repeater bisa berisi data basi.
     */
    public function test_peta_potongan_menang_atas_item_repeater(): void
    {
        $path = 'uang_keluar/satu.pdf';

        $baris = UangKeluarForm::susunBaris([
            [
                'file' => [$path],
                'jumlah_nota' => 1,
                'mode' => 'rinci',
                'potongan' => ['uang_keluar/potongan/LAMA/nota_1.png'],
            ],
        ], [
            $path => ['uang_keluar/potongan/BARU/nota_1.png'],
        ]);

        $this->assertSame(
            'uang_keluar/potongan/BARU/nota_1.png',
            $baris[0]['potongan'],
            'Peta potongan (state terbaru) harus menang atas item repeater',
        );
    }

    /**
     * Kalau OCR gagal (tidak ada potongan), baris tetap dibuat tanpa potongan.
     * Pratinjau akan menampilkan berkas utuh — perilaku lama, tetap benar.
     */
    public function test_baris_tetap_dibuat_tanpa_potongan(): void
    {
        $baris = UangKeluarForm::susunBaris([
            ['file' => ['uang_keluar/dua.pdf'], 'jumlah_nota' => 2, 'mode' => 'rinci'],
        ]);

        $this->assertCount(2, $baris);
        $this->assertNull($baris[0]['potongan']);
        $this->assertNull($baris[1]['potongan']);
    }

    /**
     * Jumlah potongan lebih sedikit dari jumlah nota -> jangan sampai error.
     */
    public function test_potongan_kurang_dari_jumlah_nota_aman(): void
    {
        $baris = UangKeluarForm::susunBaris([
            [
                'file' => ['uang_keluar/tiga.pdf'],
                'jumlah_nota' => 3,
                'mode' => 'rinci',
                'potongan' => ['uang_keluar/potongan/x/nota_1.png'],
            ],
        ]);

        $this->assertCount(3, $baris);
        $this->assertSame('uang_keluar/potongan/x/nota_1.png', $baris[0]['potongan']);
        $this->assertNull($baris[1]['potongan'], 'Baris tanpa potongan tidak boleh error');
        $this->assertNull($baris[2]['potongan']);
    }

    // =========================================================
    // 4. TAMPILAN
    // =========================================================

    public function test_pratinjau_memakai_potongan_kalau_ada(): void
    {
        $view = file_get_contents(
            resource_path('views/filament/components/pratinjau-nota.blade.php')
        );

        $this->assertStringContainsString('$potongan', $view);
        $this->assertStringContainsString('potonganBersih', $view);
    }

    public function test_ada_komponen_pesan_ocr(): void
    {
        $this->assertFileExists(
            resource_path('views/filament/components/info-ocr.blade.php'),
        );

        $view = file_get_contents(resource_path('views/filament/components/info-ocr.blade.php'));

        // Pesan harus menegaskan nominal diisi manual.
        $this->assertStringContainsString('Nominal tetap diisi manual', $view);
        $this->assertStringContainsString('OCR tidak membaca angka', $view);
    }

    /**
     * Form harus benar-benar memanggil OCR saat berkas diunggah.
     */
    public function test_form_memanggil_ocr_saat_berkas_diunggah(): void
    {
        $form = file_get_contents(
            app_path('Filament/Resources/UangKeluars/Schemas/UangKeluarForm.php')
        );

        $this->assertStringContainsString('bacaDenganOcr', $form);
        $this->assertStringContainsString('afterStateUpdated', $form);
        // Kegagalan OCR harus ditangkap, bukan dibiarkan naik.
        $this->assertStringContainsString('catch (Throwable', $form);
    }
}
