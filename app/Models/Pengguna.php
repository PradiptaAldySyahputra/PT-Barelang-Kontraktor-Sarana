<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Peran;
use App\Support\Nota;
use Database\Factories\PenggunaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * Model `pengguna` - akun pengguna sistem.
 *
 * Menggantikan model `User` bawaan Laravel, karena sistem ini memakai
 * tabel `pengguna` sesuai skema domain BKS.
 *
 * @property int $id
 * @property string $nama
 * @property string $email
 * @property string $password
 * @property Peran $peran
 * @property bool $is_aktif
 * @property string|null $avatar
 * @property string|null $tanda_tangan
 * @property Carbon|null $terakhir_masuk
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
        'avatar',
        'tanda_tangan',
        'terakhir_masuk',
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
            'terakhir_masuk' => 'datetime',
        ];
    }

    // Helper peran

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

    /**
     * URL avatar (disk privat `nota` atau path template public). Null kalau belum ada.
     */
    public function urlAvatar(): ?string
    {
        if (blank($this->avatar)) {
            return null;
        }

        // Jika merujuk ke avatar bawaan template di public/images/user/
        if (str_starts_with($this->avatar, 'images/') || str_starts_with($this->avatar, '/images/')) {
            return '/'.ltrim($this->avatar, '/');
        }

        return Nota::ada($this->avatar)
            ? Nota::url($this->avatar)
            : null;
    }

    /**
     * URL tanda tangan (disk privat `nota`). Null kalau belum diunggah.
     */
    public function urlTandaTangan(): ?string
    {
        return Nota::ada($this->tanda_tangan)
            ? Nota::url($this->tanda_tangan)
            : null;
    }

    /**
     * Apakah pengguna ini sudah punya tanda tangan untuk PDF?
     */
    public function punyaTandaTangan(): bool
    {
        return Nota::ada($this->tanda_tangan);
    }

    // Relasi

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
