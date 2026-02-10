@extends('layouts.admin')

@section('content')
<div class="form-container">
    <div class="form-card-large shadow-2xl">
        {{-- Header --}}
        <div class="form-header text-center mb-5">
            <h4 class="form-title">📄 Konfirmasi Pengembalian</h4>
            <p class="form-subtitle">Validasi barang dan penyelesaian denda (jika ada).</p>
        </div>

        {{-- Info Box: Detail Transaksi --}}
        <div class="transaction-info-card">
            <div class="info-row">
                <span class="info-label">Kode Transaksi</span>
                <span class="info-value text-indigo-400 font-mono">{{ $kode }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Nama Peminjam</span>
                <span class="info-value text-white">{{ $first->user->name ?? 'User Tidak Ditemukan' }}</span>
            </div>

            <div class="divider-dashed"></div>

            <div class="tool-summary">
                <p class="summary-title">Daftar Alat yang Dikembalikan:</p>
                <div class="tool-grid">
                    @foreach($items as $peminjaman)
                        @foreach($peminjaman->detailPeminjaman as $detail)
                        <div class="tool-confirm-item">
                            <span class="text-slate-200">{{ $detail->alat->nama_alat ?? 'Alat tidak ditemukan' }}</span>
                            <span class="badge-qty">{{ $detail->jumlah }} Unit</span>
                        </div>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <div class="divider-dashed"></div>

            <div class="row g-3">
                <div class="col-6">
                    <p class="info-label mb-1">Batas Kembali</p>
                    <p class="text-rose-400 fw-bold">{{ \Carbon\Carbon::parse($first->tgl_kembali_rencana)->format('d M Y') }}</p>
                </div>
                <div class="col-6 text-end">
                    <p class="info-label mb-1">Tanggal Kembali (Sistem)</p>
                    <p class="text-emerald-400 fw-bold">{{ $tgl_aktual->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Denda Calculation Area --}}
        <div class="denda-display-card {{ $hari_terlambat > 0 ? 'denda-late' : 'denda-safe' }}">
            @if($hari_terlambat > 0)
                <div class="late-badge">⚠️ TERLAMBAT {{ $hari_terlambat }} HARI</div>
                <div class="denda-value">Rp {{ number_format($denda, 0, ',', '.') }}</div>
                <p class="denda-note">(Denda dihitung Rp 5.000 / hari per transaksi)</p>
            @else
                <div class="safe-badge">✅ TEPAT WAKTU</div>
                <div class="denda-value">Rp 0</div>
                <p class="denda-note">Tidak ada tanggungan denda.</p>
            @endif
        </div>

        {{-- Form Konfirmasi --}}
        <form action="{{ route('admin.peminjaman.store_pengembalian', $kode) }}" method="POST">
            @csrf
            <input type="hidden" name="tgl_kembali_aktual" value="{{ $tgl_aktual->format('Y-m-d H:i:s') }}">
            <input type="hidden" name="denda" value="{{ $denda }}">

            <div class="form-actions mt-4">
                <button type="submit" class="btn-confirm-save" 
                        onclick="return confirm('Apakah barang sudah diterima lengkap dan denda sudah lunas? Stok akan otomatis bertambah.')">
                    Konfirmasi & Update Inventaris
                </button>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
    /* Card & Layout */
    .form-container { display: flex; justify-content: center; padding: 10px 0; }
    .form-card-large {
        background: #1e293b;
        width: 100%;
        max-width: 650px;
        padding: 40px;
        border-radius: 24px;
        border: 1px solid #334155;
    }

    /* Info Card */
    .transaction-info-card {
        background: rgba(15, 23, 42, 0.4);
        border: 1px solid #334155;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
    .info-label { color: #64748b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .info-value { font-weight: 700; font-size: 14px; }
    
    .divider-dashed { border-top: 1px dashed #334155; margin: 20px 0; }

    /* Tool Grid */
    .summary-title { color: #818cf8; font-size: 13px; font-weight: 800; margin-bottom: 12px; }
    .tool-grid { display: grid; gap: 8px; }
    .tool-confirm-item {
        display: flex; justify-content: space-between; background: rgba(255,255,255,0.03);
        padding: 8px 12px; border-radius: 8px; font-size: 13px;
    }
    .badge-qty { color: #6366f1; font-weight: 800; }

    /* Denda Card */
    .denda-display-card {
        text-align: center; padding: 30px; border-radius: 20px; border: 2px dashed;
        transition: 0.3s;
    }
    
    .denda-late {
        background: rgba(244, 63, 94, 0.05);
        border-color: rgba(244, 63, 94, 0.3);
    }
    .denda-safe {
        background: rgba(34, 197, 94, 0.05);
        border-color: rgba(34, 197, 94, 0.3);
    }

    .late-badge { color: #fb7185; font-weight: 900; font-size: 12px; letter-spacing: 1px; }
    .safe-badge { color: #4ade80; font-weight: 900; font-size: 12px; letter-spacing: 1px; }

    .denda-value { font-size: 2.5rem; font-weight: 900; margin: 10px 0; }
    .denda-late .denda-value { color: #f43f5e; text-shadow: 0 0 20px rgba(244, 63, 94, 0.2); }
    .denda-safe .denda-value { color: #10b981; }
    
    .denda-note { color: #64748b; font-size: 11px; font-weight: 600; }

    /* Buttons */
    .btn-confirm-save {
        flex: 2; background: #10b981; color: white; border: none; padding: 16px;
        border-radius: 14px; font-weight: 800; font-size: 15px; cursor: pointer; transition: 0.3s;
    }
    .btn-confirm-save:hover { background: #059669; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3); }

    .btn-cancel {
        flex: 1; text-align: center; background: transparent; color: #94a3b8;
        border: 1px solid #334155; padding: 16px; border-radius: 14px;
        text-decoration: none; font-weight: 700; transition: 0.3s;
    }
    .btn-cancel:hover { background: rgba(255,255,255,0.05); color: white; }

    .form-actions { display: flex; gap: 15px; }
</style>
@endsection