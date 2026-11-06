<?php

declare(strict_types=1);

namespace App\Livewire\CashOut;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Services\PembacaNota;
use App\Services\PenyimpanBerkas;
use App\Support\Format;
use App\Support\SaldoKas;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

/**
 * Form Uang Keluar — beberapa baris sekaligus, tiap baris punya berkas nota
 * sendiri (permintaan pemilik sistem: admin biasanya memegang 4 nota sekaligus).
 *
 * Satu baris = satu record `uang_keluar`. Semua baris disimpan dalam SATU
 * transaksi, jadi tidak ada kondisi setengah tersimpan.
 *
 * OCR: tombol "Isi dari OCR" per baris memakai `PembacaNota` yang sama dengan
 * Filament. OCR hanya BANTUAN — hasilnya selalu bisa (dan boleh) dikoreksi
 * admin, karena satu berkas bisa berisi beberapa nota.
 */
final class CashOutForm extends Component
{
    use WithFileUploads;

    private const BATAS_NOMINAL = 10_000_000_000;

    private const MAKS_BARIS = 20;

    /** @var array<string, array<string, mixed>> */
    public array $baris = [];

    /** @var array<string, array<int, mixed>> */
    public array $unggahan = [];

    /** @var array<string, string> */
    public array $pesanOcr = [];

    public ?int $recordId = null;

    public function mount(?UangKeluar $record = null): void
    {
        abort_unless((bool) auth()->user()?->bolehInput(), 403);

        if ($record !== null && $record->exists) {
            $this->recordId = $record->getKey();
            $this->baris = [(string) Str::uuid() => [
                'tanggal' => $record->tanggal?->format('Y-m-d'),
                'akun' => $record->akun?->value ?? AkunKas::Kas->value,
                'jumlah' => Format::untukInputUang($record->jumlah),
                'kategori' => $record->kategori?->value,
                'detail_kategori' => $record->detail_kategori,
                'penerima' => $record->penerima,
                'spk_id' => $record->spk_id,
                'keterangan' => $record->keterangan,
                'bukti' => $record->bukti ?? [],
            ]];

            return;
        }

        $this->tambahBaris();
    }

    public function tambahBaris(): void
    {
        if (count($this->baris) >= self::MAKS_BARIS) {
            return;
        }

        $this->baris[(string) Str::uuid()] = [
            'tanggal' => now()->format('Y-m-d'),
            'akun' => AkunKas::Kas->value,
            'jumlah' => '',
            'kategori' => '',
            'detail_kategori' => '',
            'penerima' => '',
            'spk_id' => '',
            'keterangan' => '',
            'bukti' => [],
        ];
    }

    public function hapusBaris(string $kunci): void
    {
        unset($this->baris[$kunci], $this->unggahan[$kunci], $this->pesanOcr[$kunci]);

        if ($this->baris === []) {
            $this->tambahBaris();
        }
    }

    public function hapusBukti(string $kunci, string $path): void
    {
        $this->baris[$kunci]['bukti'] = array_values(
            array_diff($this->baris[$kunci]['bukti'] ?? [], [$path]),
        );
    }

