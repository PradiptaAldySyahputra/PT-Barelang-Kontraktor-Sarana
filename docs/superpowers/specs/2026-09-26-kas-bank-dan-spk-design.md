# Spec — Buku Kas & Bank + Penyempurnaan Tagihan/Tenggat SPK

> **Tanggal:** 26 September 2026
> **Proyek:** PT Barelang Kontraktor Sarana (Laravel 13 + Filament 5)
> **Status:** Menunggu review pengguna
> **Batasan:** Skema **tetap 5 tabel** (`mitra`, `spk`, `uang_masuk`, `uang_keluar`, `pengguna`) — semua tambahan berupa **kolom** atau **JSON**, tanpa tabel baru (Rules.md §1, Schema.md §7).

---

## 1. Latar Belakang & Tujuan

### 1.1 Keluhan / permintaan pengguna

1. **Keuangan (Kas & Bank).**
   "Kas/bank ini sebenarnya uang masuk dan uang keluar, tetapi dari admin biarkan saja seperti itu. Tetapi bisa ditambah menu baru dengan penyesuaian, supaya memudahkan admin untuk memanage bagian tersebut ketika diminta oleh bagian pajak — contohnya tanggal sekian dan bulan sekian, admin bisa mencari dan menemukan data tersebut sama seperti pada Excel."

2. **SPK — tagihan sebagian.**
   "Pada bagian tagihan, bagian yang sudah diterima tidak bisa dikelola admin atau diperbarui, karena pasti dari SPK tersebut dibayar tetapi bisa saja separuh atau 95%, dan itu berkaitan dengan belum diterima atau uang yang belum diterima."

3. **SPK — perpanjangan tenggat.**
   "Kalau SPK itu berakhirnya tidak bergantung pada tenggat waktu, itu bisa diperpanjang sesuai kesepakatan — bisa berapa bulan atau sesuai perjanjian."

4. **SPK — keterangan pengantaran.**
   "SPK ini perlu keterangan (lihat `LIST SPK 2026.xlsx`) — kalau di dalam SPK tersebut ada keterangan, jadi admin perlu itu, dan apakah saran Anda dibuat menu baru atau disesuaikan saja dengan menu yang sudah ada, karena itu penting juga untuk admin mengetahui apakah SPK tersebut sudah diantar atau belum."

### 1.2 Tujuan akhir

- **Kas & Bank:** admin dapat mencari & menyajikan transaksi per bulan/akun untuk keperluan pajak, dengan bentuk keluaran **menyerupai Excel** yang sudah dipakai perusahaan, tanpa mengubah cara input yang sudah dikenal admin.
- **SPK:** sistem mengenali pembayaran **bertahap** (50%, 95%, …), tidak lagi "mengunci" SPK begitu ditandai dibayar, serta dapat mencatat **perpanjangan tenggat** dan **status pengantaran dokumen**.

### 1.3 Bukan tujuan (YAGNI)

- Bukan sistem akuntansi berpasangan (double-entry). Tidak ada jurnal, buku besar, atau neraca.
- Tidak menghitung pajak (PPN/PPh), laba/rugi, retensi, atau aging piutang — konsisten dengan keputusan pengguna 19 Sep 2026.
- Tidak ada impor Excel otomatis. (Pengguna tidak meminta impor.)
- Kolom `REF` pada Excel pengguna **kosong seluruhnya** → tidak dibuat.

---

## 2. Bukti dari Data Nyata

### 2.1 `BKS - Format Kas & Bank 2026 (AGUSTUS).xlsx`

| Sheet | Baris data | Pemasukan | Pengeluaran | Catatan |
|---|---|---|---|---|
| KAS | 92 | Rp 902.745.978 | Rp 1.064.526.400 | saldo awal "Sisa Kas (pemasukan bulan Juli)" = Rp 9.204.578 |
| BANK | 58 | — | — | saldo berjalan **negatif** (−Rp 399 juta) |

