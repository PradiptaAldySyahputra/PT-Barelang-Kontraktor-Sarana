<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Pages;

use App\Filament\Resources\Spks\SpkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListSpks extends ListRecords
{
    protected static string $resource = SpkResource::class;

    protected static ?string $title = 'Daftar SPK';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->visible(fn (): bool => SpkResource::bolehUbahData())->label('Tambah SPK'),
        ];
    }

    /**
     * Subjudul halaman — menjelaskan CAKUPAN data & arti tab.
     *
     * Permintaan user (9 Okt 2026): "batasan setiap data tidak jelas jadi user
     * tidak ternavigasi". Subjudul ini menjawab: data apa yang tampil, tab
     * menyaring apa, dan total dihitung dari mana.
     */
    public function getSubheading(): ?string
    {
        return 'Seluruh SPK yang tercatat. Tab menyaring cepat: Berjalan · Belum Lunas · Tanpa SPK. '
            .'Baris Total di bawah tabel menghitung SEMUA baris terfilter — bukan hanya halaman ini.';
    }

    /**
     * Tab filter cepat — memudahkan melihat SPK yang perlu ditindaklanjuti.
     */
    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua'),

            'berjalan' => Tab::make('Berjalan')
                ->modifyQueryUsing(fn (Builder $query) => $query->berjalan())
                ->badge(fn (): int => SpkResource::getModel()::berjalan()->count()),

            'belum_lunas' => Tab::make('Belum Lunas')
                ->modifyQueryUsing(fn (Builder $query) => $query->belumLunas())
                ->badge(fn (): int => SpkResource::getModel()::belumLunas()->count()),

            'tanpa_spk' => Tab::make('Tanpa SPK')
                ->modifyQueryUsing(fn (Builder $query) => $query->tanpaSpk()),
        ];
    }
}
