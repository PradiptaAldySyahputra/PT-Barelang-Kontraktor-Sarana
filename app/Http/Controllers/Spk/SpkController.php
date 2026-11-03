<?php

declare(strict_types=1);

namespace App\Http\Controllers\Spk;

use App\Enums\DikerjakanOleh;
use App\Enums\StatusAntar;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Mitra;
use App\Models\Spk;
use App\Services\PenyimpanBerkas;
use App\Support\Format;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * SPK: daftar, formulir, detail, dan dua form status terpisah.
 *
 * Aturan yang dipegang (sama dengan Filament sebelumnya):
 *   - Hanya Admin yang boleh menambah/mengubah (Rules.md §4).
 *   - Status PEKERJAAN dan status TAGIHAN TIDAK diubah dari form utama -
 *     masing-masing punya form sendiri supaya tidak salah ubah data lain.
 *   - `Dibayar` hanya boleh kalau piutang sudah 0 (temuan audit A1).
 *   - SPK baru otomatis Draft + Belum Ditagihkan.
 *   - Dokumen (banyak berkas) disimpan di disk privat `nota`, kolom JSON `dokumen`.
 */
final class SpkController
{
    /** Batas atas nominal untuk menahan salah ketik — sama dengan Filament. */
    private const BATAS_NOMINAL = 10_000_000_000;

    private const MAKS_DOKUMEN = 10;

