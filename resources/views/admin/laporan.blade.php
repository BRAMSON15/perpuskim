@extends('admin.layout')

@section('content')
<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Laporan Peminjaman Buku</h4>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Filter Laporan</h4>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.laporan') }}" method="GET" class="row align-items-end mb-4">
            <div class="col-md-3">
              <label>Berdasarkan Tanggal</label>
              <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-3">
              <label>Berdasarkan Bulan</label>
              <select name="bulan" class="form-control">
                <option value="">Semua Bulan</option>
                @for($m = 1; $m <= 12; $m++)
                  <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ request('bulan') == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                    {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                  </option>
                @endfor
              </select>
            </div>
            <div class="col-md-3">
              <label>Berdasarkan Tahun</label>
              <select name="tahun" class="form-control">
                <option value="">Semua Tahun</option>
                @php $currentYear = date('Y'); @endphp
                @for($y = $currentYear; $y >= 2020; $y--)
                  <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
              </select>
            </div>
            <div class="col-md-3">
              <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
              <a href="{{ route('admin.laporan') }}" class="btn btn-default">Reset</a>
            </div>
          </form>

          <hr>
          
          <div class="mb-3">
            <a href="{{ route('admin.laporan.pdf', request()->all()) }}" class="btn btn-danger btn-sm" target="_blank">
                <i class="fa fa-file-pdf"></i> Cetak PDF
            </a>
            <a href="{{ route('admin.laporan.excel', request()->all()) }}" class="btn btn-success btn-sm">
                <i class="fa fa-file-excel"></i> Export Excel (CSV)
            </a>
          </div>

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
                  <td>{{ $item->buku->judul ?? 'N/A' }}</td>
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
                        <span class="badge badge-success">Selesai</span>
                    @else
                        <span class="badge badge-warning">Dipinjam</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Data tidak ditemukan.</td>
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
