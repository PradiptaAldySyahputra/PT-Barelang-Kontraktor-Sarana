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

/**
 * Tabel daftar Uang Masuk (`/panel/cash-in`).
 *
 * Pengganti `UangMasuksTable` Filament. Yang dipertahankan:
 *   - SATU baris total terfilter di atas tabel (bukan total ganda)
 *   - filter satu tanggal + akun + sumber
 *   - kolom "Sumber" disimpulkan dari spk_id, bukan kolom tersimpan
 *   - soft delete: data terhapus bisa dilihat & dipulihkan
 */
final class CashInTable extends Component
{
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
    public string $sumber = '';

    #[Url(except: 'aktif')]
    public string $terhapus = 'aktif';

    #[Url(except: 'tanggal')]
    public string $urut = 'tanggal';

    #[Url(except: 'desc')]
    public string $arah = 'desc';

    public function updating(string $properti): void
    {
        if (in_array($properti, ['cari', 'tanggal', 'periode', 'akun', 'sumber', 'terhapus'], true)) {
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
        $this->reset('cari', 'tanggal', 'periode', 'akun', 'sumber', 'terhapus', 'semua');
    }

    public function render(): View
    {
        $kueri = $this->kueri();

        return view('livewire.cash-in.cash-in-table', [
            'daftar' => (clone $kueri)
                ->with(['spk:id,nomor_spk,nama_pekerjaan', 'mitra:id,nama'])
                ->orderBy($this->urut, $this->arah)
                ->when(! $this->semua, fn ($q) => $q->limit(self::BATAS_BARIS))
                ->get(),
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
            || $this->tanggal !== ''
            || $this->periode !== ''
            || $this->akun !== ''
            || $this->sumber !== ''
            || $this->terhapus !== 'aktif';
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
     * @return Builder<UangMasuk>
     */
    private function kueri(): Builder
    {
        return UangMasuk::query()
            ->when($this->terhapus === 'aktif', fn (Builder $q) => $q->whereNull('deleted_at'))
            ->when($this->terhapus === 'saja', fn (Builder $q) => $q->onlyTrashed())
            ->when($this->tanggal !== '', fn (Builder $q) => $q->whereDate('tanggal', $this->tanggal))
            ->when($this->awalPeriode() !== null, fn (Builder $q) => $q->whereDate('tanggal', '>=', $this->awalPeriode()))
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
