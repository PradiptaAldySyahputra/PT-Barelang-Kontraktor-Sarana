<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use App\Support\Format;
use App\Support\SaldoKas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Perintah rekapitulasi harian/mingguan otomatis: ringkasan arus kas, saldo, dan SPK kritis.
 * Dapat dipanggil manual atau didaftarkan pada scheduler crontab server kantor.
 */
class RekapLaporanOtomatis extends Command
{
    protected $signature = 'bks:rekap-harian {--email= : Kirim hasil rekap ke alamat email tertentu}';

    protected $description = 'Kompilasi ringkasan eksekutif harian: saldo kas/bank, mutasi hari ini, dan SPK kritis';

    public function handle(): int
    {
        $hariIni = now()->toDateString();
        $masukHariIni = (float) UangMasuk::whereDate('tanggal', $hariIni)->sum('jumlah');
        $keluarHariIni = (float) UangKeluar::whereDate('tanggal', $hariIni)->sum('jumlah');
        $saldo = SaldoKas::ringkasan();

        $spkKritis = Spk::query()
            ->with('mitra')
            ->where('tanggal_akhir', '<=', now()->addDays(7))
            ->where('status_tagihan', '!=', 'dibayar')
            ->count();

        $teksRingkasan = sprintf(
            "=== REKAP HARIAN PT BARELANG KONTRAKTOR SARANA [%s] ===\n".
            "Kas Masuk Hari Ini  : %s\n".
            "Kas Keluar Hari Ini : %s\n".
            "Total Saldo Kas/Bank: %s (Kas: %s | Bank: %s)\n".
            "SPK Kritis (<= 7 hr): %d SPK membutuhkan tindak lanjut.\n",
            now()->format('d/m/Y H:i'),
            Format::rupiah($masukHariIni),
            Format::rupiah($keluarHariIni),
            Format::rupiah($saldo['total']),
            Format::rupiah($saldo['kas']),
            Format::rupiah($saldo['bank']),
            $spkKritis
        );

        $this->info($teksRingkasan);
        Log::info('BKS Rekap Harian Otomatis', ['ringkasan' => $teksRingkasan]);

        return self::SUCCESS;
    }
}
