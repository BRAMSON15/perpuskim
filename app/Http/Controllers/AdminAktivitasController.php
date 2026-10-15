<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;

class AdminAktivitasController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['buku', 'mahasiswa'])->latest()->get();
        return view('admin.aktivitaspeminjaman', compact('peminjaman'));
    }
}
