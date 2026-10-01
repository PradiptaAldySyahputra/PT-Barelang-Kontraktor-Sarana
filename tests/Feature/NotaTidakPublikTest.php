<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\UangKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * KEAMANAN — berkas nota TIDAK BOLEH bisa diakses publik.
 *
 * ⚠️ TEMUAN AUDIT (26 Sep 2026):
 * Semua berkas nota tersimpan di disk `public` (storage/app/public) yang
 * disajikan langsung lewat symlink `public/storage`. Akibatnya:
 *
 *     GET /storage/uang_keluar/xxx.pdf  ->  200  (TANPA LOGIN)
 *
 * Nota berisi harga material, pembayaran subkon, dan gaji karyawan. Siapa pun
 * yang bisa membuka jaringan kantor dapat membaca & mengunduhnya. Ini
 * kebocoran data keuangan perusahaan.
 *
 * PERBAIKAN: nota disimpan di disk PRIVAT (`nota`), dan hanya bisa dibaca
 * lewat rute ber-otentikasi `/admin/nota/{path}` yang memeriksa login.
 *
 * ⚠️ Catatan: PHP built-in server (`php artisan serve`) TIDAK menerapkan
 * aturan `.htaccess`. Karena itu tes ini memeriksa DUA hal:
 *   1. disk penyimpanan nota bukan disk publik yang disajikan langsung;
 *   2. rute penyaji menolak pengguna yang belum login.
 */
class NotaTidakPublikTest extends TestCase
{
    use RefreshDatabase;

    public function test_disk_nota_bukan_disk_publik(): void
    {
        $rootNota = config('filesystems.disks.nota.root');
        $rootPublik = config('filesystems.disks.public.root');

        $this->assertNotNull($rootNota, 'Harus ada disk `nota` (privat) untuk berkas nota.');
        $this->assertNotSame(
            $rootPublik,
            $rootNota,
            'Berkas nota TIDAK boleh disimpan di disk publik — bisa diunduh tanpa login.',
        );

        $this->assertStringNotContainsString(
            'public',
            (string) $rootNota,
            'Disk nota harus di luar storage/app/public.',
        );
    }

    public function test_rute_nota_menolak_tanpa_login(): void
    {
        Storage::fake('nota');
        Storage::disk('nota')->put('uang_keluar/uji.pdf', 'isi nota rahasia');

        $this->get('/admin/nota/uang_keluar/uji.pdf')->assertRedirect();
    }

    public function test_rute_nota_melayani_pengguna_login(): void
    {
        Storage::fake('nota');
        Storage::disk('nota')->put('uang_keluar/uji.pdf', 'isi nota rahasia');

        $admin = Pengguna::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/admin/nota/uang_keluar/uji.pdf')
            ->assertSuccessful();
    }

    public function test_rute_nota_menolak_path_traversal(): void
    {
        Storage::fake('nota');
        $admin = Pengguna::factory()->admin()->create();

        // Percobaan keluar dari folder nota.
        $this->actingAs($admin)
            ->get('/admin/nota/..%2F..%2F.env')
            ->assertNotFound();
    }

    public function test_form_uang_keluar_memakai_disk_nota(): void
    {
        $sumber = file_get_contents(app_path('Filament/Resources/UangKeluars/Schemas/UangKeluarForm.php'));

        $this->assertStringNotContainsString(
            "default_filesystem_disk', 'public'",
            $sumber,
            'Form uang keluar masih menunjuk disk publik — nota bisa bocor.',
        );
    }

    public function test_uang_keluar_model_tetap_bisa_dibaca(): void
    {
        // Pastikan perbaikan tidak merusak fungsionalitas.
        $record = UangKeluar::factory()->create(['akun' => 'kas']);

        $this->assertDatabaseHas('uang_keluar', ['id' => $record->id]);
    }

    /**
     * Halaman form TIDAK boleh membocorkan URL publik /storage/...
     *
     * FileUpload bawaan Filament menaruh `url: /storage/...` di state preview.
     * URL itu sudah ditutup (403), jadi pratinjau akan rusak — dan lebih
     * penting, membocorkan bentuk URL lama yang tidak lagi boleh dipakai.
     */
    public function test_halaman_edit_tidak_membocorkan_url_storage(): void
    {
        Storage::fake('nota');
        Storage::disk('nota')->put('uang_keluar/uji.jpg', 'isi');

        $admin = Pengguna::factory()->admin()->create();
        $record = UangKeluar::factory()->create([
            'akun' => 'kas',
            'bukti' => ['uang_keluar/uji.jpg'],
        ]);

        $html = $this->actingAs($admin)
            ->get("/admin/uang-keluars/{$record->id}/edit")
            ->assertSuccessful()
            ->getContent();

        $this->assertStringNotContainsString(
            '/storage/uang_keluar',
            $html,
            'Form masih membocorkan URL publik /storage/ — berkas nota harus lewat rute ber-otentikasi.',
        );
    }
}
