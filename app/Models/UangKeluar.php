<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use Database\Factories\UangKeluarFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Model `uang_keluar` — pengeluaran dana.
 *
 * TIDAK ADA APPROVAL (keputusan user) — tidak ada field disetujui_oleh.
 * spk_id boleh NULL untuk pengeluaran umum.
 *
 * @property int $id
 * @property int|null $spk_id
 * @property Carbon $tanggal
 * @property string $jumlah
 * @property KategoriPengeluaran|null $kategori
 * @property string|null $penerima
 * @property string|null $keterangan
 * @property array<int, string>|null $bukti
 */
class UangKeluar extends Model
{
    /** @use HasFactory<UangKeluarFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $table = 'uang_keluar';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'spk_id',
        'tanggal',
        'akun',
        'jumlah',
        'kategori',
        'penerima',
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
            'kategori' => KategoriPengeluaran::class,
            'bukti' => 'array',
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

    // ---------------------------------------------------------
    // Helper
    // ---------------------------------------------------------

    /**
     * Apakah pengeluaran ini terkait SPK tertentu?
     *
     * CATATAN: nama method diawali `is` agar TIDAK bertabrakan dengan
     * scope `scopeTerkaitSpk`.
     */
    public function isTerkaitSpk(): bool
    {
        return $this->spk_id !== null;
    }

    public function labelKategori(): string
    {
        return $this->kategori?->label() ?? '—';
    }

    public function jumlahFileBukti(): int
    {
        return count($this->bukti ?? []);
    }

    // ---------------------------------------------------------
    // Scope
    // ---------------------------------------------------------

    /**
     * @param  Builder<UangKeluar>  $query
     */
    public function scopeTerkaitSpk(Builder $query): void
    {
        $query->whereNotNull('spk_id');
    }

    /**
     * @param  Builder<UangKeluar>  $query
     */
    public function scopeUmum(Builder $query): void
    {
        $query->whereNull('spk_id');
    }
}
