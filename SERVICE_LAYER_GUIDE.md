# Service Layer Implementation Guide

Panduan cepat untuk memahami dan menggunakan service layer di project Perpuskim.

## Quick Start

### Struktur Service Layer

```
app/
├── Http/Controllers/           # HTTP Request/Response handling
├── Services/                   # Business Logic
│   ├── PeminjamanService.php
│   ├── BukuSearchService.php
│   ├── DashboardService.php
│   ├── MahasiswaRegistrationService.php
│   ├── MahasiswaAuthenticationService.php
│   ├── ReportService.php
│   ├── MahasiswaStatusService.php
│   └── StafService.php
└── Models/                     # Database Models
```

## Menggunakan Service

### 1. Inject Service ke Controller

```php
<?php

namespace App\Http\Controllers;

use App\Services\PeminjamanService;

class BukuController extends Controller
{
    private $peminjamanService;

    // Dependency Injection via constructor
    public function __construct(PeminjamanService $peminjamanService)
    {
        $this->peminjamanService = $peminjamanService;
    }

    // Gunakan service
    public function pinjam($bukuId)
    {
        try {
            $peminjaman = $this->peminjamanService->createPeminjaman(
                auth()->guard('mahasiswa')->user()->npm,
                $bukuId
            );
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
```

### 2. Error Handling

Service akan throw exception jika ada error:

```php
try {
    $result = $this->service->doSomething();
} catch (\Exception $e) {
    // Handle error
    return redirect()->back()->with('error', $e->getMessage());
}
```

## Service Reference

### PeminjamanService

Untuk peminjaman/pengembalian buku.

```php
$service = new PeminjamanService();

// Buat peminjaman
$peminjaman = $service->createPeminjaman($npm, $bukuId);

// Selesaikan peminjaman
$peminjaman = $service->completePeminjaman($peminjamanId);

// Ambil peminjaman aktif
$aktif = $service->getActivePeminjaman($npm);

// Ambil semua riwayat
$history = $service->getPeminjamanHistory();

// Filter dengan criteria
$filtered = $service->getFilteredPeminjaman([
    'status' => 'Dipinjam',
    'from_date' => '2024-01-01',
    'to_date' => '2024-12-31'
]);

// Statistik
$stats = $service->getStatistics();
```

### BukuSearchService

Untuk search dan filter buku.

```php
$service = new BukuSearchService();

// Search dengan filter
$books = $service->search([
    'search' => 'laravel',
    'fakultas' => 'IT',
    'in_stock_only' => true
], $perPage = 6);

// Ambil by fakultas
$books = $service->getByFakultas('IT');

// Ambil buku stok rendah
$lowStock = $service->getLowStockBooks($threshold = 5);

// Ambil buku habis
$outOfStock = $service->getOutOfStockBooks();

// Buku populer (most borrowed)
$popular = $service->getPopularBooks($limit = 10);

// Detail buku
$book = $service->getDetail($bukuId);

// Cek ketersediaan
$available = $service->isAvailable($bukuId);
```

### DashboardService

Untuk statistik dashboard.

```php
$service = new DashboardService();

// Ambil semua data dashboard
$data = $service->getFullDashboardData();

// Atau ambil per kategori
$stats = $service->getAdminDashboardStats();
$recent = $service->getRecentTransactions($limit = 6);
$pending = $service->getPendingMembers($limit = 5);
$memberStats = $service->getMemberStats();
$bookStats = $service->getBookStats();
$borrowingStats = $service->getBorrowingStats();

// Untuk grafik
$labels = $service->getChartLabels();  // Label 7 hari terakhir
$borrowData = $service->getChartDataBorrowings();
$returnData = $service->getChartDataReturns();
```

### MahasiswaRegistrationService

Untuk registrasi mahasiswa.

```php
$service = new MahasiswaRegistrationService();

// Registrasi
$mahasiswa = $service->register([
    'npm' => '12345678901234',
    'nama' => 'John Doe',
    'email' => 'john@example.com',
    'password' => 'secret123',
    'foto_kartu' => $uploadedFile,
    // ... other fields
]);

// Cek NPM exists
if ($service->npmExists('12345678901234')) {
    // NPM sudah terdaftar
}

// Cek email exists
if ($service->emailExists('email@example.com')) {
    // Email sudah terdaftar
}

// Update profil
$updated = $service->updateProfile($mahasiswa, [
    'nama' => 'Jane Doe',
    'email' => 'jane@example.com',
    'password' => 'newsecret', // optional
    'foto_kartu' => $newFile,  // optional
]);

// Ambil yang pending
$pending = $service->getPendingRegistrations();
$pendingCount = $service->getPendingCount();
```

### MahasiswaAuthenticationService

Untuk login mahasiswa.

```php
$service = new MahasiswaAuthenticationService();

// Login
try {
    $mahasiswa = $service->authenticate($npm, $password);
    $service->login($mahasiswa, $remember = false);
} catch (\Exception $e) {
    // Error: wrong credentials atau status invalid
}

// Logout
$service->logout();

// Cek authenticated
$user = $service->getAuthenticatedUser();

// Ubah password
$service->changePassword($mahasiswa, $newPassword);

// Verifikasi password
$valid = $service->verifyPassword($mahasiswa, $password);
```

### ReportService

Untuk laporan dan export.

