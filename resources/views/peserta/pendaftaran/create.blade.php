@extends('layouts.app')

@section('title', 'Form Pendaftaran Magang')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6">
                <h1 class="text-xl font-bold text-white" id="form-heading">Formulir Pendaftaran Magang</h1>
                <p class="text-blue-100 text-sm mt-1">Lengkapi data, tentukan tanggal, dan unggah berkas yang diperlukan</p>
            </div>

            <form method="POST" action="{{ route('peserta.pendaftaran.store') }}" enctype="multipart/form-data"
                class="p-8 space-y-6">
                @csrf

                {{-- Internship Dates Section --}}
                <fieldset class="border border-gray-200 rounded-lg p-6">
                    <legend class="text-sm font-semibold text-gray-700 px-2">Periode Pelaksanaan Magang</legend>
                    <p class="text-xs text-gray-500 mt-1 mb-4">Silakan tentukan sendiri kapan Anda berencana memulai dan
                        mengakhiri magang.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai
                                *</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                                required min="{{ now()->format('Y-m-d') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                Selesai *</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                value="{{ old('tanggal_selesai') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                    </div>
                </fieldset>

                {{-- Profile Section --}}
                <fieldset class="border border-gray-200 rounded-lg p-6">
                    <legend class="text-sm font-semibold text-gray-700 px-2">Data Pribadi</legend>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon *</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="08xxxxxxxxxx">
                        </div>
                        <div>
                            <label for="Asal Instansi" class="block text-sm font-medium text-gray-700 mb-1">Asal Instansi
                                *</label>
                            <input type="text" name="Asal Instansi" id="Asal Instansi"
                                value="{{ old('Asal Instansi', Auth::user()->AsalInstansi) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Nama Asal Instansi">
                        </div>
                        <div>
                            <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-1">Jurusan / Prodi
                                *</label>
                            <input type="text" name="jurusan" id="jurusan"
                                value="{{ old('jurusan', Auth::user()->jurusan) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Program studi">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap *</label>
                        <textarea name="alamat" id="alamat" rows="3" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Alamat tempat tinggal saat ini">{{ old('alamat', Auth::user()->alamat) }}</textarea>
                    </div>
                </fieldset>

                {{-- Document Uploads --}}
                <fieldset class="border border-gray-200 rounded-lg p-6">
                    <legend class="text-sm font-semibold text-gray-700 px-2">Unggah Berkas</legend>
                    <p class="text-xs text-gray-500 mt-1 mb-4">Format: PDF, DOC, DOCX, JPG, PNG. Maksimal 5 MB per file.</p>

                    @php
                        $jenisRequired = \App\Models\Berkas::JENIS_REQUIRED;
                    @endphp

                    @foreach($jenisRequired as $index => $jenis)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                            <input type="hidden" name="berkas[{{ $index }}][jenis]" value="{{ $jenis }}">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $jenis }} <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="berkas[{{ $index }}][file]" required
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition"
                                id="berkas-{{ $index }}">
                        </div>
                    @endforeach
                </fieldset>

                {{-- Submit --}}
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('peserta.dashboard') }}"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" id="btn-submit-pendaftaran"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition">
                        Ajukan Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection