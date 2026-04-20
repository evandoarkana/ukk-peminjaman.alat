<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa - MINJAM BOY</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        /* Base Setup - Menyamakan dengan standard Admin Utama */
        html, body {
            height: 100%;
            margin: 0;
            background-color: #0f172a !important; 
            color: #f8fafc;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR: Menyamakan dengan warna sidebar admin yang lebih solid */
        .sidebar-fixed {
            width: 260px;
            background-color: #111827; 
            border-right: 1px solid #1f2937;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        /* AREA KONTEN */
        .content-main {
            flex: 1;
            margin-left: 260px;
            background-color: #0f172a;
            min-height: 100vh;
            padding: 40px 50px;
        }

        /* Navigasi Link (Sesuai gaya Admin) */
        .nav-item-custom {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
            margin: 4px 15px;
            transition: all 0.2s ease;
        }

        .nav-item-custom:hover {
            color: #818cf8;
            background: rgba(99, 102, 241, 0.05);
        }

        .nav-item-custom.active {
            background: #6366f1; /* Indigo matching Admin */
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.2);
        }

        .sidebar-label {
            color: #475569;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 25px 0 10px 30px;
        }

        /* Tombol Logout (Minimalis Gray-Red) */
        .btn-logout {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 1.5px;
            border: 1px solid #1f2937;
            color: #4b5563;
            background: transparent;
            transition: 0.3s;
            text-transform: uppercase;
        }

        .btn-logout:hover {
            color: #f43f5e;
            border-color: rgba(244, 63, 94, 0.5);
            background: rgba(244, 63, 94, 0.02);
        }

        /* STYLE CARD UNTUK SISWA (Sama dengan Admin Card) */
        .student-card {
            background-color: #1e2139; /* Warna card ungu pekat sesuai gambar */
            border-radius: 12px;
            border-bottom: 4px solid #10b981; /* Aksen hijau untuk membedakan dengan Admin */
            padding: 25px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="main-wrapper">
        <aside class="sidebar-fixed">
            {{-- Brand Section --}}
            <div class="p-6">
                <h1 class="text-white font-black text-xl tracking-tighter mb-0">MINJAM BOY</h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <p class="text-[10px] text-emerald-400 font-bold uppercase tracking-widest mb-0">Siswa Dashboard</p>
                </div>
            </div>

            {{-- Main Navigation --}}
            <nav class="flex-1 overflow-y-auto">
                <a href="{{ route('peminjam.dashboard') }}" class="nav-item-custom {{ request()->routeIs('peminjam.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <div class="sidebar-label">Layanan Pinjam</div>
                <a href="{{ route('peminjam.alat.index') }}" class="nav-item-custom {{ request()->routeIs('peminjam.alat.index') ? 'active' : '' }}">
                    Daftar Alat
                </a>
                <a href="{{ route('peminjam.checkout') }}" class="nav-item-custom {{ request()->routeIs('peminjam.checkout') ? 'active' : '' }}">
                    Daftar Pinjam
                </a>
                <a href="{{ route('peminjam.kembalikan') }}" class="nav-item-custom {{ request()->routeIs('peminjam.kembalikan') ? 'active' : '' }}">
                    Kembalikan Alat
                </a>

                <div class="sidebar-label">Riwayat & Finansial</div>
                <a href="{{ route('peminjam.riwayat') }}" class="nav-item-custom {{ request()->routeIs('peminjam.riwayat') ? 'active' : '' }}">
                    Riwayat Peminjaman
                </a>
                {{-- <a href="#" class="nav-item-custom">
                    Pembayaran Denda
                </a> --}}
            </nav>

            {{-- Footer Sidebar --}}
            <div class="p-5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        LOGOUT SYSTEM
                    </button>
                </form>
            </div>
        </aside>

        <main class="content-main">
            {{-- Header Title (Meniru gaya screenshot Admin) --}}
            <div class="mb-10">
                <h2 class="text-white text-2xl font-bold tracking-tight">Student Overview</h2>
                <div class="flex items-center gap-2">
                    <p class="text-slate-400 text-sm mb-0">Sistem Informasi Inventaris — </p>
                    <span class="text-emerald-500 text-sm font-semibold">Siswa Utama</span>
                </div>
            </div>

            @yield('content')
        </main>
    </div>

</body>
</html>