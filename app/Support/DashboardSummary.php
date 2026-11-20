<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * RINGKASAN DASBOR PANEL BLADE - satu-satunya sumber angka dashboard.
 *
 * ⚠️ KENAPA JADI KELAS SENDIRI (bukan query di controller):
 * Dashboard Direktur (`director.dashboard`) dan Dashboard Admin
 * (`admin.dashboard`) membaca tabel yang sama. Kalau rumusnya ditulis dua kali, cepat atau
 * lambat angkanya akan berbeda diam-diam - jenis bug paling mahal di aplikasi
 * keuangan. Semua agregasi dikumpulkan di sini, lalu kedua dashboard memakainya.
 *
 * Kelas ini MURNI BACA: tidak menulis, tidak menyimpan, tidak menambah tabel
 * (Rules.md §1). Semua dihitung dari transaksi yang sudah ada.
 *
 * Dua peran, dua kebutuhan berbeda (bukan dua tampilan yang sama):
 *
 *   eksekutif()   → DIREKTUR: strategis. Nilai pekerjaan, piutang, arus kas
 *                   6 bulan, sebaran status tagihan, SPK yang perlu dipantau.
 *                   Tidak ada tombol input - Direktur read-only.
 *
 *   operasional() → ADMIN: taktis. Saldo siap pakai, aksi cepat input,
 *                   antrean yang harus dikerjakan hari ini, transaksi terakhir.
 */
final class DashboardSummary
{
    /* =========================================================
       DIREKTUR - dashboard eksekutif
       ========================================================= */

    /**
     * @return array<string, mixed>
     */
    public static function eksekutif(): array
    {
        // SPK Dibatalkan tidak menerima pembayaran → kecualikan dari nilai & piutang.
        $aktif = fn (Builder $q) => $q->where('status_spk', '!=', StatusSpk::Dibatalkan->value)->orWhereNull('status_spk');

        $jumlahSpkAktif = Spk::query()->where($aktif)->count();
        $nilaiSpk = (float) Spk::query()->where($aktif)->sum('nilai_spk');
        $diterimaDariSpk = (float) UangMasuk::whereNotNull('spk_id')->sum('jumlah');
        $belumDiterima = max(0.0, $nilaiSpk - $diterimaDariSpk);

        $masukBulanIni = (float) UangMasuk::where('tanggal', '>=', now()->startOfMonth())->sum('jumlah');
        $keluarBulanIni = (float) UangKeluar::where('tanggal', '>=', now()->startOfMonth())->sum('jumlah');

        $awalBulanLalu = now()->subMonthNoOverflow()->startOfMonth();
        $akhirBulanLalu = now()->subMonthNoOverflow()->endOfMonth();
        $masukBulanLalu = (float) UangMasuk::whereBetween('tanggal', [$awalBulanLalu, $akhirBulanLalu])->sum('jumlah');
        $keluarBulanLalu = (float) UangKeluar::whereBetween('tanggal', [$awalBulanLalu, $akhirBulanLalu])->sum('jumlah');

        $saldo = SaldoKas::ringkasan();

        return [
            'kpi' => [
                [
                    'label' => 'Nilai Pekerjaan',
                    'nilai' => Format::rupiah($nilaiSpk),
                    'ket' => $jumlahSpkAktif.' SPK tercatat',
                    'nada' => 'netral',
                ],
                [
                    'label' => 'Belum Diterima',
                    'nilai' => Format::rupiah($belumDiterima),
                    'ket' => Spk::belumLunas()->where($aktif)->count().' SPK belum lunas',
                    'nada' => $belumDiterima > 0 ? 'perhatian' : 'aman',
                ],
                [
                    'label' => 'Total Saldo',
                    'nilai' => Format::rupiah($saldo['total']),
                    'ket' => 'Kas '.Format::rupiah($saldo['kas']).' · Bank '.Format::rupiah($saldo['bank']),
                    'nada' => $saldo['total'] < 0 ? 'bahaya' : 'netral',
                ],
                [
                    'label' => 'Lewat Tenggat',
                    'nilai' => (string) Spk::lewatTenggat()->count(),
                    'ket' => Spk::lewatTenggat()->count() > 0 ? 'Perlu ditindaklanjuti' : 'Semua sesuai jadwal',
                    'nada' => Spk::lewatTenggat()->count() > 0 ? 'bahaya' : 'aman',
                ],
            ],

            'bulanIni' => [
                'masuk' => $masukBulanIni,
                'keluar' => $keluarBulanIni,
                'bandingMasuk' => Perbandingan::bulanLalu($masukBulanIni, $masukBulanLalu),
                'bandingKeluar' => Perbandingan::bulanLalu($keluarBulanIni, $keluarBulanLalu),
            ],

            'tertagih' => [
                'diterima' => $diterimaDariSpk,
                'nilai' => $nilaiSpk,
                'persen' => $nilaiSpk > 0 ? min(100.0, round($diterimaDariSpk / $nilaiSpk * 100, 1)) : 0.0,
            ],

            'saldo' => $saldo,

            'tren' => self::trenEnamBulan(),
            'sebaranTagihan' => self::sebaranStatusTagihan(),
            'spkPrioritas' => self::spkPrioritas(),
            'topMitraPiutang' => self::topMitraPiutang(),
            'hariIni' => self::mutasiHariIni(),
        ];
    }

