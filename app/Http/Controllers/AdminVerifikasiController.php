<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Services\MahasiswaStatusService;

class AdminVerifikasiController extends Controller
{
    private $statusService;

    public function __construct(MahasiswaStatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    public function index()
    {
        // Tampilkan semua mahasiswa yang statusnya pending
        $pendingMahasiswa = $this->statusService->getPending();
        return view('admin.verifikasi', compact('pendingMahasiswa'));
    }

    public function approve($npm)
    {
        try {
            $this->statusService->approve($npm);
            return redirect()->back()->with('success', 'Akun mahasiswa berhasil disetujui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject($npm)
    {
        try {
            $this->statusService->reject($npm);
            return redirect()->back()->with('success', 'Akun mahasiswa telah ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
