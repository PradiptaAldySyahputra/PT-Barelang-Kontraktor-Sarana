# MANUAL BOOK — Sistem Informasi SPK & Kontrol Keuangan

## PT Barelang Kontraktor Sarana

> **Untuk:** Admin (operator harian) & Direktur (pemantau)
> **Versi dokumen:** 1.0 — 29 September 2026
> **Aplikasi:** Laravel 13 + Filament 5, berjalan **lokal di jaringan kantor**
>
> ⚠️ Manual ini ditulis berdasarkan **kode yang benar-benar berjalan**, bukan
> dari rencana. Setiap menu & tombol yang disebut sudah diverifikasi ada.

---

## 1. Cara Masuk

### 1.1 Alamat aplikasi

| Dari | Alamat |
|:-----|:-------|
| PC server (PC Direktur) | `http://localhost:8000/admin` |
| PC lain di jaringan kantor | `http://<IP-PC-server>:8000/admin` |

> 📌 **Sebelum dipakai kantor**, ikuti `docs/Architecture.md` §12 (pemasangan PC
> server) agar aplikasi hidup otomatis saat PC menyala dan alamatnya tidak berubah.

### 1.2 Akun

| Peran | Email | Password awal |
|:------|:------|:--------------|
| **Admin** | `admin@bks.test` | `password` |
| **Direktur** | `direktur@bks.test` | `password` |

> 🔴 **WAJIB diganti sebelum dipakai sungguhan.** Password `password` hanya
> untuk uji coba. Ganti lewat menu **Master Data → Pengguna**.

### 1.3 Apa bedanya Admin dan Direktur

| | Admin | Direktur |
|:--|:------|:---------|
| Input SPK | ✅ bisa | ❌ hanya lihat |
| Input uang masuk/keluar | ✅ bisa | ❌ hanya lihat |
| Kelola mitra | ✅ bisa | ❌ hanya lihat |
| Kelola pengguna | ✅ bisa | ✅ bisa (khusus direktur) |
| Dashboard & laporan | ✅ bisa | ✅ bisa |
| Ekspor laporan | ✅ bisa | ✅ bisa |

> ⚠️ Direktur yang mencoba membuka halaman input akan **ditolak sistem** (403),
> bukan sekadar tidak melihat menunya. Ini disengaja (Rules §4).

---

## 2. Peta Menu

```
Dashboard          — ringkasan keuangan
SPK
  ├── List SPK              — daftar & input SPK
  ├── Status SPK            — pantau status pekerjaan
  ├── Tagihan SPK           — pantau status tagihan
  └── Tagihan Selesai SPK   — tagihan yang sudah lunas
Keuangan
  ├── Uang Masuk            — penerimaan
  └── Uang Keluar           — pengeluaran
Master Data
  ├── Mitra                 — PLN & Subkon/Vendor
  └── Pengguna              — akun (khusus direktur)
Laporan                     — laporan + ekspor Excel/PDF/CSV
```

---

## 3. Untuk ADMIN

### 3.1 Mengisi Data Mitra

**Master Data → Mitra → Tambah**

Hanya **2 kategori** (keputusan perusahaan):

| Kategori | Isi |
|:---------|:----|
| **PLN (Pemberi Kerja)** | Yang memberi pekerjaan kepada BKS |
| **Subkon/Vendor** | Yang mengerjakan sebagian pekerjaan BKS |

> 📌 Nomor telepon/kontak **opsional** — boleh dikosongkan.

### 3.2 Membuat SPK Baru

**SPK → List SPK → Tambah**

| Field | Wajib | Catatan |
|:------|:-----:|:--------|
| Nomor SPK | ✅ | **Tidak boleh duplikat** — sistem menolak |
| Nama Pekerjaan | ✅ | Tulis lengkap, mis. "Pengadaan Material Accessories" |
| Mitra | ✅ | Pilih dari daftar mitra |
| Nilai SPK | ✅ | Angka rupiah |
| Tanggal SPK | — | Boleh kosong untuk SPK lama tanpa tanggal |
| Tanggal Akhir | — | Dipakai untuk **peringatan tenggat** |
| Lokasi | — | |
| Status | ✅ | Draft / Terbit / Berjalan / Selesai / Sudah Ditagihkan / Dibatalkan |
| Status Tagihan | ✅ | Belum Ditagihkan / Sudah Ditagihkan / Revisi Dokumen / Menunggu Pembayaran / Dibayar |
| Pelaksana | ✅ | Dikerjakan Sendiri / Disubkonkan |
| Keterangan Pengantaran | — | Belum Diantar / Sudah Diantar / Diterima |
| Dokumen | — | BAST, scan SPK, kuitansi — **boleh banyak berkas** |

