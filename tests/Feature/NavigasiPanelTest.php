<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Lapisan navigasi panel: sidebar aktif, breadcrumb, dan tombol Kembali.
 *
 * Yang dijaga:
 *   - Dashboard hanya menyala tepat di /panel
 *   - anak menu tidak saling menyorot (List SPK vs Kalender/Monitoring,
 *     Unggah Nota vs Arsip Nota)
 *   - breadcrumb memakai induk modul yang benar, tanpa awalan "Dashboard"
 *   - tombol Kembali hanya di halaman anak dan URL-nya dari peta ?asal=
 */
final class NavigasiPanelTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    private Pengguna $direktur;

    private Mitra $mitra;

    private Spk $spk;

    private UangMasuk $uangMasuk;

    private UangKeluar $uangKeluar;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->create([
            'peran' => Peran::Admin,
            'is_aktif' => true,
        ]);

        $this->direktur = Pengguna::factory()->create([
            'peran' => Peran::Direktur,
            'is_aktif' => true,
        ]);

        $this->mitra = Mitra::factory()->create();
        $this->spk = Spk::factory()->create(['mitra_id' => $this->mitra->id]);
        $this->uangMasuk = UangMasuk::factory()->create([
            'spk_id' => null,
            'mitra_id' => null,
            'tanggal' => '2026-01-05',
            'jumlah' => 1_000_000,
        ]);
        $this->uangKeluar = UangKeluar::factory()->create(['spk_id' => null, 'jumlah' => 500_000]);
    }

    // ---------------------------------------------------------------- utilitas

    private function html(string $url, ?Pengguna $sebagai = null): string
    {
        $pengguna = $sebagai ?? $this->admin;

        $respons = $this->actingAs($pengguna)->get($url);
        $respons->assertOk();

        return $respons->getContent();
    }

    /**
     * Ambil blok breadcrumb (null bila halaman tidak punya breadcrumb).
     *
     * @return array{induk: ?string, indukUrl: ?string, judul: ?string, blok: ?string}
     */
    private function breadcrumb(string $html): array
    {
        if (preg_match('|<nav data-nav-breadcrumb.*?</nav>|s', $html, $cocok) !== 1) {
            return ['induk' => null, 'indukUrl' => null, 'judul' => null, 'blok' => null];
        }

        $blok = $cocok[0];

        $induk = null;
        $indukUrl = null;
        if (preg_match('|<a\s+data-nav-induk\s+href="([^"]+)"[^>]*>\s*(.*?)\s*</a>|s', $blok, $cocokInduk) === 1) {
            $indukUrl = html_entity_decode($cocokInduk[1], ENT_QUOTES);
            $induk = html_entity_decode(trim(strip_tags($cocokInduk[2])), ENT_QUOTES);
        }

        $judul = null;
        if (preg_match('|<span data-nav-halaman[^>]*>\s*(.*?)\s*</span>|s', $blok, $cocokJudul) === 1) {
            $judul = html_entity_decode(trim(strip_tags($cocokJudul[1])), ENT_QUOTES);
        }

        return ['induk' => $induk, 'indukUrl' => $indukUrl, 'judul' => $judul, 'blok' => $blok];
    }

    /**
     * Peta nama menu sidebar => status aktif ('1' menyala, '0' padam).
     *
     * @return array<string, string>
     */
    private function statusSidebar(string $html): array
    {
        preg_match_all('|data-menu="([^"]+)"\s+data-aktif="(\d)"|', $html, $cocok, PREG_SET_ORDER);

        $peta = [];
        foreach ($cocok as $baris) {
            $peta[html_entity_decode($baris[1], ENT_QUOTES)] = $baris[2];
        }

        return $peta;
    }

    private function kembaliUrl(string $html): ?string
    {
        if (preg_match('|<a\s+href="([^"]+)"\s+data-nav-kembali|', $html, $cocok) === 1) {
            return html_entity_decode($cocok[1], ENT_QUOTES);
        }

        return null;
    }

    // ------------------------------------------------------------ sidebar aktif

    public function test_dashboard_hanya_menyala_tepat_di_panel(): void
    {
        $dasbor = $this->statusSidebar($this->html('/panel'));
        $this->assertSame('1', $dasbor['Dashboard'] ?? null);

        foreach (['/panel/spk', '/panel/cash-in', '/panel/reports', '/panel/status'] as $url) {
            $peta = $this->statusSidebar($this->html($url));
            $this->assertSame('0', $peta['Dashboard'] ?? null, "Dashboard tidak boleh menyala di {$url}");
        }
    }

    public function test_menu_spk_menyorot_item_yang_tepat_dan_membuka_grup(): void
    {
        // Detail/ubah/tambah/status/billing SPK menyorot List SPK, bukan kalender.
        foreach ([
            route('panel.spk.show', $this->spk),
            route('panel.spk.edit', $this->spk),
            route('panel.spk.create'),
            route('panel.spk.status', $this->spk),
            route('panel.spk.billing', $this->spk),
        ] as $url) {
            $html = $this->html($url);
            $peta = $this->statusSidebar($html);

            $this->assertSame('1', $peta['List SPK'] ?? null, "List SPK harus menyala di {$url}");
            $this->assertSame('0', $peta['Kalender Tenggat'] ?? null, "Kalender tidak boleh menyala di {$url}");
            $this->assertStringContainsString('data-menu="SPK"', $html);
            $this->assertStringContainsString('data-terbuka="1"', $html, "Grup SPK harus terbuka di {$url}");
        }

        $kalender = $this->statusSidebar($this->html(route('panel.spk.calendar')));
        $this->assertSame('1', $kalender['Kalender Tenggat'] ?? null);
        $this->assertSame('0', $kalender['List SPK'] ?? null);
    }

    public function test_halaman_monitoring_menyorot_item_monitoring_yang_tepat(): void
    {
        foreach ([
            'status' => 'Status SPK',
            'billing' => 'Tagihan SPK',
            'completed' => 'Tagihan Selesai SPK',
        ] as $mode => $nama) {
            $html = $this->html(route('panel.spk.monitoring', $mode));
            $peta = $this->statusSidebar($html);

            $this->assertSame('1', $peta[$nama] ?? null, "{$nama} harus menyala di monitoring/{$mode}");
            $this->assertSame('0', $peta['List SPK'] ?? null, "List SPK tidak boleh menyala di monitoring/{$mode}");

            foreach (array_diff(['Status SPK', 'Tagihan SPK', 'Tagihan Selesai SPK'], [$nama]) as $lain) {
                $this->assertSame('0', $peta[$lain] ?? null, "{$lain} tidak boleh menyala di monitoring/{$mode}");
            }
        }
    }

    public function test_halaman_unggah_nota_hanya_menyorot_unggah_bukan_arsip(): void
    {
        $unggah = $this->statusSidebar($this->html(route('panel.receipts.upload')));
        $this->assertSame('1', $unggah['Unggah & Ekstraksi Nota'] ?? null);
        $this->assertSame('0', $unggah['Arsip Nota'] ?? null);

        $arsip = $this->statusSidebar($this->html(route('panel.receipts')));
        $this->assertSame('1', $arsip['Arsip Nota'] ?? null);
        $this->assertSame('0', $arsip['Unggah & Ekstraksi Nota'] ?? null);
    }

    public function test_halaman_profil_tidak_menyorot_menu_lain(): void
    {
        $peta = $this->statusSidebar($this->html(route('panel.profile')));

        foreach ($peta as $nama => $aktif) {
            $this->assertSame('0', $aktif, "Menu '{$nama}' tidak boleh menyala di halaman profil");
        }
    }

    // --------------------------------------------------------------- breadcrumb

    public function test_breadcrumb_memakai_induk_modul_yang_benar(): void
    {
        $harapan = [
            [route('panel.spk.index'), 'SPK', route('panel.spk.index')],
            [route('panel.spk.monitoring', 'status'), 'Monitoring SPK', route('panel.spk.monitoring', 'status')],
            [route('panel.spk.monitoring', 'billing'), 'Monitoring SPK', route('panel.spk.monitoring', 'status')],
            [route('panel.spk.monitoring', 'completed'), 'Monitoring SPK', route('panel.spk.monitoring', 'status')],
            [route('panel.cash-in.index'), 'Keuangan', route('panel.cash-in.index')],
            [route('panel.cash-out.index'), 'Keuangan', route('panel.cash-in.index')],
            [route('panel.receipts'), 'Nota & Bukti', route('panel.receipts')],
            [route('panel.receipts.upload'), 'Nota & Bukti', route('panel.receipts')],
            [route('panel.partners.index'), 'Master Data', route('panel.partners.index')],
            [route('panel.users.index'), 'Pengguna', route('panel.users.index')],
            [route('panel.status'), 'Sistem', route('panel.status')],
            [route('panel.backup'), 'Sistem', route('panel.status')],
            [route('panel.import'), 'Sistem', route('panel.status')],
        ];

        foreach ($harapan as [$url, $label, $urlInduk]) {
            $breadcrumb = $this->breadcrumb($this->html($url, $this->direktur));

            $this->assertNotNull($breadcrumb['blok'], "Breadcrumb hilang di {$url}");
            $this->assertSame($label, $breadcrumb['induk'], "Induk breadcrumb salah di {$url}");
            $this->assertSame($urlInduk, $breadcrumb['indukUrl'], "Pranala induk salah di {$url}");
        }
    }

    public function test_breadcrumb_halaman_anak_mengikuti_induk_yang_benar(): void
    {
        $status = $this->breadcrumb($this->html(route('panel.spk.status', $this->spk)));
        $this->assertSame('Status SPK', $status['induk']);
        $this->assertSame(route('panel.spk.monitoring', 'status'), $status['indukUrl']);

        $billing = $this->breadcrumb($this->html(route('panel.spk.billing', $this->spk)));
        $this->assertSame('Tagihan SPK', $billing['induk']);

        $edit = $this->breadcrumb($this->html(route('panel.spk.edit', $this->spk)));
        $this->assertSame('SPK', $edit['induk']);
        $this->assertSame(route('panel.spk.index'), $edit['indukUrl']);

        $mitra = $this->breadcrumb($this->html(route('panel.partners.edit', $this->mitra)));
        $this->assertSame('Mitra', $mitra['induk']);
        $this->assertSame(route('panel.partners.index'), $mitra['indukUrl']);

        $pengguna = $this->breadcrumb($this->html(route('panel.users.edit', $this->direktur), $this->direktur));
        $this->assertSame('Pengguna', $pengguna['induk']);
        $this->assertSame(route('panel.users.index'), $pengguna['indukUrl']);
    }

    public function test_tidak_ada_awalan_breadcrumb_dashboard_di_halaman_non_dashboard(): void
    {
        $halaman = [
            route('panel.spk.index'),
            route('panel.spk.calendar'),
            route('panel.spk.monitoring', 'status'),
            route('panel.spk.monitoring', 'billing'),
            route('panel.spk.monitoring', 'completed'),
            route('panel.cash-in.index'),
            route('panel.cash-out.index'),
            route('panel.receipts'),
            route('panel.receipts.upload'),
            route('panel.reports'),
            route('panel.partners.index'),
            route('panel.users.index'),
            route('panel.status'),
            route('panel.backup'),
            route('panel.import'),
            route('panel.profile'),
            route('panel.spk.show', $this->spk),
            route('panel.spk.create'),
            route('panel.spk.edit', $this->spk),
        ];

        foreach ($halaman as $url) {
            $breadcrumb = $this->breadcrumb($this->html($url, $this->direktur));

            if ($breadcrumb['blok'] === null) {
                continue;
            }

            $this->assertStringNotContainsString('Dashboard', $breadcrumb['blok'], "Breadcrumb di {$url} masih berawalan Dashboard");
        }
    }

    public function test_halaman_list_tidak_menduplikasi_judul_pada_breadcrumb(): void
    {
        foreach ([
            route('panel.cash-in.index'),
            route('panel.cash-out.index'),
            route('panel.reports'),
            route('panel.receipts'),
            route('panel.spk.index'),
            route('panel.partners.index'),
            route('panel.users.index'),
            route('panel.status'),
        ] as $url) {
            $breadcrumb = $this->breadcrumb($this->html($url, $this->direktur));

            if ($breadcrumb['blok'] === null) {
                continue;
            }

            $this->assertNotSame(
                $breadcrumb['judul'],
                $breadcrumb['induk'],
                "Breadcrumb di {$url} menduplikasi judul halaman"
            );
        }
    }

    public function test_dashboard_dan_laporan_tanpa_breadcrumb_dua_tingkat(): void
    {
        $this->assertNull($this->breadcrumb($this->html('/panel'))['blok']);
        $this->assertNull($this->breadcrumb($this->html(route('panel.reports')))['blok']);
        $this->assertNull($this->breadcrumb($this->html(route('panel.profile')))['blok']);
    }

    // ------------------------------------------------------------ tombol Kembali

    public function test_halaman_list_tidak_menampilkan_tombol_kembali(): void
    {
        foreach ([
            '/panel',
            route('panel.spk.index'),
            route('panel.spk.calendar'),
            route('panel.spk.monitoring', 'status'),
            route('panel.spk.monitoring', 'billing'),
            route('panel.spk.monitoring', 'completed'),
            route('panel.cash-in.index'),
            route('panel.cash-out.index'),
            route('panel.receipts'),
            route('panel.reports'),
            route('panel.partners.index'),
            route('panel.users.index'),
            route('panel.status'),
            route('panel.backup'),
            route('panel.import'),
        ] as $url) {
            $this->assertNull($this->kembaliUrl($this->html($url, $this->direktur)), "Tombol Kembali tidak boleh ada di {$url}");
        }
    }

    public function test_halaman_anak_menampilkan_tombol_kembali(): void
    {
        foreach ([
            route('panel.spk.show', $this->spk),
            route('panel.spk.create'),
            route('panel.spk.edit', $this->spk),
            route('panel.spk.status', $this->spk),
            route('panel.spk.billing', $this->spk),
            route('panel.receipts.upload'),
            route('panel.cash-in.create'),
            route('panel.cash-in.edit', $this->uangMasuk),
            route('panel.cash-out.create'),
            route('panel.cash-out.edit', $this->uangKeluar),
            route('panel.partners.create'),
            route('panel.partners.edit', $this->mitra),
        ] as $url) {
            $this->assertNotNull($this->kembaliUrl($this->html($url, $this->direktur)), "Tombol Kembali harus ada di {$url}");
        }

        $this->assertNotNull($this->kembaliUrl($this->html(route('panel.users.create'), $this->direktur)));
        $this->assertNotNull($this->kembaliUrl($this->html(route('panel.users.edit', $this->direktur), $this->direktur)));
    }

    public function test_tombol_kembali_mengikuti_peta_asal(): void
    {
        $dariDetail = $this->kembaliUrl($this->html(
            route('panel.spk.status', ['spk' => $this->spk, 'asal' => 'show'])
        ));
        $this->assertSame(route('panel.spk.show', $this->spk), $dariDetail);

        $dariTagihan = $this->kembaliUrl($this->html(
            route('panel.spk.status', ['spk' => $this->spk, 'asal' => 'tagihan-spk'])
        ));
        $this->assertSame(route('panel.spk.monitoring', 'billing'), $dariTagihan);

        $dariKalender = $this->kembaliUrl($this->html(
            route('panel.spk.show', ['spk' => $this->spk, 'asal' => 'calendar'])
        ));
        $this->assertSame(route('panel.spk.calendar'), $dariKalender);

        $unggah = $this->kembaliUrl($this->html(route('panel.receipts.upload')));
        $this->assertSame(route('panel.receipts'), $unggah);
    }

    public function test_asal_asing_tidak_dipakai_mentah_sebagai_tujuan(): void
    {
        foreach (['https://evil.example', '//evil.example', 'javascript:alert(1)'] as $asing) {
            $html = $this->html(route('panel.spk.edit', ['spk' => $this->spk, 'asal' => $asing]));
            $tujuan = $this->kembaliUrl($html);

            $this->assertNotNull($tujuan, "Tombol Kembali harus tetap ada untuk asal asing {$asing}");
            $this->assertStringNotContainsString('evil.example', $tujuan);
            $this->assertStringNotContainsString('javascript:', $tujuan);
            $this->assertSame(route('panel.spk.index'), $tujuan);
        }
    }

    /**
     * Atribut Alpine pada <x-layouts.app ...> hilang saat komponen dirender,
     * sehingga x-data/x-on di sana tidak pernah sampai ke DOM dan semua
     * ekspresi turunannya gagal ("modalBuka is not defined").
     */
    public function test_sidebar_melebar_saat_kursor_diarahkan(): void
    {
        // Sidebar yang diciutkan harus melebar saat kursor masuk dan mengecil lagi
        // saat kursor keluar; tanpa @mouseenter/@mouseleave fitur ini mati diam-diam.
        $isi = (string) file_get_contents(resource_path('views/layouts/sidebar.blade.php'));

        $this->assertStringContainsString('@mouseenter="$store.sidebar.setHovered(true)"', $isi);
        $this->assertStringContainsString('@mouseleave="$store.sidebar.setHovered(false)"', $isi);
    }

    public function test_alpine_data_selalu_berada_di_elemen_dalam_layout(): void
    {
        $pelanggaran = [];

        foreach (glob(resource_path('views').'/**/*.blade.php') ?: [] as $berkas) {
            $isi = (string) file_get_contents($berkas);

            if (preg_match('/<x-layouts\.app\b[^>]*\bx-(?:data|on:[a-z]+)=/s', $isi) === 1) {
                $pelanggaran[] = str_replace(resource_path('views').'/', '', $berkas);
            }
        }

        $this->assertSame([], $pelanggaran, 'x-data/x-on tidak boleh dipasang pada <x-layouts.app>: atributnya tidak diteruskan ke DOM.');
    }
}
