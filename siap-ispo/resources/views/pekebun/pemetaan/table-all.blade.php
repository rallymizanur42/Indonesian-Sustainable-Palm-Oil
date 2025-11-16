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
        padding: 1rem;
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
                            <i class="fas fa-table me-2"></i> Semua Data Perkebunan Sawit
                        </h4>
                        <div class="d-flex align-items-center gap-3">
                            <!-- Tab Navigation -->
                            <ul class="nav nav-tabs mb-0" id="viewTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" href="{{ route('pekebun.pemetaan.map-all') }}">
                                        <i class="fas fa-map me-1"></i> Map
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" href="{{ route('pekebun.pemetaan.table-all') }}">
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
                        <!-- Statistics Row -->
                        <div class="stats-row">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="stat-item">
                                        <div class="icon text-primary"><i class="fas fa-seedling"></i></div>
                                        <div class="number" id="totalKebun">{{ $gisData->where('properties.deskripsi', 'Kebun Sawit')->count() }}</div>
                                        <div class="label">Total Kebun</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-item">
                                        <div class="icon text-success"><i class="fas fa-check-circle"></i></div>
                                        <div class="number" id="lulusCount">{{ $gisData->where('properties.statusISPO', 'Lulus')->count() }}</div>
                                        <div class="label">Lulus ISPO</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-item">
                                        <div class="icon text-warning"><i class="fas fa-spinner"></i></div>
                                        <div class="number" id="prosesCount">{{ $gisData->where('properties.statusISPO', 'Dalam Proses')->count() }}</div>
                                        <div class="label">Dalam Proses</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-item">
                                        <div class="icon text-info"><i class="fas fa-expand-arrows-alt"></i></div>
                                        <div class="number" id="totalLuas">{{ number_format($gisData->sum('properties.luasLahan'), 2) }}</div>
                                        <div class="label">Total Luas (Ha)</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="data-card">
                            <h2 class="page-title mb-4">
                                <i class="fas fa-table me-2"></i>Data Spasial Perkebunan - Semua Pekebun
                            </h2>
                            
                            <div class="alert-info-custom">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Info:</strong> Menampilkan data dari seluruh pekebun. Klik tombol "Lihat di Peta" untuk melihat lokasi kebun pada peta interaktif.
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan ID, Pemilik, Desa..."/>
                                </div>
                                <div class="col-md-4">
                                    <select id="ownerFilter" class="form-select">
                                        <option value="">Semua Pemilik</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
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
                                            <th>No</th>
                                            <th>ID Lahan</th>
                                            <th>Pemilik</th>
                                            <th>Tipe</th>
                                            <th>Lokasi</th>
                                            <th>Status ISPO</th>
                                            <th>Luas (ha)</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataTableBody">
                                        @forelse($gisData as $index => $data)
                                            @php
                                                $p = $data['properties'];
                                                $badgeClass = '';
                                                if ($p['statusISPO'] == 'Lulus') $badgeClass = 'bg-success';
                                                elseif ($p['statusISPO'] == 'Dalam Proses') $badgeClass = 'bg-warning text-dark';
                                                elseif ($p['statusISPO'] == 'Perlu Perbaikan') $badgeClass = 'bg-danger';
                                            @endphp
                                            <tr data-owner="{{ $p['pemilik'] }}" data-status="{{ $p['statusISPO'] }}">
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="fw-bold">{{ $p['idLahan'] }}</td>
                                                <td><span class="badge bg-info">{{ $p['pemilik'] }}</span></td>
                                                <td>{{ $p['deskripsi'] }}</td>
                                                <td>{{ $p['desa'] }}, {{ $p['kecamatan'] }}</td>
                                                <td class="text-center">
                                                    @if($p['statusISPO'] !== 'N/A')
                                                        <span class="badge {{ $badgeClass }}">{{ $p['statusISPO'] }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $p['luasLahan'] > 0 ? $p['luasLahan'] : '-' }}</td>
                                                <td class="text-end">
                                                    <a href="{{ route('pekebun.pemetaan.map-all') }}?focus={{ $data['id'] }}" 
                                                       class="btn btn-sm btn-outline-success btn-pemetaan"
                                                       title="Lihat lokasi di peta">
                                                        <i class="fas fa-map-marker-alt me-1"></i> Lihat di Peta
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">Tidak ada data perkebunan</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
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
    function filterTable() {
        const searchText = document.getElementById("searchInput").value.toLowerCase();
        const ownerFilter = document.getElementById("ownerFilter").value;
        const statusFilter = document.getElementById("statusFilter").value;
        const rows = document.querySelectorAll("#dataTableBody tr");

        let visibleCount = 0;
        let visibleLulus = 0;
        let visibleProses = 0;
        let visiblePerbaikan = 0;
        let visibleLuas = 0;

        rows.forEach((row) => {
            // Skip empty state row
            if (row.cells.length < 8) {
                return;
            }

            const idLahan = row.cells[1].textContent.toLowerCase();
            const pemilik = row.getAttribute('data-owner') || '';
            const tipe = row.cells[3].textContent.toLowerCase();
            const lokasi = row.cells[4].textContent.toLowerCase();
            const status = row.getAttribute('data-status') || '';
            const luasText = row.cells[6].textContent.trim();
            const luas = parseFloat(luasText) || 0;

            const matchesSearch = idLahan.includes(searchText) || 
                                  pemilik.toLowerCase().includes(searchText) || 
                                  tipe.includes(searchText) ||
                                  lokasi.includes(searchText);
            const matchesOwner = ownerFilter === "" || pemilik === ownerFilter;
            const matchesStatus = statusFilter === "" || status === statusFilter;
            
            const isVisible = matchesSearch && matchesOwner && matchesStatus;
            row.style.display = isVisible ? "" : "none";

            if (isVisible && tipe.includes('kebun')) {
                visibleCount++;
                visibleLuas += luas;
                if (status === "Lulus") visibleLulus++;
                if (status === "Dalam Proses") visibleProses++;
                if (status === "Perlu Perbaikan") visiblePerbaikan++;
            }
        });

        // Update statistik berdasarkan filter
        document.getElementById("totalKebun").textContent = visibleCount;
        document.getElementById("lulusCount").textContent = visibleLulus;
        document.getElementById("prosesCount").textContent = visibleProses;
        document.getElementById("totalLuas").textContent = visibleLuas.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById("searchInput").addEventListener("input", filterTable);
        document.getElementById("ownerFilter").addEventListener("change", filterTable);
        document.getElementById("statusFilter").addEventListener("change", filterTable);
    });
</script>

@endsection