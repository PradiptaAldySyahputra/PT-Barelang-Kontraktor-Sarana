@php
    use App\Enums\KategoriPengeluaran;
@endphp

<x-filament-panels::page>

    {{-- ================= FILTER PERIODE ================= --}}
    <div class="flex flex-wrap items-center gap-2">
        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Periode:</span>

        @foreach ([1 => 'Bulan Ini', 3 => '3 Bulan', 12 => '12 Bulan', 0 => 'Semua'] as $nilai => $label)
            <button
                wire:click="setPeriode({{ $nilai }})"
                class="rounded-lg px-3 py-1.5 text-sm font-medium transition
                    {{ $periode === $nilai
                        ? 'bg-primary-600 text-white'
                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}"
            >
                {{ $label }}
            </button>
        @endforeach

        <div class="ml-auto flex flex-wrap gap-2">
            <x-filament::button size="sm" color="gray" wire:click="ekspor('spk')" tag="button">
                Ekspor SPK
            </x-filament::button>
            <x-filament::button size="sm" color="gray" wire:click="ekspor('cashflow')" tag="button">
                Ekspor Arus Kas
            </x-filament::button>
            <x-filament::button size="sm" color="gray" wire:click="ekspor('kategori')" tag="button">
                Ekspor Kategori
            </x-filament::button>
            <x-filament::button size="sm" color="gray" wire:click="ekspor('laba_rugi')" tag="button">
                Ekspor Laba-Rugi
            </x-filament::button>
            <x-filament::button size="sm" color="gray" wire:click="ekspor('piutang')" tag="button">
                Ekspor Piutang
            </x-filament::button>
        </div>
    </div>

    {{-- ================= RINGKASAN ================= --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Uang Masuk</div>
            <div class="mt-1 text-xl font-semibold text-success-600 dark:text-success-400">
                Rp {{ number_format($totalMasuk, 0, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Dari SPK Rp {{ number_format($masukDariSpk, 0, ',', '.') }}
                · Luar Rp {{ number_format($masukLuarSpk, 0, ',', '.') }}
            </div>
        </div>

        <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Uang Keluar</div>
            <div class="mt-1 text-xl font-semibold text-danger-600 dark:text-danger-400">
                Rp {{ number_format($totalKeluar, 0, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $perKategori->count() }} kategori</div>
        </div>

        <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Saldo Bersih</div>
            <div class="mt-1 text-xl font-semibold {{ $saldo >= 0 ? 'text-gray-900 dark:text-white' : 'text-danger-600 dark:text-danger-400' }}">
                Rp {{ number_format($saldo, 0, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Masuk − Keluar</div>
        </div>

        <div class="rounded-xl bg-warning-50 p-4 ring-1 ring-warning-200 dark:bg-warning-500/10 dark:ring-warning-500/30">
            <div class="text-xs font-medium uppercase tracking-wide text-warning-700 dark:text-warning-400">Total Piutang</div>
            <div class="mt-1 text-xl font-semibold text-warning-900 dark:text-warning-300">
                Rp {{ number_format($totalPiutang, 0, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-warning-700 dark:text-warning-400">
                {{ $piutang->count() }} SPK belum lunas
            </div>
        </div>
    </div>

    {{-- ================= ARUS KAS PER BULAN ================= --}}
    <x-filament::section>
        <x-slot name="heading">Arus Kas per Bulan</x-slot>
        <x-slot name="description">Uang masuk, keluar, dan selisihnya</x-slot>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-500 dark:border-white/10 dark:text-gray-400">
                        <th class="py-2 pr-4">Bulan</th>
                        <th class="py-2 pr-4 text-center">Transaksi</th>
                        <th class="py-2 pr-4 text-right">Uang Masuk</th>
                        <th class="py-2 pr-4 text-right">Uang Keluar</th>
                        <th class="py-2 text-right">Selisih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($perBulan as $b)
                        <tr>
                            <td class="py-2 pr-4 font-medium text-gray-900 dark:text-white">{{ $b['label'] }}</td>
                            <td class="py-2 pr-4 text-center text-gray-500 dark:text-gray-400">
                                {{ $b['jumlah_masuk'] }} masuk / {{ $b['jumlah_keluar'] }} keluar
                            </td>
                            <td class="py-2 pr-4 text-right text-success-600 dark:text-success-400">
                                {{ number_format($b['masuk'], 0, ',', '.') }}
                            </td>
                            <td class="py-2 pr-4 text-right text-danger-600 dark:text-danger-400">
                                {{ number_format($b['keluar'], 0, ',', '.') }}
                            </td>
                            <td class="py-2 text-right font-semibold {{ $b['selisih'] >= 0 ? 'text-success-700 dark:text-success-400' : 'text-danger-700 dark:text-danger-400' }}">
                                {{ number_format($b['selisih'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-500 dark:text-gray-400">
                                Belum ada transaksi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>

    {{-- ================= PENGELUARAN PER KATEGORI ================= --}}
    <x-filament::section>
        <x-slot name="heading">Pengeluaran per Kategori</x-slot>
        <x-slot name="description">Kategori konsisten karena divalidasi PHP Enum</x-slot>

        @php $maksKategori = max(1, (float) ($perKategori->max('total') ?? 1)); @endphp

        <div class="space-y-3">
            @forelse ($perKategori as $k)
                @php
                    // `kategori` sudah di-cast ke Enum oleh model, jadi bisa
                    // berupa objek Enum ATAU string mentah (kalau nilainya
                    // tidak dikenal). Tangani keduanya.
                    $kategori = $k->kategori;
                    $labelKategori = $kategori instanceof KategoriPengeluaran
                        ? $kategori->label()
                        : ($kategori ?: 'Tanpa kategori');
                @endphp
                <div>
                    <div class="mb-1 flex items-center justify-between text-sm">
                        <span class="font-medium text-gray-700 dark:text-gray-300">
                            {{ $labelKategori }}
                            <span class="text-xs text-gray-400">({{ $k->jumlah_transaksi }}×)</span>
                        </span>
                        <span class="font-semibold text-gray-900 dark:text-white">
                            Rp {{ number_format((float) $k->total, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="h-2 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                        <div class="h-full rounded-full bg-danger-500"
                             style="width: {{ round((float) $k->total / $maksKategori * 100, 2) }}%"></div>
                    </div>
                </div>
            @empty
                <p class="py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                    Belum ada pengeluaran pada periode ini.
                </p>
            @endforelse
        </div>
    </x-filament::section>

    {{-- ================= LABA-RUGI PER SPK ================= --}}
    <x-filament::section>
        <x-slot name="heading">Laba-Rugi per SPK</x-slot>
        <x-slot name="description">Dihitung dari penerimaan − biaya tiap SPK</x-slot>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-500 dark:border-white/10 dark:text-gray-400">
                        <th class="py-2 pr-3">Nomor SPK</th>
                        <th class="py-2 pr-3">Pekerjaan</th>
                        <th class="py-2 pr-3 text-right">Nilai SPK</th>
                        <th class="py-2 pr-3 text-right">Penerimaan</th>
                        <th class="py-2 pr-3 text-right">Biaya</th>
                        <th class="py-2 pr-3 text-right">Laba/Rugi</th>
                        <th class="py-2 text-right">Piutang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($labaRugiSpk as $r)
                        <tr>
                            <td class="py-2 pr-3 font-mono text-xs text-gray-700 dark:text-gray-300">{{ $r['nomor_spk'] }}</td>
                            <td class="py-2 pr-3 text-gray-800 dark:text-gray-200">
                                {{ $r['pekerjaan'] }}
                                <div class="text-xs text-gray-400">{{ $r['mitra'] ?? '—' }}</div>
                            </td>
                            <td class="py-2 pr-3 text-right text-gray-600 dark:text-gray-400">
                                {{ number_format($r['nilai_spk'], 0, ',', '.') }}
                            </td>
                            <td class="py-2 pr-3 text-right text-success-600 dark:text-success-400">
                                {{ number_format($r['penerimaan'], 0, ',', '.') }}
                            </td>
                            <td class="py-2 pr-3 text-right text-danger-600 dark:text-danger-400">
                                {{ number_format($r['biaya'], 0, ',', '.') }}
                            </td>
                            <td class="py-2 pr-3 text-right font-semibold {{ $r['laba'] >= 0 ? 'text-success-700 dark:text-success-400' : 'text-danger-700 dark:text-danger-400' }}">
                                {{ number_format($r['laba'], 0, ',', '.') }}
                            </td>
                            <td class="py-2 text-right text-warning-600 dark:text-warning-400">
                                {{ number_format($r['piutang'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-gray-500 dark:text-gray-400">
                                Belum ada SPK.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>

    {{-- ================= PIUTANG ================= --}}
    <x-filament::section>
        <x-slot name="heading">Piutang SPK (Belum Lunas)</x-slot>
        <x-slot name="description">SPK yang penerimaannya masih kurang dari nilai SPK</x-slot>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-500 dark:border-white/10 dark:text-gray-400">
                        <th class="py-2 pr-3">Nomor SPK</th>
                        <th class="py-2 pr-3">Pekerjaan</th>
                        <th class="py-2 pr-3">Status Tagihan</th>
                        <th class="py-2 pr-3 text-right">Nilai SPK</th>
                        <th class="py-2 pr-3 text-right">Diterima</th>
                        <th class="py-2 text-right">Sisa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($piutang as $r)
                        <tr>
                            <td class="py-2 pr-3 font-mono text-xs text-gray-700 dark:text-gray-300">{{ $r['nomor_spk'] }}</td>
                            <td class="py-2 pr-3 text-gray-800 dark:text-gray-200">
                                {{ $r['pekerjaan'] }}
                                <div class="text-xs text-gray-400">{{ $r['mitra'] ?? '—' }}</div>
                            </td>
                            <td class="py-2 pr-3">
                                <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    {{ $r['status_tagihan'] }}
                                </span>
                            </td>
                            <td class="py-2 pr-3 text-right text-gray-600 dark:text-gray-400">
                                {{ number_format($r['nilai_spk'], 0, ',', '.') }}
                            </td>
                            <td class="py-2 pr-3 text-right text-success-600 dark:text-success-400">
                                {{ number_format($r['diterima'], 0, ',', '.') }}
                            </td>
                            <td class="py-2 text-right font-semibold text-warning-700 dark:text-warning-400">
                                {{ number_format($r['sisa'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada piutang — semua SPK sudah lunas. 🎉
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>

</x-filament-panels::page>
