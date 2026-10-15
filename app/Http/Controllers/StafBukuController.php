<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StafBukuController extends Controller
{
    public function index()
    {
        $buku = Buku::latest()->get();
        return view('stafperpus.kelolabuku', compact('buku'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'tahun_terbit' => 'nullable|integer',
            'kategori' => 'required|string|max:100',
            'fakultas' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'gambar' => 'image|file|max:2048|nullable'
        ]);

        if ($request->file('gambar')) {
            $validatedData['gambar'] = $request->file('gambar')->store('buku-images', 'public');
        }

        Buku::create($validatedData);

        return redirect()->back()->with('success', 'Buku baru berhasil ditambahkan!');
    }

    public function update(Request $request, Buku $kelolabuku)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'tahun_terbit' => 'nullable|integer',
            'kategori' => 'required|string|max:100',
            'fakultas' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'gambar' => 'image|file|max:2048|nullable'
        ]);

        if ($request->file('gambar')) {
            if ($kelolabuku->gambar) {
                Storage::disk('public')->delete($kelolabuku->gambar);
            }
            $validatedData['gambar'] = $request->file('gambar')->store('buku-images', 'public');
        }

        $kelolabuku->update($validatedData);

        return redirect()->back()->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(Buku $kelolabuku)
    {
        if ($kelolabuku->gambar) {
            Storage::disk('public')->delete($kelolabuku->gambar);
        }
        $kelolabuku->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus!');
    }
}
