<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>PERPUSKIM - Universitas Kristen Indonesia Maluku</title>
    <meta name="description" content="Perpustakaan Universitas Kristen Indonesia Maluku">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('home/img/image.png')}}" type="image/png">
    <!--====== Animate CSS ======-->
    <link rel="stylesheet" href="{{asset('traveland/assets/css/animate.css')}}">
    <!--====== Nice Select CSS ======-->
    <link rel="stylesheet" href="{{asset('traveland/assets/css/nice-select.css')}}">
    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="{{asset('traveland/assets/css/LineIcons.2.0.css')}}">
    <!--====== Bootstrap CSS ======-->
    <link rel="stylesheet" href="{{asset('traveland/assets/css/bootstrap.4.5.2.min.css')}}">
    <!--====== Default CSS ======-->
    <link rel="stylesheet" href="{{asset('traveland/assets/css/default.css')}}">
    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="{{asset('traveland/assets/css/style.css')}}">
    <style>
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .login-card h3 {
            margin-bottom: 25px;
            font-size: 26px;
            color: #333;
            font-weight: bold;
            text-align: center;
        }
        .login-card .form-control {
            margin-bottom: 15px;
            height: 50px;
            border-radius: 5px;
        }
        @media (max-width: 991px) {
            .login-card {
                margin-top: 40px;
            }
        }
    </style>
</head>

