@php
    use App\Support\Nota;

    $kelasInput = 'h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3.5 py-2 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800';
    $kelasLabel = 'block text-theme-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400 mb-1.5';
    $kelasKartu = 'rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs md:p-6';
@endphp

<div class="space-y-4">

    @if (session('berhasil'))
        <div class="rounded-lg border border-success-100 bg-success-50 px-4 py-3 text-theme-sm text-success-700 dark:border-success-600/30 dark:bg-success-600/10 dark:text-success-500">
            {{ session('berhasil') }}
        </div>
    @endif

    @error('baris')
        <div class="rounded-lg border border-error-100 bg-error-50 px-4 py-3 text-theme-sm text-error-700 dark:border-error-600/30 dark:bg-error-600/10 dark:text-error-500">
            {{ $message }}
        </div>
    @enderror

    @if ($peringatanSaldoKas)
        <div class="rounded-xl border border-warning-200 bg-warning-50/80 p-4 dark:border-warning-500/20 dark:bg-warning-500/10 shadow-theme-xs">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-warning-600 dark:text-warning-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="text-theme-xs text-warning-800 dark:text-warning-200">
                    <span class="font-bold">Pengingat Saldo Kas:</span> Total rencana pengeluaran kas (<span class="font-semibold text-warning-900 dark:text-white">Rp {{ number_format($totalPengeluaranKas, 0, ',', '.') }}</span>) saat ini melebihi estimasi saldo kas di tangan (<span class="font-semibold text-warning-900 dark:text-white">Rp {{ number_format($saldoKasSaatIni, 0, ',', '.') }}</span>). Transaksi tetap dapat disimpan sesuai pencatatan fisik faktur.
                </div>
            </div>
        </div>
    @endif

    @foreach ($baris as $kunci => $r)
        <section class="{{ $kelasKartu }}" wire:key="baris-{{ $kunci }}">

            <div class="flex items-center justify-between gap-3">
                <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">
                    Pengeluaran {{ $loop->iteration }}
                </h2>

                @if ($recordId === null && count($baris) > 1)
                    <button type="button" wire:click="hapusBaris('{{ $kunci }}')"
                        class="text-theme-xs font-medium text-error-600 hover:underline dark:text-error-500">
                        Hapus baris
                    </button>
                @endif
            </div>

            <div class="mt-3 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label for="tgl-{{ $kunci }}" class="{{ $kelasLabel }}">Tanggal</label>
                    <input id="tgl-{{ $kunci }}" type="date" max="{{ now()->format('Y-m-d') }}"
                        wire:model="baris.{{ $kunci }}.tanggal" class="mt-1 {{ $kelasInput }}">
                    @error("baris.$kunci.tanggal")
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jml-{{ $kunci }}" class="{{ $kelasLabel }}">Jumlah (Rp)</label>
                    <input id="jml-{{ $kunci }}" type="text" inputmode="numeric" placeholder="0"
                        wire:model="baris.{{ $kunci }}.jumlah" class="mt-1 {{ $kelasInput }} angka">
                    @error("baris.$kunci.jumlah")
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="akun-{{ $kunci }}" class="{{ $kelasLabel }}">Kas/Bank</label>
                    <select id="akun-{{ $kunci }}" wire:model="baris.{{ $kunci }}.akun" class="mt-1 {{ $kelasInput }}">
                        @foreach ($opsiAkun as $nilai => $label)
                            <option value="{{ $nilai }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error("baris.$kunci.akun")
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kat-{{ $kunci }}" class="{{ $kelasLabel }}">Kategori</label>
                    <select id="kat-{{ $kunci }}" wire:model="baris.{{ $kunci }}.kategori" class="mt-1 {{ $kelasInput }}">
                        <option value="">— Pilih —</option>
                        @foreach ($opsiKategori as $nilai => $label)
                            <option value="{{ $nilai }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error("baris.$kunci.kategori")
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="det-{{ $kunci }}" class="{{ $kelasLabel }}">Detail Kategori</label>
                    <input id="det-{{ $kunci }}" type="text" maxlength="255"
                        wire:model="baris.{{ $kunci }}.detail_kategori" class="mt-1 {{ $kelasInput }}"
                        placeholder="mis. kabel NYY 2x4">
                    @error("baris.$kunci.detail_kategori")
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="penerima-{{ $kunci }}" class="{{ $kelasLabel }}">Penerima</label>
                    <input id="penerima-{{ $kunci }}" type="text" maxlength="255"
                        wire:model="baris.{{ $kunci }}.penerima" class="mt-1 {{ $kelasInput }}">
                    @error("baris.$kunci.penerima")
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-2">
                    <label for="spk-{{ $kunci }}" class="{{ $kelasLabel }}">SPK (opsional)</label>
                    <div class="mt-1">
                        <x-form.spk-select
                            :options="$daftarSpk"
                            :selected="$r['spk_id'] ?? null"
                            wireModel="baris.{{ $kunci }}.spk_id"
                            placeholder="Pilih atau cari SPK..."
                        />
                    </div>
                    @error("baris.$kunci.spk_id")
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2 lg:col-span-4">
                    <label for="ket-{{ $kunci }}" class="{{ $kelasLabel }}">Keterangan</label>
                    <input id="ket-{{ $kunci }}" type="text" maxlength="255"
                        wire:model="baris.{{ $kunci }}.keterangan" class="mt-1 {{ $kelasInput }}">
                    @error("baris.$kunci.keterangan")
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Berkas bukti baris ini --}}
            <div class="mt-4 border-t border-gray-100 pt-3 dark:border-gray-800">
                <p class="{{ $kelasLabel }}">Bukti / Nota</p>

                @if (($r['bukti'] ?? []) !== [])
                    <ul class="mt-2 space-y-1">
                        @foreach ($r['bukti'] as $path)
                            <li class="flex items-center justify-between gap-3">
                                <a href="{{ Nota::url($path) }}" target="_blank" rel="noopener"
                                    class="truncate text-theme-sm font-medium text-brand-600 hover:underline dark:text-brand-400">
                                    {{ basename($path) }}
                                </a>
                                <button type="button" wire:click="hapusBukti('{{ $kunci }}', @js($path))"
                                    class="shrink-0 text-theme-xs font-medium text-error-600 hover:underline dark:text-error-500">
                                    Hapus
                                </button>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="mt-2 flex flex-wrap items-center gap-2">
                    <input type="file" multiple wire:model="unggahan.{{ $kunci }}"
                        accept="application/pdf,image/jpeg,image/png,image/webp"
                        class="block w-full max-w-md rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-theme-xs text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-1 file:text-theme-xs file:font-medium dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:file:bg-white/10">

                    <button type="button" wire:click="isiOcr('{{ $kunci }}')" wire:loading.attr="disabled"
                        class="inline-flex h-8 items-center rounded-lg border border-gray-300 px-3 text-theme-xs font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-white/5">
                        <span wire:loading.remove wire:target="isiOcr('{{ $kunci }}')">Isi dari OCR</span>
                        <span wire:loading wire:target="isiOcr('{{ $kunci }}')">Membaca…</span>
                    </button>
                </div>

                <div wire:loading wire:target="unggahan.{{ $kunci }}" class="mt-1 text-theme-xs text-gray-500">
                    Mengunggah…
                </div>

                @error("unggahan.$kunci.*")
                    <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                @enderror

                @if (filled($pesanOcr[$kunci] ?? ''))
                    <p class="mt-1 text-theme-xs text-gray-600 dark:text-gray-400">{{ $pesanOcr[$kunci] }}</p>
                @endif
            </div>
        </section>
    @endforeach

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            @if ($recordId === null && count($baris) < $maksBaris)
                <button type="button" wire:click="tambahBaris"
                    class="inline-flex h-9 items-center gap-1.5 rounded-lg border border-gray-300 px-3.5 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-white/5">
                    <span class="text-base leading-none">+</span> Tambah Baris
                </button>
            @endif
            <span class="text-theme-xs text-gray-500 dark:text-gray-400">{{ count($baris) }} baris</span>
        </div>

        <div class="flex items-center gap-2.5">
            <button type="button" wire:click="simpan" wire:loading.attr="disabled" wire:target="simpan"
                class="inline-flex h-9 items-center rounded-lg bg-brand-600 px-4 text-theme-sm font-semibold text-white hover:bg-brand-700 disabled:opacity-60">
                <span wire:loading.remove wire:target="simpan">
                    {{ $recordId === null ? 'Simpan Pengeluaran' : 'Simpan Perubahan' }}
                </span>
                <span wire:loading wire:target="simpan">Menyimpan…</span>
            </button>
        </div>
    </div>
</div>