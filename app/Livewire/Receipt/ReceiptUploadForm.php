<?php

declare(strict_types=1);

namespace App\Livewire\Receipt;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Jobs\EkstrakNotaOcr;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use App\Services\PenyimpanBerkas;
use App\Support\Format;
use App\Support\Nota;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Komponen Unggah & Ekstraksi Nota Mandiri (/panel/receipts/upload).
 *
 * Mampu menerima:
 * 1. Berkas Satuan (misal: nota1.jpg) -> membaca 1 nota, form ringkas tunggal.
 * 2. Berkas Tumpuk / Multi-nota PDF (misal: (12) nota simada...pdf)
 *    -> memotong per nota, membaca seluruh nota otomatis, dan menghasilkan
 *       N kartu isian sesuai jumlah nota yang terdeteksi OCR.
 */
final class ReceiptUploadForm extends Component
{
    use WithFileUploads;

    public mixed $berkasNota = null;

    public bool $sedangProses = false;

    public ?string $pesanStatus = null;

    public ?string $berkasTersimpanPath = null;

    /** Kunci cache tempat job OCR menitipkan hasilnya (lihat EkstrakNotaOcr). */
    public ?string $kunciOcr = null;

    /** Jenis transaksi untuk nota yang diunggah: 'keluar' (Pengeluaran Kas) atau 'masuk' (Uang Masuk). */
    public string $jenisTransaksi = 'keluar';

    /**
     * Daftar hasil pemotongan dan pembacaan nota.
     * Tiap item: [
     *   'id' => string uuid,
     *   'ke' => int,
     *   'potongan' => string|null, // URL atau path potongan
     *   'tanggal' => string,
     *   'nominal' => numeric|null,
     *   'penerima' => string|null,
     *   'kategori' => string,
     *   'keterangan' => string|null,
     *   'spk_id' => int|null,
     *   'akun' => string,
     * ]
     */
    public array $daftarNota = [];

    public function mount(): void
    {
        abort_unless((bool) auth()->user()?->bolehInput(), 403);

        $this->daftarNota = [];
        $this->kunciOcr = null;
    }

    public function updatedBerkasNota(): void
    {
        abort_unless((bool) auth()->user()?->bolehInput(), 403);

        $this->validate([
            'berkasNota' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:'.PenyimpanBerkas::maksUkuranKb()],
        ]);

        $this->prosesEkstraksi();
    }

    public function prosesEkstraksi(): void
    {
        abort_unless((bool) auth()->user()?->bolehInput(), 403);

        if (! $this->berkasNota) {
            return;
        }

        $this->sedangProses = true;
        $this->pesanStatus = 'Mengunggah berkas nota...';

        // Berkas dari unggahan sebelumnya (bila admin mengganti berkas) tidak
        // akan pernah tersimpan ke database - buang sekarang, jangan menunggu
        // pembersih harian.
        $sebelumnya = $this->berkasTersimpanPath;

        // 1. Validasi & Kompres Berkas Langsung via PenyimpanBerkas
        // PenyimpanBerkas otomatis mengompres gambar/scan (kualitas 80, max 2400px)
        // sehingga proses OCR ringan, cepat, dan latensi upload minimal.
        $folderTujuan = $this->jenisTransaksi === 'masuk' ? 'uang_masuk' : 'uang_keluar';
        $pathRelatif = app(PenyimpanBerkas::class)->simpanKe($this->berkasNota, $folderTujuan, 'nota');
        $this->berkasTersimpanPath = $pathRelatif;

        if ($sebelumnya && $sebelumnya !== $pathRelatif) {
            Storage::disk('nota')->delete($sebelumnya);
        }

        if (! $pathRelatif) {
            $this->pesanStatus = 'Gagal menyimpan berkas nota.';
            $this->sedangProses = false;

            return;
        }

        // 2. OCR dijalankan sebagai job (AUD-6): request tidak menggantung
        //    menunggu Python, hasilnya diambil lewat polling `periksaHasilOcr`.
        $this->kunciOcr = (string) Str::uuid();
        EkstrakNotaOcr::dispatch($this->kunciOcr, $pathRelatif);
        $this->pesanStatus = 'Berkas terunggah. OCR berjalan di latar belakang - kartu nota muncul otomatis.';

        // Antrean `sync` menyelesaikan job seketika: ambil hasilnya sekarang.
        $this->periksaHasilOcr();
    }

