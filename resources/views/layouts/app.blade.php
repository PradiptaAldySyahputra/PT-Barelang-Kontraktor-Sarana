<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('judul', 'Dashboard') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="h-full bg-slate-100 font-sans antialiased">

<div class="flex min-h-full">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="hidden w-64 shrink-0 flex-col bg-slate-900 lg:flex">
        <div class="flex h-16 items-center gap-2 border-b border-slate-800 px-5">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 font-bold text-white">
                B
            </div>
            <div class="leading-tight">
                <div class="text-sm font-semibold text-white">SIAKAD SPK</div>
                <div class="text-[11px] text-slate-400">PT Barelang Kontraktor Sarana</div>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto p-3 text-sm">
            @php
                $menu = [
                    ['route' => 'dashboard', 'label' => 'Dashboard', 'ikon' => '📊'],
                ];
                if (auth()->user()?->bolehInput()) {
                    $menu[] = ['route' => null, 'label' => 'SPK', 'ikon' => '📄', 'segera' => true];
                    $menu[] = ['route' => null, 'label' => 'Uang Masuk', 'ikon' => '💰', 'segera' => true];
                    $menu[] = ['route' => null, 'label' => 'Uang Keluar', 'ikon' => '💸', 'segera' => true];
                    $menu[] = ['route' => null, 'label' => 'Mitra', 'ikon' => '🤝', 'segera' => true];
                }
                $menu[] = ['route' => null, 'label' => 'Laporan', 'ikon' => '📈', 'segera' => true];
            @endphp

            @foreach ($menu as $item)
                @if ($item['route'] && Route::has($item['route']))
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2 {{ request()->routeIs($item['route']) ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>{{ $item['ikon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @else
                    <div class="flex cursor-not-allowed items-center gap-3 rounded-lg px-3 py-2 text-slate-500"
                         title="Belum tersedia">
                        <span>{{ $item['ikon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                        @if (!empty($item['segera']))
                            <span class="ml-auto rounded bg-slate-800 px-1.5 py-0.5 text-[10px] text-slate-400">soon</span>
                        @endif
                    </div>
                @endif
            @endforeach
        </nav>

        <div class="border-t border-slate-800 p-3">
            <div class="mb-2 px-2">
                <div class="truncate text-sm font-medium text-white">{{ auth()->user()->nama }}</div>
                <div class="text-[11px] text-slate-400">
                    {{ auth()->user()->peran->label() }}
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full rounded-lg bg-slate-800 px-3 py-2 text-sm text-slate-300 hover:bg-slate-700 hover:text-white">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ================= KONTEN ================= --}}
    <div class="flex min-w-0 flex-1 flex-col">

        {{-- Header mobile --}}
        <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 lg:px-8">
            <div>
                <h1 class="text-lg font-semibold text-slate-800">@yield('judul', 'Dashboard')</h1>
                <p class="text-xs text-slate-500">@yield('subjudul', 'Sistem Informasi SPK & Kontrol Keuangan')</p>
            </div>
            <div class="text-right lg:hidden">
                <div class="text-xs font-medium text-slate-700">{{ auth()->user()->nama }}</div>
                <div class="text-[10px] text-slate-500">{{ auth()->user()->peran->label() }}</div>
            </div>
        </header>

        <main class="flex-1 p-4 lg:p-8">
            {{-- Notifikasi --}}
            @if (session('sukses'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('sukses') }}
                </div>
            @endif
            @if (session('galat'))
                <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    {{ session('galat') }}
                </div>
            @endif

            @yield('konten')
        </main>

        <footer class="border-t border-slate-200 bg-white px-4 py-3 text-center text-[11px] text-slate-400 lg:px-8">
            SIAKAD SPK — PT Barelang Kontraktor Sarana · {{ now()->format('Y') }}
        </footer>
    </div>
</div>

@stack('skrip')
</body>
</html>
