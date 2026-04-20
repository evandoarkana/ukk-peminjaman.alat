@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4" style="background: #0f172a; min-height: 100vh;">
    {{-- Header --}}
    <div class="mb-4">
        <h2 class="text-white fw-bold">Dashboard Overview</h2>
        <p class="text-secondary small">Sistem Informasi Inventaris — <span style="color: #6366f1;">Admin Utama</span></p>
    </div>

    {{-- Title Section --}}
    <div class="mb-5">
        <h5 class="text-white d-flex align-items-center gap-2 fw-bold">
            <span style="color: #fbbf24;">🔔</span> Persetujuan Peminjaman
        </h5>
        <p class="text-secondary small" style="opacity: 0.7;">Tinjau dan proses permintaan peminjaman alat dari pengguna.</p>
    </div>

    {{-- WRAPPER UTAMA (CARD DENGAN BORDER TEGAS) --}}
    <div class="main-card" style="background: #1e293b; border-radius: 20px; border: 1px solid #334155; overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);">
        
        {{-- HEADER KOLOM --}}
        <div class="row px-4 py-4 text-secondary fw-bold" style="font-size: 11px; letter-spacing: 2px; border-bottom: 1px solid #334155; background: rgba(15, 23, 42, 0.2);">
            <div class="col-md-3 text-center">PEMINJAM</div>
            <div class="col-md-3 text-center">DAFTAR ALAT & JUMLAH</div>
            <div class="col-md-3 text-center">JADWAL PINJAM</div>
            <div class="col-md-3 text-center">AKSI</div>
        </div>

        {{-- LIST DATA --}}
        <div class="p-4">
            @forelse($peminjamans as $p)
            <div class="row align-items-center p-4 mb-4 row-data" style="background: rgba(15, 23, 42, 0.4); border-radius: 15px; border: 1px solid #334155;">
                
                {{-- 1. PEMINJAM --}}
                <div class="col-md-3 text-center">
                    <h5 class="text-white fw-bold mb-2" style="letter-spacing: 0.5px; text-transform: uppercase;">{{ $p->user->name }}</h5>
                    <div class="d-inline-block px-3 py-1" style="background: #0f172a; border-radius: 6px; border: 1px solid #334155;">
                        <span style="color: #6366f1; font-size: 10px; font-family: monospace; font-weight: bold;">{{ $p->kode_peminjaman }}</span>
                    </div>
                </div>

                {{-- 2. DAFTAR ALAT --}}
                <div class="col-md-3 text-center">
                    <div class="d-inline-block p-2 px-4" style="background: rgba(30, 41, 59, 0.8); border: 1px solid #475569; border-radius: 12px;">
                        <span class="text-white fw-bold small me-1">{{ $p->alat->nama_alat ?? 'Alat Dihapus' }}</span>
                        <span style="color: #818cf8; font-weight: 900; font-size: 16px;">x{{ $p->jumlah }}</span>
                    </div>
                </div>

                {{-- 3. JADWAL PINJAM (KOTAK TERANG) --}}
                <div class="col-md-3 text-center">
                    <div class="py-2 px-3 d-inline-block" style="background: rgba(15, 23, 42, 0.6); border: 1px solid #334155; border-radius: 12px; min-width: 160px;">
                        <div class="mb-2 border-bottom border-secondary pb-1" style="border-style: dashed !important;">
                            <small style="color: #64748b; font-size: 8px; font-weight: bold; display: block; text-transform: uppercase;">Mulai</small>
                            <span class="text-white fw-bold small">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') }}</span>
                        </div>
                        <div>
                            <small style="color: #64748b; font-size: 8px; font-weight: bold; display: block; text-transform: uppercase;">Kembali</small>
                            <span class="text-white fw-bold small">{{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

             <td class="text-center">
    <div class="d-flex justify-content-center align-items-center gap-2">
        
        {{-- Form Setujui --}}
        <form action="{{ route('admin.peminjaman.setujui', $p->id) }}" method="POST" class="m-0 p-0">
            @csrf
            @method('PUT') {{-- PENTING: Harus PUT sesuai route --}}
            <button type="submit" class="btn-approve-action" onclick="return confirm('Setujui peminjaman ini?')">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Setujui
            </button>
        </form>

        {{-- Form Tolak (Jika diperlukan) --}}
        <form action="{{ route('admin.peminjaman.tolak', $p->id) }}" method="POST" class="m-0 p-0">
            @csrf
            <button type="submit" class="btn-reject-action" onclick="return confirm('Tolak permintaan ini?')">
                Tolak
            </button>
        </form>

    </div>
</td>
            @empty
            <div class="text-center py-5 text-secondary">
                <p style="font-style: italic;">Tidak ada antrean persetujuan saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    /* Styling Button Khusus */
    .btn-action-approve {
        background: #10b981;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 800;
        font-size: 11px;
        padding: 10px 20px;
        letter-spacing: 1px;
        box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.4);
        transition: all 0.3s;
    }
    .btn-action-approve:hover {
        background: #059669;
        transform: translateY(-2px);
        color: white;
    }

    .btn-action-reject {
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 800;
        font-size: 11px;
        padding: 10px 20px;
        letter-spacing: 1px;
        box-shadow: 0 4px 14px 0 rgba(239, 68, 68, 0.4);
        transition: all 0.3s;
    }
    .btn-action-reject:hover {
        background: #dc2626;
        transform: translateY(-2px);
        color: white;
    }

    .row-data:hover {
        border-color: #4f46e5 !important;
        background: rgba(30, 41, 59, 0.6) !important;
    }
</style>
@endsection