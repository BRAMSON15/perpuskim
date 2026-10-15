# Refactoring Examples - Before & After

Dokumentasi tentang perubahan kode dari controller ke service layer.

## 1. AdminDashboardController

### ❌ SEBELUM (Query langsung di controller)

```php
<?php

namespace App\Http\Controllers;

use App\Models\Staf;
use App\Models\Buku;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 11+ database queries!
        $totalStaf = Staf::where('role', 'staf')->count();
        $bukuDipinjam = Peminjaman::where('status', 'Dipinjam')->count();
        $totalBuku = (int) Buku::sum('stok');
        $totalJudulBuku = Buku::count();
        $totalAnggota = Mahasiswa::where('status', 'active')->count();
        $pendingVerifikasi = Mahasiswa::where('status', 'pending')->count();
        $totalPeminjaman = Peminjaman::count();
        
        $pengembalianHariIni = Peminjaman::where('status', 'Selesai')
            ->whereDate('tanggal_kembali', Carbon::today())
            ->count();

        $riwayatTerbaru = Peminjaman::with(['buku', 'mahasiswa'])
            ->latest('id')
            ->take(6)
            ->get();

        $pendingMahasiswa = Mahasiswa::where('status', 'pending')
            ->latest('created_at')
            ->take(5)
            ->get();

        // Loop dengan multiple queries! (N+1 problem)
        $chartLabels = [];
        $chartDataPinjam = [];
        $chartDataKembali = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartDataPinjam[] = Peminjaman::whereDate('tanggal_pinjam', $date)->count();
            $chartDataKembali[] = Peminjaman::where('status', 'Selesai')
                ->whereDate('tanggal_kembali', $date)
                ->count();
        }
            
        return view('admin.dashboardadmin', compact(
            'totalStaf',
            'bukuDipinjam',
            'totalBuku',
            'totalJudulBuku',
            'totalAnggota',
            'pendingVerifikasi',
            'totalPeminjaman',
            'pengembalianHariIni',
            'riwayatTerbaru',
            'pendingMahasiswa',
            'chartLabels',
            'chartDataPinjam',
            'chartDataKembali'
        ));
    }
}
```

**Masalah**:
- 11+ queries dalam satu method
- N+1 problem dalam loop (14+ queries)
- Sulit di-test
- Sulit di-reuse
- Kode bloated dan hard to read

### ✅ SESUDAH (Menggunakan DashboardService)

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;

class AdminDashboardController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $data = $this->dashboardService->getFullDashboardData();
        return view('admin.dashboardadmin', $data);
    }
}
```

**Keuntungan**:
- Controller hanya 4 baris!
- Semua query logic di service
- Mudah di-test
- Mudah di-reuse
- Clean dan maintainable

---

## 2. BukuController

### ❌ SEBELUM (Search logic di controller)

```php
<?php

class BukuController extends Controller
{
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
        
        $peminjamanAktif = \App\Models\Peminjaman::with('buku')
            ->where('mahasiswa_npm', $mahasiswa->npm)
            ->where('status', 'Dipinjam')
            ->get();

        return view('mahasiswa.home', compact('buku', 'mahasiswa', 'peminjamanAktif'));
    }

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
```

**Masalah**:
- Business logic di controller (bukan HTTP layer)
- Search/filter logic tidak reusable
- Peminjaman logic tidak reusable
- Sulit di-test
- Kompleks dan hard to maintain

### ✅ SESUDAH (Menggunakan Service)

```php
<?php

class BukuController extends Controller
{
    private $bukuSearchService;
    private $peminjamanService;

