<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>Profil Mahasiswa - PERPUSKIM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('home/img/image.png')}}" type="image/png">
    
    <link rel="stylesheet" href="{{asset('traveland/assets/css/bootstrap.4.5.2.min.css')}}">
    <link rel="stylesheet" href="{{asset('traveland/assets/css/default.css')}}">
    <link rel="stylesheet" href="{{asset('traveland/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('traveland/assets/css/LineIcons.2.0.css')}}">
    
    <style>
        body { background-color: #f8f9fa; }
        .profil-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .header-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 0;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('mahasiswa.home') }}">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="{{asset('home/img/image.png')}}" alt="#" style="max-width: 40px; height: auto;" />
                    <span style="font-size: 16px; font-weight: bold; color: #333;">PERPUSKIM</span>
                </div>
            </a>
            <div class="ml-auto">
                <a href="{{ route('mahasiswa.home') }}" class="btn btn-outline-primary mr-2">Kembali ke Dashboard</a>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="header-bg">
        <div class="container">
            <h2>Profil Saya</h2>
            <p>Kelola informasi akun dan pantau aktivitas peminjaman buku Anda</p>
        </div>
    </div>

    <!-- Profil Section -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="profil-card">
                    <h3 class="mb-4 border-bottom pb-3"><i class="lni lni-user text-primary"></i> Informasi Akun</h3>
                    
                    <div class="row mb-4" style="font-size: 16px; line-height: 2;">
                        <div class="col-sm-4 text-muted font-weight-bold">Nama Lengkap</div>
                        <div class="col-sm-8">{{ $mahasiswa->nama }}</div>
                        
                        <div class="col-sm-4 text-muted font-weight-bold">NPM</div>
                        <div class="col-sm-8">{{ $mahasiswa->npm }}</div>
                        
                        <div class="col-sm-4 text-muted font-weight-bold">Email</div>
                        <div class="col-sm-8">{{ $mahasiswa->email ?? '-' }}</div>
                        
                        <div class="col-sm-4 text-muted font-weight-bold">Program Studi</div>
                        <div class="col-sm-8">{{ $mahasiswa->prodi ?? '-' }}</div>
                        
                        <div class="col-sm-4 text-muted font-weight-bold">Fakultas</div>
                        <div class="col-sm-8">{{ $mahasiswa->fakultas ?? '-' }}</div>
                        
                        <div class="col-sm-4 text-muted font-weight-bold">No. Telepon</div>
                        <div class="col-sm-8">{{ $mahasiswa->no_telp ?? '-' }}</div>
                    </div>

                    <h3 class="mt-5 mb-4 border-bottom pb-3"><i class="lni lni-book text-warning"></i> Status Peminjaman Aktif</h3>
                    
                    @if(isset($peminjamanAktif) && $peminjamanAktif->count() > 0)
                        <div class="alert alert-info p-4" style="border-radius: 10px;">
                            <ul class="pl-3 mb-0" style="list-style-type: disc; color: #333; font-size: 15px;">
                            @foreach($peminjamanAktif as $pinjam)
                                @php
                                    $sisaHari = \Carbon\Carbon::now()->startOfDay()->diffInDays($pinjam->tenggat_waktu, false);
                                    $isLate = $sisaHari < 0;
                                @endphp
                                <li class="mb-3">
                                    <strong>{{ $pinjam->buku->judul ?? 'Buku dihapus' }}</strong><br>
                                    Dipinjam pada: {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}<br>
                                    @if($isLate)
                                        <span class="text-danger font-weight-bold">Terlambat {{ abs($sisaHari) }} hari! Harap segera kembalikan ke perpustakaan.</span>
                                    @elseif($sisaHari == 0)
                                        <span class="text-warning font-weight-bold">Batas pengembalian hari ini!</span>
                                    @else
                                        <span class="text-success font-weight-bold">Sisa waktu peminjaman: {{ $sisaHari }} hari</span>
                                    @endif
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="alert alert-light text-center p-4">
                            <p class="mb-0 text-muted">Anda tidak memiliki peminjaman buku aktif saat ini.</p>
                        </div>
                    @endif

                    <div class="mt-5 text-center">
                        <form method="POST" action="{{route('mahasiswa.logout')}}">
                            @csrf
                            <button class="btn btn-danger px-5 py-2" style="border-radius: 30px; font-weight: bold;" type="submit"><i class="lni lni-exit"></i> Keluar (Logout)</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <section id="footer" class="footer_area bg-dark">
        <div class="footer_widget py-4 text-center">
            <p class="text-white mb-0">© 2024 All Rights Reserved. Perpustakaan UKIM</p>
        </div> 
    </section>

</body>
</html>
