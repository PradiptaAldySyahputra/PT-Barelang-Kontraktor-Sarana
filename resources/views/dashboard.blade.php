@extends('layouts.app')

@section('judul', 'Dashboard')
@section('subjudul', 'Ringkasan SPK, arus kas, dan laba-rugi')

@section('konten')

    {{-- ================= KARTU RINGKASAN ================= --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Nilai SPK</div>
            <div class="mt-2 text-2xl font-semibold text-slate-800">
                Rp {{ number_format($totalNilaiSpk, 0, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-slate-500">{{ $jumlahSpk }} SPK terdaftar</div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Uang Masuk</div>
            <div class="mt-2 text-2xl font-semibold text-emerald-600">
                Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-slate-500">
                Dari SPK Rp {{ number_format($masukDariSpk, 0, ',', '.') }}
                · Luar Rp {{ number_format($masukDariLuar, 0, ',', '.') }}
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Uang Keluar</div>
            <div class="mt-2 text-2xl font-semibold text-rose-600">
                Rp {{ number_format($totalUangKeluar, 0, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-slate-500">{{ $pengeluaranPerKategori->count() }} kategori pengeluaran</div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="text-xs font-medium uppercase tracking-wide text-slate-500">Saldo Bersih</div>
            <div class="mt-2 text-2xl font-semibold {{ $saldoBersih >= 0 ? 'text-slate-800' : 'text-rose-600' }}">
                Rp {{ number_format($saldoBersih, 0, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-slate-500">Masuk − Keluar</div>
        </div>
    </div>

    {{-- Piutang --}}
    <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-5">
        <div class="flex flex-wrap items-center justify-between gap-2">
            <div>
                <div class="text-xs font-medium uppercase tracking-wide text-amber-700">Total Piutang SPK</div>
                <div class="mt-1 text-xl font-semibold text-amber-900">
                    Rp {{ number_format($totalPiutang, 0, ',', '.') }}
                </div>
            </div>
            <div class="text-xs text-amber-700">
                Nilai SPK Rp {{ number_format($totalNilaiSpk, 0, ',', '.') }}
                − penerimaan Rp {{ number_format($masukDariSpk, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- ================= GRAFIK ARUS KAS ================= --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 xl:col-span-2">
            <h2 class="text-sm font-semibold text-slate-800">Arus Kas 6 Bulan Terakhir</h2>
            <p class="text-xs text-slate-500">Uang masuk vs uang keluar per bulan</p>

            @php $maks = max(1, $grafikBulanan->max(fn ($b) => max($b['masuk'], $b['keluar']))); @endphp

            <div class="mt-5 space-y-4">
                @foreach ($grafikBulanan as $b)
                    <div>
                        <div class="mb-1 flex items-center justify-between text-xs">
                            <span class="font-medium text-slate-600">{{ $b['label'] }}</span>
                            <span class="text-slate-500">
                                <span class="text-emerald-600">Rp {{ number_format($b['masuk'], 0, ',', '.') }}</span>
                                ·
                                <span class="text-rose-600">Rp {{ number_format($b['keluar'], 0, ',', '.') }}</span>
                            </span>
                        </div>
                        <div class="flex h-2 gap-1 overflow-hidden rounded-full bg-slate-100">
                            <div class="rounded-full bg-emerald-500"
                                 style="width: {{ round($b['masuk'] / $maks * 100, 2) }}%"></div>
                        </div>
                        <div class="mt-1 flex h-2 gap-1 overflow-hidden rounded-full bg-slate-100">
                            <div class="rounded-full bg-rose-500"
                                 style="width: {{ round($b['keluar'] / $maks * 100, 2) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 flex gap-4 text-[11px] text-slate-500">
                <span class="flex items-center gap-1">
                    <span class="inline-block h-2 w-4 rounded-full bg-emerald-500"></span> Masuk
                </span>
                <span class="flex items-center gap-1">
                    <span class="inline-block h-2 w-4 rounded-full bg-rose-500"></span> Keluar
                </span>
            </div>
        </div>

        {{-- ================= STATUS & KATEGORI ================= --}}
        <div class="space-y-6">

            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <h2 class="text-sm font-semibold text-slate-800">SPK per Status</h2>
                <div class="mt-3 space-y-2">
                    @forelse ($spkPerStatus as $status => $jumlah)
                        @php $enum = \App\Enums\StatusSpk::tryFrom((string) $status); @endphp
                        <div class="flex items-center justify-between text-sm">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs {{ $enum?->warna() ?? 'bg-slate-100 text-slate-700' }}">
                                {{ $enum?->label() ?? ($status ?: 'Tanpa status') }}
                            </span>
                            <span class="font-medium text-slate-700">{{ $jumlah }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500">Belum ada SPK.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <h2 class="text-sm font-semibold text-slate-800">Pengeluaran per Kategori</h2>
                <div class="mt-3 space-y-2">
                    @forelse ($pengeluaranPerKategori as $kategori => $total)
                        @php $enum = \App\Enums\KategoriPengeluaran::tryFrom((string) $kategori); @endphp
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">{{ $enum?->label() ?? ($kategori ?: 'Tanpa kategori') }}</span>
                            <span class="font-medium text-slate-700">
                                Rp {{ number_format((float) $total, 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500">Belum ada pengeluaran.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ================= SPK BERJALAN ================= --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white">
        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="text-sm font-semibold text-slate-800">SPK Berjalan — Laba/Rugi</h2>
            <p class="text-xs text-slate-500">Dihitung otomatis dari transaksi terkait</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Nomor SPK</th>
                        <th class="px-5 py-3 text-left">Pekerjaan</th>
                        <th class="px-5 py-3 text-right">Nilai SPK</th>
                        <th class="px-5 py-3 text-right">Penerimaan</th>
                        <th class="px-5 py-3 text-right">Biaya</th>
                        <th class="px-5 py-3 text-right">Laba/Rugi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($spkBerjalan as $spk)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-mono text-xs text-slate-700">{{ $spk->nomor_spk }}</td>
                            <td class="px-5 py-3">
                                <div class="text-slate-800">{{ $spk->nama_pekerjaan }}</div>
                                <div class="text-xs text-slate-500">{{ $spk->lokasi ?? '—' }}</div>
                            </td>
                            <td class="px-5 py-3 text-right text-slate-700">
                                {{ number_format((float) $spk->nilai_spk, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-right text-emerald-600">
                                {{ number_format($spk->hitung_penerimaan, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-right text-rose-600">
                                {{ number_format($spk->hitung_biaya, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-right font-semibold {{ $spk->hitung_laba >= 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                                {{ number_format($spk->hitung_laba, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-sm text-slate-500">
                                Belum ada SPK berjalan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
