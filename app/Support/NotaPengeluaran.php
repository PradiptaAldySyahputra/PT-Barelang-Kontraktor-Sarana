<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\KategoriPengeluaran;
use App\Services\PembacaNota;
use App\Services\PenyimpanBerkas;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Throwable;

/**
 * LOGIKA MURNI pengolahan nota Uang Keluar.
 *
 * ⚠️ KENAPA DIPISAH DARI `UangKeluarForm`:
 * Dulu SEMUA logika (skema form + OCR + penyusun baris) menumpuk di satu
 * berkas `UangKeluarForm` (± 1.620 baris) - "god class" yang sulit dibaca,
 * diuji, dan diubah. Kelas ini memindahkan bagian yang TIDAK butuh Filament
 * (baca OCR, susun baris rincian, salin isian) ke sini, sehingga:
 *   - bisa diuji TANPA Livewire/browser (fungsi murni);
 *   - `UangKeluarForm` tinggal menyusun skema + memanggil kelas ini.
 *
 * Semua method di sini MURNI/statis: tidak menyentuh state Livewire. Itu
 * disengaja - dulu logika yang sama terjebak di dalam closure form sehingga
 * tidak terjangkau tes.
 *
 * JUMLAH NOTA - DITENTUKAN ADMIN, BUKAN DITEBAK SISTEM.
 * Satu berkas (PDF/gambar) bisa berisi BEBERAPA nota (contoh nyata: 1 halaman
 * A4 berisi 4 form "NOTA NO."). Jadi "1 berkas = 1 nota" adalah asumsi SALAH.
 * Sistem sengaja tidak menebak: OCR hanya BANTUAN, admin tetap penentu.
 */
final class NotaPengeluaran
{
    /**
     * Batas pengaman jumlah berkas & baris sekaligus.
     *
     * Dinaikkan 20 → 50 (8 Okt 2026) → 200 (permintaan user): berkas gabungan
     * sebulan sering berisi puluhan–ratusan nota (contoh nyata: 57 nota dalam
     * 15 halaman). 200 memberi ruang cukup, sekaligus menahan salah ketik
     * ekstrem (mis. "4000") yang bisa membuat browser hang.
     */
    public const MAKS_BARIS = 200;

    /**
     * Maksimal nota yang boleh dideklarasikan untuk SATU berkas (mode rinci).
     *
     * ⚠️ PERBAIKAN BUG (audit): dulu nilainya 10, SEDANGKAN `MAKS_BARIS` 20.
     * Akibatnya mode rinci dengan 12 nota hanya membuat 10 baris DIAM-DIAM -
     * 2 nota hilang dari laporan tanpa peringatan. Sekarang disamakan dengan
     * `MAKS_BARIS`, jadi batas per berkas TIDAK PERNAH lebih ketat daripada
     * batas total baris.
     */
    public const MAKS_NOTA_PER_BERKAS = self::MAKS_BARIS;

    /**
     * Jumlah nota default saat berkas baru diunggah.
     *
     * Permintaan user: "untuk jumlah nota default buat saja langsung 4 form
     * tetapi masih bisa diubah". Dipilih 4 karena 1 lembar nota di lapangan
     * biasanya berisi 4 form "NOTA NO.".
     */
    public const DEFAULT_NOTA = 4;

    /**
     * Mode input per berkas.
     *
     *   - 'total' → 1 berkas = 1 baris (isi TOTAL saja). Untuk nota sebulan
     *     yang di-merge jadi satu PDF (mis. 57 nota jadi 1 file).
     *   - 'rinci' → 1 berkas = N baris (tiap nota sendiri). Untuk nota
     *     satuan / harian.
     *
     * DEFAULT 'rinci' (keputusan user 8 Okt 2026): ketika satu berkas berisi
     * banyak nota, user ingin tiap nota dipotong & dibuatkan form sendiri.
     */
    public const MODE_DEFAULT = 'rinci';

