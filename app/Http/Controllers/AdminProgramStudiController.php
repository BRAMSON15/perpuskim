<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use App\Services\ProgramStudiService;
use App\Services\FakultasService;

class AdminProgramStudiController extends Controller
{
    private $programStudiService;
    private $fakultasService;

    public function __construct(ProgramStudiService $programStudiService, FakultasService $fakultasService)
    {
        $this->programStudiService = $programStudiService;
        $this->fakultasService = $fakultasService;
    }

    /**
     * Show list of program studi
     */
    public function index(Request $request)
    {
        if ($request->filled('search')) {
            $programStudi = $this->programStudiService->search($request->search);
        } else {
            $programStudi = $this->programStudiService->getAll();
        }

        $fakultas = $this->fakultasService->getActive();

        return view('admin.kelolaprogramstudi', compact('programStudi', 'fakultas'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $fakultas = $this->fakultasService->getActive();
        $jenjang = ['S1', 'S2', 'S3', 'D3', 'D4'];
        
        return view('admin.programstudi.form', compact('fakultas', 'jenjang'));
    }

    /**
     * Store new program studi
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'nama_program_studi' => 'required|string|max:255|unique:program_studi,nama_program_studi',
            'kode_program_studi' => 'required|string|max:50|unique:program_studi,kode_program_studi',
            'deskripsi' => 'nullable|string',
            'jenjang' => 'required|string|in:S1,S2,S3,D3,D4',
            'ketua_program' => 'nullable|string|max:255',
        ]);

        try {
            $this->programStudiService->create($validated);
            return redirect()->route('admin.program-studi.index')->with('success', 'Program Studi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $programStudi = $this->programStudiService->getById($id);
        $fakultas = $this->fakultasService->getActive();
        $jenjang = ['S1', 'S2', 'S3', 'D3', 'D4'];
        
        return view('admin.programstudi.form', compact('programStudi', 'fakultas', 'jenjang'));
    }

    /**
     * Update program studi
     */
    public function update(Request $request, $id)
    {
        $programStudi = $this->programStudiService->getById($id);

        $validated = $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'nama_program_studi' => 'required|string|max:255|unique:program_studi,nama_program_studi,' . $id,
            'kode_program_studi' => 'required|string|max:50|unique:program_studi,kode_program_studi,' . $id,
            'deskripsi' => 'nullable|string',
            'jenjang' => 'required|string|in:S1,S2,S3,D3,D4',
            'ketua_program' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $this->programStudiService->update($id, $validated);
            return redirect()->route('admin.program-studi.index')->with('success', 'Program Studi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Delete program studi
     */
    public function destroy($id)
    {
        try {
            $this->programStudiService->delete($id);
            return redirect()->back()->with('success', 'Program Studi berhasil dihapus.');
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
            $this->programStudiService->toggleStatus($id);
            return redirect()->back()->with('success', 'Status Program Studi berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
