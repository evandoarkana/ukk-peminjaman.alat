<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 2px 0;
            font-size: 12px;
        }

        .judul {
            text-align: center;
            margin: 15px 0;
        }

        .judul h3 {
            margin: 0;
            text-transform: uppercase;
        }

        .periode {
            text-align: center;
            margin-bottom: 20px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f2f2f2;
            font-size: 11px;
            padding: 8px;
            border: 1px solid #000;
        }

        td {
            padding: 7px;
            border: 1px solid #000;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        tfoot td {
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            width: 100%;
        }

        .ttd {
            width: 200px;
            text-align: center;
            float: right;
        }

        .ttd-space {
            height: 60px;
        }
    </style>
</head>
<body>

{{-- HEADER INSTANSI --}}
<div class="header">
    <h2>PEMINJAMAN BOY</h2>
    <p>Sistem Inventaris Peminjaman Alat</p>
    <p>Jl. Pendidikan No. 1</p>
</div>

{{-- JUDUL --}}
<div class="judul">
    <h3>LAPORAN PEMINJAMAN ALAT</h3>
</div>

{{-- PERIODE --}}
<div class="periode">
    @if($tgl_mulai && $tgl_selesai)
        Periode: {{ $tgl_mulai }} s/d {{ $tgl_selesai }}
    @else
        Semua Data
    @endif
</div>

{{-- TABLE --}}
<table>
    <thead>
        <tr>
            <th width="10%">Kode</th>
            <th width="20%">Peminjam</th>
            <th width="20%">Alat</th>
            <th width="15%">Tgl Pinjam</th>
            <th width="15%">Tgl Kembali</th>
            <th width="10%">Denda</th>
            <th width="10%">Status</th>
        </tr>
    </thead>

    <tbody>
        @php $total = 0; @endphp

        @foreach($laporans as $l)
        <tr>
            <td class="text-center">{{ $l->kode_peminjaman }}</td>
            <td>{{ $l->user->name ?? '-' }}</td>
            <td>{{ $l->alat->nama_alat ?? '-' }}</td>
            <td class="text-center">
                {{ \Carbon\Carbon::parse($l->tgl_pinjam)->format('d/m/Y') }}
            </td>
            <td class="text-center">
                {{ $l->tgl_kembali_real ? \Carbon\Carbon::parse($l->tgl_kembali_real)->format('d/m/Y') : '-' }}
            </td>
            <td class="text-right">
                Rp {{ number_format($l->denda) }}
            </td>
            <td class="text-center">
                {{ strtoupper($l->status) }}
            </td>
        </tr>

        @php $total += $l->denda; @endphp
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <td colspan="5" class="text-right">Total Denda</td>
            <td class="text-right">Rp {{ number_format($total) }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>

{{-- TANDA TANGAN --}}
<div class="footer">
    <div class="ttd">
        <p>{{ now()->format('d F Y') }}</p>
        <p>Petugas</p>

        <div class="ttd-space"></div>

        <p><b>{{ auth()->user()->name ?? 'Petugas' }}</b></p>
    </div>
</div>

</body>
</html>