<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Pages;

use App\Enums\StatusSpk;
use App\Filament\Resources\MonitoringSpk\StatusSpkResource;
use App\Filament\Resources\MonitoringSpk\TagihanSelesaiSpkResource;
use App\Filament\Resources\MonitoringSpk\TagihanSpkResource;
use App\Filament\Resources\Spks\SpkResource;
use App\Models\Spk;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * UBAH STATUS SPK — form TERPISAH, hanya berisi status.
 *
 * ⚠️ PERMINTAAN USER:
 * "di spk bagian status spk merubahnya lewat ubah status saja, jadi status
 *  cuman menampilkan progres. untuk tagihan status begitu juga cara
 *  merubahnya, jadi formnya masing masing untuk status progres spk dan
 *  status tagihan spk dan itu saling berkaitan sampai ke tagihan selesai"
 *
 * Jadi ada DUA halaman terpisah yang jelas bedanya:
 *
 *   `UbahStatusSpk`      → hanya STATUS PEKERJAAN (draft → berjalan → selesai)
 *   `UbahStatusTagihan`  → hanya STATUS TAGIHAN (belum → ditagihkan → dibayar)
 *
 * Tiap halaman:
 *   - Menampilkan data SPK sebagai konteks (read-only)
 *   - HANYA field status yang bisa diubah
 *   - Tombol simpan + kembali ke menu ASAL (bukan selalu List SPK)
 *
 * Alasan dipisah: supaya Admin tidak salah ubah data lain saat hanya ingin
 * mengganti status, dan supaya jelas bedanya status pekerjaan vs tagihan.
 */
class UbahStatusSpk extends EditRecord
{
    protected static string $resource = SpkResource::class;

    protected static ?string $title = 'Ubah Status Pekerjaan';

    public function getSubheading(): ?string
    {
        $r = $this->getRecord();

        return $r->nomor_spk.' — '.$r->nama_pekerjaan;
    }

    /**
     * Form: KONTEKS (read-only) + SATU field status.
     */
    public function form(Schema $schema): Schema
    {
        $r = $this->getRecord();

        return $schema
            ->components([
                Section::make('Konteks SPK')
                    ->description('Data ini hanya tampilan — untuk mengubahnya, buka menu List SPK.')
                    ->schema([
                        Placeholder::make('info_nomor')
                            ->label('Nomor SPK')
                            ->content($r->nomor_spk),

                        Placeholder::make('info_nilai')
                            ->label('Nilai SPK')
                            ->content('Rp '.number_format((float) $r->nilai_spk, 0, ',', '.')),

                        Placeholder::make('info_status_tagihan')
                            ->label('Status Tagihan (sekarang)')
                            ->content($r->status_tagihan?->label() ?? 'Belum Ditagihkan'),

                        Placeholder::make('info_tenggat')
                            ->label('Tenggat')
                            ->content($r->tanggal_akhir?->format('d/m/Y') ?? '—'),
                    ])
                    ->columns(2),

                Section::make('Status Pekerjaan')
                    ->description('Tahapan pekerjaan: Draft → Terbit → Berjalan → Selesai → Sudah Ditagihkan. Dibatalkan untuk SPK yang batal.')
                    ->schema([
                        Select::make('status_spk')
                            ->label('Status Pekerjaan')
                            ->options(StatusSpk::opsi())
                            ->required()
                            ->native(false)
                            ->helperText('Ini status PROGRES PEKERJAAN, bukan status tagihan/pembayaran.'),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label('Simpan Status Pekerjaan'),

            $this->getCancelFormAction()
                ->label('Batal'),
        ];
    }

    /**
     * Kembali ke menu ASAL (Status SPK), bukan selalu List SPK.
     */
    protected function getRedirectUrl(): string
    {
        $asal = request()->query('asal');

        return match ($asal) {
            'status-spk' => StatusSpkResource::getUrl('index'),
            'tagihan-spk' => TagihanSpkResource::getUrl('index'),
            'tagihan-selesai' => TagihanSelesaiSpkResource::getUrl('index'),
            default => SpkResource::getUrl('index'),
        };
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Status pekerjaan diperbarui')
            ->body('Status SPK '.$this->getRecord()->nomor_spk.' berhasil disimpan.');
    }
}
