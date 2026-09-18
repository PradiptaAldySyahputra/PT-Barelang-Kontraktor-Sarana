# Rules - Sistem Informasi Keuangan Internal PT Barelang Kontraktor Sarana

Dokumen ini berisi aturan wajib yang harus dipatuhi AI agent/developer saat membangun sistem. Tujuannya menjaga sistem tetap fokus, konsisten, dan tidak melebar dari ruang lingkup.

## 1. Batasan Ruang Lingkup (WAJIB DIPATUHI)

- Sistem ini **HANYA** untuk pencatatan keuangan & pembukuan internal. **DILARANG** menambahkan modul di luar itu, termasuk namun tidak terbatas pada:
  - Manajemen inventori/stok gudang.
  - Modul HRD, payroll, absensi karyawan.
  - Fitur multi-tenant/SaaS (langganan, billing untuk perusahaan lain).
  - Integrasi e-Faktur/pajak otomatis (fase lanjutan, bukan fase ini).
- Jika ada permintaan fitur baru yang tidak tercantum di PRD.md, agent harus menandai fitur tersebut sebagai "di luar scope" dan meminta konfirmasi eksplisit sebelum mengimplementasikan.

## 2. Aturan Bisnis (Business Rules)

1. **Setiap transaksi Uang Masuk WAJIB memiliki `id_proyek`** — pemasukan tanpa proyek tidak diperbolehkan (semua pemasukan berasal dari termin proyek).
2. **Transaksi Uang Keluar boleh memiliki `id_proyek = NULL`** hanya jika kategori biayanya bertipe operasional kantor (non-proyek). Untuk biaya langsung proyek (material, upah lapangan), `id_proyek` wajib diisi.
3. **Kategori biaya harus konsisten dengan tipe transaksi**: kategori bertipe `PEMASUKAN` hanya boleh dipakai pada transaksi `MASUK`, dan sebaliknya.
4. **Jumlah transaksi (`jumlah`) harus lebih besar dari 0.** Tidak ada transaksi dengan nilai nol atau negatif — arah transaksi ditentukan oleh `tipe_transaksi`, bukan tanda minus pada jumlah.
5. **Transaksi tidak boleh dihapus permanen.** Gunakan mekanisme void/soft-delete dengan jejak audit (siapa yang membatalkan, kapan, alasan) untuk menjaga integritas laporan keuangan historis.
6. **Saldo rekening bank tidak boleh disimpan sebagai kolom statis yang diedit manual** — saldo selalu dihitung dari `saldo_awal` + akumulasi transaksi, untuk mencegah data tidak sinkron.
7. **Kas Kecil (Petty Cash) diperlakukan sebagai rekening biasa** (`is_kas_kecil = TRUE`), bukan tabel terpisah — semua transaksi kas kecil tetap melalui alur `tabel_transaksi_keuangan` yang sama.
8. **Setiap transaksi sebaiknya memiliki bukti (`file_bukti`)** — tidak wajib secara sistem, tapi UI harus mendorong (encourage) user untuk selalu melampirkan bukti demi kelengkapan audit.

## 3. Aturan Akses (Role-Based)

| Role | Boleh | Tidak Boleh |
|---|---|---|
| Admin/Owner | Semua aksi, termasuk konfigurasi master data & hapus/void transaksi | - |
| Staf Keuangan | Input/edit transaksi, kelola master data, lihat semua laporan | Menghapus data secara permanen |
| Pengawas Lapangan | Input transaksi Uang Keluar (kas kecil) hanya untuk proyek yang ditugaskan | Melihat laporan laba-rugi proyek lain, mengedit master data, melihat data proyek di luar penugasannya |

## 4. Aturan Penamaan & Konvensi Kode

- Nama tabel database menggunakan `snake_case` berbahasa Indonesia sesuai Schema.md (jangan diterjemahkan ke bahasa Inggris agar konsisten dengan dokumen).
- Nama variabel/fungsi di kode program boleh menggunakan bahasa Inggris sesuai konvensi framework yang dipakai (misal Laravel: `camelCase` untuk method, `PascalCase` untuk class).
- Format mata uang selalu Rupiah (Rp), dengan pemisah ribuan titik (contoh: Rp 15.000.000).
- Format tanggal konsisten: `DD-MM-YYYY` di tampilan UI, `YYYY-MM-DD` di database.

## 5. Aturan Validasi Wajib di Setiap Form Transaksi

- Tanggal transaksi tidak boleh lebih dari hari ini (kecuali ada kebutuhan khusus input transaksi terlambat, yang harus disertai catatan/approval).
- Proyek yang dipilih harus berstatus `BERJALAN` atau `TERTUNDA` untuk transaksi baru (proyek `SELESAI` tidak menerima transaksi baru kecuali ada override khusus oleh Admin).
- Rekening/kas yang dipilih harus aktif (tidak dalam status nonaktif/arsip).

## 6. Prioritas Pengembangan (Jika Dipecah ke Sprint)

1. Master Data (Proyek, Rekening, Kategori) — fondasi wajib sebelum modul lain berjalan.
2. Modul Transaksi (Uang Masuk, Uang Keluar, Kas Kecil).
3. Modul Laporan (Arus Kas, Laba-Rugi Proyek, Piutang Termin).
4. Modul Dashboard (bergantung pada data transaksi & laporan yang sudah berjalan).

## 7. Referensi Silang Dokumen

- Kebutuhan fitur & scope: lihat **PRD.md**.
- Struktur teknis & tech stack: lihat **Architecture.md**.
- Tampilan & alur UI: lihat **Design.md**.
- Struktur database: lihat **Schema.md**.
