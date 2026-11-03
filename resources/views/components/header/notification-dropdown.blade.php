@php
    use App\Models\Spk;
    use App\Enums\StatusTagihan;
    use App\Enums\StatusSpk;
    use Carbon\Carbon;

    // Ambil notifikasi operasional riil (SPK lewat tenggat, mendekati tenggat, dan selesai belum ditagihkan)
    $notifList = [];
    $totalNotif = 0;

    try {
        // 1. SPK Lewat Batas Waktu
        $lewatCount = Spk::query()
            ->lewatTenggat()
            ->count();

        $spkLewat = Spk::query()
            ->with('mitra:id,nama')
            ->lewatTenggat()
            ->orderBy('tanggal_akhir', 'asc')
            ->limit(10)
            ->get();

        foreach ($spkLewat as $s) {
            $hari = abs((int) now()->startOfDay()->diffInDays($s->tanggal_akhir->startOfDay(), false));
            $notifList[] = [
                'id' => 'spk-lewat-' . $s->id,
                'tipe' => 'error',
                'kategori' => 'Lewat Tenggat',
                'judul' => 'Lewat Batas Waktu (' . $hari . ' hari)',
                'nomor' => $s->nomor_spk,
                'pekerjaan' => $s->nama_pekerjaan,
                'mitra' => $s->mitra?->nama ?? 'PT PLN Batam',
                'url' => route('panel.spk.show', $s),
                'tenggat' => 'Tenggat: ' . ($s->tanggal_akhir?->format('d/m/Y') ?? '-'),
            ];
        }

        // 2. SPK Mendekati Tenggat (14 hari ke depan)
        $dekatCount = Spk::query()
            ->mendekatiTenggat()
            ->count();

        $spkMendekati = Spk::query()
            ->with('mitra:id,nama')
            ->mendekatiTenggat()
            ->orderBy('tanggal_akhir', 'asc')
            ->limit(8)
            ->get();

        foreach ($spkMendekati as $s) {
            $sisaHari = (int) now()->startOfDay()->diffInDays($s->tanggal_akhir->startOfDay(), false);
            $notifList[] = [
                'id' => 'spk-dekat-' . $s->id,
                'tipe' => 'warning',
                'kategori' => 'Mendekati',
                'judul' => 'Mendekati Tenggat (' . $sisaHari . ' hari lagi)',
                'nomor' => $s->nomor_spk,
                'pekerjaan' => $s->nama_pekerjaan,
                'mitra' => $s->mitra?->nama ?? 'PT PLN Batam',
                'url' => route('panel.spk.show', $s),
                'tenggat' => 'Tenggat: ' . ($s->tanggal_akhir?->format('d/m/Y') ?? '-'),
            ];
        }

        // 3. SPK Selesai Belum Ditagihkan
        $tagihCount = Spk::query()
            ->where('status_spk', StatusSpk::Selesai->value)
            ->where(fn ($q) => $q->where('status_tagihan', StatusTagihan::BelumDitagihkan->value)->orWhereNull('status_tagihan'))
            ->count();

        $spkPerluTagih = Spk::query()
            ->with('mitra:id,nama')
            ->where('status_spk', StatusSpk::Selesai->value)
            ->where(fn ($q) => $q->where('status_tagihan', StatusTagihan::BelumDitagihkan->value)->orWhereNull('status_tagihan'))
            ->limit(8)
            ->get();

        foreach ($spkPerluTagih as $s) {
            $notifList[] = [
                'id' => 'spk-tagih-' . $s->id,
                'tipe' => 'info',
                'kategori' => 'Perlu Ditagih',
                'judul' => 'SPK Selesai Belum Ditagihkan',
                'nomor' => $s->nomor_spk,
                'pekerjaan' => $s->nama_pekerjaan,
                'mitra' => $s->mitra?->nama ?? 'PT PLN Batam',
                'url' => route('panel.spk.billing', $s),
                'tenggat' => 'Selesai: ' . ($s->updated_at?->diffForHumans() ?? 'baru saja'),
            ];
        }

        $totalNotif = $lewatCount + $dekatCount + $tagihCount;
    } catch (\Throwable $e) {
        // Fallback aman
    }
