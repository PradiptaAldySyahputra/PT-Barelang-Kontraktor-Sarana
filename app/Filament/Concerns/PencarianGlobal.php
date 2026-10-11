<?php

declare(strict_types=1);

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Pencarian global (topbar "Cari").
 *
 * ⚠️ KENAPA TRAIT INI ADA:
 * Topbar sudah lama menampilkan kotak "Cari", tetapi tiap Resource hanya
 * mengindeks SATU kolom (judul) lewat `$recordTitleAttribute`. Akibatnya
 * admin tidak bisa menemukan transaksi lewat keterangan/nomor SPK/penerima
 * — padahal itu cara kerja sehari-hari.
 *
 * Trait ini:
 *   1. Menyediakan daftar kolom yang diindeks per Resource
 *      (`getGloballySearchableAttributes()`).
 *   2. Memastikan pencarian TIDAK memunculkan data yang sudah di-soft-delete
 *      (`getGlobalSearchEloquentQuery()`), karena Resource memakai
 *      `withoutGlobalScopes([SoftDeletingScope::class])` untuk keperluan
 *      lain (kolom "Data Terhapus").
 */
trait PencarianGlobal
{
    /**
     * Query khusus pencarian global — kecualikan baris terhapus BILA model
     * memakai SoftDeletes (Mitra/Pengguna tidak memakainya).
     *
     * @return Builder<static>
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        $query = static::getEloquentQuery();

        $model = static::getModel();

        if (in_array(SoftDeletes::class, class_uses_recursive($model), true)) {
            $query->whereNull($model::make()->getTable().'.deleted_at');
        }

        return $query;
    }
}
