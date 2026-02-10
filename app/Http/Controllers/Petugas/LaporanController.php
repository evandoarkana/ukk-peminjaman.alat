<?php

namespace App\Http\Controllers\Petugas;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input tanggal dari filter
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        // Query dasar
        $query = Peminjaman::with(['user', 'alat'])->where('status', 'selesai');

        // Jika ada filter tanggal
        if ($tgl_mulai && $tgl_selesai) {
            $query->whereBetween('tgl_kembali_real', [$tgl_mulai, $tgl_selesai]);
        }

        $laporans = $query->latest('tgl_kembali_real')->get();

        return view('petugas.laporan.index', compact('laporans', 'tgl_mulai', 'tgl_selesai'));
    }

    public function cetakPdf(Request $request)
    {
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        $query = Peminjaman::with(['user', 'alat'])->where('status', 'selesai');

        if ($tgl_mulai && $tgl_selesai) {
            $query->whereBetween('tgl_kembali_real', [$tgl_mulai, $tgl_selesai]);
        }

        $laporans = $query->latest('tgl_kembali_real')->get();
        $total_denda = $laporans->sum('denda');

        // Load view khusus untuk PDF
        $pdf = Pdf::loadView('petugas.laporan.pdf', compact('laporans', 'tgl_mulai', 'tgl_selesai', 'total_denda'));
        
        // Download atau stream di browser
        return $pdf->stream('Laporan-Peminjaman-' . now()->format('d-m-Y') . '.pdf');
    }
}