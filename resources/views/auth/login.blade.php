<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50 dark:bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="/favicon.ico" sizes="48x48">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#0F4C81">

    <title>Masuk · BKS Panel</title>

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

<body class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-10 dark:bg-gray-900 font-sans">

    <div class="w-full max-w-[440px]">
        {{-- Logo & Identitas Brand Resmi BKS (Stacked) --}}
        <div class="mb-8 text-center">
            <img src="/bks-stacked-mono-0f4c81.svg" alt="PT Barelang Kontraktor Sarana" class="mx-auto h-24 w-auto dark:hidden">
            <img src="/bks-stacked-white.svg" alt="PT Barelang Kontraktor Sarana" class="mx-auto h-24 w-auto hidden dark:block">
            <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                Sistem Informasi SPK &amp; Kontrol Keuangan
            </p>
        </div>

        {{-- Card Form Masuk --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-md sm:p-8 dark:border-gray-800 dark:bg-white/[0.03]">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Masuk ke panel</h2>
            <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                Silakan masukkan email dan kata sandi akun Anda.
            </p>

            @if ($errors->any())
                <div class="mt-5 rounded-xl border border-error-500/20 bg-error-500/10 p-3.5 text-theme-sm text-error-700 dark:text-error-400">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('panel.login.attempt') }}" class="mt-6 space-y-4">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-theme-xs font-medium uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Email
                    </label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username"
                        placeholder="contoh@bks.test"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                </div>

                <div>
                    <label for="password" class="mb-2 block text-theme-xs font-medium uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Kata Sandi
                    </label>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        placeholder="••••••••"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-theme-sm text-gray-600 dark:text-gray-400">
                        <input type="checkbox" name="ingat" value="1"
                            class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <button type="submit"
                    class="mt-2 flex w-full items-center justify-center rounded-lg bg-brand-500 px-4 py-3 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600 focus:outline-hidden focus:ring-3 focus:ring-brand-500/20 transition-colors">
                    Masuk
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-theme-xs text-gray-400 dark:text-gray-500">
            Intranet PT Barelang Kontraktor Sarana &middot; Batam
        </p>
    </div>

</body>

</html>
