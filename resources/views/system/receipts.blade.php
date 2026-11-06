{{--
    Arsip Nota (/panel/receipts): semua berkas bukti uang masuk & keluar.
    Dilengkapi pagination, pratinjau modal/preview, tautan edit transaksi terkait, dan unduh ZIP.
--}}
@php
    use App\Support\Nota;

    $kelasKartu = 'rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs';
    $kelasInput = 'h-9 rounded-xl border border-gray-300 bg-white px-3 text-xs text-gray-800 shadow-theme-xs focus:border-brand-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90';
    $jumlahBerkasAda = $semuaArsip->where('ada', true)->count();
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <div class="space-y-5" x-data="{
        previewModal: false,
        previewUrl: '',
        previewNama: '',
        isImage: true,
        bukaPratinjau(url, nama, gambar) {
            this.previewUrl = url;
            this.previewNama = nama;
            this.isImage = gambar;
            this.previewModal = true;
        }
    }">
        {{-- Form Filter Pencarian --}}
        <form method="GET" action="{{ route('panel.receipts') }}" class="{{ $kelasKartu }} p-4 sm:p-5">
            <div class="flex flex-wrap items-center gap-2.5">
                <div class="min-w-0 flex-1 sm:max-w-xs">
                    <label for="q" class="sr-only">Cari</label>
                    <input id="q" name="q" type="search" value="{{ $filter['q'] }}"
                        placeholder="Cari penerima atau keterangan..."
                        class="h-9 w-full rounded-xl border border-gray-300 bg-white px-3 text-xs text-gray-900 placeholder:text-gray-400 focus:border-brand-400 focus:outline-none dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                </div>

                <div class="flex items-center gap-1.5">
                    <label class="sr-only" for="tgl">Tanggal Transaksi</label>
                    <input id="tgl" name="tgl" type="date" value="{{ $filter['tanggal_awal'] }}" title="Pilih tanggal transaksi" class="{{ $kelasInput }}">
                </div>

                <label class="sr-only" for="akun">Akun Kas/Bank</label>
                <select id="akun" name="akun" class="{{ $kelasInput }}">
                    <option value="">Semua Akun</option>
                    @foreach ($opsiAkun as $nilai => $label)
                        <option value="{{ $nilai }}" @selected($filter['akun'] === $nilai)>{{ $label }}</option>
                    @endforeach
                </select>

                <label class="sr-only" for="kategori">Kategori Pengeluaran</label>
                <select id="kategori" name="kategori" class="{{ $kelasInput }}">
                    <option value="">Semua Kategori</option>
                    @foreach ($opsiKategori as $nilai => $label)
                        <option value="{{ $nilai }}" @selected($filter['kategori'] === $nilai)>{{ $label }}</option>
                    @endforeach
                </select>

                <div class="flex items-center gap-2 ml-auto">
                    @if (auth()->user()?->bolehInput())
                        <a href="{{ route('panel.receipts.upload') }}"
                            class="inline-flex h-9 items-center gap-1.5 rounded-xl bg-brand-600 px-3.5 text-xs font-semibold text-white shadow-theme-xs hover:bg-brand-700 transition"
                            title="Unggah nota fisik untuk diekstrak otomatis">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Unggah Nota
                        </a>
                    @endif

                    <button type="submit"
                        class="inline-flex h-9 items-center rounded-xl bg-gray-900 dark:bg-white dark:text-gray-900 px-4 text-xs font-semibold text-white shadow-theme-xs hover:bg-gray-800 transition">
                        Filter
                    </button>

                    <a href="{{ route('arsip-nota.zip', request()->only(['q', 'tgl', 'dari', 'sampai', 'akun', 'kategori'])) }}"
                        class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-gray-300 bg-white px-3.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition"
                        title="Unduh seluruh nota terfilter dalam format ZIP">
                        <svg class="h-3.5 w-3.5 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh ZIP
                    </a>

                    @if (filled($filter['q']) || filled($filter['tanggal_awal']) || filled($filter['tanggal_akhir']) || filled($filter['akun']) || filled($filter['kategori']))
                        <a href="{{ route('panel.receipts') }}" class="text-xs text-error-600 hover:underline dark:text-error-400">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Tabel Berkas Arsip Nota --}}
        <section class="{{ $kelasKartu }} overflow-hidden">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                <div>
                    <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Daftar Berkas Bukti & Kuitansi</h2>
                    <p class="text-theme-xs text-gray-500 dark:text-gray-400">
                        Menampilkan {{ $arsip->count() }} dari total {{ $arsip->total() }} berkas nota
                    </p>
                </div>
                <span class="rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700 dark:bg-brand-500/10 dark:text-brand-300">
                    {{ $jumlahBerkasAda }} Berkas Tersedia di Server
                </span>
            </div>

            @if ($arsip->isEmpty())
                <div class="px-5 py-12 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                    <p>Tidak ada berkas nota pada filter ini.</p>
                </div>
            @else
                <div class="hidden overflow-hidden md:block">
                    <table class="w-full text-left text-theme-sm">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/70 text-[11px] font-medium uppercase tracking-wide text-gray-500 dark:border-gray-800 dark:bg-white/[0.02] dark:text-gray-400">
                                <th class="w-24 px-4 py-3">Tanggal</th>
                                <th class="w-28 px-3 py-3">Transaksi</th>
                                <th class="w-24 px-3 py-3">Akun</th>
                                <th class="px-3 py-3">Keterangan / Mitra</th>
                                <th class="w-56 px-4 py-3">Nama Berkas</th>
                                <th class="w-36 px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($arsip as $baris)
                                <tr class="hover:bg-gray-50/60 dark:hover:bg-white/[0.02] transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-700 dark:text-gray-300">
                                        {{ $baris['tanggal']?->format('d/m/Y') ?? '—' }}
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold {{ $baris['jenis'] === 'Uang Masuk' ? 'bg-success-50 text-success-700 dark:bg-success-500/10 dark:text-success-400' : 'bg-error-50 text-error-700 dark:bg-error-500/10 dark:text-error-400' }}">
                                            {{ $baris['jenis'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                        {{ $baris['akun'] ?? '—' }}
                                    </td>
                                    <td class="px-3 py-3">
                                        <p class="font-medium text-xs text-gray-900 dark:text-gray-100 truncate max-w-xs">
                                            {{ $baris['penerima'] ?: ($baris['keterangan'] ?: '—') }}
                                        </p>
                                        @if (filled($baris['spk_nomor']))
                                            <span class="text-[11px] text-brand-600 dark:text-brand-400">SPK: {{ $baris['spk_nomor'] }}</span>
                                        @elseif (filled($baris['kategori']))
                                            <span class="text-[11px] text-gray-400">Kat: {{ $baris['kategori'] }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($baris['ada'])
                                            <div class="flex items-center gap-2">
                                                @if ($baris['gambar'])
                                                    <button type="button" @click="bukaPratinjau('{{ $baris['url'] }}', '{{ $baris['nama'] }}', true)"
                                                        class="h-8 w-8 rounded-lg border border-gray-200 overflow-hidden shrink-0 hover:opacity-80 transition" title="Klik untuk pratinjau">
                                                        <img src="{{ $baris['url'] }}" alt="{{ $baris['nama'] }}" class="h-full w-full object-cover">
                                                    </button>
                                                @else
                                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400 shrink-0 font-bold text-[10px]">
                                                        PDF
                                                    </span>
                                                @endif
                                                <button type="button" @click="bukaPratinjau('{{ $baris['url'] }}', '{{ $baris['nama'] }}', {{ $baris['gambar'] ? 'true' : 'false' }})"
                                                    class="truncate text-xs font-medium text-brand-600 hover:underline dark:text-brand-400 text-left"
                                                    title="{{ $baris['nama'] }}">
                                                    {{ $baris['nama'] }}
                                                </button>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-xs text-gray-700 dark:text-gray-300 font-mono">{{ $baris['nama'] }}</span>
                                                <span class="text-[10px] rounded px-1 font-medium bg-error-50 text-error-700 dark:bg-error-500/10 dark:text-error-400" title="Berkas fisik belum diunggah atau sudah dipindahkan">
                                                    (belum ada file)
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center justify-end gap-1.5">
                                            @if ($baris['ada'])
                                                <button type="button" @click="bukaPratinjau('{{ $baris['url'] }}', '{{ $baris['nama'] }}', {{ $baris['gambar'] ? 'true' : 'false' }})"
                                                    class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-2 py-1 text-[11px] font-semibold text-gray-700 shadow-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                                    👁 Lihat
                                                </button>
                                                <a href="{{ $baris['url'] }}" download="{{ $baris['nama'] }}"
                                                    class="inline-flex items-center gap-1 rounded-lg border border-brand-200 bg-brand-50 px-2 py-1 text-[11px] font-semibold text-brand-700 hover:bg-brand-100 dark:border-brand-500/30 dark:bg-brand-500/10 dark:text-brand-400">
                                                    Unduh
                                                </a>
                                            @endif
                                            @if ($baris['edit_url'])
                                                <a href="{{ $baris['edit_url'] }}"
                                                    class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-2 py-1 text-[11px] font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300"
                                                    title="Buka & ubah transaksi asal">
                                                    Ubah
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Cards (md:hidden) --}}
                <ul class="divide-y divide-gray-100 md:hidden dark:divide-gray-800">
                    @foreach ($arsip as $baris)
                        <li class="px-4 py-3.5 space-y-2">
                            <div class="flex items-start justify-between gap-2">
                                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">
                                    {{ $baris['tanggal']?->format('d/m/Y') ?? '—' }} · {{ $baris['akun'] ?? '—' }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold {{ $baris['jenis'] === 'Uang Masuk' ? 'bg-success-50 text-success-700 dark:bg-success-500/10 dark:text-success-400' : 'bg-error-50 text-error-700 dark:bg-error-500/10 dark:text-error-400' }}">
                                    {{ $baris['jenis'] }}
                                </span>
                            </div>

                            <p class="text-xs font-medium text-gray-900 dark:text-gray-100">
                                {{ $baris['penerima'] ?: ($baris['keterangan'] ?: '—') }}
                            </p>

                            <div class="flex items-center justify-between gap-2 text-xs text-gray-500 dark:text-gray-400">
                                <span class="truncate">{{ $baris['nama'] }}</span>
                                @if (! $baris['ada'])
                                    <span class="text-[10px] rounded px-1 font-medium bg-error-50 text-error-700 dark:bg-error-500/10 dark:text-error-400">
                                        (belum ada file)
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center justify-end gap-1.5 pt-2 border-t border-gray-100 dark:border-gray-800">
                                @if ($baris['ada'])
                                    <button type="button" @click="bukaPratinjau('{{ $baris['url'] }}', '{{ $baris['nama'] }}', {{ $baris['gambar'] ? 'true' : 'false' }})"
                                        class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-2.5 py-1 text-xs font-semibold text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                        Lihat
                                    </button>
                                    <a href="{{ $baris['url'] }}" download="{{ $baris['nama'] }}"
                                        class="inline-flex items-center gap-1 rounded-lg border border-brand-200 bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700 dark:border-brand-500/30 dark:bg-brand-500/10 dark:text-brand-400">
                                        Unduh
                                    </a>
                                @endif
                                @if ($baris['edit_url'])
                                    <a href="{{ $baris['edit_url'] }}"
                                        class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-2.5 py-1 text-xs font-semibold text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        Ubah
                                    </a>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>

                {{-- Pagination Navigasi --}}
                @if ($arsip->hasPages())
                    <div class="border-t border-gray-100 px-5 py-3 dark:border-gray-800">
                        {{ $arsip->links() }}
                    </div>
                @endif
            @endif
        </section>

        {{-- Modal Preview Pratinjau Nota TailAdmin --}}
        <div x-show="previewModal" x-transition.opacity class="fixed inset-0 z-99999 flex items-center justify-center bg-gray-900/60 backdrop-blur-xs p-4" style="display: none;">
            <div x-show="previewModal" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                @click.outside="previewModal = false"
                class="w-full max-w-3xl rounded-2xl bg-white p-5 shadow-2xl dark:bg-gray-900 border border-gray-200 dark:border-gray-800 flex flex-col max-h-[90vh]">

                <div class="flex items-center justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate" x-text="previewNama"></h3>
                    <div class="flex items-center gap-2">
                        <a :href="previewUrl" target="_blank"
                            class="rounded-lg border border-gray-200 bg-white px-3 py-1 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                            Buka Tab Baru ↗
                        </a>
                        <button type="button" @click="previewModal = false"
                            class="p-1 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            ✕
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-auto py-4 flex items-center justify-center min-h-[300px]">
                    <template x-if="isImage && previewUrl">
                        <img :src="previewUrl" :alt="previewNama" class="max-h-[70vh] w-auto rounded-lg object-contain shadow-sm">
                    </template>
                    <template x-if="!isImage && previewUrl">
                        <iframe :src="previewUrl" class="w-full h-[65vh] rounded-lg border border-gray-200 dark:border-gray-800"></iframe>
                    </template>
                </div>

                <div class="border-t border-gray-100 pt-3 dark:border-gray-800 flex justify-end">
                    <button type="button" @click="previewModal = false"
                        class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
