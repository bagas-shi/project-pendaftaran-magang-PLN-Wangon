@extends('layouts.app')

@section('title', 'Detail Pendaftaran')

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Back Button --}}
        <a href="{{ route('peserta.dashboard') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6">
            ← Kembali ke Dashboard
        </a>

        {{-- Status Banner --}}
        <div class="rounded-xl p-6 mb-6 {{ $pendaftaran->status_badge_class }}">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold" id="detail-heading">Pendaftaran Magang</h1>
                    <p class="text-sm mt-1">Status saat ini: <strong>{{ $pendaftaran->status_label }}</strong></p>
                    <p class="text-sm mt-1">Silahkan menghubungi nomor ini memlaui whatshap untuk informasi lebih lanjut <a
                            href="https://wa.me/" target="_blank"><strong>Whatsapp</strong></a></p>
                </div>
            </div>
        </div>

        {{-- Application Details --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Candidate Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Data Peserta</h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Nama</dt>
                        <dd class="font-medium">{{ $pendaftaran->user->name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Email</dt>
                        <dd>{{ $pendaftaran->user->email }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Telepon</dt>
                        <dd>{{ $pendaftaran->user->phone ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Universitas</dt>
                        <dd>{{ $pendaftaran->user->universitas ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Jurusan</dt>
                        <dd>{{ $pendaftaran->user->jurusan ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Internship Dates Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pelaksanaan</h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Mulai</dt>
                        <dd class="font-medium text-gray-900">{{ $pendaftaran->tanggal_mulai->format('d F Y') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Selesai</dt>
                        <dd class="font-medium text-gray-900">{{ $pendaftaran->tanggal_selesai->format('d F Y') }}</dd>
                    </div>
                    <div class="flex justify-between mt-3 pt-3 border-t border-gray-100">
                        <dt class="text-gray-500">Tanggal Daftar</dt>
                        <dd>{{ $pendaftaran->tanggal_daftar->format('d F Y') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Admin Notes (if rejected) --}}
        @if($pendaftaran->catatan_admin)
            <div class="bg-red-50 border border-red-200 rounded-xl p-6 mt-6">
                <h3 class="text-sm font-semibold text-red-800">Catatan dari Admin:</h3>
                <p class="text-sm text-red-700 mt-2">{{ $pendaftaran->catatan_admin }}</p>
            </div>
        @endif

        {{-- Uploaded Documents --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mt-6 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Berkas yang Diunggah</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($pendaftaran->berkas as $berkas)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div>
                            <p class="font-medium text-gray-900">{{ $berkas->jenis_berkas }}</p>
                            <p class="text-sm text-gray-500">{{ $berkas->nama_asli }} — {{ $berkas->formatted_size }}</p>
                        </div>
                        <a href="{{ route('berkas.download', $berkas) }}"
                            class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Download
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection