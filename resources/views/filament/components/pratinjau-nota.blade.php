{{--
    Pratinjau nota — ditampilkan LEBAR PENUH di atas field form.

    Dipakai di dalam repeater form uang keluar:
        Placeholder::make('pratinjau_nota')->content(fn (Get $get) =>
            view('filament.components.pratinjau-nota', ['files' => $get('bukti')]))

    Variabel:
        $files    : array path file (relatif terhadap disk Filament)
        $potongan : path potongan nota hasil OCR (opsional). Kalau ada, ini yang
                    ditampilkan — supaya tiap baris menampilkan NOTANYA SENDIRI,
                    bukan gambar penuh yang sama berulang-ulang.
--}}
@php
    use App\Support\Nota;
    use Illuminate\Support\Facades\Storage;

    $disk = 'nota';

    // Kalau OCR berhasil memotong nota, PAKAI POTONGANNYA.
    // Ini menyelesaikan masalah "1 PDF 4 nota -> 4 baris menampilkan gambar
    // yang sama". Sekarang tiap baris menampilkan potongan notanya sendiri.
    $potonganBersih = is_string($potongan ?? null) && filled($potongan) ? $potongan : null;

    $daftar = $potonganBersih !== null
        ? collect([$potonganBersih])
        : collect(is_array($files ?? null) ? $files : [])
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
                    // File sementara (belum tersimpan) — simpan ke disk privat nota.
                    return $f->store('nota');
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
                        // URL ber-otentikasi (disk nota PRIVAT) — bukan /storage.
                        $url = Nota::url($path);
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
                    {{--
                        Nota SELALU tampil UTUH — tidak terpotong.

                        Caranya: kotak dengan tinggi tetap + gambar
                        `object-contain` (dikecilkan agar muat seluruhnya,
                        TIDAK dipotong). Sebelumnya memakai `w-full` sehingga
                        nota yang tinggi/panjang ikut terpotong.

                        Klik gambar untuk membuka ukuran penuh di tab baru.
                    --}}
                    <a href="{{ $url }}" target="_blank" rel="noopener"
                       title="Klik untuk membuka ukuran penuh"
                       class="nota-kotak flex h-[68vh] w-full items-center justify-center bg-gray-100 p-2 dark:bg-gray-800">
                        <img
                            src="{{ $url }}"
                            alt="Nota"
                            class="max-h-full max-w-full object-contain"
                            loading="lazy"
                        />
                    </a>
                @elseif ($ekstensi === 'pdf')
                    {{--
                        PDF ditampilkan dalam kotak tinggi tetap.
                        #view=FitH = pas lebar; toolbar aktif untuk zoom.
                        Admin mengetik sambil melihat nota ini, jadi ukurannya
                        sengaja dibuat besar (68vh) agar terbaca.
                    --}}
                    <iframe
                        src="{{ $url }}#view=FitH&toolbar=1&navpanes=0"
                        class="block h-[68vh] w-full"
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
