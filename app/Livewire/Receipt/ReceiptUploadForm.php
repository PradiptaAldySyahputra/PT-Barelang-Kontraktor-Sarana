<?php

declare(strict_types=1);

namespace App\Livewire\Receipt;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Services\PembacaNota;
use App\Services\PenyimpanBerkas;
use App\Support\Nota;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
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
        $this->pesanStatus = 'Mengunggah & memproses OCR pada berkas...';

        // 1. Validasi & Kompres Berkas Langsung via PenyimpanBerkas
        // PenyimpanBerkas otomatis mengompres gambar/scan (kualitas 80, max 2400px)
        // sehingga proses OCR ringan, cepat, dan latensi upload minimal.
        $pathRelatif = app(PenyimpanBerkas::class)->simpanKe($this->berkasNota, 'uang_keluar', 'nota');
        $this->berkasTersimpanPath = $pathRelatif;

        if (! $pathRelatif) {
            $this->pesanStatus = 'Gagal menyimpan berkas nota.';
            $this->sedangProses = false;

            return;
        }

        // 2. Jalankan PembacaNota (OCR Python)
        $pembaca = app(PembacaNota::class);
        $hasil = $pembaca->baca($pathRelatif, 'nota');

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

        $this->sedangProses = false;
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

    public function simpanSemua(): void
    {
        abort_unless((bool) auth()->user()?->bolehInput(), 403);

        if (empty($this->daftarNota)) {
            $this->addError('berkasNota', 'Unggah berkas nota terlebih dahulu.');

            return;
        }

        // Angka bertitik ("1.500.000") dinormalisasi dulu supaya lolos `numeric`.
        foreach ($this->daftarNota as $i => $n) {
            $this->daftarNota[$i]['nominal'] = \App\Support\Format::bersihkanUang($n['nominal'] ?? '');
        }

        $this->validate([
            'daftarNota.*.tanggal' => ['required', 'date', 'before_or_equal:today'],
            'daftarNota.*.nominal' => ['required', 'numeric', 'min:0.01', 'max:10000000000'],
            'daftarNota.*.akun' => ['required', Rule::in(array_keys(AkunKas::opsi()))],
            'daftarNota.*.kategori' => ['required', Rule::in(array_keys(KategoriPengeluaran::opsi()))],
            'daftarNota.*.penerima' => ['nullable', 'string', 'max:200'],
            'daftarNota.*.keterangan' => ['nullable', 'string', 'max:255'],
            'daftarNota.*.spk_id' => ['nullable', 'integer', 'exists:spk,id'],
        ], [
            'daftarNota.*.tanggal.required' => 'Tanggal nota wajib diisi.',
            'daftarNota.*.tanggal.before_or_equal' => 'Tanggal tidak boleh di masa depan.',
            'daftarNota.*.nominal.required' => 'Nominal nota wajib diisi.',
            'daftarNota.*.nominal.min' => 'Nominal minimal Rp 0,01.',
        ]);

        // SPK Dibatalkan tidak menerima transaksi baru (Rules §5.3).
        $dibatalkan = Spk::query()
            ->whereIn('id', collect($this->daftarNota)->pluck('spk_id')->filter())
            ->get()
            ->first(fn (Spk $s): bool => $s->status_spk !== null && ! $s->status_spk->bolehTransaksiBaru());

        if ($dibatalkan !== null) {
            $this->addError('berkasNota', 'SPK '.$dibatalkan->nomor_spk.' berstatus Dibatalkan dan tidak bisa menerima transaksi baru.');

            return;
        }

        $berkasLampiran = $this->berkasTersimpanPath ? [$this->berkasTersimpanPath] : [];

        // Simpan setiap nota sebagai transaksi pengeluaran kas riil yang tercatat bukti fisiknya
        foreach ($this->daftarNota as $item) {
            $lampiran = $berkasLampiran;
            if (! empty($item['potongan_path'])) {
                // Sertakan juga berkas crop spesifiknya jika ada
                $lampiran[] = $item['potongan_path'];
            }

            // 1. Catat ke tabel uang_keluar dengan tanggal persis dari form nota masing-masing
            $trx = UangKeluar::create([
                'tanggal' => $item['tanggal'],
                'akun' => $item['akun'],
                'jumlah' => $item['nominal'],
                'kategori' => $item['kategori'],
                'penerima' => $item['penerima'] ?: null,
                'spk_id' => $item['spk_id'] ?: null,
                'keterangan' => $item['keterangan'] ?: 'Input dari Ekstraksi Nota OCR',
                'bukti' => array_values(array_unique($lampiran)),
            ]);

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

        session()->flash('berhasil', 'Berhasil menyimpan '.count($this->daftarNota).' nota ke dalam arsip & sistem.');

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
