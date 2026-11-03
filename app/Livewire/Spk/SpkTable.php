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
 *   - Baris yang diklik tetap menuju halaman Filament selama masa transisi,
 *     jadi tidak ada fitur yang hilang saat dipakai.
 */
final class SpkTable extends Component
{
    use WithPagination;

    /**
     * Kolom yang boleh dipakai mengurutkan.
     * `?urut=nilai_spk` diterima, `?urut=id;drop` ditolak diam-diam.
     *
     * @var list<string>
     */
    private const URUT_SAH = ['tanggal_spk', 'tanggal_akhir', 'nomor_spk', 'nilai_spk'];

    private const PER_HALAMAN = 15;

    #[Url(as: 'q', except: '')]
    public string $cari = '';

    #[Url(except: '')]
    public string $status = '';

    #[Url(except: '')]
    public string $tagihan = '';

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
        if (in_array($properti, ['cari', 'status', 'tagihan'], true)) {
            $this->resetPage();
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
        $this->reset('cari', 'status', 'tagihan');
        $this->resetPage();
    }

    public function render(): View
    {
        $kueri = $this->kueri();

        return view('livewire.spk.spk-table', [
            'daftar' => (clone $kueri)
                ->orderBy($this->urut, $this->arah)
                ->paginate(self::PER_HALAMAN),
            // Ringkasan mengikuti penyaring yang sedang aktif - angka di
            // atas tabel harus sama dengan isi tabel di bawahnya.
            'ringkas' => [
                'jumlah' => (clone $kueri)->count(),
                'nilai' => (float) (clone $kueri)->sum('nilai_spk'),
            ],
            'opsiStatus' => StatusSpk::opsi(),
            'opsiTagihan' => StatusTagihan::opsi(),
            'adaPenyaring' => trim($this->cari) !== '' || $this->status !== '' || $this->tagihan !== '',
            'bolehUbah' => (bool) auth()->user()?->bolehInput(),
        ]);
    }

    /**
     * @return Builder<Spk>
     */
    private function kueri(): Builder
    {
        return Spk::query()
            ->with(['mitra:id,nama', 'subkon:id,nama'])
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
