<?php

namespace App\Services;

use App\Models\Peminjaman;
use App\Models\Buku;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PeminjamanService
{
    /**
     * Create a new peminjaman (book borrowing)
     * 
     * @param string $mahasiswaNpm
     * @param int $bukuId
     * @return Peminjaman
     * @throws \Exception
     */
    public function createPeminjaman(string $mahasiswaNpm, int $bukuId): Peminjaman
    {
        // Validate buku exists and has stock
        $buku = Buku::findOrFail($bukuId);
        
        if ($buku->stok <= 0) {
            throw new \Exception('Stok buku habis.');
        }

        // Check if mahasiswa already has active borrowing for this book
        if ($this->hasDuplicateActiveBorrowing($mahasiswaNpm, $bukuId)) {
            throw new \Exception('Anda masih meminjam buku ini dan belum mengembalikannya.');
        }

        // Begin transaction for data consistency
        \DB::beginTransaction();
        
        try {
            // Create peminjaman record
            $peminjaman = Peminjaman::create([
                'mahasiswa_npm' => $mahasiswaNpm,
                'buku_id' => $bukuId,
                'tanggal_pinjam' => Carbon::today(),
                'tenggat_waktu' => Carbon::today()->addDays(7),
                'status' => 'Dipinjam',
            ]);

            // Decrement book stock
            $buku->decrement('stok');

            \DB::commit();
            
            return $peminjaman;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * Complete a peminjaman (return the book)
     * 
     * @param int $peminjamanId
     * @return Peminjaman
     * @throws \Exception
     */
    public function completePeminjaman(int $peminjamanId): Peminjaman
    {
        $peminjaman = Peminjaman::findOrFail($peminjamanId);

        if ($peminjaman->status !== 'Dipinjam') {
            throw new \Exception('Peminjaman ini sudah berstatus Selesai.');
        }

        \DB::beginTransaction();
        
        try {
            // Update peminjaman status and return date
            $peminjaman->update([
                'status' => 'Selesai',
                'tanggal_kembali' => Carbon::now(),
            ]);

            // Increment book stock
            if ($peminjaman->buku) {
                $peminjaman->buku->increment('stok');
            }

            \DB::commit();
            
            return $peminjaman;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * Check if mahasiswa has duplicate active borrowing for the same book
     * 
     * @param string $mahasiswaNpm
     * @param int $bukuId
     * @return bool
     */
    public function hasDuplicateActiveBorrowing(string $mahasiswaNpm, int $bukuId): bool
    {
        return Peminjaman::where('mahasiswa_npm', $mahasiswaNpm)
            ->where('buku_id', $bukuId)
            ->where('status', 'Dipinjam')
            ->exists();
    }

    /**
     * Get all active peminjaman (borrowed books)
     * 
     * @param string|null $mahasiswaNpm
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActivePeminjaman(?string $mahasiswaNpm = null)
    {
        $query = Peminjaman::with(['mahasiswa', 'buku'])
            ->where('status', 'Dipinjam');

        if ($mahasiswaNpm) {
            $query->where('mahasiswa_npm', $mahasiswaNpm);
        }

        return $query->latest()->get();
    }

    /**
     * Get all peminjaman history
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPeminjamanHistory()
    {
        return Peminjaman::with(['mahasiswa', 'buku'])->latest()->get();
    }

    /**
     * Get peminjaman by status
     * 
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPeminjamanByStatus(string $status)
    {
        return Peminjaman::with(['mahasiswa', 'buku'])
            ->where('status', $status)
            ->latest()
            ->get();
    }

    /**
     * Get peminjaman untuk filter/export (dengan filtering optional)
     * 
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFilteredPeminjaman(array $filters = [])
    {
        $query = Peminjaman::with(['mahasiswa', 'buku']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['from_date'])) {
            $query->whereDate('tanggal_pinjam', '>=', $filters['from_date']);
        }

        if (isset($filters['to_date'])) {
            $query->whereDate('tanggal_pinjam', '<=', $filters['to_date']);
        }

        if (isset($filters['mahasiswa_npm'])) {
            $query->where('mahasiswa_npm', $filters['mahasiswa_npm']);
        }

        if (isset($filters['buku_id'])) {
            $query->where('buku_id', $filters['buku_id']);
        }

        return $query->latest()->get();
    }

    /**
     * Get statistics for dashboard
     * 
     * @return array
     */
    public function getStatistics(): array
    {
        return [
            'total_peminjaman' => Peminjaman::count(),
            'active_peminjaman' => Peminjaman::where('status', 'Dipinjam')->count(),
            'completed_peminjaman' => Peminjaman::where('status', 'Selesai')->count(),
            'today_returns' => Peminjaman::whereDate('tanggal_kembali', Carbon::today())
                ->where('status', 'Selesai')
                ->count(),
        ];
    }

    /**
     * Get overdue peminjaman (past due date but not returned)
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOverduePeminjaman()
    {
        return Peminjaman::with(['mahasiswa', 'buku'])
            ->where('status', 'Dipinjam')
            ->where('tenggat_waktu', '<', Carbon::now())
            ->latest()
            ->get();
    }

    /**
     * Get peminjaman due today
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPeminjamanDueToday()
    {
        return Peminjaman::with(['mahasiswa', 'buku'])
            ->where('status', 'Dipinjam')
            ->whereDate('tenggat_waktu', Carbon::today())
            ->get();
    }
}
