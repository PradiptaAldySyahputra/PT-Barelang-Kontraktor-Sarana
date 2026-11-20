{{--
    Arsip Nota (/panel/receipts): semua berkas bukti uang masuk & keluar.
    Dilengkapi pagination, pratinjau modal/preview, tautan edit transaksi terkait, dan unduh ZIP.
--}}
@php
    use App\Support\Nota;
    use App\Support\Format;

    $kelasKartu = 'rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs';
    $kelasInput = 'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-500 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-500';
    $kelasTanggal = 'min-w-0 flex-1 border-0 bg-transparent p-0 text-sm text-gray-800 focus:outline-hidden focus:ring-0 dark:text-white/90 lg:w-40 lg:flex-none';
    $jumlahBerkasAda = $semuaArsip->where('ada', true)->count();
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <div class="space-y-5" x-data="{
        previewModal: false,
        previewUrl: '',
        previewNama: '',
        previewJenis: '',
        previewId: '',
        previewPath: '',
        isImage: true,
        bukaPratinjau(url, nama, gambar, jenis, id, path) {
            this.previewUrl = url;
            this.previewNama = nama;
            this.isImage = gambar;
            this.previewJenis = jenis || '';
            this.previewId = id || '';
            this.previewPath = path || '';
            this.previewModal = true;
        }
    }">
        {{-- Form Filter Pencarian --}}
        <form method="GET" action="{{ route('panel.receipts') }}" class="{{ $kelasKartu }} p-4 sm:p-5">
            <div class="grid grid-cols-1 gap-2.5 sm:grid-cols-2 lg:flex lg:flex-wrap lg:items-center">
                <div class="min-w-0 sm:col-span-2 lg:max-w-xs lg:flex-1">
                    <label for="q" class="sr-only">Cari</label>
                    <input id="q" name="q" type="search" value="{{ $filter['q'] }}"
                        placeholder="Cari nomor transaksi, pihak, atau keterangan..."
                        class="{{ $kelasInput }}">
                </div>

                <x-common.filter-tanggal id="tanggal-arsip" mode="get" :tanggal="(string) ($filter['tanggal_awal'] ?? '')" />

                <label class="sr-only" for="akun">Akun Kas/Bank</label>
                <select id="akun" name="akun" class="{{ $kelasInput }} lg:w-40 lg:flex-none">
                    <option value="">Semua Akun</option>
                    @foreach ($opsiAkun as $nilai => $label)
                        <option value="{{ $nilai }}" @selected($filter['akun'] === $nilai)>{{ $label }}</option>
                    @endforeach
                </select>

                <label class="sr-only" for="kategori">Kategori Pengeluaran</label>
                <select id="kategori" name="kategori" class="{{ $kelasInput }} lg:w-44 lg:flex-none">
                    <option value="">Semua Kategori</option>
                    @foreach ($opsiKategori as $nilai => $label)
                        <option value="{{ $nilai }}" @selected($filter['kategori'] === $nilai)>{{ $label }}</option>
                    @endforeach
                </select>

                <div class="flex flex-wrap items-center gap-2 sm:col-span-2 lg:ml-auto">
                    @if (auth()->user()?->bolehInput())
                        <a href="{{ route('panel.receipts.upload') }}"
                            class="inline-flex h-11 items-center gap-1.5 rounded-lg bg-brand-600 px-3.5 text-theme-xs font-semibold text-white shadow-theme-xs transition hover:bg-brand-700"
                            title="Unggah nota fisik untuk diekstrak otomatis">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Unggah Nota
                        </a>
                    @endif

                    <button type="submit"
                        class="inline-flex h-11 items-center rounded-lg bg-gray-900 px-4 text-theme-xs font-semibold text-white shadow-theme-xs transition hover:bg-gray-800 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100">
                        Filter
                    </button>

                    <a href="{{ route('arsip-nota.zip', request()->only(['q', 'tanggal', 'periode', 'akun', 'kategori'])) }}"
                        class="inline-flex h-11 items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3.5 text-theme-xs font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                        title="Unduh seluruh nota terfilter dalam format ZIP">
                        <svg class="h-4 w-4 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh ZIP
                    </a>

                    @if (filled($filter['q']) || filled($filter['tanggal_awal']) || filled($filter['tanggal_akhir']) || filled($filter['akun']) || filled($filter['kategori']))
                        <a href="{{ route('panel.receipts') }}" class="text-theme-xs font-medium text-error-600 hover:underline dark:text-error-400">
                            Reset
                        </a>
                    @endif
                </div>
            </div>

            <div class="mt-3 flex flex-wrap items-center gap-2 border-t border-gray-200/70 pt-3 dark:border-gray-700/60">
                <x-common.filter-periode mode="get" :periode="$periode" />
            </div>
        </form>

        {{-- Tabel Berkas Arsip Nota --}}
        <section class="{{ $kelasKartu }} overflow-hidden">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                <div>
                    <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Daftar Berkas Bukti & Kuitansi</h2>
                    <p class="text-theme-xs text-gray-500 dark:text-gray-400">
                        Menampilkan {{ $arsip->count() }} dari total {{ $semuaArsip->count() }} berkas nota
                    </p>
                </div>
                <span class="rounded-full bg-brand-50 px-3 py-1 text-theme-xs font-semibold text-brand-700 dark:bg-brand-500/10 dark:text-brand-300">
                    {{ $jumlahBerkasAda }} Berkas Tersedia di Server
                </span>
            </div>

            @if ($arsip->isEmpty())
                <div class="px-5 py-12 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                    <p>Tidak ada berkas nota pada filter ini.</p>
                </div>
            @else
                @php $qArsip = request()->except(['jenis', 'periode']); @endphp
                {{-- Pemisah jenis arsip (pola tab segmented monitoring SPK) --}}
                <div class="my-4 mx-5 inline-flex items-center gap-1 rounded-xl bg-gray-100 p-1 shadow-theme-xs dark:bg-gray-800/80">
                    <a href="{{ route('panel.receipts', $qArsip) }}"
                        class="inline-flex items-center whitespace-nowrap rounded-lg px-4 py-2 text-xs font-bold transition-all {{ ! $filter['jenis'] ? 'bg-white text-gray-900 shadow-theme-xs dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                        Semua
                    </a>
                    <a href="{{ route('panel.receipts', array_merge($qArsip, ['jenis' => 'Uang Masuk'])) }}"
                        class="inline-flex items-center whitespace-nowrap rounded-lg px-4 py-2 text-xs font-bold transition-all {{ $filter['jenis'] === 'Uang Masuk' ? 'bg-white text-gray-900 shadow-theme-xs dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                        Uang Masuk
                    </a>
                    <a href="{{ route('panel.receipts', array_merge($qArsip, ['jenis' => 'Uang Keluar'])) }}"
                        class="inline-flex items-center whitespace-nowrap rounded-lg px-4 py-2 text-xs font-bold transition-all {{ $filter['jenis'] === 'Uang Keluar' ? 'bg-white text-gray-900 shadow-theme-xs dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                        Uang Keluar
                    </a>
                </div>
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left text-theme-sm">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/70 text-theme-xs font-medium uppercase tracking-wide text-gray-500 dark:border-gray-800 dark:bg-white/[0.02] dark:text-gray-400">
                                <th class="w-24 px-4 py-3">Tanggal</th>
                                <th class="w-28 px-3 py-3">Transaksi</th>
                                <th class="w-24 px-3 py-3">Akun</th>
                                <th class="min-w-[138px] px-3 py-3 text-right">Jumlah</th>
                                <th class="px-3 py-3">Keterangan / Mitra</th>
                                <th class="w-56 px-4 py-3">Nama Berkas</th>
                                <th class="w-36 px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($arsip as $baris)
                                <tr class="hover:bg-gray-50/60 dark:hover:bg-white/[0.02] transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-theme-sm text-gray-700 dark:text-gray-300">
                                        {{ $baris['tanggal']?->format('d/m/Y') ?? '—' }}
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-theme-xs font-semibold {{ $baris['jenis'] === 'Uang Masuk' ? 'bg-success-50 text-success-700 dark:bg-success-500/10 dark:text-success-400' : 'bg-error-50 text-error-700 dark:bg-error-500/10 dark:text-error-400' }}">
                                            {{ $baris['jenis'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-theme-sm text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                        {{ $baris['akun'] ?? '—' }}
                                    </td>
                                    <td class="min-w-[138px] shrink-0 px-3 py-3 text-right whitespace-nowrap">
                                        <span class="text-theme-sm font-semibold {{ $baris['jenis'] === 'Uang Masuk' ? 'text-success-700 dark:text-success-400' : 'text-error-700 dark:text-error-400' }}">
                                            {{ filled($baris['jumlah']) ? Format::rupiah((float) $baris['jumlah']) : '—' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <p class="font-medium text-theme-sm text-gray-900 dark:text-gray-100 truncate max-w-xs">
                                            {{ $baris['penerima'] ?: ($baris['keterangan'] ?: '—') }}
                                        </p>
                                        @if (filled($baris['penerima']) && filled($baris['keterangan']))
                                            <p class="text-theme-xs text-gray-500 dark:text-gray-400 truncate max-w-xs">
                                                {{ $baris['keterangan'] }}
                                            </p>
                                        @endif
                                        @if (filled($baris['spk_nomor']))
                                            <span class="text-theme-xs text-brand-600 dark:text-brand-400">SPK: {{ $baris['spk_nomor'] }}</span>
                                        @elseif (filled($baris['kategori']))
                                            <span class="text-theme-xs text-gray-500 dark:text-gray-400">Kat: {{ $baris['kategori'] }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($baris['ada'])
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                                    @if ($baris['gambar'])
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                        </svg>
                                                    @endif
                                                </span>
                                                <span class="min-w-0 truncate text-theme-xs font-medium text-gray-700 dark:text-gray-300" title="{{ $baris['nama'] }}">
                                                    {{ $baris['nama'] }}
                                                </span>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-theme-sm text-gray-700 dark:text-gray-300">{{ $baris['nama'] }}</span>
                                                <span class="text-theme-xs rounded px-1 font-medium bg-error-50 text-error-700 dark:bg-error-500/10 dark:text-error-400" title="Berkas fisik belum diunggah atau sudah dipindahkan">
                                                    (belum ada file)
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center justify-end gap-1.5">
                                            @if ($baris['ada'])
                                                <button type="button" @click="bukaPratinjau(@js($baris['url']), @js($baris['nama']), {{ $baris['gambar'] ? 'true' : 'false' }}, @js($baris['jenis']), @js($baris['model_id'] ?? ''), @js($baris['path'] ?? ''))"
                                                    class="inline-flex h-8 items-center gap-1 rounded-lg border border-gray-300 bg-white px-2.5 text-theme-xs font-semibold text-gray-700 shadow-theme-xs transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                                                    title="Pratinjau in-app">
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Lihat
                                                </button>
                                                <a href="{{ $baris['url'] }}" download="{{ $baris['nama'] }}"
                                                    class="inline-flex h-8 items-center gap-1 rounded-lg border border-brand-300 bg-brand-50 px-2.5 text-theme-xs font-semibold text-brand-700 shadow-theme-xs transition hover:bg-brand-100 dark:border-brand-500/30 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20">
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Unduh
                                                </a>
                                            @endif
                                            @if ($baris['edit_url'])
                                                <a href="{{ $baris['edit_url'] }}"
                                                    class="inline-flex h-8 items-center gap-1 rounded-lg border border-gray-300 bg-white px-2.5 text-theme-xs font-semibold text-gray-700 shadow-theme-xs transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                                    title="Buka & ubah transaksi asal">
                                                    Ubah
                                                </a>
                                            @endif
                                            @if ($baris['ada'] && filled($baris['model_id'] ?? null) && filled($baris['path'] ?? null))
                                                <form method="POST" action="{{ route('panel.receipts.hapus-berkas') }}" class="inline"
                                                    onsubmit="return confirm('Hapus berkas nota ini? File asli akan dihapus dari penyimpanan.')">
                                                    @csrf
                                                    <input type="hidden" name="jenis" value="{{ $baris['jenis'] }}">
                                                    <input type="hidden" name="id" value="{{ $baris['model_id'] }}">
                                                    <input type="hidden" name="path" value="{{ $baris['path'] }}">
                                                    <button type="submit"
                                                        class="inline-flex h-8 items-center gap-1 rounded-lg border border-error-300 bg-white px-2.5 text-theme-xs font-semibold text-error-700 shadow-theme-xs transition hover:bg-error-50 dark:border-error-500/30 dark:bg-gray-800 dark:text-error-400 dark:hover:bg-error-500/10"
                                                        title="Hapus berkas nota">
                                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
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
                                <span class="text-theme-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ $baris['tanggal']?->format('d/m/Y') ?? '—' }} · {{ $baris['akun'] ?? '—' }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-theme-xs font-semibold {{ $baris['jenis'] === 'Uang Masuk' ? 'bg-success-50 text-success-700 dark:bg-success-500/10 dark:text-success-400' : 'bg-error-50 text-error-700 dark:bg-error-500/10 dark:text-error-400' }}">
                                    {{ $baris['jenis'] }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-2">
                                <span class="text-theme-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Jumlah</span>
                                <span class="text-theme-sm font-semibold {{ $baris['jenis'] === 'Uang Masuk' ? 'text-success-700 dark:text-success-400' : 'text-error-700 dark:text-error-400' }}">
                                    {{ filled($baris['jumlah']) ? Format::rupiah((float) $baris['jumlah']) : '—' }}
                                </span>
                            </div>

                            <p class="text-theme-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $baris['penerima'] ?: ($baris['keterangan'] ?: '—') }}
                            </p>
                            @if (filled($baris['penerima']) && filled($baris['keterangan']))
                                <p class="text-theme-xs text-gray-500 dark:text-gray-400">
                                    {{ $baris['keterangan'] }}
                                </p>
                            @endif

                            <div class="flex items-center justify-between gap-2 text-theme-sm text-gray-500 dark:text-gray-400">
                                <span class="truncate">{{ $baris['nama'] }}</span>
                                @if (! $baris['ada'])
                                    <span class="text-theme-xs rounded px-1 font-medium bg-error-50 text-error-700 dark:bg-error-500/10 dark:text-error-400">
                                        (belum ada file)
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center justify-end gap-1.5 border-t border-gray-100 pt-2 dark:border-gray-800">
                                @if ($baris['ada'])
                                    <button type="button" @click="bukaPratinjau(@js($baris['url']), @js($baris['nama']), {{ $baris['gambar'] ? 'true' : 'false' }}, @js($baris['jenis']), @js($baris['model_id'] ?? ''), @js($baris['path'] ?? ''))"
                                        class="inline-flex h-8 items-center gap-1 rounded-lg border border-gray-300 bg-white px-2.5 text-theme-xs font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat
                                    </button>
                                    <a href="{{ $baris['url'] }}" download="{{ $baris['nama'] }}"
                                        class="inline-flex h-8 items-center gap-1 rounded-lg border border-brand-300 bg-brand-50 px-2.5 text-theme-xs font-semibold text-brand-700 dark:border-brand-500/30 dark:bg-brand-500/10 dark:text-brand-400">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Unduh
                                    </a>
                                @endif
                                @if ($baris['edit_url'])
                                    <a href="{{ $baris['edit_url'] }}"
                                        class="inline-flex h-8 items-center gap-1 rounded-lg border border-gray-300 bg-white px-2.5 text-theme-xs font-semibold text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        Ubah
                                    </a>
                                @endif
                                @if ($baris['ada'] && filled($baris['model_id'] ?? null) && filled($baris['path'] ?? null))
                                    <form method="POST" action="{{ route('panel.receipts.hapus-berkas') }}" class="inline"
                                        onsubmit="return confirm('Hapus berkas nota ini? File asli akan dihapus dari penyimpanan.')">
                                        @csrf
                                        <input type="hidden" name="jenis" value="{{ $baris['jenis'] }}">
                                        <input type="hidden" name="id" value="{{ $baris['model_id'] }}">
                                        <input type="hidden" name="path" value="{{ $baris['path'] }}">
                                        <button type="submit"
                                            class="inline-flex h-8 items-center gap-1 rounded-lg border border-error-300 bg-white px-2.5 text-theme-xs font-semibold text-error-700 dark:border-error-500/30 dark:bg-gray-800 dark:text-error-400 dark:hover:bg-error-500/10">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>

                {{-- Cap tampilan (pola laporan) --}}
                @if (! $semua && $semuaArsip->count() > $batas)
                    <div class="flex flex-wrap items-center justify-between gap-2 border-t border-gray-100 px-5 py-3 dark:border-gray-800">
                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">
                            Menampilkan {{ $batas }} dari {{ $semuaArsip->count() }} berkas nota
                        </p>
                        <a href="{{ route('panel.receipts', array_merge(request()->query(), ['semua' => 1])) }}"
                            class="text-theme-xs font-semibold text-brand-600 hover:underline dark:text-brand-400">
                            Tampilkan Semua
                        </a>
                    </div>
                @endif
            @endif
        </section>

        {{-- Modal Pratinjau Nota (in-app) --}}
        <div x-show="previewModal" x-cloak x-transition.opacity
            class="fixed inset-0 z-99999 flex items-center justify-center bg-gray-900/60 p-4 backdrop-blur-xs"
            @keydown.escape.window="previewModal = false" role="dialog" aria-modal="true" aria-label="Pratinjau berkas nota">
            <div x-show="previewModal" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                @click.outside="previewModal = false"
                class="flex max-h-[90vh] w-full max-w-3xl flex-col rounded-2xl border border-gray-200 bg-white p-5 shadow-2xl dark:border-gray-800 dark:bg-gray-900">

                <div class="flex items-center justify-between gap-3 border-b border-gray-100 pb-3 dark:border-gray-800">
                    <h3 class="min-w-0 flex-1 truncate text-theme-sm font-semibold text-gray-900 dark:text-white" x-text="previewNama"></h3>
                    <div class="flex shrink-0 items-center gap-2">
                        <a :href="previewUrl" :download="previewNama"
                            class="inline-flex h-9 items-center gap-1.5 rounded-lg border border-brand-300 bg-brand-50 px-3 text-theme-xs font-semibold text-brand-700 transition hover:bg-brand-100 dark:border-brand-500/30 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh
                        </a>
                        <a :href="previewUrl" target="_blank" rel="noopener"
                            class="inline-flex h-9 items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 text-theme-xs font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Tab Baru
                        </a>
                        <button type="button" @click="previewModal = false" aria-label="Tutup pratinjau"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-200">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex min-h-[300px] flex-1 items-center justify-center overflow-auto py-4">
                    <template x-if="isImage && previewUrl">
                        <img :src="previewUrl" :alt="previewNama" class="max-h-[65vh] w-auto rounded-lg object-contain shadow-theme-xs">
                    </template>
                    <template x-if="!isImage && previewUrl">
                        <iframe :src="previewUrl" title="Pratinjau berkas PDF"
                            class="h-[60vh] w-full rounded-lg border border-gray-200 dark:border-gray-800"></iframe>
                    </template>
                </div>

                <div class="flex items-center justify-between gap-3 border-t border-gray-100 pt-3 dark:border-gray-800">
                    <form x-show="previewPath" method="POST" action="{{ route('panel.receipts.hapus-berkas') }}"
                        onsubmit="return confirm('Hapus berkas ini? File asli akan dihapus dari penyimpanan.');">
                        @csrf
                        <input type="hidden" name="jenis" :value="previewJenis">
                        <input type="hidden" name="id" :value="previewId">
                        <input type="hidden" name="path" :value="previewPath">
                        <button type="submit"
                            class="inline-flex h-10 items-center gap-1.5 rounded-lg border border-error-300 bg-white px-4 text-theme-xs font-semibold text-error-700 transition hover:bg-error-50 dark:border-error-500/30 dark:bg-gray-800 dark:text-error-400 dark:hover:bg-error-500/10">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Berkas
                        </button>
                    </form>
                    <button type="button" @click="previewModal = false"
                        class="inline-flex h-10 items-center rounded-lg border border-gray-300 bg-white px-4 text-theme-xs font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>