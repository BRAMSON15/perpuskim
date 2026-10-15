<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fakultas;
use App\Services\FakultasService;

class AdminFakultasController extends Controller
{
    private $fakultasService;

    public function __construct(FakultasService $fakultasService)
    {
        $this->fakultasService = $fakultasService;
    }

    /**
     * Show list of facultas
     */
    public function index(Request $request)
    {
        if ($request->filled('search')) {
            $fakultas = $this->fakultasService->search($request->search);
        } else {
            $fakultas = $this->fakultasService->getAll();
        }

        return view('admin.kelolafakultas', compact('fakultas'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.fakultas.form');
    }

    /**
     * Store new fakultas
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_fakultas' => 'required|string|max:255|unique:fakultas,nama_fakultas',
            'kode_fakultas' => 'required|string|max:50|unique:fakultas,kode_fakultas',
            'deskripsi' => 'nullable|string',
            'kepala_fakultas' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:255',
        ]);

        try {
            $this->fakultasService->create($validated);
            return redirect()->route('admin.fakultas.index')->with('success', 'Fakultas berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $fakultas = $this->fakultasService->getById($id);
        return view('admin.fakultas.form', compact('fakultas'));
    }

    /**
     * Update fakultas
     */
    public function update(Request $request, $id)
    {
        $fakultas = $this->fakultasService->getById($id);

        $validated = $request->validate([
            'nama_fakultas' => 'required|string|max:255|unique:fakultas,nama_fakultas,' . $id,
            'kode_fakultas' => 'required|string|max:50|unique:fakultas,kode_fakultas,' . $id,
            'deskripsi' => 'nullable|string',
            'kepala_fakultas' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $this->fakultasService->update($id, $validated);
            return redirect()->route('admin.fakultas.index')->with('success', 'Fakultas berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Delete fakultas
     */
    public function destroy($id)
    {
        try {
            $this->fakultasService->delete($id);
            return redirect()->back()->with('success', 'Fakultas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Toggle status
     */
    public function toggleStatus($id)
    {
        try {
            $this->fakultasService->toggleStatus($id);
            return redirect()->back()->with('success', 'Status fakultas berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