Kolom: `TANGGAL | REF | KETERANGAN | PEMASUKAN/PENGELUARAN | SALDO`. Kolom `REF` **kosong semua**.

**Kesimpulan:** Excel memisahkan **dua buku (KAS & BANK)** dengan **saldo berjalan**. Sistem sekarang tidak punya konsep ini.

### 2.2 `LIST SPK 2026.xlsx`

11 sheet: `Tagihan BKS`, `GARDU MU ALIM`, `ARIF`, `ANGGI`, `CUT`, `THOMAS`, `SAM`, `SINAGA`, `TRIPAL`, `JESS`, `SADIRMAN`.

Kolom: `Tanggal SPK | No SPK | Nama Pekerjaan | Lokasi | Nilai | Keterangan | Keterangan sudah masuk ke rek BKS`.

Pola isi kolom `Keterangan` (contoh nyata):
- "20/7/2026 sudah diantar ke imperium"
- "22/7/2026 sudah dibawa pak ipul"
- "27/7/2026 sudah diantar ke infra & BASTP sudah diantar ke infra 29/7/2026"

Setiap sheet memiliki blok **"TAGIHAN YANG SUDAH DIBAYARKAN"** dan **"TAGIHAN SUDAH MASUK KE …"**.

**Kesimpulan:** kolom `keterangan` (pernah dihapus pengguna 19 Sep) dibutuhkan kembali, tetapi maknanya kini **status pengantaran dokumen**, bukan teks bebas.

### 2.3 Akar masalah tagihan "terkunci" (temuan kode)

```
TagihanSpkResource        → status_tagihan != 'dibayar'
TagihanSelesaiSpkResource → status_tagihan == 'dibayar'
```

Status tagihan bersifat **biner**. Begitu diubah ke "Dibayar", SPK **pindah ke arsip** dan tidak muncul lagi di daftar kerja — padahal kenyataannya baru dibayar sebagian.

---

## 3. Keputusan Desain (disetujui / diambil)

| # | Pertanyaan | Keputusan | Alasan |
|---|---|---|---|
| D1 | Menu baru atau manfaatkan yang ada (keuangan)? | **Dua-duanya.** Input tetap di Uang Masuk/Keluar (tambah kolom `akun`); laporan & ekspor di **menu baru "Buku Kas & Bank"** | Sesuai kata pengguna: "biarkan saja seperti itu" + "tambah menu baru" |
| D2 | Menu baru untuk SPK? | **Tidak.** Cukup perkaya menu yang ada | SPK sudah punya menu monitoring tagihan & tenggat |
| D3 | Cara mencatat pembayaran sebagian | **Lewat Uang Masuk yang sudah ada**; SPK menghitung sisa otomatis | Paling sederhana, tanpa alur baru |
| D4 | Data lama (209 uang keluar, 83 uang masuk) | Tandai default **`kas`**; laporan mulai rapi dari transaksi baru | Tidak menghapus data apa pun |
| D5 | Kolom `REF` | **Tidak dibuat sebagai kolom database.** Di ekspor tetap ditampilkan (kosong) agar bentuknya identik Excel pengguna | Terkonfirmasi kosong seluruhnya (0 nilai di sheet KAS & BANK). Lihat §4.6 |
| D6 | Kolom `akun` wajib? | **Nullable**, default `kas` untuk data lama; dropdown di form (Kas/Bank) | Tidak memaksa admin lama |
| D7 | Saldo awal per bulan | **Dihitung berjalan dari transaksi**, bukan diinput manual per bulan | Menghindari dua sumber kebenaran; "Sisa Kas" awal tetap bisa dicatat sebagai transaksi uang masuk |

---

## 4. Rancangan — Bagian A: Kas & Bank

### 4.1 Perubahan skema (tetap 5 tabel)

Dua migrasi baru menambah **satu kolom** masing-masing:

```php
// uang_masuk & uang_keluar
$table->string('akun', 20)->nullable()->default('kas')->after('tanggal')->index();
// nilai: 'kas' | 'bank'  (divalidasi App\Enums\AkunKas)
```