    /**
     * Baca satu berkas dengan OCR lalu isi barisnya. Admin tetap penentu:
     * hasil hanya draf yang bisa diubah.
     */
    public function isiOcr(string $kunci): void
    {
        abort_unless((bool) auth()->user()?->bolehInput(), 403);

        $this->pesanOcr[$kunci] = '';

        $berkas = $this->berkasUntuk($kunci);

        if ($berkas === null) {
            $this->pesanOcr[$kunci] = 'Unggah berkas notanya dulu.';

            return;
        }

        try {
            $hasil = app(PembacaNota::class)->baca($berkas);
        } catch (Throwable $e) {
            report($e);
            $this->pesanOcr[$kunci] = 'OCR gagal membaca berkas ini - isi manual.';

            return;
        }

        if (! ($hasil['ok'] ?? false)) {
            $this->pesanOcr[$kunci] = 'OCR tidak bisa membaca berkas ini - isi manual.';

            return;
        }

        $nota = is_array($hasil['nota'] ?? null) ? $hasil['nota'] : [];
        $pertama = $nota[0] ?? [];

        $this->baris[$kunci]['jumlah'] = $pertama['nominal'] ?? $pertama['jumlah'] ?? $this->baris[$kunci]['jumlah'];
        $this->baris[$kunci]['penerima'] = $pertama['penerima'] ?? $this->baris[$kunci]['penerima'];
        $this->baris[$kunci]['tanggal'] = $pertama['tanggal'] ?? $this->baris[$kunci]['tanggal'];
        $this->baris[$kunci]['keterangan'] = $pertama['keterangan'] ?? $this->baris[$kunci]['keterangan'];

        if (isset($pertama['kategori']) && KategoriPengeluaran::tryFrom((string) $pertama['kategori']) !== null) {
            $this->baris[$kunci]['kategori'] = $pertama['kategori'];
        }

        $jumlahNota = (int) ($hasil['jumlah_nota'] ?? 1);

        // Jika terdapat lebih dari 1 nota dalam berkas (multi-nota tumpuk / scan PDF banyak nota),
        // otomatis tambahkan baris form baru dan isi tiap baris dari hasil crop/baca OCR masing-masing nota!
        if ($jumlahNota > 1 && count($nota) > 1 && $this->recordId === null) {
            $berkasAsli = $this->baris[$kunci]['bukti'] ?? [];
            if (empty($berkasAsli) && isset($this->unggahan[$kunci])) {
                $berkasAsli = $this->unggahan[$kunci];
            }

            for ($i = 1; $i < min(count($nota), self::MAKS_BARIS - count($this->baris) + 1); $i++) {
                $itemNota = $nota[$i] ?? [];
                $kunciBaru = (string) Str::uuid();

                $barisBaru = [
                    'tanggal' => $itemNota['tanggal'] ?? $this->baris[$kunci]['tanggal'],
                    'akun' => $this->baris[$kunci]['akun'] ?? AkunKas::Kas->value,
                    'jumlah' => $itemNota['nominal'] ?? null,
                    'kategori' => (isset($itemNota['kategori']) && KategoriPengeluaran::tryFrom((string) $itemNota['kategori']) !== null)
                        ? $itemNota['kategori']
                        : $this->baris[$kunci]['kategori'],
                    'detail_kategori' => null,
                    'penerima' => $itemNota['penerima'] ?? null,
                    'spk_id' => $this->baris[$kunci]['spk_id'] ?? null,
                    'keterangan' => ($itemNota['keterangan'] ?? '') ?: 'Nota '.($i + 1).' (dari berkas tumpuk)',
                    'bukti' => $berkasAsli,
                ];

                $this->baris[$kunciBaru] = $barisBaru;
                $this->pesanOcr[$kunciBaru] = 'Terisi otomatis dari nota ke-'.($i + 1).' pada berkas scan yang sama.';
            }

            $this->pesanOcr[$kunci] = "OCR mendeteksi {$jumlahNota} nota dalam berkas ini. Berhasil memecah & mengisi otomatis ke dalam baris-baris form!";
        } else {
            $this->pesanOcr[$kunci] = $jumlahNota > 1
                ? "OCR mendeteksi {$jumlahNota} nota di berkas ini. Baris terisi dari nota pertama."
                : 'Terisi otomatis dari OCR - periksa kembali angkanya sebelum menyimpan.';
        }
    }

