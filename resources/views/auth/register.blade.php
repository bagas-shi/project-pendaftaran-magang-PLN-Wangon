@extends('layouts.app')

@section('title', 'Registrasi')

@section('content')
    <div class="min-h-[80vh] flex items-center justify-center py-8">
        <div
            class="w-full max-w-5xl bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row border border-gray-100">

            {{-- Left Side: Branding --}}
            <div
                class="w-full md:w-1/2 bg-gradient-to-br from-blue-900 via-blue-700 to-blue-600 p-10 flex-col justify-between text-white relative hidden md:flex">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-blue-500 opacity-20 blur-3xl">
                </div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-teal-400 opacity-20 blur-3xl">
                </div>

                <div class="relative z-10">
                    <img src="{{ asset('assets/Logo_PLN.png') }}" width="50" height="50" alt="Logo PLN">
                </div>

                <div class="relative z-10 mt-auto">
                    <p class="text-blue-200 text-sm font-medium mb-2">Mudah dan Cepat</p>
                    <h2 class="text-3xl font-bold leading-snug">
                        Bergabunglah untuk memulai perjalanan karir magang Anda
                    </h2>
                </div>
            </div>

            {{-- Right Side: Form --}}
            <div class="w-full md:w-1/2 p-8 md:p-12 lg:p-16 bg-white flex flex-col justify-center">
                <div class="mb-8">
                    <div class="md:hidden mb-4 text-yellow-400 drop-shadow-md">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900" id="register-heading">Buat akun baru</h1>
                    <p class="text-gray-500 mt-2 text-sm">Daftar sekarang untuk mengajukan magang di PLN ULP Wangon dan
                        pantau statusnya.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none"
                            placeholder="Nama lengkap Anda">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none"
                            placeholder="nama@email.com">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none"
                            placeholder="Minimal 8 karakter">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
                            Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none"
                            placeholder="Ulangi password">
                    </div>

                    <button type="submit" id="btn-register"
                        class="w-full bg-blue-600 text-white py-3.5 mt-2 rounded-xl font-semibold hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition shadow-lg shadow-blue-600/30">
                        Daftar Sekarang
                    </button>
                </form>

                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-white px-4 text-gray-400">atau daftar dengan</span>
                    </div>
                </div>

                <a href="{{ route('auth.google') }}"
                    class="flex items-center justify-center w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-gray-700 hover:bg-gray-100 hover:border-gray-300 transition font-medium"
                    id="btn-google-register">
                    <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    Daftar dengan Google
                </a>

                <p class="text-center text-sm text-gray-500 mt-8">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
@endsection