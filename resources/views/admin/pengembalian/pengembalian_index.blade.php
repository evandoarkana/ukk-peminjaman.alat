@extends('layouts.admin')

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
                        <div class="font-black text-white mb-1" style="font-size: 16px; letter-spacing: -0.3px;">
                            {{ strtoupper($p->user->name) }}
                        </div>
                        <span class="badge-code">{{ $p->kode_peminjaman }}</span>
                    </td>
                   <td class="text-center">
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            
                            {{-- TOMBOL TERIMA PENGEMBALIAN --}}
                            <form action="{{ route('admin.peminjaman.kembali', $p->id) }}" method="POST" class="m-0 p-0">
                                @csrf
                                @method('PUT') {{-- PENTING: Karena di web.php menggunakan Route::put --}}
                                <button type="submit" class="btn-approve-action" onclick="return confirm('Konfirmasi pengembalian alat ini?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Terima Kembali
                                </button>
                            </form>

                        </div>
                    </td>
                    <td class="text-center">
                        <div class="schedule-box mx-auto" style="max-width: 180px;">
                            <div class="small-label text-center">Mulai</div>
                            <div class="date-value text-center">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') }}</div>
                            <div class="small-label mt-2 text-center">Kembali</div>
                            <div class="date-value text-rose-400 text-center font-bold">{{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d M Y') }}</div>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center align-items-center gap-2">
                        <form action="{{ route('admin.peminjaman.kembali', $p->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit">Setujui Pengembalian</button>
                        </form>
                            <form action="{{ route('admin.peminjaman.tolak', $p->id) }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="btn-reject-action"
                                        onclick="return confirm('Tolak permintaan ini?')">
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
    .gap-2 { gap: 0.75rem !important; }
    .m-0 { margin: 0 !important; }
    .p-0 { padding: 0 !important; }

    /* Peningkatan Readability Nama Alat */
    .font-black { font-weight: 900 !important; }
    .qty-label-bold { color: #818cf8; font-weight: 900; font-size: 15px; margin-left: 10px; }

    /* Badge & Box */
    .badge-code { background: #0f172a; color: #818cf8; padding: 2px 8px; border-radius: 6px; font-size: 10px; font-weight: 800; border: 1px solid #334155; font-family: monospace; display: inline-block; }
    .tool-list-container { display: flex; flex-direction: column; gap: 8px; }
    .tool-item-approve { display: flex; justify-content: space-between; align-items: center; background: rgba(30, 41, 59, 0.7); padding: 10px 16px; border-radius: 12px; }
    .schedule-box { background: rgba(15, 23, 42, 0.4); padding: 12px; border-radius: 12px; border: 1px solid #334155; }
    .small-label { font-size: 9px; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; }
    .date-value { font-size: 12px; font-weight: 800; color: #f8fafc; }

    /* Buttons */
    .btn-approve-action, .btn-reject-action { display: flex; align-items: center; gap: 6px; padding: 10px 16px; border-radius: 12px; font-size: 12px; font-weight: 900; border: none; cursor: pointer; transition: 0.3s; text-transform: uppercase; }
    .btn-approve-action { background: #10b981; color: white; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2); }
    .btn-approve-action:hover { background: #059669; transform: translateY(-2px); }
    .btn-reject-action { background: #f43f5e; color: white; box-shadow: 0 4px 10px rgba(244, 63, 94, 0.2); }
    .btn-reject-action:hover { background: #e11d48; transform: translateY(-2px); }

    /* Table & Container */
    .table-container { background: #1e293b; border-radius: 24px; border: 1px solid #334155; overflow: hidden; margin-bottom: 3rem; }
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table th { background: rgba(15, 23, 42, 0.6); padding: 20px; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #64748b; border-bottom: 2px solid #334155; }
    .modern-table td { padding: 24px; vertical-align: middle; border-bottom: 1px solid #334155; }
    
    .alert-custom-success, .alert-custom-danger { padding: 18px; border-radius: 16px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; font-weight: 700; border: 1px solid; }
    .alert-custom-success { background: rgba(34, 197, 94, 0.1); border-color: #22c55e; color: #4ade80; }
    .alert-custom-danger { background: rgba(244, 63, 94, 0.1); border-color: #f43f5e; color: #fb7185; }
</style>
@endsection