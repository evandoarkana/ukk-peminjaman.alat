<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

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

        .login-box {
            width: 350px;
            background: #1e293b;
            padding: 30px;
            border-radius: 20px;
            border: 1px solid #334155;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            text-align: center;
        }

        .title {
            color: #f8fafc;
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            border-radius: 10px;
            border: 1px solid #334155;
            background: #020617;
            color: white;
        }

        input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
        }

        button {
            width: 100%;
            margin-top: 18px;
            padding: 12px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            color: white;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(99,102,241,0.4);
        }

        .error {
            color: #f87171;
            font-size: 13px;
            margin-top: 10px;
        }

        .back {
            margin-top: 15px;
            display: block;
            color: #818cf8;
            font-size: 13px;
            text-decoration: none;
        }
    </style>
</head>

<body>

@php
    $role = $role ?? null;
@endphp

<div class="login-box">

    <div class="title">
        🔐 Login {{ ucfirst($role) }}
    </div>

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ url('/login/'.$role) }}">
        @csrf

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Masuk</button>
    </form>

    <a href="/login" class="back">← Kembali pilih role</a>

</div>

</body>
</html>