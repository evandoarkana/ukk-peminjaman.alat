<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Selesai - Admin</title>
    <style>
        /* CSS Khusus PDF agar tampilan rapi saat dicetak */
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; line-height: 1.5; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1e293b; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; color: #1e293b; font-size: 18px; }
        .header p { margin: 5px 0; font-size: 12px; color: #64748b; }
        
        .info-table { width: 100%; margin-bottom: 20px; font-size: 12px; }
        .info-table td { padding: 3px 0; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th { background-color: #6366f1; color: white; padding: 10px; font-size: 11px; text-transform: uppercase; border: 1px solid #4f46e5; }
        table.data-table td { border: 1px solid #e2e8f0; padding: 8px; font-size: 10px; text-align: center; }
        
        .total-row { background-color: #f8fafc; font-weight: bold; }
        .text-end { text-align: right; }
        .footer { margin-top: 40px; text-align: right; font-size: 12px; }
        .signature-space { margin-top: 60px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Peminjaman Alat (Selesai)</h2>
        <p>Laporan Resmi Admin - Sistem Peminjaman PPLG</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Periode</strong></td>
            <td width="35%">: {{ \Carbon\Carbon::parse($tgl_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($tgl_selesai)->format('d M Y') }}</td>
            <td width="20%" class="text-end"><strong>Tanggal Cetak</strong></td>
            <td width="30%">: {{ date('d F Y, H:i') }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Peminjam</th>
                <th>Nama Alat</th>
                <th>Tgl Kembali</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @php $totalDenda = 0; @endphp
            @forelse($laporans as $index => $l)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="font-weight: bold;">{{ $l->kode_transaksi }}</td>
                <td>{{ $l->user->name }}</td>
                <td>{{ $l->alat->nama_alat ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($l->tgl_kembali_real)->format('d/m/Y') }}</td>
                <td>Rp {{ number_format($l->denda, 0, ',', '.') }}</td>
            </tr>
            @php $totalDenda += $l->denda; @endphp
            @empty
            <tr>
                <td colspan="6" style="padding: 20px;">Data peminjaman tidak ditemukan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        @if(!$laporans->isEmpty())
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-end" style="padding-right: 15px;">TOTAL PENDAPATAN DENDA</td>
                <td>Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        <p>Ciampea, {{ date('d F Y') }}</p>
        <p>Mengetahui, <br> Administrator Sistem</p>
        <div class="signature-space">
            {{ Auth::user()->name }}
        </div>
    </div>

</body>
</html>