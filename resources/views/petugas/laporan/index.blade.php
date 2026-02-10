@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: sans-serif;">
    <div class="mb-4">
        <h4 style="font-weight: 600; color: #333; margin: 0;">📋 Laporan Pengembalian Alat</h4>
        <p style="color: #858796; font-size: 13px; margin: 0;">Rekapitulasi data transaksi yang telah selesai.</p>
    </div>

    <div
        style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e3e6f0; margin-bottom: 20px;">
        <form action="{{ route('petugas.laporan.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label style="font-size: 12px; font-weight: 700; color: #4e73df;">TANGGAL MULAI</label>
                <input type="date" name="tgl_mulai" class="form-control" value="{{ $tgl_mulai }}">
            </div>
            <div class="col-md-3">
                <label style="font-size: 12px; font-weight: 700; color: #4e73df;">TANGGAL SELESAI</label>
                <input type="date" name="tgl_selesai" class="form-control" value="{{ $tgl_selesai }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100" style="background: #4e73df; font-weight: 600;">
                    <i class="fas fa-filter"></i> Filter Data
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('petugas.laporan.index') }}" class="btn btn-secondary w-100"
                    style="font-weight: 600;">Reset</a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('petugas.laporan.cetak', ['tgl_mulai' => $tgl_mulai, 'tgl_selesai' => $tgl_selesai]) }}"
                    target="_blank" class="btn btn-danger w-100" style="font-weight: 600;">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </a>
            </div>
        </form>
    </div>

    <div
        style="background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e3e6f0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #f8f9fc; border-bottom: 2px solid #e3e6f0;">
                <tr>
                    <th style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px;">NO</th>
                    <th style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px;">PEMINJAM</th>
                    <th style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px;">ALAT</th>
                    <th style="padding: 15px; text-align: center; color: #4e73df; font-size: 12px;">TGL KEMBALI</th>
                    <th style="padding: 15px; text-align: right; color: #4e73df; font-size: 12px;">DENDA</th>
                </tr>
            </thead>
            <tbody>
                @php $total_denda = 0; @endphp
                @forelse($laporans as $l)
                <tr style="border-bottom: 1px solid #e3e6f0;">
                    <td style="padding: 15px; color: #6e707e;">{{ $loop->iteration }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #3a3b45;">{{ $l->user->name }}</td>
                    <td style="padding: 15px; color: #6e707e;">{{ $l->alat->nama_alat ?? 'Alat tidak ditemukan' }} ({{ $l->jumlah }})</td>
                    <td style="padding: 15px; text-align: center; color: #6e707e;">
                        {{ \Carbon\Carbon::parse($l->tgl_kembali_real)->format('d/m/Y') }}
                    </td>
                    <td
                        style="padding: 15px; text-align: right; font-weight: 700; color: {{ $l->denda > 0 ? '#e74a3b' : '#1cc88a' }};">
                        Rp {{ number_format($l->denda, 0, ',', '.') }}
                    </td>
                </tr>
                @php $total_denda += $l->denda; @endphp
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #999;">Tidak ada data laporan untuk
                        periode ini.</td>
                </tr>
                @endforelse
            </tbody>
            @if($laporans->count() > 0)
            <tfoot style="background: #f8f9fc; font-weight: 800;">
                <tr>
                    <td colspan="4" style="padding: 15px; text-align: right; color: #333;">TOTAL PENDAPATAN DENDA:</td>
                    <td style="padding: 15px; text-align: right; color: #e74a3b;">Rp
                        {{ number_format($total_denda, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection