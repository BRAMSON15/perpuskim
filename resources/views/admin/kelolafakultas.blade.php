@extends('admin.layout')

@section('title', 'Kelola Fakultas - PERPUSKIM')

@section('content')
<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Kelola Fakultas</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ route('admin.dashboard') }}">
          <i class="icon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="icon-arrow-right"></i>
      </li>
      <li class="nav-item">
        <a href="#">Pengaturan</a>
      </li>
      <li class="separator">
        <i class="icon-arrow-right"></i>
      </li>
      <li class="nav-item">
        <a href="#">Fakultas</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <i class="fas fa-building me-2"></i>Daftar Fakultas
          </div>
          <div class="card-tools">
            <a href="{{ route('admin.fakultas.create') }}" class="btn btn-primary btn-sm">
              <i class="icon-plus"></i> Tambah Fakultas
            </a>
          </div>
        </div>
        
        <div class="card-body">
          @if($errors->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <strong>Error!</strong> {{ $errors->first('error') }}
            </div>
          @endif

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <strong>Sukses!</strong> {{ session('success') }}
            </div>
          @endif

          <!-- Search Bar -->
          <div class="mb-3">
            <form method="GET" class="d-flex gap-2">
              <input type="text" name="search" class="form-control" placeholder="Cari Fakultas..." value="{{ request('search') }}">
              <button type="submit" class="btn btn-outline-secondary">
                <i class="fas fa-search"></i> Cari
              </button>
            </form>
          </div>

          <!-- Table -->
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="table-dark">
                <tr>
                  <th style="width: 5%">#</th>
                  <th>Nama Fakultas</th>
                  <th>Kode</th>
                  <th>Kepala Fakultas</th>
                  <th>Program Studi</th>
                  <th>Status</th>
                  <th style="width: 20%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($fakultas as $item)
                  <tr>
                    <td><strong>{{ $loop->iteration }}</strong></td>
                    <td>
                      <strong>{{ $item->nama_fakultas }}</strong>
                      @if($item->deskripsi)
                        <br><small class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>
                      @endif
                    </td>
                    <td>
                      <span class="badge bg-info">{{ $item->kode_fakultas }}</span>
                    </td>
                    <td>
                      {{ $item->kepala_fakultas ?? '-' }}
                      @if($item->kontak)
                        <br><small class="text-muted">{{ $item->kontak }}</small>
                      @endif
                    </td>
                    <td>
                      <span class="badge bg-secondary">
                        {{ $item->countAllProgramStudi() }} Program
                      </span>
                      @if($item->countActiveProgramStudi() > 0)
                        <br><small class="text-success">{{ $item->countActiveProgramStudi() }} Aktif</small>
                      @endif
                    </td>
                    <td>
                      @if($item->is_active)
                        <span class="badge bg-success">Aktif</span>
                      @else
                        <span class="badge bg-danger">Nonaktif</span>
                      @endif
                    </td>
                    <td>
                      <a href="{{ route('admin.fakultas.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                      <form method="POST" action="{{ route('admin.fakultas.destroy', $item->id) }}" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                          <i class="fas fa-trash"></i> Hapus
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center py-4">
                      <i class="fas fa-inbox fa-3x mb-3 text-secondary opacity-50"></i>
                      <p class="mb-0 fw-semibold">Belum ada data Fakultas.</p>
                    </td>
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

<style>
  .table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
  }
</style>
@endsection