Enum baru `App\Enums\AkunKas` (pola sama dengan `KategoriPengeluaran`):

```php
enum AkunKas: string {
    case Kas  = 'kas';
    case Bank = 'bank';
    // label(), opsi(), warnaBadge()
}
```

### 4.2 Perubahan form

- `UangMasukForm` dan `UangKeluarForm`: tambah `Select::make('akun')` — label "Akun", opsi Kas/Bank, default **Kas**, wajib diisi.
- Tidak ada perubahan alur lain. Admin tetap input seperti biasa.

### 4.3 Menu baru: "Buku Kas & Bank"

Halaman Filament baru (grup navigasi **Keuangan**, urutan setelah Uang Keluar):

- **Filter:** Akun (Kas/Bank) + Bulan (picker) + opsi "Semua bulan".
- **Tabel:** `TANGGAL | KETERANGAN | PEMASUKAN | PENGELUARAN | SALDO`.
- **Saldo berjalan:** dihitung dari **saldo awal periode** + akumulasi transaksi urut tanggal.
  - **Saldo awal periode** = jumlah **seluruh** transaksi akun tersebut yang tanggalnya **sebelum** tanggal awal periode (pemasukan − pengeluaran). Bukan diinput manual (lihat D7).
  - Contoh: periode Agustus 2026 → saldo awal = semua transaksi s.d. 31 Juli 2026. Baris "Sisa Kas" milik pengguna tetap tercatat sebagai transaksi uang masuk biasa, sehingga otomatis ikut terhitung.
- **Ringkasan atas:** total pemasukan, total pengeluaran, saldo akhir.
- **Sumber data:** gabungan `uang_masuk` (pemasukan) + `uang_keluar` (pengeluaran) yang `akun`-nya cocok, dalam rentang periode.

### 4.4 Ekspor Excel

- Tombol **"Unduh Excel"** pada halaman Buku Kas & Bank.
- Pustaka: **`openspout/openspout` v4** (sudah ada di `composer.lock` sebagai dependensi transitif; ditambahkan sebagai dependensi langsung). Alasan: ringan, tanpa `ext-zip` eksternal, mendukung streaming (aman untuk data besar).
- Format keluaran **menyerupai** `BKS - Format Kas & Bank`:

```
PT. BARELANG KONTRAKTOR SARANA
ACCOUNT        : KAS
Periode: AGUSTUS 2026
TANGGAL | REF | KETERANGAN | PEMASUKAN | PENGELUARAN | SALDO
...baris...
T O T A L | ... | total pemasukan | total pengeluaran | saldo akhir
```

- Kolom `REF` **tetap ada di keluaran** (agar bentuknya sama) namun **kosong** — atau dihilangkan bila pengguna lebih suka. **Perlu konfirmasi** (lihat §7).

### 4.6 Catatan kolom `REF`

Kolom `REF` pada Excel pengguna berisi **nomor referensi transaksi**. Saya sudah memeriksa kedua sheet (KAS & BANK): **nol nilai** — kolom itu tidak pernah dipakai.

**Keputusan:** tidak dibuat sebagai kolom database (YAGNI). Namun pada ekspor, kolom `REF` **tetap dicetak kosong** supaya susunan kolom sama persis dengan Excel pengguna dan tidak membingungkan bagian pajak.

### 4.7 Ekspor di seluruh menu (permintaan pengguna)

Pengguna meminta **setiap menu dapat mengekspor datanya**. Filament v5 sudah menyediakan `ExportAction` bawaan (mendukung **CSV & XLSX**, menghormati filter aktif) — jadi tidak perlu dibangun manual satu-satu.

