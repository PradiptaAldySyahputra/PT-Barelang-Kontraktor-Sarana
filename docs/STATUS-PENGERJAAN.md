# STATUS PENGERJAAN — Titik Lanjut Sesi

> Dibuat agar sesi berikutnya bisa **lanjut tanpa menebak**.
> Bahasa: Indonesia. Verifikasi ulang sebelum menulis angka/nama (aturan AGENTS.md §2.5).
>
> **Terakhir diperbarui:** 4 Oktober 2026
> **Cabang:** `main` · **Sinkron dengan** `origin/main` (0 ahead / 0 behind)

---

## 1. Kondisi Repo Sekarang

| Item | Nilai |
|:-----|:------|
| Tes | **574 lulus · 1.548 assertions** · 1 *risky* (pra-ada: `KompresiUntukOcrTest`) |
| Formatter | `./vendor/bin/pint` bersih |
| Commit terakhir | `0cd3176` docs: perbarui AGENTS.md jadi konteks proyek BKS |
| Sinkron remote | ✅ `git rev-list --left-right --count origin/main...HEAD` → `0 0` |

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

## 4. Belum Selesai / Menunggu Keputusan User

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
