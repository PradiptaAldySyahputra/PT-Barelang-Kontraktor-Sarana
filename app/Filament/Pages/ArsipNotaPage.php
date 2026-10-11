<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Support\ArsipNota;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

/**
 * HALAMAN ARSIP NOTA (B2-7).
 *
 * ⚠️ KENAPA PERLU:
 * Menggantikan penelusuran folder manual (`D:\NOTA BKS\2026\8. AGUSTUS\1`).
 * Admin memfilter per tanggal/periode/akun/kategori/kata kunci, lalu:
 *   - mengunduh satu nota, atau
 *   - mengunduh SEMUA hasil filter sebagai ZIP.
 *
 * Tombol unduh & ZIP memakai route biasa (bukan aksi Livewire) supaya andal
 * mengirim berkas. Lihat routes/web.php.
 */
class ArsipNotaPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.arsip-nota';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolderOpen;

    protected static string|\UnitEnum|null $navigationGroup = 'Keuangan';

    protected static ?string $navigationLabel = 'Arsip Nota';

    protected static ?string $title = 'Arsip Nota';

    protected static ?int $navigationSort = 3;

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'tanggal_awal' => now()->startOfMonth()->toDateString(),
            'tanggal_akhir' => now()->toDateString(),
        ]);
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Cari & unduh nota berdasarkan tanggal, akun, kategori, atau kata kunci.';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('tanggal_awal')->label('Dari Tanggal')->native(false),
                DatePicker::make('tanggal_akhir')->label('Sampai Tanggal')->native(false),
                Select::make('akun')->label('Akun')->options(AkunKas::opsi())->placeholder('Semua'),
                Select::make('kategori')->label('Kategori')->options(KategoriPengeluaran::opsi())->placeholder('Semua'),
                TextInput::make('q')->label('Kata Kunci')->placeholder('Penerima / keterangan'),
            ])
            ->columns(5)
            ->statePath('data');
    }

    /**
     * Hasil pencarian (dipanggil saat render).
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $arsip = ArsipNota::cari($this->data);

        return [
            'arsip' => $arsip,
            'jumlah' => $arsip->count(),
            'jumlahAda' => $arsip->where('ada', true)->count(),
        ];
    }
}
