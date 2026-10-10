@extends('layouts.admin')

@section('title', 'Review Pendaftaran')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Back Button --}}
    <a href="{{ route('admin.pendaftaran.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6">
        ← Kembali ke Daftar Pendaftaran
    </a>

    {{-- Status Banner --}}
    <div class="rounded-xl p-6 mb-6 {{ $pendaftaran->status_badge_class }}" id="review-status-banner">
        <h1 class="text-xl font-bold">Review Pendaftaran #{{ $pendaftaran->id }}</h1>
        <p class="text-sm mt-1">Status: <strong>{{ $pendaftaran->status_label }}</strong></p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Candidate & Period Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Candidate Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Data Peserta</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-500">Nama:</span><br><strong>{{ $pendaftaran->user->name }}</strong></div>
                    <div><span class="text-gray-500">Email:</span><br>{{ $pendaftaran->user->email }}</div>
                    <div><span class="text-gray-500">Telepon:</span><br>{{ $pendaftaran->user->phone ?? '-' }}</div>
                    <div><span class="text-gray-500">Universitas:</span><br>{{ $pendaftaran->user->universitas ?? '-' }}</div>
                    <div><span class="text-gray-500">Jurusan:</span><br>{{ $pendaftaran->user->jurusan ?? '-' }}</div>
                    <div><span class="text-gray-500">Alamat:</span><br>{{ $pendaftaran->user->alamat ?? '-' }}</div>
                </div>
            </div>

            {{-- Internship Dates Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pelaksanaan</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-500">Tanggal Daftar:</span><br>{{ $pendaftaran->tanggal_daftar->format('d/m/Y') }}</div>
                    <div><span class="text-gray-500">Mulai:</span><br><strong>{{ $pendaftaran->tanggal_mulai->format('d/m/Y') }}</strong></div>
                    <div><span class="text-gray-500">Selesai:</span><br><strong>{{ $pendaftaran->tanggal_selesai->format('d/m/Y') }}</strong></div>
                </div>
            </div>

            {{-- Uploaded Documents --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Berkas Terunggah ({{ $pendaftaran->berkas->count() }})</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($pendaftaran->berkas as $berkas)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                        <div>
                            <p class="font-medium text-gray-900">{{ $berkas->jenis_berkas }}</p>
                            <p class="text-xs text-gray-500">{{ $berkas->nama_asli }} · {{ $berkas->formatted_size }} · {{ $berkas->mime_type }}</p>
                        </div>
                        <a href="{{ route('berkas.download', $berkas) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Download</a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right Column: Admin Actions --}}
        <div class="space-y-4">
            {{-- Verify --}}
            @if($pendaftaran->status === 'diajukan')
            <form method="POST" action="{{ route('admin.pendaftaran.verify', $pendaftaran) }}">
                @csrf
                @method('PATCH')
                <button type="submit" id="btn-verify"
                        class="w-full inline-flex justify-center items-center bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition"
                        onclick="return confirm('Verifikasi pendaftaran ini?')">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Verifikasi Berkas
                </button>
            </form>
            @endif

            {{-- Approve --}}
            @if($pendaftaran->status === 'diverifikasi')
            <form method="POST" action="{{ route('admin.pendaftaran.approve', $pendaftaran) }}">
                @csrf
                @method('PATCH')
                <button type="submit" id="btn-approve"
                        class="w-full inline-flex justify-center items-center bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition"
                        onclick="return confirm('Terima pendaftaran ini?')">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Terima Pendaftaran
                </button>
            </form>
            @endif

            {{-- Reject --}}
            @if(in_array($pendaftaran->status, ['diajukan', 'diverifikasi']))
            <form method="POST" action="{{ route('admin.pendaftaran.reject', $pendaftaran) }}">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="catatan_admin" class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan *</label>
                    <textarea name="catatan_admin" id="catatan_admin" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 text-sm"
                              placeholder="Jelaskan alasan penolakan..."></textarea>
                </div>
                <button type="submit" id="btn-reject"
                        class="w-full inline-flex justify-center items-center bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition"
                        onclick="return confirm('Tolak pendaftaran ini?')">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Tolak Pendaftaran
                </button>
            </form>
            @endif

            {{-- Admin Notes (if exists) --}}
            @if($pendaftaran->catatan_admin)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-yellow-800">Catatan Admin:</h3>
                <p class="text-sm text-yellow-700 mt-1">{{ $pendaftaran->catatan_admin }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
