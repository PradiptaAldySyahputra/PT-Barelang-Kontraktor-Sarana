<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Exports\SpkExporter;
use App\Filament\Pages\EksporUnduhanPage;
use App\Models\Pengguna;
use App\Support\RiwayatEkspor;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * EKSPOR & UNDUHAN (peta menu C) — riwayat ekspor + unduh ulang.
 *
 * ⚠️ KENAPA DIUJI:
 * Halaman riwayat harus menampilkan status ekspor dengan benar dan route unduh
 * ulang harus AMAN: Admin hanya berkas miliknya, berkas yang belum selesai /
 * hilang ditolak.
 */
class EksporUnduhanTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    private function direktur(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Direktur]);
    }

    private function buatEkspor(Pengguna $user, bool $selesai = true, string $isi = 'DATA'): Export
    {
        Storage::fake('local');

        $ekspor = Export::create([
            'completed_at' => $selesai ? now() : null,
            'file_disk' => 'local',
            'file_name' => 'spk.xlsx',
            'exporter' => SpkExporter::class,
            'processed_rows' => 5,
            'total_rows' => 5,
            'successful_rows' => 5,
            'user_id' => $user->id,
        ]);

        if ($selesai) {
            Storage::disk('local')->put(
                $ekspor->getFileDirectory().DIRECTORY_SEPARATOR.'spk.xlsx',
                $isi,
            );
        }

        return $ekspor;
    }

    // ---------------------------------------------------------
    // RiwayatEkspor
    // ---------------------------------------------------------

    public function test_riwayat_menandai_selesai_dan_diproses(): void
    {
        $user = $this->admin();
        $this->buatEkspor($user, selesai: true);
        $this->buatEkspor($user, selesai: false);

        $daftar = RiwayatEkspor::daftar();

        $this->assertCount(2, $daftar);
        $status = $daftar->pluck('status')->all();
        $this->assertContains('selesai', $status);
        $this->assertContains('diproses', $status);
    }

    public function test_riwayat_label_jenis_data(): void
    {
        $this->buatEkspor($this->admin());

        $this->assertSame('Data SPK', RiwayatEkspor::daftar()->first()['jenis']);
    }

    public function test_riwayat_menandai_berkas_bisa_diunduh(): void
    {
        $this->buatEkspor($this->admin(), selesai: true);

        $this->assertTrue(RiwayatEkspor::daftar()->first()['bisa_unduh']);
    }

    // ---------------------------------------------------------
    // Halaman
    // ---------------------------------------------------------

    public function test_halaman_bisa_dibuka_admin(): void
    {
        $this->actingAs($this->admin());

        Livewire::test(EksporUnduhanPage::class)
            ->assertOk()
            ->assertSee('Ekspor & Unduhan')
            ->assertSee('Riwayat Ekspor');
    }

    public function test_admin_hanya_melihat_riwayat_miliknya(): void
    {
        $admin = $this->admin();
        $lain = $this->admin();

        $this->buatEkspor($admin, selesai: true);
        $this->buatEkspor($lain, selesai: true);

        $this->actingAs($admin);

        Livewire::test(EksporUnduhanPage::class)
            ->assertOk()
            ->assertSee('spk.xlsx');

        // Riwayat yang dipetakan hanya milik admin ini.
        $this->assertCount(1, RiwayatEkspor::daftar($admin->id));
    }

    // ---------------------------------------------------------
    // Route unduh
    // ---------------------------------------------------------

    public function test_unduh_ulang_ekspor_milik_sendiri(): void
    {
        $admin = $this->admin();
        $ekspor = $this->buatEkspor($admin, selesai: true, isi: 'ISI-XLSX');

        $this->actingAs($admin)
            ->get(route('ekspor.unduh', ['ekspor' => $ekspor->id]))
            ->assertOk()
            ->assertDownload('spk.xlsx');
    }

    public function test_unduh_ditolak_untuk_ekspor_orang_lain(): void
    {
        $admin = $this->admin();
        $lain = $this->admin();
        $ekspor = $this->buatEkspor($lain, selesai: true);

        $this->actingAs($admin)
            ->get(route('ekspor.unduh', ['ekspor' => $ekspor->id]))
            ->assertForbidden();
    }

    public function test_direktur_boleh_mengunduh_ekspor_siapa_pun(): void
    {
        $admin = $this->admin();
        $ekspor = $this->buatEkspor($admin, selesai: true);

        $this->actingAs($this->direktur())
            ->get(route('ekspor.unduh', ['ekspor' => $ekspor->id]))
            ->assertOk();
    }

    public function test_unduh_ditolak_bila_belum_selesai(): void
    {
        $admin = $this->admin();
        $ekspor = $this->buatEkspor($admin, selesai: false);

        $this->actingAs($admin)
            ->get(route('ekspor.unduh', ['ekspor' => $ekspor->id]))
            ->assertNotFound();
    }

    public function test_unduh_butuh_login(): void
    {
        $ekspor = $this->buatEkspor($this->admin(), selesai: true);

        $this->get(route('ekspor.unduh', ['ekspor' => $ekspor->id]))
            ->assertRedirect();
    }
}
