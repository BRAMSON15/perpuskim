@extends('stafperpus.layout')

@section('content')
<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Kelola Koleksi Buku</h4>
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
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Daftar Buku</h4>
          <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addBukuModal">
            <i class="fa fa-plus"></i>
            Tambah Buku Baru
          </button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Gambar</th>
                  <th>Judul Buku</th>
                  <th>Pengarang</th>
                  <th>Kategori</th>
                  <th>Fakultas</th>
                  <th>Stok</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($buku as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                      @if($item->gambar)
                          <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" style="width: 50px; height: 70px; object-fit: cover;">
                      @else
                          <span class="text-muted">Tidak ada</span>
                      @endif
                  </td>
                  <td>{{ $item->judul }}</td>
                  <td>{{ $item->pengarang }}</td>
                  <td>{{ $item->kategori }}</td>
                  <td>{{ $item->fakultas ?? '-' }}</td>
                  <td>{{ $item->stok }}</td>
                  <td>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editBukuModal{{ $item->id }}">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    
                    <form action="{{ route('kelolabuku.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                    </form>
                  </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editBukuModal{{ $item->id }}" tabindex="-1" aria-labelledby="editBukuModalLabel{{ $item->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="editBukuModalLabel{{ $item->id }}">Edit Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="{{ route('kelolabuku.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Judul Buku</label>
                                <input type="text" name="judul" class="form-control" value="{{ $item->judul }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Pengarang</label>
                                <input type="text" name="pengarang" class="form-control" value="{{ $item->pengarang }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Penerbit</label>
                                <input type="text" name="penerbit" class="form-control" value="{{ $item->penerbit }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>ISBN</label>
                                <input type="text" name="isbn" class="form-control" value="{{ $item->isbn }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" class="form-control" value="{{ $item->tahun_terbit }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Kategori</label>
                                <input type="text" name="kategori" class="form-control" value="{{ $item->kategori }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Fakultas</label>
                                <input type="text" name="fakultas" class="form-control" value="{{ $item->fakultas }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Stok</label>
                                <input type="number" name="stok" class="form-control" value="{{ $item->stok }}" required min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Gambar Cover (Biarkan kosong jika tidak diubah)</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3">{{ $item->deskripsi }}</textarea>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End Modal Edit -->
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data buku</td>
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

<!-- Modal Tambah -->
<div class="modal fade" id="addBukuModal" tabindex="-1" aria-labelledby="addBukuModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBukuModalLabel">Tambah Buku Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('kelolabuku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
                <label>Judul Buku <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Pengarang <span class="text-danger">*</span></label>
                <input type="text" name="pengarang" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Penerbit</label>
                <input type="text" name="penerbit" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>ISBN</label>
                <input type="text" name="isbn" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Tahun Terbit</label>
                <input type="number" name="tahun_terbit" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Kategori <span class="text-danger">*</span></label>
                <input type="text" name="kategori" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Fakultas</label>
                <input type="text" name="fakultas" class="form-control" placeholder="Contoh: Teknik, Ekonomi">
            </div>
            <div class="col-md-6 mb-3">
                <label>Stok <span class="text-danger">*</span></label>
                <input type="number" name="stok" class="form-control" required min="0">
            </div>
            <div class="col-md-6 mb-3">
                <label>Gambar Cover</label>
                <input type="file" name="gambar" class="form-control" accept="image/*">
            </div>
            <div class="col-md-12 mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Buku</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal Tambah -->
@endsection
