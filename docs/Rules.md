# Rules — Aturan Bisnis, Konvensi & Guidelines
## Sistem Informasi SPK & Kontrol Keuangan — PT Barelang Kontraktor Sarana

> **WAJIB DIPATUHI** oleh AI agent/developer.
>
> ⚠️ **Aturan terpenting:** karena schema hanya 5 tabel, kolom status/kategori berupa **teks**.
> **WAJIB** divalidasi dengan **PHP Enum + dropdown** — tanpa itu laporan akan terpecah.
> Lihat §2 butir 11 dan bukti uji di `Schema.md` §7.

---

## 1. Batasan Ruang Lingkup (WAJIB DIPATUHI)

Sistem ini **HANYA** untuk pengelolaan **SPK, uang masuk, uang keluar**, dan kontrol keuangan.
**DILARANG** menambahkan modul di luar itu:

- Manajemen proyek (entitas PROYEK **tidak ada** — SPK adalah entitas inti).
- Pengajuan dana & approval.
- Manajemen inventori/stok gudang.
- Modul HRD, payroll, absensi karyawan.
- Fitur multi-tenant/SaaS.
- Integrasi e-Faktur/pajak otomatis.
- Integrasi otomatis dengan sistem PLN.
- Integrasi bank otomatis.
- Mobile app native.
- Approval multi-level.
- Forecasting keuangan lanjutan.

> ⚠️ **Pengecualian yang perlu diperhatikan:** file `8. UD AGUSTUS 2026.xlsx` dan
> `9. UD SEPTEMBER 2026.xlsx` berisi data **pelanggan PLN** (IDPEL, tarif, daya, tanggal bayar).
> Itu pekerjaan **administrasi Ubah Daya**, **bukan** keuangan BKS — **di luar scope**.

> 📌 Jika ada permintaan fitur baru yang tidak tercantum di `PRD.md`, agent **harus menandai
> sebagai "di luar scope"** dan **meminta konfirmasi eksplisit** sebelum mengimplementasikan.

## 2. Aturan Bisnis (Business Rules)

1. **SPK adalah entitas inti.** Tidak ada entitas PROYEK.

2. **❌ RETENSI TIDAK DIPAKAI** — keputusan pengguna 19 Sep 2026, dikonfirmasi
   26 Sep 2026 lewat pemeriksaan data nyata.

   > **Bukti dari data perusahaan:** seluruh SPK yang sudah berstatus `Dibayar`
   > diterima **100%** dari nilai SPK — tidak ada satu pun yang ditahan 5%.
   > Contoh: `0094.SPK/DAN.01.03/PLNBATAM020400/2026` nilai Rp 461.700.000
   > diterima Rp 461.700.000 (100%).

   **Konsekuensinya (WAJIB dipatuhi saat coding):**

   ```
   piutang = nilai_spk − sudah_diterima      ← rumus yang DIPAKAI
   ```

   - **DILARANG** memakai `persen_retensi` / `nilai_retensi` — kolomnya sudah
     **dihapus** dari tabel `spk` (lihat `Schema.md`).
   - **DILARANG** mengurangi piutang dengan retensi 5%. Melakukan itu akan
     membuat piutang **lebih kecil dari kenyataan** sebesar 5% — padahal klien
     membayar penuh.
   - Tidak ada konsep "dana ditahan" maupun "masa pemeliharaan" di sistem ini.

   **Riwayat:** aturan retensi 5% pernah ada di dokumen versi lama. Sudah
   dihapus dari sistem, dan dokumen ini diselaraskan 26 Sep 2026.

3. **❌ LABA-RUGI PER SPK TIDAK DIHITUNG** — keputusan pengguna 19 Sep 2026.

   Sistem **murni mencatat** data yang diinput. Tidak menghitung pajak, biaya,
   laba/rugi, maupun margin. Alasannya: perusahaan belum memakai perhitungan
   tersebut, dan angka yang tidak dipakai justru berisiko menyesatkan.

   Yang tetap disajikan: **nilai SPK**, **sudah diterima**, **belum diterima**
   (piutang), dan **arus kas** dari transaksi nyata.

4. **Tidak ada approval.** Admin langsung mencatat transaksi; Direktur hanya memantau.
5. **Sumber uang masuk disimpulkan dari `spk_id`:**
   - `spk_id` **terisi** → uang masuk dari SPK
   - `spk_id` **NULL** → uang masuk dari luar SPK
