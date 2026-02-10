@extends('layouts.peminjam')

@section('content')
<div class="container-fluid min-h-screen">
    {{-- Header --}}
    <div class="mb-5">
        <h4 class="text-white fw-semibold mb-1">↩️ Pengembalian Alat</h4>
        <p class="text-slate-500 small mb-0 font-medium">Daftar alat di bawah ini harus segera dikembalikan ke petugas gudang untuk validasi.</p>
    </div>

    <div class="grid gap-4">
        @forelse($pinjamanAktif as $p)
        <div class="card-return-student shadow-lg">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    {{-- Status Badge --}}
                    <div class="status-badge-active mb-3">
                        <span class="dot-pulse"></span>
                        SEDANG DIPINJAM
                    </div>

                    {{-- Transaction Info --}}
                    <h5 class="text-indigo-400 font-mono fw-bold mb-2" style="font-size: 1.1rem; letter-spacing: 0.5px;">
                        {{ $p->kode_peminjaman }}
                    </h5>
                    
                    <p class="text-slate-400 small mb-4 font-medium">
                        Jadwal Kembali: 
                        <span class="text-rose-400 fw-semibold">{{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d M Y') }}</span>
                    </p>

                    {{-- Tool List Box --}}
                    <div class="tool-list-box-student">
                        <p class="text-[10px] font-bold text-slate-500 uppercase mb-2 tracking-wider">Daftar Alat:</p>
                        <ul class="list-unstyled m-0">
                            @foreach($p->detailPeminjaman as $detail)
                            <li class="d-flex justify-content-between align-items-center mb-1 text-slate-200" style="font-size: 13px;">
                                <span class="font-medium">{{ $detail->alat->nama_alat }}</span>
                                <span class="badge-qty-simple">{{ $detail->jumlah }} Unit</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Instruction Sidebar --}}
                <div class="instruction-sidebar text-end ps-4">
                    <div class="text-[10px] font-bold text-slate-500 uppercase mb-1">Instruksi:</div>
                    <div class="text-white small leading-relaxed font-medium">
                        Bawa alat ke petugas <br> 
                        untuk proses <br> 
                        <span class="text-indigo-400">Validasi Kembali</span>.
                    </div>
                </div>
            </div>
        </div>
        @empty
        {{-- Empty State --}}
        <div class="empty-return-state">
            <div class="mb-3 opacity-20">
                <svg class="w-16 h-16 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <p class="text-slate-500 font-medium italic">Anda tidak memiliki pinjaman aktif yang perlu dikembalikan.</p>
            <a href="{{ route('peminjam.alat.index') }}" class="btn-indigo-outline mt-3">
                Pinjam Alat Sekarang →
            </a>
        </div>
        @endforelse
    </div>
</div>

<style>
    /* Card Styling */
    .card-return-student {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 16px;
        padding: 24px;
        transition: transform 0.3s ease;
    }
    .card-return-student:hover {
        transform: translateY(-4px);
        border-color: #475569;
    }

    /* Badge & Status */
    .status-badge-active {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .dot-pulse {
        width: 6px;
        height: 6px;
        background: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
        animation: pulse 2s infinite;
    }

    /* Tool List Box */
    .tool-list-box-student {
        background: rgba(15, 23, 42, 0.4);
        border: 1px solid #334155;
        border-radius: 12px;
        padding: 16px;
    }
    .badge-qty-simple {
        font-size: 11px;
        font-weight: 700;
        color: #818cf8;
    }

    /* Empty State */
    .empty-return-state {
        text-align: center;
        padding: 60px 20px;
        background: #0f172a;
        border: 2px dashed #334155;
        border-radius: 20px;
    }
    .btn-indigo-outline {
        display: inline-block;
        padding: 10px 20px;
        color: #818cf8;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #334155;
        border-radius: 12px;
        transition: 0.3s;
    }
    .btn-indigo-outline:hover {
        background: #6366f1;
        color: white;
        border-color: #6366f1;
    }

    /* Utilities */
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
    .text-slate-500 { color: #64748b; }
    .text-slate-400 { color: #94a3b8; }
    .fw-semibold { font-weight: 600; }
</style>
@endsection