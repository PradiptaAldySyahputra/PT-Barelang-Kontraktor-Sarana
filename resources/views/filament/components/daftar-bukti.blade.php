{{--
    DAFTAR BUKTI TRANSAKSI — dipakai modal "Lihat Bukti".

    ⚠️ KENAPA INI ADA (keluhan pengguna 29 Sep 2026):
      "admin perlu itu kemudahan untuk mengelolanya, mencari bukti dari uang
       tersebut, dan kebutuhan data lainnya"

    Nota memuat harga material, pembayaran subkon, dan gaji karyawan — jadi
    berkas TIDAK boleh bisa diakses tanpa login. Semua tautan di sini menuju
    rute `/admin/nota/{path}` yang memerlukan otentikasi (disk privat).

    Gambar ditampilkan langsung sebagai pratinjau supaya admin bisa memastikan
    nota yang benar tanpa mengunduh; PDF & berkas lain dibuka di tab baru.
--}}
@php
    $gambar = ['jpg', 'jpeg', 'png', 'webp'];
@endphp

@if (empty($berkas))
    <p class="text-sm text-gray-500">Tidak ada berkas bukti pada transaksi ini.</p>
@else
    <div class="space-y-4">
        @foreach ($berkas as $i => $path)
            @php
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $url = route('nota.lihat', ['path' => $path]);
                $nama = basename($path);
            @endphp

            <div class="rounded-lg border border-gray-200 dark:border-white/10 p-3">
                <div class="flex items-center justify-between gap-3 mb-2">
                    <span class="text-sm font-medium">
                        Berkas {{ $i + 1 }} — {{ $nama }}
                    </span>
                    <a href="{{ $url }}" target="_blank"
                       class="text-sm text-primary-600 hover:underline whitespace-nowrap">
                        Buka di tab baru ↗
                    </a>
                </div>

                @if (in_array($ext, $gambar, true))
                    <img src="{{ $url }}" alt="{{ $nama }}"
                         class="max-h-96 w-auto rounded border border-gray-200 dark:border-white/10" />
                @elseif ($ext === 'pdf')
                    <iframe src="{{ $url }}" class="w-full h-96 rounded border border-gray-200 dark:border-white/10"></iframe>
                @else
                    <p class="text-xs text-gray-500">
                        Berkas .{{ $ext }} tidak bisa dipratinjau — klik "Buka di tab baru".
                    </p>
                @endif
            </div>
        @endforeach
    </div>
@endif
