<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staf;
use App\Models\Buku;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalStaf = Staf::where('role', 'staf')->count();
        $bukuDipinjam = Peminjaman::where('status', 'Dipinjam')->count();
        $totalBuku = (int) Buku::sum('stok');
        $totalJudulBuku = Buku::count();
        $totalAnggota = Mahasiswa::where('status', 'active')->count();
        $pendingVerifikasi = Mahasiswa::where('status', 'pending')->count();
        $totalPeminjaman = Peminjaman::count();
        
        $pengembalianHariIni = Peminjaman::where('status', 'Selesai')
            ->whereDate('tanggal_kembali', Carbon::today())
            ->count();

        // Riwayat transaksi peminjaman terbaru (5 teratas)
        $riwayatTerbaru = Peminjaman::with(['buku', 'mahasiswa'])
            ->latest('id')
            ->take(6)
            ->get();

        // Calon anggota yang menunggu verifikasi berkas (maks 5)
        $pendingMahasiswa = Mahasiswa::where('status', 'pending')
            ->latest('created_at')
            ->take(5)
            ->get();

        // Data statistik sirkulasi 7 hari terakhir untuk grafik
        $chartLabels = [];
        $chartDataPinjam = [];
        $chartDataKembali = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartDataPinjam[] = Peminjaman::whereDate('tanggal_pinjam', $date)->count();
            $chartDataKembali[] = Peminjaman::where('status', 'Selesai')
                ->whereDate('tanggal_kembali', $date)
                ->count();
        }
            
        return view('admin.dashboardadmin', compact(
            'totalStaf',
            'bukuDipinjam',
            'totalBuku',
            'totalJudulBuku',
            'totalAnggota',
            'pendingVerifikasi',
            'totalPeminjaman',
            'pengembalianHariIni',
            'riwayatTerbaru',
            'pendingMahasiswa',
            'chartLabels',
            'chartDataPinjam',
            'chartDataKembali'
        ));
    }
}
