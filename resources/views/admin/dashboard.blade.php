@extends('layouts.admin')

@section('content')
<style>
    /* Menggunakan palet warna Slate & Indigo yang lebih modern */
    body {
        background: #0f172a; /* Slate 900 */
    }

    .card-box {
        background: #1e293b; /* Slate 800 */
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transition: all .3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #334155;
        position: relative;
        overflow: hidden;
    }

    /* Aksen garis di atas card agar lebih elegan */
    .card-box::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #6366f1, #a855f7); /* Indigo to Purple */
    }

    .card-box:hover {
        transform: translateY(-5px);
        border-color: #6366f1;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
    }

    .stat-title {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8; /* Slate 400 */
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: #f8fafc; /* Slate 50 */
    }

    .sub-text {
        color: #64748b; /* Slate 500 */
        font-size: 12.5px;
    }

    .section-card {
        background: #1e293b;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #334155;
    }

    .table-dark-custom {
        margin-top: 10px;
    }

    .table-dark-custom tr {
        border-bottom: 1px solid #334155;
    }

    .table-dark-custom tr:last-child {
        border-bottom: none;
    }

    .table-dark-custom tr:hover {
        background: rgba(99, 102, 241, 0.05);
    }

    .table-dark-custom td {
        padding: 16px 8px;
        color: #cbd5e1;
        font-size: 14px;
    }

    .link-indigo {
        color: #818cf8;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s;
    }

    .link-indigo:hover {
        color: #6366f1;
        text-decoration: underline;
    }

    /* Box Stok Menipis dengan warna Rose/Red yang lebih "Alert" */
    .danger-box {
        background: #1e293b;
        border: 1px solid #471719;
        border-left: 4px solid #f43f5e; /* Rose 500 */
        border-radius: 16px;
        padding: 24px;
    }

    .danger-title {
        color: #fb7185; /* Rose 400 */
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Paksa semua background utama jadi dark */
body, .container-fluid {
    background-color: #0f172a !important;
}

/* FIX TABLE biar gak putih */
.table {
    background: transparent !important;
    color: #e2e8f0;
}

.table td, .table th {
    background: transparent !important;
    border-color: #334155 !important;
}

/* Hilangkan putih di Bootstrap */
.bg-white {
    background-color: #1e293b !important;
}

/* Badge biar lebih soft */
.badge.bg-danger {
    background-color: #be123c !important;
}

.badge.bg-warning {
    background-color: #d97706 !important;
    color: white;
}

/* Link default bootstrap */
a {
    color: #818cf8;
}

/* Scrollbar biar dark juga */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-thumb {
    background: #334155;
    border-radius: 10px;
}

</style>

<div class="container-fluid px-4 py-4">

    {{-- Header --}}
    <div class="mb-5">
        <h3 style="color:#f8fafc; font-weight:800; letter-spacing: -0.5px;">Dashboard Overview</h3>
        <p class="sub-text">
            Sistem Informasi Inventaris — <span style="color:#818cf8;">{{ auth()->user()->name }}</span>
        </p>
    </div>

    {{-- Statistik --}}
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card-box">
                <div class="stat-title">Total Inventaris</div>
                <div class="stat-value">{{ $total_alat }}</div>
                <div class="sub-text">Item terdaftar</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box">
                <div class="stat-title">Menunggu Persetujuan</div>
                <div class="stat-value text-warning">{{ $pinjam_menunggu }}</div>
                <div class="sub-text">Perlu tindakan</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box">
                <div class="stat-title">Pinjaman Aktif</div>
                <div class="stat-value" style="color:#22c55e;">{{ $pinjam_aktif }}</div>
                <div class="sub-text">Sedang digunakan</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box">
                <div class="stat-title">Total Kas Denda</div>
                <div class="stat-value">
                    <small style="font-size: 14px; color: #94a3b8;">Rp</small> {{ number_format($total_denda, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Log Aktivitas --}}
        <div class="col-lg-8">
            <div class="section-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 style="color:#f8fafc; font-weight:700; margin:0;">Log Aktivitas Terbaru</h6>
                    <a href="{{ route('admin.log.index') }}" class="link-indigo" style="font-size: 13px;">Lihat Semua →</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-dark-custom mb-0">
                        @foreach($recent_logs as $log)
                        <tr>
                            <td style="font-weight:600; color: #f8fafc;">
                                {{ $log->user->name }}
                            </td>
                            <td>{{ $log->deskripsi }}</td>
                            <td class="text-end sub-text">
                                {{ $log->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        {{-- Stok Menipis --}}
        <div class="col-lg-4">
            <div class="danger-box h-100">
                <h6 class="danger-title mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                    Stok Menipis
                </h6>

                <ul class="list-unstyled mb-0">
                    @php $alats = \App\Models\Alat::where('stok', '<', 5)->get(); @endphp
                    @forelse($alats as $a)
                        <li class="d-flex justify-content-between align-items-center mb-3 p-2" style="background: rgba(244, 63, 94, 0.05); border-radius: 8px;">
                            <span style="color:#e2e8f0; font-size: 14px;">{{ $a->nama_alat }}</span>
                            <span class="badge bg-danger rounded-pill">
                                {{ $a->stok }}
                            </span>
                        </li>
                    @empty
                        <li class="sub-text text-center py-4">Semua stok terpantau aman.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection