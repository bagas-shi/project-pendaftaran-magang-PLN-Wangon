<?php

namespace App\Http\Requests;

use App\Models\Berkas;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PendaftaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->hasRole('peserta');
    }

    public function rules(): array
    {
        return [
            'tanggal_mulai'       => ['required', 'date', 'after_or_equal:today'],
            'tanggal_selesai'     => ['required', 'date', 'after:tanggal_mulai'],

            'phone'       => ['required', 'string', 'max:20'],
            'universitas' => ['required', 'string', 'max:255'],
            'jurusan'     => ['required', 'string', 'max:255'],
            'alamat'      => ['required', 'string', 'max:1000'],

            'berkas'              => ['required', 'array', 'min:1'],
            'berkas.*.jenis'      => ['required', 'string', Rule::in(Berkas::JENIS_LIST)],
            'berkas.*.file'       => [
                'required',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:5120',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_mulai.required'  => 'Tanggal mulai magang wajib diisi.',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh di masa lalu.',
            'tanggal_selesai.required'=> 'Tanggal selesai magang wajib diisi.',
            'tanggal_selesai.after'   => 'Tanggal selesai harus setelah tanggal mulai.',
            'phone.required'          => 'Nomor telepon wajib diisi.',
            'universitas.required'    => 'Nama universitas wajib diisi.',
            'jurusan.required'        => 'Jurusan / program studi wajib diisi.',
            'alamat.required'         => 'Alamat wajib diisi.',
            'berkas.required'         => 'Minimal satu berkas harus diunggah.',
            'berkas.*.file.required'  => 'File berkas wajib diunggah.',
            'berkas.*.file.mimes'     => 'Format file harus PDF, DOC, DOCX, JPG, atau PNG.',
            'berkas.*.file.max'       => 'Ukuran file maksimal 5 MB.',
            'berkas.*.jenis.required' => 'Jenis berkas wajib dipilih.',
            'berkas.*.jenis.in'       => 'Jenis berkas tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'berkas.*.file'  => 'file berkas',
            'berkas.*.jenis' => 'jenis berkas',
        ];
    }
}
