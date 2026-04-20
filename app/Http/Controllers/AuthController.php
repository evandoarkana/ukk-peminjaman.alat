<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // TAMPILKAN PILIH ROLE
    public function pilihRole()
    {
        return view('auth.pilih-role');
    }

    // TAMPILKAN FORM LOGIN SESUAI ROLE
    public function showLogin($role)
    {
        $allowed = ['admin', 'petugas', 'peminjam'];

        if (!in_array(strtolower($role), $allowed)) {
            abort(404);
        }

        return view('auth.login', ['role' => strtolower($role)]);
    }

    // PROSES LOGIN
    public function login(Request $request, $role)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $userRole = strtolower(auth()->user()->role);

            // ❗ VALIDASI ROLE HARUS SESUAI URL
            if ($userRole != strtolower($role)) {
                Auth::logout();
                return back()->with('error', 'Role tidak sesuai!');
            }

            // REDIRECT SESUAI ROLE DB
            if ($userRole == 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($userRole == 'petugas') {
                return redirect('/petugas/dashboard');
            } else {
                return redirect('/peminjam/dashboard');
            }
        }

        return back()->with('error', 'Email atau password salah!');
    }

    // LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}