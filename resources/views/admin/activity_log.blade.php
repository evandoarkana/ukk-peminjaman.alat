@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: 'Segoe UI', sans-serif;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight: 700; color: #333; margin: 0;">📊 Log Aktivitas Sistem</h4>
            <p style="color: #718096; font-size: 0.9rem; margin: 0;">Rekaman jejak aktivitas pengguna dalam sistem
                persewaan alat.</p>
        </div>
    </div>

    <div
        style="background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e3e6f0;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #f8f9fc; border-bottom: 2px solid #e3e6f0;">
                <tr>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Waktu</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        User</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Aktivitas</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Deskripsi</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        IP Address</th>
                </tr>
            </thead>
            <tbody>
                {{-- Menggunakan @forelse untuk menangani kondisi jika data log masih kosong [cite: 63] --}}
                @forelse($logs as $log)
                <tr style="border-bottom: 1px solid #e3e6f0;">
                    <td style="padding: 15px; font-size: 13px; color: #6e707e;">
                        {{ $log->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td style="padding: 15px; font-weight: 600; color: #3a3b45;">
                        {{ $log->user->name ?? 'System' }}
                    </td>
                    <td style="padding: 15px;">
                        <span class="badge"
                            style="background: #eef2ff; color: #4338ca; padding: 5px 10px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                            {{ $log->aktivitas }}
                        </span>
                    </td>
                    <td style="padding: 15px; color: #666; font-size: 13px;">
                        {{ $log->deskripsi }}
                    </td>
                    <td style="padding: 15px; color: #999; font-size: 11px; font-family: monospace;">
                        {{ $log->ip_address }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #a0aec0;">
                        Belum ada aktivitas yang tercatat dalam sistem[cite: 62].
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Navigasi Pagination untuk efisiensi data besar [cite: 58] --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $logs->links() }}
    </div>
</div>
@endsection