<?php

declare(strict_types=1);

namespace App\Filament\Resources\Penggunas\Pages;

use App\Filament\Resources\Penggunas\PenggunaResource;
use App\Models\Pengguna;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

/**
 * Ubah Pengguna.
 *
 * ⚠️ PENGAMAN SISTEM TERKUNCI (temuan audit):
 * Selain canEdit() di Resource, di sini ada pengaman KEDUA: kalau Admin
 * mencoba menonaktifkan akunnya sendiri, perubahan dibatalkan dengan
 * pesan jelas. Dua lapis supaya tidak ada celah lewat Livewire langsung.
 */
class EditPengguna extends EditRecord
{
    protected static string $resource = PenggunaResource::class;

    protected static ?string $title = 'Ubah Pengguna';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn (): bool => PenggunaResource::canDelete($this->getRecord())),
        ];
    }

    /**
     * Pengaman: jangan biarkan Admin menonaktifkan dirinya sendiri.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->getRecord();

        $diriSendiri = $record instanceof Pengguna && auth()->id() === $record->getKey();

        if ($diriSendiri && array_key_exists('is_aktif', $data) && $data['is_aktif'] === false) {
            // Kembalikan ke aktif & beri tahu.
            $data['is_aktif'] = true;

            Notification::make()
                ->title('Tidak bisa menonaktifkan akun sendiri')
                ->body('Kalau akun ini dinonaktifkan, Anda akan terkunci dari sistem. Minta Admin lain untuk melakukannya.')
                ->danger()
                ->persistent()
                ->send();
        }

        // Pengaman tambahan: jangan biarkan peran sendiri diubah jadi
        // non-Admin oleh diri sendiri (bisa mengunci hak akses).
        if ($diriSendiri && array_key_exists('peran', $data)) {
            $data['peran'] = $record->peran->value;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Perubahan pengguna tersimpan';
    }
}
