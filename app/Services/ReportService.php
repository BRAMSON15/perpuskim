<?php

namespace App\Services;

use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportService
{
    /**
     * Get filtered peminjaman data
     * 
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFilteredPeminjaman(array $filters = [])
    {
        $query = Peminjaman::with(['buku', 'mahasiswa'])->latest();

        // Filter by specific date
        if (isset($filters['tanggal']) && !empty($filters['tanggal'])) {
            $query->whereDate('tanggal_pinjam', $filters['tanggal']);
        }

        // Filter by month
        if (isset($filters['bulan']) && !empty($filters['bulan'])) {
            $query->whereMonth('tanggal_pinjam', $filters['bulan']);
        }

        // Filter by year
        if (isset($filters['tahun']) && !empty($filters['tahun'])) {
            $query->whereYear('tanggal_pinjam', $filters['tahun']);
        }

        // Filter by status
        if (isset($filters['status']) && !empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by mahasiswa npm
        if (isset($filters['mahasiswa_npm']) && !empty($filters['mahasiswa_npm'])) {
            $query->where('mahasiswa_npm', $filters['mahasiswa_npm']);
        }

        // Filter by date range (from - to)
        if (isset($filters['from_date']) && !empty($filters['from_date'])) {
            $query->whereDate('tanggal_pinjam', '>=', $filters['from_date']);
        }

        if (isset($filters['to_date']) && !empty($filters['to_date'])) {
            $query->whereDate('tanggal_pinjam', '<=', $filters['to_date']);
        }

        return $query->get();
    }

    /**
     * Generate PDF report
     * 
     * @param array $filters
     * @param string|null $filename
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generatePdfReport(array $filters = [], ?string $filename = null)
    {
        $peminjaman = $this->getFilteredPeminjaman($filters);
        
        if (!$filename) {
            $filename = 'laporan-peminjaman-' . date('Y-m-d') . '.pdf';
        }

        $pdf = Pdf::loadView('admin.laporan_pdf', compact('peminjaman'));
        
        return $pdf->download($filename);
    }

    /**
     * Generate CSV export response
     * 
     * @param array $filters
     * @param string|null $filename
     * @return void
     */
    public function generateCsvReport(array $filters = [], ?string $filename = null)
    {
        $peminjaman = $this->getFilteredPeminjaman($filters);
        
        if (!$filename) {
            $filename = "laporan-peminjaman-" . date('Y-m-d') . ".csv";
        }

        // Set headers
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Output to browser
        $output = fopen('php://output', 'w');
        
        // Add UTF-8 BOM for Excel compatibility
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // CSV Header
        $this->writeCsvRow($output, ['No', 'Nama Mahasiswa', 'Judul Buku', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status']);
        
        // CSV Data
        foreach ($peminjaman as $index => $item) {
            $this->writeCsvRow($output, [
                $index + 1,
                $item->mahasiswa->nama ?? 'N/A',
                $item->buku->judul ?? 'N/A',
                $item->tanggal_pinjam,
                $item->tanggal_kembali ?? '-',
                $item->status
            ]);
        }
        
        fclose($output);
        exit;
    }

    /**
     * Write a single CSV row
     * 
     * @param resource $handle
     * @param array $row
     * @return void
     */
    private function writeCsvRow($handle, array $row): void
    {
        fputcsv($handle, $row);
    }

    /**
     * Get summary statistics for report
     * 
     * @param array $filters
     * @return array
     */
    public function getReportSummary(array $filters = []): array
    {
        $peminjaman = $this->getFilteredPeminjaman($filters);

        return [
            'total' => $peminjaman->count(),
            'completed' => $peminjaman->where('status', 'Selesai')->count(),
            'active' => $peminjaman->where('status', 'Dipinjam')->count(),
            'date_range' => $this->getDateRangeFromFilters($filters),
        ];
    }

    /**
     * Get date range description from filters
     * 
     * @param array $filters
     * @return string
     */
    private function getDateRangeFromFilters(array $filters): string
    {
        if (isset($filters['tanggal']) && !empty($filters['tanggal'])) {
            return "Tanggal: {$filters['tanggal']}";
        }

        if (isset($filters['bulan']) && !empty($filters['bulan'])) {
            $months = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            $month = $months[$filters['bulan']] ?? 'Unknown';
            $year = isset($filters['tahun']) ? $filters['tahun'] : date('Y');
            return "Bulan: $month $year";
        }

        if (isset($filters['tahun']) && !empty($filters['tahun'])) {
            return "Tahun: {$filters['tahun']}";
        }

        if (isset($filters['from_date']) && isset($filters['to_date'])) {
            return "Periode: {$filters['from_date']} s/d {$filters['to_date']}";
        }

        return "Semua Data";
    }

    /**
     * Get available years for report filter
     * 
     * @return array
     */
    public function getAvailableYears(): array
    {
        $years = Peminjaman::distinct()
            ->selectRaw('YEAR(tanggal_pinjam) as year')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Add current year if not present
        if (!in_array(date('Y'), $years)) {
            array_unshift($years, date('Y'));
        }

        return $years;
    }

    /**
     * Get available months for report filter
     * 
     * @return array
     */
    public function getAvailableMonths(): array
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
    }

    /**
     * Get report data for viewing
     * 
     * @param array $filters
     * @return array
     */
    public function getReportData(array $filters = []): array
    {
        return [
            'peminjaman' => $this->getFilteredPeminjaman($filters),
            'summary' => $this->getReportSummary($filters),
            'available_years' => $this->getAvailableYears(),
            'available_months' => $this->getAvailableMonths(),
        ];
    }
}
