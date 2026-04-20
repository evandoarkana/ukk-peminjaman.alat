@extends('layouts.petugas')

@section('content')

<style>
    .card-denda {
        background: #1e293b;
        border-radius: 16px;
        padding: 30px;
        border: 1px solid #334155;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        position: relative;
        overflow: hidden;
    }

    /* Glow atas */
    .card-denda::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #22c55e, #4ade80);
    }

    .info-box {
        background: #020617;
        border: 1px solid #334155;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 12px;
    }

    .info-title {
        color: #94a3b8;
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .info-value {
        color: #f8fafc;
        font-weight: 600;
        font-size: 14px;
    }

    .input-denda {
        width: 100%;
        padding: 12px;
        background: #020617;
        border: 1px solid #334155;
        color: white;
        border-radius: 10px;
        transition: 0.3s;
    }

    .input-denda:focus {
        border-color: #22c55e;
        box-shadow: 0 0 0 3px rgba(34,197,94,0.2);
        outline: none;
    }

    .btn-submit {
        margin-top: 20px;
        background: linear-gradient(90deg, #22c55e, #4ade80);
        border: none;
        padding: 12px;
        border-radius: 10px;
        color: white;
        font-weight: 700;
        width: 100%;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(34,197,94,0.4);
    }

    .note {
        color: #64748b;
        font-size: 12px;
        margin-top: 6px;
    }
</style>

<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 style="color:#f8fafc; font-weight:800;">
            💰 Validasi Denda Pengembalian
        </h4>
        <p style="color:#64748b;">
            Input denda jika terdapat kerusakan pada alat
        </p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card-denda">

                {{-- INFO --}}
                <div class="info-box">
                    <div class="info-title">Nama Peminjam</div>
                    <div class="info-value">{{ $peminjaman->user->name }}</div>
                </div>

                <div class="info-box">
                    <div class="info-title">Barang</div>
                    <div class="info-value">{{ $peminjaman->alat->nama_alat }}</div>
                </div>

                <div class="info-box">
                    <div class="info-title">Tanggal Pinjam</div>
                    <div class="info-value">{{ $peminjaman->tanggal_pinjam }}</div>
                </div>

                {{-- FORM --}}
                <form action="{{ route('petugas.pengembalian.konfirmasi', $peminjaman->id) }}" method="POST">
                    @csrf

                    <div style="margin-top:20px;">
                        <label class="info-title">Denda Kerusakan</label>

                        <input 
                            type="number" 
                            name="denda" 
                            class="input-denda"
                            placeholder="Contoh: 5000"
                        >

                        <div class="note">
                            Kosongkan jika tidak ada kerusakan.
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        💾 Simpan & Selesaikan
                    </button>
                </form>

            </div>

        </div>
    </div>

</div>

@endsection