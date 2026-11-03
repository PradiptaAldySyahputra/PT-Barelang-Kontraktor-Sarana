{{--
    Form Tambah / Ubah SPK.

    Status pekerjaan & status tagihan TIDAK ada di sini - masing-masing punya
    form sendiri (./status.blade.php & ./billing.blade.php) supaya Admin tidak
    salah ubah data lain saat hanya ingin mengganti status.
--}}
@php
    use App\Enums\DikerjakanOleh;
    use App\Support\Format;
    use App\Support\Nota;

    $modeUbah = $spk !== null;
    $aksi = $modeUbah
        ? route('panel.spk.update', array_filter(['spk' => $spk, 'asal' => $asal ?? null]))
        : route('panel.spk.store');
    $nilaiAwal = old('nilai_spk', $modeUbah ? Format::untukInputUang($spk->nilai_spk) : '');
    $dokumenLama = $modeUbah ? ($spk->dokumen ?? []) : [];

    $kelasInput = 'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800';
    $kelasLabel = 'block text-theme-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-2';
    $kelasKartu = 'rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs md:p-6';
@endphp

<x-layouts.app :judul="$judul" :keterangan="$keterangan" :kembali="$kembali ?? route('panel.spk.index')">
    <form method="POST" action="{{ $aksi }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @if ($modeUbah)
            @method('PUT')
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-error-100 bg-error-50 px-4 py-3 text-theme-sm text-error-700 dark:border-error-600/30 dark:bg-error-600/10 dark:text-error-500">
                Ada isian yang perlu diperbaiki. Periksa tanda merah di bawah.
            </div>
        @endif

        <div class="grid gap-5 xl:grid-cols-2">

            {{-- Data SPK --}}
            <section class="{{ $kelasKartu }}">
                <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Data SPK</h2>
                <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                    Nomor SPK wajib unik. Pekerjaan tanpa surat resmi: isi "TANPA SPK" dan biarkan tanggal kosong.
                </p>

                <div class="mt-4 space-y-4">
                    <div>
                        <label for="nomor_spk" class="{{ $kelasLabel }}">Nomor SPK <span class="text-error-600">*</span></label>
                        <input id="nomor_spk" name="nomor_spk" type="text" required maxlength="150"
                            value="{{ old('nomor_spk', $spk?->nomor_spk) }}" placeholder="mis. 0123/SPK/DAN.01.03/2026"
                            class="mt-1.5 {{ $kelasInput }}">
                        @error('nomor_spk')
                            <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="tanggal_spk" class="{{ $kelasLabel }}">Tanggal SPK</label>
                            <input id="tanggal_spk" name="tanggal_spk" type="date"
                                value="{{ old('tanggal_spk', $spk?->tanggal_spk?->format('Y-m-d')) }}"
                                class="mt-1.5 {{ $kelasInput }}">
                            <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Kosongkan jika TANPA SPK.</p>
                            @error('tanggal_spk')
                                <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tanggal_akhir" class="{{ $kelasLabel }}">Tanggal Akhir SPK</label>
                            <input id="tanggal_akhir" name="tanggal_akhir" type="date"
                                value="{{ old('tanggal_akhir', $spk?->tanggal_akhir?->format('Y-m-d')) }}"
                                class="mt-1.5 {{ $kelasInput }}">
                            <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Batas akhir pekerjaan.</p>
                            @error('tanggal_akhir')
                                <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </section>

            {{-- Pekerjaan --}}
            <section class="{{ $kelasKartu }}">
                <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Pekerjaan</h2>

                <div class="mt-4 space-y-4">
                    <div>
                        <label for="nama_pekerjaan" class="{{ $kelasLabel }}">Nama Pekerjaan <span class="text-error-600">*</span></label>
                        <input id="nama_pekerjaan" name="nama_pekerjaan" type="text" required maxlength="255"
                            value="{{ old('nama_pekerjaan', $spk?->nama_pekerjaan) }}"
                            class="mt-1.5 {{ $kelasInput }}">
                        @error('nama_pekerjaan')
                            <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="lokasi" class="{{ $kelasLabel }}">Lokasi</label>
                            <input id="lokasi" name="lokasi" type="text" maxlength="255"
                                value="{{ old('lokasi', $spk?->lokasi) }}" class="mt-1.5 {{ $kelasInput }}">
                            @error('lokasi')
                                <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="mitra_id" class="{{ $kelasLabel }}">Pemberi Kerja / Mitra</label>
                            <select id="mitra_id" name="mitra_id" class="mt-1.5 {{ $kelasInput }}">
                                <option value="">— Tanpa mitra —</option>
                                @foreach ($daftarMitra as $id => $nama)
                                    <option value="{{ $id }}" @selected((string) old('mitra_id', $spk?->mitra_id) === (string) $id)>
                                        {{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mitra_id')
                                <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </section>

            {{-- Nilai SPK --}}
            <section class="{{ $kelasKartu }}">
                <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Nilai SPK</h2>
                <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                    Nilai kontrak murni. Tanpa retensi: piutang = Nilai SPK − Total Uang Masuk.
                </p>

                <div class="mt-4">
                    <label for="nilai_spk" class="{{ $kelasLabel }}">Nilai SPK (Rp) <span class="text-error-600">*</span></label>
                    <div class="mt-1.5 flex items-center gap-2">
                        <span class="text-theme-sm font-medium text-gray-500 dark:text-gray-400">Rp</span>
                        <input id="nilai_spk" name="nilai_spk" type="text" inputmode="numeric" required
                            value="{{ $nilaiAwal }}" placeholder="0" class="{{ $kelasInput }} angka">
                    </div>
                    @error('nilai_spk')
                        <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            {{-- Klasifikasi --}}
            <section class="{{ $kelasKartu }}">
                <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Klasifikasi</h2>

                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="jenis_sumber" class="{{ $kelasLabel }}">Jenis Sumber</label>
                        <select id="jenis_sumber" name="jenis_sumber" class="mt-1.5 {{ $kelasInput }}">
                            <option value="">—</option>
                            @foreach (['pln' => 'PLN', 'luar' => 'Luar', 'internal' => 'Internal', 'lainnya' => 'Lainnya'] as $nilai => $label)
                                <option value="{{ $nilai }}" @selected(old('jenis_sumber', $spk?->jenis_sumber) === $nilai)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_sumber')
                            <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="sheet_lama" class="{{ $kelasLabel }}">Sheet Lama (referensi Excel)</label>
                        <input id="sheet_lama" name="sheet_lama" type="text" maxlength="100"
                            value="{{ old('sheet_lama', $spk?->sheet_lama) }}" class="mt-1.5 {{ $kelasInput }}">
                        @error('sheet_lama')
                            <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Pengantaran Dokumen --}}
            <section class="{{ $kelasKartu }}">
                <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Pengantaran Dokumen</h2>
                <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                    Catat apakah dokumen SPK sudah diantar ke pihak terkait.
                </p>

                <div class="mt-4 space-y-4">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="status_antar" class="{{ $kelasLabel }}">Status Pengantaran</label>
                            <select id="status_antar" name="status_antar" required class="mt-1.5 {{ $kelasInput }}">
                                @foreach ($opsiStatusAntar as $nilai => $label)
                                    <option value="{{ $nilai }}"
                                        @selected(old('status_antar', $spk?->status_antar?->value ?? 'belum') === $nilai)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_antar')
                                <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tanggal_antar" class="{{ $kelasLabel }}">Tanggal Diantar</label>
                            <input id="tanggal_antar" name="tanggal_antar" type="date"
                                max="{{ now()->format('Y-m-d') }}"
                                value="{{ old('tanggal_antar', $spk?->tanggal_antar?->format('Y-m-d')) }}"
                                class="mt-1.5 {{ $kelasInput }}">
                            @error('tanggal_antar')
                                <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="keterangan" class="{{ $kelasLabel }}">Keterangan</label>
                        <input id="keterangan" name="keterangan" type="text" maxlength="255"
                            value="{{ old('keterangan', $spk?->keterangan) }}"
                            placeholder="mis. diantar ke imperium / sudah masuk rek BKS"
                            class="mt-1.5 {{ $kelasInput }}">
                        @error('keterangan')
                            <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Pelaksana --}}
            <section class="{{ $kelasKartu }}">
                <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Pelaksana Pekerjaan</h2>
                <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                    Kalau pekerjaan hanya SEBAGIAN disubkonkan (mis. 5 gardu: 3 sendiri, 2 subkon), buat SPK terpisah untuk bagian yang disubkonkan.
                </p>

                <div class="mt-4 space-y-4">
                    <fieldset>
                        <legend class="sr-only">Dikerjakan oleh</legend>
                        <div class="flex flex-wrap gap-4">
                            @foreach ($opsiDikerjakan as $nilai => $label)
                                <label class="inline-flex cursor-pointer items-center gap-2">
                                    <input type="radio" name="dikerjakan_oleh" value="{{ $nilai }}" required
                                        @checked(old('dikerjakan_oleh', $spk?->dikerjakan_oleh?->value ?? 'sendiri') === $nilai)
                                        class="h-4 w-4 border-gray-300 text-brand-600 focus:ring-brand-500 dark:border-gray-700">
                                    <span class="text-theme-sm text-gray-700 dark:text-gray-200">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('dikerjakan_oleh')
                            <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <div>
                        <label for="subkon_id" class="{{ $kelasLabel }}">Mitra Subkon</label>
                        <select id="subkon_id" name="subkon_id" class="mt-1.5 {{ $kelasInput }}">
                            <option value="">— Pilih subkon —</option>
                            @foreach ($daftarSubkon as $id => $nama)
                                <option value="{{ $id }}" @selected((string) old('subkon_id', $spk?->subkon_id) === (string) $id)>
                                    {{ $nama }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                            Belum ada subkon? Tambahkan dulu di menu Mitra dengan kategori "Subkon".
                        </p>
                        @error('subkon_id')
                            <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>
        </div>

        {{-- Status (hanya tampil saat mengubah) --}}
        @if ($modeUbah)
            <section class="{{ $kelasKartu }}">
                <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Status (hanya tampil)</h2>
                <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                    Status diubah lewat menu Status SPK & Tagihan SPK — bukan dari sini.
                </p>
                <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-theme-xs text-gray-500 dark:text-gray-400">Status Pekerjaan</dt>
                        <dd class="mt-0.5 text-theme-sm font-semibold text-gray-900 dark:text-white">
                            {{ $spk->status_spk?->label() ?? 'Draft' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-theme-xs text-gray-500 dark:text-gray-400">Status Tagihan</dt>
                        <dd class="mt-0.5 text-theme-sm font-semibold text-gray-900 dark:text-white">
                            {{ $spk->status_tagihan?->label() ?? 'Belum Ditagihkan' }}
                        </dd>
                    </div>
                </dl>
            </section>
        @endif

        {{-- Dokumen --}}
        <section class="{{ $kelasKartu }}">
            <h2 class="text-theme-sm font-semibold text-gray-900 dark:text-white">Dokumen SPK</h2>
            <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                Scan kontrak SPK, kuitansi tagihan, BAST, atau BAAP. PDF/JPG/PNG/WEBP, maksimal 10 berkas.
            </p>

            @if ($dokumenLama !== [])
                <ul class="mt-4 divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($dokumenLama as $path)
                        <li class="flex items-center justify-between gap-3 py-2">
                            <a href="{{ Nota::url($path) }}" target="_blank" rel="noopener"
                                class="truncate text-theme-sm font-medium text-brand-600 hover:underline dark:text-brand-400">
                                {{ basename($path) }}
                            </a>
                            <label class="inline-flex shrink-0 cursor-pointer items-center gap-1.5 text-theme-xs text-gray-600 dark:text-gray-400">
                                <input type="checkbox" name="hapus_dokumen[]" value="{{ $path }}"
                                    class="h-3.5 w-3.5 rounded border-gray-300 text-error-600 focus:ring-error-500 dark:border-gray-700">
                                Hapus
                            </label>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="mt-4">
                <label for="dokumen" class="{{ $kelasLabel }}">Tambah Berkas</label>
                <input id="dokumen" name="dokumen[]" type="file" multiple
                    accept="application/pdf,image/jpeg,image/png,image/webp"
                    class="mt-1.5 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-theme-sm text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-1.5 file:text-theme-xs file:font-medium dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200 dark:file:bg-white/10">
                @error('dokumen.*')
                    <p class="mt-1 text-theme-xs text-error-600 dark:text-error-500">{{ $message }}</p>
                @enderror
            </div>
        </section>

        <div class="flex items-center justify-end">
            <button type="submit"
                class="inline-flex h-9 items-center rounded-lg bg-brand-600 px-4 text-theme-sm font-semibold text-white hover:bg-brand-700">
                {{ $modeUbah ? 'Simpan Perubahan' : 'Simpan SPK' }}
            </button>
        </div>
    </form>
</x-layouts.app>