    /**
     * Batas atas jumlah nota untuk keperluan INFORMASI (mode total).
     *
     * Berkas gabungan sebulan bisa berisi puluhan nota. Angka ini hanya info
     * "berkas ini berisi N nota", BUKAN untuk membuat baris - jadi longgar.
     */
    public const MAKS_NOTA_INFO = 999;

    /**
     * Kolom yang diisi ADMIN (bukan struktur) pada satu baris pengeluaran.
     *
     * Dipakai `isianAdmin()` untuk mempertahankan isian admin saat baris
     * disusun ulang. JANGAN masukkan kolom struktur (`bukti`, `nota_ke`,
     * `mode`, `potongan`, `sumber`, `berkas_ke`) - itu selalu dibuat baru.
     *
     * @var list<string>
     */
    private const KOLOM_ISIAN = [
        'jumlah',
        'akun',
        'kategori',
        'detail_kategori',
        'penerima',
        'spk_id',
        'keterangan',
        'tanggal',
    ];

    /**
     * Ambil path file dari state unggahan.
     *
     * PENTING: jangan panggil `store($disk)` - argumen pertama `store()` adalah
     * NAMA FOLDER, bukan disk; pernah menyebabkan file tersimpan di
     * `storage/app/public/public/` dan tidak bisa dibuka.
     *
     * Menerima ARRAY juga, karena unggahan bisa berbentuk array walau isinya
     * satu berkas.
     */
    public static function pathFile(mixed $file): ?string
    {
        // State berbentuk array - ambil berkas pertamanya.
        if (is_array($file)) {
            foreach ($file as $satu) {
                if (filled($path = self::pathFile($satu))) {
                    return $path;
                }
            }

            return null;
        }

        if (is_string($file)) {
            return $file;
        }

        if (! is_object($file)) {
            return null;
        }

        /*
         * ⚠️ JANGAN kembalikan path berkas SEMENTARA (livewire-tmp/...).
         *
         * Bug yang pernah terjadi: berkas sementara dikembalikan sebagai path,
         * sehingga `Storage::disk('public')->exists()` gagal ("File tidak
         * ditemukan") dan OCR tidak bisa membaca berkas.
         *
         * Sekarang berkas diringankan (kompres) lalu DISIMPAN ke disk, dan yang
         * dikembalikan adalah path RELATIF yang benar (mis. uang_keluar/x.jpg).
         * Karena nama berkas deterministik, pemanggilan berulang tidak membuat
         * salinan ganda - pemanggilan berikutnya memakai path yang SAMA saat Simpan.
         */
        if ($file instanceof UploadedFile) {
            return app(PenyimpanBerkas::class)->simpanKe($file, 'uang_keluar', 'nota');
        }

        return null;
    }

    /**
     * Jalankan OCR saat berkas nota diunggah.
     *
     * Yang dilakukan:
     *   1. Hitung jumlah nota di dalam berkas -> isi field `jumlah_nota`.
     *   2. Simpan path potongan tiap nota -> dipakai pratinjau per baris.
     *
     * ⚠️ OCR ini BANTUAN. Kalau gagal, TIDAK boleh menghalangi admin: jumlah
     * nota dibiarkan apa adanya (default 4) dan admin bisa ubah manual. Karena
     * itu semua kegagalan ditangkap dan hanya dicatat di log.
     *
     * @param  mixed  $state  state FileUpload (array path, karena multiple)
     * @return array{jumlah_nota: int|null, potongan: array<int, string>, isi: array<int, array<string, mixed>>, pesan: string|null}
     */
    public static function bacaDenganOcr(mixed $state): array
    {
        $kosong = ['jumlah_nota' => null, 'potongan' => [], 'isi' => [], 'pesan' => null];

        $pembaca = app(PembacaNota::class);

        if (! $pembaca->aktif()) {
            return $kosong;
        }

        $path = self::pathFile($state);

        if (blank($path)) {
            // Berkas dihapus - bersihkan hasil OCR sebelumnya.
            return ['jumlah_nota' => null, 'potongan' => [], 'isi' => [], 'pesan' => ''];
        }

        try {
            $hasil = $pembaca->baca($path);
        } catch (Throwable $e) {
            // OCR tidak boleh menjatuhkan form.
            report($e);

            return $kosong;
        }

        if (! ($hasil['ok'] ?? false)) {
            // Gagal baca: beri tahu admin supaya dia tahu harus isi manual.
            return [
                'jumlah_nota' => null,
                'potongan' => [],
                'isi' => [],
                'pesan' => 'OCR tidak bisa membaca berkas ini - isi jumlah nota manual.',
            ];
        }

        $jumlah = (int) $hasil['jumlah_nota'];

        // DRAF isi tiap nota (nominal/tanggal/penerima/kategori) - dipakai
        // mengisi baris otomatis. Admin tetap bisa mengubah.
        $isi = is_array($hasil['nota'] ?? null) ? $hasil['nota'] : [];

        return [
            'jumlah_nota' => $jumlah,
            'potongan' => $hasil['potongan'] ?? [],
            'isi' => $isi,
            'pesan' => $jumlah > 1
                ? "OCR mendeteksi {$jumlah} nota di berkas ini."
                : null,
        ];
    }

