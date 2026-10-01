<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mitras\Pages;

use App\Enums\KategoriMitra;
use App\Filament\Resources\Mitras\MitraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListMitras extends ListRecords
{
    protected static string $resource = MitraResource::class;

    protected static ?string $title = 'Daftar Mitra';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->visible(fn (): bool => MitraResource::bolehUbahData())->label('Tambah Mitra'),
        ];
    }

    /**
     * Tab menu Mitra — TEPAT TIGA: Semua · PLN · Subkon.
     *
     * ⚠️ PERMINTAAN PENGGUNA (26 Sep 2026):
     * "di filter menu mitra kenapa anda buat jadi banyak filter navbarnya
     *  buat semua, pln, subkon saja"
     *
     * ⚠️ RIWAYAT BUG (dua kali):
     * 1. Versi awal punya 4 tab (Semua/Aktif/PLN/Subkon & Vendor) — terlalu
     *    banyak untuk data yang hanya 2 kategori.
     * 2. Tab "PLN" menyaring `kategori = 'pln'`, dan "Subkon & Vendor"
     *    menyaring `['subkon','vendor']` — padahal nilai 'pln' & 'vendor'
     *    SUDAH TIDAK ADA di KategoriMitra (hanya `mitra` & `subkon`).
     *    Akibatnya kedua tab itu SELALU KOSONG.
     *
     * PENJELASAN (sesuai keputusan pengguna): PLN DILEBUR ke kategori `mitra`
     * sebagai pemberi kerja. Jadi:
     *   - tab "PLN"   → kategori `mitra` (pemberi kerja, termasuk PT PLN Batam)
     *   - tab "Subkon"→ kategori `subkon` (rekanan pelaksana)
     *
     * Filter kategori & aktif TIDAK dipasang sebagai dropdown karena sudah
     * diwakili tab — mencegah dua tempat yang bisa saling bertentangan.
     */
    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua')
                ->badge(fn (): int => MitraResource::getModel()::query()->count()),

            'pln' => Tab::make('PLN')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('kategori', KategoriMitra::Mitra->value))
                ->badge(fn (): int => MitraResource::getModel()::query()
                    ->where('kategori', KategoriMitra::Mitra->value)->count()),

            'subkon' => Tab::make('Subkon')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('kategori', KategoriMitra::Subkon->value))
                ->badge(fn (): int => MitraResource::getModel()::query()
                    ->where('kategori', KategoriMitra::Subkon->value)->count()),
        ];
    }
}