6. **Uang keluar boleh memiliki `spk_id = NULL`** untuk pengeluaran umum.
   Untuk biaya langsung pekerjaan, `spk_id` diisi agar pengeluaran bisa
t   dikaitkan ke SPK tertentu (laba-rugi TIDAK dihitung — lihat §2).
7. **Jumlah transaksi harus > 0.** Arah transaksi ditentukan oleh **tabel**
   (`uang_masuk`/`uang_keluar`), **bukan** tanda minus.
8. **Nominal rupiah disimpan `DECIMAL(18,2)` — DILARANG `FLOAT`/`DOUBLE`.**
9. **Transaksi tidak boleh dihapus permanen** — gunakan soft delete dengan jejak audit.
10. **Saldo & rekap tidak disimpan sebagai kolom statis** — dihitung dari akumulasi transaksi.
11. **⭐ WAJIB: `status_spk`, `status_tagihan`, `kategori`, `jenis_sumber`, `peran`, dan
    `mitra.kategori` divalidasi memakai PHP Enum + dropdown.**
    Karena schema hanya 5 tabel, kolom-kolom ini berupa teks. Tanpa validasi Enum,
    laporan akan **terpecah** (mis. "Material" vs "Material Bangunan" vs "Material2" jadi
    3 baris terpisah). Risiko ini sudah dibuktikan dengan uji di MariaDB — lihat `Schema.md` §8.
12. **Setiap transaksi sebaiknya memiliki bukti** — tidak wajib, tapi UI harus mendorong user.
    **Jumlah file bebas** (disimpan sebagai JSON array di kolom `bukti`).
13. **Kolom keterangan tersedia pada `uang_masuk` dan `uang_keluar`.**
    > 📌 Pada tabel `spk`, kolom `keterangan` **dihapus** sesuai keputusan user.

14. **⭐ `status_tagihan` DISINKRONKAN OTOMATIS dari pembayaran nyata.**
    Diatur oleh `SinkronStatusTagihanObserver` (dipasang di model `UangMasuk`).

    | Kondisi | Status yang di-set |
    |---|---|
    | Piutang lancar = 0 | `Dibayar` |
    | Ada piutang, sudah ada pembayaran | `MenungguPembayaran` |
    | Belum ada pembayaran & status sebelumnya di-set sistem | `BelumDitagihkan` |
    | Belum ada pembayaran & status **manual** (`SudahDitagihkan`/`RevisiDokumen`) | **tidak disentuh** |

    > ⚠️ Tanpa sinkronisasi ini, status bisa tertulis "Dibayar" padahal uangnya
    > belum masuk — laporan jadi tidak benar.
    > Diuji di `tests/Feature/SinkronStatusTagihanTest.php`.

15. **⭐ UANG MASUK TIDAK BOLEH MELEBIHI PIUTANG LANCAR SPK.**
    Untuk SPK yang dipilih, `jumlah` dibatasi `sisaTagih() − sudah_diterima`
    (`sisaTagih()` = `nilai_spk − sudah_diterima`, tidak pernah negatif).
    Kalau melebihi, form menolak dengan pesan yang menjelaskan batasnya.
    > Uang masuk **luar SPK** (mode manual, `spk_id` NULL) **tidak dibatasi**.
    > Diuji di `tests/Feature/BatasUangMasukTest.php`.
    >
    > 📌 Catatan (10 Okt 2026): dokumen lama menyebut `nilaiTagih()` — nama itu
    > tidak ada di kode. Yang dipakai: `Spk::piutang()` / `Spk::sisaTagih()`.

16. **❌ UMUR PIUTANG (AGING) TIDAK DIPAKAI** — keputusan user 19 Sep 2026.
    Sebelumnya dokumen ini menjanjikan aging piutang (kelompok `0-30`/`31-60`/
    `61-90`/`>90`), padahal **kode tidak punya `Spk::kategoriUmur()`** dan
    laporan tidak menampilkannya. Sama seperti retensi & laba-rugi, aging
    dihapus dari sistem. Yang dipakai hanya **tenggat SPK** (butir 17).

17. **⭐ TENGGAT SPK (`tanggal_akhir`) DIPAKAI untuk peringatan.**
    - Lewat tenggat → badge merah
    - ≤ 14 hari lagi → badge kuning
    Implementasi: `Spk::labelTenggat()`, scope `lewatTenggat()`, `mendekatiTenggat()`.

## 3. Status Kanonis

