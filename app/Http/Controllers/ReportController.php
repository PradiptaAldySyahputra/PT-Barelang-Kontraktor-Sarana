<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\LaporanData;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

/**
 * Laporan (`/panel/reports`).
 *
 * Satu halaman, empat periode (1 / 3 / 12 bulan / semua). Semua angka berasal
 * dari `App\Support\LaporanData`; ekspor memakai rute `laporan.ekspor` yang
 * sudah ada (CSV/XLSX/PDF) supaya tidak ada dua mesin ekspor.
 */
final class ReportController
{
    private const PERIODE_SAH = [1, 3, 12, 0];

    public function __invoke(Request $request): View
    {
        $periode = (int) $request->query('periode', 12);

        if (! in_array($periode, self::PERIODE_SAH, true)) {
            $periode = 12;
        }

        // Rentang kustom: tanggal tidak valid diabaikan; mulai > selesai ditukar.
        $tanggalMulai = $this->tanggal($request->query('mulai'));
        $tanggalSelesai = $this->tanggal($request->query('selesai'));

        if ($tanggalMulai && $tanggalSelesai && $tanggalMulai->gt($tanggalSelesai)) {
            [$tanggalMulai, $tanggalSelesai] = [$tanggalSelesai, $tanggalMulai];
        }

        return view('reports.index', [
            'judul' => 'Laporan',
            'keterangan' => 'Ringkasan keuangan, buku kas & bank, tenggat SPK, dan piutang',
            'periode' => $periode,
            'tanggalMulai' => $tanggalMulai?->toDateString(),
            'tanggalSelesai' => $tanggalSelesai?->toDateString(),
            'opsiPeriode' => [
                1 => 'Bulan ini',
                3 => '3 bulan',
                12 => '1 tahun',
                0 => 'Semua',
            ],
            'data' => LaporanData::lengkap($periode, $tanggalMulai, $tanggalSelesai),
            // Tabel buku kas/bank bisa berisi ratusan baris. Batasi tampilan agar
            // halaman tidak membengkak; daftar lengkap ada di unduhan Excel/PDF.
            'batasBaris' => $request->boolean('semua') ? null : 60,
        ]);
    }

    private function tanggal(mixed $nilai): ?Carbon
    {
        if (! is_string($nilai) || ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $nilai)) {
            return null;
        }

        try {
            return Carbon::createFromFormat('!Y-m-d', $nilai);
        } catch (\Throwable) {
            return null;
        }
    }
}
