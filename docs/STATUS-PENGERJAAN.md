# STATUS PENGERJAAN — Titik Lanjut Sesi

> Dibuat agar sesi berikutnya bisa **lanjut tanpa menebak**.
> Bahasa: Indonesia. Verifikasi ulang sebelum menulis angka/nama (aturan AGENTS.md §2.5).
>
> **Terakhir diperbarui:** 8 Oktober 2026
> **Cabang:** `main` · Perubahan sesi ini **belum di-commit** (aturan: user yang commit)

---

## 1. Kondisi Repo Sekarang

| Item | Nilai |
|:-----|:------|
| Tes | **616 lulus · 1.673 assertions** · 1 *risky* (pra-ada: `KompresiUntukOcrTest`) |
| Formatter | `./vendor/bin/pint` bersih |
| Aset | `npm run build` OK |
| Sinkron remote | ⚠️ ada perubahan belum di-commit di working tree |

Jalankan untuk memastikan:
```bash
cd "/home/pradipta/Project/PT Barelang Kontraktor Sarana"
php artisan test
./vendor/bin/pint --dirty
git rev-list --left-right --count origin/main...HEAD   # harus 0 0
```

---

## 2. Yang Selesai di Sesi Ini (5 commit, sudah di-push)

| Hash | Ringkas |
|:-----|:--------|
| `3d07062` | **fix**: tangani `status_spk`/`status_tagihan` NULL (scope `belumLunas`, `lewatTenggat`, `mendekatiTenggat` + guard form Uang Masuk/Keluar). Tes: `tests/Feature/SpkStatusNullTest.php` |
| `e1730e0` | **feat**: ekspor PDF semua menu + **perbaiki bug ekspor Excel SPK** (`SpkExporter` memakai `ExportColumn` untuk method `totalPenerimaan` → ekspor gagal total; diganti `getStateUsing()`). Tes: `EksporExporterTest`, `EksporPdfMenuTest` |
| `d22ca19` | **feat**: preview SPK **satu jalan masuk** — klik baris membuka **slide-over** (bukan lagi dua jalur: klik baris→halaman, tombol→modal). Tes: `PreviewSpkTest` |
| `0592a0a` | **feat**: rapikan & lengkapi halaman **Laporan** (ekspor per-bagian, bagian Piutang, badge Surplus/Defisit, Tren Arus Uang) |
| `0cd3176` | **docs**: AGENTS.md jadi konteks proyek BKS |

### Akar masalah "dua preview" (penting untuk diingat)
Filament `ListRecords::makeTable()` **otomatis mengisi `recordUrl`** selama Resource punya halaman `view`.
Akibatnya: klik baris → **halaman detail**, sedangkan tombol "Detail" → **modal**. Dua jalur berbeda.
**Solusi:** `->recordUrl(null)` + `->recordAction('view')`; tombol "Detail" di baris dihapus.

⚠️ **Jebakan teknis:** Filament menganggap aksi `hidden()` sebagai `disabled()` juga, sehingga aksi tanpa tombol **tidak bisa di-mount**. Dipakai kelas kecil `app/Filament/Actions/AksiKlikBaris.php` yang menimpa `isDisabled()` agar baris tetap bisa memicu preview. **Kalau Filament naik versi mayor, cek ulang** `tests/Feature/PreviewSpkTest.php` (`test_klik_baris_*`).

---

## 3. Berkas Kunci dari Sesi Ini

Baru:
- `app/Filament/Actions/PreviewSpk.php` — slide-over preview + aksi footer (Ubah/Hapus/Buka Halaman Detail)
- `app/Filament/Actions/AksiKlikBaris.php` — aksi yang dipicu klik baris (tanpa tombol)
- `app/Filament/Actions/EksporPdf.php` + `app/Filament/Exports/RakitEkspor.php` + `resources/views/filament/exports/tabel-pdf.blade.php`
- `resources/views/filament/pages/partials/ekspor-laporan.blade.php`

