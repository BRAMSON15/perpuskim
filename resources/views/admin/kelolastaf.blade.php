@extends('admin.layout')

@section('content')
<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Kelola Akun Staf</h4>
  </div>
  <div class="row">
    <div class="col-md-12">
        
      @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif

      @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Daftar Staf</h4>
          <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addStafModal">
            <i class="fa fa-plus"></i> Tambah Staf
          </button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Username</th>
                  <th>Tanggal Terdaftar</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($staf as $index => $item)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $item->nama }}</td>
                  <td>{{ $item->username }}</td>
                  <td>{{ $item->created_at->format('d M Y') }}</td>
                  <td>
                    <!-- Edit Button -->
                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStafModal{{ $item->id }}">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <!-- Delete Button -->
                    <form action="{{ route('kelolastaf.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus staf ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </form>
                  </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editStafModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <form action="{{ route('kelolastaf.update', $item->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Edit Akun Staf</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ $item->nama }}" required>
                          </div>
                          <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="{{ $item->username }}" required>
                          </div>
                          <div class="form-group">
                            <label>Password Baru <small class="text-muted">(kosongkan jika tidak ingin diubah)</small></label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada akun staf terdaftar.</td>
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

<!-- Add Modal -->
<div class="modal fade" id="addStafModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('kelolastaf.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Akun Staf Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Tambah Staf</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
