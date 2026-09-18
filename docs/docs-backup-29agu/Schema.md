# Schema - Sistem Informasi Keuangan Internal PT Barelang Kontraktor Sarana

## 1. Ringkasan Tabel

| Tabel | Fungsi |
|---|---|
| `tabel_proyek` | Master data proyek konstruksi |
| `tabel_kategori_biaya` | Bagan akun sederhana (Chart of Accounts) |
| `tabel_rekening_bank` | Master data rekening bank & kas kecil |
| `tabel_transaksi_keuangan` | Tabel utama pencatatan semua uang masuk/keluar |

## 2. DDL (Data Definition Language)

```sql
-- =========================================================
-- TABEL: tabel_proyek
-- =========================================================
CREATE TABLE tabel_proyek (
    id_proyek        INT PRIMARY KEY AUTO_INCREMENT,
    kode_proyek      VARCHAR(20) UNIQUE NOT NULL,
    nama_proyek      VARCHAR(150) NOT NULL,
    nama_klien       VARCHAR(150),
    nilai_kontrak    DECIMAL(18,2) DEFAULT 0,
    tanggal_mulai    DATE,
    tanggal_selesai  DATE,
    status_proyek    ENUM('BERJALAN','SELESAI','TERTUNDA') DEFAULT 'BERJALAN',
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================================
-- TABEL: tabel_kategori_biaya
-- =========================================================
CREATE TABLE tabel_kategori_biaya (
    id_kategori      INT PRIMARY KEY AUTO_INCREMENT,
    nama_kategori    VARCHAR(100) NOT NULL,
    tipe_kategori    ENUM('PEMASUKAN','PENGELUARAN') NOT NULL,
    keterangan       VARCHAR(255)
);

-- =========================================================
-- TABEL: tabel_rekening_bank
-- =========================================================
CREATE TABLE tabel_rekening_bank (
    id_rekening      INT PRIMARY KEY AUTO_INCREMENT,
    nama_bank        VARCHAR(100) NOT NULL,
    no_rekening      VARCHAR(50),
    nama_pemilik     VARCHAR(100),
    saldo_awal       DECIMAL(18,2) DEFAULT 0,
    is_kas_kecil     BOOLEAN DEFAULT FALSE,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================================
-- TABEL: tabel_transaksi_keuangan
-- =========================================================
CREATE TABLE tabel_transaksi_keuangan (
    id_transaksi     INT PRIMARY KEY AUTO_INCREMENT,
    tanggal_transaksi DATE NOT NULL,
    tipe_transaksi   ENUM('MASUK','KELUAR') NOT NULL,
    id_proyek        INT NULL,
    id_kategori      INT NOT NULL,
    id_rekening      INT NOT NULL,
    jumlah           DECIMAL(18,2) NOT NULL,
    deskripsi        VARCHAR(255),
    no_bukti         VARCHAR(50),
    file_bukti       VARCHAR(255),
    dicatat_oleh     VARCHAR(100),
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_transaksi_proyek
        FOREIGN KEY (id_proyek) REFERENCES tabel_proyek(id_proyek),
    CONSTRAINT fk_transaksi_kategori
        FOREIGN KEY (id_kategori) REFERENCES tabel_kategori_biaya(id_kategori),
    CONSTRAINT fk_transaksi_rekening
        FOREIGN KEY (id_rekening) REFERENCES tabel_rekening_bank(id_rekening)
);
```

## 3. Penjelasan Relasi

- **`tabel_proyek` (1) → (N) `tabel_transaksi_keuangan`**: Satu proyek memiliki banyak transaksi. `id_proyek` nullable untuk biaya operasional kantor non-proyek.
- **`tabel_kategori_biaya` (1) → (N) `tabel_transaksi_keuangan`**: Setiap transaksi wajib memiliki satu kategori biaya/pendapatan.
- **`tabel_rekening_bank` (1) → (N) `tabel_transaksi_keuangan`**: Setiap transaksi wajib tercatat pada satu rekening/kas.

## 4. Kolom Turunan (Computed, Tidak Disimpan di DB)

Nilai-nilai berikut **dihitung on-the-fly**, bukan disimpan permanen, untuk menghindari data tidak sinkron:

- **Saldo Rekening** = `saldo_awal` + SUM(transaksi MASUK pada rekening) - SUM(transaksi KELUAR pada rekening).
- **Total Pemasukan Proyek** = SUM(`jumlah` WHERE `id_proyek` = X AND `tipe_transaksi` = 'MASUK').
- **Total Biaya Proyek** = SUM(`jumlah` WHERE `id_proyek` = X AND `tipe_transaksi` = 'KELUAR').
- **Estimasi Laba/Rugi Proyek** = Total Pemasukan Proyek - Total Biaya Proyek.
- **Piutang Termin** = `nilai_kontrak` proyek - Total Pemasukan Proyek yang sudah tercatat (opsional, tergantung definisi bisnis termin).

## 5. Indexing yang Disarankan

```sql
CREATE INDEX idx_transaksi_proyek ON tabel_transaksi_keuangan(id_proyek);
CREATE INDEX idx_transaksi_rekening ON tabel_transaksi_keuangan(id_rekening);
CREATE INDEX idx_transaksi_tanggal ON tabel_transaksi_keuangan(tanggal_transaksi);
```
