<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\Pendaftaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdminSelectionController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total_pendaftar'  => Pendaftaran::count(),
            'diajukan'         => Pendaftaran::byStatus(Pendaftaran::STATUS_DIAJUKAN)->count(),
            'diverifikasi'     => Pendaftaran::byStatus(Pendaftaran::STATUS_DIVERIFIKASI)->count(),
            'diterima'         => Pendaftaran::byStatus(Pendaftaran::STATUS_DITERIMA)->count(),
            'ditolak'          => Pendaftaran::byStatus(Pendaftaran::STATUS_DITOLAK)->count(),
        ];

        $latestPendaftaran = Pendaftaran::with(['user'])
            ->latest('tanggal_daftar')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestPendaftaran'));
    }

    public function index(Request $request): View
    {
        $query = Pendaftaran::with(['user', 'berkas']);

        if ($request->filled('status') && in_array($request->status, Pendaftaran::STATUSES)) {
            $query->byStatus($request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal_daftar')) {
            $query->whereDate('tanggal_daftar', $request->tanggal_daftar);
        }

        $pendaftaran = $query->latest('tanggal_daftar')->paginate(15)->withQueryString();

        return view('admin.pendaftaran.index', compact('pendaftaran'));
    }

    public function show(Pendaftaran $pendaftaran): View
    {
        $pendaftaran->load(['user', 'berkas']);

        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function verify(Pendaftaran $pendaftaran): RedirectResponse
    {
        if ($pendaftaran->status !== Pendaftaran::STATUS_DIAJUKAN) {
            return back()->withErrors(['status' => 'Hanya pendaftaran berstatus "Diajukan" yang dapat diverifikasi.']);
        }

        $uploadedTypes = $pendaftaran->berkas->pluck('jenis_berkas')->toArray();
        $missingDocs   = array_diff(Berkas::JENIS_REQUIRED, $uploadedTypes);

        if (! empty($missingDocs)) {
            return back()->withErrors([
                'berkas' => 'Berkas belum lengkap. Dokumen yang kurang: ' . implode(', ', $missingDocs),
            ]);
        }

        $pendaftaran->update(['status' => Pendaftaran::STATUS_DIVERIFIKASI]);

        Log::info('Application verified', ['pendaftaran_id' => $pendaftaran->id]);

        $this->notifyStatusChange($pendaftaran);

        return back()->with('success', 'Pendaftaran berhasil diverifikasi.');
    }

    public function approve(Pendaftaran $pendaftaran): RedirectResponse
    {
        if ($pendaftaran->status !== Pendaftaran::STATUS_DIVERIFIKASI) {
            return back()->withErrors(['status' => 'Hanya pendaftaran berstatus "Diverifikasi" yang dapat diterima.']);
        }

        $pendaftaran->update([
            'status' => Pendaftaran::STATUS_DITERIMA,
        ]);

        Log::info('Application approved', ['pendaftaran_id' => $pendaftaran->id]);

        $this->notifyStatusChange($pendaftaran);

        return back()->with('success', 'Pendaftaran berhasil diterima.');
    }

    public function reject(Request $request, Pendaftaran $pendaftaran): RedirectResponse
    {
        $request->validate([
            'catatan_admin' => ['required', 'string', 'max:1000'],
        ], [
            'catatan_admin.required' => 'Alasan penolakan wajib diisi.',
        ]);

        if (! in_array($pendaftaran->status, [Pendaftaran::STATUS_DIAJUKAN, Pendaftaran::STATUS_DIVERIFIKASI])) {
            return back()->withErrors(['status' => 'Pendaftaran ini tidak dapat ditolak.']);
        }

        $pendaftaran->update([
            'status'        => Pendaftaran::STATUS_DITOLAK,
            'catatan_admin' => $request->catatan_admin,
        ]);

        Log::info('Application rejected', [
            'pendaftaran_id' => $pendaftaran->id,
            'reason'         => $request->catatan_admin,
        ]);

        $this->notifyStatusChange($pendaftaran);

        return back()->with('success', 'Pendaftaran telah ditolak.');
    }

    protected function notifyStatusChange(Pendaftaran $pendaftaran): void
    {
        $pendaftaran->load('user');
        $user   = $pendaftaran->user;
        $status = $pendaftaran->status_label;

        try {
            Mail::raw(
                "Yth. {$user->name},\n\n" .
                "Status pendaftaran magang Anda telah diperbarui menjadi: {$status}.\n\n" .
                "Silakan login ke sistem untuk melihat detail lebih lanjut.\n\n" .
                "Salam,\nPT. PLN (Persero) ULP Wangon",
                function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('Update Status Pendaftaran Magang - PLN ULP Wangon');
                }
            );

            Log::info('Status notification sent', [
                'pendaftaran_id' => $pendaftaran->id,
                'email'          => $user->email,
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to send status notification', [
                'pendaftaran_id' => $pendaftaran->id,
                'error'          => $e->getMessage(),
            ]);
        }
    }
}
