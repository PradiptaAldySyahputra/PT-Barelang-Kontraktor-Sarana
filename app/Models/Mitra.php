<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\KategoriMitra;
use Database\Factories\MitraFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model `mitra` — pihak terkait (PLN, pelanggan, vendor, subkon).
 *
 * @property int $id
 * @property string $nama
 * @property KategoriMitra $kategori
 * @property string|null $kontak
 * @property string|null $alamat
 * @property bool $is_aktif
 */
class Mitra extends Model
{
    /** @use HasFactory<MitraFactory> */
    use HasFactory;

    protected $table = 'mitra';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'kategori',
        'kontak',
        'alamat',
        'is_aktif',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'kategori' => KategoriMitra::class,
            'is_aktif' => 'boolean',
        ];
    }

    // ---------------------------------------------------------
    // Relasi
    // ---------------------------------------------------------

    /**
     * SPK yang diberikan oleh mitra ini (sebagai pemberi kerja).
     *
     * @return HasMany<Spk, $this>
     */
    public function spk(): HasMany
    {
        return $this->hasMany(Spk::class, 'mitra_id');
    }

    /**
     * Uang masuk yang berasal dari mitra ini.
     *
     * @return HasMany<UangMasuk, $this>
     */
    public function uangMasuk(): HasMany
    {
        return $this->hasMany(UangMasuk::class, 'mitra_id');
    }

    // ---------------------------------------------------------
    // Scope
    // ---------------------------------------------------------

    /**
     * @param  Builder<Mitra>  $query
     */
    public function scopeAktif(Builder $query): void
    {
        $query->where('is_aktif', true);
    }

    /**
     * @param  Builder<Mitra>  $query
     */
    public function scopePemberiKerja(Builder $query): void
    {
        $query->whereIn('kategori', [
            KategoriMitra::Pln->value,
            KategoriMitra::Pelanggan->value,
        ]);
    }
}
