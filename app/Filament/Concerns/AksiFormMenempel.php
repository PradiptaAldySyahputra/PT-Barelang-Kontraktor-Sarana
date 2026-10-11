<?php

declare(strict_types=1);

namespace App\Filament\Concerns;

/**
 * Sticky action bar untuk halaman form.
 *
 * ⚠️ KENAPA TRAIT (bukan `stickyFormActions()`):
 * `BasePage::stickyFormActions()` menulis ke properti STATIS `$formActionsAreSticky`
 * yang DIBAGI semua subclass. Kalau satu halaman memanggilnya di `boot()`, bisa
 * memengaruhi halaman lain secara tak terduga. Trait ini meng-override method
 * `areFormActionsSticky()` agar SELALU true untuk halaman yang memakainya —
 * eksplisit, terisolasi, dan mudah diuji.
 *
 * ⚠️ MASALAH YANG DIPERBAIKI:
 * Form SPK & Uang Keluar panjang (8+ section). Setelah mengisi field terbawah,
 * admin harus scroll ke atas untuk menemukan tombol "Simpan". Dengan menempel,
 * tombol selalu terlihat tanpa scroll.
 */
trait AksiFormMenempel
{
    public function areFormActionsSticky(): bool
    {
        return true;
    }
}
