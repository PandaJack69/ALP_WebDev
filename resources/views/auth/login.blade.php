<x-guest-layout>
    <style>
        body {
            background-image: url('{{ asset('images/bg_makanan.jpg') }}'); /* Correct path using asset helper */
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Keeps the background fixed while scrolling */
            height: 100vh;
            margin: 0;
        }
        .login-register-box {
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent white for contrast */
            border-radius: 10px;
            padding: 20px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .login-register-box form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .login-register-box .flex {
            justify-content: space-between;
            align-items: center;
        }
        a {
            text-decoration: none;
            color: #4a5568;
        }
        a:hover {
            color: #2d3748;
        }
    </style>

    <div class="flex items-center justify-center min-h-screen">
        <div class="login-register-box">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf

    <!-- Email Address -->
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div>
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Remember Me -->
    <div class="flex items-center">
        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>
    </div>

    <div class="flex items-center justify-between mt-4">
        @if (Route::has('password.request'))
            <a class="text-sm hover:underline" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
        @endif

        <x-primary-button class="ml-3">
            {{ __('Log in') }}
        </x-primary-button>
    </div>
</form>
        </div>
    </div>
</x-guest-layout>
