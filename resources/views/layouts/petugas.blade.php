<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petugas - MINJAM BOY</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        /* Memastikan dasar aplikasi selalu gelap dan setinggi layar */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #0f172a !important; /* Slate 900 */
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
            background-color: #0f172a;
        }

        /* SIDEBAR: Dikunci di kiri agar tidak bergeser */
        .sidebar-fixed {
            width: 260px;
            background-color: #1e293b; /* Slate 800 */
            border-right: 1px solid #334155;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        /* AREA KONTEN: Didorong ke kanan agar tidak tertutup sidebar */
        .content-main {
            flex: 1;
            margin-left: 260px; /* Jarak harus sama dengan lebar sidebar */
            background-color: #0f172a;
            min-height: 100vh;
            padding: 40px;
        }

        /* Navigasi Link Custom */
        .nav-item-custom {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 600;
            border-radius: 12px;
            margin: 4px 15px;
            transition: 0.3s;
        }

        .nav-item-custom:hover {
            background: rgba(99, 102, 241, 0.1);
            color: #818cf8;
        }

        .nav-item-custom.active {
            background: #6366f1;
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .sidebar-label {
            color: #475569;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 25px 0 10px 30px;
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <aside class="sidebar-fixed">
        <div class="p-6 border-b border-slate-800/50">
            <h1 class="text-white font-black text-xl tracking-tighter">MINJAM BOY</h1>
            <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-widest">Petugas Panel</p>
        </div>

        <nav class="flex-1 overflow-y-auto py-4">
            <a href="{{ route('petugas.dashboard') }}" class="nav-item-custom {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <div class="sidebar-label">Layanan</div>
            <a href="{{ route('petugas.peminjaman.index') }}" class="nav-item-custom {{ request()->routeIs('petugas.peminjaman.*') ? 'active' : '' }}">
                Persetujuan
            </a>
            <a href="{{ route('petugas.pengembalian.index') }}" class="nav-item-custom {{ request()->routeIs('petugas.pengembalian.*') ? 'active' : '' }}">
                Pengembalian
            </a>
            <a href="{{ route('petugas.alat.index') }}" class="nav-item-custom {{ request()->routeIs('petugas.alat.*') ? 'active' : '' }}">
                Stok Alat
            </a>
        </nav>

        <div class="p-5 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-xs border border-slate-700 text-slate-500 hover:text-rose-500 hover:border-rose-500 transition-all duration-300">
                    LOGOUT SYSTEM
                </button>
            </form>
        </div>
    </aside>

    <main class="content-main">
        @yield('content')
    </main>
</div>

</body>
</html>