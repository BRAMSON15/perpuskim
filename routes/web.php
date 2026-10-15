<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaAuthController;
use App\Http\Controllers\BukuController;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    $query = \App\Models\Buku::query();
    
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
    return view('welcome', compact('buku'));
});

// Routes untuk mahasiswa login

// Pendaftaran Mahasiswa
Route::get('/mahasiswa/register', [MahasiswaAuthController::class, 'showRegister'])->name('mahasiswa.register');
Route::post('/mahasiswa/register', [MahasiswaAuthController::class, 'processRegister']);

Route::post('/mahasiswa/login', [MahasiswaAuthController::class, 'login'])->name('mahasiswa.login');

// Routes yang memerlukan authentikasi sebagai mahasiswa
Route::middleware('auth:mahasiswa')->group(function () {
    Route::get('/mahasiswa/home', [BukuController::class, 'index'])->name('mahasiswa.home');
    Route::get('/mahasiswa/profil', [BukuController::class, 'profil'])->name('mahasiswa.profil');
    Route::post('/mahasiswa/logout', [MahasiswaAuthController::class, 'logout'])->name('mahasiswa.logout');
    Route::post('/mahasiswa/pinjam/{buku_id}', [BukuController::class, 'pinjam'])->name('mahasiswa.pinjam');
});

// Routes untuk buku (public)
Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.detail');

// Routes untuk admin login
use App\Http\Controllers\AdminAuthController;

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Routes untuk stafperpus
use App\Http\Controllers\StafAuthController;

Route::get('/stafperpus/login', [StafAuthController::class, 'showLoginForm'])->name('staf.login');
Route::post('/stafperpus/login', [StafAuthController::class, 'login']);

// Routes yang memerlukan authentikasi sebagai staf
Route::middleware('auth:staf')->group(function () {
    Route::get('/stafperpus/home', function () {
        $totalAnggota = \App\Models\Mahasiswa::count();
        $bukuDipinjam = \App\Models\Peminjaman::where('status', 'Dipinjam')->count();
        $totalBuku = \App\Models\Buku::sum('stok'); // Atau count() jika yang dimaksud total judul buku
        $pengembalianHariIni = \App\Models\Peminjaman::where('status', 'Selesai')
            ->whereDate('tanggal_kembali', \Carbon\Carbon::today())
            ->count();
            
        $anggotaBaru = \App\Models\Mahasiswa::latest()->take(5)->get();
        $riwayatPeminjaman = \App\Models\Peminjaman::with('buku')->latest()->take(6)->get();

        return view('stafperpus.stafhome', compact(
            'totalAnggota', 'bukuDipinjam', 'totalBuku', 'pengembalianHariIni', 'anggotaBaru', 'riwayatPeminjaman'
        ));
    })->name('staf.home');
    
    // Rute lain untuk kelola peminjaman, dll bisa ditambahkan di sini
    Route::get('/stafperpus/kelolapeminjaman', [\App\Http\Controllers\StafPeminjamanController::class, 'index'])->name('staf.kelolapeminjaman');
    Route::get('/stafperpus/aktivitaspeminjaman', [\App\Http\Controllers\StafPeminjamanController::class, 'history'])->name('staf.aktivitaspeminjaman');
    Route::post('/stafperpus/kelolapeminjaman/{id}/selesai', [\App\Http\Controllers\StafPeminjamanController::class, 'complete'])->name('staf.peminjaman.selesai');
    Route::resource('/stafperpus/kelolabuku', \App\Http\Controllers\StafBukuController::class);
    
    Route::post('/stafperpus/logout', [StafAuthController::class, 'logout'])->name('staf.logout');
});

// Routes untuk Admin (memerlukan authentikasi staf dan role admin)
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/kelolastaf', \App\Http\Controllers\AdminStafController::class);
    
    // Verifikasi Anggota
    Route::get('/admin/verifikasi', [\App\Http\Controllers\AdminVerifikasiController::class, 'index'])->name('admin.verifikasi');
    Route::post('/admin/verifikasi/{npm}/approve', [\App\Http\Controllers\AdminVerifikasiController::class, 'approve'])->name('admin.verifikasi.approve');
    Route::post('/admin/verifikasi/{npm}/reject', [\App\Http\Controllers\AdminVerifikasiController::class, 'reject'])->name('admin.verifikasi.reject');

    // Kelola Anggota Terverifikasi
    Route::get('/admin/anggota', [\App\Http\Controllers\AdminAnggotaController::class, 'index'])->name('admin.anggota');
    Route::post('/admin/anggota/{npm}/toggle', [\App\Http\Controllers\AdminAnggotaController::class, 'toggleStatus'])->name('admin.anggota.toggle');

    Route::get('/admin/aktivitaspeminjaman', [\App\Http\Controllers\AdminAktivitasController::class, 'index'])->name('admin.aktivitaspeminjaman');
    Route::get('/admin/laporan', [\App\Http\Controllers\AdminLaporanController::class, 'index'])->name('admin.laporan');
    Route::get('/admin/laporan/export-pdf', [\App\Http\Controllers\AdminLaporanController::class, 'exportPdf'])->name('admin.laporan.pdf');
    Route::get('/admin/laporan/export-excel', [\App\Http\Controllers\AdminLaporanController::class, 'exportExcel'])->name('admin.laporan.excel');

    // Kelola Fakultas
    Route::resource('/admin/fakultas', \App\Http\Controllers\AdminFakultasController::class, [
        'names' => [
            'index' => 'admin.fakultas.index',
            'create' => 'admin.fakultas.create',
            'store' => 'admin.fakultas.store',
            'edit' => 'admin.fakultas.edit',
            'update' => 'admin.fakultas.update',
            'destroy' => 'admin.fakultas.destroy',
        ]
    ]);

    // Kelola Program Studi
    Route::resource('/admin/program-studi', \App\Http\Controllers\AdminProgramStudiController::class, [
        'names' => [
            'index' => 'admin.program-studi.index',
            'create' => 'admin.program-studi.create',
            'store' => 'admin.program-studi.store',
            'edit' => 'admin.program-studi.edit',
            'update' => 'admin.program-studi.update',
            'destroy' => 'admin.program-studi.destroy',
        ]
    ]);
});
