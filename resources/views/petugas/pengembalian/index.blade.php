@extends('layouts.petugas')

@section('content')
<div class="container-fluid min-h-screen">
    
    @if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

    {{-- HEADER --}}
    <div class="mb-5">
        <h4 class="text-white fw-bold mb-1">📦 Validasi Pengembalian</h4>
        <p class="text-slate-500 small mb-0">
            Proses pengembalian alat dari peminjam.
        </p>
    </div>

    {{-- TABLE --}}
    <div class="table-container shadow-2xl">
        <table class="modern-table">
            <thead>
                <tr>
                    <th class="text-center" width="25%">Peminjam</th>
                    <th class="text-center" width="35%">Daftar Alat</th>
                    <th class="text-center" width="20%">Tanggal Pinjam</th>
                    <th class="text-center" width="20%">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peminjamans as $p)
                <tr>

                    {{-- PEMINJAM --}}
                    <td class="text-center">
                        <div class="font-black text-white mb-1" style="font-size: 16px;">
                            {{ strtoupper($p->user->name ?? 'USER TIDAK ADA') }}
                        </div>
                        <span class="badge-code">
                            {{ $p->kode_peminjaman }}
                        </span>
                    </td>

                    {{-- ALAT --}}
                    <td>
    <div class="tool-item">
        {{-- 🔥 FIX DISINI --}}
        {{ $p->alat->nama_alat ?? 'Alat tidak ditemukan' }}
        <span>x{{ $p->jumlah }}</span>
    </div>
</td>

                    {{-- TANGGAL --}}
                    <td class="text-center">
                        <div class="schedule-box">
                            <div class="small-label">Tanggal Pinjam</div>
                            <div class="date-value">
                                {{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') }}
                            </div>
                        </div>
                    </td>

                    {{-- AKSI --}}
                    <td class="text-center">
                        <div class="action-group">

                            {{-- DENDA --}}
                            <a href="{{ route('petugas.pengembalian.cek', $p->id) }}" 
                               class="btn-action btn-denda">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-width="2" d="M12 8c-2 0-4 1-4 3s2 3 4 3 4 1 4 3-2 3-4 3m0-12v12"/>
                                </svg>
                                <span>Denda</span>
                            </a>

                            {{-- SELESAI --}}
                            <form action="{{ route('petugas.pengembalian.konfirmasi', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-action btn-success"
                                    onclick="return confirm('Konfirmasi pengembalian alat?')">
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>

                                    <span>Selesai</span>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="4" class="text-center py-10">
                        <span class="text-slate-500 italic">
                            Tidak ada data pengembalian.
                        </span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<style>

/* TEXT */
.text-center { text-align: center !important; }
.font-black { font-weight: 900; }

/* TABLE */
.table-container {
    background: #1e293b;
    border-radius: 24px;
    border: 1px solid #334155;
    overflow: hidden;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
}

.modern-table th {
    background: rgba(15, 23, 42, 0.6);
    padding: 20px;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #64748b;
}

.modern-table td {
    padding: 24px;
    border-bottom: 1px solid #334155;
}

/* BADGE */
.badge-code {
    background: #0f172a;
    color: #818cf8;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 800;
    border: 1px solid #334155;
}

/* TOOL */
.tool-list-container {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.tool-item {
    display: flex;
    justify-content: space-between;
    background: rgba(30, 41, 59, 0.7);
    padding: 10px 14px;
    border-radius: 12px;
}

.tool-name {
    color: white;
    font-weight: 800;
}

.qty {
    color: #818cf8;
    font-weight: 900;
}

/* SCHEDULE */
.schedule-box {
    background: rgba(15, 23, 42, 0.4);
    padding: 12px;
    border-radius: 12px;
    border: 1px solid #334155;
}

.small-label {
    font-size: 9px;
    color: #64748b;
    text-transform: uppercase;
    font-weight: 800;
}

.date-value {
    font-size: 13px;
    color: white;
    font-weight: 900;
}

/* ACTION */
.action-group {
    display: flex;
    justify-content: center;
    gap: 10px;
}

/* BUTTON BASE */
.btn-action {
    display: flex;
    align-items: center;
    gap: 6px;

    padding: 10px 14px;
    border-radius: 14px;

    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;

    border: none;
    cursor: pointer;

    transition: 0.25s;
    position: relative;
}

/* ICON */
.icon {
    width: 16px;
    height: 16px;
}

/* DENDA */
.btn-denda {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
    color: white;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.btn-denda:hover {
    transform: translateY(-2px) scale(1.05);
}

/* SELESAI */
.btn-success {
    background: linear-gradient(135deg, #10b981, #34d399);
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-success:hover {
    transform: translateY(-2px) scale(1.05);
}

/* HOVER EFFECT */
.btn-action::after {
    content: '';
    position: absolute;
    inset: 0;
    background: white;
    opacity: 0;
    transition: 0.3s;
}

.btn-action:hover::after {
    opacity: 0.08;
}

</style>
@endsection