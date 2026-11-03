{{--
    Profil Saya (/panel/profile): data diri, foto, tanda tangan, kata sandi.
--}}
@php
    use App\Support\Nota;

    $kelasKartu = 'rounded-2xl border border-gray-200 bg-white p-6 md:p-8 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs';
    $kelasLabel = 'block text-theme-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300';
    $kelasInput = 'mt-2 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800';
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    <div class="mx-auto max-w-3xl space-y-4">

        {{-- Data diri --}}
        <form method="POST" action="{{ route('panel.profile.update') }}" enctype="multipart/form-data" class="{{ $kelasKartu }}">
            @csrf
            @method('PUT')

            <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Data Diri</h2>

            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="nama" class="{{ $kelasLabel }}">Nama Lengkap</label>
                    <input id="nama" name="nama" type="text" required maxlength="200"
                        value="{{ old('nama', $pengguna->nama) }}" class="{{ $kelasInput }}">
                    @error('nama')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="{{ $kelasLabel }}">Email</label>
                    <input id="email" name="email" type="email" required maxlength="200"
                        value="{{ old('email', $pengguna->email) }}" class="{{ $kelasInput }}">
                    @error('email')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="avatar" class="{{ $kelasLabel }}">Foto Profil</label>
                    <div class="mt-2 flex flex-col sm:flex-row sm:items-start gap-4"
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
                                const boxSize = 200; // area crop lingkaran

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
                        }">
                        
                        {{-- Input tersembunyi untuk hasil crop Base64 --}}
                        <input type="hidden" name="avatar_base64" id="avatar_base64" value="">

                        <div class="relative shrink-0">
                            <template x-if="pratinjauHasil">
                                <img :src="pratinjauHasil" alt="Draf Foto Hasil Edit"
                                    class="h-20 w-20 rounded-full object-cover border-2 border-brand-500 ring-4 ring-brand-500/20 shadow-theme-sm">
                            </template>
                            <template x-if="!pratinjauHasil && gambarAsli">
                                <img :src="gambarAsli" alt="Foto profil saat ini"
                                    class="h-20 w-20 rounded-full object-cover border-2 border-brand-500 shadow-theme-xs">
                            </template>
                            <template x-if="!pratinjauHasil && !gambarAsli">
                                <div class="h-20 w-20 rounded-full bg-brand-50 dark:bg-brand-500/15 border border-brand-200 dark:border-brand-500/20 flex items-center justify-center font-bold text-brand-600 dark:text-brand-400 text-2xl shadow-theme-xs">
                                    {{ strtoupper(mb_substr((string) ($pengguna->nama ?? 'U'), 0, 1)) }}
                                </div>
                            </template>
                        </div>

                        <div class="flex-1 space-y-2">
                            <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/webp"
                                @change="pilihBerkas($event)"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-theme-xs text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-1 file:text-theme-xs file:font-medium dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:file:bg-white/10">

                            <div class="flex flex-wrap items-center gap-3">
                                <template x-if="pratinjauHasil">
                                    <button type="button" @click="batalBaru()"
                                        class="text-xs font-semibold text-error-600 hover:underline">
                                        &times; Batalkan Foto Baru
                                    </button>
                                </template>

                                @if ($pengguna->urlAvatar())
                                    <label class="inline-flex items-center gap-1.5 text-xs text-error-600 dark:text-error-400 cursor-pointer">
                                        <input type="checkbox" name="hapus_avatar" value="1" class="rounded border-gray-300 text-error-600 focus:ring-error-500">
                                        <span>Hapus foto profil saat ini (gunakan inisial)</span>
                                    </label>
                                @endif
                            </div>
                            <p class="text-[11px] text-gray-400">
                                Pilih foto untuk membuka editor pangkas (crop) &amp; posisi sebelum disimpan.
                            </p>
                        </div>

                        {{-- Modal Dialog Crop / Edit Foto Profil --}}
                        <div x-show="modalCrop" x-transition.opacity
                            class="fixed inset-0 z-99999 flex items-center justify-center bg-gray-900/70 backdrop-blur-xs p-4"
                            style="display: none;">
                            <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800 flex flex-col items-center">
                                <div class="w-full flex items-center justify-between border-b border-gray-100 pb-3 mb-4 dark:border-gray-800">
                                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Sesuaikan &amp; Pangkas Foto Profil</h3>
                                    <button type="button" @click="batalBaru()" class="text-gray-400 hover:text-gray-600 text-lg">&times;</button>
                                </div>

                                {{-- Area Canvas Interaktif --}}
                                <div x-ref="cropArea"
                                    @mousedown="startDrag($event)"
                                    @mousemove="onDrag($event)"
                                    @mouseup="endDrag()"
                                    @mouseleave="endDrag()"
                                    class="relative h-[280px] w-full max-w-[340px] overflow-hidden rounded-2xl bg-gray-950 flex items-center justify-center cursor-move select-none">
                                    
                                    <img x-ref="cropImage" src="" alt="Pratinjau Crop"
                                        :style="`transform: translate(${posX}px, ${posY}px) scale(${zoom}); max-height: 240px; pointer-events: none;`"
                                        class="transition-transform duration-75">

                                    {{-- Garis Lingkaran Crop --}}
                                    <div class="pointer-events-none absolute h-[200px] w-[200px] rounded-full border-2 border-white shadow-[0_0_0_9999px_rgba(0,0,0,0.55)]"></div>
                                </div>

                                {{-- Kontrol Zoom Slider --}}
                                <div class="w-full max-w-[340px] mt-4 flex items-center gap-3">
                                    <span class="text-xs text-gray-500">Perkecil</span>
                                    <input type="range" min="0.5" max="3" step="0.05" x-model.number="zoom"
                                        class="h-1.5 w-full bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                                    <span class="text-xs text-gray-500">Perbesar</span>
                                </div>
                                <span class="text-[11px] text-gray-400 mt-1">Geser gambar untuk mengatur posisi wajah</span>

                                {{-- Tombol Aksi Modal --}}
                                <div class="mt-6 flex items-center justify-end gap-2.5 w-full border-t border-gray-100 pt-3 dark:border-gray-800">
                                    <button type="button" @click="batalBaru()"
                                        class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        Batal
                                    </button>
                                    <button type="button" @click="terapkanCrop()"
                                        class="rounded-xl bg-brand-600 px-5 py-2 text-xs font-semibold text-white shadow-theme-xs hover:bg-brand-700 transition">
                                        Terapkan Potongan Foto
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @error('avatar')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanda_tangan" class="{{ $kelasLabel }}">Tanda Tangan (untuk PDF)</label>
                    @if ($pengguna->urlTandaTangan())
                        <div class="mt-2 flex items-center gap-3">
                            <img src="{{ $pengguna->urlTandaTangan() }}" alt="Tanda tangan saat ini"
                                class="h-16 object-contain border border-gray-200 dark:border-gray-700 rounded-lg p-1 bg-white">
                            <label class="inline-flex items-center gap-1.5 text-xs text-error-600 dark:text-error-400 cursor-pointer">
                                <input type="checkbox" name="hapus_tanda_tangan" value="1" class="rounded border-gray-300 text-error-600 focus:ring-error-500">
                                <span>Hapus</span>
                            </label>
                        </div>
                    @endif
                    <input id="tanda_tangan" name="tanda_tangan" type="file" accept="image/jpeg,image/png,image/webp"
                        class="mt-1.5 block w-full rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-theme-xs text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-1 file:text-theme-xs file:font-medium dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:file:bg-white/10">
                    @error('tanda_tangan')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-5 flex items-center justify-end border-t border-gray-100 pt-4 dark:border-gray-800">
                <button type="submit"
                    class="inline-flex h-9 items-center rounded-lg bg-brand-600 px-4 text-theme-sm font-semibold text-white hover:bg-brand-700">
                    Simpan Profil
                </button>
            </div>
        </form>

        {{-- Ganti kata sandi --}}
        <form method="POST" action="{{ route('panel.profile.password') }}" class="{{ $kelasKartu }}">
            @csrf
            @method('PUT')

            <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Ganti Kata Sandi</h2>
            <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                Minimal 8 karakter, kombinasi huruf &amp; angka. Sesi lain akan diputus setelah diganti.
            </p>

            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                <div>
                    <label for="password_lama" class="{{ $kelasLabel }}">Sandi Sekarang</label>
                    <input id="password_lama" name="password_lama" type="password" required autocomplete="current-password"
                        class="{{ $kelasInput }}">
                    @error('password_lama')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="{{ $kelasLabel }}">Sandi Baru</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                        class="{{ $kelasInput }}">
                    @error('password')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="{{ $kelasLabel }}">Ulangi Sandi Baru</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        autocomplete="new-password" class="{{ $kelasInput }}">
                </div>
            </div>

            <div class="mt-5 flex items-center justify-end border-t border-gray-100 pt-4 dark:border-gray-800">
                <button type="submit"
                    class="inline-flex h-9 items-center rounded-lg bg-brand-600 px-4 text-theme-sm font-semibold text-white hover:bg-brand-700">
                    Ganti Kata Sandi
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>