@extends('layouts.app')

@section('title', 'Sistem Pendaftaran Magang - PLN ULP Wangon')

@section('content')
{{-- Hero Section --}}
<div class="relative bg-gradient-to-br from-blue-900 to-blue-700 overflow-hidden rounded-3xl mb-16 shadow-2xl">
    {{-- Decorative circles --}}
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-500 opacity-20 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-teal-400 opacity-20 blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-6 py-20 md:py-32 flex flex-col items-center text-center">
        <div class="inline-flex items-center space-x-2 bg-blue-800 bg-opacity-50 rounded-full px-4 py-2 mb-6 border border-blue-600 backdrop-blur-sm">
            <span class="flex h-2 w-2 rounded-full bg-green-400"></span>
            <span class="text-blue-100 text-sm font-medium">Pendaftaran Terbuka Sepanjang Tahun</span>
        </div>
        
        <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-6 leading-tight">
            Mulai Karir Cemerlangmu <br class="hidden md:block"> bersama <span class="text-yellow-400">PLN ULP Wangon</span>
        </h1>
        
        <p class="mt-4 text-lg md:text-xl text-blue-100 max-w-3xl mb-10 leading-relaxed">
            Sistem Informasi Pendaftaran Magang / Kerja Praktek (KP) terpadu. Dapatkan pengalaman berharga di industri ketenagalistrikan Indonesia bersama tim profesional kami.
        </p>
        
        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
            @guest
                <a href="{{ route('register') }}" class="bg-yellow-400 text-blue-900 font-bold px-8 py-4 rounded-xl shadow-lg hover:bg-yellow-300 hover:-translate-y-1 transition duration-300 text-lg text-center">
                    Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="bg-white bg-opacity-10 text-blue-900 font-bold px-8 py-4 rounded-xl hover:bg-white-300 hover:-translate-y-1 transition duration-300 border-white border-opacity-20 hover:bg-opacity-20 transition duration-300 text-lg text-center backdrop-blur-sm">
                    Masuk ke Akun
                </a>
            @else
                @role('peserta')
                    @if(!Auth::user()->pendaftaran()->where('status', 'diterima')->exists())
                        <a href="{{ route('peserta.pendaftaran.create') }}" class="bg-yellow-400 text-blue-900 font-bold px-8 py-4 rounded-xl shadow-lg hover:bg-yellow-300 hover:-translate-y-1 transition duration-300 text-lg text-center">
                            Mulai Daftar Magang →
                        </a>
                    @endif
                    <a href="{{ route('peserta.dashboard') }}" class="bg-white bg-opacity-10 text-blue-900 font-bold px-8 py-4 rounded-xl hover:bg-white-300 hover:-translate-y-1 transition duration-300 font-semibold px-8 py-4 rounded-xl border border-white border-opacity-20 hover:bg-opacity-20 transition duration-300 text-lg text-center backdrop-blur-sm">
                        Lihat Status (Dashboard)
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="bg-yellow-400 text-blue-900 font-bold px-8 py-4 rounded-xl shadow-lg hover:bg-yellow-300 hover:-translate-y-1 transition duration-300 text-lg text-center">
                        Masuk ke Dashboard Admin →
                    </a>
                @endrole
            @endguest
        </div>
    </div>
</div>

{{-- About Section --}}
<div class="max-w-7xl mx-auto px-4 mb-20">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-6 relative inline-block">
                Tentang Program Magang
                <div class="absolute -bottom-2 left-0 w-1/3 h-1 bg-yellow-400 rounded-full"></div>
            </h2>
            <p class="text-gray-600 text-lg mb-4 leading-relaxed">
                Program Magang/Kerja Praktek di PT. PLN (Persero) ULP Wangon dirancang khusus untuk mahasiswa dan siswa SMK yang ingin menerapkan ilmu akademisnya secara langsung di dunia kerja.
            </p>
            <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                Anda akan dilibatkan dalam berbagai proyek dan kegiatan operasional sehari-hari, mulai dari administrasi, pelayanan pelanggan, hingga teknik distribusi tenaga listrik.
            </p>
            
            <ul class="space-y-4">
                <li class="flex items-start">
                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center mt-1">
                        <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="ml-3 text-gray-700">Fleksibilitas memilih tanggal mulai dan selesai magang.</p>
                </li>
                <li class="flex items-start">
                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center mt-1">
                        <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="ml-3 text-gray-700">Proses pendaftaran full online tanpa perlu datang ke kantor.</p>
                </li>
                <li class="flex items-start">
                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center mt-1">
                        <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="ml-3 text-gray-700">Mendapatkan e-sertifikat (Surat Keterangan Selesai Magang).</p>
                </li>
            </ul>
        </div>
        
        <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-tr from-blue-600 to-teal-400 rounded-3xl transform rotate-3 opacity-20"></div>
            <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Kerja Praktek PLN" class="relative rounded-3xl shadow-xl object-cover h-[450px] w-full border border-gray-100">
        </div>
    </div>
</div>

{{-- Steps Section --}}
<div class="bg-gray-50 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-20 border-t border-gray-200">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900">Alur Pendaftaran Magang</h2>
            <p class="mt-4 text-gray-500 max-w-2xl mx-auto">Proses pendaftaran yang mudah, cepat, dan transparan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            {{-- Step 1 --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition relative group">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition">1</div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Buat Akun</h3>
                <p class="text-gray-600 text-sm">Daftar menggunakan email aktif atau akun Google Anda untuk mengakses sistem.</p>
            </div>
            
            {{-- Step 2 --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition relative group">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition">2</div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Lengkapi Data</h3>
                <p class="text-gray-600 text-sm">Tentukan tanggal pelaksanaan magang Anda dan isi data diri dengan lengkap.</p>
            </div>

            {{-- Step 3 --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition relative group">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition">3</div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Unggah Berkas</h3>
                <p class="text-gray-600 text-sm">Upload CV, Surat Pengantar Kampus/Sekolah, dan berkas pendukung lainnya.</p>
            </div>

            {{-- Step 4 --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition relative group">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center font-bold text-xl mb-6 group-hover:bg-green-600 group-hover:text-white transition">4</div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Tunggu Konfirmasi</h3>
                <p class="text-gray-600 text-sm">Admin PLN akan mereview aplikasi Anda. Jika diterima, Anda akan dihubungi oleh Admin PLN untuk proses selanjutnya.</p>
            </div>
        </div>
    </div>
</div>
@endsection