    public function __construct(
        BukuSearchService $bukuSearchService, 
        PeminjamanService $peminjamanService
    ) {
        $this->bukuSearchService = $bukuSearchService;
        $this->peminjamanService = $peminjamanService;
    }

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'fakultas' => $request->fakultas,
        ];

        $buku = $this->bukuSearchService->search($filters);
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $peminjamanAktif = $this->peminjamanService->getActivePeminjaman($mahasiswa->npm);

        return view('mahasiswa.home', compact('buku', 'mahasiswa', 'peminjamanAktif'));
    }

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
```

**Keuntungan**:
- Controller fokus pada HTTP handling
- Business logic di service (reusable)
- Error handling lebih baik
- Lebih mudah di-test
- Clean dan clear responsibilities

---

## 3. MahasiswaAuthController

### ❌ SEBELUM (File handling dan auth logic di controller)

```php
<?php

class MahasiswaAuthController extends Controller
{
    public function processRegister(Request $request)
    {
        $request->validate([
            'npm' => 'required|string|regex:/^\d{14}$/|unique:mahasiswa,npm',
            'nama' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:mahasiswa,email',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:20',
            'password' => 'required|string|min:6',
            'foto_kartu' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'npm.unique' => 'NPM ini sudah terdaftar.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'foto_kartu.required' => 'Foto/Scan Kartu wajib diunggah.',
            'foto_kartu.image' => 'File harus berupa gambar.',
            'foto_kartu.max' => 'Ukuran file maksimal 2MB.',
        ]);

        // File upload di controller
        $path = $request->file('foto_kartu')->store('kartu_mahasiswa', 'public');

        Mahasiswa::create([
            'npm' => $request->npm,
            'nama' => $request->nama,
            'fakultas' => $request->fakultas,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->password),
            'foto_kartu' => $path,
            'status' => 'pending',
        ]);

        return redirect('/')->with('success', 'Registrasi berhasil!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'npm' => ['required', 'string', 'regex:/^\d{14}$/'],
            'password' => ['required', 'string'],
        ]);

        // Auth logic di controller
        $mahasiswa = Mahasiswa::where('npm', $credentials['npm'])->first();

        if (!$mahasiswa || !Hash::check($credentials['password'], $mahasiswa->password)) {
            return back()->withErrors([
                'npm' => 'NPM atau password salah',
            ])->onlyInput('npm');
        }

        if ($mahasiswa->status === 'pending') {
            return back()->withErrors(['npm' => 'Akun Anda sedang menunggu verifikasi oleh Admin.'])->onlyInput('npm');
        } elseif ($mahasiswa->status === 'rejected') {
            return back()->withErrors(['npm' => 'Pendaftaran akun Anda ditolak. Silakan hubungi Admin.'])->onlyInput('npm');
        }

        Auth::guard('mahasiswa')->login($mahasiswa);

        return redirect()->route('mahasiswa.home')->with('success', 'Login berhasil!');
    }
}
```

**Masalah**:
- File handling di controller
- Auth logic tidak terpusat
- Password hashing di controller
- Status validation tidak terstruktur
- Sulit di-test dan di-reuse
- Error handling minimal

### ✅ SESUDAH (Menggunakan Service)

```php
<?php

class MahasiswaAuthController extends Controller
{
    private $registrationService;
    private $authService;

    public function __construct(
        MahasiswaRegistrationService $registrationService,
        MahasiswaAuthenticationService $authService
    ) {
        $this->registrationService = $registrationService;
        $this->authService = $authService;
    }

