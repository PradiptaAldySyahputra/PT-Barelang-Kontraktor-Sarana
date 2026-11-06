<?php

declare(strict_types=1);

namespace App\Livewire\CashIn;

use App\Enums\AkunKas;
use App\Models\Mitra;
use App\Models\UangMasuk;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Tabel daftar Uang Masuk (`/panel/cash-in`).
 *
 * Pengganti `UangMasuksTable` Filament. Yang dipertahankan:
 *   - SATU baris total terfilter di atas tabel (bukan total ganda)
 *   - filter PERIODE (dari/sampai) + akun + sumber + data terhapus
 *   - kolom "Sumber" disimpulkan dari spk_id, bukan kolom tersimpan
 *   - soft delete: data terhapus bisa dilihat & dipulihkan
 */
final class CashInTable extends Component
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
    public string $sumber = '';

    #[Url(except: 'aktif')]
    public string $terhapus = 'aktif';

    #[Url(except: 'tanggal')]
    public string $urut = 'tanggal';

    #[Url(except: 'desc')]
    public string $arah = 'desc';

    public function updating(string $properti): void
    {
        if (in_array($properti, ['cari', 'dari', 'sampai', 'akun', 'sumber', 'terhapus'], true)) {
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
        $this->reset('cari', 'dari', 'sampai', 'akun', 'sumber', 'terhapus');
        $this->resetPage();
    }

    public function render(): View
    {
        $kueri = $this->kueri();

        return view('livewire.cash-in.cash-in-table', [
            'daftar' => (clone $kueri)
                ->with(['spk:id,nomor_spk,nama_pekerjaan', 'mitra:id,nama'])
                ->orderBy($this->urut, $this->arah)
                ->paginate(self::PER_HALAMAN),
            'ringkas' => [
                'jumlah' => (clone $kueri)->count(),
                'total' => (float) (clone $kueri)->sum('jumlah'),
            ],
            'opsiAkun' => AkunKas::opsi(),
            'daftarMitra' => Mitra::query()->orderBy('nama')->pluck('nama', 'id')->all(),
            'adaPenyaring' => $this->adaPenyaring(),
            'bolehUbah' => (bool) auth()->user()?->bolehInput(),
        ]);
    }

    private function adaPenyaring(): bool
    {
        return trim($this->cari) !== ''
            || $this->dari !== ''
            || $this->sampai !== ''
            || $this->akun !== ''
            || $this->sumber !== ''
            || $this->terhapus !== 'aktif';
    }

    /**
     * @return Builder<UangMasuk>
     */
    private function kueri(): Builder
    {
        return UangMasuk::query()
            ->when($this->terhapus === 'aktif', fn (Builder $q) => $q->whereNull('deleted_at'))
            ->when($this->terhapus === 'saja', fn (Builder $q) => $q->onlyTrashed())
            ->when($this->dari !== '', fn (Builder $q) => $q->whereDate('tanggal', '>=', $this->dari))
            ->when($this->sampai !== '', fn (Builder $q) => $q->whereDate('tanggal', '<=', $this->sampai))
            ->when($this->akun !== '', fn (Builder $q) => $q->where('akun', $this->akun))
            ->when($this->sumber === 'spk', fn (Builder $q) => $q->whereNotNull('spk_id'))
            ->when($this->sumber === 'luar', fn (Builder $q) => $q->whereNull('spk_id'))
            ->when(trim($this->cari) !== '', function (Builder $q): void {
                $kata = '%'.trim($this->cari).'%';

                $q->where(function (Builder $w) use ($kata): void {
                    $w->where('nomor_spk', 'like', $kata)
                        ->orWhere('nama_pekerjaan', 'like', $kata)
                        ->orWhere('keterangan', 'like', $kata)
                        ->orWhereHas('mitra', fn (Builder $m) => $m->where('nama', 'like', $kata));
                });
            });
    }
}
