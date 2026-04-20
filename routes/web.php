<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;

// Controller Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\LaporanController as LaporanAdmin;

// Controller Petugas
use App\Http\Controllers\Petugas\DashboardController as DashPetugas;
use App\Http\Controllers\Petugas\AlatController as PetugasAlat;
use App\Http\Controllers\Petugas\TransaksiController as TransaksiPetugas;
use App\Http\Controllers\Petugas\LaporanController as LaporanPetugas;

// Controller Peminjam
use App\Http\Controllers\Peminjam\AlatController as AlatUser;
use App\Http\Controllers\Peminjam\TransaksiController as TransaksiUser;

// HALAMAN PILIH ROLE
Route::get('/login', [AuthController::class, 'pilihRole'])->name('login');

// LOGIN BERDASARKAN ROLE
Route::get('/login/{role}', [AuthController::class, 'showLogin']);
Route::post('/login/{role}', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
/*
| Dashboard Redirect
*/
Route::middleware('auth')->get('/dashboard', function () {
    // Tambahkan dd ini untuk tes: dd(auth()->user()->role); 
    return match (auth()->user()->role) {
        'admin'    => redirect()->route('admin.dashboard'),
        'petugas'  => redirect()->route('petugas.dashboard'),
        'peminjam' => redirect()->route('peminjam.dashboard'),
        default    => abort(403),
    };
})->name('dashboard');

/*
| Admin Route
*/
/*
| Admin Route
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.') // Semua route di sini otomatis diawali 'admin.'
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Master Data
        Route::resource('user', UserController::class)->except(['show']);
        Route::resource('kategori', KategoriController::class);
        Route::resource('alat', AlatController::class);
        
        // Transaksi Peminjaman
        Route::put('/peminjaman/setujui/{id}', [TransaksiController::class, 'setujui'])->name('peminjaman.setujui');
        Route::get('/peminjaman/create', [TransaksiController::class, 'createPeminjaman'])->name('peminjaman.create');
        Route::post('/peminjaman/store', [TransaksiController::class, 'storePeminjaman'])->name('peminjaman.store');
        
        // Alur Persetujuan (Approval)
        // Gunakan TransaksiController sesuai import kamu di atas
        Route::put('/peminjaman/setujui-pinjam/{id}', [TransaksiController::class, 'setujuiPinjam'])->name('peminjaman.setujui');
        Route::put('/peminjaman/setujui-kembali/{id}', [TransaksiController::class, 'setujuiKembali'])->name('peminjaman.kembali');
        Route::post('/peminjaman/tolak/{id}', [TransaksiController::class, 'tolak'])->name('peminjaman.tolak');

        // Transaksi Pengembalian & Laporan
        Route::get('/pengembalian', [TransaksiController::class, 'indexPengembalian'])->name('pengembalian.index');
        Route::get('/peminjaman/konfirmasi/{kode}', [TransaksiController::class, 'konfirmasiPengembalian'])->name('peminjaman.konfirmasi');
        Route::post('/peminjaman/store-pengembalian/{kode}', [TransaksiController::class, 'storePengembalian'])->name('peminjaman.store_pengembalian');
    
        Route::get('/log-aktivitas', [ActivityLogController::class, 'index'])->name('log.index');
        Route::get('/laporan', [LaporanAdmin::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [LaporanAdmin::class, 'cetakPdf'])->name('laporan.cetak');
    });
/*
| Petugas Route (SUDAH DIPERBAIKI)
*/
Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', [DashPetugas::class, 'index'])
            ->name('dashboard');

     Route::get('/daftar-alat', [PetugasAlat::class, 'index'])
            ->name('alat.index');


        // APPROVAL
        Route::get('/peminjaman/approval', [TransaksiPetugas::class, 'indexApproval'])
            ->name('peminjaman.index');

        Route::post('/peminjaman/setujui/{id}', [TransaksiPetugas::class, 'setujui'])
            ->name('peminjaman.setujui');

        Route::post('/peminjaman/tolak/{id}', [TransaksiPetugas::class, 'tolak'])
            ->name('peminjaman.tolak');

        // PENGEMBALIAN
        Route::get('/pengembalian', [TransaksiPetugas::class, 'indexPengembalian'])
            ->name('pengembalian.index');

        Route::get('/pengembalian/cek/{id}', [TransaksiPetugas::class, 'cekDenda'])
            ->name('pengembalian.cek');

        Route::post('/pengembalian/konfirmasi/{id}', [TransaksiPetugas::class, 'konfirmasiKembali'])
            ->name('pengembalian.konfirmasi');
            
        // LAPORAN
        Route::get('/laporan', [LaporanPetugas::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/cetak', [LaporanPetugas::class, 'cetakPdf'])
            ->name('laporan.cetak');

    });     
/*
| Peminjam Route
*/
Route::middleware(['auth', 'role:peminjam'])
    ->prefix('peminjam')
    ->name('peminjam.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('peminjam.dashboard');
        })->name('dashboard');

        Route::get('/daftar-alat', [AlatUser::class, 'index'])->name('alat.index');
        Route::post('/cart/add', [TransaksiUser::class, 'addToCart'])->name('cart.add');
        Route::get('/cart/hapus/{id}', [TransaksiUser::class, 'removeFromCart'])->name('cart.remove');
        Route::get('/checkout', [TransaksiUser::class, 'checkout'])->name('checkout');
        Route::post('/pinjam/simpan', [TransaksiUser::class, 'store'])->name('pinjam.store');
        Route::get('/riwayat', [TransaksiUser::class, 'history'])->name('riwayat');
        Route::get('/kembalikan', [TransaksiUser::class, 'returning'])->name('kembalikan');
    });

