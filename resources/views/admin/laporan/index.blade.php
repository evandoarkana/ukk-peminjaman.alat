@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="fw-bold text-white mb-1">📊 Laporan Peminjaman</h4>
        <p class="text-slate-400 small mb-0">
            Rekap pengembalian alat & total denda
        </p>
    </div>

    {{-- FILTER --}}
    <div class="card-dark shadow-lg mb-4 p-4">
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="row g-3 align-items-end">

            <div class="col-md-3">
                <label class="label-custom">Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" class="input-dark" value="{{ request('tgl_mulai') }}">
            </div>

            <div class="col-md-3">
                <label class="label-custom">Tanggal Selesai</label>
                <input type="date" name="tgl_selesai" class="input-dark" value="{{ request('tgl_selesai') }}">
            </div>

            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn-primary-custom w-100">Filter</button>
                <a href="{{ route('admin.laporan.cetak', request()->all()) }}" class="btn-danger-custom w-100">
                    Cetak PDF
                </a>
            </div>

        </form>
    </div>

    {{-- TABLE --}}
    <div class="card-dark shadow-lg overflow-hidden">

        <table class="table-modern w-full">

            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Peminjam</th>
                    <th>Alat</th>
                    <th class="text-center">Pinjam</th>
                    <th class="text-center">Kembali</th>
                    <th class="text-end">Denda</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>

            <tbody>
                @php $totalDenda = 0; @endphp

                @forelse($laporans as $l)
                <tr>

                    {{-- KODE --}}
                    <td>
                        <span class="badge-code">
                            {{ $l->kode_peminjaman }}
                        </span>
                    </td>

                    {{-- USER --}}
                    <td>
                        <div class="text-white fw-bold">
                            {{ $l->user->name ?? '-' }}
                        </div>
                        <small class="text-slate-500">
                            ID: {{ $l->user_id }}
                        </small>
                    </td>

                    {{-- ALAT --}}
                    <td>
                        <div class="text-white">
                            {{ $l->alat->nama_alat ?? '-' }}
                        </div>
                        <small class="text-slate-500">
                            {{ $l->alat && $l->alat->kategori ? $l->alat->kategori->nama_kategori : '-' }}
                        </small>
                    </td>

                    {{-- PINJAM --}}
                    <td class="text-center">
                        <div class="date-box">
                            {{ \Carbon\Carbon::parse($l->tgl_pinjam)->format('d M Y') }}
                        </div>
                    </td>

                    {{-- KEMBALI --}}
                    <td class="text-center">
                        @if($l->tgl_kembali_real)
                            <div class="date-box success">
                                {{ \Carbon\Carbon::parse($l->tgl_kembali_real)->format('d M Y') }}
                            </div>
                        @else
                            <span class="text-slate-500 italic">Belum</span>
                        @endif
                    </td>

                    {{-- DENDA --}}
                    <td class="text-end fw-bold">
                        <span class="{{ $l->denda > 0 ? 'text-warning' : 'text-slate-500' }}">
                            Rp {{ number_format($l->denda) }}
                        </span>
                    </td>

                    {{-- STATUS --}}
                    <td class="text-center">
                        @if($l->status == 'selesai')
                            <span class="badge-status done">SELESAI</span>
                        @elseif($l->status == 'disetujui')
                            <span class="badge-status approved">DIPINJAM</span>
                        @else
                            <span class="badge-status pending">
                                {{ strtoupper($l->status) }}
                            </span>
                        @endif
                    </td>

                </tr>

                @php $totalDenda += $l->denda; @endphp

                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-slate-500">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>

            {{-- TOTAL --}}
            @if($laporans->count())
            <tfoot>
                <tr>
                    <td colspan="5" class="text-end text-slate-400 fw-bold">
                        Total Denda
                    </td>
                    <td class="text-end text-success fw-bold">
                        Rp {{ number_format($totalDenda) }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
            @endif

        </table>

    </div>

</div>

<style>

/* CARD */
.card-dark {
    background: #0f172a;
    border-radius: 18px;
    border: 1px solid #1e293b;
}

/* TABLE */
.table-modern {
    width: 100%;
    border-collapse: collapse;
}

.table-modern th {
    background: rgba(30,41,59,0.5);
    padding: 16px;
    font-size: 11px;
    text-transform: uppercase;
    color: #64748b;
}

.table-modern td {
    padding: 16px;
    border-bottom: 1px solid #1e293b;
}

/* BADGE */
.badge-code {
    background: #020617;
    color: #818cf8;
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 800;
}

/* STATUS */
.badge-status {
    padding: 5px 10px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 800;
}

.done { background: #10b981; color: white; }
.approved { background: #3b82f6; color: white; }
.pending { background: #facc15; color: black; }

/* DATE */
.date-box {
    background: rgba(15,23,42,0.5);
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 12px;
    color: #cbd5f5;
}

.date-box.success {
    color: #34d399;
}

/* INPUT */
.input-dark {
    background: #020617;
    border: 1px solid #1e293b;
    color: white;
    padding: 8px;
    border-radius: 8px;
}

/* BUTTON */
.btn-primary-custom {
    background: #3b82f6;
    color: white;
    border-radius: 8px;
    padding: 10px;
    border: none;
}

.btn-danger-custom {
    background: #ef4444;
    color: white;
    border-radius: 8px;
    padding: 10px;
    text-align: center;
}

</style>
@endsection