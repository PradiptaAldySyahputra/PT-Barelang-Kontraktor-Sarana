<?php

declare(strict_types=1);

namespace App\Livewire\Spk;

use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Spk;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Tiga menu monitoring SPK dalam SATU komponen — bedanya hanya penyaring:
 *
 *   status    → Status SPK          : semua SPK, urut tenggat terdekat
 *   billing   → Tagihan SPK         : status tagihan != Dibayar
 *   completed → Tagihan Selesai SPK : status tagihan = Dibayar
 *
 * Satu komponen, tiga mode: perilaku tabel (cari, urut, paginasi) identik,
 * jadi menyalinnya tiga kali hanya menambah tempat bug.
 */
final class MonitoringTable extends Component
{
    use WithPagination;

    /**
     * @var list<string>
     */
    private const URUT_SAH = ['tanggal_akhir', 'tanggal_spk', 'nomor_spk', 'nilai_spk'];

    private const MODE_SAH = ['status', 'billing', 'completed'];

    private const PER_HALAMAN = 15;

    public string $mode = 'status';

    #[Url(as: 'q', except: '')]
    public string $cari = '';

    #[Url(except: '')]
    public string $status = '';

    #[Url(except: '')]
    public string $tagihan = '';

    #[Url(except: 'tanggal_akhir')]
    public string $urut = 'tanggal_akhir';

    #[Url(except: 'asc')]
    public string $arah = 'asc';

    public function mount(string $mode = 'status'): void
    {
        $this->mode = in_array($mode, self::MODE_SAH, true) ? $mode : 'status';
    }

    public function updating(string $properti): void
    {
        if (in_array($properti, ['cari', 'status', 'tagihan'], true)) {
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
        $this->arah = 'asc';
    }

    public function bersihkan(): void
    {
        $this->reset('cari', 'status', 'tagihan');
        $this->resetPage();
    }

    public function render(): View
    {
        $kueri = $this->kueri();

        return view('livewire.spk.monitoring-table', [
            'daftar' => (clone $kueri)
                ->with(['mitra:id,nama', 'subkon:id,nama'])
                ->orderBy($this->urut, $this->arah)
                ->paginate(self::PER_HALAMAN),
            'ringkas' => [
                'jumlah' => (clone $kueri)->count(),
                'nilai' => (float) (clone $kueri)->sum('nilai_spk'),
            ],
            'opsiStatus' => StatusSpk::opsi(),
            'opsiTagihan' => StatusTagihan::opsi(),
            'adaPenyaring' => trim($this->cari) !== '' || $this->status !== '' || $this->tagihan !== '',
            'bolehUbah' => (bool) auth()->user()?->bolehInput(),
            'asal' => match ($this->mode) {
                'billing' => 'tagihan-spk',
                'completed' => 'tagihan-selesai',
                default => 'status-spk',
            },
        ]);
    }

    /**
     * @return Builder<Spk>
     */
    private function kueri(): Builder
    {
        return Spk::query()
            ->when($this->mode === 'billing', function (Builder $q): void {
                $q->where(function (Builder $w): void {
                    $w->where('status_tagihan', '!=', StatusTagihan::Dibayar->value)
                        ->orWhereNull('status_tagihan');
                });
            })
            ->when($this->mode === 'completed', fn (Builder $q) => $q->where('status_tagihan', StatusTagihan::Dibayar->value))
            ->when(trim($this->cari) !== '', function (Builder $q): void {
                $kata = '%'.trim($this->cari).'%';

                $q->where(function (Builder $w) use ($kata): void {
                    $w->where('nomor_spk', 'like', $kata)
                        ->orWhere('nama_pekerjaan', 'like', $kata)
                        ->orWhere('lokasi', 'like', $kata)
                        ->orWhereHas('mitra', fn (Builder $m) => $m->where('nama', 'like', $kata));
                });
            })
            ->when($this->status !== '', fn (Builder $q) => $q->where('status_spk', $this->status))
            ->when($this->tagihan !== '', fn (Builder $q) => $q->where('status_tagihan', $this->tagihan));
    }
}