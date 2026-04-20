<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // HALAMAN LAPORAN
    public function index(Request $request)
    {
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        $laporans = Peminjaman::with(['user', 'alat'])
            ->when($tgl_mulai && $tgl_selesai, function ($query) use ($tgl_mulai, $tgl_selesai) {
                return $query->whereBetween('tgl_pinjam', [$tgl_mulai, $tgl_selesai]);
            })
            ->latest()
            ->get();

        return view('petugas.laporan.index', compact('laporans', 'tgl_mulai', 'tgl_selesai'));
    }

    // CETAK PDF
    public function cetakPdf(Request $request)
    {
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        $query = Peminjaman::with(['user', 'alat']);

        if ($tgl_mulai && $tgl_selesai) {
            $query->whereBetween('tgl_pinjam', [$tgl_mulai, $tgl_selesai]);
        }

        $laporans = $query->get();

        $pdf = Pdf::loadView('petugas.laporan.cetak', compact('laporans', 'tgl_mulai', 'tgl_selesai'));

        return $pdf->stream('laporan-petugas.pdf');
    }
}