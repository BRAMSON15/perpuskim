<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['buku', 'mahasiswa'])->latest();

        // Filter based on input
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pinjam', $request->tanggal);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_pinjam', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_pinjam', $request->tahun);
        }

        $peminjaman = $query->get();
        return view('admin.laporan', compact('peminjaman'));
    }

    private function getFilteredData(Request $request)
    {
        $query = Peminjaman::with(['buku', 'mahasiswa'])->latest();

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pinjam', $request->tanggal);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_pinjam', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_pinjam', $request->tahun);
        }

        return $query->get();
    }

    public function exportPdf(Request $request)
    {
        $peminjaman = $this->getFilteredData($request);
        $pdf = Pdf::loadView('admin.laporan_pdf', compact('peminjaman'));
        
        return $pdf->download('laporan-peminjaman-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $peminjaman = $this->getFilteredData($request);
        
        $filename = "laporan-peminjaman-" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // CSV Header
        fputcsv($handle, ['No', 'Nama Mahasiswa', 'Judul Buku', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status']);
        
        // CSV Data
        foreach ($peminjaman as $index => $item) {
            fputcsv($handle, [
                $index + 1,
                $item->mahasiswa->nama ?? 'N/A',
                $item->buku->judul ?? 'N/A',
                $item->tanggal_pinjam,
                $item->tanggal_kembali ?? '-',
                $item->status
            ]);
        }
        
        fclose($handle);
        exit;
    }
}
