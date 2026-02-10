@extends('layouts.admin')

@section('content')
<div class="form-container">
    <div class="form-card">
        {{-- Header Form --}}
        <div class="form-header">
            <h4 class="form-title">Edit Data Alat</h4>
            <p class="form-subtitle">Perbarui informasi aset atau ketersediaan stok inventaris.</p>
        </div>

        <form action="{{ route('admin.alat.update', $alat->id) }}" method="POST">
            @csrf 
            @method('PUT')
            
            {{-- Nama Alat --}}
            <div class="input-group-custom">
                <label class="label-custom">Nama Alat</label>
                <input type="text" name="nama_alat" value="{{ $alat->nama_alat }}" 
                       class="input-custom" placeholder="Masukkan nama alat" required>
            </div>

            {{-- Kategori --}}
            <div class="input-group-custom">
                <label class="label-custom">Kategori</label>
                <div class="select-wrapper">
                    <select name="kategori_id" class="input-custom select-custom" required>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ $alat->kategori_id == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Spesifikasi --}}
            <div class="input-group-custom">
                <label class="label-custom">Spesifikasi</label>
                <textarea name="spesifikasi" rows="4" class="input-custom" 
                          placeholder="Detail teknis alat..." required>{{ $alat->spesifikasi }}</textarea>
            </div>

            {{-- Stok --}}
            <div class="input-group-custom">
                <label class="label-custom">Stok Alat</label>
                <input type="number" name="stok" value="{{ $alat->stok }}" min="0" 
                       class="input-custom" required>
            </div>

            {{-- Tombol Aksi --}}
            <div class="form-actions">
                <button type="submit" class="btn-update">Update Data</button>
                <a href="{{ route('admin.alat.index') }}" class="btn-back">Kembali</a>
            </div>
        </form>
    </div>
</div>

<style>
    /* Kontainer Utama */
    .form-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 10px;
    }

    /* Kartu Form */
    .form-card {
        background: #1e293b; /* Slate 800 */
        width: 100%;
        max-width: 550px;
        padding: 40px;
        border-radius: 20px;
        border: 1px solid #334155;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    /* Header */
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

    /* Input Styling */
    .input-group-custom {
        margin-bottom: 20px;
    }

    .label-custom {
        display: block;
        color: #818cf8; /* Indigo 400 */
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 8px;
    }

    .input-custom {
        width: 100%;
        background: #0f172a; /* Slate 900 */
        border: 1px solid #334155;
        border-radius: 12px;
        padding: 12px 16px;
        color: white;
        font-size: 14px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .input-custom:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        background: #1e293b;
    }

    /* Tombol */
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 35px;
    }

    .btn-update {
        flex: 2;
        background: #6366f1; /* Indigo 600 */
        color: white;
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-update:hover {
        background: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
    }

    .btn-back {
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
        transition: all 0.3s;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.05);
        color: white;
        border-color: #64748b;
    }

    /* Chrome, Safari, Edge, Opera - menghilangkan arrow pada input number */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endsection