    /**
     * Jalankan OCR untuk seluruh berkas, kembalikan state yang sudah diperbarui.
     *
     * ⚠️ CARA KERJA & KENAPA BEGINI
     *
     * Dipanggil dari `Repeater::afterStateUpdated()` (repeater WAJIB `live()`,
     * kalau tidak event-nya tidak pernah terpanggil saat FilePond selesai
     * mengunggah - sudah dibuktikan lewat trace).
     *
     * Hasil OCR (jumlah nota + potongan) TIDAK ditulis ke dalam item repeater
     * lewat `$set()` dari dalam item, karena itu menyebabkan error
     * "$attribute was unresolvable". Sebagai gantinya:
     *
     *   1. Hasil OCR disimpan di CACHE tingkat form (`potongan_ocr`).
     *   2. `berkas` yang dikembalikan sudah berisi `jumlah_nota` hasil OCR.
     *   3. Pemanggil menulis kembali `berkas_nota` HANYA kalau ada perubahan -
     *      ini yang memutus potensi loop.
     *
     * @param  array<mixed>  $berkas
     * @param  array<string, array<int, string>>  $cache
     * @param  array<string, array<int, array<string, mixed>>>  $cacheIsi
     * @return array{berkas: array<mixed>, potongan: array<string, array<int, string>>, isi: array<string, array<int, array<string, mixed>>>}
     */
    public static function prosesOcr(array $berkas, array $cache = [], array $cacheIsi = []): array
    {
        if (! app(PembacaNota::class)->aktif()) {
            return ['berkas' => $berkas, 'potongan' => $cache, 'isi' => $cacheIsi];
        }

        $peta = $cache;
        $petaIsi = $cacheIsi;

        foreach ($berkas as $index => $item) {
            if (! is_array($item)) {
                continue;
            }

            $path = self::pathFile($item['file'] ?? null);

            if (blank($path)) {
                continue;
            }

            // Sudah pernah dibaca -> pakai hasil cache (jangan OCR ulang).
            if (array_key_exists($path, $peta)) {
                continue;
            }

            $hasil = self::bacaDenganOcr($item['file'] ?? null);

            $peta[$path] = $hasil['potongan'];
            $petaIsi[$path] = $hasil['isi'];

            // Tulis hasil OCR ke item, supaya `jumlah_nota` di form ikut terisi
            // dan baris rincian disusun dengan jumlah yang benar.
            if ($hasil['jumlah_nota'] !== null) {
                $berkas[$index]['jumlah_nota'] = $hasil['jumlah_nota'];
            }

            $berkas[$index]['ocr_info'] = $hasil['pesan'];
        }

        return ['berkas' => $berkas, 'potongan' => $peta, 'isi' => $petaIsi];
    }

