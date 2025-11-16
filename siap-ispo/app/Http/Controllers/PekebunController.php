<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\RiwayatDSS;
use App\Models\PemetaanLahan;

class PekebunController extends Controller
{
    public function dashboard()
    {
        $pekebun = Auth::user();
        $lahan = $pekebun->pemetaanLahans;
        $riwayat = $pekebun->riwayatDsses()->latest()->take(5)->get();

        return view('pekebun.dashboard', compact('pekebun', 'lahan', 'riwayat'));
    }

    public function pemetaanMap()
    {
        $pekebun = Auth::user();
        $lahan = $pekebun->pemetaanLahans;
        $gisData = $this->formatGisData($lahan);

        return view('pekebun.pemetaan.map', compact('lahan', 'gisData'));
    }

    public function pemetaanTable()
    {
        $pekebun = Auth::user();
        $lahan = $pekebun->pemetaanLahans;
        $gisData = $this->formatGisData($lahan);

        return view('pekebun.pemetaan.table', compact('lahan', 'gisData'));
    }

    public function dss()
    {
        return view('pekebun.dss');
    }

    private function formatGisData($data)
    {
        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'geometryType' => $item->geometry_type,
                'geometry' => json_decode($item->geometry),
                'properties' => [
                    'idLahan' => $item->id_lahan ?? 'N/A',
                    'deskripsi' => $item->deskripsi,
                    'desa' => $item->desa,
                    'kecamatan' => $item->kecamatan,
                    'statusISPO' => $item->status_ispo ?? 'N/A',
                    'tingkatKesiapan' => $item->tingkat_kesiapan ?? 'N/A',
                    'luasLahan' => $item->luas_lahan
                ]
            ];
        });
    }
}
