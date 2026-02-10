@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h4 class="text-white fw-bold mb-1">🏷️ Manajemen Kategori</h4>
            <p class="text-slate-500 small mb-0">Organisir pengelompokan alat inventaris Anda.</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}" class="btn-indigo">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Kategori Baru
        </a>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="alert-custom-success">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert-custom-danger">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Card Table --}}
    <div class="table-container">
        <table class="modern-table">
            <thead>
                <tr>
                    <th width="10%">NO</th>
                    <th width="70%">NAMA KATEGORI</th>
                    <th width="20%" class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $kategori)
                <tr>
                    <td class="text-slate-500 font-mono">{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-bold text-white">{{ $kategori->nama_kategori }}</div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="btn-action-edit" title="Edit Kategori">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action-delete" title="Hapus Kategori">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-5 text-slate-500 italic">Belum ada data kategori.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Utility */
    .text-slate-500 { color: #64748b; }
    
    /* Tombol Indigo */
    .btn-indigo {
        background: #6366f1;
        color: white;
        padding: 10px 22px;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        font-size: 14px;
    }
    .btn-indigo:hover {
        background: #4f46e5;
        transform: translateY(-2px);
        color: white;
    }

    /* Aler Kustom */
    .alert-custom-success, .alert-custom-danger {
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        font-size: 14px;
        border: 1px solid;
    }
    .alert-custom-success {
        background: rgba(34, 197, 94, 0.1);
        border-color: rgba(34, 197, 94, 0.2);
        color: #4ade80;
    }
    .alert-custom-danger {
        background: rgba(244, 63, 94, 0.1);
        border-color: rgba(244, 63, 94, 0.2);
        color: #fb7185;
    }

    /* Kontainer Tabel */
    .table-container {
        background: #1e293b;
        border-radius: 16px;
        border: 1px solid #334155;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
    }

    .modern-table th {
        background: rgba(15, 23, 42, 0.5);
        padding: 18px 24px;
        text-align: left;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #94a3b8;
        border-bottom: 1px solid #334155;
    }

    .modern-table td {
        padding: 18px 24px;
        vertical-align: middle;
        border-bottom: 1px solid #334155;
    }

    .modern-table tr:last-child td { border-bottom: none; }
    .modern-table tr:hover { background: rgba(255, 255, 255, 0.02); }

    /* Tombol Aksi */
    .btn-action-edit, .btn-action-delete {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s ease;
        border: 1px solid;
    }

    .btn-action-edit {
        background: rgba(99, 102, 241, 0.1);
        color: #818cf8;
        border-color: rgba(99, 102, 241, 0.2);
    }
    .btn-action-edit:hover { background: #6366f1; color: white; }

    .btn-action-delete {
        background: rgba(244, 63, 94, 0.1);
        color: #fb7185;
        border-color: rgba(244, 63, 94, 0.2);
    }
    .btn-action-delete:hover { background: #f43f5e; color: white; }

    /* SVG Sizing */
    .w-4 { width: 1rem; }
    .h-4 { height: 1rem; }
    .w-5 { width: 1.25rem; }
    .h-5 { height: 1.25rem; }
</style>
@endsection