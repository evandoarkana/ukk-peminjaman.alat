<?php

namespace App\Http\Controllers\Peminjam; // Pastikan namespace ini sesuai folder Anda

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman; // <--- TARUH DI SINI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // 1. Menambahkan alat ke "Keranjang" (Session)
    public function addToCart(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $alat = Alat::findOrFail($request->alat_id);

        // Validasi stok alat sebelum masuk keranjang
        if ($request->jumlah > $alat->stok) {
            return back()->with('error', 'Stok ' . $alat->nama_alat . ' tidak mencukupi!');
        }

        $cart = session()->get('cart', []);

        // Jika barang sudah ada di keranjang, jumlahnya ditambah
        if(isset($cart[$alat->id])) {
            $cart[$alat->id]['jumlah'] += $request->jumlah;
        } else {
            $cart[$alat->id] = [
                "id" => $alat->id,
                "nama" => $alat->nama_alat,
                "jumlah" => $request->jumlah,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('peminjam.alat.index')->with('success', 'Alat berhasil ditambah ke daftar pinjam!');
    }

    // 2. Menampilkan halaman keranjang/checkout
    public function checkout()
    {
        $cart = session()->get('cart', []);
        return view('peminjam.transaksi.checkout', compact('cart'));
    }

    // 3. Menyimpan banyak barang dan jadwal ke Database
    public function store(Request $request)
    {
        $request->validate([
            'tgl_pinjam' => 'required|date|after_or_equal:today',
            'tgl_kembali_rencana' => 'required|date|after:tgl_pinjam',
        ]);

        $cart = session()->get('cart');
        if(!$cart) return redirect()->route('peminjam.alat.index')->with('error', 'Daftar pinjam kosong!');

        // Membuat Kode Transaksi Unik
        $kode_peminjaman = 'PMJ-' . date('YmdHis') . rand(10, 99);

        try {
            DB::transaction(function () use ($cart, $request, $kode_peminjaman) {
                // Simpan ke Tabel Peminjamans (Header)
                // Pastikan kolom alat_id di database sudah NULLABLE agar tidak error
                $peminjaman = Peminjaman::create([
                    'kode_peminjaman' => $kode_peminjaman,
                    'user_id' => auth()->id(),
                    'tgl_pinjam' => $request->tgl_pinjam,
                    'tgl_kembali_rencana' => $request->tgl_kembali_rencana,
                    'status' => 'menunggu',
                    'denda' => 0,
                    'alat_id' => null, // Dipaksa Null karena pindah ke tabel detail
                    'jumlah' => null   // Dipaksa Null karena pindah ke tabel detail
                ]);

                // Simpan ke Tabel Detail Peminjamans (Detail)
                foreach ($cart as $id => $details) {
                    DetailPeminjaman::create([
                        'peminjaman_id' => $peminjaman->id,
                        'alat_id' => $id,
                        'jumlah' => $details['jumlah'],
                    ]);

                    // Mengurangi stok alat secara otomatis
                    $alat = Alat::find($id);
                    if ($alat) {
                        $alat->decrement('stok', $details['jumlah']);
                    }
                }
            });

            session()->forget('cart');
            return redirect()->route('peminjam.alat.index')->with('success', 'Peminjaman ' . $kode_peminjaman . ' berhasil dijadwalkan!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // 4. Menghapus item dari keranjang
    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Alat dihapus dari daftar.');
    }

    public function history()
    {
        // Mengambil data riwayat milik user yang sedang login beserta detail alatnya
        $riwayat = Peminjaman::with(['detailPeminjaman.alat'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('peminjam.transaksi.riwayat', compact('riwayat'));
    }

    public function returning()
    {
        // Mengambil data yang statusnya 'disetujui' (artinya barang ada di tangan siswa)
        $pinjamanAktif = Peminjaman::with(['detailPeminjaman.alat'])
            ->where('user_id', auth()->id())
            ->where('status', 'disetujui')
            ->latest()
            ->get();

        return view('peminjam.transaksi.kembalikan', compact('pinjamanAktif'));
    }
}