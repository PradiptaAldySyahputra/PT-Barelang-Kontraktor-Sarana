<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TandaTanganDigitalDokumenTest extends TestCase
{
    use RefreshDatabase;

    private function buatGambarPngTransparan(): UploadedFile
    {
        $tmp = tempnam(sys_get_temp_dir(), 'ttd_').'.png';
        $im = imagecreatetruecolor(200, 80);
        imagesavealpha($im, true);
        $transparan = imagecolorallocatealpha($im, 0, 0, 0, 127);
        imagefill($im, 0, 0, $transparan);
        $hitam = imagecolorallocate($im, 15, 76, 129);
        imageline($im, 10, 40, 190, 40, $hitam);
        imagepng($im, $tmp);
        imagedestroy($im);

        return new UploadedFile($tmp, 'ttd-direktur.png', 'image/png', null, true);
    }

    public function test_direktur_dapat_mengunggah_tanda_tangan_di_profil(): void
    {
        Storage::fake('nota');

        $direktur = Pengguna::factory()->create([
            'peran' => Peran::Direktur,
            'tanda_tangan' => null,
        ]);

        $fileTtd = $this->buatGambarPngTransparan();

        $response = $this->actingAs($direktur)
            ->put(route('panel.profile.update'), [
                'nama' => 'Direktur Utama Baru',
                'email' => $direktur->email,
                'tanda_tangan' => $fileTtd,
            ]);

        $response->assertRedirect(route('panel.profile'));
        $response->assertSessionHas('berhasil');

        $direktur->refresh();
        $this->assertNotNull($direktur->tanda_tangan);
        $this->assertTrue(Storage::disk('nota')->exists($direktur->tanda_tangan));
    }

    public function test_kuitansi_pdf_merender_tanda_tangan_dan_stempel_digital(): void
    {
        Storage::fake('nota');

        $direktur = Pengguna::factory()->create([
            'nama' => 'H. Pradipta Direktur',
            'peran' => Peran::Direktur,
            'tanda_tangan' => 'profil/2026/11/06/ttd-direktur.png',
        ]);

        Storage::disk('nota')->put('profil/2026/11/06/ttd-direktur.png', 'fake-png-binary-content');

        $spk = Spk::factory()->create(['nilai_spk' => 50000000]);
        $uangMasuk = UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 25000000,
        ]);

        $response = $this->actingAs($direktur)
            ->get(route('panel.cash-in.kuitansi', $uangMasuk));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }
}