    /**
     * Hitung peta potongan (path berkas -> daftar potongan) dengan menjalankan
     * OCR hanya untuk berkas yang BELUM ada di peta.
     *
     * DIBUAT FUNGSI MURNI supaya bisa diuji langsung tanpa Livewire - tes
     * lewat `fillForm` tidak memicu `afterStateUpdated`, sehingga jalur ini
     * tidak terjangkau oleh tes berbasis Livewire.
     *
     * Penjaga idempoten: berkas yang sudah ada di `$petaLama` dilewati, jadi
     * OCR jalan SEKALI per berkas (tidak diulang tiap admin mengetik).
     *
     * @param  array<mixed>  $berkas  state repeater `berkas_nota`
     * @param  array<string, array<int, string>>  $petaLama
     * @return array<string, array<int, string>>
     */
    public static function hitungPetaPotongan(array $berkas, array $petaLama = []): array
    {
        if (! app(PembacaNota::class)->aktif()) {
            return $petaLama;
        }

        $peta = $petaLama;

        foreach ($berkas as $item) {
            if (! is_array($item)) {
                continue;
            }

            $path = self::pathFile($item['file'] ?? null);

            if (blank($path)) {
                continue;
            }

            // Sudah pernah dibaca -> lewati.
            if (array_key_exists($path, $peta)) {
                continue;
            }

            $hasil = self::bacaDenganOcr($item['file'] ?? null);

            $peta[$path] = $hasil['potongan'];
        }

        return $peta;
    }

    /**
     * Jalankan OCR lalu kembalikan state form yang sudah diperbarui.
     *
     * Dipakai oleh tes dan oleh tempat lain yang butuh hasil lengkap
     * (jumlah nota per berkas + baris rincian) dalam satu panggilan.
     *
     * @param  array<mixed>  $berkas
     * @return array{berkas: array<mixed>, potongan: array<string, array<int, string>>, isi: array<string, array<int, array<string, mixed>>>, baris: array<int, array<string, mixed>>}
     */
    public static function jalankanOcrPenuh(array $berkas): array
    {
        $peta = self::hitungPetaPotongan($berkas);
        $petaIsi = [];

        // Isi jumlah_nota per berkas dari hasil OCR.
        foreach ($berkas as $index => $item) {
            if (! is_array($item)) {
                continue;
            }

            $path = self::pathFile($item['file'] ?? null);

            if (blank($path)) {
                continue;
            }

            $hasil = self::bacaDenganOcr($item['file'] ?? null);

            if ($hasil['jumlah_nota'] !== null) {
                $berkas[$index]['jumlah_nota'] = $hasil['jumlah_nota'];
            }

            $berkas[$index]['ocr_info'] = $hasil['pesan'];
            $petaIsi[$path] = $hasil['isi'];
        }

        return [
            'berkas' => $berkas,
            'potongan' => $peta,
            'isi' => $petaIsi,
            'baris' => self::susunBaris($berkas, $peta, [], [], $petaIsi),
        ];
    }

    /**
     * Salin isian "struktur" dari SATU baris ke baris-baris yang masih KOSONG.
     *
     * ⚠️ SARAN USER (9 Okt 2026): "Duplikat baris - tombol 'salin baris ini'
     * untuk nota sejenis (beda nominal saja)."
     *
     * Dipisah dari komponen agar logika bisa diuji tanpa browser.
     * HANYA kolom yang biasanya sama antar-nota sejenis yang disalin -
     * `jumlah` (nominal) SENGAJA TIDAK disalin karena itu yang berbeda.
     *
     * @param  array<int|string, mixed>  $items
     * @return array{items: array<int|string, mixed>, jumlah: int}
     */
    public static function salinIsianKeBarisKosong(array $items, mixed $dari): array
    {
        if ($dari === null || ! isset($items[$dari])) {
            return ['items' => $items, 'jumlah' => 0];
        }

        $kolomSalin = ['kategori', 'detail_kategori', 'penerima', 'spk_id', 'akun', 'tanggal'];
        $sumber = is_array($items[$dari]) ? $items[$dari] : [];
        $jumlah = 0;

        foreach ($items as $kunci => $baris) {
            if ((string) $kunci === (string) $dari || ! is_array($baris)) {
                continue;
            }

            // Baris "kosong" = belum ada nominal.
            if (filled($baris['jumlah'] ?? null)) {
                continue;
            }

            foreach ($kolomSalin as $kolom) {
                if (filled($sumber[$kolom] ?? null)) {
                    $items[$kunci][$kolom] = $sumber[$kolom];
                }
            }

            $jumlah++;
        }

        return ['items' => $items, 'jumlah' => $jumlah];
    }

