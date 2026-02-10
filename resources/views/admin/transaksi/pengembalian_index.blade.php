@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Header Halaman --}}
    <div class="mb-5">
        <h4 class="text-white fw-bold mb-1">↩️ Riwayat Pengembalian</h4>
        <p class="text-slate-500 small mb-0">Catatan lengkap alat yang sudah dikembalikan ke inventaris.</p>
    </div>

    {{-- Tabel Card --}}
    <div class="table-container shadow-2xl">
        <table class="modern-table">
            <thead>
                <tr>
                    <th width="20%">Peminjam</th>
                    <th width="30%">Alat</th>
                    <th width="20%">Tgl Kembali</th>
                    <th width="15%">Denda</th>
                    <th width="15%">Petugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengembalians as $pk)
                <tr>
                    <td>
                        <div class="fw-bold text-white">{{ $pk->peminjaman->user->name }}</div>
                        <div class="text-[10px] text-slate-500 font-mono mt-1 uppercase">Selesai</div>
                    </td>
                    <td>
                        <div class="text-slate-200 font-medium">{{ $pk->peminjaman->alat->nama_alat }}</div>
                    </td>
                    <td class="text-slate-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ \Carbon\Carbon::parse($pk->tgl_kembali_aktual)->format('d M Y') }}
                        </div>
                    </td>
                    <td>
                        @if($pk->denda > 0)
                            <div class="denda-badge-late">
                                Rp {{ number_format($pk->denda, 0, ',', '.') }}
                            </div>
                        @else
                            <div class="denda-badge-safe">
                                Rp 0
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="petugas-tag">
                            <div class="petugas-avatar">
                                {{ strtoupper(substr($pk->petugas->name, 0, 1)) }}
                            </div>
                            <span>{{ $pk->petugas->name }}</span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-10 text-slate-500 italic">
                        Belum ada riwayat pengembalian yang tercatat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-5 custom-pagination">
        {{ $pengembalians->links() }}
    </div>
</div>

<style>
    /* Denda Badges */
    .denda-badge-late {
        background: rgba(244, 63, 94, 0.1);
        color: #fb7185;
        border: 1px solid rgba(244, 63, 94, 0.2);
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 13px;
        display: inline-block;
    }

    .denda-badge-safe {
        background: rgba(34, 197, 94, 0.1);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.2);
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 13px;
        display: inline-block;
    }

    /* Petugas Tag */
    .petugas-tag {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #0f172a;
        padding: 5px 10px;
        border-radius: 10px;
        border: 1px solid #334155;
        width: fit-content;
    }

    .petugas-avatar {
        width: 20px;
        height: 20px;
        background: #6366f1;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 9px;
        font-weight: 900;
    }

    .petugas-tag span {
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
    }

    /* Reusable Table Styles */
    .table-container { background: #1e293b; border-radius: 16px; border: 1px solid #334155; overflow: hidden; }
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table th { background: rgba(15, 23, 42, 0.5); padding: 18px 24px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #94a3b8; border-bottom: 1px solid #334155; }
    .modern-table td { padding: 18px 24px; vertical-align: middle; border-bottom: 1px solid #334155; }
    .modern-table tr:hover { background: rgba(255, 255, 255, 0.02); }
    
    .w-4 { width: 1rem; }
    .h-4 { height: 1rem; }
</style>
@endsection