### 3.1 Status SPK

```
Draft ──► Terbit ──► Berjalan ──► Selesai ──► Sudah Ditagihkan
  │          │           │            │
  └──────────┴───────────┴────────────┴──► Dibatalkan
```

| Status | Makna | Kondisi Pemicu | Aksi Berikutnya |
|---|---|---|---|
| **Draft** | SPK dibuat, belum resmi | Admin menyimpan sebagai draft | Lengkapi data, ubah ke Terbit |
| **Terbit** | SPK resmi bernomor, pekerjaan belum mulai | Admin simpan SPK final | Mulai pekerjaan, ubah ke Berjalan |
| **Berjalan** | Pekerjaan sedang berlangsung | Admin memperbarui saat pekerjaan dimulai | Input progres, catat transaksi |
| **Selesai** | Selesai administratif & operasional | Admin menandai selesai | Arsipkan |
| **Sudah Ditagihkan** | Tagihan sudah diajukan | Admin mencatat penagihan | Pantau pembayaran |
| **Dibatalkan** | SPK tidak dilanjutkan | Admin membatalkan | Simpan alasan |

> 📌 **Perlu Follow-up** diposisikan sebagai **flag/to-do**, **bukan** status siklus utama.

### 3.2 Status Tagihan

`Belum Ditagihkan` → `Sudah Ditagihkan` → `Revisi Dokumen` → `Menunggu Pembayaran` → `Dibayar`

## 4. Aturan Akses (Role-Based)

Sistem hanya memiliki **2 role**:

| Role | Boleh | Tidak Boleh |
|---|---|---|
| **Admin** | CRUD SPK, input uang masuk & keluar, upload bukti, kelola Mitra | Kelola Pengguna (hanya Direktur) |
| **Direktur** | Monitoring dashboard, lihat semua data, ekspor laporan, **kelola Pengguna** (tambah/ubah/hapus akun, kecuali akun sendiri) | CRUD transaksi & SPK (input data) |

> 📌 Catatan (10 Okt 2026): dokumen lama menulis Admin boleh *"manajemen user
> (jika diberi kewenangan)"*. Kenyataannya kode menetapkan **hanya Direktur**
> yang boleh mengelola Pengguna (`PenggunaResource::canViewAny()` = Direktur).
> Direktur juga **tidak boleh** menonaktifkan/menghapus **akunnya sendiri**
> (pengaman sistem terkunci).

> ⚠️ **Authorization wajib memakai middleware role** — **bukan** hanya menyembunyikan menu.
> Direktur yang mencoba membuka halaman input harus **ditolak sistem**, bukan sekadar
> tidak melihat menunya.

## 5. Aturan Validasi Wajib di Setiap Form

1. **Tanggal transaksi tidak boleh lebih dari hari ini** (kecuali input transaksi terlambat
   yang harus disertai catatan).
2. **Nominal harus > 0** — tolak nilai negatif atau nol.
3. **SPK yang dipilih harus valid** — SPK berstatus `Dibatalkan` **DITOLAK**
   untuk transaksi baru (uang masuk & uang keluar), tanpa pengecualian.
   > 📌 Catatan (10 Okt 2026): dokumen lama menyebut *"kecuali ada override
   > khusus oleh Admin"*, tetapi **mekanisme override itu tidak pernah ada di
   > kode**. Sistem menerapkan aturan secara KETAT (lebih aman). Kalau nanti
   > perusahaan memang butuh override, tambahkan dulu fitur & aturannya —
   > jangan menuliskan janji yang tidak dijalankan.
4. **Setiap transaksi wajib punya kategori yang valid.**
5. **Upload bukti:** validasi MIME type, ukuran maksimal 5–10 MB, nama file unik (timestamp/UUID).
6. **Format tampilan rupiah di Blade tidak boleh mengubah nilai asli di database.**

## 6. Aturan Penamaan & Konvensi Kode

