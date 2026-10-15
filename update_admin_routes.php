<?php
$file = 'c:/backup/laragon/www/perpuskim/routes/web.php';
$content = file_get_contents($file);

$adminRoutes = <<<PHP
    // Manajemen Admin (Laporan, dll)
    Route::get('/admin/laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan');
    
    // Verifikasi Mahasiswa
    Route::get('/admin/verifikasi', [\App\Http\Controllers\AdminVerifikasiController::class, 'index'])->name('admin.verifikasi');
    Route::post('/admin/verifikasi/{npm}/approve', [\App\Http\Controllers\AdminVerifikasiController::class, 'approve'])->name('admin.verifikasi.approve');
    Route::post('/admin/verifikasi/{npm}/reject', [\App\Http\Controllers\AdminVerifikasiController::class, 'reject'])->name('admin.verifikasi.reject');
PHP;

// Find the existing reports route and insert next to it
$content = str_replace(
    "Route::get('/admin/laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan');",
    $adminRoutes,
    $content
);

file_put_contents($file, $content);
echo "Admin routes updated.";
