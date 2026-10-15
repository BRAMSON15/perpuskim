<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .text-center {
            text-align: center;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Aktivitas Peminjaman Buku</h2>
        <p>Perpustakaan - Dicetak pada: {{ date('d M Y H:i') }}</p>
    </div>

    <table>
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
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->mahasiswa->nama ?? 'N/A' }}</td>
                <td>{{ $item->buku->judul ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</td>
                <td>
                    {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') : '-' }}
                </td>
                <td>{{ $item->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
