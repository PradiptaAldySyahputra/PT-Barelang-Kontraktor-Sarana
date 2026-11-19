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

/**
 * Tabel daftar Uang Keluar (`/panel/cash-out`).
 *
 * Sama seperti Uang Masuk: total terfilter di atas tabel, filter PERIODE
 * (satu tanggal) + akun + kategori + sumber, dan soft delete yang bisa
 * dipulihkan. Form input dengan OCR nota masih memakai /admin sampai
 * migrasinya selesai (lihat docs/RENCANA-MIGRASI-BLADE.md).
 */
final class CashOutTable extends Component
{
    /**
     * @var list<string>
     */
    private const URUT_SAH = ['tanggal', 'jumlah', 'created_at'];

    /** Cap tampilan agar halaman tidak membengkak (pola laporan). */
    private const BATAS_BARIS = 50;

    #[Url(as: 'q', except: '')]
    public string $cari = '';

    #[Url(as: 'tanggal', except: '')]
    public string $tanggal = '';

    #[Url(as: 'periode', except: '')]
    public string $periode = '';

    #[Url(as: 'semua', except: false)]
    public bool $semua = false;

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
        if (in_array($properti, ['cari', 'tanggal', 'periode', 'akun', 'kategori', 'sumber', 'terhapus'], true)) {
            $this->semua = false;
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
        $this->reset('cari', 'tanggal', 'periode', 'akun', 'kategori', 'sumber', 'terhapus', 'semua');
    }

    public function render(): View
    {
        $kueri = $this->kueri();

        return view('livewire.cash-out.cash-out-table', [
            'daftar' => (clone $kueri)
                ->with(['spk:id,nomor_spk'])
                ->orderBy($this->urut, $this->arah)
                ->when(! $this->semua, fn ($q) => $q->limit(self::BATAS_BARIS))
                ->get(),
            'ringkas' => [
                'jumlah' => (clone $kueri)->count(),
                'total' => (float) (clone $kueri)->sum('jumlah'),
            ],
            'opsiAkun' => AkunKas::opsi(),
            'opsiKategori' => KategoriPengeluaran::opsi(),
            'adaPenyaring' => trim($this->cari) !== ''
                || $this->tanggal !== ''
                || $this->periode !== ''
                || $this->akun !== ''
                || $this->kategori !== ''
                || $this->sumber !== ''
                || $this->terhapus !== 'aktif',
            'bolehUbah' => (bool) auth()->user()?->bolehInput(),
        ]);
    }

    /** Tanggal awal dari preset periode ('' = tanpa batas, semua data). */
    private function awalPeriode(): ?string
    {
        return match ($this->periode) {
            'hari-ini' => now()->format('Y-m-d'),
            '7-hari' => now()->subDays(6)->format('Y-m-d'),
            'bulan' => now()->startOfMonth()->format('Y-m-d'),
            'tahun' => now()->startOfYear()->format('Y-m-d'),
            default => null,
        };
    }

    /**
     * @return Builder<UangKeluar>
     */
    private function kueri(): Builder
    {
        return UangKeluar::query()
            ->when($this->terhapus === 'aktif', fn (Builder $q) => $q->whereNull('deleted_at'))
            ->when($this->terhapus === 'saja', fn (Builder $q) => $q->onlyTrashed())
            ->when($this->tanggal !== '', fn (Builder $q) => $q->whereDate('tanggal', $this->tanggal))
            ->when($this->awalPeriode() !== null, fn (Builder $q) => $q->whereDate('tanggal', '>=', $this->awalPeriode()))
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
