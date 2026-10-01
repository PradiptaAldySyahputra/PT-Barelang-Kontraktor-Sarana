<?php

declare(strict_types=1);

namespace App\Filament\Resources\Penggunas;

use App\Enums\Peran;
use App\Filament\Concerns\BolehUbahData;
use App\Filament\Resources\Penggunas\Pages\CreatePengguna;
use App\Filament\Resources\Penggunas\Pages\EditPengguna;
use App\Filament\Resources\Penggunas\Pages\ListPenggunas;
use App\Filament\Resources\Penggunas\Schemas\PenggunaForm;
use App\Filament\Resources\Penggunas\Tables\PenggunasTable;
use App\Models\Pengguna;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

/**
 * Resource Pengguna — manajemen akun.
 *
 * ⚠️ PERMINTAAN USER (19 Sep 2026):
 * "bagian pengguna hanya direktur yang bisa lihat."
 *
 * Jadi:
 *   - HANYA Direktur yang bisa MELIHAT menu Pengguna
 *   - Direktur juga yang boleh menambah/mengubah akun
 *   - Admin (operator) tidak melihat menu ini sama sekali
 *
 * Alasan: pengelolaan akun menyangkut hak akses sistem. Ditaruh di tangan
 * Direktur (pemilik keputusan), bukan operator harian.
 *
 * ⚠️ PENGAMAN SISTEM TERKUNCI:
 * Siapa pun (termasuk Direktur) TIDAK boleh menghapus atau menonaktifkan
 * akunnya SENDIRI — kalau tidak, dia bisa mengunci dirinya dari sistem dan
 * tidak ada yang bisa mengembalikan akses.
 */
class PenggunaResource extends Resource
{
    use BolehUbahData;

    protected static ?string $model = Pengguna::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?string $modelLabel = 'Pengguna';

    protected static ?string $pluralModelLabel = 'Pengguna';

    protected static ?string $recordTitleAttribute = 'nama';

    protected static ?int $navigationSort = 22;

    public static function form(Schema $schema): Schema
    {
        return PenggunaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenggunasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenggunas::route('/'),
            'create' => CreatePengguna::route('/create'),
            'edit' => EditPengguna::route('/{record}/edit'),
        ];
    }

    // ---------------------------------------------------------
    // Hak akses — HANYA Direktur
    // ---------------------------------------------------------

    /**
     * Apakah pengguna yang login adalah Direktur?
     */
    protected static function isDirektur(): bool
    {
        return auth()->user()?->peran === Peran::Direktur;
    }

    /**
     * Sembunyikan menu dari Admin — hanya Direktur yang melihat.
     */
    public static function shouldRegisterNavigation(): bool
    {
        return static::isDirektur();
    }

    public static function canViewAny(): bool
    {
        return static::isDirektur();
    }

    public static function canCreate(): bool
    {
        return static::isDirektur();
    }

    public static function canEdit($record): bool
    {
        if (! static::isDirektur()) {
            return false;
        }

        return ! static::adalahDiriSendiri($record);
    }

    public static function canDelete($record): bool
    {
        if (! static::isDirektur()) {
            return false;
        }

        return ! static::adalahDiriSendiri($record);
    }

    /**
     * Apakah record ini akun yang sedang login?
     */
    protected static function adalahDiriSendiri(mixed $record): bool
    {
        if (! $record instanceof Pengguna) {
            return false;
        }

        return auth()->id() === $record->getKey();
    }
}
