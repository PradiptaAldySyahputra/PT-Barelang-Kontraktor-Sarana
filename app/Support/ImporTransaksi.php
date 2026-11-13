<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\AkunKas;
use App\Enums\DikerjakanOleh;
use App\Enums\KategoriMitra;
use App\Enums\KategoriPengeluaran;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Support\Carbon;

/**
 * IMPOR TRANSAKSI (B3-13) - append-only + cegah duplikat + TEGAKKAN ATURAN BISNIS.
 *
 * ⚠️ KENAPA PERLU:
 * Migrasi data awal / input massal dari Excel. Aturan penting:
 *   - **APPEND-ONLY**: impor hanya MENAMBAH baris; tidak pernah mengubah
 *     atau menghapus data lama.
 *   - **CEGAH DUPLIKAT**: baris yang sudah ada (sidik jari sama) DILEWATI.
 *   - **ATURAN BISNIS SAMA DENGAN FORM** (perbaikan BUG-2, 11 Okt 2026):
 *     dulu impor diam-diam melewati validasi yang ditegakkan form, sehingga
 *     data uang bisa korup. Sekarang tiap baris divalidasi:
 *       (a) uang masuk ≤ sisa piutang SPK,
 *       (b) SPK `Dibatalkan` menolak transaksi baru,
 *       (c) tanggal transaksi ≤ hari ini.
 *     Baris yang melanggar masuk daftar `gagal` dengan pesan jelas.
 *
 * ⚠️ TIDAK ADA TABEL BARU - sidik jari dihitung on-the-fly dari kolom yang ada.
 *
 * ⚠️ KINERJA (perbaikan BUG-1, 11 Okt 2026):
 * Dulu `sudahAda()` memuat SELURUH tabel (`withTrashed()->get()`) untuk SETIAP
 * baris impor → O(n²), lambat & boros memori. Sekarang sidik jari seluruh tabel
 * dihitung SEKALI per jenis (di luar loop), lalu tiap baris cukup dicek ke
 * himpunan (Set) itu.
 */
final class ImporTransaksi
{
    private const BATAS_NOMINAL = 10_000_000_000;

