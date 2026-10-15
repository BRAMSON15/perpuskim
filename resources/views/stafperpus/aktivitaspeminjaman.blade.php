@extends('stafperpus.layout')

@section('content')
<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Riwayat Aktivitas Peminjaman</h4>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Semua Data Peminjaman</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama Peminjam</th>
                  <th>NPM</th>
                  <th>Buku</th>
                  <th>Fakultas Buku</th>
                  <th>Tgl Pinjam</th>
                  <th>Tenggat Waktu</th>
                  <th>Tgl Kembali</th>
                  <th>Status</th>
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
                  <td>{{ $item->tenggat_waktu->format('d M Y') }}</td>
                  <td>
                      @if($item->tanggal_kembali)
                        {{ $item->tanggal_kembali->format('d M Y') }}
                      @else
                        -
                      @endif
                  </td>
                  <td>
                      @if($item->status === 'Dipinjam')
                        <span class="badge badge-warning">Dipinjam</span>
                      @else
                        <span class="badge badge-success">Selesai</span>
                      @endif
                  </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada riwayat peminjaman.</td>
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
