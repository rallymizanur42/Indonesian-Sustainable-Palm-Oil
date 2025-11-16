@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-color: #2c7c3d;
        --secondary-color: #f5a623;
        --light-bg: #f8fafc;
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
    .detail-card {
        border-left: 4px solid var(--primary-color);
    }
    .info-label {
        font-weight: 600;
        color: #495057;
        min-width: 150px;
    }
    .info-value {
        color: #6c757d;
    }
    .badge-status {
        font-size: 0.9em;
        padding: 0.5em 1em;
    }
    .map-container {
        height: 400px;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #e9ecef;
        background-color: #f8f9fa;
    }

    #detailMap {
        width: 100%;
        height: 100%;
    }

    .layer-controls {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1000;
        background: rgba(255, 255, 255, 0.95);
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        border: 1px solid #ddd;
    }

    .layer-btn {
        margin: 2px;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        background: white;
        transition: all 0.3s ease;
    }

    .layer-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .layer-btn:hover {
        background: #f8f9fa;
    }
</style>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-header-pemetaan d-flex justify-content-between align-items-center">
                    <h4 class="card-title-pemetaan">
                        <i class="fas fa-eye me-2"></i> Detail Data Pemetaan: {{ $perkebunan->id_lahan }}
                    </h4>
                    <div>
                        <a href="{{ route('admin.pemetaan.index') }}" class="btn btn-light btn-sm me-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <a href="{{ route('admin.pemetaan.edit', $perkebunan->id) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit me-2"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i> Hapus
                        </button>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Informasi Dasar -->
                        <div class="col-md-6">
                            <div class="card detail-card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-info-circle me-2 text-primary"></i>
                                        Informasi Dasar
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-4 info-label">ID Lahan</div>
                                        <div class="col-sm-8 info-value fw-bold text-primary">{{ $perkebunan->id_lahan }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4 info-label">Deskripsi</div>
                                        <div class="col-sm-8 info-value">{{ $perkebunan->deskripsi }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4 info-label">Lokasi</div>
                                        <div class="col-sm-8 info-value">{{ $perkebunan->desa }}, {{ $perkebunan->kecamatan }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4 info-label">Pemilik</div>
                                        <div class="col-sm-8 info-value">
                                            @if($perkebunan->pekebun)
                                                {{ $perkebunan->pekebun->name }} ({{ $perkebunan->pekebun->email }})
                                            @else
                                                <span class="text-muted">Admin</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4 info-label">Luas Lahan</div>
                                        <div class="col-sm-8 info-value">{{ number_format($perkebunan->luas_lahan, 2) }} ha</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status dan Kesiapan -->
                        <div class="col-md-6">
                            <div class="card detail-card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-chart-line me-2 text-primary"></i>
                                        Status & Kesiapan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-4 info-label">Status ISPO</div>
                                        <div class="col-sm-8">
                                            @php
                                                $statusClass = '';
                                                if ($perkebunan->status_ispo == 'Lulus') $statusClass = 'bg-success';
                                                elseif ($perkebunan->status_ispo == 'Dalam Proses') $statusClass = 'bg-warning text-dark';
                                                elseif ($perkebunan->status_ispo == 'Perlu Perbaikan') $statusClass = 'bg-danger';
                                                else $statusClass = 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $statusClass }} badge-status">{{ $perkebunan->status_ispo }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4 info-label">Tingkat Kesiapan</div>
                                        <div class="col-sm-8">
                                            @php
                                                $kesiapanClass = '';
                                                if ($perkebunan->tingkat_kesiapan == 'Siap') $kesiapanClass = 'bg-success';
                                                elseif ($perkebunan->tingkat_kesiapan == 'Dalam Evaluasi') $kesiapanClass = 'bg-warning text-dark';
                                                elseif ($perkebunan->tingkat_kesiapan == 'Belum Siap') $kesiapanClass = 'bg-danger';
                                                else $kesiapanClass = 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $kesiapanClass }} badge-status">{{ $perkebunan->tingkat_kesiapan }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4 info-label">Tipe Geometri</div>
                                        <div class="col-sm-8 info-value text-capitalize">{{ $perkebunan->geometry_type }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4 info-label">Dibuat Pada</div>
                                        <div class="col-sm-8 info-value">{{ $perkebunan->created_at->format('d F Y H:i') }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4 info-label">Diupdate Pada</div>
                                        <div class="col-sm-8 info-value">{{ $perkebunan->updated_at->format('d F Y H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Peta dan Data Spasial -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card detail-card">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-map-marked-alt me-2 text-primary"></i>
                                        Data Spasial
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="map-container mb-3 position-relative">
                                                <div id="detailMap"></div>
                                                <div class="layer-controls">
                                                    <button class="layer-btn active" onclick="switchLayer('satellite')">Satelit</button>
                                                    <button class="layer-btn" onclick="switchLayer('street')">Jalan</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Data Geometry (GeoJSON)</label>
                                                <pre class="bg-light p-3 rounded" style="font-size: 0.8rem; max-height: 300px; overflow-y: auto;"><code id="geometryData">{{ json_encode($perkebunan->geometry, JSON_PRETTY_PRINT) }}</code></pre>
                                            </div>
                                            <div class="alert alert-info">
                                                <small>
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    Data spasial dalam format GeoJSON. Gunakan kontrol layer untuk beralih antara peta satelit dan peta jalan.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form untuk delete -->
<form id="deleteForm" action="{{ route('admin.pemetaan.destroy', $perkebunan->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let map;
    let geoJsonLayer;
    let satelitLayer, streetLayer;
    let currentLayer = 'satellite';

    // Initialize map
    function initDetailMap() {
        console.log('Initializing detail map...');
        
        const defaultLat = 2.05;
        const defaultLng = 100.80;
        const defaultZoom = 12;

        map = L.map('detailMap').setView([defaultLat, defaultLng], defaultZoom);
        initLayers();
        L.control.scale({ imperial: false }).addTo(map);
        processAndDisplayGeometry();

        map.on('click', function(e) {
            const popup = L.popup()
                .setLatLng(e.latlng)
                .setContent(`
                    <div class="text-center">
                        <strong>Koordinat Diklik</strong><br>
                        Lat: ${e.latlng.lat.toFixed(6)}<br>
                        Lng: ${e.latlng.lng.toFixed(6)}
                    </div>
                `)
                .openOn(map);
        });
    }

    // Initialize layers
    function initLayers() {
        satelitLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, Maxar, Earthstar Geographics, and the GIS User Community',
            maxZoom: 19
        });
        streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        });
        satelitLayer.addTo(map);
    }

    // Process and display geometry
    function processAndDisplayGeometry() {
        try {
            let rawData = {!! json_encode($perkebunan->geometry) !!};
            
            console.log('===== GEOMETRY PROCESSING START =====');
            console.log('Raw Data from Laravel:', rawData);
            
            if (!rawData) {
                console.error('❌ Geometry data is null or undefined');
                showFallbackMarker();
                return;
            }
            
            let geometryData = rawData;
            
            if (typeof geometryData === 'string') {
                console.log('📝 Geometry is string, attempting to parse...');
                try {
                    let cleanedString = geometryData.replace(/\\/g, '');
                    geometryData = JSON.parse(cleanedString);
                    console.log('✅ Successfully parsed to:', geometryData);
                } catch (e) {
                    console.error('❌ Error parsing geometry string:', e);
                    try {
                        geometryData = JSON.parse(JSON.parse(geometryData));
                        console.log('✅ Double parse successful:', geometryData);
                    } catch (e2) {
                        console.error('❌ Double parse also failed:', e2);
                        showFallbackMarker();
                        return;
                    }
                }
            }
            
            if (!geometryData || typeof geometryData !== 'object') {
                console.error('❌ Invalid geometry data structure - not an object');
                showFallbackMarker();
                return;
            }
            
            geometryData = validateAndFixGeometry(geometryData);
            
            if (geometryData && geometryData.type && geometryData.coordinates) {
                console.log('✅ Valid geometry data found, displaying on map');
                displayGeometryOnMap(geometryData);
            } else {
                console.warn('⚠️ No valid geometry data after validation');
                showFallbackMarker();
            }
            
            console.log('===== GEOMETRY PROCESSING END =====');
        } catch (error) {
            console.error('❌ Error processing geometry:', error);
            showFallbackMarker();
        }
    }

    // Validate and fix geometry data
    function validateAndFixGeometry(geometry) {
        if (!geometry || !geometry.type) {
            console.error('Missing geometry or geometry.type');
            return null;
        }

        console.log('Validating geometry type:', geometry.type);
        console.log('Original coordinates:', JSON.stringify(geometry.coordinates));

        try {
            switch(geometry.type.toLowerCase()) {
                case 'point':
                    if (Array.isArray(geometry.coordinates) && 
                        geometry.coordinates.length === 2 &&
                        typeof geometry.coordinates[0] === 'number' &&
                        typeof geometry.coordinates[1] === 'number') {
                        console.log('✓ Valid Point geometry');
                        return geometry;
                    }
                    console.error('✗ Invalid Point coordinates');
                    break;
                    
                case 'polygon':
                    if (!Array.isArray(geometry.coordinates)) {
                        console.error('✗ Polygon coordinates must be an array');
                        return null;
                    }
                    
                    let rings = geometry.coordinates;
                    
                    if (rings.length > 0 && 
                        Array.isArray(rings[0]) && 
                        rings[0].length === 2 && 
                        typeof rings[0][0] === 'number') {
                        console.log('→ Fixing: Single ring without outer array');
                        rings = [rings];
                    }
                    
                    rings = rings.map((ring, ringIndex) => {
                        if (!Array.isArray(ring)) {
                            console.error(`✗ Ring ${ringIndex} is not an array`);
                            return null;
                        }
                        
                        const validCoords = ring.filter((coord, coordIndex) => {
                            const isValid = Array.isArray(coord) && 
                                coord.length === 2 &&
                                typeof coord[0] === 'number' &&
                                typeof coord[1] === 'number';
                            
                            if (!isValid) {
                                console.warn(`Invalid coord at ring ${ringIndex}, index ${coordIndex}:`, coord);
                            }
                            return isValid;
                        });
                        
                        if (validCoords.length < 3) {
                            console.error(`✗ Ring ${ringIndex} has less than 3 valid coordinates`);
                            return null;
                        }
                        
                        const first = validCoords[0];
                        const last = validCoords[validCoords.length - 1];
                        
                        if (first[0] !== last[0] || first[1] !== last[1]) {
                            console.log(`→ Closing ring ${ringIndex}`);
                            validCoords.push([first[0], first[1]]);
                        }
                        
                        return validCoords;
                    }).filter(ring => ring !== null);
                    
                    if (rings.length === 0) {
                        console.error('✗ No valid rings found');
                        return null;
                    }
                    
                    geometry.coordinates = rings;
                    console.log('✓ Fixed Polygon coordinates:', JSON.stringify(geometry.coordinates));
                    return geometry;
                
                // --- AWAL PERBAIKAN ---
                case 'polyline': // Menangkap 'polyline'
                case 'linestring': // Menangkap 'LineString'
                    if (Array.isArray(geometry.coordinates) && 
                        geometry.coordinates.length >= 2) {
                        
                        const validCoords = geometry.coordinates.filter(coord =>
                            Array.isArray(coord) &&
                            coord.length === 2 &&
                            typeof coord[0] === 'number' &&
                            typeof coord[1] === 'number'
                        );
                        
                        if (validCoords.length >= 2) {
                            geometry.coordinates = validCoords;
                            geometry.type = 'LineString'; // Normalkan tipe
                            console.log('✓ Valid LineString/Polyline geometry');
                            return geometry;
                        }
                    }
                    console.error('✗ Invalid LineString/Polyline coordinates');
                    break;
                // --- AKHIR PERBAIKAN ---
                    
                default:
                    console.error('✗ Unsupported geometry type:', geometry.type);
            }
        } catch (error) {
            console.error('Error in validateAndFixGeometry:', error);
        }
        
        return null;
    }

    // Switch between layers
    function switchLayer(layerType) {
        if (currentLayer === 'satellite') {
            map.removeLayer(satelitLayer);
        } else {
            map.removeLayer(streetLayer);
        }

        if (layerType === 'satellite') {
            satelitLayer.addTo(map);
            currentLayer = 'satellite';
        } else {
            streetLayer.addTo(map);
            currentLayer = 'street';
        }

        document.querySelectorAll('.layer-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
    }

    function displayGeometryOnMap(geometryData) {
        console.log('===== DISPLAYING ON MAP =====');
        console.log('Geometry to display:', geometryData);

        if (geoJsonLayer) {
            map.removeLayer(geoJsonLayer);
        }

        let geojson;
        if (geometryData.type === 'Feature' || geometryData.type === 'FeatureCollection') {
            geojson = geometryData;
        } else {
            geojson = {
                type: 'Feature',
                geometry: geometryData,
                properties: {}
            };
        }

        const getStyle = (type) => {
            const baseStyle = { weight: 3, opacity: 0.8, fillOpacity: 0.4 };
            if (type === 'Point') return { radius: 10, fillColor: '#ff4444', color: '#ff0000', weight: 2, fillOpacity: 0.8 };
            if (type === 'Polygon') return { ...baseStyle, color: '#2c7c3d', fillColor: '#2c7c3d', weight: 4 };
            if (type === 'LineString') return { ...baseStyle, color: '#ff8800', weight: 4 }; // <-- 'LineString' sudah benar
            return baseStyle;
        };

        const pointToLayer = (feature, latlng) => {
            if (feature.geometry && feature.geometry.type === 'Point') {
                return L.circleMarker(latlng, getStyle('Point'));
            }
            return L.marker(latlng);
        };

        try {
            geoJsonLayer = L.geoJSON(geojson, {
                style: (feature) => getStyle(feature.geometry?.type),
                pointToLayer,
                onEachFeature: (feature, layer) => {
                    if (feature.geometry && feature.geometry.type) {
                        const type = feature.geometry.type;
                        layer.bindPopup(`<strong>Tipe:</strong> ${type}`);
                    }
                }
            }).addTo(map);

            map.fitBounds(geoJsonLayer.getBounds());
        } catch (error) {
            console.error('❌ Error creating GeoJSON layer:', error);
            showFallbackMarker();
        }
    }

    // (Fungsi setViewFromGeometry dan calculateArea tidak terpakai di alur ini, tapi tidak masalah)

    // Helper function untuk fallback marker
    function showFallbackMarker() {
        console.log('Showing fallback marker');
        const defaultLat = 2.05; // Rokan Hilir default
        const defaultLng = 100.80;
        
        const marker = L.circleMarker([defaultLat, defaultLng], {
            radius: 10,
            fillColor: '#ff4444',
            color: '#ff0000',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.8
        })
        .addTo(map)
        .bindPopup(`
            <div class="p-2">
                <h6 class="fw-bold text-warning">Lokasi Lahan</h6>
                <hr>
                <p class="mb-1"><strong>ID Lahan:</strong> {{ $perkebunan->id_lahan }}</p>
                <p class="mb-1"><strong>Lokasi:</strong> {{ $perkebunan->desa }}, {{ $perkebunan->kecamatan }}</p>
                <p class="mb-0 text-danger"><strong>Catatan:</strong> Data koordinat tidak valid, menampilkan lokasi default Rokan Hilir</p>
            </div>
        `)
        .openPopup();
        
        map.setView([defaultLat, defaultLng], 12);
    }

    // Confirm delete function
    function confirmDelete() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            html: `Data <strong>{{ $perkebunan->id_lahan }}</strong> akan dihapus permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    }

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing detail map...');
        setTimeout(() => {
            initDetailMap();
        }, 100);
    });
</script>
@endsection