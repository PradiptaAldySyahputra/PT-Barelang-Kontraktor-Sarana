<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\KategoriPengeluaran;
use App\Enums\StatusTagihan;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * DATA DUMMY TRANSAKSI — untuk menguji SELURUH bagian aplikasi.
 *
 * ⚠️ TUJUAN
 * Data SPK asli dari Excel hanya memuat daftar SPK — tidak ada uang masuk
 * maupun uang keluar. Akibatnya banyak bagian tidak bisa diuji:
 *   - Kartu dashboard "Sudah Diterima", "Uang Keluar", "Belum Diterima"
 *   - Grafik arus kas (kosong, hanya garis nol)
 *   - Laporan: arus uang, pengeluaran per kategori
 *   - Menu Tagihan Selesai SPK (tidak pernah terisi)
 *   - Peringatan biaya melebihi nilai SPK
 *
 * Seeder ini mengisi transaksi yang WAJAR terhadap nilai SPK, sehingga
 * semua bagian bisa dilihat dan diuji.
 *
 * ⚠️ ANGKA DIBUAT WAJAR, BUKAN ASAL
 * Setiap SPK diberi pola pembayaran & biaya yang realistis:
 *   - 40% SPK  : belum ada pembayaran      -> "Belum Ditagihkan"
 *   - 30% SPK  : dibayar sebagian (1–2 termin) -> "Menunggu Pembayaran"
 *   - 30% SPK  : dibayar lunas             -> "Dibayar" (pindah ke Tagihan Selesai)
 *
 * Biaya per SPK dijaga DI BAWAH nilai SPK supaya tidak memicu peringatan
 * "biaya melebihi nilai SPK" — peringatan itu hanya untuk salah ketik.
 *
 * Jalankan:  php artisan db:seed --class=DataDummyTransaksiSeeder
 */
class DataDummyTransaksiSeeder extends Seeder
{
    /** Benih acak tetap — supaya hasilnya sama tiap kali dijalankan. */
    private const BENIH = 20260920;

    /** Folder bukti (relatif terhadap disk `public`). */
    private const DIR_MASUK = 'uang_masuk';

    private const DIR_KELUAR = 'uang_keluar';

    public function run(): void
    {
        mt_srand(self::BENIH);

        $admin = Pengguna::where('peran', 'admin')->first() ?? Pengguna::first();

        if (! $admin) {
            $this->command?->warn('Tidak ada pengguna — jalankan seeder pengguna dulu.');

            return;
        }

        $spks = Spk::orderBy('id')->get();

        if ($spks->isEmpty()) {
            $this->command?->warn('Tidak ada SPK — jalankan DatabaseSeeder dulu.');

            return;
        }

        $this->bersihkanTransaksiLama();

        $pdf = $this->buatPdfContoh();
        $png = $this->buatPngContoh();

        $jumlahMasuk = 0;
        $jumlahKeluar = 0;

        foreach ($spks as $i => $spk) {
            [$masuk, $keluar] = $this->transaksiUntukSpk($spk, $i, $pdf, $png, $admin->id);

            $jumlahMasuk += $masuk;
            $jumlahKeluar += $keluar;
        }

        [$masukUmum, $keluarUmum] = $this->transaksiTanpaSpk($pdf, $png);

        $jumlahMasuk += $masukUmum;
        $jumlahKeluar += $keluarUmum;

        $this->command?->info(sprintf(
            'Data dummy: %d uang masuk, %d uang keluar (untuk %d SPK).',
            $jumlahMasuk,
            $jumlahKeluar,
            $spks->count(),
        ));
    }

    // =========================================================
    // TRANSAKSI PER SPK
    // =========================================================

