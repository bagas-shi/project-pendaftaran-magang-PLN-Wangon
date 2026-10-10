<?php

namespace App\Http\Controllers;

use App\Http\Requests\PendaftaranRequest;
use App\Models\Berkas;
use App\Models\Pendaftaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PendaftaranController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();

        $pendaftaran = Pendaftaran::where('user_id', $user->id)
            ->with(['berkas'])
            ->latest('tanggal_daftar')
            ->get();

        return view('peserta.dashboard', compact('pendaftaran'));
    }

    public function create(): View
    {
        return view('peserta.pendaftaran.create');
    }

    public function store(PendaftaranRequest $request): RedirectResponse
    {
        $user      = Auth::user();
        $validated = $request->validated();

        // Check if user has pending or accepted application
        $hasPendingOrAccepted = Pendaftaran::where('user_id', $user->id)
            ->whereIn('status', [Pendaftaran::STATUS_DIAJUKAN, Pendaftaran::STATUS_DIVERIFIKASI, Pendaftaran::STATUS_DITERIMA])
            ->exists();

        if ($hasPendingOrAccepted) {
            return back()
                ->withInput()
                ->withErrors(['general' => 'Anda masih memiliki pendaftaran yang sedang diproses atau sudah diterima.']);
        }

        DB::beginTransaction();

        try {
            $user->update([
                'phone'       => $validated['phone'],
                'universitas' => $validated['universitas'],
                'jurusan'     => $validated['jurusan'],
                'alamat'      => $validated['alamat'],
            ]);

            $pendaftaran = Pendaftaran::create([
                'user_id'         => $user->id,
                'tanggal_mulai'   => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'status'          => Pendaftaran::STATUS_DIAJUKAN,
                'tanggal_daftar'  => now()->toDateString(),
            ]);

            foreach ($request->input('berkas', []) as $index => $berkasData) {
                $file = $request->file("berkas.{$index}.file");

                if (! $file) {
                    continue;
                }

                $storagePath = $file->store(
                    "berkas/{$pendaftaran->id}",
                    'private'
                );

                Berkas::create([
                    'pendaftaran_id' => $pendaftaran->id,
                    'jenis_berkas'   => $berkasData['jenis'],
                    'nama_asli'      => $file->getClientOriginalName(),
                    'file_path'      => $storagePath,
                    'mime_type'      => $file->getClientMimeType(),
                    'file_size'      => $file->getSize(),
                ]);
            }

            DB::commit();

            Log::info('New application submitted', [
                'user_id'        => $user->id,
                'pendaftaran_id' => $pendaftaran->id,
            ]);

            return redirect()
                ->route('peserta.pendaftaran.show', $pendaftaran)
                ->with('success', 'Pendaftaran berhasil diajukan! Silakan tunggu proses verifikasi.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Application submission failed', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['general' => 'Terjadi kesalahan. Silakan coba lagi.']);
        }
    }

    public function show(Pendaftaran $pendaftaran): View
    {
        $this->authorizeCandidate($pendaftaran);

        $pendaftaran->load(['berkas', 'user']);

        return view('peserta.pendaftaran.show', compact('pendaftaran'));
    }

    public function downloadBerkas(Berkas $berkas): StreamedResponse
    {
        $pendaftaran = $berkas->pendaftaran;
        $user        = Auth::user();

        if ($pendaftaran->user_id !== $user->id && ! $user->hasAnyRole(['admin', 'super_admin'])) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        if (! Storage::disk('private')->exists($berkas->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('private')->download(
            $berkas->file_path,
            $berkas->nama_asli
        );
    }

    protected function authorizeCandidate(Pendaftaran $pendaftaran): void
    {
        if ($pendaftaran->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pendaftaran ini.');
        }
    }
}
