<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\AkunKas;
use App\Enums\KategoriMitra;
use App\Enums\KategoriPengeluaran;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Database\Seeder;
use OpenSpout\Reader\XLSX\Reader;

/**
 * Seeder DATA REAL dari Excel perusahaan (folder docs/file bks/).
 *
 * Sumber:
 *   - LIST SPK 2026.xlsx  → tabel `spk`
 *   - BKS - Format Kas & Bank 2026 (AGUSTUS).xlsx → tabel `uang_masuk` & `uang_keluar`
 *
 * Catatan:
 *   - Sel rumus (`=486000000*95%`, `=78000+35000`) dievaluasi sederhana.
 *   - Nomor SPK ganda (satu nomor terbagi 95%/5%) digabung nilainya.
 *   - Baris tanpa nomor SPK ("TANPA SPK") diberi nomor otomatis.
 *   - Diperuntukkan pengembangan/testing; data bisa dijalankan berulang
 *     (SPK memakai updateOrCreate, transaksi ditambah tiap jalan).
 */
class DataRealSeeder extends Seeder
{
    private const BASE = 'docs/file bks';

    public function run(): void
    {
        $pln = Mitra::firstOrCreate(
            ['nama' => 'PT PLN Batam'],
            ['kategori' => KategoriMitra::Mitra->value, 'is_aktif' => true]
        );

        $admin = Pengguna::where('email', 'admin@bks.test')->first();
        $admin ??= Pengguna::factory()->admin()->create([
            'nama' => 'Admin BKS',
            'email' => 'admin@bks.test',
            'password' => (string) \Illuminate\Support\Str::password(12),
        ]);

        $this->seedSpk($pln, $admin);
        $this->seedKasBank();

        $this->command->info('✓ Data real BKS: SPK + uang masuk/keluar (kas & bank)');
    }

