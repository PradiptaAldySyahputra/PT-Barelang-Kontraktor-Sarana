<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Siapa yang mengerjakan SPK ini.
 *
 * | Nilai | Arti |
 * |---|---|
 * | `sendiri` | Dikerjakan tim kita |
 * | `subkon` | Disubkonkan ke pihak lain — kita bayar mereka |
 *
 * ⚠️ KENAPA INI PERLU (permintaan user):
 * Contoh kasus: ada pekerjaan bangun 5 gardu. Kita kerjakan 3, sisanya 2
 * diserahkan ke subkon. Supaya jelas mana yang dikerjakan sendiri dan mana
 * yang disubkonkan — termasuk untuk kontrol keuangan (uang keluar ke subkon).
 *
 * Karena schema dibatasi 5 tabel, pekerjaan yang sebagian disubkonkan
 * dibuat sebagai **SPK terpisah** (mis. "Gardu 1-3" dan "Gardu 4-5 subkon").
 */
enum DikerjakanOleh: string
{
    case Sendiri = 'sendiri';
    case Subkon = 'subkon';

    public function label(): string
    {
        return match ($this) {
            self::Sendiri => 'Dikerjakan Sendiri',
            self::Subkon => 'Disubkonkan',
        };
    }

    /**
     * Label pendek untuk badge/tabel.
     */
    public function labelPendek(): string
    {
        return match ($this) {
            self::Sendiri => 'Sendiri',
            self::Subkon => 'Subkon',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function opsi(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $k): array => [$k->value => $k->label()])
            ->all();
    }
}
