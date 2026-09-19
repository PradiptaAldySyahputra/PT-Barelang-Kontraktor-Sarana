{{--
    Pratinjau nota — ditampilkan SEJAJAR dengan form pengeluaran.

    Dipakai di dalam repeater form uang keluar:
        Placeholder::make('pratinjau')->content(fn (Get $get) =>
            view('filament.components.pratinjau-nota', ['files' => $get('bukti')]))

    Variabel:
        $files : array path file (relatif terhadap disk Filament)
--}}
@php
    use Illuminate\Support\Facades\Storage;

    $disk = config('filament.default_filesystem_disk', 'public');

    $daftar = collect(is_array($files ?? null) ? $files : [])
        ->filter()
        ->map(function ($f): ?string {
            // FileUpload bisa mengembalikan string path atau objek file.
            if (is_string($f)) {
                return $f;
            }

            if (is_object($f) && method_exists($f, 'getStatePath')) {
                return $f->getStatePath();
            }

            if (is_object($f) && method_exists($f, 'store')) {
                // File sementara (belum tersimpan) — simpan ke disk publik.
                return $f->store(config('filament.default_filesystem_disk', 'public'));
            }

            return null;
        })
        ->values();

    $ekstensiGambar = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp'];
@endphp

<div class="flex h-full flex-col gap-2">
    @if ($daftar->isEmpty())
        <div class="flex min-h-[14rem] flex-1 flex-col items-center justify-center gap-2 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-4 text-center dark:border-gray-700 dark:bg-gray-900">
            <x-filament::icon icon="heroicon-o-document-plus" class="h-8 w-8 text-gray-400" />
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Unggah nota di atas,<br>pratinjau akan muncul di sini.
            </p>
        </div>
    @else
        @foreach ($daftar as $path)
            @php
                $ekstensi = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $ada = false;
                $url = null;

                try {
                    // Cek dulu filenya BENAR-BENAR ada. Tanpa ini, iframe
                    // akan menampilkan halaman error yang membingungkan.
                    $ada = Storage::disk($disk)->exists($path);

                    if ($ada) {
                        $url = Storage::disk($disk)->url($path);
                    }
                } catch (\Throwable $e) {
                    $ada = false;
                }
            @endphp

            <div class="overflow-hidden rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
                @if (! $ada)
                    {{-- File hilang: beri tahu jelas, jangan tampilkan iframe rusak --}}
                    <div class="flex min-h-[8rem] flex-col items-center justify-center gap-1 p-3 text-center">
                        <x-filament::icon icon="heroicon-o-exclamation-triangle" class="h-6 w-6 text-warning-500" />
                        <p class="text-xs font-medium text-warning-700 dark:text-warning-400">File tidak ditemukan</p>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400">
                            Nota ini tidak ada di penyimpanan. Unggah ulang bila perlu.
                        </p>
                    </div>
                @elseif (in_array($ekstensi, $ekstensiGambar, true))
                    <a href="{{ $url }}" target="_blank" rel="noopener" title="Klik untuk perbesar">
                        <img src="{{ $url }}" alt="Nota" class="max-h-[24rem] w-full object-contain" loading="lazy" />
                    </a>
                @elseif ($ekstensi === 'pdf')
                    <iframe
                        src="{{ $url }}#view=FitH&toolbar=1"
                        class="h-[24rem] w-full"
                        title="Pratinjau nota PDF"
                    ></iframe>
                @else
                    <a href="{{ $url }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2 p-3 text-xs text-primary-600 hover:underline">
                        <x-filament::icon icon="heroicon-o-document" class="h-4 w-4" />
                        Buka file {{ strtoupper($ekstensi) }}
                    </a>
                @endif

                <div class="flex items-center justify-between gap-2 border-t border-gray-200 bg-white px-2 py-1 dark:border-gray-700 dark:bg-gray-800">
                    <span class="truncate text-[10px] text-gray-500 dark:text-gray-400" title="{{ basename($path) }}">
                        {{ basename($path) }}
                    </span>
                    @if ($ada)
                        <a href="{{ $url }}" target="_blank" rel="noopener"
                           class="shrink-0 text-[10px] text-primary-600 hover:underline">
                            Buka ↗
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
