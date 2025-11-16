# Sistem Pemetaan Kesiapan Sertifikasi ISPO

Sistem informasi geografis berbasis web untuk membantu petani kelapa sawit swadaya dalam mempersiapkan dan mendapatkan sertifikasi Indonesian Sustainable Palm Oil (ISPO) melalui analisis tingkat kesiapan menggunakan metode Decision Support System (DSS).

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=flat&logo=bootstrap)
![Leaflet](https://img.shields.io/badge/Leaflet-1.9-199900?style=flat&logo=leaflet)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql)

## 📋 Deskripsi

Aplikasi ini dirancang khusus untuk membantu petani kelapa sawit swadaya dalam mempersiapkan diri mendapatkan sertifikasi ISPO. Sistem menggunakan metode DSS (Decision Support System) untuk mengevaluasi tingkat kesiapan kebun dan memberikan rekomendasi perbaikan yang diperlukan.

### Fitur Utama

- 🗺️ **Pemetaan Interaktif** - Visualisasi lokasi kebun kelapa sawit dengan Leaflet.js
- ✏️ **Drawing Tools** - Menggambar dan mengedit batas kebun menggunakan Leaflet Draw
- 📊 **Analisis DSS** - Evaluasi otomatis tingkat kesiapan sertifikasi ISPO
- 🎨 **Layer Visualization** - Multiple layers untuk kesiapan dan status ISPO
- 📍 **GeoJSON Support** - Import/export data geografis dalam format GeoJSON
- 📈 **Dashboard Analytics** - Statistik dan laporan kesiapan sertifikasi

## 🎯 Tujuan

1. Membantu petani swadaya memahami persyaratan sertifikasi ISPO
2. Mengevaluasi tingkat kesiapan kebun untuk sertifikasi
3. Memberikan rekomendasi perbaikan yang terukur
4. Memetakan sebaran kebun berdasarkan status kesiapan
5. Mempermudah proses monitoring dan pendampingan

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 12
- **Frontend**: Bootstrap 5
- **Mapping**: Leaflet.js & Leaflet Draw
- **Database**: MySQL 8.0
- **Data Format**: GeoJSON
- **DSS Method**: Weighted Scoring / Simple Additive Weighting (SAW)

## 📦 Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL >= 8.0
- Web Server (Apache/Nginx)

