{{--
    Profil Saya (/panel/profile): data diri, foto, dan kata sandi.
    Tata letak mengikuti referensi TailAdmin Pro asli: satu kartu utama "Profil Saya"
    berisi kartu dalam (Informasi Pribadi + dialog Edit, lalu Keamanan).
    Lebar dibatasi max-w-3xl agar tidak terlalu lebar; ukuran avatar diperkecil.
--}}
@php
    $kelasKartu = 'rounded-2xl border border-gray-200 bg-white p-5 lg:p-6 dark:border-gray-700 dark:bg-white/[0.03] shadow-theme-xs';
    $kelasLabel = 'block text-xs font-medium text-gray-500 dark:text-gray-400';
    $kelasInput = 'mt-2 h-11 w-full rounded-[10px] border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800';
    $kelasNilai = 'text-sm font-medium text-gray-800 dark:text-white/90';
    $kelasTombolEdit = 'inline-flex h-9 shrink-0 items-center gap-2 rounded-lg border border-gray-300 bg-transparent px-3.5 text-sm font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white';
    $kelasTombolPrimer = 'inline-flex h-10 items-center justify-center rounded-xl bg-brand-600 px-5 text-sm font-semibold text-white shadow-theme-xs transition hover:bg-brand-700';
    $kelasTombolSekunder = 'rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700';
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <div class="p-4 mx-auto max-w-3xl md:p-6" x-data="{ editDialog: false }">
        <div class="space-y-6">

            {{-- Informasi Pribadi --}}
            <div class="{{ $kelasKartu }}">
                        <div class="flex items-center justify-between gap-4">
                            <h2 class="text-base font-semibold text-gray-800 sm:text-lg dark:text-white/90">Informasi Pribadi</h2>
                            <button type="button" @click="editDialog = true" class="{{ $kelasTombolEdit }}">
                                <svg class="size-4.5 fill-current" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M17.091 3.532a2.25 2.25 0 00-3.182 0l-8.302 8.302c-.308.308-.52.7-.61 1.126l-.735 3.485a.75.75 0 00.888.889l3.485-.735a2.25 2.25 0 001.127-.611l8.301-8.302a2.25 2.25 0 000-3.182l-.972-.972zm-2.121 1.06a.75.75 0 011.06 0l.973.973a.75.75 0 010 1.06l-.899.899-2.033-2.033.899-.898zm-1.96 1.96l-6.342 6.342a.75.75 0 00-.203.376l-.498 2.358 2.358-.497a.75.75 0 00.376-.204l6.343-6.342-2.033-2.033z" fill="currentColor" />
                                </svg>
                                <span>Edit</span>
                            </button>
                        </div>

                        <div class="mt-2 flex items-center gap-4 sm:gap-6">
                            <div class="relative shrink-0">
                                @if ($pengguna->urlAvatar())
                                    <img src="{{ $pengguna->urlAvatar() }}" alt="Foto profil"
                                        class="aspect-square size-16 rounded-full object-cover sm:size-20">
                                @else
                                    <div class="flex aspect-square size-16 items-center justify-center rounded-full bg-brand-400 text-xl font-medium text-white sm:size-20 dark:bg-brand-400 dark:text-white">
                                        {{ strtoupper(mb_substr((string) ($pengguna->nama ?? 'U'), 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex min-w-0 flex-col gap-1">
                                <h3 class="truncate text-base font-semibold text-gray-800 sm:text-lg dark:text-white/90">{{ $pengguna->nama }}</h3>
                                <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 sm:text-sm dark:text-gray-400">
                                    <span class="capitalize">{{ $pengguna->peran?->value ?? 'Pengguna' }}</span>
                                    <span class="inline-block h-3.5 w-px bg-gray-300 dark:bg-gray-700"></span>
                                    <span class="truncate">{{ $pengguna->email }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 grid grid-cols-1 gap-5 border-t border-gray-200 pt-5 dark:border-gray-700 sm:grid-cols-2 lg:grid-cols-3">
                            <div class="flex flex-col gap-1">
                                <span class="{{ $kelasLabel }}">Nama</span>
                                <p class="{{ $kelasNilai }}">{{ $pengguna->nama }}</p>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="{{ $kelasLabel }}">Email</span>
                                <p class="{{ $kelasNilai }} break-all">{{ $pengguna->email }}</p>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="{{ $kelasLabel }}">Peran</span>
                                <p class="{{ $kelasNilai }} capitalize">{{ $pengguna->peran?->value ?? 'Pengguna' }}</p>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="{{ $kelasLabel }}">Terakhir masuk</span>
                                <p class="{{ $kelasNilai }}">
                                    {{ $pengguna->terakhir_masuk?->format('d/m/Y H:i') ?? 'Belum pernah login' }}
                                </p>
                            </div>
                        </div>
            </div>

            {{-- Keamanan (ganti kata sandi) --}}
            <div class="{{ $kelasKartu }}">
                        <h2 class="text-base font-semibold text-gray-800 sm:text-lg dark:text-white/90">Keamanan</h2>

                        <form method="POST" action="{{ route('panel.profile.password') }}" class="mt-4 space-y-4 sm:max-w-md">
                            @csrf
                            @method('PUT')

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Minimal 8 karakter, kombinasi huruf &amp; angka. Sesi lain akan diputus setelah diganti.
                            </p>

                            <div>
                                <label for="password_lama" class="{{ $kelasLabel }}">Sandi Sekarang</label>
                                <input id="password_lama" name="password_lama" type="password" required autocomplete="current-password"
                                    class="{{ $kelasInput }}">
                                @error('password_lama')
                                    <p class="mt-1 text-xs text-error-600 dark:text-error-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password" class="{{ $kelasLabel }}">Sandi Baru</label>
                                <input id="password" name="password" type="password" required autocomplete="new-password"
                                    class="{{ $kelasInput }}">
                                @error('password')
                                    <p class="mt-1 text-xs text-error-600 dark:text-error-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="{{ $kelasLabel }}">Ulangi Sandi Baru</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required
                                    autocomplete="new-password" class="{{ $kelasInput }}">
                            </div>

                            <div class="flex items-center justify-end pt-2">
                                <button type="submit" class="{{ $kelasTombolPrimer }}">
                                    Ganti Kata Sandi
                                </button>
                            </div>
                        </form>

                        <div class="mt-6 border-t border-gray-200 pt-5 dark:border-gray-700">
                            <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Sesi Aktif</h3>
                            <p class="mt-0.5 max-w-md text-xs text-gray-500 dark:text-gray-400">
                                Putus seluruh perangkat lain yang masih login memakai akun ini, selain perangkat saat ini.
                            </p>
                            <form method="POST" action="{{ route('panel.profile.sesi.putus') }}" class="mt-3">
                                @csrf
                                <button type="submit" class="{{ $kelasTombolSekunder }}">
                                    Putus Semua Sesi Lain
                                </button>
                            </form>
                        </div>

            </div>
        </div>

        {{-- Dialog Edit Personal Information (ganti foto + data diri) --}}
        <div x-show="editDialog" x-transition.opacity
            class="fixed inset-0 isolate z-100 flex items-center justify-center bg-black/50 p-4 backdrop-blur-xs"
            style="display: none;">
            <div class="grid max-h-[90vh] w-full max-w-2xl gap-4 overflow-hidden rounded-2xl border border-gray-200 bg-white text-sm text-gray-700 shadow-theme-lg dark:border-gray-800 dark:bg-[#1E2635] dark:text-gray-300">
            <div class="min-w-0">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col gap-1 sm:gap-2">
                        <h2 class="text-xl font-semibold text-gray-800 sm:text-2xl dark:text-white/90">Edit Personal Information</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Update detail profil Anda.</p>
                    </div>

                    <form method="POST" action="{{ route('panel.profile.update') }}" enctype="multipart/form-data"
                        x-data="{
                            gambarAsli: '{{ $pengguna->urlAvatar() ?? '' }}',
                            pratinjauHasil: null,
                            modalCrop: false,
                            zoom: 1,
                            posX: 0,
                            posY: 0,
                            isDragging: false,
                            startX: 0,
                            startY: 0,
                            imgWidth: 0,
                            imgHeight: 0,

                            pilihBerkas(e) {
                                const file = e.target.files[0];
                                if (!file) return;
                                const reader = new FileReader();
                                reader.onload = (event) => {
                                    const img = new Image();
                                    img.onload = () => {
                                        this.imgWidth = img.width;
                                        this.imgHeight = img.height;
                                        this.zoom = 1;
                                        this.posX = 0;
                                        this.posY = 0;
                                        this.$refs.cropImage.src = event.target.result;
                                        this.modalCrop = true;
                                    };
                                    img.src = event.target.result;
                                };
                                reader.readAsDataURL(file);
                            },

                            startDrag(e) {
                                this.isDragging = true;
                                this.startX = e.clientX - this.posX;
                                this.startY = e.clientY - this.posY;
                            },
                            onDrag(e) {
                                if (!this.isDragging) return;
                                this.posX = e.clientX - this.startX;
                                this.posY = e.clientY - this.startY;
                            },
                            endDrag() {
                                this.isDragging = false;
                            },

                            terapkanCrop() {
                                const canvas = document.createElement('canvas');
                                const size = 300;
                                canvas.width = size;
                                canvas.height = size;
                                const ctx = canvas.getContext('2d');

                                const img = this.$refs.cropImage;
                                const container = this.$refs.cropArea;
                                const cRect = container.getBoundingClientRect();
                                const boxSize = 200;

                                const centerBoxX = cRect.width / 2;
                                const centerBoxY = cRect.height / 2;

                                const renderW = img.offsetWidth * this.zoom;
                                const renderH = img.offsetHeight * this.zoom;
                                const imgLeft = centerBoxX - (renderW / 2) + this.posX;
                                const imgTop = centerBoxY - (renderH / 2) + this.posY;

                                const cropLeft = centerBoxX - (boxSize / 2);
                                const cropTop = centerBoxY - (boxSize / 2);

                                const sx = ((cropLeft - imgLeft) / renderW) * img.naturalWidth;
                                const sy = ((cropTop - imgTop) / renderH) * img.naturalHeight;
                                const sWidth = (boxSize / renderW) * img.naturalWidth;
                                const sHeight = (boxSize / renderH) * img.naturalHeight;

                                ctx.drawImage(img, sx, sy, sWidth, sHeight, 0, 0, size, size);

                                const base64 = canvas.toDataURL('image/jpeg', 0.9);
                                this.pratinjauHasil = base64;
                                document.getElementById('avatar_base64').value = base64;
                                this.modalCrop = false;
                            },

                            batalBaru() {
                                this.pratinjauHasil = null;
                                document.getElementById('avatar').value = '';
                                document.getElementById('avatar_base64').value = '';
                                this.modalCrop = false;
                            }
                        }"
                        class="custom-scrollbar mt-4 space-y-6 overflow-x-hidden overflow-y-auto">
                        @csrf
                        @method('PUT')

                        {{-- Ubah Foto Profil --}}
                        <div class="space-y-4">
                            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Ubah Foto Profil</h3>
                            <div class="flex items-center gap-4 sm:gap-6">
                                <div class="relative shrink-0">
                                    <template x-if="pratinjauHasil">
                                        <img :src="pratinjauHasil" alt="Draf Foto Hasil Edit"
                                            class="aspect-square size-16 rounded-full border-2 border-brand-500 object-cover ring-4 ring-brand-500/20 shadow-theme-sm sm:size-20">
                                    </template>
                                    <template x-if="!pratinjauHasil && gambarAsli">
                                        <img :src="gambarAsli" alt="Foto profil saat ini"
                                            class="aspect-square size-16 rounded-full border-2 border-brand-500 object-cover shadow-theme-xs sm:size-20">
                                    </template>
                                    <template x-if="!pratinjauHasil && !gambarAsli">
                                        <div class="flex aspect-square size-16 items-center justify-center rounded-full bg-brand-400 text-xl font-medium text-white sm:size-20 dark:bg-brand-400 dark:text-white">
                                            {{ strtoupper(mb_substr((string) ($pengguna->nama ?? 'U'), 0, 1)) }}
                                        </div>
                                    </template>

                                    <button type="button" aria-label="Unggah foto profil"
                                        @click="$refs.avatarInput.click()"
                                        class="absolute bottom-0 end-0 flex size-8 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="size-4.5 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.673 3.419c-.236-.316-.607-.502-1.001-.502H8.328c-.394 0-.765.186-1.001.502L6.832 4.081a1.25 1.25 0 01-1.002.502H3.542A1.25 1.25 0 002.292 5.833v8.542A1.25 1.25 0 003.542 15.625h12.916a1.25 1.25 0 001.25-1.25V5.833a1.25 1.25 0 00-1.25-1.25h-2.288a1.25 1.25 0 01-1.002-.502l-.495-.662zM13.333 9.793a3.333 3.333 0 11-6.666 0 3.333 3.333 0 016.666 0z" fill="currentColor" />
                                        </svg>
                                    </button>

                                    <input id="avatar" x-ref="avatarInput" name="avatar" type="file" hidden
                                        accept="image/jpeg,image/png,image/webp" @change="pilihBerkas($event)">
                                </div>
                                <div class="flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                                    <p>Unggah gambar persegi (200×200 px)</p>
                                    <p>format JPEG atau PNG.</p>
                                    @if ($pengguna->urlAvatar())
                                        <label class="mt-1 inline-flex cursor-pointer items-center gap-1.5 text-xs font-semibold text-error-600 dark:text-error-400">
                                            <input type="checkbox" name="hapus_avatar" value="1" class="rounded border-gray-300 text-error-600 focus:ring-error-500 dark:text-error-400">
                                            Hapus foto profil (gunakan inisial)
                                        </label>
                                    @endif
                                    @error('avatar')
                                        <p class="mt-1 text-xs text-error-600 dark:text-error-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Informasi Pribadi --}}
                        <div class="space-y-4">
                            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Informasi Pribadi</h3>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="nama" class="{{ $kelasLabel }}">Nama Lengkap</label>
                                    <input id="nama" name="nama" type="text" required maxlength="200"
                                        value="{{ old('nama', $pengguna->nama) }}" class="{{ $kelasInput }}">
                                    @error('nama')
                                        <p class="mt-1 text-xs text-error-600 dark:text-error-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="{{ $kelasLabel }}">Email</label>
                                    <input id="email" name="email" type="email" required maxlength="200"
                                        value="{{ old('email', $pengguna->email) }}" class="{{ $kelasInput }}">
                                    @error('email')
                                        <p class="mt-1 text-xs text-error-600 dark:text-error-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Modal Dialog Crop / Edit Foto Profil --}}
                        <div x-show="modalCrop" x-transition.opacity
                            class="fixed inset-0 z-101 flex items-center justify-center bg-black/50 p-4 backdrop-blur-xs"
                            style="display: none;">
                            <div class="flex w-full max-w-lg flex-col items-center rounded-2xl border border-gray-100 bg-white p-6 shadow-2xl dark:border-gray-800 dark:bg-gray-900">
                                <div class="mb-4 flex w-full items-center justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Sesuaikan &amp; Pangkas Foto Profil</h3>
                                    <button type="button" @click="batalBaru()" class="text-lg text-gray-500 hover:text-gray-600 dark:text-gray-400">&times;</button>
                                </div>

                                <input type="hidden" name="avatar_base64" id="avatar_base64" value="">

                                <div x-ref="cropArea"
                                    @mousedown="startDrag($event)"
                                    @mousemove="onDrag($event)"
                                    @mouseup="endDrag()"
                                    @mouseleave="endDrag()"
                                    class="relative flex h-[280px] w-full max-w-[340px] cursor-move select-none items-center justify-center overflow-hidden rounded-2xl bg-gray-950">
                                    <img x-ref="cropImage" alt="Pratinjau Crop"
                                        :style="`transform: translate(${posX}px, ${posY}px) scale(${zoom}); max-height: 240px; pointer-events: none;`"
                                        class="transition-transform duration-75">
                                    <div class="pointer-events-none absolute h-[200px] w-[200px] rounded-full border-2 border-white shadow-[0_0_0_9999px_rgba(0,0,0,0.55)]"></div>
                                </div>

                                <div class="mt-4 flex w-full max-w-[340px] items-center gap-3">
                                    <span class="text-xs text-gray-500">Perkecil</span>
                                    <input type="range" min="0.5" max="3" step="0.05" x-model.number="zoom"
                                        class="h-1.5 w-full appearance-none cursor-pointer rounded-lg bg-gray-200 dark:bg-gray-700">
                                    <span class="text-xs text-gray-500">Perbesar</span>
                                </div>
                                <span class="mt-1 text-[11px] text-gray-500 dark:text-gray-400">Geser gambar untuk mengatur posisi wajah</span>

                                <div class="mt-6 flex w-full items-center justify-end gap-2.5 border-t border-gray-100 pt-3 dark:border-gray-800">
                                    <button type="button" @click="batalBaru()" class="{{ $kelasTombolSekunder }}">
                                        Batal
                                    </button>
                                    <button type="button" @click="terapkanCrop()"
                                        class="rounded-xl bg-brand-600 px-5 py-2 text-xs font-semibold text-white shadow-theme-xs transition hover:bg-brand-700">
                                        Terapkan Potongan Foto
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-2.5 border-t border-gray-100 pt-4 dark:border-gray-800">
                            <button type="button" @click="editDialog = false" class="{{ $kelasTombolSekunder }}">
                                Batal
                            </button>
                            <button type="submit" class="{{ $kelasTombolPrimer }}">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</x-layouts.app>
