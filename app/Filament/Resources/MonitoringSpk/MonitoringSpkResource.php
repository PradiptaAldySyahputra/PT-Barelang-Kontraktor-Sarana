<?php

declare(strict_types=1);

namespace App\Filament\Resources\MonitoringSpk;

use App\Filament\Concerns\BolehUbahData;
use App\Models\Spk;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Dasar untuk resource SPK yang bersifat MONITORING (baca saja).
 *
 * Dipakai oleh:
 *   - StatusSpkResource          → monitoring status pekerjaan
 *   - TagihanSpkResource         → monitoring tagihan yang belum selesai
 *   - TagihanSelesaiSpkResource  → riwayat tagihan yang sudah selesai
 *
 * ⚠️ Resource turunan TIDAK boleh membuat/mengubah/menghapus data.
 * Perubahan data hanya lewat "List SPK".
 */
abstract class MonitoringSpkResource extends Resource
{
    use BolehUbahData;

    protected static ?string $model = Spk::class;

    protected static string|\UnitEnum|null $navigationGroup = 'SPK';

    protected static ?string $recordTitleAttribute = 'nomor_spk';

    protected static ?string $modelLabel = 'SPK';

    protected static ?string $pluralModelLabel = 'SPK';

    /**
     * Monitoring = BACA SAJA. Tidak ada tombol tambah/ubah/hapus.
     */
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    /**
     * Form kosong — resource monitoring tidak punya halaman create/edit,
     * tetapi method ini wajib ada karena abstract di parent.
     */
    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    /**
     * Query dasar: buang data yang sudah di-soft-delete, sertakan total
     * penerimaan/biaya lewat subquery (hindari N+1).
     *
     * @return Builder<Spk>
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('mitra')
            ->withSum('uangMasuk as total_masuk', 'jumlah')
            ->withSum('uangKeluar as total_keluar', 'jumlah');
    }

    /**
     * Ikon navigasi default — ditimpa tiap turunan.
     */
    protected static function ikon(): string|BackedEnum
    {
        return Heroicon::OutlinedEye;
    }
}
