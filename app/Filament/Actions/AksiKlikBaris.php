<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use Filament\Actions\Action;

/**
 * Aksi yang dipicu dengan MENGKLIK BARIS tabel, bukan lewat tombol.
 *
 * ⚠️ KENAPA KELAS INI ADA:
 * Filament menganggap aksi yang `hidden()` sebagai `disabled()` juga, sehingga
 * aksi yang disembunyikan tombolnya TIDAK bisa di-mount — padahal kita justru
 * ingin baris tabel memicunya. Kelas ini memutus kaitan itu: tombolnya tetap
 * tidak tampil (`hidden()`), tetapi aksinya tetap bisa dijalankan saat baris
 * diklik.
 */
class AksiKlikBaris extends Action
{
    public function isDisabled(): bool
    {
        return (bool) $this->evaluate($this->isDisabled);
    }
}
