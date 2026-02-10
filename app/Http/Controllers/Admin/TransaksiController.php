<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Alat;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Menampilkan daftar peminjaman yang aktif [cite: 30]
     * Data dikelompokkan berdasarkan kode_peminjaman agar muncul dalam satu baris [cite: 54]
     */
    public function indexPeminjaman() {
        $peminjamans = Peminjaman::with(['user', 'detailPeminjaman.alat']) // WAJIB ADA INI
            ->where('status', 'disetujui')
            ->latest()
            ->get()
            ->groupBy('kode_peminjaman');
        return view('admin.transaksi.peminjaman_index', compact('peminjamans'));
    }
    /**
     * Menampilkan form untuk membuat peminjaman baru [cite: 27]
     */
    public function createPeminjaman()
    {
        $users = User::where('role', 'peminjam')->get();
        $alats = Alat::where('stok', '>', 0)->get();

        return view('admin.transaksi.peminjaman_create', compact('users', 'alats'));
    }

    /**
     * Menyimpan data peminjaman massal (Multi-Barang) 
     * Menggunakan Database Transaction untuk keamanan data (Commit & Rollback) 
     */
    public function storePeminjaman(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'alat_id' => 'required|array|min:1',
            'alat_id.*' => 'exists:alats,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali_rencana' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        // Membuat kode unik sebagai identitas satu transaksi
        $kode = 'PMJ-' . \Carbon\Carbon::now()->format('YmdHis');

        try {
            DB::beginTransaction();

            // 1. Simpan ke Tabel Header (Peminjaman) 
            // Cukup buat SATU baris untuk satu Kode Transaksi
            $peminjamanHeader = \App\Models\Peminjaman::create([
                'kode_peminjaman' => $kode,
                'user_id'         => $request->user_id,
                'tgl_pinjam'      => $request->tgl_pinjam,
                'tgl_kembali_rencana' => $request->tgl_kembali_rencana,
                'status'          => 'disetujui',
                'petugas_id'      => auth()->id(),
                'denda'           => 0
            ]);

            // 2. Simpan ke Tabel Detail (DetailPeminjaman)
            // Looping dilakukan di sini untuk setiap alat yang dipilih
            foreach ($request->alat_id as $key => $id) {
                $qty = $request->jumlah[$key];
                $alat = \App\Models\Alat::findOrFail($id);

                if ($alat->stok < $qty) {
                    throw new \Exception("Stok alat '{$alat->nama_alat}' tidak mencukupi.");
                }

                // Simpan rincian barang ke tabel detail
                \App\Models\DetailPeminjaman::create([
                    'peminjaman_id' => $peminjamanHeader->id,
                    'alat_id'       => $id,
                    'jumlah'        => $qty,
                ]);

                // Update stok alat
                $alat->decrement('stok', $qty);
            }

            // 3. Pencatatan Log Aktivitas Admin
            \App\Models\ActivityLog::create([
                'user_id'   => auth()->id(),
                'aktivitas' => 'Peminjaman Alat (Admin)',
                'deskripsi' => auth()->user()->name . ' memproses transaksi baru: ' . $kode,
                'ip_address'=> request()->ip(),
            ]);

            DB::commit();
            return redirect()->route('admin.peminjaman.index')->with('success', 'Transaksi peminjaman berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Menampilkan riwayat pengembalian alat [cite: 30]
     */
    public function indexPengembalian()
    {
        $pengembalians = Pengembalian::with(['peminjaman.user', 'peminjaman.alat', 'petugas'])
            ->latest()
            ->paginate(10);

        return view('admin.transaksi.pengembalian_index', compact('pengembalians'));
    }

    /**
     * Halaman konfirmasi untuk menghitung denda sebelum dikembalikan [cite: 47]
     */
    /**
 * Tahap 1: Konfirmasi Pengembalian Massal berdasarkan KODE
 */
    public function konfirmasiPengembalian($kode)
    {
        // Eager Loading sangat penting agar data alat tidak NULL di Blade
        $items = Peminjaman::with(['user', 'detailPeminjaman.alat'])
                    ->where('kode_peminjaman', $kode)
                    ->where('status', 'disetujui') // Tambahan: Pastikan hanya yang statusnya dipinjam
                    ->get();

        if ($items->isEmpty()) {
            return redirect()->route('admin.peminjaman.index')->with('error', 'Data transaksi tidak ditemukan atau sudah dikembalikan.');
        }

        $first = $items->first();

        // Logika Perhitungan Hari: Paksa ke jam 00:00:00 agar akurat
        $tgl_rencana = \Carbon\Carbon::parse($first->tgl_kembali_rencana)->startOfDay();
        $tgl_aktual = \Carbon\Carbon::now(); // Simpan waktu asli untuk database
        $tgl_pembanding = \Carbon\Carbon::now()->startOfDay(); // Hanya untuk hitung selisih hari

        $denda = 0;
        $hari_terlambat = 0;
        $tarif_denda = 5000; 

        // Periksa keterlambatan menggunakan tanggal pembanding (00:00:00)
        if ($tgl_pembanding->gt($tgl_rencana)) {
            $hari_terlambat = $tgl_pembanding->diffInDays($tgl_rencana);
            $denda = $hari_terlambat * $tarif_denda;
        }

        return view('admin.transaksi.peminjaman_konfirmasi', compact(
            'items', 'first', 'tgl_aktual', 'denda', 'hari_terlambat', 'kode'
        ));
    }

    /**
     * Tahap 2: Proses Simpan Pengembalian Massal
     */
    public function storePengembalian(Request $request, $kode)
    {
        $request->validate([
            'tgl_kembali_aktual' => 'required',
            'denda' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            // 1. Ambil semua data peminjaman berdasarkan kode transaksi
            $items = Peminjaman::with('detailPeminjaman.alat')
                ->where('kode_peminjaman', $kode)
                ->where('status', 'disetujui')
                ->get();

            if ($items->isEmpty()) {
                throw new \Exception("Data transaksi dengan kode $kode tidak ditemukan atau sudah diproses.");
            }

            foreach ($items as $index => $peminjaman) {
                /** * STRATEGI ANTI-DUPLIKASI DENDA:
                 * Denda hanya dimasukkan ke baris pertama ($index == 0).
                 * Baris selebihnya diisi 0 agar total denda di database tidak berlipat ganda.
                 */
                $nominalDenda = ($index == 0) ? $request->denda : 0;

                // 2. Simpan ke tabel pengembalian
                Pengembalian::create([
                    'peminjaman_id'      => $peminjaman->id,
                    'tgl_kembali_aktual' => $request->tgl_kembali_aktual,
                    'denda'              => $nominalDenda, 
                    'petugas_id'         => auth()->id(),
                ]);

                // 3. Update status peminjaman menjadi 'selesai'
                $peminjaman->update(['status' => 'selesai']);
                
                // 4. Kembalikan stok untuk semua alat di tabel detail
                foreach ($peminjaman->detailPeminjaman as $detail) {
                    if ($detail->alat) {
                        $detail->alat->increment('stok', $detail->jumlah);
                    }
                }
            }

            // 5. Pencatatan Log Aktivitas
            \App\Models\ActivityLog::create([
                'user_id'   => auth()->id(),
                'aktivitas' => 'Pengembalian Massal',
                'deskripsi' => auth()->user()->name . ' memproses pengembalian kode: ' . $kode . ' (Denda: Rp ' . number_format($request->denda) . ')',
                'ip_address'=> request()->ip(),
            ]);

            DB::commit();
            return redirect()->route('admin.peminjaman.index')->with('success', 'Semua alat berhasil dikembalikan dan denda tercatat.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }

    public function simpanPengembalian(Request $request, $id)
    {
        // Cari data Header Peminjaman beserta rincian alat di tabel detail
        $peminjaman = Peminjaman::with('detailPeminjaman.alat')->findOrFail($id);

        try {
            DB::beginTransaction();

            // 1. Update status di tabel peminjamans (Header)
            $peminjaman->update([
                'status' => 'selesai',
                'tgl_kembali_real' => now(),
                'denda' => $request->input('denda', 0),
                'petugas_id' => auth()->id()
            ]);

            // 2. Kembalikan stok untuk semua alat yang ada di detail peminjaman
            foreach ($peminjaman->detailPeminjaman as $detail) {
                if ($detail->alat) {
                    $detail->alat->increment('stok', $detail->jumlah);
                }
            }

            // 3. Catat Log Aktivitas Petugas
            ActivityLog::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Proses Pengembalian',
                'deskripsi' => auth()->user()->name . ' memproses pengembalian kode: ' . $peminjaman->kode_peminjaman,
                'ip_address' => request()->ip(),
            ]);

            DB::commit();
            return redirect()->route('petugas.pengembalian.index')
                             ->with('success', 'Barang berhasil diterima dan stok gudang telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memproses data: ' . $e->getMessage());
        }
    }
}