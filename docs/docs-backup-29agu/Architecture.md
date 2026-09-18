# Architecture - Sistem Informasi Keuangan Internal PT Barelang Kontraktor Sarana

## 1. Prinsip Arsitektur

- Monolitik, sederhana, mudah dirawat oleh tim kecil (1-3 developer).
- Tidak menggunakan microservices, message queue, atau container orchestration — tidak dibutuhkan untuk skala internal.
- Server-rendered atau lightweight SPA, tanpa kompleksitas build pipeline berlebihan.

## 2. Tech Stack

| Layer | Teknologi | Alasan |
|---|---|---|
| Backend Framework | Laravel (PHP) | Matang, dokumentasi lengkap, cocok CRUD & laporan keuangan |
| Database | MySQL / PostgreSQL | Relasional, stabil, gratis, sesuai skema data |
| Frontend | Blade + Bootstrap, atau template admin (AdminLTE/Tabler) | Mempercepat pengembangan UI |
| Grafik | Chart.js | Ringan untuk visualisasi kas masuk vs keluar |
| Export Laporan | DomPDF/TCPDF (PDF), PhpSpreadsheet (Excel) | Kebutuhan laporan cetak |
| Autentikasi | Laravel Breeze + role-based access (Admin, Staf Keuangan, Pengawas Lapangan) | Cukup untuk kontrol akses internal |
| Hosting | VPS sederhana (DigitalOcean/Niagahoster) | Biaya rendah, cukup untuk user terbatas |

> Catatan: Stack di atas adalah rekomendasi. Jika tim developer lebih familiar dengan stack lain (misal Django/Python, atau Node.js/Express), prinsip arsitektur tetap sama — monolitik, relasional, server-rendered dashboard.

## 3. Struktur Modul Aplikasi

```
app/
├── Dashboard/         # Ringkasan kas, grafik, piutang termin
├── MasterData/
│   ├── Proyek/
│   ├── RekeningBank/
│   └── KategoriBiaya/
├── Transaksi/
│   ├── UangMasuk/
│   ├── UangKeluar/
│   └── KasKecil/
├── Laporan/
│   ├── ArusKas/
│   ├── LabaRugiProyek/
│   └── PiutangTermin/
└── Auth/              # Login, role & permission
```

## 4. Alur Data Tingkat Tinggi

```
[User Input Transaksi] 
        │
        ▼
[Validasi: Proyek/Kategori/Rekening wajib valid]
        │
        ▼
[Simpan ke tabel_transaksi_keuangan]
        │
        ├──▶ [Update saldo rekening bank terkait]
        ├──▶ [Update akumulasi biaya/pendapatan proyek terkait]
        └──▶ [Refresh data Dashboard & Laporan]
```

## 5. Keamanan & Integritas Data

- Setiap transaksi wajib memiliki kategori dan rekening yang valid (foreign key constraint).
- Role-based access control: Pengawas Lapangan hanya bisa input transaksi kas kecil untuk proyek yang ditugaskan padanya.
- Bukti transaksi (upload file) disimpan dengan penamaan unik dan referensi ke `id_transaksi`.
- Tidak ada penghapusan transaksi secara permanen — gunakan soft delete/void untuk menjaga jejak audit.

## 6. Non-Functional Requirements

- Aplikasi harus dapat diakses oleh maksimal ~20-30 pengguna bersamaan (skala internal).
- Waktu respons halaman laporan < 3 detik untuk data 1 tahun berjalan.
- Backup database dilakukan berkala (harian/mingguan) karena ini data keuangan kritikal.
