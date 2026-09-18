# PRD - Sistem Informasi Keuangan Internal PT Barelang Kontraktor Sarana

## 1. Latar Belakang

PT Barelang Kontraktor Sarana adalah perusahaan kontraktor lokal di Batam yang menjalankan bisnis berbasis proyek konstruksi. Saat ini pencatatan keuangan dilakukan manual, menyebabkan sulitnya mengetahui laba-rugi per proyek, saldo bank real-time, dan status piutang termin klien.

## 2. Tujuan Produk

1. Digitalisasi pencatatan kas masuk dan kas keluar perusahaan secara terpusat.
2. Melacak laba-rugi per proyek — setiap transaksi dikaitkan ke proyek tertentu.
3. Memantau saldo setiap rekening bank & kas kecil secara akurat.
4. Menyediakan laporan keuangan dasar untuk pengambilan keputusan manajemen.

## 3. Target Pengguna

| Role | Akses |
|---|---|
| Admin/Owner | Akses penuh ke semua modul, termasuk konfigurasi master data |
| Staf Keuangan | Input transaksi, lihat laporan, kelola master data proyek/rekening/kategori |
| Pengawas Lapangan | Input transaksi uang keluar (khusus kas kecil) terkait proyek yang ditugaskan |

## 4. Ruang Lingkup Fitur

### 4.1 Modul Dashboard
- Ringkasan saldo kas & bank gabungan.
- Total piutang termin (belum cair).
- Grafik kas masuk vs kas keluar per bulan.
- Ringkasan status laba-rugi proyek berjalan.

### 4.2 Modul Master Data
- CRUD Data Proyek (nama, klien, nilai kontrak, tanggal, status).
- CRUD Data Rekening Bank (termasuk kas kecil sebagai jenis rekening).
- CRUD Data Kategori Biaya (bagan akun sederhana, tipe pemasukan/pengeluaran).

### 4.3 Modul Transaksi
- Pencatatan Uang Masuk (termin proyek dari klien).
- Pencatatan Uang Keluar (biaya langsung proyek atau operasional kantor).
- Manajemen Kas Kecil/Petty Cash lapangan.
- Upload bukti transaksi (foto nota/kwitansi).

### 4.4 Modul Laporan
- Laporan Arus Kas (per periode, per rekening).
- Laporan Laba-Rugi Per Proyek.
- Laporan Piutang Termin (dengan aging/umur piutang).

## 5. Di Luar Lingkup (Out of Scope)

- Modul ERP penuh.
- Manajemen inventori/gudang material.
- Modul HRD, payroll, absensi.
- Fitur multi-tenant/SaaS.
- Integrasi e-Faktur/pajak otomatis.

## 6. Kriteria Sukses

- Setiap transaksi keuangan tercatat dengan kategori dan (jika relevan) proyek yang jelas.
- Saldo rekening bank di sistem selalu sinkron dengan akumulasi transaksi.
- Laporan laba-rugi per proyek dapat dihasilkan tanpa rekap manual tambahan.
