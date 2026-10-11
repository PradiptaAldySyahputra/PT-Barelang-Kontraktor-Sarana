{{--
    ============================================================
    HALAMAN IMPOR DATA (B3-13)
    ============================================================

    Input massal dari Excel/CSV. Append-only + cegah duplikat.
    Variabel: $data, $hasil (dari properti komponen)
--}}
<x-filament-panels::page>

    <x-filament::section>
        <x-slot name="heading">Berkas Impor</x-slot>
        <x-slot name="description">
            Kolom yang dikenali: <strong>tanggal, jumlah, akun, kategori, penerima, keterangan</strong>.
            Impor hanya <strong>menambah</strong> baris — data lama tidak diubah, duplikat dilewati.
        </x-slot>

        <form wire:submit="proses">
            {{ $this->form }}

            <div class="mt-4">
                <x-filament::button type="submit" icon="heroicon-m-arrow-up-tray">
                    Mulai Impor
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>

    @if ($hasil !== null)
        <x-filament::section>
            <x-slot name="heading">Hasil Impor</x-slot>

            <div class="grid grid-cols-3 gap-4 text-center">
                <div>
                    <div class="text-2xl font-bold text-success-600">{{ $hasil['ditambah'] }}</div>
                    <div class="text-xs text-gray-500">Ditambah</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-warning-600">{{ $hasil['dilewati'] }}</div>
                    <div class="text-xs text-gray-500">Dilewati (duplikat)</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-danger-600">{{ count($hasil['gagal']) }}</div>
                    <div class="text-xs text-gray-500">Gagal</div>
                </div>
            </div>

            @if (count($hasil['gagal']) > 0)
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Baris bermasalah:</p>
                    <ul class="mt-2 list-disc pl-5 text-sm text-danger-600">
                        @foreach ($hasil['gagal'] as $g)
                            <li>{{ $g }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </x-filament::section>
    @endif

</x-filament-panels::page>