    /**
     * Ambil HANYA isian admin dari satu baris lama, untuk disalin ke baris baru.
     *
     * ⚠️ INI KUNCI PERBAIKAN BUG "isian hilang".
     *
     * `susunBaris()` membuat baris baru setiap kali berkas berubah. Tanpa
     * fungsi ini, isian admin (jumlah, kategori, dst) ikut terbuang dan alert
     * "belum lengkap" muncul padahal sudah diisi.
     *
     * Sengaja HANYA kolom isian yang disalin - kolom struktur (`bukti`,
     * `berkas_ke`, `nota_ke`, `mode`, `potongan`, `sumber`) TIDAK disalin,
     * supaya struktur baru dari `susunBaris()` yang menang.
     *
     * @param  array<string, mixed>  $lama
     * @return array<string, mixed>
     */
    public static function isianAdmin(array $lama): array
    {
        $isian = [];

        foreach (self::KOLOM_ISIAN as $kolom) {
            if (array_key_exists($kolom, $lama) && filled($lama[$kolom])) {
                $isian[$kolom] = $lama[$kolom];
            }
        }

        return $isian;
    }

    /**
     * Ubah DRAF hasil OCR satu nota menjadi isian baris.
     *
     * ⚠️ HANYA field yang BERHASIL dibaca yang diisi (null/blank dilewati),
     * supaya baris tidak terisi nilai kosong yang menutupi input admin.
     *
     * ⚠️ Hasilnya DRAF. `susunBaris()` memasang draf ini LEBIH DULU daripada
     * isian admin (`isianAdmin`), jadi apa pun yang sudah diketik admin selalu
     * menang. Ini pengaman agar OCR tidak pernah menimpa pekerjaan admin -
     * penting karena nota banyak yang tulisan tangan dan bisa salah baca.
     *
     * @param  array<string, mixed>  $isi  satu entri dari `petaIsi` hasil OCR
     * @return array<string, mixed>
     */
    public static function isianOcr(array $isi): array
    {
        $isian = [];

        // Nominal → kolom `jumlah` (hanya kalau wajar).
        $nominal = $isi['nominal'] ?? null;

        if (is_numeric($nominal) && (int) $nominal > 0) {
            $isian['jumlah'] = (int) $nominal;
        }

        // Kategori saran - HANYA kalau kode enum-nya valid, supaya dropdown
        // tidak menerima nilai asing.
        $kategori = $isi['kategori'] ?? null;

        if (is_string($kategori) && array_key_exists($kategori, KategoriPengeluaran::opsi())) {
            $isian['kategori'] = $kategori;
        }

        if (filled($isi['penerima'] ?? null)) {
            $isian['penerima'] = mb_substr((string) $isi['penerima'], 0, 200);
        }

        if (filled($isi['keterangan'] ?? null)) {
            $isian['keterangan'] = mb_substr((string) $isi['keterangan'], 0, 500);
        }

        return $isian;
    }

