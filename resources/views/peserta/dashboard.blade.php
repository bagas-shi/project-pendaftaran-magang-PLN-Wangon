@extends('layouts.app')

@section('title', 'Dashboard Peserta')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Welcome Section --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-8 text-white mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold" id="peserta-welcome">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="mt-2 text-blue-100">Panel peserta magang PT. PLN (Persero) ULP Wangon</p>
        </div>
        @if(!$pendaftaran->contains('status', 'diterima'))
            <a href="{{ route('peserta.pendaftaran.create') }}"
               class="bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 shadow-md transition">
                Daftar Magang
            </a>
        @endif
    </div>

    {{-- Application History --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Riwayat Pendaftaran</h2>
        </div>

        @if($pendaftaran->isEmpty())
            <div class="p-12 text-center text-gray-400">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p>Anda belum memiliki pendaftaran.</p>
                <a href="{{ route('peserta.pendaftaran.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Daftar magang sekarang →</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="pendaftaran-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode Magang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Berkas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pendaftaran as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-900 font-medium">{{ $item->tanggal_daftar->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $item->tanggal_mulai->format('d/m/Y') }} — {{ $item->tanggal_selesai->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->status_badge_class }}">
                                    {{ $item->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $item->berkas->count() }} file</td>
                            <td class="px-6 py-4 space-x-2">
                                <a href="{{ route('peserta.pendaftaran.show', $item) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
