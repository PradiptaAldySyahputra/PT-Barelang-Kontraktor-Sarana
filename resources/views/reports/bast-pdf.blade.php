<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>BAST &middot; {{ $spk->nomor_spk }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            margin: 25px 35px;
            line-height: 1.5;
        }
        .kop-tabel {
            width: 100%;
            border-bottom: 2px solid #0F4C81;
            padding-bottom: 8px;
            margin-bottom: 16px;
        }
        .kop-nama {
            font-size: 14px;
            font-weight: bold;
            color: #0F4C81;
        }
        .kop-sub {
            font-size: 9px;
            color: #4b5563;
        }
        .judul-dokumen {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 15px;
            text-transform: uppercase;
        }
        .nomor-dokumen {
            text-align: center;
            font-size: 10px;
            color: #4b5563;
            margin-bottom: 18px;
        }
        .paragraf {
            text-align: justify;
            margin-bottom: 12px;
        }
        .tabel-rincian {
            width: 100%;
            margin: 12px 0 16px 0;
            border-collapse: collapse;
        }
        .tabel-rincian td {
            padding: 4px 6px;
            vertical-align: top;
        }
        .tabel-rincian td.lbl {
            width: 25%;
            font-weight: bold;
            color: #374151;
        }
        .tabel-rincian td.val {
            width: 73%;
        }
        .tabel-ttd {
            width: 100%;
            margin-top: 35px;
        }
        .tabel-ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .garis-nama {
            margin-top: 65px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    {{-- KOP PERUSAHAAN BKS --}}
    <table class="kop-tabel">
        <tr>
            <td style="width: 55px; vertical-align: middle;">
                <img src="{{ public_path('bks-symbol-mono-0f4c81-1024.png') }}" style="width: 46px; height: auto;" alt="Logo BKS">
            </td>
            <td style="vertical-align: middle; padding-left: 8px;">
                <div class="kop-nama">PT BARELANG KONTRAKTOR SARANA</div>
                <div class="kop-sub">Subkontraktor PT PLN Batam · Jasa Konstruksi & Ketenagalistrikan</div>
                <div class="kop-sub">Pulau Batam, Kepulauan Riau — Indonesia</div>
            </td>
        </tr>
    </table>

    <div class="judul-dokumen">BERITA ACARA SERAH TERIMA PEKERJAAN (BAST)</div>
    <div class="nomor-dokumen">Nomor: BAST/{{ date('Y') }}/{{ str_pad((string)$spk->id, 4, '0', STR_PAD_LEFT) }}</div>

    <div class="paragraf">
        Pada hari ini, <strong>{{ now()->translatedFormat('l, d F Y') }}</strong>, bertempat di Batam, yang bertanda tangan di bawah ini:
    </div>

    <table class="tabel-rincian">
        <tr>
            <td class="lbl">1. Pihak Pertama (Penyedia)</td>
            <td>:</td>
            <td class="val">
                <strong>PT BARELANG KONTRAKTOR SARANA</strong><br>
                Diwakili oleh Direktur Utama, bertindak untuk dan atas nama penyedia jasa konstruksi.
            </td>
        </tr>
        <tr>
            <td class="lbl">2. Pihak Kedua (Pemberi Kerja)</td>
            <td>:</td>
            <td class="val">
                <strong>{{ $spk->mitra?->nama ?? 'PT PLN Batam' }}</strong><br>
                {{ $spk->mitra?->alamat ?? 'Pulau Batam, Kepulauan Riau' }}
            </td>
        </tr>
    </table>

    <div class="paragraf">
        Menyatakan bahwa Pihak Pertama telah menyelesaikan seluruh lingkup fisik pekerjaan dengan rincian kontrak sebagai berikut:
    </div>

    <table class="tabel-rincian" style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px;">
        <tr>
            <td class="lbl">Nomor SPK / Kontrak</td>
            <td>:</td>
            <td class="val"><strong>{{ $spk->nomor_spk }}</strong></td>
        </tr>
        <tr>
            <td class="lbl">Nama Pekerjaan</td>
            <td>:</td>
            <td class="val">{{ $spk->nama_pekerjaan }}</td>
        </tr>
        <tr>
            <td class="lbl">Nilai Kontrak Fisik</td>
            <td>:</td>
            <td class="val"><strong>{{ \App\Support\Format::rupiah($spk->nilai_spk) }}</strong></td>
        </tr>
        <tr>
            <td class="lbl">Masa Pelaksanaan</td>
            <td>:</td>
            <td class="val">
                {{ $spk->tanggal_spk?->format('d/m/Y') }} s/d {{ $spk->tanggal_akhir?->format('d/m/Y') }}
            </td>
        </tr>
        <tr>
            <td class="lbl">Status Pekerjaan</td>
            <td>:</td>
            <td class="val"><strong>{{ $spk->status_spk instanceof \App\Enums\StatusSpk ? $spk->status_spk->label() : ucfirst((string)$spk->status_spk) }}</strong> (100% Selesai)</td>
        </tr>
    </table>

    <div class="paragraf">
        Kedua belah pihak telah sepakat bahwa pekerjaan telah dilaksanakan dengan baik sesuai spesifikasi teknis dan gambar kerja yang disepakati. Berita Acara ini dibuat dalam rangkap yang cukup untuk dipergunakan dalam proses administrasi penagihan dan keuangan.
    </div>

    {{-- TANDA TANGAN DUA BELAH PIHAK --}}
    <table class="tabel-ttd">
        <tr>
            <td>
                <div>Pihak Kedua (Pemberi Kerja)</div>
                <div style="font-weight: bold; margin-top: 2px;">{{ $spk->mitra?->nama ?? 'PT PLN Batam' }}</div>
                <div class="garis-nama">{{ $spk->mitra?->pic ?: '( .................................................... )' }}</div>
                <div style="font-size: 9px; color: #6b7280;">Penanggung Jawab Lapangan</div>
            </td>
            <td>
                <div>Pihak Pertama (Penyedia)</div>
                <div style="font-weight: bold; margin-top: 2px;">PT BARELANG KONTRAKTOR SARANA</div>
                @if ($tandaTangan['gambar'] ?? null)
                    <div style="margin-top: 10px;">
                        <img src="{{ $tandaTangan['gambar'] }}" style="height: 50px; object-fit: contain;" alt="TTD">
                    </div>
                    <div style="font-weight: bold; text-decoration: underline;">{{ $direkturUser?->nama ?? $tandaTangan['nama'] }}</div>
                @else
                    <div class="garis-nama">{{ $direkturUser?->nama ?? 'Direktur Utama' }}</div>
                @endif
                <div style="font-size: 9px; color: #6b7280;">Direktur Utama</div>
            </td>
        </tr>
    </table>
</body>
</html>
