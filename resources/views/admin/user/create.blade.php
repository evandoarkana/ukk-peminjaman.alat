@extends('layouts.admin')

@section('content')
<style>
    /* Container utama dibuat Flexbox untuk menengahkan konten */
    .content-wrapper-center {
        display: flex;
        flex-direction: column;
        align-items: center; /* Menengahkan secara horizontal */
        justify-content: center; /* Menengahkan secara vertikal jika tinggi cukup */
        min-height: 80vh;
    }

    .form-card { 
        background: #1e293b; 
        border-radius: 16px; 
        padding: 40px; 
        border: 1px solid #334155; 
        width: 100%;
        max-width: 550px; /* Lebar maksimal form */
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .form-label { 
        color: #94a3b8; 
        font-size: 12px; 
        font-weight: 800; 
        margin-bottom: 10px; 
        display: block;
        letter-spacing: 1px;
    }

    .form-control-dark { 
        background: #0f172a; 
        border: 1px solid #334155; 
        color: #f8fafc; 
        padding: 14px; 
        border-radius: 12px; 
        width: 100%; 
        transition: 0.3s;
        font-size: 14px;
    }

    .form-control-dark:focus { 
        border-color: #6366f1; 
        outline: none; 
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); 
    }

    .btn-save { 
        background: linear-gradient(90deg, #6366f1, #a855f7); 
        color: white; 
        border: none; 
        padding: 15px; 
        border-radius: 12px; 
        font-weight: 800; 
        width: 100%; 
        margin-top: 25px;
        cursor: pointer;
        transition: 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-save:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
</style>

<div class="content-wrapper-center">
    {{-- Header Tengah --}}
    <div class="text-center mb-4">
        <h3 style="color:#f8fafc; font-weight:800; letter-spacing: -1px; size: 1.8rem;">Tambah User Baru</h3>
        <p style="color:#64748b; font-size: 14px;">Silakan isi data akun petugas atau peminjam di bawah ini.</p>
    </div>

    {{-- Form Card --}}
    <div class="form-card">
        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label">NAMA LENGKAP</label>
                <input type="text" name="name" class="form-control-dark" required placeholder="Masukkan nama lengkap...">
            </div>
            
            <div class="mb-4">
                <label class="form-label">ALAMAT EMAIL</label>
                <input type="email" name="email" class="form-control-dark" required placeholder="nama@email.com">
            </div>

           <div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" class="form-control">
    <small style="color: #64748b; font-size: 0.75rem;">
        *Minimal 8 karakter, wajib ada huruf KAPITAL dan angka.
    </small>
</div>
            <div class="mb-4">
                <label class="form-label">ROLE / HAK AKSES</label>
                <select name="role" class="form-control-dark" required>
                    <option value="peminjam">Peminjam (Siswa/Anggota)</option>
                    <option value="petugas">Petugas (Staff Inventaris)</option>
                    <option value="admin">Administrator (Full Access)</option>
                </select>
            </div>

            <button type="submit" class="btn-save">Daftarkan User Sekarang</button>
            
            <div class="text-center mt-4">
                <a href="{{ route('admin.user.index') }}" style="color: #64748b; font-size: 13px; text-decoration: none;">
                    ← Kembali ke Daftar User
                </a>
            </div>
        </form>
    </div>
</div>
@endsection