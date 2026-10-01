<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Peran;
use Database\Factories\PenggunaFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model `pengguna` — akun pengguna sistem.
 *
 * Menggantikan model `User` bawaan Laravel, karena sistem ini memakai
 * tabel `pengguna` sesuai skema awal.
 *
 * Mengimplementasikan HasName karena Filament mencari atribut `name`,
 * sedangkan tabel ini memakai kolom `nama`. Tanpa HasName, dashboard
 * Filament akan error "Return value must be of type string, null returned".
 *
 * @property int $id
 * @property string $nama
 * @property string $email
 * @property string $password
 * @property Peran $peran
 * @property bool $is_aktif
 */
class Pengguna extends Authenticatable implements FilamentUser, HasName
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
    // Akses panel Filament
    // ---------------------------------------------------------

    /**
     * Nama yang ditampilkan Filament.
     *
     * Filament secara default mencari atribut `name`, sedangkan tabel
     * `pengguna` memakai kolom `nama`. Method ini menjembataninya.
     */
    public function getFilamentName(): string
    {
        return $this->nama;
    }

    /**
     * Siapa yang boleh masuk panel Filament.
     *
     * Admin & Direktur boleh masuk, TAPI akun nonaktif ditolak.
     * Pembatasan CRUD lebih rinci dilakukan di masing-masing Resource
     * lewat canViewAny() / canCreate() / canEdit() / canDelete().
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_aktif
            && in_array($this->peran, [Peran::Admin, Peran::Direktur], true);
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