    /**
     * Impor baris daftar SPK.
     *
     * @param  list<array<string, mixed>>  $baris
     * @return array{ditambah: int, dilewati: int, gagal: list<string>}
     */
    public static function spk(array $baris, bool $cegahDuplikat = true, ?int $dibuatOleh = null): array
    {
        $hasil = ['ditambah' => 0, 'dilewati' => 0, 'gagal' => []];

        $pembuatId = $dibuatOleh ?? auth()->id() ?? Pengguna::first()?->id ?? 1;

        // Cari mitra PLN default atau buat jika belum ada sama sekali
        $mitraPln = Mitra::where('kategori', KategoriMitra::Mitra->value)
            ->where(function ($q) {
                $q->where('nama', 'like', '%PLN%')
                    ->orWhere('nama', 'like', '%Batam%');
            })->first() ?? Mitra::where('kategori', KategoriMitra::Mitra->value)->first();

        // Sequence nomor TANPA-SPK tertinggi yang ada di DB
        $maxTanpaSpk = 0;
        $nomorTanpaSpkList = Spk::withTrashed()
            ->where('nomor_spk', 'like', 'TANPA-SPK-%')
            ->pluck('nomor_spk');

        foreach ($nomorTanpaSpkList as $nomor) {
            if (preg_match('/TANPA-SPK-(\d+)/', $nomor, $match)) {
                $num = (int) $match[1];
                if ($num > $maxTanpaSpk) {
                    $maxTanpaSpk = $num;
                }
            }
        }

        // Cache nomor SPK yang sudah ada di DB untuk deteksi cepat
        $spkAda = [];
        foreach (Spk::withTrashed()->pluck('nomor_spk') as $n) {
            $spkAda[mb_strtolower(trim((string) $n))] = true;
        }

        // Cache pasangan pekerjaan + nilai untuk deteksi duplikat TANPA SPK
        $tanpaSpkAset = [];
        foreach (Spk::withTrashed()->where('nomor_spk', 'like', 'TANPA-SPK-%')->get(['nama_pekerjaan', 'nilai_spk']) as $s) {
            $kunci = mb_strtolower(trim($s->nama_pekerjaan)).'|'.number_format((float) $s->nilai_spk, 2, '.', '');
            $tanpaSpkAset[$kunci] = true;
        }

        foreach ($baris as $i => $b) {
            $nomorBaris = $i + 1;

            try {
                $namaPekerjaan = trim((string) ($b['nama_pekerjaan'] ?? ''));
                if ($namaPekerjaan === '') {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: nama pekerjaan tidak boleh kosong.";

                    continue;
                }

                $nilaiRaw = $b['jumlah'] ?? $b['nilai_spk'] ?? 0;
                $nilai = self::jumlah($nilaiRaw) ?? 0.0;

                $rawNomor = trim((string) ($b['nomor_spk'] ?? ''));
                $isTanpaSpk = $rawNomor === '' || strtoupper($rawNomor) === 'TANPA SPK';

                $tanggal = self::tanggal($b['tanggal_spk'] ?? $b['tanggal'] ?? null);

                // Mitra
                $mitraId = null;
                $namaMitra = trim((string) ($b['mitra'] ?? ''));
                if ($namaMitra !== '') {
                    $m = Mitra::where('nama', $namaMitra)->first()
                        ?? Mitra::where('nama', 'like', "%{$namaMitra}%")->first();
                    $mitraId = $m?->id;
                }
                if ($mitraId === null) {
                    $mitraId = $mitraPln?->id ?? Mitra::first()?->id;
                }

                if ($isTanpaSpk) {
                    $kunciTanpaSpk = mb_strtolower($namaPekerjaan).'|'.number_format($nilai, 2, '.', '');
                    if ($cegahDuplikat && isset($tanpaSpkAset[$kunciTanpaSpk])) {
                        $hasil['dilewati']++;

                        continue;
                    }

                    $maxTanpaSpk++;
                    $nomorSpkBaru = sprintf('TANPA-SPK-%04d', $maxTanpaSpk);
                } else {
                    $kunciSpk = mb_strtolower($rawNomor);
                    if ($cegahDuplikat && isset($spkAda[$kunciSpk])) {
                        $hasil['dilewati']++;

                        continue;
                    }

                    $nomorSpkBaru = $rawNomor;
                }

                // Cek status bayar / catatan bayar
                $catatanBayar = trim((string) ($b['catatan_bayar'] ?? ''));
                $isLunas = $catatanBayar !== '' && (
                    str_contains(mb_strtolower($catatanBayar), 'lunas') ||
                    str_contains(mb_strtolower($catatanBayar), 'sudah masuk') ||
                    str_contains(mb_strtolower($catatanBayar), 'masuk') ||
                    str_contains(mb_strtolower($catatanBayar), 'dibayar')
                );

                $statusSpk = StatusSpk::Berjalan;
                $statusTagihan = $isLunas ? StatusTagihan::Dibayar : StatusTagihan::BelumDitagihkan;

                Spk::create([
                    'nomor_spk' => $nomorSpkBaru,
                    'tanggal_spk' => $isTanpaSpk ? null : $tanggal,
                    'nama_pekerjaan' => $namaPekerjaan,
                    'lokasi' => ! empty($b['lokasi']) ? trim((string) $b['lokasi']) : null,
                    'nilai_spk' => $nilai,
                    'mitra_id' => $mitraId,
                    'status_spk' => $statusSpk,
                    'status_tagihan' => $statusTagihan,
                    'dikerjakan_oleh' => DikerjakanOleh::Sendiri,
                    'dibuat_oleh' => $pembuatId,
                    'keterangan' => ! empty($b['keterangan']) ? trim((string) $b['keterangan']) : null,
                ]);

                if ($isTanpaSpk) {
                    $tanpaSpkAset[$kunciTanpaSpk] = true;
                } else {
                    $spkAda[mb_strtolower($nomorSpkBaru)] = true;
                }

                $hasil['ditambah']++;
            } catch (\Throwable $e) {
                $hasil['gagal'][] = "Baris {$nomorBaris}: ".$e->getMessage();
            }
        }

        return $hasil;
    }

