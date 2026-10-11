<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Filament\Auth\Pages\PasswordReset\RequestPasswordReset;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Illuminate\Auth\Events\PasswordResetLinkSent;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Facades\Password;

/**
 * HALAMAN LUPA PASSWORD — minta tautan reset lewat email.
 *
 * Memakai mesin bawaan Laravel (broker password + token kedaluwarsa 60 menit,
 * lihat config/auth.php `passwords.users.expire = 60`).
 *
 * ⚠️ DUA PENYESUAIAN KEAMANAN dari bawaan Filament:
 *
 *   1. ANTI-ENUMERASI USER.
 *      Bawaan Filament membedakan pesan: kalau email TIDAK terdaftar, muncul
 *      pesan "kami tidak menemukan pengguna dengan email itu". Penyerang bisa
 *      memakainya untuk memastikan email mana yang terdaftar di sistem. Di sini
 *      pesan SELALU sama, apa pun hasilnya.
 *
 *   2. RATE LIMIT 5 percobaan / menit (bawaan Filament hanya 2), sesuai
 *      permintaan: "Rate limit 5x percobaan/menit untuk login & reset password".
 */
class LupaPassword extends RequestPasswordReset
{
    protected static ?string $title = 'Lupa Password';

    public function getHeading(): string
    {
        return 'Lupa Password';
    }

    protected function getEmailFormComponent(): Component
    {
        return parent::getEmailFormComponent()
            ->helperText('Kami akan mengirim tautan pembuatan password baru bila email ini terdaftar.');
    }

    /**
     * Kirim tautan reset.
     *
     * Seluruh alur memakai `Password::broker()->sendResetLink()` bawaan Laravel
     * (signed URL + token kedaluwarsa). Notifikasi yang ditampilkan ke pengguna
     * SELALU pesan sukses generik — tidak pernah membocorkan apakah email
     * terdaftar atau tidak.
     */
    public function request(): void
    {
        try {
            // 5 percobaan per menit (decay bawaan LivewireRateLimiting = 60 detik).
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return;
        }

        $data = $this->form->getState();

        Password::broker(Filament::getAuthPasswordBroker())->sendResetLink(
            ['email' => $data['email']],
            function (CanResetPassword $user, string $token): void {
                // Akun nonaktif / tidak boleh masuk panel tidak dikirimi tautan.
                if (
                    ($user instanceof FilamentUser) &&
                    (! $user->canAccessPanel(Filament::getCurrentOrDefaultPanel()))
                ) {
                    return;
                }

                $notification = app(ResetPasswordNotification::class, ['token' => $token]);
                $notification->url = Filament::getResetPasswordUrl($token, $user);

                $user->notify($notification);

                if (class_exists(PasswordResetLinkSent::class)) {
                    event(new PasswordResetLinkSent($user));
                }
            },
        );

        /*
         * ⚠️ ANTI-ENUMERASI: pesan yang SAMA untuk email terdaftar maupun tidak.
         * Jangan pernah memakai status kembalian broker untuk membedakan pesan.
         */
        Notification::make()
            ->success()
            ->title('Permintaan diterima')
            ->body('Jika email tersebut terdaftar, tautan pembuatan password baru sudah dikirim. Periksa kotak masuk (dan folder spam). Tautan berlaku 60 menit.')
            ->send();

        $this->form->fill();
    }
}
