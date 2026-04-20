<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - MINJAM BOY')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        /* Base Setup */
        html, body {
            height: 100%;
            margin: 0;
            background-color: #0f172a !important; 
            color: #f8fafc;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        .admin-wrapper { display: flex; min-height: 100vh; }

        /* SIDEBAR: Warna diselaraskan dengan card admin (#111827) */
        .sidebar { 
            width: 260px; 
            background-color: #111827; 
            border-right: 1px solid #1f2937; 
            display: flex; 
            flex-direction: column; 
            position: fixed; 
            height: 100vh; 
            z-index: 1000; 
        }

        .sidebar-header { 
            padding: 25px; 
            border-bottom: 1px solid rgba(255,255,255,0.05); 
        }

        .logo-text { 
            color: white; 
            font-weight: 900; 
            font-size: 1.25rem; 
            letter-spacing: -1px; 
            margin-bottom: 5px;
        }

        /* Navigasi Link (Indigo Style) */
        .sidebar-menu { flex: 1; padding: 15px; overflow-y: auto; }
        
        .menu-label { 
            color: #475569; 
            font-size: 10px; 
            font-weight: 800; 
            text-transform: uppercase; 
            letter-spacing: 1.5px; 
            margin: 25px 0 10px 15px; 
        }

        .nav-link { 
            display: flex; 
            align-items: center; 
            padding: 12px 15px; 
            color: #94a3b8; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 600; 
            border-radius: 10px; 
            transition: 0.3s; 
            margin-bottom: 4px; 
        }

        .nav-link:hover { background: rgba(99, 102, 241, 0.1); color: #818cf8; transform: translateX(5px); }
        .nav-link.active { background: #6366f1; color: white; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3); }

        /* AREA KONTEN */
        .main-content { 
            flex: 1; 
            margin-left: 260px; 
            background-color: #0f172a; 
            padding: 40px 50px; 
            min-height: 100vh; 
        }

        /* Tombol Logout Minimalis */
        .logout-box { padding: 20px; border-top: 1px solid rgba(255,255,255,0.05); }
        
        .btn-logout { 
            width: 100%; 
            padding: 12px; 
            background: transparent; 
            border: 1px solid #1f2937; 
            color: #4b5563; 
            border-radius: 10px; 
            font-weight: 700; 
            font-size: 11px; 
            letter-spacing: 1.5px; 
            text-transform: uppercase;
            cursor: pointer; 
            transition: 0.3s; 
        }

        .btn-logout:hover { border-color: #f43f5e; color: #f43f5e; background: rgba(244, 63, 94, 0.02); }

        /* ANIMASI KELAP-KELIP HIJAU */
        @keyframes pulse-green {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .pulse-dot {
            display: inline-block;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #10b981;
            animation: pulse-green 2s infinite;
            }
            
    </style>
</head>
<body>
<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-text">MINJAM BOY</div>
            <div class="flex items-center gap-2 mt-1">
                <span class="pulse-dot"></span>
                <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-widest mb-0">Admin Utama</p>
            </div>
        </div>

        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span>Dashboard</span>
            </a>

            <div class="menu-label">Master Data</div>
            <a href="{{ route('admin.alat.index') }}" class="nav-link {{ request()->routeIs('admin.alat.*') ? 'active' : '' }}">
                <span>Data Alat</span>
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                <span>Kategori</span>
            </a>
            <a href="{{ route('admin.user.index') }}" class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                <span>Manajemen User</span>
            </a>

            {{-- <div class="menu-label">Transaksi</div>
            {{-- <a href="{{ route('admin.peminjaman.index') }}" class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                <span>Peminjaman</span>
            </a> --}}
           {{--  <a href="{{ route('admin.pengembalian.index') }}" class="nav-link {{ request()->routeIs('admin.pengembalian.*') ? 'active' : '' }}">
                <span>Pengembalian</span>
            </a> --}}
 
            <div class="menu-label">Laporan</div>
            <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                <span>Laporan Peminjaman</span>
            </a>
        </nav>
        
        <div class="logout-box">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">LOGOUT SYSTEM</button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        {{-- Header Breadcrumb sesuai screenshot --}}
        {{-- <div class="mb-10">
            <h2 class="text-white text-2xl font-bold tracking-tight">Dashboard Overview</h2>
            <div class="flex items-center gap-2">
                <p class="text-slate-400 text-sm mb-0">Sistem Informasi Inventaris — </p>
                <span class="text-indigo-500 text-sm font-semibold">Admin Utama</span>
            </div>
        </div> --}}

        @yield('content')
    </main>
</div>
</body>
</html>