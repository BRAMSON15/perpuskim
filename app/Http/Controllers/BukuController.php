<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\BukuSearchService;
use App\Services\PeminjamanService;

class BukuController extends Controller
{
    private $bukuSearchService;
    private $peminjamanService;

    public function __construct(BukuSearchService $bukuSearchService, PeminjamanService $peminjamanService)
    {
        $this->bukuSearchService = $bukuSearchService;
        $this->peminjamanService = $peminjamanService;
    }

    /**
     * Show all books
     */
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'fakultas' => $request->fakultas,
        ];

        $buku = $this->bukuSearchService->search($filters);
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        // Get active borrowings for notification and duration
        $peminjamanAktif = $this->peminjamanService->getActivePeminjaman($mahasiswa->npm);

        return view('mahasiswa.home', compact('buku', 'mahasiswa', 'peminjamanAktif'));
    }

    /**
     * Show Mahasiswa Profile
     */
    public function profil()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        $peminjamanAktif = $this->peminjamanService->getActivePeminjaman($mahasiswa->npm);

        return view('mahasiswa.profil', compact('mahasiswa', 'peminjamanAktif'));
    }

    /**
     * Show book details
     */
    public function show($id)
    {
        $buku = $this->bukuSearchService->getDetail($id);
        return view('buku.detail', compact('buku'));
    }

    /**
     * Process book borrowing
     */
    public function pinjam($id)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        if (!$mahasiswa) {
            return response()->json(['success' => false, 'message' => 'Anda harus login sebagai mahasiswa.']);
        }

        try {
            $peminjaman = $this->peminjamanService->createPeminjaman($mahasiswa->npm, $id);
            
            return response()->json(['success' => true, 'message' => 'Buku berhasil dipinjam!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
