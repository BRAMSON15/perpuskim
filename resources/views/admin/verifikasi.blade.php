@extends('admin.layout')

@section('content')
<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Verifikasi Anggota Baru</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ url('/admin/dashboard') }}">
          <i class="icon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="icon-arrow-right"></i>
      </li>
      <li class="nav-item">
        <a href="#">Verifikasi Anggota</a>
      </li>
    </ul>
  </div>

  @if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Daftar Pendaftar (Menunggu Verifikasi)</div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-head-bg-primary mt-4">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">NPM</th>
                  <th scope="col">Nama Lengkap</th>
                  <th scope="col">Fakultas</th>
                  <th scope="col">Email</th>
                  <th scope="col">Foto Kartu</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pendingMahasiswa as $idx => $mhs)
                <tr>
                  <td>{{ $idx + 1 }}</td>
                  <td>{{ $mhs->npm }}</td>
                  <td>{{ $mhs->nama }}</td>
                  <td>{{ $mhs->fakultas }}</td>
                  <td>{{ $mhs->email }}</td>
                  <td>
                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalKartu{{ $mhs->npm }}">
                      Lihat Kartu
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="modalKartu{{ $mhs->npm }}" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Kartu Identitas - {{ $mhs->nama }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body text-center">
                            <img src="{{ asset('storage/' . $mhs->foto_kartu) }}" alt="Foto Kartu" style="max-width: 100%; height: auto;">
                            <hr>
                            <div class="text-start">
                              <p><strong>NPM:</strong> {{ $mhs->npm }}</p>
                              <p><strong>Nama:</strong> {{ $mhs->nama }}</p>
                              <p><strong>Fakultas:</strong> {{ $mhs->fakultas }}</p>
                              <p><strong>Alamat:</strong> {{ $mhs->alamat }}</p>
                              <p><strong>No HP:</strong> {{ $mhs->no_telp }}</p>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex gap-2" style="gap: 5px;">
                      <form action="{{ route('admin.verifikasi.approve', $mhs->npm) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin menyetujui akun ini?')">Setujui</button>
                      </form>
                      <form action="{{ route('admin.verifikasi.reject', $mhs->npm) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menolak akun ini?')">Tolak</button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center">Tidak ada pendaftar yang menunggu verifikasi saat ini.</td>
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
