<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    // ===============================
    // TAMBAH KE CART
    // ===============================
    public function addToCart(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $alat = Alat::findOrFail($request->alat_id);

        if ($request->jumlah > $alat->stok) {
            return back()->with('error', 'Stok ' . $alat->nama_alat . ' tidak mencukupi!');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$alat->id])) {
            $cart[$alat->id]['jumlah'] += $request->jumlah;
        } else {
            $cart[$alat->id] = [
                "id" => $alat->id,
                "nama" => $alat->nama_alat,
                "jumlah" => $request->jumlah,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('peminjam.alat.index')
            ->with('success', 'Alat berhasil ditambah ke daftar pinjam!');
    }

    // ===============================
    // HALAMAN CHECKOUT
    // ===============================
    public function checkout()
    {
        $cart = session()->get('cart', []);
        return view('peminjam.transaksi.checkout', compact('cart'));
    }

    // ===============================
    // SIMPAN KE DATABASE (FIXED)
    // ===============================
    public function store(Request $request)
    {
        // 🔒 Pastikan user login
        if (!auth()->check()) {
            return back()->with('error', 'Silakan login terlebih dahulu!');
        }

        // ✅ Validasi
        $request->validate([
            'tgl_pinjam' => 'required|date|after_or_equal:today',
            'tgl_kembali_rencana' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        // 🛒 Ambil cart
        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            return back()->with('error', 'Daftar pinjam kosong!');
        }

        try {
            DB::beginTransaction();

            foreach ($cart as $id => $item) {
                Peminjaman::create([
                    'user_id'             => auth()->id(),
                    'alat_id'             => $id,
                    'jumlah'              => $item['jumlah'],
                    'tgl_pinjam'          => $request->tgl_pinjam,
                    'tgl_kembali_rencana' => $request->tgl_kembali_rencana,
                    'status'              => 'menunggu',
                    'kode_peminjaman'     => 'PMJ-' . strtoupper(Str::random(6)),
                ]);
            }

            DB::commit();

            session()->forget('cart');

            return redirect()->route('peminjam.riwayat')
                ->with('success', 'Pengajuan berhasil dikirim!');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // ===============================
    // HAPUS CART
    // ===============================
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Alat dihapus dari daftar.');
    }

    // ===============================
    // RIWAYAT
    // ===============================
    public function history()
    {
        $riwayat = Peminjaman::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('peminjam.transaksi.riwayat', compact('riwayat'));
    }

public function returning()
{
    $peminjamans = \App\Models\Peminjaman::with('detailPeminjaman.alat')
        ->where('user_id', auth()->id())
        ->where('status', 'disetujui') // yang masih dipinjam
        ->latest()
        ->get();

    return view('peminjam.transaksi.kembalikan', [
        'pinjamanAktif' => $peminjamans
    ]);
}
    }