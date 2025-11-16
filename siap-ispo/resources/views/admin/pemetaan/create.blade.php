@extends('layouts.app')

@section('content')
<style>
    :root { 
        --primary-color: #2c7c3d; 
        --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); 
    }
    .card { 
        border-radius: 12px; 
        border: none; 
        box-shadow: var(--card-shadow); 
    }
    .card-header-pemetaan { 
        background: linear-gradient(135deg, var(--primary-color) 0%, #1a3e23 100%); 
        color: white; 
        padding: 1.5rem; 
    }
    .card-title-pemetaan { 
        font-weight: 600; 
        margin: 0; 
    }
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(44, 124, 61, 0.25);
    }
    .map-container {
        height: 400px; /* Saya perbesar sedikit agar lebih mudah menggambar */
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 1rem;
        border: 2px solid #e9ecef;
    }
    #coordinateMap {
        width: 100%;
        height: 100%;
    }
    /* Style untuk Leaflet.draw toolbar */
    .leaflet-draw-toolbar {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-header-pemetaan d-flex justify-content-between align-items-center">
                    <h4 class="card-title-pemetaan">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Data Perkebunan Baru
                    </h4>
                    <a href="{{ route('admin.pemetaan.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.pemetaan.store') }}" method="POST" id="pemetaanForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-4 text-primary">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                </h5>

                                <div class="mb-3">
                                    <label for="id_lahan" class="form-label">ID Lahan</label>
                                    <input type="text" class="form-control" id="id_lahan" name="id_lahan" value="{{ old('id_lahan') }}" required>
                                    <div class="form-text">Kode unik untuk identifikasi lahan</div>
                                </div>

                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Pemilik Lahan</label>
                                    <select class="form-select" id="user_id" name="user_id">
                                        <option value="">Pilih Pemilik</option>
                                        @foreach($pekebuns as $pekebun)
                                            <option value="{{ $pekebun->id }}" {{ old('user_id') == $pekebun->id ? 'selected' : '' }}>
                                                {{ $pekebun->name }} ({{ $pekebun->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Kosongkan jika dimiliki oleh admin</div>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <select class="form-select" id="deskripsi" name="deskripsi" required>
                                        <option value="">Pilih jenis...</option>
                                        <option value="Kebun Sawit" {{ old('deskripsi') == 'Kebun Sawit' ? 'selected' : '' }}>Kebun Sawit</option>
                                        <option value="Titik Kumpul" {{ old('deskripsi') == 'Titik Kumpul' ? 'selected' : '' }}>Titik Kumpul</option>
                                        <option value="Akses Jalan" {{ old('deskripsi') == 'Akses Jalan' ? 'selected' : '' }}>Akses Jalan</option>
                                        <option value="Pabrik Pengolahan" {{ old('deskripsi') == 'Pabrik Pengolahan' ? 'selected' : '' }}>Pabrik Pengolahan</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="desa" class="form-label">Desa</label>
                                        <input type="text" class="form-control" id="desa" name="desa" value="{{ old('desa') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="kecamatan" class="form-label">Kecamatan</label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="status_ispo" class="form-label">Status ISPO</label>
                                    <select class="form-select" id="status_ispo" name="status_ispo" required>
                                        <option value="">Pilih status...</option>
                                        <option value="Lulus" {{ old('status_ispo') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                        <option value="Dalam Proses" {{ old('status_ispo') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                                        <option value="Perlu Perbaikan" {{ old('status_ispo') == 'Perlu Perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tingkat_kesiapan" class="form-label">Tingkat Kesiapan</label>
                                    <select class="form-select" id="tingkat_kesiapan" name="tingkat_kesiapan" required>
                                        <option value="">Pilih tingkat...</option>
                                        <option value="Siap" {{ old('tingkat_kesiapan') == 'Siap' ? 'selected' : '' }}>Siap</option>
                                        <option value="Dalam Evaluasi" {{ old('tingkat_kesiapan') == 'Dalam Evaluasi' ? 'selected' : '' }}>Dalam Evaluasi</option>
                                        <option value="Belum Siap" {{ old('tingkat_kesiapan') == 'Belum Siap' ? 'selected' : '' }}>Belum Siap</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="luas_lahan" class="form-label">Luas Lahan (ha)</label>
                                    <input type="number" step="0.01" class="form-control" id="luas_lahan" name="luas_lahan" value="{{ old('luas_lahan') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="mb-4 text-primary">
                                    <i class="fas fa-map-marked-alt me-2"></i>Data Spasial
                                </h5>

                                <div class="mb-3">
                                    <label for="geometry_type" class="form-label">Tipe Geometri</label>
                                    <select class="form-select" id="geometry_type" name="geometry_type" required>
                                        <option value="">Pilih tipe (akan terisi otomatis)...</option>
                                        <option value="polygon" {{ old('geometry_type') == 'polygon' ? 'selected' : '' }}>Polygon</option>
                                        <option value="point" {{ old('geometry_type') == 'point' ? 'selected' : '' }}>Point</option>
                                        <option value="polyline" {{ old('geometry_type') == 'polyline' ? 'selected' : '' }}>Polyline</option>
                                    </select>
                                </div>

                                <div class="map-container">
                                    <div id="coordinateMap"></div>
                                </div>
                                
                                <div class="mb-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="useCurrentLocation()">
                                        <i class="fas fa-crosshairs me-2"></i> Gunakan Lokasi Saya Saat Ini
                                    </button>
                                    <div class="form-text text-center mt-2">
                                        Klik tombol di atas untuk menuju lokasi Anda, lalu gunakan toolbar di peta untuk menggambar.
                                    </div>
                                </div>
                                

                                <div class="mb-3">
                                    <label for="geometry" class="form-label">Data Geometry (GeoJSON)</label>
                                    <textarea class="form-control" id="geometry" name="geometry" rows="6" required readonly placeholder='Akan terisi otomatis setelah Anda menggambar di peta...'>{{ old('geometry') }}</textarea>
                                    <div class="form-text">
                                        Data ini akan ter-generate otomatis dari gambar di peta.
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('admin.pemetaan.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color)">
                                <i class="fas fa-save me-2"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

<script>
    let coordinateMap;
    let drawnItems;

    // Fungsi untuk memindahkan peta ke lokasi pengguna
    function useCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                coordinateMap.setView([lat, lng], 15);
            });
        } else {
            alert('Geolocation tidak didukung oleh browser ini.');
        }
    }

    // Fungsi utama untuk inisialisasi peta
    function initCoordinateMap() {
        coordinateMap = L.map('coordinateMap').setView([2.027, 100.975], 14);

        // --- AWAL MODIFIKASI SATELIT ---

        // 1. Definisikan layer Satellite (Esri)
        const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'google'
        });

        // 2. Definisikan layer Street (OpenStreetMap)
        const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        });

        
        // 3. Buat objek untuk control basemap
        const baseMaps = {
            "Satellite": satelliteLayer,
            "Street": osmLayer
            
        };

        // 4. Tambahkan layer default (Street) ke peta
        satelliteLayer.addTo(coordinateMap);

        // 5. Tambahkan control untuk ganti layer ke peta
        L.control.layers(baseMaps).addTo(coordinateMap);

        // --- AKHIR MODIFIKASI SATELIT ---


        // --- Inisialisasi Leaflet.draw ---
        drawnItems = new L.FeatureGroup();
        coordinateMap.addLayer(drawnItems);

        const drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems,
                remove: true
            },
            draw: {
                polygon: true,
                polyline: true,
                marker: true,
                rectangle: false,
                circle: false,
                circlemarker: false
            }
        });
        coordinateMap.addControl(drawControl);

        // --- Event Handlers ---
        coordinateMap.on(L.Draw.Event.CREATED, function(e) {
            const type = e.layerType;
            const layer = e.layer;

            drawnItems.clearLayers();
            drawnItems.addLayer(layer);

            const geojson = layer.toGeoJSON().geometry;
            document.getElementById('geometry').value = JSON.stringify(geojson, null, 2);

            if (type === 'marker') {
                document.getElementById('geometry_type').value = 'point';
            } else if (type === 'polygon') {
                document.getElementById('geometry_type').value = 'polygon';
            } else if (type === 'polyline') {
                document.getElementById('geometry_type').value = 'polyline';
            }
        });

        coordinateMap.on(L.Draw.Event.EDITED, function(e) {
            const layers = e.layers;
            layers.eachLayer(function(layer) {
                const geojson = layer.toGeoJSON().geometry;
                document.getElementById('geometry').value = JSON.stringify(geojson, null, 2);
            });
        });

        coordinateMap.on(L.Draw.Event.DELETED, function(e) {
            document.getElementById('geometry').value = '';
            document.getElementById('geometry_type').value = '';
        });
        
        // --- Memuat data lama ---
        const oldGeometry = document.getElementById('geometry').value;
        if (oldGeometry) {
            try {
                const geojsonData = JSON.parse(oldGeometry);
                const layer = L.geoJSON(geojsonData);
                drawnItems.addLayer(layer);
                if (layer.getBounds) {
                    coordinateMap.fitBounds(layer.getBounds());
                }
            } catch (error) {
                console.error("Gagal mem-parse GeoJSON lama: ", error);
            }
        }
    }

    // Panggil fungsi inisialisasi saat halaman siap
    document.addEventListener('DOMContentLoaded', function() {
        initCoordinateMap();

        // INISIALISASI SELECT2
        $('#user_id').select2({
            theme: "bootstrap-5",
            width: '100%'
        });
    });
</script>
@endsection