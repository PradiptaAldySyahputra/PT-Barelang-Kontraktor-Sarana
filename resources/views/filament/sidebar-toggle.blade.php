{{--
    Tombol buka/tutup sidebar — DIPISAH dari nama perusahaan.

    ⚠️ PERMINTAAN USER:
    "untuk menutup sidebar icon atau buttonnya jangan sama letaknya dengan
     nama perusahaan nanti di situ bisa ditambah logo atau apa"

    Jadi:
      - Baris ATAS sidebar  : [tombol toggle]  [LOGO]  [nama perusahaan]
      - Tombol toggle ada di kiri sendiri, tidak menempel pada nama.

    Dipasang lewat render hook `panels::sidebar.logo.before` sehingga
    muncul di dalam header sidebar, sebelum logo & nama brand.
--}}
<div class="flex items-center gap-2">
    {{-- Tombol tutup/buka sidebar (desktop) --}}
    <button
        type="button"
        class="fi-icon-btn fi-size-sm hidden shrink-0 lg:flex"
        title="Tutup / buka sidebar"
        aria-label="Tutup atau buka sidebar"
        x-on:click="$store.sidebar.isOpenDesktop = ! $store.sidebar.isOpenDesktop"
    >
        {{-- Ikon panel: dua garis vertikal --}}
        <svg class="fi-icon fi-size-md" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v16.5m16.5-16.5v16.5" />
        </svg>
    </button>

    {{-- Tombol tutup sidebar (mobile) --}}
    <button
        type="button"
        class="fi-icon-btn fi-size-sm flex shrink-0 lg:hidden"
        title="Tutup sidebar"
        aria-label="Tutup sidebar"
        x-on:click="$store.sidebar.close()"
    >
        <svg class="fi-icon fi-size-md" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>

    {{-- LOGO perusahaan (SVG monokrom, selaras tema) --}}
    <span class="fi-logo-mark flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-zinc-900 text-[11px] font-bold tracking-tight text-white dark:bg-zinc-100 dark:text-zinc-900">
        BKS
    </span>
</div>
