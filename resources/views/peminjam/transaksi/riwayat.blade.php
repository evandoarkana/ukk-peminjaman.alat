@extends('layouts.peminjam')

@section('content')
<div class="container-fluid min-h-screen">
    {{-- Header --}}
    <div class="mb-5">
        <h4 class="text-white fw-semibold mb-1">📜 Riwayat Peminjaman Saya</h4>
        <p class="text-slate-500 small mb-0 font-medium">Pantau status pengajuan dan jadwal pengembalian alat Anda secara real-time.</p>
    </div>

    {{-- Table Card --}}
    <div class="table-container shadow-2xl">
        <table class="modern-table">
            <thead>
                <tr>
                    <th width="25%">Kode & Tanggal</th>
                    <th width="35%">Daftar Alat</th>
                    <th width="20%" class="text-center">Status</th>
                    <th width="20%" class="text-end">Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $r)
                <tr>
                    <td>
                        <div class="text-white font-semibold mb-1" style="font-size: 15px; letter-spacing: 0.5px;">
                            {{ $r->kode_peminjaman }}
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <span class="text-slate-400" style="font-size: 11px;">
                                <i class="far fa-calendar-alt me-1"></i> Pinjam: {{ \Carbon\Carbon::parse($r->tgl_pinjam)->format('d M Y') }}
                            </span>
                            <span class="text-rose-400 font-medium" style="font-size: 11px;">
                                <i class="far fa-clock me-1"></i> Kembali: {{ \Carbon\Carbon::parse($r->tgl_kembali_rencana)->format('d M Y') }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="tool-list-box-student py-2 px-3">
                            <ul class="list-unstyled m-0" style="font-size: 13px;">
                                @foreach($r->detailPeminjaman as $detail)
                                <li class="text-slate-300 mb-1 d-flex justify-content-between">
                                    <span>{{ $detail->alat->nama_alat }}</span>
                                    <span class="text-indigo-400 fw-semibold">{{ $detail->jumlah }} Unit</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </td>
                    <td class="text-center">
                        @php
                            $statusClasses = [
                                'menunggu' => 'status-pill-amber',
                                'disetujui' => 'status-pill-emerald',
                                'ditolak'   => 'status-pill-rose',
                                'selesai'   => 'status-pill-indigo'
                            ];
                            $currentClass = $statusClasses[$r->status] ?? 'status-pill-slate';
                        @endphp
                        <span class="status-pill-base {{ $currentClass }}">
                            {{ $r->status }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="font-mono {{ $r->denda > 0 ? 'text-rose-400' : 'text-emerald-400' }}" style="font-size: 14px; font-weight: 700;">
                            Rp {{ number_format($r->denda, 0, ',', '.') }}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-10">
                        <div class="text-slate-700 mb-2">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <span class="text-slate-500 italic font-medium">Belum ada riwayat peminjaman yang tercatat.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Status Pill Styling */
    .status-pill-base {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid;
        display: inline-block;
    }

    .status-pill-amber { background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.3); color: #f59e0b; }
    .status-pill-emerald { background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3); color: #10b981; }
    .status-pill-rose { background: rgba(244, 63, 94, 0.1); border-color: rgba(244, 63, 94, 0.3); color: #f43f5e; }
    .status-pill-indigo { background: rgba(99, 102, 241, 0.1); border-color: rgba(99, 102, 241, 0.3); color: #818cf8; }
    .status-pill-slate { background: rgba(148, 163, 184, 0.1); border-color: rgba(148, 163, 184, 0.3); color: #94a3b8; }

    /* Tool List Box */
    .tool-list-box-student {
        background: rgba(15, 23, 42, 0.4);
        border: 1px solid #334155;
        border-radius: 10px;
    }

    /* Base UI Components */
    .table-container { background: #1e293b; border-radius: 20px; border: 1px solid #334155; overflow: hidden; }
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table th { background: #0f172a; padding: 18px 24px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #64748b; border-bottom: 2px solid #334155; }
    .modern-table td { padding: 18px 24px; vertical-align: middle; border-bottom: 1px solid #334155; }
    .modern-table tr:hover { background: rgba(255, 255, 255, 0.02); }

    .fw-semibold { font-weight: 600 !important; }
    .text-center { text-align: center !important; }
    .text-end { text-align: right !important; }
</style>
@endsection