<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StafPeminjamanController extends Controller
{
    public function index()
    {
        // Peminjaman yang masih aktif (belum dikembalikan)
        $peminjaman = Peminjaman::with(['mahasiswa', 'buku'])->where('status', 'Dipinjam')->latest()->get();
        return view('stafperpus.kelolapeminjaman', compact('peminjaman'));
    }

    public function history()
    {
        // Semua riwayat peminjaman
        $peminjaman = Peminjaman::with(['mahasiswa', 'buku'])->latest()->get();
        return view('stafperpus.aktivitaspeminjaman', compact('peminjaman'));
    }

    public function complete($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($peminjaman->status === 'Dipinjam') {
            $peminjaman->update([
                'status' => 'Selesai',
                'tanggal_kembali' => Carbon::now(),
            ]);

            // Kembalikan stok buku
            $buku = $peminjaman->buku;
            if ($buku) {
                $buku->increment('stok');
            }

            return redirect()->back()->with('success', 'Peminjaman berhasil diselesaikan. Stok buku telah bertambah.');
        }

        return redirect()->back()->with('error', 'Peminjaman ini sudah berstatus Selesai.');
    }
}
