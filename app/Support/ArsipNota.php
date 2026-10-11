<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * ARSIP NOTA (B2-7) — pencarian & pengunduhan nota per periode.
 *
 * ⚠️ KENAPA PERLU:
 * Nota tersimpan sebagai berkas lepas di disk. Untuk mencari "nota tanggal
 * sekian, bulan sekian" admin harus menelusuri folder manual (seperti
 * `D:\NOTA BKS\2026\8. AGUSTUS\1`). Halaman Arsip Nota menggantikannya:
 * filter tanggal/periode/akun/kategori → unduh langsung, atau unduh semua
 * sebagai ZIP.
 *
 * ⚠️ TIDAK ADA TABEL BARU: arsip dibangun dari relasi `bukti` (JSON) pada
 * uang_masuk & uang_keluar yang sudah ada. Tidak melanggar scope lock.
 *
 * ⚠️ SATU BARIS ARSIP = SATU BERKAS. Nama unduhan dibuat otomatis
 * `YYYY-MM-DD (n).ext` agar admin tidak menamai manual (1.1 / 1.2 dst).
 */
final class ArsipNota
{
    /**
     * Cari nota sesuai filter.
     *
     * @param  array{tanggal_awal?: string|null, tanggal_akhir?: string|null, akun?: string|null, kategori?: string|null, q?: string|null}  $filter
     * @return Collection<int, array{jenis: string, tanggal: Carbon, akun: string|null, kategori: string|null, penerima: string|null, keterangan: string|null, path: string, nama: string, ada: bool, url: string|null}>
     */
    public static function cari(array $filter = []): Collection
    {
        $hasil = collect();

        $awal = filled($filter['tanggal_awal'] ?? null) ? Carbon::parse($filter['tanggal_awal']) : null;
        $akhir = filled($filter['tanggal_akhir'] ?? null) ? Carbon::parse($filter['tanggal_akhir']) : null;
        $akun = $filter['akun'] ?? null;
        $kategori = $filter['kategori'] ?? null;
        $q = $filter['q'] ?? null;

        // --- Uang keluar ---
        UangKeluar::query()
            ->when($awal, fn ($query) => $query->where('tanggal', '>=', $awal->toDateString()))
            ->when($akhir, fn ($query) => $query->where('tanggal', '<=', $akhir->toDateString()))
            ->when($akun, fn ($query) => $query->where('akun', $akun))
            ->when($kategori, fn ($query) => $query->where('kategori', $kategori))
            ->when($q, function ($query) use ($q): void {
                $query->where(function ($sub) use ($q): void {
                    $sub->where('penerima', 'like', "%{$q}%")
                        ->orWhere('keterangan', 'like', "%{$q}%");
                });
            })
            ->whereNotNull('bukti')
            ->orderBy('tanggal')
            ->get()
            ->each(function (UangKeluar $r) use ($hasil): void {
                foreach ($r->bukti ?? [] as $path) {
                    $hasil->push(self::baris(
                        'Uang Keluar',
                        $r->tanggal,
                        $r->akun instanceof AkunKas ? $r->akun->value : $r->akun,
                        $r->kategori instanceof KategoriPengeluaran ? $r->kategori->label() : $r->kategori,
                        $r->penerima,
                        $r->keterangan,
                        (string) $path,
                    ));
                }
            });

        // --- Uang masuk ---
        UangMasuk::query()
            ->when($awal, fn ($query) => $query->where('tanggal', '>=', $awal->toDateString()))
            ->when($akhir, fn ($query) => $query->where('tanggal', '<=', $akhir->toDateString()))
            ->when($akun, fn ($query) => $query->where('akun', $akun))
            ->when($q, function ($query) use ($q): void {
                $query->where(function ($sub) use ($q): void {
                    $sub->where('keterangan', 'like', "%{$q}%");
                });
            })
            ->whereNotNull('bukti')
            ->orderBy('tanggal')
            ->get()
            ->each(function (UangMasuk $r) use ($hasil): void {
                foreach ($r->bukti ?? [] as $path) {
                    $hasil->push(self::baris(
                        'Uang Masuk',
                        $r->tanggal,
                        $r->akun instanceof AkunKas ? $r->akun->value : $r->akun,
                        null,
                        null,
                        $r->keterangan,
                        (string) $path,
                    ));
                }
            });

        return $hasil
            ->sortBy(fn (array $b): int => $b['tanggal']->getTimestamp())
            ->values()
            // Beri nomor urut per tanggal untuk nama unduhan otomatis.
            ->groupBy(fn (array $b): string => $b['tanggal']->format('Y-m-d'))
            ->flatMap(function (Collection $grup): Collection {
                $n = 1;

                return $grup->map(function (array $b) use (&$n): array {
                    $ext = strtolower(pathinfo($b['path'], PATHINFO_EXTENSION) ?: 'bin');
                    $b['nama'] = $b['tanggal']->format('Y-m-d').' ('.$n.').'.$ext;
                    $n++;

                    return $b;
                });
            })
            ->values();
    }

    /**
     * @return array{jenis: string, tanggal: Carbon, akun: string|null, kategori: string|null, penerima: string|null, keterangan: string|null, path: string, nama: string, ada: bool, url: string|null}
     */
    private static function baris(
        string $jenis,
        Carbon $tanggal,
        ?string $akun,
        ?string $kategori,
        ?string $penerima,
        ?string $keterangan,
        string $path,
    ): array {
        return [
            'jenis' => $jenis,
            'tanggal' => $tanggal,
            'akun' => $akun,
            'kategori' => $kategori,
            'penerima' => $penerima,
            'keterangan' => $keterangan,
            'path' => $path,
            'nama' => '', // diisi setelah pengelompokan
            'ada' => Nota::ada($path),
            'url' => Nota::url($path),
            // Thumbnail (B2-7): hanya gambar yang bisa dipratinjau langsung;
            // PDF ditandai supaya view menampilkan ikon, bukan <img> rusak.
            'gambar' => self::gambar($path),
        ];
    }

    /**
     * Apakah berkas nota berupa gambar (bisa ditampilkan sebagai thumbnail)?
     */
    public static function gambar(string $path): bool
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp'], true);
    }

    /**
     * Buat berkas ZIP dari daftar arsip (untuk "Unduh semua").
     *
     * @param  Collection<int, array<string, mixed>>  $arsip
     * @return string|null Path absolut berkas ZIP, atau null bila tidak ada berkas.
     */
    public static function buatZip(Collection $arsip): ?string
    {
        $ada = $arsip->where('ada', true);

        if ($ada->isEmpty()) {
            return null;
        }

        $zipPath = tempnam(sys_get_temp_dir(), 'arsip-nota').'.zip';

        $zip = new \ZipArchive;

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return null;
        }

        $disk = Storage::disk('nota');

        foreach ($ada as $b) {
            $isi = $disk->get($b['path']);

            if ($isi !== null) {
                // Simpan dalam sub-folder per tanggal agar rapi.
                $zip->addFromString($b['tanggal']->format('Y-m-d').'/'.$b['nama'], $isi);
            }
        }

        $zip->close();

        return $zipPath;
    }
}
