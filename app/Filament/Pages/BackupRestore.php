<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Enums\Peran;
use App\Models\Pengguna;
use App\Support\StatusBackup;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

/**
 * HALAMAN BACKUP & RESTORE (B1-4).
 *
 * ⚠️ KENAPA PERLU:
 * Temuan audit — backup terjadwal TIDAK PERNAH menghasilkan berkas dan tidak
 * terpantau. Direktur (non-teknisi) butuh satu halaman untuk melihat: kapan
 * backup terakhir, berapa ukurannya, dan tombol unduh. Bukan hanya perintah
 * artisan yang tak terlihat.
 *
 * ⚠️ KHUSUS ADMIN: halaman ini bisa memicu backup & mengunduh seluruh data —
 * hanya Admin yang boleh. Direktur read-only TIDAK boleh.
 */
class BackupRestore extends Page
{
    protected string $view = 'filament.pages.backup-restore';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCircleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Sistem';

    protected static ?string $navigationLabel = 'Backup & Restore';

    protected static ?string $title = 'Backup & Restore';

    protected static ?int $navigationSort = 1;

    /**
     * Hanya Admin yang boleh melihat halaman ini.
     */
    public static function canAccess(): bool
    {
        /** @var Pengguna|null $user */
        $user = Auth::user();

        return $user?->peran === Peran::Admin;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Pantau backup database & unduh salinan terakhir.';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'ringkasan' => StatusBackup::ringkasan(),
            'daftar' => StatusBackup::daftar(),
        ];
    }

    /**
     * @return list<Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('buatBackup')
                ->label('Buat Backup Sekarang')
                ->icon('heroicon-m-play')
                ->requiresConfirmation()
                ->modalHeading('Buat backup sekarang?')
                ->modalDescription('Menjalankan mysqldump dan menyimpan berkas .sql.gz. Bisa memakan beberapa detik.')
                ->action(function (): void {
                    $exit = Artisan::call('bks:backup', ['--hari' => 30]);
                    $keluaran = trim(Artisan::output());

                    if ($exit === 0) {
                        Notification::make()
                            ->title('Backup berhasil')
                            ->body($keluaran !== '' ? $keluaran : 'Berkas backup dibuat.')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Backup GAGAL')
                            ->body($keluaran !== '' ? $keluaran : 'Periksa konfigurasi database & mysqldump.')
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
