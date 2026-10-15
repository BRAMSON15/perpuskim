@extends('admin.layout')

@section('title', (isset($programStudi) ? 'Edit' : 'Tambah') . ' Program Studi - PERPUSKIM')

@section('content')
<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">{{ isset($programStudi) ? 'Edit Program Studi' : 'Tambah Program Studi Baru' }}</h4>
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
        <a href="{{ route('admin.program-studi.index') }}">Program Studi</a>
      </li>
      <li class="separator">
        <i class="icon-arrow-right"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ isset($programStudi) ? 'Edit' : 'Tambah' }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <i class="fas fa-graduation-cap me-2"></i>{{ isset($programStudi) ? 'Edit Program Studi' : 'Form Tambah Program Studi' }}
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

          <form method="POST" action="{{ isset($programStudi) ? route('admin.program-studi.update', $programStudi->id) : route('admin.program-studi.store') }}">
            @csrf
            @if(isset($programStudi))
              @method('PUT')
            @endif

            <div class="mb-3">
              <label for="fakultas_id" class="form-label">Fakultas <span class="text-danger">*</span></label>
              <select class="form-select @error('fakultas_id') is-invalid @enderror" 
                      id="fakultas_id" name="fakultas_id" required>
                <option value="">-- Pilih Fakultas --</option>
                @foreach($fakultas as $fak)
                  <option value="{{ $fak->id }}" {{ old('fakultas_id', $programStudi->fakultas_id ?? '') == $fak->id ? 'selected' : '' }}>
                    {{ $fak->nama_fakultas }}
                  </option>
                @endforeach
              </select>
              @error('fakultas_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="nama_program_studi" class="form-label">Nama Program Studi <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nama_program_studi') is-invalid @enderror" 
                     id="nama_program_studi" name="nama_program_studi" 
                     value="{{ old('nama_program_studi', $programStudi->nama_program_studi ?? '') }}" 
                     placeholder="Contoh: Teknik Informatika"
                     required>
              @error('nama_program_studi')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="kode_program_studi" class="form-label">Kode Program Studi <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('kode_program_studi') is-invalid @enderror" 
                     id="kode_program_studi" name="kode_program_studi" 
                     value="{{ old('kode_program_studi', $programStudi->kode_program_studi ?? '') }}" 
                     placeholder="Contoh: TIF"
                     required>
              <small class="text-muted">Gunakan format singkat, misal TIF, TIF, SE, dll</small>
              @error('kode_program_studi')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="jenjang" class="form-label">Jenjang <span class="text-danger">*</span></label>
                <select class="form-select @error('jenjang') is-invalid @enderror" 
                        id="jenjang" name="jenjang" required>
                  <option value="">-- Pilih Jenjang --</option>
                  @foreach($jenjang as $j)
                    <option value="{{ $j }}" {{ old('jenjang', $programStudi->jenjang ?? '') == $j ? 'selected' : '' }}>
                      {{ $j }}
                    </option>
                  @endforeach
                </select>
                @error('jenjang')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label for="ketua_program" class="form-label">Ketua Program</label>
                <input type="text" class="form-control @error('ketua_program') is-invalid @enderror" 
                       id="ketua_program" name="ketua_program" 
                       value="{{ old('ketua_program', $programStudi->ketua_program ?? '') }}" 
                       placeholder="Nama Ketua Program">
                @error('ketua_program')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi</label>
              <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                        id="deskripsi" name="deskripsi" 
                        rows="4" 
                        placeholder="Deskripsi singkat tentang program studi...">{{ old('deskripsi', $programStudi->deskripsi ?? '') }}</textarea>
              @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            @if(isset($programStudi))
              <div class="mb-3">
                <label for="is_active" class="form-check-label">
                  <input type="checkbox" id="is_active" name="is_active" class="form-check-input" 
                         value="1" {{ old('is_active', $programStudi->is_active) ? 'checked' : '' }}>
                  Aktif
                </label>
                <small class="text-muted d-block">Nonaktifkan jika program studi tidak digunakan</small>
              </div>
            @endif

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>{{ isset($programStudi) ? 'Perbarui' : 'Simpan' }}
              </button>
              <a href="{{ route('admin.program-studi.index') }}" class="btn btn-secondary">
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
            <li>Pilih Fakultas terlebih dahulu</li>
            <li>Nama Program Studi harus unik</li>
            <li>Kode singkat memudahkan identifikasi</li>
            <li>Jenjang menunjukkan tingkat pendidikan</li>
            <li>Lengkapi data Ketua Program</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