    /**
     * Impor daftar SPK dari semua sheet LIST SPK 2026.xlsx.
     */
    private function seedSpk(Mitra $pln, Pengguna $admin): void
    {
        $path = base_path(self::BASE.'/LIST SPK 2026.xlsx');
        $reader = new Reader();
        $reader->open($path);

        // Kunci = nomor SPK; SPK tanpa nomor disatukan per baris.
        $map = [];

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $r = $row->toArray();

                $tgl = $this->tanggal($r[0] ?? null);
                $no = strtolower(trim((string) ($r[1] ?? '')));
                $nama = trim((string) ($r[2] ?? ''));
                $lokasi = trim((string) ($r[3] ?? ''));
                $nilai = $this->angka($r[4] ?? null);
                $ket = trim((string) ($r[5] ?? ''));

                // Lewati baris header / penanda bagian / kosong.
                if (str_contains($nama, 'Tanggal SPK') || str_contains($nama, 'TAGIHAN')) {
                    continue;
                }
                if ($nama === '' && $lokasi === '' && $nilai === null && $no === '') {
                    continue;
                }

                $key = $no !== '' ? $no : 'NONE_'.count($map);

                if (! isset($map[$key])) {
                    $map[$key] = [
                        'tgl' => $tgl,
                        'no' => $no,
                        'nama' => $nama !== '' ? $nama : 'Tanpa Nama Pekerjaan',
                        'lokasi' => $lokasi !== '' ? $lokasi : null,
                        'ket' => $ket,
                        'nilai' => 0.0,
                    ];
                }

                $map[$key]['nilai'] += $nilai ?? 0.0;
            }
        }

        $reader->close();

        $i = 0;
        foreach ($map as $row) {
            $nomor = $row['no'] !== '' ? $row['no'] : 'TANPA-SPK-'.(++$i);

            Spk::updateOrCreate(
                ['nomor_spk' => $nomor],
                [
                    'tanggal_spk' => $row['tgl'],
                    'tanggal_akhir' => null,
                    'nama_pekerjaan' => $row['nama'],
                    'lokasi' => $row['lokasi'],
                    'nilai_spk' => $row['nilai'],
                    'mitra_id' => $pln->id,
                    'status_spk' => StatusSpk::Berjalan->value,
                    'status_tagihan' => StatusTagihan::BelumDitagihkan->value,
                    'dibuat_oleh' => $admin->id,
                ]
            );
        }

        $this->command->info('  SPK diimpor: '.count($map));
    }

    /**
     * Impor transaksi KAS & BANK ke uang_masuk/uang_keluar.
     */
    private function seedKasBank(): void
    {
        $path = base_path(self::BASE.'/BKS - Format Kas & Bank 2026 (AGUSTUS).xlsx');
        $reader = new Reader();
        $reader->open($path);

        $masuk = 0;
        $keluar = 0;

        foreach ($reader->getSheetIterator() as $sheet) {
            $name = strtolower(trim((string) $sheet->getName()));
            $isKas = str_contains($name, 'kas');
            $isBank = str_contains($name, 'bank');

            if (! $isKas && ! $isBank) {
                continue;
            }

            foreach ($sheet->getRowIterator() as $row) {
                $r = $row->toArray();

                $tgl = $this->tanggal($r[1] ?? null);
                $ket = trim((string) ($r[4] ?? ''));

                if ($tgl === null || $ket === '' || $ket === 'KETERANGAN'
                    || str_contains($ket, 'T O T A L')) {
                    continue;
                }

                $akun = $isKas ? AkunKas::Kas->value : AkunKas::Bank->value;
                $masukNominal = $this->angka($r[5] ?? null);
                $keluarNominal = $this->angka($r[6] ?? null);

                if ($masukNominal !== null && $masukNominal > 0) {
                    UangMasuk::create([
                        'tanggal' => $tgl,
                        'akun' => $akun,
                        'jumlah' => $masukNominal,
                        'keterangan' => $ket,
                    ]);
                    $masuk++;
                }

                if ($keluarNominal !== null && $keluarNominal > 0) {
                    UangKeluar::create([
                        'tanggal' => $tgl,
                        'akun' => $akun,
                        'jumlah' => $keluarNominal,
                        'kategori' => $this->kategori($ket),
                        'keterangan' => $ket,
                    ]);
                    $keluar++;
                }
            }
        }

        $reader->close();

        $this->command->info('  Uang masuk : '.$masuk);
        $this->command->info('  Uang keluar: '.$keluar);
    }

    /**
     * Ubah sel ke angka; evaluasi aritmetika sederhana pada sel rumus.
     */
    private function angka(mixed $v): ?float
    {
        if ($v instanceof \DateTimeInterface) {
            return null;
        }
        if (is_numeric($v)) {
            return (float) $v;
        }

        $s = trim((string) $v);
        if ($s === '' || $s === '=' || str_contains($s, 'SUM') || str_contains($s, 'TOTAL')) {
            return null;
        }
        if (str_starts_with($s, '=')) {
            $s = substr($s, 1);
        }
        if (! preg_match('/^[0-9+\-*\/%.(). ]+$/', $s)) {
            return null;
        }

        $expr = preg_replace('/(\d+)%/', '($1/100)', $s);
        if ($expr === null) {
            return null;
        }

        try {
            $result = eval('return '.$expr.';');
        } catch (\Throwable) {
            return null;
        }

        return is_numeric($result) ? (float) $result : null;
    }

    /**
     * Ubah sel tanggal (DateTimeImmutable atau string d/m/y) ke Y-m-d.
     */
    private function tanggal(mixed $v): ?string
    {
        if ($v instanceof \DateTimeInterface) {
            return $v->format('Y-m-d');
        }

        $s = trim((string) $v);
        if ($s === '') {
            return null;
        }

        foreach (['d/m/y', 'd/m/Y'] as $fmt) {
            $d = \DateTime::createFromFormat($fmt, $s);
            if ($d instanceof \DateTime) {
                return $d->format('Y-m-d');
            }
        }

        return null;
    }

    /**
     * Petakan keterangan ke KategoriPengeluaran.
     */
    private function kategori(string $ket): string
    {
        $k = strtolower($ket);

        if (str_contains($k, 'bensin') || str_contains($k, 'sewa crane')) {
            return KategoriPengeluaran::Transportasi->value;
        }
        if (str_contains($k, 'gaji')) {
            return KategoriPengeluaran::Gaji->value;
        }
        if (str_contains($k, 'nota')) {
            return KategoriPengeluaran::Nota->value;
        }
        if (str_contains($k, 'material') || str_contains($k, 'mcb')
            || str_contains($k, 'atk') || str_contains($k, 'hvs')
            || str_contains($k, 'stiker') || str_contains($k, 'tinta')
            || str_contains($k, 'materai') || str_contains($k, 'meterai')) {
            return KategoriPengeluaran::Material->value;
        }
        if (str_contains($k, 'operasional') || str_contains($k, 'listrik')
            || str_contains($k, 'internet') || str_contains($k, 'bpjs')
            || str_contains($k, 'pajak') || str_contains($k, 'sewa')
            || str_contains($k, 'makan') || str_contains($k, 'telpon')) {
            return KategoriPengeluaran::Operasional->value;
        }

        return KategoriPengeluaran::Lainnya->value;
    }
}
