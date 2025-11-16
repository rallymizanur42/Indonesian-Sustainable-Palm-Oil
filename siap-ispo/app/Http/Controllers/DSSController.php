<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KriteriaISPO;
use App\Models\DSS;
use App\Models\RiwayatDSS;
use App\Models\PemetaanLahan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DSSController extends Controller
{
    public function index()
    {
        $kriteria = KriteriaISPO::all()->groupBy('prinsip');
        $lahan = PemetaanLahan::where('user_id', Auth::id())->get();

        // Ambil riwayat user yang sedang login
        $riwayatTerbaru = RiwayatDSS::with(['pemetaanLahan'])
            ->where('user_id', Auth::id())
            ->latest('tanggal_analisis')
            ->take(5)
            ->get();

        // Hitung total analisis yang pernah dilakukan
        $totalAnalisis = RiwayatDSS::where('user_id', Auth::id())->count();

        return view('pekebun.dss.index', compact('kriteria', 'lahan', 'riwayatTerbaru', 'totalAnalisis'));
    }

    public function hitungKesiapan(Request $request)
    {
        Log::info('DSS Request Data:', $request->all());

        $request->validate([
            'pemetaan_lahan_id' => 'required|exists:pemetaan_lahans,id',
            'nilai' => 'required|array',
            'nilai.*' => 'required|numeric|min:0|max:100'
        ]);

        $user_id = Auth::id();
        $pemetaan_lahan_id = $request->pemetaan_lahan_id;

        // Hitung hasil SAW berdasarkan nilai yang dikirim
        $hasil = $this->hitungSAW($request->nilai);

        if (!$hasil['success']) {
            return response()->json($hasil);
        }

        try {
            // Simpan ke tabel DSS untuk setiap kriteria
            $dssRecords = [];
            foreach ($request->nilai as $kriteria_id => $nilai) {
                $kriteria = KriteriaISPO::find($kriteria_id);

                $dssRecord = DSS::create([
                    'user_id' => $user_id,
                    'kriteria_ispo_id' => $kriteria_id,
                    'parameter_kriteria_ispo' => $kriteria->nama_kriteria,
                    'skor_kesiapan' => $nilai,
                    'level_kesiapan' => $this->getLevelKesiapan($nilai),
                    'rekomendasi_text' => $this->getRekomendasiKriteria($nilai),
                    'tanggal_dibuat' => now(),
                ]);
                $dssRecords[] = $dssRecord;
            }

            // === INI LOKASI KODE YANG DIMAKSUD ===
            // Di method hitungKesiapan(), setelah perhitungan SAW
            $skorAkhir = round($hasil['skor_akhir'], 2);

            // Simpan ke riwayat DSS
            $riwayatDSS = RiwayatDSS::create([
                'user_id' => $user_id,
                'pemetaan_lahan_id' => $pemetaan_lahan_id,
                'dss_id' => $dssRecords[0]->id,
                'skor_akhir' => $skorAkhir, // PASTIKAN ini sama dengan yang dihitung
                'rekomendasi_text' => implode(' | ', $hasil['rekomendasi']),
                'tanggal_analisis' => now(),
            ]);
            // === END LOKASI ===

            // Update pemetaan lahan
            $pemetaanLahan = PemetaanLahan::find($pemetaan_lahan_id);
            if ($pemetaanLahan) {
                $pemetaanLahan->update([
                    'tingkat_kesiapan' => $hasil['tingkat_kesiapan']['status'],
                    // 'status_ispo' => $this->getStatusISPO($hasil['skor_akhir']),
                ]);
            }

            $hasil['riwayat_id'] = $riwayatDSS->id;
            return response()->json($hasil);
        } catch (\Exception $e) {
            Log::error('Error saving DSS data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ]);
        }
    }

    private function hitungSAW($nilaiKriteria)
    {
        $kriteria = KriteriaISPO::all();

        if (count($nilaiKriteria) !== $kriteria->count()) {
            return [
                'success' => false,
                'message' => 'Jumlah kriteria yang dinilai tidak sesuai. Harap isi semua kriteria.'
            ];
        }

        $totalSkor = 0;
        $totalBobot = 0;
        $detailKriteria = [];
        $kriteriaPerPrinsip = [];

        foreach ($kriteria as $krit) {
            if (!isset($nilaiKriteria[$krit->id])) {
                return [
                    'success' => false,
                    'message' => "Kriteria {$krit->kode_kriteria} belum dinilai"
                ];
            }

            $nilai = $nilaiKriteria[$krit->id];

            // PASTIKAN nilai tidak melebihi 100
            $nilai = min($nilai, 100);

            // Normalisasi nilai ke skala 0-1
            $nilaiNormalized = $nilai / 100;

            // Hitung skor dengan bobot yang tepat
            // Bobot sudah dalam persentase, jadi bagi dengan 100 untuk mendapatkan fraksi
            $bobotFraction = $krit->bobot / 100;
            $skor = $nilaiNormalized * $bobotFraction;

            $detailKriteria[] = [
                'kode' => $krit->kode_kriteria,
                'nama' => $krit->nama_kriteria,
                'prinsip' => $krit->prinsip,
                'bobot' => $krit->bobot,
                'nilai' => $nilai,
                'normalized' => $nilaiNormalized,
                'skor' => $skor * 100, // Konversi kembali ke persentase untuk display
            ];

            // Hitung per prinsip
            $prinsip = $krit->prinsip;
            if (!isset($kriteriaPerPrinsip[$prinsip])) {
                $kriteriaPerPrinsip[$prinsip] = [
                    'total_bobot' => 0,
                    'total_skor' => 0,
                    'kriteria_count' => 0
                ];
            }

            $kriteriaPerPrinsip[$prinsip]['total_bobot'] += $krit->bobot;
            $kriteriaPerPrinsip[$prinsip]['total_skor'] += $skor * 100;
            $kriteriaPerPrinsip[$prinsip]['kriteria_count']++;

            $totalSkor += $skor;
            $totalBobot += $krit->bobot;
        }

        // === PERBAIKAN UTAMA: Hitung skor akhir yang TIDAK melebihi 100% ===

        // Pastikan total bobot = 100% untuk perhitungan yang benar
        if ($totalBobot != 100) {
            // Jika total bobot tidak 100%, lakukan normalisasi
            $skorAkhir = ($totalSkor / ($totalBobot / 100)) * 100;
        } else {
            // Jika total bobot tepat 100%, skor akhir = totalSkor * 100
            $skorAkhir = $totalSkor * 100;
        }

        // PASTIKAN skor akhir tidak melebihi 100%
        $skorAkhir = min(round($skorAkhir, 2), 100);

        $tingkatKesiapan = $this->tentukanTingkatKesiapan($skorAkhir);

        // Hitung skor per prinsip
        $skorPrinsip = [];
        foreach ($kriteriaPerPrinsip as $prinsip => $data) {
            if ($data['kriteria_count'] > 0) {
                $skorPrinsip[$prinsip] = $data['total_skor'] / $data['kriteria_count'];
                // Pastikan juga skor prinsip tidak melebihi 100%
                $skorPrinsip[$prinsip] = min($skorPrinsip[$prinsip], 100);
            }
        }

        return [
            'success' => true,
            'skor_akhir' => $skorAkhir,
            'tingkat_kesiapan' => $tingkatKesiapan,
            'detail_kriteria' => $detailKriteria,
            'skor_prinsip' => $skorPrinsip,
            'total_kriteria' => count($detailKriteria),
            'total_bobot' => $totalBobot,
            'rekomendasi' => $this->berikanRekomendasi($skorAkhir, $detailKriteria)
        ];
    }

    private function tentukanTingkatKesiapan($skor)
    {
        if ($skor >= 85) return ['status' => 'Sangat Siap', 'class' => 'success', 'color' => '#28a745'];
        if ($skor >= 70) return ['status' => 'Siap', 'class' => 'primary', 'color' => '#007bff'];
        if ($skor >= 55) return ['status' => 'Cukup Siap', 'class' => 'warning', 'color' => '#ffc107'];
        if ($skor >= 40) return ['status' => 'Kurang Siap', 'class' => 'info', 'color' => '#17a2b8'];
        return ['status' => 'Belum Siap', 'class' => 'danger', 'color' => '#dc3545'];
    }

    private function berikanRekomendasi($skor, $detailKriteria)
    {
        $rekomendasi = [];

        if ($skor >= 80) {
            $rekomendasi[] = "🎉 Kesiapan sangat baik. Direkomendasikan untuk segera mengajukan sertifikasi ISPO.";
        } elseif ($skor >= 60) {
            $rekomendasi[] = "✅ Kesiapan cukup baik. Fokus pada penyempurnaan dokumen dan implementasi SOP.";
        } else {
            $rekomendasi[] = "⚠️ Perlu perbaikan signifikan pada beberapa aspek penting.";
        }

        // Cari kriteria dengan nilai terendah untuk rekomendasi perbaikan
        usort($detailKriteria, function ($a, $b) {
            return $a['nilai'] <=> $b['nilai'];
        });

        $kriteriaRendah = array_slice($detailKriteria, 0, 3);
        if (!empty($kriteriaRendah)) {
            $rekomendasiPerbaikan = [];
            foreach ($kriteriaRendah as $k) {
                if ($k['nilai'] < 60) {
                    $rekomendasiPerbaikan[] = "{$k['nama']} ({$k['nilai']}%)";
                }
            }

            if (!empty($rekomendasiPerbaikan)) {
                $rekomendasi[] = "🔧 Prioritas perbaikan: " . implode(', ', $rekomendasiPerbaikan);
            }
        }

        return $rekomendasi;
    }

    private function getLevelKesiapan($nilai)
    {
        if ($nilai >= 80) return 'tinggi';
        if ($nilai >= 60) return 'sedang';
        return 'rendah';
    }

    private function getRekomendasiKriteria($nilai)
    {
        if ($nilai >= 80) return 'Pertahankan pencapaian';
        if ($nilai >= 60) return 'Tingkatkan sedikit';
        if ($nilai >= 40) return 'Perlu perbaikan';
        return 'Perbaikan mendesak';
    }

    private function getStatusISPO($skor)
    {
        if ($skor >= 80) return 'Lulus';
        if ($skor >= 60) return 'Dalam Proses';
        return 'Perlu Perbaikan';
    }

    // Untuk Pekebun: Lihat semua riwayat
    public function riwayatPekebun()
    {
        $riwayat = RiwayatDSS::with(['pemetaanLahan'])
            ->where('user_id', Auth::id())
            ->orderBy('tanggal_analisis', 'desc')
            ->paginate(10);

        return view('pekebun.dss.riwayat', compact('riwayat'));
    }

    // Untuk Admin: Lihat riwayat terbaru semua user
    public function riwayatAdmin()
    {
        $riwayat = RiwayatDSS::with(['user', 'pemetaanLahan'])
            ->latest('tanggal_analisis')
            ->paginate(10);

        return view('admin.dss.riwayat', compact('riwayat'));
    }

    public function showRiwayat($id)
    {
        $riwayat = RiwayatDSS::with(['user', 'pemetaanLahan'])
            ->findOrFail($id);

        // Authorization check
        if (Auth::user()->role === 'pekebun' && $riwayat->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // GUNAKAN SKOR DARI RIWAYAT - jangan hitung ulang
        $skorAkhir = $riwayat->skor_akhir;

        // Ambil DSS records dengan rentang waktu yang lebih longgar
        $dssRecords = DSS::with('kriteria')
            ->where('user_id', $riwayat->user_id)
            ->whereBetween('tanggal_dibuat', [
                $riwayat->tanggal_analisis->copy()->subHours(2),
                $riwayat->tanggal_analisis->copy()->addHours(2)
            ])
            ->get();

        $detailKriteria = [];
        $kriteriaIds = []; // Untuk menghindari duplikasi

        foreach ($dssRecords as $dss) {
            if ($dss->kriteria && !in_array($dss->kriteria_ispo_id, $kriteriaIds)) {
                $kriteriaIds[] = $dss->kriteria_ispo_id;

                $detailKriteria[] = [
                    'kode' => $dss->kriteria->kode_kriteria,
                    'nama' => $dss->kriteria->nama_kriteria,
                    'prinsip' => $dss->kriteria->prinsip,
                    'bobot' => $dss->kriteria->bobot,
                    'nilai' => $dss->skor_kesiapan,
                    'skor' => ($dss->skor_kesiapan * $dss->kriteria->bobot) / 100,
                    'level_kesiapan' => $dss->level_kesiapan,
                    'rekomendasi_text' => $dss->rekomendasi_text,
                ];
            }
        }

        // Hanya tampilkan maksimal 34 kriteria
        if (count($detailKriteria) > 34) {
            $detailKriteria = array_slice($detailKriteria, 0, 34);
        }

        return view('pekebun.dss.riwayat-detail', compact('riwayat', 'detailKriteria', 'skorAkhir'));
    }


    // Get data penilaian sebelumnya untuk pre-fill form - PERBAIKAN
    public function getPenilaianSebelumnya($pemetaan_lahan_id)
    {
        $user_id = Auth::id();

        // Ambil dari RiwayatDSS karena DSS tidak punya pemetaan_lahan_id
        $riwayatTerbaru = RiwayatDSS::where('user_id', $user_id)
            ->where('pemetaan_lahan_id', $pemetaan_lahan_id)
            ->latest('tanggal_analisis')
            ->first();

        if (!$riwayatTerbaru) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }

        // Ambil DSS records berdasarkan riwayat terbaru
        $penilaian = DSS::with('kriteria')
            ->where('user_id', $user_id)
            ->whereDate('tanggal_dibuat', $riwayatTerbaru->tanggal_analisis->format('Y-m-d'))
            ->whereTime('tanggal_dibuat', $riwayatTerbaru->tanggal_analisis->format('H:i:s'))
            ->get()
            ->keyBy('kriteria_ispo_id');

        return response()->json([
            'success' => true,
            'data' => $penilaian
        ]);
    }
}
