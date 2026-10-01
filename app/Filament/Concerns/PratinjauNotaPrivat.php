<?php

declare(strict_types=1);

namespace App\Filament\Concerns;

use App\Support\Nota;
use Filament\Forms\Components\BaseFileUpload;
use Illuminate\Support\Facades\Storage;

/**
 * Pratinjau berkas dari disk PRIVAT.
 *
 * ⚠️ KENAPA INI PERLU (temuan audit 26 Sep 2026):
 * Nota disimpan di disk privat `nota` supaya tidak bisa diunduh tanpa login.
 * Tapi bawaan Filament membangun pratinjau dari `Storage::url()`, yang untuk
 * disk tanpa konfigurasi `url` menghasilkan `/storage/...` — alamat itu sudah
 * DITUTUP (403). Akibatnya thumbnail di form tampil rusak.
 *
 * Trait ini mengganti pembuat pratinjau agar memakai rute ber-otentikasi
 * `/admin/nota/{path}` (lihat App\Support\Nota), sehingga:
 *   - admin yang login melihat notanya seperti biasa;
 *   - URL tidak pernah menunjuk ke alamat publik.
 *
 * DIPAKAI UNTUK SEMUA FileUpload yang menyimpan ke disk `nota`.
 */
trait PratinjauNotaPrivat
{
    /**
     * Pasang pembuat pratinjau privat pada FileUpload.
     */
    public static function pratinjauPrivat(BaseFileUpload $field): BaseFileUpload
    {
        return $field->getUploadedFileUsing(
            static function (BaseFileUpload $component, string $file, string|array|null $storedFileNames): ?array {
                $disk = 'nota';

                if (! Storage::disk($disk)->exists($file)) {
                    return null;
                }

                return [
                    'name' => (is_array($storedFileNames) ? ($storedFileNames[$file] ?? null) : $storedFileNames)
                        ?? basename($file),
                    'size' => Storage::disk($disk)->size($file),
                    'type' => Storage::disk($disk)->mimeType($file),
                    // URL BER-OTENTIKASI — bukan /storage.
                    'url' => Nota::url($file),
                ];
            },
        );
    }
}
