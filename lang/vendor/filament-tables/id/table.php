<?php

/*
 * Terjemahan Indonesia untuk Filament Tables.
 *
 * ⚠️ KENAPA FILE INI ADA (temuan uji deploy 7 Okt 2026):
 * Filament v5 TIDAK menyediakan kunci `table.columns.icon.boolean.true/false`
 * untuk locale `id` (hanya ada di `en`). Akibatnya kolom `IconColumn->boolean()`
 * (mis. kolom "Aktif" di Mitra & Pengguna) memakai fallback bahasa Inggris —
 * teks alternatif untuk pembaca layar berbunyi "Yes"/"No", padahal aplikasi
 * berbahasa Indonesia (Rules §6).
 *
 * File override ini DIGABUNG dengan terjemahan bawaan paket (Laravel memuat
 * override per-kunci), jadi cukup menambahkan kunci yang hilang.
 */
return [
    'columns' => [
        'icon' => [
            'boolean' => [
                'true' => 'Ya',
                'false' => 'Tidak',
            ],
        ],
    ],
];
