<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PemetaanLahan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PemetaanLahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan tabel dulu
        DB::table('pemetaan_lahans')->delete();

        $pekebuns = User::where('role', 'pekebun')->get();

        // --- KOORDINAT BARU DI DARATAN (BUKAN SUNGAI) ---
        // Cluster 1: Area Labuhan Tangga Baru (Selatan Sungai)
        // Base coordinate: ~2.02, 100.98

        // Cluster 2: Area Sungai Rangau (Lebih ke Barat/Selatan)
        // Base coordinate: ~2.00, 100.90

        $pemetaanData = [
            // --- DATA KEBUN SAWIT (POLYGON REALISTIS DI DARATAN) ---
            [
                'id_lahan' => 'KB001',
                'user_id' => $pekebuns->where('email', 'pekebun@ispo.com')->first()->id ?? null,
                'deskripsi' => 'Kebun Sawit',
                'desa' => 'Labuhan Tangga Baru',
                'kecamatan' => 'Bangko',
                'status_ispo' => 'Lulus',
                'tingkat_kesiapan' => 'Siap',
                'luas_lahan' => 120.5,
                'geometry_type' => 'polygon',
                'geometry' => json_encode([
                    "type" => "Polygon",
                    "coordinates" => [[ // Cluster 1
                        [100.980, 2.020],
                        [100.985, 2.021],
                        [100.986, 2.025],
                        [100.983, 2.026],
                        [100.981, 2.024],
                        [100.980, 2.020]
                    ]]
                ])
            ],
            [
                'id_lahan' => 'KB002',
                'user_id' => $pekebuns->where('email', 'heri@ispo.com')->first()->id ?? null,
                'deskripsi' => 'Kebun Sawit',
                'desa' => 'Labuhan Tangga Baru',
                'kecamatan' => 'Bangko',
                'status_ispo' => 'Dalam Proses',
                'tingkat_kesiapan' => 'Dalam Evaluasi',
                'luas_lahan' => 85.2,
                'geometry_type' => 'polygon',
                'geometry' => json_encode([
                    "type" => "Polygon",
                    "coordinates" => [[ // Cluster 1
                        [100.975, 2.025],
                        [100.979, 2.026],
                        [100.980, 2.030],
                        [100.976, 2.031],
                        [100.975, 2.028],
                        [100.975, 2.025]
                    ]]
                ])
            ],
            [
                'id_lahan' => 'KB003',
                'user_id' => $pekebuns->where('email', 'salwa@ispo.com')->first()->id ?? null,
                'deskripsi' => 'Kebun Sawit',
                'desa' => 'Sungai Rangau',
                'kecamatan' => 'Bangko',
                'status_ispo' => 'Perlu Perbaikan',
                'tingkat_kesiapan' => 'Belum Siap',
                'luas_lahan' => 150.8,
                'geometry_type' => 'polygon',
                'geometry' => json_encode([
                    "type" => "Polygon",
                    "coordinates" => [[ // Cluster 2
                        [100.900, 2.000],
                        [100.905, 2.001],
                        [100.906, 2.004],
                        [100.903, 2.005],
                        [100.901, 2.003],
                        [100.900, 2.000]
                    ]]
                ])
            ],
            [
                'id_lahan' => 'KB004',
                'user_id' => $pekebuns->where('email', 'ahmad@ispo.com')->first()->id ?? null,
                'deskripsi' => 'Kebun Sawit',
                'desa' => 'Sungai Rangau',
                'kecamatan' => 'Bangko',
                'status_ispo' => 'Lulus',
                'tingkat_kesiapan' => 'Siap',
                'luas_lahan' => 95.7,
                'geometry_type' => 'polygon',
                'geometry' => json_encode([
                    "type" => "Polygon",
                    "coordinates" => [[ // Cluster 2
                        [100.910, 2.005],
                        [100.914, 2.006],
                        [100.915, 2.009],
                        [100.912, 2.010],
                        [100.910, 2.008],
                        [100.910, 2.005]
                    ]]
                ])
            ],
            [
                'id_lahan' => 'KB005',
                'user_id' => null,
                'deskripsi' => 'Kebun Sawit',
                'desa' => 'Labuhan Tangga Baru',
                'kecamatan' => 'Bangko',
                'status_ispo' => 'Lulus',
                'tingkat_kesiapan' => 'Siap',
                'luas_lahan' => 200.3,
                'geometry_type' => 'polygon',
                'geometry' => json_encode([
                    "type" => "Polygon",
                    "coordinates" => [[ // Cluster 1
                        [100.988, 2.028],
                        [100.992, 2.029],
                        [100.993, 2.032],
                        [100.990, 2.033],
                        [100.988, 2.031],
                        [100.988, 2.028]
                    ]]
                ])
            ],
            [
                'id_lahan' => 'KB006',
                'user_id' => null,
                'deskripsi' => 'Kebun Sawit',
                'desa' => 'Sungai Rangau',
                'kecamatan' => 'Bangko',
                'status_ispo' => 'Dalam Proses',
                'tingkat_kesiapan' => 'Dalam Evaluasi',
                'luas_lahan' => 175.9,
                'geometry_type' => 'polygon',
                'geometry' => json_encode([
                    "type" => "Polygon",
                    "coordinates" => [[ // Cluster 2
                        [100.895, 2.010],
                        [100.899, 2.011],
                        [100.900, 2.014],
                        [100.897, 2.015],
                        [100.895, 2.013],
                        [100.895, 2.010]
                    ]]
                ])
            ],

            // --- DATA TITIK (POINT) DI DARATAN ---
            [
                'id_lahan' => 'TK001',
                'user_id' => null,
                'deskripsi' => 'Titik Kumpul',
                'desa' => 'Labuhan Tangga Baru',
                'kecamatan' => 'Bangko',
                'status_ispo' => 'Lulus',
                'tingkat_kesiapan' => 'Siap',
                'luas_lahan' => 2.5,
                'geometry_type' => 'point',
                'geometry' => json_encode([ // Cluster 1
                    "type" => "Point",
                    "coordinates" => [100.982, 2.023]
                ])
            ],
            [
                'id_lahan' => 'TK002',
                'user_id' => $pekebuns->where('email', 'pekebun@ispo.com')->first()->id ?? null,
                'deskripsi' => 'Titik Kumpul',
                'desa' => 'Sungai Rangau',
                'kecamatan' => 'Bangko',
                'status_ispo' => 'Dalam Proses',
                'tingkat_kesiapan' => 'Dalam Evaluasi',
                'luas_lahan' => 1.8,
                'geometry_type' => 'point',
                'geometry' => json_encode([ // Cluster 2
                    "type" => "Point",
                    "coordinates" => [100.904, 2.002]
                ])
            ],
            [
                'id_lahan' => 'PP001',
                'user_id' => null,
                'deskripsi' => 'Pabrik Pengolahan',
                'desa' => 'Labuhan Tangga Baru',
                'kecamatan' => 'Bangko',
                'status_ispo' => 'Lulus',
                'tingkat_kesiapan' => 'Siap',
                'luas_lahan' => 15.2,
                'geometry_type' => 'point',
                'geometry' => json_encode([ // Cluster 1
                    "type" => "Point",
                    "coordinates" => [100.978, 2.029]
                ])
            ],
            [
                'id_lahan' => 'PP002',
                'user_id' => $pekebuns->where('email', 'siti@ispo.com')->first()->id ?? null,
                'deskripsi' => 'Pabrik Pengolahan',
                'desa' => 'Sungai Rangau',
                'kecamatan' => 'Bangko',
                'status_ispo' => 'Dalam Proses',
                'tingkat_kesiapan' => 'Dalam Evaluasi',
                'luas_lahan' => 12.8,
                'geometry_type' => 'point',
                'geometry' => json_encode([ // Cluster 2
                    "type" => "Point",
                    "coordinates" => [100.913, 2.007]
                ])
            ],

            // --- DATA AKSES JALAN (POLYLINE) DI DARATAN ---
            [
                'id_lahan' => 'AJ001',
                'user_id' => null,
                'deskripsi' => 'Akses Jalan',
                'desa' => 'Labuhan Tangga Baru',
                'kecamatan' => 'Bangko',
                'status_ispo' => 'Lulus',
                'tingkat_kesiapan' => 'Siap',
                'luas_lahan' => 0.0,
                'geometry_type' => 'polyline',
                'geometry' => json_encode([ // Cluster 1
                    "type" => "LineString",
                    "coordinates" => [
                        [100.975, 2.024], // Mulai
                        [100.978, 2.025], // Belok
                        [100.980, 2.022], // Belok
                        [100.982, 2.023]  // Selesai di Titik Kumpul 1
                    ]
                ])
            ],
            [
                'id_lahan' => 'AJ002',
                'user_id' => $pekebuns->where('email', 'budi@ispo.com')->first()->id ?? null,
                'deskripsi' => 'Akses Jalan',
                'desa' => 'Sungai Rangau',
                'kecamatan' => 'Bangko',
                'status_ispo' => 'Lulus',
                'tingkat_kesiapan' => 'Siap',
                'luas_lahan' => 0.0,
                'geometry_type' => 'polyline',
                'geometry' => json_encode([ // Cluster 2
                    "type" => "LineString",
                    "coordinates" => [
                        [100.900, 2.005], // Mulai
                        [100.903, 2.003], // Belok
                        [100.904, 2.002]  // Selesai di Titik Kumpul 2
                    ]
                ])
            ],
        ];

        // Insert data ke database
        foreach ($pemetaanData as $data) {
            PemetaanLahan::create($data);
        }

        echo "PemetaanLahanSeeder berhasil dijalankan!\n";
        echo "Lokasi: Rokan Hilir (Rohil) - Kecamatan Bangko\n";
        echo "Desa: Labuhan Tangga Baru, Sungai Rangau\n";
        echo "Total data: " . count($pemetaanData) . "\n";
        echo "Data koordinat telah dipindahkan ke daratan (area perkebunan).\n";
    }
}
