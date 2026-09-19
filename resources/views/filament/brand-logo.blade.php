{{--
    Logo panel.

    Dipanggil lewat ->brandLogo(fn () => view('filament.brand-logo')).
    Karena ini VIEW BIASA (bukan Blade component), JANGAN memakai
    `$attributes` — variabel itu hanya ada di dalam component.
    Kesalahan ini sempat membuat dashboard error 500:
    "Undefined variable $attributes".
--}}
<div class="flex items-center gap-2">
    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary-600 text-sm font-bold text-white">
        BKS
    </span>
</div>
