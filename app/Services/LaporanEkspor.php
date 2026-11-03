<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\AkunKas;
use App\Models\Spk;
use App\Support\BukuKasBank;
use App\Support\LaporanData;
use App\Support\TandaTangan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Entity\SheetView;
use OpenSpout\Writer\XLSX\Writer as XlsxWriter;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Service untuk memproses ekspor laporan keuangan (CSV, XLSX, PDF).
 *
 * Murni mandiri tanpa dependensi pada Filament.
 */
class LaporanEkspor
{
    public function ekspor(string $jenis, string $format = 'csv', int $periode = 12): StreamedResponse|HttpResponse
    {
        [$judul, $header, $baris] = $this->siapkanDataEkspor($jenis, $periode);

        $namaFile = str($judul)->slug().'-'.now()->format('Y-m-d');

        return match ($format) {
            'pdf' => $this->unduhPdf($judul, $header, $baris, $namaFile, $periode),
            'xlsx' => $this->unduhXlsx($judul, $header, $baris, $namaFile),
            default => $this->unduhCsv($judul, $header, $baris, $namaFile),
        };
    }

    /**
     * @return array{0: string, 1: array<int, string>, 2: array<int, mixed>}
     */
    public function siapkanDataEkspor(string $jenis, int $periode): array
    {
        $data = LaporanData::lengkap($periode);
        $awal = LaporanData::tanggalAwal($periode);
        $labelPeriode = $this->labelPeriode($periode);

        return match ($jenis) {
            'buku-kas', 'buku-bank' => (function () use ($jenis, $awal, $labelPeriode): array {
                $akun = $jenis === 'buku-bank' ? AkunKas::Bank : AkunKas::Kas;
                $buku = BukuKasBank::susun($akun, $awal, now());
                [$header, $baris] = BukuKasBank::untukEkspor($buku);

                return [
                    'Buku '.$akun->label().' ('.$labelPeriode.')',
                    $header,
                    $baris,
                ];
            })(),
            'masuk' => [
                'Laporan Uang Masuk per Bulan',
                ['Bulan', 'Jumlah Transaksi', 'Total Masuk', 'Total Keluar', 'Selisih'],
                $data['perBulan']->map(fn (array $r): array => [
                    $r['label'],
                    $r['jumlah_masuk'],
                    $r['masuk'],
                    $r['keluar'],
                    $r['selisih'],
                ])->all(),
            ],
            'keluar' => [
                'Laporan Uang Keluar per Kategori',
                ['Kategori', 'Jumlah Transaksi', 'Total'],
                $data['perKategori']->map(fn (array $r): array => [
                    $r['label'],
                    $r['jumlah_transaksi'],
                    $r['total'],
                ])->all(),
            ],
            'tenggat' => [
                'Laporan Tenggat SPK',
                ['Nomor SPK', 'Pekerjaan', 'Mitra', 'Tenggat', 'Sisa Hari', 'Keterangan', 'Nilai SPK'],
                $data['spkLewatTenggat']
                    ->map(fn (Spk $s): array => [
                        $s->nomor_spk,
                        $s->nama_pekerjaan,
                        $s->mitra?->nama ?? '-',
                        $s->tanggal_akhir?->format('d/m/Y') ?? '-',
                        $s->sisaTenggatHari() ?? '-',
                        'LEWAT TENGGAT',
                        (float) $s->nilai_spk,
                    ])
                    ->concat(
                        $data['spkMendekatiTenggat']->map(fn (Spk $s): array => [
                            $s->nomor_spk,
                            $s->nama_pekerjaan,
                            $s->mitra?->nama ?? '-',
                            $s->tanggal_akhir?->format('d/m/Y') ?? '-',
                            $s->sisaTenggatHari() ?? '-',
                            'MENDEKATI TENGGAT',
                            (float) $s->nilai_spk,
                        ])
                    )
                    ->all(),
            ],
            'piutang' => [
                'Laporan Piutang (SPK Belum Diterima Penuh)',
                ['Nomor SPK', 'Pekerjaan', 'Mitra', 'Nilai SPK', 'Sudah Diterima', 'Belum Diterima', 'Status Tagihan', 'Tenggat'],
                $data['daftarPiutang']->map(fn (Spk $s): array => [
                    $s->nomor_spk,
                    $s->nama_pekerjaan,
                    $s->mitra?->nama ?? '-',
                    (float) $s->nilai_spk,
                    $s->totalPenerimaan(),
                    $s->sisaTagih(),
                    $s->status_tagihan?->label() ?? 'Belum Ditagihkan',
                    $s->tanggal_akhir?->format('d/m/Y') ?? '-',
                ])->all(),
            ],
            default => [
                'Laporan Daftar SPK',
                ['Nomor SPK', 'Pekerjaan', 'Mitra', 'Tanggal', 'Nilai SPK', 'Sudah Diterima', 'Belum Diterima', 'Status SPK', 'Status Tagihan'],
                $data['daftarSpk']->map(fn (array $r): array => [
                    $r['nomor_spk'],
                    $r['pekerjaan'],
                    $r['mitra'] ?? '-',
                    $r['tanggal'] ?? 'TANPA SPK',
                    $r['nilai_spk'],
                    $r['diterima'],
                    $r['belum_diterima'],
                    $r['status_spk'],
                    $r['status_tagihan'],
                ])->all(),
            ],
        };
    }

