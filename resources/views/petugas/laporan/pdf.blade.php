<!DOCTYPE html>
<html>

<head>
    <title>Laporan Peminjaman Alat</title>
    <style>
    body {
        font-family: sans-serif;
        font-size: 12px;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        border: 1px solid #333;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .total {
        font-weight: bold;
        text-align: right;
    }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN PEMINJAMAN ALAT</h2>
        <p>Periode: {{ $tgl_mulai ?? 'Semua' }} s/d {{ $tgl_selesai ?? 'Semua' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Nama Alat</th>
                <th>Tgl Kembali</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporans as $l)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $l->user->name }}</td>
                <td>{{ $l->alat->nama_alat }} ({{ $l->jumlah }})</td>
                <td>{{ \Carbon\Carbon::parse($l->tgl_kembali_real)->format('d/m/Y') }}</td>
                <td>Rp {{ number_format($l->denda, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="total">Total Pendapatan Denda:</td>
                <td class="total text-danger">Rp {{ number_format($total_denda, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>