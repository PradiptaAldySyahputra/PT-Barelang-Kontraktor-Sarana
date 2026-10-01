<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Enums\StatusAntar;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use PHPUnit\Framework\TestCase;

/**
 * UNIT TEST — ENUM: NILAI, LABEL, & LOGIKA TURUNAN.
 *
 * ⚠️ KENAPA ENUM DIUJI TERPISAH (`docs/Rules.md` §2 butir 11):
 *   "WAJIB: status_spk, status_tagihan, kategori, jenis_sumber, peran, dan
 *    mitra.kategori divalidasi memakai PHP Enum + dropdown."
 *
 * Karena schema hanya 5 tabel, kolom-kolom ini berupa TEKS di database. Enum
 * adalah **satu-satunya penjaga** agar laporan tidak terpecah
 * ("Material" vs "Material Bangunan" vs "Material2" = 3 baris terpisah).
 *
 * Kalau nilai enum berubah tanpa sengaja (mis. `dibayar` → `sudah_dibayar`),
 * data lama di database jadi tidak dikenali dan laporan langsung rusak.
 * Uji ini mengunci nilai-nilai itu.
 *
 * 📌 Unit test murni — Enum tidak menyentuh database sama sekali.
 */
class EnumTest extends TestCase
{
    // ---------------------------------------------------------------
    // NILAI TERKUNCI (jangan berubah — data lama bergantung padanya)
    // ---------------------------------------------------------------

    public function test_nilai_status_spk_terkunci(): void
    {
        $this->assertSame([
            'draft',
            'terbit',
            'berjalan',
            'selesai',
            'sudah_ditagihkan',
            'dibatalkan',
        ], array_column(StatusSpk::cases(), 'value'));
    }

    public function test_nilai_status_tagihan_terkunci(): void
    {
        $this->assertSame([
            'belum_ditagihkan',
            'sudah_ditagihkan',
            'revisi_dokumen',
            'menunggu_pembayaran',
            'dibayar',
        ], array_column(StatusTagihan::cases(), 'value'));
    }

    public function test_nilai_kategori_pengeluaran_terkunci(): void
    {
        $this->assertSame([
            'material',
            'upah',
            'operasional',
            'gaji',
            'nota',
            'transportasi',
            'lainnya',
        ], array_column(KategoriPengeluaran::cases(), 'value'));
    }

    public function test_nilai_akun_kas_terkunci(): void
    {
        // Hanya 2 — sesuai Excel perusahaan (sheet KAS + BANK).
        $this->assertSame(['kas', 'bank'], array_column(AkunKas::cases(), 'value'));
    }

    public function test_nilai_status_antar_terkunci(): void
    {
        // 3 nilai — keputusan pengguna 26 Sep 2026.
        $this->assertSame(
            ['belum', 'sudah_diantar', 'diterima'],
            array_column(StatusAntar::cases(), 'value'),
        );
    }

    // ---------------------------------------------------------------
    // LABEL & OPSI (dipakai dropdown)
    // ---------------------------------------------------------------

    public function test_semua_enum_punya_label_tidak_kosong(): void
    {
        foreach ([
            StatusSpk::cases(),
            StatusTagihan::cases(),
            KategoriPengeluaran::cases(),
            AkunKas::cases(),
            StatusAntar::cases(),
        ] as $kumpulan) {
            foreach ($kumpulan as $kasus) {
                $this->assertNotSame(
                    '',
                    trim($kasus->label()),
                    "Label untuk {$kasus->value} tidak boleh kosong.",
                );
            }
        }
    }

    public function test_opsi_cocok_dengan_jumlah_nilai(): void
    {
        /*
         * `opsi()` dipakai untuk mengisi dropdown. Kalau jumlahnya tidak sama
         * dengan jumlah nilai enum, ada status yang tidak bisa dipilih admin —
         * dan itu menyebabkan data tidak konsisten.
         */
        $this->assertCount(count(StatusSpk::cases()), StatusSpk::opsi());
        $this->assertCount(count(StatusTagihan::cases()), StatusTagihan::opsi());
        $this->assertCount(count(KategoriPengeluaran::cases()), KategoriPengeluaran::opsi());
        $this->assertCount(count(AkunKas::cases()), AkunKas::opsi());
        $this->assertCount(count(StatusAntar::cases()), StatusAntar::opsi());
    }

