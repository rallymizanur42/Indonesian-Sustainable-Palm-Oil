<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KriteriaISPO;

class KriteriaISPOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriteriaData = [
            // =============================================
            // PRINSIP 1: Legalitas dan Dokumen
            // =============================================
            [
                'kode_kriteria' => 'P1-1',
                'nama_kriteria' => 'Sertifikat Tanah dan Bukti Kepemilikan',
                'indikator' => 'Memiliki sertifikat tanah, akta jual beli tanah, girik, dan bukti kepemilikan tanah lainnya yang sah',
                'prinsip' => 'Prinsip 1 - Legalitas',
                'verifier' => 'Dokumen sertifikat tanah, akta jual beli, girik',
                'jenis' => 'benefit',
                'bobot' => 8.00,
            ],
            [
                'kode_kriteria' => 'P1-2',
                'nama_kriteria' => 'Kesesuaian Tata Ruang',
                'indikator' => 'Lahan pekebun mengacu kepada penetapan tata ruang',
                'prinsip' => 'Prinsip 1 - Legalitas',
                'verifier' => 'Dokumen RTRW, izin lokasi',
                'jenis' => 'benefit',
                'bobot' => 6.00,
            ],
            [
                'kode_kriteria' => 'P1-3',
                'nama_kriteria' => 'Dokumen Penyelesaian Sengketa',
                'indikator' => 'Mempunyai dokumen progres musyawarah untuk penyelesaian sengketa dan tersedia peta lokasi sengketa lahan',
                'prinsip' => 'Prinsip 1 - Legalitas',
                'verifier' => 'Berita acara musyawarah, peta sengketa',
                'jenis' => 'benefit',
                'bobot' => 5.00,
            ],
            [
                'kode_kriteria' => 'P1-4',
                'nama_kriteria' => 'Perjanjian yang Disepakati',
                'indikator' => 'Mempunyai salinan perjanjian yang telah disepakati',
                'prinsip' => 'Prinsip 1 - Legalitas',
                'verifier' => 'Dokumen perjanjian, MoU',
                'jenis' => 'benefit',
                'bobot' => 4.00,
            ],
            [
                'kode_kriteria' => 'P1-5',
                'nama_kriteria' => 'STD-B',
                'indikator' => 'Memiliki Surat Tanda Daftar Usaha Perkebunan Untuk Budidaya (STD-B)',
                'prinsip' => 'Prinsip 1 - Legalitas',
                'verifier' => 'Dokumen STD-B',
                'jenis' => 'benefit',
                'bobot' => 7.00,
            ],
            [
                'kode_kriteria' => 'P1-6',
                'nama_kriteria' => 'Izin Lingkungan SPPL',
                'indikator' => 'Memiliki izin lingkungan sesuai SPPL',
                'prinsip' => 'Prinsip 1 - Legalitas',
                'verifier' => 'Dokumen SPPL',
                'jenis' => 'benefit',
                'bobot' => 6.00,
            ],
            [
                'kode_kriteria' => 'P1-7',
                'nama_kriteria' => 'Penerapan SPPL',
                'indikator' => 'Memiliki catatan pelaksanaan penerapan SPPL',
                'prinsip' => 'Prinsip 1 - Legalitas',
                'verifier' => 'Laporan penerapan SPPL',
                'jenis' => 'benefit',
                'bobot' => 4.00,
            ],

            // =============================================
            // PRINSIP 2: Pengelolaan Kebun Berkelanjutan
            // =============================================
            [
                'kode_kriteria' => 'P2-1',
                'nama_kriteria' => 'Kelembagaan Pekebun',
                'indikator' => 'Pekebun memiliki kelembagaan dalam bentuk kelompok tani atau koperasi',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Dokumen kelembagaan',
                'jenis' => 'benefit',
                'bobot' => 4.00,
            ],
            [
                'kode_kriteria' => 'P2-2',
                'nama_kriteria' => 'Dokumen Kelembagaan',
                'indikator' => 'Mempunyai dokumen pembentukan kelompok tani dan/atau koperasi yang diketahui oleh pejabat berwenang',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'SK pembentukan, berita acara',
                'jenis' => 'benefit',
                'bobot' => 3.00,
            ],
            [
                'kode_kriteria' => 'P2-3',
                'nama_kriteria' => 'Rencana Kegiatan Operasional',
                'indikator' => 'Memiliki dokumen rencana kegiatan operasional pekebun, kelompok tani dan/atau koperasi',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'RKAP, rencana kerja',
                'jenis' => 'benefit',
                'bobot' => 4.00,
            ],
            [
                'kode_kriteria' => 'P2-4',
                'nama_kriteria' => 'Laporan Kegiatan',
                'indikator' => 'Memiliki laporan kegiatan pekebun, kelompok tani dan/atau koperasi',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Laporan bulanan/tahunan',
                'jenis' => 'benefit',
                'bobot' => 3.00,
            ],
            [
                'kode_kriteria' => 'P2-5',
                'nama_kriteria' => 'SOP Pembukaan Lahan Tanpa Bakar',
                'indikator' => 'Memiliki dan melaksanakan SOP dan instruksi kerja cara pembukaan lahan tanpa bakar',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Dokumen SOP, laporan pelaksanaan',
                'jenis' => 'benefit',
                'bobot' => 6.00,
            ],
            [
                'kode_kriteria' => 'P2-6',
                'nama_kriteria' => 'Benih Bersertifikat',
                'indikator' => 'Menggunakan benih dari produsen yang tersertifikasi oleh lembaga berwenang dan diakui oleh kementrian pertanian',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Sertifikat benih, faktur pembelian',
                'jenis' => 'benefit',
                'bobot' => 5.00,
            ],
            [
                'kode_kriteria' => 'P2-7',
                'nama_kriteria' => 'Dokumen Rencana Operasional',
                'indikator' => 'Memiliki Dokumen Rencana Operasional Petani, Kelompok Tani, dan/atau Koperasi',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Dokumen rencana operasional',
                'jenis' => 'benefit',
                'bobot' => 4.00,
            ],
            [
                'kode_kriteria' => 'P2-8',
                'nama_kriteria' => 'Catatan Asal Benih',
                'indikator' => 'Mempunyai catatan asal benih',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Buku catatan, faktur',
                'jenis' => 'benefit',
                'bobot' => 3.00,
            ],
            [
                'kode_kriteria' => 'P2-9',
                'nama_kriteria' => 'SOP Penanaman GAP',
                'indikator' => 'Memiliki dan melaksanakan SOP penanaman yang sesuai Good Agriculture Practise (GAP)',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Dokumen SOP GAP, laporan pelaksanaan',
                'jenis' => 'benefit',
                'bobot' => 5.00,
            ],
            [
                'kode_kriteria' => 'P2-10',
                'nama_kriteria' => 'Catatan Pelaksanaan Penanaman',
                'indikator' => 'Memiliki catatan pelaksanaan penanaman',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Buku catatan penanaman',
                'jenis' => 'benefit',
                'bobot' => 3.00,
            ],
            [
                'kode_kriteria' => 'P2-11',
                'nama_kriteria' => 'Penanaman Lahan Gambut',
                'indikator' => 'Memiliki catatan untuk penanaman pada lahan gambut yang mengacu kepada peraturan berlaku',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Catatan khusus lahan gambut',
                'jenis' => 'benefit',
                'bobot' => 4.00,
            ],
            [
                'kode_kriteria' => 'P2-12',
                'nama_kriteria' => 'SOP dan Instruksi Kerja',
                'indikator' => 'Memiliki SOP dan Instruksi Kerja',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Dokumen SOP lengkap',
                'jenis' => 'benefit',
                'bobot' => 4.00,
            ],
            [
                'kode_kriteria' => 'P2-13',
                'nama_kriteria' => 'Catatan Pemupukan dan Pemeliharaan',
                'indikator' => 'Memiliki catatan mengenai pemupukan dan pemeliharaan tanaman',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Buku catatan pemupukan',
                'jenis' => 'benefit',
                'bobot' => 4.00,
            ],
            [
                'kode_kriteria' => 'P2-14',
                'nama_kriteria' => 'Penerapan PHT',
                'indikator' => 'Memiliki dan menerapkan Pedoman Teknis Pengendalian Hama Terpadu (PHT)',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Dokumen PHT, laporan penerapan',
                'jenis' => 'benefit',
                'bobot' => 5.00,
            ],
            [
                'kode_kriteria' => 'P2-15',
                'nama_kriteria' => 'Sarana Pengendalian OPT',
                'indikator' => 'Mempunyai sarana pengendalian OPT sesuai petunjuk teknis serta tenaga Ahli',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Dokumen sarana, sertifikat tenaga ahli',
                'jenis' => 'benefit',
                'bobot' => 4.00,
            ],
            [
                'kode_kriteria' => 'P2-16',
                'nama_kriteria' => 'Pedoman Teknis Panen',
                'indikator' => 'Memiliki Acuan atau pedoman Teknis yang menentukan bahwa buah yang dipanen sudah matang dan dipanen tepat waktu',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Dokumen pedoman panen',
                'jenis' => 'benefit',
                'bobot' => 5.00,
            ],
            [
                'kode_kriteria' => 'P2-17',
                'nama_kriteria' => 'Catatan Pelaksanaan Pemanenan',
                'indikator' => 'Memiliki Catatan Pelaksanaan Pemanenan',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Buku catatan panen',
                'jenis' => 'benefit',
                'bobot' => 3.00,
            ],
            [
                'kode_kriteria' => 'P2-18',
                'nama_kriteria' => 'Petunjuk Teknis Pengangkutan TBS',
                'indikator' => 'Memiliki dan melaksanakan petunjuk teknis pengangkutan TBS',
                'prinsip' => 'Prinsip 2 - Pengelolaan Kebun',
                'verifier' => 'Dokumen petunjuk teknis',
                'jenis' => 'benefit',
                'bobot' => 3.00,
            ],

            // =============================================
            // PRINSIP 3: Pengelolaan Lingkungan
            // =============================================
            [
                'kode_kriteria' => 'P3-1',
                'nama_kriteria' => 'Pencegahan dan Penanggulangan Kebakaran',
                'indikator' => 'Melaksanakan pencegahan dan penanggulangan kebakaran secara bersama-sama dengan penduduk sekitar dan instansi terkait, Sesuai pedoman pencegahan dan pengendalian Kebakaran',
                'prinsip' => 'Prinsip 3 - Lingkungan',
                'verifier' => 'Dokumen koordinasi, laporan kegiatan',
                'jenis' => 'benefit',
                'bobot' => 7.00,
            ],
            [
                'kode_kriteria' => 'P3-2',
                'nama_kriteria' => 'Pengetahuan Keanekaragaman Hayati',
                'indikator' => 'Mengetahui keberadaan satwa dan tumbuhan di area tersebut dan di sekitar kebun dan sesudah dimulainya usaha perkebunan',
                'prinsip' => 'Prinsip 3 - Lingkungan',
                'verifier' => 'Dokumen identifikasi, laporan monitoring',
                'jenis' => 'benefit',
                'bobot' => 5.00,
            ],
            [
                'kode_kriteria' => 'P3-3',
                'nama_kriteria' => 'Catatan Keanekaragaman Hayati',
                'indikator' => 'Memiliki catatan keberadaan satwa dan tumbuhan di kebun dan sekitar kebun',
                'prinsip' => 'Prinsip 3 - Lingkungan',
                'verifier' => 'Buku catatan biodiversitas',
                'jenis' => 'benefit',
                'bobot' => 4.00,
            ],

            // =============================================
            // PRINSIP 4: Tanggung Jawab Sosial
            // =============================================
            [
                'kode_kriteria' => 'P4-1',
                'nama_kriteria' => 'Informasi Harga TBS',
                'indikator' => 'Memiliki informasi harga TBS berdasarkan penetapan harga yang ditetapkan oleh Tim Penetapan Harga TBS untuk setiap penjualan',
                'prinsip' => 'Prinsip 4 - Tanggung Jawab Sosial',
                'verifier' => 'Dokumen penetapan harga',
                'jenis' => 'benefit',
                'bobot' => 5.00,
            ],
            [
                'kode_kriteria' => 'P4-2',
                'nama_kriteria' => 'Catatan Harga TBS dan Realisasi',
                'indikator' => 'Memiliki catatan harga TBS dan realisasi pembelian oleh perusahaan/pabrik dan tersedia sumber informasi harga untuk penetapan harga pembelian TBS yang dipantau oleh pekebun, kelompok tani dan/atau koperasi',
                'prinsip' => 'Prinsip 4 - Tanggung Jawab Sosial',
                'verifier' => 'Buku catatan harga, laporan realisasi',
                'jenis' => 'benefit',
                'bobot' => 4.00,
            ],
            [
                'kode_kriteria' => 'P4-3',
                'nama_kriteria' => 'SOP Pelayanan Informasi',
                'indikator' => 'Sudah menerapkan SOP pelayanan informasi',
                'prinsip' => 'Prinsip 4 - Tanggung Jawab Sosial',
                'verifier' => 'Dokumen SOP pelayanan',
                'jenis' => 'benefit',
                'bobot' => 3.00,
            ],
            [
                'kode_kriteria' => 'P4-4',
                'nama_kriteria' => 'Pemberian Informasi kepada Pemangku Kepentingan',
                'indikator' => 'Mempunyai dokumen pemberian informasi kepada pemangku kepentingan sesuai peraturan yang berlaku',
                'prinsip' => 'Prinsip 4 - Tanggung Jawab Sosial',
                'verifier' => 'Dokumen distribusi informasi',
                'jenis' => 'benefit',
                'bobot' => 3.00,
            ],
            [
                'kode_kriteria' => 'P4-5',
                'nama_kriteria' => 'Pelayanan Informasi Pemangku Kepentingan',
                'indikator' => 'Mempunyai dokumen tanggapan atau pelayanan informasi terhadap permintaan informasi dari pemangku kepentingan',
                'prinsip' => 'Prinsip 4 - Tanggung Jawab Sosial',
                'verifier' => 'Arsip permintaan dan tanggapan',
                'jenis' => 'benefit',
                'bobot' => 3.00,
            ],

            // =============================================
            // PRINSIP 5: Peningkatan Berkelanjutan
            // =============================================
            [
                'kode_kriteria' => 'P5-1',
                'nama_kriteria' => 'Dokumen Perbaikan Berkelanjutan',
                'indikator' => 'Memiliki dokumen hasil penerapan perbaikan/ peningkatan usaha yang berkelanjutan',
                'prinsip' => 'Prinsip 5 - Peningkatan Berkelanjutan',
                'verifier' => 'Laporan perbaikan berkelanjutan',
                'jenis' => 'benefit',
                'bobot' => 6.00,
            ],
        ];

        foreach ($kriteriaData as $kriteria) {
            KriteriaISPO::create($kriteria);
        }

        echo "KriteriaISPOSeeder berhasil dijalankan!\n";
        echo "Total kriteria: " . count($kriteriaData) . "\n";

        // Hitung total bobot untuk verifikasi
        $totalBobot = array_sum(array_column($kriteriaData, 'bobot'));
        echo "Total bobot: " . $totalBobot . "%\n";

        // Tampilkan summary per prinsip
        $summary = [];
        foreach ($kriteriaData as $k) {
            $prinsip = $k['prinsip'];
            if (!isset($summary[$prinsip])) {
                $summary[$prinsip] = 0;
            }
            $summary[$prinsip] += $k['bobot'];
        }

        echo "\nSummary Bobot per Prinsip:\n";
        foreach ($summary as $prinsip => $bobot) {
            echo "- {$prinsip}: {$bobot}%\n";
        }
    }
}
