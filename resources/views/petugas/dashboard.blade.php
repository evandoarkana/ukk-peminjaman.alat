@extends('layouts.petugas')

@section('content')
<div class="container-fluid">
    {{-- Welcome Header --}}
    <div class="mb-5">
        <h4 class="text-white fw-bold mb-1">👋 Selamat Datang, Petugas!</h4>
        <p class="text-slate-500 small mb-0">Berikut adalah ringkasan operasional gudang alat hari ini.</p>
    </div>

    {{-- Statistik Cards --}}
    <div class="row g-4 mb-5">
        {{-- Card: Perlu Persetujuan --}}
        <div class="col-xl-3 col-md-6">
            <div class="card-box" style="border-left: 4px solid #6366f1;">
                <div class="stat-title">Perlu Persetujuan</div>
                <div class="stat-value text-white">{{ $perlu_approval }}</div>
                <div class="mt-3">
                    <a href="{{ route('petugas.peminjaman.index') }}" class="link-indigo" style="font-size: 11px;">
                        Lihat Antrean →
                    </a>
                </div>
            </div>
        </div>

        {{-- Card: Sedang Dipinjam --}}
        <div class="col-xl-3 col-md-6">
            <div class="card-box" style="border-left: 4px solid #10b981;">
                <div class="stat-title">Sedang Dipinjam</div>
                <div class="stat-value text-white">{{ $sedang_dipinjam }}</div>
                <div class="mt-3">
                    <a href="{{ route('petugas.pengembalian.index') }}" class="link-emerald" style="font-size: 11px;">
                        Validasi Kembali →
                    </a>
                </div>
            </div>
        </div>

        {{-- Card: Jatuh Tempo --}}
        <div class="col-xl-3 col-md-6">
            <div class="card-box" style="border-left: 4px solid #f59e0b;">
                <div class="stat-title">Jatuh Tempo Hari Ini</div>
                <div class="stat-value text-warning">{{ $kembali_hari_ini }}</div>
                <p class="text-slate-500 mt-2" style="font-size: 10px; font-weight: 700; text-transform: uppercase;">
                    Segera cek pengembalian
                </p>
            </div>
        </div>

        {{-- Card: Total Stok --}}
        <div class="col-xl-3 col-md-6">
            <div class="card-box" style="border-left: 4px solid #06b6d4;">
                <div class="stat-title">Total Stok Tersedia</div>
                <div class="stat-value text-white">{{ $total_alat }}</div>
                <div class="mt-3">
                    <a href="{{ route('petugas.alat.index') }}" class="link-cyan" style="font-size: 11px;">
                        Cek Inventaris →
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="section-card shadow-2xl">
        <div class="d-flex justify-content-between align-items-center mb-4 px-2">
            <h6 class="text-white fw-bold mb-0">⚡ Aktivitas Peminjaman Terbaru</h6>
        </div>
        
        <div class="table-responsive">
            <table class="modern-table">
                <tbody>
                    @forelse($recent_activities as $ra)
                    <tr>
                        <td class="py-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="avatar-sm bg-slate-800 text-indigo-400">
                                    {{ strtoupper(substr($ra->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <span class="text-white fw-bold d-block">{{ $ra->user->name }}</span>
                                    <span class="text-slate-500 small">Mengajukan kode: </span>
                                    <span class="font-mono text-indigo-300 small fw-bold">{{ $ra->kode_peminjaman }}</span>
                                    
                                    <div class="mt-3 d-flex flex-wrap gap-2">
                                        @foreach($ra->detailPeminjaman as $detail)
                                        <span class="tool-badge">
                                            {{ $detail->alat->nama_alat }} <span class="text-indigo-400 ms-1">({{ $detail->jumlah }})</span>
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-end">
                            @php
                                $statusStyle = [
                                    'menunggu' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                    'disetujui' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                    'ditolak' => 'bg-rose-500/10 text-rose-500 border-rose-500/20'
                                ];
                            @endphp
                            <span class="status-pill {{ $statusStyle[$ra->status] ?? 'bg-slate-700 text-white' }}">
                                {{ $ra->status }}
                            </span>
                        </td>
                        <td class="text-end text-slate-500 font-mono small px-4">
                            {{ $ra->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-slate-500 italic">
                            Belum ada aktivitas peminjaman terbaru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Status & Badge Styling */
    .status-pill {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid;
    }

    .tool-badge {
        background: rgba(30, 41, 59, 0.5);
        color: #cbd5e1;
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 600;
        border: 1px solid #334155;
    }

    .avatar-sm {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 12px;
        border: 1px solid #334155;
    }

    /* Links Colors */
    .link-emerald { color: #10b981; text-decoration: none; font-weight: 700; }
    .link-cyan { color: #06b6d4; text-decoration: none; font-weight: 700; }
    .link-indigo { color: #818cf8; text-decoration: none; font-weight: 700; }

    /* Reusable Components from Previous Styles */
    .card-box { background: #1e293b; padding: 24px; border-radius: 16px; border: 1px solid #334155; }
    .stat-title { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #64748b; margin-bottom: 8px; }
    .stat-value { font-size: 28px; font-weight: 800; }
    .section-card { background: #1e293b; border-radius: 20px; padding: 30px; border: 1px solid #334155; }
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table td { vertical-align: middle; border-bottom: 1px solid #334155; padding: 15px 0; }
    .modern-table tr:last-child td { border-bottom: none; }
    
    /* Text Helpers */
    .text-slate-500 { color: #64748b; }
    .text-amber-500 { color: #f59e0b; }
    .bg-amber-500\/10 { background-color: rgba(245, 158, 11, 0.1); }
</style>
@endsection