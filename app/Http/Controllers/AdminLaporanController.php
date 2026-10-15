<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Services\ReportService;

class AdminLaporanController extends Controller
{
    private $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index(Request $request)
    {
        $filters = [
            'tanggal' => $request->tanggal,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ];

        $data = $this->reportService->getReportData($filters);
        
        return view('admin.laporan', [
            'peminjaman' => $data['peminjaman'],
            'summary' => $data['summary'],
            'available_years' => $data['available_years'],
            'available_months' => $data['available_months'],
        ]);
    }

    public function exportPdf(Request $request)
    {
        $filters = [
            'tanggal' => $request->tanggal,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ];

        return $this->reportService->generatePdfReport($filters);
    }

    public function exportExcel(Request $request)
    {
        $filters = [
            'tanggal' => $request->tanggal,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ];

        $this->reportService->generateCsvReport($filters);
    }
}
