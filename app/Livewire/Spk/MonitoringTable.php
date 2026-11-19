<?php

declare(strict_types=1);

namespace App\Livewire\Spk;

use App\Enums\StatusAntar;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Spk;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;

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
    /**
     * @var list<string>
     */
    private const URUT_SAH = ['tanggal_akhir', 'tanggal_spk', 'nomor_spk', 'nilai_spk'];

    private const MODE_SAH = ['status', 'billing', 'completed'];

    private const PER_HALAMAN = 50;

    public string $mode = 'status';

    #[Url(as: 'q', except: '')]
    public string $cari = '';

    #[Url(except: '')]
    public string $status = '';

    #[Url(except: '')]
    public string $tagihan = '';

    #[Url(as: 'antar', except: '')]
    public string $antar = '';

    #[Url(as: 'tanggal', except: '')]
    public string $tanggal = '';

    #[Url(as: 'periode', except: '')]
    public string $periode = '';

    #[Url(as: 'semua', except: false)]
    public bool $semua = false;

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
        if (in_array($properti, ['cari', 'status', 'tagihan', 'antar', 'periode'], true)) {
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
        $this->arah = 'asc';
    }

    public function bersihkan(): void
    {
        $this->reset('cari', 'status', 'tagihan', 'antar', 'tanggal', 'periode', 'semua');
    }

    public function render(): View
    {
        $kueri = $this->kueri();

        return view('livewire.spk.monitoring-table', [
            'daftar' => (clone $kueri)
                ->with(['mitra:id,nama', 'subkon:id,nama'])
                ->withSum('uangMasuk as total_masuk', 'jumlah')
                ->orderBy($this->urut, $this->arah)
                ->when(! $this->semua, fn ($q) => $q->limit(self::PER_HALAMAN))
                ->get(),
            'ringkas' => [
                'jumlah' => (clone $kueri)->count(),
            ],
            'opsiStatus' => StatusSpk::opsiProgres(),
            'opsiTagihan' => StatusTagihan::opsiPenagihan(),
            'opsiStatusAntar' => StatusAntar::opsi(),
            'adaPenyaring' => trim($this->cari) !== '' || $this->status !== '' || $this->tagihan !== ''
                || $this->antar !== '' || $this->tanggal !== '' || $this->periode !== '',
            'bolehUbah' => (bool) auth()->user()?->bolehInput(),
            'asal' => match ($this->mode) {
                'billing' => 'tagihan-spk',
                'completed' => 'tagihan-selesai',
                default => 'status-spk',
            },
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
            ->when($this->mode === 'completed', function (Builder $q): void {
                // Arsip lunas: pekerjaan sudah selesai DAN tagihannya sudah dibayar.
                $q->where('status_spk', StatusSpk::Selesai->value)
                    ->where('status_tagihan', StatusTagihan::Dibayar->value);
            })
            ->when(trim($this->cari) !== '', function (Builder $q): void {
                $kata = '%'.trim($this->cari).'%';

                $q->where(function (Builder $w) use ($kata): void {
                    $w->where('nomor_spk', 'like', $kata)
                        ->orWhere('nama_pekerjaan', 'like', $kata)
                        ->orWhere('lokasi', 'like', $kata)
                        ->orWhereHas('mitra', fn (Builder $m) => $m->where('nama', 'like', $kata));
                });
            })
            ->when($this->tanggal !== '', fn (Builder $q) => $q->whereDate('tanggal_spk', $this->tanggal))
            ->when($this->awalPeriode() !== null, fn (Builder $q) => $q->whereDate('tanggal_spk', '>=', $this->awalPeriode()))
            ->when($this->status !== '' && $this->mode === 'status', fn (Builder $q) => $q->where('status_spk', $this->status))
            ->when($this->tagihan !== '' && $this->mode !== 'status', fn (Builder $q) => $q->where('status_tagihan', $this->tagihan))
            ->when($this->antar !== '', fn (Builder $q) => $q->where('status_antar', $this->antar));
    }
}
