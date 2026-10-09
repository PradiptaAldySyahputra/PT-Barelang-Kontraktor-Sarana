<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Pages\CreateUangKeluar;
use App\Filament\Resources\UangKeluars\Schemas\UangKeluarForm;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Uji form "Tambah Uang Keluar" — 1 berkas bisa berisi BEBERAPA nota.
 *
 * MASALAH NYATA yang harus diselesaikan:
 *   1 halaman A4 (contoh: nota-contoh.pdf) bisa berisi 4 form "NOTA NO."
 *   sekaligus. Jadi "1 berkas = 1 nota" adalah asumsi yang SALAH.
 *
 * ⚠️ RIWAYAT KEPUTUSAN DESAIN — jangan dibalik tanpa alasan:
 *
 *   1. Awalnya: 1 berkas = 1 baris, tanpa batas.
 *   2. User minta "paling banyak 4" → dikunci 4.
 *   3. User minta "boleh lebih dari 4, bebas" → batas jadi 20 (pengaman).
 *   4. Sempat pakai DROPDOWN "Nota / Berkas": admin menambah baris manual
 *      lalu memilih berkas yang sama di tiap baris.
 *      → DITOLAK karena tidak praktis (kerja dua kali: unggah, lalu pilih lagi).
 *   5. DESAIN SEKARANG: admin isi "Jumlah nota" per berkas, sistem membuat
 *      baris rincian otomatis. Tidak ada dropdown, tidak ada tambah baris
 *      manual. Ini yang paling sesuai cara kerja admin.
 *
 * Yang diuji:
 *   1. `susunBaris()` menghasilkan baris sebanyak jumlah nota.
 *   2. 1 berkas 4 nota → 4 baris; campur beberapa berkas → total benar.
 *   3. Batas MAKS_BARIS & MAKS_NOTA_PER_BERKAS ditegakkan.
 *   4. Tidak ada lagi dropdown "Nota / Berkas".
 *   5. Penyimpanan ke database benar (kolom `bukti` terisi path).
 */
class NotaSekaligusTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('nota');

        $this->admin = Pengguna::factory()->admin()->create(['email' => 'admin-nota@bks.test']);
    }

    private function nota(string $nama = 'nota.pdf'): UploadedFile
    {
        return UploadedFile::fake()->create($nama, 100, 'application/pdf');
    }

    /**
     * Bantu: susun baris dari daftar berkas (path + jumlah nota).
     *
     * ⚠️ DEFAULT MODE SEKARANG 'rinci' (1 nota = 1 baris), keputusan user
     * 8 Okt 2026. Tes yang menguji perilaku "1 berkas = 1 baris total" harus
     * memakai mode 'total' secara eksplisit.
     *
     * @param  array<int, array{path: string, nota: int, mode?: string}>  $berkas
     * @return array<int, array<string, mixed>>
     */
    private function susun(array $berkas, ?string $modePaksa = null): array
    {
        $state = [];

        foreach ($berkas as $i => $b) {
            $state['item-'.$i] = [
                'file' => $b['path'],
                'jumlah_nota' => $b['nota'],
                'mode' => $b['mode'] ?? $modePaksa ?? UangKeluarForm::MODE_DEFAULT,
            ];
        }

        return UangKeluarForm::susunBaris($state);
    }

    /**
     * Bantu: susun baris dalam mode RINCI (1 nota = 1 baris).
     *
     * Dipakai tes yang menguji pemecahan per nota.
     *
     * @param  array<int, array{path: string, nota: int}>  $berkas
     * @return array<int, array<string, mixed>>
     */
    private function susunRinci(array $berkas): array
    {
        return $this->susun($berkas, 'rinci');
    }

    // =========================================================
    // 1. MODE RINCI: JUMLAH BARIS = JUMLAH NOTA
    //
    // ⚠️ Mode rinci harus diminta EKSPLISIT sekarang, karena default sudah
    // 'total' (permintaan admin untuk berkas gabungan sebulan).
    // =========================================================

    public function test_mode_rinci_satu_berkas_empat_nota_menghasilkan_empat_baris(): void
    {
        $baris = $this->susunRinci([
            ['path' => 'uang_keluar/satu-pdf-4-nota.pdf', 'nota' => 4],
        ]);

        $this->assertCount(4, $baris, '1 berkas berisi 4 nota harus menghasilkan 4 baris');
    }

    /**
     * ⚠️ PERILAKU BARU — inti permintaan admin:
     *   "1 file upload itu satu form untuk semua total dari nota yang diupload"
     *
     * 1 berkas gabungan (mis. 57 nota sebulan) harus jadi 1 BARIS saja.
     */
    public function test_mode_total_satu_berkas_banyak_nota_menghasilkan_satu_baris(): void
    {
        $baris = $this->susun([
            ['path' => 'uang_keluar/nota-sebulan.pdf', 'nota' => 57, 'mode' => 'total'],
        ]);

        $this->assertCount(
            1,
            $baris,
            'Mode total: 1 berkas = 1 baris, walau isinya 57 nota',
        );

        // Baris total ditandai nota_ke = 0 dan mode 'total'.
        $this->assertSame(0, $baris[0]['nota_ke'], 'Baris total ditandai nota_ke = 0');
        $this->assertSame('total', $baris[0]['mode']);
        $this->assertSame(57, $baris[0]['nota_dari'], 'Jumlah nota tetap dicatat untuk info');
        $this->assertNull($baris[0]['potongan'], 'Mode total pakai berkas utuh, bukan potongan');
    }

    /**
     * Default mode HARUS 'rinci' (keputusan user 8 Okt 2026): saat satu berkas
     * berisi banyak nota, tiap nota dipotong & dibuatkan form sendiri.
     */
    public function test_default_mode_adalah_rinci(): void
    {
        $this->assertSame('rinci', UangKeluarForm::MODE_DEFAULT);
    }

    public function test_satu_berkas_satu_nota_menghasilkan_satu_baris(): void
    {
        $baris = $this->susun([
            ['path' => 'uang_keluar/foto.jpg', 'nota' => 1],
        ]);

        $this->assertCount(1, $baris);
    }

    public function test_dua_berkas_dengan_nota_berbeda_menghasilkan_total_yang_benar(): void
    {
        // Kasus campuran: PDF 4 nota + foto 2 nota = 6 baris
        $baris = $this->susunRinci([
            ['path' => 'uang_keluar/empat.pdf', 'nota' => 4],
            ['path' => 'uang_keluar/dua.jpg', 'nota' => 2],
        ]);

        $this->assertCount(6, $baris, '4 nota + 2 nota harus jadi 6 baris');
    }

    /**
     * Kasus yang diminta user: "total nota dalam satu pdf bisa aja jadi 2
     * atau 3 atau bisa lebih" — jadi jumlahnya harus bebas, bukan dipaku 4.
     */
    public function test_jumlah_nota_per_berkas_bebas_dua_tiga_atau_lebih(): void
    {
        foreach ([2, 3, 5, 7] as $jumlah) {
            $baris = $this->susunRinci([
                ['path' => 'uang_keluar/uji.pdf', 'nota' => $jumlah],
            ]);

            $this->assertCount(
                $jumlah,
                $baris,
                "Jumlah nota $jumlah harus menghasilkan $jumlah baris",
            );
        }
    }

    /**
     * PENANDA ASAL BERKAS — permintaan user:
     *   "bisa diberi pembeda untuk setiap bukti atau nota karna anda hanya buat
     *    pengeluaran 1 sampai selanjutnya itu bergabung dengan nota yang lain
     *    jadi admin tidak ada navigasi yang jelas untuk membedakanya"
     *
     * Tiap baris harus mencatat: berkas ke-berapa, dari total berapa, dan
     * nota ke-berapa di dalam berkas itu.
     */
    public function test_tiap_baris_mencatat_nomor_berkas_dan_nota(): void
    {
        $baris = $this->susunRinci([
            ['path' => 'uang_keluar/empat.pdf', 'nota' => 4],
            ['path' => 'uang_keluar/dua.jpg', 'nota' => 2],
        ]);

        // 4 baris pertama = berkas 1 dari 2
        foreach (range(0, 3) as $i) {
            $this->assertSame(1, $baris[$i]['berkas_ke'], "Baris $i harus berkas 1");
            $this->assertSame(2, $baris[$i]['berkas_dari'], 'Total berkas harus 2');
            $this->assertSame($i + 1, $baris[$i]['nota_ke'], 'Nomor nota harus berurutan');
            $this->assertSame(4, $baris[$i]['nota_dari']);
        }

        // 2 baris berikutnya = berkas 2 dari 2
        foreach (range(4, 5) as $i) {
            $this->assertSame(2, $baris[$i]['berkas_ke'], "Baris $i harus berkas 2");
            $this->assertSame($i - 3, $baris[$i]['nota_ke'], 'Nomor nota di berkas 2 mulai dari 1');
            $this->assertSame(2, $baris[$i]['nota_dari']);
        }
    }

    /**
     * Jumlah nota DEFAULT = 4 (permintaan user), tapi tetap bisa diubah.
     */
    public function test_default_jumlah_nota_adalah_4(): void
    {
        $this->assertSame(4, UangKeluarForm::DEFAULT_NOTA);
    }

    public function test_field_jumlah_nota_default_4_dan_masih_bisa_diubah(): void
    {
        $this->actingAs($this->admin);

        // Default 4 diperiksa dari STATE form (sumber kebenaran), bukan dari
        // atribut `value` di HTML — Filament memakai `wire:model`, jadi input
        // tidak punya atribut value.
        $test = Livewire::test(CreateUangKeluar::class);

        $berkas = $test->get('data.berkas_nota');
        $this->assertIsArray($berkas);
        $this->assertNotEmpty($berkas, 'Harus ada 1 baris berkas default');

        $pertama = reset($berkas);
        $this->assertSame(
            4,
            (int) ($pertama['jumlah_nota'] ?? 0),
            'Jumlah nota default harus 4',
        );

        // Masih bisa diubah: field tidak disabled/readonly di HTML.
        $html = $test->html();

        $this->assertStringContainsString('jumlah_nota', $html);
        $this->assertDoesNotMatchRegularExpression(
            '/jumlah_nota[^>]*\s(disabled|readonly)\b/',
            $html,
            'Field jumlah nota tidak boleh disabled/readonly — harus bisa diubah',
        );
    }

    /**
     * Penanda baris harus benar-benar dirender — memakai TEKS (nomor nota),
     * bukan lagi badge warna (desain baru 8 Okt 2026).
     */
    public function test_ada_penanda_berkas_di_tiap_baris(): void
    {
        $view = file_get_contents(resource_path('views/filament/components/penanda-berkas.blade.php'));

        $this->assertStringContainsString('Nota', $view);
        $this->assertStringContainsString('TOTAL', $view, 'Mode total harus jelas tertulis');
    }

    /**
     * Desain baru: garis kiri MONOKROM tipis (bukan warna-warni per berkas).
     */
    public function test_tema_punya_garis_pembeda_monokrom(): void
    {
        $css = file_get_contents(resource_path('css/filament/admin/theme.css'));

        $this->assertStringContainsString('border-left-width: 2px', $css);
        // Warna-warni lama harus HILANG.
        $this->assertStringNotContainsString('penanda-berkas-1', $css);
        $this->assertStringNotContainsString('border-left-color: #10b981', $css);
    }

    // =========================================================
    // 2. TIAP BARIS TERHUBUNG OTOMATIS KE BERKASNYA
    // =========================================================

    public function test_tiap_baris_menunjuk_berkas_yang_benar(): void
    {
        $baris = $this->susunRinci([
            ['path' => 'uang_keluar/empat.pdf', 'nota' => 4],
            ['path' => 'uang_keluar/satu.jpg', 'nota' => 1],
        ]);

        // 4 baris pertama -> empat.pdf
        foreach (range(0, 3) as $i) {
            $this->assertSame(
                ['uang_keluar/empat.pdf'],
                $baris[$i]['bukti'],
                "Baris $i harus menunjuk empat.pdf",
            );
        }

        // Baris ke-5 -> satu.jpg
        $this->assertSame(['uang_keluar/satu.jpg'], $baris[4]['bukti']);
    }

    /**
     * Nomor nota dicatat, supaya admin tahu ini nota ke-berapa dari berkas itu.
     */
    public function test_baris_mencatat_nomor_nota(): void
    {
        $baris = $this->susunRinci([
            ['path' => 'uang_keluar/empat.pdf', 'nota' => 4],
        ]);

        foreach (range(0, 3) as $i) {
            $this->assertSame($i + 1, $baris[$i]['nota_ke'], 'Nomor nota harus berurutan');
            $this->assertSame(4, $baris[$i]['nota_dari'], 'Total nota berkas harus tercatat');
        }
    }

    // =========================================================
    // 3. BATAS PENGAMAN
    // =========================================================

    public function test_jumlah_baris_tidak_melebihi_batas_pengaman(): void
    {
        // 5 berkas × 10 nota = 50, tapi batasnya 20
        $berkas = [];

        foreach (range(1, 5) as $i) {
            $berkas[] = ['path' => "uang_keluar/b$i.pdf", 'nota' => 10];
        }

        $baris = $this->susunRinci($berkas);

        $this->assertLessThanOrEqual(
            UangKeluarForm::MAKS_BARIS,
            count($baris),
            'Jumlah baris harus dibatasi MAKS_BARIS sebagai pengaman',
        );
    }

    public function test_jumlah_nota_per_berkas_dibatasi(): void
    {
        // Salah ketik 4000 harus ditahan jadi MAKS_NOTA_PER_BERKAS
        $baris = $this->susunRinci([
            ['path' => 'uang_keluar/salah-ketik.pdf', 'nota' => 4000],
        ]);

        $this->assertLessThanOrEqual(
            UangKeluarForm::MAKS_NOTA_PER_BERKAS,
            count($baris),
            'Jumlah nota per berkas harus dibatasi — menahan salah ketik',
        );
    }

    /**
     * Jumlah nota tidak masuk akal (0 / negatif / kosong) -> pakai DEFAULT 4.
     *
     * ⚠️ PERUBAHAN KEPUTUSAN (jangan diubah tanpa bertanya ke user):
     * Sebelumnya nilai tidak masuk akal dianggap 1. Sekarang mengikuti
     * DEFAULT_NOTA (4) karena user meminta: "untuk jumlah nota default buat
     * saja langsung 4 form tetapi masih bisa diubah".
     *
     * Alasannya: kalau berkas sudah diunggah tapi jumlah nota kosong/aneh,
     * kemungkinan besar admin belum mengisinya — dan ekspektasi user adalah
     * 4 (1 lembar A4 biasanya berisi 4 nota). Admin tetap bisa mengubahnya.
     */
    public function test_jumlah_nota_nol_atau_kosong_pakai_default(): void
    {
        foreach ([0, -3, null] as $nilai) {
            $baris = $this->susunRinci([
                ['path' => 'uang_keluar/uji.pdf', 'nota' => $nilai],
            ]);

            $this->assertCount(
                UangKeluarForm::DEFAULT_NOTA,
                $baris,
                'Jumlah nota kosong/tidak masuk akal harus pakai DEFAULT_NOTA',
            );
        }
    }

    /**
     * Berkas yang belum diunggah (tidak ada path) tidak boleh membuat baris.
     */
    public function test_berkas_tanpa_file_tidak_membuat_baris(): void
    {
        $baris = $this->susun([
            ['path' => '', 'nota' => 4],
        ]);

        // Tetap ada 1 baris kosong sebagai tempat mulai (bukan 4)
        $this->assertCount(1, $baris);
        $this->assertEmpty($baris[0]['bukti'] ?? []);
    }

    // =========================================================
    // 4. TAMPILAN — DROPDOWN SUDAH DIHAPUS
    // =========================================================

    /**
     * Pemilih MODE harus ada — inilah yang membuat admin bisa memilih
     * "1 berkas = 1 baris" (total) atau "1 baris per nota" (rinci).
     *
     * ⚠️ Field "Jumlah nota" TIDAK selalu tampil: hanya di mode rinci.
     * Di mode total (default) field itu disembunyikan karena tidak diperlukan.
     */
    public function test_ada_pemilih_mode_total_atau_rinci(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('Cara mencatat berkas ini', $html);
        $this->assertStringContainsString('Total (1 berkas = 1 baris)', $html);
        $this->assertStringContainsString('Rinci (1 baris per nota)', $html);
    }

    /**
     * Field "Jumlah nota" harus tetap TERDAFTAR di schema (dipakai mode rinci),
     * walau secara default disembunyikan.
     *
     * Diperiksa dari file schema, bukan render HTML — supaya tes tidak rapuh
     * dan tidak bergantung pada container Livewire.
     */
    public function test_field_jumlah_nota_terdaftar_di_schema(): void
    {
        $sumber = file_get_contents(
            app_path('Filament/Resources/UangKeluars/Schemas/UangKeluarForm.php')
        );

        $this->assertStringContainsString(
            "TextInput::make('jumlah_nota')",
            $sumber,
            'Field jumlah_nota harus ada untuk mode rinci',
        );

        // Harus disembunyikan saat mode total.
        $this->assertStringContainsString(
            "=== 'rinci'",
            $sumber,
            'Field jumlah_nota harus punya kondisi visible berdasar mode',
        );
    }

    /**
     * ⚠️ REGRESI: dropdown "Nota / Berkas" TIDAK boleh kembali.
     *
     * Dropdown itu ditolak user karena tidak praktis — admin harus mengunggah
     * berkas lalu memilihnya LAGI di tiap baris.
     */
    public function test_dropdown_nota_berkas_sudah_tidak_ada(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        $this->assertStringNotContainsString(
            'pilih berkas nota',
            $html,
            'Dropdown "Nota / Berkas" harus sudah dihapus — diganti field "Jumlah nota"',
        );
    }

    /**
     * Tidak ada tombol tambah baris manual di bagian rincian — baris dibuat
     * otomatis dari jumlah nota.
     */
    public function test_tidak_ada_tambah_baris_manual_di_rincian(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        $this->assertStringNotContainsString('Tambah baris pengeluaran', $html);
    }

    public function test_halaman_menjelaskan_satu_berkas_bisa_beberapa_nota(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('4 nota', $html);
    }

    public function test_halaman_tambah_menampilkan_placeholder_pratinjau(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('pratinjau', strtolower($html));
    }

    // =========================================================
    // 5. PENYIMPANAN
    // =========================================================

    public function test_simpan_beberapa_baris_menyimpan_beberapa_transaksi(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'berkas_nota' => [
                    'b1' => ['file' => [$this->nota('satu.pdf')], 'jumlah_nota' => 1],
                ],
            ])
            ->fillForm([
                'pengeluaran' => [
                    ['tanggal' => '2026-09-01', 'jumlah' => 1_000_000, 'kategori' => 'material'],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(1, UangKeluar::count());
        $this->assertSame(1_000_000.0, (float) UangKeluar::sum('jumlah'));
    }

    /**
     * Nota harus tersimpan di kolom `bukti` — kalau tidak, bukti hilang.
     */
    public function test_nota_tersimpan_di_kolom_bukti(): void
    {
        $this->actingAs($this->admin);

        $test = Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'berkas_nota' => [
                    'b1' => ['file' => [$this->nota('bukti-saya.pdf')], 'jumlah_nota' => 1],
                ],
            ]);

        // Isi isian admin TANPA mengganti struktur baris — seperti yang
        // dilakukan browser asli (mengirim array lengkap dengan `bukti`).
        // Mengganti seluruh array lewat fillForm akan menghapus `bukti`.
        $test->call('$set', 'data.pengeluaran.'.array_key_first($test->get('data.pengeluaran')).'.tanggal', '2026-09-01');
        $test->call('$set', 'data.pengeluaran.'.array_key_first($test->get('data.pengeluaran')).'.jumlah', 1_000_000);
        $test->call('$set', 'data.pengeluaran.'.array_key_first($test->get('data.pengeluaran')).'.kategori', 'material');

        $test->call('create')->assertHasNoFormErrors();

        $keluar = UangKeluar::first();

        $this->assertNotNull($keluar->bukti, 'Kolom bukti harus terisi path nota');
        $this->assertIsArray($keluar->bukti);
        $this->assertNotEmpty($keluar->bukti);
    }

    /**
     * ⚠️ REGRESI BUG PENTING.
     *
     * Versi lama memanggil `$f->store('public')` — padahal parameter pertama
     * `store()` adalah NAMA FOLDER, bukan nama disk. Akibatnya file tersimpan
     * di folder bersarang `storage/app/public/public/xxx.pdf` sehingga nota
     * TIDAK bisa dibuka (file "belum ada").
     */
    public function test_path_nota_tidak_bersarang_di_folder_public(): void
    {
        $this->actingAs($this->admin);

        $test = Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'berkas_nota' => [
                    'b1' => ['file' => [$this->nota('path-uji.pdf')], 'jumlah_nota' => 1],
                ],
            ]);

        // Isi tanpa mengganti struktur baris (lihat catatan di tes bukti).
        $kunci = array_key_first($test->get('data.pengeluaran'));
        $test->call('$set', 'data.pengeluaran.'.$kunci.'.tanggal', '2026-09-01');
        $test->call('$set', 'data.pengeluaran.'.$kunci.'.jumlah', 1_000_000);
        $test->call('$set', 'data.pengeluaran.'.$kunci.'.kategori', 'material');

        $test->call('create')->assertHasNoFormErrors();

        $keluar = UangKeluar::first();
        $path = is_array($keluar->bukti) ? ($keluar->bukti[0] ?? null) : $keluar->bukti;

        $this->assertNotNull($path, 'Path nota tidak boleh kosong');
        $this->assertStringStartsWith('uang_keluar/', $path);
        $this->assertStringNotContainsString('public/', $path);
    }

    public function test_disk_default_adalah_public(): void
    {
        // Bug sebelumnya: FILESYSTEM_DISK=local membuat file tersimpan di
        // storage/app/private yang TIDAK bisa diakses browser, sehingga
        // semua link bukti 404.
        $this->assertSame('public', config('filament.default_filesystem_disk'));
    }
}