- **Backend Laravel mengikuti PSR-12.**
- Kelas PHP baru menggunakan `declare(strict_types=1);`.
- Nama class, method, dan variable deskriptif.
- **Frontend menggunakan komponen reusable** dan satu pola state management.
- **Jangan menaruh logika bisnis kompleks di Blade atau controller** — gunakan service/action.
- Nama variabel/fungsi di kode boleh bahasa Inggris (`camelCase` method, `PascalCase` class).
- **Format mata uang selalu Rupiah (Rp)**, pemisah ribuan titik: `Rp 15.000.000`.
- **Format tanggal:** `DD-MM-YYYY` di UI, `YYYY-MM-DD` di database.
- Nama tabel database mengikuti konvensi Laravel (`snake_case`, plural).
- **Warna badge = SATU SUMBER KEBENARAN di enum.** Semua warna badge
  (status, kategori, peran, akun, dll) WAJIB didefinisikan sebagai method
  `warnaBadge(): string` pada enum terkait — **jangan** tulis peta warna
  `match(...)` di dalam tabel/form. Alasan: satu status bisa tampil di beberapa
  halaman; kalau warnanya ditulis terpisah, bisa berbeda tanpa disadari.
  Warna mengikuti standar tema Tailwind/TailAdmin (`gray|brand|success|warning|error`). Dikunci oleh `tests/Feature/PetaWarnaBadgeTest.php`.
- **Mode gelap (dark mode) adalah keadaan yang WAJIB didukung.** Setiap halaman
  baru harus diverifikasi di mode gelap (latar `#09090b`, teks terang, badge
  kontras). ⚠️ Saat memverifikasi halaman Admin-only, pakai akun **Admin** —
  sebagai Direktur halaman itu 403 (latar putih = halaman error, bukan bug tema).
- **Aksen warna = satu saja** (biru enterprise `#2563eb`). Jangan warna-warni
  per modul.

## 7. Framework & Best Practices

- Gunakan **Blade Template** untuk frontend.
- Gunakan **Form Request** untuk validasi endpoint Laravel.
- Gunakan **Eloquent relationship secara eksplisit**.
- Gunakan **migration, seeder, dan factory** yang dapat dijalankan ulang dengan aman.
- Gunakan **pagination** untuk tabel besar.
- Gunakan **eager loading** dan **aggregate query** pada dashboard — hindari N+1.
- Tambahkan **automated tests** untuk authorization, validasi, relasi penting, perhitungan
  retensi, dan akurasi rupiah.
- Desain database mengikuti **normalisasi 3NF**.

## 8. Data Integrity

1. **Foreign key constraint** pada semua relasi.
2. **Unique constraint** pada `spk_number` dan `email`.
3. **Nominal rupiah `DECIMAL(18,2)`** — dilarang `FLOAT`.
4. **Retensi TIDAK dihitung** (lihat §2) — kolomnya sudah dihapus dari tabel `spk`.
5. **Gunakan transaction** untuk operasi yang mengubah beberapa tabel.
6. **Jangan menghapus histori keuangan** — gunakan soft delete.
7. **Index** pada kolom yang sering difilter: `spk_number`, status, tanggal, foreign key.

## 9. Security Policy

1. **Password wajib hashing Laravel** (Bcrypt/Argon2) — tidak pernah plain text, tidak di-log.
2. **Authorization wajib role/middleware** — bukan hanya menyembunyikan menu.
3. **Data keuangan hanya tersedia untuk user yang berwenang** dan sudah login.
4. **File bukti hanya dapat diakses user yang sudah login.**
5. **Jangan menampilkan stack trace** atau detail database di production.
6. **Rahasia dan kredensial** hanya melalui environment/config secret.
7. **`.env` tidak boleh** ter-commit ke Git dan tidak boleh diakses dari web.
8. **Batasi akses folder upload dan database** agar tidak diubah di luar aplikasi.
9. **Batasi akses fisik** ke PC server (PC Direktur).
10. **Tidak ada akun/password default di repo.** Seeder hanya untuk data
    **demo** (`APP_ENV != production`) dan **menolak jalan di produksi**.
    Akun pertama dibuat lewat perintah interaktif **`php artisan app:buat-admin`**
    (password diminta tersembunyi, minimal 8 karakter huruf+angka).
    Seeder demo memakai password dari `BKS_SEEDER_PASSWORD` bila di-set,
    selain itu password acak — **tidak pernah** `password` literal.
11. **Notifikasi ekspor memerlukan queue worker.** `Filament\Notifications\DatabaseNotification`
    meng-`implements ShouldQueue`; jalankan `php artisan queue:work` di produksi
    (`QUEUE_CONNECTION=database`). Status worker terlihat di halaman **Status Sistem**.

## 10. Log Aktivitas — ❌ DIHAPUS

**Keputusan user 19 September 2026: audit log tidak perlu.**

Konsekuensi yang perlu disadari:

