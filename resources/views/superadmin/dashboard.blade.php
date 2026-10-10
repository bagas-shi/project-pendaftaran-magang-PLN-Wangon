@extends('layouts.admin')

@section('title', 'Dashboard Super Admin')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-gradient-to-r from-purple-700 to-indigo-800 rounded-2xl p-8 text-white mb-8">
        <h1 class="text-2xl font-bold" id="superadmin-heading">Panel Super Admin</h1>
        <p class="mt-2 text-purple-200">Manajemen sistem keseluruhan</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 text-center">
            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Total User</p>
        </div>
        <div class="bg-blue-50 rounded-xl border border-blue-200 p-5 text-center">
            <p class="text-3xl font-bold text-blue-700">{{ $stats['total_peserta'] }}</p>
            <p class="text-xs text-blue-600 mt-1">Peserta</p>
        </div>
        <div class="bg-green-50 rounded-xl border border-green-200 p-5 text-center">
            <p class="text-3xl font-bold text-green-700">{{ $stats['total_admin'] }}</p>
            <p class="text-xs text-green-600 mt-1">Admin</p>
        </div>
        <div class="bg-purple-50 rounded-xl border border-purple-200 p-5 text-center">
            <p class="text-3xl font-bold text-purple-700">{{ $stats['total_roles'] }}</p>
            <p class="text-xs text-purple-600 mt-1">Roles</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('superadmin.admins.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <h3 class="flex items-center font-semibold text-gray-800 mb-2"><svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> Kelola Admin</h3>
            <p class="text-sm text-gray-500">Tambah, lihat, atau hapus akun admin.</p>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <h3 class="flex items-center font-semibold text-gray-800 mb-2"><svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg> Panel Admin</h3>
            <p class="text-sm text-gray-500">Akses dashboard admin untuk kelola pendaftaran.</p>
        </a>
    </div>
</div>
@endsection
