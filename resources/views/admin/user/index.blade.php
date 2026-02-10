@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: 'Segoe UI', sans-serif;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 style="font-weight: 700; color: #333; margin: 0;">Manajemen Pengguna</h4>
        <a href="{{ route('admin.user.create') }}" class="btn"
            style="background-color: #4e73df; color: white; border-radius: 6px; padding: 10px 20px; text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.3s;">
            <i class="fas fa-plus me-1"></i> Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
    <div
        style="background-color: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #badbcc;">
        {{ session('success') }}
    </div>
    @endif

    <div
        style="background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e3e6f0;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #f8f9fc; border-bottom: 2px solid #e3e6f0;">
                <tr>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        No</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Nama Lengkap</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Email</th>
                    <th
                        style="padding: 15px; text-align: left; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Role</th>
                    <th
                        style="padding: 15px; text-align: center; color: #4e73df; font-size: 12px; text-transform: uppercase;">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr style="border-bottom: 1px solid #e3e6f0;">
                    <td style="padding: 15px; color: #6e707e;">
                        {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #3a3b45;">{{ $user->name }}</td>
                    <td style="padding: 15px; color: #6e707e;">{{ $user->email }}</td>
                    <td style="padding: 15px;">
                        @php
                        $bg = $user->role == 'admin' ? '#e74a3b' : ($user->role == 'petugas' ? '#f6c23e' : '#36b9cc');
                        @endphp
                        <span
                            style="background-color: {{ $bg }}; color: white; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; text-transform: uppercase;">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 8px;">
                            <a href="{{ route('admin.user.edit', $user->id) }}"
                                style="background-color: #f8f9fc; color: #4e73df; border: 1px solid #d1d3e2; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600;">Edit</a>
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('Hapus user ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    style="background-color: #fff; color: #e74a3b; border: 1px solid #e74a3b; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 600;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>
</div>
@endsection