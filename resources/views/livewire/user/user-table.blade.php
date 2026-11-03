@php
    use App\Enums\Peran;
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
        'admin' => 'Admin',
        'direktur' => 'Direktur',
        'nonaktif' => 'Nonaktif',
    ];
@endphp

<div>
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">

        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 px-5 py-4 dark:border-gray-800">
            <div class="flex flex-wrap items-center gap-2" role="tablist" aria-label="Status akun">
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

            <a href="{{ route('panel.users.create') }}"
                class="inline-flex items-center justify-center font-medium gap-2 rounded-xl transition px-4 py-2.5 text-xs bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Pengguna
            </a>
        </div>

        <div class="flex flex-wrap items-center gap-3 px-5 py-3.5 bg-gray-50/50 dark:bg-white/[0.01] border-b border-gray-100 dark:border-gray-800">
            <div class="relative min-w-0 flex-1 sm:max-w-xs">
                <label for="cari-pengguna" class="sr-only">Cari di tabel ini</label>
                <svg class="pointer-events-none absolute top-1/2 left-3.5 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                </svg>
                <input id="cari-pengguna" type="search" wire:model.live.debounce.300ms="cari"
                    placeholder="Cari nama atau email..."
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
                <p class="text-theme-sm font-medium text-gray-900 dark:text-white">Tidak ada pengguna yang cocok</p>
                <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Ubah filter peran, status, atau kata kunci pencarian.</p>
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
                                    Nama Pengguna
                                    @if ($urut === 'nama')
                                        <span class="text-brand-600" aria-hidden="true">{{ $arah === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-700" aria-hidden="true">⇅</span>
                                    @endif
                                </button>
                            </th>
                            <th class="px-3 py-3">
                                <button type="button" wire:click="urutkan('email')" class="inline-flex items-center gap-1 hover:text-gray-900 dark:hover:text-white">
                                    Email
                                    @if ($urut === 'email')
                                        <span class="text-brand-600" aria-hidden="true">{{ $arah === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-700" aria-hidden="true">⇅</span>
                                    @endif
                                </button>
                            </th>
                            <th class="px-3 py-3">Peran Akun</th>
                            <th class="px-3 py-3 text-center">Status</th>
                            <th class="px-3 py-3 text-center">SPK Dibuat</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-theme-sm dark:divide-gray-800">
                        @foreach ($daftar as $pengguna)
                            @php
                                $peran = $pengguna->peran ?? Peran::Admin;
                                $diriSendiri = $pengguna->id === $idDiriSendiri;
                            @endphp
                            <tr wire:key="pengguna-{{ $pengguna->id }}" class="align-top hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $pengguna->nama }}
                                        @if ($diriSendiri)
                                            <span class="ml-1 text-theme-xs font-normal text-brand-600 dark:text-brand-400">(Anda)</span>
                                        @endif
                                    </p>
                                </td>
                                <td class="px-3 py-3">
                                    <span class="text-gray-700 dark:text-gray-300">
                                        {{ $pengguna->email }}
                                    </span>
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="inline-flex rounded-md px-2 py-0.5 text-xs font-semibold {{ $badge($peran->warnaBadge()) }}">
                                        {{ $peran->label() }}
                                    </span>
                                </td>
                                <td class="px-3 py-3 text-center whitespace-nowrap">
                                    <span class="inline-flex rounded-md px-2 py-0.5 text-xs font-semibold {{ $pengguna->is_aktif ? $badge('success') : $badge('gray') }}">
                                        {{ $pengguna->is_aktif ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-3 py-3 text-center whitespace-nowrap">
                                    <span class="angka inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-bold text-gray-700 dark:bg-white/10 dark:text-gray-300">
                                        {{ Format::angka($pengguna->spk_dibuat_count ?? 0) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right whitespace-nowrap">
                                    @if ($diriSendiri)
                                        <span class="text-theme-xs text-gray-400 dark:text-gray-500" title="Akun yang sedang dipakai tidak bisa diubah atau dihapus dari sini.">
                                            —
                                        </span>
                                    @else
                                        <div class="inline-flex items-center justify-end gap-1.5">
                                            <a href="{{ route('panel.users.edit', $pengguna) }}"
                                                class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-2.5 py-1 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition"
                                                title="Ubah Akun Pengguna">
                                                <svg class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                                Ubah
                                            </a>
                                            @if ($pengguna->id !== $idDiriSendiri)
                                                <form method="POST" action="{{ route('panel.users.destroy', $pengguna) }}"
                                                    onsubmit="return konfirmasiAksi(this, 'Hapus akun {{ addslashes($pengguna->nama) }}? Akses pengguna ini ke sistem akan dihentikan.');"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center rounded-lg px-2 py-1 text-xs font-medium text-error-600 hover:bg-error-50 dark:text-error-400 dark:hover:bg-error-500/10 transition"
                                                        title="Hapus Akun Pengguna">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards: 100% Nyaman di Layar Kecil (md:hidden) --}}
            <ul class="divide-y divide-gray-100 md:hidden dark:divide-gray-800">
                @foreach ($daftar as $pengguna)
                    @php
                        $peran = $pengguna->peran ?? Peran::Admin;
                        $diriSendiri = $pengguna->id === $idDiriSendiri;
                    @endphp
                    <li class="px-4 py-3.5 space-y-2">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <h4 class="font-bold text-theme-sm text-gray-900 dark:text-white">
                                    {{ $pengguna->nama }}
                                    @if ($diriSendiri)
                                        <span class="text-xs text-brand-600">(Anda)</span>
                                    @endif
                                </h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $pengguna->email }}</p>
                            </div>
                            <span class="inline-flex rounded px-2 py-0.5 text-[11px] font-semibold {{ $badge($peran->warnaBadge()) }}">
                                {{ $peran->label() }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-300 pt-1">
                            <span>Status: <strong class="{{ $pengguna->is_aktif ? 'text-success-600' : 'text-gray-400' }}">{{ $pengguna->is_aktif ? 'Aktif' : 'Nonaktif' }}</strong></span>
                            <span>{{ Format::angka($pengguna->spk_dibuat_count ?? 0) }} SPK</span>
                        </div>

                        @if (!$diriSendiri)
                            <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100 dark:border-gray-800">
                                <a href="{{ route('panel.users.edit', $pengguna) }}"
                                    class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-2.5 py-1 text-xs font-semibold text-gray-700">
                                    Ubah
                                </a>
                                <form method="POST" action="{{ route('panel.users.destroy', $pengguna) }}"
                                    onsubmit="return konfirmasiAksi(this, 'Hapus akun {{ addslashes($pengguna->nama) }}? Akses pengguna ini ke sistem akan dihentikan.');" class="inline">
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
