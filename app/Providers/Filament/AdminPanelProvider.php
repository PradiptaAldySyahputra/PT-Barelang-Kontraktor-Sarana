<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Enums\Peran;
use App\Filament\Pages\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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
 * Panel utama aplikasi.
 *
 * Dipakai oleh Admin (input data) dan Direktur (monitoring).
 * Pembatasan hak akses dilakukan lewat:
 *   1. canAccessPanel() di model Pengguna
 *   2. canCreate()/canEdit()/canDelete() + trait BolehUbahData di Resource
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
            ->brandName('PT Barelang Kontraktor Sarana')
            ->brandLogo(fn () => view('filament.brand-logo'))
            ->brandLogoHeight('2.25rem')
            ->favicon(fn () => asset('favicon.svg'))
            ->colors([
                'primary' => Color::Blue,
                'gray' => Color::Slate,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
                'danger' => Color::Rose,
            ])
            // ---------------------------------------------------------
            // Navigasi
            // ---------------------------------------------------------
            // sidebarFullyCollapsibleOnDesktop = sidebar bisa DITUTUP TOTAL
            // (hilang dari layar) atau dibuka kembali, bukan sekadar
            // menyusut jadi ikon. Tombol toggle ada di header.
            ->sidebarFullyCollapsibleOnDesktop()
            ->collapsibleNavigationGroups(true)  // grup menu bisa dilipat
            ->sidebarWidth('16rem')
            ->collapsedSidebarWidth('4.5rem')
            ->spa()                              // navigasi tanpa reload penuh

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                AccountWidget::class,
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
     * Peran yang boleh masuk panel.
     *
     * @return list<string>
     */
    public static function peranYangBolehMasuk(): array
    {
        return [Peran::Admin->value, Peran::Direktur->value];
    }
}
