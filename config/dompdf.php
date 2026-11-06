<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Dompdf (barryvdh/laravel-dompdf)
|--------------------------------------------------------------------------
|
| PENTING: paket ini membaca opsi dari `dompdf.options` (array bersarang),
| bukan dari kunci tingkat atas. Hanya `options` yang ditimpa di sini;
| sisanya memakai bawaan Dompdf.
|
*/

return [

    'options' => [

        /*
         * Bawaan paket: false. Akibatnya SELURUH berkas font DejaVu (≈450 KB
         * per varian) ikut tertanam di tiap PDF, padahal yang dipakai hanya
         * puluhan glyph — PDF laporan jadi ~950 KB.
         * Dengan subsetting: hanya glyph terpakai yang disematkan.
         */
        'enable_font_subsetting' => true,

    ],

];