    /**
     * Dipanggil berkala (`wire:poll`) selama OCR belum selesai.
     */
    public function periksaHasilOcr(): void
    {
        if (! $this->kunciOcr) {
            return;
        }

        $hasil = Cache::get(EkstrakNotaOcr::kunciCache($this->kunciOcr));

        if (! is_array($hasil)) {
            return; // job belum selesai - biarkan spinner berputar
        }

        Cache::forget(EkstrakNotaOcr::kunciCache($this->kunciOcr));
        $this->kunciOcr = null;

        $this->terapkanHasil($hasil);
        $this->sedangProses = false;
    }

    /**
     * Ubah hasil OCR menjadi kartu isian.
     *
     * @param  array<string, mixed>  $hasil
     */
    private function terapkanHasil(array $hasil): void
    {
        $this->daftarNota = [];
        $tglDefault = now()->toDateString();

        if ($hasil['ok'] ?? false) {
            $items = is_array($hasil['nota'] ?? null) ? $hasil['nota'] : [];
            $jumlah = count($items);

            if ($jumlah === 0) {
                // Fallback jika tidak ada data spesifik
                $this->tambahBarisSatu(1, null, null, null, null, null);
                $this->pesanStatus = 'Nota terunggah. OCR tidak menemukan teks khusus — silakan lengkapi isian.';
            } else {
                foreach ($items as $idx => $item) {
                    $potonganUrl = null;
                    if (! empty($item['potongan'])) {
                        $potonganUrl = Nota::url($item['potongan']);
                    }

                    $kategoriVal = KategoriPengeluaran::Nota->value;
                    if (! empty($item['kategori']) && KategoriPengeluaran::tryFrom((string) $item['kategori']) !== null) {
                        $kategoriVal = $item['kategori'];
                    }

                    $this->daftarNota[] = [
                        'id' => (string) Str::uuid(),
                        'ke' => (int) ($item['ke'] ?? ($idx + 1)),
                        'potongan' => $potonganUrl,
                        'potongan_path' => $item['potongan'] ?? null,
                        'tanggal' => ! empty($item['tanggal']) ? Carbon::parse($item['tanggal'])->toDateString() : $tglDefault,
                        'nominal' => $item['nominal'] ?? null,
                        'penerima' => $item['penerima'] ?? null,
                        'kategori' => $kategoriVal,
                        'keterangan' => $item['keterangan'] ?? ('Nota '.($idx + 1)),
                        'spk_id' => null,
                        'akun' => AkunKas::Kas->value,
                    ];
                }

                $this->pesanStatus = $jumlah > 1
                    ? "Berhasil mendeteksi & memecah {$jumlah} nota dari berkas tumpuk secara otomatis!"
                    : 'Berhasil mendeteksi 1 nota satuan tunggal.';
            }
        } else {
            // OCR tidak aktif atau tidak dapat membaca
            $this->tambahBarisSatu(1, null, null, null, null, null);
            $this->pesanStatus = 'Berkas tersimpan. OCR tidak aktif atau teks belum terbaca — silakan isi rincian secara manual.';
        }
    }

    private function tambahBarisSatu(int $ke, ?string $potongan, ?int $nominal, ?string $penerima, ?string $kategori, ?string $keterangan): void
    {
        $this->daftarNota[] = [
            'id' => (string) Str::uuid(),
            'ke' => $ke,
            'potongan' => $potongan ? Nota::url($potongan) : null,
            'potongan_path' => $potongan,
            'tanggal' => now()->toDateString(),
            'nominal' => $nominal,
            'penerima' => $penerima,
            'kategori' => $kategori ?? KategoriPengeluaran::Nota->value,
            'keterangan' => $keterangan ?? 'Nota Satuan',
            'spk_id' => null,
            'akun' => AkunKas::Kas->value,
        ];
    }

    public function hapusBaris(int $index): void
    {
        if (isset($this->daftarNota[$index])) {
            unset($this->daftarNota[$index]);
            $this->daftarNota = array_values($this->daftarNota);
        }
    }

