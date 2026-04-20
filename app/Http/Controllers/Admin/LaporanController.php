<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman; 
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        $laporans = Peminjaman::with(['user', 'alat.kategori'])
            ->when($tgl_mulai && $tgl_selesai, function ($query) use ($tgl_mulai, $tgl_selesai) {
                return $query->whereBetween('tgl_pinjam', [$tgl_mulai, $tgl_selesai]);
            })
            ->orderBy('tgl_pinjam', 'desc')
            ->get();

        return view('admin.laporan.index', compact('laporans', 'tgl_mulai', 'tgl_selesai'));
    }

    public function cetakPdf(Request $request)
    {
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        $laporans = Peminjaman::with(['user', 'alat.kategori']) // 🔥 FIX
            ->when($tgl_mulai && $tgl_selesai, function ($query) use ($tgl_mulai, $tgl_selesai) {
                return $query->whereBetween('tgl_pinjam', [$tgl_mulai, $tgl_selesai]);
            })
            ->get();

        $pdf = Pdf::loadView('admin.laporan.cetak', compact('laporans', 'tgl_mulai', 'tgl_selesai'));

        return $pdf->stream('Laporan-Transaksi.pdf');
    }
}