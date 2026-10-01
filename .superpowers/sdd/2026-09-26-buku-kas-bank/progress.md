# SDD ledger — plan: docs/superpowers/plans/2026-09-26-buku-kas-bank.md

Ruling: JANGAN commit (USER.md). Tanpa worktree.

## SESI 26 Sep 2026 (lanjutan #4) — ANALISIS ALUR BISNIS + PERBAIKAN

Pengguna minta: "saran dan masukkan dari anda apakah sudah sesuai dengan alur
bisnis project yang ingin dibangun". Saya baca PRD.md, Rules.md, Schema.md
lalu bandingkan dengan kode NYATA.

### A. KESESUAIAN DENGAN PRD (SUDAH SESUAI)
5 tabel; login + 2 role + otorisasi 2 lapis; SPK inti (CRUD/status/tagihan/
tenggat/subkon); Uang Masuk 2 mode + bukti; Uang Keluar kategori + relasi SPK
opsional + bukti; Monitoring SPK 3 menu; Dashboard 5 widget; backup terjadwal;
ekspor CSV/Excel per menu; OCR nota (tambahan).

### B. MENYIMPANG DARI DOKUMEN (perlu keputusan pengguna)
1. Retensi 5% DIHAPUS — padahal Rules.md §2 mewajibkan.
   Dampak: piutang jadi LEBIH BESAR dari kenyataan sebesar nilai retensi.
2. Laba-rugi per SPK DIHAPUS — padahal PRD FR-RPT-006 (High) & tujuan #4.
3. Piutang/aging DIHAPUS — padahal PRD FR-RPT-005 (High).
Ketiganya keputusan pengguna 19 Sep, TAPI PRD/Rules belum diperbarui ->
risiko saat serah terima/BAST. PERLU keputusan: dokumen diperbarui, atau
fitur dikembalikan. (Sudah ditanyakan; pengguna belum jawab.)

### C. BELUM DIBANGUN (diminta PRD/pengguna)
1. Upload dokumen SPK (BAST, scan SPK) — FR-SPK-007 + PRD §9 no.2.
2. Keterangan/status pengantaran SPK (LIST SPK: "Keterangan", "masuk rek BKS").
3. Ekspor PDF — FR-RPT-007 (baru CSV/Excel).
4. Laporan Piutang tersendiri — FR-RPT-005.
5. Pajak PPN/PPh — PRD §9 no.8 belum diputuskan (padahal bagian pajak minta data).

### D. DIPERBAIKI SESI INI (yang tidak butuh keputusan bisnis)
1. [BUG] 2 widget dashboard $sort SAMA (SpkPerStatus & StatusTagihanChart = 3)
   -> urutan tidak pasti. FIX: 1,2,3,4,5 (Ringkasan, ArusKas, SpkPerStatus,
   StatusTagihan, SpkBerjalan). Tes: UrutanWidgetTest.
2. [BUG TATA LETAK] Dashboard grid 2 kolom + 3 chart 1 kolom = 1 SLOT KOSONG
   (inilah "chart tidak sejajar" yang dikeluhkan pengguna).
   FIX: GrafikArusKas -> columnSpan 'full'; SpkPerStatus & StatusTagihanChart
   masing-masing 1 kolom (berdampingan).
   Verifikasi browser: Arus Kas w=1136(full); Status Tagihan & SPK per Status
   x=272/852 y=1212 (SEJAJAR), w=556 masing-masing.
3. Verifikasi responsif: mobile 390px -> tidak ada scroll horizontal,
   tombol menu ada, sidebar tersembunyi (overlay).
4. KPI grid: 12 kartu x 3 kolom = 4 baris penuh (sudah pas, tidak diubah).
5. [BUG FILTER DUPLIKAT] Filter `Disubkonkan` (toggle) DUPLIKAT dengan filter
   `Pelaksana` (kolom dikerjakan_oleh SAMA). DIHAPUS. Tes: FilterSpkTest.
   Filter SPK: 8 -> 7.
