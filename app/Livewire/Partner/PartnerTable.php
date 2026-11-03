<?php

declare(strict_types=1);

namespace App\Livewire\Partner;

use App\Enums\KategoriMitra;
use App\Models\Mitra;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Tabel daftar Mitra (`/panel/partners`).
 *
 * Sesuai ListMitras & MitrasTable di Filament:
 *   - 3 tab: Semua · Mitra (Pemberi Kerja) · Subkon
 *   - Pencarian di nama, kontak, alamat
 *   - Tanpa dropdown filter duplikat yang bertabrakan dengan tab
 *   - Hanya Admin yang boleh menambah/mengubah/menghapus
 */
final class PartnerTable extends Component
{
    use WithPagination;

    /**
     * @var list<string>
     */
    private const URUT_SAH = ['nama', 'kategori', 'created_at'];

    /**
     * @var list<string>
     */
    private const TAB_SAH = ['semua', 'mitra', 'subkon'];

    private const PER_HALAMAN = 15;

    #[Url(as: 'q', except: '')]
    public string $cari = '';

    #[Url(except: 'semua')]
    public string $tab = 'semua';

    #[Url(except: 'nama')]
    public string $urut = 'nama';

    #[Url(except: 'asc')]
    public string $arah = 'asc';

    public function updating(string $properti): void
    {
        if (in_array($properti, ['cari', 'tab'], true)) {
            $this->resetPage();
        }
    }

    public function pilihTab(string $tab): void
    {
        if (! in_array($tab, self::TAB_SAH, true)) {
            return;
        }

        $this->tab = $tab;
        $this->resetPage();
    }

    public function urutkan(string $kolom): void
    {
        if (! in_array($kolom, self::URUT_SAH, true)) {
            return;
        }

        if ($this->urut === $kolom) {
            $this->arah = $this->arah === 'asc' ? 'desc' : 'asc';

            return;
        }

        $this->urut = $kolom;
        $this->arah = 'asc';
    }

    public function bersihkan(): void
    {
        $this->reset('cari', 'tab');
        $this->resetPage();
    }

    public function render(): View
    {
        $kueri = $this->kueri();

        return view('livewire.partner.partner-table', [
            'daftar' => (clone $kueri)
                ->withCount('spk')
                ->orderBy($this->urut, $this->arah)
                ->paginate(self::PER_HALAMAN),
            'jumlahTab' => [
                'semua' => Mitra::query()->count(),
                'mitra' => Mitra::query()->where('kategori', KategoriMitra::Mitra->value)->count(),
                'subkon' => Mitra::query()->where('kategori', KategoriMitra::Subkon->value)->count(),
            ],
            'adaPenyaring' => trim($this->cari) !== '' || $this->tab !== 'semua',
            'bolehUbah' => (bool) auth()->user()?->bolehInput(),
        ]);
    }

    /**
     * @return Builder<Mitra>
     */
    private function kueri(): Builder
    {
        return Mitra::query()
            ->when(
                in_array($this->tab, ['mitra', 'subkon'], true),
                fn (Builder $q) => $q->where('kategori', $this->tab),
            )
            ->when(trim($this->cari) !== '', function (Builder $q): void {
                $kata = '%'.trim($this->cari).'%';

                $q->where(function (Builder $w) use ($kata): void {
                    $w->where('nama', 'like', $kata)
                        ->orWhere('kontak', 'like', $kata)
                        ->orWhere('alamat', 'like', $kata);
                });
            });
    }
}
