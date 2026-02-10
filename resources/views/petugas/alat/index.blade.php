@extends('layouts.petugas')

@section('content')
<div class="container-fluid min-h-screen">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h4 class="text-white fw-semibold mb-1">📦 Inventaris Alat (Petugas)</h4>
            <p class="text-slate-500 small mb-0 font-medium">Pantau ketersediaan stok barang secara real-time.</p>
        </div>
        <div class="text-end">
            <span class="badge-role">Role: Petugas</span>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="table-container shadow-2xl">
        <table class="modern-table">
            <thead>
                <tr>
                    <th class="text-center" width="40%">Informasi Alat</th>
                    <th class="text-center" width="20%">Kategori</th>
                    <th class="text-center" width="20%">Jumlah Stok</th>
                    <th class="text-center" width="20%">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alats as $a)
                <tr>
                    <td>
                        {{-- Nama alat dikurangi ketebalannya menjadi Semibold (600) --}}
                        <div class="text-white mb-1" style="font-size: 16px; font-weight: 600; letter-spacing: -0.2px;">
                            {{ $a->nama_alat }}
                        </div>
                        <div class="text-slate-400 small italic" style="font-weight: 400;">
                            Spesifikasi: {{ $a->spesifikasi }}
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge-category">
                            {{ $a->kategori->nama_kategori ?? 'UMUM' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="stock-display">
                            <span class="stock-number text-white">{{ $a->stok }}</span>
                            <span class="stock-unit text-slate-500">Unit</span>
                        </div>
                    </td>
                    <td class="text-center">
                        @if($a->stok > 10)
                            <div class="status-indicator status-safe">
                                <span class="dot-glow bg-emerald-500"></span>
                                AMAN
                            </div>
                        @elseif($a->stok > 0)
                            <div class="status-indicator status-warning">
                                <span class="dot-glow bg-amber-500"></span>
                                TERBATAS
                            </div>
                        @else
                            <div class="status-indicator status-danger">
                                <span class="dot-glow bg-rose-500"></span>
                                KOSONG
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-10">
                        <span class="text-slate-500 italic font-medium">Belum ada data inventaris alat saat ini.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Global Text Centering */
    .text-center { text-align: center !important; }
    
    /* Font Weight Adjustments (Tidak terlalu bold) */
    .fw-semibold { font-weight: 600 !important; }
    .fw-bold { font-weight: 700 !important; }

    /* Badge Role */
    .badge-role {
        background: rgba(99, 102, 241, 0.1);
        color: #818cf8;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        border: 1px solid rgba(99, 102, 241, 0.2);
    }

    /* Badge Category */
    .badge-category {
        background: #0f172a;
        color: #cbd5e1;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
        border: 1px solid #334155;
    }

    /* Stock Display */
    .stock-display { display: flex; flex-direction: column; align-items: center; }
    .stock-number { font-size: 20px; font-weight: 700; line-height: 1; }
    .stock-unit { font-size: 10px; font-weight: 600; text-transform: uppercase; margin-top: 2px; }

    /* Status Indicators */
    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 5px 12px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        border: 1px solid;
    }

    .dot-glow { width: 7px; height: 7px; border-radius: 50%; }

    .status-safe { background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); color: #10b981; }
    .status-warning { background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.2); color: #f59e0b; }
    .status-danger { background: rgba(244, 63, 94, 0.1); border-color: rgba(244, 63, 94, 0.2); color: #f43f5e; }

    /* Table Structure */
    .table-container { background: #1e293b; border-radius: 20px; border: 1px solid #334155; overflow: hidden; }
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table th { background: #0f172a; padding: 18px; font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #64748b; border-bottom: 2px solid #334155; }
    .modern-table td { padding: 20px; vertical-align: middle; border-bottom: 1px solid #334155; }
    .modern-table tr:hover { background: rgba(99, 102, 241, 0.02); transition: 0.2s; }
</style>
@endsection