<x-guest-layout>
    <style>
        /* Menimpa background x-guest-layout agar full Slate 900 */
        body, .min-h-screen {
            background-color: #0f172a !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Styling Kartu Login */
        .min-h-screen > div:nth-child(2) {
            background-color: #1e293b !important; /* Slate 800 */
            border: 1px solid #334155;
            border-radius: 24px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
            padding: 40px !important;
            width: 100%;
            max-width: 420px;
        }

        /* Judul Tambahan */
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h2 {
            color: white;
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }
        .login-header p {
            color: #64748b;
            font-size: 0.875rem;
        }

        /* Menyesuaikan Label */
        label, .text-gray-600 {
            color: #94a3b8 !important;
            font-weight: 600 !important;
            font-size: 0.75rem !important;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Menyesuaikan Input */
        input[type="email"], input[type="password"] {
            background-color: #0f172a !important;
            border: 1px solid #334155 !important;
            color: white !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
            transition: all 0.3s !important;
        }

        input:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
        }

        /* Tombol Utama */
        button, .inline-flex.items-center.px-4.py-2.bg-gray-800 {
            background-color: #6366f1 !important;
            color: white !important;
            border-radius: 12px !important;
            width: 100%;
            justify-content: center;
            padding: 12px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            transition: all 0.3s !important;
        }

        button:hover {
            background-color: #4f46e5 !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4) !important;
        }

        /* Link & Checkbox */
        a {
            color: #818cf8 !important;
            font-weight: 600 !important;
            text-decoration: none !important;
        }
        a:hover { color: #6366f1 !important; }

        input[type="checkbox"] {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            border-radius: 4px !important;
        }
        input[type="checkbox"]:checked {
            background-color: #6366f1 !important;
        }
    </style>

    <div class="login-header">
        <h2>LOGIN DULU GUYSS</h2>
        <p>Silakan masuk untuk mengelola inventaris.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <div class="mt-4 mb-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember">
                <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm rounded-md focus:outline-none" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="mt-8">
            <x-primary-button>
                {{ __('Kalo udah pencet ini') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>