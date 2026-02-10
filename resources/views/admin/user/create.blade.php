@extends('layouts.admin')

@section('content')
<div class="container" style="margin-top: 40px; max-width: 550px; font-family: 'Segoe UI', sans-serif;">
    <div
        style="background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 35px; border: 1px solid #e3e6f0;">
        <h4 style="margin-bottom: 30px; color: #3a3b45; font-weight: 700; text-align: center;">Tambah Pengguna Baru</h4>

        {{-- Menampilkan Pesan Error Validasi  --}}
        @if ($errors->any())
        <div
            style="background-color: #f8d7da; color: #842029; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 13px;">
            <ul style="margin: 0;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf

            {{-- Nama Lengkap [cite: 26] --}}
            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; margin-bottom: 8px; font-size: 12px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Nama
                    Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px; outline: none;"
                    required>
            </div>

            {{-- Email Aktif  --}}
            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; margin-bottom: 8px; font-size: 12px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Email
                    Aktif</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@mail.com"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px; outline: none;"
                    required>
            </div>

            {{-- Password  --}}
            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; margin-bottom: 8px; font-size: 12px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Password</label>
                <input type="password" name="password" placeholder="Minimal 6 karakter"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px; outline: none;"
                    required>
            </div>

            {{-- Role/Privilege User [cite: 28, 30] --}}
            <div style="margin-bottom: 30px;">
                <label
                    style="display: block; margin-bottom: 8px; font-size: 12px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Hak
                    Akses (Role)</label>
                <select name="role"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px; background-color: white; cursor: pointer;"
                    required>
                    <option value="" disabled selected>-- Pilih Role --</option>
                    <option value="peminjam" {{ old('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                    <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            {{-- Tombol Aksi  --}}
            <div style="display: flex; gap: 12px;">
                <button type="submit"
                    style="flex: 2; background-color: #4e73df; color: white; border: none; padding: 14px; border-radius: 6px; cursor: pointer; font-weight: 700; font-size: 14px;">
                    Simpan Data
                </button>
                <a href="{{ route('admin.user.index') }}"
                    style="flex: 1; text-align: center; background-color: #f8f9fc; color: #4e73df; border: 1px solid #d1d3e2; padding: 14px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 700;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection