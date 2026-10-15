<?php
$file = 'c:/backup/laragon/www/perpuskim/routes/web.php';
$content = file_get_contents($file);

$registerRoutes = <<<PHP

// Pendaftaran Mahasiswa
Route::get('/mahasiswa/register', [MahasiswaAuthController::class, 'showRegister'])->name('mahasiswa.register');
Route::post('/mahasiswa/register', [MahasiswaAuthController::class, 'processRegister']);

PHP;

// Insert before the Mahasiswa Login routes
$content = str_replace(
    "Route::post('/mahasiswa/login', [MahasiswaAuthController::class, 'login'])->name('mahasiswa.login');",
    $registerRoutes . "\nRoute::post('/mahasiswa/login', [MahasiswaAuthController::class, 'login'])->name('mahasiswa.login');",
    $content
);

file_put_contents($file, $content);
echo "Routes updated.";
