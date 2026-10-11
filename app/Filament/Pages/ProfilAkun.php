<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Filament\Concerns\PratinjauNotaPrivat;
use Filament\Auth\Pages\EditProfile;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

/**
 * HALAMAN PROFIL SAYA — lihat/ubah data diri + ganti password.
 *
 * ⚠️ KENAPA MEMBUAT KELAS SENDIRI (bukan memakai EditProfile bawaan apa adanya):
 *
 *   1. Tabel pengguna memakai kolom `nama`, sedangkan bawaan Filament memakai
 *      `name` — tanpa override, field nama tidak akan tersimpan.
 *   2. Label bawaan berbahasa Inggris ("Name", "Password").
 *   3. Setelah ganti password, SESI LAIN harus diputus (keamanan): kalau
 *      seseorang pernah login di komputer lain lalu password diganti, sesi lama
 *      tidak boleh tetap hidup.
 *
 * ⚠️ TAMBAHAN (permintaan user 10 Okt 2026 — "profile masih sederhana"):
 *   - Foto profil (avatar)
 *   - Tanda tangan digital → dipakai di blok "Disetujui oleh" pada PDF
 *   - Info akun: peran & waktu login terakhir
 *
 * Halaman ini didaftarkan di AdminPanelProvider lewat `->profile(ProfilAkun::class)`,
 * sehingga otomatis muncul di MENU PENGGUNA (pojok kanan atas).
 *
 * Aturan password (minimal 8 karakter, kombinasi huruf & angka) dipusatkan di
 * `AppServiceProvider::boot()` lewat `Password::defaults()`, supaya konsisten
 * dengan halaman Lupa Password.
 */
class ProfilAkun extends EditProfile
{
    use PratinjauNotaPrivat;

    protected static ?string $title = 'Profil Saya';

    public static function getLabel(): string
    {
        return 'Profil Saya';
    }

    public function getHeading(): string
    {
        return 'Profil Saya';
    }

    /**
     * Komponen field NAMA memakai kolom `nama` (bukan `name` bawaan).
     */
    protected function getNameFormComponent(): Component
    {
        return TextInput::make('nama')
            ->label('Nama Lengkap')
            ->required()
            ->maxLength(200)
            ->autofocus();
    }

    /**
     * Field EMAIL — wajib unik (tidak boleh dipakai akun lain).
     */
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Email')
            ->email()
            ->required()
            ->maxLength(200)
            ->unique(ignoreRecord: true)
            ->helperText('Dipakai untuk login. Harus unik — tidak boleh sama dengan akun lain.')
            ->live(debounce: 500);
    }

    /**
     * Field FOTO PROFIL (avatar).
     *
     * ⚠️ Disimpan di disk privat `nota` — data pribadi pegawai, jangan di
     * disk publik. Pratinjau memakai rute ber-otentikasi (PratinjauNotaPrivat).
     */
    protected function getAvatarFormComponent(): Component
    {
        return self::pratinjauPrivat(
            FileUpload::make('avatar')
                ->label('Foto Profil')
                ->image()
                ->avatar()
                ->disk('nota')
                ->directory('profil')
                ->visibility('private')
                ->maxSize(2048)
                ->helperText('Opsional. JPG/PNG, maksimal 2 MB.')
        );
    }

    /**
     * Field TANDA TANGAN — dipakai pada blok "Disetujui oleh" di PDF.
     *
     * ⚠️ Disimpan di disk privat (data pribadi). Format PNG disarankan agar
     * latar transparan terlihat rapi saat ditempel ke dokumen.
     */
    protected function getTandaTanganFormComponent(): Component
    {
        return self::pratinjauPrivat(
            FileUpload::make('tanda_tangan')
                ->label('Tanda Tangan')
                ->image()
                ->disk('nota')
                ->directory('tanda-tangan')
                ->visibility('private')
                ->maxSize(1024)
                ->helperText('Opsional. PNG/JPG, maksimal 1 MB. Akan muncul di kolom "Disetujui oleh" pada PDF laporan.')
        );
    }

    protected function getPasswordFormComponent(): Component
    {
        return parent::getPasswordFormComponent()
            ->label('Password Baru')
            ->helperText('Minimal 8 karakter, kombinasi huruf dan angka.');
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return parent::getPasswordConfirmationFormComponent()
            ->label('Konfirmasi Password Baru');
    }

    protected function getCurrentPasswordFormComponent(): Component
    {
        return parent::getCurrentPasswordFormComponent()
            ->label('Password Saat Ini')
            ->belowContent('Wajib diisi untuk mengonfirmasi perubahan.');
    }

    /**
     * Susunan form: Data Akun → Foto & Tanda Tangan → Ubah Password.
     *
     * ⚠️ Field password bawaan tetap disertakan apa adanya supaya semua
     * perilaku keamanan bawaan (verifikasi password lama, konfirmasi, aturan
     * password) tidak hilang.
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Akun')
                    ->description('Nama & email untuk login.')
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getInfoAkunComponent(),
                    ])
                    ->columns(2),

                Section::make('Foto & Tanda Tangan')
                    ->description('Opsional. Tanda tangan akan muncul di dokumen PDF yang Anda setujui.')
                    ->schema([
                        $this->getAvatarFormComponent(),
                        $this->getTandaTanganFormComponent(),
                    ])
                    ->columns(2),

                Section::make('Ubah Password')
                    ->description('Kosongkan bila tidak ingin mengganti password.')
                    ->schema([
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getCurrentPasswordFormComponent(),
                    ])
                    ->columns(2),
            ]);
    }

    /**
     * Info akun (read-only): peran & waktu login terakhir.
     */
    protected function getInfoAkunComponent(): Component
    {
        return Placeholder::make('info_akun')
            ->label('Info Akun')
            ->content(function (): HtmlString {
                $user = $this->getUser();

                $peran = method_exists($user, 'isDirektur') && $user->isDirektur() ? 'Direktur' : 'Admin';

                $terakhir = $user->terakhir_masuk?->translatedFormat('d F Y, H:i') ?? 'Belum tercatat';

                return new HtmlString(
                    'Peran: <strong>'.e($peran).'</strong><br>'
                    .'Login terakhir: '.e($terakhir)
                );
            });
    }

    /**
     * Simpan profil.
     *
     * Menambah dua hal penting di atas perilaku bawaan:
     *   - `Auth::logoutOtherDevices()` → sesi di perangkat lain yang masih
     *     memakai password lama DIPUTUS begitu password diganti.
     *   - `session()->regenerate()` → ID sesi diganti (cegah session fixation).
     *
     * Password baru diambil SEBELUM `parent::save()` karena bawaan Filament
     * mengosongkan `$this->data['password']` setelah menyimpan.
     */
    public function save(): void
    {
        $passwordBaru = filled($this->data['password'] ?? null)
            ? (string) $this->data['password']
            : null;

        parent::save();

        if ($passwordBaru !== null) {
            Auth::logoutOtherDevices($passwordBaru);

            if (request()->hasSession()) {
                request()->session()->regenerate();
            }
        }
    }
}