**Catatan tabel `exports`:** `ExportAction` bawaan memerlukan tabel `exports` (mencatat progres ekspor). Tabel ini **tabel infrastruktur**, bukan tabel domain — sama seperti `jobs`, `cache`, `sessions` yang sudah ada. Database saat ini berisi **13 tabel**: 5 tabel domain (mitra, pengguna, spk, uang_masuk, uang_keluar) + 8 tabel infrastruktur. Aturan "5 tabel" (Rules.md §1) menyangkut **tabel domain** dan tetap dipatuhi.

**Alternatif bila pengguna menolak tabel `exports`:** ekspor ditulis manual (streaming CSV/XLSX langsung tanpa antrian). Lebih banyak kode & lebih rawan bug; dipakai hanya jika diminta.

Dipasang di **seluruh tabel** berikut:

| Menu | Isi ekspor |
|---|---|
| List SPK | semua kolom SPK (termasuk perpanjangan & status antar) |
| Status SPK | status pekerjaan |
| Tagihan SPK | tagihan belum selesai (dengan % diterima) |
| Tagihan Selesai SPK | arsip tagihan lunas |
| Uang Masuk | transaksi pemasukan + akun |
| Uang Keluar | transaksi pengeluaran + akun |
| Buku Kas & Bank | buku kas/bank per periode (format Excel perusahaan) |
| Data Mitra | daftar mitra |
| Pengguna | daftar pengguna |

**Aturan:** ekspor menghormati **filter yang sedang aktif** (kalau admin memfilter Agustus 2026, ekspor hanya bulan itu) — inilah yang dibutuhkan saat bagian pajak meminta "tanggal sekian, bulan sekian".

### 4.8 Kriteria selesai (Bagian A)

- [ ] Admin dapat memilih akun Kas/Bank saat input uang masuk & uang keluar.
- [ ] Halaman Buku Kas & Bank menampilkan saldo berjalan yang **benar** (diverifikasi vs Excel pengguna).
- [ ] Filter bulan + akun bekerja; pencarian keterangan bekerja.
- [ ] Ekspor Excel menghasilkan berkas yang dapat dibuka Excel/Calc tanpa peringatan rusak.
- [ ] Data lama tetap tampil (default `kas`).

---

## 5. Rancangan — Bagian B: SPK

### 5.1 Tagihan sebagian (pembayaran bertahap)

**Tidak ada kolom baru.** Yang berubah adalah **aturan tampilan & status**:

- `TagihanSpkResource`: **tetap menampilkan** SPK yang sudah `dibayar` **selama masih ada sisa** (`piutang() > 0`). Artinya SPK tidak "hilang" dari daftar kerja saat baru dibayar sebagian.
- `TagihanSelesaiSpkResource`: hanya SPK yang `status_tagihan = dibayar` **DAN** `sisa = 0`.
- Kolom tabel `Sudah Diterima` dan `Belum Diterima` sudah ada → dipertahankan; tambahkan **persentase** (`diterima / nilai_spk`) sebagai kolom bantu.
- Tampilkan **riwayat pembayaran** (daftar `uang_masuk` milik SPK) pada halaman Ubah Status Tagihan.

**Aturan status otomatis (usulan):** bila `sisa = 0` tetapi status masih `menunggu_pembayaran`, sistem **menyarankan** (bukan memaksa) mengubah ke `dibayar`.

### 5.2 Perpanjangan tenggat

- **Kolom baru** `perpanjangan` (JSON) di `spk`, pola sama seperti `bukti`:

```json
[{"dari": "2026-08-01", "ke": "2026-11-01", "alasan": "kesepakatan adendum", "dicatat": "2026-09-26"}]
```

- `tanggal_akhir` menjadi **tenggat efektif** (yang dipakai perhitungan `sisaTenggatHari()`).
- Form SPK: bagian "Perpanjangan Tenggat" — tombol tambah baris (Repeater), tiap baris: tanggal lama, tanggal baru, alasan.
- Saat baris ditambah, `tanggal_akhir` **diperbarui** ke tanggal baru terakhir; **riwayat lama disimpan** di JSON.
- Tabel SPK: kolom kecil "Diperpanjang N×" bila ada riwayat.

