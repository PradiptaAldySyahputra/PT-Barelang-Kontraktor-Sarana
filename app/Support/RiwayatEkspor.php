<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Export;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * RIWAYAT EKSPOR (peta menu C - "Ekspor & Unduhan").
 *
 * ⚠️ KENAPA PERLU:
 * B1-2 menambah tabel `notifications` + notifikasi unduhan, tetapi belum ada
 * HALAMAN yang menampilkan riwayat ekspor. Admin perlu melihat daftar ekspor
 * (sedang diproses / selesai / gagal) dan mengunduhnya kembali tanpa menunggu
 * notifikasi.
 *
 * ⚠️ Data diambil dari tabel `exports` (tabel infrastruktur, bukan tabel domain) - TIDAK ada tabel baru.
 */
final class RiwayatEkspor
{
    /**
     * Daftar ekspor terbaru, terbaru di atas.
     *
     * @param  int|null  $userId  batasi ke pengguna tertentu (null = semua)
     * @return Collection<int, array{
     *     id: int,
     *     jenis: string,
     *     jenis_asli: string,
     *     nama_berkas: string,
     *     disk: string,
     *     status: string,
     *     status_label: string,
     *     warna: string,
     *     baris_diproses: int,
     *     total_baris: int,
     *     baris_sukses: int,
     *     baris_gagal: int,
     *     selesai: bool,
     *     waktu: Carbon|null,
     *     pengguna: string|null,
     *     bisa_unduh: bool
     * }>
     */
    public static function daftar(?int $userId = null, int $limit = 50): Collection
    {
        return Export::query()
            ->when($userId, fn ($q) => $q->where('user_id', $userId))
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->map(fn (Export $e): array => self::petakan($e));
    }

    /**
     * @return array<string, mixed>
     */
    private static function petakan(Export $e): array
    {
        $selesai = $e->completed_at !== null;
        $gagal = $e->getFailedRowsCount() > 0 && $selesai;

        if (! $selesai) {
            $status = 'diproses';
            $statusLabel = 'Sedang diproses';
            $warna = 'warning';
        } elseif ($gagal) {
            $status = 'sebagian';
            $statusLabel = 'Selesai (ada baris gagal)';
            $warna = 'danger';
        } else {
            $status = 'selesai';
            $statusLabel = 'Selesai';
            $warna = 'success';
        }

        $berkasAda = $selesai
            && $e->file_name !== null
            && $e->getFileDisk()->exists($e->getFileDirectory().DIRECTORY_SEPARATOR.$e->file_name);

        $jenisSlug = self::slugEksportir((string) $e->exporter);

        return [
            'id' => (int) $e->getKey(),
            'jenis' => self::labelEksportir((string) $e->exporter),
            'jenis_asli' => (string) $e->exporter,
            'jenis_slug' => $jenisSlug,
            'nama_berkas' => (string) ($e->file_name ?? '-'),
            'disk' => (string) $e->file_disk,
            'status' => $status,
            'status_label' => $statusLabel,
            'warna' => $warna,
            'baris_diproses' => (int) $e->processed_rows,
            'total_baris' => (int) $e->total_rows,
            'baris_sukses' => (int) $e->successful_rows,
            'baris_gagal' => $e->getFailedRowsCount(),
            'selesai' => $selesai,
            'waktu' => $e->created_at,
            'pengguna' => $e->user?->nama ?? null,
            'bisa_unduh' => $berkasAda,
            'ekspor_baru_url' => $jenisSlug ? route('laporan.ekspor', ['jenis' => $jenisSlug, 'format' => 'xlsx']) : null,
        ];
    }

    /**
     * Slug jenis laporan yang kompatibel dengan LaporanEkspor.
     */
    public static function slugEksportir(string $exporter): ?string
    {
        $pendek = class_basename($exporter);

        return match (true) {
            str_contains($pendek, 'Spk') => 'spk',
            str_contains($pendek, 'UangMasuk') => 'masuk',
            str_contains($pendek, 'UangKeluar') => 'keluar',
            default => null,
        };
    }

    /**
     * Nama ramah untuk kelas exporter Filament.
     */
    private static function labelEksportir(string $exporter): string
    {
        $pendek = class_basename($exporter);

        return match (true) {
            str_contains($pendek, 'Spk') => 'Data SPK',
            str_contains($pendek, 'UangMasuk') => 'Uang Masuk',
            str_contains($pendek, 'UangKeluar') => 'Uang Keluar',
            str_contains($pendek, 'Mitra') => 'Mitra',
            default => $pendek,
        };
    }
}
