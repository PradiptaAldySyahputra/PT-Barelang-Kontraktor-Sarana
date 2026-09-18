# Design - Sistem Informasi Keuangan Internal PT Barelang Kontraktor Sarana

## 1. Prinsip Desain UI/UX

- Antarmuka **dashboard admin** yang sederhana, bersih, fokus pada angka dan tabel (bukan aplikasi konsumen dengan desain berat).
- Prioritaskan kejelasan data finansial: gunakan warna hijau/merah secara konsisten untuk menandai pemasukan vs pengeluaran, atau untung vs rugi.
- Navigasi sidebar tetap, mengikuti 4 modul utama: Dashboard, Master Data, Transaksi, Laporan.
- Mobile-friendly untuk halaman input transaksi (pengawas lapangan sering input dari HP di lokasi proyek).

## 2. Daftar Halaman (Page List)

| Halaman | Modul | Deskripsi Singkat |
|---|---|---|
| Login | Auth | Form login dengan role-based redirect |
| Dashboard | Dashboard | Kartu ringkasan saldo, grafik kas, daftar proyek berjalan |
| Daftar Proyek | Master Data | Tabel proyek + form tambah/edit |
| Daftar Rekening Bank | Master Data | Tabel rekening + form tambah/edit |
| Daftar Kategori Biaya | Master Data | Tabel kategori + form tambah/edit |
| Input Uang Masuk | Transaksi | Form pencatatan termin masuk |
| Input Uang Keluar | Transaksi | Form pencatatan biaya keluar |
| Kas Kecil | Transaksi | Form khusus petty cash + riwayat penggunaan |
| Laporan Arus Kas | Laporan | Filter periode/rekening, tabel + total |
| Laporan Laba-Rugi Proyek | Laporan | Pilih proyek, tampilkan pemasukan vs biaya vs margin |
| Laporan Piutang Termin | Laporan | Daftar termin belum cair + umur piutang |

## 3. Komponen Dashboard (Detail)

- **Kartu Ringkasan** (di bagian atas): Total Saldo Kas & Bank, Total Piutang Termin, Total Pengeluaran Bulan Ini.
- **Grafik Line/Bar**: Kas Masuk vs Kas Keluar per bulan (6-12 bulan terakhir).
- **Tabel Proyek Aktif**: Nama proyek, total pemasukan, total biaya, estimasi laba/rugi, status.

## 4. Desain Form Transaksi

Form Uang Masuk & Uang Keluar menggunakan pola yang konsisten:

1. Dropdown Proyek (searchable, nullable khusus untuk Uang Keluar kategori operasional kantor).
2. Dropdown Kategori (difilter otomatis sesuai tipe transaksi: pemasukan/pengeluaran).
3. Dropdown Rekening/Kas tujuan atau sumber dana.
4. Input jumlah (format rupiah otomatis).
5. Input tanggal (default hari ini).
6. Input deskripsi/catatan.
7. Upload bukti (drag-and-drop, preview gambar).
8. Tombol Simpan dengan konfirmasi sebelum submit.

## 5. Desain Laporan

- Semua laporan memiliki filter periode (tanggal awal-akhir) dan filter proyek/rekening jika relevan.
- Tombol export ke PDF dan Excel di setiap halaman laporan.
- Laporan Laba-Rugi Per Proyek ditampilkan dalam format sederhana: Pemasukan (Termin) - Pengeluaran (Biaya Proyek) = Estimasi Laba/Rugi.

## 6. Pola Interaksi

- Konfirmasi modal sebelum menyimpan transaksi bernilai besar (opsional, threshold dapat dikonfigurasi).
- Notifikasi sukses/gagal (toast) setelah setiap aksi simpan/edit/hapus.
- Validasi inline pada form (contoh: jumlah harus lebih dari 0, tanggal tidak boleh di masa depan untuk transaksi realisasi).
