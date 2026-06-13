<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        {{-- Brand --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-orange-500 rounded-2xl mb-4">
                <span class="text-white font-bold text-xl">SB</span>
            </div>
            <h1 class="text-2xl font-bold text-white">SuronBikes</h1>
            <p class="text-gray-400 text-sm mt-1">Admin Panel</p>
        </div>

        {{-- Login Card --}}
        <div class="bg-gray-800 rounded-2xl p-8 shadow-xl border border-gray-700">
            <h2 class="text-lg font-semibold text-white mb-6">Sign in to your account</h2>

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-1.5">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 text-sm
                            focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent
                            transition-colors duration-150
                            @error('email') border-red-500 ring-1 ring-red-500 @enderror"
                        placeholder="admin@suronbikes.com"
                    >
                    @error('email')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                    <div x-data="{ show: false }" class="relative">
                        <input
                            :type="show ? 'text' : 'password'"
                            id="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 text-sm
                                focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent
                                transition-colors duration-150 pr-10
                                @error('password') border-red-500 ring-1 ring-red-500 @enderror"
                            placeholder="••••••••"
                        >
                        <button
                            type="button"
                            @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-300 transition-colors"
                        >
                            <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        class="w-4 h-4 rounded border-gray-600 bg-gray-700 text-orange-500 focus:ring-orange-500 focus:ring-offset-gray-800"
                    >
                    <label for="remember" class="ml-2 text-sm text-gray-300">Remember me</label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full py-2.5 px-4 bg-orange-500 hover:bg-orange-600 active:bg-orange-700 text-white font-medium text-sm rounded-lg
                        transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-gray-800"
                >
                    Sign In
                </button>
            </form>
        </div>

        <p class="text-center text-gray-500 text-xs mt-6">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>
</body>
</html>
