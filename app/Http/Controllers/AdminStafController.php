<?php

namespace App\Http\Controllers;

use App\Models\Staf;
use Illuminate\Http\Request;
use App\Services\StafService;

class AdminStafController extends Controller
{
    private $stafService;

    public function __construct(StafService $stafService)
    {
        $this->stafService = $stafService;
    }

    public function index()
    {
        $staf = $this->stafService->getStaf('staf');
        return view('admin.kelolastaf', compact('staf'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:staf',
            'password' => 'required|string|min:6',
        ]);

        try {
            $this->stafService->createStaf([
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => $request->password,
            ]);

            return redirect()->back()->with('success', 'Akun staf berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {
        $staf = Staf::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:staf,username,' . $staf->id,
            'password' => 'nullable|string|min:6',
        ]);

        try {
            $this->stafService->updateStaf($id, [
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => $request->password,
            ]);

            return redirect()->back()->with('success', 'Akun staf berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->stafService->deleteStaf($id);
            return redirect()->back()->with('success', 'Akun staf berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
