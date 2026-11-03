{{--
    Form Tambah / Ubah Pengguna (/panel/users/create & /panel/users/{pengguna}/edit).
--}}
@php
    $modeUbah = $pengguna !== null;
    $aksi = $modeUbah ? route('panel.users.update', $pengguna) : route('panel.users.store');
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan" :kembali="$kembali ?? route('panel.users.index')">
    <div class="mx-auto max-w-2xl">
        <form method="POST" action="{{ $aksi }}"
            class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">
            @csrf
            @if ($modeUbah)
                @method('PUT')
            @endif

            @if ($diriSendiri)
                <div class="mb-5 rounded-lg border border-warning-100 bg-warning-50 px-4 py-3 text-theme-sm text-warning-700 dark:border-warning-600/30 dark:bg-warning-600/10 dark:text-warning-500">
                    Ini akun Anda sendiri. Peran dan status aktif tidak bisa diubah dari halaman ini supaya Anda tidak terkunci dari sistem.
                </div>
            @endif

            <div class="space-y-5">
                <div>
                    <label for="nama" class="block text-theme-sm font-medium text-gray-700 dark:text-gray-200">
                        Nama Lengkap <span class="text-error-600">*</span>
                    </label>
                    <input id="nama" name="nama" type="text" required maxlength="200"
                        value="{{ old('nama', $pengguna?->nama) }}"
                        class="mt-1.5 h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-theme-sm text-gray-900 focus:border-brand-400 focus:ring-2 focus:ring-brand-500/20 focus:outline-none dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                    @error('nama')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-theme-sm font-medium text-gray-700 dark:text-gray-200">
                        Email <span class="text-error-600">*</span>
                    </label>
                    <input id="email" name="email" type="email" required maxlength="200"
                        value="{{ old('email', $pengguna?->email) }}"
                        class="mt-1.5 h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-theme-sm text-gray-900 focus:border-brand-400 focus:ring-2 focus:ring-brand-500/20 focus:outline-none dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                    <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Dipakai untuk login.</p>
                    @error('email')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="peran" class="block text-theme-sm font-medium text-gray-700 dark:text-gray-200">
                            Peran <span class="text-error-600">*</span>
                        </label>
                        <select id="peran" name="peran" required @disabled($diriSendiri)
                            class="mt-1.5 h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-theme-sm text-gray-900 focus:border-brand-400 focus:outline-none disabled:cursor-not-allowed disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-950 dark:text-white dark:disabled:bg-white/5">
                            @foreach ($opsiPeran as $nilai => $label)
                                <option value="{{ $nilai }}"
                                    @selected(old('peran', $pengguna?->peran?->value ?? 'admin') === $nilai)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @if ($diriSendiri)
                            <input type="hidden" name="peran" value="{{ $pengguna->peran->value }}">
                        @endif
                        <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                            Admin = input &amp; kelola data operasional. Direktur = Super Admin (akses penuh seluruh fitur + manajemen akun).
                        </p>
                        @error('peran')
                            <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col justify-center pt-2">
                        <input type="hidden" name="is_aktif" value="0">
                        <label class="inline-flex cursor-pointer items-center gap-2.5">
                            <input type="checkbox" name="is_aktif" value="1"
                                @checked((bool) old('is_aktif', $pengguna?->is_aktif ?? true)) @disabled($diriSendiri)
                                class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 disabled:cursor-not-allowed dark:border-gray-700">
                            <span class="text-theme-sm font-medium text-gray-700 dark:text-gray-200">Akun Aktif</span>
                        </label>
                        @if ($diriSendiri)
                            <input type="hidden" name="is_aktif" value="1">
                        @endif
                        <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                            Akun nonaktif tidak bisa login.
                        </p>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-5 dark:border-gray-800">
                    <label for="password" class="block text-theme-sm font-medium text-gray-700 dark:text-gray-200">
                        Password @if (! $modeUbah) <span class="text-error-600">*</span> @endif
                    </label>
                    <input id="password" name="password" type="password" @required(! $modeUbah)
                        autocomplete="new-password"
                        class="mt-1.5 h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-theme-sm text-gray-900 focus:border-brand-400 focus:ring-2 focus:ring-brand-500/20 focus:outline-none dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                    <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                        @if ($modeUbah)
                            Kosongkan kalau password tidak diganti.
                        @else
                            Minimal 8 karakter, kombinasi huruf &amp; angka.
                        @endif
                    </p>
                    @error('password')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end border-t border-gray-100 pt-4 dark:border-gray-800">
                <button type="submit"
                    class="inline-flex h-9 items-center rounded-lg bg-brand-600 px-4 text-theme-sm font-semibold text-white hover:bg-brand-700">
                    {{ $modeUbah ? 'Simpan Perubahan' : 'Simpan Akun' }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