/*
| Profile Route
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// require __DIR__.'/auth.php';<?php


// ================= CONTROLLER =================


// =====================================================
// 🔥 ROOT (BIAR TIDAK 404)
// =====================================================
Route::get('/', function () {
    return redirect('/login');
});


// =====================================================
// 🔥 PILIH ROLE LOGIN
// =====================================================
Route::get('/login', function () {
    return view('auth.pilih-role');
})->name('login');


// =====================================================
// 🔥 LOGIN BERDASARKAN ROLE
// =====================================================
Route::get('/login/{role}', [AuthController::class, 'showLogin']);
Route::post('/login/{role}', [AuthController::class, 'login']);


// =====================================================
// 🔥 REDIRECT DASHBOARD SESUAI ROLE
// =====================================================
Route::middleware('auth')->get('/dashboard', function () {
    return match (auth()->user()->role) {
        'Admin'    => redirect()->route('admin.dashboard'),
        'Petugas'  => redirect()->route('petugas.dashboard'),
        'Peminjam' => redirect()->route('peminjam.dashboard'),
        default    => abort(403),
    };
})->name('dashboard');


// =====================================================
// 🔥 ADMIN
// =====================================================
Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('user', UserController::class)->except(['show']);
        Route::resource('kategori', KategoriController::class);
        Route::resource('alat', AlatController::class);

        // Peminjaman
        Route::put('/peminjaman/setujui/{id}', [TransaksiController::class, 'setujui'])->name('peminjaman.setujui');
        Route::get('/peminjaman/create', [TransaksiController::class, 'createPeminjaman'])->name('peminjaman.create');
        Route::post('/peminjaman/store', [TransaksiController::class, 'storePeminjaman'])->name('peminjaman.store');

        Route::put('/peminjaman/setujui-pinjam/{id}', [TransaksiController::class, 'setujuiPinjam'])->name('peminjaman.setujuiPinjam');
        Route::put('/peminjaman/setujui-kembali/{id}', [TransaksiController::class, 'setujuiKembali'])->name('peminjaman.kembali');
        Route::post('/peminjaman/tolak/{id}', [TransaksiController::class, 'tolak'])->name('peminjaman.tolak');

        // Pengembalian
        Route::get('/pengembalian', [TransaksiController::class, 'indexPengembalian'])->name('pengembalian.index');
        Route::get('/peminjaman/konfirmasi/{kode}', [TransaksiController::class, 'konfirmasiPengembalian'])->name('peminjaman.konfirmasi');
        Route::post('/peminjaman/store-pengembalian/{kode}', [TransaksiController::class, 'storePengembalian'])->name('peminjaman.store_pengembalian');

        // Log & Laporan
        Route::get('/log-aktivitas', [ActivityLogController::class, 'index'])->name('log.index');
        Route::get('/laporan', [LaporanAdmin::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [LaporanAdmin::class, 'cetakPdf'])->name('laporan.cetak');
    });


// =====================================================
// 🔥 PETUGAS
// =====================================================
Route::middleware(['auth', 'role:Petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', [DashPetugas::class, 'index'])->name('dashboard');

        Route::get('/daftar-alat', [PetugasAlat::class, 'index'])->name('alat.index');

        // Approval
        Route::get('/peminjaman/approval', [TransaksiPetugas::class, 'indexApproval'])->name('peminjaman.index');
        Route::post('/peminjaman/setujui/{id}', [TransaksiPetugas::class, 'setujui'])->name('peminjaman.setujui');
        Route::post('/peminjaman/tolak/{id}', [TransaksiPetugas::class, 'tolak'])->name('peminjaman.tolak');

        // Pengembalian
        Route::get('/pengembalian', [TransaksiPetugas::class, 'indexPengembalian'])->name('pengembalian.index');
        Route::get('/pengembalian/cek/{id}', [TransaksiPetugas::class, 'cekDenda'])->name('pengembalian.cek');
        Route::post('/pengembalian/konfirmasi/{id}', [TransaksiPetugas::class, 'konfirmasiKembali'])->name('pengembalian.konfirmasi');

        // Laporan
        Route::get('/laporan', [LaporanPetugas::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [LaporanPetugas::class, 'cetakPdf'])->name('laporan.cetak');
    });


// =====================================================
// 🔥 PEMINJAM
// =====================================================
Route::middleware(['auth', 'role:Peminjam'])
    ->prefix('peminjam')
    ->name('peminjam.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('peminjam.dashboard');
        })->name('dashboard');

        Route::get('/daftar-alat', [AlatUser::class, 'index'])->name('alat.index');

        Route::post('/cart/add', [TransaksiUser::class, 'addToCart'])->name('cart.add');
        Route::get('/cart/hapus/{id}', [TransaksiUser::class, 'removeFromCart'])->name('cart.remove');

        Route::get('/checkout', [TransaksiUser::class, 'checkout'])->name('checkout');
        Route::post('/pinjam/simpan', [TransaksiUser::class, 'store'])->name('pinjam.store');

        Route::get('/riwayat', [TransaksiUser::class, 'history'])->name('riwayat');
        Route::get('/kembalikan', [TransaksiUser::class, 'returning'])->name('kembalikan');
    });


// =====================================================
// 🔥 PROFILE
// =====================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// =====================================================
// ❌ NONAKTIFKAN AUTH BAWAAN (WAJIB)
// =====================================================
// require __DIR__.'/auth.php';