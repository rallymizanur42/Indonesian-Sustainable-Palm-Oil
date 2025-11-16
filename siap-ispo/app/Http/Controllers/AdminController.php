<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PemetaanLahan;
use App\Models\DSS;
use App\Models\RiwayatDSS; // Diperlukan oleh Kode 2
use App\Models\KriteriaISPO;
use App\Models\InformasiISPO;
use Illuminate\Http\Request;
use Carbon\Carbon; // Diperlukan oleh Kode 2

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistik dasar (ada di kedua kode)
        $totalPekebun = User::where('role', 'pekebun')->count();
        $totalLahan = PemetaanLahan::count();
        $totalAnalisis = DSS::count();

        // <-- TAMBAHAN DARI KODE 1
        // Mengambil 5 pekebun terbaru
        $latestPekebun = User::where('role', 'pekebun')
            ->latest()
            ->take(5)
            ->get();
        // <-- AKHIR TAMBAHAN

        // Data riwayat DSS terbaru (dari Kode 2)
        $latestRiwayat = RiwayatDSS::with(['user', 'pemetaanLahan'])
            ->latest('tanggal_analisis')
            ->take(10)
            ->get();

        // Data untuk grafik (dari Kode 2)
        $chartData = $this->getChartData();

        // Statistik status sertifikasi (dari Kode 2)
        $statusStats = $this->getStatusStats();

        // Data pekebun dengan assessment terbaru (dari Kode 2)
        $latestAssessment = RiwayatDSS::with(['user', 'pemetaanLahan'])
            ->latest('tanggal_analisis')
            ->first();

        return view('admin.dashboard', compact(
            'totalPekebun',
            'totalLahan',
            'totalAnalisis',
            'latestPekebun',    // <-- TAMBAHAN DARI KODE 1
            'latestRiwayat',
            'chartData',
            'statusStats',
            'latestAssessment'
        ));
    }

    // Metode privat untuk dashboard (dari Kode 2)
    private function getChartData()
    {
        $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();

        $data = RiwayatDSS::where('tanggal_analisis', '>=', $sixMonthsAgo)
            ->selectRaw('YEAR(tanggal_analisis) as year, MONTH(tanggal_analisis) as month, AVG(skor_akhir) as avg_score')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $labels = [];
        $scores = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthYear = $date->translatedFormat('M Y');

            $found = $data->first(function ($item) use ($date) {
                return $item->year == $date->year && $item->month == $date->month;
            });

            $labels[] = $monthYear;
            $scores[] = $found ? round($found->avg_score, 2) : 0;
        }

        return [
            'labels' => $labels,
            'scores' => $scores
        ];
    }

    // Metode privat untuk dashboard (dari Kode 2)
    private function getStatusStats()
    {
        $total = RiwayatDSS::count();

        if ($total === 0) {
            return [
                'siap' => 0,
                'dianjurkan' => 0,
                'perlu_perbaikan' => 0,
                'total' => 0
            ];
        }

        $siap = RiwayatDSS::where('skor_akhir', '>=', 80)->count();
        $dianjurkan = RiwayatDSS::whereBetween('skor_akhir', [60, 79])->count();
        $perlu_perbaikan = RiwayatDSS::where('skor_akhir', '<', 60)->count();

        return [
            'siap' => $siap,
            'dianjurkan' => $dianjurkan,
            'perlu_perbaikan' => $perlu_perbaikan,
            'total' => $total
        ];
    }

    // ==========================================================
    // METODE CRUD INFORMASI (IDENTIK DI KEDUA KODE)
    // ==========================================================

    public function informasiIndex()
    {
        $informasi = InformasiISPO::all();
        return view('admin.informasi.index', compact('informasi'));
    }

    public function informasiCreate()
    {
        return view('admin.informasi.create');
    }

    public function informasiStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
            'konten' => 'required|string',
        ]);

        InformasiISPO::create($request->all());

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi ISPO berhasil ditambahkan!');
    }

    public function informasiEdit($id)
    {
        $informasi = InformasiISPO::findOrFail($id);
        return view('admin.informasi.edit', compact('informasi'));
    }

    public function informasiUpdate(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
            'konten' => 'required|string',
        ]);

        $informasi = InformasiISPO::findOrFail($id);
        $informasi->update($request->all());

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi ISPO berhasil diperbarui!');
    }

    public function informasiDestroy($id)
    {
        $informasi = InformasiISPO::findOrFail($id);
        $informasi->delete();

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi ISPO berhasil dihapus.');
    }
}
