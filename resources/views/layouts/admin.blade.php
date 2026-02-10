<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - UKK Alat')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        /* RESET DASAR */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; color: #cbd5e1; }

        .admin-wrapper { display: flex; min-height: 100vh; }

        /* SIDEBAR FIX */
        .sidebar {
            width: 260px;
            background-color: #1e293b;
            border-right: 1px solid #334155;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }

        .sidebar-header { padding: 25px; border-bottom: 1px solid #334155; }
        .logo-text { color: white; font-weight: 800; font-size: 1.2rem; letter-spacing: -1px; }

        .sidebar-menu { flex: 1; padding: 20px; overflow-y: auto; }
        .menu-label { color: #475569; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin: 20px 0 10px 10px; }
        
        .nav-link { 
            display: block; padding: 12px 15px; color: #94a3b8; text-decoration: none; 
            font-size: 14px; font-weight: 600; border-radius: 10px; transition: 0.3s; margin-bottom: 5px;
        }
        .nav-link:hover { background: rgba(99, 102, 241, 0.1); color: #818cf8; }
        .nav-link.active { background: #6366f1; color: white; }

        /* CONTENT AREA FIX */
        .main-content {
            flex: 1;
            margin-left: 260px; /* Sesuai lebar sidebar */
            background-color: #0f172a;
            padding: 40px;
            min-height: 100vh;
        }

        .logout-box { padding: 20px; border-top: 1px solid #334155; }
        .btn-logout {
            width: 100%; padding: 10px; background: transparent; border: 1px solid #334155;
            color: #64748b; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.3s;
        }
        .btn-logout:hover { border-color: #f43f5e; color: #f43f5e; background: rgba(244, 63, 94, 0.05); }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-text">MINJAM BOY</div>
        </div>

        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>

            <div class="menu-label">Master Data</div>
            <a href="{{ route('admin.alat.index') }}" class="nav-link {{ request()->routeIs('admin.alat.*') ? 'active' : '' }}">Data Alat</a>
            <a href="{{ route('admin.kategori.index') }}" class="nav-link">Kategori</a>

            <div class="menu-label">Transaksi</div>
            <a href="{{ route('admin.peminjaman.index') }}" class="nav-link">Peminjaman</a>
            <a href="{{ route('admin.pengembalian.index') }}" class="nav-link">Pengembalian</a>
        </nav>

        <div class="logout-box">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">LOGOUT SYSTEM</button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>
</div>

</body>
</html>