    /**
     * @return array{int, int} jumlah uang masuk & keluar yang dibuat
     */
    private function transaksiUntukSpk(Spk $spk, int $urutan, string $pdf, string $png, int $adminId): array
    {
        $nilai = (float) $spk->nilai_spk;

        if ($nilai <= 0) {
            return [0, 0];
        }

        $tanggalSpk = $spk->tanggal_spk ?? now()->subMonths(6);
        $masuk = 0;
        $keluar = 0;

        // ---------------------------------------------------------
        // UANG MASUK — pola pembayaran
        // ---------------------------------------------------------
        $pola = $urutan % 10;

        $termin = match (true) {
            $pola < 4 => [],                          // belum dibayar
            $pola < 7 => [0.40, 0.25],                // dibayar sebagian
            default => [1.0],                         // lunas
        };

        foreach ($termin as $porsi) {
            $jumlah = round($nilai * $porsi, 2);
            $tanggal = $tanggalSpk->copy()->addDays(mt_rand(20, 120));

            if ($tanggal->isFuture()) {
                $tanggal = now()->subDays(mt_rand(1, 25));
            }

            UangMasuk::create([
                'spk_id' => $spk->id,
                'tanggal' => $tanggal->toDateString(),
                'jumlah' => $jumlah,
                'mitra_id' => $spk->mitra_id,
                'keterangan' => 'Pembayaran '.number_format($porsi * 100, 0).'% — '.$spk->nomor_spk,
                'bukti' => [$porsi >= 1.0 ? $pdf : $png],
            ]);

            $masuk++;
        }

        // ---------------------------------------------------------
        // UANG KELUAR — biaya pekerjaan
        //
        // SPK subkon: mayoritas dibayarkan ke subkon.
        // SPK sendiri: material + upah + transportasi.
        // Total selalu < nilai SPK.
        // ---------------------------------------------------------
        $komponen = $spk->isDisubkonkan()
            ? [
                [KategoriPengeluaran::Upah, 0.72, 'Pembayaran ke '.($spk->subkon?->nama ?? 'subkon')],
            ]
            : [
                [KategoriPengeluaran::Material, 0.38, 'Pembelian material'],
                [KategoriPengeluaran::Upah, 0.22, 'Upah tukang'],
                [KategoriPengeluaran::Transportasi, 0.05, 'Angkut material'],
            ];

        foreach ($komponen as [$kategori, $porsi, $ket]) {
            $tanggal = $tanggalSpk->copy()->addDays(mt_rand(5, 60));

            if ($tanggal->isFuture()) {
                $tanggal = now()->subDays(mt_rand(1, 20));
            }

            UangKeluar::create([
                'spk_id' => $spk->id,
                'tanggal' => $tanggal->toDateString(),
                'jumlah' => round($nilai * $porsi, 2),
                'kategori' => $kategori,
                'penerima' => $kategori === KategoriPengeluaran::Upah
                    ? ($spk->subkon?->nama ?? 'Mandor')
                    : 'Toko Material',
                'keterangan' => $ket.' — '.$spk->nomor_spk,
                'bukti' => [$png],
            ]);

            $keluar++;
        }

        // Sebagian SPK diberi status "Revisi Dokumen" supaya SEMUA nilai
        // status tagihan terwakili saat pengujian. Dipasang SETELAH uang
        // masuk dibuat, agar tidak ditimpa observer.
        if ($pola === 5) {
            $spk->update(['status_tagihan' => StatusTagihan::RevisiDokumen]);
        }

        return [$masuk, $keluar];
    }

    // =========================================================
    // TRANSAKSI TANPA SPK (biaya kantor & penerimaan lain)
    // =========================================================

