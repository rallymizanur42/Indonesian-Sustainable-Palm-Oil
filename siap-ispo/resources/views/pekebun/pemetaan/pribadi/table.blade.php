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

    .card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
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

    .data-card {
        background-color: #fff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        margin-top: 2rem;
    }

    .page-title {
        font-weight: 700;
        color: var(--primary-color);
    }

    .table {
        border-collapse: separate;
        border-spacing: 0 8px;
        margin-top: 1rem;
    }

    .table thead th {
        background-color: var(--primary-color);
        color: white;
        border: 0;
        font-weight: 500;
        text-align: center;
    }

    .table tbody tr {
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: var(--hover-shadow);
    }

    .table td, .table th {
        vertical-align: middle;
        padding: 1rem;
        border: none;
    }

    .table thead th:first-child {
        border-radius: 8px 0 0 8px;
    }

    .table thead th:last-child {
        border-radius: 0 8px 8px 0;
    }

    .table .badge {
        font-size: 0.8rem;
        padding: 0.5em 0.8em;
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

    .stats-row {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
        background: white;
        border-radius: 8px;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-3px);
        box-shadow: var(--hover-shadow);
    }

    .stat-item .icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .stat-item .number {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .stat-item .label {
        font-size: 0.9rem;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 500;
    }

    .alert-info-custom {
        background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
        border: 1px solid #b8daff;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
</style>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header-pemetaan text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title-pemetaan">
                            <i class="fas fa-table me-2"></i> Data Perkebunan Sawit
                        </h4>
                        <div class="d-flex align-items-center gap-3">
                            <!-- Tab Navigation -->
                            <ul class="nav nav-tabs mb-0" id="viewTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" href="{{ route('pekebun.pemetaan.map') }}">
                                        <i class="fas fa-map me-1"></i> Map
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" href="{{ route('pekebun.pemetaan.table') }}">
                                        <i class="fas fa-table me-1"></i> Table
                                    </a>
                                </li>
                            </ul>
                            <span class="badge badge-pemetaan">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <section class="p-4">
                        <!-- Statistics Row -->
                        <div class="stats-row">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="stat-item">
                                        <div class="icon text-primary"><i class="fas fa-seedling"></i></div>
                                        <div class="number" id="totalKebun">0</div>
                                        <div class="label">Total Kebun</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-item">
                                        <div class="icon text-success"><i class="fas fa-check-circle"></i></div>
                                        <div class="number" id="lulusCount">0</div>
                                        <div class="label">Lulus ISPO</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-item">
                                        <div class="icon text-warning"><i class="fas fa-spinner"></i></div>
                                        <div class="number" id="prosesCount">0</div>
                                        <div class="label">Dalam Proses</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-item">
                                        <div class="icon text-info"><i class="fas fa-expand-arrows-alt"></i></div>
                                        <div class="number" id="totalLuas">0</div>
                                        <div class="label">Total Luas (Ha)</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="data-card">
                            <h2 class="page-title mb-4">
                                <i class="fas fa-table me-2"></i>Data Spasial Perkebunan
                            </h2>
                            
                            <div class="alert-info-custom">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Info:</strong> Klik tombol "Lihat di Peta" untuk melihat lokasi kebun pada peta interaktif.
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan ID, Desa, atau Kecamatan..."/>
                                </div>
                                <div class="col-md-4">
                                    <select id="statusFilter" class="form-select">
                                        <option value="">Semua Status ISPO</option>
                                        <option value="Lulus">Lulus</option>
                                        <option value="Dalam Proses">Dalam Proses</option>
                                        <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID Lahan</th>
                                            <th>Tipe</th>
                                            <th>Lokasi</th>
                                            <th>Status ISPO</th>
                                            <th>Luas (ha)</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataTableBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // DATA DIAMBIL SECARA DINAMIS DARI CONTROLLER LARAVEL
    const gisData = @json($gisData);

    function populateTable() {
        const tableBody = document.getElementById("dataTableBody");
        tableBody.innerHTML = "";
        const badgeClass = { Lulus: "bg-success", "Dalam Proses": "bg-warning text-dark", "Perlu Perbaikan": "bg-danger" };

        gisData.forEach((data) => {
            const p = data.properties;
            const row = `<tr>
                <td class="fw-bold text-center">${p.idLahan}</td>
                <td class="text-center">${p.deskripsi}</td>
                <td>${p.desa}, ${p.kecamatan}</td>
                <td class="text-center">
                    <span class="badge ${badgeClass[p.statusISPO] || "d-none"}">${p.statusISPO}</span>
                </td>
                <td class="text-center">${p.luasLahan > 0 ? p.luasLahan : "-"}</td>
                <td class="text-end">
                    <a href="{{ route('pekebun.pemetaan.map') }}?focus=${data.id}" class="btn btn-sm btn-outline-success btn-pemetaan">
                        <i class="fas fa-map-marker-alt me-1"></i> Lihat di Peta
                    </a>
                </td>
            </tr>`;
            tableBody.insertAdjacentHTML("beforeend", row);
        });
    }

    function filterTable() {
        const searchText = document.getElementById("searchInput").value.toLowerCase();
        const statusFilter = document.getElementById("statusFilter").value;
        const rows = document.querySelectorAll("#dataTableBody tr");

        rows.forEach((row) => {
            const idLahan = row.cells[0].textContent.toLowerCase();
            const lokasi = row.cells[2].textContent.toLowerCase();
            const status = row.cells[3].textContent;
            const matchesSearch = idLahan.includes(searchText) || lokasi.includes(searchText);
            const matchesStatus = statusFilter === "" || status === statusFilter;
            row.style.display = matchesSearch && matchesStatus ? "" : "none";
        });
    }

    function initStatistics() {
        const kebunData = gisData.filter((d) => d.properties.deskripsi === "Kebun Sawit");
        const totalLuas = kebunData.reduce((sum, d) => sum + d.properties.luasLahan, 0);
        
        document.getElementById("totalKebun").textContent = kebunData.length;
        document.getElementById("lulusCount").textContent = kebunData.filter((d) => d.properties.statusISPO === "Lulus").length;
        document.getElementById("prosesCount").textContent = kebunData.filter((d) => d.properties.statusISPO === "Dalam Proses").length;
        document.getElementById("totalLuas").textContent = totalLuas.toFixed(2);
    }

    window.onload = function () {
        initStatistics();
        populateTable();
        document.getElementById("searchInput").addEventListener("input", filterTable);
        document.getElementById("statusFilter").addEventListener("change", filterTable);
    };
</script>

@endsection