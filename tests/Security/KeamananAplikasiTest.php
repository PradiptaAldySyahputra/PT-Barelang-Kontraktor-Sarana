<?php

declare(strict_types=1);

namespace Tests\Security;

use App\Enums\KategoriMitra;
use App\Enums\KategoriPengeluaran;
use App\Enums\Peran;
use App\Livewire\CashOut\CashOutForm;
use App\Models\Pengguna;
use App\Models\Spk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use OpenSpout\Reader\XLSX\Reader;
use Tests\TestCase;

/**
 * Pengujian Keamanan Sistem & Celah Aplikasi:
 *
 * 1. Otorisasi Peran: Tamu & Akun Nonaktif wajib ditolak (403/Redirect Login).
 * 2. Proteksi Hak Akses Khusus: Admin dilarang mengakses Manajemen Akun Pengguna (/panel/users).
 * 3. Proteksi Path Traversal & Berkas Privat:
 *    - Akses bukti nota langsung dari URL publik tidak boleh bocor (403).
 *    - Unduh berkas dengan karakter manipulasi ('..', '/', '\\') wajib ditangkal.
 * 4. Proteksi File Upload Jahat (Malicious Uploads):
 *    - File executable (.php, .phtml, .sh, .exe) wajib ditolak oleh validasi mime/ekstensi.
 * 5. Proteksi Open Redirect:
 *    - Parameter `?asal=https://evil.com` atau nilai di luar daftar putih tidak boleh meloloskan redirect ke domain eksternal.
 * 6. Proteksi Integritas Data Keuangan:
 *    - Nilai nominal negatif, manipulasi desimal, dan injeksi karakter string ditolak.
 * 7. Header Keamanan HTTP:
 *    - X-Frame-Options, X-Content-Type-Options, Referrer-Policy, CSP.
 */
class KeamananAplikasiTest extends TestCase
{
    use RefreshDatabase;

    public function test_tamu_dan_akun_nonaktif_ditolak_mengakses_panel(): void
    {
        // 1. Tamu diarahkan ke login
        $this->get(route('panel.dashboard'))
            ->assertRedirect(route('panel.login'));

        // 2. Akun nonaktif dilempar ke 403 Forbidden
        $akunMati = Pengguna::factory()->create([
            'is_aktif' => false,
            'peran' => Peran::Admin,
        ]);

        $this->actingAs($akunMati)
            ->get(route('panel.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_tidak_bisa_mengakses_manajemen_pengguna(): void
    {
        $admin = Pengguna::factory()->create([
            'peran' => Peran::Admin,
            'is_aktif' => true,
        ]);

        $this->actingAs($admin)
            ->get('/panel/users')
            ->assertForbidden();

        $this->actingAs($admin)
            ->post('/panel/users', [
                'nama' => 'Hacker User',
                'email' => 'hacker@bks.test',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'peran' => Peran::Admin->value,
            ])
            ->assertForbidden();
    }

    public function test_bukti_nota_privat_tidak_bisa_diakses_langsung_tanpa_otentikasi(): void
    {
        Storage::fake('nota');
        Storage::disk('nota')->put('uang_keluar/2026/11/06/nota-rahasia.jpg', 'isi rahasia harga vendor');

        $this->get('/storage/uang_keluar/2026/11/06/nota-rahasia.jpg')
            ->assertForbidden();
    }

    public function test_unduh_arsip_nota_mencegah_path_traversal(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);

        // Manipulasi path dengan base64 path traversal
        $pathJahat = base64_encode('../../../../etc/passwd');

        $this->actingAs($admin)
            ->get(route('arsip-nota.unduh', ['path' => $pathJahat, 'nama' => 'passwd']))
            ->assertNotFound();
    }

    public function test_unggah_berkas_berbahaya_ditolak(): void
    {
        Storage::fake('nota');
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);

        $filePhp = UploadedFile::fake()->create('backdoor.php', 10, 'application/x-php');

        $response = $this->actingAs($admin)
            ->post(route('panel.cash-in.store'), [
                'mode' => 'manual',
                'tanggal' => now()->toDateString(),
                'akun' => 'kas',
                'jumlah' => '1000000',
                'keterangan' => 'Uji upload berbahaya',
                'bukti' => [$filePhp],
            ]);

        $response->assertSessionHasErrors(['bukti.0']);
    }

    public function test_parameter_asal_mencegah_open_redirect(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);
        $spk = Spk::factory()->create();

        // Coba injeksi domain luar di query param asal
        $response = $this->actingAs($admin)
            ->get(route('panel.spk.show', [$spk, 'asal' => 'https://evil-attacker-site.com']));

        $response->assertOk();
        // Memastikan HTML tidak merender URL jahat secara mentah sebagai link kembali
        $response->assertDontSee('https://evil-attacker-site.com');
    }

