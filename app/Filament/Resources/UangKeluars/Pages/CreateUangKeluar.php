<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangKeluars\Pages;

use App\Filament\Resources\UangKeluars\Schemas\UangKeluarForm;
use App\Filament\Resources\UangKeluars\UangKeluarResource;
use App\Models\UangKeluar;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * TAMBAH UANG KELUAR — 4 BARIS SEKALIGUS (permintaan user).
 *
 * Alasan: admin biasanya memegang beberapa nota sekaligus. Daripada membuka
 * form 4 kali, halaman ini menyediakan 4 baris.
 *
 * ⚠️ Catatan penting: file nota TIDAK dibaca otomatis (tidak ada OCR).
 * Jadi alurnya: pilih/unggah 4 file sekaligus (file ke-1 → Baris 1, dst),
 * lalu isi angkanya manual sesuai tiap nota. Presisi terjaga karena tiap
 * nota menempel pada barisnya sendiri.
 *
 * Halaman ini MENGGANTIKAN menu terpisah "Input Uang Keluar (4 sekaligus)"
 * yang sebelumnya dibuat — sekarang semuanya ada di sini.
 */
class CreateUangKeluar extends CreateRecord
{
    protected static string $resource = UangKeluarResource::class;

    protected static ?string $title = 'Tambah Uang Keluar';

    /**
     * Data baris yang akan disimpan. Diisi di mutateFormDataBeforeCreate().
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $barisPengeluaran = [];

    public function form(Schema $schema): Schema
    {
        return UangKeluarForm::configureSekaligus($schema);
    }

    public function getSubheading(): ?string
    {
        return 'Unggah berkas notanya, isi ada berapa nota di dalam berkas itu — baris rincian dibuat otomatis.';
    }

    /**
     * Pisahkan baris dari data utama.
     *
     * Repeater `pengeluaran` tidak tersimpan sebagai kolom, jadi harus
     * dikeluarkan dulu sebelum membuat record.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->barisPengeluaran = collect($data['pengeluaran'] ?? [])
            ->filter(fn ($r): bool => is_array($r) && (filled($r['jumlah'] ?? null) || filled($r['kategori'] ?? null)))
            ->values()
            ->all();

        unset($data['pengeluaran'], $data['berkas_nota'], $data['potongan_ocr'], $data['jumlah_nota_ocr']);

        return $data;
    }

    /**
     * Validasi baris: yang terisi harus lengkap.
     *
     * ⚠️ BUG YANG DICEGAH (penting):
     * Sebelumnya method ini membaca `$this->data['pengeluaran']` — yaitu state
     * form MENTAH. Padahal `$this->data` diisi saat validasi form, dan isinya
     * bisa BERBEDA dari data yang sudah diolah `mutateFormDataBeforeCreate()`
     * (yang menambahkan `jumlah`, `kategori`, dll).
     *
     * Akibatnya validasi melihat baris "kosong" padahal sudah diisi → `halt()`
     * terpanggil → SEMUA baris tidak tersimpan tanpa pesan error apa pun.
     *
     * Perbaikan: validasi memakai `$this->barisPengeluaran`, yaitu data yang
     * SUDAH diolah dan memang akan disimpan.
     */
    protected function beforeCreate(): void
    {
        $terisi = collect($this->barisPengeluaran);

        if ($terisi->isEmpty()) {
            Notification::make()
                ->title('Belum ada pengeluaran yang diisi')
                ->body('Isi minimal satu baris: tanggal, jumlah, dan kategori.')
                ->danger()
                ->persistent()
                ->send();

            $this->halt();
        }

        $tidakLengkap = [];

        foreach ($terisi as $i => $r) {
            $kurang = [];

            if (blank($r['tanggal'] ?? null)) {
                $kurang[] = 'tanggal';
            }

            if (blank($r['jumlah'] ?? null)) {
                $kurang[] = 'jumlah';
            }

            if (blank($r['kategori'] ?? null)) {
                $kurang[] = 'kategori';
            }

            if ($kurang !== []) {
                $tidakLengkap[] = 'Baris '.($i + 1).': '.implode(', ', $kurang);
            }
        }

        if ($tidakLengkap !== []) {
            Notification::make()
                ->title('Ada baris yang belum lengkap')
                ->body(implode(' · ', $tidakLengkap))
                ->danger()
                ->persistent()
                ->send();

            $this->halt();
        }
    }

    /**
     * Simpan SEMUA baris.
     *
     * Baris pertama menjadi record utama (dibuat oleh parent), baris
     * berikutnya dibuat menyusul — semuanya dalam satu transaksi.
     *
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordCreation(array $data): Model
    {
        $baris = $this->barisPengeluaran;

        if ($baris === []) {
            $baris = [['tanggal' => now(), 'jumlah' => 0, 'kategori' => null]];
        }

        return DB::transaction(function () use ($baris): Model {
            $utama = null;

            foreach ($baris as $i => $r) {
                $atribut = [
                    'tanggal' => $r['tanggal'],
                    'jumlah' => $r['jumlah'],
                    'kategori' => $r['kategori'],
                    'penerima' => $r['penerima'] ?? null,
                    'spk_id' => $r['spk_id'] ?? null,
                    'keterangan' => $r['keterangan'] ?? null,
                    'bukti' => $r['bukti'] ?? null,
                ];

                if ($i === 0) {
                    // Record utama dibuat lewat parent agar redirect & event normal.
                    $utama = parent::handleRecordCreation($atribut);

                    continue;
                }

                UangKeluar::create($atribut);
            }

            return $utama;
        });
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        $jumlah = count($this->barisPengeluaran);
        $total = collect($this->barisPengeluaran)->sum(fn ($r): float => (float) ($r['jumlah'] ?? 0));

        return $jumlah > 1
            ? $jumlah.' pengeluaran dicatat — Rp '.number_format($total, 0, ',', '.')
            : 'Uang keluar dicatat — Rp '.number_format($total, 0, ',', '.');
    }

    /**
     * Teks tombol Simpan dibuat jelas.
     *
     * Permintaan user: "diperbarui dengan navigasi yang jelas juga, di button,
     * alert, icon". Tombol "Create" (bahasa Inggris, umum) tidak menjelaskan
     * apa yang akan terjadi. Diganti supaya admin tahu persis aksinya.
     */
    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan Pengeluaran');
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('Simpan & Tambah Lagi');
    }

    /**
     * Tombol Batal juga diterjemahkan, supaya seluruh aksi konsisten
     * berbahasa Indonesia (tidak campur "Cancel").
     */
    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
