<?php

declare(strict_types=1);

namespace App\Http\Controllers\CashIn;

use App\Enums\AkunKas;
use App\Models\Mitra;
use App\Models\Spk;
use App\Models\UangMasuk;
use App\Services\PenyimpanBerkas;
use App\Support\Format;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Uang Masuk pada panel Blade (`/panel/cash-in`).
 *
 * Aturan bisnis yang WAJIB dijaga (Rules.md):
 *   - Tanggal transaksi tidak boleh melewati hari ini.
 *   - Uang masuk tidak boleh melebihi piutang SPK (nilai − sudah diterima).
 *   - SPK berstatus `Dibatalkan` tidak menerima transaksi baru.
 *   - Nominal DECIMAL(18,2): titik pemisah ribuan dinormalisasi dulu.
 */
final class CashInController
{
    private const BATAS_NOMINAL = 10_000_000_000;

    public function index(): View
    {
        return view('cash-in.index', [
            'judul' => 'Uang Masuk',
            'keterangan' => 'Seluruh penerimaan: dari SPK maupun di luar SPK',
        ]);
    }

    public function create(Request $request): View
    {
        $this->pastikanBolehInput();

        $spkTerpilih = $this->spkDariQuery();
        $asal = $request->string('asal')->toString();
        $kembali = $spkTerpilih !== null
            ? route('panel.spk.show', $spkTerpilih)
            : $this->tujuanKembali($asal);

        return view('cash-in.form', [
            'judul' => 'Catat Uang Masuk',
            'keterangan' => 'Pilih sumber penerimaan: berdasarkan SPK atau manual',
            'uangMasuk' => null,
            'spkTerpilih' => $spkTerpilih,
            'kembali' => $kembali,
            ...$this->dataForm(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->pastikanBolehInput();

        $data = $this->validasi($request, null);
        $data['bukti'] = $this->simpanBukti($request, []);

        UangMasuk::query()->create($data);

        return redirect()
            ->route('panel.cash-in.index')
            ->with('berhasil', 'Uang masuk berhasil dicatat.');
    }

    public function edit(Request $request, UangMasuk $uangMasuk): View
    {
        $this->pastikanBolehInput();

        $asal = $request->string('asal')->toString();
        $kembali = $this->tujuanKembali($asal);

        return view('cash-in.form', [
            'judul' => 'Ubah Uang Masuk',
            'keterangan' => 'Perbarui data transaksi uang masuk',
            'uangMasuk' => $uangMasuk,
            'kembali' => $kembali,
            ...$this->dataForm($uangMasuk->spk_id),
        ]);
    }

    public function update(Request $request, UangMasuk $uangMasuk): RedirectResponse
    {
        $this->pastikanBolehInput();

        $data = $this->validasi($request, $uangMasuk);

        /** @var list<string> $hapus */
        $hapus = array_values(array_filter((array) $request->input('hapus_bukti', [])));
        $data['bukti'] = $this->simpanBukti($request, $uangMasuk->bukti ?? [], $hapus);

        $uangMasuk->update($data);

        return redirect()
            ->route('panel.cash-in.index')
            ->with('berhasil', 'Perubahan uang masuk tersimpan.');
    }

    public function destroy(UangMasuk $uangMasuk): RedirectResponse
    {
        $this->pastikanBolehInput();

        $uangMasuk->delete();

        return redirect()
            ->route('panel.cash-in.index')
            ->with('berhasil', 'Uang masuk dihapus. Data masih bisa dipulihkan lewat penyaring "Data Terhapus".');
    }

    public function restore(int $id): RedirectResponse
    {
        $this->pastikanBolehInput();

        UangMasuk::withTrashed()->findOrFail($id)->restore();

        return redirect()
            ->route('panel.cash-in.index', ['terhapus' => 'saja'])
            ->with('berhasil', 'Uang masuk dipulihkan.');
    }

    // ---------------------------------------------------------- bantu

    /**
     * @return array<string, mixed>
     */
    private function dataForm(): array
    {
        return [
            'opsiAkun' => AkunKas::opsi(),
            'daftarMitra' => Mitra::query()->orderBy('nama')->pluck('nama', 'id')->all(),
            'daftarSpk' => Spk::query()
                ->orderByDesc('tanggal_spk')
                ->get(['id', 'nomor_spk', 'nama_pekerjaan'])
                ->mapWithKeys(fn (Spk $s): array => [
                    $s->id => $s->nomor_spk.' - '.$s->nama_pekerjaan,
                ])
                ->all(),
        ];
    }

    private function spkDariQuery(): ?Spk
    {
        $id = request()->integer('spk_id');

        return $id > 0 ? Spk::find($id) : null;
    }

    private function pastikanBolehInput(): void
    {
        abort_unless((bool) auth()->user()?->bolehInput(), 403);
    }

    private function tujuanKembali(string $asal): string
    {
        if ($asal === 'receipts') {
            return route('panel.receipts');
        }

        if (str_starts_with($asal, '/panel/') && ! str_starts_with($asal, '//')) {
            return url($asal);
        }

        return route('panel.cash-in.index');
    }

    /**
     * @return array<string, mixed>
     */
    private function validasi(Request $request, ?UangMasuk $record): array
    {
        $request->merge([
            'jumlah' => Format::bersihkanUang($request->input('jumlah')),
        ]);

        $data = $request->validate([
            'mode' => ['required', Rule::in(['spk', 'manual'])],
            'akun' => ['required', Rule::in(array_keys(AkunKas::opsi()))],
            'spk_id' => ['nullable', 'integer', 'exists:spk,id', 'required_if:mode,spk'],
            'nomor_spk' => ['nullable', 'string', 'max:150'],
            'nama_pekerjaan' => ['nullable', 'string', 'max:255'],
            'tanggal' => ['required', 'date', 'before_or_equal:today'],
            'jumlah' => ['required', 'numeric', 'min:0.01', 'max:'.self::BATAS_NOMINAL],
            'mitra_id' => ['nullable', 'integer', 'exists:mitra,id'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'bukti' => ['nullable', 'array'],
            'bukti.*' => ['file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:'.PenyimpanBerkas::maksUkuranKb()],
        ]);

        unset($data['bukti']);

        $spkId = $data['spk_id'] ?? null;
        $spk = $spkId !== null ? Spk::find((int) $spkId) : null;

        if ($data['mode'] === 'spk' && $spk === null) {
            throw ValidationException::withMessages(['spk_id' => 'SPK yang dipilih tidak ditemukan.']);
        }

        if ($spk !== null) {
            // Rules.md §5 butir 3
            if ($spk->status_spk !== null && ! $spk->status_spk->bolehTransaksiBaru()) {
                throw ValidationException::withMessages([
                    'spk_id' => 'SPK ini berstatus Dibatalkan - tidak bisa menerima transaksi baru.',
                ]);
            }

            $sudahDiterima = $spk->uangMasuk()
                ->when($record !== null, fn ($q) => $q->whereKeyNot($record->getKey()))
                ->sum('jumlah');

            $batas = (float) $spk->nilai_spk - (float) $sudahDiterima;

            if ((float) $data['jumlah'] > $batas + 0.01) {
                throw ValidationException::withMessages([
                    'jumlah' => sprintf(
                        'Melebihi nilai SPK. Nilai SPK %s, sudah diterima %s - maksimal %s.',
                        Format::rupiah((float) $spk->nilai_spk),
                        Format::rupiah((float) $sudahDiterima),
                        Format::rupiah(max(0, $batas)),
                    ),
                ]);
            }

            // Nomor & nama pekerjaan SELALU dari SPK, bukan dari isian bebas -
            // supaya laporan tidak terpecah karena salah ketik.
            $data['nomor_spk'] = $spk->nomor_spk;
            $data['nama_pekerjaan'] = $spk->nama_pekerjaan;
            $data['mitra_id'] = $data['mitra_id'] ?? $spk->mitra_id;
        } else {
            $data['spk_id'] = null;
            $data['nomor_spk'] = filled($data['nomor_spk'] ?? null) ? trim((string) $data['nomor_spk']) : null;
            $data['nama_pekerjaan'] = filled($data['nama_pekerjaan'] ?? null) ? trim((string) $data['nama_pekerjaan']) : null;
        }

        unset($data['mode']);

        return $data;
    }

    /**
     * @param  list<string>  $lama
     * @param  list<string>  $hapus
     * @return list<string>
     */
    private function simpanBukti(Request $request, array $lama, array $hapus = []): array
    {
        $hasil = array_values(array_diff($lama, $hapus));

        /** @var list<UploadedFile> $berkas */
        $berkas = $request->file('bukti', []) ?? [];

        foreach ($berkas as $file) {
            $path = app(PenyimpanBerkas::class)->simpanKe($file, 'uang_masuk', 'nota');

            if ($path !== null) {
                $hasil[] = $path;
            }
        }

        return $hasil;
    }
}
