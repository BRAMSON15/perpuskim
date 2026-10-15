@extends('admin.layout')

@section('content')
<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Pantau Aktivitas Peminjaman</h4>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Riwayat Peminjaman & Pengembalian Mahasiswa</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Mahasiswa</th>
                  <th>Judul Buku</th>
                  <th>Tanggal Pinjam</th>
                  <th>Tanggal Kembali</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($peminjaman as $index => $item)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $item->mahasiswa->nama ?? 'N/A' }}</td>
                  <td>{{ $item->buku->judul ?? 'Buku Dihapus' }}</td>
                  <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                  <td>
                    @if($item->tanggal_kembali)
                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                    @else
                        -
                    @endif
                  </td>
                  <td>
                    @if($item->status == 'Selesai')
                        <span class="badge badge-success">Dikembalikan</span>
                    @else
                        <span class="badge badge-warning">Dipinjam</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada aktivitas peminjaman.</td>
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
