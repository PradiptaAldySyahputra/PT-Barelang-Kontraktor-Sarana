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
 * Tabel LIST SPK pada panel Blade (`/panel/spk`).
 *
 * Ini adalah POLA ACUAN untuk tabel-tabel lain (Uang Masuk, Uang Keluar,
 * Mitra, Pengguna): pencarian, penyaring, pengurutan, dan paginasi dikerjakan
 * Livewire di sisi server - TIDAK ada JavaScript kustom.
 *
 * Aturan yang dipegang:
 *   - Keadaan tabel masuk URL (`#[Url]`) supaya tombol Back browser,
 *     bookmark, dan kirim-tautan-ke-rekan kerja tetap berfungsi.
 *   - Nama kolom pengurutan DIVALIDASI terhadap daftar putih
 *     (`URUT_SAH`), karena `?urut=` datang dari luar.
 *   - Baris yang diklik membuka halaman detail SPK (/panel/spk/{id}),
 *     jadi tidak ada fitur yang hilang.
 */
final class SpkTable extends Component
{
    /**
     * Kolom yang boleh dipakai mengurutkan.
     * `?urut=nilai_spk` diterima, `?urut=id;drop` ditolak diam-diam.
     *
     * @var list<string>
     */
    private const URUT_SAH = ['tanggal_spk', 'tanggal_akhir', 'nomor_spk', 'nilai_spk'];

    /** Cap tampilan agar halaman tidak membengkak (pola laporan). */
    private const BATAS_BARIS = 50;

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

    #[Url(except: 'tanggal_spk')]
    public string $urut = 'tanggal_spk';

    #[Url(except: 'desc')]
    public string $arah = 'desc';

    /**
     * Penyaring berubah -> kembali ke halaman 1 (kalau tidak, pengguna
     * bisa terdampar di halaman 9 dari hasil yang tinggal 1 halaman).
     */
    public function updating(string $properti): void
    {
        if (in_array($properti, ['cari', 'status', 'tagihan', 'antar', 'periode'], true)) {
            $this->semua = false;
        }
    }

    /**
     * Klik judul kolom: kolom yang sama membalik arah, kolom lain mulai asc.
     */
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

    /**
     * Tombol "Bersihkan" pada keadaan kosong.
     */
    public function bersihkan(): void
    {
        $this->reset('cari', 'status', 'tagihan', 'antar', 'tanggal', 'periode', 'semua');
    }

    public function render(): View
    {
        $kueri = $this->kueri();

        return view('livewire.spk.spk-table', [
            'daftar' => (clone $kueri)
                ->orderBy($this->urut, $this->arah)
                ->when(! $this->semua, fn ($q) => $q->limit(self::BATAS_BARIS))
                ->get(),
            // Jumlah mengikuti penyaring yang sedang aktif - angka di atas
            // tabel harus sama dengan isi tabel di bawahnya.
            'ringkas' => [
                'jumlah' => (clone $kueri)->count(),
            ],
            'opsiStatus' => StatusSpk::opsiProgres(),
            'opsiTagihan' => StatusTagihan::opsiPenagihan(),
            'opsiStatusAntar' => StatusAntar::opsi(),
            'adaPenyaring' => trim($this->cari) !== '' || $this->status !== '' || $this->tagihan !== ''
                || $this->antar !== '' || $this->tanggal !== '' || $this->periode !== '',
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
     * @return Builder<Spk>
     */
    private function kueri(): Builder
    {
        return Spk::query()
            ->with(['mitra:id,nama', 'subkon:id,nama'])
            ->withCount('uangMasuk')
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
            ->when($this->status !== '', fn (Builder $q) => $q->where('status_spk', $this->status))
            ->when($this->tagihan !== '', fn (Builder $q) => $q->where('status_tagihan', $this->tagihan))
            ->when($this->antar !== '', fn (Builder $q) => $q->where('status_antar', $this->antar));
    }
}