```php
$service = new ReportService();

// Ambil data dengan filter
$data = $service->getFilteredPeminjaman([
    'tanggal' => '2024-01-15',      // specific date
    'bulan' => 1,                    // january
    'tahun' => 2024,
    'status' => 'Selesai'
]);

// Export PDF
$response = $service->generatePdfReport([
    'bulan' => 1,
    'tahun' => 2024
], 'custom-filename.pdf');

// Export CSV
$service->generateCsvReport([
    'tahun' => 2024
], 'report.csv');

// Summary statistik
$summary = $service->getReportSummary([
    'tanggal' => '2024-01-15'
]);

// Ambil data untuk view
$data = $service->getReportData([
    'bulan' => 1,
    'tahun' => 2024
]);
// Returns: ['peminjaman', 'summary', 'available_years', 'available_months']
```

### MahasiswaStatusService

Untuk management status mahasiswa.

```php
$service = new MahasiswaStatusService();

// Approve pending
$mahasiswa = $service->approve($npm);

// Reject pending
$mahasiswa = $service->reject($npm);

// Toggle active/nonaktif
$mahasiswa = $service->toggleStatus($npm);

// Set ke status spesifik
$mahasiswa = $service->updateStatus($npm, 'active');

// Ambil by status
$active = $service->getActive();
$pending = $service->getPending();
$rejected = $service->getRejected();
$inactive = $service->getInactive();

// Statistik
$stats = $service->getStatusCounts();
```

### StafService

Untuk management staf.

```php
$service = new StafService();

// Buat staf baru
$staf = $service->createStaf([
    'nama' => 'John Staff',
    'username' => 'john_staff',
    'password' => 'secret123'
], $role = 'staf'); // atau 'admin'

// Update staf
$staf = $service->updateStaf($id, [
    'nama' => 'Jane Staff',
    'username' => 'jane_staff',
    'password' => 'newsecret' // optional
]);

// Hapus staf
$service->deleteStaf($id);

// Ambil staf by role
$staffList = $service->getStaf('staf');  // atau 'admin'
$allStaff = $service->getStaf();

// Cek username
if ($service->usernameExists('john_staff')) {
    // Username exists
}

// Ubah password
$service->changePassword($id, $newPassword);

// Verifikasi password
$valid = $service->verifyPassword($staf, $password);

// Statistik
$stats = $service->getStatistics();
// Returns: ['total', 'admin', 'staf']
```

## Common Patterns

### Pattern 1: CRUD dengan Error Handling

```php
// Create
try {
    $item = $this->service->create($data);
    return redirect()->back()->with('success', 'Created!');
} catch (\Exception $e) {
    return redirect()->back()->with('error', $e->getMessage());
}

// Update
try {
    $item = $this->service->update($id, $data);
    return redirect()->back()->with('success', 'Updated!');
} catch (\Exception $e) {
    return redirect()->back()->with('error', $e->getMessage());
}

// Delete
try {
    $this->service->delete($id);
    return redirect()->back()->with('success', 'Deleted!');
} catch (\Exception $e) {
    return redirect()->back()->with('error', $e->getMessage());
}
```

### Pattern 2: List dengan Filter

```php
public function index(Request $request)
{
    $filters = [
        'search' => $request->search,
        'status' => $request->status,
        'from_date' => $request->from_date,
        'to_date' => $request->to_date
    ];
    
    $items = $this->service->getFiltered($filters);
    
    return view('items.index', compact('items'));
}
```

### Pattern 3: Export Data

```php
public function export(Request $request)
{
    $filters = $request->all();
    
    // PDF
    if ($request->format === 'pdf') {
        return $this->service->exportPdf($filters);
    }
    
    // CSV
    if ($request->format === 'csv') {
        return $this->service->exportCsv($filters);
    }
}
```

## Tips & Best Practices

### ✅ DO

```php
// ✅ Gunakan service untuk business logic
public function store(Request $request)
{
    $user = $this->userService->create($request->all());
    return response()->json($user);
}

// ✅ Handle exception
try {
    $result = $this->service->do();
} catch (\Exception $e) {
    // Handle error properly
}

// ✅ Inject dependency
public function __construct(PeminjamanService $service)
{
    $this->service = $service;
}

// ✅ Type hint return value
public function getPeminjaman(): Collection
{
    return $this->service->getAll();
}
```

### ❌ DON'T

```php
// ❌ Jangan query di controller
public function index()
{
    $data = Peminjaman::with(['mahasiswa', 'buku'])->get();
}

// ❌ Jangan duplicate business logic
// Jika logic sudah di service, gunakan service

// ❌ Jangan create service tanpa injection
$service = new PeminjamanService();

// ❌ Jangan ignore exception
try {
    $result = $this->service->do();
} catch (\Exception $e) {
    // ❌ JANGAN: silent fail
}
```

## Troubleshooting

### Service tidak ditemukan?

**Error**: `Class not found: App\Services\PeminjamanService`

**Solusi**: 
- Pastikan file ada di `app/Services/`
- Pastikan namespace benar
- Run `composer dump-autoload`

### Constructor injection tidak bekerja?

**Error**: `Target class does not exist`

**Solusi**:
- Laravel service container otomatis resolve dependencies
- Pastikan type hint di constructor benar
- Pastikan service class namespace benar

### Service method tidak ada?

**Error**: `Call to undefined method ...`

**Solusi**:
- Check dokumentasi service
- Pastikan method exists di service class
- Check spelling dan case sensitivity

## Next Steps

Setelah familiar dengan service layer:

1. **Create FormRequest Classes** - Extract validation
2. **Create Repositories** - Abstract database queries
3. **Create Events** - Handle side effects
4. **Create Jobs** - Handle queued tasks
5. **Create Policies** - Handle authorization

---

**Last Updated**: October 15, 2026  
**Version**: 1.0
