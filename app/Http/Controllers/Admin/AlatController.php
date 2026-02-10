<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller {
    public function index() {
        $alats = Alat::with('kategori')->latest()->paginate(10); // Query efisien dengan limit [cite: 54, 58]
        return view('admin.alat.index', compact('alats'));
    }

    public function create() {
        $kategoris = Kategori::all();
        return view('admin.alat.create', compact('kategoris'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_alat' => 'required',
            'kategori_id' => 'required',
            'stok' => 'required|integer|min:0'
        ]);

        Alat::create($request->all());
        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil ditambah');
    }

    public function edit(Alat $alat) {
        $kategoris = Kategori::all();
        return view('admin.alat.edit', compact('alat', 'kategoris'));
    }

    public function update(Request $request, Alat $alat) {
        $alat->update($request->all());
        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil diupdate');
    }

    public function destroy(Alat $alat) {
        $alat->delete();
        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil dihapus');
    }
}