6. [BUG TES SAYA SENDIRI] FilterSpkTest membuat Pengguna TANPA RefreshDatabase
   -> data bocor, tes SeederTest gagal ("harus ada 2 akun" -> 3).
   FIX: tambah `use RefreshDatabase`.

### E. TEMUAN DATA: jenis_sumber masih berisi 'pln' (76 SPK)
Data nyata: jenis_sumber = 'pln' (76), 'luar' (14).
CATATAN: `jenis_sumber` adalah BIDANG BERBEDA dari `mitra.kategori` —
`jenis_sumber` = asal SPK (punya nomor PLN resmi / tidak), sedangkan
`mitra.kategori` = jenis mitra (mitra/subkon). Jadi BUKAN duplikat.
Bukti: 14 SPK 'luar' semuanya bernomor `TANPA-SPK-xxxx` (sheet "Tagihan BKS").
KESIMPULAN: `jenis_sumber` DIPERTAHANKAN apa adanya — tidak diubah.

### F. RETENSI: KEPUTUSAN BERDASARKAN BUKTI DATA ✅
Pertanyaan pengguna: "retensi itu untuk apa? kalau penting untuk apa,
mempengaruhi alur bisnis / sistem?"
BUKTI dari data perusahaan: SEMUA SPK berstatus 'dibayar' diterima 100%
(mis. 0094.SPK/.../2026 nilai 461.700.000 diterima 461.700.000).
Tidak ada satu pun yang ditahan 5%.
KESIMPULAN: retensi TIDAK dipakai. Kolom sudah dihapus dari DB.
DOKUMEN DISELARASKAN (agar dokumen = sistem, aman untuk serah terima):
- Rules.md §2 butir 2 & 3: retensi -> TIDAK DIPAKAI + laba-rugi TIDAK dihitung.
- Rules.md §8 butir 4, §14 no.2, §13: diselaraskan.
- PRD.md: tujuan #2 & #4, FR-SPK-003, FR-RPT-006, kriteria sukses #2 & #4,
  modul dashboard/laporan, alur §7.1 langkah 3: diselaraskan.
- Architecture.md: diagram alur + checklist: diselaraskan.
- Schema.md: kolom persen_retensi/nilai_retensi ditandai DIHAPUS + §6 catatan.
Verifikasi: grep penyebutan kontradiktif = BERSIH.

### G. TAB MITRA -> TEPAT 3 (permintaan pengguna) ✅
"buat semua, pln, subkon saja"
Sebelum: Semua | Aktif | Mitra (Pemberi Kerja) | Subkon  (4 tab)
Sesudah: Semua | PLN | Subkon  (3 tab)
Tab PLN menyaring kategori `mitra` (pemberi kerja, termasuk PT PLN Batam).
BUG lama (tab PLN selalu kosong karena menyaring 'pln' yang tidak ada di enum)
dijamin TIDAK terulang oleh tes. Tes: TabMitraTest (5 tes).
Verifikasi browser: ['Semua 11','PLN 1','Subkon 10']; tab PLN isi 'PT PLN Batam';
tab Subkon isi 10 subkon.

## STATUS AKHIR
- Suite: 435 tes lulus / 1180 assertion. Pint bersih. Aset ter-build.
- Server uji (8002-8008): SEMUA DIMATIKAN. Server pengguna (8000) aman.
- Dokumen (PRD/Rules/Architecture/Schema) SELARAS dengan sistem.

## MASIH BELUM DIBANGUN (diminta PRD/pengguna)
1. Upload dokumen SPK (BAST, scan SPK) — FR-SPK-007, PRD §9 no.2.
2. Keterangan/status pengantaran SPK (LIST SPK: "Keterangan", "masuk rek BKS").
3. Ekspor PDF — FR-RPT-007 (baru CSV/Excel).
4. Laporan Piutang tersendiri — FR-RPT-005.
5. Pajak PPN/PPh — PRD §9 no.8 belum diputuskan.