    /**
     * @return array{int, int}
     */
    private function transaksiTanpaSpk(string $pdf, string $png): array
    {
        $mitra = Mitra::query()->where('kategori', 'mitra')->first();

        // Biaya kantor bulanan — tidak terkait SPK.
        $bulanIni = now()->startOfMonth();
        $biayaKantor = [
            [KategoriPengeluaran::Gaji, 18_500_000, 'Gaji staf kantor'],
            [KategoriPengeluaran::Operasional, 4_250_000, 'Listrik, air, internet'],
            [KategoriPengeluaran::Lainnya, 2_750_000, 'ATK & keperluan kantor'],
        ];

        foreach ($biayaKantor as $i => [$kategori, $jumlah, $ket]) {
            UangKeluar::create([
                'spk_id' => null,
                'tanggal' => $bulanIni->copy()->subMonths($i)->addDays(4)->toDateString(),
                'jumlah' => $jumlah,
                'kategori' => $kategori,
                'penerima' => $kategori === KategoriPengeluaran::Gaji ? 'Staf' : 'Vendor',
                'keterangan' => $ket,
                'bukti' => [$pdf],
            ]);
        }

        // Penerimaan di luar SPK — mis. jasa sewa alat.
        $penerimaanUmum = [
            [5_500_000, 'Sewa alat berat (di luar SPK)'],
            [1_750_000, 'Penjualan material sisa'],
        ];

        foreach ($penerimaanUmum as $i => [$jumlah, $ket]) {
            UangMasuk::create([
                'spk_id' => null,
                'tanggal' => now()->subDays(30 + $i * 45)->toDateString(),
                'jumlah' => $jumlah,
                'mitra_id' => $mitra?->id,
                'keterangan' => $ket,
                'bukti' => [$png],
            ]);
        }

        return [count($penerimaanUmum), count($biayaKantor)];
    }

    // =========================================================
    // FILE BUKTI CONTOH
    // =========================================================

    private function bersihkanTransaksiLama(): void
    {
        UangMasuk::withTrashed()->forceDelete();
        UangKeluar::withTrashed()->forceDelete();

        // File bukti lama ikut dibersihkan supaya tidak menumpuk.
        foreach ([self::DIR_MASUK, self::DIR_KELUAR] as $dir) {
            foreach (Storage::disk('public')->files($dir) as $file) {
                Storage::disk('public')->delete($file);
            }
        }
    }

    /**
     * PDF contoh yang benar-benar bisa dibuka (bukan file kosong).
     */
    private function buatPdfContoh(): string
    {
        $teks = 'NOTA PEMBAYARAN - Contoh untuk pengujian';
        $isi = "%PDF-1.4\n"
            ."1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n"
            ."2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n"
            ."3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 300 120]/Contents 4 0 R/Resources<</Font<</F1 5 0 R>>>>>>endobj\n"
            ."4 0 obj<</Length 78>>stream\nBT /F1 11 Tf 20 70 Td (".$teks.") Tj 0 -20 Td (PT Barelang Kontraktor Sarana) Tj ET\nendstream endobj\n"
            ."5 0 obj<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>endobj\n"
            ."trailer<</Root 1 0 R>>\n%%EOF";

        $path = self::DIR_MASUK.'/nota-contoh.pdf';
        Storage::disk('public')->put($path, $isi);

        return $path;
    }

    /**
     * Gambar contoh (JPEG) — meniru foto nota.
     */
    private function buatPngContoh(): string
    {
        if (! extension_loaded('gd')) {
            // Tanpa GD: pakai PDF saja sebagai bukti.
            return $this->buatPdfContoh();
        }

        $img = imagecreatetruecolor(420, 300);
        $putih = imagecolorallocate($img, 252, 252, 252);
        $hitam = imagecolorallocate($img, 24, 24, 27);
        $abu = imagecolorallocate($img, 161, 161, 170);

        imagefilledrectangle($img, 0, 0, 420, 300, $putih);
        imagerectangle($img, 8, 8, 411, 291, $abu);

        imagestring($img, 5, 24, 30, 'NOTA / KUITANSI', $hitam);
        imagestring($img, 3, 24, 70, 'Contoh bukti untuk pengujian', $abu);
        imagestring($img, 3, 24, 110, 'PT Barelang Kontraktor Sarana', $hitam);
        imageline($img, 24, 140, 395, 140, $abu);
        imagestring($img, 3, 24, 165, 'Status : LUNAS (dummy)', $hitam);
        imagestring($img, 2, 24, 250, 'Dokumen ini dibuat otomatis oleh seeder.', $abu);

        $path = self::DIR_KELUAR.'/nota-contoh.jpg';
        ob_start();
        imagejpeg($img, null, 88);
        $data = ob_get_clean();
        imagedestroy($img);

        Storage::disk('public')->put($path, $data);

        return $path;
    }
}
