<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Support\Facades\Cache;

/**
 * Notifikasi operasional lintas modul untuk header panel.
 *
 * Tiga kelompok: pekerjaan (tenggat SPK), tagihan (siklus penagihan), dan
 * keuangan (arus pembayaran & rekonsiliasi).
 */
final class NotifikasiOperasional
{
    /**
     * @return array{total: int, jumlah: array<string, int>, daftar: list<array<string, mixed>>}
     */
    public static function ambil(): array
    {
        return Cache::remember('bks_header_notifikasi_operasional', 60, static function (): array {
            $daftar = [];
            $jumlah = ['pekerjaan' => 0, 'tagihan' => 0, 'keuangan' => 0];

            // 1. Pekerjaan: SPK lewat batas waktu
            $lewatQuery = Spk::query()->with('mitra:id,nama')->lewatTenggat();
            $jumlah['pekerjaan'] += (int) (clone $lewatQuery)->count();
            $lewat = (clone $lewatQuery)->orderBy('tanggal_akhir', 'asc')->limit(12)->get();

            foreach ($lewat as $s) {
                $hari = $s->tanggal_akhir !== null
                    ? abs((int) now()->startOfDay()->diffInDays($s->tanggal_akhir->startOfDay(), false))
                    : 0;

                $daftar[] = [
                    'id' => 'spk-lewat-'.$s->id,
                    'grup' => 'pekerjaan',
                    'tingkat' => 'error',
                    'kategori' => 'Lewat Tenggat',
                    'judul' => 'Lewat Batas Waktu ('.$hari.' hari)',
                    'nomor' => $s->nomor_spk,
                    'keterangan' => ($s->nama_pekerjaan ?? '-').' · '.($s->mitra?->nama ?? 'Mitra'),
                    'detail_waktu' => 'Tenggat: '.($s->tanggal_akhir?->format('d/m/Y') ?? '-'),
                    'badge' => $hari.' hari terlambat',
                    'url' => route('panel.spk.show', $s),
                    'waktu_unix' => $s->updated_at?->timestamp ?? now()->timestamp,
                ];
            }

            // 2. Pekerjaan: SPK mendekati tenggat (14 hari ke depan)
            $dekatQuery = Spk::query()->with('mitra:id,nama')->mendekatiTenggat();
            $jumlah['pekerjaan'] += (int) (clone $dekatQuery)->count();
            $dekat = (clone $dekatQuery)->orderBy('tanggal_akhir', 'asc')->limit(10)->get();

            foreach ($dekat as $s) {
                $sisa = $s->tanggal_akhir !== null
                    ? (int) now()->startOfDay()->diffInDays($s->tanggal_akhir->startOfDay(), false)
                    : 0;

                $daftar[] = [
                    'id' => 'spk-dekat-'.$s->id,
                    'grup' => 'pekerjaan',
                    'tingkat' => 'warning',
                    'kategori' => 'Mendekati Tenggat',
                    'judul' => 'Mendekati Tenggat ('.$sisa.' hari lagi)',
                    'nomor' => $s->nomor_spk,
                    'keterangan' => ($s->nama_pekerjaan ?? '-').' · '.($s->mitra?->nama ?? 'Mitra'),
                    'detail_waktu' => 'Tenggat: '.($s->tanggal_akhir?->format('d/m/Y') ?? '-'),
                    'badge' => $sisa.' hari tersisa',
                    'url' => route('panel.spk.show', $s),
                    'waktu_unix' => $s->updated_at?->timestamp ?? now()->timestamp,
                ];
            }

            // 3. Tagihan: SPK selesai tapi belum ditagihkan (URGENT)
            $perluTagihQuery = Spk::query()->with('mitra:id,nama')
                ->where('status_spk', StatusSpk::Selesai->value)
                ->where(static fn ($q) => $q->where('status_tagihan', StatusTagihan::BelumDitagihkan->value)->orWhereNull('status_tagihan'));
            $jumlah['tagihan'] += (int) (clone $perluTagihQuery)->count();
            $perluTagih = (clone $perluTagihQuery)->orderByDesc('updated_at')->limit(8)->get();

            foreach ($perluTagih as $s) {
                $daftar[] = [
                    'id' => 'tagihan-baru-'.$s->id,
                    'grup' => 'tagihan',
                    'tingkat' => 'warning',
                    'kategori' => 'Perlu Ditagih',
                    'judul' => 'SPK Selesai Belum Ditagihkan',
                    'nomor' => $s->nomor_spk,
                    'keterangan' => ($s->nama_pekerjaan ?? '-').' · '.($s->mitra?->nama ?? 'Mitra'),
                    'detail_waktu' => 'Selesai: '.($s->updated_at?->diffForHumans() ?? 'baru saja'),
                    'badge' => 'Nilai: '.Format::rupiah((float) $s->nilai_spk),
                    'url' => route('panel.spk.billing', $s),
                    'waktu_unix' => $s->updated_at?->timestamp ?? now()->timestamp,
                ];
            }

            // 4. Tagihan: SPK menunggu pembayaran termin / pelunasan
            $menungguQuery = Spk::query()->with('mitra:id,nama')
                ->where('status_tagihan', StatusTagihan::MenungguPembayaran->value);
            $jumlah['tagihan'] += (int) (clone $menungguQuery)->count();
            $menunggu = (clone $menungguQuery)->orderByDesc('updated_at')->limit(8)->get();

            foreach ($menunggu as $s) {
                $piutang = (float) $s->sisaTagih();
                $daftar[] = [
                    'id' => 'tagihan-tunggu-'.$s->id,
                    'grup' => 'tagihan',
                    'tingkat' => 'info',
                    'kategori' => 'Menunggu Pembayaran',
                    'judul' => 'Menunggu Pencairan Dana',
                    'nomor' => $s->nomor_spk,
                    'keterangan' => ($s->nama_pekerjaan ?? '-').' · '.($s->mitra?->nama ?? 'Mitra'),
                    'detail_waktu' => 'Piutang: '.Format::rupiah($piutang),
                    'badge' => 'Tagihan Aktif',
                    'url' => route('panel.spk.billing', $s),
                    'waktu_unix' => $s->updated_at?->timestamp ?? now()->timestamp,
                ];
            }

            // 5. Keuangan: Pembayaran Masuk Terbaru (60 hari terakhir agar mutasi aktif terpantau)
            $sejak = now()->subDays(60)->startOfDay();
            $masuk = UangMasuk::query()->with(['spk:id,nomor_spk'])->whereDate('tanggal', '>=', $sejak)->orderByDesc('tanggal')->limit(4)->get();
            $jumlahMasuk = $masuk->count();

            if ($jumlahMasuk > 0) {
                foreach ($masuk as $m) {
                    $daftar[] = [
                        'id' => 'keuangan-masuk-'.$m->id,
                        'grup' => 'keuangan',
                        'tingkat' => 'sukses',
                        'kategori' => 'Pembayaran Masuk',
                        'judul' => 'Penerimaan: '.Format::rupiah((float) $m->jumlah),
                        'nomor' => $m->spk?->nomor_spk ?? ($m->nomor_spk ?: 'Non-SPK'),
                        'keterangan' => ($m->keterangan ?: 'Penerimaan Kas/Bank').' · Akun: '.($m->akun?->label() ?? '-'),
                        'detail_waktu' => ($m->tanggal?->translatedFormat('d M Y') ?? 'Baru saja'),
                        'badge' => '+ '.Format::rupiah((float) $m->jumlah),
                        'url' => route('panel.cash-in.index'),
                        'waktu_unix' => $m->tanggal?->timestamp ?? now()->timestamp,
                    ];
                }
                $jumlah['keuangan'] += $jumlahMasuk;
            }

            // 6. Keuangan: Transaksi keluar terbaru (14 hari terakhir)
            $keluarTerbaru = UangKeluar::query()->with(['spk:id,nomor_spk'])->whereDate('tanggal', '>=', now()->subDays(14)->startOfDay())->orderByDesc('tanggal')->limit(3)->get();
            $jumlahKeluar = $keluarTerbaru->count();

            if ($jumlahKeluar > 0) {
                foreach ($keluarTerbaru as $k) {
                    $daftar[] = [
                        'id' => 'keuangan-keluar-'.$k->id,
                        'grup' => 'keuangan',
                        'tingkat' => 'info',
                        'kategori' => 'Pengeluaran Kas',
                        'judul' => 'Pengeluaran: '.Format::rupiah((float) $k->jumlah),
                        'nomor' => $k->spk?->nomor_spk ?? 'Operasional Umum',
                        'keterangan' => ($k->keterangan ?: 'Biaya Proyek / Kas Keluar').' · Kategori: '.($k->kategori?->label() ?? 'Operasional'),
                        'detail_waktu' => ($k->tanggal?->translatedFormat('d M Y') ?? 'Baru saja'),
                        'badge' => '- '.Format::rupiah((float) $k->jumlah),
                        'url' => route('panel.cash-out.index'),
                        'waktu_unix' => $k->tanggal?->timestamp ?? now()->timestamp,
                    ];
                }
                $jumlah['keuangan'] += $jumlahKeluar;
            }

            // 7. Keuangan: Transaksi masuk tanpa nomor SPK (perlu verifikasi)
            $tanpaSpk = UangMasuk::query()->whereNull('spk_id')->count();

            if ($tanpaSpk > 0) {
                $daftar[] = [
                    'id' => 'keuangan-tanpa-spk',
                    'grup' => 'keuangan',
                    'tingkat' => 'warning',
                    'kategori' => 'Perlu Ditelusuri',
                    'judul' => $tanpaSpk.' Uang Masuk Tanpa Tautan SPK',
                    'nomor' => 'Audit Dana',
                    'keterangan' => 'Terdapat dana masuk yang belum dipetakan ke nomor SPK.',
                    'detail_waktu' => 'Periksa sumber dana di Uang Masuk',
                    'badge' => 'Cek Mutasi',
                    'url' => route('panel.cash-in.index'),
                    'waktu_unix' => now()->timestamp - 120,
                ];
                $jumlah['keuangan']++;
            }

            // Urutkan notifikasi: error (merah) dulu, lalu warning (kuning), lalu info & sukses
            usort($daftar, static function (array $a, array $b): int {
                $prioritas = ['error' => 1, 'warning' => 2, 'info' => 3, 'sukses' => 4];
                $pA = $prioritas[$a['tingkat']] ?? 99;
                $pB = $prioritas[$b['tingkat']] ?? 99;

                if ($pA !== $pB) {
                    return $pA <=> $pB;
                }

                return $b['waktu_unix'] <=> $a['waktu_unix'];
            });

            return [
                'total' => array_sum($jumlah),
                'jumlah' => $jumlah,
                'daftar' => $daftar,
            ];
        });
    }

    /**
     * Hapus cache notifikasi (dipanggil otomatis saat data SPK berubah).
     */
    public static function segarkan(): void
    {
        Cache::forget('bks_header_notifikasi_operasional');
    }
}
