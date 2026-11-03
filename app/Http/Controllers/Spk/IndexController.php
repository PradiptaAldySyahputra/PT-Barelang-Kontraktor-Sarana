<?php

declare(strict_types=1);

namespace App\Http\Controllers\Spk;

use Illuminate\View\View;

/**
 * Halaman LIST SPK pada panel Blade (/panel/spk).
 *
 * Controller ini sengaja TIPIS: hanya menyiapkan kerangka halaman
 * (judul + keterangan). Seluruh pencarian, penyaringan, pengurutan, dan
 * paginasi ada di komponen Livewire App\Livewire\Spk\SpkTable.
 *
 * Pola ini dipakai untuk semua halaman daftar berikutnya.
 */
final class IndexController
{
    public function __invoke(): View
    {
        return view('spk.index', [
            'judul' => 'List SPK',
            'keterangan' => 'Data induk SPK: nomor, pekerjaan, nilai, dan status',
        ]);
    }
}
