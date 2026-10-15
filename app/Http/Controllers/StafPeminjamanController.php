<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use App\Services\PeminjamanService;

class StafPeminjamanController extends Controller
{
    private $peminjamanService;

    public function __construct(PeminjamanService $peminjamanService)
    {
        $this->peminjamanService = $peminjamanService;
    }

    public function index()
    {
        // Peminjaman yang masih aktif (belum dikembalikan)
        $peminjaman = $this->peminjamanService->getActivePeminjaman();
        return view('stafperpus.kelolapeminjaman', compact('peminjaman'));
    }

    public function history()
    {
        // Semua riwayat peminjaman
        $peminjaman = $this->peminjamanService->getPeminjamanHistory();
        return view('stafperpus.aktivitaspeminjaman', compact('peminjaman'));
    }

    public function complete($id)
    {
        try {
            $peminjaman = $this->peminjamanService->completePeminjaman($id);
            
            return redirect()->back()->with('success', 'Peminjaman berhasil diselesaikan. Stok buku telah bertambah.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