> 💡 **Keterangan Pengantaran** menjawab pertanyaan "SPK ini sudah diantar atau
> belum?" — kolom ini ada di Excel lama Anda, jadi ikut dipindahkan.

> ⚠️ **Tanggal tidak boleh lebih dari hari ini.** Salah ketik tahun (2062
> alih-alih 2026) akan ditolak sistem — supaya transaksi tidak "hilang" dari
> filter bulan.

### 3.3 Mengubah Status SPK

**Tidak diubah dari halaman edit.** Gunakan tombol khusus:

| Yang diubah | Caranya |
|:------------|:--------|
| Status pekerjaan | **SPK → Status SPK** → tombol **Ubah Status** |
| Status tagihan | **SPK → Tagihan SPK** → tombol **Ubah Status** |

> 📌 Dipisah supaya jelas: satu form untuk satu tujuan, tidak tercampur.

### 3.4 Mencatat Uang Masuk

**Keuangan → Uang Masuk → Tambah**

Ada **2 mode**:

**Mode 1 — Dari SPK** (paling sering dipakai)
1. Pilih **Dari SPK**
2. Pilih SPK dari dropdown → nomor & nama pekerjaan terisi otomatis
3. Isi tanggal & jumlah

**Mode 2 — Manual / Luar SPK**
1. Pilih **Manual / Luar SPK**
2. Isi nomor SPK & nama pekerjaan sendiri

| Field | Wajib | Catatan |
|:------|:-----:|:--------|
| Tanggal Masuk | ✅ | **Tidak boleh lebih dari hari ini** |
| Jumlah | ✅ | Harus > 0 |
| Kas/Bank | — | Kosong = dianggap **Kas** |
| Keterangan | — | |
| Bukti | — | Boleh banyak berkas |

> 🔴 **PENTING:** jumlah uang masuk **tidak boleh melebihi piutang** SPK yang
> dipilih. Kalau SPK nilainya Rp 100 juta dan sudah diterima Rp 60 juta, input
> maksimal Rp 40 juta. Sistem menolak dengan pesan yang menjelaskan batasnya.
>
> Uang masuk **luar SPK** (Mode 2) **tidak dibatasi**.

> 💡 **Status tagihan berubah otomatis** dari pembayaran nyata — tidak perlu
> diubah manual:
> - Piutang habis → **Dibayar**
> - Sudah ada bayar tapi belum lunas → **Menunggu Pembayaran**

### 3.5 Mencatat Uang Keluar

**Keuangan → Uang Keluar → Tambah**

Form ini bisa memuat **beberapa pengeluaran sekaligus** dalam satu halaman.

| Field | Wajib | Catatan |
|:------|:-----:|:--------|
| Tanggal Keluar | ✅ | **Tidak boleh lebih dari hari ini** |
| Jumlah | ✅ | Harus > 0 |
| Kategori | ✅ | Material / Upah / Operasional / Gaji / Nota / Transportasi / Lainnya |
| Kas/Bank | — | Kosong = dianggap **Kas** |
| Penerima | — | Terisi otomatis dari mitra SPK bila dikaitkan ke SPK |
| Kaitkan ke SPK | — | Opsional. Kosongkan untuk biaya kantor |
| Keterangan | — | |

#### Cara cepat mengisi dari foto/PDF nota

1. **Unggah berkas nota** (bisa PDF berisi banyak nota, atau foto)
2. Sistem menghitung **berapa nota** di dalam berkas itu
3. Pilih mode:

| Mode | Untuk | Hasil |
|:-----|:------|:------|
| **Total** (default) | Nota sebulan yang di-merge jadi 1 PDF | 1 baris, isi total saja |
| **Rinci** | Nota satuan/harian | 1 baris per nota |

> ⚠️ **Sistem TIDAK membaca nominal rupiah dari nota.** Nominal tetap diisi
> admin. Alasannya: salah hitung jumlah nota mudah diperbaiki, tapi salah baca
> nominal langsung masuk laporan keuangan. OCR terbukti tidak akurat untuk
> tulisan tangan.

### 3.6 Melihat & Menyaring Data

Semua tabel punya filter. Di **Uang Masuk** dan **Uang Keluar**:

| Filter | Fungsi |
|:-------|:-------|
| Periode | Saring per tahun / bulan / rentang tanggal |
| Kas/Bank | Pisahkan Kas dan Bank |
| Kategori | (Uang Keluar) saring per jenis pengeluaran |
| Mitra | (Uang Masuk) saring per mitra |
| **SPK** | **Saring hanya satu SPK** |
| Data Terhapus | Lihat data yang dihapus (soft delete) |

> 💡 **Filter SPK** berguna saat ada selisih, atau saat bagian pajak meminta
> rincian satu pekerjaan tertentu.

### 3.7 Ekspor Laporan

**Laporan** → pilih tombol ekspor (ada **3 pilihan**):

