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

    /**
     * Piutang = nilai SPK - penerimaan yang sudah masuk.
     */
    public function piutang(): float
    {
        return (float) $this->nilai_spk - $this->totalPenerimaan();
    }

    /**
     * Nilai bersih setelah retensi.
     */
    public function nilaiBersih(): float
    {
        return (float) $this->nilai_spk - (float) ($this->nilai_retensi ?? 0);
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
}