    public function processRegister(Request $request)
    {
        $validated = $request->validate([
            'npm' => 'required|string|regex:/^\d{14}$/|unique:mahasiswa,npm',
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:mahasiswa,email',
            'password' => 'required|string|min:6',
            'foto_kartu' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // ... other fields
        ]);

        try {
            $mahasiswa = $this->registrationService->register($validated);
            return redirect('/')->with('success', 'Registrasi berhasil!');
        } catch (\Exception $e) {
            return back()->withErrors(['foto_kartu' => $e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'npm' => ['required', 'string', 'regex:/^\d{14}$/'],
            'password' => ['required', 'string'],
        ]);

        try {
            $mahasiswa = $this->authService->authenticate(
                $credentials['npm'], 
                $credentials['password']
            );
            $this->authService->login($mahasiswa);
            return redirect()->route('mahasiswa.home')->with('success', 'Login berhasil!');
        } catch (\Exception $e) {
            return back()->withErrors(['npm' => $e->getMessage()])->onlyInput('npm');
        }
    }
}
```

**Keuntungan**:
- File handling di service
- Auth logic di service (reusable)
- Password hashing di service
- Status validation terstruktur
- Mudah di-test dan di-reuse
- Error handling lebih baik

---

## 4. AdminLaporanController

### ❌ SEBELUM (Duplicated filter logic)

```php
<?php

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        // Query pertama
        $query = Peminjaman::with(['buku', 'mahasiswa'])->latest();

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pinjam', $request->tanggal);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_pinjam', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_pinjam', $request->tahun);
        }

        $peminjaman = $query->get();
        return view('admin.laporan', compact('peminjaman'));
    }

    // Private method dengan filter logic yang sama (DUPLICATED!)
    private function getFilteredData(Request $request)
    {
        $query = Peminjaman::with(['buku', 'mahasiswa'])->latest();

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pinjam', $request->tanggal);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_pinjam', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_pinjam', $request->tahun);
        }

        return $query->get();
    }

    public function exportPdf(Request $request)
    {
        $peminjaman = $this->getFilteredData($request);
        $pdf = Pdf::loadView('admin.laporan_pdf', compact('peminjaman'));
        
        return $pdf->download('laporan-peminjaman-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $peminjaman = $this->getFilteredData($request);
        
        $filename = "laporan-peminjaman-" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        fputcsv($handle, ['No', 'Nama Mahasiswa', 'Judul Buku', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status']);
        
        foreach ($peminjaman as $index => $item) {
            fputcsv($handle, [
                $index + 1,
                $item->mahasiswa->nama ?? 'N/A',
                $item->buku->judul ?? 'N/A',
                $item->tanggal_pinjam,
                $item->tanggal_kembali ?? '-',
                $item->status
            ]);
        }
        
        fclose($handle);
        exit;
    }
}
```

**Masalah**:
- Filter logic di-duplicate
- Export logic tidak terstruktur
- Sulit menambah export format baru
- Manual CSV handling tidak clean
- Tidak reusable

### ✅ SESUDAH (Menggunakan Service)

```php
<?php

class AdminLaporanController extends Controller
{
    private $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index(Request $request)
    {
        $filters = [
            'tanggal' => $request->tanggal,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ];

        $data = $this->reportService->getReportData($filters);
        
        return view('admin.laporan', [
            'peminjaman' => $data['peminjaman'],
            'summary' => $data['summary'],
            'available_years' => $data['available_years'],
            'available_months' => $data['available_months'],
        ]);
    }

    public function exportPdf(Request $request)
    {
        $filters = [
            'tanggal' => $request->tanggal,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ];

        return $this->reportService->generatePdfReport($filters);
    }

    public function exportExcel(Request $request)
    {
        $filters = [
            'tanggal' => $request->tanggal,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ];

        $this->reportService->generateCsvReport($filters);
    }
}
```

**Keuntungan**:
- Filter logic terpusat di service
- Export logic clean dan reusable
- Mudah menambah format export baru
- CSV handling lebih proper
- Reusable di berbagai tempat

---

## Summary of Changes

| Aspect | Before | After |
|--------|--------|-------|
| **Code Location** | Query di controller | Query di service |
| **Reusability** | Low | High |
| **Testability** | Difficult | Easy |
| **Maintainability** | Hard | Easy |
| **Controller Size** | Large (50+ lines) | Small (5-10 lines) |
| **Error Handling** | Basic | Comprehensive |
| **Transaction Safety** | None | Implemented |
| **Code Duplication** | High | None |

---

## Key Takeaways

✅ **Services handle business logic**  
✅ **Controllers handle HTTP layer only**  
✅ **Services are reusable and testable**  
✅ **Error handling is centralized**  
✅ **Code is more maintainable**  
✅ **Separation of concerns is clear**  

