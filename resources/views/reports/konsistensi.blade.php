<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <div class="space-y-5">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex flex-wrap items-baseline justify-between gap-3">
                <div>
                    <p class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">SPK diperiksa</p>
                    <p class="angka mt-1 text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($jumlahSpk, 0, ',', '.') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Temuan</p>
                    <p class="angka mt-1 text-2xl font-bold {{ $totalTemuan > 0 ? 'text-error-600 dark:text-error-400' : 'text-success-700 dark:text-success-400' }}">
                        {{ number_format($totalTemuan, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            <p class="mt-3 text-theme-xs leading-relaxed text-gray-500 dark:text-gray-400">
                Diperiksa: nilai SPK dibanding total uang masuk, dan status tagihan dibanding sisa piutang.
                Selisih di bawah Rp 1 diabaikan sebagai pembulatan.
            </p>
        </div>

        @if ($totalTemuan === 0)
            <x-common.alert tipe="sukses" judul="Tidak ada ketidakcocokan">
                Seluruh SPK konsisten antara nilai, penerimaan, dan status tagihan.
            </x-common.alert>
        @endif

        @foreach ([
            ['judul' => 'Uang masuk melebihi nilai SPK', 'baris' => $kelebihanBayar, 'kolom' => 'Kelebihan'],
            ['judul' => 'Status tagihan tidak cocok dengan piutang', 'baris' => $statusTidakCocok, 'kolom' => 'Alasan'],
            ['judul' => 'SPK dibatalkan tetapi sudah menerima uang', 'baris' => $dibatalkanAdaBayar, 'kolom' => 'Penerimaan'],
        ] as $bagian)
            @if (count($bagian['baris']) > 0)
                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                        <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">{{ $bagian['judul'] }}</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-theme-xs">
                            <thead class="bg-gray-50 text-theme-xs uppercase tracking-wider text-gray-500 dark:bg-white/[0.02] dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3 font-semibold">Nomor SPK</th>
                                    <th class="px-4 py-3 font-semibold">Mitra</th>
                                    <th class="px-4 py-3 text-right font-semibold">Nilai SPK</th>
                                    <th class="px-4 py-3 text-right font-semibold">Uang Masuk</th>
                                    <th class="px-4 py-3 text-right font-semibold">{{ $bagian['kolom'] }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($bagian['baris'] as $b)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                                        <td class="px-4 py-3">
                                            <a href="{{ route('panel.spk.show', $b['spk']) }}" class="font-semibold text-brand-600 hover:underline dark:text-brand-400">
                                                {{ $b['spk']->nomor_spk }}
                                            </a>
                                            <p class="mt-0.5 text-gray-500 dark:text-gray-400">{{ $b['spk']->nama_pekerjaan }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $b['spk']->mitra?->nama ?? 'Tanpa mitra' }}</td>
                                        <td class="angka px-4 py-3 text-right text-gray-900 dark:text-white">{{ \App\Support\Format::rupiah($b['spk']->nilai_spk) }}</td>
                                        <td class="angka px-4 py-3 text-right text-gray-900 dark:text-white">{{ \App\Support\Format::rupiah($b['masuk']) }}</td>
                                        <td class="angka px-4 py-3 text-right font-semibold {{ $b['sisa'] < 0 ? 'text-error-600 dark:text-error-400' : 'text-gray-700 dark:text-gray-300' }}">
                                            @if (isset($b['alasan']))
                                                {{ $b['alasan'] }}
                                            @else
                                                {{ \App\Support\Format::rupiah(abs($b['sisa'])) }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</x-layouts.app>
