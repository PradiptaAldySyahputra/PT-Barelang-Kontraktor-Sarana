<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Jobs\EkstrakNotaOcr;
use App\Livewire\Receipt\ReceiptUploadForm;
use App\Models\Pengguna;
use App\Services\PembacaNota;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * AUD-6: OCR nota dipindah ke job antrean + diambil lewat polling.
 *
 * Yang diuji: job menitipkan hasil ke cache, dan komponen mengubah hasil itu
 * menjadi kartu isian saat `periksaHasilOcr()` dipanggil.
 */
class NotaOcrQueueTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_menitipkan_hasil_ocr_ke_cache(): void
    {
        $this->mock(PembacaNota::class, function ($mock): void {
            $mock->shouldReceive('baca')
                ->once()
                ->with('uang_keluar/nota.pdf', 'nota')
                ->andReturn([
                    'ok' => true,
                    'jumlah_nota' => 1,
                    'metode' => 'ocr',
                    'nota' => [['ke' => 1, 'nominal' => 150000, 'penerima' => 'Toko Jaya']],
                ]);
        });

        (new EkstrakNotaOcr('kunci-uji', 'uang_keluar/nota.pdf'))->handle(app(PembacaNota::class));

        $hasil = Cache::get(EkstrakNotaOcr::kunciCache('kunci-uji'));

        $this->assertIsArray($hasil);
        $this->assertTrue($hasil['ok']);
        $this->assertSame('Toko Jaya', $hasil['nota'][0]['penerima']);
    }

    public function test_job_yang_gagal_tetap_menitipkan_hasil_agar_form_tidak_macet(): void
    {
        $this->mock(PembacaNota::class, function ($mock): void {
            $mock->shouldReceive('baca')->once()->andThrow(new \RuntimeException('python mati'));
        });

        (new EkstrakNotaOcr('kunci-gagal', 'uang_keluar/nota.pdf'))->handle(app(PembacaNota::class));

        $hasil = Cache::get(EkstrakNotaOcr::kunciCache('kunci-gagal'));

        $this->assertIsArray($hasil);
        $this->assertFalse($hasil['ok']);
    }

    public function test_komponen_mengubah_hasil_cache_menjadi_kartu_nota(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin]);

        Cache::put(EkstrakNotaOcr::kunciCache('kunci-komponen'), [
            'ok' => true,
            'jumlah_nota' => 2,
            'metode' => 'ocr',
            'nota' => [
                ['ke' => 1, 'nominal' => 100000, 'penerima' => 'Toko A'],
                ['ke' => 2, 'nominal' => 200000, 'penerima' => 'Toko B'],
            ],
        ], now()->addHour());

        Livewire::actingAs($admin)
            ->test(ReceiptUploadForm::class)
            ->set('sedangProses', true)
            ->set('kunciOcr', 'kunci-komponen')
            ->call('periksaHasilOcr')
            ->assertSet('sedangProses', false)
            ->assertSet('kunciOcr', null)
            ->assertCount('daftarNota', 2)
            ->assertSet('daftarNota.1.penerima', 'Toko B');

        $this->assertNull(Cache::get(EkstrakNotaOcr::kunciCache('kunci-komponen')));
    }

    public function test_polling_tanpa_hasil_belum_mengubah_apa_pun(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin]);

        Livewire::actingAs($admin)
            ->test(ReceiptUploadForm::class)
            ->set('sedangProses', true)
            ->set('kunciOcr', 'belum-selesai')
            ->call('periksaHasilOcr')
            ->assertSet('sedangProses', true)
            ->assertSet('kunciOcr', 'belum-selesai')
            ->assertCount('daftarNota', 0);
    }
}