Diubah penting:
- `app/Filament/Resources/Spks/Tables/SpksTable.php` — `recordUrl(null)` + `recordAction('view')`
- 3 resource monitoring (`StatusSpkResource`, `TagihanSpkResource`, `TagihanSelesaiSpkResource`) — `recordAction('view')`
- `resources/views/filament/pages/laporan.blade.php` — ekspor per-bagian + Tren + badge
- `app/Models/Spk.php` — scope NULL
- `app/Filament/Exports/SpkExporter.php` — `getStateUsing()`

---

## 4. Sesi 7–8 Oktober 2026 (belum di-commit)

### 4a. Bug KRITIS keamanan — diperbaiki & diverifikasi
`UangMasukForm` `FileUpload::make('bukti')` **tidak** memakai `->disk('nota')` → jatuh ke disk `public`, sehingga bukti nota uang masuk bisa diakses **tanpa login** (`GET /storage/uang_masuk/...` → 200). Nota berisi harga material/subkon/gaji.
- Diperbaiki: pakai disk privat `nota` + `PratinjauNotaPrivat`; file lama dipindah; seeder diperbaiki; `livewire-tmp` dipindah ke disk privat `local` (`config/livewire.php`).
- Verifikasi: akses tanpa login kini **403/302**. Tes: `BuktiUangMasukPrivatTest`.

### 4b. OCR membaca ISI tiap nota (bukan hanya jumlahnya)
- `python/ocr_nota.py` — `teks_per_kotak()` mengelompokkan teks OCR per kotak nota; tetap "angka-blind" (mengembalikan `teks` mentah).
- `app/Support/PembacaIsiNota.php` (baru) — parsing `teks` → nominal/tanggal/penerima/kategori-saran/keterangan + confidence. Toleran pemisah tulisan tangan (`80-000` → 80000).
- Hasil OCR = **DRAF** yang harus dikonfirmasi admin; isian admin selalu menang.
- `MAKS_BARIS` 20 → **50**; mode default `total` → **`rinci`**.

### 4c. Bug mode **Rinci** (dilaporkan user) — akar masalah & perbaikan
Gejala: pilih mode Rinci → muncul "OCR tidak bisa membaca berkas ini" + hanya **1** form.
- **Akar masalah nyata (dari log):** `TooManyCallsException: Too many method calls in a single request (74). Maximum allowed is 50`. Form dengan puluhan baris (tiap baris punya field `live()`) melebihi batas `payload.max_calls` Livewire → request ditolak → form jatuh ke 1 baris.
- **Perbaikan:** `config/livewire.php` → `payload.max_calls` 50 → **1000**, `max_size` 1 MB → 4 MB. Diverifikasi: mode Rinci kini membuat 50 baris.

### 4d. Rombak desain — hilangkan "AI slop"
Palet **warna-warni** (badge 8 warna + garis kiri 6px warna per berkas) diganti **monokrom profesional**:
- `penanda-berkas.blade.php` — pembeda berbasis **TEKS** ("Nota 3 / 50") + titik status tipis, bukan warna.
- `theme.css` — border kartu 1px + garis aksen kiri **2px monokrom**; header baris lebih tipis.
- `progres-pengisian.blade.php` — 4 kotak alert menumpuk → **satu** baris status + peringatan hanya bila perlu.
- `info-ocr.blade.php`, `pratinjau-nota.blade.php` — pesan tenang, ikon lebih kecil.
- Judul/deskripsi section dipersingkat.
- ⚠️ Aturan lama yang **dibatalkan user**: dulu dilarang membaca nominal via OCR — kini justru diminta (sebagai draf).