<body>
    <div class="preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== HEADER PART START ======-->
    <section class="header_area">
        <div class="header_navbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="{{url('/')}}">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="{{asset('home/img/image.png')}}" alt="Logo" style="max-width: 40px; height: auto;" />
                                    <div style="display: flex; flex-direction: column;">
                                       <span style="font-size: 14px; font-weight: bold; color: #333; line-height: 1.2;">PERPUSKIM</span>
                                    </div>
                                 </div>
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ml-auto">
                                    <li class="nav-item active">
                                        <a class="page-scroll" href="#home">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#about">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#koleksi">Koleksi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#video">Video</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#contact">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div id="home" class="header_slider" style="position: relative;">
            <!-- Background Carousel -->
            <div id="bgCarousel" class="carousel slide carousel-fade" data-ride="carousel" data-pause="false" style="position: absolute; top:0; left:0; width:100%; height:100%; z-index: 1;">
                <div class="carousel-inner" style="height: 100%;">
                    <div class="carousel-item active" style="height: 100%;">
                        <div class="bg_cover" style="background-image: url({{asset('home/img/1.png')}}); height: 100%; width: 100%; background-position: center; background-size: cover;">
                           <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5);"></div>
                        </div>
                    </div>
                    <div class="carousel-item" style="height: 100%;">
                        <div class="bg_cover" style="background-image: url({{asset('home/img/2.png')}}); height: 100%; width: 100%; background-position: center; background-size: cover;">
                           <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5);"></div>
                        </div>
                    </div>
                    <div class="carousel-item" style="height: 100%;">
                        <div class="bg_cover" style="background-image: url({{asset('home/img/3.png')}}); height: 100%; width: 100%; background-position: center; background-size: cover;">
                           <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5);"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Foreground Content -->
            <div class="single_slider d-flex align-items-center" style="position: relative; z-index: 2; min-height: 800px;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-7 col-md-12">
                            <div class="slider_content">
                                <h2 class="slider_title wow fadeInLeftBig" data-wow-duration="1.3s" data-wow-delay="0.2s">Jelajahi Dunia Pengetahuan<br>bersama<span> PERPUSKIM</span></h2>
                                <p class="wow fadeInLeftBig" data-wow-duration="1.3s" data-wow-delay="0.5s">Temukan ribuan koleksi buku, jurnal, dan referensi akademik untuk mendukung kegiatan studi Anda di Universitas Kristen Indonesia Maluku.</p>
                            </div> 
                        </div>
                        <div class="col-lg-5 col-md-12">
                            <div class="login-card wow fadeInRightBig" data-wow-duration="1.3s" data-wow-delay="0.8s">
                                <h3>Login Mahasiswa</h3>
                                <form method="POST" action="{{route('mahasiswa.login')}}">
                                    @csrf
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Masukkan NPM 14 digit" type="text" name="npm" pattern="\d{14}" maxlength="14" value="{{ old('npm') }}" required>
                                        @error('npm')
                                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Masukkan Password" type="password" name="password" required>
                                        @error('password')
                                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button class="main-btn w-100 text-center" type="submit">Login Sekarang</button>
                                    <div class="mt-3 text-center">
                                        <a href="{{ route('mahasiswa.register') }}" style="color: #667eea; font-weight: bold; text-decoration: underline;">Belum punya akun? Daftar via Scan Kartu</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> 
                </div> 
            </div> 
        </div> 
    </section>
    <!--====== HEADER PART ENDS ======-->

    <!--====== ABOUT PART START ======-->
    <section id="about" class="about_area pt-130 pb-130">
        <div class="about_wrapper">
            <div class="about_image bg_cover" style="background-image: url({{asset('home/img/4.png')}})"></div>
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-lg-6">
                        <div class="about_content">
                            <div class="section_title">
                                <h3 class="title">Tentang Kami <br> Perpustakaan <span>UKIM</span></h3>
                                <p>Perpustakaan Universitas Kristen Indonesia Maluku (PERPUSKIM) adalah pusat informasi dan pembelajaran yang menyediakan koleksi buku, jurnal, dan sumber daya digital untuk mendukung kegiatan akademik mahasiswa dan dosen. Dengan fasilitas modern dan staf yang berpengalaman, kami berkomitmen untuk memberikan layanan terbaik dalam meningkatkan literasi dan pengetahuan sivitas akademika UKIM.</p>
                            </div> 
                        </div> 
                    </div>
                </div> 
            </div> 
        </div> 
    </section>
    <!--====== ABOUT PART ENDS ======-->

    <!--====== KOLEKSI PART START ======-->
    <section id="koleksi" class="services_area pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center pb-25">
                        <h3 class="title">Koleksi Buku</h3>
                        <p>Jelajahi berbagai koleksi buku dari berbagai kategori yang tersedia di Perpustakaan UKIM.</p>
                    </div> 
                </div>
            </div> 

            <!-- Filter & Search Form -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8">
                    <form action="{{ url('/') }}#koleksi" method="GET" class="d-flex justify-content-center">
                        <div class="input-group" style="box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-radius: 5px; overflow: hidden;">
                            <select name="fakultas" class="form-control" style="border: none; border-right: 1px solid #eee; max-width: 250px; height: 50px; background: white; cursor: pointer;">
                                <option value="">Semua Fakultas</option>
                                <option value="Fakultas Teologi" {{ request('fakultas') == 'Fakultas Teologi' ? 'selected' : '' }}>Fakultas Teologi</option>
                                <option value="Fakultas Kesehatan" {{ request('fakultas') == 'Fakultas Kesehatan' ? 'selected' : '' }}>Fakultas Kesehatan</option>
                                <option value="Fakultas Ekonomi" {{ request('fakultas') == 'Fakultas Ekonomi' ? 'selected' : '' }}>Fakultas Ekonomi</option>
                                <option value="Fakultas Ilmu Sosial dan Ilmu Politik" {{ request('fakultas') == 'Fakultas Ilmu Sosial dan Ilmu Politik' ? 'selected' : '' }}>Fakultas Ilmu Sosial dan Ilmu Politik</option>
                                <option value="Fakultas Teknik" {{ request('fakultas') == 'Fakultas Teknik' ? 'selected' : '' }}>Fakultas Teknik</option>
                                <option value="Fakultas Hukum" {{ request('fakultas') == 'Fakultas Hukum' ? 'selected' : '' }}>Fakultas Hukum</option>
                                <option value="Fakultas Keguruan dan Ilmu Pendidikan" {{ request('fakultas') == 'Fakultas Keguruan dan Ilmu Pendidikan' ? 'selected' : '' }}>Fakultas Keguruan dan Ilmu Pendidikan</option>
                            </select>
                            <input type="text" name="search" class="form-control" placeholder="Cari judul buku atau pengarang..." value="{{ request('search') }}" style="border: none; height: 50px; padding-left: 15px;">
                            <div class="input-group-append">
                                <button class="main-btn" type="submit" style="border-radius: 0; padding: 0 25px; line-height: 50px; height: 50px; border: none; cursor: pointer;"><i class="lni lni-search-alt"></i> Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                @forelse($buku as $item)
                <div class="col-lg-4 col-sm-6">
                    <div class="single_service mt-30 text-center wow fadeInUpBig" data-wow-duration="1.3s" data-wow-delay="0.2s" style="padding: 20px; box-shadow: 0 0 15px rgba(0,0,0,0.05); border-radius: 10px;">
                        <div class="services_icon" style="margin-bottom: 20px; width: 100%; height: auto; text-align: center; border: none; background: transparent;">
                            @if($item->gambar)
                               <img src="{{asset('storage/' . $item->gambar)}}" alt="{{$item->judul}}" style="height: 200px; width: 100%; object-fit: cover; border-radius: 5px;">
                            @else
                               <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 200px; width: 100%; display: flex; align-items: center; justify-content: center; border-radius: 5px;">
                                  <div style="text-align: center; color: white;">
                                     <i class="lni lni-book" style="font-size: 48px; color: white;"></i>
                                  </div>
                               </div>
                            @endif
                        </div>
                        <div class="services_content">
                            <h4 class="title" style="margin-bottom: 10px;">{{$item->judul}}</h4>
                            <p style="font-size: 14px; margin-bottom: 5px;"><strong>Pengarang:</strong> {{$item->pengarang}}</p>
                            <p style="font-size: 14px; margin-bottom: 5px;"><strong>Kategori:</strong> {{$item->kategori}}</p>
                            <p style="font-size: 14px; margin-bottom: 15px;"><strong>Stok:</strong> <span style="color: {{$item->stok > 0 ? '#28a745' : '#dc3545'}};">{{$item->stok > 0 ? $item->stok . ' tersedia' : 'Tidak tersedia'}}</span></p>
                            <a href="{{route('buku.detail', $item->id)}}" class="main-btn" style="padding: 0 20px; line-height: 40px; margin-top: 10px;">Detail Buku</a>
                        </div>
                    </div> 
                </div>
                @empty
                <div class="col-md-12">
                   <p style="text-align: center; padding: 20px;">Tidak ada buku tersedia</p>
                </div>
                @endforelse
            </div> 
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $buku->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div> 
    </section>
    <!--====== KOLEKSI PART ENDS ======-->

    <!--====== VIDEO PART START ======-->
    <section id="video" class="blog_area pt-120 pb-130" style="background-color: #f4f6f7;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center pb-25">
                        <h3 class="title">Video Perpustakaan</h3>
                        <p>Tonton video tentang Perpustakaan UKIM dan layanan yang kami sediakan</p>
                    </div> 
                </div>
            </div> 
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="single_blog mt-30 text-center bg-white p-3" style="border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        <div class="blog_image" style="border-radius: 10px; overflow: hidden;">
                            <iframe width="100%" height="450" src="https://www.youtube.com/embed/CnDWuZDPr30" title="Perpustakaan UKIM" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                        <div class="blog_content mt-4">
                            <h4 class="blog_title">Dokumentasi Perpustakaan Universitas Kristen Indonesia Maluku</h4>
                            <p class="mt-3">Video ini menampilkan fasilitas, koleksi, dan layanan yang tersedia di Perpustakaan UKIM. Saksikan pengalaman belajar yang menarik dan koleksi buku yang lengkap.</p>
                        </div>
                    </div> 
                </div>
            </div> 
        </div> 
    </section>
    <!--====== VIDEO PART ENDS ======-->

    <!--====== CONTACT PART START ======-->
    <section id="contact" class="contact_area pt-120 pb-130">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center pb-25">
                        <h3 class="title">Hubungi Kami</h3>
                        <p>Tinggalkan pesan atau pertanyaan Anda di sini, kami akan segera merespons.</p>
                    </div> 
                </div>
            </div> 
            <div class="row">
               <div class="col-lg-6">
                  <div class="contact_form mt-30">
                      <form id="contact-form">
                          <div class="row">
                              <div class="col-lg-12">
                                  <div class="single_form">
                                      <input type="text" name="name" placeholder="Name">
                                  </div> 
                              </div>
                              <div class="col-lg-12">
                                  <div class="single_form">
                                      <input type="email" name="email" placeholder="Email">
                                  </div> 
                              </div>
                              <div class="col-lg-12">
                                  <div class="single_form">
                                      <textarea name="message" placeholder="Message"></textarea>
                                  </div> 
                              </div>
                              <div class="col-lg-12">
                                  <div class="single_form">
                                      <button type="button" class="main-btn">Kirim Pesan</button>
                                  </div> 
                              </div>
                          </div> 
                      </form>
                  </div> 
               </div>
               <div class="col-lg-6">
                  <div class="mt-30" style="border-radius: 10px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                     <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&amp;q=Universitas+Kristen+Indonesia+Maluku" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                  </div>
               </div>
            </div>
        </div> 
    </section>
    <!--====== CONTACT PART ENDS ======-->

    <!--====== FOOTER PART START ======-->
    <section id="footer" class="footer_area">
        <div class="footer_widget pt-80 pb-80">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8 text-center">
                        <div class="footer_about mt-50">
                            <h3 style="color: white; font-weight: bold; margin-bottom: 20px;">PERPUSKIM</h3>
                            <p>Pusat informasi dan pembelajaran Universitas Kristen Indonesia Maluku. Kami berkomitmen untuk memberikan layanan terbaik dalam meningkatkan literasi mahasiswa.</p>
                            <ul class="social" style="justify-content: center; margin-top: 30px;">
                                <li><a class="social_1" href="javascript:void(0)"><i class="lni lni-facebook-original"></i></a></li>
                                <li><a class="social_2" href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                                <li><a class="social_3" href="javascript:void(0)"><i class="lni lni-instagram-original"></i></a></li>
                                <li><a class="social_4" href="javascript:void(0)"><i class="lni lni-youtube"></i></a></li>
                            </ul>
                        </div> 
                    </div>
                </div> 
            </div> 
            <p class="text-center mt-90">© 2024 All Rights Reserved. Perpustakaan UKIM <br> Distributed by <a href="https://themewagon.com" target="_blank">ThemeWagon</a></p>
        </div> 
    </section>
    <!--====== FOOTER PART ENDS ======-->

    <!--====== BACK TOP TOP PART START ======-->
    <a href="#" class="back-to-top"><i class="lni lni-chevron-up"></i></a>
    <!--====== BACK TOP TOP PART ENDS ======-->

    <!--====== Jquery js ======-->
    <script src="{{asset('traveland/assets/js/vendor/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('traveland/assets/js/vendor/modernizr-3.7.1.min.js')}}"></script>
    <!--====== Bootstrap js ======-->
    <script src="{{asset('traveland/assets/js/popper.min.js')}}"></script>
    <script src="{{asset('traveland/assets/js/bootstrap.4.5.2.min.js')}}"></script>
    <!--====== Scrolling Nav js ======-->
    <script src="{{asset('traveland/assets/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('traveland/assets/js/scrolling-nav.js')}}"></script>
    <!--====== Counter Up js ======-->
    <script src="{{asset('traveland/assets/js/waypoints.min.js')}}"></script>
    <script src="{{asset('traveland/assets/js/jquery.counterup.min.js')}}"></script>
    <!--====== Nice Select js ======-->
    <script src="{{asset('traveland/assets/js/jquery.nice-select.min.js')}}"></script>
    <!--====== WOW js ======-->
    <script src="{{asset('traveland/assets/js/wow.min.js')}}"></script>
    <!--====== Main js ======-->
    <script src="{{asset('traveland/assets/js/main.js')}}"></script>
    
</body>
</html>