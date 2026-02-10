@extends('layouts.admin')

@section('content')
<div class="form-container">
    <div class="form-card-large">
        <div class="form-header text-center">
            <h4 class="form-title">Form Peminjaman Alat</h4>
            <p class="form-subtitle">Input data peminjam dan daftar alat yang akan dipinjam secara kolektif.</p>
        </div>

        {{-- Pesan Error --}}
        @if(session('error'))
        <div class="alert-custom-danger mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <form action="{{ route('admin.peminjaman.store') }}" method="POST">
            @csrf

            {{-- Pilih Peminjam --}}
            <div class="input-group-custom">
                <label class="label-custom">Pilih Peminjam</label>
                <select name="user_id" class="input-custom select-custom" required>
                    <option value="" disabled selected>-- Pilih Akun Peminjam --</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="divider"></div>

            {{-- Dynamic Tools Container --}}
            <div id="container-alat">
                <label class="label-custom mb-3 d-block">Daftar Alat & Jumlah</label>

                {{-- Baris Alat Pertama --}}
                <div class="item-alat-row">
                    <div class="col-select">
                        <small class="sub-label">Pilih Alat</small>
                        <select name="alat_id[]" class="input-custom select-custom" required>
                            <option value="" disabled selected>-- Pilih Alat --</option>
                            @foreach($alats as $alat)
                            <option value="{{ $alat->id }}">{{ $alat->nama_alat }} (Stok: {{ $alat->stok }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-qty">
                        <small class="sub-label">Jumlah</small>
                        <input type="number" name="jumlah[]" min="1" value="1" class="input-custom" required>
                    </div>
                    <div class="col-action">
                        <button type="button" class="btn-remove-row" style="visibility: hidden;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <button type="button" id="tambah-alat" class="btn-add-item">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Barang Lagi
            </button>

            <div class="divider"></div>

            {{-- Tanggal --}}
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <label class="label-custom">Tanggal Pinjam</label>
                    <input type="date" name="tgl_pinjam" value="{{ date('Y-m-d') }}" class="input-custom" required>
                </div>
                <div class="col-md-6">
                    <label class="label-custom">Batas Kembali</label>
                    <input type="date" name="tgl_kembali_rencana" class="input-custom" min="{{ date('Y-m-d') }}" required>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="form-actions">
                <button type="submit" class="btn-save">Simpan Transaksi</button>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
    .form-container { display: flex; justify-content: center; padding: 20px 0; }
    
    .form-card-large {
        background: #1e293b;
        width: 100%;
        max-width: 750px;
        padding: 45px;
        border-radius: 24px;
        border: 1px solid #334155;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
    }

    .divider { border-top: 1px dashed #334155; margin: 30px 0; }
    
    .item-alat-row {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        align-items: flex-end;
        background: rgba(15, 23, 42, 0.3);
        padding: 15px;
        border-radius: 16px;
        border: 1px solid #334155;
    }

    .col-select { flex: 2; }
    .col-qty { flex: 0.8; }
    .col-action { flex: 0.2; }

    .sub-label { display: block; color: #64748b; font-size: 11px; margin-bottom: 6px; font-weight: 700; text-transform: uppercase; }

    .btn-add-item {
        background: rgba(99, 102, 241, 0.1);
        color: #818cf8;
        border: 1px dashed #6366f1;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
    }

    .btn-add-item:hover { background: #6366f1; color: white; }

    .btn-remove-row {
        background: rgba(244, 63, 94, 0.1);
        color: #fb7185;
        border: none;
        padding: 11px;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-remove-row:hover { background: #f43f5e; color: white; }

    /* Reuse Styles from Previous Forms */
    .form-title { color: white; font-weight: 800; font-size: 1.5rem; margin-bottom: 8px; }
    .form-subtitle { color: #64748b; font-size: 0.9rem; margin-bottom: 30px; }
    .label-custom { color: #818cf8; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; }
    .input-custom { width: 100%; background: #0f172a; border: 1px solid #334155; border-radius: 12px; padding: 13px 16px; color: white; font-size: 14px; }
    .btn-save { flex: 2; background: #6366f1; color: white; border: none; padding: 16px; border-radius: 12px; font-weight: 700; cursor: pointer; transition: 0.3s; }
    .btn-save:hover { background: #4f46e5; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4); }
    .btn-cancel { flex: 1; text-align: center; background: transparent; color: #94a3b8; border: 1px solid #334155; padding: 16px; border-radius: 12px; text-decoration: none; font-weight: 700; }
    .alert-custom-danger { background: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2); color: #fb7185; padding: 15px; border-radius: 12px; display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 600; }
    .form-actions { display: flex; gap: 15px; }
</style>

<script>
document.getElementById('tambah-alat').addEventListener('click', function() {
    const container = document.getElementById('container-alat');
    const originalRow = container.querySelector('.item-alat-row');
    const newRow = originalRow.cloneNode(true);

    newRow.querySelector('select').value = "";
    newRow.querySelector('input').value = "1";

    const hapusBtn = newRow.querySelector('.btn-remove-row');
    hapusBtn.style.visibility = 'visible';

    hapusBtn.addEventListener('click', function() {
        newRow.remove();
    });

    container.appendChild(newRow);
});
</script>
@endsection