    /**
     * Impor baris uang masuk.
     *
     * @param  list<array<string, mixed>>  $baris
     * @return array{ditambah: int, dilewati: int, gagal: list<string>}
     */
    public static function uangMasuk(array $baris, bool $cegahDuplikat = true): array
    {
        $hasil = ['ditambah' => 0, 'dilewati' => 0, 'gagal' => []];

        // BUG-1: hitung sidik jari tabel SEKALI, bukan per baris.
        $sidikAda = $cegahDuplikat ? self::sidikTersimpan('masuk') : [];

        // Akumulasi uang masuk per SPK (termasuk baris yang baru ditambah dalam
        // batch ini) supaya aturan "≤ sisa piutang" benar walau 1 SPK diimpor
        // beberapa baris sekaligus.
        $terimaPerSpk = [];

        foreach ($baris as $i => $b) {
            $nomorBaris = $i + 1;

            try {
                $tanggal = self::tanggal($b['tanggal'] ?? null);
                $jumlah = self::jumlah($b['jumlah'] ?? null);

                if ($tanggal === null || $jumlah === null) {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: tanggal/jumlah tidak valid.";

                    continue;
                }

                // (c) Tanggal ≤ hari ini.
                if ($tanggal > now()->toDateString()) {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: tanggal {$tanggal} melebihi hari ini.";

                    continue;
                }

                $akun = self::akun($b['akun'] ?? null);
                $spk = self::cariSpk($b);
                $spkId = $spk?->id;

                if ($spk === null && (! empty($b['spk_id']) || ! empty($b['nomor_spk']))) {
                    $labelRef = (string) ($b['nomor_spk'] ?? $b['spk_id']);
                    $hasil['gagal'][] = "Baris {$nomorBaris}: SPK '{$labelRef}' tidak ditemukan.";

                    continue;
                }

                // (b) SPK Dibatalkan menolak transaksi baru.
                if ($spk !== null && $spk->status_spk !== null && ! $spk->status_spk->bolehTransaksiBaru()) {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: SPK {$spk->nomor_spk} berstatus Dibatalkan - tidak bisa menerima transaksi baru.";

                    continue;
                }

                // (a) Uang masuk ≤ sisa piutang SPK.
                if ($spk !== null) {
                    $sudah = $terimaPerSpk[$spk->id] ?? (float) $spk->uangMasuk()->sum('jumlah');
                    $batas = (float) $spk->nilai_spk - $sudah;

                    if ($jumlah > $batas + 0.01) {
                        $hasil['gagal'][] = sprintf(
                            'Baris %d: melebihi nilai SPK %s. Sisa yang boleh diterima Rp %s, diminta Rp %s.',
                            $nomorBaris,
                            $spk->nomor_spk,
                            number_format(max(0, $batas), 0, ',', '.'),
                            number_format($jumlah, 0, ',', '.'),
                        );

                        continue;
                    }
                }

                $sidik = self::sidik('masuk', $tanggal, $jumlah, $akun, $b['keterangan'] ?? null, $spkId);

                if ($cegahDuplikat && isset($sidikAda[$sidik])) {
                    $hasil['dilewati']++;

                    continue;
                }

                UangMasuk::create([
                    'spk_id' => $spkId,
                    'nomor_spk' => $spk?->nomor_spk ?? ($b['nomor_spk'] ?? null),
                    'nama_pekerjaan' => $spk?->nama_pekerjaan ?? ($b['nama_pekerjaan'] ?? null),
                    'tanggal' => $tanggal,
                    'akun' => $akun,
                    'jumlah' => $jumlah,
                    'keterangan' => $b['keterangan'] ?? null,
                ]);

                // Catat untuk pengecekan baris berikutnya + cegah duplikat
                // DI DALAM batch yang sama (mis. 2 baris kembar di berkas).
                if ($spk !== null) {
                    $terimaPerSpk[$spk->id] = ($terimaPerSpk[$spk->id] ?? (float) $spk->uangMasuk()->sum('jumlah')) + $jumlah;
                }

                $sidikAda[$sidik] = true;
                $hasil['ditambah']++;
            } catch (\Throwable $e) {
                $hasil['gagal'][] = "Baris {$nomorBaris}: ".$e->getMessage();
            }
        }

        return $hasil;
    }

