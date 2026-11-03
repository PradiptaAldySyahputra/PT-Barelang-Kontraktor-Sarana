<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Kuitansi Pembayaran - {{ $nomorKuitansi }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm 15mm;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 11px;
            line-height: 1.5;
        }
        .header {
            border-bottom: 2px solid #111827;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-nama {
            font-size: 16px;
            font-weight: bold;
            color: #111827;
            letter-spacing: 0.5px;
        }
        .kop-sub {
            font-size: 10px;
            color: #4b5563;
            margin-top: 2px;
        }
        .judul-kuitansi {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 20px 0 5px 0;
            text-decoration: underline;
        }
        .nomor-kuitansi {
            text-align: center;
            font-size: 11px;
            color: #4b5563;
            margin-bottom: 25px;
        }
        .tabel-isi {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .tabel-isi td {
            padding: 8px 6px;
            vertical-align: top;
        }
        .label {
            width: 160px;
            color: #374151;
            font-weight: 500;
        }
        .titik-dua {
            width: 15px;
            text-align: center;
        }
        .nilai {
            color: #111827;
        }
        .kotak-terbilang {
            background-color: #f3f4f6;
            border: 1px dashed #9ca3af;
            padding: 8px 12px;
            font-style: italic;
            font-weight: bold;
            border-radius: 4px;
        }
        .kotak-nominal {
            background-color: #e5e7eb;
            border-left: 4px solid #2563eb;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
        }
        .tanda-tangan {
            width: 100%;
            margin-top: 40px;
        }
        .tanda-tangan td {
            text-align: center;
            vertical-align: top;
            width: 50%;
        }
        .garis-ttd {
            margin-top: 65px;
            font-weight: bold;
            text-decoration: underline;
        }
        .footer-note {
            margin-top: 45px;
            font-size: 9px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 6px;
        }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td style="width: 55px; vertical-align: top;">
                    <img src="{{ public_path('bks-symbol-mono-0f4c81-1024.png') }}" style="width: 48px; height: auto;" alt="Logo BKS">
                </td>
                <td style="vertical-align: top; padding-left: 8px;">
                    <div class="kop-nama">PT BARELANG KONTRAKTOR SARANA</div>
                    <div class="kop-sub">Subkontraktor PT PLN Batam · Jasa Konstruksi & Ketenagalistrikan</div>
                    <div class="kop-sub">Pulau Batam, Kepulauan Riau — Indonesia</div>
                </td>
                <td style="text-align: right; vertical-align: top;">
                    <div style="font-size: 10px; color: #6b7280;">BUKTI PENERIMAAN KAS/BANK</div>
                    <div style="font-size: 12px; font-weight: bold; color: #0F4C81;">KUITANSI RESMI</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="judul-kuitansi">KUITANSI PEMBAYARAN</div>
    <div class="nomor-kuitansi">Nomor: {{ $nomorKuitansi }}</div>

    <table class="tabel-isi">
        <tr>
            <td class="label">Telah Diterima Dari</td>
            <td class="titik-dua">:</td>
            <td class="nilai" style="font-weight: bold;">{{ $mitraNama }}</td>
        </tr>
        <tr>
            <td class="label">Uang Sejumlah</td>
            <td class="titik-dua">:</td>
            <td class="nilai">
                <div class="kotak-terbilang">
                    # {{ ucwords($terbilang) }} #
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Untuk Pembayaran</td>
            <td class="titik-dua">:</td>
            <td class="nilai">
                @if ($spk)
                    <strong>Pembayaran SPK: {{ $spk->nomor_spk }}</strong><br>
                    <span>Pekerjaan: {{ $spk->nama_pekerjaan }}</span>
                    @if (filled($spk->lokasi))
                        <br><span style="font-size: 10px; color: #4b5563;">Lokasi: {{ $spk->lokasi }}</span>
                    @endif
                @else
                    <span>{{ $uangMasuk->keterangan ?: 'Penerimaan Uang Masuk' }}</span>
                @endif
                @if (filled($uangMasuk->keterangan) && $spk)
                    <br><span style="font-size: 10px; color: #4b5563;">Keterangan Tambahan: {{ $uangMasuk->keterangan }}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Metode / Akun Kas</td>
            <td class="titik-dua">:</td>
            <td class="nilai">
                <strong>{{ $uangMasuk->akun?->label() ?? 'Kas / Bank' }}</strong>
                @if (filled($uangMasuk->kategori))
                    &middot; Kategori: {{ $uangMasuk->kategori }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Tanggal Diterima</td>
            <td class="titik-dua">:</td>
            <td class="nilai">
                {{ $uangMasuk->tanggal?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y') }}
            </td>
        </tr>
    </table>

    <div style="margin-left: 6px;">
        <span style="font-size: 10px; color: #4b5563;">Jumlah Pembayaran:</span><br>
        <div class="kotak-nominal">
            {{ \App\Support\Format::rupiah($uangMasuk->jumlah) }}
        </div>
    </div>

    <table class="tanda-tangan">
        <tr>
            <td>
                <div>Mengetahui,</div>
                <div style="font-size: 10px; color: #4b5563;">Direktur Utama</div>
                @if ($tandaTangan['gambar'] ?? null)
                    <img src="{{ $tandaTangan['gambar'] }}" alt="Tanda tangan" style="height: 55px; margin: 4px 0;">
                    <div style="font-weight: bold; text-decoration: underline;">{{ $tandaTangan['nama'] }}</div>
                @else
                    <div class="garis-ttd">{{ $tandaTangan['nama'] ?? '( ........................................ )' }}</div>
                @endif
                <div style="font-size: 9px; color: #6b7280;">PT Barelang Kontraktor Sarana</div>
            </td>
            <td>
                <div>Batam, {{ $uangMasuk->tanggal?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y') }}</div>
                <div style="font-size: 10px; color: #4b5563;">Diterima Oleh (Kasir / Admin Keuangan)</div>
                <div class="garis-ttd">( ........................................ )</div>
                <div style="font-size: 9px; color: #6b7280;">Bagian Keuangan & Administrasi</div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        * Dokumen ini dicetak otomatis oleh Sistem Kontrol Keuangan PT Barelang Kontraktor Sarana pada {{ now()->translatedFormat('d F Y H:i') }} WIB dan sah sebagai tanda terima pembayaran.
    </div>
</body>
</html>
