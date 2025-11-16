@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-color: #2c7c3d;
        --secondary-color: #f5a623;
        --light-bg: #f8fafc;
        --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        --hover-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
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
        background: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,0.1) 10px, rgba(255,255,255,0.1) 20px);
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
    
    .table th {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        border: none;
    }
    
    .table td {
        vertical-align: middle;
        border-color: #e9ecef;
    }
    
    .badge-score {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
    }
    
    .status-badge {
        font-size: 0.8rem;
        padding: 0.4rem 0.75rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .riwayat-item:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease;
    }
    
    .pagination .page-link {
        color: var(--primary-color);
        border-color: #dee2e6;
    }
    
    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .filter-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
</style>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg">
                {{-- Header --}}
                <div class="card-header-pemetaan text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title-pemetaan">
                                <i class="fas fa-history me-2"></i> Riwayat Analisis DSS
                            </h4>
                            <p class="mb-0 opacity-75 small">Halo, {{ Auth::user()->name }}! Berikut adalah riwayat lengkap analisis ISPO Anda.</p>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('pekebun.dss.index') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-2"></i> Kembali ke DSS
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Filter Section --}}
                <div class="card-body">
                    <div class="filter-section">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h6 class="mb-0 text-primary">
                                    <i class="fas fa-filter me-2"></i>Total Riwayat: {{ $riwayat->total() }} Analisis
                                </h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <small class="text-muted">
                                    Menampilkan {{ $riwayat->firstItem() ?? 0 }} - {{ $riwayat->lastItem() ?? 0 }} dari {{ $riwayat->total() }} riwayat
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Tabel Riwayat --}}
                    @if($riwayat->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="50">#</th>
                                        <th width="120">Tanggal</th>
                                        <th>Lahan</th>
                                        <th width="120" class="text-center">Skor Akhir</th>
                                        <th width="120" class="text-center">Tingkat Kesiapan</th>
                                        <th width="120" class="text-center">Status ISPO</th>
                                        <th width="100" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayat as $item)
                                    <tr class="riwayat-item">
                                        <td class="fw-bold text-muted">
                                            {{ $loop->iteration + ($riwayat->currentPage() - 1) * $riwayat->perPage() }}
                                        </td>
                                        <td>
                                            <small class="text-muted d-block">{{ $item->tanggal_analisis->format('d/m/Y') }}</small>
                                            <small class="text-muted">{{ $item->tanggal_analisis->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $item->pemetaanLahan->id_lahan ?? 'N/A' }}</div>
                                            <small class="text-muted">
                                                {{ $item->pemetaanLahan->desa ?? '' }}, {{ $item->pemetaanLahan->kecamatan ?? '' }}
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $scoreColor = $item->skor_akhir >= 80 ? 'success' : ($item->skor_akhir >= 60 ? 'warning' : 'danger');
                                            @endphp
                                            <span class="badge badge-score bg-{{ $scoreColor }}">
                                                {{ $item->skor_akhir }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $tingkatColor = $item->pemetaanLahan->tingkat_kesiapan == 'Sangat Siap' ? 'success' : 
                                                              ($item->pemetaanLahan->tingkat_kesiapan == 'Siap' ? 'primary' : 
                                                              ($item->pemetaanLahan->tingkat_kesiapan == 'Cukup Siap' ? 'warning' : 
                                                              ($item->pemetaanLahan->tingkat_kesiapan == 'Kurang Siap' ? 'info' : 'danger')));
                                            @endphp
                                            <span class="badge status-badge bg-{{ $tingkatColor }}">
                                                {{ $item->pemetaanLahan->tingkat_kesiapan ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $statusColor = $item->pemetaanLahan->status_ispo == 'Lulus' ? 'success' : 
                                                             ($item->pemetaanLahan->status_ispo == 'Dalam Proses' ? 'warning' : 'danger');
                                            @endphp
                                            <span class="badge status-badge bg-{{ $statusColor }}">
                                                {{ $item->pemetaanLahan->status_ispo ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('pekebun.dss.riwayat.detail', $item->id) }}" 
                                                   class="btn btn-sm btn-primary" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-secondary" 
                                                        title="Rekomendasi"
                                                        onclick="showRekomendasi('{{ addslashes($item->rekomendasi_text) }}')">
                                                    <i class="fas fa-lightbulb"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Menampilkan <strong>{{ $riwayat->firstItem() }}</strong> - <strong>{{ $riwayat->lastItem() }}</strong> dari <strong>{{ $riwayat->total() }}</strong> riwayat
                            </div>
                            <div>
                                {{ $riwayat->links() }}
                            </div>
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h4>Belum Ada Riwayat Analisis</h4>
                            <p class="mb-4">Anda belum melakukan analisis DSS. Mulai analisis pertama Anda untuk melihat riwayat di sini.</p>
                            <a href="{{ route('pekebun.dss.index') }}" class="btn btn-primary">
                                <i class="fas fa-calculator me-2"></i> Mulai Analisis DSS
                            </a>
                        </div>
                    @endif

                    {{-- Statistik Ringkas --}}
                    @if($riwayat->count() > 0)
    @foreach($riwayat as $item)
    <tr class="riwayat-item">
        <td class="fw-bold text-muted">
            {{ $loop->iteration + ($riwayat->currentPage() - 1) * $riwayat->perPage() }}
        </td>
        <td>
            <small class="text-muted d-block">{{ $item->tanggal_analisis->format('d/m/Y') }}</small>
            <small class="text-muted">{{ $item->tanggal_analisis->format('H:i') }}</small>
        </td>
        <td>
            <div class="fw-bold">{{ $item->pemetaanLahan->id_lahan ?? 'N/A' }}</div>
            <small class="text-muted">
                {{ $item->pemetaanLahan->desa ?? '' }}, {{ $item->pemetaanLahan->kecamatan ?? '' }}
            </small>
        </td>
        <td class="text-center">
            @php
                $scoreColor = $item->skor_akhir >= 80 ? 'success' : ($item->skor_akhir >= 60 ? 'warning' : 'danger');
            @endphp
            <span class="badge badge-score bg-{{ $scoreColor }}">
                {{ $item->skor_akhir }}%
            </span>
        </td>
        <td class="text-center">
            @php
                $tingkatColor = $item->pemetaanLahan->tingkat_kesiapan == 'Sangat Siap' ? 'success' : 
                              ($item->pemetaanLahan->tingkat_kesiapan == 'Siap' ? 'primary' : 
                              ($item->pemetaanLahan->tingkat_kesiapan == 'Cukup Siap' ? 'warning' : 
                              ($item->pemetaanLahan->tingkat_kesiapan == 'Kurang Siap' ? 'info' : 'danger')));
            @endphp
            <span class="badge status-badge bg-{{ $tingkatColor }}">
                {{ $item->pemetaanLahan->tingkat_kesiapan ?? 'N/A' }}
            </span>
        </td>
        <td class="text-center">
            @php
                $statusColor = $item->pemetaanLahan->status_ispo == 'Lulus' ? 'success' : 
                             ($item->pemetaanLahan->status_ispo == 'Dalam Proses' ? 'warning' : 'danger');
            @endphp
            <span class="badge status-badge bg-{{ $statusColor }}">
                {{ $item->pemetaanLahan->status_ispo ?? 'N/A' }}
            </span>
        </td>
        <td class="text-center">
            <div class="btn-group" role="group">
                <a href="{{ route('pekebun.dss.riwayat.detail', $item->id) }}" 
                   class="btn btn-sm btn-primary" 
                   title="Lihat Detail">
                    <i class="fas fa-eye"></i>
                </a>
                <button type="button" 
                        class="btn btn-sm btn-outline-secondary" 
                        title="Rekomendasi"
                        onclick="showRekomendasi('{{ addslashes($item->rekomendasi_text ?? '') }}')">
                    <i class="fas fa-lightbulb"></i>
                </button>
            </div>
        </td>
    </tr>
    @endforeach
@endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Rekomendasi -->
<div class="modal fade" id="rekomendasiModal" tabindex="-1" aria-labelledby="rekomendasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="rekomendasiModalLabel">
                    <i class="fas fa-lightbulb me-2"></i>Rekomendasi Analisis
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="rekomendasiContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showRekomendasi(rekomendasiText) {
        const modal = new bootstrap.Modal(document.getElementById('rekomendasiModal'));
        const contentDiv = document.getElementById('rekomendasiContent');
        
        // Format rekomendasi text
        let formattedContent = '';
        if (rekomendasiText) {
            const recommendations = rekomendasiText.split(' | ');
            formattedContent = recommendations.map(rec => {
                // Tambahkan icon berdasarkan jenis rekomendasi
                let icon = 'fas fa-info-circle';
                if (rec.includes('🎉')) icon = 'fas fa-check-circle text-success';
                else if (rec.includes('✅')) icon = 'fas fa-thumbs-up text-primary';
                else if (rec.includes('⚠️')) icon = 'fas fa-exclamation-triangle text-warning';
                else if (rec.includes('🔧')) icon = 'fas fa-tools text-info';
                
                return `
                    <div class="d-flex align-items-start mb-3">
                        <i class="${icon} me-3 mt-1"></i>
                        <div class="flex-grow-1">
                            ${rec.replace(/🎉|✅|⚠️|🔧/g, '')}
                        </div>
                    </div>
                `;
            }).join('');
        } else {
            formattedContent = '<p class="text-muted">Tidak ada rekomendasi tersedia untuk analisis ini.</p>';
        }
        
        contentDiv.innerHTML = formattedContent;
        modal.show();
    }

    // Tambahkan efek hover pada baris tabel
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.riwayat-item');
        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    });
</script>
@endsection