    /**
     * Impor baris uang keluar.
     *
     * @param  list<array<string, mixed>>  $baris
     * @return array{ditambah: int, dilewati: int, gagal: list<string>}
     */
    public static function uangKeluar(array $baris, bool $cegahDuplikat = true): array
    {
        $hasil = ['ditambah' => 0, 'dilewati' => 0, 'gagal' => []];

        // BUG-1: hitung sidik jari tabel SEKALI.
        $sidikAda = $cegahDuplikat ? self::sidikTersimpan('keluar') : [];

        foreach ($baris as $i => $b) {
            $nomorBaris = $i + 1;

            try {
                $tanggal = self::tanggal($b['tanggal'] ?? null);
                $jumlah = self::jumlah($b['jumlah'] ?? null);

                if ($tanggal === null || $jumlah === null) {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: tanggal/jumlah tidak valid.";

                    continue;
                }

                // (c) Tanggal ≤ hari ini.
                if ($tanggal > now()->toDateString()) {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: tanggal {$tanggal} melebihi hari ini.";

                    continue;
                }

                $akun = self::akun($b['akun'] ?? null);
                $kategoriHasil = self::kategori($b['kategori'] ?? null);
                $kategori = $kategoriHasil['kategori'];
                $detailKategori = $b['detail_kategori'] ?? $kategoriHasil['detail_kategori'];
                $spk = self::cariSpk($b);
                $spkId = $spk?->id;

                if ($spk === null && (! empty($b['spk_id']) || ! empty($b['nomor_spk']))) {
                    $labelRef = (string) ($b['nomor_spk'] ?? $b['spk_id']);
                    $hasil['gagal'][] = "Baris {$nomorBaris}: SPK '{$labelRef}' tidak ditemukan.";

                    continue;
                }

                // (b) SPK Dibatalkan menolak transaksi baru.
                if ($spk !== null && $spk->status_spk !== null && ! $spk->status_spk->bolehTransaksiBaru()) {
                    $hasil['gagal'][] = "Baris {$nomorBaris}: SPK {$spk->nomor_spk} berstatus Dibatalkan - tidak bisa menerima transaksi baru.";

                    continue;
                }

                $sidik = self::sidik('keluar', $tanggal, $jumlah, $akun, $b['keterangan'] ?? null, $spkId);

                if ($cegahDuplikat && isset($sidikAda[$sidik])) {
                    $hasil['dilewati']++;

                    continue;
                }

                UangKeluar::create([
                    'spk_id' => $spkId,
                    'tanggal' => $tanggal,
                    'akun' => $akun,
                    'jumlah' => $jumlah,
                    'kategori' => $kategori,
                    'detail_kategori' => $detailKategori,
                    'penerima' => $b['penerima'] ?? null,
                    'keterangan' => $b['keterangan'] ?? null,
                ]);

                $sidikAda[$sidik] = true;
                $hasil['ditambah']++;
            } catch (\Throwable $e) {
                $hasil['gagal'][] = "Baris {$nomorBaris}: ".$e->getMessage();
            }
        }

        return $hasil;
    }

    // Sidik jari (deteksi duplikat) - tanpa tabel baru.

