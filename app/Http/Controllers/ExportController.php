<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function exportExcel(Request $request): StreamedResponse
    {
        $query = $this->buildExportQuery($request);
        $data  = $query->get();

        $filename = 'Data_Peserta_Magang_' . now()->format('Y-m-d_His') . '.csv';

        Log::info('Excel export generated', [
            'rows'    => $data->count(),
            'filters' => $request->only(['status']),
        ]);

        return response()->streamDownload(function () use ($data) {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'No',
                'Nama Lengkap',
                'Email',
                'No. Telepon',
                'Universitas',
                'Jurusan',
                'Alamat',
                'Tanggal Mulai',
                'Tanggal Selesai',
                'Tanggal Daftar',
                'Status',
                'Catatan Admin',
            ], ';');

            foreach ($data as $index => $item) {
                fputcsv($handle, [
                    $index + 1,
                    $item->user->name ?? '-',
                    $item->user->email ?? '-',
                    $item->user->phone ?? '-',
                    $item->user->universitas ?? '-',
                    $item->user->jurusan ?? '-',
                    $item->user->alamat ?? '-',
                    $item->tanggal_mulai?->format('d/m/Y') ?? '-',
                    $item->tanggal_selesai?->format('d/m/Y') ?? '-',
                    $item->tanggal_daftar?->format('d/m/Y') ?? '-',
                    $item->status_label,
                    $item->catatan_admin ?? '-',
                ], ';');
            }

            fclose($handle);
        }, $filename, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }


    protected function buildExportQuery(Request $request)
    {
        $query = Pendaftaran::with(['user']);

        if ($request->filled('status') && in_array($request->status, Pendaftaran::STATUSES)) {
            $query->byStatus($request->status);
        }

        return $query->orderBy('tanggal_daftar', 'desc');
    }
}
