# AGENTS.md — Konteks Proyek

> Dibaca otomatis oleh agent yang bekerja di folder ini. **Bahasa: Indonesia.**
> Jangkar konteks: baca ini dulu sebelum bertanya atau menebak.
> Terakhir diperbarui: 6 November 2026.

## 1. Identitas Proyek

| Item | Nilai |
|:-----|:------|
| Proyek | **Sistem Informasi SPK & Kontrol Keuangan** |
| Perusahaan | PT Barelang Kontraktor Sarana (Batam) — subkontraktor PT PLN Batam |
| Sifat | Sistem internal — **tugas magang** Pradipta Aldy Syahputra |
| Stack | Laravel 13 · Blade + Livewire 4 (`/panel`, TailAdmin) · Tailwind CSS v4 · MySQL/MariaDB · PHP 8.5 |
| Skema | **5 tabel domain**: `mitra`, `spk`, `uang_masuk`, `uang_keluar`, `pengguna` |
| Role | **2**: Admin (input) · Direktur (**full akses**: input/ubah/hapus + kelola Pengguna). Filament sudah dicabut total. |
| Deploy | **Dedicated Server Intranet 24 Jam (`bks-server`)** — Ubuntu Server 26.04 LTS (i3-10105, RAM 8GB, SSD 256GB OS + HDD 1TB Data di `/data`), LAN kantor `192.168.100.10:8232`, remote admin via Tailscale (`bks-server` / `100.111.175.26`), containerized Docker/Portainer/Beszel |
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
- `docs/MANUAL-BOOK.md` — panduan Admin & Direktur
- `docs/PANDUAN-UAT.md` — lembar skenario uji coba & validasi user kantor
- `docs/arsip-migrasi-lama/` — dokumen historis analisis & panduan Filament lama (arsip)

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
Dashboard              /panel
SPK         : List SPK → Kalender Tenggat → Status SPK → Tagihan SPK → Tagihan Selesai SPK
Keuangan    : Uang Masuk → Uang Keluar
Nota & Bukti: Unggah & Ekstraksi Nota → Arsip Nota
Laporan     : /panel/reports
Master Data : Mitra → (Manajemen Akun — khusus Direktur)
Sistem      : Status Sistem → Backup Database → Impor Data
```

- Siklus status SPK: `Draft → Terbit → Berjalan → Selesai → Sudah Ditagihkan` (⇢ `Dibatalkan`)
- Siklus status tagihan: `Belum Ditagihkan → Sudah Ditagihkan → Revisi Dokumen → Menunggu Pembayaran → Dibayar`
- Status tagihan sinkron otomatis (`SinkronStatusTagihanObserver`)
- Aksi khusus SPK: ubah status & ubah tagihan (form terpisah, `?asal=` untuk breadcrumb kembali)

## 6. Cara Menjalankan & Menguji

```bash
cd "/home/pradipta/Project/PT Barelang Kontraktor Sarana"
php artisan test
php artisan serve        # http://127.0.0.1:8000/panel/login
npm run build            # aset Tailwind v4 (wajib setelah ubah view/CSS)
./vendor/bin/pint
php artisan queue:work   # worker OCR; di mesin ini sudah jalan via systemd --user (bks-queue)
```

Akun: `admin@bks.test` dan `direktur@bks.test` — kata sandi dibuat saat seeding/`php artisan app:buat-admin` (tidak ditulis di dokumen)

## 7. Status Pekerjaan

Selesai:
- Migrasi penuh Filament → **Blade + Livewire 4 (TailAdmin)**; seluruh paket Filament dihapus (`composer update` 4 Nov 2026)
- Direktur = full akses (route `peran:admin,direktur`, gate `bolehInput()`)
- Ekspor XLSX/CSV/PDF + bundel ZIP, BAST & kuitansi PDF, arsip nota, backup, impor, status sistem
- Audit keamanan + perbaikan bug (Bast PDF slug, validasi nilai SPK vs pembayaran, upload nota, responsive 375px, dark mode)

Belum/menunggu keputusan:
- Antrean OCR **aktif**: `.env` = `QUEUE_CONNECTION=database`, worker `bks-queue.service` wajib hidup (systemd; `docs/Architecture.md` §12.6a). Worker mati = halaman Unggah Nota berhenti di status menunggu.
- `docs/STATUS-PENGERJAAN.md` bagian historis (§0x–§4) masih menyebut Filament — arsip, bukan kondisi terkini

## 8. Jebakan (jangan ulangi)

- Menulis angka/nama dari ingatan → selalu verifikasi
- Factory Spk status acak → sudah deterministik
- Dropdown diklik via JS → pakai Playwright `get_by_role`
- Validasi di dalam `when($wajib)` di repeater uang keluar → taruh di luar
- Tes lulus ≠ suite hijau → jalankan `php artisan test` penuh
- Menulis kredensial/nilai keuangan ke dokumen → cek sebelum commit
