# Sistem Informasi SPK & Kontrol Keuangan

Aplikasi web internal **PT Barelang Kontraktor Sarana** (Batam) untuk mencatat
SPK, uang masuk, dan uang keluar, serta memantau piutang per SPK. Dua peran:
**Admin** (input) dan **Direktur** (monitor). Berjalan lokal di jaringan kantor.

Stack: Laravel 13 · Filament 5 · MySQL/MariaDB · PHP 8.5.

---

## Mulai Cepat

```bash
composer install
cp .env.example .env
php artisan key:generate

# Sesuaikan DB_* di .env (database: bks), lalu:
php artisan migrate --seed
php artisan serve            # http://127.0.0.1:8000/admin
```

Akun awal: `admin@bks.test` / `password` · `direktur@bks.test` / `password`
(**ganti sebelum dipakai kerja**).

```bash
php artisan test             # seluruh suite
./vendor/bin/pint            # formatter
```

Prasyarat: PHP 8.5, Composer 2, MySQL/MariaDB, Node 20+ (build aset).
Detail pemasangan server ada di [docs/Architecture.md](docs/Architecture.md).

---

## Dokumentasi

Semua dokumen ada di `docs/`. Baca sesuai kebutuhan.

| Dokumen | Isi |
|:--------|:----|
| [docs/PRD.md](docs/PRD.md) | Kebutuhan fitur & ruang lingkup — **inti proyek** |
| [docs/Rules.md](docs/Rules.md) | **Aturan bisnis — wajib dipatuhi** |
| [docs/Architecture.md](docs/Architecture.md) | Arsitektur, deployment, backup, pengujian |
| [docs/Schema.md](docs/Schema.md) | Struktur database (5 tabel) |
| [docs/Design.md](docs/Design.md) | UI/UX |
| [docs/MANUAL-BOOK.md](docs/MANUAL-BOOK.md) | Panduan Admin & Direktur |
| [AGENTS.md](AGENTS.md) | Konteks untuk AI agent (aturan kerja, keputusan, jebakan) |

---

## Struktur Proyek

```
app/
  Enums/            Status & kategori (pengganti tabel master)
  Models/           5 model Eloquent
  Filament/         Panel admin: Resources, Pages, Widgets, Exports
  Services/         OCR nota, penyimpanan berkas
  Support/          Format rupiah, helper nota
database/
  migrations/       Skema 5 tabel + tabel infrastruktur
  factories/  seeders/
tests/
  Unit/             Logika murni (rumus piutang, tenggat, enum)
  Feature/          Resource, alur, keamanan, ekspor
python/             Skrip OCR nota (opsional)
```

Skema inti: `pengguna`, `mitra`, `spk` (entitas inti), `uang_masuk`, `uang_keluar`.
Tidak ada entitas PROYEK. Detail di [docs/Schema.md](docs/Schema.md).

---

## Catatan Penting

- **Data perusahaan tidak ada di repo ini.** Data asli disimpan di luar repo
  (`~/data-perusahaan-bks/`). Seeder hanya memuat data contoh.
- **Backup wajib.** `php artisan bks:backup` — jadwalkan lewat cron/Task Scheduler.
  Lihat [docs/Architecture.md](docs/Architecture.md).
- **Sebelum produksi:** set `APP_ENV=production` dan `APP_DEBUG=false`, ganti
  password default, dan pakai web server (Laragon/XAMPP), bukan `php artisan serve`.

---

Riwayat perubahan ada di `git log`.
