@extends('layouts.petugas')

@section('content')
<div class="container-fluid min-h-screen">
    {{-- Header --}}
    <div class="mb-5">
        <h4 class="text-white fw-bold mb-1">🔔 Persetujuan Peminjaman</h4>
        <p class="text-slate-500 small mb-0">Tinjau dan proses permintaan peminjaman alat dari pengguna.</p>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
    <div class="alert-custom-success">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="alert-custom-danger">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    {{-- Table Card --}}
    <div class="table-container shadow-2xl">
        <table class="modern-table">
            <thead>
                <tr>
                    <th class="text-center" width="25%">Peminjam</th>
                    <th class="text-center" width="35%">Daftar Alat & Jumlah</th>
                    <th class="text-center" width="20%">Jadwal Pinjam</th>
                    <th class="text-center" width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $p)
                <tr>
                    <td class="text-center">
                        <div class="fw-bold text-white mb-1" style="font-size: 15px;">{{ $p->user->name }}</div>
                        <span class="badge-code">{{ $p->kode_peminjaman }}</span>
                    </td>
                    <td class="text-center">
                        <div class="tool-list-container align-items-center">
                            @foreach($p->detailPeminjaman as $detail)
                            <div class="tool-item-approve mx-auto" style="max-width: 250px;">
                                <span class="text-slate-300">{{ $detail->alat->nama_alat }}</span>
                                <span class="qty-label">x{{ $detail->jumlah }}</span>
                            </div>
                            @endforeach
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="schedule-box mx-auto" style="max-width: 180px;">
                            <div class="small-label text-center">Mulai</div>
                            <div class="date-value text-center">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') }}</div>
                            <div class="small-label mt-2 text-center">Kembali</div>
                            <div class="date-value text-rose-400 text-center">{{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d M Y') }}</div>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            {{-- Button Setujui --}}
                            <form action="{{ route('petugas.peminjaman.setujui', $p->id) }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="btn-approve-action"
                                        onclick="return confirm('Setujui peminjaman ini? Stok akan otomatis berkurang.')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Setujui
                                </button>
                            </form>

                            {{-- Button Tolak --}}
                            <form action="{{ route('petugas.peminjaman.tolak', $p->id) }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="btn-reject-action"
                                        onclick="return confirm('Tolak permintaan peminjaman ini?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-10">
                        <div class="text-slate-600 mb-2 text-center">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <span class="text-slate-500 italic d-block text-center">Tidak ada antrean persetujuan saat ini.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Paksa Alignment Tengah */
    .text-center { text-align: center !important; }
    .mx-auto { margin-left: auto !important; margin-right: auto !important; }
    .d-flex { display: flex !important; }
    .justify-content-center { justify-content: center !important; }
    .align-items-center { align-items: center !important; }
    .gap-2 { gap: 0.5rem !important; }
    .m-0 { margin: 0 !important; }
    .p-0 { padding: 0 !important; }

    /* Badge Kode */
    .badge-code {
        background: #0f172a;
        color: #818cf8;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 800;
        border: 1px solid #334155;
        font-family: monospace;
        display: inline-block;
    }

    /* Alat List */
    .tool-list-container { display: flex; flex-direction: column; gap: 6px; }
    .tool-item-approve {
        display: flex; justify-content: space-between; align-items: center;
        background: rgba(255,255,255,0.03); padding: 6px 12px; border-radius: 8px; font-size: 13px;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .qty-label { color: #6366f1; font-weight: 800; }

    /* Schedule Box */
    .schedule-box { background: rgba(15, 23, 42, 0.4); padding: 10px; border-radius: 10px; border: 1px solid #334155; }
    .small-label { font-size: 9px; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; }
    .date-value { font-size: 12px; font-weight: 700; color: #cbd5e1; }

    /* Action Buttons */
    .btn-approve-action, .btn-reject-action {
        display: flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 10px;
        font-size: 12px; font-weight: 800; border: none; cursor: pointer; transition: 0.3s;
    }

    .btn-approve-action { background: #10b981; color: white; }
    .btn-approve-action:hover { background: #059669; transform: translateY(-2px); }

    .btn-reject-action { background: #f43f5e; color: white; }
    .btn-reject-action:hover { background: #e11d48; transform: translateY(-2px); }

    /* Base Styles */
    .table-container { background: #1e293b; border-radius: 20px; border: 1px solid #334155; overflow: hidden; margin-bottom: 2rem; }
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table th { background: rgba(15, 23, 42, 0.5); padding: 18px 24px; text-align: center; font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #94a3b8; border-bottom: 1px solid #334155; }
    .modern-table td { padding: 18px 24px; vertical-align: middle; border-bottom: 1px solid #334155; }
    
    .alert-custom-success, .alert-custom-danger { padding: 16px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; font-weight: 600; border: 1px solid; }
    .alert-custom-success { background: rgba(34, 197, 94, 0.1); border-color: rgba(34, 197, 94, 0.2); color: #4ade80; }
    .alert-custom-danger { background: rgba(244, 63, 94, 0.1); border-color: rgba(244, 63, 94, 0.2); color: #fb7185; }
    
    .w-4 { width: 1rem; } .h-4 { height: 1rem; } .w-5 { width: 1.25rem; } .h-5 { height: 1.25rem; } .w-12 { width: 3rem; } .h-12 { height: 3rem; }
</style>
@endsection 