<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Beranda Staf - Sistem Informasi Peminjaman</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link rel="icon" href="{{ asset('home/img/image.png') }}" type="image/png" />

    <!-- Fonts and icons -->
    <script src="{{ asset('admin_theme/assets') }}/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["{{ asset('admin_theme/assets') }}/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin_theme/assets') }}/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('admin_theme/assets') }}/css/plugins.min.css" />
    <link rel="stylesheet" href="{{ asset('admin_theme/assets') }}/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('admin_theme/assets') }}/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
                          <a href="{{ url('/') }}" class="logo d-flex align-items-center" style="gap: 10px;">
                <img
                  src="{{ asset('home/img/image.png') }}"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="30"
                />
                <span style="color: white; font-weight: bold; font-size: 18px;">PERPUSKIM</span>
              </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a href="{{ url('/stafperpus/home') }}">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Manajemen</h4>
              </li>
              <li class="nav-item">
                <a href="{{ url('/stafperpus/kelolapeminjaman') }}">
                  <i class="fas fa-book-reader"></i>
                  <p>Kelola Peminjaman</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/stafperpus/aktivitaspeminjaman') }}">
                  <i class="fas fa-history"></i>
                  <p>Aktivitas Peminjaman</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/stafperpus/kelolabuku') }}">
                  <i class="fas fa-book"></i>
                  <p>Input Koleksi Buku</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
                            <a href="{{ url('/') }}" class="logo d-flex align-items-center" style="gap: 10px;">
                <img
                  src="{{ asset('home/img/image.png') }}"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="30"
                />
                <span style="color: white; font-weight: bold; font-size: 18px;">PERPUSKIM</span>
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                <li class="nav-item topbar-user dropdown hidden-caret">
  <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
    <div class="avatar-sm">
      <!-- <img src="{{ asset('admin_theme/assets') }}/img/profile.jpg" alt="..." class="avatar-img rounded-circle" /> -->
    </div>
    <span class="profile-username">
      <span class="op-7">Hi,</span>
      <span class="fw-bold">{{ Auth::guard('staf')->user()->nama ?? 'Staf' }}</span>
    </span>
  </a>
  <ul class="dropdown-menu dropdown-user animated fadeIn">
    <div class="dropdown-user-scroll scrollbar-outer">
      <li>
        <div class="user-box">
          <div class="avatar-lg">
            <!-- <img src="{{ asset('admin_theme/assets') }}/img/profile.jpg" alt="image profile" class="avatar-img rounded" /> -->
          </div>
          <div class="u-text">
            <h4>{{ Auth::guard('staf')->user()->nama ?? 'Staf' }}</h4>
            <p class="text-muted">{{ Auth::guard('staf')->user()->username ?? '' }}</p>
          </div>
        </div>
      </li>
      <li>
        <div class="dropdown-divider"></div>
        <form action="{{ route('staf.logout') }}" method="POST">
            @csrf
            <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; text-align: left; padding-left: 20px;">Logout</button>
        </form>
      </li>
    </div>
  </ul>
</li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>

        <div class="container">
          @yield('content')
        </div>

                <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <nav class="pull-left">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    PERPUSKIM
                  </a>
                </li>
              </ul>
            </nav>
            <div class="copyright">
              2024, Sistem Informasi Perpustakaan UKIM
            </div>
          </div>
        </footer>
      </div>

      <!-- Custom template | don't include it in your project! -->
      <div class="custom-template">
        <div class="title">Settings</div>
        <div class="custom-content">
          <div class="switcher">
            <div class="switch-block">
              <h4>Logo Header</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="selected changeLogoHeaderColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="blue"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="purple"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="light-blue"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="green"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="orange"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="red"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="white"
                ></button>
                <br />
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="dark2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="blue2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="purple2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="light-blue2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="green2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="orange2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="red2"
                ></button>
              </div>
            </div>
            <div class="switch-block">
              <h4>Navbar Header</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="blue"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="purple"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="light-blue"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="green"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="orange"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="red"
                ></button>
                <button
                  type="button"
                  class="selected changeTopBarColor"
                  data-color="white"
                ></button>
                <br />
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="dark2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="blue2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="purple2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="light-blue2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="green2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="orange2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="red2"
                ></button>
              </div>
            </div>
            <div class="switch-block">
              <h4>Sidebar</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="changeSideBarColor"
                  data-color="white"
                ></button>
                <button
                  type="button"
                  class="selected changeSideBarColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeSideBarColor"
                  data-color="dark2"
                ></button>
              </div>
            </div>
          </div>
        </div>
        <div class="custom-toggle">
          <i class="icon-settings"></i>
        </div>
      </div>
      <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('admin_theme/assets') }}/js/core/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('admin_theme/assets') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('admin_theme/assets') }}/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('admin_theme/assets') }}/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="{{ asset('admin_theme/assets') }}/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('admin_theme/assets') }}/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('admin_theme/assets') }}/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="{{ asset('admin_theme/assets') }}/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('admin_theme/assets') }}/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('admin_theme/assets') }}/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="{{ asset('admin_theme/assets') }}/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('admin_theme/assets') }}/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('admin_theme/assets') }}/js/kaiadmin.min.js"></script>

    
    <script>
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
      });

      $(document).ready(function() {
        $('.table').DataTable({
          "pageLength": 10,
        });
      });
    </script>
  </body>
</html>