    /**
     * Gabungkan baris BARU dengan baris LAMA sambil MEMPERTAHANKAN KUNCI item.
     *
     * ⚠️ INI PENTING - JANGAN DIHAPUS.
     *
     * Livewire mengenali tiap baris repeater dari KUNCI array-nya (UUID).
     * Kalau `$set('pengeluaran', ...)` mengembalikan array dengan kunci BARU,
     * semua item dianggap "baris baru" - akibatnya:
     *   - fokus/kursor admin bisa lepas saat mengetik;
     *   - pilihan dropdown (mis. Kategori) yang dikirim browser "nyasar" ke
     *     item lama, sehingga tersimpan sebagai NULL.
     *
     * SEKARANG kunci dicocokkan lewat IDENTITAS baris (sumber berkas + nomor
     * nota), BUKAN posisi. Kunci tetap menempel pada nota yang sama walau
     * jumlah/urutan baris berubah.
     *
     * @param  array<mixed>  $lama
     * @param  array<int, array<string, mixed>>  $baru
     * @return array<string, array<string, mixed>>
     */
    public static function gabungBaris(array $lama, array $baru): array
    {
        // Peta IDENTITAS -> kunci lama. Identitas = sumber berkas + nota ke-berapa.
        $kunciPerIdentitas = [];

        foreach ($lama as $kunci => $r) {
            if (! is_array($r)) {
                continue;
            }

            $identitas = self::identitasBaris($r);

            // Kalau ada identitas ganda (seharusnya tidak), kunci pertama menang.
            if ($identitas !== null && ! isset($kunciPerIdentitas[$identitas])) {
                $kunciPerIdentitas[$identitas] = (string) $kunci;
            }
        }

        $hasil = [];
        $terpakai = [];

        foreach ($baru as $r) {
            $identitas = self::identitasBaris($r);

            // Pakai ulang kunci lama kalau identitasnya sama & belum dipakai.
            $kunci = null;

            if ($identitas !== null && isset($kunciPerIdentitas[$identitas])) {
                $kandidat = $kunciPerIdentitas[$identitas];

                if (! isset($terpakai[$kandidat])) {
                    $kunci = $kandidat;
                }
            }

            $kunci ??= (string) Str::uuid();

            $terpakai[$kunci] = true;
            $hasil[$kunci] = $r;
        }

        return $hasil;
    }

    /**
     * Identitas unik satu baris: sumber berkas + nomor nota.
     *
     * Dipakai `gabungBaris()` supaya kunci Livewire menempel pada NOTA yang
     * sama, bukan pada POSISI baris. `nota_ke` = 0 untuk mode total.
     *
     * @param  array<string, mixed>  $r
     */
    public static function identitasBaris(array $r): ?string
    {
        $sumber = $r['sumber'] ?? null;

        // Sumber bisa berupa array (state FileUpload) - ambil berkas pertama.
        if (is_array($sumber)) {
            $sumber = reset($sumber) ?: null;
        }

        if (blank($sumber)) {
            return null;
        }

        return $sumber.'|'.(int) ($r['nota_ke'] ?? 0);
    }

