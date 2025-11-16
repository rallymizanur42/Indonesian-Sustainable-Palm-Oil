@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-color: #2c7c3d;
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
    
    .score-badge {
        font-size: 1.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
    }
    
    .kriteria-item {
        border-left: 4px solid var(--primary-color);
        padding-left: 1rem;
        margin-bottom: 1rem;
    }
    
    .progress {
        height: 25px;
    }
    
    .prinsip-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
</style>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-lg">
                {{-- Header --}}
                <div class="card-header-pemetaan text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-file-alt me-2"></i> Detail Analisis DSS
                            </h4>
                            <p class="mb-0 opacity-75 small">
                                Analisis ID: {{ $riwayat->id }} | 
                                Tanggal: {{ $riwayat->tanggal_analisis->format('d F Y H:i') }}
                            </p>
                        </div>
                        <div class="text-end">
                            @if(Auth::user()->role === 'pekebun')
                                <a href="{{ route('pekebun.dss.index') }}" class="btn btn-light">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </a>
                            @else
                                <a href="{{ route('admin.dss.riwayat') }}" class="btn btn-light">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- Informasi Umum --}}
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="text-primary">{{ number_format($skorAkhir, 1) }}%</h3>
                                    <p class="mb-0">Skor Akhir</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="text-info">{{ count($detailKriteria) }}</h3>
                                    <p class="mb-0">Total Kriteria</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="text-success">
                                        {{ $riwayat->pemetaanLahan->tingkat_kesiapan ?? 'N/A' }}
                                    </h3>
                                    <p class="mb-0">Tingkat Kesiapan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="text-warning">
                                        {{ $riwayat->pemetaanLahan->status_ispo ?? 'N/A' }}
                                    </h3>
                                    <p class="mb-0">Status ISPO</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Informasi Lahan --}}
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-map-marker-alt me-2"></i> Informasi Lahan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>ID Lahan:</strong> {{ $riwayat->pemetaanLahan->id_lahan ?? 'N/A' }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Lokasi:</strong> 
                                            {{ $riwayat->pemetaanLahan->desa ?? '' }}, 
                                            {{ $riwayat->pemetaanLahan->kecamatan ?? '' }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Luas:</strong>
                                            {{ $riwayat->pemetaanLahan->luas ?? 'N/A' }} Ha
                                        </div>
                                    </div>
                                    @if(Auth::user()->role === 'admin')
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <strong>Pemilik:</strong> 
                                            {{ $riwayat->user->name ?? 'N/A' }} ({{ $riwayat->user->email ?? 'N/A' }})
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Per Kriteria --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-list-alt me-2"></i> Detail Penilaian Kriteria
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @php
                                        $groupedKriteria = collect($detailKriteria)->groupBy('prinsip');
                                    @endphp

                                    @if(count($detailKriteria) > 0)
                                        @foreach($groupedKriteria as $prinsip => $kriteriaList)
                                        <div class="prinsip-section">
                                            <h6 class="fw-bold text-primary mb-3">
                                                <i class="fas fa-folder me-1"></i>{{ $prinsip }}
                                            </h6>
                                            
                                            @foreach($kriteriaList as $kriteria)
                                            <div class="kriteria-item">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold mb-1">{{ $kriteria['kode'] }}: {{ $kriteria['nama'] }}</h6>
                                                        <small class="text-muted">Bobot: {{ $kriteria['bobot'] }}%</small>
                                                        <div class="mt-2">
                                                            <span class="badge bg-{{ $kriteria['level_kesiapan'] == 'tinggi' ? 'success' : ($kriteria['level_kesiapan'] == 'sedang' ? 'warning' : 'danger') }}">
                                                                {{ $kriteria['level_kesiapan'] }}
                                                            </span>
                                                            <small class="text-muted ms-2">{{ $kriteria['rekomendasi_text'] }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1 me-3">
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-{{ $kriteria['nilai'] >= 80 ? 'success' : ($kriteria['nilai'] >= 60 ? 'warning' : 'danger') }}" 
                                                                         style="width: {{ $kriteria['nilai'] }}%">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="fw-bold" style="min-width: 50px;">
                                                                {{ $kriteria['nilai'] }}%
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">Skor: {{ number_format($kriteria['skor'], 2) }}%</small>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            Tidak ada data penilaian kriteria yang ditemukan untuk analisis ini.
                                            <br>
                                            <small>Skor akhir: {{ $skorAkhir }}%</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Rekomendasi --}}
                    @if($riwayat->rekomendasi_text)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0">
                                        <i class="fas fa-lightbulb me-2"></i> Rekomendasi
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @php
                                        $rekomendasiList = explode(' | ', $riwayat->rekomendasi_text);
                                    @endphp
                                    <ul class="list-unstyled">
                                        @foreach($rekomendasiList as $rekomendasi)
                                            @if(trim($rekomendasi))
                                            <li class="mb-2">
                                                <i class="fas fa-arrow-right text-primary me-2"></i>
                                                {{ trim($rekomendasi) }}
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection