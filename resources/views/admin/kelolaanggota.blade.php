@extends('admin.layout')

@section('content')
<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Kelola Anggota Mahasiswa</h4>
  </div>
  <div class="row">
    <div class="col-md-12">
      
      @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif

      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Daftar Anggota Terverifikasi</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>NPM</th>
                  <th>Nama Mahasiswa</th>
                  <th>Prodi / Fakultas</th>
                  <th>No. Telepon</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($anggota as $item)
                <tr>
                  <td>{{ $item->npm }}</td>
                  <td>{{ $item->nama }}</td>
                  <td>{{ $item->prodi }}<br><small class="text-muted">{{ $item->fakultas }}</small></td>
                  <td>{{ $item->no_telp ?? '-' }}</td>
                  <td>
                      @if($item->status == 'active')
                          <span class="badge badge-success">Aktif</span>
                      @else
                          <span class="badge badge-danger">Nonaktif</span>
                      @endif
                  </td>
                  <td>
                    <form action="{{ route('admin.anggota.toggle', $item->npm) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin {{ $item->status == 'active' ? 'menonaktifkan' : 'mengaktifkan kembali' }} akun mahasiswa ini?');">
                        @csrf
                        @if($item->status == 'active')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Nonaktifkan</button>
                        @else
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Aktifkan</button>
                        @endif
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada anggota terverifikasi.</td>
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
