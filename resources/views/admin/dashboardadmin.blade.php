@extends('admin.layout')

@section('title', 'Dashboard Administrator - PERPUSKIM')

@section('styles')
<style>
  /* ==========================================================
     ADMIN DASHBOARD MODERN STYLING
     ========================================================== */
  
  :root {
    --adm-primary: #1d4ed8;
    --adm-primary-dark: #0f172a;
    --adm-success: #10b981;
    --adm-warning: #f59e0b;
    --adm-danger: #ef4444;
    --adm-info: #06b6d4;
    --adm-purple: #8b5cf6;
    --adm-card-border: rgba(226, 232, 240, 0.9);
  }

  /* Hero Welcome Banner */
  .admin-hero-banner {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 55%, #2563eb 100%);
    border-radius: 18px;
    padding: 30px 32px;
    color: #ffffff;
    box-shadow: 0 10px 30px -5px rgba(37, 99, 235, 0.25);
    position: relative;
    overflow: hidden;
    margin-bottom: 24px;
    border: 1px solid rgba(255, 255, 255, 0.1);
  }

  .admin-hero-banner::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 240px;
    height: 240px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0) 70%);
    border-radius: 50%;
    pointer-events: none;
  }

  .admin-hero-banner::after {
    content: '';
    position: absolute;
    bottom: -60px;
    left: 30%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(96, 165, 250, 0.15) 0%, rgba(96, 165, 250, 0) 70%);
    border-radius: 50%;
    pointer-events: none;
  }

  .hero-pill-badge {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    padding: 5px 14px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.7px;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #e0f2fe;
    margin-bottom: 12px;
  }

  .pulse-dot {
    width: 8px;
    height: 8px;
    background-color: #34d399;
    border-radius: 50%;
    display: inline-block;
    box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.7);
    animation: pulseGlow 1.8s infinite;
  }

  @keyframes pulseGlow {
    0% {
      transform: scale(0.95);
      box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.7);
    }
    70% {
      transform: scale(1);
      box-shadow: 0 0 0 8px rgba(52, 211, 153, 0);
    }
    100% {
      transform: scale(0.95);
      box-shadow: 0 0 0 0 rgba(52, 211, 153, 0);
    }
  }

  .date-display-badge {
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 12px;
    padding: 10px 18px;
    font-size: 0.88rem;
    color: #ffffff;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-weight: 500;
  }

  /* Pending Verification Alert Banner */
  .pending-alert-banner {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border: 1px solid #fde68a;
    border-left: 5px solid #f59e0b;
    border-radius: 16px;
    padding: 16px 22px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.08);
  }

  .pending-alert-icon {
    width: 44px;
    height: 44px;
    background: #f59e0b;
    color: #ffffff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
  }

  /* Modern Stat Cards */
  .stat-card-modern {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid var(--adm-card-border);
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    padding: 22px;
    height: 100%;
    transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
    position: relative;
    overflow: hidden;
  }

  .stat-card-modern:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(15, 23, 42, 0.09);
    border-color: #cbd5e1;
  }

  .stat-icon-wrapper {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    color: #ffffff;
    flex-shrink: 0;
  }

  .icon-grad-blue {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    box-shadow: 0 6px 14px rgba(37, 99, 235, 0.3);
  }

  .icon-grad-amber {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    box-shadow: 0 6px 14px rgba(245, 158, 11, 0.3);
  }

  .icon-grad-emerald {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    box-shadow: 0 6px 14px rgba(16, 185, 129, 0.3);
  }

  .icon-grad-purple {
    background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    box-shadow: 0 6px 14px rgba(139, 92, 246, 0.3);
  }

  .stat-title {
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    margin-bottom: 4px;
  }

  .stat-number {
    font-size: 1.85rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.15;
    margin-bottom: 6px;
    letter-spacing: -0.5px;
  }

  .stat-subtitle {
    font-size: 0.78rem;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  /* Quick Action Buttons */
  .quick-action-col {
    flex: 0 0 20%;
    max-width: 20%;
  }

  @media (max-width: 991px) {
    .quick-action-col {
      flex: 0 0 33.333333%;
      max-width: 33.333333%;
    }
  }

  @media (max-width: 576px) {
    .quick-action-col {
      flex: 0 0 50%;
      max-width: 50%;
    }
  }

  .quick-action-tile {
    background: #ffffff;
    border: 1px solid var(--adm-card-border);
    border-radius: 14px;
    padding: 16px 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    color: #1e293b;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    height: 100%;
  }

  .quick-action-tile:hover {
    background: #f8fafc;
    border-color: #3b82f6;
    color: #1d4ed8;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.08);
  }

  .quick-action-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    flex-shrink: 0;
  }

  /* Modern Card Box */
  .modern-box {
    background: #ffffff;
    border: 1px solid var(--adm-card-border);
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
    margin-bottom: 24px;
    overflow: hidden;
  }

  .modern-box-header {
    padding: 18px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #ffffff;
  }

  .modern-box-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .modern-box-body {
    padding: 22px 24px;
  }

  /* Modern Table Styling */
  .table-custom-modern {
    margin-bottom: 0;
  }

  .table-custom-modern thead th {
    background-color: #f8fafc;
    color: #64748b;
    font-size: 0.74rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    border-top: none;
    border-bottom: 1px solid #e2e8f0;
    padding: 12px 16px;
    white-space: nowrap;
  }

  .table-custom-modern tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.88rem;
    color: #334155;
  }

  .table-custom-modern tbody tr:last-child td {
    border-bottom: none;
  }

  .table-custom-modern tbody tr:hover {
    background-color: #f8fafc;
  }

  /* User Initial Avatar */
  .user-avatar-initial {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #eff6ff;
    color: #2563eb;
    font-weight: 700;
    font-size: 0.95rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #dbeafe;
    flex-shrink: 0;
  }

  /* Badges */
  .badge-soft-success {
    background-color: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
    padding: 5px 10px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 0.74rem;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }

  .badge-soft-warning {
    background-color: #fffbeb;
    color: #d97706;
    border: 1px solid #fde68a;
    padding: 5px 10px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 0.74rem;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }

  .badge-soft-danger {
    background-color: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
    padding: 5px 10px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 0.74rem;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }

  /* Pending Student List Item */
  .pending-student-card {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 14px;
    background: #ffffff;
    transition: all 0.2s ease;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }

  .pending-student-card:hover {
    border-color: #3b82f6;
    background: #f8fafc;
    transform: translateX(2px);
  }

  /* System Metric Progress Bar */
  .system-progress-item {
    margin-bottom: 16px;
  }

  .system-progress-label {
    display: flex;
    justify-content: space-between;
    font-size: 0.82rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 6px;
  }

  .progress-custom {
    height: 8px;
    border-radius: 10px;
    background-color: #f1f5f9;
    overflow: hidden;
  }

  .chart-container-box {
    position: relative;
    height: 260px;
    width: 100%;
  }
