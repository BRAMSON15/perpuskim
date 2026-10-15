<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', 'Dashboard Admin - PERPUSKIM')</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <!-- <link rel="icon" href="{{ asset('home/img/image.png') }}" type="image/png" /> -->

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
    @yield('styles')
    @stack('styles')
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
              <li class="nav-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                <a href="{{ url('/admin/dashboard') }}">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Manajemen Admin</h4>
              </li>
              @php
                $sidebarPendingCount = \App\Models\Mahasiswa::where('status', 'pending')->count();
              @endphp
              <li class="nav-item {{ request()->is('admin/verifikasi*') ? 'active' : '' }}">
                <a href="{{ url('/admin/verifikasi') }}">
                  <i class="fas fa-id-card"></i>
                  <p>Verifikasi Anggota</p>
                  @if($sidebarPendingCount > 0)
                    <span class="badge badge-warning badge-pill ms-auto" style="font-size: 11px; padding: 4px 8px;">{{ $sidebarPendingCount }}</span>
                  @endif
                </a>
              </li>
              <li class="nav-item {{ request()->is('admin/anggota*') ? 'active' : '' }}">
                <a href="{{ url('/admin/anggota') }}">
                  <i class="fas fa-users"></i>
                  <p>Kelola Anggota</p>
                </a>
              </li>
              <li class="nav-item {{ request()->is('admin/kelolastaf*') ? 'active' : '' }}">
                <a href="{{ url('/admin/kelolastaf') }}">
                  <i class="fas fa-user-cog"></i>
                  <p>Kelola Staf</p>
                </a>
              </li>
              <li class="nav-item {{ request()->is('admin/aktivitaspeminjaman*') ? 'active' : '' }}">
                <a href="{{ url('/admin/aktivitaspeminjaman') }}">
                  <i class="fas fa-history"></i>
                  <p>Aktivitas Peminjaman</p>
                </a>
              </li>
              <li class="nav-item {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                <a href="{{ url('/admin/laporan') }}">
                  <i class="fas fa-file-alt"></i>
                  <p>Laporan</p>
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
                <li class="nav-item dropdown hidden-caret">
                  <a class="dropdown-toggle profile-pic d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm d-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-bold shadow-sm" style="width: 36px; height: 36px; font-size: 14px;">
                      {{ strtoupper(substr(Auth::guard('staf')->user()->nama ?? 'A', 0, 1)) }}
                    </div>
                    <span class="profile-username ms-2">
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold">{{ Auth::guard('staf')->user()->nama ?? 'Admin' }}</span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box d-flex align-items-center p-3">
                          <div class="avatar-lg d-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-bold shadow-sm me-3" style="width: 48px; height: 48px; font-size: 20px;">
                            {{ strtoupper(substr(Auth::guard('staf')->user()->nama ?? 'A', 0, 1)) }}
                          </div>
                          <div class="u-text">
                            <h4 class="mb-1" style="font-size: 15px;">{{ Auth::guard('staf')->user()->nama ?? 'Admin' }}</h4>
                            <p class="text-muted mb-0 small">{{ Auth::guard('staf')->user()->username ?? '' }} &bull; <span class="badge badge-primary py-0 px-2" style="font-size: 10px;">{{ strtoupper(Auth::guard('staf')->user()->role ?? 'ADMIN') }}</span></p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item py-2" href="{{ url('/admin/dashboard') }}">
                          <i class="fas fa-home me-2 text-primary"></i> Dashboard
                        </a>
                        <a class="dropdown-item py-2" href="{{ url('/admin/verifikasi') }}">
                          <i class="fas fa-id-card me-2 text-warning"></i> Verifikasi Anggota
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2" style="border: none; background: none; width: 100%; text-align: left; padding-left: 16px;">
                              <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
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

      <!-- Custom template removed for production clean look -->
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
      $(document).ready(function() {
        if ($.fn.DataTable) {
          $('.table:not(.table-simple):not(.table-no-datatable)').each(function() {
            if (!$.fn.DataTable.isDataTable(this)) {
              $(this).DataTable({
                "pageLength": 10,
              });
            }
          });
        }
      });
    </script>
    @yield('scripts')
    @stack('scripts')
  </body>
</html>
