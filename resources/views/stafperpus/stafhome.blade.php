@extends('stafperpus.layout')

@section('content')
<div class="page-inner">
  <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
      <h3 class="fw-bold mb-3">Dashboard Staf</h3>
      <h6 class="op-7 mb-2">Sistem Informasi Peminjaman Perpustakaan</h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
      <a href="{{ url('/stafperpus/kelolapeminjaman') }}" class="btn btn-primary btn-round">Kelola Peminjaman</a>
    </div>
  </div>

  <div class="row">
    <!-- Total Anggota -->
    <div class="col-sm-6 col-md-3">
      <div class="card card-stats card-round">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-icon">
              <div class="icon-big text-center icon-primary bubble-shadow-small">
                <i class="fas fa-users"></i>
              </div>
            </div>
            <div class="col col-stats ms-3 ms-sm-0">
              <div class="numbers">
                <p class="card-category">Total Anggota</p>
                <h4 class="card-title">{{ number_format($totalAnggota) }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Buku Dipinjam -->
    <div class="col-sm-6 col-md-3">
      <div class="card card-stats card-round">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-icon">
              <div class="icon-big text-center icon-info bubble-shadow-small">
                <i class="fas fa-user-check"></i>
              </div>
            </div>
            <div class="col col-stats ms-3 ms-sm-0">
              <div class="numbers">
                <p class="card-category">Buku Dipinjam</p>
                <h4 class="card-title">{{ number_format($bukuDipinjam) }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Total Buku -->
    <div class="col-sm-6 col-md-3">
      <div class="card card-stats card-round">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-icon">
              <div class="icon-big text-center icon-success bubble-shadow-small">
                <i class="fas fa-luggage-cart"></i>
              </div>
            </div>
            <div class="col col-stats ms-3 ms-sm-0">
              <div class="numbers">
                <p class="card-category">Total Buku</p>
                <h4 class="card-title">{{ number_format($totalBuku) }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Pengembalian Hari Ini -->
    <div class="col-sm-6 col-md-3">
      <div class="card card-stats card-round">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-icon">
              <div class="icon-big text-center icon-secondary bubble-shadow-small">
                <i class="far fa-check-circle"></i>
              </div>
            </div>
            <div class="col col-stats ms-3 ms-sm-0">
              <div class="numbers">
                <p class="card-category">Pengembalian Hari Ini</p>
                <h4 class="card-title">{{ number_format($pengembalianHariIni) }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Anggota Baru -->
    <div class="col-md-4">
      <div class="card card-round">
        <div class="card-body">
          <div class="card-head-row card-tools-still-right">
            <div class="card-title">Anggota Baru</div>
          </div>
          <div class="card-list py-4">
            @forelse($anggotaBaru as $anggota)
            <div class="item-list">
              <div class="avatar">
                <span class="avatar-title rounded-circle border border-white bg-primary">{{ strtoupper(substr($anggota->nama, 0, 1)) }}</span>
              </div>
              <div class="info-user ms-3">
                <div class="username">{{ $anggota->nama }}</div>
                <div class="status">{{ $anggota->prodi ?? 'Mahasiswa' }}</div>
              </div>
              <button class="btn btn-icon btn-link op-8 text-primary">
                <i class="far fa-envelope"></i>
              </button>
            </div>
            @empty
            <div class="text-center text-muted">Belum ada anggota.</div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
    
    <!-- Riwayat Peminjaman Terbaru -->
    <div class="col-md-8">
      <div class="card card-round">
        <div class="card-header">
          <div class="card-head-row card-tools-still-right">
            <div class="card-title">Riwayat Peminjaman Terbaru</div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead class="thead-light">
                <tr>
                  <th scope="col">ID Peminjaman</th>
                  <th scope="col" class="text-end">Tanggal Peminjaman</th>
                  <th scope="col" class="text-end">Tenggat Waktu</th>
                  <th scope="col" class="text-end">Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($riwayatPeminjaman as $riwayat)
                <tr>
                  <th scope="row">
                    <button class="btn btn-icon btn-round btn-{{ $riwayat->status === 'Selesai' ? 'success' : 'warning' }} btn-sm me-2">
                      <i class="fa fa-{{ $riwayat->status === 'Selesai' ? 'check' : 'clock' }}"></i>
                    </button>
                    Buku Pinjaman #{{ $riwayat->id }}
                  </th>
                  <td class="text-end">{{ $riwayat->tanggal_pinjam->format('M d, Y, g.ia') }}</td>
                  <td class="text-end">{{ $riwayat->tenggat_waktu->format('d M Y') }}</td>
                  <td class="text-end">
                    @if($riwayat->status === 'Selesai')
                      <span class="badge badge-success">Dikembalikan</span>
                    @else
                      <span class="badge badge-warning">Dipinjam</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center py-4">Belum ada riwayat peminjaman.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
