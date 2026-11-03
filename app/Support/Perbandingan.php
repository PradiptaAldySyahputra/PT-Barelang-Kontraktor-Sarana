<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Perbandingan angka dengan periode sebelumnya (mis. "bulan ini vs bulan lalu").
 *
 * ⚠️ SARAN USER (9 Okt 2026):
 * "Hindari angka mentah tanpa konteks - selalu pasangkan dengan perbandingan
 *  (bulan lalu, target)."
 *
 * Angka "Rp 1.500.000 bulan ini" tidak berarti apa-apa tanpa pembanding:
 * naik atau turun? Class murni ini menghitung persentase & arah perubahan,
 * dan memformatnya jadi kalimat siap tampil. Dipisah dari widget agar bisa
 * diuji tanpa browser.
 */
class Perbandingan
{
    /**
     * Hitung perubahan relatif `kini` terhadap `sebelumnya`.
     *
     * @return array{persen: float|null, arah: string, teks: string}
     *                                                               - persen : persentase perubahan (null bila tak bisa dihitung)
     *                                                               - arah   : 'naik' | 'turun' | 'sama' | 'baru'
     *                                                               - teks   : kalimat siap tampil, mis. "▲ 12,5% vs bulan lalu"
     */
    public static function bulanLalu(float $kini, float $sebelumnya): array
    {
        // Bulan lalu nol: tidak ada dasar persentase.
        if ($sebelumnya <= 0.0) {
            if ($kini <= 0.0) {
                return ['persen' => null, 'arah' => 'sama', 'teks' => 'sama dengan bulan lalu'];
            }

            return ['persen' => null, 'arah' => 'baru', 'teks' => 'baru ada bulan ini'];
        }

        $persen = ($kini - $sebelumnya) / $sebelumnya * 100;

        if (abs($persen) < 0.05) {
            return ['persen' => 0.0, 'arah' => 'sama', 'teks' => 'sama dengan bulan lalu'];
        }

        $arah = $persen > 0 ? 'naik' : 'turun';
        $simbol = $persen > 0 ? '▲' : '▼';

        return [
            'persen' => round($persen, 1),
            'arah' => $arah,
            'teks' => $simbol.' '.Format::persen(abs($persen), 1).' vs bulan lalu',
        ];
    }
}