### 5.3 Keterangan pengantaran dokumen

- **Kembalikan kolom** `keterangan` (teks) di `spk`.
- Ditambah **enum status pengantaran** agar bisa difilter — `App\Enums\StatusAntar`:

```php
enum StatusAntar: string {
    case BelumDiantar   = 'belum';
    case SudahDiantar   = 'sudah_diantar';
    case DiterimaPihak  = 'diterima';
    // label(), opsi(), warnaBadge()
}
```

- **Kolom baru** `status_antar` (string, nullable, index) + `tanggal_antar` (date, nullable) di `spk`.
- Form SPK: bagian "Pengantaran Dokumen" — status (dropdown), tanggal antar, dan `keterangan` bebas (mis. "diantar ke imperium").
- Tabel SPK & monitoring: kolom badge status antar + filter, sehingga admin **langsung tahu mana yang belum diantar**.

### 5.4 Kriteria selesai (Bagian B)

- [ ] SPK dibayar sebagian tetap muncul di Tagihan SPK selama ada sisa.
- [ ] Riwayat pembayaran per SPK terlihat.
- [ ] Perpanjangan tenggat tercatat dengan riwayat; `tanggal_akhir` ikut berubah; alarm tenggat memakai tanggal efektif.
- [ ] Status pengantaran dapat diisi, difilter, dan tampil di daftar.
- [ ] Tidak ada regresi pada 372 tes yang sudah lulus.

---

## 6. Rencana Pengujian

Setiap butir di atas dilengkapi tes otomatis (TDD):

| Area | Jenis tes |
|---|---|
| Enum `AkunKas` / `StatusAntar` | Unit — label, opsi |
| Migrasi `akun`, `keterangan`, `status_antar`, `perpanjangan` | Feature — kolom ada & default benar |
| Saldo berjalan Buku Kas & Bank | Feature — **dibandingkan angka Excel pengguna** (KAS Agustus) |
| Ekspor Excel | Feature — berkas terbentuk, header & total benar |
| Tagihan sebagian | Feature — SPK dibayar 50% tetap di Tagihan SPK; 100% pindah ke Selesai |
| Perpanjangan tenggat | Feature — `tanggal_akhir` berubah, riwayat tersimpan, alarm pakai tanggal baru |
| Status antar | Feature — filter & badge |

**Verifikasi akhir:** seluruh suite (`php artisan test`) hijau + uji manual di browser untuk alur kas/bank dan SPK.

---

## 7. Jawaban atas Pertanyaan Terbuka (dikonfirmasi pengguna 26 Sep 2026)

1. **Kolom `REF`** → **Dipertahankan di ekspor (kosong)** agar bentuknya identik dengan Excel pengguna. Tidak dibuat sebagai kolom database. (Lihat §4.6)
2. **Nilai default `akun` untuk data lama** → **Semua `kas`**. Tidak ada data lama yang perlu diubah manual.
3. **Status pengantaran** → **Cukup 3 nilai** untuk saat ini: `Belum` / `Sudah Diantar` / `Diterima`. Nilai tambahan (mis. "Revisi") dapat ditambahkan menyusul bila diperlukan.
4. **Ekspor di setiap menu** → **Ya**, dipasang di seluruh tabel (lihat §4.7).

---

## 8. Risiko & Mitigasi

| Risiko | Mitigasi |
|---|---|
| Saldo berjalan salah karena data lama tanpa akun | Data lama default `kas`; laporan punya periode "mulai dari" yang dapat diatur |
| Ekspor Excel gagal di server kantor | `openspout` tanpa dependensi eksternal berat; diuji dengan membuka hasilnya |
| Perubahan status tagihan memengaruhi laporan lama | Aturan baru hanya memindahkan **tampilan**; data tidak diubah |
| Batas 5 tabel dilanggar tanpa sengaja | Semua tambahan kolom/JSON; ditambahkan tes yang memastikan jumlah tabel tetap 5 |
