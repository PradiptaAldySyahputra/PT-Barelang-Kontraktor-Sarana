<?php

declare(strict_types=1);

namespace App\Filament\Resources\Penggunas\Schemas;

use App\Enums\Peran;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Password;

/**
 * Form Pengguna — akun Admin & Direktur.
 */
class PenggunaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Akun')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(200),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(200)
                            ->unique(ignoreRecord: true)
                            ->helperText('Dipakai untuk login.'),

                        Select::make('peran')
                            ->label('Peran')
                            ->options(Peran::opsi())
                            ->required()
                            ->native(false)
                            ->helperText('Admin = boleh input data. Direktur = hanya melihat.'),

                        Toggle::make('is_aktif')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Akun nonaktif tidak bisa login.'),
                    ])
                    ->columns(2),

                Section::make('Password')
                    ->description('Kosongkan saat mengubah data jika password tidak diganti.')
                    ->schema([
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            // ⚠️ PAKAI aturan TERPUSAT (`Password::default()`) —
                            // jangan `->minLength(8)` sendiri. Sebelumnya password
                            // "12345678" (angka saja) LOLOS di sini padahal ditolak
                            // di Profil/Lupa Password → kebijakan jadi tidak seragam.
                            ->rule(Password::default())
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->helperText('Minimal 8 karakter, kombinasi huruf & angka.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