    public function tambahNotaManual(): void
    {
        $ke = count($this->daftarNota) + 1;
        $this->tambahBarisSatu($ke, null, null, null, null, 'Nota '.$ke);
    }

    public bool $sedangMenyimpan = false;

    public function simpanSemua(): void
    {
        abort_unless((bool) auth()->user()?->bolehInput(), 403);

        if ($this->sedangMenyimpan) {
            return;
        }

        if (empty($this->daftarNota)) {
            $this->addError('berkasNota', 'Unggah berkas nota terlebih dahulu.');

            return;
        }

        $this->sedangMenyimpan = true;

        // Angka bertitik ("1.500.000") dinormalisasi dulu supaya lolos `numeric`.
        foreach ($this->daftarNota as $i => $n) {
            $this->daftarNota[$i]['nominal'] = Format::bersihkanUang($n['nominal'] ?? '');
        }

        try {
            $this->validate([
                'daftarNota.*.tanggal' => ['required', 'date', 'before_or_equal:today'],
                'daftarNota.*.nominal' => ['required', 'numeric', 'min:0.01', 'max:10000000000'],
                'daftarNota.*.akun' => ['required', Rule::in(array_keys(AkunKas::opsi()))],
                'daftarNota.*.kategori' => [Rule::requiredIf($this->jenisTransaksi === 'keluar'), Rule::in(array_keys(KategoriPengeluaran::opsi()))],
                'daftarNota.*.penerima' => ['nullable', 'string', 'max:200'],
                'daftarNota.*.keterangan' => ['nullable', 'string', 'max:255'],
                'daftarNota.*.spk_id' => ['nullable', 'integer', 'exists:spk,id'],
            ], [
                'daftarNota.*.tanggal.required' => 'Tanggal nota wajib diisi.',
                'daftarNota.*.tanggal.before_or_equal' => 'Tanggal tidak boleh di masa depan.',
                'daftarNota.*.nominal.required' => 'Nominal nota wajib diisi.',
                'daftarNota.*.nominal.min' => 'Nominal minimal Rp 0,01.',
            ]);
        } catch (\Throwable $e) {
            $this->sedangMenyimpan = false;
            throw $e;
        }

        if ($this->jenisTransaksi === 'keluar') {
            foreach ($this->daftarNota as $idx => $n) {
                if (($n['kategori'] ?? null) === KategoriPengeluaran::Lainnya->value && blank($n['keterangan'] ?? null)) {
                    $this->addError("daftarNota.$idx.keterangan", 'Keterangan / rincian wajib diisi bila kategori "Lainnya".');
                    $this->sedangMenyimpan = false;

                    return;
                }
            }
        }

        // SPK Dibatalkan tidak menerima transaksi baru (Rules §5.3).
        $dibatalkan = Spk::query()
            ->whereIn('id', collect($this->daftarNota)->pluck('spk_id')->filter())
            ->get()
            ->first(fn (Spk $s): bool => $s->status_spk !== null && ! $s->status_spk->bolehTransaksiBaru());

        if ($dibatalkan !== null) {
            $this->addError('berkasNota', 'SPK '.$dibatalkan->nomor_spk.' berstatus Dibatalkan dan tidak bisa menerima transaksi baru.');
            $this->sedangMenyimpan = false;

            return;
        }

        // Khusus Uang Masuk terkait SPK: jumlah (termasuk akumulasi beberapa nota untuk SPK yang sama)
        // tidak boleh melebihi sisa piutang SPK
        if ($this->jenisTransaksi === 'masuk') {
            $terimaPerSpk = [];
            foreach ($this->daftarNota as $idx => $item) {
                if (! empty($item['spk_id'])) {
                    $targetSpk = Spk::find($item['spk_id']);
                    if ($targetSpk) {
                        $sudah = $terimaPerSpk[$targetSpk->id] ?? $targetSpk->totalPenerimaan();
                        $batas = (float) $targetSpk->nilai_spk - $sudah;
                        if ((float) $item['nominal'] > $batas + 0.01) {
                            $this->addError("daftarNota.$idx.nominal", sprintf(
                                'Nominal melebihi sisa piutang SPK %s (%s). Maksimal: %s.',
                                $targetSpk->nomor_spk,
                                Format::rupiah((float) $targetSpk->nilai_spk),
                                Format::rupiah(max(0, $batas))
                            ));
                            $this->sedangMenyimpan = false;

                            return;
                        }
                        $terimaPerSpk[$targetSpk->id] = $sudah + (float) $item['nominal'];
                    }
                }
            }
        }

        $berkasLampiran = $this->berkasTersimpanPath ? [$this->berkasTersimpanPath] : [];

        // Simpan setiap nota sebagai transaksi kas riil (Uang Keluar atau Uang Masuk)
        // Dibungkus transaksi DB agar aman jika terjadi interupsi
        DB::transaction(function (): void {
            foreach ($this->daftarNota as $item) {
                $lampiran = [];
                // Hanya sertakan potongan spesifik jika ada; jika tidak ada, lampirkan berkas sumber utama
                if (! empty($item['potongan_path'])) {
                    $lampiran[] = $item['potongan_path'];
                } elseif (! empty($this->berkasTersimpanPath)) {
                    $lampiran[] = $this->berkasTersimpanPath;
                }

                $lampiran = array_values(array_unique($lampiran));

                if ($this->jenisTransaksi === 'masuk') {
                    $spkObj = ! empty($item['spk_id']) ? Spk::find($item['spk_id']) : null;
                    $trx = UangMasuk::create([
                        'tanggal' => $item['tanggal'],
                        'akun' => $item['akun'],
                        'jumlah' => $item['nominal'],
                        'spk_id' => $item['spk_id'] ?: null,
                        'nomor_spk' => $spkObj?->nomor_spk,
                        'nama_pekerjaan' => $spkObj?->nama_pekerjaan,
                        'mitra_id' => $spkObj?->mitra_id,
                        'keterangan' => $item['keterangan'] ?: 'Penerimaan dari Ekstraksi Nota / Bukti',
                        'bukti' => $lampiran,
                    ]);
                } else {
                    $trx = UangKeluar::create([
                        'tanggal' => $item['tanggal'],
                        'akun' => $item['akun'],
                        'jumlah' => $item['nominal'],
                        'kategori' => $item['kategori'],
                        'detail_kategori' => ($item['kategori'] ?? null) === KategoriPengeluaran::Lainnya->value
                            ? ($item['keterangan'] ?: 'Lainnya')
                            : null,
                        'penerima' => $item['penerima'] ?: null,
                        'spk_id' => $item['spk_id'] ?: null,
                        'keterangan' => $item['keterangan'] ?: 'Input dari Ekstraksi Nota OCR',
                        'bukti' => $lampiran,
                    ]);
                }

                // Selaraskan timestamps created_at agar mengikuti tanggal nota yang diinput
                if (! empty($item['tanggal'])) {
                    try {
                        $waktuNota = Carbon::parse($item['tanggal'])->setTime(12, 0, 0);
                        $trx->timestamps = false;
                        $trx->created_at = $waktuNota;
                        $trx->updated_at = $waktuNota;
                        $trx->saveQuietly();
                    } catch (\Throwable) {
                        // abaikan fallback ke now()
                    }
                }
            }
        });

        // Kosongkan state formulir agar tidak tersimpan ulang
        $countDisimpan = count($this->daftarNota);
        $this->daftarNota = [];
        $this->berkasNota = null;
        $this->berkasTersimpanPath = null;

        $labelJenis = $this->jenisTransaksi === 'masuk' ? 'uang masuk' : 'uang keluar';
        session()->flash('berhasil', "Berhasil menyimpan {$countDisimpan} nota {$labelJenis} ke dalam arsip & sistem.");

        $this->redirectRoute('panel.receipts', navigate: false);
    }

    public function render(): View
    {
        return view('livewire.receipt.receipt-upload-form', [
            'opsiAkun' => AkunKas::opsi(),
            'opsiKategori' => KategoriPengeluaran::opsi(),
            'daftarSpk' => Spk::query()
                ->orderByDesc('tanggal_spk')
                ->get(['id', 'nomor_spk', 'nama_pekerjaan'])
                ->mapWithKeys(fn (Spk $s): array => [$s->id => $s->nomor_spk.' - '.$s->nama_pekerjaan])
                ->all(),
        ]);
    }
}
