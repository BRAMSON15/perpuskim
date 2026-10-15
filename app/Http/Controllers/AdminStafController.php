<?php

namespace App\Http\Controllers;

use App\Models\Staf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminStafController extends Controller
{
    public function index()
    {
        $staf = Staf::where('role', 'staf')->latest()->get();
        return view('admin.kelolastaf', compact('staf'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:staf',
            'password' => 'required|string|min:6',
        ]);

        Staf::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'staf',
        ]);

        return redirect()->back()->with('success', 'Akun staf berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $staf = Staf::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:staf,username,' . $staf->id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staf->update($data);

        return redirect()->back()->with('success', 'Akun staf berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $staf = Staf::findOrFail($id);
        $staf->delete();

        return redirect()->back()->with('success', 'Akun staf berhasil dihapus.');
    }
}