    /**
     * Himpunan sidik jari SELURUH baris tersimpan (termasuk ter-soft-delete).
     *
     * ⚠️ BUG-1: dipanggil SEKALI per impor, BUKAN per baris. Ini yang mengubah
     * O(n²) jadi O(n).
     *
     * @return array<string, true>
     */
    private static function sidikTersimpan(string $jenis): array
    {
        $model = $jenis === 'masuk' ? UangMasuk::class : UangKeluar::class;

        $himpunan = [];

        // Bandingkan terhadap SEMUA baris (termasuk yang ter-soft-delete),
        // supaya baris yang pernah dihapus tidak "kembali" saat impor ulang.
        foreach ($model::withTrashed()->get() as $r) {
            $himpunan[self::sidik(
                $jenis,
                Carbon::parse($r->tanggal)->toDateString(),
                (float) $r->jumlah,
                $r->akun instanceof AkunKas ? $r->akun->value : $r->akun,
                $r->keterangan ?? null,
                $r->spk_id ?? null,
            )] = true;
        }

        return $himpunan;
    }

    private static function sidik(string $jenis, string $tanggal, float $jumlah, ?string $akun, ?string $keterangan, mixed $spkId): string
    {
        return md5(implode('|', [
            $jenis,
            $tanggal,
            number_format($jumlah, 2, '.', ''),
            (string) $akun,
            mb_strtolower(trim((string) $keterangan)),
            (string) self::spkId($spkId),
        ]));
    }

    // Normalisasi nilai

    private static function tanggal(mixed $nilai): ?string
    {
        if ($nilai === null || $nilai === '') {
            return null;
        }

        if (is_string($nilai)) {
            $t = trim($nilai);
            if (strtoupper($t) === 'TANPA SPK' || $t === '') {
                return null;
            }

            // Tanggal Indonesia dengan slash: 26/06/2026, 26/6/26, 2/7/26, 23/2/2026
            if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})$/', $t, $m)) {
                $hari = (int) $m[1];
                $bulan = (int) $m[2];
                $tahun = (int) $m[3];
                if ($tahun < 100) {
                    $tahun += 2000;
                }