</style>
@endsection

@section('content')
<div class="page-inner py-4">

  <!-- ==========================================================
       1. HERO BANNER / GREETING SECTION
       ========================================================== -->
  <div class="admin-hero-banner">
    <div class="row align-items-center">
      <div class="col-lg-8 mb-3 mb-lg-0">
        <div class="hero-pill-badge">
          <span class="pulse-dot"></span>
          <span>Sistem Informasi Perpustakaan UKIM</span>
        </div>
        <h2 class="fw-bold mb-2">Selamat Datang, {{ Auth::guard('staf')->user()->nama ?? 'Administrator' }}! 👋</h2>
        <p class="text-white-50 mb-0" style="font-size: 0.95rem; line-height: 1.6; max-width: 620px;">
          Pantau sirkulasi peminjaman buku, kelola staf operasional, dan lakukan verifikasi berkas anggota mahasiswa secara terintegrasi dan real-time.
        </p>
      </div>
      <div class="col-lg-4 text-lg-end">
        <div class="d-flex flex-column flex-sm-row flex-lg-column align-items-lg-end gap-2 justify-content-lg-center">
          <div class="date-display-badge">
            <i class="far fa-calendar-check text-info"></i>
            <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
          </div>
          <div class="mt-2">
            <a href="{{ url('/admin/laporan') }}" class="btn btn-light btn-round fw-bold shadow-sm px-3 py-2" style="color: #1e3a8a;">
              <i class="fas fa-file-pdf me-1 text-danger"></i> Rekap Laporan
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ==========================================================
       2. NOTIFIKASI PENDING VERIFIKASI (JIKA ADA)
       ========================================================== -->
  @if(($pendingVerifikasi ?? 0) > 0)
  <div class="pending-alert-banner">
    <div class="d-flex align-items-center gap-3">
      <div class="pending-alert-icon">
        <i class="fas fa-user-clock"></i>
      </div>
      <div>
        <h6 class="fw-bold mb-1 text-dark">
          Terdapat {{ $pendingVerifikasi }} Calon Anggota Baru Menunggu Verifikasi
        </h6>
        <p class="mb-0 text-muted small">
          Mahasiswa baru telah mendaftar dan mengunggah kartu identitas. Segera lakukan peninjauan berkas agar akun mereka dapat aktif.
        </p>
      </div>
    </div>
    <div>
      <a href="{{ url('/admin/verifikasi') }}" class="btn btn-warning btn-round fw-bold px-3 py-2 text-dark shadow-sm">
        <i class="fas fa-id-card me-1"></i> Tinjau Pendaftar ({{ $pendingVerifikasi }}) <i class="fas fa-arrow-right ms-1"></i>
      </a>
    </div>
  </div>
  @endif

  <!-- ==========================================================
       3. METRICS / STAT CARDS GRID
       ========================================================== -->
  <div class="row g-3 mb-4">
    <!-- Stat 1: Total Anggota Aktif -->
    <div class="col-sm-6 col-xl-3">
      <div class="stat-card-modern">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <span class="stat-title">Anggota Terverifikasi</span>
          <div class="stat-icon-wrapper icon-grad-blue">
            <i class="fas fa-users"></i>
          </div>
        </div>
        <div class="stat-number">{{ number_format($totalAnggota ?? 0) }}</div>
        <div class="stat-subtitle">
          @if(($pendingVerifikasi ?? 0) > 0)
            <span class="text-warning fw-semibold">
              <i class="fas fa-clock"></i> {{ $pendingVerifikasi }} pending
            </span>
          @else
            <span class="text-success fw-semibold">
              <i class="fas fa-check-circle"></i> Semua aktif
            </span>
          @endif
          <span class="text-muted ms-1">&bull; Mahasiswa</span>
        </div>
      </div>
    </div>

    <!-- Stat 2: Buku Dipinjam -->
    <div class="col-sm-6 col-xl-3">
      <div class="stat-card-modern">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <span class="stat-title">Sedang Dipinjam</span>
          <div class="stat-icon-wrapper icon-grad-amber">
            <i class="fas fa-book-reader"></i>
          </div>
        </div>
        <div class="stat-number">{{ number_format($bukuDipinjam ?? 0) }}</div>
        <div class="stat-subtitle">
          <span class="text-success fw-semibold">
            <i class="fas fa-undo-alt"></i> {{ $pengembalianHariIni ?? 0 }} kembali
          </span>
          <span class="text-muted ms-1">&bull; Hari ini</span>
        </div>
      </div>
    </div>

    <!-- Stat 3: Total Eksemplar Buku -->
    <div class="col-sm-6 col-xl-3">
      <div class="stat-card-modern">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <span class="stat-title">Total Stok Koleksi</span>
          <div class="stat-icon-wrapper icon-grad-emerald">
            <i class="fas fa-book"></i>
          </div>
        </div>
        <div class="stat-number">{{ number_format($totalBuku ?? 0) }}</div>
        <div class="stat-subtitle">
          <span class="text-primary fw-semibold">
            <i class="fas fa-layer-group"></i> {{ $totalJudulBuku ?? 0 }} judul
          </span>
          <span class="text-muted ms-1">&bull; Eksemplar buku</span>
        </div>
      </div>
    </div>

    <!-- Stat 4: Staf Operasional -->
    <div class="col-sm-6 col-xl-3">
      <div class="stat-card-modern">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <span class="stat-title">Staf Perpustakaan</span>
          <div class="stat-icon-wrapper icon-grad-purple">
            <i class="fas fa-user-shield"></i>
          </div>
        </div>
        <div class="stat-number">{{ number_format($totalStaf ?? 0) }}</div>
        <div class="stat-subtitle">
          <span class="text-purple fw-semibold">
            <i class="fas fa-check-shield"></i> Bertugas
          </span>
          <span class="text-muted ms-1">&bull; Role Staf Perpus</span>
        </div>
      </div>
    </div>
  </div>

  <!-- ==========================================================
       4. PUSAT AKSES CEPAT (QUICK ACTIONS)
       ========================================================== -->
  <div class="row g-3 mb-4">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <h6 class="fw-bold text-dark mb-0" style="letter-spacing: 0.3px;">
          <i class="fas fa-bolt text-warning me-1"></i> Pusat Akses Cepat Administrator
        </h6>
        <span class="text-muted small">Pintasan menu utama</span>
      </div>
    </div>

    <!-- Action 1: Verifikasi Anggota -->
    <div class="quick-action-col mb-2">
      <a href="{{ url('/admin/verifikasi') }}" class="quick-action-tile">
        <div class="quick-action-icon bg-warning bg-opacity-10 text-warning">
          <i class="fas fa-id-card"></i>
        </div>
        <div>
          <div class="fw-bold small">Verifikasi</div>
          <div class="text-muted" style="font-size: 11px;">
            @if(($pendingVerifikasi ?? 0) > 0)
              <span class="badge badge-warning p-1" style="font-size: 9px;">{{ $pendingVerifikasi }} menunggu</span>
            @else
              Anggota baru
            @endif
          </div>
        </div>
      </a>
    </div>

    <!-- Action 2: Kelola Anggota -->
    <div class="quick-action-col mb-2">
      <a href="{{ url('/admin/anggota') }}" class="quick-action-tile">
        <div class="quick-action-icon bg-primary bg-opacity-10 text-primary">
          <i class="fas fa-users-cog"></i>
        </div>
        <div>
          <div class="fw-bold small">Data Anggota</div>
          <div class="text-muted" style="font-size: 11px;">Daftar & status</div>
        </div>
      </a>
    </div>

    <!-- Action 3: Kelola Staf -->
    <div class="quick-action-col mb-2">
      <a href="{{ url('/admin/kelolastaf') }}" class="quick-action-tile">
        <div class="quick-action-icon bg-info bg-opacity-10 text-info">
          <i class="fas fa-user-tie"></i>
        </div>
        <div>
          <div class="fw-bold small">Kelola Staf</div>
          <div class="text-muted" style="font-size: 11px;">Akun petugas</div>
        </div>
      </a>
    </div>

    <!-- Action 4: Aktivitas Peminjaman -->
    <div class="quick-action-col mb-2">
      <a href="{{ url('/admin/aktivitaspeminjaman') }}" class="quick-action-tile">
        <div class="quick-action-icon bg-success bg-opacity-10 text-success">
          <i class="fas fa-history"></i>
        </div>
        <div>
          <div class="fw-bold small">Sirkulasi</div>
          <div class="text-muted" style="font-size: 11px;">Log peminjaman</div>
        </div>
      </a>
    </div>

    <!-- Action 5: Laporan PDF/Excel -->
    <div class="quick-action-col mb-2">
      <a href="{{ url('/admin/laporan') }}" class="quick-action-tile">
        <div class="quick-action-icon bg-danger bg-opacity-10 text-danger">
          <i class="fas fa-file-alt"></i>
        </div>
        <div>
          <div class="fw-bold small">Laporan</div>
          <div class="text-muted" style="font-size: 11px;">Cetak rekapitulasi</div>
        </div>
      </a>
    </div>
  </div>

  <!-- ==========================================================
       5. MAIN CONTENT: 2-COLUMN GRID (8 + 4)
       ========================================================== -->
  <div class="row g-4">
    
    <!-- KOLOM KIRI (COL-LG-8): GRAFIK & AKTIVITAS PEMINJAMAN TERBARU -->
    <div class="col-lg-8">
      
      <!-- Grafik Tren Sirkulasi -->
      <div class="modern-box">
        <div class="modern-box-header">
          <div>
            <h5 class="modern-box-title">
              <i class="fas fa-chart-line text-primary"></i> Tren Sirkulasi Peminjaman & Pengembalian
            </h5>
            <small class="text-muted">Aktivitas peminjaman dan pengembalian dalam 7 hari terakhir</small>
          </div>
          <div class="d-flex align-items-center gap-2">
            <span class="badge badge-soft-warning">
              <i class="fas fa-book-open"></i> {{ $totalPeminjaman ?? 0 }} Total Transaksi
            </span>
          </div>
        </div>
        <div class="modern-box-body">
          <div class="chart-container-box">
            <canvas id="circulationChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Tabel Peminjaman Terkini -->
      <div class="modern-box">
        <div class="modern-box-header">
          <div>
            <h5 class="modern-box-title">
              <i class="fas fa-clock text-warning"></i> Aktivitas Peminjaman Terkini
            </h5>
            <small class="text-muted">Daftar transaksi peminjaman buku paling baru</small>
          </div>
          <a href="{{ url('/admin/aktivitaspeminjaman') }}" class="btn btn-outline-primary btn-sm btn-round">
            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
          </a>
        </div>
        <div class="modern-box-body p-0">
          <div class="table-responsive">
            <table class="table table-custom-modern table-simple w-100">
              <thead>
                <tr>
                  <th>Mahasiswa</th>
                  <th>Buku</th>
                  <th>Tanggal Pinjam</th>
                  <th>Tenggat</th>
                  <th class="text-center">Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($riwayatTerbaru as $item)
                  @php
                    $isOverdue = false;
                    if ($item->status === 'Dipinjam' && $item->tenggat_waktu) {
                        $isOverdue = \Carbon\Carbon::now()->startOfDay()->gt(\Carbon\Carbon::parse($item->tenggat_waktu)->startOfDay());
                    }
                    $initial = strtoupper(substr($item->mahasiswa->nama ?? 'M', 0, 1));
                  @endphp
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <div class="user-avatar-initial">{{ $initial }}</div>
                        <div>
                          <div class="fw-bold text-dark" style="font-size: 0.88rem;">{{ $item->mahasiswa->nama ?? 'Tidak diketahui' }}</div>
                          <div class="text-muted" style="font-size: 0.74rem;">NPM: {{ $item->mahasiswa_npm }}</div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="fw-semibold text-dark" style="font-size: 0.88rem;">
                        <i class="fas fa-book text-muted me-1"></i> {{ $item->buku->judul ?? 'Buku #'.$item->buku_id }}
                      </div>
                      <div class="text-muted" style="font-size: 0.74rem;">
                        {{ $item->buku->pengarang ?? '-' }}
                      </div>
                    </td>
                    <td class="text-muted" style="font-size: 0.82rem;">
                      {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y') : '-' }}
                    </td>
                    <td class="text-muted" style="font-size: 0.82rem;">
                      {{ $item->tenggat_waktu ? \Carbon\Carbon::parse($item->tenggat_waktu)->translatedFormat('d M Y') : '-' }}
                    </td>
                    <td class="text-center">
                      @if($item->status === 'Selesai')
                        <span class="badge-soft-success">
                          <i class="fas fa-check"></i> Selesai
                        </span>
                      @elseif($isOverdue)
                        <span class="badge-soft-danger">
                          <i class="fas fa-exclamation-triangle"></i> Terlambat
                        </span>
                      @else
                        <span class="badge-soft-warning">
                          <i class="fas fa-clock"></i> Dipinjam
                        </span>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center py-5">
                      <div class="text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 text-secondary opacity-50"></i>
                        <p class="mb-0 fw-semibold">Belum ada riwayat aktivitas peminjaman buku.</p>
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>

    <!-- KOLOM KANAN (COL-LG-4): PENDAFTAR PENDING & STATUS SISTEM -->
    <div class="col-lg-4">

      <!-- Widget: Calon Anggota Menunggu Verifikasi -->
      <div class="modern-box">
        <div class="modern-box-header">
          <div>
            <h5 class="modern-box-title" style="font-size: 0.98rem;">
              <i class="fas fa-user-check text-warning"></i> Calon Anggota Baru
            </h5>
            <small class="text-muted">Pendaftar menunggu verifikasi berkas</small>
          </div>
          @if(($pendingVerifikasi ?? 0) > 0)
            <span class="badge badge-warning rounded-pill px-2 py-1" style="font-size: 11px;">{{ $pendingVerifikasi }}</span>
          @endif
        </div>
        <div class="modern-box-body">
          @forelse($pendingMahasiswa as $pending)
            @php
              $pInitial = strtoupper(substr($pending->nama ?? 'U', 0, 1));
            @endphp
            <div class="pending-student-card">
              <div class="d-flex align-items-center gap-2" style="min-width: 0;">
                <div class="user-avatar-initial" style="background: #fef3c7; color: #d97706; border-color: #fde68a;">
                  {{ $pInitial }}
                </div>
                <div style="min-width: 0;">
                  <div class="fw-bold text-truncate text-dark" style="font-size: 0.85rem;" title="{{ $pending->nama }}">
                    {{ $pending->nama }}
                  </div>
                  <div class="text-muted small text-truncate" style="font-size: 0.72rem;">
                    NPM: {{ $pending->npm }}
                  </div>
                </div>
              </div>
              <a href="{{ url('/admin/verifikasi') }}" class="btn btn-outline-warning btn-sm btn-round fw-bold px-2 py-1 text-nowrap" style="font-size: 11px;">
                Tinjau <i class="fas fa-chevron-right ms-1"></i>
              </a>
            </div>
          @empty
            <div class="text-center py-4">
              <div class="mb-2">
                <i class="fas fa-check-circle text-success" style="font-size: 2.5rem; opacity: 0.85;"></i>
              </div>
              <h6 class="fw-bold text-dark mb-1">Semua Berkas Bersih!</h6>
              <p class="text-muted small mb-0">Tidak ada calon anggota baru yang menunggu verifikasi saat ini.</p>
            </div>
          @endforelse

          @if(($pendingVerifikasi ?? 0) > count($pendingMahasiswa ?? []))
            <div class="text-center mt-3 pt-2 border-top">
              <a href="{{ url('/admin/verifikasi') }}" class="text-primary small fw-bold text-decoration-none">
                Lihat {{ $pendingVerifikasi - count($pendingMahasiswa) }} pendaftar lainnya &rarr;
              </a>
            </div>
          @endif
        </div>
      </div>

      <!-- Widget: Ringkasan Kapasitas & Operasional -->
      <div class="modern-box">
        <div class="modern-box-header">
          <div>
            <h5 class="modern-box-title" style="font-size: 0.98rem;">
              <i class="fas fa-sliders-h text-info"></i> Kapasitas & Status Sistem
            </h5>
            <small class="text-muted">Ringkasan operasional perpustakaan</small>
          </div>
        </div>
        <div class="modern-box-body">
          @php
            $totalStokSafe = ($totalBuku ?? 0) > 0 ? $totalBuku : 1;
            $persenDipinjam = min(100, round((($bukuDipinjam ?? 0) / $totalStokSafe) * 100, 1));
            
            $totalMhsAll = ($totalAnggota ?? 0) + ($pendingVerifikasi ?? 0);
            $persenAnggotaAktif = $totalMhsAll > 0 ? min(100, round((($totalAnggota ?? 0) / $totalMhsAll) * 100, 1)) : 100;
          @endphp

          <!-- Progress 1: Sirkulasi Koleksi -->
          <div class="system-progress-item">
            <div class="system-progress-label">
              <span>Buku Dalam Sirkulasi</span>
              <span class="text-warning fw-bold">{{ $persenDipinjam }}% ({{ $bukuDipinjam }} buku)</span>
            </div>
            <div class="progress progress-custom">
              <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $persenDipinjam }}%" aria-valuenow="{{ $persenDipinjam }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>

          <!-- Progress 2: Rasio Anggota Terverifikasi -->
          <div class="system-progress-item">
            <div class="system-progress-label">
              <span>Anggota Terverifikasi</span>
              <span class="text-success fw-bold">{{ $persenAnggotaAktif }}%</span>
            </div>
            <div class="progress progress-custom">
              <div class="progress-bar bg-success" role="progressbar" style="width: {{ $persenAnggotaAktif }}%" aria-valuenow="{{ $persenAnggotaAktif }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>

          <!-- Quick Summary List -->
          <div class="mt-4 pt-3 border-top">
            <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
              <span class="text-muted small"><i class="fas fa-book me-2 text-primary"></i> Total Judul Buku</span>
              <span class="fw-bold text-dark small">{{ number_format($totalJudulBuku ?? 0) }} Judul</span>
            </div>
            <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
              <span class="text-muted small"><i class="fas fa-layer-group me-2 text-success"></i> Stok Buku Fisik</span>
              <span class="fw-bold text-dark small">{{ number_format($totalBuku ?? 0) }} Eks</span>
            </div>
            <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
              <span class="text-muted small"><i class="fas fa-exchange-alt me-2 text-warning"></i> Total Transaksi</span>
              <span class="fw-bold text-dark small">{{ number_format($totalPeminjaman ?? 0) }} Kali</span>
            </div>
            <div class="d-flex align-items-center justify-content-between py-2">
              <span class="text-muted small"><i class="fas fa-shield-alt me-2 text-info"></i> Status Server</span>
              <span class="badge badge-success px-2 py-1" style="font-size: 10px;">
                <i class="fas fa-check-circle me-1"></i> AKTIF & NORMAL
              </span>
            </div>
          </div>

          <div class="mt-3">
            <a href="{{ url('/admin/laporan') }}" class="btn btn-outline-secondary btn-sm w-100 btn-round">
              <i class="fas fa-chart-pie me-1"></i> Buka Pusat Laporan Lengkap
            </a>
          </div>

        </div>
      </div>

    </div>

  </div>

</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    var ctx = document.getElementById('circulationChart');
    if (ctx) {
      var chartCtx = ctx.getContext('2d');

      var gradientPinjam = chartCtx.createLinearGradient(0, 0, 0, 240);
      gradientPinjam.addColorStop(0, 'rgba(37, 99, 235, 0.28)');
      gradientPinjam.addColorStop(1, 'rgba(37, 99, 235, 0.01)');

      var gradientKembali = chartCtx.createLinearGradient(0, 0, 0, 240);
      gradientKembali.addColorStop(0, 'rgba(16, 185, 129, 0.25)');
      gradientKembali.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

      var labels = {!! json_encode($chartLabels ?? ['H-6', 'H-5', 'H-4', 'H-3', 'H-2', 'Kemarin', 'Hari Ini']) !!};
      var dataPinjam = {!! json_encode($chartDataPinjam ?? [0, 0, 0, 0, 0, 0, 0]) !!};
      var dataKembali = {!! json_encode($chartDataKembali ?? [0, 0, 0, 0, 0, 0, 0]) !!};

      new Chart(chartCtx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [
            {
              label: 'Peminjaman Baru',
              data: dataPinjam,
              borderColor: '#2563eb',
              backgroundColor: gradientPinjam,
              borderWidth: 2.5,
              fill: true,
              tension: 0.35,
              pointBackgroundColor: '#2563eb',
              pointBorderColor: '#ffffff',
              pointBorderWidth: 2,
              pointRadius: 4,
              pointHoverRadius: 6
            },
            {
              label: 'Buku Dikembalikan',
              data: dataKembali,
              borderColor: '#10b981',
              backgroundColor: gradientKembali,
              borderWidth: 2.5,
              fill: true,
              lineTension: 0.35,
              pointBackgroundColor: '#10b981',
              pointBorderColor: '#ffffff',
              pointBorderWidth: 2,
              pointRadius: 4,
              pointHoverRadius: 6
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            position: 'top',
            labels: {
              usePointStyle: true,
              boxWidth: 8,
              padding: 16,
              fontFamily: "'Public Sans', sans-serif",
              fontSize: 12
            }
          },
          tooltips: {
            backgroundColor: '#0f172a',
            cornerRadius: 8,
            titleFontFamily: "'Public Sans', sans-serif",
            bodyFontFamily: "'Public Sans', sans-serif",
            xPadding: 12,
            yPadding: 10
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
                precision: 0,
                fontColor: '#94a3b8',
                fontSize: 11
              },
              gridLines: {
                color: '#f1f5f9',
                drawBorder: false
              }
            }],
            xAxes: [{
              ticks: {
                fontColor: '#94a3b8',
                fontSize: 11
              },
              gridLines: {
                display: false,
                drawBorder: false
              }
            }]
          }
        }
      });
    }
  });
</script>
@endsection
