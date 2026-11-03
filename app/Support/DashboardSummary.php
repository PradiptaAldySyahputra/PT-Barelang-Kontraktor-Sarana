<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Mitra;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * RINGKASAN DASBOR PANEL BLADE - satu-satunya sumber angka dashboard.
 *
 * ⚠️ KENAPA JADI KELAS SENDIRI (bukan query di controller):
 * Dashboard Filament (`RingkasanDirektur`, `AdminActionBar`) dan dashboard
 * Blade membaca tabel yang sama. Kalau rumusnya ditulis dua kali, cepat atau
 * lambat angkanya akan berbeda diam-diam - jenis bug paling mahal di aplikasi
 * keuangan. Semua agregasi dikumpulkan di sini, lalu kedua antarmuka memakainya.
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
        $nilaiSpk = (float) Spk::sum('nilai_spk');
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
                    'ket' => Spk::count().' SPK tercatat',
                    'nada' => 'netral',
                ],
                [
                    'label' => 'Belum Diterima',
                    'nilai' => Format::rupiah($belumDiterima),
                    'ket' => Spk::belumLunas()->count().' SPK belum lunas',
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

            'tren' => self::trenEnamBulan(),
            'sebaranTagihan' => self::sebaranStatusTagihan(),
            'sebaranSpk' => self::sebaranStatusSpk(),
            'spkPrioritas' => self::spkPrioritas(),
            'notifikasiPenting' => self::notifikasiPenting(),
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
                    'status_tagihan' => $s->status_tagihan?->label() ?? 'Belum Ditagihkan',
                ];
            })
            ->sortByDesc(static fn (array $i): float => ($i['lewat'] ? 1e12 : 0.0) + $i['sisa'])
            ->take(5)
            ->values()
            ->all();
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

        return [
            'saldo' => $saldo,

            'bulanIni' => [
                'masuk' => (float) UangMasuk::where('tanggal', '>=', now()->startOfMonth())->sum('jumlah'),
                'keluar' => (float) UangKeluar::where('tanggal', '>=', now()->startOfMonth())->sum('jumlah'),
                'jumlahMasuk' => UangMasuk::where('tanggal', '>=', now()->startOfMonth())->count(),
                'jumlahKeluar' => UangKeluar::where('tanggal', '>=', now()->startOfMonth())->count(),
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
            ],

            'terbaru' => self::aktivitasTerbaru(8),
            'spkBerjalan' => self::spkBerjalan(6),
            'jumlahMitra' => Mitra::count(),
            'spkBerjalanCount' => Spk::where('status_spk', StatusSpk::Berjalan->value)->count(),
            'tren' => self::trenEnamBulan(),
            'sebaranSpk' => self::sebaranStatusSpk(),
            'notifikasiPenting' => self::notifikasiPenting(),
            'hariIni' => self::mutasiHariIni(),
        ];
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
     * @return list<array{tipe: string, judul: string, pesan: string, aksi_url: string, aksi_label: string}>
     */
    public static function notifikasiPenting(): array
    {
        $alerts = [];

        try {
            $lewat = Spk::lewatTenggat()->with('mitra')->get();
            if ($lewat->isNotEmpty()) {
                $alerts[] = [
                    'tipe' => 'error',
                    'judul' => 'Peringatan: ' . $lewat->count() . ' SPK Melewati Batas Waktu!',
                    'pesan' => 'Ada SPK yang telah melewati tenggat jadwal dan memerlukan tindak lanjut segera (' . $lewat->pluck('nomor_spk')->take(3)->implode(', ') . ($lewat->count() > 3 ? '...' : '') . ').',
                    'aksi_url' => route('panel.spk.monitoring', 'status'),
                    'aksi_label' => 'Periksa SPK',
                ];
            }

            $mendekati = Spk::mendekatiTenggat()->count();
            if ($mendekati > 0) {
                $alerts[] = [
                    'tipe' => 'warning',
                    'judul' => 'Perhatian: ' . $mendekati . ' SPK Mendekati Tenggat (≤ 14 Hari)',
                    'pesan' => 'Periksa kemajuan fisik dan siapkan dokumen berita acara sebelum masa kontrak berakhir.',
                    'aksi_url' => route('panel.spk.monitoring', 'status'),
                    'aksi_label' => 'Pantau Progres',
                ];
            }

            $belumTagih = Spk::where('status_spk', StatusSpk::Selesai->value)
                ->where(function ($q) {
                    $q->whereNull('status_tagihan')
                        ->orWhere('status_tagihan', StatusTagihan::BelumDitagihkan->value);
                })
                ->count();
            if ($belumTagih > 0) {
                $alerts[] = [
                    'tipe' => 'info',
                    'judul' => $belumTagih . ' SPK Selesai Belum Diterbitkan Tagihan',
                    'pesan' => 'Pekerjaan fisik telah selesai. Terbitkan dokumen penagihan ke mitra agar pencairan dana tidak tertunda.',
                    'aksi_url' => route('panel.spk.monitoring', 'billing'),
                    'aksi_label' => 'Buka Penagihan',
                ];
            }
        } catch (\Throwable $e) {
            // fallback bila database kosong/skema belum siap
        }

        return $alerts;
    }

    /**
     * Transaksi terakhir dari kedua arah, digabung & diurutkan per tanggal.
     *
     * @return list<array{tanggal: Carbon, jenis: string, label: string, jumlah: float, keterangan: string}>
     */
    public static function aktivitasTerbaru(int $batas = 8): array
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
            ->where('status_spk', StatusSpk::Berjalan->value)
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