    /**
     * Arus kas 6 bulan terakhir, sudah dalam persen untuk lebar batang.
     *
     * @return list<array{label: string, masuk: float, keluar: float, persen_masuk: float, persen_keluar: float}>
     */
    private static function trenEnamBulan(): array
    {
        $awal = now()->subMonthsNoOverflow(5)->startOfMonth();

        $masuk = self::agregatBulanan(UangMasuk::class, $awal);
        $keluar = self::agregatBulanan(UangKeluar::class, $awal);

        $puncak = 1.0;
        $mentah = [];

        for ($i = 5; $i >= 0; $i--) {
            $waktu = now()->subMonthsNoOverflow($i);
            $kunci = $waktu->format('Y-m');
            $m = (float) ($masuk[$kunci] ?? 0);
            $k = (float) ($keluar[$kunci] ?? 0);
            $puncak = max($puncak, $m, $k);

            $mentah[] = [
                'label' => $waktu->translatedFormat('M Y'),
                'masuk' => $m,
                'keluar' => $k,
            ];
        }

        return array_map(static fn (array $b): array => [
            ...$b,
            // Minimal 4% supaya bulan bernilai kecil tetap terlihat sebagai batang.
            'persen_masuk' => $b['masuk'] > 0 ? max(4.0, round($b['masuk'] / $puncak * 100, 1)) : 0.0,
            'persen_keluar' => $b['keluar'] > 0 ? max(4.0, round($b['keluar'] / $puncak * 100, 1)) : 0.0,
        ], $mentah);
    }

    /**
     * @param  class-string<Model>  $model
     * @return array<string, float>
     */
    private static function agregatBulanan(string $model, Carbon $awal): array
    {
        return $model::query()
            ->where('tanggal', '>=', $awal)
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(jumlah) as total")
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->map(static fn ($v): float => (float) $v)
            ->all();
    }

    /**
     * @return list<array{label: string, jumlah: int, persen: float, warna: string}>
     */
    private static function sebaranStatusTagihan(): array
    {
        $mentah = Spk::query()
            ->selectRaw('status_tagihan, COUNT(*) as jumlah')
            ->groupBy('status_tagihan')
            ->pluck('jumlah', 'status_tagihan');

        $total = max(1, Spk::count());

        return array_map(static function (StatusTagihan $st) use ($mentah, $total): array {
            $jml = (int) ($mentah[$st->value] ?? 0);

            return [
                'label' => $st->label(),
                'jumlah' => $jml,
                'persen' => round($jml / $total * 100, 1),
                'warna' => $st->warnaBadge(),
            ];
        }, StatusTagihan::cases());
    }

    /**
     * Lima SPK yang paling perlu dilihat Direktur: lewat tenggat dulu,
     * lalu sisa piutang terbesar.
     *
     * @return list<array<string, mixed>>
     */
    private static function spkPrioritas(): array
    {
        return Spk::query()
            ->with('mitra:id,nama')
            ->withSum('uangMasuk as total_masuk', 'jumlah')
            ->where(function ($q): void {
                $q->where('status_tagihan', '!=', StatusTagihan::Dibayar->value)
                    ->orWhereNull('status_tagihan');
            })
            // Urutkan di SQL: lewat tenggat dulu, lalu sisa piutang terbesar.
            ->orderByRaw('(tanggal_akhir IS NOT NULL AND tanggal_akhir < CURDATE()) DESC')
            ->orderByRaw('(COALESCE(nilai_spk, 0) - COALESCE(total_masuk, 0)) DESC')
            ->limit(5)
            ->get()
            ->map(static function (Spk $s): array {
                $diterima = $s->totalPenerimaan();

                return [
                    'id' => (int) $s->getKey(),
                    'nomor_spk' => $s->nomor_spk,
                    'pekerjaan' => $s->nama_pekerjaan,
                    'mitra' => $s->mitra?->nama ?? '-',
                    'nilai' => (float) $s->nilai_spk,
                    'sisa' => max(0.0, (float) $s->nilai_spk - $diterima),
                    'tenggat' => $s->tanggal_akhir?->format('d/m/Y') ?? '-',
                    'label_tenggat' => $s->labelTenggat(),
                    'lewat' => $s->sudahLewatTenggat(),
                    'sisa_hari' => $s->sisaTenggatHari(),
                    'status_tagihan' => $s->status_tagihan?->label() ?? 'Belum Ditagihkan',
                ];
            })
            ->values()
            ->all();
    }

