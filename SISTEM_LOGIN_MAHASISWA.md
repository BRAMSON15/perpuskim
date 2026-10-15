# Sistem Login Mahasiswa PERPUSKIM

## Ringkasan
Sistem login mahasiswa telah dibuat dengan fitur-fitur berikut:
- ✅ Login menggunakan NPM (14 digit) dan Password
- ✅ Dashboard mahasiswa setelah login berhasil
- ✅ Logout functionality
- ✅ Error handling dan validasi

---

## Struktur File yang Dibuat

### 1. Model
- **`app/Models/Mahasiswa.php`** - Model untuk tabel mahasiswa

### 2. Migration
- **`database/migrations/2024_01_01_create_mahasiswa_table.php`** - Membuat tabel mahasiswa

### 3. Controller
- **`app/Http/Controllers/MahasiswaAuthController.php`** - Controller untuk handle login/logout

### 4. Seeder
- **`database/seeders/MahasiswaSeeder.php`** - Data test mahasiswa

### 5. Views
- **`resources/views/welcome.blade.php`** (updated) - Form login di halaman utama
- **`resources/views/mahasiswa/home.blade.php`** - Dashboard mahasiswa

### 6. Configuration
- **`config/auth.php`** (updated) - Tambah guard dan provider untuk mahasiswa

### 7. Routes
- **`routes/web.php`** (updated) - Tambah routes login/logout

---

## Cara Login

### Data Test yang Tersedia

| NPM | Password | Nama |
|-----|----------|------|
| 12345678901234 | password123 | Budi Santoso |
| 12345678901235 | password123 | Siti Nurhaliza |
| 12345678901236 | password123 | Ahmad Wijaya |

### Langkah-Langkah Login

1. Buka halaman utama (/)
2. Scroll ke bagian "Login Mahasiswa"
3. Masukkan NPM (14 digit, contoh: `12345678901234`)
4. Masukkan Password (contoh: `password123`)
5. Klik tombol "Login"
6. Jika berhasil, akan diarahkan ke `/mahasiswa/home` (dashboard)

---

## Validasi Form

### NPM
- Harus diisi
- Harus tepat 14 digit angka
- Format: `^\d{14}$`

### Password
- Harus diisi
- Akan di-hash menggunakan bcrypt di database

---

## Routes yang Tersedia

| Method | Route | Controller | Nama |
|--------|-------|------------|------|
| POST | `/mahasiswa/login` | MahasiswaAuthController@login | mahasiswa.login |
| GET | `/mahasiswa/home` | MahasiswaAuthController@home | mahasiswa.home |
| POST | `/mahasiswa/logout` | MahasiswaAuthController@logout | mahasiswa.logout |

---

## Fitur Dashboard Mahasiswa

1. **Informasi Pribadi**
   - Nama lengkap
   - NPM
   - Email
   - Program Studi
   - Nomor Telepon

2. **Menu**
   - Peminjaman Buku
   - Riwayat Peminjaman
   - Ubah Profil
   - Bantuan

3. **Statistik**
   - Jumlah Buku yang Dipinjam
   - Total Peminjaman
   - Denda Tertunda

4. **Logout Button**
   - Logout dengan aman

---

## Middleware Proteksi

Rute `/mahasiswa/home` dan `/mahasiswa/logout` dilindungi dengan middleware `auth:mahasiswa`, yang berarti:
- Hanya pengguna yang sudah login sebagai mahasiswa yang dapat mengakses
- Pengguna yang belum login akan diarahkan kembali ke halaman login

---

## Cara Menambah Mahasiswa Baru

### Via Database Seeder

Edit file `database/seeders/MahasiswaSeeder.php` dan tambahkan:

```php
Mahasiswa::create([
    'npm' => '12345678901237',
    'nama' => 'Nama Mahasiswa',
    'email' => 'email@example.com',
    'password' => Hash::make('password123'),
    'prodi' => 'Teknik Informatika',
    'no_telp' => '081234567893',
]);
```

Kemudian jalankan:
```bash
php artisan db:seed --class=MahasiswaSeeder
```

### Via Artisan Tinker

```bash
php artisan tinker
```

Kemudian:
```php
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;

Mahasiswa::create([
    'npm' => '12345678901237',
    'nama' => 'Nama Mahasiswa',
    'email' => 'email@example.com',
    'password' => Hash::make('password_baru'),
    'prodi' => 'Teknik Informatika',
    'no_telp' => '081234567893',
]);

exit;
```

---

## Testing

Untuk testing login, gunakan salah satu data test:

```
NPM: 12345678901234
Password: password123
```

Sistem akan:
1. Validasi NPM (harus 14 digit)
2. Validasi Password
3. Cek di database
4. Jika berhasil, login dan redirect ke dashboard
5. Jika gagal, tampilkan error message

---

## Troubleshooting

### "NPM atau password salah"
- Pastikan NPM yang dimasukkan sesuai dengan yang ada di database
- Pastikan password sesuai
- NPM harus 14 digit angka

### "NPM harus terdiri dari 14 digit angka"
- Pastikan hanya memasukkan angka
- Harus tepat 14 digit, tidak boleh lebih atau kurang

### Tidak bisa logout
- Pastikan session sudah aktif
- Coba clear cache: `php artisan cache:clear`

### Halaman 403 Unauthorized
- Pastikan sudah login terlebih dahulu
- Cookies/session mungkin sudah expired, silakan login ulang

---

## Next Steps

Fitur yang bisa ditambahkan di masa depan:
- [ ] Reset password
- [ ] Edit profil mahasiswa
- [ ] Sistem peminjaman buku
- [ ] Riwayat peminjaman
- [ ] Notifikasi denda
- [ ] Export data peminjaman
- [ ] Multi-factor authentication

---

Dibuat: 2024
