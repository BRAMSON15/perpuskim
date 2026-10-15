@extends('admin.layout')

@section('title', (isset($fakultas) ? 'Edit' : 'Tambah') . ' Fakultas - PERPUSKIM')

@section('content')
<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">{{ isset($fakultas) ? 'Edit Fakultas' : 'Tambah Fakultas Baru' }}</h4>
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
        <a href="{{ route('admin.fakultas.index') }}">Fakultas</a>
      </li>
      <li class="separator">
        <i class="icon-arrow-right"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ isset($fakultas) ? 'Edit' : 'Tambah' }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <i class="fas fa-building me-2"></i>{{ isset($fakultas) ? 'Edit Fakultas' : 'Form Tambah Fakultas' }}
          </div>
        </div>

        <div class="card-body">
          @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <strong>Terjadi Kesalahan!</strong>
              <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ isset($fakultas) ? route('admin.fakultas.update', $fakultas->id) : route('admin.fakultas.store') }}">
            @csrf
            @if(isset($fakultas))
              @method('PUT')
            @endif

            <div class="mb-3">
              <label for="nama_fakultas" class="form-label">Nama Fakultas <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nama_fakultas') is-invalid @enderror" 
                     id="nama_fakultas" name="nama_fakultas" 
                     value="{{ old('nama_fakultas', $fakultas->nama_fakultas ?? '') }}" 
                     placeholder="Contoh: Fakultas Teknologi Informasi"
                     required>
              @error('nama_fakultas')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="kode_fakultas" class="form-label">Kode Fakultas <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('kode_fakultas') is-invalid @enderror" 
                     id="kode_fakultas" name="kode_fakultas" 
                     value="{{ old('kode_fakultas', $fakultas->kode_fakultas ?? '') }}" 
                     placeholder="Contoh: FTI"
                     required>
              <small class="text-muted">Gunakan format singkat, misal FTI, FMIPA, dll</small>
              @error('kode_fakultas')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="kepala_fakultas" class="form-label">Kepala Fakultas</label>
              <input type="text" class="form-control @error('kepala_fakultas') is-invalid @enderror" 
                     id="kepala_fakultas" name="kepala_fakultas" 
                     value="{{ old('kepala_fakultas', $fakultas->kepala_fakultas ?? '') }}" 
                     placeholder="Nama Kepala Fakultas">
              @error('kepala_fakultas')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="kontak" class="form-label">Kontak</label>
              <input type="text" class="form-control @error('kontak') is-invalid @enderror" 
                     id="kontak" name="kontak" 
                     value="{{ old('kontak', $fakultas->kontak ?? '') }}" 
                     placeholder="Email atau nomor telepon">
              @error('kontak')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi</label>
              <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                        id="deskripsi" name="deskripsi" 
                        rows="4" 
                        placeholder="Deskripsi singkat tentang fakultas...">{{ old('deskripsi', $fakultas->deskripsi ?? '') }}</textarea>
              @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            @if(isset($fakultas))
              <div class="mb-3">
                <label for="is_active" class="form-check-label">
                  <input type="checkbox" id="is_active" name="is_active" class="form-check-input" 
                         value="1" {{ old('is_active', $fakultas->is_active) ? 'checked' : '' }}>
                  Aktif
                </label>
                <small class="text-muted d-block">Nonaktifkan jika fakultas tidak digunakan</small>
              </div>
            @endif

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>{{ isset($fakultas) ? 'Perbarui' : 'Simpan' }}
              </button>
              <a href="{{ route('admin.fakultas.index') }}" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Batal
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-header">
          <h5 class="card-title">
            <i class="fas fa-info-circle me-2"></i>Informasi
          </h5>
        </div>
        <div class="card-body">
          <p><strong>Tips:</strong></p>
          <ul class="ps-3 mb-0">
            <li>Nama Fakultas harus unik</li>
            <li>Kode Fakultas digunakan sebagai identitas singkat</li>
            <li>Lengkapi data Kepala Fakultas untuk kelengkapan data</li>
            <li>Gunakan kontak yang valid dan dapat dihubungi</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
