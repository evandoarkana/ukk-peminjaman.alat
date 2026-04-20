@extends('layouts.petugas')

@section('content')
<div class="container-fluid min-h-screen px-4 py-4">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-white fw-bold mb-1"> INVESTARIS ALAT</h4>
            <p class="text-slate-400 small mb-0">Manajemen stok barang dan ketersediaan alat secara real-time.</p>
        </div>
        <div class="text-end">
            <span class="badge-role shadow-sm">PANEL PETUGAS</span>
        </div>
    </div>

    {{-- Stats Row (Opsional: Agar lebih mirip dashboard admin) --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card shadow-sm">
                <span class="text-slate-400 small d-block mb-1">Total Jenis Alat</span>
                <h3 class="text-white fw-bold mb-0">{{ $alats->count() }}</h3>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="table-container shadow-lg">
        <div class="table-header px-4 py-3 border-bottom border-slate-700 bg-[#1e2139]">
            <h6 class="text-purple-400 fw-bold mb-0"><i class="fas fa-list-ul me-2"></i>Daftar Stok Inventaris</h6>
        </div>
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th class="ps-4">Informasi Alat</th>
                        <th class="text-center">Kategori</th>
                        <th class="text-center">Jumlah Stok</th>
                        <th class="text-center pe-4">Status Ketersediaan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alats as $a)
                    <tr>
                        <td class="ps-4">
                            <div class="text-white mb-1 fw-semibold" style="font-size: 15px;">
                                {{ $a->nama_alat }}
                            </div>
                            <div class="text-slate-500 small">
                                <span class="text-slate-600 font-monospace">SPEC:</span> {{ $a->spesifikasi }}
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge-category">
                                {{ $a->kategori->nama_kategori ?? 'UMUM' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="stock-wrapper">
                                <span class="stock-number text-white">{{ $a->stok }}</span>
                                <span class="stock-unit">Unit</span>
                            </div>
                        </td>
                        <td class="text-center pe-4">
                            @if($a->stok > 10)
                                <div class="status-badge status-safe">
                                    <span class="pulse-dot bg-emerald-500"></span> AMAN
                                </div>
                            @elseif($a->stok > 0)
                                <div class="status-badge status-warning">
                                    <span class="pulse-dot bg-amber-500"></span> TERBATAS
                                </div>
                            @else
                                <div class="status-badge status-danger">
                                    <span class="pulse-dot bg-rose-500"></span> KOSONG
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="py-4">
                                <i class="fas fa-box-open text-slate-700 mb-3" style="font-size: 40px;"></i>
                                <p class="text-slate-500 italic mb-0">Belum ada data inventaris alat.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* UI Alignment & Colors */
    :root {
        --bg-card: #1e2139; /* Menyelaraskan dengan Dashboard Admin */
        --bg-dark: #111827;
        --accent-purple: #818cf8;
    }

    /* Badge Role Custom */
    .badge-role {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(129, 140, 248, 0.1));
        color: var(--accent-purple);
        padding: 6px 16px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1px;
        border: 1px solid rgba(99, 102, 241, 0.3);
    }

    /* Stat Card Style */
    .stat-card {
        background: var(--bg-card);
        padding: 20px;
        border-radius: 16px;
        border-left: 4px solid var(--accent-purple);
    }

    /* Badge Category */
    .badge-category {
        background: rgba(30, 41, 59, 0.5);
        color: #94a3b8;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        border: 1px solid #334155;
        text-transform: uppercase;
    }

    /* Stock Display */
    .stock-wrapper { line-height: 1.2; }
    .stock-number { font-size: 18px; font-weight: 800; display: block; }
    .stock-unit { font-size: 9px; font-weight: 700; color: #64748b; text-transform: uppercase; }

    /* Modern Badge Status */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.5px;
    }
    .status-safe { background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
    .status-warning { background: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); }
    .status-danger { background: rgba(244, 63, 94, 0.1); color: #f43f5e; border: 1px solid rgba(244, 63, 94, 0.2); }

    /* Animation Dot */
    .pulse-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }

    /* Table Structure */
    .table-container { 
        background: var(--bg-card); 
        border-radius: 16px; 
        border: 1px solid #2d304e; 
        overflow: hidden; 
    }
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table th { 
        background: rgba(15, 23, 42, 0.4); 
        padding: 15px; 
        font-size: 10px; 
        text-transform: uppercase; 
        letter-spacing: 1.2px; 
        color: #94a3b8; 
        font-weight: 700;
    }
    .modern-table td { 
        padding: 16px; 
        vertical-align: middle; 
        border-bottom: 1px solid #2d304e; 
    }
    .modern-table tr:hover { background: rgba(255, 255, 255, 0.02); }
    .modern-table tr:last-child td { border-bottom: none; }
</style>
@endsection