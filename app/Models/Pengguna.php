<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Peran;
use Database\Factories\PenggunaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model `pengguna` — akun pengguna sistem.
 *
 * Menggantikan model `User` bawaan Laravel, karena sistem ini memakai
 * tabel `pengguna` sesuai db.txt.
 *
 * @property int $id
 * @property string $nama
 * @property string $email
 * @property string $password
 * @property Peran $peran
 * @property bool $is_aktif
 */
class Pengguna extends Authenticatable
{
    /** @use HasFactory<PenggunaFactory> */
    use HasFactory;

    use Notifiable;

    protected $table = 'pengguna';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'peran',
        'is_aktif',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'peran' => Peran::class,
            'is_aktif' => 'boolean',
            'password' => 'hashed',
        ];
    }

    // ---------------------------------------------------------
    // Helper peran
    // ---------------------------------------------------------

    public function isAdmin(): bool
    {
        return $this->peran === Peran::Admin;
    }

    public function isDirektur(): bool
    {
        return $this->peran === Peran::Direktur;
    }

    /**
     * Boleh menginput/mengubah data?
     * Sesuai Rules.md §4: hanya Admin yang boleh input.
     */
    public function bolehInput(): bool
    {
        return $this->peran->bolehInput();
    }

    // ---------------------------------------------------------
    // Relasi
    // ---------------------------------------------------------

    /**
     * SPK yang dibuat oleh pengguna ini.
     *
     * @return HasMany<Spk, $this>
     */
    public function spkDibuat(): HasMany
    {
        return $this->hasMany(Spk::class, 'dibuat_oleh');
    }
}
