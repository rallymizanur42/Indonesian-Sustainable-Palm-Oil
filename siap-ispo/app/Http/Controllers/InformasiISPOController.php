<?php

namespace App\Http\Controllers;

use App\Models\InformasiISPO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformasiISPOController extends Controller
{
    public function index()
    {
        $informasi = InformasiISPO::latest()->get();
        return view('admin.informasi.index', compact('informasi'));
    }

    public function create()
    {
        return view('admin.informasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
            'syarat_ispo' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string|max:100',
            'manfaat' => 'nullable|string|max:100',
            'fitur' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $gambarName = time() . '.' . $request->gambar->extension();
            $request->gambar->storeAs('public/informasi', $gambarName);
            $data['gambar'] = $gambarName;
        }

        InformasiISPO::create($data);

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil ditambahkan!');
    }

    public function show(InformasiISPO $informasi)
    {
        return view('admin.informasi.show', compact('informasi'));
    }

    public function edit(InformasiISPO $informasi)
    {
        return view('admin.informasi.edit', compact('informasi'));
    }

    public function update(Request $request, InformasiISPO $informasi)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
            'syarat_ispo' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string|max:100',
            'manfaat' => 'nullable|string|max:100',
            'fitur' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($informasi->gambar) {
                Storage::delete('public/informasi/' . $informasi->gambar);
            }

            $gambarName = time() . '.' . $request->gambar->extension();
            $request->gambar->storeAs('public/informasi', $gambarName);
            $data['gambar'] = $gambarName;
        }

        $informasi->update($data);

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil diperbarui!');
    }

    public function destroy(InformasiISPO $informasi)
    {
        // Hapus gambar jika ada
        if ($informasi->gambar) {
            Storage::delete('public/informasi/' . $informasi->gambar);
        }

        $informasi->delete();

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil dihapus!');
    }
}
