<?php

/*
 * Terjemahan Indonesia untuk Filament Tables.
 *
 * ⚠️ KENAPA FILE INI ADA (temuan uji deploy 7 Okt 2026, diperluas 9 Okt 2026):
 * Filament v5 TIDAK menyediakan beberapa kunci untuk locale `id`, sehingga
 * teks Inggris bocor ke UI (melanggar Rules §6):
 *   - `columns.icon.boolean.true/false` — kolom IconColumn->boolean()
 *     (mis. "Aktif" di Mitra & Pengguna) memakai fallback "Yes"/"No".
 *   - `loading` ("Loading..."), `result_count` ("10 results" di bawah tabel),
 *     `column_manager.actions.reorder.label`, dll.
 *
 * File override ini DIGABUNG dengan terjemahan bawaan paket (Laravel memuat
 * override per-kunci), jadi cukup menambahkan kunci yang hilang.
 */
return [
    'loading' => 'Memuat...',

    'result_count' => '{0} Tanpa hasil|{1} :count hasil|[2,*] :count hasil',

    'column_manager' => [
        'actions' => [
            'reorder' => [
                'label' => 'Urutkan kolom',
            ],
        ],
    ],

    'actions' => [
        'reorder_record' => [
            'label' => 'Urutkan item :key',
        ],
        'toggle_record_content' => [
            'label' => 'Buka/tutup item :key',
        ],
    ],

    'columns' => [
        'icon' => [
            'boolean' => [
                'true' => 'Ya',
                'false' => 'Tidak',
            ],
        ],
    ],
];
