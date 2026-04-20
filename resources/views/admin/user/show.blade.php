@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4" style="margin-top: 25px; font-family: 'Segoe UI', sans-serif;">
    <div class="mb-4">
        <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-light border">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e3e6f0; overflow: hidden;">
        <div style="background: #f8f9fc; padding: 20px; border-bottom: 1px solid #e3e6f0;">
            <h5 style="font-weight: 700; color: #4e73df; margin: 0;">Detail Pengguna</h5>
        </div>
        
        <div style="padding: 30px;">
            <div class="row">
                <div class="col-md-4 text-center border-end">
                    <div style="width: 100px; height: 100px; background: #eaecf4; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fas fa-user fa-3x" style="color: #b7b9cc;"></i>
                    </div>
                    <h5 style="font-weight: 700; color: #333;">{{ $user->name }}</h5>
                    <span style="background-color: {{ $user->role == 'admin' ? '#e74a3b' : '#36b9cc' }}; color: white; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; text-transform: uppercase;">
                        {{ $user->role }}
                    </span>
                </div>
                
                <div class="col-md-8 px-4">
                    <div class="mb-3">
                        <label style="font-size: 11px; font-weight: 800; color: #4e73df; text-transform: uppercase;">Email</label>
                        <p style="color: #5a5c69; font-size: 15px;">{{ $user->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label style="font-size: 11px; font-weight: 800; color: #4e73df; text-transform: uppercase;">Dibuat Pada</label>
                        <p style="color: #5a5c69; font-size: 15px;">{{ $user->created_at->format('d F Y (H:i)') }}</p>
                    </div>
                    <hr>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning btn-sm fw-bold">Edit User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection