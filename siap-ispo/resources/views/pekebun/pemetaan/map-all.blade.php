@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-color: #2c7c3d;
        --secondary-color: #f5a623;
        --light-bg: #f8fafc;
        --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        --hover-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        --text-color: #333;
        --text-muted: #6c757d;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--light-bg);
    }

    main {
        padding: 2rem 0;
    }

    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }

    .card-header-pemetaan {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1a3e23 100%);
        color: white;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .card-header-pemetaan::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: repeating-linear-gradient(
            45deg,
            transparent,
            transparent 10px,
            rgba(255,255,255,0.1) 10px,
            rgba(255,255,255,0.1) 20px
        );
        animation: shimmer 20s linear infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }

    .card-title-pemetaan {
        font-weight: 600;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .badge-pemetaan {
        background-color: var(--secondary-color) !important;
        color: white !important;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 10px;
    }

    .sidebar-card {
        background-color: white;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        height: 75vh;
        overflow-y: auto;
    }

    .map-container {
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        height: 75vh;
    }

    #map {
        width: 100%;
        height: 100%;
    }

    .sidebar-section h5 {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .stat-card-modern {
        background: var(--light-bg);
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        border: 1px solid #eee;
        transition: all 0.3s ease;
    }

    .stat-card-modern:hover {
        transform: translateY(-3px);
        box-shadow: var(--hover-shadow);
    }

    .stat-card-modern .icon {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .stat-card-modern .count {
        font-size: 1.75rem;
        font-weight: 700;
    }

    .stat-card-modern .label {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
    }

    .btn-pemetaan {
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }

    .btn-pemetaan:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .custom-marker-icon i {
        font-size: 2.2rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
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

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .nav-tabs {
        border-bottom: 2px solid var(--primary-color);
    }

    .nav-tabs .nav-link {
        border: none;
        border-radius: 8px 8px 0 0;
        margin-right: 5px;
        color: var(--text-muted);
        font-weight: 600;
    }

    .nav-tabs .nav-link.active {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .nav-tabs .nav-link:hover:not(.active) {
        border-color: transparent;
        background-color: rgba(44, 124, 61, 0.1);
        color: var(--primary-color);
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css"/>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header-pemetaan text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title-pemetaan">
                            <i class="fas fa-globe me-2"></i> Semua Data Perkebunan Sawit
                        </h4>
                        <div class="d-flex align-items-center gap-3">
                            <ul class="nav nav-tabs mb-0" id="viewTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" href="{{ route('pekebun.pemetaan.map-all') }}">
                                        <i class="fas fa-map me-1"></i> Map
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" href="{{ route('pekebun.pemetaan.table-all') }}">
                                        <i class="fas fa-table me-1"></i> Table
                                    </a>
                                </li>
                            </ul>
                            <span class="badge badge-pemetaan">Semua Pekebun</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <section class="p-4">
                        <div class="row g-4">
                            <div class="col-xl-4">
                                <aside class="sidebar-card">
                                    <!-- Filter Pemilik -->
                                    <div class="sidebar-section">
                                        <h5><i class="fas fa-filter me-2"></i>Filter Pemilik</h5>
                                        <select id="ownerFilter" class="form-select">
                                            <option value="">Semua Pemilik</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="sidebar-section">
                                        <h5><i class="fas fa-layer-group me-2"></i>Layer Tampilan</h5>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="layerRadio" id="statusRadio" value="status_ispo" checked />
                                            <label class="form-check-label" for="statusRadio">Status Penilaian ISPO</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="layerRadio" id="readinessRadio" value="tingkat_kesiapan" />
                                            <label class="form-check-label" for="readinessRadio">Tingkat Kesiapan</label>
                                        </div>
                                    </div>

                                    <div class="sidebar-section">
                                        <h5><i class="fas fa-map me-2"></i>Peta Dasar</h5>
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-outline-success btn-sm btn-pemetaan" onclick="changeBaseMap('satellite')">
                                                <i class="fas fa-satellite me-1"></i> Satelit
                                            </button>
                                            <button class="btn btn-outline-secondary btn-sm btn-pemetaan" onclick="changeBaseMap('openstreetmap')">
                                                <i class="fas fa-road me-1"></i> Jalan
                                            </button>
                                        </div>
                                    </div>

                                    <div class="sidebar-section">
                                        <h5><i class="fas fa-chart-pie me-2"></i>Statistik Keseluruhan</h5>
                                        <div class="row g-2">
                                            @php
                                                $kebunSawit = collect($gisData)->where('properties.deskripsi', 'Kebun Sawit');
                                                $totalLulus = $kebunSawit->where('properties.statusISPO', 'Lulus')->count();
                                                $totalProses = $kebunSawit->where('properties.statusISPO', 'Dalam Proses')->count();
                                                $totalPerbaikan = $kebunSawit->where('properties.statusISPO', 'Perlu Perbaikan')->count();
                                                $totalLuas = $kebunSawit->sum('properties.luasLahan');
                                            @endphp
                                            <div class="col-6">
                                                <div class="stat-card-modern">
                                                    <div class="icon text-success"><i class="fas fa-check-circle"></i></div>
                                                    <div class="count" id="lulusCount">{{ $totalLulus }}</div>
                                                    <div class="label">LULUS ISPO</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="stat-card-modern">
                                                    <div class="icon text-warning"><i class="fas fa-spinner"></i></div>
                                                    <div class="count" id="prosesCount">{{ $totalProses }}</div>
                                                    <div class="label">PROSES</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="stat-card-modern">
                                                    <div class="icon text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                                                    <div class="count" id="perbaikanCount">{{ $totalPerbaikan }}</div>
                                                    <div class="label">PERBAIKAN</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="stat-card-modern">
                                                    <div class="icon text-primary"><i class="fas fa-ruler-combined"></i></div>
                                                    <div class="count" id="totalLuas">{{ number_format($totalLuas, 2) }}</div>
                                                    <div class="label">TOTAL HA</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sidebar-section">
                                        <h5><i class="fas fa-info-circle me-2"></i>Legenda</h5>
                                        <div class="legend-item d-flex align-items-center mb-2">
                                            <div class="legend-color" style="width: 20px; height: 20px; background-color: #28a745; border-radius: 3px; margin-right: 10px;"></div>
                                            <span class="small">Lulus ISPO</span>
                                        </div>
                                        <div class="legend-item d-flex align-items-center mb-2">
                                            <div class="legend-color" style="width: 20px; height: 20px; background-color: #ffc107; border-radius: 3px; margin-right: 10px;"></div>
                                            <span class="small">Dalam Proses</span>
                                        </div>
                                        <div class="legend-item d-flex align-items-center mb-2">
                                            <div class="legend-color" style="width: 20px; height: 20px; background-color: #dc3545; border-radius: 3px; margin-right: 10px;"></div>
                                            <span class="small">Perlu Perbaikan</span>
                                        </div>
                                        <div class="legend-item d-flex align-items-center mb-2">
                                            <div class="legend-color" style="width: 20px; height: 20px; background-color: #808080; border-radius: 3px; margin-right: 10px;"></div>
                                            <span class="small">Belum Dinilai</span>
                                        </div>
                                    </div>
                                </aside>
                            </div>
                            <div class="col-xl-8">
                                <section class="map-container">
                                    <div id="map"></div>
                                </section>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>

<script>
    // Data dari backend (server-side)
    const allGisData = @json($gisData);
    let filteredData = [...allGisData];

    let map;
    let featureLayer;
    let currentLayerStyle = "status_ispo";
    let currentBaseMap = "satellite";
    
    const baseMaps = {
        satellite: { 
            url: "https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}", 
            attribution: "© Google" 
        },
        openstreetmap: { 
            url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", 
            attribution: "© OpenStreetMap" 
        },
    };

    function getFeatureStyle(properties) {
        let color = "#808080";
        const type = properties.deskripsi;
        
        if (type === "Kebun Sawit") {
        if (currentLayerStyle === "status_ispo") {
            // STATUS ISPO - TETAP BAGUS SEPERTI SEMULA
            const key = properties.statusISPO;
            const colorMap = { 
                "Lulus": "#28a745", 
                "Perlu Perbaikan": "#dc3545", 
                "Dalam Proses": "#ffc107" 
            };
            color = colorMap[key] || color;
        } else {
            // TINGKAT KESIAPAN - TAMBAH WARNA ABU-ABU UNTUK BELUM DINILAI
            const key = properties.tingkatKesiapan;
            
            // Cek jika tingkat kesiapan null/kosong/belum dinilai
            if (!key || key === "null" || key === "" || key === "N/A") {
                color = "#808080"; // Abu-abu untuk belum dinilai
            } else {
                const colorMap = { 
                    "Siap": "#28a745", 
                    "Belum Siap": "#dc3545", 
                    "Dalam Evaluasi": "#007bff" 
                };
                color = colorMap[key] || "#808080";
            }
        }
    } else if (type === "Titik Kumpul") {
        color = "#6f42c1";
    } else if (type === "Akses Jalan") {
        color = "#fd7e14";
    }
        
        return { 
            color: color, 
            fillColor: color, 
            weight: 3, 
            fillOpacity: 0.6,
            opacity: 0.8
        };
    }

    function convertCoordinates(coords, geometryType) {
        if (geometryType === "point") {
            return [coords[1], coords[0]];
        } else if (geometryType === "polyline") {
            return coords.map(coord => [coord[1], coord[0]]);
        } else if (geometryType === "polygon") {
            const ring = Array.isArray(coords[0][0]) ? coords[0] : coords;
            return ring.map(coord => [coord[1], coord[0]]);
        }
        return coords;
    }

    function initMap() {
        map = L.map("map", { zoomControl: false }).setView([2.05, 100.80], 12);
        L.control.zoom({ position: "bottomright" }).addTo(map);
        updateBaseMap();
        updateFeatures();
    }

    function updateBaseMap() {
        if (map.basemap) map.removeLayer(map.basemap);
        const config = baseMaps[currentBaseMap];
        map.basemap = L.tileLayer(config.url, { 
            attribution: config.attribution, 
            maxZoom: 20 
        }).addTo(map);
    }

    function updateFeatures() {
        if (featureLayer) map.removeLayer(featureLayer);
        featureLayer = L.layerGroup();

        let bounds = L.latLngBounds();
        let hasValidFeatures = false;

        filteredData.forEach((data) => {
            try {
                let feature;
                const style = getFeatureStyle(data.properties);
                const coords = convertCoordinates(data.geometry.coordinates, data.geometryType);

                if (data.geometryType === "polygon") {
                    feature = L.polygon(coords, style);
                    hasValidFeatures = true;
                } else if (data.geometryType === "point") {
                    const icon = L.divIcon({ 
                        className: "custom-marker-icon", 
                        html: `<i class="fas fa-map-pin" style="color: ${style.color};"></i>`, 
                        iconSize: [30, 30], 
                        iconAnchor: [15, 30] 
                    });
                    feature = L.marker(coords, { icon: icon });
                    hasValidFeatures = true;
                } else if (data.geometryType === "polyline") {
                    feature = L.polyline(coords, style);
                    hasValidFeatures = true;
                }

                if (feature) {
                    feature.featureData = data;
                    const p = data.properties;
                    const popupContent = `
                        <div class="p-2" style="min-width: 200px;">
                            <h6 style="color:var(--primary-color); margin-bottom: 8px; font-weight: bold;">
                                ${p.idLahan}
                            </h6>
                            <p class="mb-1 small"><strong>Tipe:</strong> ${p.deskripsi}</p>
                            <p class="mb-1 small"><strong>Pemilik:</strong> ${p.pemilik}</p>
                            <p class="mb-1 small"><strong>Lokasi:</strong> ${p.desa}, ${p.kecamatan}</p>
                            ${p.luasLahan > 0 ? `<p class="mb-1 small"><strong>Luas:</strong> ${p.luasLahan} ha</p>` : ""}
                            ${p.statusISPO !== "N/A" ? `<p class="mb-1 small"><strong>Status ISPO:</strong> <span class="badge bg-${p.statusISPO === 'Lulus' ? 'success' : p.statusISPO === 'Dalam Proses' ? 'warning' : 'danger'}">${p.statusISPO}</span></p>` : ""}
                        </div>
                    `;
                    
                    feature.bindPopup(popupContent);
                    featureLayer.addLayer(feature);
                    
                    if (data.geometryType === "point") {
                        bounds.extend(coords);
                    } else {
                        bounds.extend(coords);
                    }
                }
            } catch (error) {
                console.error('Error rendering feature:', data.properties.idLahan, error);
            }
        });

        featureLayer.addTo(map);

        if (hasValidFeatures && bounds.isValid()) {
            setTimeout(() => {
                map.fitBounds(bounds, { padding: [50, 50], maxZoom: 15 });
            }, 100);
        }
    }

    function changeLayerStyle(style) {
        currentLayerStyle = style;
        updateFeatures();
    }

    function changeBaseMap(mapType) {
        currentBaseMap = mapType;
        updateBaseMap();
    }

    function filterByOwner(ownerId) {
        if (ownerId === "") {
            filteredData = [...allGisData];
        } else {
            filteredData = allGisData.filter(d => d.properties.pemilikId == ownerId);
        }
        updateFeatures();
        updateStatistics();
    }

    function updateStatistics() {
        const kebunData = filteredData.filter((d) => d.properties.deskripsi === "Kebun Sawit");
        const totalLuas = kebunData.reduce((sum, d) => sum + d.properties.luasLahan, 0);
        
        document.getElementById("lulusCount").textContent = 
            kebunData.filter((d) => d.properties.statusISPO === "Lulus").length;
        document.getElementById("prosesCount").textContent = 
            kebunData.filter((d) => d.properties.statusISPO === "Dalam Proses").length;
        document.getElementById("perbaikanCount").textContent = 
            kebunData.filter((d) => d.properties.statusISPO === "Perlu Perbaikan").length;
        document.getElementById("totalLuas").textContent = totalLuas.toFixed(2);
    }

    function zoomToFeature(id) {
        const data = allGisData.find((d) => d.id === id);
        if (!data || !map) return;

        const coords = convertCoordinates(data.geometry.coordinates, data.geometryType);

        if (data.geometryType === "point") {
            map.setView(coords, 16);
        } else {
            const bounds = L.latLngBounds(coords);
            map.fitBounds(bounds, { padding: [50, 50] });
        }

        // Buka popup
        featureLayer.eachLayer((layer) => {
            if (layer.featureData && layer.featureData.id === id) {
                layer.openPopup();
            }
        });
    }

    function checkFocusParameter() {
        const urlParams = new URLSearchParams(window.location.search);
        const focusId = urlParams.get('focus');
        
        if (focusId) {
            setTimeout(() => {
                const featureId = parseInt(focusId);
                zoomToFeature(featureId);
            }, 1000);
        }
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[name="layerRadio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                changeLayerStyle(this.value);
            });
        });

        document.getElementById('ownerFilter').addEventListener('change', function() {
            filterByOwner(this.value);
        });
    });

    // Initialize
    window.onload = function () {
        initMap();
        checkFocusParameter();
    };
</script>

@endsection