<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan Daftar User dengan Pagination
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Form Tambah User
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Simpan User Baru
     */
    public function store(Request $request)
{
    $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email:rfc,dns|unique:users', 
    'password' => [
        'required', 
        'string',
        'min:8', 
        'regex:/[a-z]/',      // Minimal 1 huruf kecil
        'regex:/[A-Z]/',      // Minimal 1 huruf kapital
        'regex:/[0-9]/',      // Minimal 1 angka
    ],
    'role' => 'required|in:admin,petugas,peminjam',
], [
    // Pesan Kustom (Custom Messages)
    'email.email' => 'Format email harus benar (menggunakan @ dan domain .com/.id/dll).',
    'password.min' => 'Password minimal harus 8 karakter.',
    'password.regex' => 'Password harus kombinasi dari huruf besar, huruf kecil, dan angka.',
    'role.required' => 'Pilih role user terlebih dahulu.',
]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan dengan keamanan tinggi.');
}
    /**
     * Form Edit User
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update Data User
     */
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email:rfc,dns|unique:users,email,'.$id,
        'role' => 'required|in:admin,petugas,peminjam',
    ];

    // Jika password diisi, maka wajib mengikuti aturan kombinasi
    if ($request->filled('password')) {
        $rules['password'] = [
            'min:8', 
            'regex:/[a-z]/', 
            'regex:/[A-Z]/', 
            'regex:/[0-9]/'
        ];
    }

    $request->validate($rules);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('admin.user.index')->with('success', 'Data user diperbarui dengan validasi yang benar.');
}

    /**
     * Hapus User dengan Peringatan Transaksi Aktif
     */
    public function destroy($id)
{
    $user = User::findOrFail($id);

    if (auth()->id() == $id) {
        return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
    }

    // 1. Cek apakah ada transaksi yang BELUM selesai
    $transaksiAktif = \App\Models\Peminjaman::where('user_id', $id)
                        ->whereIn('status', ['dipinjam', 'diproses', 'terlambat']) 
                        ->exists();

    if ($transaksiAktif) {
        return redirect()->back()->with('error', 'Gagal hapus! User masih meminjam alat. Harap kembalikan alat dulu.');
    }

    try {
        // 2. HAPUS RIWAYAT: Bersihkan semua data transaksi user ini (meskipun sudah kembali)
        // Ini dilakukan agar Foreign Key tidak lagi menjegal penghapusan user
        \App\Models\Peminjaman::where('user_id', $id)->delete();

        // 3. Hapus User
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User dan semua riwayat transaksinya berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menghapus karena masalah database.');
    }
}
     /* Menampilkan detail pengguna tertentu.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.show', compact('user'));
    }
} // Penutup Class UserController (Wajib Ada)