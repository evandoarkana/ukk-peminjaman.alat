@extends('layouts.peminjam')

@section('content')
<div class="container-fluid min-h-screen">

    {{-- HEADER --}}
    <div class="mb-5">
        <h4 class="text-white fw-bold mb-1">📦 Pengembalian Alat</h4>
        <p class="text-slate-500 small mb-0">
            Daftar alat yang sedang kamu pinjam
        </p>
    </div>

    <div class="grid gap-4">

        @forelse($pinjamanAktif as $p)

        <div class="card-return shadow-lg">

            <div class="d-flex justify-content-between align-items-start">

                <div>

                    {{-- STATUS --}}
                    <div class="status-badge mb-2">
                        ● Sedang Dipinjam
                    </div>

                    {{-- KODE --}}
                    <div class="kode">
                        {{ $p->kode_peminjaman }}
                    </div>

                    {{-- TANGGAL --}}
                    <div class="tanggal">
                        Kembali:
                        <span class="text-danger">
                            {{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d M Y') }}
                        </span>
                    </div>

                </div>

            </div>

            {{-- LIST ALAT --}}
            <div class="alat-box mt-3">
                @foreach($p->detailPeminjaman as $d)
                    <div class="alat-item">
                        <span>{{ $d->alat->nama_alat ?? '-' }}</span>
                        <b>x{{ $d->jumlah }}</b>
                    </div>
                @endforeach
            </div>

        </div>

        @empty
        <div class="text-center text-slate-400 py-5">
            Tidak ada alat yang sedang dipinjam
        </div>
        @endforelse

    </div>

</div>

<style>

/* CARD */
.card-return {
    background: #0f172a;
    border-radius: 18px;
    padding: 20px;
    border: 1px solid #1e293b;
}

/* STATUS */
.status-badge {
    color: #22c55e;
    font-size: 12px;
    font-weight: 700;
}

/* KODE */
.kode {
    color: #818cf8;
    font-weight: 800;
    font-size: 14px;
}

/* TANGGAL */
.tanggal {
    color: #94a3b8;
    font-size: 12px;
}

/* ALAT */
.alat-box {
    background: rgba(15,23,42,0.5);
    border-radius: 12px;
    padding: 10px;
}

.alat-item {
    display: flex;
    justify-content: space-between;
    color: white;
    padding: 6px 0;
    border-bottom: 1px solid #1e293b;
}

.alat-item:last-child {
    border-bottom: none;
}

</style>
@endsection