    /**
     * Lima mitra dengan sisa piutang terbesar (hanya SPK aktif).
     *
     * @return list<array{mitra: string, nilai: float, sisa: float}>
     */
    private static function topMitraPiutang(int $batas = 5): array
    {
        $aktif = fn (Builder $q) => $q->where('status_spk', '!=', StatusSpk::Dibatalkan->value)->orWhereNull('status_spk');

        // Dataset inner: SPK aktif + total diterima per SPK (withSum).
        $inner = Spk::query()->withSum('uangMasuk as total_masuk', 'jumlah')->where($aktif);

        // Agregasi per mitra di SQL, bukan di PHP.
        $baris = DB::query()
            ->fromSub($inner, 'data')
            ->join('mitra', 'mitra.id', '=', 'data.mitra_id')
            ->selectRaw('mitra.id AS mitra_id, mitra.nama AS nama_mitra, SUM(data.nilai_spk) AS total_nilai, COALESCE(SUM(data.total_masuk), 0) AS total_masuk')
            ->groupBy('mitra.id', 'mitra.nama')
            ->orderByDesc(DB::raw('(SUM(data.nilai_spk) - COALESCE(SUM(data.total_masuk), 0))'))
            ->limit($batas)
            ->get();

        return $baris->map(static fn ($r): array => [
            'mitra' => $r->nama_mitra,
            'nilai' => (float) $r->total_nilai,
            'sisa' => max(0.0, (float) $r->total_nilai - (float) $r->total_masuk),
        ])->values()->all();
    }

    /* =========================================================
      ADMIN - dashboard operasional
      ========================================================= */

