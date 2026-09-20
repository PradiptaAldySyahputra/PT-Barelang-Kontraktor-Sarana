<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Pages;

use App\Enums\StatusTagihan;
use App\Filament\Resources\MonitoringSpk\StatusSpkResource;
use App\Filament\Resources\MonitoringSpk\TagihanSelesaiSpkResource;
use App\Filament\Resources\MonitoringSpk\TagihanSpkResource;
use App\Filament\Resources\Spks\SpkResource;
use App\Support\Format;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

/**
 * UBAH STATUS TAGIHAN — form TERPISAH, hanya berisi status tagihan.
 *
 * ⚠️ PERMINATAN USER: status tagihan punya form sendiri, terpisah dari
 * status pekerjaan, dan keduanya saling berkaitan sampai "Tagihan Selesai".
 *
 * Alur: Belum Ditagihkan → Sudah Ditagihkan → Menunggu Pembayaran → Dibayar
 *       (Revisi Dokumen = jalur alternatif saat dokumen perlu diperbaiki)
 *
 * Saat status diubah jadi "Dibayar", SPK otomatis pindah ke menu
 * "Tagihan Selesai SPK" dan TIDAK muncul lagi di "Tagihan SPK".
 *
 * Halaman ini juga bisa dipakai untuk MEMPERBAIKI salah input — misalnya
 * tagihan yang sudah "Dibayar" ternyata salah, bisa dikembalikan statusnya.
 */
class UbahStatusTagihan extends EditRecord
{
    protected static string $resource = SpkResource::class;

    protected static ?string $title = 'Ubah Status Tagihan';

    public function getSubheading(): ?string
    {
        $r = $this->getRecord();

        return $r->nomor_spk.' — '.$r->nama_pekerjaan;
    }

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
                            ->content(Format::rupiah((float) $r->nilai_spk)),

                        Placeholder::make('info_status_spk')
                            ->label('Status Pekerjaan (sekarang)')
                            ->content($r->status_spk?->label() ?? '—'),

                        Placeholder::make('info_diterima')
                            ->label('Sudah Diterima')
                            ->content(Format::rupiah($r->totalPenerimaan())),
                    ])
                    ->columns(2),

                Section::make('Status Tagihan')
                    ->description('Tahapan penagihan sampai pembayaran diterima. Bisa diubah kembali kalau ada salah input.')
                    ->schema([
                        Select::make('status_tagihan')
                            ->label('Status Tagihan')
                            ->options(StatusTagihan::opsi())
                            ->required()
                            ->native(false)
                            ->live()
                            ->helperText('Kalau diubah ke "Dibayar", SPK pindah ke menu Tagihan Selesai SPK.'),

                        TextInput::make('catatan_status')
                            ->label('Catatan Perubahan (opsional)')
                            ->maxLength(255)
                            ->dehydrated(false)
                            ->placeholder('mis. dokumen revisi dikirim ulang 20/9')
                            ->helperText('Catatan ini tidak disimpan — hanya pengingat saat mengisi.')
                            ->visible(fn (Get $get): bool => $get('status_tagihan') === StatusTagihan::RevisiDokumen->value),
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
                ->label('Simpan Status Tagihan'),

            $this->getCancelFormAction()
                ->label('Batal'),
        ];
    }

    /**
     * Kembali ke menu ASAL (Tagihan SPK / Tagihan Selesai), bukan List SPK.
     *
     * ⚠️ PERBAIKAN USER: "misal saya tadi isi form ubah status tapi malah
     * kembali ke list spk jadi perbaiki bagian lain juga."
     */
    protected function getRedirectUrl(): string
    {
        $asal = request()->query('asal');

        return match ($asal) {
            'tagihan-spk' => TagihanSpkResource::getUrl('index'),
            'tagihan-selesai' => TagihanSelesaiSpkResource::getUrl('index'),
            'status-spk' => StatusSpkResource::getUrl('index'),
            default => SpkResource::getUrl('index'),
        };
    }

    protected function getSavedNotification(): ?Notification
    {
        $r = $this->getRecord();

        $body = 'Status tagihan '.$r->nomor_spk.' disimpan.';

        if ($r->status_tagihan === StatusTagihan::Dibayar) {
            $body .= ' SPK ini sekarang ada di menu "Tagihan Selesai SPK".';
        }

        return Notification::make()
            ->success()
            ->title('Status tagihan diperbarui')
            ->body($body);
    }
}
