<?php

declare(strict_types=1);

namespace App\Models;

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
 * @property string|null $persen_retensi
 * @property string|null $nilai_retensi
 * @property string|null $jenis_sumber
 * @property string|null $sheet_lama
 * @property int|null $mitra_id
 * @property StatusSpk|null $status_spk
 * @property StatusTagihan|null $status_tagihan
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
        'nama_pekerjaan',
        'lokasi',
        'nilai_spk',
        'persen_retensi',
        'nilai_retensi',
        'jenis_sumber',
        'sheet_lama',
        'mitra_id',
        'status_spk',
        'status_tagihan',
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
            'nilai_spk' => 'decimal:2',
            'persen_retensi' => 'decimal:2',
            'nilai_retensi' => 'decimal:2',
            'status_spk' => StatusSpk::class,
            'status_tagihan' => StatusTagihan::class,
        ];
    }

    /**
     * Hitung ulang `nilai_retensi` SETIAP kali SPK disimpan.
     *
     * Ini menjamin `nilai_retensi = nilai_spk × persen_retensi / 100` selalu
     * konsisten, tidak peduli bagaimana record dibuat (form, seeder, factory).
     * Sesuai Rules.md §2 butir 2.
     */
    protected static function booted(): void
    {
        static::saving(function (Spk $spk): void {
            $spk->hitungRetensi();
        });
    }

    /**
     * Hitung nilai retensi dari nilai SPK & persen retensi.
     */
    public function hitungRetensi(): void
    {
        if ($this->persen_retensi === null || $this->nilai_spk === null) {
            $this->nilai_retensi = null;

            return;
        }

        $this->nilai_retensi = round(
            (float) $this->nilai_spk * (float) $this->persen_retensi / 100,
            2
        );
    }

    /**
     * Terapkan retensi (default 5%) untuk SPK subkon/vendor.
     */
    public function terapkanRetensi(float $persen = 5.00): static
    {
        $this->persen_retensi = $persen;
        $this->hitungRetensi();

        return $this;
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

    /**
     * Total biaya untuk SPK ini.
     */
    public function totalBiaya(): float
    {
        return (float) $this->uangKeluar()->sum('jumlah');
    }

    /**
     * Estimasi laba/rugi = penerimaan - biaya.
     */
    public function labaRugi(): float
    {
        return $this->totalPenerimaan() - $this->totalBiaya();
    }

    // ---------------------------------------------------------
    // RETENSI & PIUTANG
    // ---------------------------------------------------------
    //
    // KONSEP (penting — lihat Rules.md §2 dan docs/RETENSI.md):
    //
    // Retensi adalah bagian nilai SPK yang DITAHAN pemberi kerja sampai
    // masa pemeliharaan selesai. Karena itu retensi:
    //   - BUKAN piutang lancar (belum boleh ditagih)
    //   - ditampilkan TERPISAH agar tetap terlihat, bukan disembunyikan
    //
    //   nilai_tagih (boleh ditagih sekarang) = nilai_spk − retensi_ditahan
    //   piutang lancar                        = nilai_tagih − sudah_diterima
    //
    // Retensi dianggap DILEPAS ketika SPK berstatus tagihan `Dibayar`
    // (artinya pekerjaan selesai & masa pemeliharaan berjalan/selesai).
    // Setelah dilepas, nilai penuh kembali boleh ditagih.

    /**
     * Retensi yang masih ditahan.
     *
     * Mengembalikan 0 jika SPK sudah berstatus `Dibayar` (retensi dilepas).
     */
    public function retensiDitahan(): float
    {
        if ($this->status_tagihan === StatusTagihan::Dibayar) {
            return 0.0;
        }

        return (float) ($this->nilai_retensi ?? 0);
    }

    /**
     * Nilai SPK yang boleh ditagih sekarang (setelah dikurangi retensi ditahan).
     */
    public function nilaiTagih(): float
    {
        return (float) $this->nilai_spk - $this->retensiDitahan();
    }

    /**
     * Piutang lancar — versi yang menjalankan query sendiri.
     */
    public function piutang(): float
    {
        return $this->piutangDari($this->totalPenerimaan());
    }

    /**
     * Piutang lancar dari angka penerimaan yang SUDAH diketahui.
     *
     * Dipakai di laporan/widget yang memakai `withSum` agar tidak N+1.
     */
    public function piutangDari(float $penerimaan): float
    {
        return max(0.0, $this->nilaiTagih() - $penerimaan);
    }

    /**
     * Sisa hak penuh = nilai SPK − sudah diterima (termasuk retensi ditahan).
     *
     * Ini angka "kalau semua termasuk retensi akhirnya dibayar".
     */
    public function sisaHakPenuhDari(float $penerimaan): float
    {
        return max(0.0, (float) $this->nilai_spk - $penerimaan);
    }

    // ---------------------------------------------------------
    // UMUR PIUTANG (AGING)
    // ---------------------------------------------------------

    /**
     * Umur piutang dalam hari, dihitung dari tanggal SPK.
     */
    public function umurHari(): ?int
    {
        if ($this->tanggal_spk === null) {
            return null;
        }

        return (int) $this->tanggal_spk->diffInDays(now(), absolute: true);
    }

    /**
     * Kelompok umur piutang (aging bucket).
     *
     * @return '0-30'|'31-60'|'61-90'|'>90'|'tanpa-tanggal'
     */
    public function kategoriUmur(): string
    {
        $umur = $this->umurHari();

        return match (true) {
            $umur === null => 'tanpa-tanggal',
            $umur <= 30 => '0-30',
            $umur <= 60 => '31-60',
            $umur <= 90 => '61-90',
            default => '>90',
        };
    }

    // ---------------------------------------------------------
    // TENGGAT (tanggal_akhir)
    // ---------------------------------------------------------

    /**
     * Sisa hari sampai tenggat. Negatif = sudah lewat.
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
    public function mendekatiTenggat(int $hari = 14): bool
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

    /**
     * Nilai bersih setelah retensi (alias nilaiTagih untuk kompatibilitas).
     */
    public function nilaiBersih(): float
    {
        return $this->nilaiTagih();
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
        $query->where('status_tagihan', '!=', StatusTagihan::Dibayar->value);
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
        $query->whereNotNull('tanggal_akhir')
            ->whereDate('tanggal_akhir', '<', now()->toDateString());
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
            ->whereDate('tanggal_akhir', '<=', now()->addDays($hari)->toDateString());
    }

    /**
     * Piutang yang sudah menua lebih dari $hari hari (belum lunas).
     *
     * @param  Builder<Spk>  $query
     */
    public function scopePiutangMenua(Builder $query, int $hari = 90): void
    {
        $query->belumLunas()
            ->whereNotNull('tanggal_spk')
            ->whereDate('tanggal_spk', '<=', now()->subDays($hari)->toDateString());
    }
}
