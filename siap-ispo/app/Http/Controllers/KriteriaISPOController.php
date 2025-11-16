<?php

namespace App\Http\Controllers;

use App\Models\KriteriaISPO;
use Illuminate\Http\Request;

class KriteriaISPOController extends Controller
{
    public function index()
    {
        $kriteria = KriteriaISPO::all();
        return view('admin.kriteria.index', compact('kriteria'));
    }

    public function create()
    {
        return view('admin.kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:100',
            'indikator' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        KriteriaISPO::create($request->all());

        return redirect()
            ->route('admin.kriteria.index')
            ->with('success', 'Kriteria ISPO berhasil ditambahkan!');
    }

    public function show($id)
    {
        $kriteria = KriteriaISPO::findOrFail($id);
        return view('admin.kriteria.show', compact('kriteria'));
    }

    public function edit($id)
    {
        $kriteria = KriteriaISPO::findOrFail($id);
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:100',
            'indikator' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        $kriteria = KriteriaISPO::findOrFail($id);
        $kriteria->update($request->all());

        return redirect()
            ->route('admin.kriteria.index')
            ->with('success', 'Kriteria ISPO berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kriteria = KriteriaISPO::findOrFail($id);
        $kriteria->delete();

        return redirect()
            ->route('admin.kriteria.index')
            ->with('success', 'Kriteria ISPO berhasil dihapus.');
    }
}
