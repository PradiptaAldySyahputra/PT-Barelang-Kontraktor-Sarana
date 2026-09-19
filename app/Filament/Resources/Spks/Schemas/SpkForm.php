<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Schemas;

use App\Enums\DikerjakanOleh;
use App\Enums\KategoriMitra;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Mitra;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
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

                // ---------------------------------------------------------
                // PELAKSANA PEKERJAAN (permintaan user)
                //
                // Kasus: bangun 5 gardu — 3 dikerjakan sendiri, 2 disubkonkan.
                // Karena schema dibatasi 5 tabel, pekerjaan yang sebagian
                // disubkonkan dibuat sebagai SPK TERPISAH.
                // ---------------------------------------------------------
                Section::make('Pelaksana Pekerjaan')
                    ->description('Tandai apakah SPK ini dikerjakan tim sendiri atau diserahkan ke subkon (kita bayar mereka).')
                    ->schema([
                        Radio::make('dikerjakan_oleh')
                            ->label('Dikerjakan Oleh')
                            ->options(DikerjakanOleh::opsi())
                            ->default(DikerjakanOleh::Sendiri->value)
                            ->required()
                            ->live()
                            ->inline()
                            ->columnSpanFull(),

                        Select::make('subkon_id')
                            ->label('Mitra Subkon')
                            ->options(
                                fn (): array => Mitra::query()
                                    ->where('kategori', KategoriMitra::Subkon->value)
                                    ->orderBy('nama')
                                    ->pluck('nama', 'id')
                                    ->all()
                            )
                            ->searchable()
                            ->preload()
                            ->visible(fn (Get $get): bool => $get('dikerjakan_oleh') === DikerjakanOleh::Subkon->value)
                            ->required(fn (Get $get): bool => $get('dikerjakan_oleh') === DikerjakanOleh::Subkon->value)
                            ->helperText('Belum ada subkon? Tambahkan dulu di menu Data Mitra dengan kategori "Subkon".')
                            ->columnSpanFull(),

                        Placeholder::make('catatan_subkon')
                            ->label('')
                            ->content('Kalau pekerjaan hanya SEBAGIAN disubkonkan (mis. 5 gardu: 3 sendiri, 2 subkon), buat SPK terpisah untuk bagian yang disubkonkan.')
                            ->visible(fn (Get $get): bool => $get('dikerjakan_oleh') === DikerjakanOleh::Subkon->value)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
