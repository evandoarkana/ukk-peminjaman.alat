@extends('layouts.admin')

@section('content')
<div class="container" style="margin-top: 40px; max-width: 550px; font-family: 'Segoe UI', sans-serif;">
    <div
        style="background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 35px; border: 1px solid #e3e6f0; border-top: 4px solid #36b9cc;">
        <h4 style="margin-bottom: 30px; color: #3a3b45; font-weight: 700; text-align: center;">Perbarui Profil</h4>

        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
            @csrf @method('PUT')
            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #36b9cc; text-transform: uppercase;">Nama
                    Lengkap</label>
                <input type="text" name="name" value="{{ $user->name }}"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px; outline: none;"
                    required>
            </div>
            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #36b9cc; text-transform: uppercase;">Email</label>
                <input type="email" name="email" value="{{ $user->email }}"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px; outline: none;"
                    required>
            </div>
            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #36b9cc; text-transform: uppercase;">Password
                    Baru <span style="text-transform: none; color: #999; font-weight: 400;">(Kosongkan jika
                        tetap)</span></label>
                <input type="password" name="password"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px; outline: none;">
            </div>
            <div style="margin-bottom: 30px;">
                <label
                    style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #36b9cc; text-transform: uppercase;">Level
                    Akses</label>
                <select name="role"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px; background-color: white; cursor: pointer;"
                    required>
                    <option value="peminjam" {{ $user->role == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                    <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div style="display: flex; gap: 12px;">
                <button type="submit"
                    style="flex: 2; background-color: #36b9cc; color: white; border: none; padding: 14px; border-radius: 6px; cursor: pointer; font-weight: 700; font-size: 14px;">Simpan
                    Perubahan</button>
                <a href="{{ route('admin.user.index') }}"
                    style="flex: 1; text-align: center; background-color: #f8f9fc; color: #36b9cc; border: 1px solid #d1d3e2; padding: 14px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 700;">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection