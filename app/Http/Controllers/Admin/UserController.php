<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * 1. Menampilkan Daftar User (Read)
     * Menggunakan pagination agar halaman memuat dengan cepat sesuai instruksi soal.
     */
    public function index()
    {
        // Poin 54 & 58: Gunakan pagination untuk efisiensi data besar
        $users = User::latest()->paginate(10); 
        return view('admin.user.index', compact('users'));
    }

    /**
     * 2. Menampilkan Form Tambah (Create)
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * 3. Menyimpan User Baru (Store)
     * Melakukan validasi input sesuai spesifikasi role (Privilege User).
     */
    public function store(Request $request)
    {
        // PERBAIKAN: Pastikan View Anda memiliki input 'name', 'email', 'password', dan 'role'
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,petugas,peminjam', // Sesuai Poin 28 & 30
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Poin 53: Best Practices keamanan
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dibuat!');
    }

    /**
     * 4. Menampilkan Form Edit
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    /**
     * 5. Memperbarui Data User (Update)
     * Menangani pembaruan data secara selektif (Cek privilege user).
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6', // Password opsional saat update
            'role'     => 'required|in:admin,petugas,peminjam',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * 6. Menghapus User (Delete)
     */
    public function destroy(User $user)
    {
        // Mencegah penghapusan diri sendiri untuk menjaga kestabilan sistem
        if (auth()->id() == $user->id) {
            return redirect()->route('admin.user.index')->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus!');
    }
}