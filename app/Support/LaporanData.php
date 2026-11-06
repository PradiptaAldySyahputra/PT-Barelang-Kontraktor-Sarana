<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Models\Mitra;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Angka-angka halaman Laporan untuk panel Blade (/panel/reports).
 *
 * Satu-satunya sumber perhitungan laporan: halaman Laporan, ekspor CSV/XLSX/PDF,
 * dan bundel ZIP semuanya membaca dari sini.
 *
 * Semua method statis & murni (tanpa state Livewire), jadi bisa diuji tanpa
 * browser.
 */
final class LaporanData
{
    /**
     * Tanggal awal periode. `0` = semua data (tanpa batas).
     */
    public static function tanggalAwal(int $periode): ?Carbon
    {
        return $periode > 0
            ? now()->subMonths($periode)->startOfMonth()
            : null;
    }

    /**
     * @return Builder<UangMasuk>
     */
    private static function queryMasuk(?Carbon $awal, ?Carbon $akhir = null): Builder
    {
        return UangMasuk::query()
            ->when($awal, fn ($q) => $q->where('tanggal', '>=', $awal))
            ->when($akhir, fn ($q) => $q->where('tanggal', '<=', $akhir->toDateString()));
    }

    /**
     * @return Builder<UangKeluar>
     */
    private static function queryKeluar(?Carbon $awal, ?Carbon $akhir = null): Builder
    {
        return UangKeluar::query()
            ->when($awal, fn ($q) => $q->where('tanggal', '>=', $awal))
            ->when($akhir, fn ($q) => $q->where('tanggal', '<=', $akhir->toDateString()));
    }

    /**
     * @return array<string, float>
     */
    public static function ringkasan(?Carbon $awal, ?Carbon $akhir = null): array
    {
        $totalMasuk = (float) self::queryMasuk($awal, $akhir)->sum('jumlah');
        $totalKeluar = (float) self::queryKeluar($awal, $akhir)->sum('jumlah');

        $nilaiSpk = (float) Spk::sum('nilai_spk');
        $belumDiterima = $nilaiSpk - (float) UangMasuk::whereNotNull('spk_id')->sum('jumlah');

        return [
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'selisih' => $totalMasuk - $totalKeluar,
            'masukDariSpk' => (float) self::queryMasuk($awal, $akhir)->whereNotNull('spk_id')->sum('jumlah'),
            'masukLuarSpk' => (float) self::queryMasuk($awal, $akhir)->whereNull('spk_id')->sum('jumlah'),
            'nilaiSpk' => $nilaiSpk,
            'belumDiterima' => max(0, $belumDiterima),
        ];
    }

