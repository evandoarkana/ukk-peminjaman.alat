<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pilih Login</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #020617, #0f172a);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            text-align: center;
        }

        .title {
            color: #f8fafc;
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 40px;
        }

        .card-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .card {
            width: 200px;
            padding: 25px;
            border-radius: 16px;
            background: #1e293b;
            border: 1px solid #334155;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-8px);
            border-color: #6366f1;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.4);
        }

        .icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .label {
            font-size: 16px;
            font-weight: 700;
            color: #f1f5f9;
        }

        /* Warna khusus tiap role */
        .admin .icon { color: #f43f5e; }
        .petugas .icon { color: #6366f1; }
        .peminjam .icon { color: #22c55e; }

        .admin:hover { border-color: #f43f5e; }
        .petugas:hover { border-color: #6366f1; }
        .peminjam:hover { border-color: #22c55e; }

        /* Glow effect */
        .card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: 0.3s;
        }

        .admin:hover::before {
            background: radial-gradient(circle, rgba(244,63,94,0.2), transparent);
            opacity: 1;
        }

        .petugas:hover::before {
            background: radial-gradient(circle, rgba(99,102,241,0.2), transparent);
            opacity: 1;
        }

        .peminjam:hover::before {
            background: radial-gradient(circle, rgba(34,197,94,0.2), transparent);
            opacity: 1;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="title">🔐 Pilih Login</div>
    <div class="subtitle">Silakan masuk sesuai peran Anda</div>

    <div class="card-group">

        <a href="/login/admin" class="card admin">
            <div class="icon">👑</div>
            <div class="label">Admin</div>
        </a>

        <a href="/login/petugas" class="card petugas">
            <div class="icon">🛠️</div>
            <div class="label">Petugas</div>
        </a>

        <a href="/login/peminjam" class="card peminjam">
            <div class="icon">📦</div>
            <div class="label">Peminjam</div>
        </a>

    </div>

</div>

</body>
</html>