<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Enums\Peran;
use App\Models\Pengguna;
use App\Support\ImporTransaksi;
use App\Support\PembacaImpor;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * HALAMAN IMPOR DATA (B3-13) — input massal dari Excel/CSV.
 *
 * ⚠️ KENAPA PERLU:
 * Mempercepat migrasi data awal / input massal. Bersifat **APPEND-ONLY**:
 * hanya menambah baris, tidak pernah mengubah/menghapus data lama, dan
 * **mencegah duplikat** saat berkas yang sama diimpor dua kali.
 */
class ImporDataPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.impor-data';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpTray;

    protected static string|\UnitEnum|null $navigationGroup = 'Sistem';

    protected static ?string $navigationLabel = 'Impor Data';

    protected static ?string $title = 'Impor Data';

    protected static ?int $navigationSort = 3;

    /** @var array<string, mixed> */
    public array $data = [];

    /** @var array{ditambah?: int, dilewati?: int, gagal?: list<string>, jenis?: string}|null */
    public ?array $hasil = null;

    public function getSubheading(): string|Htmlable|null
    {
        return 'Input massal dari Excel/CSV — hanya menambah data, duplikat otomatis dilewati.';
    }

    /**
     * Impor = mengubah data → hanya Admin.
     */
    public static function canAccess(): bool
    {
        /** @var Pengguna|null $user */
        $user = Auth::user();

        return $user?->peran === Peran::Admin;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Radio::make('jenis')
                    ->label('Jenis Data')
                    ->options([
                        'masuk' => 'Uang Masuk',
                        'keluar' => 'Uang Keluar',
                    ])
                    ->default('masuk')
                    ->required()
                    ->inline(),

                FileUpload::make('berkas')
                    ->label('Berkas Excel/CSV')
                    ->acceptedFileTypes([
                        'text/csv',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ])
                    ->disk('local')
                    ->directory('impor')
                    ->required(),
            ])
            ->statePath('data');
    }

    /**
     * @return list<Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('unduhTemplate')
                ->label('Unduh Template CSV')
                ->icon('heroicon-m-arrow-down-tray')
                ->action(fn () => $this->unduhTemplate()),
        ];
    }

    public function proses(): void
    {
        $jenis = $this->data['jenis'] ?? 'masuk';
        $berkas = $this->data['berkas'] ?? null;

        if (blank($berkas)) {
            Notification::make()->title('Pilih berkas terlebih dahulu.')->danger()->send();

            return;
        }

        $path = is_array($berkas) ? reset($berkas) : $berkas;
        $absolut = Storage::disk('local')->path($path);

        if (! is_file($absolut)) {
            Notification::make()->title('Berkas tidak ditemukan.')->danger()->send();

            return;
        }

        $baris = PembacaImpor::baca($absolut);

        $hasil = $jenis === 'keluar'
            ? ImporTransaksi::uangKeluar($baris)
            : ImporTransaksi::uangMasuk($baris);

        $this->hasil = array_merge($hasil, ['jenis' => $jenis]);

        Notification::make()
            ->title('Impor selesai')
            ->body("{$hasil['ditambah']} ditambah · {$hasil['dilewati']} dilewati · ".count($hasil['gagal']).' gagal')
            ->success()
            ->send();
    }

    private function unduhTemplate(): mixed
    {
        $csv = "tanggal,jumlah,akun,kategori,penerima,keterangan\n"
            ."2026-01-05,1500000,Kas,,,Setoran awal\n"
            ."2026-01-06,2500000,Bank,material,Toko A,Beli material\n";

        return response()->streamDownload(function () use ($csv): void {
            echo $csv;
        }, 'template-impor.csv', ['Content-Type' => 'text/csv']);
    }
}
