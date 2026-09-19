<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Mitra;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Kartu ringkasan dashboard.
 *
 * ⚠️ REVISI USER: "dashboard masih kurang untuk tata letak dan informasi
 * yang disampaikan yang jelas menampilkan ringkasan atau bagian penting
 * dari menu atau fitur."
 *
 * Kartu disusun 4 baris logis, tiap kartu menjawab SATU pertanyaan:
 *
 *   Baris 1 — UANG: berapa nilai pekerjaan, sudah masuk berapa, keluar berapa,
 *             sisa berapa.
 *   Baris 2 — PEKERJAAN: berapa SPK, mana yang lewat tenggat.
 *   Baris 3 — TAGIHAN: berapa yang belum ditagih, sedang ditagih, sudah dibayar.
 *   Baris 4 — MASTER: mitra & subkon.
 *
 * Tiap kartu diberi keterangan yang menjelaskan ARTINYA, bukan hanya angkanya.
 */
class RingkasanKeuangan extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        // ---------------------------------------------------------
        // UANG
        // ---------------------------------------------------------
        $nilaiSpk = (float) Spk::sum('nilai_spk');
        $masuk = (float) UangMasuk::sum('jumlah');
        $keluar = (float) UangKeluar::sum('jumlah');
        $sisa = $nilaiSpk - $masuk;

        $masukBulanIni = (float) UangMasuk::where('tanggal', '>=', now()->startOfMonth())->sum('jumlah');
        $keluarBulanIni = (float) UangKeluar::where('tanggal', '>=', now()->startOfMonth())->sum('jumlah');

        // ---------------------------------------------------------
        // PEKERJAAN
        // ---------------------------------------------------------
        $totalSpk = Spk::count();
        $berjalan = Spk::where('status_spk', StatusSpk::Berjalan->value)->count();
        $selesai = Spk::where('status_spk', StatusSpk::Selesai->value)->count();
        $lewatTenggat = Spk::lewatTenggat()->count();
        $mendekati = Spk::mendekatiTenggat()->count();

        // ---------------------------------------------------------
        // TAGIHAN
        // ---------------------------------------------------------
        $belumDitagih = Spk::where('status_tagihan', StatusTagihan::BelumDitagihkan->value)->count();
        $prosesTagih = Spk::whereIn('status_tagihan', [
            StatusTagihan::SudahDitagihkan->value,
            StatusTagihan::RevisiDokumen->value,
            StatusTagihan::MenungguPembayaran->value,
        ])->count();
        $sudahDibayar = Spk::where('status_tagihan', StatusTagihan::Dibayar->value)->count();

        // ---------------------------------------------------------
        // MASTER
        // ---------------------------------------------------------
        $mitra = Mitra::where('kategori', 'mitra')->count();
        $subkon = Mitra::where('kategori', 'subkon')->count();

        return [
            // ============ BARIS 1 — UANG ============
            Stat::make('Nilai SPK', $this->rupiah($nilaiSpk))
                ->description($totalSpk.' SPK tercatat')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Sudah Diterima', $this->rupiah($masuk))
                ->description($masuk > 0
                    ? number_format($masuk / max($nilaiSpk, 1) * 100, 1).'% dari nilai SPK · '.$this->rupiah($masukBulanIni).' bulan ini'
                    : 'Belum ada penerimaan')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->color('success'),

            Stat::make('Uang Keluar', $this->rupiah($keluar))
                ->description($keluar > 0
                    ? $this->rupiah($keluarBulanIni).' bulan ini'
                    : 'Belum ada pengeluaran')
                ->descriptionIcon('heroicon-m-arrow-up-tray')
                ->color('danger'),

            Stat::make('Belum Diterima', $this->rupiah(max(0, $sisa)))
                ->description('Nilai SPK − sudah diterima')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($sisa > 0 ? 'warning' : 'success'),

            // ============ BARIS 2 — PEKERJAAN ============
            Stat::make('SPK Berjalan', (string) $berjalan)
                ->description($selesai.' selesai · '.$totalSpk.' total')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('info'),

            Stat::make('Lewat Tenggat', (string) $lewatTenggat)
                ->description($lewatTenggat > 0
                    ? 'Perlu ditindaklanjuti segera'
                    : 'Semua pekerjaan sesuai jadwal')
                ->descriptionIcon($lewatTenggat > 0
                    ? 'heroicon-m-exclamation-triangle'
                    : 'heroicon-m-check-circle')
                ->color($lewatTenggat > 0 ? 'danger' : 'success'),

            Stat::make('Mendekati Tenggat', (string) $mendekati)
                ->description('≤ 14 hari lagi')
                ->descriptionIcon('heroicon-m-clock')
                ->color($mendekati > 0 ? 'warning' : 'gray'),

            // ============ BARIS 3 — TAGIHAN ============
            Stat::make('Belum Ditagihkan', (string) $belumDitagih)
                ->description('Perlu dibuatkan tagihan')
                ->descriptionIcon('heroicon-m-document-plus')
                ->color($belumDitagih > 0 ? 'warning' : 'success'),

            Stat::make('Sedang Ditagih', (string) $prosesTagih)
                ->description('Ditagihkan / menunggu bayar')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info'),

            Stat::make('Sudah Dibayar', (string) $sudahDibayar)
                ->description('Tagihan selesai')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            // ============ BARIS 4 — MASTER ============
            Stat::make('Mitra', (string) $mitra)
                ->description('Pemberi kerja terdaftar')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('gray'),

            Stat::make('Subkon', (string) $subkon)
                ->description('Rekanan pelaksana')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('gray'),
        ];
    }

    protected function rupiah(float $nilai): string
    {
        return 'Rp '.number_format($nilai, 0, ',', '.');
    }
}
