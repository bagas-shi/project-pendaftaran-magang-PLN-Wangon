@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900" id="admin-dashboard-heading">Dashboard Admin</h1>
            <p class="text-gray-500 mt-1">Kelola pendaftaran magang PLN ULP Wangon</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.export.excel') }}" class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition" id="btn-export-excel">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Export Excel
            </a>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 text-center">
            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_pendaftar'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Total Pendaftar</p>
        </div>
        <div class="bg-yellow-50 rounded-xl border border-yellow-200 p-5 text-center">
            <p class="text-3xl font-bold text-yellow-700">{{ $stats['diajukan'] }}</p>
            <p class="text-xs text-yellow-600 mt-1">Diajukan</p>
        </div>
        <div class="bg-blue-50 rounded-xl border border-blue-200 p-5 text-center">
            <p class="text-3xl font-bold text-blue-700">{{ $stats['diverifikasi'] }}</p>
            <p class="text-xs text-blue-600 mt-1">Diverifikasi</p>
        </div>
        <div class="bg-green-50 rounded-xl border border-green-200 p-5 text-center">
            <p class="text-3xl font-bold text-green-700">{{ $stats['diterima'] }}</p>
            <p class="text-xs text-green-600 mt-1">Diterima</p>
        </div>
        <div class="bg-red-50 rounded-xl border border-red-200 p-5 text-center">
            <p class="text-3xl font-bold text-red-700">{{ $stats['ditolak'] }}</p>
            <p class="text-xs text-red-600 mt-1">Ditolak</p>
        </div>
    </div>

    {{-- Latest Applications --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Pendaftaran Terbaru</h2>
            <a href="{{ route('admin.pendaftaran.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Lihat Semua →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="admin-pendaftaran-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Universitas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Magang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Daftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($latestPendaftaran as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->user->name }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $item->user->universitas ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-500 text-xs">{{ $item->tanggal_mulai->format('d/m/y') }} - {{ $item->tanggal_selesai->format('d/m/y') }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $item->tanggal_daftar->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->status_badge_class }}">
                                {{ $item->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.pendaftaran.show', $item) }}" class="text-blue-600 hover:text-blue-800">Review</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada data pendaftaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
