@extends('layouts.peminjam')

@section('content')
<div class="container-fluid min-h-screen">
    {{-- Header & Search --}}
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <h4 class="text-white fw-bold mb-1">🛠️ Katalog Alat Tersedia</h4>
            <p class="text-slate-500 small mb-0 font-medium">Pilih alat yang Anda butuhkan dan masukkan ke daftar pinjam.</p>
            
            @if(session('cart') && count(session('cart')) > 0)
            <a href="{{ route('peminjam.checkout') }}" class="btn-cart-floating mt-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span>Lihat Keranjang ({{ count(session('cart')) }})</span>
            </a>
            @endif
        </div>

        <form action="{{ route('peminjam.alat.index') }}" method="GET" class="search-wrapper">
            <input type="text" name="search" placeholder="Cari nama alat..." value="{{ request('search') }}" class="input-search-dark">
            <button type="submit" class="btn-indigo-search">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </button>
        </form>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert-custom-success">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- Katalog Table --}}
    <div class="table-container shadow-2xl">
        <table class="modern-table">
            <thead>
                <tr>
                    <th width="35%">Informasi Alat</th>
                    <th width="20%" class="text-center">Kategori</th>
                    <th width="15%" class="text-center">Stok Ready</th>
                    <th width="30%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alats as $alat)
                <tr>
                    <td>
                        <div class="text-white font-semibold mb-1" style="font-size: 15px;">{{ $alat->nama_alat }}</div>
                        <div class="text-slate-500 small italic font-medium">
                            {{ Str::limit($alat->spesifikasi, 60) }}
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge-category-student">
                            {{ $alat->kategori->nama_kategori }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="stock-indicator-peminjam {{ $alat->stok > 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                            {{ $alat->stok }} <span class="small opacity-50">Unit</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('peminjam.cart.add') }}" method="POST" class="d-flex justify-content-center align-items-center gap-2">
                            @csrf
                            <input type="hidden" name="alat_id" value="{{ $alat->id }}">
                            <div class="qty-input-dark">
                                <input type="number" name="jumlah" value="1" min="1" max="{{ $alat->stok }}" required>
                            </div>
                            <button type="submit" class="btn-add-to-cart {{ $alat->stok <= 0 ? 'btn-disabled' : '' }}" {{ $alat->stok <= 0 ? 'disabled' : '' }}>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                <span>Pinjam</span>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-10">
                        <div class="text-slate-600 mb-2">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        </div>
                        <span class="text-slate-500 italic font-medium">Maaf, alat tidak ditemukan atau stok kosong.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-5 d-flex justify-content-center">
        {{ $alats->appends(request()->input())->links() }}
    </div>
</div>

<style>
    /* Search Bar */
    .search-wrapper { position: relative; display: flex; gap: 0; }
    .input-search-dark {
        background: #1e293b; border: 1px solid #334155; color: white;
        padding: 10px 20px; border-radius: 12px 0 0 12px; font-size: 14px;
        width: 250px; transition: 0.3s;
    }
    .input-search-dark:focus { outline: none; border-color: #6366f1; background: #131c2e; }
    .btn-indigo-search {
        background: #6366f1; border: none; color: white;
        padding: 0 20px; border-radius: 0 12px 12px 0; cursor: pointer; transition: 0.3s;
    }

    /* Floating Cart Button */
    .btn-cart-floating {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(16, 185, 129, 0.1); color: #10b981;
        padding: 8px 16px; border-radius: 20px; font-size: 12px;
        font-weight: 700; text-decoration: none; border: 1px solid rgba(16, 185, 129, 0.2);
        transition: 0.3s;
    }
    .btn-cart-floating:hover { background: #10b981; color: white; transform: translateY(-2px); }

    /* Table Components */
    .table-container { background: #1e293b; border-radius: 20px; border: 1px solid #334155; overflow: hidden; }
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table th { background: #0f172a; padding: 20px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #64748b; border-bottom: 2px solid #334155; }
    .modern-table td { padding: 20px; vertical-align: middle; border-bottom: 1px solid #334155; }
    
    .badge-category-student {
        background: #0f172a; color: #94a3b8; padding: 4px 10px;
        border-radius: 8px; font-size: 10px; font-weight: 800; border: 1px solid #334155;
    }

    .stock-indicator-peminjam { font-size: 18px; font-weight: 800; }

    /* Input Qty & Button */
    .qty-input-dark input {
        width: 60px; background: #0f172a; border: 1.5px solid #334155;
        color: white; padding: 8px; border-radius: 10px; text-align: center;
        font-size: 13px; font-weight: 700;
    }
    .qty-input-dark input:focus { outline: none; border-color: #6366f1; }

    .btn-add-to-cart {
        background: #6366f1; color: white; border: none; padding: 9px 18px;
        border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer;
        display: flex; align-items: center; gap: 6px; transition: 0.3s;
    }
    .btn-add-to-cart:hover { background: #4f46e5; transform: scale(1.05); }
    .btn-disabled { background: #334155 !important; color: #64748b !important; cursor: not-allowed !important; transform: none !important; }

    /* Success Alert */
    .alert-custom-success {
        background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2);
        color: #4ade80; padding: 16px; border-radius: 14px; margin-bottom: 25px;
        display: flex; align-items: center; gap: 12px; font-weight: 600; font-size: 14px;
    }

    .text-center { text-align: center !important; }
</style>
@endsection