@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h4 class="text-white fw-bold mb-1">🔄 Peminjaman Aktif</h4>
            <p class="text-slate-500 small mb-0">Monitor transaksi alat yang sedang dipinjam oleh user.</p>
        </div>
        <a href="{{ route('admin.peminjaman.create') }}" class="btn-indigo">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Pinjam Alat Baru
        </a>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="alert-custom-success">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Table Container --}}
    <div class="table-container shadow-2xl">
        <table class="modern-table">
            <thead>
                <tr>
                    <th width="25%">Peminjam & Kode</th>
                    <th width="35%">Detail Inventaris</th>
                    <th width="15%">Waktu Pinjam</th>
                    <th width="15%">Batas Kembali</th>
                    <th width="10%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $kode => $groupItems)
                @php
                    $first = $groupItems->first();
                    $totalUnit = 0;
                    foreach($groupItems as $p) {
                        $totalUnit += $p->detailPeminjaman->sum('jumlah');
                    }
                    $isOverdue = \Carbon\Carbon::parse($first->tgl_kembali_rencana)->isPast();
                @endphp
                <tr class="{{ $isOverdue ? 'row-overdue' : '' }}">
                    <td class="px-4">
                        <div class="font-mono text-[10px] text-indigo-400 font-bold mb-1">{{ $kode }}</div>
                        <div class="text-white fw-bold">{{ $first->user->name ?? 'User Tidak Ditemukan' }}</div>
                        <div class="mt-2">
                            <span class="badge-unit">{{ $totalUnit }} Unit Terdata</span>
                        </div>
                    </td>
                    <td>
                        <div class="tool-list-container">
                            @foreach($groupItems as $p)
                                @foreach($p->detailPeminjaman as $detail)
                                <div class="tool-item">
                                    <span class="tool-dot"></span>
                                    <span class="text-slate-300">{{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}</span>
                                    <span class="tool-qty">x{{ $detail->jumlah }}</span>
                                </div>
                                @endforeach
                            @endforeach
                        </div>
                    </td>
                    <td class="text-slate-400 font-medium">
                        {{ \Carbon\Carbon::parse($first->tgl_pinjam)->format('d M Y') }}
                    </td>
                    <td>
                        <div class="deadline-box {{ $isOverdue ? 'deadline-late' : '' }}">
                            <div class="date">{{ \Carbon\Carbon::parse($first->tgl_kembali_rencana)->format('d M Y') }}</div>
                            @if($isOverdue)
                                <div class="status-late">TERLAMBAT</div>
                            @else
                                <div class="status-safe">AKTIF</div>
                            @endif
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.peminjaman.konfirmasi', $kode) }}" class="btn-return-action" title="Kembalikan Semua Alat">
                           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"/></svg>
                           <span>Proses</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-10 text-slate-500 italic">
                        Tidak ada transaksi peminjaman aktif saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Status Overdue Row */
    .row-overdue {
        background: rgba(244, 63, 94, 0.03) !important;
    }

    /* Badge Unit */
    .badge-unit {
        background: rgba(34, 197, 94, 0.15);
        color: #4ade80;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
    }

    /* Tool List Styling */
    .tool-list-container {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .tool-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        background: rgba(255,255,255,0.03);
        padding: 4px 10px;
        border-radius: 8px;
    }

    .tool-dot {
        width: 5px;
        height: 5px;
        background: #6366f1;
        border-radius: 50%;
    }

    .tool-qty {
        margin-left: auto;
        font-weight: 800;
        color: #818cf8;
    }

    /* Deadline Box */
    .deadline-box {
        padding: 8px 12px;
        border-radius: 10px;
        background: rgba(148, 163, 184, 0.1);
        border: 1px solid rgba(148, 163, 184, 0.1);
        text-align: center;
        width: fit-content;
    }

    .deadline-box .date {
        font-size: 13px;
        font-weight: 700;
        color: #e2e8f0;
    }

    .deadline-late {
        background: rgba(244, 63, 94, 0.1);
        border-color: rgba(244, 63, 94, 0.2);
    }

    .deadline-late .date { color: #fb7185; }

    .status-late {
        font-size: 9px;
        font-weight: 900;
        color: #f43f5e;
        margin-top: 2px;
    }

    .status-safe {
        font-size: 9px;
        font-weight: 900;
        color: #64748b;
        margin-top: 2px;
    }

    /* Button Action Return */
    .btn-return-action {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        color: #22c55e;
        transition: 0.3s;
        padding: 8px;
        border-radius: 12px;
    }

    .btn-return-action:hover {
        background: rgba(34, 197, 94, 0.1);
        transform: scale(1.05);
    }

    .btn-return-action span {
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
    }

    /* CSS Bawaan sebelumnya yang relevan */
    .table-container { background: #1e293b; border-radius: 16px; border: 1px solid #334155; overflow: hidden; }
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table th { background: rgba(15, 23, 42, 0.5); padding: 18px 24px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #94a3b8; border-bottom: 1px solid #334155; }
    .modern-table td { padding: 18px 24px; vertical-align: middle; border-bottom: 1px solid #334155; }
    .btn-indigo { background: #6366f1; color: white; padding: 10px 22px; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-size: 14px; }
    .alert-custom-success { background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); color: #4ade80; padding: 16px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; font-weight: 600; }
</style>
@endsection