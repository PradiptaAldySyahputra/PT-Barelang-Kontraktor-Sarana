<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DikerjakanOleh;
use App\Enums\StatusAntar;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use Database\Factories\SpkFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Model `spk` — ENTITAS INTI sistem.
 *
 * Menyimpan semua SPK, baik dari PLN/pelanggan maupun SPK subkon/vendor.
 * Tidak ada entitas PROYEK (keputusan user).
 *
 * @property int $id
 * @property string $nomor_spk
 * @property Carbon|null $tanggal_spk
 * @property Carbon|null $tanggal_akhir
 * @property string $nama_pekerjaan
 * @property string|null $lokasi
 * @property string $nilai_spk
 * @property string|null $jenis_sumber
 * @property string|null $sheet_lama
 * @property int|null $mitra_id
 * @property StatusSpk|null $status_spk
 * @property StatusTagihan|null $status_tagihan
 * @property DikerjakanOleh $dikerjakan_oleh
 * @property int|null $subkon_id
 * @property int $dibuat_oleh
 */
class Spk extends Model
{
    /** @use HasFactory<SpkFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $table = 'spk';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nomor_spk',
        'tanggal_spk',
        'tanggal_akhir',
        'perpanjangan',
        'nama_pekerjaan',
        'lokasi',
        'keterangan',
        'dokumen',
        'nilai_spk',
        'jenis_sumber',
        'sheet_lama',
        'mitra_id',
        'status_spk',
        'status_tagihan',
        'status_antar',
        'tanggal_antar',
        'dikerjakan_oleh',
        'subkon_id',
        'dibuat_oleh',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_spk' => 'date',
            'tanggal_akhir' => 'date',
            'tanggal_antar' => 'date',
            'nilai_spk' => 'decimal:2',
            'status_spk' => StatusSpk::class,
            'status_tagihan' => StatusTagihan::class,
            'status_antar' => StatusAntar::class,
            'dikerjakan_oleh' => DikerjakanOleh::class,
            // Riwayat perpanjangan tenggat (adendum) — lihat §perpanjangan.
            'perpanjangan' => 'array',
            // Berkas SPK (BAST, scan SPK) — banyak berkas per SPK.
            'dokumen' => 'array',
        ];
    }

    // ---------------------------------------------------------
    // Relasi
    // ---------------------------------------------------------

    /**
     * @return BelongsTo<Pengguna, $this>
     */
    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'dibuat_oleh');
    }

    /**
     * @return BelongsTo<Mitra, $this>
     */
    public function mitra(): BelongsTo
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    /**
     * Mitra subkon — hanya terisi jika `dikerjakan_oleh = subkon`.
     *
     * @return BelongsTo<Mitra, $this>
     */
    public function subkon(): BelongsTo
    {
        return $this->belongsTo(Mitra::class, 'subkon_id');
    }

    /**
     * Apakah SPK ini disubkonkan ke pihak lain?
     *
     * ⚠️ Dinamai `isDisubkonkan()` (bukan `disubkonkan()`) karena nama itu
     * BENTROK dengan `scopeDisubkonkan()` — PHP akan menolak panggilan
     * statis `Spk::disubkonkan()`. Pola yang sama pernah terjadi pada
     * `dariSpk()` vs `scopeDariSpk()`.
     */
    public function isDisubkonkan(): bool
    {
        return $this->dikerjakan_oleh === DikerjakanOleh::Subkon;
    }

    /**
     * @return HasMany<UangMasuk, $this>
     */
    public function uangMasuk(): HasMany
    {
        return $this->hasMany(UangMasuk::class, 'spk_id');
    }

    /**
     * @return HasMany<UangKeluar, $this>
     */
    public function uangKeluar(): HasMany
    {
        return $this->hasMany(UangKeluar::class, 'spk_id');
    }

    // ---------------------------------------------------------
    // Kolom turunan (dihitung, tidak disimpan)
    // Lihat Schema.md §6
    // ---------------------------------------------------------

    /**
     * Total penerimaan untuk SPK ini.
     */
    public function totalPenerimaan(): float
    {
        return (float) $this->uangMasuk()->sum('jumlah');
    }

    // ---------------------------------------------------------
    // SISA & PIUTANG (SEDERHANA)
    // ---------------------------------------------------------
    //
    // ⚠️ KEPUTUSAN USER (19 Sep 2026):
    // Retensi, laba/rugi, dan aging piutang DIHAPUS. Sistem murni mencatat
    // data yang diinput — tanpa perhitungan pajak/biaya/laba yang tidak
    // dipakai perusahaan.
    //
    // Karena itu `totalBiaya()` dan `labaRugi()` IKUT DIHAPUS: keduanya
    // tidak pernah dipakai di antarmuka, hanya tertinggal di test & seeder.
    //
    // Yang tersisa hanya dua angka yang benar-benar dipakai monitoring:
    //   piutang = nilai_spk − sudah_diterima
    //   sisa    = sama, tapi tidak pernah negatif (untuk tampilan)

    /**
     * Piutang: sisa nilai SPK yang belum diterima.
     *
     * Bisa negatif kalau penerimaan melebihi nilai SPK — itu tanda ada
     * kelebihan input yang perlu diperiksa.
     */
    public function piutang(): float
    {
        return (float) $this->nilai_spk - $this->totalPenerimaan();
    }

    /**
     * Piutang dari angka penerimaan yang SUDAH diketahui.
     *
     * Dipakai di laporan/widget yang memakai `withSum` agar tidak N+1.
     */
    public function piutangDari(float $penerimaan): float
    {
        return (float) $this->nilai_spk - $penerimaan;
    }

    /**
     * Sisa yang belum diterima, tidak pernah negatif (untuk tampilan).
     */
    public function sisaTagih(): float
    {
        return max(0.0, $this->piutang());
    }

    /**
     * Apakah SPK ini sudah lunas (tidak ada sisa)?
     */
    public function sudahLunas(): bool
    {
        return $this->piutang() <= 0;
    }

    // ---------------------------------------------------------
    // TENGGAT (tanggal_akhir) & PERPANJANGAN
    // ---------------------------------------------------------

    /**
     * Tenggat EFEKTIF — tanggal_akhir terbaru setelah semua perpanjangan.
     *
     * ⚠️ KENAPA INI ADA (permintaan pengguna 26 Sep 2026):
     * "perpanjangan tenggat SPK tidak bergantung tenggat waktu awal, bisa
     *  diperpanjang sesuai kesepakatan (berapa bulan / perjanjian)"
     *
     * Karena `catatPerpanjangan()` SELALU memperbarui `tanggal_akhir`, maka
     * nilai itu sendiri sudah menjadi tenggat efektif. Method ini disediakan
     * supaya maksudnya jelas di kode pemanggil (tidak perlu tahu detailnya).
     */
    public function tenggatEfektif(): ?Carbon
    {
        return $this->tanggal_akhir;
    }

    /**
     * Berapa kali SPK ini diperpanjang.
     */
    public function jumlahPerpanjangan(): int
    {
        return count($this->perpanjangan ?? []);
    }

    /**
     * Apakah SPK ini pernah diperpanjang?
     */
    public function pernahDiperpanjang(): bool
    {
        return $this->jumlahPerpanjangan() > 0;
    }

    /**
     * Catat perpanjangan tenggat (adendum).
     *
     * ⚠️ JEJAK TENGGAT AWAL TIDAK HILANG: tanggal lama disimpan di riwayat
     * JSON sebelum `tanggal_akhir` diperbarui. Ini penting karena pengguna
     * memakai Excel yang mencatat perjanjian perpanjangan, dan perlu tahu
     * berapa kali & sejak kapan SPK diperpanjang.
     *
     * @param  string  $tanggalBaru  format Y-m-d
     * @param  string|null  $alasan  mis. "kesepakatan adendum"
     */
    public function catatPerpanjangan(string $tanggalBaru, ?string $alasan = null): void
    {
        $riwayat = $this->perpanjangan ?? [];

        $riwayat[] = [
            'dari' => $this->tanggal_akhir?->toDateString(),
            'ke' => $tanggalBaru,
            'alasan' => $alasan,
            'dicatat' => now()->toDateString(),
        ];

        $this->perpanjangan = $riwayat;
        $this->tanggal_akhir = $tanggalBaru;
        $this->save();
    }

    /**
     * Berapa berkas dokumen yang tersimpan untuk SPK ini.
     *
     * Dipakai tabel supaya admin langsung tahu mana SPK yang dokumennya
     * belum diunggah (0 berkas) — kebutuhan dari PRD FR-SPK-007.
     */
    public function jumlahDokumen(): int
    {
        return count($this->dokumen ?? []);
    }

    /**
     * Sisa hari sampai tenggat. Negatif = sudah lewat.
     *
     * Memakai `tanggal_akhir` yang sudah mencerminkan perpanjangan terbaru,
     * jadi alarm tenggat otomatis mengikuti tanggal hasil perpanjangan.
     */
    public function sisaTenggatHari(): ?int
    {
        if ($this->tanggal_akhir === null) {
            return null;
        }

        return (int) now()->startOfDay()->diffInDays($this->tanggal_akhir->startOfDay(), absolute: false);
    }

    /**
     * Apakah sudah melewati tenggat.
     */
    public function sudahLewatTenggat(): bool
    {
        $sisa = $this->sisaTenggatHari();

        return $sisa !== null && $sisa < 0;
    }

    /**
     * Mendekati tenggat (≤ 14 hari lagi, belum lewat).
     */
    public function isMendekatiTenggat(int $hari = 14): bool
    {
        $sisa = $this->sisaTenggatHari();

        return $sisa !== null && $sisa >= 0 && $sisa <= $hari;
    }

    /**
     * Label tenggat untuk ditampilkan di tabel.
     */
    public function labelTenggat(): ?string
    {
        $sisa = $this->sisaTenggatHari();

        if ($sisa === null) {
            return null;
        }

        if ($sisa < 0) {
            return 'Lewat '.abs($sisa).' hari';
        }

        if ($sisa === 0) {
            return 'Hari ini';
        }

        return $sisa.' hari lagi';
    }

    // ---------------------------------------------------------
    // Scope
    // ---------------------------------------------------------

    /**
     * @param  Builder<Spk>  $query
     */
    public function scopeBerjalan(Builder $query): void
    {
        $query->whereIn('status_spk', [
            StatusSpk::Terbit->value,
            StatusSpk::Berjalan->value,
        ]);
    }

    /**
     * @param  Builder<Spk>  $query
     */
    public function scopeBelumLunas(Builder $query): void
    {
        // ⚠️ `status_tagihan` boleh NULL. Di SQL, `NULL != 'dibayar'` bernilai
        // UNKNOWN (bukan true), sehingga tanpa `orWhereNull` SPK yang statusnya
        // belum diisi HILANG dari daftar "Belum Lunas" — padahal justru itu yang
        // perlu ditindaklanjuti. Perlakukan NULL sebagai "belum lunas".
        $query->where(function (Builder $q): void {
            $q->where('status_tagihan', '!=', StatusTagihan::Dibayar->value)
                ->orWhereNull('status_tagihan');
        });
    }

    /**
     * @param  Builder<Spk>  $query
     */
    public function scopeTanpaSpk(Builder $query): void
    {
        $query->whereNull('tanggal_spk');
    }

    /**
     * SPK yang sudah melewati tenggat (tanggal_akhir < hari ini).
     *
     * @param  Builder<Spk>  $query
     */
    public function scopeLewatTenggat(Builder $query): void
    {
        // ⚠️ Hanya SPK yang MASIH BERJALAN. Tanpa syarat ini, SPK lama yang
        // sudah selesai ikut terhitung "lewat tenggat" dan memunculkan alarm
        // palsu (pernah terjadi: 67 dari 90 SPK asli dianggap lewat tenggat).
        //
        // ⚠️ `status_spk` boleh NULL. `whereNotIn` MENYARING HABIS baris NULL
        // (karena `NULL NOT IN (...)` = UNKNOWN), sehingga SPK berstatus belum
        // diisi justru lolos dari pemantauan tenggat. NULL diperlakukan sebagai
        // "belum selesai" lewat `orWhereNull`.
        $query->whereNotNull('tanggal_akhir')
            ->whereDate('tanggal_akhir', '<', now()->toDateString())
            ->where(function (Builder $q): void {
                $q->whereNotIn('status_spk', [
                    StatusSpk::Selesai->value,
                    StatusSpk::SudahDitagihkan->value,
                    StatusSpk::Dibatalkan->value,
                ])->orWhereNull('status_spk');
            });
    }

    /**
     * SPK yang mendekati tenggat (≤ $hari hari lagi, belum lewat).
     *
     * @param  Builder<Spk>  $query
     */
    public function scopeMendekatiTenggat(Builder $query, int $hari = 14): void
    {
        $query->whereNotNull('tanggal_akhir')
            ->whereDate('tanggal_akhir', '>=', now()->toDateString())
            ->whereDate('tanggal_akhir', '<=', now()->addDays($hari)->toDateString())
            ->where(function (Builder $q): void {
                $q->whereNotIn('status_spk', [
                    StatusSpk::Selesai->value,
                    StatusSpk::SudahDitagihkan->value,
                    StatusSpk::Dibatalkan->value,
                ])->orWhereNull('status_spk');
            });
    }

    /**
     * Apakah SPK ini sudah selesai / tidak perlu dipantau lagi?
     */
    public function sudahSelesai(): bool
    {
        return in_array($this->status_spk, [
            StatusSpk::Selesai,
            StatusSpk::SudahDitagihkan,
            StatusSpk::Dibatalkan,
        ], true);
    }

    /**
     * SPK yang disubkonkan ke pihak lain.
     *
     * @param  Builder<Spk>  $query
     */
    public function scopeDisubkonkan(Builder $query): void
    {
        $query->where('dikerjakan_oleh', DikerjakanOleh::Subkon->value);
    }

    /**
     * SPK yang dikerjakan sendiri.
     *
     * @param  Builder<Spk>  $query
     */
    public function scopeDikerjakanSendiri(Builder $query): void
    {
        $query->where('dikerjakan_oleh', DikerjakanOleh::Sendiri->value);
    }
}
