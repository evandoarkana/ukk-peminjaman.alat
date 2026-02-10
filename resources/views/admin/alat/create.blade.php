@extends('layouts.admin')

@section('content')
<div class="form-container">
    <div class="form-card">
        <div class="form-header">
            <h4 class="form-title">Tambah Alat Baru</h4>
            <p class="form-subtitle">Pastikan data spesifikasi dan stok sudah sesuai.</p>
        </div>

        <form action="{{ route('admin.alat.store') }}" method="POST">
            @csrf
            
            <div class="input-group-custom">
                <label class="label-custom">Nama Alat</label>
                <input type="text" name="nama_alat" class="input-custom" 
                       placeholder="Contoh: Sony Alpha A7II" required>
            </div>

            <div class="input-group-custom">
                <label class="label-custom">Kategori</label>
                <select name="kategori_id" class="input-custom select-custom" required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-group-custom">
                <label class="label-custom">Spesifikasi</label>
                <textarea name="spesifikasi" rows="4" class="input-custom" 
                          placeholder="Masukkan rincian teknis alat..." required></textarea>
            </div>

            <div class="input-group-custom">
                <label class="label-custom">Stok Alat</label>
                <input type="number" name="stok" min="0" class="input-custom" 
                       placeholder="0" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Simpan Alat</button>
                <a href="{{ route('admin.alat.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
    .form-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 20px;
    }

    .form-card {
        background: #1e293b;
        width: 100%;
        max-width: 550px;
        padding: 40px;
        border-radius: 20px;
        border: 1px solid #334155;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .form-header {
        margin-bottom: 30px;
        border-bottom: 1px solid #334155;
        padding-bottom: 20px;
    }

    .form-title {
        color: white;
        font-weight: 800;
        font-size: 1.25rem;
        margin-bottom: 5px;
    }

    .form-subtitle {
        color: #64748b;
        font-size: 0.85rem;
    }

    .input-group-custom {
        margin-bottom: 20px;
    }

    .label-custom {
        display: block;
        color: #818cf8; /* Indigo 400 */
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .input-custom {
        width: 100%;
        background: #0f172a;
        border: 1px solid #334155;
        border-radius: 12px;
        padding: 12px 16px;
        color: white;
        font-size: 14px;
        transition: all 0.3s;
    }

    .input-custom:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .select-custom {
        appearance: none;
        cursor: pointer;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 30px;
    }

    .btn-save {
        flex: 2;
        background: #6366f1;
        color: white;
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-save:hover {
        background: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
    }

    .btn-cancel {
        flex: 1;
        text-align: center;
        background: transparent;
        color: #94a3b8;
        border: 1px solid #334155;
        padding: 14px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        transition: 0.3s;
    }

    .btn-cancel:hover {
        background: rgba(255, 255, 255, 0.05);
        color: white;
    }
</style>
@endsection