    /**
     * Saldo adalah posisi TERKINI - tidak dibatasi periode.
     *
     * @return array<string, mixed>
     */
    public static function saldo(?Carbon $awal, ?Carbon $akhir = null): array
    {
        $saldo = SaldoKas::ringkasan();

        return [
            'saldoKas' => $saldo['kas'],
            'saldoBank' => $saldo['bank'],
            'saldoTotal' => $saldo['total'],
            'saldoKasPerBulan' => SaldoKas::perBulan(AkunKas::Kas),
            'saldoBankPerBulan' => SaldoKas::perBulan(AkunKas::Bank),
            'bukuKas' => BukuKasBank::susun(AkunKas::Kas, $awal, $akhir ?? now()),
            'bukuBank' => BukuKasBank::susun(AkunKas::Bank, $awal, $akhir ?? now()),
        ];
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public static function perBulan(?Carbon $awal, ?Carbon $akhir = null): Collection
    {
        $masukPerBulan = self::queryMasuk($awal, $akhir)
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total")
            ->groupBy('bulan')
            ->orderByDesc('bulan')
            ->limit(12)
            ->get()
            ->keyBy('bulan');

        $keluarPerBulan = self::queryKeluar($awal, $akhir)
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total")
            ->groupBy('bulan')
            ->orderByDesc('bulan')
            ->limit(12)
            ->get()
            ->keyBy('bulan');

        $bulan = $masukPerBulan->keys()
            ->merge($keluarPerBulan->keys())
            ->unique()
            ->sortDesc()
            ->take(12);

        return $bulan->map(function (string $kodeBulan) use ($masukPerBulan, $keluarPerBulan): array {
            $masuk = $masukPerBulan->get($kodeBulan);
            $keluar = $keluarPerBulan->get($kodeBulan);
            $masukNominal = (float) ($masuk->total ?? 0);
            $keluarNominal = (float) ($keluar->total ?? 0);

            return [
                'bulan' => $kodeBulan,
                'label' => Carbon::parse($kodeBulan.'-01')->translatedFormat('F Y'),
                'masuk' => $masukNominal,
                'keluar' => $keluarNominal,
                'selisih' => $masukNominal - $keluarNominal,
                'jumlah_masuk' => (int) ($masuk->jumlah_transaksi ?? 0),
                'jumlah_keluar' => (int) ($keluar->jumlah_transaksi ?? 0),
            ];
        });
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public static function perKategori(?Carbon $awal, ?Carbon $akhir = null): Collection
    {
        return self::queryKeluar($awal, $akhir)
            ->selectRaw('kategori, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get()
            ->map(function ($row): array {
                $enum = $row->kategori instanceof KategoriPengeluaran
                    ? $row->kategori
                    : KategoriPengeluaran::tryFrom((string) $row->kategori);

                return [
                    'label' => $enum?->label() ?? ($row->kategori ?: 'Tanpa kategori'),
                    'jumlah_transaksi' => (int) $row->jumlah_transaksi,
                    'total' => (float) $row->total,
                ];
            });
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public static function daftarSpk(): Collection
    {
        return Spk::query()
            ->with(['mitra', 'subkon'])
            ->withSum('uangMasuk as total_masuk', 'jumlah')
            ->orderByDesc('tanggal_spk')
            ->get()
            ->map(fn (Spk $spk): array => [
                'nomor_spk' => $spk->nomor_spk,
                'pekerjaan' => $spk->nama_pekerjaan,
                'mitra' => $spk->mitra?->nama,
                'tanggal' => $spk->tanggal_spk?->format('d/m/Y'),
                'nilai_spk' => (float) $spk->nilai_spk,
                'diterima' => (float) ($spk->total_masuk ?? 0),
                'belum_diterima' => max(0, $spk->piutangDari((float) ($spk->total_masuk ?? 0))),
                'status_spk' => $spk->status_spk?->label() ?? '-',
                'status_tagihan' => $spk->status_tagihan?->label() ?? 'Belum Ditagihkan',
            ]);
    }

    /**
     * @return Collection<int, Spk>
     */
    public static function daftarPiutang(): Collection
    {
        return Spk::query()
            ->with('mitra')
            ->withSum('uangMasuk as total_masuk', 'jumlah')
            ->get()
            ->filter(fn (Spk $s): bool => $s->piutangDari((float) ($s->total_masuk ?? 0)) > 0)
            ->sortByDesc(fn (Spk $s): float => $s->piutangDari((float) ($s->total_masuk ?? 0)))
            ->values();
    }

    /**
     * Seluruh data yang dibutuhkan halaman Laporan.
     *
     * @return array<string, mixed>
     */
    public static function lengkap(int $periode, ?Carbon $mulai = null, ?Carbon $selesai = null): array
    {
        // Rentang kustom (mulai/selesai) menimpa periode preset.
        $awal = $mulai ?? self::tanggalAwal($periode);
        $akhir = $selesai;

        return [
            'periode' => $periode,
            ...self::ringkasan($awal, $akhir),
            ...self::saldo($awal, $akhir),
            'perBulan' => self::perBulan($awal, $akhir),
            'perKategori' => self::perKategori($awal, $akhir),
            'daftarSpk' => self::daftarSpk(),
            'spkLewatTenggat' => Spk::query()->lewatTenggat()->with('mitra')->orderBy('tanggal_akhir')->get(),
            'spkMendekatiTenggat' => Spk::query()->mendekatiTenggat()->with('mitra')->orderBy('tanggal_akhir')->get(),
            'daftarPiutang' => self::daftarPiutang(),
            'jumlahSpk' => Spk::count(),
            'jumlahMitra' => Mitra::count(),
            'jumlahMasuk' => UangMasuk::count(),
            'jumlahKeluar' => UangKeluar::count(),
        ];
    }
}
