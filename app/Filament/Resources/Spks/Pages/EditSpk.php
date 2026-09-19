<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Pages;

use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Filament\Resources\MonitoringSpk\StatusSpkResource;
use App\Filament\Resources\Spks\SpkResource;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Halaman UBAH SPK.
 *
 * Dipakai dua cara:
 *   1. Dari LIST SPK → form lengkap (semua data SPK).
 *   2. Dari STATUS SPK → form RINGKAS (hanya status & tagihan), supaya
 *      mengubah status jadi cepat dan tidak berisiko salah ubah data lain.
 *
 * Cara mana yang dipakai ditentukan oleh query string `?ringkas=1`
 * yang dikirim dari tombol di halaman Status SPK.
 */
class EditSpk extends EditRecord
{
    protected static string $resource = SpkResource::class;

    protected static ?string $title = 'Ubah SPK';

    /**
     * Apakah sedang memakai form ringkas (dari halaman Status SPK)?
     */
    protected function modeRingkas(): bool
    {
        return (bool) request()->query('ringkas');
    }

    public function getHeading(): string
    {
        return $this->modeRingkas() ? 'Ubah Status SPK' : 'Ubah SPK';
    }

    public function getSubheading(): ?string
    {
        return $this->modeRingkas()
            ? 'Ubah status pekerjaan & status tagihan. Untuk mengubah data lain, buka menu List SPK.'
            : null;
    }

    /**
     * Form ringkas: HANYA status (permintaan user: "simple mengubahnya").
     */
    public function form(Schema $schema): Schema
    {
        if (! $this->modeRingkas()) {
            return parent::form($schema);
        }

        $record = $this->getRecord();

        return $schema
            ->components([
                Section::make('Status SPK')
                    ->description($record->nomor_spk.' — '.$record->nama_pekerjaan)
                    ->schema([
                        Select::make('status_spk')
                            ->label('Status Pekerjaan')
                            ->options(StatusSpk::opsi())
                            ->required()
                            ->native(false)
                            ->helperText('Status pekerjaan: Draft → Terbit → Berjalan → Selesai → Sudah Ditagihkan.'),

                        Select::make('status_tagihan')
                            ->label('Status Tagihan')
                            ->options(StatusTagihan::opsi())
                            ->native(false)
                            ->helperText('Status tagihan disinkronkan otomatis dari pembayaran, tetapi bisa ditimpa manual di sini.'),
                    ])
                    ->columns(1),
            ]);
    }

    protected function getHeaderActions(): array
    {
        // Halaman ringkas tidak perlu aksi hapus.
        if ($this->modeRingkas()) {
            return [];
        }

        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        // Kembali ke halaman asal supaya alur monitoring tidak terputus.
        if ($this->modeRingkas()) {
            return StatusSpkResource::getUrl('index');
        }

        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return $this->modeRingkas() ? 'Status SPK diperbarui' : 'Perubahan SPK tersimpan';
    }
}