                if (checkdate($bulan, $hari, $tahun)) {
                    return sprintf('%04d-%02d-%02d', $tahun, $bulan, $hari);
                }
            }

            // Tanggal Indonesia dengan minus: 26-06-2026, 26-6-26
            if (preg_match('/^(\d{1,2})-(\d{1,2})-(\d{2,4})$/', $t, $m)) {
                $hari = (int) $m[1];
                $bulan = (int) $m[2];
                $tahun = (int) $m[3];
                if ($tahun < 100) {
                    $tahun += 2000;
                }

                if (checkdate($bulan, $hari, $tahun)) {
                    return sprintf('%04d-%02d-%02d', $tahun, $bulan, $hari);
                }
            }
        }

        // Integer serial date Excel (misal 45469)
        if (is_int($nilai) || (is_numeric($nilai) && ! str_contains((string) $nilai, '-') && ! str_contains((string) $nilai, '/'))) {
            $serial = (int) $nilai;
            // Serial date Excel valid (antara 1900 dan 2100 ~ 1 hingga 73050)
            if ($serial > 1000 && $serial < 100000) {
                try {
                    // Excel epoch: 1899-12-30 karena bug tahun kabisat 1900
                    return Carbon::create(1899, 12, 30)->addDays($serial)->toDateString();
                } catch (\Throwable) {
                    // Abaikan dan coba parse biasa
                }
            }
        }

        try {
            return Carbon::parse($nilai)->toDateString();
        } catch (\Throwable) {
            return null;
        }
    }

    public static function jumlah(mixed $nilai): ?float
    {
        if ($nilai === null || $nilai === '') {
            return null;
        }

        // Terima format "1.500.000", "2,500,000", "1500000", "1 500 000".
        $bersih = preg_replace('/[^0-9,.\-]/', '', (string) $nilai);

        if ($bersih === null || $bersih === '' || $bersih === '-') {
            return null;
        }

        $adaTitik = str_contains($bersih, '.');
        $adaKoma = str_contains($bersih, ',');

        if ($adaTitik && $adaKoma) {
            // Keduanya ada → yang TERAKHIR adalah pemisah desimal.
            if (strrpos($bersih, ',') > strrpos($bersih, '.')) {
                // Format Indonesia: titik ribuan, koma desimal.
                $bersih = str_replace('.', '', $bersih);
                $bersih = str_replace(',', '.', $bersih);
            } else {
                // Format Inggris: koma ribuan, titik desimal.
                $bersih = str_replace(',', '', $bersih);
            }
        } elseif ($adaKoma) {
            // Hanya koma: banyak koma = ribuan; satu koma = desimal.
            $bersih = substr_count($bersih, ',') > 1
                ? str_replace(',', '', $bersih)
                : str_replace(',', '.', $bersih);
        } elseif ($adaTitik && substr_count($bersih, '.') > 1) {
            // Banyak titik = pemisah ribuan.
            $bersih = str_replace('.', '', $bersih);
        } elseif ($adaTitik) {
            // Satu titik. Format Indonesia "1.500" (3 digit di belakang) =
            // pemisah ribuan; selain itu anggap desimal.
            if (preg_match('/^\d{1,3}(\.\d{3})+$/', $bersih) === 1) {
                $bersih = str_replace('.', '', $bersih);
            }
        }

        $angka = (float) $bersih;

        return ($angka > 0 && $angka <= self::BATAS_NOMINAL) ? $angka : null;
    }

    private static function akun(mixed $nilai): ?string
    {
        $v = strtolower(trim((string) $nilai));

        return match (true) {
            str_contains($v, 'bank') => AkunKas::Bank->value,
            str_contains($v, 'kas') => AkunKas::Kas->value,
            default => null,
        };
    }

    /**
     * @return array{kategori: ?string, detail_kategori: ?string}
     */
    private static function kategori(mixed $nilai): array
    {
        $raw = trim((string) $nilai);
        if ($raw === '') {
            return ['kategori' => null, 'detail_kategori' => null];
        }

        $v = strtolower($raw);

        foreach (KategoriPengeluaran::cases() as $k) {
            if ($v === $k->value || str_contains($v, $k->value)) {
                return ['kategori' => $k->value, 'detail_kategori' => null];
            }
        }

        return ['kategori' => KategoriPengeluaran::Lainnya->value, 'detail_kategori' => $raw];
    }

    private static function spkId(mixed $nilai): ?int
    {
        if ($nilai === null || $nilai === '') {
            return null;
        }

        return is_numeric($nilai) ? (int) $nilai : null;
    }

    /**
     * Resolusi SPK dari `spk_id` (numerik) atau `nomor_spk` (teks nomor kontrak).
     * Toleran terhadap pencarian parsial jika nomor spesifik tidak cocok eksak.
     *
     * @param  array<string, mixed>  $baris
     */
    private static function cariSpk(array $baris): ?Spk
    {
        $id = self::spkId($baris['spk_id'] ?? null);
        if ($id !== null) {
            return Spk::find($id);
        }

        $nomor = trim((string) ($baris['nomor_spk'] ?? ''));
        if ($nomor === '') {
            return null;
        }

        $spk = Spk::where('nomor_spk', $nomor)->first();
        if ($spk !== null) {
            return $spk;
        }

        // Coba nomor tanpa spasi berlebih
        $spk = Spk::whereRaw('TRIM(nomor_spk) = ?', [$nomor])->first();
        if ($spk !== null) {
            return $spk;
        }

        // Toleransi parsial: cari jika nomor unik (misal bagian nomor awal / pola SPK)
        if (strlen($nomor) >= 4) {
            $kandidat = Spk::where('nomor_spk', 'like', "%{$nomor}%")->limit(2)->get();
            if ($kandidat->count() === 1) {
                return $kandidat->first();
            }
        }

        return null;
    }
}
