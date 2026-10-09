<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Pages\CreateUangKeluar;
use App\Filament\Resources\UangMasuks\Pages\CreateUangMasuk;
use App\Models\Pengguna;
use Filament\Forms\Components\FileUpload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * CELAH KEAMANAN — BUKTI UANG MASUK BOCOR (audit 8 Okt 2026).
 *
 * TEMUAN: `UangMasukForm` TIDAK menyetel `->disk('nota')` pada FileUpload
 * bukti, sedangkan `UangKeluarForm` menyetelnya. Karena `.env` memakai
 * `FILESYSTEM_DISK=public`, berkas bukti Uang Masuk jatuh ke disk PUBLIK dan
 * bisa diunduh SIAPA PUN TANPA LOGIN lewat `/storage/uang_masuk/...`.
 *
 * Nota memuat harga material, pembayaran subkon, dan gaji karyawan — jadi ini
 * kebocoran serius, bukan sekadar kosmetik.
 *
 * Tes ini MENGUNCI perbaikan: FileUpload bukti Uang Masuk WAJIB di disk privat
 * `nota`, dan tidak boleh ada FileUpload bukti yang jatuh ke disk default.
 *
 * Cara uji: bangun halaman create (Livewire) lalu telusuri komponen schema-nya.
 * Ini mengikuti pola yang sudah terbukti di TataLetakUangKeluarTest.
 */
class BuktiUangMasukPrivatTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-bukti-masuk@bks.test',
        ]);
    }

    /**
     * Kumpulkan semua FileUpload di schema halaman → [nama => disk].
     *
     * @return array<string, string|null>
     */
    private function semuaFileUpload(string $halaman): array
    {
        $this->actingAs($this->admin);

        $schema = Livewire::test($halaman)->instance()->getSchema('form');
        $hasil = [];

        $telusuri = function ($k) use (&$telusuri, &$hasil): void {
            if ($k instanceof FileUpload) {
                $hasil[(string) $k->getName()] = $k->getDiskName();
            }

            if (method_exists($k, 'getDefaultChildComponents')) {
                foreach ($k->getDefaultChildComponents() as $anak) {
                    $telusuri($anak);
                }
            }
        };

        foreach ($schema->getComponents(withActions: false) as $k) {
            $telusuri($k);
        }

        return $hasil;
    }

    /**
     * ⚠️ TES INTI — FileUpload bukti Uang Masuk HARUS di disk `nota`.
     */
    public function test_bukti_uang_masuk_di_disk_privat_nota(): void
    {
        $peta = $this->semuaFileUpload(CreateUangMasuk::class);

        $this->assertArrayHasKey('bukti', $peta, 'Form Uang Masuk harus punya FileUpload bukti.');

        $this->assertSame(
            'nota',
            $peta['bukti'],
            'FileUpload bukti Uang Masuk WAJIB memakai disk privat `nota`. '
            .'Disk null berarti jatuh ke FILESYSTEM_DISK (=public) → bocor tanpa login.',
        );
    }

    /**
     * Uang Keluar tetap benar (tidak boleh regresi). Field unggahnya bernama
     * `file` (di dalam repeater `berkas_nota`).
     */
    public function test_bukti_uang_keluar_tetap_di_disk_privat_nota(): void
    {
        $peta = $this->semuaFileUpload(CreateUangKeluar::class);

        $this->assertArrayHasKey('file', $peta, 'Form Uang Keluar harus punya FileUpload berkas.');
        $this->assertSame('nota', $peta['file']);
    }

    /**
     * Penjaga umum: TIDAK boleh ada FileUpload apa pun yang jatuh ke disk
     * default (null). Kalau ada form baru lupa `->disk('nota')`, tes ini gagal.
     */
    public function test_tidak_ada_fileupload_tanpa_disk_nota(): void
    {
        foreach ([
            'Uang Masuk' => CreateUangMasuk::class,
            'Uang Keluar' => CreateUangKeluar::class,
        ] as $label => $halaman) {
            foreach ($this->semuaFileUpload($halaman) as $nama => $disk) {
                $this->assertSame(
                    'nota',
                    $disk,
                    "FileUpload '$nama' di form $label tidak di disk `nota` (dapat: "
                    .var_export($disk, true).'). Berkas bukti tidak boleh di disk publik.',
                );
            }
        }
    }
}