    /**
     * Susun baris rincian dari daftar berkas + jumlah notanya.
     *
     * Aturan penting:
     *   1. Isian admin yang SUDAH ADA dipertahankan (jangan hilang saat berkas
     *      ditambah/diubah) - dicocokkan lewat identitas (berkas + nomor nota).
     *   2. Tiap baris otomatis menunjuk berkasnya sendiri (`sumber` + `bukti`),
     *      jadi admin tidak perlu memilih berkas lagi.
     *   3. Jumlah total baris dibatasi MAKS_BARIS sebagai pengaman.
     *
     * @param  mixed  $berkas  state repeater `berkas_nota`
     * @param  array<string, array<int, string>>  $petaPotongan
     *                                                           Peta path berkas -> daftar path potongan hasil OCR.
     * @param  array<string, array<int, array<string, mixed>>>  $petaIsi
     *                                                                    Peta path berkas -> daftar DRAF isi tiap nota hasil OCR.
     * @return array<int, array<string, mixed>>
     */
    public static function susunBaris(mixed $berkas, array $petaPotongan = [], array $petaJumlah = [], mixed $lama = [], array $petaIsi = []): array
    {
        $baris = [];
        $nomorBerkas = 0;
        $terpotong = false;

        $petaIsian = self::petaIsianAdmin($lama);

        $berkasList = collect(is_array($berkas) ? $berkas : [])
            ->filter(fn ($item): bool => is_array($item) && filled(self::pathFile($item['file'] ?? null)));

        $totalBerkas = $berkasList->count();

        foreach ($berkasList as $item) {
            $path = self::pathFile($item['file'] ?? null);

            if (blank($path)) {
                continue;
            }

            $nomorBerkas++;

            /*
             * MODE PER BERKAS - "total" atau "rinci".
             *   - mode 'total' -> 1 berkas = 1 baris (isi TOTAL saja).
             *   - mode 'rinci' -> 1 berkas = N baris (tiap nota sendiri).
             * Mode dipilih ADMIN per berkas - sistem tidak menebak.
             */
            $mode = ($item['mode'] ?? self::MODE_DEFAULT) === 'rinci' ? 'rinci' : 'total';

            [$mentah, $jumlahNota] = self::hitungJumlahNota($item, $path, $petaJumlah, $mode);

            // Potongan nota hasil OCR. Sumber utamanya `$petaPotongan`
            // (state tingkat form); item repeater dipakai sebagai cadangan.
            $potongan = $petaPotongan[$path]
                ?? (is_array($item['potongan'] ?? null) ? array_values($item['potongan']) : []);

            // MODE TOTAL: satu baris untuk seluruh berkas.
            if ($mode === 'total') {
                if (count($baris) >= self::MAKS_BARIS) {
                    $terpotong = true;
                    break;
                }

                $baris[] = self::barisTotal($path, $nomorBerkas, $totalBerkas, $jumlahNota, $petaIsian);

                continue;
            }

            // MODE RINCI: satu baris per nota.
            //
            // Kalau jumlah nota MENTAH melebihi batas pengaman, sistem
            // memotongnya. Itu harus DITANDAI (bukan diam-diam), supaya admin
            // tahu ada nota yang belum tercatat.
            if ($mentah > $jumlahNota) {
                $terpotong = true;
            }

            $hasilRinci = self::barisRinci(
                $path, $nomorBerkas, $totalBerkas, $jumlahNota, $potongan,
                $petaIsi, $petaIsian, $baris,
            );

            $baris = $hasilRinci['baris'];
            $terpotong = $terpotong || $hasilRinci['terpotong'];

            if ($hasilRinci['berhenti']) {
                break;
            }
        }

        // Tandai baris TERAKHIR kalau ada yang terpotong batas pengaman.
        if ($terpotong && $baris !== []) {
            $baris[count($baris) - 1]['terpotong'] = true;
        }

        return $baris === [] ? [[]] : $baris;
    }

    /**
     * PETA ISIAN ADMIN YANG SUDAH ADA - SUMBER PERBAIKAN BUG PENTING.
     *
     * `susunBaris()` dipanggil ULANG setiap kali berkas berubah (mis. OCR
     * selesai 40 detik setelah admin mulai mengetik). Dulu setiap panggilan
     * MEMBUAT BARIS BARU KOSONG, sehingga isian admin HILANG - dan alert
     * "Masih ada N baris belum lengkap" muncul padahal barisnya sudah diisi.
     *
     * Perbaikan: baris lama diindeks per (berkas + nomor nota), lalu isian
     * admin disalin kembali ke baris baru.
     *
     * @return array<string, array<int, array<string, mixed>>>
     */
    private static function petaIsianAdmin(mixed $lama): array
    {
        $petaIsian = [];

        foreach (collect(is_array($lama) ? $lama : [])->filter() as $r) {
            if (! is_array($r)) {
                continue;
            }

            $pLama = self::pathFile($r['bukti'] ?? null);

            if (blank($pLama)) {
                continue;
            }

            $petaIsian[$pLama][(int) ($r['nota_ke'] ?? 0)] = $r;
        }

        return $petaIsian;
    }