    public function test_header_keamanan_terpasang_pada_respons(): void
    {
        $response = $this->get('/panel/login');

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    public function test_input_teks_dengan_payload_xss_lolos_sanitasi_dan_tidak_dieksekusi(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);

        $payloadXss = '<script>alert("XSS-ATTACK")</script>';

        $response = $this->actingAs($admin)
            ->post(route('panel.partners.store'), [
                'nama' => 'Mitra Uji '.$payloadXss,
                'kategori' => KategoriMitra::Mitra->value,
                'kontak' => '08123456789',
                'alamat' => 'Batam Center',
            ]);

        $response->assertRedirect(route('panel.partners.index'));

        // Pastikan tersimpan dan dirender dengan escaping Blade {{ }} bukan raw {!! !!}
        $halaman = $this->actingAs($admin)->get(route('panel.partners.index'));
        $halaman->assertOk();
        $halaman->assertSee('&lt;script&gt;alert(&quot;XSS-ATTACK&quot;)&lt;/script&gt;', false);
        $halaman->assertDontSee('<script>alert("XSS-ATTACK")</script>', false);
    }

    public function test_ekspor_xlsx_dan_csv_menangkal_injeksi_formula_spreadsheet(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);

        Spk::factory()->create([
            'nomor_spk' => 'SPK/FORMULA/2026/001',
            'nama_pekerjaan' => '=CMD|\' /C calc\'!A0',
            'nilai_spk' => 15_000_000,
        ]);

        // 1. Uji CSV
        $resCsv = $this->actingAs($admin)
            ->get(route('laporan.ekspor', ['jenis' => 'spk', 'format' => 'csv']));
        $resCsv->assertOk();
        $this->assertStringContainsString("'=CMD|", $resCsv->streamedContent());

        // 2. Uji XLSX
        $resXlsx = $this->actingAs($admin)
            ->get(route('laporan.ekspor', ['jenis' => 'spk', 'format' => 'xlsx']));
        $resXlsx->assertOk();

        $dasar = tempnam(sys_get_temp_dir(), 'uji_formula');
        $path = $dasar.'.xlsx';
        @unlink((string) $dasar);
        file_put_contents($path, $resXlsx->streamedContent());

        try {
            $reader = new Reader;
            $reader->open($path);
            $sel = [];
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {
                    foreach ($row->toArray() as $val) {
                        $sel[] = (string) $val;
                    }
                }
            }
            $reader->close();
        } finally {
            @unlink($path);
        }

        $gabung = implode(' | ', $sel);
        $this->assertStringContainsString("'=CMD|", $gabung);
    }

    public function test_validasi_nominal_minus_atau_nol_ditolak_pada_transaksi_keuangan(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);
        $spk = Spk::factory()->create(['nilai_spk' => 10_000_000]);

        // 1. Cash In: nominal minus ditolak
        $this->actingAs($admin)
            ->post(route('panel.cash-in.store'), [
                'mode' => 'spk',
                'spk_id' => $spk->id,
                'akun' => 'kas',
                'tanggal' => now()->toDateString(),
                'jumlah' => '-500000',
            ])
            ->assertSessionHasErrors('jumlah');

        // 2. Cash In: nominal nol ditolak
        $this->actingAs($admin)
            ->post(route('panel.cash-in.store'), [
                'mode' => 'spk',
                'spk_id' => $spk->id,
                'akun' => 'kas',
                'tanggal' => now()->toDateString(),
                'jumlah' => '0',
            ])
            ->assertSessionHasErrors('jumlah');

        // 3. SPK: nilai_spk minus ditolak
        $this->actingAs($admin)
            ->post(route('panel.spk.store'), [
                'nomor_spk' => 'SPK/MINUS/001',
                'nama_pekerjaan' => 'Proyek Minus',
                'nilai_spk' => '-1000000',
                'status_antar' => 'belum_diantar',
                'dikerjakan_oleh' => 'sendiri',
            ])
            ->assertSessionHasErrors('nilai_spk');
    }

    public function test_cash_out_form_livewire_menolak_nominal_minus_atau_nol(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);

        Livewire::actingAs($admin)
            ->test(CashOutForm::class)
            ->set('baris.uji.tanggal', now()->toDateString())
            ->set('baris.uji.jumlah', '-150000')
            ->set('baris.uji.kategori', KategoriPengeluaran::Material->value)
            ->call('simpan')
            ->assertHasErrors(['baris.*.jumlah']);
    }
}
