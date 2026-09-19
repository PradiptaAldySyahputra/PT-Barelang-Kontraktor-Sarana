<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\StatusTagihan;
use App\Models\Spk;
use App\Models\UangMasuk;

/**
 * Sinkronisasi `status_tagihan` SPK dengan pembayaran yang sudah masuk.
 *
 * ⚠️ KENAPA INI PERLU:
 * Sebelumnya `status_tagihan` diisi MANUAL oleh Admin. Risikonya:
 * status tertulis "Dibayar" padahal uangnya belum masuk — laporan jadi bohong.
 *
 * ATURAN:
 *   - SPK lunas (piutang lancar = 0)  -> `Dibayar`
 *   - belum lunas & sudah ada bayaran -> `MenungguPembayaran`
 *   - belum ada bayaran sama sekali   -> dibiarkan apa adanya
 *     (Admin mungkin sudah menandai `SudahDitagihkan` atau `RevisiDokumen`,
 *      dan status itu TIDAK boleh ditimpa oleh sistem)
 *
 * Dipanggil dari event model UangMasuk (created/updated/deleted).
 */
class SinkronStatusTagihanObserver
{
    /**
     * Sinkronkan status SPK terkait sebuah transaksi uang masuk.
     *
     * @param  int|null  $spkId  ID SPK yang mungkin terpengaruh
     */
    public function sinkron(?int $spkId): void
    {
        if ($spkId === null) {
            return;
        }

        $spk = Spk::find($spkId);

        if (! $spk) {
            return;
        }

        $diterima = (float) $spk->uangMasuk()->sum('jumlah');
        $piutang = $spk->piutangDari($diterima);

        // Status yang DI-SET SISTEM (bukan diisi manual Admin).
        $statusSistem = [StatusTagihan::Dibayar, StatusTagihan::MenungguPembayaran];

        $statusBaru = match (true) {
            // Sudah tidak ada piutang lancar -> lunas
            $piutang <= 0.01 => StatusTagihan::Dibayar,

            // Ada piutang, tapi sudah ada pembayaran masuk
            $diterima > 0 => StatusTagihan::MenungguPembayaran,

            // Tidak ada pembayaran sama sekali:
            //  - kalau status sebelumnya di-set SISTEM (mis. pembayaran dihapus),
            //    kembalikan ke BelumDitagihkan
            //  - kalau status MANUAL (SudahDitagihkan / RevisiDokumen),
            //    jangan sentuh — itu penanda kerja Admin
            in_array($spk->status_tagihan, $statusSistem, true) => StatusTagihan::BelumDitagihkan,

            default => null,
        };

        if ($statusBaru === null || $spk->status_tagihan === $statusBaru) {
            return;
        }

        // Simpan tanpa memicu hitungRetensi ulang yang tidak perlu
        $spk->status_tagihan = $statusBaru;
        $spk->save();
    }

    /**
     * Dipanggil saat uang masuk DIBUAT.
     */
    public function created(UangMasuk $uangMasuk): void
    {
        $this->sinkron($uangMasuk->spk_id);
    }

    /**
     * Dipanggil saat uang masuk DIUBAH.
     *
     * Perlu menangani SPK lama juga — kalau `spk_id` dipindah dari SPK A ke B,
     * maka A juga harus dihitung ulang.
     */
    public function updated(UangMasuk $uangMasuk): void
    {
        $this->sinkron($uangMasuk->spk_id);
        $this->sinkron($uangMasuk->getOriginal('spk_id'));
    }

    /**
     * Dipanggil saat uang masuk DIHAPUS.
     */
    public function deleted(UangMasuk $uangMasuk): void
    {
        $this->sinkron($uangMasuk->spk_id);
    }

    /**
     * Dipanggil saat uang masuk DIKEMBALIKAN dari soft delete.
     */
    public function restored(UangMasuk $uangMasuk): void
    {
        $this->sinkron($uangMasuk->spk_id);
    }

    /**
     * Dipanggil saat uang masuk DIHAPUS PERMANEN.
     */
    public function forceDeleted(UangMasuk $uangMasuk): void
    {
        $this->sinkron($uangMasuk->spk_id);
    }
}
