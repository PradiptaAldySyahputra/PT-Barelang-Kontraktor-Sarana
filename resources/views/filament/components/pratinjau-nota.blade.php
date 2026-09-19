{{--
    Pratinjau nota — ditampilkan LEBAR PENUH di atas field form.

    Dipakai di dalam repeater form uang keluar:
        Placeholder::make('pratinjau_nota')->content(fn (Get $get) =>
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

<div class="w-full">
    @if ($daftar->isEmpty())
        {{-- Belum ada nota: beri petunjuk jelas, jangan tampilkan kotak kosong besar --}}
        <div class="flex w-full flex-col items-center justify-center gap-2 rounded-lg border border-dashed border-gray-300 bg-gray-50 px-4 py-8 text-center dark:border-gray-700 dark:bg-gray-900">
            <x-filament::icon icon="heroicon-o-document-plus" class="h-9 w-9 text-gray-400" />
            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Nota belum ada</p>
            <p class="max-w-md text-xs text-gray-500 dark:text-gray-400">
                Unggah nota pada bagian <strong>“1. Unggah Nota”</strong> di atas.
                Setelah terunggah, pratinjau akan muncul di sini secara otomatis.
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

            <div class="w-full overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                @if (! $ada)
                    {{-- File hilang: beri tahu jelas, jangan tampilkan iframe rusak --}}
                    <div class="flex w-full flex-col items-center justify-center gap-1 px-4 py-10 text-center">
                        <x-filament::icon icon="heroicon-o-exclamation-triangle" class="h-7 w-7 text-warning-500" />
                        <p class="text-sm font-medium text-warning-700 dark:text-warning-400">File tidak ditemukan</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Nota ini tidak ada di penyimpanan. Unggah ulang bila perlu.
                        </p>
                    </div>
                @elseif (in_array($ekstensi, $ekstensiGambar, true))
                    {{-- LEBAR PENUH agar nota jelas terbaca --}}
                    <a href="{{ $url }}" target="_blank" rel="noopener" title="Klik untuk perbesar">
                        <img
                            src="{{ $url }}"
                            alt="Nota"
                            class="block max-h-[80vh] w-full bg-gray-100 object-contain dark:bg-gray-800"
                            loading="lazy"
                        />
                    </a>
                @elseif ($ekstensi === 'pdf')
                    {{--
                        PDF LEBAR PENUH + tinggi besar (70% layar) supaya
                        halaman nota terbaca utuh, tidak terpotong separuh.
                        #view=FitH = pas lebar; scrollbar aktif untuk turun.
                    --}}
                    <iframe
                        src="{{ $url }}#view=FitH&toolbar=1&navpanes=0"
                        class="block h-[70vh] w-full"
                        title="Pratinjau nota PDF"
                    ></iframe>
                @else
                    <a href="{{ $url }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2 px-3 py-4 text-sm text-primary-600 hover:underline">
                        <x-filament::icon icon="heroicon-o-document" class="h-5 w-5" />
                        Buka file {{ strtoupper($ekstensi) }}
                    </a>
                @endif

                <div class="flex items-center justify-between gap-3 border-t border-gray-200 bg-gray-50 px-3 py-2 dark:border-gray-700 dark:bg-gray-800">
                    <span class="truncate text-xs text-gray-600 dark:text-gray-400" title="{{ basename($path) }}">
                        {{ basename($path) }}
                    </span>
                    @if ($ada)
                        <a href="{{ $url }}" target="_blank" rel="noopener"
                           class="shrink-0 text-xs font-medium text-primary-600 hover:underline">
                            Buka di tab baru ↗
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
