<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

/**
 * UJI REGRESI: komentar Blade tidak boleh bocor jadi teks di layar.
 *
 * Latar masalah (12 Okt 2026): saat menghapus banner dekoratif
 * (`{{-- ==== ... ==== --}}`), baris PEMBUKA `{{-- ====` ikut terhapus
 * sementara penutup `==== --}}` tertinggal. Akibatnya isi komentar
 * (mis. "PEMILIH PERIODE") tercetak sebagai teks di halaman Laporan -
 * terlihat berantakan dan membingungkan pengguna.
 *
 * Tes ini menjaga: setiap berkas Blade punya jumlah pembuka `{{--`
 * dan penutup `--}}` yang SEIMBANG, dan tidak ada baris `====` yang
 * berada di LUAR komentar.
 */
class KomentarBladeTest extends TestCase
{
    /**
     * @return list<string>
     */
    private function berkasBlade(): array
    {
        $akar = resource_path('views');
        $hasil = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($akar, \FilesystemIterator::SKIP_DOTS),
        );

        foreach ($iterator as $berkas) {
            if ($berkas->isFile() && str_ends_with($berkas->getFilename(), '.blade.php')) {
                $hasil[] = $berkas->getPathname();
            }
        }

        return $hasil;
    }

    public function test_setiap_blade_punya_komentar_yang_seimbang(): void
    {
        $rusak = [];

        foreach ($this->berkasBlade() as $berkas) {
            $isi = file_get_contents($berkas);
            $buka = substr_count($isi, '{{--');
            $tutup = substr_count($isi, '--}}');

            if ($buka !== $tutup) {
                $rusak[] = str_replace(resource_path('views').'/', '', $berkas)
                    ." (buka=$buka, tutup=$tutup)";
            }
        }

        $this->assertSame(
            [],
            $rusak,
            "Komentar Blade tidak seimbang (isi komentar akan bocor jadi teks):\n".implode("\n", $rusak),
        );
    }

    public function test_tidak_ada_baris_banner_di_luar_komentar(): void
    {
        $bocor = [];

        foreach ($this->berkasBlade() as $berkas) {
            $baris = file($berkas, FILE_IGNORE_NEW_LINES);
            $dalamKomentar = false;

            foreach ($baris as $nomor => $isi) {
                // Lacak buka/tutup komentar (blade tidak mendukung komentar bersarang).
                $sisa = $isi;
                while ($sisa !== '') {
                    if (! $dalamKomentar && str_starts_with($sisa, '{{--')) {
                        $dalamKomentar = true;
                        $sisa = substr($sisa, 4);

                        continue;
                    }
                    if ($dalamKomentar && str_starts_with($sisa, '--}}')) {
                        $dalamKomentar = false;
                        $sisa = substr($sisa, 4);

                        continue;
                    }
                    $sisa = substr($sisa, 1);
                }

                $teks = trim($isi);
                if (! $dalamKomentar && preg_match('/^={5,}$/', $teks)) {
                    $bocor[] = str_replace(resource_path('views').'/', '', $berkas)
                        .':'.($nomor + 1);
                }
            }
        }

        $this->assertSame(
            [],
            $bocor,
            "Baris banner '====' ditemukan DI LUAR komentar (bocor ke tampilan):\n".implode("\n", $bocor),
        );
    }
}