    public function simpan(): void
    {
        abort_unless((bool) auth()->user()?->bolehInput(), 403);

        // Baris yang sama sekali belum diisi dibuang, bukan divalidasi -
        // sama seperti Filament: admin boleh menambah baris lalu menyimpan
        // hanya yang terisi.
        $this->baris = array_filter(
            $this->baris,
            static fn (array $r): bool => filled($r['jumlah'] ?? null) || filled($r['kategori'] ?? null),
        );

        if ($this->baris === []) {
            $this->addError('baris', 'Isi minimal satu baris: tanggal, jumlah, dan kategori.');

            return;
        }

        $aturan = [
            'baris.*.tanggal' => ['required', 'date', 'before_or_equal:today'],
            'baris.*.akun' => ['required', Rule::in(array_keys(AkunKas::opsi()))],
            'baris.*.jumlah' => ['required', 'numeric', 'min:0.01', 'max:'.self::BATAS_NOMINAL],
            'baris.*.kategori' => ['required', Rule::in(array_keys(KategoriPengeluaran::opsi()))],
            'baris.*.detail_kategori' => ['nullable', 'string', 'max:255'],
            'baris.*.penerima' => ['nullable', 'string', 'max:255'],
            'baris.*.spk_id' => ['nullable', 'integer', 'exists:spk,id'],
            'baris.*.keterangan' => ['nullable', 'string', 'max:255'],
            'unggahan.*.*' => ['file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:'.PenyimpanBerkas::maksUkuranKb()],
        ];

        // Angka bertitik ("1.500.000") dinormalisasi dulu supaya lolos `numeric`.
        foreach ($this->baris as $kunci => $r) {
            $this->baris[$kunci]['jumlah'] = Format::bersihkanUang($r['jumlah'] ?? '');
        }

        $this->validate($aturan, [], [
            'baris.*.tanggal' => 'tanggal',
            'baris.*.jumlah' => 'jumlah',
            'baris.*.kategori' => 'kategori',
        ]);

        $this->pastikanSpkBolehTransaksi('baris');

        foreach ($this->baris as $kunci => $r) {
            if (($r['kategori'] ?? null) === KategoriPengeluaran::Lainnya->value && blank($r['detail_kategori'] ?? null)) {
                $this->addError("baris.$kunci.detail_kategori", 'Rincian wajib diisi bila kategori "Lainnya".');

                return;
            }
        }

        $tersimpan = DB::transaction(function (): int {
            $jumlahBaris = 0;

            foreach ($this->baris as $kunci => $r) {
                $bukti = $r['bukti'] ?? [];

                foreach ($this->unggahan[$kunci] ?? [] as $file) {
                    $path = app(PenyimpanBerkas::class)->simpanKe($file, 'uang_keluar', 'nota');

                    if ($path !== null) {
                        $bukti[] = $path;
                    }
                }

                $atribut = [
                    'tanggal' => $r['tanggal'],
                    'akun' => $r['akun'],
                    'jumlah' => (float) $r['jumlah'],
                    'kategori' => $r['kategori'],
                    'detail_kategori' => $r['detail_kategori'] ?: null,
                    'penerima' => $r['penerima'] ?: null,
                    'spk_id' => $r['spk_id'] ?: null,
                    'keterangan' => $r['keterangan'] ?: null,
                    'bukti' => $bukti,
                ];

                if ($this->recordId !== null) {
                    UangKeluar::query()->findOrFail($this->recordId)->update($atribut);
                } else {
                    UangKeluar::query()->create($atribut);
                }

                $jumlahBaris++;
            }

            return $jumlahBaris;
        });

        $this->unggahan = [];

        session()->flash(
            'berhasil',
            $tersimpan > 1
                ? $tersimpan.' pengeluaran berhasil dicatat.'
                : 'Uang keluar berhasil dicatat.',
        );

        $this->redirectRoute('panel.cash-out.index', navigate: false);
    }

    /**
     * SPK Dibatalkan tidak menerima transaksi baru (Rules §5.3).
     */
    private function pastikanSpkBolehTransaksi(string $prefix): void
    {
        $ids = collect($this->baris)->pluck('spk_id')->filter()->unique();

        $ditolak = Spk::query()->whereIn('id', $ids)->get()
            ->first(fn (Spk $s): bool => $s->status_spk !== null && ! $s->status_spk->bolehTransaksiBaru());

        if ($ditolak !== null) {
            $kunci = collect($this->baris)->search(fn (array $r): bool => (int) ($r['spk_id'] ?? 0) === $ditolak->id);
            $this->addError("$prefix.$kunci.spk_id", 'SPK '.$ditolak->nomor_spk.' berstatus Dibatalkan dan tidak bisa menerima transaksi baru.');

            throw new ValidationException($this->getErrorBag());
        }
    }

    /**
     * Path berkas untuk OCR: simpan unggahan ke disk 'nota' dulu jika baru, atau pakai bukti tersimpan.
     */
    private function berkasUntuk(string $kunci): ?string
    {
        $baru = $this->unggahan[$kunci][0] ?? null;

        if ($baru !== null) {
            return app(PenyimpanBerkas::class)->simpanKe($baru, 'uang_keluar', 'nota');
        }

        $lama = $this->baris[$kunci]['bukti'][0] ?? null;

        return is_string($lama) ? $lama : null;
    }

    public function render(): View
    {
        $saldoKasSaatIni = SaldoKas::saldo(AkunKas::Kas);
        $totalPengeluaranKas = collect($this->baris)
            ->filter(fn ($b) => ($b['akun'] ?? 'kas') === 'kas')
            ->sum(fn ($b) => Format::bersihkanUang($b['jumlah'] ?? 0));

        $peringatanSaldoKas = $totalPengeluaranKas > $saldoKasSaatIni;

        return view('livewire.cash-out.cash-out-form', [
            'opsiAkun' => AkunKas::opsi(),
            'opsiKategori' => KategoriPengeluaran::opsi(),
            'daftarSpk' => Spk::query()
                ->orderByDesc('tanggal_spk')
                ->get(['id', 'nomor_spk', 'nama_pekerjaan'])
                ->mapWithKeys(fn (Spk $s): array => [$s->id => $s->nomor_spk.' - '.$s->nama_pekerjaan])
                ->all(),
            'maksBaris' => self::MAKS_BARIS,
            'saldoKasSaatIni' => $saldoKasSaatIni,
            'totalPengeluaranKas' => $totalPengeluaranKas,
            'peringatanSaldoKas' => $peringatanSaldoKas,
        ]);
    }
}
