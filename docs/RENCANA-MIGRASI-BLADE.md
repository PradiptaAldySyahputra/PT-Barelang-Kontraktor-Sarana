# Rencana Migrasi Filament → Blade + TailAdmin

Status: **SELESAI (Filament Berhasil Dicabut Penuh)** · 31 Okt 2026 · Branch: `main`
Keputusan pemilik proyek: **Jalur B — lepas Filament sepenuhnya**, template
TailAdmin Laravel, interaktivitas memakai **Livewire**. Arsitektur bersih (Clean Architecture).

---

## 1. Keputusan arsitektur

| Aspek | Keputusan | Alasan |
|---|---|---|
| Proyek | **Tetap di repo ini**, bukan proyek baru | Domain (model, enum, observer, Support/Service) dan 238 tes domain sudah benar. Proyek baru = nol riwayat bug tertutup + risiko divergence skema data keuangan. |
| Lokasi UI baru | `/panel` | Filament di `/admin` dibiarkan hidup sampai fase akhir, agar bisa dibandingkan dan di-rollback per halaman. |
| Template | TailAdmin Laravel (`/home/pradipta/Project/tailadmin-laravel-main`) | Tailwind v4 + Blade + Alpine, MIT. Stack-nya sama dengan proyek ini. |
| Interaktivitas | **Livewire 4** (sudah terpasang v4.4.8 lewat Filament) | Form reaktif tanpa menulis banyak JS. Menjadi dependensi langsung saat Filament dicabut. |
| Chart | ApexCharts (bawaan template) | Menggantikan `ChartWidget` Filament (Chart.js). Hanya dipakai di dashboard & laporan. |
| Font | `system-ui` (bukan Outfit dari template) | `theme.css` + Design.md proyek sudah memutuskan font sistem dan membuang Inter. Template wajib menyesuaikan, bukan sebaliknya. |
| Warna | Aksen `#2563eb` + netral zinc | Sama dengan sistem desain v1.1 proyek. Palet `brand-*` template di-remap ke nilai ini. |

---

## 2. Jebakan teknis yang WAJIB dihindari

1. **Alpine ganda.** Template melakukan `import Alpine from 'alpinejs'` lalu
   `Alpine.start()`. Livewire 4 sudah membawa Alpine sendiri. Kalau keduanya
   dimuat → `Alpine has already been initialized` dan seluruh dropdown/modal mati.
   → Jangan pasang `alpinejs` di `package.json`. Pakai `window.Alpine` milik Livewire.
2. **Tailwind tidak memindai kelas Livewire.** `@source` di `panel.css` harus
   mencakup `app/Http/Livewire/**` dan `resources/views/panel/**`, kalau tidak
   kelas yang hanya muncul di komponen Livewire akan terbuang saat build.
3. **`@livewireStyles` / `@livewireScripts`** wajib ada di layout panel,
   diletakkan sebelum `@vite` agar urutan eksekusi Alpine benar.
4. **Middleware tamu.** `bootstrap/app.php` mengarahkan tamu ke `/admin/login`.
   Untuk `/panel` perlu tujuan sendiri (`/panel/masuk`), jangan dibiarkan
   memantul ke Filament setelah Filament dicabut.
5. **`Pengguna` implements `FilamentUser`.** Saat Filament dicabut, kontrak
   `FilamentUser`, `HasAvatar`, `HasName` harus dilepas dari model.
6. **Menulis di atas working tree kotor.** Sesi desain sebelumnya meninggalkan
   belasan file termodifikasi belum di-commit. Sesuai AGENTS.md §1, commit
   adalah hak pengguna — minta commit dulu sebelum fase yang menghapus file.

---

## 3. Peta modul (sumber Filament → target Blade)

