<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Filament\Widgets\Concerns\HanyaAdmin;
use App\Models\Mitra;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use App\Support\Format;
use App\Support\Perbandingan;
use App\Support\SaldoKas;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Kartu ringkasan dashboard.
 *
 * ⚠️ PEROMBAKAN (12 Okt 2026) - hilangkan "card soup".
 *
 * MASALAH SEBELUMNYA: 15 kartu ukuran/padding/border IDENTIK disusun 3x3
 * seragam. Tidak ada hierarki - "Total Aset" dan "Lewat Tenggat" punya bobot
 * visual sama. Kartu paling URGENT (Lewat Tenggat) justru tanpa penanda,
 * sementara kartu lain berwarna-warni. Ikon deskripsi kecil berwarna-warni
 * terasa seperti emoji, tidak satu keluarga.
 *
 * SUSUNAN BARU: kartu dikelompokkan jadi 4 BLOK LOGIS yang bernapas, tiap blok
 * menjawab satu pertanyaan:
 *
 *   1. UANG              - nilai pekerjaan, sudah masuk, keluar, belum diterima.
 *   2. PERLU PERHATIAN   - pekerjaan yang lewat/mendekati tenggat (URGENT,
 *                          kartu lewat tenggat diberi penanda merah).
 *   3. PEKERJAAN & TAGIHAN - SPK berjalan + status tagihan.
 *   4. SALDO & MITRA     - saldo kas/bank (digabung) + mitra & subkon.
 *
 * Yang berubah dari versi lama:
 *   - Saldo Kas + Bank + Total DIGABUNG jadi satu kartu "Total Saldo"
 *     (rincian kas/bank pindah ke keterangan) - menghapus 2 kartu.
 *   - Mitra + Subkon DIGABUNG jadi satu kartu.
 *   - Ikon deskripsi dekoratif DIHAPUS (terasa seperti emoji); warna kini
 *     hanya dipakai bila benar-benar bermakna (hijau = masuk, merah = keluar).
 *   - Kartu "Lewat Tenggat" diberi tint merah + penanda tegas.
 *
 * Jumlah kartu 15 -> 12. Tidak ada angka baru yang dikarang.
 */
class RingkasanKeuangan extends StatsOverviewWidget
{
    // ⚠️ B3-12: dashboard lengkap hanya untuk Admin; Direktur punya
    // RingkasanDirektur sendiri.
    use HanyaAdmin;

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    /**
     * Susunan kartu = 4 blok logis. Menggantikan satu grid 3x3 seragam.
     *
     * `getStats()` tetap disediakan (dipakai tes) dan mengembalikan SELURUH
     * kartu datar; `content()` yang mengelompokkannya ke dalam seksi.
     */
    public function content(Schema $schema): Schema
    {
        return $schema->components([
            $this->blok('Uang', $this->barisUang(), 4),
            $this->blok('Perlu Perhatian', $this->barisPerhatian(), 2),
            $this->blok('Pekerjaan & Tagihan', $this->barisPekerjaanTagihan(), 4),
            $this->blok('Saldo & Mitra', $this->barisSaldoMitra(), 2),
        ]);
    }

    /**
     * Semua kartu (datar) - dipertahankan untuk kompatibilitas tes.
     *
     * @return array<int, Stat>
     */
    protected function getStats(): array
    {
        return [
            ...$this->barisUang(),
            ...$this->barisPerhatian(),
            ...$this->barisPekerjaanTagihan(),
            ...$this->barisSaldoMitra(),
        ];
    }

    /**
     * Satu blok logis: judul + kartu-kartunya, tanpa kotak pembungkus.
     *
     * `contained(false)` + `gridContainer()` sama seperti bawaan
     * StatsOverviewWidget - supaya kartu tetap punya gaya `.fi-wi-stats-overview-stat`
     * yang sudah ditata tema.
     *
     * @param  array<int, Stat>  $stats
     */
    private function blok(string $judul, array $stats, int $kolom): Section
    {
        return Section::make($judul)
            ->schema($stats)
            ->columns($kolom)
            ->contained(false)
            ->gridContainer();
    }

