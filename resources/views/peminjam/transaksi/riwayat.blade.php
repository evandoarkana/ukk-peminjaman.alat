@extends('layouts.peminjam')

@section('content')
<div class="container-fluid min-h-screen">

    {{-- Header --}}
    <div class="mb-5">
        <h4 class="text-white fw-semibold mb-1">📜 Riwayat Peminjaman Saya</h4>
        <p class="text-slate-500 small mb-0 font-medium">
            Pantau status pengajuan dan jadwal pengembalian alat Anda.
        </p>
    </div>

    {{-- Table --}}
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

                    {{-- KODE & TANGGAL --}}
                    <td>
                        <div class="text-white font-semibold mb-1" style="font-size: 15px;">
                            {{ $r->kode_peminjaman }}
                        </div>

                        <div class="d-flex flex-column gap-1">
                            <span class="text-slate-400" style="font-size: 11px;">
                                Pinjam: {{ \Carbon\Carbon::parse($r->tgl_pinjam)->format('d M Y') }}
                            </span>

                            <span class="text-rose-400" style="font-size: 11px;">
                                Kembali: {{ \Carbon\Carbon::parse($r->tgl_kembali_rencana)->format('d M Y') }}
                            </span>
                        </div>
                    </td>

                    {{-- 🔥 DATA ALAT (FIX UTAMA) --}}
                    <td>
                        <div class="tool-list-box-student py-2 px-3">
                            <ul class="list-unstyled m-0" style="font-size: 13px;">
                                <li class="text-slate-300 mb-1 d-flex justify-content-between">
                                    <span>{{ $r->alat->nama_alat ?? 'Alat tidak ditemukan' }}</span>
                                    <span class="text-indigo-400 fw-semibold">
                                        {{ $r->jumlah }} Unit
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </td>

                    {{-- STATUS --}}
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

                    {{-- DENDA --}}
                    <td class="text-end">
                        <div class="font-mono {{ ($r->denda ?? 0) > 0 ? 'text-rose-400' : 'text-emerald-400' }}" style="font-size: 14px; font-weight: 700;">
                            Rp {{ number_format($r->denda ?? 0, 0, ',', '.') }}
                        </div>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="4" class="text-center py-10">
                        <span class="text-slate-500 italic">
                            Belum ada riwayat peminjaman.
                        </span>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

<style>
/* TABLE */
.table-container {
    background: #1e293b;
    border-radius: 20px;
    border: 1px solid #334155;
    overflow: hidden;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
}

.modern-table th {
    background: #0f172a;
    padding: 18px 24px;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #64748b;
    border-bottom: 2px solid #334155;
}

.modern-table td {
    padding: 18px 24px;
    border-bottom: 1px solid #334155;
}

/* TOOL BOX */
.tool-list-box-student {
    background: rgba(15, 23, 42, 0.4);
    border: 1px solid #334155;
    border-radius: 10px;
}

/* STATUS */
.status-pill-base {
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    border: 1px solid;
}

.status-pill-amber { color: #f59e0b; border-color: #f59e0b33; }
.status-pill-emerald { color: #10b981; border-color: #10b98133; }
.status-pill-rose { color: #ef4444; border-color: #ef444433; }
.status-pill-indigo { color: #6366f1; border-color: #6366f133; }
.status-pill-slate { color: #94a3b8; border-color: #94a3b833; }

.text-center { text-align: center; }
.text-end { text-align: right; }
</style>
@endsection