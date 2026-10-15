<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bukuData = [
            [
                'judul' => 'Laskar Pelangi',
                'pengarang' => 'Andrea Hirata',
                'penerbit' => 'Bentang',
                'isbn' => '978-979-22-1701-5',
                'tahun_terbit' => 2005,
                'kategori' => 'Fiksi',
                'deskripsi' => 'Kisah inspiratif tentang perjuangan siswa-siswa berbakat dari keluarga kurang mampu di Belitung. Novel ini mengisahkan persahabatan dan semangat belajar yang luar biasa.',
                'stok' => 5,
            ],
            [
                'judul' => 'Bumi Manusia',
                'pengarang' => 'Pramoedya Ananta Toer',
                'penerbit' => 'Hasta Mitra',
                'isbn' => '978-979-95-7799-8',
                'tahun_terbit' => 1980,
                'kategori' => 'Fiksi Sejarah',
                'deskripsi' => 'Novel epic tentang perjuangan rakyat Indonesia melawan penjajahan Belanda. Mengisahkan kehidupan dan cinta Minke, seorang pemuda pribumi yang berpikiran maju.',
                'stok' => 3,
            ],
            [
                'judul' => 'Perahu Kertas',
                'pengarang' => 'Dee Lestari',
                'penerbit' => 'Gramedia',
                'isbn' => '978-979-533-036-3',
                'tahun_terbit' => 2009,
                'kategori' => 'Fiksi',
                'deskripsi' => 'Cerita dua kaum muda yang terlibat dalam petualangan mencari identitas mereka. Perpaduan sempurna antara romance, thriller, dan spiritual.',
                'stok' => 4,
            ],
            [
                'judul' => 'Filosofi Teras',
                'pengarang' => 'Henry Manampiring',
                'penerbit' => 'Gramedia',
                'isbn' => '978-602-03-3826-8',
                'tahun_terbit' => 2017,
                'kategori' => 'Non-Fiksi',
                'deskripsi' => 'Buku filosofi modern yang menggabungkan pemikiran Stoic kuno dengan kehidupan kontemporer. Memberikan solusi praktis untuk menghadapi tantangan hidup modern.',
                'stok' => 6,
            ],
            [
                'judul' => 'Sapiens',
                'pengarang' => 'Yuval Noah Harari',
                'penerbit' => 'Harvill Secker',
                'isbn' => '978-1-846-55850-2',
                'tahun_terbit' => 2011,
                'kategori' => 'Non-Fiksi',
                'deskripsi' => 'Sejarah singkat manusia dari zaman Batu hingga era modern. Buku yang mengubah perspektif tentang bagaimana peradaban manusia berkembang.',
                'stok' => 4,
            ],
            [
                'judul' => 'Clean Code',
                'pengarang' => 'Robert C. Martin',
                'penerbit' => 'Prentice Hall',
                'isbn' => '978-0-132-35088-2',
                'tahun_terbit' => 2008,
                'kategori' => 'Teknik Informatika',
                'deskripsi' => 'Panduan praktis untuk menulis kode yang bersih, mudah dibaca, dan mudah dipelihara. Wajib dibaca untuk setiap programmer profesional.',
                'stok' => 3,
            ],
            [
                'judul' => 'The Pragmatic Programmer',
                'pengarang' => 'David Thomas, Andrew Hunt',
                'penerbit' => 'Addison-Wesley',
                'isbn' => '978-0-201-61622-4',
                'tahun_terbit' => 1999,
                'kategori' => 'Teknik Informatika',
                'deskripsi' => 'Koleksi tips dan trik dari programmer berpengalaman. Buku ini membantu developer menjadi lebih produktif dan efisien dalam mengerjakan proyek.',
                'stok' => 2,
            ],
            [
                'judul' => 'Pemrograman PHP Modern',
                'pengarang' => 'Adi Nugroho',
                'penerbit' => 'Mediakom',
                'isbn' => '978-979-065-271-8',
                'tahun_terbit' => 2015,
                'kategori' => 'Teknik Informatika',
                'deskripsi' => 'Tutorial lengkap PHP modern dengan framework Laravel. Panduan praktis untuk membangun aplikasi web yang scalable dan secure.',
                'stok' => 5,
            ],
        ];

        foreach ($bukuData as $buku) {
            Buku::create($buku);
        }
    }
}
