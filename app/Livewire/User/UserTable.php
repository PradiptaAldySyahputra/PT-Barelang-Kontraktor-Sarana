<?php

declare(strict_types=1);

namespace App\Livewire\User;

use App\Enums\Peran;
use App\Models\Pengguna;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Tabel daftar Pengguna (`/panel/users`).
 *
 * Hak akses (permintaan pemilik sistem, 19 Sep 2026): HANYA Direktur.
 * Alasan: pengelolaan akun menyangkut hak akses sistem.
 *
 * ⚠️ PENGAMAN SISTEM TERKUNCI: akun yang sedang login TIDAK boleh diubah
 * atau dihapus dari tabel ini - kalau tidak, Direktur bisa mengunci dirinya
 * sendiri dan tidak ada yang bisa mengembalikan akses.
 */
final class UserTable extends Component
{
    use WithPagination;

    /**
     * @var list<string>
     */
    private const URUT_SAH = ['nama', 'email', 'created_at'];

    /**
     * @var list<string>
     */
    private const TAB_SAH = ['semua', 'admin', 'direktur', 'nonaktif'];

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
        abort_unless(auth()->user()?->isDirektur() === true, 403);

        $kueri = $this->kueri();

        return view('livewire.user.user-table', [
            'daftar' => (clone $kueri)
                ->withCount('spkDibuat')
                ->orderBy($this->urut, $this->arah)
                ->paginate(self::PER_HALAMAN),
            'jumlahTab' => [
                'semua' => Pengguna::query()->count(),
                'admin' => Pengguna::query()->where('peran', Peran::Admin->value)->count(),
                'direktur' => Pengguna::query()->where('peran', Peran::Direktur->value)->count(),
                'nonaktif' => Pengguna::query()->where('is_aktif', false)->count(),
            ],
            'adaPenyaring' => trim($this->cari) !== '' || $this->tab !== 'semua',
            'idDiriSendiri' => auth()->id(),
        ]);
    }

    /**
     * @return Builder<Pengguna>
     */
    private function kueri(): Builder
    {
        return Pengguna::query()
            ->when($this->tab === 'admin', fn (Builder $q) => $q->where('peran', Peran::Admin->value))
            ->when($this->tab === 'direktur', fn (Builder $q) => $q->where('peran', Peran::Direktur->value))
            ->when($this->tab === 'nonaktif', fn (Builder $q) => $q->where('is_aktif', false))
            ->when(trim($this->cari) !== '', function (Builder $q): void {
                $kata = '%'.trim($this->cari).'%';

                $q->where(function (Builder $w) use ($kata): void {
                    $w->where('nama', 'like', $kata)
                        ->orWhere('email', 'like', $kata);
                });
            });
    }
}
