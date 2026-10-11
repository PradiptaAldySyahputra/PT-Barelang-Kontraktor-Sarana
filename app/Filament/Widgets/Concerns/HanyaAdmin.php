<?php

declare(strict_types=1);

namespace App\Filament\Widgets\Concerns;

use App\Enums\Peran;

/**
 * Widget dashboard yang HANYA untuk Admin (B3-12).
 *
 * ⚠️ KENAPA:
 * Dashboard lengkap (grafik rinci + tabel SPK berjalan) dirancang untuk Admin
 * yang menginput data. Direktur mendapat dashboard RINGKAS tersendiri
 * (`RingkasanDirektur`), jadi widget rinci disembunyikan darinya lewat trait ini.
 *
 * Widget yang memakai trait ini otomatis punya `canView()` = true hanya untuk
 * peran Admin. Filament memfilter widget berdasarkan `canView()` saat merender.
 */
trait HanyaAdmin
{
    public static function canView(): bool
    {
        return auth()->user()?->peran === Peran::Admin;
    }
}
