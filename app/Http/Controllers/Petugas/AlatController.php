<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        // Mengambil data alat beserta kategorinya
        $alats = Alat::with('kategori')->latest()->get();
        
        return view('petugas.alat.index', compact('alats'));
    }
}
