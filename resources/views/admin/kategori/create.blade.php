@extends('layouts.admin')

@section('content')
<div class="form-container">
    <div class="form-card">
        {{-- Header Form --}}
        <div class="form-header">
            <h4 class="form-title">Tambah Kategori Baru</h4>
            <p class="form-subtitle">Buat grup klasifikasi untuk memudahkan manajemen alat.</p>
        </div>

        <form action="{{ route('admin.kategori.store') }}" method="POST">
            @csrf
            
            <div class="input-group-custom">
                <label class="label-custom">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="input-custom" 
                       placeholder="Misal: Multimedia, Networking, dsb." required autofocus>
            </div>

            <div class="form-actions-stack">
                <button type="submit" class="btn-save-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Kategori
                </button>
                <a href="{{ route('admin.kategori.index') }}" class="btn-cancel-link">Batal dan Kembali</a>
            </div>
        </form>
    </div>
</div>

<style>
    /* Layout Wrapper */
    .form-container {
        display: flex;
        justify-content: center;
        padding-top: 30px;
    }

    /* Card Styling */
    .form-card {
        background: #1e293b;
        width: 100%;
        max-width: 450px;
        padding: 40px;
        border-radius: 20px;
        border: 1px solid #334155;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .form-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .form-title {
        color: white;
        font-weight: 800;
        font-size: 1.25rem;
        margin-bottom: 8px;
    }

    .form-subtitle {
        color: #64748b;
        font-size: 0.85rem;
        line-height: 1.5;
    }

    /* Input Styling */
    .input-group-custom {
        margin-bottom: 25px;
    }

    .label-custom {
        display: block;
        color: #818cf8;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 10px;
        padding-left: 4px;
    }

    .input-custom {
        width: 100%;
        background: #0f172a;
        border: 2px solid #334155;
        border-radius: 12px;
        padding: 14px 18px;
        color: white;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .input-custom:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        background: #131c2e;
    }

    /* Buttons */
    .form-actions-stack {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-save-full {
        width: 100%;
        background: #6366f1;
        color: white;
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s;
    }

    .btn-save-full:hover {
        background: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
    }

    .btn-cancel-link {
        text-align: center;
        color: #64748b;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        padding: 8px;
        transition: color 0.2s;
    }

    .btn-cancel-link:hover {
        color: #94a3b8;
    }

    .w-4 { width: 1rem; }
    .h-4 { height: 1rem; }
</style>
@endsection