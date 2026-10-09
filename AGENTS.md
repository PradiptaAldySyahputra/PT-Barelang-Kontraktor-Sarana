# AGENTS.md — Konteks Proyek

> Dibaca otomatis oleh agent yang bekerja di folder ini. **Bahasa: Indonesia.**
> Jangkar konteks: baca ini dulu sebelum bertanya atau menebak.
> Terakhir diperbarui: 2 Oktober 2026.

## 1. Identitas Proyek

| Item | Nilai |
|:-----|:------|
| Proyek | **Sistem Informasi SPK & Kontrol Keuangan** |
| Perusahaan | PT Barelang Kontraktor Sarana (Batam) — subkontraktor PT PLN Batam |
| Sifat | Sistem internal — **tugas magang** Pradipta Aldy Syahputra |
| Stack | Laravel 13 · Filament 5 (`/admin`) · MySQL/MariaDB · PHP 8.5 |
| Skema | **5 tabel domain**: `mitra`, `spk`, `uang_masuk`, `uang_keluar`, `pengguna` |
| Role | **2**: Admin (input) · Direktur (monitor) |
| Deploy | **Lokal intranet** — PC Direktur = server (Windows, Laragon/XAMPP) |
| Repo | github.com/PradiptaAldySyahputra/PT-Barelang-Kontraktor-Sarana (private) |

## 2. Aturan Keras (jangan dilanggar)

1. **Git: pengguna melakukan SEMUA commit/push.** Agent DILARANG commit, push, buat PR, atau ubah history.
2. **Jangan menebak keputusan bisnis** — tanya. Perubahan alur bisnis = keputusan perusahaan.
3. **Jangan tambah tabel ke-6.** Skema tetap 5 tabel domain. Tambahan lewat kolom/JSON + PHP Enum. (Tabel infrastruktur boleh.)
4. **Balas bahasa Indonesia.**
5. **Verifikasi sebelum menulis** — jangan tulis angka/nama dari ingatan; jalankan perintah dulu.
6. **Data perusahaan tidak boleh bocor** ke GitHub. Data asli di `~/data-perusahaan-bks/`.
7. **Backup dulu** sebelum mengubah berkas besar/dokumen.
8. **Uji di browser sungguhan** sebelum bilang "selesai".

## 3. Dokumen Wajib

- `docs/PRD.md` — kebutuhan fitur & ruang lingkup (inti proyek)
- `docs/Rules.md` — aturan bisnis (WAJIB DIPATUHI)
- `docs/Architecture.md` — struktur teknis, deployment, backup, pengujian, OCR
- `docs/Schema.md` — struktur database
- `docs/Design.md` — UI/UX
- `docs/PANDUAN-FILAMENT.md` — cara review & ubah kode Filament (untuk yang biasa Blade)
- `docs/MANUAL-BOOK.md` — panduan Admin & Direktur

## 4. Keputusan Bisnis FINAL

- ❌ Retensi 5% · ❌ Laba-rugi per SPK · ❌ Pajak PPN/PPh
- ❌ Approval Direktur · ❌ Audit log · ❌ Entitas PROYEK (SPK = inti)
- ✅ Kategori mitra hanya 2: PLN & Subkon/Vendor
- ❌ Menu Buku Kas & Bank dihapus, diganti filter periode + kolom `akun`
- ✅ Akun Kas/Bank: kolom manual
- ✅ Mode nota: total vs rinci
- ❌ Docker untuk produksi · ✅ PDF via dompdf

### Aturan bisnis yang WAJIB dijalankan kode

- `piutang = nilai_spk − sudah_diterima` (tanpa retensi)
- SPK `Dibatalkan` tidak menerima transaksi baru
- Uang masuk tidak boleh melebihi piutang SPK
- Status tagihan sinkron otomatis dari pembayaran
- Tanggal transaksi ≤ hari ini
- Status/kategori wajib PHP Enum + dropdown
- Nominal `DECIMAL(18,2)`, dilarang FLOAT
- Soft delete

## 5. Peta Menu & Alur

```
Dashboard (-10)
SPK         : List SPK (1) → Status SPK (2) → Tagihan SPK (3) → Tagihan Selesai SPK (4)
Keuangan    : Uang Masuk (11) → Uang Keluar (12)
Master Data : Mitra (21) → Pengguna (22)
Laporan     (31)
```

- Siklus status SPK: `Draft → Terbit → Berjalan → Selesai → Sudah Ditagihkan` (⇢ `Dibatalkan`)
- Siklus status tagihan: `Belum Ditagihkan → Sudah Ditagihkan → Revisi Dokumen → Menunggu Pembayaran → Dibayar`
- Status tagihan sinkron otomatis (`SinkronStatusTagihanObserver`)
- Aksi khusus SPK: `UbahStatusSpk`, `UbahStatusTagihan` (form terpisah)

## 6. Cara Menjalankan & Menguji

```bash
cd "/home/pradipta/Project/PT Barelang Kontraktor Sarana"
php artisan test
php artisan serve        # http://127.0.0.1:8000/admin
./vendor/bin/pint
```

Akun: `admin@bks.test` / password · `direktur@bks.test` / password

## 7. Status Pekerjaan

Selesai:
- C2 Detail SPK (`ViewSpk` + 2 RelationManager, 10 tes)
- 5 poin 26 Sep (dokumen SPK, status antar, ekspor Excel/PDF, laporan piutang)
- Celah PRD/Rules 29 Sep, Kas/Bank B2 & B3
- `tests/Unit/` terisi

Belum/menunggu:
- **B1 Saldo berjalan Kas & Bank** (butuh keputusan)
- B4 Ekspor Excel format perusahaan (terikat B1)
- C1 Navigasi/UI lebih tegas
- C3 Menu baru (butuh daftar)

## 8. Jebakan (jangan ulangi)

- Menulis angka/nama dari ingatan → selalu verifikasi
- Factory Spk status acak → sudah deterministik
- Dropdown diklik via JS → pakai Playwright `get_by_role`
- Validasi di dalam `when($wajib)` di repeater uang keluar → taruh di luar
- Tes lulus ≠ suite hijau → jalankan `php artisan test` penuh
- Menulis kredensial/nilai keuangan ke dokumen → cek sebelum commit