    private function unduhPdf(string $judul, array $header, array $baris, string $namaFile, int $periode): HttpResponse
    {
        return Pdf::loadView('reports.pdf', [
            'judul' => $judul,
            'header' => $header,
            'baris' => $baris,
            'periode' => $this->labelPeriode($periode),
            'tandaTangan' => TandaTangan::untukPdf(),
        ])->setPaper('a4', 'landscape')->download($namaFile.'.pdf');
    }

    private function unduhXlsx(string $judul, array $header, array $baris, string $namaFile): StreamedResponse
    {
        $path = (string) tempnam(sys_get_temp_dir(), 'laporan').'.xlsx';

        $writer = new XlsxWriter;
        $writer->openToFile($path);

        $writer->getCurrentSheet()->setSheetView(
            (new SheetView)->setFreezeRow(7),
        );

        $kopStyle = (new Style)->setFontBold()->setFontSize(14);
        $subKopStyle = (new Style)->setFontItalic()->setFontSize(10);
        $judulStyle = (new Style)->setFontBold()->setFontSize(12);
        $headerStyle = (new Style)->setFontBold();
        $ttdStyle = (new Style)->setFontBold();

        $writer->addRow(Row::fromValues(['PT. BARELANG KONTRAKTOR SARANA'], $kopStyle));
        $writer->addRow(Row::fromValues(['Subkontraktor PT PLN Batam · Pulau Batam'], $subKopStyle));
        $writer->addRow(Row::fromValues([$judul], $judulStyle));
        $writer->addRow(Row::fromValues(['Dicetak: '.now()->translatedFormat('d F Y H:i').' WIB · Sistem Kontrol Keuangan']));
        $writer->addRow(Row::fromValues([]));
        $writer->addRow(Row::fromValues($header, $headerStyle));

        foreach ($baris as $r) {
            $writer->addRow(Row::fromValues(array_values((array) $r)));
        }

        $total = self::hitungBarisTotal($header, $baris);

        if ($total !== null) {
            $writer->addRow(Row::fromValues([]));
            $writer->addRow(Row::fromValues($total, $headerStyle));
        }

        // Tanda Tangan Resmi Format Perusahaan
        $writer->addRow(Row::fromValues([]));
        $writer->addRow(Row::fromValues([]));
        $writer->addRow(Row::fromValues(['Mengetahui,', '', '', '', 'Dibuat Oleh,'], $ttdStyle));
        $writer->addRow(Row::fromValues(['Direktur Utama', '', '', '', 'Admin Keuangan']));
        $writer->addRow(Row::fromValues([]));
        $writer->addRow(Row::fromValues([]));
        $writer->addRow(Row::fromValues(['( .................................... )', '', '', '', '( .................................... )']));

        $writer->close();

        return Response::streamDownload(function () use ($path): void {
            readfile($path);
            @unlink($path);
        }, $namaFile.'.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function unduhCsv(string $judul, array $header, array $baris, string $namaFile): StreamedResponse
    {
        return Response::streamDownload(function () use ($judul, $header, $baris): void {
            $out = fopen('php://output', 'w');

            // BOM UTF-8
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [self::amanCsv($judul)], ';');
            fputcsv($out, ['Dicetak: '.now()->format('d/m/Y H:i')], ';');
            fputcsv($out, [], ';');
            fputcsv($out, array_map(self::amanCsv(...), $header), ';');

            foreach ($baris as $r) {
                fputcsv($out, array_map(self::amanCsv(...), (array) $r), ';');
            }

            fclose($out);
        }, $namaFile.'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private static function amanCsv(mixed $nilai): mixed
    {
        if ($nilai === null || is_int($nilai) || is_float($nilai)) {
            return $nilai;
        }

        $teks = (string) $nilai;

        if ($teks === '') {
            return '';
        }

        if (in_array($teks[0], ['=', '+', '-', '@'], true)) {
            return "'".$teks;
        }

        return $teks;
    }

    private static function hitungBarisTotal(array $header, array $baris): ?array
    {
        if ($baris === []) {
            return null;
        }

        $kolom = count($header);
        $total = array_fill(0, $kolom, null);
        $adaAngka = false;

        for ($i = 0; $i < $kolom; $i++) {
            $semuaAngka = true;
            $jumlah = 0.0;
            $terisi = false;

            foreach ($baris as $r) {
                $nilai = array_values((array) $r)[$i] ?? null;

                if (is_int($nilai) || is_float($nilai)) {
                    $jumlah += (float) $nilai;
                    $terisi = true;

                    continue;
                }

                if ($nilai !== null && $nilai !== '' && $nilai !== '-') {
                    $semuaAngka = false;

                    break;
                }
            }

            if ($semuaAngka && $terisi) {
                $total[$i] = $jumlah;
                $adaAngka = true;
            }
        }

        if (! $adaAngka) {
            return null;
        }

        foreach ($total as $i => $nilai) {
            if ($nilai === null) {
                $total[$i] = 'TOTAL';

                break;
            }
        }

        return $total;
    }

    public function simpanBerkasXlsx(string $jenis, int $periode, string $tujuanPath): void
    {
        [$judul, $header, $baris] = $this->siapkanDataEkspor($jenis, $periode);

        $writer = new XlsxWriter;
        $writer->openToFile($tujuanPath);

        $sheetView = new SheetView;
        $sheetView->setFreezeRow(7);
        $writer->getCurrentSheet()->setSheetView($sheetView);

        $kopStyle = (new Style)->setFontBold()->setFontSize(14);
        $subKopStyle = (new Style)->setFontItalic()->setFontSize(10);
        $judulStyle = (new Style)->setFontBold()->setFontSize(12);
        $headerStyle = (new Style)->setFontBold();
        $ttdStyle = (new Style)->setFontBold();

        $writer->addRow(Row::fromValues(['PT. BARELANG KONTRAKTOR SARANA'], $kopStyle));
        $writer->addRow(Row::fromValues(['Subkontraktor PT PLN Batam · Pulau Batam'], $subKopStyle));
        $writer->addRow(Row::fromValues([$judul], $judulStyle));
        $writer->addRow(Row::fromValues(['Dicetak: '.now()->translatedFormat('d F Y H:i').' WIB · Sistem Kontrol Keuangan']));
        $writer->addRow(Row::fromValues([]));
        $writer->addRow(Row::fromValues($header, $headerStyle));

        foreach ($baris as $r) {
            $writer->addRow(Row::fromValues(array_values((array) $r)));
        }

        $total = self::hitungBarisTotal($header, $baris);

        if ($total !== null) {
            $writer->addRow(Row::fromValues([]));
            $writer->addRow(Row::fromValues($total, $headerStyle));
        }

        // Tanda Tangan Resmi Format Perusahaan
        $writer->addRow(Row::fromValues([]));
        $writer->addRow(Row::fromValues([]));
        $writer->addRow(Row::fromValues(['Mengetahui,', '', '', '', 'Dibuat Oleh,'], $ttdStyle));
        $writer->addRow(Row::fromValues(['Direktur Utama', '', '', '', 'Admin Keuangan']));
        $writer->addRow(Row::fromValues([]));
        $writer->addRow(Row::fromValues([]));
        $writer->addRow(Row::fromValues(['( .................................... )', '', '', '', '( .................................... )']));

        $writer->close();
    }

    public function bundelZip(int $periode = 12): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $label = str($this->labelPeriode($periode))->slug();
        $zipNama = 'bundel-laporan-bks-'.$label.'-'.now()->format('Y-m-d').'.zip';
        $tempDir = storage_path('app/temp-bundel-'.uniqid());
        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $berkas = [
            '01-Buku-Kas-Operasional.xlsx' => 'buku-kas',
            '02-Buku-Bank-Rekening-PLN.xlsx' => 'buku-bank',
            '03-Laporan-Piutang-SPK.xlsx' => 'piutang',
            '04-Laporan-Tenggat-SPK.xlsx' => 'tenggat',
            '05-Daftar-Seluruh-SPK.xlsx' => 'spk',
        ];

        $filesToDelete = [];
        $zipPath = $tempDir.DIRECTORY_SEPARATOR.$zipNama;
        $zip = new \ZipArchive;
        $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($berkas as $filename => $jenis) {
            $filePath = $tempDir.DIRECTORY_SEPARATOR.$filename;
            $this->simpanBerkasXlsx($jenis, $periode, $filePath);
            $zip->addFile($filePath, $filename);
            $filesToDelete[] = $filePath;
        }

        $zip->close();

        foreach ($filesToDelete as $f) {
            @unlink($f);
        }

        $response = response()->download($zipPath, $zipNama, [
            'Content-Type' => 'application/zip',
        ])->deleteFileAfterSend(true);

        // Bersihkan direktori penampung setelah berkas terkirim
        register_shutdown_function(static function () use ($tempDir): void {
            if (is_dir($tempDir)) {
                @rmdir($tempDir);
            }
        });

        return $response;
    }

    public function labelPeriode(int $periode): string
    {
        return match ($periode) {
            1 => 'Bulan Ini',
            3 => '3 Bulan Terakhir',
            12 => '1 Tahun Terakhir',
            default => 'Semua Data',
        };
    }
}
