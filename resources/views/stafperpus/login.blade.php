<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>Login Staf - PERPUSKIM</title>
    <meta name="description" content="Perpustakaan Universitas Kristen Indonesia Maluku">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{asset('home/images/fevicon.png')}}" type="image/png">
        
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
                                    <img src="{{asset('home/img/image.png')}}" alt="#" style="max-width: 40px; height: auto;" />
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
                                <h2 class="slider_title wow fadeInLeftBig" data-wow-duration="1.3s" data-wow-delay="0.2s">Portal Manajemen<br><span>PERPUSKIM</span></h2>
                                <p class="wow fadeInLeftBig" data-wow-duration="1.3s" data-wow-delay="0.5s">Silakan login untuk mengelola sirkulasi peminjaman, data anggota, dan koleksi buku perpustakaan.</p>
                            </div> 
                        </div>
                        <div class="col-lg-5 col-md-12">
                            <div class="login-card wow fadeInRightBig" data-wow-duration="1.3s" data-wow-delay="0.8s">
                                <h3>Login Staf Perpustakaan</h3>
                                @if(session('error'))
                                    <div class="alert alert-danger" style="margin-bottom: 15px; font-size: 14px; padding: 10px; border-radius: 5px;">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <form method="POST" action="{{ url('/stafperpus/login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Masukkan Username" type="text" name="username" value="{{ old('username') }}" required autofocus>
                                        @error('username')
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
                                </form>
                            </div>
                        </div>
                    </div> 
                </div> 
            </div> 
        </div> 
    </section>
    <!--====== HEADER PART ENDS ======-->

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

