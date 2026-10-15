<?php

namespace App\Services;

use App\Models\Buku;
use Illuminate\Pagination\Paginator;

class BukuSearchService
{
    private const DEFAULT_PAGE_SIZE = 6;

    /**
     * Search and filter books with pagination
     * 
     * @param array $filters
     * @param int $perPage
     * @return mixed
     */
    public function search(array $filters = [], int $perPage = self::DEFAULT_PAGE_SIZE)
    {
        $query = Buku::query();

        // Apply search filter
        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%");
            });
        }

        // Apply faculty/kategori filter
        if (isset($filters['fakultas']) && !empty($filters['fakultas'])) {
            $query->where('fakultas', $filters['fakultas']);
        }

        // Apply stock filter (optional - get only books with stock)
        if (isset($filters['in_stock_only']) && $filters['in_stock_only']) {
            $query->where('stok', '>', 0);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Get all available fakultas/categories
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFakultasList()
    {
        return Buku::distinct()
            ->pluck('fakultas')
            ->filter(function($value) {
                return !is_null($value) && $value !== '';
            })
            ->sort()
            ->values();
    }

    /**
     * Get books by specific fakultas
     * 
     * @param string $fakultas
     * @param int $perPage
     * @return mixed
     */
    public function getByFakultas(string $fakultas, int $perPage = self::DEFAULT_PAGE_SIZE)
    {
        return Buku::where('fakultas', $fakultas)
            ->paginate($perPage);
    }

    /**
     * Get books with low stock
     * 
     * @param int $threshold
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLowStockBooks(int $threshold = 5)
    {
        return Buku::where('stok', '<=', $threshold)
            ->orderBy('stok', 'asc')
            ->get();
    }

    /**
     * Get books out of stock
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOutOfStockBooks()
    {
        return Buku::where('stok', '<=', 0)->get();
    }

    /**
     * Get available books (in stock)
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableBooks(int $limit = null)
    {
        $query = Buku::where('stok', '>', 0);
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->get();
    }

    /**
     * Get popular books (most borrowed)
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPopularBooks(int $limit = 10)
    {
        return Buku::withCount('peminjaman')
            ->orderBy('peminjaman_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get book detail with related data
     * 
     * @param int $bukuId
     * @return Buku
     */
    public function getDetail(int $bukuId)
    {
        return Buku::with('peminjaman')->findOrFail($bukuId);
    }

    /**
     * Check if book is available for borrowing
     * 
     * @param int $bukuId
     * @return bool
     */
    public function isAvailable(int $bukuId): bool
    {
        $buku = Buku::find($bukuId);
        return $buku && $buku->stok > 0;
    }
}
