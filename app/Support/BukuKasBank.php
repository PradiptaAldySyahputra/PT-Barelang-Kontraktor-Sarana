<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\AkunKas;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * BUKU KAS / BUKU BANK (B2-11) — format persis template atasan.
 *
 * ⚠️ KENAPA PERLU:
 * Laporan akhir perusahaan = sheet "KAS" & "BANK" dengan kolom:
 *   TANGGAL | REF | KETERANGAN | DEBET | KREDIT | SALDO
 * di mana SALDO berjalan (kumulatif). Sistem harus bisa menghasilkan format
 * ini LANGSUNG dari data, tanpa admin menyusun manual di Excel.
 *
 * ⚠️ DEBET = uang MASUK, KREDIT = uang KELUAR (sudut pandang buku kas).
 * SALDO berjalan = saldo awal + debet − kredit, per baris.
 *
 * ⚠️ TIDAK ADA TABEL BARU — dihitung on-the-fly (Rules §1).
 */
final class BukuKasBank
{
    /**
     * Susun buku untuk satu akun (kas/bank) pada rentang periode.
     *
     * @return array{
     *     akun: string,
     *     label: string,
     *     periode: string,
     *     saldo_awal: float,
     *     baris: Collection<int, array{tanggal: Carbon, ref: string, keterangan: string, debet: float, kredit: float, saldo: float}>,
     *     total_debet: float,
     *     total_kredit: float,
     *     saldo_akhir: float
     * }
     */
    public static function susun(AkunKas|string $akun, ?Carbon $awal = null, ?Carbon $akhir = null): array
    {
        $nilai = $akun instanceof AkunKas ? $akun->value : $akun;
        $enum = $akun instanceof AkunKas ? $akun : AkunKas::from($akun);

        // Saldo AWAL = posisi sebelum periode (semua transaksi sebelum $awal).
        $saldoAwal = $awal !== null
            ? SaldoKas::saldo($enum, $awal->copy()->subDay())
            : 0.0;

        // Kumpulkan transaksi masuk (debet) & keluar (kredit).
        $masuk = UangMasuk::query()
            ->where('akun', $nilai)
            ->when($awal, fn ($q) => $q->where('tanggal', '>=', $awal->toDateString()))
            ->when($akhir, fn ($q) => $q->where('tanggal', '<=', $akhir->toDateString()))
            ->get()
            ->map(fn (UangMasuk $r): array => [
                'tanggal' => $r->tanggal,
                'ref' => $r->nomor_spk ?: ('UM-'.$r->id),
                'keterangan' => $r->keterangan ?: ($r->nama_pekerjaan ?: 'Penerimaan'),
                'debet' => (float) $r->jumlah,
                'kredit' => 0.0,
            ]);

        $keluar = UangKeluar::query()
            ->where('akun', $nilai)
            ->when($awal, fn ($q) => $q->where('tanggal', '>=', $awal->toDateString()))
            ->when($akhir, fn ($q) => $q->where('tanggal', '<=', $akhir->toDateString()))
            ->get()
            ->map(fn (UangKeluar $r): array => [
                'tanggal' => $r->tanggal,
                'ref' => 'UK-'.$r->id,
                'keterangan' => $r->keterangan ?: ($r->penerima ?: 'Pengeluaran'),
                'debet' => 0.0,
                'kredit' => (float) $r->jumlah,
            ]);

        // Urutkan per tanggal, lalu hitung saldo berjalan.
        $baris = $masuk->concat($keluar)
            ->sortBy(fn (array $b): int => $b['tanggal']->getTimestamp())
            ->values()
            ->reduce(function (Collection $acc, array $b) use ($saldoAwal): Collection {
                $saldoSebelum = $acc->last()['saldo'] ?? $saldoAwal;
                $b['saldo'] = $saldoSebelum + $b['debet'] - $b['kredit'];
                $acc->push($b);

                return $acc;
            }, collect());

        return [
            'akun' => $nilai,
            'label' => $enum->label(),
            'periode' => self::labelPeriode($awal, $akhir),
            'saldo_awal' => $saldoAwal,
            'baris' => $baris,
            'total_debet' => (float) $baris->sum('debet'),
            'total_kredit' => (float) $baris->sum('kredit'),
            'saldo_akhir' => $baris->last()['saldo'] ?? $saldoAwal,
        ];
    }

    /**
     * Siapkan [header, baris] untuk ekspor (XLSX/CSV/PDF).
     *
     * @param  array<string, mixed>  $buku  hasil susun()
     * @return array{0: list<string>, 1: list<array<int, mixed>>}
     */
    public static function untukEkspor(array $buku): array
    {
        $header = ['Tanggal', 'Ref', 'Keterangan', 'Debet (Masuk)', 'Kredit (Keluar)', 'Saldo'];

        $baris = [];

        // Baris saldo awal.
        $baris[] = [
            $buku['periode'],
            '',
            'SALDO AWAL',
            null,
            null,
            $buku['saldo_awal'],
        ];

        foreach ($buku['baris'] as $b) {
            $baris[] = [
                $b['tanggal']->format('d/m/Y'),
                $b['ref'],
                $b['keterangan'],
                $b['debet'] ?: null,
                $b['kredit'] ?: null,
                $b['saldo'],
            ];
        }

        // Baris total.
        $baris[] = [
            '',
            '',
            'TOTAL',
            $buku['total_debet'],
            $buku['total_kredit'],
            $buku['saldo_akhir'],
        ];

        return [$header, $baris];
    }

    private static function labelPeriode(?Carbon $awal, ?Carbon $akhir): string
    {
        if ($awal === null && $akhir === null) {
            return 'Semua periode';
        }

        $dari = $awal?->format('d/m/Y') ?? 'awal';
        $sampai = $akhir?->format('d/m/Y') ?? 'sekarang';

        return $dari.' s.d. '.$sampai;
    }
}
