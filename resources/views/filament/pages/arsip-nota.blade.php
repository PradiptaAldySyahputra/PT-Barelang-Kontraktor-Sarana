{{--
    ============================================================
    HALAMAN ARSIP NOTA (B2-7)
    ============================================================

    Filter: tanggal/periode, akun, kategori, kata kunci.
    Hasil: daftar nota + tombol Pratinjau, Unduh, dan Unduh ZIP.

    Variabel: $arsip, $jumlah, $jumlahAda
--}}
<x-filament-panels::page>

    {{-- ================= FILTER ================= --}}
    <x-filament::section>
        <x-slot name="heading">Pencarian</x-slot>

        <form wire:submit="refresh">
            {{ $this->form }}

            <div class="mt-4">
                <x-filament::button type="submit" icon="heroicon-m-magnifying-glass">
                    Cari Nota
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>

    {{-- ================= HASIL ================= --}}
    <x-filament::section>
        <x-slot name="heading">
            Hasil ({{ $jumlah }} nota{{ $jumlahAda < $jumlah ? ' · '.$jumlah.' terdaftar, '.$jumlahAda.' berkas ada' : '' }})
        </x-slot>

        @if ($jumlah === 0)
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Tidak ada nota pada filter ini. Coba ubah rentang tanggal.
            </p>
        @else
            <div class="mb-4">
                <x-filament::button
                    color="primary"
                    icon="heroicon-m-arrow-down-tray"
                    tag="a"
                    :href="route('arsip-nota.zip', ['f' => base64_encode(json_encode($this->data))])"
                >
                    Unduh Semua sebagai ZIP ({{ $jumlahAda }} berkas)
                </x-filament::button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-500 dark:border-gray-700 dark:text-gray-400">
                            <th class="px-3 py-2">Nota</th>
                            <th class="px-3 py-2">Tanggal</th>
                            <th class="px-3 py-2">Jenis</th>
                            <th class="px-3 py-2">Akun</th>
                            <th class="px-3 py-2">Keterangan</th>
                            <th class="px-3 py-2">Nama Unduhan</th>
                            <th class="px-3 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arsip as $b)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                {{-- Thumbnail (B2-7): gambar ditampilkan; PDF & berkas
                                     hilang diberi ikon dokumen. --}}
                                <td class="px-3 py-2">
                                    @if ($b['ada'] && $b['gambar'])
                                        <a href="{{ $b['url'] }}" target="_blank" title="Buka nota">
                                            <img
                                                src="{{ $b['url'] }}"
                                                alt="Nota {{ $b['nama'] }}"
                                                loading="lazy"
                                                class="h-12 w-12 rounded object-cover ring-1 ring-gray-200 dark:ring-gray-700"
                                            />
                                        </a>
                                    @else
                                        <span
                                            class="inline-flex h-12 w-12 items-center justify-center rounded bg-gray-100 text-gray-400 ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700"
                                            title="{{ $b['ada'] ? 'Dokumen (bukan gambar)' : 'Berkas hilang' }}"
                                        >
                                            <x-filament::icon
                                                :icon="$b['ada'] ? 'heroicon-o-document-text' : 'heroicon-o-exclamation-triangle'"
                                                class="h-5 w-5"
                                            />
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $b['tanggal']->format('d/m/Y') }}</td>
                                <td class="px-3 py-2 text-gray-600 dark:text-gray-400">{{ $b['jenis'] }}</td>
                                <td class="px-3 py-2 text-gray-600 dark:text-gray-400">{{ ucfirst($b['akun'] ?? '—') }}</td>
                                <td class="px-3 py-2 text-gray-600 dark:text-gray-400">
                                    {{ \Illuminate\Support\Str::limit($b['penerima'] ?? $b['keterangan'] ?? '—', 40) }}
                                </td>
                                <td class="px-3 py-2 font-mono text-xs text-gray-700 dark:text-gray-300">
                                    {{ $b['nama'] }}
                                    @unless ($b['ada'])
                                        <span class="ml-1 text-rose-600 dark:text-rose-400">(berkas hilang)</span>
                                    @endunless
                                </td>
                                <td class="px-3 py-2 text-right whitespace-nowrap">
                                    @if ($b['ada'])
                                        <x-filament::button size="xs" color="gray" tag="a" target="_blank" :href="$b['url']">
                                            Pratinjau
                                        </x-filament::button>
                                        <x-filament::button size="xs" color="gray" tag="a" :href="route('arsip-nota.unduh', ['path' => base64_encode($b['path']), 'nama' => $b['nama']])">
                                            Unduh
                                        </x-filament::button>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::section>

</x-filament-panels::page>
