<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa - MINJAM BOY</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        /* Base Reset & Full Background */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #0f172a !important; /* Slate 900 */
            color: #f8fafc;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Siswa - Dark Slate */
        .sidebar {
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

        /* Content Area Push */
        .content-area {
            flex: 1;
            margin-left: 260px;
            background-color: #0f172a;
            min-height: 100vh;
            padding: 40px;
        }

        /* Navigasi Link Siswa */
        .nav-link-student {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border-radius: 12px;
            margin: 4px 15px;
            transition: all 0.3s ease;
        }

        .nav-link-student:hover {
            background: rgba(99, 102, 241, 0.1);
            color: #818cf8;
        }

        .nav-link-student.active {
            background: #6366f1; /* Indigo 500 */
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .menu-label {
            color: #475569;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 25px 0 10px 30px;
        }

        /* Tombol Logout Keren */
        .btn-logout-student {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            background: rgba(244, 63, 94, 0.05);
            border: 1px solid rgba(244, 63, 94, 0.2);
            border-radius: 14px;
            color: #fb7185;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-logout-student:hover {
            background: #f43f5e;
            color: white;
            box-shadow: 0 10px 20px -5px rgba(244, 63, 94, 0.4);
        }
    </style>
</head>

<body>

    <div class="main-wrapper">

        <aside class="sidebar">
            <div class="p-6 border-b border-slate-800/50">
                <h1 class="text-white font-black text-xl tracking-tighter">MINJAM BOY</h1>
                <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-widest">Siswa Dashboard</p>
            </div>

            <nav class="flex-1 overflow-y-auto py-4">
                {{-- Dashboard --}}
                <a href="" class="nav-link-student {{ request()->routeIs('peminjam.dashboard') ? 'active' : '' }}">
                    🏠 Dashboard
                </a>

                <div class="menu-label">Layanan Pinjam</div>

                {{-- Daftar Alat --}}
                <a href="{{ route('peminjam.alat.index') }}" 
                   class="nav-link-student {{ request()->routeIs('peminjam.alat.index') ? 'active' : '' }}">
                    📦 Daftar Alat
                </a>

                {{-- Daftar Pinjam --}}
                <a href="{{ route('peminjam.checkout') }}" 
                   class="nav-link-student {{ request()->routeIs('peminjam.checkout') ? 'active' : '' }}">
                    ➕ Daftar Pinjam
                </a>

                {{-- Kembalikan Alat --}}
                <a href="{{ route('peminjam.kembalikan') }}" 
                   class="nav-link-student {{ request()->routeIs('peminjam.kembalikan') ? 'active' : '' }}">
                    ↩️ Kembalikan Alat
                </a>

                <div class="menu-label">Riwayat & Finansial</div>

                {{-- Riwayat --}}
                <a href="{{ route('peminjam.riwayat') }}" 
                   class="nav-link-student {{ request()->routeIs('peminjam.riwayat') ? 'active' : '' }}">
                    📚 Riwayat Peminjaman
                </a>

                {{-- Pembayaran Denda --}}
                <a href="" class="nav-link-student {{ request()->routeIs('peminjam.denda') ? 'active' : '' }}">
                    💰 Pembayaran Denda
                </a>
            </nav>

            {{-- Bagian Logout --}}
            <div class="p-5 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout-student">
                        <span>🚪 LOGOUT SYSTEM</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="content-area">
            @yield('content')
        </main>

    </div>

</body>

</html>