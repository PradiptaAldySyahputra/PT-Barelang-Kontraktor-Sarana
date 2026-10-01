{{--
    ============================================================
    CETAK LAPORAN KE PDF — PRD FR-RPT-007
    ============================================================

    ⚠️ KENAPA PDF, padahal sudah ada Excel & CSV:
    Excel untuk MENGOLAH angka; PDF untuk MENYERAHKAN & MENGARSIPKAN.
    PDF tidak bisa diubah angkanya tanpa jejak — lebih aman sebagai dokumen
    resmi (mis. lampiran ke bagian pajak, atau bukti saat pemeriksaan).

    ⚠️ CATATAN TEKNIS dompdf:
    - dompdf TIDAK mendukung CSS modern (flex/grid). Tata letak memakai
      <table> — itu cara paling andal di dompdf.
    - Font memakai DejaVu Sans (bawaan dompdf) karena mendukung karakter
      Indonesia dengan baik.

    Variabel: $judul, $header, $baris, $periode
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $judul }}</title>
    <style>
        @page { margin: 18mm 14mm; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #111827;
        }

        .kop {
            border-bottom: 2px solid #1f2937;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }

        .kop .nama {
            font-size: 14px;
            font-weight: bold;
            letter-spacing: .3px;
        }

        .kop .alamat {
            font-size: 8px;
            color: #4b5563;
            margin-top: 2px;
        }

        .judul {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin: 10px 0 3px;
        }

        .meta {
            text-align: center;
            font-size: 8px;
            color: #4b5563;
            margin-bottom: 10px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th {
            background-color: #1f2937;
            color: #ffffff;
            font-size: 8px;
            padding: 4px 3px;
            border: 1px solid #374151;
            text-align: left;
        }

        table.data td {
            padding: 3px;
            border: 1px solid #d1d5db;
            font-size: 8px;
        }

        table.data tr:nth-child(even) td {
            background-color: #f9fafb;
        }

        .angka { text-align: right; }

        .kaki {
            margin-top: 12px;
            font-size: 7px;
            color: #6b7280;
            border-top: 1px solid #d1d5db;
            padding-top: 5px;
        }

        .tanda-tangan {
            margin-top: 22px;
            width: 100%;
        }

        .tanda-tangan td {
            text-align: center;
            font-size: 8px;
            padding-top: 30px;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop">
        <div class="nama">PT BARELANG KONTRAKTOR SARANA</div>
        <div class="alamat">Batam, Kepulauan Riau</div>
    </div>

    <div class="judul">{{ $judul }}</div>
    <div class="meta">
        Periode: {{ $periode ?? 'Seluruh data' }}
        &nbsp;·&nbsp;
        Dicetak: {{ now()->format('d/m/Y H:i') }}
    </div>

    {{-- TABEL DATA --}}
    <table class="data">
        <thead>
            <tr>
                @foreach ($header as $kolom)
                    <th>{{ $kolom }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($baris as $r)
                <tr>
                    @foreach ((array) $r as $nilai)
                        @php
                            // Kolom angka dibuat rata kanan supaya mudah dibaca.
                            $angka = is_int($nilai) || is_float($nilai);
                        @endphp
                        <td class="{{ $angka ? 'angka' : '' }}">
                            {{ $angka ? number_format((float) $nilai, 0, ',', '.') : $nilai }}
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($header) }}" style="text-align:center; padding:10px;">
                        Tidak ada data pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <table class="tanda-tangan">
        <tr>
            <td>
                Dibuat oleh,<br><br><br>
                (............................)<br>
                Admin
            </td>
            <td>
                Disetujui oleh,<br><br><br>
                (............................)<br>
                Direktur
            </td>
        </tr>
    </table>

    <div class="kaki">
        Dokumen ini dihasilkan otomatis oleh Sistem Informasi SPK &amp; Kontrol Keuangan
        PT Barelang Kontraktor Sarana. Data bersumber dari transaksi yang tercatat di sistem.
    </div>

</body>
</html>
