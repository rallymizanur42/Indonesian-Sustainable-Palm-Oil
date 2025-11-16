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
    .detail-item {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #eee;
    }
    .detail-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .detail-value {
        color: #555;
        font-size: 1rem;
    }
    .badge-jenis {
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
    }
    .badge-benefit {
        background-color: #28a745;
        color: white;
    }
    .badge-cost {
        background-color: #dc3545;
        color: white;
    }
    .indikator-list {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
    }
    .indikator-item {
        padding: 0.5rem 0;
        border-bottom: 1px solid #e9ecef;
    }
    .indikator-item:last-child {
        border-bottom: none;
    }
    .text-bobot {
        font-size: 1.25rem;
        font-weight: 600;
    }
</style>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-header-pemetaan d-flex justify-content-between align-items-center">
                    <h4 class="card-title-pemetaan">
                        <i class="fas fa-eye me-2"></i> Detail Kriteria - {{ $kriteria->kode_kriteria }}
                    </h4>
                    <a href="{{ route('admin.kriteria.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">Kode Kriteria</div>
                                <div class="detail-value fs-5 fw-bold text-primary">{{ $kriteria->kode_kriteria }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Nama Kriteria</div>
                                <div class="detail-value fs-5">{{ $kriteria->nama_kriteria }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Prinsip</div>
                                <div class="detail-value">
                                    <span class="badge bg-secondary">{{ $kriteria->prinsip }}</span>
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Jenis Kriteria</div>
                                <div class="detail-value">
                                    @if($kriteria->jenis == 'benefit')
                                        <span class="badge badge-jenis badge-benefit">
                                            <i class="fas fa-chart-line me-1"></i> Benefit
                                        </span>
                                    @else
                                        <span class="badge badge-jenis badge-cost">
                                            <i class="fas fa-chart-bar me-1"></i> Cost
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Bobot</div>
                                <div class="detail-value">
                                    <span class="text-bobot text-primary">{{ number_format($kriteria->bobot, 2) }}%</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            @if($kriteria->verifier)
                            <div class="detail-item">
                                <div class="detail-label">Verifier</div>
                                <div class="detail-value">{{ $kriteria->verifier }}</div>
                            </div>
                            @endif
                            
                            @if($kriteria->deskripsi)
                            <div class="detail-item">
                                <div class="detail-label">Deskripsi</div>
                                <div class="detail-value">{{ $kriteria->deskripsi }}</div>
                            </div>
                            @endif
                            
                            <div class="detail-item">
                                <div class="detail-label">Dibuat Pada</div>
                                <div class="detail-value">
                                    <i class="far fa-calendar me-2"></i>
                                    {{ $kriteria->created_at->format('d F Y H:i') }}
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Diperbarui Pada</div>
                                <div class="detail-value">
                                    <i class="far fa-calendar-check me-2"></i>
                                    {{ $kriteria->updated_at->format('d F Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Indikator -->
                    <div class="detail-item">
                        <div class="detail-label">Indikator</div>
                        <div class="indikator-list">
                            @php
                                // Memisahkan indikator berdasarkan bullet points atau newline
                                $indikators = [];
                                if (!empty($kriteria->indikator)) {
                                    // Coba split berdasarkan bullet points
                                    $indikators = array_filter(
                                        array_map('trim', 
                                            explode('•', $kriteria->indikator)
                                        )
                                    );
                                    
                                    // Jika tidak ada bullet points, coba split berdasarkan newline
                                    if (empty($indikators) || (count($indikators) === 1 && empty($indikators[0]))) {
                                        $indikators = array_filter(
                                            array_map('trim', 
                                                explode("\n", $kriteria->indikator)
                                            )
                                        );
                                    }
                                    
                                    // Hapus elemen kosong di awal array jika ada
                                    if (empty($indikators[0])) {
                                        array_shift($indikators);
                                    }
                                }
                                
                                // Jika masih kosong, tampilkan indikator asli
                                if (empty($indikators)) {
                                    $indikators = [$kriteria->indikator];
                                }
                            @endphp
                            
                            @foreach($indikators as $index => $indikator)
                                @if(trim($indikator) !== '')
                                <div class="indikator-item">
                                    <div class="d-flex align-items-start">
                                        <span class="badge bg-primary me-2 mt-1">{{ $index + 1 }}</span>
                                        <div class="flex-grow-1">
                                            {{ trim($indikator) }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Tombol Aksi -->
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('admin.kriteria.edit', $kriteria->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i> Edit Kriteria
                        </a>
                        <form action="{{ route('admin.kriteria.destroy', $kriteria->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kriteria {{ $kriteria->nama_kriteria }}? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus Kriteria
                            </button>
                        </form>
                        <a href="{{ route('admin.kriteria.index') }}" class="btn btn-secondary ms-auto">
                            <i class="fas fa-list me-2"></i> Daftar Kriteria
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection