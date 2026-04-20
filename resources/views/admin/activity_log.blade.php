@extends('layouts.admin')

@section('content')

<style>
    body {
        background: #0f172a;
    }

    .log-container {
        background: #1e293b;
        border-radius: 16px;
        border: 1px solid #334155;
        overflow: hidden;
    }

    .log-header h4 {
        color: #f8fafc;
        font-weight: 800;
        margin: 0;
    }

    .log-header p {
        color: #94a3b8;
        font-size: 13px;
        margin: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #020617;
        border-bottom: 1px solid #334155;
    }

    th {
        padding: 14px;
        text-align: left;
        font-size: 11px;
        text-transform: uppercase;
        color: #818cf8;
        letter-spacing: 1px;
    }

    tbody tr {
        border-bottom: 1px solid #334155;
        transition: 0.2s;
    }

    tbody tr:hover {
        background: rgba(99, 102, 241, 0.05);
    }

    td {
        padding: 14px;
        font-size: 13px;
        color: #cbd5e1;
    }

    .user-name {
        font-weight: 600;
        color: #f8fafc;
    }

    .badge-log {
        background: rgba(99, 102, 241, 0.15);
        color: #818cf8;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .ip-text {
        color: #64748b;
        font-size: 12px;
        font-family: monospace;
    }

    .empty {
        text-align: center;
        padding: 40px;
        color: #64748b;
    }

    /* Pagination dark */
    .pagination {
        --bs-pagination-bg: #1e293b;
        --bs-pagination-border-color: #334155;
        --bs-pagination-color: #000000;
        --bs-pagination-hover-bg: #6366f1;
        --bs-pagination-hover-color: white;
        --bs-pagination-active-bg: #6366f1;
        --bs-pagination-active-border-color: #6366f1;
    }
</style>

<div class="container-fluid px-4" style="margin-top: 25px;">

    {{-- Header --}}
    <div class="log-header mb-4">
        <h4>📊 Log Aktivitas Sistem</h4>
        <p>Rekaman jejak aktivitas pengguna dalam sistem persewaan alat.</p>
    </div>

    {{-- Table --}}
    <div class="log-container">
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aktivitas</th>
                    <th>Deskripsi</th>
                    <th>IP Address</th>
                </tr>
            </thead>

            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>

                    <td class="user-name">
                        {{ $log->user->name ?? 'System' }}
                    </td>

                    <td>
                        <span class="badge-log">
                            {{ $log->aktivitas }}
                        </span>
                    </td>

                    <td>{{ $log->deskripsi }}</td>

                    <td class="ip-text">
                        {{ $log->ip_address }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty">
                        Belum ada aktivitas yang tercatat dalam sistem.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $logs->links() }}
    </div>

</div>

@endsection