{{--
    ============================================================
    HALAMAN STATUS SISTEM (B2-10)
    ============================================================

    Menampilkan kesehatan sistem: database, queue, backup, penyimpanan.
    Hanya Admin (dijaga di StatusSistemPage::canAccess()).

    Variabel: $status (list array)
--}}
<x-filament-panels::page>

    <x-filament::section>
        <x-slot name="heading">Kesehatan Sistem</x-slot>
        <x-slot name="description">
            Ringkasan kondisi sistem. Tanda merah berarti perlu ditindaklanjuti.
        </x-slot>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            @foreach ($status as $s)
                <div @class([
                    'rounded-lg border p-4',
                    'border-emerald-300 bg-emerald-50 dark:border-emerald-700 dark:bg-emerald-950' => $s['sehat'] === true,
                    'border-rose-300 bg-rose-50 dark:border-rose-700 dark:bg-rose-950' => $s['sehat'] === false,
                    'border-gray-200 dark:border-gray-700' => $s['sehat'] === null,
                ])>
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ $s['label'] }}</p>
                        <span @class([
                            'inline-flex h-2.5 w-2.5 rounded-full',
                            'bg-emerald-500' => $s['sehat'] === true,
                            'bg-rose-500' => $s['sehat'] === false,
                            'bg-gray-400' => $s['sehat'] === null,
                        ])></span>
                    </div>
                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $s['nilai'] }}</p>
                    <p class="mt-0.5 text-xs text-gray-600 dark:text-gray-400">{{ $s['keterangan'] }}</p>
                </div>
            @endforeach
        </div>
    </x-filament::section>

    <x-filament::section collapsible collapsed>
        <x-slot name="heading">Catatan untuk Administrator</x-slot>
        <ul class="list-disc space-y-1 pl-5 text-sm text-gray-600 dark:text-gray-400">
            <li>Queue worker dijalankan lewat: <code class="font-mono">php artisan queue:work</code> (atau service di server).</li>
            <li>Scheduler backup: <code class="font-mono">php artisan schedule:run</code> tiap menit (cron/Task Scheduler).</li>
            <li>Bila "job GAGAL" bertambah, periksa <code class="font-mono">storage/logs/laravel.log</code>.</li>
        </ul>
    </x-filament::section>

</x-filament-panels::page>