@endphp

<div class="relative" x-data="{
    dropdownOpen: false,
    activeTab: 'semua',
    readNotifs: JSON.parse(localStorage.getItem('bks_read_notifs') || '[]'),
    allNotifs: @js($notifList),
    totalAwal: {{ $totalNotif }},
    isRead(id) {
        return this.readNotifs.includes(id);
    },
    tandaiDibaca(id) {
        if (!this.readNotifs.includes(id)) {
            this.readNotifs.push(id);
            this.simpan();
        }
    },
    tandaiKategoriDibaca(tipe) {
        const targetIds = this.allNotifs
            .filter(n => tipe === 'semua' || n.tipe === tipe)
            .map(n => n.id);
        this.readNotifs = Array.from(new Set([...this.readNotifs, ...targetIds]));
        this.simpan();
    },
    tandaiSemuaDibaca() {
        const allIds = this.allNotifs.map(n => n.id);
        this.readNotifs = Array.from(new Set([...this.readNotifs, ...allIds]));
        this.simpan();
    },
    pulihkanNotifikasi() {
        this.readNotifs = [];
        this.simpan();
    },
    simpan() {
        localStorage.setItem('bks_read_notifs', JSON.stringify(this.readNotifs));
    },
    bukaNotif(id, url) {
        this.tandaiDibaca(id);
        window.location.href = url;
    },
    get count() {
        const dismissed = this.allNotifs.filter(n => this.readNotifs.includes(n.id)).length;
        return Math.max(0, this.totalAwal - dismissed);
    },
    countByTipe(tipe) {
        return this.allNotifs.filter(n => n.tipe === tipe && !this.readNotifs.includes(n.id)).length;
    },
    toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
    },
    closeDropdown() {
        this.dropdownOpen = false;
    }
}" @click.outside="closeDropdown()">
    <!-- Notification Button -->
    <button
        class="relative flex items-center justify-center text-gray-500 transition-colors bg-white border border-gray-200 rounded-full hover:text-dark-900 h-11 w-11 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
        @click="toggleDropdown()"
        type="button"
        aria-label="Notifikasi Operasional"
        :title="'Notifikasi Operasional (' + count + ' penting)'"
    >
        <template x-if="count > 0">
            <span x-text="count > 99 ? '99+' : count"
                class="absolute -top-1 -right-1 z-10 flex h-5 min-w-5 items-center justify-center rounded-full bg-error-500 px-1 text-[10px] font-bold text-white shadow-sm ring-2 ring-white dark:ring-gray-900">
            </span>
        </template>

        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.75 2.29248C10.75 1.87827 10.4143 1.54248 10 1.54248C9.58583 1.54248 9.25004 1.87827 9.25004 2.29248V2.83613C6.08266 3.20733 3.62504 5.9004 3.62504 9.16748V14.4591H3.33337C2.91916 14.4591 2.58337 14.7949 2.58337 15.2091C2.58337 15.6234 2.91916 15.9591 3.33337 15.9591H4.37504H15.625H16.6667C17.0809 15.9591 17.4167 15.6234 17.4167 15.2091C17.4167 14.7949 17.0809 14.4591 16.6667 14.4591H16.375V9.16748C16.375 5.9004 13.9174 3.20733 10.75 2.83613V2.29248ZM14.875 14.4591V9.16748C14.875 6.47509 12.6924 4.29248 10 4.29248C7.30765 4.29248 5.12504 6.47509 5.12504 9.16748V14.4591H14.875ZM8.00004 17.7085C8.00004 18.1228 8.33583 18.4585 8.75004 18.4585H11.25C11.6643 18.4585 12 18.1228 12 17.7085C12 17.2943 11.6643 16.9585 11.25 16.9585H8.75004C8.33583 16.9585 8.00004 17.2943 8.00004 17.7085Z"/>
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div
        x-show="dropdownOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-3 flex h-auto max-h-[580px] w-[380px] sm:w-[460px] flex-col rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-lg dark:border-gray-800 dark:bg-gray-900 z-50"
        style="display: none;"
    >
        {{-- Header Pop-up --}}
        <div class="flex items-center justify-between border-b border-gray-100 pb-3 px-1 dark:border-gray-800">
            <div>
                <h4 class="text-sm font-bold text-gray-800 dark:text-white/90">Notifikasi Operasional</h4>
                <p class="text-[11px] text-gray-500 dark:text-gray-400">Pemberitahuan tenggat & penagihan SPK</p>
            </div>
            <div class="flex items-center gap-2">
                <template x-if="readNotifs.length > 0">
                    <button type="button" @click="pulihkanNotifikasi()"
                        class="text-[11px] font-semibold text-emerald-600 hover:underline dark:text-emerald-400"
                        title="Tampilkan kembali notifikasi yang sudah ditandai dibaca">
                        ↺ Pulihkan Semua
                    </button>
                </template>
                <template x-if="count > 0">
                    <button type="button" @click="tandaiSemuaDibaca()"
                        class="text-[11px] font-semibold text-brand-600 hover:underline dark:text-brand-400">
                        Tandai Semua Dibaca
                    </button>
                </template>
                <span class="rounded-full bg-error-50 px-2.5 py-0.5 text-xs font-bold text-error-600 dark:bg-error-500/15 dark:text-error-400"
                    x-text="count + ' Perhatian'">
                </span>
            </div>
        </div>

        {{-- Filter Tab Per Masalah --}}
        <div class="flex items-center gap-1.5 pt-3 pb-2 border-b border-gray-100 dark:border-gray-800 overflow-x-auto text-[11px]">
            <button type="button" @click="activeTab = 'semua'"
                :class="activeTab === 'semua' ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300'"
                class="rounded-lg px-2.5 py-1 font-semibold transition shrink-0">
                Semua (<span x-text="count"></span>)
            </button>
            <button type="button" @click="activeTab = 'error'"
                :class="activeTab === 'error' ? 'bg-error-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300'"
                class="rounded-lg px-2.5 py-1 font-semibold transition shrink-0 flex items-center gap-1">
                <span>🔴 Lewat</span>
                <span class="rounded-full bg-white/20 px-1 text-[10px]" x-text="countByTipe('error')"></span>
            </button>
            <button type="button" @click="activeTab = 'warning'"
                :class="activeTab === 'warning' ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300'"
                class="rounded-lg px-2.5 py-1 font-semibold transition shrink-0 flex items-center gap-1">
                <span>🟡 Mendekati</span>
                <span class="rounded-full bg-white/20 px-1 text-[10px]" x-text="countByTipe('warning')"></span>
            </button>
            <button type="button" @click="activeTab = 'info'"
                :class="activeTab === 'info' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300'"
                class="rounded-lg px-2.5 py-1 font-semibold transition shrink-0 flex items-center gap-1">
                <span>🔵 Perlu Tagih</span>
                <span class="rounded-full bg-white/20 px-1 text-[10px]" x-text="countByTipe('info')"></span>
            </button>
        </div>

        {{-- Aksi Cepat per Kategori Masalah --}}
        <div x-show="activeTab !== 'semua' && countByTipe(activeTab) > 0" class="flex items-center justify-between py-1.5 px-1 text-[11px] text-gray-500">
            <span>Menampilkan masalah kategori ini</span>
            <button type="button" @click="tandaiKategoriDibaca(activeTab)"
                class="font-semibold text-brand-600 hover:underline dark:text-brand-400">
                ✓ Tandai Kategori Ini Dibaca
            </button>
        </div>

        {{-- Daftar Notifikasi --}}
        <ul class="flex flex-col gap-2.5 overflow-y-auto custom-scrollbar py-2.5 my-1 max-h-[380px]">
            @forelse ($notifList as $notif)
                <li x-show="(activeTab === 'semua' || activeTab === '{{ $notif['tipe'] }}') && !isRead('{{ $notif['id'] }}')">
                    <div class="group relative flex flex-col gap-1.5 rounded-xl p-3 border border-gray-100 bg-white dark:border-gray-800 dark:bg-gray-800/40 hover:border-brand-300 dark:hover:border-gray-700 shadow-xs transition-colors">
                        <div class="flex items-center justify-between gap-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ ($notif['tipe'] ?? '') === 'error' ? 'bg-error-50 text-error-700 dark:bg-error-500/20 dark:text-error-400' : (($notif['tipe'] ?? '') === 'warning' ? 'bg-warning-50 text-warning-700 dark:bg-warning-500/20 dark:text-warning-400' : 'bg-blue-50 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400') }}">
                                {{ $notif['judul'] }}
                            </span>
                            <span class="text-[11px] font-semibold text-gray-500 dark:text-gray-400">{{ $notif['tenggat'] }}</span>
                        </div>

                        <div>
                            <p class="text-xs font-bold text-brand-600 dark:text-brand-400">{{ $notif['nomor'] }}</p>
                            <p class="line-clamp-2 text-xs text-gray-800 dark:text-gray-200 mt-0.5 font-medium">{{ $notif['pekerjaan'] }}</p>
                            <span class="text-[11px] text-gray-400">{{ $notif['mitra'] }}</span>
                        </div>

                        {{-- Tombol Aksi per Notif (Baca & Masalah) --}}
                        <div class="mt-1 pt-2 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between gap-2">
                            <button type="button" @click="tandaiDibaca('{{ $notif['id'] }}')"
                                class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1 text-[11px] font-medium text-gray-600 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition"
                                title="Tandai notifikasi ini sudah dibaca">
                                <svg class="h-3 w-3 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Tandai Dibaca</span>
                            </button>

                            <button type="button" @click="bukaNotif('{{ $notif['id'] }}', '{{ $notif['url'] }}')"
                                class="inline-flex items-center gap-1 rounded-lg border border-brand-200 bg-brand-50 px-2.5 py-1 text-[11px] font-semibold text-brand-700 hover:bg-brand-100 dark:border-brand-500/30 dark:bg-brand-500/10 dark:text-brand-400 transition"
                                title="Buka dan proses dokumen ini">
                                <span>Periksa Masalah &rarr;</span>
                            </button>
                        </div>
                    </div>
                </li>
            @empty
                <li class="py-8 text-center text-xs text-gray-500 dark:text-gray-400">
                    Semua operasional terkendali. Tidak ada SPK lewat tenggat.
                </li>
            @endforelse

            {{-- Pesan Bila Semua Sudah Dibaca --}}
            <li x-show="count === 0" class="py-6 px-4 text-center rounded-xl bg-gray-50 dark:bg-gray-800/40 border border-dashed border-gray-200 dark:border-gray-700">
                <div class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 mb-2">
                    ✓
                </div>
                <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">Semua notifikasi operasional telah dibaca.</p>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Operasional berjalan lancar tanpa kendala tenggat.</p>
                <button type="button" @click="pulihkanNotifikasi()"
                    class="mt-3 inline-flex items-center gap-1 rounded-lg border border-gray-300 bg-white px-3 py-1 text-xs font-semibold text-gray-700 shadow-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                    ↺ Tampilkan Kembali Notifikasi
                </button>
            </li>
        </ul>

        {{-- Footer Pop-up --}}
        <div class="border-t border-gray-100 pt-3 text-center dark:border-gray-800 flex items-center justify-between text-xs">
            <a href="{{ route('panel.spk.calendar') }}" class="font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                📅 Kalender Tenggat
            </a>
            <a href="{{ route('panel.spk.monitoring', 'status') }}" class="font-bold text-brand-600 hover:text-brand-700 dark:text-brand-400">
                Monitoring SPK &rarr;
            </a>
        </div>
    </div>
</div>
