<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_alat'      => Alat::count(),
            'stok_menipis'    => Alat::where('stok', '<', 5)->count(),
            'pinjam_menunggu' => Peminjaman::where('status', 'menunggu')->count(),
            'pinjam_aktif'    => Peminjaman::where('status', 'disetujui')->count(),
            'total_denda'     => Pengembalian::sum('denda'),
            // Mengambil 5 aktivitas terbaru
            'recent_logs'     => ActivityLog::with('user')->latest()->take(5)->get()
        ];

        return view('admin.dashboard', $data);
    }
}