    /**
     * @return array<string, mixed>
     */
    public static function operasional(): array
    {
        $saldo = SaldoKas::ringkasan();

        $belumDitagihkan = Spk::query()
            ->where(function ($q): void {
                $q->whereNull('status_tagihan')
                    ->orWhere('status_tagihan', StatusTagihan::BelumDitagihkan->value);
            })
            ->count();

        $mendekatiTenggat = Spk::mendekatiTenggat()->count();
        $lewatTenggat = Spk::lewatTenggat()->count();
        $revisiDokumen = Spk::where('status_spk', StatusSpk::RevisiDokumen->value)->count();

        $aktif = fn (Builder $q) => $q->where('status_spk', '!=', StatusSpk::Dibatalkan->value)->orWhereNull('status_spk');
        $nilaiTotalSpk = (float) Spk::query()->where($aktif)->sum('nilai_spk');
        $masukTotalSpk = (float) UangMasuk::whereNotNull('spk_id')->sum('jumlah');

        return [
            'saldo' => $saldo,

            'bulanIni' => [
                'masuk' => $masukBulanIni = (float) UangMasuk::where('tanggal', '>=', now()->startOfMonth())->sum('jumlah'),
                'keluar' => $keluarBulanIni = (float) UangKeluar::where('tanggal', '>=', now()->startOfMonth())->sum('jumlah'),
                'jumlahMasuk' => UangMasuk::where('tanggal', '>=', now()->startOfMonth())->count(),
                'jumlahKeluar' => UangKeluar::where('tanggal', '>=', now()->startOfMonth())->count(),
                'bandingMasuk' => Perbandingan::bulanLalu(
                    $masukBulanIni,
                    (float) UangMasuk::whereBetween('tanggal', [now()->subMonthNoOverflow()->startOfMonth(), now()->subMonthNoOverflow()->endOfMonth()])->sum('jumlah'),
                ),
                'bandingKeluar' => Perbandingan::bulanLalu(
                    $keluarBulanIni,
                    (float) UangKeluar::whereBetween('tanggal', [now()->subMonthNoOverflow()->startOfMonth(), now()->subMonthNoOverflow()->endOfMonth()])->sum('jumlah'),
                ),
            ],

            'realisasiSpk' => [
                'totalNilai' => $nilaiTotalSpk,
                'totalDiterima' => $masukTotalSpk,
                'sisaPiutang' => max(0.0, $nilaiTotalSpk - $masukTotalSpk),
                'persenDiterima' => $nilaiTotalSpk > 0 ? round(($masukTotalSpk / $nilaiTotalSpk) * 100, 1) : 0.0,
            ],

            // Yang harus dikerjakan hari ini - bukan angka hiasan.
            'antrean' => [
                [
                    'label' => 'SPK belum ditagihkan',
                    'jumlah' => $belumDitagihkan,
                    'ket' => 'Siap dibuatkan tagihan',
                    'nada' => $belumDitagihkan > 0 ? 'perhatian' : 'aman',
                ],
                [
                    'label' => 'Mendekati tenggat',
                    'jumlah' => $mendekatiTenggat,
                    'ket' => '≤ 14 hari lagi',
                    'nada' => $mendekatiTenggat > 0 ? 'perhatian' : 'aman',
                ],
                [
                    'label' => 'Lewat tenggat',
                    'jumlah' => $lewatTenggat,
                    'ket' => 'Perlu tindak lanjut',
                    'nada' => $lewatTenggat > 0 ? 'bahaya' : 'aman',
                ],
                [
                    'label' => 'Revisi dokumen',
                    'jumlah' => $revisiDokumen,
                    'ket' => 'Perbaikan berkas mitra',
                    'nada' => $revisiDokumen > 0 ? 'perhatian' : 'aman',
                ],
            ],

            'terbaru' => self::aktivitasTerbaru(8),
            'spkBerjalan' => self::spkBerjalan(6),
            'spkPerluPerhatian' => self::spkPerluPerhatian(5),
            'pengeluaranKategori' => self::pengeluaranPerKategoriBulanIni(),
            'spkBerjalanCount' => Spk::berjalan()->count(),
            'tren' => self::trenEnamBulan(),
            'sebaranSpk' => self::sebaranStatusSpk(),
            'hariIni' => self::mutasiHariIni(),
        ];
    }

    /**
     * Komposisi pengeluaran operasional per kategori bulan ini.
     *
     * @return list<array{kategori: string, label: string, total: float, jumlah_trx: int, persen: float}>
     */
    public static function pengeluaranPerKategoriBulanIni(): array
    {
        $awalBulan = now()->startOfMonth();
        $totalKeluar = (float) UangKeluar::where('tanggal', '>=', $awalBulan)->sum('jumlah');

        $rows = UangKeluar::query()
            ->selectRaw('kategori, SUM(jumlah) as total, COUNT(*) as jumlah_trx')
            ->where('tanggal', '>=', $awalBulan)
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        return $rows->map(static function ($r) use ($totalKeluar): array {
            $kat = $r->kategori;
            $subtotal = (float) $r->total;

            return [
                'kategori' => $kat?->value ?? 'lainnya',
                'label' => $kat?->label() ?? 'Lainnya',
                'total' => $subtotal,
                'jumlah_trx' => (int) $r->jumlah_trx,
                'persen' => $totalKeluar > 0 ? round(($subtotal / $totalKeluar) * 100, 1) : 0.0,
            ];
        })->all();
    }

    /**
     * SPK yang memerlukan perhatian operasional Admin segera (lewat tenggat atau siap ditagih).
     *
     * @return list<array<string, mixed>>
     */
    public static function spkPerluPerhatian(int $batas = 5): array
    {
        return Spk::query()
            ->with('mitra:id,nama')
            ->where(function ($q): void {
                $q->lewatTenggat()
                    ->orWhere('status_spk', StatusSpk::RevisiDokumen->value)
                    ->orWhere(function ($sub): void {
                        $sub->where('status_spk', StatusSpk::Selesai->value)
                            ->where(function ($st): void {
                                $st->whereNull('status_tagihan')
                                    ->orWhere('status_tagihan', StatusTagihan::BelumDitagihkan->value);
                            });
                    });
            })
            ->orderBy('tanggal_akhir')
            ->limit($batas)
            ->get()
            ->map(static fn (Spk $s): array => [
                'id' => $s->id,
                'nomor_spk' => $s->nomor_spk,
                'pekerjaan' => $s->nama_pekerjaan,
                'mitra' => $s->mitra?->nama ?? '-',
                'nilai' => (float) $s->nilai_spk,
                'status_spk' => $s->status_spk?->label() ?? '-',
                'status_tagihan' => $s->status_tagihan?->label() ?? 'Belum Ditagihkan',
                'label_tenggat' => $s->labelTenggat(),
                'lewat' => $s->sudahLewatTenggat(),
                'sisa_hari' => $s->sisaTenggatHari(),
            ])
            ->all();
    }