    /**
     * Hitung jumlah nota untuk satu berkas, dibatasi sesuai mode.
     *
     * BEDA BATAS PER MODE:
     *   - mode RINCI: dibatasi MAKS_NOTA_PER_BERKAS (menentukan jumlah BARIS).
     *   - mode TOTAL: hanya INFO, batasnya longgar (MAKS_NOTA_INFO).
     *
     * @param  array<string, mixed>  $item
     * @param  array<string, mixed>  $petaJumlah
     * @return array{0: int, 1: int} [mentah, jumlahNota]
     */
    private static function hitungJumlahNota(array $item, string $path, array $petaJumlah, string $mode): array
    {
        $dariOcr = (int) ($petaJumlah[$path] ?? 0);
        $dariAdmin = (int) ($item['jumlah_nota'] ?? 0);

        $mentah = $dariOcr > 0 ? $dariOcr : ($dariAdmin > 0 ? $dariAdmin : self::DEFAULT_NOTA);

        $jumlahNota = $mode === 'total'
            ? max(1, min(self::MAKS_NOTA_INFO, $mentah))
            : max(1, min(self::MAKS_NOTA_PER_BERKAS, $mentah));

        return [$mentah, $jumlahNota];
    }

    /**
     * Satu baris untuk mode TOTAL (seluruh berkas dicatat sebagai satu total).
     *
     * @param  array<string, array<int, array<string, mixed>>>  $petaIsian
     * @return array<string, mixed>
     */
    private static function barisTotal(string $path, int $nomorBerkas, int $totalBerkas, int $jumlahNota, array $petaIsian): array
    {
        return array_merge([
            'bukti' => [$path],
            'sumber' => $path,
            'berkas_ke' => $nomorBerkas,
            'berkas_dari' => $totalBerkas,
            // nota_ke = 0 menandai "ini total seluruh berkas".
            'nota_ke' => 0,
            'nota_dari' => $jumlahNota,
            'mode' => 'total',
            // Mode total: tampilkan berkas UTUH, bukan potongan.
            'potongan' => null,
            'tanggal' => now()->toDateString(),
        ], self::isianAdmin($petaIsian[$path][0] ?? []));
    }

    /**
     * Baris-baris untuk mode RINCI (satu baris per nota).
     *
     * @param  array<int, string>  $potongan
     * @param  array<string, mixed>  $petaIsi
     * @param  array<string, array<int, array<string, mixed>>>  $petaIsian
     * @param  array<int, array<string, mixed>>  $baris  baris yang sudah tersusun
     * @return array{baris: array<int, array<string, mixed>>, terpotong: bool, berhenti: bool}
     */
    private static function barisRinci(
        string $path,
        int $nomorBerkas,
        int $totalBerkas,
        int $jumlahNota,
        array $potongan,
        array $petaIsi,
        array $petaIsian,
        array $baris,
    ): array {
        $terpotong = false;
        $berhenti = false;

        for ($n = 1; $n <= $jumlahNota; $n++) {
            if (count($baris) >= self::MAKS_BARIS) {
                // Baris ke-n TIDAK dibuat karena batas pengaman. Tandai
                // supaya admin tahu ada nota yang belum tercatat.
                $terpotong = true;
                $berhenti = true;

                break;
            }

            $baris[] = array_merge([
                'bukti' => [$path],
                // Penanda asal - dipakai untuk MEMBEDAKAN baris mana milik
                // berkas mana.
                'sumber' => $path,
                'berkas_ke' => $nomorBerkas,
                'berkas_dari' => $totalBerkas,
                'nota_ke' => $n,
                'nota_dari' => $jumlahNota,
                'mode' => 'rinci',
                // Potongan khusus untuk baris ini (kalau OCR berhasil).
                'potongan' => $potongan[$n - 1] ?? null,
                'tanggal' => now()->toDateString(),
            ],
                // 1) DRAF dari OCR - hanya field yang berhasil dibaca.
                self::isianOcr($petaIsi[$path][$n - 1] ?? []),
                // 2) Isian admin yang SUDAH ADA menang atas draf OCR.
                self::isianAdmin($petaIsian[$path][$n] ?? []));
        }

        return ['baris' => $baris, 'terpotong' => $terpotong, 'berhenti' => $berhenti];
    }
}
