@extends('stafperpus.layout')

@section('content')
<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Kelola Aktivitas Peminjaman</h4>
  </div>
  <div class="row">
    <div class="col-md-12">
        
      @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif

      @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif

      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Daftar Peminjaman Aktif</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID Peminjaman</th>
                  <th>Nama Peminjam</th>
                  <th>NPM</th>
                  <th>Buku</th>
                  <th>Fakultas Buku</th>
                  <th>Tanggal Pinjam</th>
                  <th>Tenggat Waktu</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($peminjaman as $item)
                <tr>
                  <td>#{{ $item->id }}</td>
                  <td>{{ $item->mahasiswa->nama ?? 'Tidak Diketahui' }}</td>
                  <td>{{ $item->mahasiswa_npm }}</td>
                  <td>{{ $item->buku->judul ?? 'Tidak Diketahui' }}</td>
                  <td>{{ $item->buku->fakultas ?? '-' }}</td>
                  <td>{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                  <td>
                    @php
                        $isLate = \Carbon\Carbon::now()->startOfDay()->gt($item->tenggat_waktu);
                    @endphp
                    <span class="{{ $isLate ? 'text-danger fw-bold' : '' }}">
                        {{ $item->tenggat_waktu->format('d M Y') }}
                    </span>
                  </td>
                  <td><span class="badge badge-warning">{{ $item->status }}</span></td>
                  <td>
                    <form action="{{ route('staf.peminjaman.selesai', $item->id) }}" method="POST" onsubmit="return confirm('Tandai peminjaman ini sebagai selesai (buku dikembalikan)?');">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fa fa-check"></i> Selesaikan
                        </button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada peminjaman aktif saat ini.</td>
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
