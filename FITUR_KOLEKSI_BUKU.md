# Fitur Koleksi Buku PERPUSKIM

## Ringkasan
Sistem koleksi buku telah diintegrasikan ke dalam dashboard mahasiswa dengan fitur:
- ✅ List koleksi buku dari berbagai kategori
- ✅ View detail buku dengan informasi lengkap
- ✅ Badge status stok buku (tersedia/tidak tersedia)
- ✅ Fitur peminjaman buku (siap untuk diimplementasikan)

---

## File yang Dibuat

### 1. Model
- **`app/Models/Buku.php`** - Model untuk tabel buku

### 2. Migration
- **`database/migrations/2024_01_02_create_buku_table.php`** - Membuat tabel buku

### 3. Seeder
- **`database/seeders/BukuSeeder.php`** - Data 8 koleksi buku untuk testing

### 4. Controller
- **`app/Http/Controllers/BukuController.php`** - Handle index dan show buku

### 5. Views
- **`resources/views/mahasiswa/home.blade.php`** (updated) - List koleksi buku
- **`resources/views/buku/detail.blade.php`** - Detail view untuk setiap buku

### 6. Routes
- **`routes/web.php`** (updated) - Route untuk koleksi buku

---

## Data Koleksi Buku yang Tersedia

| No | Judul | Pengarang | Kategori | Stok |
|----|----- |----------|----------|------|
| 1 | Laskar Pelangi | Andrea Hirata | Fiksi | 5 |
| 2 | Bumi Manusia | Pramoedya Ananta Toer | Fiksi Sejarah | 3 |
| 3 | Perahu Kertas | Dee Lestari | Fiksi | 4 |
| 4 | Filosofi Teras | Henry Manampiring | Non-Fiksi | 6 |
| 5 | Sapiens | Yuval Noah Harari | Non-Fiksi | 4 |
| 6 | Clean Code | Robert C. Martin | Teknik Informatika | 3 |
| 7 | The Pragmatic Programmer | David Thomas, Andrew Hunt | Teknik Informatika | 2 |
| 8 | Pemrograman PHP Modern | Adi Nugroho | Teknik Informatika | 5 |

---

## Fitur dan Cara Penggunaan

### 1. List Koleksi Buku

**Lokasi:** `/mahasiswa/home` (setelah login)

**Fitur:**
- Menampilkan grid koleksi buku dengan gambar (placeholder jika tidak ada)
- Informasi singkat: judul, pengarang, kategori
- Status stok dengan warna (hijau=tersedia, merah=tidak tersedia)
- Button "Lihat Detail" untuk melihat informasi lengkap

### 2. Detail Buku

**Lokasi:** `/buku/{id}` (dapat diakses publik atau member)

**Menampilkan:**
- Gambar buku
- Informasi lengkap:
  - Judul
  - Pengarang
  - Penerbit
  - ISBN
  - Tahun Terbit
  - Kategori
  - Deskripsi
  - Status Stok
- Button "Pinjam Buku" (aktif jika stok > 0)
- Button "Kembali ke Koleksi" (untuk mahasiswa login)

---

## Struktur Database Tabel Buku

```sql
CREATE TABLE buku (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    pengarang VARCHAR(255) NOT NULL,
    penerbit VARCHAR(255) NOT NULL,
    isbn VARCHAR(255) NOT NULL UNIQUE,
    tahun_terbit INT NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    deskripsi LONGTEXT NULLABLE,
    stok INT DEFAULT 1,
    gambar VARCHAR(255) NULLABLE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

---

## Routes yang Tersedia

| Method | Route | Controller | Middleware | Nama |
|--------|-------|------------|-----------|------|
| GET | `/mahasiswa/home` | BukuController@index | auth:mahasiswa | mahasiswa.home |
| GET | `/buku/{id}` | BukuController@show | - | buku.detail |

---

## Cara Menambah Buku Baru

### Via Database Seeder

Edit file `database/seeders/BukuSeeder.php` dan tambahkan data buku baru:

```php
Buku::create([
    'judul' => 'Judul Buku',
    'pengarang' => 'Nama Pengarang',
    'penerbit' => 'Nama Penerbit',
    'isbn' => '978-1234567890',
    'tahun_terbit' => 2024,
    'kategori' => 'Kategori',
    'deskripsi' => 'Deskripsi buku...',
    'stok' => 5,
    'gambar' => null, // atau path ke gambar
]);
```

Kemudian jalankan:
```bash
php artisan db:seed --class=BukuSeeder
```

### Via Artisan Tinker

```bash
php artisan tinker
```

```php
use App\Models\Buku;

Buku::create([
    'judul' => 'Judul Buku',
    'pengarang' => 'Nama Pengarang',
    'penerbit' => 'Nama Penerbit',
    'isbn' => '978-1234567890',
    'tahun_terbit' => 2024,
    'kategori' => 'Kategori',
    'deskripsi' => 'Deskripsi buku...',
    'stok' => 5,
]);

exit;
```

### Via Admin Panel (Jika dibuat di masa depan)

Akan dapat menambah buku melalui form di admin panel

---

## Fitur Gambar Buku

### Cara Upload Gambar

1. Simpan gambar di folder `storage/app/public/buku/`
2. Update kolom `gambar` di tabel buku dengan path: `buku/nama-gambar.jpg`

### Setup Symbolic Link

```bash
php artisan storage:link
```

### Contoh Update Gambar via Tinker

```bash
php artisan tinker
```

```php
use App\Models\Buku;

$buku = Buku::first();
$buku->update(['gambar' => 'buku/laskar-pelangi.jpg']);

exit;
```

---

## Fitur yang Akan Ditambahkan di Masa Depan

- [ ] Upload gambar buku
- [ ] Sistem peminjaman buku
- [ ] Riwayat peminjaman
- [ ] Rating dan review buku
- [ ] Search dan filter buku
- [ ] Kategori buku (relasi dengan kategori)
- [ ] Pengarang buku (relasi dengan pengarang)
- [ ] Admin panel untuk manage buku
- [ ] Notifikasi reminder pengembalian buku
- [ ] Daftar tunggu (waiting list) jika stok habis

---

## Testing

### Login Sebagai Mahasiswa

1. Buka halaman utama `/`
2. Scroll ke form login mahasiswa
3. Masukkan NPM dan password dari data test
4. Klik Login → akan diarahkan ke `/mahasiswa/home`

### Lihat Koleksi Buku

Halaman dashboard akan menampilkan:
- Grid koleksi buku 3 kolom
- Setiap buku menampilkan thumbnail dengan placeholder
- Info judul, pengarang, kategori, status stok
- Button "Lihat Detail"

### Buka Detail Buku

1. Klik button "Lihat Detail" pada salah satu buku
2. Akan dibuka halaman `/buku/{id}` dengan detail lengkap
3. Informasi ditampilkan dalam layout profesional
4. Button "Pinjam Buku" tersedia jika stok > 0
5. Button "Kembali ke Koleksi" untuk kembali

---

## API Response (Future Implementation)

```json
{
  "success": true,
  "data": {
    "id": 1,
    "judul": "Laskar Pelangi",
    "pengarang": "Andrea Hirata",
    "penerbit": "Bentang",
    "isbn": "978-979-22-1701-5",
    "tahun_terbit": 2005,
    "kategori": "Fiksi",
    "deskripsi": "...",
    "stok": 5,
    "gambar": "buku/laskar-pelangi.jpg",
    "tersedia": true
  }
}
```

---

Dibuat: 2024
