@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-white fw-bold mb-1">📦 Inventaris Alat</h4>
            <p class="text-slate-500 small mb-0">Kelola daftar aset dan ketersediaan stok alat.</p>
        </div>
        <a href="{{ route('admin.alat.create') }}" 
           class="btn-indigo">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Alat
        </a>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="alert-custom-success">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Table Card --}}
    <div class="table-container">
        <table class="modern-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="45%">Detail Alat</th>
                    <th width="15%">Kategori</th>
                    <th width="15%">Stok</th>
                    <th width="20%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alats as $alat)
                <tr>
                    <td class="text-slate-500 font-mono">
                        {{ ($alats->currentPage() - 1) * $alats->perPage() + $loop->iteration }}
                    </td>
                    <td>
                        <div class="fw-bold text-white mb-1">{{ $alat->nama_alat }}</div>
                        <div class="text-slate-500 small text-truncate" style="max-width: 300px;">
                            {{ $alat->spesifikasi }}
                        </div>
                    </td>
                    <td>
                        <span class="badge-slate">{{ $alat->kategori->nama_kategori }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <span class="stok-indicator {{ $alat->stok < 5 ? 'bg-rose-500' : 'bg-indigo-500' }}"></span>
                            <span class="fw-bold {{ $alat->stok < 5 ? 'text-rose-400' : 'text-slate-200' }}">
                                {{ $alat->stok }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.alat.edit', $alat->id) }}" class="btn-action-edit" title="Edit Data">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.alat.destroy', $alat->id) }}" method="POST" onsubmit="return confirm('Hapus alat ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action-delete" title="Hapus Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 custom-pagination">
        {{ $alats->links() }}
    </div>
</div>

<style>
    /* Global Utilities */
    .text-slate-500 { color: #64748b; }
    .bg-rose-500 { background-color: #f43f5e; }
    .bg-indigo-500 { background-color: #6366f1; }

    /* Button Tambah */
    .btn-indigo {
        background: #6366f1;
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
    }
    .btn-indigo:hover {
        background: #4f46e5;
        transform: translateY(-2px);
    }

    /* Alert */
    .alert-custom-success {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.2);
        color: #4ade80;
        padding: 14px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
    }

    /* Table Container */
    .table-container {
        background: #1e293b;
        border-radius: 16px;
        border: 1px solid #334155;
        overflow: hidden;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
    }

    .modern-table thead {
        background: rgba(15, 23, 42, 0.5);
    }

    .modern-table th {
        padding: 16px 20px;
        text-align: left;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        border-bottom: 1px solid #334155;
    }

    .modern-table td {
        padding: 16px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #334155;
    }

    .modern-table tr:last-child td { border-bottom: none; }

    .modern-table tr:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    /* Components */
    .badge-slate {
        background: #334155;
        color: #cbd5e1;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .stok-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    /* Action Buttons */
    .btn-action-edit, .btn-action-delete {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-action-edit {
        background: rgba(99, 102, 241, 0.1);
        color: #818cf8;
        border: 1px solid rgba(99, 102, 241, 0.2);
    }
    .btn-action-edit:hover {
        background: #6366f1;
        color: white;
    }

    .btn-action-delete {
        background: rgba(244, 63, 94, 0.1);
        color: #fb7185;
        border: 1px solid rgba(244, 63, 94, 0.2);
    }
    .btn-action-delete:hover {
        background: #f43f5e;
        color: white;
    }

    /* Icon size */
    .w-4 { width: 1rem; }
    .h-4 { height: 1rem; }
    .w-5 { width: 1.25rem; }
    .h-5 { height: 1.25rem; }
</style>
@endsection