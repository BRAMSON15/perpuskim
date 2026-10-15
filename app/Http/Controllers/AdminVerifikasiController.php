<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class AdminVerifikasiController extends Controller
{
    public function index()
    {
        // Tampilkan semua mahasiswa yang statusnya pending
        $pendingMahasiswa = Mahasiswa::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        return view('admin.verifikasi', compact('pendingMahasiswa'));
    }

    public function approve($npm)
    {
        $mahasiswa = Mahasiswa::findOrFail($npm);
        $mahasiswa->status = 'active';
        $mahasiswa->save();

        return redirect()->back()->with('success', 'Akun mahasiswa berhasil disetujui.');
    }

    public function reject($npm)
    {
        $mahasiswa = Mahasiswa::findOrFail($npm);
        $mahasiswa->status = 'rejected';
        $mahasiswa->save();

        return redirect()->back()->with('success', 'Akun mahasiswa telah ditolak.');
    }
}
