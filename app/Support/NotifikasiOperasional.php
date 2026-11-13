<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Support\Facades\Cache;

/**
 * Notifikasi operasional lintas modul untuk header panel.
 *
 * Tiga kelompok: pekerjaan (tenggat SPK), tagihan (siklus penagihan), dan
 * keuangan (arus pembayaran terbaru). Setiap butir membawa `grup`, `tingkat`,
 * `judul`, `keterangan`, dan `url` sehingga header bisa menampilkannya
 * terkelompok dengan tab, bukan hanya daftar SPK.
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
            $lewat = Spk::query()->with('mitra:id,nama')->lewatTenggat()->orderByDesc('tanggal_akhir')->limit(8)->get();

            foreach ($lewat as $s) {
                $hari = $s->tanggal_akhir !== null
                    ? abs((int) now()->startOfDay()->diffInDays($s->tanggal_akhir->startOfDay(), false))
                    : 0;

                $daftar[] = [
                    'id' => 'spk-lewat-'.$s->id,
                    'grup' => 'pekerjaan',
                    'tingkat' => 'error',
                    'kategori' => 'Lewat tenggat',
                    'judul' => $s->nomor_spk.' lewat '.$hari.' hari',
                    'keterangan' => ($s->nama_pekerjaan ?? '-').' · '.($s->mitra?->nama ?? 'PT PLN Batam'),
                    'url' => route('panel.spk.show', $s),
                    'waktu_unix' => $s->updated_at?->timestamp ?? now()->timestamp,
                ];
            }
            $jumlah['pekerjaan'] += $lewat->count();
            $jumlah['pekerjaan'] += (int) Spk::query()->lewatTenggat()->count() - $lewat->count();

            // 2. Pekerjaan: tenggat 14 hari ke depan
            $dekat = Spk::query()->with('mitra:id,nama')->mendekatiTenggat()->orderBy('tanggal_akhir')->limit(6)->get();

            foreach ($dekat as $s) {
                $sisa = $s->tanggal_akhir !== null
                    ? (int) now()->startOfDay()->diffInDays($s->tanggal_akhir->startOfDay(), false)
                    : 0;

                $daftar[] = [
                    'id' => 'spk-dekat-'.$s->id,
                    'grup' => 'pekerjaan',
                    'tingkat' => 'warning',
                    'kategori' => 'Mendekati tenggat',
                    'judul' => $s->nomor_spk.' · '.$sisa.' hari lagi',
                    'keterangan' => ($s->nama_pekerjaan ?? '-').' · tenggat '.($s->tanggal_akhir?->format('d/m/Y') ?? '-'),
                    'url' => route('panel.spk.show', $s),
                    'waktu_unix' => $s->updated_at?->timestamp ?? now()->timestamp,
                ];
            }
            $jumlah['pekerjaan'] += $dekat->count();
            $jumlah['pekerjaan'] += (int) Spk::query()->mendekatiTenggat()->count() - $dekat->count();

            // 3. Tagihan: menunggu pembayaran
            $menunggu = Spk::query()->with('mitra:id,nama')
                ->where('status_tagihan', StatusTagihan::MenungguPembayaran->value)
                ->orderByDesc('updated_at')->limit(6)->get();

            foreach ($menunggu as $s) {
                $daftar[] = [
                    'id' => 'tagihan-tunggu-'.$s->id,
                    'grup' => 'tagihan',
                    'tingkat' => 'info',
                    'kategori' => 'Menunggu pembayaran',
                    'judul' => $s->nomor_spk.' menunggu dana masuk',
                    'keterangan' => ($s->mitra?->nama ?? 'PT PLN Batam').' · nilai '.Format::rupiah((float) $s->nilai_spk),
                    'url' => route('panel.spk.billing', $s),
                    'waktu_unix' => $s->updated_at?->timestamp ?? now()->timestamp,
                ];
            }
            $jumlah['tagihan'] += (int) Spk::query()->where('status_tagihan', StatusTagihan::MenungguPembayaran->value)->count();

            // 4. Tagihan: selesai tapi belum ditagihkan
            $perluTagih = Spk::query()->with('mitra:id,nama')
                ->where('status_spk', StatusSpk::Selesai->value)
                ->where(static fn ($q) => $q->where('status_tagihan', StatusTagihan::BelumDitagihkan->value)->orWhereNull('status_tagihan'))
                ->orderByDesc('updated_at')->limit(6)->get();

            foreach ($perluTagih as $s) {
                $daftar[] = [
                    'id' => 'tagihan-baru-'.$s->id,
                    'grup' => 'tagihan',
                    'tingkat' => 'warning',
                    'kategori' => 'Belum ditagihkan',
                    'judul' => $s->nomor_spk.' selesai, belum ditagihkan',
                    'keterangan' => ($s->mitra?->nama ?? 'PT PLN Batam').' · selesai '.($s->updated_at?->diffForHumans() ?? 'baru saja'),
                    'url' => route('panel.spk.billing', $s),
                    'waktu_unix' => $s->updated_at?->timestamp ?? now()->timestamp,
                ];
            }
            $jumlah['tagihan'] += (int) Spk::query()
                ->where('status_spk', StatusSpk::Selesai->value)
                ->where(static fn ($q) => $q->where('status_tagihan', StatusTagihan::BelumDitagihkan->value)->orWhereNull('status_tagihan'))
                ->count();

            // 5. Keuangan: pembayaran masuk 7 hari terakhir (ringkasan, bukan per SPK)
            $sejak = now()->subDays(6)->startOfDay();
            $masuk = UangMasuk::query()->whereDate('tanggal', '>=', $sejak);
            $jumlahMasuk = (clone $masuk)->count();
            $nilaiMasuk = (float) (clone $masuk)->sum('jumlah');

            if ($jumlahMasuk > 0) {
                $daftar[] = [
                    'id' => 'keuangan-masuk-7hari',
                    'grup' => 'keuangan',
                    'tingkat' => 'sukses',
                    'kategori' => 'Uang masuk',
                    'judul' => $jumlahMasuk.' pembayaran dalam 7 hari terakhir',
                    'keterangan' => 'Total '.Format::rupiah($nilaiMasuk),
                    'url' => route('panel.cash-in.index'),
                    'waktu_unix' => now()->timestamp - 60,
                ];
                $jumlah['keuangan']++;
            }

            // 6. Keuangan: transaksi masuk tanpa nomor SPK (perlu ditelusuri)
            $tanpaSpk = UangMasuk::query()->whereNull('spk_id')->whereDate('tanggal', '>=', now()->subDays(29)->startOfDay())->count();

            if ($tanpaSpk > 0) {
                $daftar[] = [
                    'id' => 'keuangan-tanpa-spk',
                    'grup' => 'keuangan',
                    'tingkat' => 'warning',
                    'kategori' => 'Perlu ditelusuri',
                    'judul' => $tanpaSpk.' uang masuk tanpa tautan SPK',
                    'keterangan' => '30 hari terakhir · cek sumber dana',
                    'url' => route('panel.cash-in.index'),
                    'waktu_unix' => now()->timestamp - 120,
                ];
                $jumlah['keuangan']++;
            }

            usort($daftar, static fn (array $a, array $b): int => $b['waktu_unix'] <=> $a['waktu_unix']);

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
