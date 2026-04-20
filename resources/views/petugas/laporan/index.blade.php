@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h5 class="text-white fw-semibold mb-1">Laporan Peminjaman</h5>
        <p class="text-slate-500 small mb-0">
            Rekap transaksi peminjaman dan pengembalian
        </p>
    </div>

    {{-- FILTER --}}
    <div class="card-filter mb-4">
        <form method="GET" class="row g-3 align-items-end">

            <div class="col-md-3">
                <label class="label">Tanggal Mulai</label>
                <input type="date" name="tgl_mulai"
                       class="input"
                       value="{{ request('tgl_mulai') }}">
            </div>

            <div class="col-md-3">
                <label class="label">Tanggal Selesai</label>
                <input type="date" name="tgl_selesai"
                       class="input"
                       value="{{ request('tgl_selesai') }}">
            </div>

            <div class="col-md-6 d-flex gap-2">
                <button type="submit" class="btn-primary w-100">
                    Filter
                </button>

                <a href="{{ route('petugas.laporan.cetak', request()->all()) }}"
                   class="btn-outline w-100">
                    Cetak PDF
                </a>
            </div>

        </form>
    </div>

    {{-- TABLE --}}
    <div class="table-wrapper">
        <table class="table-modern w-100">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Peminjam</th>
                    <th>Alat</th>
                    <th>Tanggal Pinjam</th>
                    <th class="text-end">Denda</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>

            <tbody>
                @php $total = 0; @endphp

                @forelse($laporans as $l)
                <tr>
                    <td class="font-mono text-slate-300">
                        {{ $l->kode_peminjaman }}
                    </td>

                    <td class="text-white">
                        {{ $l->user->name ?? '-' }}
                    </td>

                    <td class="text-slate-300">
                        {{ $l->alat->nama_alat ?? '-' }}
                    </td>

                    <td class="text-slate-400">
                        {{ \Carbon\Carbon::parse($l->tgl_pinjam)->format('d M Y') }}
                    </td>

                    <td class="text-end {{ $l->denda > 0 ? 'text-amber-400' : 'text-slate-500' }}">
                        Rp {{ number_format($l->denda) }}
                    </td>

                    <td class="text-center">
                        <span class="status {{ strtolower($l->status) }}">
                            {{ $l->status }}
                        </span>
                    </td>
                </tr>

                @php $total += $l->denda; @endphp

                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-slate-500">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>

            @if(!$laporans->isEmpty())
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end text-slate-500 small">
                        Total Denda
                    </td>
                    <td class="text-end text-white fw-semibold">
                        Rp {{ number_format($total) }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
            @endif

        </table>
    </div>

</div>

<style>

/* FILTER CARD */
.card-filter {
    background: #1e293b;
    padding: 16px;
    border-radius: 10px;
    border: 1px solid #334155;
}

/* LABEL */
.label {
    font-size: 11px;
    color: #94a3b8;
    display: block;
    margin-bottom: 4px;
}

/* INPUT */
.input {
    width: 100%;
    background: #0f172a;
    border: 1px solid #334155;
    color: white;
    padding: 8px;
    border-radius: 6px;
}

/* BUTTON */
.btn-primary {
    background: #6366f1;
    border: none;
    color: white;
    padding: 8px;
    border-radius: 6px;
    font-weight: 600;
}

.btn-outline {
    border: 1px solid #334155;
    color: #cbd5f5;
    padding: 8px;
    border-radius: 6px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
}

/* TABLE WRAPPER */
.table-wrapper {
    background: #1e293b;
    border-radius: 10px;
    border: 1px solid #334155;
    overflow: hidden;
}

/* TABLE */
.table-modern {
    width: 100%;
    border-collapse: collapse;
}

.table-modern th {
    background: #0f172a;
    color: #64748b;
    font-size: 11px;
    padding: 12px;
    text-align: left;
    text-transform: uppercase;
}

.table-modern td {
    padding: 12px;
    border-bottom: 1px solid #334155;
}

/* STATUS */
.status {
    font-size: 10px;
    padding: 4px 8px;
    border-radius: 6px;
    text-transform: uppercase;
}

/* STATUS COLORS */
.status.selesai {
    background: #10b981;
    color: white;
}

.status.disetujui {
    background: #3b82f6;
    color: white;
}

.status.menunggu {
    background: #f59e0b;
    color: white;
}

.status.ditolak {
    background: #ef4444;
    color: white;
}

</style>
@endsection