    /**
     * Mutasi kas & bank khusus hari ini (real-time daily pulse).
     *
     * @return array{masuk: float, keluar: float, saldoKas: float, saldoBank: float, totalSaldo: float}
     */
    public static function mutasiHariIni(): array
    {
        $hariIni = now()->toDateString();

        $masukHariIni = (float) UangMasuk::whereDate('tanggal', $hariIni)->sum('jumlah');
        $keluarHariIni = (float) UangKeluar::whereDate('tanggal', $hariIni)->sum('jumlah');
        $saldo = SaldoKas::ringkasan();

        return [
            'masuk' => $masukHariIni,
            'keluar' => $keluarHariIni,
            'saldoKas' => (float) $saldo['kas'],
            'saldoBank' => (float) $saldo['bank'],
            'totalSaldo' => (float) $saldo['total'],
        ];
    }

    /**
     * @return list<array{label: string, jumlah: int, persen: float, warna: string}>
     */
    public static function sebaranStatusSpk(): array
    {
        $mentah = Spk::query()
            ->selectRaw('status_spk, COUNT(*) as jumlah')
            ->groupBy('status_spk')
            ->pluck('jumlah', 'status_spk');

        $total = max(1, Spk::count());

        return array_map(static function (StatusSpk $st) use ($mentah, $total): array {
            $jml = (int) ($mentah[$st->value] ?? 0);

            return [
                'label' => $st->label(),
                'jumlah' => $jml,
                'persen' => round($jml / $total * 100, 1),
                'warna' => $st->warnaBadge(),
            ];
        }, StatusSpk::cases());
    }

    /**
     * Transaksi terakhir dari kedua arah, digabung & diurutkan per tanggal.
     *
     * @return list<array{tanggal: Carbon, jenis: string, label: string, jumlah: float, keterangan: string}>
     */
    public static function aktivitasTerbaru(int $batas = 6): array
    {
        $masuk = UangMasuk::query()
            ->latest('tanggal')
            ->latest('id')
            ->limit($batas)
            ->get()
            ->map(static fn (UangMasuk $u): array => [
                'tanggal' => $u->tanggal,
                'jenis' => 'masuk',
                'label' => $u->nomor_spk ?: ($u->nama_pekerjaan ?: 'Penerimaan'),
                'jumlah' => (float) $u->jumlah,
                'keterangan' => (string) ($u->keterangan ?? $u->akun?->label()),
            ]);

        $keluar = UangKeluar::query()
            ->latest('tanggal')
            ->latest('id')
            ->limit($batas)
            ->get()
            ->map(static fn (UangKeluar $k): array => [
                'tanggal' => $k->tanggal,
                'jenis' => 'keluar',
                'label' => $k->kategori?->label() ?? 'Pengeluaran',
                'jumlah' => (float) $k->jumlah,
                'keterangan' => (string) ($k->keterangan ?? $k->penerima ?? ''),
            ]);

        /** @var Collection<int, array<string, mixed>> $gabung */
        $gabung = $masuk->concat($keluar)
            ->sortByDesc(static fn (array $r): string => $r['tanggal']->format('Y-m-d'))
            ->take($batas)
            ->values();

        return $gabung->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    private static function spkBerjalan(int $batas = 6): array
    {
        return Spk::query()
            ->with('mitra:id,nama')
            ->berjalan()
            ->orderBy('tanggal_akhir')
            ->limit($batas)
            ->get()
            ->map(static fn (Spk $s): array => [
                'id' => $s->id,
                'nomor_spk' => $s->nomor_spk,
                'pekerjaan' => $s->nama_pekerjaan,
                'mitra' => $s->mitra?->nama ?? '-',
                'nilai' => (float) $s->nilai_spk,
                'label_tenggat' => $s->labelTenggat(),
                'lewat' => $s->sudahLewatTenggat(),
                'sisa_hari' => $s->sisaTenggatHari(),
            ])
            ->all();
    }
}
