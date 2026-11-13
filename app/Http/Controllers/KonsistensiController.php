<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Spk;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Laporan baca-saja "Periksa Konsistensi Piutang" (Fase 1 MASTER-PLAN, B-1).
 *
 * TIDAK mengubah data apa pun. Hanya mencari baris yang tidak cocok antara
 * nilai SPK, total penerimaan, dan status tagihan - supaya kesalahan input
 * lama (sebelum validasi berlaku) bisa ditemukan tanpa mengubah alur bisnis.
 */
final class KonsistensiController
{
    /** Toleransi pembulatan rupiah. */
    private const TOLERANSI = 0.5;

    public function __invoke(Request $request): View
    {
        abort_unless($request->user()?->bolehInput() || $request->user()?->isDirektur(), 403);

        $spk = Spk::query()
            ->with(['mitra:id,nama'])
            ->withSum('uangMasuk as total_masuk', 'jumlah')
            ->orderBy('tanggal_spk')
            ->get();

        $kelebihanBayar = [];
        $statusTidakCocok = [];
        $dibatalkanAdaBayar = [];

        foreach ($spk as $s) {
            $masuk = (float) ($s->total_masuk ?? 0);
            $nilai = (float) $s->nilai_spk;
            $sisa = $nilai - $masuk;

            if ($masuk - $nilai > self::TOLERANSI) {
                $kelebihanBayar[] = ['spk' => $s, 'masuk' => $masuk, 'sisa' => $sisa];
            }

            $tagihan = $s->status_tagihan;
            $seharusnyaDibayar = abs($sisa) <= self::TOLERANSI;

            if ($tagihan === StatusTagihan::Dibayar && ! $seharusnyaDibayar) {
                $statusTidakCocok[] = ['spk' => $s, 'masuk' => $masuk, 'sisa' => $sisa, 'alasan' => 'Ditandai Dibayar, tetapi piutang belum nol'];
            } elseif ($tagihan !== StatusTagihan::Dibayar && $seharusnyaDibayar && $s->status_spk !== StatusSpk::Dibatalkan) {
                $statusTidakCocok[] = ['spk' => $s, 'masuk' => $masuk, 'sisa' => $sisa, 'alasan' => 'Piutang sudah nol, tetapi status belum Dibayar'];
            }

            if ($s->status_spk === StatusSpk::Dibatalkan && $masuk > self::TOLERANSI) {
                $dibatalkanAdaBayar[] = ['spk' => $s, 'masuk' => $masuk, 'sisa' => $sisa];
            }
        }

        return view('reports.konsistensi', [
            'judul' => 'Periksa Konsistensi Piutang',
            'keterangan' => 'Menampilkan SPK yang angkanya tidak cocok. Halaman ini hanya membaca, tidak mengubah data.',
            'jumlahSpk' => $spk->count(),
            'kelebihanBayar' => $kelebihanBayar,
            'statusTidakCocok' => $statusTidakCocok,
            'dibatalkanAdaBayar' => $dibatalkanAdaBayar,
            'totalTemuan' => count($kelebihanBayar) + count($statusTidakCocok) + count($dibatalkanAdaBayar),
        ]);
    }
}
