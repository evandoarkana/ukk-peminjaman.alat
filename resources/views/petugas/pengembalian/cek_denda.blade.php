@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4" style="margin-top: 30px; font-family: 'Segoe UI', sans-serif;">
    <div
        style="max-width: 600px; margin: auto; background: white; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden; border: 1px solid #e3e6f0;">

        {{-- Header Struk --}}
        <div style="background: #4e73df; padding: 20px; color: white; text-align: center;">
            <h5 style="margin: 0; font-weight: 700; letter-spacing: 1px;">STRUK KONFIRMASI PENGEMBALIAN</h5>
        </div>

        <div style="padding: 30px;">
            {{-- Bagian Informasi Transaksi --}}
            <div style="margin-bottom: 20px; border-bottom: 1px dashed #d1d3e2; padding-bottom: 20px;">
                <p style="margin: 5px 0; color: #858796;">Kode Transaksi: <strong
                        style="color: #4e73df;">{{ $peminjaman->kode_peminjaman }}</strong></p>
                <p style="margin: 5px 0; color: #858796;">Nama Peminjam: <strong
                        style="color: #333;">{{ $peminjaman->user->name }}</strong></p>

                <div style="margin-top: 15px;">
                    <p style="margin: 5px 0; color: #858796; font-weight: 700; font-size: 13px;">DAFTAR ALAT YANG
                        DIKEMBALIKAN:</p>
                    <ul style="margin: 0; padding-left: 20px; color: #333;">
                        {{-- Menampilkan daftar semua alat dalam satu transaksi --}}
                        @foreach($peminjaman->detailPeminjaman as $detail)
                        <li style="margin-bottom: 5px;">
                            {{ $detail->alat->nama_alat ?? 'Alat tidak ditemukan' }}
                            <strong style="color: #4e73df;">({{ $detail->jumlah }} Unit)</strong>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Kalkulasi Waktu --}}
            <div style="background: #f8f9fc; padding: 15px; border-radius: 8px; margin-bottom: 25px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #6e707e;">Batas Kembali:</span>
                    <span
                        style="font-weight: 600;">{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali_rencana)->format('d/m/Y') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #6e707e;">Tanggal Kembali (Hari Ini):</span>
                    <span style="font-weight: 600;">{{ $tgl_kembali_real->format('d/m/Y') }}</span>
                </div>
                <hr style="border-top: 1px solid #d1d3e2;">
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #6e707e;">Status Keterlambatan:</span>
                    <span style="color: {{ $hari_terlambat > 0 ? '#e74a3b' : '#1cc88a' }}; font-weight: 700;">
                        {{ $hari_terlambat > 0 ? $hari_terlambat . ' Hari Terlambat' : 'Tepat Waktu' }}
                    </span>
                </div>
            </div>

            {{-- Total Denda --}}
            <div style="text-align: center; margin-bottom: 30px;">
                <h6 style="color: #858796; font-size: 12px; margin-bottom: 5px; text-transform: uppercase;">Total Denda
                    yang Harus Dibayar</h6>
                <h2 style="color: #e74a3b; font-weight: 800; margin: 0;">Rp
                    {{ number_format($total_denda, 0, ',', '.') }}</h2>
                <small style="color: #999;">(Denda dihitung per transaksi sesuai jadwal)</small>
            </div>

            {{-- PERBAIKAN: Pastikan route mengarah ke role PETUGAS bukan ADMIN --}}
            <form action="{{ route('petugas.pengembalian.simpan', $peminjaman->id) }}" method="POST">
                @csrf
                {{-- Input hidden untuk mengirimkan denda --}}
                <input type="hidden" name="denda" value="{{ $total_denda }}">

                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <button type="submit"
                        style="background: #1cc88a; color: white; border: none; padding: 14px; border-radius: 8px; font-weight: 700; cursor: pointer;"
                        onclick="return confirm('Apakah barang sudah diterima fisik dan denda sudah dibayarkan?')">
                        TERIMA BARANG & SIMPAN DATA
                    </button>
                    <a href="{{ route('petugas.pengembalian.index') }}"
                        style="text-align: center; color: #858796; text-decoration: none; font-size: 13px; font-weight: 600; padding: 10px;">
                        Batal / Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection