<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Schemas\UangKeluarForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * REGRESI BUG-B — "semua baris terisi tapi alert 'belum lengkap'".
 *
 * Temuan 9 Okt 2026. `gabungBaris()` dulu memakai ulang kunci baris lama
 * BERDASARKAN POSISI. Saat jumlah baris berubah (mis. OCR selesai belakangan),
 * kunci bergeser ke nota yang berbeda → pilihan dropdown (Kategori) di browser
 * nyasar → tersimpan null → baris dianggap "belum lengkap" padahal sudah diisi.
 *
 * Perbaikan: kunci dicocokkan lewat IDENTITAS baris (sumber berkas + nota_ke).
 * Tes ini mengunci perilaku itu.
 */
class KunciBarisTetapTest extends TestCase
{
    use RefreshDatabase;

    public function test_kunci_baris_tetap_saat_jumlah_baris_berubah(): void
    {
        $berkas = [
            'a' => ['file' => ['uang_keluar/a.pdf'], 'jumlah_nota' => 4, 'mode' => 'rinci'],
            'b' => ['file' => ['uang_keluar/b.pdf'], 'jumlah_nota' => 4, 'mode' => 'rinci'],
        ];

        $lama = UangKeluarForm::susunBaris($berkas);
        $lamaUuid = [];
        foreach ($lama as $r) {
            $lamaUuid[(string) Str::uuid()] = $r;
        }
        $lama = $lamaUuid;

        foreach ($lama as $k => $r) {
            $lama[$k]['jumlah'] = 100000;
            $lama[$k]['kategori'] = 'material';
            $lama[$k]['tanggal'] = '2026-09-01';
        }

        $identitasAwal = [];
        foreach ($lama as $k => $r) {
            $identitasAwal[$k] = ($r['sumber'] ?? '?').'|'.$r['nota_ke'];
        }

        // OCR selesai belakangan: berkas A ternyata 2 nota (bukan 4).
        $berkasBaru = [
            'a' => ['file' => ['uang_keluar/a.pdf'], 'jumlah_nota' => 2, 'mode' => 'rinci'],
            'b' => ['file' => ['uang_keluar/b.pdf'], 'jumlah_nota' => 4, 'mode' => 'rinci'],
        ];

        $baru = UangKeluarForm::susunBaris($berkasBaru, [], [], $lama, []);

        $m = new \ReflectionMethod(UangKeluarForm::class, 'gabungBaris');
        $m->setAccessible(true);
        $hasil = $m->invoke(null, $lama, $baru);

        foreach ($hasil as $k => $r) {
            $identitas = ($r['sumber'] ?? '?').'|'.$r['nota_ke'];

            // Setiap kunci yang dipakai ulang HARUS masih menunjuk nota yang sama.
            if (isset($identitasAwal[$k])) {
                $this->assertSame(
                    $identitasAwal[$k],
                    $identitas,
                    'Kunci baris bergeser ke nota lain — ini penyebab BUG-B.',
                );
            }
        }

        // Isian admin tidak boleh hilang untuk baris yang masih ada.
        $jumlahTerisi = collect($hasil)->filter(
            fn ($r): bool => filled($r['jumlah'] ?? null),
        )->count();

        $this->assertGreaterThanOrEqual(
            2,
            $jumlahTerisi,
            'Isian admin pada baris yang masih ada tidak boleh hilang.',
        );
    }

    public function test_kunci_baris_baru_mendapat_uuid_saat_nota_bertambah(): void
    {
        $lama = UangKeluarForm::susunBaris([
            'a' => ['file' => ['uang_keluar/a.pdf'], 'jumlah_nota' => 2, 'mode' => 'rinci'],
        ]);
        $lamaUuid = [];
        foreach ($lama as $r) {
            $lamaUuid[(string) Str::uuid()] = $r;
        }

        // Bertambah jadi 4 nota.
        $baru = UangKeluarForm::susunBaris([
            'a' => ['file' => ['uang_keluar/a.pdf'], 'jumlah_nota' => 4, 'mode' => 'rinci'],
        ]);

        $m = new \ReflectionMethod(UangKeluarForm::class, 'gabungBaris');
        $m->setAccessible(true);
        $hasil = $m->invoke(null, $lamaUuid, $baru);

        // 2 baris lama dipertahankan kuncinya, 2 baris baru dapat kunci baru.
        $this->assertCount(4, $hasil);
        $kunciBaru = array_diff(array_keys($hasil), array_keys($lamaUuid));
        $this->assertCount(2, $kunciBaru, 'Dua baris baru harus dapat kunci UUID baru.');
    }
}
