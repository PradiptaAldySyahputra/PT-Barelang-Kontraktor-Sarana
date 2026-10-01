<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AkunKas;
use App\Observers\SinkronStatusTagihanObserver;
use Database\Factories\UangMasukFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Model `uang_masuk` — penerimaan dana.
 *
 * Sumber uang masuk DISIMPULKAN dari spk_id:
 *   - spk_id terisi -> dari SPK
 *   - spk_id NULL   -> dari luar SPK
 *
 * @property int $id
 * @property int|null $spk_id
 * @property string|null $nomor_spk
 * @property string|null $nama_pekerjaan
 * @property Carbon $tanggal
 * @property AkunKas|null $akun
 * @property string $jumlah
 * @property int|null $mitra_id
 * @property string|null $keterangan
 * @property array<int, string>|null $bukti
 */
#[ObservedBy(SinkronStatusTagihanObserver::class)]
class UangMasuk extends Model
{
    /** @use HasFactory<UangMasukFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $table = 'uang_masuk';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'spk_id',
        'nomor_spk',
        'nama_pekerjaan',
        'tanggal',
        'akun',
        'jumlah',
        'mitra_id',
        'keterangan',
        'bukti',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'jumlah' => 'decimal:2',
            'akun' => AkunKas::class,
            'bukti' => 'array', // JSON array, jumlah file bebas
        ];
    }

    // ---------------------------------------------------------
    // Relasi
    // ---------------------------------------------------------

    /**
     * @return BelongsTo<Spk, $this>
     */
    public function spk(): BelongsTo
    {
        return $this->belongsTo(Spk::class, 'spk_id');
    }

    /**
     * @return BelongsTo<Mitra, $this>
     */
    public function mitra(): BelongsTo
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    // ---------------------------------------------------------
    // Helper
    // ---------------------------------------------------------

    /**
     * Apakah uang masuk ini berasal dari SPK?
     *
     * CATATAN: nama method diawali `is` agar TIDAK bertabrakan dengan
     * scope `scopeDariSpk` — kalau namanya sama (`dariSpk`), PHP akan
     * menolak `UangMasuk::dariSpk()` dengan "Non-static method cannot be
     * called statically".
     */
    public function isDariSpk(): bool
    {
        return $this->spk_id !== null;
    }

    public function labelSumber(): string
    {
        return $this->isDariSpk() ? 'Dari SPK' : 'Luar SPK';
    }

    public function jumlahFileBukti(): int
    {
        return count($this->bukti ?? []);
    }

    // ---------------------------------------------------------
    // Scope
    // ---------------------------------------------------------

    /**
     * @param  Builder<UangMasuk>  $query
     */
    public function scopeDariSpk(Builder $query): void
    {
        $query->whereNotNull('spk_id');
    }

    /**
     * @param  Builder<UangMasuk>  $query
     */
    public function scopeDariLuarSpk(Builder $query): void
    {
        $query->whereNull('spk_id');
    }
}
