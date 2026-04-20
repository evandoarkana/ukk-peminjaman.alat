@extends('layouts.petugas')

@section('content')
<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="topbar">
        <div>
            <h2>Persetujuan Peminjaman</h2>
            <p>Validasi peminjaman alat laboratorium secara real-time</p>
        </div>

        <div class="status-live">
            <span class="dot"></span>
            ACTIVE SYSTEM
        </div>
    </div>

    {{-- GRID --}}
    <div class="grid">

        @forelse($peminjamans ?? [] as $p)

        <div class="card">

            {{-- CARD HEADER --}}
            <div class="card-header">

                <div class="user">
                    <div class="avatar">
                        {{ strtoupper(substr($p->user->name ?? 'U',0,1)) }}
                    </div>

                    <div>
                        <div class="name">
                            {{ $p->user->name ?? 'Unknown User' }}
                        </div>
                        <div class="code">
                            {{ $p->kode_peminjaman ?? '-' }}
                        </div>
                    </div>
                </div>

                <span class="badge">PENDING</span>
            </div>

            {{-- BODY --}}
            <div class="card-body">

                {{-- ALAT --}}
                <div class="section">
                    <h5>DAFTAR ALAT</h5>

                    @foreach($p->detailPeminjaman ?? [] as $detail)
                        <div class="tool">
                            <span>{{ $detail->alat->nama_alat ?? '-' }}</span>
                            <b>{{ $detail->jumlah ?? 0 }} pcs</b>
                        </div>
                    @endforeach
                </div>

                {{-- TANGGAL --}}
                <div class="section">
                    <h5>JADWAL</h5>

                    <div class="date-box">
                        <div>
                            <small>PINJAM</small>
                            <p>{{ $p->tgl_pinjam ?? '-' }}</p>
                        </div>

                        <div class="line"></div>

                        <div>
                            <small>KEMBALI</small>
                            <p class="danger">{{ $p->tgl_kembali_rencana ?? '-' }}</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ACTION --}}
            <div class="card-footer">

                <form action="{{ route('petugas.peminjaman.setujui', $p->id) }}" method="POST">
                    @csrf
                    <button class="btn-approve">SETUJUI</button>
                </form>

                <form action="{{ route('petugas.peminjaman.tolak', $p->id) }}" method="POST">
                    @csrf
                    <button class="btn-reject">TOLAK</button>
                </form>

            </div>

        </div>

        @empty
        <div class="empty">
            <h3>Tidak ada peminjaman</h3>
        </div>
        @endforelse

    </div>

</div>

{{-- STYLE --}}
<style>

body {
    background: #0b1220;
    font-family: 'Segoe UI', sans-serif;
}

.page-wrapper {
    padding: 30px;
}

.topbar {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.topbar h2 {
    color:white;
    margin:0;
}

.topbar p {
    color:#94a3b8;
    margin:5px 0 0;
}

.status-live {
    background:#111827;
    padding:10px 15px;
    border-radius:999px;
    color:#22c55e;
    font-weight:600;
    display:flex;
    align-items:center;
    gap:8px;
}

.dot {
    width:8px;
    height:8px;
    background:#22c55e;
    border-radius:50%;
    animation:pulse 1.5s infinite;
}

@keyframes pulse {
    0% { transform:scale(1); opacity:1; }
    50% { transform:scale(1.5); opacity:0.5; }
    100% { transform:scale(1); opacity:1; }
}

.grid {
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(340px,1fr));
    gap:20px;
}

.card {
    background: rgba(17,24,39,0.9);
    border:1px solid rgba(255,255,255,0.05);
    border-radius:18px;
    overflow:hidden;
    transition:.3s;
}

.card:hover {
    transform:translateY(-5px);
    border-color:#6366f1;
}

.card-header {
    display:flex;
    justify-content:space-between;
    padding:18px;
    border-bottom:1px solid rgba(255,255,255,0.05);
}

.user {
    display:flex;
    gap:12px;
    align-items:center;
}

.avatar {
    width:45px;
    height:45px;
    background:linear-gradient(135deg,#6366f1,#a855f7);
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-weight:bold;
}

.name {
    color:white;
    font-weight:600;
}

.code {
    color:#94a3b8;
    font-size:12px;
}

.badge {
    background:#f59e0b20;
    color:#f59e0b;
    padding:6px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
}

.card-body {
    padding:18px;
}

.section h5 {
    color:#94a3b8;
    font-size:11px;
    letter-spacing:1px;
    margin-bottom:10px;
}

.tool {
    display:flex;
    justify-content:space-between;
    padding:10px;
    background:#0f172a;
    border-radius:10px;
    margin-bottom:8px;
    color:white;
}

.date-box {
    background:#0f172a;
    padding:12px;
    border-radius:12px;
    color:white;
}

.date-box small {
    color:#94a3b8;
}

.danger {
    color:#fb7185;
}

.line {
    height:1px;
    background:#1f2937;
    margin:8px 0;
}

.card-footer {
    display:flex;
    gap:10px;
    padding:15px;
    background:#0b1220;
}

.btn-approve {
    width:100%;
    padding:10px;
    background:#22c55e;
    border:none;
    border-radius:10px;
    color:white;
    font-weight:700;
    cursor:pointer;
}

.btn-reject {
    width:100%;
    padding:10px;
    background:transparent;
    border:1px solid #ef4444;
    border-radius:10px;
    color:#ef4444;
    font-weight:700;
    cursor:pointer;
}

.empty {
    color:white;
    text-align:center;
    padding:50px;
}

</style>
@endsection