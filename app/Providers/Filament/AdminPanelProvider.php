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
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Contracts\View\View;
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
 *
 * ⚠️ CATATAN tentang brand:
 * JANGAN memakai brandLogo() berupa view HTML. Di Filament 5, jika brandLogo
 * diisi, komponen logo HANYA merender gambar itu dan NAMA BRAND DISEMBUNYIKAN
 * — navbar jadi tampak rusak (hanya kotak inisial, tanpa nama).
 * Cukup pakai brandName() agar nama perusahaan tampil rapi dan responsif.
 *
 * Kalau nanti ada file logo asli (PNG/SVG), baru pakai:
 *   ->brandLogo(asset('images/logo.svg'))
 */
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login()
            ->brandName('Barelang Kontraktor Sarana')
            ->favicon(asset('favicon.svg'))

            // ---------------------------------------------------------
            // TOMBOL TOGGLE SIDEBAR — DIPISAH DARI NAMA PERUSAHAAN
            //
            // ⚠️ PERMINTAAN USER: tombol tutup/buka sidebar jangan satu
            // tempat dengan nama perusahaan, supaya di situ bisa ditambah
            // logo. Jadi tombol ditaruh SEBELUM logo & nama brand, diikuti
            // logo "BKS".
            //
            // Hook ini menyisipkan view di dalam header sidebar, tepat
            // sebelum logo/nama brand dirender.
            // ---------------------------------------------------------
            ->renderHook(
                PanelsRenderHook::SIDEBAR_LOGO_BEFORE,
                fn (): View => view('filament.sidebar-toggle'),
            )
            // ---------------------------------------------------------
            // Warna — MONOKROM (tema Clean Minimalist Enterprise)
            // ---------------------------------------------------------
            // primary = Zinc (netral/arang), BUKAN biru. Ini membuat tombol
            // utama berwarna hampir hitam sesuai gaya Vercel/Linear.
            // gray juga Zinc agar seluruh panel konsisten netral.
            ->colors([
                'primary' => Color::Zinc,
                'gray' => Color::Zinc,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
                'danger' => Color::Rose,
                'info' => Color::Zinc,
            ])

            // ---------------------------------------------------------
            // Navigasi
            // ---------------------------------------------------------
            // Sidebar bisa DITUTUP TOTAL lalu dibuka kembali (bukan hanya
            // menyusut jadi ikon). Tombol toggle ada di topbar.
            ->sidebarFullyCollapsibleOnDesktop()
            ->collapsibleNavigationGroups(true)
            ->sidebarWidth('15rem')
            ->collapsedSidebarWidth('4.5rem')

            // Layout
            ->maxContentWidth('full')

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
