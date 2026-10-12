<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Enums\Peran;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\LupaPassword;
use App\Filament\Pages\ProfilAkun;
use Filament\FontProviders\LocalFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
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
 * - navbar jadi tampak rusak (hanya kotak inisial, tanpa nama).
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
            // MANAJEMEN AKUN - permintaan user (9 Okt 2026):
            // "Aplikasi BELUM punya pengelolaan akun yang layak."
            //
            //   ->profile(ProfilAkun::class)  → menu pengguna (pojok kanan atas)
            //        berisi lihat/ubah nama & email + GANTI PASSWORD
            //        (verifikasi password lama, min 8 karakter huruf+angka).
            //   ->passwordReset(LupaPassword::class) → tautan "Lupa password?"
            //        di halaman login, memakai email + token kedaluwarsa 60 menit.
            ->profile(ProfilAkun::class)
            ->passwordReset(LupaPassword::class)
            ->brandName('Barelang Kontraktor Sarana')
            ->favicon(asset('favicon.svg'))

            /*
             * TIPOGRAFI - FONT SISTEM (perbaikan bug font, 12 Okt 2026).
             *
             * Design.md menyatakan typography = font sistem (system-ui).
             * Kenyataannya Filament 5 default memakai "Inter Variable":
             * ia menyuntik `--font-family: 'Inter Variable'` inline dan
             * memuat berkas Inter (preload + @font-face). Override `--font-sans`
             * saja TIDAK cukup - `<html>` tetap meresolusi ke Inter lewat
             * `--default-font-family`, dan berkas Inter tetap diunduh.
             *
             * `->font('system-ui', provider: LocalFontProvider::class)` membuat
             * Filament berhenti memuat berkas font (tanpa preload, tanpa CDN);
             * nilainya sendiri adalah font sistem. Ditambah override
             * `--font-family` di theme.css, hasilnya font sistem yang nyata.
             */
            ->font('system-ui', provider: LocalFontProvider::class)

            // TOMBOL TOGGLE SIDEBAR - DIPISAH DARI NAMA PERUSAHAAN
            //
            // ⚠️ PERMINTAAN USER: tombol tutup/buka sidebar jangan satu
            // tempat dengan nama perusahaan, supaya di situ bisa ditambah
            // logo. Jadi tombol ditaruh SEBELUM logo & nama brand, diikuti
            // logo "BKS".
            //
            // Hook ini menyisipkan view di dalam header sidebar, tepat
            // sebelum logo/nama brand dirender.
            ->renderHook(
                PanelsRenderHook::SIDEBAR_LOGO_BEFORE,
                fn (): View => view('filament.sidebar-toggle'),
            )
            // NAVIGASI KEYBOARD - Enter pindah ke field berikutnya.
            //
            // ⚠️ SARAN USER (9 Okt 2026): "Enter pindah ke field berikutnya;
            // mempercepat input 2–3× lipat". Panel hanya memuat theme.css
            // (bukan app.js), jadi skrip disuntik lewat render hook ini.
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): View => view('filament.enter-navigasi'),
            )
            // Warna - AKSEN BIRU ENTERPRISE (sistem desain v1.1)
            // ⚠️ DIUBAH 11 Okt 2026 (prompt desain Bagian A.1):
            // "Aksen primer biru enterprise #2563eb menggantikan Zinc
            //  monokrom (tombol utama, menu aktif, link). Satu warna aksen
            //  saja - jangan warna-warni."
            //
            // primary = Blue (#2563eb). Gray tetap Zinc netral supaya
            // permukaan & teks tetap netral; biru hanya sebagai AKSEN.
            ->colors([
                'primary' => Color::Blue,
                'gray' => Color::Zinc,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
                'danger' => Color::Rose,
                'info' => Color::Sky,
            ])

            // Navigasi
            // Sidebar bisa DITUTUP TOTAL lalu dibuka kembali (bukan hanya
            // menyusut jadi ikon). Tombol toggle ada di topbar.
            ->sidebarFullyCollapsibleOnDesktop()
            ->collapsibleNavigationGroups(true)
            ->sidebarWidth('15rem')
            ->collapsedSidebarWidth('4.5rem')

            // GRUP NAVIGASI
            // ⚠️ Filament 5 MELARANG grup dan item sama-sama berikon
            // ("Either the group or its items can have icons, but not both").
            // Ikon PER-MENU lebih berguna untuk navigasi, jadi ikon tetap di
            // item; grup dibedakan lewat AKSEN WARNA (lihat .fi-sidebar-group-label
            // di theme.css) - memberi "peta" modul tanpa ikon kedua.
            //
            // Catatan: daftar grup di bawah ini hanya MENDAFTARKAN urutannya;
            // tanpa ->icon() agar tidak bentrok dengan ikon item.
            ->navigationGroups([
                NavigationGroup::make('SPK'),
                NavigationGroup::make('Keuangan'),
                NavigationGroup::make('Master Data'),
                NavigationGroup::make('Laporan'),
                NavigationGroup::make('Sistem'),
            ])

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
