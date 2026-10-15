<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class AdminAnggotaController extends Controller
{
    public function index()
    {
        // Hanya tampilkan anggota yang sudah diverifikasi atau pernah aktif (active/nonaktif)
        $anggota = Mahasiswa::whereIn('status', ['active', 'nonaktif'])->latest()->get();
        return view('admin.kelolaanggota', compact('anggota'));
    }

    public function toggleStatus($npm)
    {
        $mahasiswa = Mahasiswa::findOrFail($npm);
        
        if ($mahasiswa->status === 'active') {
            $mahasiswa->status = 'nonaktif';
            $message = 'Akun mahasiswa berhasil dinonaktifkan.';
        } else {
            $mahasiswa->status = 'active';
            $message = 'Akun mahasiswa berhasil diaktifkan kembali.';
        }
        
        $mahasiswa->save();

        return redirect()->back()->with('success', $message);
    }
}
