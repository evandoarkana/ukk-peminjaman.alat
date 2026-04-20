<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // ===============================
    // APPROVAL
    // ===============================
    public function indexApproval()
    {
        $peminjamans = Peminjaman::with([
                'user',
                'detailPeminjaman.alat'
            ])
            ->where('status', 'menunggu')
            ->latest()
            ->get();

        return view('petugas.peminjaman.approval', compact('peminjamans'));
    }

    // ===============================
    // PENGEMBALIAN
    // ===============================
    public function indexPengembalian()
    {
        $peminjamans = Peminjaman::with([
                'user',
                'detailPeminjaman.alat'
            ])
            ->where('status', 'disetujui')
            ->latest()
            ->get();

        return view('petugas.pengembalian.index', compact('peminjamans'));
    }

    // ===============================
    // CEK DENDA (FIX ERROR DI SINI)
    // ===============================
    public function cekDenda($id)
    {
        $peminjaman = Peminjaman::with('user', 'detailPeminjaman.alat')
            ->findOrFail($id);

        $tglRencana = \Carbon\Carbon::parse($peminjaman->tgl_kembali_rencana);
        $hariTelat = $tglRencana->diffInDays(now(), false);

        return view('petugas.pengembalian.denda', compact(
            'peminjaman',
            'hariTelat'
        ));
    }

    // ===============================
    // KONFIRMASI PENGEMBALIAN
    // ===============================
    public function konfirmasiKembali(Request $request, $id)
{
    $peminjaman = Peminjaman::with('detailPeminjaman.alat')
        ->findOrFail($id);

    DB::beginTransaction();

    try {
        $peminjaman->update([
            'status' => 'selesai', // 🔥 masuk ke laporan
            'tgl_kembali_real' => now(),
            'denda' => $request->denda ?? 0
        ]);

        foreach ($peminjaman->detailPeminjaman ?? [] as $detail) {
            if ($detail->alat) {
                $detail->alat->increment('stok', $detail->jumlah);
            }
        }

        DB::commit();

        // 🔥 INI YANG KAMU MAU
        return redirect()
            ->route('petugas.pengembalian.index')
            ->with('success', 'Denda berhasil diinput & barang dikembalikan');

    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Gagal: ' . $e->getMessage());
    }
}
    // ===============================
    // SETUJUI
    // ===============================
    public function setujui($id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.alat')->findOrFail($id);

        DB::beginTransaction();

        try {
            $peminjaman->update([
                'status' => 'disetujui'
            ]);

            foreach ($peminjaman->detailPeminjaman ?? [] as $detail) {
                if ($detail->alat) {
                    $detail->alat->decrement('stok', $detail->jumlah);
                }
            }

            DB::commit();

            return back()->with('success', 'Disetujui');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal');
        }
    }

    // ===============================
    // TOLAK
    // ===============================
    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'status' => 'ditolak'
        ]);

        return back()->with('success', 'Ditolak');
    }
}