| Tombol | Format | Kapan dipakai |
|:-------|:-------|:--------------|
| **Ekspor Excel** | `.xlsx` | **Untuk mengolah angka** — nominal tersimpan sebagai angka, bisa langsung di-`SUM` |
| **Ekspor PDF** | `.pdf` | **Untuk menyerahkan/mengarsipkan** — ada kop perusahaan & kolom tanda tangan, tidak mudah diubah |
| **Ekspor CSV** | `.csv` | Pertukaran data antar sistem |

Jenis laporan: Daftar SPK · Piutang · Uang Masuk per Bulan · Pengeluaran per Kategori · Tenggat SPK

> 📌 Ekspor mengikuti **filter yang sedang aktif** dan **periode** yang dipilih.
> Kalau memilih periode 3 bulan, ekspor hanya 3 bulan itu.

### 3.8 Menghapus Data

Hapus bersifat **soft delete** — data tidak benar-benar hilang, bisa dipulihkan
lewat filter **Data Terhapus** → tombol **Pulihkan**.

> ⚠️ Data keuangan **tidak boleh hilang permanen** (Rules §2 butir 9).

---

## 4. Untuk DIREKTUR

### 4.1 Dashboard

**Dashboard** menampilkan ringkasan:

| Kartu | Isi |
|:------|:----|
| Total Nilai SPK | Jumlah nilai semua SPK |
| Total Uang Masuk | Total penerimaan tercatat |
| Total Uang Keluar | Total pengeluaran tercatat |
| Saldo Bersih | Selisih masuk dan keluar |

Grafik: **arus kas per bulan**, **SPK per status**, **status tagihan**,
dan tabel **SPK berjalan**.

> 📌 **Laba-rugi TIDAK dihitung** — keputusan perusahaan (Rules §2). Sistem
> murni mencatat data yang diinput.

### 4.2 Memantau Tenggat & Piutang

| Menu | Isi |
|:-----|:----|
| **SPK → Status SPK** | Status pekerjaan; tenggat **lewat** = badge merah, **≤14 hari** = kuning |
| **SPK → Tagihan SPK** | Tagihan yang belum lunas |
| **SPK → Tagihan Selesai SPK** | Tagihan yang sudah lunas |
| **Laporan → Piutang** | Daftar SPK yang uangnya belum diterima penuh, diurutkan dari **piutang terbesar** |

### 4.3 Ekspor untuk Pemeriksaan

Saat bagian pajak meminta "tanggal sekian, bulan sekian":
1. Buka **Keuangan → Uang Masuk** (atau Uang Keluar)
2. Atur **filter periode**
3. Klik **Ekspor** → berkas Excel

---

## 5. Hal Penting yang Perlu Diingat

| # | Hal | Kenapa |
|:-:|:----|:-------|
| 1 | Ganti password `password` sebelum dipakai | Keamanan |
| 2 | Backup rutin + **uji restore** | Data keuangan kritikal |
| 3 | Jangan pakai `php artisan serve` untuk harian | Tidak untuk produksi (Rules §11) |
| 4 | Jangan buka aplikasi ke internet | Hanya jaringan kantor |
| 5 | UPS untuk PC server | Listrik mati bisa merusak database |
| 6 | Nominal selalu **angka**, bukan teks | Supaya bisa dijumlahkan |
| 7 | Status/kategori **wajib pilih dari dropdown** | Kalau diketik bebas, laporan terpecah |

---

## 6. Kalau Ada Masalah

| Gejala | Kemungkinan | Tindakan |
|:-------|:------------|:---------|
| Tidak bisa login | Salah password / akun nonaktif | Cek dengan Direktur |
| Angka tidak muncul di laporan | Tanggal salah (beda bulan/tahun) | Cek filter periode |
| Uang masuk ditolak | Melebihi piutang SPK | Cek nilai SPK & penerimaan sebelumnya |
| Tombol tidak muncul | Peran tidak berhak | Direktur tidak bisa input |
| Halaman error | Lihat `storage/logs/laravel.log` | Hubungi pengembang |
| Data terhapus tidak sengaja | Soft delete | Filter "Data Terhapus" → Pulihkan |

---

## 7. Berkas Rujukan

| Berkas | Isi |
|:-------|:----|
| `docs/PRD.md` | Kebutuhan fitur & ruang lingkup |
| `docs/Rules.md` | Aturan bisnis (WAJIB dipatuhi) |
| `docs/Architecture.md` | Struktur teknis, deployment, backup, pengujian |
| `docs/Schema.md` | Struktur database |
| `docs/Design.md` | UI/UX |

---

*Manual ini disusun 29 September 2026 berdasarkan kode yang berjalan.
Setiap menu & tombol yang disebut sudah diverifikasi ada di aplikasi.*
