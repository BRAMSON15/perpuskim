<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$buku->judul}} - PERPUSKIM</title>
    <link rel="stylesheet" href="{{asset('home/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/style.css')}}">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 30px;
            padding-bottom: 30px;
        }
        .detail-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .book-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .book-image-placeholder {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 400px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .book-image-placeholder i {
            font-size: 72px;
            opacity: 0.7;
        }
        .book-info h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .book-meta {
            border-bottom: 2px solid #667eea;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .meta-item {
            margin-bottom: 10px;
        }
        .meta-label {
            font-weight: 600;
            color: #667eea;
            display: inline-block;
            width: 150px;
        }
        .meta-value {
            color: #555;
        }
        .stok-badge {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .stok-badge.available {
            background: #d4edda;
            color: #155724;
        }
        .stok-badge.unavailable {
            background: #f8d7da;
            color: #721c24;
        }
        .deskripsi {
            background: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #667eea;
            border-radius: 4px;
            margin-top: 20px;
        }
        .deskripsi h3 {
            color: #333;
            margin-top: 0;
        }
        .deskripsi p {
            color: #666;
            line-height: 1.8;
        }
        .action-buttons {
            margin-top: 30px;
        }
        .btn-pinjam {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.3s;
            margin-right: 10px;
        }
        .btn-pinjam:hover {
            background: #764ba2;
            text-decoration: none;
            color: white;
        }
        .btn-pinjam:disabled {
            background: #999;
            cursor: not-allowed;
        }
        .btn-back {
            background: #6c757d;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }
        .btn-back:hover {
            background: #5a6268;
            text-decoration: none;
            color: white;
        }
        .header-detail {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .header-detail h1 {
            color: white;
            margin: 0;
        }
    </style>
</head>
<body>
    <!-- Header Detail -->
    <div class="header-detail">
        <div class="container">
            <h1><i class="fa fa-book"></i> Detail Buku</h1>
        </div>
    </div>

    <div class="container">
        <div class="detail-container">
            <div class="row">
                <!-- Gambar Buku -->
                <div class="col-md-4">
                    @if($buku->gambar)
                        <img src="{{asset('storage/' . $buku->gambar)}}" alt="{{$buku->judul}}" class="book-image">
                    @else
                        <div class="book-image-placeholder">
                            <div style="text-align: center;">
                                <i class="fa fa-book"></i>
                                <p style="margin-top: 20px;">Tidak ada gambar</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Informasi Buku -->
                <div class="col-md-8">
                    <div class="book-info">
                        <h1>{{$buku->judul}}</h1>
                        
                        <div class="book-meta mb-4 p-4" style="background-color: #f8f9fa; border-radius: 8px; border-left: 5px solid #667eea; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <span class="meta-label d-block text-muted" style="font-size: 12px; font-weight: bold; text-transform: uppercase; width: auto;">Pengarang</span>
                                    <span class="meta-value font-weight-bold text-dark">{{$buku->pengarang}}</span>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <span class="meta-label d-block text-muted" style="font-size: 12px; font-weight: bold; text-transform: uppercase; width: auto;">Penerbit</span>
                                    <span class="meta-value font-weight-bold text-dark">{{$buku->penerbit ?? '-'}}</span>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <span class="meta-label d-block text-muted" style="font-size: 12px; font-weight: bold; text-transform: uppercase; width: auto;">ISBN</span>
                                    <span class="meta-value font-weight-bold text-dark">{{$buku->isbn ?? '-'}}</span>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <span class="meta-label d-block text-muted" style="font-size: 12px; font-weight: bold; text-transform: uppercase; width: auto;">Tahun Terbit</span>
                                    <span class="meta-value font-weight-bold text-dark">{{$buku->tahun_terbit ?? '-'}}</span>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <span class="meta-label d-block text-muted" style="font-size: 12px; font-weight: bold; text-transform: uppercase; width: auto;">Kategori</span>
                                    <span class="meta-value"><span class="badge badge-primary p-2" style="background-color: #667eea;">{{$buku->kategori}}</span></span>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <span class="meta-label d-block text-muted" style="font-size: 12px; font-weight: bold; text-transform: uppercase; width: auto;">Fakultas</span>
                                    <span class="meta-value"><span class="badge badge-secondary p-2">{{$buku->fakultas ?? 'Semua Fakultas'}}</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Badge Stok -->
                        @if($buku->stok > 0)
                            <div class="stok-badge available">
                                <i class="fa fa-check-circle"></i> Tersedia ({{$buku->stok}} buku)
                            </div>
                        @else
                            <div class="stok-badge unavailable">
                                <i class="fa fa-times-circle"></i> Tidak Tersedia
                            </div>
                        @endif

                        <!-- Deskripsi -->
                        @if($buku->deskripsi)
                        <div class="deskripsi">
                            <h3>Deskripsi</h3>
                            <p>{{$buku->deskripsi}}</p>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            @if($buku->stok > 0)
                                <button class="btn-pinjam" onclick="pinjamBuku({{$buku->id}})">
                                    <i class="fa fa-download"></i> Pinjam Buku
                                </button>
                            @else
                                <button class="btn-pinjam" disabled>
                                    <i class="fa fa-lock"></i> Tidak Bisa Dipinjam
                                </button>
                            @endif
                            
                            @if(auth('mahasiswa')->check())
                                <a href="{{route('mahasiswa.home')}}" class="btn-back">
                                    <i class="fa fa-arrow-left"></i> Kembali ke Koleksi
                                </a>
                            @else
                                <a href="/" class="btn-back">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{asset('home/js/jquery.min.js')}}"></script>
    <script src="{{asset('home/js/bootstrap.bundle.min.js')}}"></script>
    <script>
        function pinjamBuku(bukuId) {
            if (!confirm('Apakah Anda yakin ingin meminjam buku ini?')) return;
            
            fetch('/mahasiswa/pinjam/' + bukuId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if(response.status === 401) {
                    alert('Silakan login sebagai Mahasiswa terlebih dahulu untuk meminjam buku.');
                    window.location.href = '/';
                    return null;
                }
                return response.json();
            })
            .then(data => {
                if(data) {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan pada sistem.');
            });
        }
    </script>
</body>
</html>
