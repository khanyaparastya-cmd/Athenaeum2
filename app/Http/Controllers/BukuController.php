<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    // INDEX
    public function index(Request $request)
    {
        $kategori_id = $request->input('kategori');
        $query = Buku::with('kategori')->latest();
        
        if ($kategori_id) {
            $query->where('kategori_id', $kategori_id);
        }
        
        $bukus = $query->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        
        return view('bukus.index', compact('bukus', 'kategoris', 'kategori_id'));
    }

    // CREATE
    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('bukus.create', compact('kategoris'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'tahun_terbit' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/bukus'), $filename);
            $data['foto'] = $filename;
        }

        Buku::create($data);

        return redirect()->route('bukus.index')
            ->with('success', 'Data buku berhasil ditambahkan');
    }

    // EDIT
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('bukus.edit', compact('buku', 'kategoris'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'tahun_terbit' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $buku = Buku::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($buku->foto && file_exists(public_path('uploads/bukus/' . $buku->foto))) {
                unlink(public_path('uploads/bukus/' . $buku->foto));
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/bukus'), $filename);
            $data['foto'] = $filename;
        }

        $buku->update($data);

        return redirect()->route('bukus.index')
            ->with('success', 'Data buku berhasil diupdate');
    }

    // DELETE
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        
        if ($buku->foto && file_exists(public_path('uploads/bukus/' . $buku->foto))) {
            unlink(public_path('uploads/bukus/' . $buku->foto));
        }
        
        $buku->delete();

        return redirect()->route('bukus.index')
            ->with('success', 'Data buku berhasil dihapus');
    }
}