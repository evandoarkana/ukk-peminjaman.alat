@extends('layouts.peminjam')

@section('content')
<div class="container-fluid min-h-screen">
    {{-- Header --}}
    <div class="mb-5">
        <h4 class="text-white fw-semibold mb-1">📅 Jadwalkan Peminjaman</h4>
        <p class="text-slate-500 small mb-0 font-medium">Tentukan jadwal dan periksa kembali daftar alat Anda sebelum mengirim pengajuan.</p>
    </div>

    {{-- Error Alert --}}
    @if(session('error'))
    <div class="alert-custom-danger mb-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <span class="font-medium">{{ session('error') }}</span>
    </div>
    @endif

    <form action="{{ route('peminjam.pinjam.store') }}" method="POST">
        @csrf
        
        {{-- Date Picker Section --}}
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <label class="label-custom-student">Tanggal Mulai Pinjam</label>
                <input type="date" name="tgl_pinjam" class="input-custom-dark" required min="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-6">
                <label class="label-custom-student">Rencana Tanggal Kembali</label>
                <input type="date" name="tgl_kembali_rencana" class="input-custom-dark" required min="{{ date('Y-m-d') }}">
            </div>
        </div>

        {{-- Table Checkout --}}
        <div class="table-container shadow-2xl">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th width="50%">Nama Alat</th>
                        <th width="30%" class="text-center">Jumlah</th>
                        <th width="20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cart as $id => $item)
                    <tr>
                        <td class="px-4">
                            <span class="text-white font-medium" style="font-size: 15px;">{{ $item['nama'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge-qty-checkout">
                                {{ $item['jumlah'] }} Unit
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('peminjam.cart.remove', $id) }}" class="btn-remove-checkout" title="Hapus dari daftar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-10">
                            <div class="text-slate-600 mb-3">
                                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <span class="text-slate-500 italic font-medium">Daftar pinjam Anda masih kosong.</span>
                            <div class="mt-4">
                                <a href="{{ route('peminjam.alat.index') }}" class="btn-indigo-sm">Cari Alat</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(count($cart) > 0)
        <div class="form-actions-stack mt-5">
            <button type="submit" class="btn-submit-checkout">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                <span>Kirim Pengajuan Peminjaman</span>
            </button>
            <a href="{{ route('peminjam.alat.index') }}" class="btn-back-link">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Katalog
            </a>
        </div>
        @endif
    </form>
</div>

<style>
    /* Typography & Label */
    .fw-semibold { font-weight: 600 !important; }
    .label-custom-student {
        display: block; color: #818cf8; font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; padding-left: 4px;
    }

    /* Input Styling */
    .input-custom-dark {
        width: 100%; background: #1e293b; border: 1px solid #334155;
        color: white; padding: 12px 16px; border-radius: 12px; font-size: 14px; transition: 0.3s;
    }
    .input-custom-dark:focus { outline: none; border-color: #6366f1; background: #131c2e; }

    /* Table Components */
    .table-container { background: #1e293b; border-radius: 20px; border: 1px solid #334155; overflow: hidden; }
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table th { background: #0f172a; padding: 18px 24px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #64748b; border-bottom: 2px solid #334155; }
    .modern-table td { padding: 18px 24px; vertical-align: middle; border-bottom: 1px solid #334155; }
    
    .badge-qty-checkout {
        background: rgba(99, 102, 241, 0.1); color: #818cf8;
        padding: 5px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; border: 1px solid rgba(99, 102, 241, 0.2);
    }

    .btn-remove-checkout {
        display: inline-flex; align-items: center; justify-content: center;
        width: 34px; height: 34px; background: rgba(244, 63, 94, 0.1);
        color: #fb7185; border-radius: 10px; transition: 0.3s; border: 1px solid rgba(244, 63, 94, 0.1);
    }
    .btn-remove-checkout:hover { background: #f43f5e; color: white; transform: scale(1.1); }

    /* Action Buttons */
    .btn-submit-checkout {
        width: 100%; background: #10b981; color: white; border: none;
        padding: 16px; border-radius: 16px; font-weight: 700; font-size: 15px;
        display: flex; align-items: center; justify-content: center; gap: 10px;
        transition: 0.3s; box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3); cursor: pointer;
    }
    .btn-submit-checkout:hover { background: #059669; transform: translateY(-3px); box-shadow: 0 15px 20px -5px rgba(16, 185, 129, 0.4); }

    .btn-back-link {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        text-align: center; color: #64748b; text-decoration: none; font-size: 13px;
        font-weight: 600; padding: 10px; transition: 0.2s; margin-top: 10px;
    }
    .btn-back-link:hover { color: #94a3b8; }

    .btn-indigo-sm {
        background: #6366f1; color: white; padding: 8px 16px; border-radius: 8px;
        text-decoration: none; font-size: 12px; font-weight: 700; transition: 0.3s;
    }

    /* Alerts */
    .alert-custom-danger {
        background: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2);
        color: #fb7185; padding: 15px; border-radius: 12px; display: flex; align-items: center; gap: 10px;
    }

    .form-actions-stack { display: flex; flex-direction: column; align-items: center; }
    .text-center { text-align: center !important; }
</style>
@endsection