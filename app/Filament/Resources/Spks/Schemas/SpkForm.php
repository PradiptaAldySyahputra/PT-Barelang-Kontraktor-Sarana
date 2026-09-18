<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Schemas;

use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

/**
 * Form SPK.
 *
 * CATATAN PENTING (keputusan user 19 Sep 2026):
 *   - `pic`        TIDAK ADA
 *   - `keterangan` TIDAK ADA
 *   - `tanggal_akhir` ADA (revisi user)
 *
 * `status_spk` & `status_tagihan` WAJIB dropdown dari Enum — bukan input bebas.
 * Ini mencegah laporan terpecah (lihat Schema.md §7).
 */
class SpkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data SPK')
                    ->description('Nomor SPK wajib unik. Untuk pekerjaan tanpa surat resmi, isi nomor dengan "TANPA SPK" dan biarkan tanggal kosong.')
                    ->schema([
                        TextInput::make('nomor_spk')
                            ->label('Nomor SPK')
                            ->required()
                            ->maxLength(150)
                            ->unique(ignoreRecord: true)
                            ->placeholder('SPK-CONTOH-D'),

                        DatePicker::make('tanggal_spk')
                            ->label('Tanggal SPK')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->helperText('Kosongkan jika TANPA SPK'),

                        DatePicker::make('tanggal_akhir')
                            ->label('Tanggal Akhir SPK')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->afterOrEqual('tanggal_spk')
                            ->helperText('Batas akhir pekerjaan'),
                    ])
                    ->columns(3),

                Section::make('Pekerjaan')
                    ->schema([
                        TextInput::make('nama_pekerjaan')
                            ->label('Nama Pekerjaan')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('lokasi')
                            ->label('Lokasi')
                            ->maxLength(255),

                        Select::make('mitra_id')
                            ->label('Pemberi Kerja / Mitra')
                            ->relationship('mitra', 'nama')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),

                Section::make('Nilai & Retensi')
                    ->description('Retensi dihitung otomatis dari nilai SPK × persen retensi. Isi 5% untuk SPK subkon/vendor.')
                    ->schema([
                        TextInput::make('nilai_spk')
                            ->label('Nilai SPK (Rp)')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix('Rp')
                            ->mask(RawJs::make('$money($input, \',\', \'.\')'))
                            ->stripCharacters('.')
                            ->dehydrateStateUsing(fn ($state): float => (float) $state),

                        TextInput::make('persen_retensi')
                            ->label('Persen Retensi (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->helperText('Contoh: 5 untuk SPK subkon'),

                        TextInput::make('nilai_retensi')
                            ->label('Nilai Retensi (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Terhitung otomatis'),
                    ])
                    ->columns(3),

                Section::make('Status & Klasifikasi')
                    ->schema([
                        Select::make('status_spk')
                            ->label('Status SPK')
                            ->options(StatusSpk::opsi())
                            ->required()
                            ->native(false),

                        Select::make('status_tagihan')
                            ->label('Status Tagihan')
                            ->options(StatusTagihan::opsi())
                            ->native(false),

                        Select::make('jenis_sumber')
                            ->label('Jenis Sumber')
                            ->options([
                                'pln' => 'PLN',
                                'luar' => 'Luar',
                                'internal' => 'Internal',
                                'lainnya' => 'Lainnya',
                            ])
                            ->native(false),

                        TextInput::make('sheet_lama')
                            ->label('Sheet Lama (referensi Excel)')
                            ->maxLength(100)
                            ->helperText('Opsional — untuk keperluan migrasi data lama'),
                    ])
                    ->columns(2),
            ]);
    }
}
