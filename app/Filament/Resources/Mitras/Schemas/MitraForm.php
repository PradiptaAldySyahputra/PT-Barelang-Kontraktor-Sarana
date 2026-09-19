<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mitras\Schemas;

use App\Enums\KategoriMitra;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Form Mitra — PLN, pelanggan, vendor, subkon.
 */
class MitraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Mitra')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Mitra')
                            ->required()
                            ->maxLength(200)
                            ->placeholder('PT PLN Batam')
                            ->columnSpan(2),

                        Select::make('kategori')
                            ->label('Kategori')
                            ->options(KategoriMitra::opsi())
                            ->required()
                            ->native(false)
                            ->helperText('PLN & Pelanggan = pemberi kerja. Subkon & Vendor = penerima pekerjaan.'),

                        Toggle::make('is_aktif')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Nonaktifkan mitra yang sudah tidak dipakai.'),
                    ])
                    ->columns(2),

                Section::make('Kontak')
                    ->schema([
                        TextInput::make('kontak')
                            ->label('Kontak')
                            ->maxLength(255)
                            ->placeholder('Nama PIC / telepon / email')
                            ->columnSpanFull(),

                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
