<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Menampilkan daftar log aktivitas
     */
    public function index()
    {
        // Mengambil data log terbaru dengan pagination agar tidak berat
        // Pastikan relasi 'user' sudah didefinisikan di model ActivityLog
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.activity_log', compact('logs'));
    }
}