{{--
    Status Sistem (/panel/status) - HANYA Admin.
    Sumber angka: App\Support\StatusSistem::semua().
--}}
<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($status as $item)
            @php
                $nada = $item['sehat'] === null
                    ? 'border-gray-200 dark:border-gray-800'
                    : ($item['sehat'] ? 'border-success-200 dark:border-success-600/40' : 'border-error-200 dark:border-error-600/40');
            @endphp
            <section class="rounded-2xl border {{ $nada }} bg-white p-5 dark:bg-white/[0.03] shadow-theme-xs">
                <div class="flex items-start justify-between gap-2">
                    <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">{{ $item['label'] }}</h2>
                    @if ($item['sehat'] !== null)
                        <span class="inline-flex shrink-0 rounded-md px-2 py-0.5 text-theme-xs font-medium
                            {{ $item['sehat']
                                ? 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500'
                                : 'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-500' }}">
                            {{ $item['sehat'] ? 'Sehat' : 'Perlu dicek' }}
                        </span>
                    @endif
                </div>

                <p class="mt-2 truncate text-theme-sm font-medium text-gray-900 dark:text-white" title="{{ $item['nilai'] }}">
                    {{ $item['nilai'] }}
                </p>
                <p class="mt-0.5 break-words text-theme-xs text-gray-500 dark:text-gray-400">
                    {{ $item['keterangan'] }}
                </p>
            </section>
        @endforeach
    </div>
</x-layouts.app>