| Dampak | Penjelasan |
|---|---|
| **Menyimpang dari SRS NFR-SEC-004** | SRS mewajibkan *"setiap perubahan nominal & upload dokumen harus tercatat"* |
| Tidak ada jejak siapa mengubah nominal | Kalau ada selisih angka, sulit ditelusuri |
| Tidak ada rekam jejak penghapusan | Soft delete tetap ada, tapi tidak ada catatan siapa & kapan |

**Jika nanti diperlukan**, bisa ditambahkan tanpa mengubah schema:
1. Package `spatie/laravel-activitylog` — otomatis membuat tabelnya sendiri
2. Tambah tabel `log_aktivitas` — jadi 6 tabel

## 11. Aturan Deployment Lokal (WAJIB)

Karena sistem berjalan **lokal** di jaringan kantor (lihat `Architecture.md` §7):

1. **Database hanya ada di PC server (PC Direktur)** — tidak ada sinkronisasi multi-DB.
2. **PC server wajib memakai static IP** agar alamat akses tidak berubah.
3. **Backup otomatis wajib dijadwalkan** (database + folder upload).
4. **Uji restore** minimal sekali sebelum sistem dipakai penuh.
5. **UPS sangat disarankan** untuk PC server dan router.
6. **Jangan gunakan `php artisan serve`** untuk pemakaian harian — gunakan web server proper.
7. **Jangan buka aplikasi langsung ke internet.** Jika butuh akses luar, gunakan VPN (Tailscale).
8. **Service auto-start** agar aplikasi hidup otomatis setelah PC menyala.

## 12. Git & Review

1. Gunakan **branch feature** dengan commit kecil dan deskriptif.
2. Jalankan **formatter, static analysis, dan test** sebelum merge.
3. **Pull request wajib menjelaskan** perubahan schema, risiko keamanan, dan cara verifikasi.
4. **Jangan mencampur refactor besar** dengan fitur tanpa alasan jelas.
5. Setiap perubahan pada `docs/` mengikuti konvensi commit yang jelas (lihat git log).

## 13. Prioritas Pengembangan (Sprint)

1. **Data Mitra** (PLN, pelanggan, vendor, subkon) + **PHP Enum** (Status SPK, Status Tagihan, Kategori Pengeluaran).
2. **Modul SPK** — entitas inti.
3. **Modul Transaksi** (Uang Masuk 2 mode, Uang Keluar).
4. **Laporan** (SPK, Uang Masuk, Uang Keluar, Cashflow, Piutang).
   Laba-Rugi per SPK TIDAK dipakai — lihat §2.
5. **Dashboard** — bergantung pada data transaksi & laporan.

> Urutan dependensi: **scope → SRS → ERD → flowchart → layout → implementation**.

## 14. Hal yang Masih Perlu Dikunci Sebelum Coding

| No | Hal | Status |
|---|---|---|
| 1 | **Pilihan deployment:** lokal | ✅ **Lokal** — PC Direktur server, PC Admin client. **PC boleh dipakai kerja lain** |
| 2 | **Formula** retensi & estimasi profit | ❌ **Tidak dipakai** — retensi & laba-rugi dihapus (lihat §2). Sistem murni mencatat |
| 3 | **Status kanonis** SPK & tagihan | ✅ Sudah dikunci (§3) |
| 4 | **Kolom `keterangan` pada SPK** | ✅ **Dihapus** |
| 5 | **Audit log** | ✅ **Dihapus** (menyimpang dari SRS NFR-SEC-004) |
| 6 | **Jumlah file bukti** | ✅ **Bebas** (JSON array) |
| 7 | **Upload dokumen SPK** (BAST, kuitansi, scan) | ✅ **SELESAI** 29 Sep 2026 — kolom `spk.dokumen` (JSON), banyak berkas per SPK |
| 8 | **Data keuangan final dari Admin** | ⏳ Belum diterima |
| 9 | **Rekening koran:** format & peran | ⏳ Belum |
| 10 | **Data lama 2024–2026:** import atau mulai dari nol | ⏳ Belum |
| 11 | **Pajak (PPN/PPh)** perlu dihitung atau tidak | ⏳ Belum |

## 15. Referensi Silang

- Kebutuhan fitur & scope: **PRD.md**
- Struktur teknis & deployment: **Architecture.md**
- Struktur database: **Schema.md**
- Tampilan & alur UI: **Design.md**

---

*Keputusan user 19 September 2026 sudah diterapkan.*
