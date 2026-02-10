<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            // Permintaan pinjam yang butuh diklik "Setujui"
            'perlu_approval' => Peminjaman::where('status', 'menunggu')->count(),
            
            // Barang yang sedang di luar (sedang dipinjam)
            'sedang_dipinjam' => Peminjaman::where('status', 'disetujui')->count(),
            
            // Barang yang seharusnya kembali hari ini
            'kembali_hari_ini' => Peminjaman::where('status', 'disetujui')
                                ->whereDate('tgl_kembali_rencana', Carbon::today())
                                ->count(),
                                
            // Total stok seluruh alat yang tersedia di gudang
            'total_alat' => Alat::sum('stok'),
            
            // List 5 transaksi terbaru untuk dipantau
            // PERBAIKAN: Menggunakan Eager Loading ke detailPeminjaman dan alat
            'recent_activities' => Peminjaman::with(['user', 'detailPeminjaman.alat'])
                                ->latest()
                                ->take(5)
                                ->get()
        ];

        return view('petugas.dashboard', $data);
    }
}