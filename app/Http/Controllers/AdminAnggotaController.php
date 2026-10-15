<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Services\MahasiswaStatusService;

class AdminAnggotaController extends Controller
{
    private $statusService;

    public function __construct(MahasiswaStatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    public function index()
    {
        // Hanya tampilkan anggota yang sudah diverifikasi atau pernah aktif (active/nonaktif)
        $anggota = Mahasiswa::whereIn('status', ['active', 'nonaktif'])->latest()->get();
        return view('admin.kelolaanggota', compact('anggota'));
    }

    public function toggleStatus($npm)
    {
        try {
            $mahasiswa = $this->statusService->toggleStatus($npm);
            
            $message = $mahasiswa->status === 'active' 
                ? 'Akun mahasiswa berhasil diaktifkan kembali.'
                : 'Akun mahasiswa berhasil dinonaktifkan.';

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
