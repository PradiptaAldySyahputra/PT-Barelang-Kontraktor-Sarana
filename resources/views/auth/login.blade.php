<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50 dark:bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/favicon.ico" sizes="48x48">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#0F4C81">

    <title>Masuk · BKS Panel</title>

    {{-- Font Resmi TailAdmin: Outfit (sinkron dengan layout app) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/panel.css'])

    <script>
        (function() {
            const saved = localStorage.getItem('bks-tema') || localStorage.getItem('theme');
            if (saved === 'gelap' || saved === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>

<body class="font-sans">

    <div class="relative z-1 bg-white p-6 sm:p-0 dark:bg-gray-900">
        <div class="relative flex h-screen w-full flex-col justify-center sm:p-0 lg:flex-row dark:bg-gray-900">

            {{-- Kolom kiri: form masuk --}}
            <div class="no-scrollbar flex w-full flex-1 flex-col overflow-y-auto lg:w-1/2">
                <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center py-6">

                    {{-- Logo & identitas brand BKS (mobile / kolom kiri) --}}
                    <div class="mb-8 text-center lg:hidden">
                        <img src="/bks-stacked-mono-0f4c81.svg" alt="PT Barelang Kontraktor Sarana" class="mx-auto h-20 w-auto dark:hidden">
                        <img src="/bks-stacked-white.svg" alt="PT Barelang Kontraktor Sarana" class="mx-auto h-20 w-auto hidden dark:block">
                    </div>

                    <div class="mb-6 sm:mb-8">
                        <h1 class="mb-2 text-title-sm font-semibold text-gray-800 dark:text-white/90">Masuk ke panel</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Silakan masukkan email dan kata sandi akun Anda.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 rounded-[10px] border border-error-500/20 bg-error-500/10 p-3.5 text-sm text-error-700 dark:text-error-400">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('panel.login.attempt') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Email
                            </label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                                autocomplete="username"
                                placeholder="contoh@bks.test"
                                @error('email') aria-invalid="true" @enderror
                                class="h-11 w-full rounded-[10px] border border-gray-300 bg-white px-4 py-2.5 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40">
                            @error('email')
                                <p class="mt-1.5 text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Kata Sandi
                            </label>
                            <div class="relative">
                                <input id="password" name="password" type="password" required autocomplete="current-password"
                                    placeholder="••••••••"
                                    @error('password') aria-invalid="true" @enderror
                                    class="h-11 w-full rounded-[10px] border border-gray-300 bg-white px-4 py-2.5 pr-11 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40">
                                <button type="button" aria-label="Lihat atau sembunyikan kata sandi" tabindex="-1"
                                    onclick="var i=document.getElementById('password'); var o=document.getElementById('pw-eye'); var c=document.getElementById('pw-eye-off'); i.type=i.type==='text'?'password':'text'; var show=i.type==='text'; o.classList.toggle('hidden',show); c.classList.toggle('hidden',!show);"
                                    class="absolute end-3 top-1/2 -translate-y-1/2 text-gray-400 transition-colors hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                                    <svg id="pw-eye" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" class="block">
                                        <path d="M2.04 12.33C3.39 7.84 7.4 4.5 12 4.5c4.6 0 8.61 3.34 9.96 7.83a1 1 0 010 .34C20.61 17.16 16.6 20.5 12 20.5c-4.6 0-8.61-3.34-9.96-7.83a1 1 0 010-.34z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/>
                                    </svg>
                                    <svg id="pw-eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" class="hidden">
                                        <path d="M9.88 9.88a3 3 0 104.24 4.24M10.73 5.08A10.43 10.43 0 0112 5c4.6 0 8.61 3.34 9.96 7.83a1 1 0 010 .34 10.8 10.8 0 01-1.96 3.1M6.61 6.61A10.5 10.5 0 002.04 12.17a1 1 0 000 .34C3.39 17.16 7.4 20.5 12 20.5a10.4 10.4 0 003.68-.67M3 3l18 18"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <input type="checkbox" name="ingat" value="1"
                                    class="h-4 w-4 rounded border-gray-300 text-brand-500 shadow-theme-xs focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900">
                                Ingat saya di perangkat ini
                            </label>
                        </div>

                        <div>
                            <button type="submit"
                                class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-[10px] bg-brand-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs transition-colors hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white">
                                Masuk
                            </button>
                        </div>
                    </form>

                    <p class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                        Intranet PT Barelang Kontraktor Sarana &middot; Batam
                    </p>
                </div>
            </div>

            {{-- Kolom kanan: panel brand TailAdmin (desktop) --}}
            <div class="relative hidden h-full w-full items-center justify-center bg-brand-950 lg:grid lg:w-1/2 dark:bg-brand-950">
                <div class="flex max-w-sm flex-col items-center px-6 text-center">
                    <img src="/bks-stacked-white.svg" alt="PT Barelang Kontraktor Sarana" class="mb-6 w-64">
                    <p class="text-sm leading-relaxed text-gray-400 dark:text-white/60">
                        Sistem Informasi SPK &amp; Kontrol Keuangan
                    </p>
                    <p class="mt-2 text-sm text-gray-400 dark:text-white/60">
                        PT Barelang Kontraktor Sarana &middot; Batam
                    </p>
                </div>
            </div>

            {{-- Tombol toggle tema mengambang (TailAdmin) --}}
            <button type="button" aria-label="Ganti tema"
                onclick="var h=document.documentElement; h.classList.toggle('dark'); var dark=h.classList.contains('dark'); localStorage.setItem('bks-tema', dark?'gelap':'terang'); localStorage.setItem('theme', dark?'dark':'light');"
                class="fixed end-6 bottom-6 z-50 hidden size-14 items-center justify-center rounded-full bg-brand-500 text-white shadow-theme-xs transition-colors hover:bg-brand-600 sm:inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" class="block dark:hidden">
                    <path d="M6.247 6.668a6.668 6.668 0 0011.207 4.885A7.708 7.708 0 118.03 2.129a6.645 6.645 0 00-1.783 4.54z"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" class="hidden dark:block">
                    <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M12 2v2m0 16v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M2 12h2m16 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
    </div>

</body>

</html>
