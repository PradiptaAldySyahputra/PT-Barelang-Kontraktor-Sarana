<?php

declare(strict_types=1);

namespace App\Http\Controllers\Spk;

use Illuminate\View\View;

/**
 * Tiga menu monitoring SPK memakai SATU halaman + SATU komponen Livewire;
 * yang berbeda hanya mode penyaringnya (status / billing / completed).
 */
final class MonitoringController
{
    public function __invoke(string $mode = 'status'): View
    {
        abort_unless(in_array($mode, ['status', 'billing', 'completed'], true), 404);

        [$judul, $keterangan] = match ($mode) {
            'billing' => ['Tagihan SPK', 'SPK yang belum lunas - antrean penagihan'],
            'completed' => ['Tagihan Selesai SPK', 'SPK yang tagihannya sudah dibayar'],
            default => ['Status SPK', 'Progres pekerjaan seluruh SPK'],
        };

        return view('spk.monitoring', [
            'judul' => $judul,
            'keterangan' => $keterangan,
            'mode' => $mode,
        ]);
    }
}