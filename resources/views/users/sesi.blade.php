<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <div class="space-y-5">
        <x-common.alert tipe="info" judul="Tentang halaman ini">
            Satu baris = satu perangkat yang sedang masuk. Bila ada perangkat yang tidak dikenal,
            putus sesinya lalu ganti kata sandi akun tersebut.
        </x-common.alert>

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Sesi aktif ({{ count($daftar) }})</h2>
                <a href="{{ route('panel.users.index') }}"
                   class="inline-flex h-9 items-center rounded-lg border border-gray-300 bg-white px-3 text-theme-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    Kembali ke daftar akun
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-theme-xs">
                    <thead class="bg-gray-50 uppercase tracking-wider text-gray-500 dark:bg-white/[0.02] dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Pengguna</th>
                            <th class="px-4 py-3 font-semibold">Perangkat</th>
                            <th class="px-4 py-3 font-semibold">Alamat IP</th>
                            <th class="px-4 py-3 font-semibold">Aktivitas terakhir</th>
                            <th class="px-4 py-3 text-right font-semibold">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($daftar as $sesi)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $sesi['nama'] }}
                                        @if ($sesi['sendiri'])
                                            <span class="ml-2 rounded-full bg-brand-50 px-2 py-0.5 text-theme-xs font-semibold text-brand-700 dark:bg-brand-500/10 dark:text-brand-300">Sesi ini</span>
                                        @endif
                                    </p>
                                    <p class="mt-0.5 text-gray-500 dark:text-gray-400">{{ $sesi['email'] }}</p>
                                </td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $sesi['perangkat'] }}</td>
                                <td class="angka px-4 py-3 text-gray-700 dark:text-gray-300">{{ $sesi['ip'] }}</td>
                                <td class="angka px-4 py-3 text-gray-700 dark:text-gray-300">{{ $sesi['terakhir']->format('d M Y, H:i') }}</td>
                                <td class="px-4 py-3 text-right">
                                    @if ($sesi['sendiri'])
                                        <span class="text-gray-500 dark:text-gray-400 dark:text-gray-500">sedang dipakai</span>
                                    @else
                                        <form method="POST" action="{{ route('panel.users.sesi.putus', $sesi['id']) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex h-9 items-center rounded-lg border border-error-200 bg-error-50 px-3 text-theme-xs font-semibold text-error-700 hover:bg-error-100 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-300">
                                                Putus sesi
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada sesi tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
