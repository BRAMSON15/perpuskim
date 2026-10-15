<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BukuController extends Controller
{
    /**
     * Show all books
     */
    public function index(Request $request)
    {
        $query = Buku::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        $buku = $query->paginate(6)->withQueryString();
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        // Get active borrowings for notification and duration
        $peminjamanAktif = \App\Models\Peminjaman::with('buku')
            ->where('mahasiswa_npm', $mahasiswa->npm)
            ->where('status', 'Dipinjam')
            ->get();

        return view('mahasiswa.home', compact('buku', 'mahasiswa', 'peminjamanAktif'));
    }

    /**
     * Show Mahasiswa Profile
     */
    public function profil()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        $peminjamanAktif = \App\Models\Peminjaman::with('buku')
            ->where('mahasiswa_npm', $mahasiswa->npm)
            ->where('status', 'Dipinjam')
            ->get();

        return view('mahasiswa.profil', compact('mahasiswa', 'peminjamanAktif'));
    }

    /**
     * Show book details
     */
    public function show($id)
    {
        $buku = Buku::findOrFail($id);
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

        $buku = Buku::findOrFail($id);

        if ($buku->stok <= 0) {
            return response()->json(['success' => false, 'message' => 'Stok buku habis.']);
        }

        // Cek apakah mahasiswa sudah meminjam buku ini dan belum mengembalikannya
        $sudahPinjam = Peminjaman::where('mahasiswa_npm', $mahasiswa->npm)
            ->where('buku_id', $buku->id)
            ->where('status', 'Dipinjam')
            ->exists();

        if ($sudahPinjam) {
            return response()->json(['success' => false, 'message' => 'Anda masih meminjam buku ini dan belum mengembalikannya.']);
        }

        // Buat peminjaman baru
        Peminjaman::create([
            'mahasiswa_npm' => $mahasiswa->npm,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => Carbon::today(),
            'tenggat_waktu' => Carbon::today()->addDays(7),
            'status' => 'Dipinjam',
        ]);

        // Kurangi stok
        $buku->decrement('stok');

        return response()->json(['success' => true, 'message' => 'Buku berhasil dipinjam!']);
    }
}