### 4e. Tata letak form sesuai brief UI/UX (8 Okt 2026)
Brief desain "Clean Minimalist Enterprise" — sebagian besar SUDAH sesuai dari sesi sebelumnya. Yang disesuaikan:
- **Uang Masuk**: pemilih mode jadi **horizontal** (`->inline()`, segmented). Field dinamis sudah benar: mode SPK → nomor SPK & nama pekerjaan *read-only*; mode Manual → keduanya bisa diketik & dropdown SPK disembunyikan. Diverifikasi di browser.
- **Uang Keluar**: "Detail Pengeluaran" diubah 2 kolom → **1 kolom penuh** (nyaman di HP). Kategori = dropdown Enum, SPK opsional + clear, penerima teks pendek, keterangan textarea — semua sudah sesuai.
- **SPK**: diubah jadi **grid 2 kolom berbasis kartu**; tanggal terbit & tanggal akhir berdampingan; "Dokumen SPK" jadi area unggah **lebar penuh di paling bawah**. Diverifikasi: 8 section, pasangan kartu sejajar (476px+476px), section penuh 976px.
- **NO RETENTION** ditegaskan di deskripsi Nilai SPK; tidak ada elemen retensi (diverifikasi di browser).
- **Keputusan user (ditanya ulang)**: (1) status SPK **tetap display-only** (ubah lewat menu Status SPK / Tagihan SPK) — brief yang minta dropdown status TIDAK diikuti; (2) batas unggah Uang Keluar **tetap 25 MB** (bukan 10 MB) agar foto HP besar tetap masuk sebelum dikompres.
- Tes baru: `tests/Feature/TataLetakBriefFormTest.php` (6 tes).

### 4f. Halaman Uang Masuk/Keluar — dua baris "Total" (8 Okt 2026)
Keluhan user: *"halaman uang masuk dan keluar kenapa ada total begitu? membuang space"*.
- **Sebab:** bawaan Filament menampilkan blok "Rangkuman" dengan **DUA** baris total — "Halaman ini" (hanya baris halaman aktif) DAN "Semua Uang Masuk/Keluar" (seluruh data terfilter). Dua angka berbeda berlabel "Total" yang sama → membingungkan (tampak seperti bug) + memakan ~190px.
- **Perbaikan:** `->summaries(pageCondition: false)` di `UangMasuksTable` & `UangKeluarsTable` → tinggal SATU total (seluruh data terfilter). Blok menyusut 190px → 77px. Filter tetap dihormati.
- **Keputusan user:** pertahankan satu total (bukan hapus blok) karena angka total memang diminta sebelumnya (29 Sep 2026).
- Tes: `RingkasanTotalUangTest` +2 (total 10).

---

## 5. Belum Selesai / Menunggu Keputusan User

| Kode | Item | Status |
|:-----|:-----|:-------|
| **B1** | Saldo berjalan Kas & Bank | ⏳ **Butuh keputusan user** (opsi a/b/c). Rancangan sudah dilebur ke `docs/Architecture.md` §16 |
| **B4** | Ekspor Excel format perusahaan | ⏳ Terikat B1 |
| **C1** | Navigasi/UI lebih tegas | 🔄 Sebagian (preview & laporan sudah; tinjau menu lain bila perlu) |
| **C3** | Menu baru | ⏳ **Butuh daftar menu** dari user |
| — | Data keuangan final dari Admin | ⏳ Belum diterima (Rules §14) |
| — | Pajak PPN/PPh, data lama 2024–2026 | ⏳ Belum diputuskan (Rules §14) |

---

## 5. Aturan Kerja yang Tetap Berlaku

- **Commit/push:** default-nya **user** yang lakukan (AGENTS.md §2.1). Sesi ini dikecualikan karena user minta eksplisit.
- **Jangan tambah tabel ke-6** — tetap 5 tabel domain; tambahan lewat kolom/JSON + PHP Enum.
- **Jangan bocorkan data perusahaan** ke GitHub. Data asli di `~/data-perusahaan-bks/`.
- **Uji di browser sungguhan** sebelum bilang "selesai" (§2.8).
- **Jangan tebak keputusan bisnis** — tanya.

---

## 6. Cara Verifikasi Cepat di Browser (tanpa mengetik password)

Sesi admin bisa dibuat **server-side** (aturan melarang mengetik password). Catatan format cookie:
- Cookie = `encrypt(session_id)`; jar HttpOnly memakai prefiks `#HttpOnly_`.
- Driver sesi `database`, serialization JSON, cookie `spk-kontrol-keuangan-session`.
- Guard key: `login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d`.

Menu monitoring (slug benar):
- `/admin/monitoring-spk/status-spks`
- `/admin/monitoring-spk/tagihan-spks`
- `/admin/monitoring-spk/tagihan-selesai-spks`

---

*Sesi berikutnya: mulai dari §1 (pastikan repo hijau), lalu §4 (pilih item yang menunggu keputusan user).*
