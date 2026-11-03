@php
    use App\Support\Format;
    use App\Enums\StatusTagihan;

    $kelasBadge = [
        'gray' => 'bg-gray-100 text-gray-700 dark:bg-white/10 dark:text-gray-300',
        'info' => 'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300',
        'primary' => 'bg-brand-50 text-brand-700 dark:bg-brand-500/15 dark:text-brand-300',
        'success' => 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500',
        'warning' => 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-500',
        'danger' => 'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-500',
    ];
    $badge = static fn (?string $warna): string => $kelasBadge[$warna ?? 'gray'] ?? $kelasBadge['gray'];

    $tampilTagihan = $mode !== 'status';
@endphp

<div x-data="{
    drawerOpen: false,
    loadingTermin: false,
    terminData: null,
    async bukaTermin(spkId) {
        this.drawerOpen = true;
        this.loadingTermin = true;
        this.terminData = null;
        try {
            const res = await fetch(`/panel/spk/${spkId}/termin-drawer`);
            this.terminData = await res.json();
        } catch (e) {
            console.error('Gagal mengambil data termin:', e);
        } finally {
            this.loadingTermin = false;
        }
    }
}">
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">

        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 px-5 py-4 dark:border-gray-800">
            <p class="text-base font-bold text-gray-900 dark:text-white">
                <span class="angka">{{ Format::angka($ringkas['jumlah']) }}</span> SPK
                @if ($adaPenyaring)
                    <span class="text-theme-xs font-normal text-gray-400">(disaring)</span>
                @endif
                <span class="mx-2 text-gray-300 dark:text-gray-700">·</span>
                Total <span class="angka text-brand-600 dark:text-brand-400">{{ Format::rupiah($ringkas['nilai']) }}</span>
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3 px-5 py-3.5 bg-gray-50/50 dark:bg-white/[0.01] border-b border-gray-100 dark:border-gray-800">
            <div class="relative min-w-0 flex-1 sm:max-w-xs">
                <label for="cari-monitoring" class="sr-only">Cari di tabel ini</label>
                <svg class="pointer-events-none absolute top-1/2 left-3.5 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                </svg>
                <input id="cari-monitoring" type="search" wire:model.live.debounce.300ms="cari"
                    placeholder="Cari nomor, pekerjaan, lokasi, mitra..."
                    class="h-10 w-full rounded-lg border border-gray-300 bg-white pr-4 pl-10 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
            </div>

            @if ($mode !== 'billing')
                <label class="sr-only" for="saring-status">Status pekerjaan</label>
                <select id="saring-status" wire:model.live="status"
                    class="h-10 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800">
                    <option value="">Semua status</option>
                    @foreach ($opsiStatus as $nilai => $label)
                        <option value="{{ $nilai }}">{{ $label }}</option>
                    @endforeach
                </select>
            @endif

            <label class="sr-only" for="saring-tagihan">Status tagihan</label>
            <select id="saring-tagihan" wire:model.live="tagihan"
                class="h-10 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800">
                <option value="">Semua tagihan</option>
                @foreach ($opsiTagihan as $nilai => $label)
                    <option value="{{ $nilai }}">{{ $label }}</option>
                @endforeach
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
                <p class="text-theme-sm font-medium text-gray-900 dark:text-white">Tidak ada SPK di menu ini.</p>
                @if ($adaPenyaring)
                    <button type="button" wire:click="bersihkan"
                        class="mt-3 inline-flex h-8 items-center rounded-lg border border-gray-300 px-3 text-theme-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200">
                        Bersihkan penyaring
                    </button>
                @endif
            </div>
        @else
            {{-- Desktop Table: 100% Fit Tanpa Scroll Samping --}}
            <div class="hidden overflow-hidden md:block border-t border-gray-100 dark:border-gray-800">
                <table class="w-full text-left text-theme-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/70 text-[11px] font-medium uppercase tracking-wide text-gray-500 dark:border-gray-800 dark:bg-white/[0.02] dark:text-gray-400">
                            <th class="px-4 py-3">
                                <button type="button" wire:click="urutkan('nomor_spk')" class="inline-flex items-center gap-1 hover:text-gray-900 dark:hover:text-white">
                                    SPK & Mitra
                                    @if ($urut === 'nomor_spk')
                                        <span class="text-brand-600" aria-hidden="true">{{ $arah === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-700" aria-hidden="true">⇅</span>
                                    @endif
                                </button>
                            </th>
                            <th class="px-3 py-3">Pekerjaan & Tenggat</th>
                            <th class="px-3 py-3">Status & Tagihan</th>
                            <th class="px-3 py-3 text-right">
                                <button type="button" wire:click="urutkan('nilai_spk')" class="inline-flex items-center gap-1 hover:text-gray-900 dark:hover:text-white">
                                    Nilai / Sisa Piutang
                                    @if ($urut === 'nilai_spk')
                                        <span class="text-brand-600" aria-hidden="true">{{ $arah === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-700" aria-hidden="true">⇅</span>
                                    @endif
                                </button>
                            </th>
                            @if ($bolehUbah)
                                <th class="px-4 py-3 text-right">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-theme-sm dark:divide-gray-800">
                        @foreach ($daftar as $spk)
                            @php
                                $sisa = $spk->sisaTenggatHari();
                                $belum = $spk->sisaTagih();
                            @endphp
                            <tr wire:key="mon-{{ $spk->id }}" class="align-top hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                                {{-- SPK & Mitra --}}
                                <td class="px-4 py-3 align-top">
                                    <a href="{{ route('panel.spk.show', ['spk' => $spk, 'asal' => $asal]) }}"
                                        class="angka block font-semibold text-brand-600 hover:underline dark:text-brand-400"
                                        title="Klik untuk membuka detail SPK {{ $spk->nomor_spk }}">
                                        {{ $spk->nomor_spk }}
                                    </a>
                                    <p class="truncate text-theme-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $spk->mitra?->nama ?? 'Tanpa mitra' }}
                                    </p>
                                </td>

                                {{-- Pekerjaan & Tenggat --}}
                                <td class="px-3 py-3 align-top">
                                    <p class="line-clamp-2 text-gray-900 dark:text-gray-100 font-medium">{{ $spk->nama_pekerjaan }}</p>
                                    <div class="mt-1 flex flex-wrap items-center gap-1.5 text-theme-xs">
                                        <span class="text-gray-400">Tenggat:</span>
                                        <span class="font-semibold {{ $sisa !== null && $sisa < 0 ? 'text-error-600 dark:text-error-500' : ($sisa !== null && $sisa <= 14 ? 'text-warning-600 dark:text-warning-500' : 'text-gray-700 dark:text-gray-300') }}"
                                            title="{{ $sisa === null ? '' : ($sisa < 0 ? 'Lewat '.abs($sisa).' hari' : 'Sisa '.$sisa.' hari') }}">
                                            {{ $spk->tenggatEfektif()?->format('d/m/Y') ?? '—' }}
                                        </span>
                                        @if ($sisa !== null && $sisa < 0)
                                            <span class="text-[10px] rounded px-1 font-bold bg-error-50 text-error-700 dark:bg-error-500/20 dark:text-error-400">
                                                Lewat {{ abs($sisa) }} hari
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Status & Tagihan --}}
                                <td class="px-3 py-3 align-top whitespace-nowrap">
                                    <div class="space-y-1">
                                        <div>
                                            <span class="inline-flex rounded px-2 py-0.5 text-[11px] font-semibold {{ $badge($spk->status_spk?->warnaBadge()) }}">
                                                {{ $spk->status_spk?->label() ?? 'Draft' }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="inline-flex rounded px-2 py-0.5 text-[11px] font-semibold {{ $badge($spk->status_tagihan?->warnaBadge()) }}">
                                                {{ $spk->status_tagihan?->labelPendek() ?? 'Belum ditagih' }}
                                            </span>
                                            @if ($mode === 'billing' && $spk->status_tagihan?->value !== StatusTagihan::Dibayar->value)
                                                @php
                                                    $agingHari = (int) ($spk->updated_at ? $spk->updated_at->diffInDays(now()) : 0);
                                                @endphp
                                                <p class="mt-0.5 text-[10px] {{ $agingHari > 30 ? 'font-semibold text-error-600 dark:text-error-400' : 'text-gray-400' }}">
                                                    Tertahan {{ $agingHari }} hari
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Nilai & Sisa Piutang --}}
                                <td class="px-3 py-3 text-right align-top whitespace-nowrap">
                                    <span class="angka block font-bold text-gray-900 dark:text-white">
                                        {{ Format::rupiah((float) $spk->nilai_spk) }}
                                    </span>
                                    <button type="button" @click="bukaTermin({{ $spk->id }})"
                                        class="angka block text-theme-xs mt-0.5 hover:underline {{ $belum > 0.01 ? 'font-semibold text-warning-600 dark:text-warning-400' : 'text-success-600 dark:text-success-400' }}"
                                        title="Klik untuk melihat riwayat termin pembayaran">
                                        Sisa: {{ Format::rupiah($belum) }} 🔍
                                    </button>
                                </td>

                                {{-- Aksi: Terpisah Sesuai Konteks Menu --}}
                                @if ($bolehUbah)
                                    <td class="px-4 py-3 text-right align-top whitespace-nowrap">
                                        <div class="inline-flex items-center justify-end gap-1.5">
                                            @if ($mode === 'status')
                                                @if ($spk->status_tagihan?->value === StatusTagihan::Dibayar->value)
                                                    <a href="{{ route('panel.spk.monitoring', 'completed') }}"
                                                        class="inline-flex items-center gap-1 rounded-lg border border-success-200 bg-success-50 px-2.5 py-1 text-xs font-semibold text-success-700 hover:bg-success-100 dark:border-success-500/30 dark:bg-success-500/10 dark:text-success-400 transition"
                                                        title="SPK sudah selesai & lunas (Buka Arsip)">
                                                        ✓ Lunas
                                                    </a>
                                                @endif
                                                <a href="{{ route('panel.spk.status', ['spk' => $spk, 'asal' => $asal]) }}"
                                                    class="inline-flex items-center gap-1 rounded-lg border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-100 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-400 transition"
                                                    title="Ubah Status Progres Pekerjaan">
                                                    Ubah Status
                                                </a>
                                            @elseif ($mode === 'billing')
                                                <a href="{{ route('panel.spk.billing', ['spk' => $spk, 'asal' => $asal]) }}"
                                                    class="inline-flex items-center gap-1 rounded-lg border border-brand-200 bg-brand-50 px-3 py-1.5 text-xs font-semibold text-brand-700 hover:bg-brand-100 dark:border-brand-500/30 dark:bg-brand-500/10 dark:text-brand-400 transition"
                                                    title="Ubah Status Tagihan & Pembayaran">
                                                    Ubah Tagihan
                                                </a>
                                            @else
                                                <span class="inline-flex items-center gap-1 rounded-lg border border-success-200 bg-success-50 px-2.5 py-1 text-xs font-semibold text-success-700 dark:border-success-500/30 dark:bg-success-500/10 dark:text-success-400">
                                                    ✓ Lunas
                                                </span>
                                            @endif
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
                @foreach ($daftar as $spk)
                    @php
                        $sisa = $spk->sisaTenggatHari();
                        $belum = $spk->sisaTagih();
                    @endphp
                    <li class="px-4 py-3.5 space-y-2">
                        <div class="flex items-start justify-between gap-2">
                            <a href="{{ route('panel.spk.show', ['spk' => $spk, 'asal' => $asal]) }}"
                                class="angka font-bold text-theme-sm text-brand-600 dark:text-brand-400">
                                {{ $spk->nomor_spk }}
                            </a>
                            <span class="inline-flex rounded px-2 py-0.5 text-[11px] font-semibold {{ $badge($spk->status_tagihan?->warnaBadge()) }}">
                                {{ $spk->status_tagihan?->labelPendek() ?? 'Belum ditagih' }}
                            </span>
                        </div>

                        <p class="text-xs font-medium text-gray-800 dark:text-gray-200 line-clamp-2">
                            {{ $spk->nama_pekerjaan }}
                        </p>

                        <div class="flex flex-wrap items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                            <span>{{ $spk->mitra?->nama ?? 'Tanpa mitra' }}</span>
                            <span class="font-semibold {{ $sisa < 0 ? 'text-error-600' : '' }}">
                                {{ $spk->tenggatEfektif()?->format('d/m/Y') }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-gray-800">
                            <div>
                                <span class="angka font-bold text-xs text-gray-900 dark:text-white">{{ Format::rupiah((float) $spk->nilai_spk) }}</span>
                                <span class="block text-[10px] text-gray-400">Sisa: {{ Format::rupiah($belum) }}</span>
                            </div>
                            @if ($bolehUbah)
                                <div class="inline-flex items-center gap-1.5">
                                    @if ($mode === 'status')
                                        <a href="{{ route('panel.spk.status', ['spk' => $spk, 'asal' => $asal]) }}"
                                            class="inline-flex rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                            Ubah Status
                                        </a>
                                    @elseif ($mode === 'billing')
                                        <a href="{{ route('panel.spk.billing', ['spk' => $spk, 'asal' => $asal]) }}"
                                            class="inline-flex rounded-lg border border-brand-200 bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700">
                                            Ubah Tagihan
                                        </a>
                                    @else
                                        <span class="inline-flex rounded-lg border border-success-200 bg-success-50 px-2 py-0.5 text-xs font-semibold text-success-700">
                                            ✓ Lunas
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
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

    {{-- Drawer Pop-up Riwayat Termin Pembayaran --}}
    <div x-show="drawerOpen" x-transition.opacity class="fixed inset-0 z-99999 bg-gray-900/50 backdrop-blur-xs flex justify-end" style="display: none;">
        <div x-show="drawerOpen" x-transition:enter="transition transform ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform ease-in duration-200"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
            @click.outside="drawerOpen = false"
            class="w-full max-w-md bg-white dark:bg-gray-900 h-full shadow-2xl flex flex-col border-l border-gray-200 dark:border-gray-800">

            {{-- Header Drawer --}}
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Riwayat Termin Pembayaran</h3>
                    <p class="text-theme-xs text-gray-500 dark:text-gray-400" x-text="terminData?.nomor_spk || 'Memuat...'"></p>
                </div>
                <button type="button" @click="drawerOpen = false" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Isi Drawer --}}
            <div class="flex-1 overflow-y-auto p-5 space-y-4">
                <template x-if="loadingTermin">
                    <div class="py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                        <svg class="inline h-6 w-6 animate-spin text-brand-500 mb-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <p>Mengambil data termin...</p>
                    </div>
                </template>

                <template x-if="!loadingTermin && terminData">
                    <div class="space-y-4">
                        {{-- Ringkasan SPK --}}
                        <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800">
                            <p class="text-xs text-gray-500 dark:text-gray-400" x-text="terminData.mitra"></p>
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mt-0.5 line-clamp-2" x-text="terminData.pekerjaan"></h4>
                            <div class="mt-3 grid grid-cols-2 gap-2 pt-3 border-t border-gray-200/60 dark:border-gray-700/60 text-xs">
                                <div>
                                    <span class="text-gray-400">Nilai Kontrak:</span>
                                    <p class="font-bold text-gray-900 dark:text-white" x-text="terminData.nilai_spk"></p>
                                </div>
                                <div>
                                    <span class="text-gray-400">Sisa Piutang:</span>
                                    <p class="font-bold text-warning-600 dark:text-warning-400" x-text="terminData.sisa_piutang"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Daftar Transaksi Termin --}}
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">
                                Pembayaran Diterima (<span x-text="terminData.transaksi.length"></span>)
                            </h4>
                            <template x-if="terminData.transaksi.length === 0">
                                <p class="rounded-xl border border-dashed border-gray-200 dark:border-gray-800 p-6 text-center text-xs text-gray-400">
                                    Belum ada termin uang masuk untuk SPK ini.
                                </p>
                            </template>

                            <div class="space-y-2">
                                <template x-for="(trx, idx) in terminData.transaksi" :key="trx.id">
                                    <div class="rounded-xl border border-gray-100 bg-white p-3 shadow-xs dark:border-gray-800 dark:bg-gray-800/40 flex items-center justify-between gap-3">
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2">
                                                <span class="rounded bg-brand-50 px-1.5 py-0.5 text-[10px] font-bold text-brand-600 dark:bg-brand-500/10 dark:text-brand-300" x-text="'Termin ' + (idx + 1)"></span>
                                                <span class="text-xs text-gray-400" x-text="trx.tanggal"></span>
                                            </div>
                                            <p class="text-xs font-medium text-gray-800 dark:text-gray-200 mt-1 truncate" x-text="trx.keterangan"></p>
                                            <span class="text-[11px] text-gray-400" x-text="'Akun: ' + trx.akun"></span>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <p class="text-xs font-bold text-success-600 dark:text-success-400" x-text="'+ ' + trx.jumlah"></p>
                                            <a :href="trx.kuitansi_url" class="inline-flex items-center gap-1 mt-1 text-[11px] font-semibold text-brand-600 hover:underline dark:text-brand-400">
                                                📄 Kuitansi
                                            </a>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Footer Drawer --}}
            <div class="border-t border-gray-100 p-4 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/20">
                <button type="button" @click="drawerOpen = false"
                    class="w-full rounded-xl border border-gray-300 bg-white py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
