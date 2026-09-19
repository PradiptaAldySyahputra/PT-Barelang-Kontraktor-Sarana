<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Enums\Peran;
use App\Filament\Widgets\GrafikArusKas;
use App\Filament\Widgets\RingkasanKeuangan;
use App\Filament\Widgets\SpkBerjalan;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * Panel Admin/Operator.
 *
 * Panel ini dipakai oleh Admin DAN Direktur.
 * Pembatasan hak akses dilakukan lewat:
 *   1. canAccessPanel() di model Pengguna  -> siapa yang boleh masuk panel
 *   2. canViewAny() / canCreate() di Resource -> siapa yang boleh CRUD
 *
 * Sesuai Rules.md §4: Direktur hanya boleh MELIHAT, tidak boleh input.
 */
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('SIAKAD SPK — PT Barelang Kontraktor Sarana')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                AccountWidget::class,
                RingkasanKeuangan::class,
                GrafikArusKas::class,
                SpkBerjalan::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    /**
     * Hanya Admin & Direktur yang boleh masuk panel.
     *
     * Catatan: Filament memakai guard `web`, jadi model Pengguna harus
     * mengimplementasikan FilamentUser agar method ini dipanggil.
     */
    public static function peranYangBolehMasuk(): array
    {
        return [Peran::Admin->value, Peran::Direktur->value];
    }
}