| # | Modul | Sumber | Target | Berat |
|---|---|---|---|---|
| 0 | Shell: layout, sidebar, topbar, token CSS, menu per peran, login | `AdminPanelProvider`, `theme.css` | `components/panel/layout`, `panel/partials/*`, `panel/auth/login`, `Support/PanelMenu`, `panel.css` | S |
| 1 | Dashboard Direktur & Admin (dipisah file) | `Widgets/` (1.229 LOC) | `panel/dashboard/director`, `panel/dashboard/admin`, `Support/DashboardSummary` | S–M |
| 2 | Daftar SPK + filter + total terfilter | `Spks/Tables/SpksTable` (323) | `panel/spk/index` + Livewire `Panel/SpkTable` (`livewire/panel/spk-table`) | M |
| 3 | Monitoring SPK (status/tagihan/selesai) | `MonitoringSpk/*` (4 resource) | `panel/spk/status`, `panel/spk/billing`, `panel/spk/completed` | M |
| 4 | Mitra & Pengguna (CRUD) | `Mitras/*`, `Penggunas/*` | `panel/partners/*`, `panel/users/*` | M |
| 5 | Form & Detail SPK | `Spks/Schemas/SpkForm` (380), `ViewSpk` | `panel/spk/form`, `panel/spk/show`, Livewire `Panel/SpkForm` | M |
| 6 | Uang Masuk (Tabel & Form) | `UangMasuks/*` (348) | `panel/cash-in/*`, Livewire `Panel/CashInTable`, `Panel/CashInForm` | M |
| 7 | **Uang Keluar + OCR multi-nota** | `UangKeluarForm` (879) | `panel/cash-out/*`, Livewire `Panel/CashOutTable`, `Panel/CashOutForm` | **XL** |
| 8 | Laporan + ekspor CSV/XLSX/PDF | `Pages/Laporan` (657) | `panel/reports/*` + controller ekspor | L |
| 9 | Arsip Nota, Impor Data, Backup/Restore, Status Sistem, Ekspor & Unduhan, Profil | `Pages/*` (1.650) | `panel/receipts/*`, `panel/system/*`, `panel/profile/*` | L |
| 10 | Cabut Filament bertahap → penuh | seluruh `app/Filament`, `theme.css` | hapus per modul setelah Blade lulus tes, terakhir `composer remove filament/filament` | L |

Rute non-UI (`/admin/nota/{path}`, `/admin/laporan/ekspor/{jenis}`,
`/admin/backup/unduh`, `/admin/arsip-nota/*`, `/admin/ekspor-unduhan/*`)
**sudah route Laravel biasa** — tidak perlu ditulis ulang, hanya perlu
dipindahkan prefix-nya di fase 10.

---

## 4. Urutan kerja

**Fase 0 — Fondasi** (dikerjakan sekarang)
Shell panel, token CSS, menu per peran, login Blade, dashboard placeholder.
Belum menyentuh satu pun file Filament. Verifikasi: `/panel` tampil,
`/admin` tetap normal, `npm run build` hijau, tes lama tidak berubah.

**Fase 1 — Dashboard**
Pindahkan `RingkasanDirektur`, `AdminActionBar`, `AktivitasTerbaru`,
`GrafikArusKas`, `SpkPerStatus`, `StatusTagihanChart`, `SpkBerjalan`,
`RingkasanKeuangan` ke komponen Blade + Livewire.

**Fase 2 — Baca (read-only)**
Daftar SPK, Monitoring SPK, Mitra, Pengguna, Uang Masuk, Uang Keluar.
Filter, pencarian, urutan kolom, total terfilter. Tes: `FilterSpkTest`,
`TotalTerfilterTest`, `PenataanMenuTest` disalin ke setelan panel baru.

**Fase 3 — Tulis (form)**
Mitra, Pengguna, SPK, Uang Masuk. Validasi dipindah ke Form Request /
kelas `Aturan*` agar bisa diuji tanpa HTTP (Lihat `app/Support` pola yang
sudah ada — `NotaPengeluaran` sebagai teladan).

**Fase 4 — Uang Keluar + OCR**
Modul terberat. Migrasi terakhir di antara form. Wajib dijaga oleh
`OcrNotaTest`, `BatasNotaSekaligusTest`, `SkenarioSatuNotaTest`,
`DrafIsiNotaKeBarisTest`, `BuktiUangMasukPrivatTest`.

**Fase 5 — Laporan & sistem**
Laporan, ekspor, impor, backup, status sistem, arsip nota, ekspor unduhan,
profil akun, ubah kata sandi.

**Fase 6 — Cabut Filament**
Hapus `app/Filament`, `theme.css`, lepas kontrak `FilamentUser` dari
`Pengguna`, `composer remove filament/filament`, hapus `AdminPanelProvider`,
pindahkan `/panel` → `/admin`, tulis ulang 606 tes yang terikat Filament,
perbarui `AGENTS.md` + `docs/STATUS-PENGERJAAN.md`.

---

## 5. Strategi pengujian

- 238 tes domain (model, Support, Service, enum, PDF, ekspor) **tidak boleh
  disentuh** — itu jaring pengaman utama. Jalankan setiap fase.
- 606 tes yang memakai `Livewire::test(...)` / kelas Filament ditulis ulang
  **per fase**, bukan sekaligus di akhir, supaya regresi ketahuan lebih awal.
- Setiap fase harus lulus `php artisan test` penuh sebelum lanjut.
- `./vendor/bin/pint --test` hijau sebelum diserahkan ke pengguna.

## 6. Aturan kerja (dari AGENTS.md)

- Pengguna melakukan semua `git commit` / `push`. Asisten tidak commit.
- Skema tetap 5 tabel: `mitra`, `spk`, `uang_masuk`, `uang_keluar`, `pengguna`.
- Bahasa komentar & penamaan: Indonesia, konsisten dengan kode yang ada.
