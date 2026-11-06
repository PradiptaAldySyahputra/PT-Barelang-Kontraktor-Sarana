<?php

declare(strict_types=1);

namespace App\Livewire\CashOut;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Models\UangKeluar;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Tabel daftar Uang Keluar (`/panel/cash-out`).
 *
 * Sama seperti Uang Masuk: total terfilter di atas tabel, filter PERIODE
 * (dari/sampai) + akun + kategori + sumber, dan soft delete yang bisa
 * dipulihkan. Form input dengan OCR nota masih memakai /admin sampai
 * migrasinya selesai (lihat docs/RENCANA-MIGRASI-BLADE.md).
 */
final class CashOutTable extends Component
{
    use WithPagination;

    /**
     * @var list<string>
     */
    private const URUT_SAH = ['tanggal', 'jumlah', 'created_at'];

    private const PER_HALAMAN = 15;

    #[Url(as: 'q', except: '')]
    public string $cari = '';

    #[Url(as: 'dari', except: '')]
    public string $dari = '';

    #[Url(as: 'sampai', except: '')]
    public string $sampai = '';

    #[Url(except: '')]
    public string $akun = '';

    #[Url(except: '')]
    public string $kategori = '';

    #[Url(except: '')]
    public string $sumber = '';

    #[Url(except: 'aktif')]
    public string $terhapus = 'aktif';

    #[Url(except: 'tanggal')]
    public string $urut = 'tanggal';

    #[Url(except: 'desc')]
    public string $arah = 'desc';

    public function updating(string $properti): void
    {
        if (in_array($properti, ['cari', 'dari', 'sampai', 'akun', 'kategori', 'sumber', 'terhapus'], true)) {
            $this->resetPage();
        }
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
        $this->arah = 'desc';
    }

    public function bersihkan(): void
    {
        $this->reset('cari', 'dari', 'sampai', 'akun', 'kategori', 'sumber', 'terhapus');
        $this->resetPage();
    }

    public function render(): View
    {
        $kueri = $this->kueri();

        return view('livewire.cash-out.cash-out-table', [
            'daftar' => (clone $kueri)
                ->with(['spk:id,nomor_spk'])
                ->orderBy($this->urut, $this->arah)
                ->paginate(self::PER_HALAMAN),
            'ringkas' => [
                'jumlah' => (clone $kueri)->count(),
                'total' => (float) (clone $kueri)->sum('jumlah'),
            ],
            'opsiAkun' => AkunKas::opsi(),
            'opsiKategori' => KategoriPengeluaran::opsi(),
            'adaPenyaring' => trim($this->cari) !== ''
                || $this->dari !== ''
                || $this->sampai !== ''
                || $this->akun !== ''
                || $this->kategori !== ''
                || $this->sumber !== ''
                || $this->terhapus !== 'aktif',
            'bolehUbah' => (bool) auth()->user()?->bolehInput(),
        ]);
    }

    /**
     * @return Builder<UangKeluar>
     */
    private function kueri(): Builder
    {
        return UangKeluar::query()
            ->when($this->terhapus === 'aktif', fn (Builder $q) => $q->whereNull('deleted_at'))
            ->when($this->terhapus === 'saja', fn (Builder $q) => $q->onlyTrashed())
            ->when($this->dari !== '', fn (Builder $q) => $q->whereDate('tanggal', '>=', $this->dari))
            ->when($this->sampai !== '', fn (Builder $q) => $q->whereDate('tanggal', '<=', $this->sampai))
            ->when($this->akun !== '', fn (Builder $q) => $q->where('akun', $this->akun))
            ->when($this->kategori !== '', fn (Builder $q) => $q->where('kategori', $this->kategori))
            ->when($this->sumber === 'spk', fn (Builder $q) => $q->whereNotNull('spk_id'))
            ->when($this->sumber === 'luar', fn (Builder $q) => $q->whereNull('spk_id'))
            ->when(trim($this->cari) !== '', function (Builder $q): void {
                $kata = '%'.trim($this->cari).'%';

                $q->where(function (Builder $w) use ($kata): void {
                    $w->where('keterangan', 'like', $kata)
                        ->orWhere('penerima', 'like', $kata)
                        ->orWhere('detail_kategori', 'like', $kata)
                        ->orWhereHas('spk', fn (Builder $s) => $s->where('nomor_spk', 'like', $kata));
                });
            });
    }
}
