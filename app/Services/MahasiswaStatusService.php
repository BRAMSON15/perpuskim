<?php

namespace App\Services;

use App\Models\Mahasiswa;

class MahasiswaStatusService
{
    /**
     * Approve a pending mahasiswa registration
     * 
     * @param string $npm
     * @return Mahasiswa
     * @throws \Exception
     */
    public function approve(string $npm): Mahasiswa
    {
        $mahasiswa = Mahasiswa::where('npm', $npm)->firstOrFail();

        if ($mahasiswa->status !== 'pending') {
            throw new \Exception('Status mahasiswa tidak pending.');
        }

        $mahasiswa->update(['status' => 'active']);
        
        return $mahasiswa;
    }

    /**
     * Reject a pending mahasiswa registration
     * 
     * @param string $npm
     * @return Mahasiswa
     * @throws \Exception
     */
    public function reject(string $npm): Mahasiswa
    {
        $mahasiswa = Mahasiswa::where('npm', $npm)->firstOrFail();

        if ($mahasiswa->status !== 'pending') {
            throw new \Exception('Status mahasiswa tidak pending.');
        }

        $mahasiswa->update(['status' => 'rejected']);
        
        return $mahasiswa;
    }

    /**
     * Deactivate mahasiswa
     * 
     * @param string $npm
     * @return Mahasiswa
     */
    public function deactivate(string $npm): Mahasiswa
    {
        $mahasiswa = Mahasiswa::where('npm', $npm)->firstOrFail();
        $mahasiswa->update(['status' => 'nonaktif']);
        
        return $mahasiswa;
    }

    /**
     * Activate mahasiswa
     * 
     * @param string $npm
     * @return Mahasiswa
     */
    public function activate(string $npm): Mahasiswa
    {
        $mahasiswa = Mahasiswa::where('npm', $npm)->firstOrFail();
        $mahasiswa->update(['status' => 'active']);
        
        return $mahasiswa;
    }

    /**
     * Toggle status between active and nonaktif
     * 
     * @param string $npm
     * @return Mahasiswa
     */
    public function toggleStatus(string $npm): Mahasiswa
    {
        $mahasiswa = Mahasiswa::where('npm', $npm)->firstOrFail();

        $newStatus = $mahasiswa->status === 'active' ? 'nonaktif' : 'active';
        $mahasiswa->update(['status' => $newStatus]);
        
        return $mahasiswa;
    }

    /**
     * Update status to specific value
     * 
     * @param string $npm
     * @param string $status
     * @return Mahasiswa
     * @throws \Exception
     */
    public function updateStatus(string $npm, string $status): Mahasiswa
    {
        $validStatuses = ['active', 'pending', 'rejected', 'nonaktif'];

        if (!in_array($status, $validStatuses)) {
            throw new \Exception("Status '{$status}' tidak valid. Status yang diizinkan: " . implode(', ', $validStatuses));
        }

        $mahasiswa = Mahasiswa::where('npm', $npm)->firstOrFail();
        $mahasiswa->update(['status' => $status]);
        
        return $mahasiswa;
    }

    /**
     * Get all mahasiswa with specific status
     * 
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByStatus(string $status)
    {
        return Mahasiswa::where('status', $status)
            ->latest('created_at')
            ->get();
    }

    /**
     * Get count of mahasiswa by status
     * 
     * @return array
     */
    public function getStatusCounts(): array
    {
        return [
            'active' => Mahasiswa::where('status', 'active')->count(),
            'pending' => Mahasiswa::where('status', 'pending')->count(),
            'rejected' => Mahasiswa::where('status', 'rejected')->count(),
            'nonaktif' => Mahasiswa::where('status', 'nonaktif')->count(),
            'total' => Mahasiswa::count(),
        ];
    }

    /**
     * Get pending mahasiswa (waiting for verification)
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPending(int $limit = null)
    {
        $query = Mahasiswa::where('status', 'pending')
            ->latest('created_at');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get active mahasiswa
     * 
     * @param int|null $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActive(int $limit = null)
    {
        $query = Mahasiswa::where('status', 'active');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get rejected mahasiswa
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRejected()
    {
        return Mahasiswa::where('status', 'rejected')->get();
    }

    /**
     * Get inactive mahasiswa
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getInactive()
    {
        return Mahasiswa::where('status', 'nonaktif')->get();
    }
}