    public function test_opsi_memakai_value_sebagai_kunci(): void
    {
        // Kunci dropdown HARUS nilai enum (yang disimpan ke DB), bukan label.
        foreach (StatusSpk::opsi() as $kunci => $label) {
            $this->assertNotNull(
                StatusSpk::tryFrom($kunci),
                "Kunci opsi '{$kunci}' harus nilai enum yang sah.",
            );
            $this->assertNotSame('', trim($label));
        }
    }

    // ---------------------------------------------------------------
    // WARNA BADGE (dipakai tampilan)
    // ---------------------------------------------------------------

    public function test_semua_enum_punya_warna_badge(): void
    {
        foreach ([
            StatusSpk::cases(),
            StatusTagihan::cases(),
            AkunKas::cases(),
            StatusAntar::cases(),
        ] as $kumpulan) {
            foreach ($kumpulan as $kasus) {
                $this->assertNotSame(
                    '',
                    trim($kasus->warnaBadge()),
                    "Warna badge {$kasus->value} tidak boleh kosong.",
                );
            }
        }
    }

    // ---------------------------------------------------------------
    // LOGIKA TURUNAN
    // ---------------------------------------------------------------

    public function test_spk_dibatalkan_tidak_boleh_transaksi_baru(): void
    {
        /*
         * ⚠️ `Rules.md` §5 butir 3: "SPK berstatus Dibatalkan tidak menerima
         * transaksi baru". Ini penjaga agar transaksi tidak masuk ke pekerjaan
         * yang sudah batal.
         */
        $this->assertFalse(
            StatusSpk::Dibatalkan->bolehTransaksiBaru(),
            'SPK Dibatalkan TIDAK boleh menerima transaksi baru.',
        );

        foreach ([StatusSpk::Draft, StatusSpk::Terbit, StatusSpk::Berjalan] as $status) {
            $this->assertTrue(
                $status->bolehTransaksiBaru(),
                "SPK {$status->value} harus boleh menerima transaksi.",
            );
        }
    }

    public function test_status_akhir_menandakan_pekerjaan_tidak_aktif(): void
    {
        $this->assertTrue(StatusSpk::Selesai->isAkhir());
        $this->assertTrue(StatusSpk::SudahDitagihkan->isAkhir());
        $this->assertTrue(StatusSpk::Dibatalkan->isAkhir());

        $this->assertFalse(
            StatusSpk::Berjalan->isAkhir(),
            'SPK Berjalan masih aktif — tidak boleh dianggap akhir.',
        );
        $this->assertFalse(StatusSpk::Terbit->isAkhir());
    }

    public function test_status_tagihan_dibayar_bukan_piutang(): void
    {
        $this->assertFalse(
            StatusTagihan::Dibayar->isPiutang(),
            'Tagihan Dibayar tidak lagi piutang.',
        );

        foreach ([
            StatusTagihan::BelumDitagihkan,
            StatusTagihan::SudahDitagihkan,
            StatusTagihan::RevisiDokumen,
            StatusTagihan::MenungguPembayaran,
        ] as $status) {
            $this->assertTrue(
                $status->isPiutang(),
                "Tagihan {$status->value} masih piutang — harus masuk laporan piutang.",
            );
        }
    }

    public function test_pengantaran_belum_berarti_dokumen_belum_keluar(): void
    {
        $this->assertFalse(
            StatusAntar::Belum->sudahKeluar(),
            'Dokumen "Belum Diantar" berarti belum keluar.',
        );
        $this->assertTrue(StatusAntar::SudahDiantar->sudahKeluar());
        $this->assertTrue(StatusAntar::Diterima->sudahKeluar());
    }
}
