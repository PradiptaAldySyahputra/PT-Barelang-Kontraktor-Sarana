<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Schemas\UangKeluarForm;
use App\Models\Pengguna;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tata letak BUKTI KIRI / FORM KANAN — permintaan user:
 *   "gambar bukti masih terpotong, bisa anda buat bersebelahan kiri kanan,
 *    kiri bukti kanan form yang jelas bukti terlihat full dan jelas"
 *
 * Diuji di sini (bukan di TataLetakUangKeluarTest) karena itu file untuk
 * layout SECTION (atas-bawah) — dua hal berbeda, jangan dicampur.
 */
class TataLetakBuktiFormTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-bukti@bks.test',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function bagianRepeater(): array
    {
        $schema = UangKeluarForm::configureSekaligus(Schema::make());
        $hasil = [];

        foreach ($schema->getComponents(withActions: false) as $section) {
            foreach ($section->getDefaultChildComponents() as $child) {
                if (! $child instanceof Repeater) {
                    continue;
                }

                foreach ($child->getDefaultChildComponents() as $isi) {
                    if ($isi instanceof Placeholder) {
                        $hasil['bukti'] = $isi;
                    } elseif ($isi instanceof Group) {
                        $hasil['form'] = $isi;
                    }
                }
            }
        }

        return $hasil;
    }

    /**
     * Repeater memakai grid 5 kolom agar rasio 2:3 bisa dibentuk.
     */
    public function test_repeater_memakai_grid_5_kolom(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString(
            'repeat(5, minmax(0, 1fr))',
            $html,
            'Repeater harus 5 kolom supaya bukti (2) dan form (3) bisa berdampingan',
        );
    }

    /**
     * Bukti di KIRI: span 2 dari 5 kolom.
     */
    public function test_bukti_berada_di_kolom_kiri(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString(
            '--col-span-lg: span 2 / span 2',
            $html,
            'Bukti harus span 2 (kolom kiri)',
        );
    }

    /**
     * Form di KANAN: span 3 dari 5 kolom.
     */
    public function test_form_berada_di_kolom_kanan(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString(
            '--col-span-lg: span 3 / span 3',
            $html,
            'Form harus span 3 (kolom kanan)',
        );
    }

    /**
     * Di layar sempit keduanya harus menumpuk (masing-masing 2 kolom penuh),
     * supaya tidak berdesakan di HP/tablet.
     */
    public function test_di_layar_sempit_menumpuk(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        // default (mobile) = span 2 dari 2 kolom = lebar penuh
        $this->assertStringContainsString('--col-span-default: span 2 / span 2', $html);
        $this->assertStringContainsString(
            '--cols-default: repeat(1, minmax(0, 1fr))',
            $html,
            'Di mobile harus 1 kolom (menumpuk atas-bawah)',
        );
    }

    /**
     * Nota harus TIDAK terpotong: gambar dibungkus kotak `object-contain`
     * dengan tinggi tetap, bukan `w-full` yang memotong.
     */
    public function test_nota_memakai_object_contain(): void
    {
        $view = file_get_contents(resource_path('views/filament/components/pratinjau-nota.blade.php'));

        $this->assertStringContainsString(
            'object-contain',
            $view,
            'Nota harus object-contain supaya tampil utuh, tidak terpotong',
        );

        $this->assertStringContainsString(
            'nota-kotak',
            $view,
            'Nota harus dibungkus kotak (nota-kotak) agar batasnya jelas',
        );

        // Tidak boleh lagi memakai `w-full` BERDIRI SENDIRI pada <img> —
        // itu penyebab nota terpotong. Catatan: `max-w-full` SAH (itu yang
        // membuat gambar tidak melebihi lebar kotak), jadi regex harus
        // menolak "w-full" yang menempel pada tanda hubung.
        $this->assertDoesNotMatchRegularExpression(
            '/<img[^>]*class="[^"]*(?<![-\w])w-full(?![-\w])/',
            $view,
            'Gambar nota TIDAK boleh memakai w-full berdiri sendiri — itu membuat nota terpotong',
        );
    }
}
