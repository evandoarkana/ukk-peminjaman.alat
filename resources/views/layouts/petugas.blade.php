<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petugas - MINJAM BOY</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        /* Base Setup - Menyamakan dengan background Admin */
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

        /* SIDEBAR: Menggunakan warna yang sama dengan card admin (#1e2139) */
        .sidebar-fixed {
            width: 260px;
            background-color: #111827; /* Dark Slate Sidebar */
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

        /* Navigasi Link (Indigo Theme) */
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
            background: #6366f1; /* Indigo 500 */
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

        /* Tombol Logout Minimalis */
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

        /* ANIMASI KELAP-KELIP HIAJU (PULSE) */
        @keyframes pulse-emerald {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        .pulse-dot {
            display: inline-block;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #10b981; /* Emerald 500 */
            animation: pulse-emerald 2s infinite;
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <aside class="sidebar-fixed">
        {{-- Brand Section - DIBERIKAN INDIKATOR KELAP-KELIP IJO --}}
        <div class="p-6 border-b border-slate-800/50">
            <h1 class="text-white font-black text-xl tracking-tighter mb-1">MINJAM BOY</h1>
            <div class="flex items-center gap-2">
                <span class="pulse-dot"></span> {{-- Ini titik kelap-kelipnya --}}
                <p class="text-[10px] text-emerald-400 font-bold uppercase tracking-widest mb-0">Petugas </p>
            </div>
        </div>

        {{-- Main Navigation --}}
        <nav class="flex-1 overflow-y-auto pt-4">
            <a href="{{ route('petugas.dashboard') }}" class="nav-item-custom {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <div class="sidebar-label">Master Data</div>
            <a href="{{ route('petugas.alat.index') }}" class="nav-item-custom {{ request()->routeIs('petugas.alat.*') ? 'active' : '' }}">
                Data Alat
            </a>

            <div class="sidebar-label">Transaksi</div>
            <a href="{{ route('petugas.peminjaman.index') }}" class="nav-item-custom {{ request()->routeIs('petugas.peminjaman.*') ? 'active' : '' }}">
                Persetujuan
            </a>
            <a href="{{ route('petugas.pengembalian.index') }}" class="nav-item-custom {{ request()->routeIs('petugas.pengembalian.*') ? 'active' : '' }}">
                Pengembalian
            </a>

            <div class="sidebar-label">Laporan</div>
            <a href="{{ route('petugas.laporan.index') }}" class="nav-item-custom {{ request()->routeIs('petugas.laporan.*') ? 'active' : '' }}">
                Rekap Peminjaman
            </a>
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
        {{-- Header Breadcrumb (Persis Screenshot Admin) --}}
        <div class="mb-10">
            <h2 class="text-white text-2xl font-bold tracking-tight">Dashboard Overview</h2>
            <div class="flex items-center gap-2">
                <p class="text-slate-400 text-sm mb-0">Sistem Informasi Inventaris — </p>
                <span class="text-indigo-500 text-sm font-semibold">Petugas Utama</span>
            </div>
        </div>

        @yield('content')
    </main>
</div>

</body>
</html>