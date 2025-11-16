<?php

namespace App\Http\Controllers;

use App\Models\PemetaanLahan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemetaanLahanController extends Controller
{
    // ADMIN: Menampilkan semua data
    public function index()
    {
        $perkebunans = PemetaanLahan::with('pekebun')->paginate(10);
        return view('admin.pemetaan.index', compact('perkebunans'));
    }

    // ADMIN: Create form
    public function create()
    {
        $pekebuns = User::where('role', 'pekebun')->get();
        return view('admin.pemetaan.create', compact('pekebuns'));
    }

    // ADMIN: Store data
    public function store(Request $request)
    {
        $request->validate([
            'id_lahan' => 'required|string|max:50|unique:pemetaan_lahans',
            'user_id' => 'nullable|exists:users,id',
            'deskripsi' => 'required|string|max:100',
            'desa' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'status_ispo' => 'required|string|max:100',
            'tingkat_kesiapan' => 'required|string|max:100',
            'luas_lahan' => 'required|numeric|min:0',
            'geometry_type' => 'required|string|max:100',
            'geometry' => 'required|json',
        ]);

        PemetaanLahan::create($request->all());

        return redirect()->route('admin.pemetaan.index')
            ->with('success', 'Data pemetaan berhasil ditambahkan.');
    }

    // ADMIN: Edit form
    public function edit($id)
    {
        $perkebunan = PemetaanLahan::findOrFail($id);
        $pekebuns = User::where('role', 'pekebun')->get();
        return view('admin.pemetaan.edit', compact('perkebunan', 'pekebuns'));
    }

    // ADMIN: Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_lahan' => 'required|string|max:50|unique:pemetaan_lahans,id_lahan,' . $id,
            'user_id' => 'nullable|exists:users,id',
            'deskripsi' => 'required|string|max:100',
            'desa' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'status_ispo' => 'required|string|max:100',
            'tingkat_kesiapan' => 'required|string|max:100',
            'luas_lahan' => 'required|numeric|min:0',
            'geometry_type' => 'required|string|max:100',
            'geometry' => 'required|json',
        ]);

        $perkebunan = PemetaanLahan::findOrFail($id);
        $perkebunan->update($request->all());

        return redirect()->route('admin.pemetaan.index')
            ->with('success', 'Data pemetaan berhasil diperbarui.');
    }

    // ADMIN: Delete data
    public function destroy($id)
    {
        $perkebunan = PemetaanLahan::findOrFail($id);
        $perkebunan->delete();

        return redirect()->route('admin.pemetaan.index')
            ->with('success', 'Data pemetaan berhasil dihapus.');
    }

    // ADMIN: Show detail
    // public function show($id)
    // {
    //     $perkebunan = PemetaanLahan::with('pekebun')->findOrFail($id);
    //     return view('admin.pemetaan.show', compact('perkebunan'));
    // }

    public function show($id)
    {
        try {
            $perkebunan = PemetaanLahan::with('pekebun')->findOrFail($id);

            // Debug geometry data
            logger('Geometry Data:', ['geometry' => $perkebunan->geometry]);

            return view('admin.pemetaan.show', compact('perkebunan'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.pemetaan.index')
                ->with('error', 'Data pemetaan tidak ditemukan.');
        }
    }
    // PEKEBUN: Map view
    public function map()
    {
        $user = Auth::user();

        // PERBAIKAN: Gunakan cara yang lebih aman untuk cek role
        if ($user && $user->role === 'admin') {
            $lahan = PemetaanLahan::all();
        } else {
            $lahan = $user->pemetaanLahans;
        }

        // Format data untuk map
        $gisData = $lahan->map(function ($item) {
            return [
                'id' => $item->id,
                'geometryType' => $item->geometry_type ?? 'point',
                'geometry' => $item->geometry ? json_decode($item->geometry) : ['type' => 'Point', 'coordinates' => [0, 0]],
                'properties' => [
                    'idLahan' => $item->id_lahan,
                    'deskripsi' => $item->deskripsi,
                    'desa' => $item->desa,
                    'kecamatan' => $item->kecamatan,
                    'statusISPO' => $item->status_ispo ?? 'N/A',
                    'luasLahan' => $item->luas_lahan,
                    'tingkatKesiapan' => $item->tingkat_kesiapan ?? 'N/A',
                    'pemilik' => $item->pekebun->name ?? 'Admin'
                ]
            ];
        });

        return view('pekebun.pemetaan.map', compact('gisData'));
    }

    // PEKEBUN: Table view
    public function table()
    {
        $user = Auth::user();

        // PERBAIKAN: Gunakan cara yang lebih aman untuk cek role
        if ($user && $user->role === 'admin') {
            $lahan = PemetaanLahan::all();
        } else {
            $lahan = $user->pemetaanLahans;
        }

        $gisData = $lahan->map(function ($item) {
            return [
                'id' => $item->id,
                'geometryType' => $item->geometry_type ?? 'point',
                'geometry' => $item->geometry ? json_decode($item->geometry) : ['type' => 'Point', 'coordinates' => [0, 0]],
                'properties' => [
                    'idLahan' => $item->id_lahan,
                    'deskripsi' => $item->deskripsi,
                    'desa' => $item->desa,
                    'kecamatan' => $item->kecamatan,
                    'statusISPO' => $item->status_ispo ?? 'N/A',
                    'luasLahan' => $item->luas_lahan,
                    'tingkatKesiapan' => $item->tingkat_kesiapan ?? 'N/A',
                    'pemilik' => $item->pekebun->name ?? 'Admin'
                ]
            ];
        });

        return view('pekebun.pemetaan.table', compact('gisData'));
    }

    // API untuk data peta
    public function getPemetaanData()
    {
        $perkebunans = PemetaanLahan::with('pekebun')->get();

        $gisData = $perkebunans->map(function ($item) {
            return [
                'id' => $item->id,
                'geometryType' => $item->geometry_type ?? 'point',
                'geometry' => $item->geometry ? (is_string($item->geometry) ? json_decode($item->geometry, true) : $item->geometry) : ['type' => 'Point', 'coordinates' => [0, 0]],
                'properties' => [
                    'idLahan' => $item->id_lahan,
                    'deskripsi' => $item->deskripsi,
                    'desa' => $item->desa,
                    'kecamatan' => $item->kecamatan,
                    'statusISPO' => $item->status_ispo ?? 'N/A',
                    'luasLahan' => $item->luas_lahan,
                    'tingkatKesiapan' => $item->tingkat_kesiapan ?? 'N/A',
                    'pemilik' => $item->pekebun->name ?? 'Admin'
                ]
            ];
        });

        return response()->json($gisData);
    }


    // MAP untuk semua data (tanpa filter role) dengan users
    public function mapAll()
    {
        $perkebunans = PemetaanLahan::with('pekebun')->get();
        $users = User::where('role', 'pekebun')->get();

        $gisData = $perkebunans->map(function ($item) {
            return [
                'id' => $item->id,
                'geometryType' => $item->geometry_type ?? 'point',
                'geometry' => $item->geometry ? json_decode($item->geometry) : ['type' => 'Point', 'coordinates' => [0, 0]],
                'properties' => [
                    'idLahan' => $item->id_lahan,
                    'deskripsi' => $item->deskripsi,
                    'desa' => $item->desa,
                    'kecamatan' => $item->kecamatan,
                    'statusISPO' => $item->status_ispo ?? 'N/A',
                    'luasLahan' => $item->luas_lahan,
                    'tingkatKesiapan' => $item->tingkat_kesiapan ?? 'N/A',
                    'pemilik' => $item->pekebun->name ?? 'Admin',
                    'pemilikId' => $item->user_id
                ]
            ];
        });

        return view('pekebun.pemetaan.map-all', compact('gisData', 'users'));
    }

    // TABLE untuk semua data (tanpa filter role) dengan users
    public function tableAll()
    {
        $perkebunans = PemetaanLahan::with('pekebun')->get();
        $users = User::where('role', 'pekebun')->get();

        $gisData = $perkebunans->map(function ($item) {
            return [
                'id' => $item->id,
                'geometryType' => $item->geometry_type ?? 'point',
                'geometry' => $item->geometry ? json_decode($item->geometry) : ['type' => 'Point', 'coordinates' => [0, 0]],
                'properties' => [
                    'idLahan' => $item->id_lahan,
                    'deskripsi' => $item->deskripsi,
                    'desa' => $item->desa,
                    'kecamatan' => $item->kecamatan,
                    'statusISPO' => $item->status_ispo ?? 'N/A',
                    'luasLahan' => $item->luas_lahan,
                    'tingkatKesiapan' => $item->tingkat_kesiapan ?? 'N/A',
                    'pemilik' => $item->pekebun->name ?? 'Admin'
                ]
            ];
        });

        return view('pekebun.pemetaan.table-all', compact('gisData', 'users'));
    }
}
