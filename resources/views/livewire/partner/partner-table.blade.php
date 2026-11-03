@php
    use App\Enums\KategoriMitra;
    use App\Support\Format;

    $kelasBadge = [
        'gray' => 'bg-gray-100 text-gray-700 dark:bg-white/10 dark:text-gray-300',
        'primary' => 'bg-brand-50 text-brand-700 dark:bg-brand-500/15 dark:text-brand-300',
        'success' => 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500',
        'warning' => 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-500',
    ];

    $badge = static fn (?string $warna): string => $kelasBadge[$warna ?? 'gray'] ?? $kelasBadge['gray'];

    $daftarTab = [
        'semua' => 'Semua',
        'mitra' => 'Mitra',
        'subkon' => 'Subkon',
    ];
@endphp

<div>
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">

        {{-- Kepala: tab + tombol tambah --}}
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 px-5 py-4 dark:border-gray-800">
            <div class="flex flex-wrap items-center gap-2" role="tablist" aria-label="Kategori mitra">
                @foreach ($daftarTab as $kunci => $label)
                    @php $aktif = $tab === $kunci; @endphp
                    <button type="button" role="tab" aria-selected="{{ $aktif ? 'true' : 'false' }}"
                        wire:click="pilihTab('{{ $kunci }}')"
                        class="inline-flex h-9 items-center gap-2 rounded-xl px-3.5 text-xs font-semibold transition-colors {{ $aktif ? 'bg-brand-500 text-white shadow-theme-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                        <span>{{ $label }}</span>
                        <span class="angka rounded-full px-2 py-0.5 text-[11px] font-bold {{ $aktif ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                            {{ Format::angka($jumlahTab[$kunci] ?? 0) }}
                        </span>
                    </button>
                @endforeach
            </div>

            @if ($bolehUbah)
                <a href="{{ route('panel.partners.create') }}"
                    class="inline-flex items-center justify-center font-medium gap-2 rounded-xl transition px-4 py-2.5 text-xs bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Mitra
                </a>
            @endif
        </div>

        {{-- Baris pencarian --}}
        <div class="flex flex-wrap items-center gap-3 px-5 py-3.5 bg-gray-50/50 dark:bg-white/[0.01] border-b border-gray-100 dark:border-gray-800">
            <div class="relative min-w-0 flex-1 sm:max-w-xs">
                <label for="cari-mitra" class="sr-only">Cari di tabel ini</label>
                <svg class="pointer-events-none absolute top-1/2 left-3.5 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                </svg>
                <input id="cari-mitra" type="search" wire:model.live.debounce.300ms="cari"
                    placeholder="Cari nama mitra, kontak, alamat..."
                    class="h-10 w-full rounded-lg border border-gray-300 bg-white pr-4 pl-10 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
            </div>

            @if ($adaPenyaring)
                <button type="button" wire:click="bersihkan"
                    class="h-10 rounded-lg border border-gray-200 bg-white px-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition">
                    Bersihkan
                </button>
            @endif
        </div>

        @if ($daftar->isEmpty())
            <div class="border-t border-gray-100 px-6 py-12 text-center dark:border-gray-800">
                <p class="text-theme-sm font-medium text-gray-900 dark:text-white">Tidak ada mitra rekanan yang cocok</p>
                <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Ubah filter kategori atau kata kunci pencarian.</p>
                @if ($adaPenyaring)
                    <button type="button" wire:click="bersihkan"
                        class="mt-3 inline-flex items-center rounded-lg border border-gray-300 px-3 py-1.5 text-theme-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-white/5 transition">
                        Reset Filter
                    </button>
                @endif
            </div>
        @else
            {{-- Desktop Table: 100% Fit Tanpa Truncate Kaku --}}
            <div class="hidden overflow-hidden md:block border-t border-gray-100 dark:border-gray-800">
                <table class="w-full text-left text-theme-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/70 text-[11px] font-medium uppercase tracking-wide text-gray-500 dark:border-gray-800 dark:bg-white/[0.02] dark:text-gray-400">
                            <th class="px-4 py-3">
                                <button type="button" wire:click="urutkan('nama')" class="inline-flex items-center gap-1 hover:text-gray-900 dark:hover:text-white">
                                    Nama & Alamat Mitra
                                    @if ($urut === 'nama')
                                        <span class="text-brand-600" aria-hidden="true">{{ $arah === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-700" aria-hidden="true">⇅</span>
                                    @endif
                                </button>
                            </th>
                            <th class="px-3 py-3">
                                <button type="button" wire:click="urutkan('kategori')" class="inline-flex items-center gap-1 hover:text-gray-900 dark:hover:text-white">
                                    Kategori
                                    @if ($urut === 'kategori')
                                        <span class="text-brand-600" aria-hidden="true">{{ $arah === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-700" aria-hidden="true">⇅</span>
                                    @endif
                                </button>
                            </th>
                            <th class="px-3 py-3">Kontak & PIC</th>
                            <th class="px-3 py-3 text-center">SPK Terkait</th>
                            <th class="px-3 py-3 text-center">Status</th>
                            @if ($bolehUbah)
                                <th class="px-4 py-3 text-right">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-theme-sm dark:divide-gray-800">
                        @foreach ($daftar as $mitra)
                            @php
                                $kat = $mitra->kategori ?? KategoriMitra::Mitra;
                            @endphp
                            <tr wire:key="mitra-{{ $mitra->id }}" class="align-top hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $mitra->nama }}
                                    </p>
                                    @if ($mitra->alamat)
                                        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                                            {{ $mitra->alamat }}
                                        </p>
                                    @endif
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="inline-flex rounded-md px-2 py-0.5 text-xs font-semibold {{ $badge($kat->warnaBadge()) }}">
                                        {{ $kat->label() }}
                                    </span>
                                </td>
                                <td class="px-3 py-3">
                                    <span class="text-gray-700 dark:text-gray-300">
                                        {{ $mitra->kontak ?: '—' }}
                                    </span>
                                </td>
                                <td class="px-3 py-3 text-center whitespace-nowrap">
                                    <span class="angka inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-bold text-gray-700 dark:bg-white/10 dark:text-gray-300">
                                        {{ Format::angka($mitra->spk_count ?? 0) }} SPK
                                    </span>
                                </td>
                                <td class="px-3 py-3 text-center whitespace-nowrap">
                                    <span class="inline-flex rounded-md px-2 py-0.5 text-xs font-semibold {{ $mitra->is_aktif ? $badge('success') : $badge('gray') }}">
                                        {{ $mitra->is_aktif ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                @if ($bolehUbah)
                                    <td class="px-4 py-3 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center justify-end gap-1.5">
                                            <a href="{{ route('panel.partners.edit', $mitra) }}"
                                                class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-2.5 py-1 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition"
                                                title="Ubah Data Mitra">
                                                <svg class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                                Ubah
                                            </a>
                                            <form method="POST" action="{{ route('panel.partners.destroy', $mitra) }}"
                                                onsubmit="return konfirmasiAksi(this, 'Hapus mitra rekanan {{ addslashes($mitra->nama) }}? Pastikan mitra tidak sedang terikat kontrak aktif.');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center rounded-lg px-2 py-1 text-xs font-medium text-error-600 hover:bg-error-50 dark:text-error-400 dark:hover:bg-error-500/10 transition"
                                                    title="Hapus Mitra">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards: 100% Nyaman di Layar Kecil (md:hidden) --}}
            <ul class="divide-y divide-gray-100 md:hidden dark:divide-gray-800">
                @foreach ($daftar as $mitra)
                    @php
                        $kat = $mitra->kategori ?? KategoriMitra::Mitra;
                    @endphp
                    <li class="px-4 py-3.5 space-y-2">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <h4 class="font-bold text-theme-sm text-gray-900 dark:text-white">
                                    {{ $mitra->nama }}
                                </h4>
                                @if ($mitra->alamat)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $mitra->alamat }}
                                    </p>
                                @endif
                            </div>
                            <span class="inline-flex rounded px-2 py-0.5 text-[11px] font-semibold {{ $badge($kat->warnaBadge()) }}">
                                {{ $kat->label() }}
                            </span>
                        </div>

                        <div class="flex flex-wrap items-center justify-between text-xs text-gray-600 dark:text-gray-300 pt-1">
                            <span>📞 {{ $mitra->kontak ?: '—' }}</span>
                            <span class="font-bold">{{ Format::angka($mitra->spk_count ?? 0) }} SPK</span>
                        </div>

                        @if ($bolehUbah)
                            <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100 dark:border-gray-800">
                                <a href="{{ route('panel.partners.edit', $mitra) }}"
                                    class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-2.5 py-1 text-xs font-semibold text-gray-700">
                                    Ubah
                                </a>
                                <form method="POST" action="{{ route('panel.partners.destroy', $mitra) }}"
                                    onsubmit="return konfirmasiAksi(this, 'Hapus mitra rekanan {{ addslashes($mitra->nama) }}? Pastikan mitra tidak sedang terikat kontrak aktif.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center rounded-lg px-2 py-1 text-xs font-medium text-error-600">
                                        Hapus
                                    </button>
                                </form>
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
