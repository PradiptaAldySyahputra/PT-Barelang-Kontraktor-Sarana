<?php

/*
 * Terjemahan Indonesia — Filament Forms (components) — kunci yang belum ada.
 *
 * ⚠️ Melengkapi locale `id` bawaan Filament v5 yang belum menerjemahkan kunci
 * ini, sehingga label pembaca layar (accessibility) tidak lagi berbahasa
 * Inggris. Contoh yang terlihat pengguna:
 *   - label bulan/tahun/jam pada pemilih tanggal-waktu
 *   - "Open in new tab" / "Download" pada unggahan berkas
 *   - label pencarian pada Select
 *
 * Digabung dengan terjemahan bawaan (override per-kunci).
 */
return [
    'select' => [
        'search_label' => 'Cari',
        'actions' => [
            'clear' => [
                'label' => 'Bersihkan pilihan',
            ],
            'remove_option' => [
                'label' => 'Hapus :label',
            ],
        ],
    ],

    'date_time_picker' => [
        'month_select' => [
            'label' => 'Bulan',
        ],
        'year_input' => [
            'label' => 'Tahun',
        ],
        'hour_input' => [
            'label' => 'Jam',
        ],
        'minute_input' => [
            'label' => 'Menit',
        ],
        'second_input' => [
            'label' => 'Detik',
        ],
    ],

    'file_upload' => [
        'editor' => [
            'label' => 'Editor gambar',
        ],
        'actions' => [
            'download' => [
                'label' => 'Unduh',
            ],
            'open' => [
                'label' => 'Buka di tab baru',
            ],
        ],
    ],

    'repeater' => [
        'columns' => [
            'actions' => [
                'label' => 'Tindakan',
            ],
            'reorder' => [
                'label' => 'Urutkan',
            ],
        ],
    ],

    'key_value' => [
        'columns' => [
            'actions' => [
                'label' => 'Tindakan',
            ],
            'reorder' => [
                'label' => 'Urutkan',
            ],
        ],
    ],

    'color_picker' => [
        'panel_label' => 'Pemilih warna',
    ],

    'rich_editor' => [
        'toolbar' => [
            'label' => 'Bilah alat editor',
        ],
    ],

    'tags_input' => [
        'tag_added' => 'Ditambahkan: :tag',
        'tag_removed' => 'Dihapus: :tag',
    ],
];