    /**
     * Blok UANG: nilai pekerjaan, sudah masuk, keluar, belum diterima.
     *
     * @return array<int, Stat>
     */
    private function barisUang(): array
    {
        $nilaiSpk = (float) Spk::sum('nilai_spk');
        $masuk = (float) UangMasuk::sum('jumlah');
        $keluar = (float) UangKeluar::sum('jumlah');
        $sisa = $nilaiSpk - $masuk;
        $totalSpk = Spk::count();

        $masukBulanIni = (float) UangMasuk::where('tanggal', '>=', now()->startOfMonth())->sum('jumlah');
        $keluarBulanIni = (float) UangKeluar::where('tanggal', '>=', now()->startOfMonth())->sum('jumlah');

        // PEMBANDING (saran user 9 Okt 2026): angka bulan ini tanpa
        // pembanding tidak memberi konteks. Hitung juga BULAN LALU.
        $awalBulanLalu = now()->subMonthNoOverflow()->startOfMonth();
        $akhirBulanLalu = now()->subMonthNoOverflow()->endOfMonth();

        $masukBulanLalu = (float) UangMasuk::whereBetween('tanggal', [$awalBulanLalu, $akhirBulanLalu])->sum('jumlah');
        $keluarBulanLalu = (float) UangKeluar::whereBetween('tanggal', [$awalBulanLalu, $akhirBulanLalu])->sum('jumlah');

        $bandingMasuk = Perbandingan::bulanLalu($masukBulanIni, $masukBulanLalu);
        $bandingKeluar = Perbandingan::bulanLalu($keluarBulanIni, $keluarBulanLalu);

        return [
            Stat::make('Nilai SPK', Format::rupiah($nilaiSpk))
                ->description($totalSpk.' SPK tercatat')
                ->color('primary'),

            Stat::make('Sudah Diterima', Format::rupiah($masuk))
                ->description($masuk > 0
                    ? number_format($masuk / max($nilaiSpk, 1) * 100, 1).'% dari nilai SPK - '.Format::rupiah($masukBulanIni).' bulan ini - '.$bandingMasuk['teks']
                    : 'Belum ada penerimaan')
                ->color('success'),

            Stat::make('Uang Keluar', Format::rupiah($keluar))
                ->description($keluar > 0
                    ? Format::rupiah($keluarBulanIni).' bulan ini - '.$bandingKeluar['teks']
                    : 'Belum ada pengeluaran')
                ->color('danger'),

            Stat::make('Belum Diterima', Format::rupiah(max(0, $sisa)))
                ->description('Nilai SPK - sudah diterima')
                ->color($sisa > 0 ? 'warning' : 'success'),
        ];
    }

    /**
     * Blok PERLU PERHATIAN: pekerjaan yang butuh tindakan.
     *
     * Kartu "Lewat Tenggat" adalah item paling URGENT - diberi penanda merah
     * (`bks-stat-urgent`, ditata di theme.css) supaya tidak tenggelam di antara
     * kartu lain.
     *
     * @return array<int, Stat>
     */
    private function barisPerhatian(): array
    {
        $lewatTenggat = Spk::lewatTenggat()->count();
        $mendekati = Spk::mendekatiTenggat()->count();

        return [
            Stat::make('Lewat Tenggat', (string) $lewatTenggat)
                ->description($lewatTenggat > 0
                    ? 'Perlu ditindaklanjuti segera'
                    : 'Semua pekerjaan sesuai jadwal')
                ->color($lewatTenggat > 0 ? 'danger' : 'success')
                // Penanda visual khusus - kartu paling urgent tidak boleh
                // tampil sama seperti kartu biasa.
                ->extraAttributes(['class' => 'bks-stat-urgent']),

            Stat::make('Mendekati Tenggat', (string) $mendekati)
                ->description('<= 14 hari lagi')
                ->color($mendekati > 0 ? 'warning' : 'gray'),
        ];
    }

    /**
     * Blok PEKERJAAN & TAGIHAN: SPK berjalan + status tagihan.
     *
     * @return array<int, Stat>
     */
    private function barisPekerjaanTagihan(): array
    {
        $totalSpk = Spk::count();
        $berjalan = Spk::where('status_spk', StatusSpk::Berjalan->value)->count();
        $selesai = Spk::where('status_spk', StatusSpk::Selesai->value)->count();

        $belumDitagih = Spk::where('status_tagihan', StatusTagihan::BelumDitagihkan->value)->count();
        $prosesTagih = Spk::whereIn('status_tagihan', [
            StatusTagihan::SudahDitagihkan->value,
            StatusTagihan::RevisiDokumen->value,
            StatusTagihan::MenungguPembayaran->value,
        ])->count();
        $sudahDibayar = Spk::where('status_tagihan', StatusTagihan::Dibayar->value)->count();

        return [
            Stat::make('SPK Berjalan', (string) $berjalan)
                ->description($selesai.' selesai - '.$totalSpk.' total')
                ->color('primary'),

            Stat::make('Belum Ditagihkan', (string) $belumDitagih)
                ->description('Perlu dibuatkan tagihan')
                ->color($belumDitagih > 0 ? 'warning' : 'success'),

            Stat::make('Sedang Ditagih', (string) $prosesTagih)
                ->description('Ditagihkan / menunggu bayar')
                ->color('gray'),

            Stat::make('Sudah Dibayar', (string) $sudahDibayar)
                ->description('Tagihan selesai')
                ->color('success'),
        ];
    }

    /**
     * Blok SALDO & MITRA.
     *
     * Saldo Kas/Bank/Total DIGABUNG jadi satu kartu "Total Saldo" (rincian
     * pindah ke keterangan) - versi lama memakai TIGA kartu untuk satu angka
     * yang sama, itu pemborosan ruang tanpa menambah informasi.
     *
     * @return array<int, Stat>
     */
    private function barisSaldoMitra(): array
    {
        $saldo = SaldoKas::ringkasan();

        $jumlahMitra = Mitra::where('kategori', 'mitra')->count();
        $jumlahSubkon = Mitra::where('kategori', 'subkon')->count();

        return [
            Stat::make('Total Saldo', Format::rupiah($saldo['total']))
                ->description('Kas '.Format::rupiah($saldo['kas']).' - Bank '.Format::rupiah($saldo['bank']))
                ->color($saldo['total'] < 0 ? 'danger' : 'primary'),

            Stat::make('Mitra & Subkon', (string) ($jumlahMitra + $jumlahSubkon))
                ->description($jumlahMitra.' mitra - '.$jumlahSubkon.' subkon')
                ->color('gray'),
        ];
    }
}
