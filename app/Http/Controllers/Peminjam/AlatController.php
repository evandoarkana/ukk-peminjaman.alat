<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        // Fitur pencarian untuk memudahkan peminjam
        $search = $request->search;
        
        $alats = Alat::with('kategori')
            ->when($search, function($query) use ($search) {
                $query->where('nama_alat', 'like', "%{$search}%");
            })
            ->where('stok', '>', 0) // Hanya tampilkan alat yang ada stoknya
            ->latest()
            ->paginate(9);

        return view('peminjam.alat.index', compact('alats'));
    }
}