@php
    use App\Support\Format;
    use App\Support\Nota;

    $kelasBadge = [
        'gray' => 'bg-gray-100 text-gray-700 dark:bg-white/10 dark:text-gray-300',
        'info' => 'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300',
        'primary' => 'bg-brand-50 text-brand-700 dark:bg-brand-500/15 dark:text-brand-300',
        'success' => 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500',
        'warning' => 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-500',
        'danger' => 'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-500',
    ];
    $badge = static fn (?string $warna): string => $kelasBadge[$warna ?? 'gray'] ?? $kelasBadge['gray'];
@endphp

<div>
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">

        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 px-5 py-4 dark:border-gray-800">
            <div>
                <p class="text-theme-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    Total Uang Keluar (terfilter)
                </p>
                <p class="mt-1 text-2xl font-bold angka text-error-600 dark:text-error-400">
                    {{ Format::rupiah($ringkas['total']) }}
                </p>
                <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                    dari {{ Format::angka($ringkas['jumlah']) }} transaksi
                </p>
            </div>

            @if ($bolehUbah)
                <a href="{{ route('panel.cash-out.create') }}"
                    class="inline-flex items-center justify-center font-medium gap-2 rounded-lg transition px-4 py-2.5 text-sm bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Catat Uang Keluar
                </a>
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-3 px-5 py-3.5 bg-gray-50/50 dark:bg-white/[0.01] border-b border-gray-100 dark:border-gray-800">
            <div class="relative min-w-0 flex-1 sm:max-w-xs">
                <label for="cari-keluar" class="sr-only">Cari di tabel ini</label>
                <svg class="pointer-events-none absolute top-1/2 left-3.5 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                </svg>
                <input id="cari-keluar" type="search" wire:model.live.debounce.300ms="cari"
                    placeholder="Cari keterangan, penerima, nomor SPK..."
                    class="h-10 w-full rounded-lg border border-gray-300 bg-white pr-4 pl-10 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
            </div>

            <label class="sr-only" for="keluar-dari">Dari tanggal</label>
            <input id="keluar-dari" type="date" wire:model.live="dari" title="Dari tanggal"
                class="h-10 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800">

            <label class="sr-only" for="keluar-sampai">Sampai tanggal</label>
            <input id="keluar-sampai" type="date" wire:model.live="sampai" title="Sampai tanggal"
                class="h-10 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800">

            <label class="sr-only" for="keluar-akun">Kas/Bank</label>
            <select id="keluar-akun" wire:model.live="akun"
                class="h-10 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800">
                <option value="">Semua akun</option>
                @foreach ($opsiAkun as $nilai => $label)
                    <option value="{{ $nilai }}">{{ $label }}</option>
                @endforeach
            </select>

            <label class="sr-only" for="keluar-kategori">Kategori</label>
            <select id="keluar-kategori" wire:model.live="kategori"
                class="h-10 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800">
                <option value="">Semua kategori</option>
                @foreach ($opsiKategori as $nilai => $label)
                    <option value="{{ $nilai }}">{{ $label }}</option>
                @endforeach
            </select>

            <label class="sr-only" for="keluar-sumber">Sumber</label>
            <select id="keluar-sumber" wire:model.live="sumber"
                class="h-10 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800">
                <option value="">Semua sumber</option>
                <option value="spk">Terhubung SPK</option>
                <option value="luar">Tanpa SPK</option>
            </select>

            <label class="sr-only" for="keluar-terhapus">Data terhapus</label>
            <select id="keluar-terhapus" wire:model.live="terhapus" title="Data terhapus"
                class="h-10 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800">
                <option value="aktif">Aktif</option>
                <option value="saja">Data terhapus</option>
            </select>

            @if ($adaPenyaring)
                <button type="button" wire:click="bersihkan"
                    class="h-10 rounded-lg border border-gray-200 bg-white px-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition">
                    Bersihkan
                </button>
            @endif
        </div>

        @if ($daftar->isEmpty())
            <div class="border-t border-gray-100 px-6 py-12 text-center dark:border-gray-800">
                <p class="text-theme-sm font-medium text-gray-900 dark:text-white">Tidak ada transaksi uang keluar yang cocok</p>
                <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Ubah filter tanggal, akun, kategori, atau kata kunci pencarian.</p>
                @if ($adaPenyaring)
                    <button type="button" wire:click="bersihkan"
                        class="mt-3 inline-flex items-center rounded-lg border border-gray-300 px-3 py-1.5 text-theme-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-white/5 transition">
                        Reset Filter
                    </button>
                @endif
            </div>
        @else
            <div class="hidden overflow-hidden md:block border-t border-gray-100 dark:border-gray-800">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/70 text-[11px] font-medium uppercase tracking-wide text-gray-500 dark:border-gray-800 dark:bg-white/[0.02] dark:text-gray-400">
                            <th class="px-4 py-2.5">
                                <button type="button" wire:click="urutkan('tanggal')" class="inline-flex items-center gap-1 hover:text-gray-900 dark:hover:text-white">
                                    Tanggal & Akun
                                    @if ($urut === 'tanggal')
                                        <span class="text-brand-600" aria-hidden="true">{{ $arah === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-700" aria-hidden="true">⇅</span>
                                    @endif
                                </button>
                            </th>
                            <th class="px-3 py-2.5">Kategori & Rincian</th>
                            <th class="px-3 py-2.5">Penerima & Keperluan</th>
                            <th class="px-3 py-2.5">Alokasi SPK</th>
                            <th class="px-3 py-2.5 text-right">
                                <button type="button" wire:click="urutkan('jumlah')" class="inline-flex items-center gap-1 hover:text-gray-900 dark:hover:text-white">
                                    Jumlah Keluar
                                    @if ($urut === 'jumlah')
                                        <span class="text-brand-600" aria-hidden="true">{{ $arah === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-700" aria-hidden="true">⇅</span>
                                    @endif
                                </button>
                            </th>
                            @if ($bolehUbah)
                                <th class="px-4 py-2.5 text-right">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-theme-sm dark:divide-gray-800">
                        @foreach ($daftar as $trx)
                            <tr wire:key="keluar-{{ $trx->id }}" class="align-top hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                                <td class="px-4 py-2.5 whitespace-nowrap text-theme-xs">
                                    <span class="block font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $trx->tanggal?->format('d/m/Y') ?? '—' }}
                                    </span>
                                    <span class="mt-0.5 inline-flex rounded px-1.5 py-0.2 text-[10px] font-medium {{ $badge($trx->akun?->warnaBadge()) }}">
                                        {{ $trx->akun?->label() ?? 'Kas' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2.5">
                                    <span class="inline-flex rounded px-1.5 py-0.2 text-[10px] font-semibold {{ $badge($trx->kategori?->warnaBadge()) }}">
                                        {{ $trx->kategori?->label() ?? 'Lainnya' }}
                                    </span>
                                    @if (filled($trx->detail_kategori))
                                        <p class="mt-0.5 truncate text-theme-xs text-gray-600 dark:text-gray-300" title="{{ $trx->detail_kategori }}">
                                            {{ $trx->detail_kategori }}
                                        </p>
                                    @endif
                                </td>
                                <td class="px-3 py-2.5">
                                    <p class="font-medium text-gray-900 dark:text-white" title="{{ $trx->penerima }}">
                                        {{ $trx->penerima ?: '—' }}
                                    </p>
                                    @if (filled($trx->keterangan))
                                        <p class="mt-0.5 line-clamp-1 text-theme-xs text-gray-500 dark:text-gray-400" title="{{ $trx->keterangan }}">
                                            {{ $trx->keterangan }}
                                        </p>
                                    @endif
                                </td>
                                <td class="px-3 py-2.5">
                                    @if ($trx->spk)
                                        <a href="{{ route('panel.spk.show', $trx->spk) }}"
                                            class="block truncate text-theme-xs font-semibold text-brand-600 hover:underline dark:text-brand-400"
                                            title="{{ $trx->spk->nomor_spk }}">
                                            {{ $trx->spk->nomor_spk }}
                                        </a>
                                    @else
                                        <span class="text-theme-xs text-gray-400">Operasional</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2.5 text-right whitespace-nowrap">
                                    <span class="angka block font-bold text-error-600 dark:text-error-400">
                                        − {{ Format::rupiah($trx->jumlah) }}
                                    </span>
                                    @if ($trx->jumlahFileBukti() > 0)
                                        <span class="mt-0.5 inline-flex rounded px-1.5 py-0.2 text-[10px] font-medium {{ $badge('info') }}">
                                            📎 {{ $trx->jumlahFileBukti() }} nota
                                        </span>
                                    @endif
                                </td>
                                @if ($bolehUbah)
                                    <td class="px-4 py-2.5 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center justify-end gap-1.5">
                                            @if ($trx->trashed())
                                                <form method="POST" action="{{ route('panel.cash-out.restore', $trx->id) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center rounded-lg border border-success-200 bg-success-50 px-2.5 py-1 text-xs font-semibold text-success-700 hover:bg-success-100 dark:border-success-500/30 dark:bg-success-500/10 dark:text-success-400 transition">
                                                        Pulihkan
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('panel.cash-out.edit', $trx) }}"
                                                    class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-2.5 py-1 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition"
                                                    title="Ubah Uang Keluar">
                                                    <svg class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                    Ubah
                                                </a>
                                                <form method="POST" action="{{ route('panel.cash-out.destroy', $trx) }}"
                                                    onsubmit="return konfirmasiAksi(this, 'Hapus catatan uang keluar senilai {{ Format::rupiah($trx->jumlah) }}? Data masih bisa dipulihkan dari tempat sampah.');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center rounded-lg px-2 py-1 text-xs font-medium text-error-600 hover:bg-error-50 dark:text-error-400 dark:hover:bg-error-500/10 transition"
                                                        title="Hapus Uang Keluar">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards (md:hidden) --}}
            <ul class="divide-y divide-gray-100 md:hidden dark:divide-gray-800 border-t border-gray-100 dark:border-gray-800">
                @foreach ($daftar as $trx)
                    <li wire:key="keluar-m-{{ $trx->id }}" class="px-4 py-3.5 space-y-2">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <span class="text-xs font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $trx->tanggal?->format('d/m/Y') ?? '—' }}
                                </span>
                                <span class="inline-flex rounded px-1.5 py-0.5 text-[10px] font-medium {{ $badge($trx->akun?->warnaBadge()) }}">
                                    {{ $trx->akun?->label() ?? 'Kas' }}
                                </span>
                                <span class="inline-flex rounded px-1.5 py-0.5 text-[10px] font-semibold {{ $badge($trx->kategori?->warnaBadge()) }}">
                                    {{ $trx->kategori?->label() ?? 'Lainnya' }}
                                </span>
                            </div>
                            <span class="angka text-xs font-bold text-error-600 dark:text-error-400">
                                − {{ Format::rupiah($trx->jumlah) }}
                            </span>
                        </div>

                        <p class="text-xs font-medium text-gray-900 dark:text-white">
                            {{ $trx->penerima ?: ($trx->keterangan ?: '—') }}
                        </p>
                        @if (filled($trx->keterangan) && filled($trx->penerima))
                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1">{{ $trx->keterangan }}</p>
                        @endif

                        <div class="flex flex-wrap items-center justify-between gap-2 text-xs text-gray-500 dark:text-gray-400">
                            @if ($trx->spk)
                                <a href="{{ route('panel.spk.show', $trx->spk) }}" class="font-semibold text-brand-600 dark:text-brand-400">
                                    {{ $trx->spk->nomor_spk }}
                                </a>
                            @else
                                <span>Operasional</span>
                            @endif
                            @if ($trx->jumlahFileBukti() > 0)
                                <span class="inline-flex rounded px-1.5 py-0.5 text-[10px] font-medium {{ $badge('info') }}">
                                    {{ $trx->jumlahFileBukti() }} nota
                                </span>
                            @endif
                        </div>

                        @if ($bolehUbah)
                            <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100 dark:border-gray-800">
                                @if ($trx->trashed())
                                    <form method="POST" action="{{ route('panel.cash-out.restore', $trx->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center rounded-lg border border-success-200 bg-success-50 px-2.5 py-1 text-xs font-semibold text-success-700">
                                            Pulihkan
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('panel.cash-out.edit', $trx) }}"
                                        class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-2.5 py-1 text-xs font-semibold text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                        Ubah
                                    </a>
                                    <form method="POST" action="{{ route('panel.cash-out.destroy', $trx) }}"
                                        onsubmit="return konfirmasiAksi(this, 'Hapus catatan uang keluar senilai {{ Format::rupiah($trx->jumlah) }}? Data masih bisa dipulihkan dari tempat sampah.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center rounded-lg px-2 py-1 text-xs font-medium text-error-600 dark:text-error-400">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>

            @if ($daftar->hasPages())
                <div class="border-t border-gray-100 px-4 py-3 dark:border-gray-800">
                    {{ $daftar->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
