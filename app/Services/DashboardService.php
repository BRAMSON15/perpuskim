<?php

namespace App\Services;

use App\Models\Staf;
use App\Models\Buku;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use Carbon\Carbon;

class DashboardService
{
    /**
     * Get complete admin dashboard statistics
     * 
     * @return array
     */
    public function getAdminDashboardStats(): array
    {
        return [
            'total_staf' => $this->getTotalStaf(),
            'buku_dipinjam' => $this->getActiveBorrowings(),
            'total_buku_stok' => $this->getTotalBookStock(),
            'total_judul_buku' => $this->getTotalBookTitles(),
            'total_anggota' => $this->getTotalActiveMembers(),
            'pending_verifikasi' => $this->getPendingVerifications(),
            'total_peminjaman' => $this->getTotalBorrowings(),
            'pengembalian_hari_ini' => $this->getReturnsTodayCount(),
        ];
    }

    /**
     * Get all dashboard data for admin view (view-ready format)
     * 
     * @return array
     */
    public function getFullDashboardData(): array
    {
        $stats = $this->getAdminDashboardStats();
        
        return array_merge($stats, [
            'totalStaf' => $stats['total_staf'],
            'bukuDipinjam' => $stats['buku_dipinjam'],
            'totalBuku' => $stats['total_buku_stok'],
            'totalJudulBuku' => $stats['total_judul_buku'],
            'totalAnggota' => $stats['total_anggota'],
            'pendingVerifikasi' => $stats['pending_verifikasi'],
            'totalPeminjaman' => $stats['total_peminjaman'],
            'pengembalianHariIni' => $stats['pengembalian_hari_ini'],
            'riwayatTerbaru' => $this->getRecentTransactions(),
            'pendingMahasiswa' => $this->getPendingMembers(),
            'chartLabels' => $this->getChartLabels(),
            'chartDataPinjam' => $this->getChartDataBorrowings(),
            'chartDataKembali' => $this->getChartDataReturns(),
        ]);
    }

    /**
     * Get total staf with role 'staf'
     * 
     * @return int
     */
    private function getTotalStaf(): int
    {
        return Staf::where('role', 'staf')->count();
    }

    /**
     * Get count of active borrowings (status 'Dipinjam')
     * 
     * @return int
     */
    private function getActiveBorrowings(): int
    {
        return Peminjaman::where('status', 'Dipinjam')->count();
    }

    /**
     * Get total book stock (sum of all stok columns)
     * 
     * @return int
     */
    private function getTotalBookStock(): int
    {
        return (int) Buku::sum('stok');
    }

    /**
     * Get total number of book titles
     * 
     * @return int
     */
    private function getTotalBookTitles(): int
    {
        return Buku::count();
    }

    /**
     * Get total active members (mahasiswa with status 'active')
     * 
     * @return int
     */
    private function getTotalActiveMembers(): int
    {
        return Mahasiswa::where('status', 'active')->count();
    }

    /**
     * Get count of pending verifications
     * 
     * @return int
     */
    private function getPendingVerifications(): int
    {
        return Mahasiswa::where('status', 'pending')->count();
    }

    /**
     * Get total borrowings count
     * 
     * @return int
     */
    private function getTotalBorrowings(): int
    {
        return Peminjaman::count();
    }

    /**
     * Get count of returns today
     * 
     * @return int
     */
    private function getReturnsTodayCount(): int
    {
        return Peminjaman::where('status', 'Selesai')
            ->whereDate('tanggal_kembali', Carbon::today())
            ->count();
    }

    /**
     * Get recent transactions (last 6)
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentTransactions(int $limit = 6)
    {
        return Peminjaman::with(['buku', 'mahasiswa'])
            ->latest('id')
            ->take($limit)
            ->get();
    }

    /**
     * Get pending members waiting for verification (last 5)
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPendingMembers(int $limit = 5)
    {
        return Mahasiswa::where('status', 'pending')
            ->latest('created_at')
            ->take($limit)
            ->get();
    }

    /**
     * Get chart labels for the last 7 days
     * 
     * @return array
     */
    public function getChartLabels(): array
    {
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('d M');
        }
        return $labels;
    }

    /**
     * Get chart data for borrowings (last 7 days)
     * 
     * @return array
     */
    public function getChartDataBorrowings(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $data[] = Peminjaman::whereDate('tanggal_pinjam', $date)->count();
        }
        return $data;
    }

    /**
     * Get chart data for returns (last 7 days)
     * 
     * @return array
     */
    public function getChartDataReturns(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $data[] = Peminjaman::where('status', 'Selesai')
                ->whereDate('tanggal_kembali', $date)
                ->count();
        }
        return $data;
    }

    /**
     * Get member statistics
     * 
     * @return array
     */
    public function getMemberStats(): array
    {
        return [
            'active' => Mahasiswa::where('status', 'active')->count(),
            'pending' => Mahasiswa::where('status', 'pending')->count(),
            'rejected' => Mahasiswa::where('status', 'rejected')->count(),
            'inactive' => Mahasiswa::where('status', 'nonaktif')->count(),
            'total' => Mahasiswa::count(),
        ];
    }

    /**
     * Get book statistics
     * 
     * @return array
     */
    public function getBookStats(): array
    {
        return [
            'total_titles' => Buku::count(),
            'total_stock' => (int) Buku::sum('stok'),
            'out_of_stock' => Buku::where('stok', '<=', 0)->count(),
            'low_stock' => Buku::where('stok', '>', 0)->where('stok', '<=', 5)->count(),
        ];
    }

    /**
     * Get borrowing statistics
     * 
     * @return array
     */
    public function getBorrowingStats(): array
    {
        return [
            'total' => Peminjaman::count(),
            'active' => Peminjaman::where('status', 'Dipinjam')->count(),
            'completed' => Peminjaman::where('status', 'Selesai')->count(),
            'overdue' => Peminjaman::where('status', 'Dipinjam')
                ->where('tenggat_waktu', '<', Carbon::now())
                ->count(),
        ];
    }

    /**
     * Get staff statistics
     * 
     * @return array
     */
    public function getStaffStats(): array
    {
        return [
            'total' => Staf::count(),
            'staff' => Staf::where('role', 'staf')->count(),
            'admin' => Staf::where('role', 'admin')->count(),
        ];
    }
}
