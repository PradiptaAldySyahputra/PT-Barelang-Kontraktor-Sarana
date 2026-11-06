{{-- Keterangan di bawah tabel buku kas/bank saat baris dipotong. --}}
@if ($batasBaris !== null && $buku['baris']->count() > $batasBaris)
    <div class="border-t border-gray-100 px-5 py-3 text-theme-xs text-gray-500 dark:border-gray-800 dark:text-gray-400">
        Menampilkan {{ number_format($batasBaris, 0, ',', '.') }} dari
        {{ number_format($buku['baris']->count(), 0, ',', '.') }} transaksi.
        <a href="{{ request()->fullUrlWithQuery(['semua' => 1]) }}"
            class="font-semibold text-brand-600 hover:underline dark:text-brand-400">Tampilkan semua</a>
        &middot; daftar lengkap juga tersedia di unduhan Excel/PDF.
    </div>
@endif
