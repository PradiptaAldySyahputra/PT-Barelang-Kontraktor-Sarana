<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * Model infrastruktur untuk riwayat berkas ekspor (`exports`).
 *
 * Menggantikan dependensi Filament\Actions\Exports\Models\Export
 * agar tabel `exports` tetap berfungsi secara mandiri tanpa Filament.
 *
 * @property int $id
 * @property string $file_disk
 * @property string|null $file_name
 * @property string $exporter
 * @property int $processed_rows
 * @property int $total_rows
 * @property int $successful_rows
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Export extends Model
{
    protected $table = 'exports';

    protected $fillable = [
        'completed_at',
        'file_disk',
        'file_name',
        'exporter',
        'processed_rows',
        'total_rows',
        'successful_rows',
        'user_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
            'processed_rows' => 'integer',
            'total_rows' => 'integer',
            'successful_rows' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Pengguna, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

    public function getFailedRowsCount(): int
    {
        return max(0, (int) $this->total_rows - (int) $this->successful_rows);
    }

    public function getFileDisk(): Filesystem
    {
        return Storage::disk($this->file_disk ?: 'local');
    }

    public function getFileDirectory(): string
    {
        return 'filament_exports';
    }
}