    public function create(): View
    {
        $this->pastikanBolehInput();

        return view('spk.form', [
            'judul' => 'Tambah SPK',
            'keterangan' => 'SPK baru otomatis berstatus Draft & Belum Ditagihkan',
            'spk' => null,
            'kembali' => route('panel.spk.index'),
            'opsiStatusAntar' => StatusAntar::opsi(),
            'opsiDikerjakan' => DikerjakanOleh::opsi(),
            'daftarMitra' => $this->daftarMitra(),
            'daftarSubkon' => $this->daftarSubkon(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->pastikanBolehInput();

        $data = $this->validasi($request);
        $data['status_spk'] = StatusSpk::Draft->value;
        $data['status_tagihan'] = StatusTagihan::BelumDitagihkan->value;
        $data['dibuat_oleh'] = $request->user()?->id;
        $data['dokumen'] = $this->simpanDokumen($request, []);

        $spk = Spk::query()->create($data);

        return redirect()
            ->route('panel.spk.show', $spk)
            ->with('berhasil', 'SPK '.$spk->nomor_spk.' berhasil dibuat.');
    }

    public function show(Request $request, Spk $spk): View
    {
        $spk->load(['mitra:id,nama', 'subkon:id,nama', 'pembuat:id,nama']);

        $asal = $this->kodeAsal($request->string('asal')->toString());

        return view('spk.show', [
            'judul' => 'Detail SPK',
            'keterangan' => $spk->nomor_spk.' - '.$spk->nama_pekerjaan,
            'spk' => $spk,
            'kembali' => $this->tujuanKembali($asal, $spk),
            'uangMasuk' => $spk->uangMasuk()->orderByDesc('tanggal')->orderByDesc('id')->get(),
            'uangKeluar' => $spk->uangKeluar()->orderByDesc('tanggal')->orderByDesc('id')->get(),
            'bolehUbah' => $this->bolehInput(),
        ]);
    }

    public function edit(Request $request, Spk $spk): View
    {
        $this->pastikanBolehInput();

        $asal = $this->kodeAsal($request->string('asal')->toString());
        $kembali = $this->tujuanKembali($asal, $spk);

        return view('spk.form', [
            'judul' => 'Ubah SPK',
            'keterangan' => $spk->nomor_spk,
            'spk' => $spk,
            'asal' => $asal,
            'kembali' => $kembali,
            'opsiStatusAntar' => StatusAntar::opsi(),
            'opsiDikerjakan' => DikerjakanOleh::opsi(),
            'daftarMitra' => $this->daftarMitra(),
            'daftarSubkon' => $this->daftarSubkon(),
        ]);
    }

    public function update(Request $request, Spk $spk): RedirectResponse
    {
        $this->pastikanBolehInput();

        $data = $this->validasi($request);

        /** @var list<string> $hapus */
        $hapus = array_values(array_filter((array) $request->input('hapus_dokumen', [])));
        $data['dokumen'] = $this->simpanDokumen($request, $spk->dokumen ?? [], $hapus);

        $spk->update($data);

        $asal = $this->kodeAsal($request->string('asal')->toString());
        $tujuan = $asal !== '' ? $this->tujuanKembali($asal, $spk) : route('panel.spk.show', $spk);

        return redirect($tujuan)
            ->with('berhasil', 'Perubahan SPK tersimpan.');
    }

    public function destroy(Spk $spk): RedirectResponse
    {
        $this->pastikanBolehInput();

        $nomor = $spk->nomor_spk;

        // SPK yang sudah punya transaksi keuangan tidak dihapus - datanya
        // dipakai laporan piutang & arus kas.
        if ($spk->uangMasuk()->exists() || $spk->uangKeluar()->exists()) {
            return redirect()
                ->route('panel.spk.show', $spk)
                ->with('gagal', 'SPK '.$nomor.' sudah punya transaksi keuangan, jadi tidak bisa dihapus. Ubah statusnya menjadi Dibatalkan.');
        }

        $spk->delete();

        return redirect()
            ->route('panel.spk.index')
            ->with('berhasil', 'SPK '.$nomor.' dihapus.');
    }

    // ---------------------------------------------------------- status

    public function statusForm(Spk $spk): View
    {
        $this->pastikanBolehInput();

        $asalKode = $this->kodeAsal(request()->string('asal')->toString());

        return view('spk.status', [
            'judul' => 'Ubah Status Pekerjaan',
            'keterangan' => $spk->nomor_spk.' - '.$spk->nama_pekerjaan,
            'spk' => $spk,
            'opsiStatus' => StatusSpk::opsi(),
            'asal' => $asalKode,
            'kembali' => $this->tujuanKembali($asalKode, $spk, route('panel.spk.monitoring', 'status')),
        ]);
    }

    public function statusUpdate(Request $request, Spk $spk): RedirectResponse
    {
        $this->pastikanBolehInput();

        $data = $request->validate([
            'status_spk' => ['required', Rule::in(array_keys(StatusSpk::opsi()))],
        ]);

        $spk->update(['status_spk' => $data['status_spk']]);

        $asalKode = $this->kodeAsal($request->string('asal')->toString());

        return redirect($this->tujuanKembali($asalKode, $spk))
            ->with('berhasil', 'Status pekerjaan SPK '.$spk->nomor_spk.' diperbarui.');
    }

    public function billingForm(Spk $spk): View
    {
        $this->pastikanBolehInput();

        $asalKode = $this->kodeAsal(request()->string('asal')->toString());

        return view('spk.billing', [
            'judul' => 'Ubah Status Tagihan',
            'keterangan' => $spk->nomor_spk.' - '.$spk->nama_pekerjaan,
            'spk' => $spk,
            'opsiStatus' => StatusTagihan::opsi(),
            'asal' => $asalKode,
            'kembali' => $this->tujuanKembali($asalKode, $spk, route('panel.spk.monitoring', 'billing')),
        ]);
    }

    public function billingUpdate(Request $request, Spk $spk): RedirectResponse
    {
        $this->pastikanBolehInput();

        $data = $request->validate([
            'status_tagihan' => ['required', Rule::in(array_keys(StatusTagihan::opsi()))],
        ]);

        $baru = $data['status_tagihan'];

        // `Dibayar` hanya boleh kalau faktanya memang lunas. Observer
        // pembayaran tidak bisa mencegah input manual ini (temuan audit A1).
        if ($baru === StatusTagihan::Dibayar->value) {
            $sisa = $spk->sisaTagih();

            if ((float) $spk->nilai_spk <= 0) {
                throw ValidationException::withMessages([
                    'status_tagihan' => 'Nilai SPK masih 0 (data belum lengkap) - status "Dibayar" belum bisa dipakai. Lengkapi nilai SPK dulu.',
                ]);
            }

            if ($sisa > 0.01) {
                throw ValidationException::withMessages([
                    'status_tagihan' => sprintf(
                        'Belum bisa "Dibayar": masih ada piutang %s dari nilai SPK %s (sudah diterima %s). Catat pembayarannya lebih dulu di menu Uang Masuk.',
                        Format::rupiah($sisa),
                        Format::rupiah((float) $spk->nilai_spk),
                        Format::rupiah($spk->totalPenerimaan()),
                    ),
                ]);
            }
        }

        $spk->update(['status_tagihan' => $baru]);

        $pesan = 'Status tagihan SPK '.$spk->nomor_spk.' disimpan.';

        if ($spk->fresh()?->status_tagihan === StatusTagihan::Dibayar) {
            $pesan .= ' SPK ini sekarang ada di menu "Tagihan Selesai SPK".';
        }

        $asalKode = $this->kodeAsal($request->string('asal')->toString());

        return redirect($this->tujuanKembali($asalKode, $spk))->with('berhasil', $pesan);
    }

    // ---------------------------------------------------------- bantu

    private function bolehInput(): bool
    {
        return (bool) auth()->user()?->bolehInput();
    }

    private function pastikanBolehInput(): void
    {
        abort_unless($this->bolehInput(), 403);
    }

    /**
     * Kembali ke menu ASAL (Detail / Status SPK / Tagihan SPK / Tagihan Selesai / List SPK).
     * Divalidasi dengan daftar putih (mencegah Open Redirect).
     */
    /**
     * Hanya kode asal yang dikenal yang diteruskan ke view/form; selain itu kosong.
     */
    private function kodeAsal(string $asal): string
    {
        return in_array($asal, ['show', 'list', 'status-spk', 'tagihan-spk', 'tagihan-selesai', 'calendar'], true) ? $asal : '';
    }

    private function tujuanKembali(string $asal, Spk $spk, ?string $default = null): string
    {
        return match ($asal) {
            'show' => route('panel.spk.show', $spk),
            'list' => route('panel.spk.index'),
            'status-spk' => route('panel.spk.monitoring', 'status'),
            'tagihan-spk' => route('panel.spk.monitoring', 'billing'),
            'tagihan-selesai' => route('panel.spk.monitoring', 'completed'),
            'calendar' => route('panel.spk.calendar'),
            default => $default ?? route('panel.spk.index'),
        };
    }

    /**
     * @return array<string, string>
     */
    private function daftarMitra(): array
    {
        return Mitra::query()->orderBy('nama')->pluck('nama', 'id')->all();
    }

    /**
     * @return array<string, string>
     */
    private function daftarSubkon(): array
    {
        return Mitra::query()->subkon()->orderBy('nama')->pluck('nama', 'id')->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function validasi(Request $request): array
    {
        // Normalisasi format rupiah pengguna (misal "250.000.000" atau "Rp 250.000.000")
        $request->merge([
            'nilai_spk' => \App\Support\Format::bersihkanUang($request->input('nilai_spk')),
        ]);

        $data = $request->validate([
            'nomor_spk' => ['required', 'string', 'max:150', Rule::unique('spk', 'nomor_spk')->ignore($request->route('spk'))],
            'tanggal_spk' => ['nullable', 'date'],
            'tanggal_akhir' => ['nullable', 'date', 'after_or_equal:tanggal_spk'],
            'nama_pekerjaan' => ['required', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'mitra_id' => ['nullable', 'integer', 'exists:mitra,id'],
            'nilai_spk' => ['required', 'numeric', 'min:0', 'max:'.self::BATAS_NOMINAL],
            'jenis_sumber' => ['nullable', Rule::in(['pln', 'luar', 'internal', 'lainnya'])],
            'sheet_lama' => ['nullable', 'string', 'max:100'],
            'status_antar' => ['required', Rule::in(array_keys(StatusAntar::opsi()))],
            'tanggal_antar' => ['nullable', 'date', 'before_or_equal:today'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'dikerjakan_oleh' => ['required', Rule::in(array_keys(DikerjakanOleh::opsi()))],
            'subkon_id' => ['nullable', 'integer', 'exists:mitra,id', 'required_if:dikerjakan_oleh,'.DikerjakanOleh::Subkon->value],
            'dokumen' => ['nullable', 'array', 'max:'.self::MAKS_DOKUMEN],
            'dokumen.*' => ['file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:'.PenyimpanBerkas::maksUkuranKb()],
        ]);

        $data['nomor_spk'] = trim((string) $data['nomor_spk']);
        $data['nama_pekerjaan'] = trim((string) $data['nama_pekerjaan']);
        $data['nilai_spk'] = (float) $data['nilai_spk'];

        if ($data['dikerjakan_oleh'] !== DikerjakanOleh::Subkon->value) {
            $data['subkon_id'] = null;
        }

        unset($data['dokumen']);

        return $data;
    }

    /**
     * Gabungkan dokumen lama (kecuali yang dihapus) dengan unggahan baru.
     *
     * @param  list<string>  $lama
     * @param  list<string>  $hapus
     * @return list<string>
     */
    private function simpanDokumen(Request $request, array $lama, array $hapus = []): array
    {
        $hasil = array_values(array_diff($lama, $hapus));

        /** @var list<UploadedFile> $berkas */
        $berkas = $request->file('dokumen', []) ?? [];

        foreach ($berkas as $file) {
            $path = app(PenyimpanBerkas::class)->simpanKe($file, 'spk', 'nota');

            if ($path !== null) {
                $hasil[] = $path;
            }
        }

        return array_slice($hasil, 0, self::MAKS_DOKUMEN);
    }
}