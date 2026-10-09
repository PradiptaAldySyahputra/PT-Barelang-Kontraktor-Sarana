<?php

/*
 * Terjemahan Indonesia — Filament Panels (layout).
 *
 * ⚠️ KENAPA FILE INI ADA (temuan uji deploy 7 Okt 2026, diperluas 9 Okt 2026):
 * Filament v5 belum menerjemahkan beberapa kunci ke locale `id`, sehingga
 * teks Inggris bocor ke UI — melanggar Rules §6 ("seluruh UI berbahasa
 * Indonesia"). Contoh yang terlihat pengguna:
 *   - "Skip to content"  (tautan lompat navigasi)
 *   - "Search"           (label aksesibilitas kotak pencarian)
 *   - "Theme" / "Topbar" / "Sidebar navigation" (label pembaca layar)
 *
 * File override ini DIGABUNG dengan terjemahan bawaan paket (Laravel memuat
 * override per-kunci), jadi cukup menambahkan kunci yang hilang.
 */
return [
    'skip_to_content' => [
        'label' => 'Lewati ke konten',
    ],

    'navigation' => [
        'label' => 'Navigasi sidebar',
    ],

    'topbar' => [
        'label' => 'Bilah atas',
    ],

    'actions' => [
        'open_database_notifications' => [
            'label_with_unread_count' => '{1} Notifikasi, :count belum dibaca|[2,*] Notifikasi, :count belum dibaca',
        ],

        'theme_switcher' => [
            'label' => 'Tema',
        ],
    ],
];
