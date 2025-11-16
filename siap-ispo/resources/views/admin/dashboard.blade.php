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
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
    }
    
    .card-header-dashboard {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1a3e23 100%);
        color: white;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .card-header-dashboard::before {
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

    .card-title-dashboard {
        font-weight: 600;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .card-header-custom {
        background: white;
        border-bottom: 1px solid #eee;
        font-weight: 600;
        color: var(--primary-color);
        font-size: 1rem;
    }

    .history-item {
        background: var(--light-bg);
        border-left: 4px solid var(--primary-color);
        border-radius: 0 8px 8px 0;
        padding: 15px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .history-item:hover {
        transform: translateX(5px);
        background: #e9ecef;
        cursor: pointer;
    }

    .history-score {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--secondary-color);
    }

    .history-title {
        font-weight: 600;
        color: var(--text-color);
    }

    .history-date {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .history-user {
        font-weight: 500;
        color: var(--primary-color);
    }

    .empty-history {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-muted);
    }

    .empty-history i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .stats-card {
        text-align: center;
        padding: 1.5rem;
        border-radius: 12px;
        background: white;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--hover-shadow);
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .stats-label {
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .latest-assessment {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1a3e23 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 2rem;
    }

    .latest-assessment-score {
        font-size: 4rem;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 1rem;
    }

    .latest-assessment-user {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .latest-assessment-date {
        opacity: 0.9;
        margin-bottom: 1rem;
    }

    .status-badge {
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .bg-siap {
        background-color: #28a745 !important;
    }

    .bg-dianjurkan {
        background-color: #ffc107 !important;
        color: #000 !important;
    }

    .bg-perlu-perbaikan {
        background-color: #dc3545 !important;
    }
</style>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header-dashboard text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                           <h4 class="card-title-dashboard">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard Admin ISPO
                            </h4>
                        </div>
                        <div class="text-end">
                             <div class="fw-bold fs-5" style="letter-spacing: 1px;">
                                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                             </div>
                             <div class="small opacity-75">
                                {{ \Carbon\Carbon::now()->translatedFormat('l') }}
                             </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    

                    <!-- Statistik -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-3">
                            <div class="stats-card">
                                <div class="stats-number">{{ $totalPekebun }}</div>
                                <div class="stats-label">
                                    <i class="fas fa-users me-2"></i>Total Pekebun
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card">
                                <div class="stats-number">{{ $totalLahan }}</div>
                                <div class="stats-label">
                                    <i class="fas fa-map me-2"></i>Total Lahan
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card">
                                <div class="stats-number">{{ $totalAnalisis }}</div>
                                <div class="stats-label">
                                    <i class="fas fa-chart-bar me-2"></i>Total Analisis
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card">
                                <div class="stats-number">{{ $statusStats['total'] }}</div>
                                <div class="stats-label">
                                    <i class="fas fa-file-alt me-2"></i>Total Assessment
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Grafik Perkembangan Skor -->
                        <div class="col-lg-5">
                            <div class="card h-100">
                                <div class="card-header card-header-custom">
                                    <i class="fas fa-chart-line me-2"></i> Grafik Rata-rata Skor ISPO
                                </div>
                                <div class="card-body d-flex align-items-center">
                                    <canvas id="progressChart" style="max-height: 400px;"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat Assessment Terbaru -->
                        <div class="col-lg-7">
                            <div class="card h-100">
                                <div class="card-header card-header-custom">
                                    <i class="fas fa-history me-2"></i> Riwayat Assessment Terbaru
                                </div>
                                <div class="card-body" style="max-height: 420px; overflow-y: auto;">
                                    @if($latestRiwayat->count() > 0)
                                        @foreach($latestRiwayat as $index => $item)
                                            @php
                                                if ($item->skor_akhir >= 80) {
                                                    $status = 'Siap Sertifikasi';
                                                    $statusClass = 'bg-siap text-white';
                                                    $description = 'Pekebun telah memenuhi kriteria sertifikasi ISPO dengan baik dan direkomendasikan untuk melanjutkan proses sertifikasi.';
                                                } elseif ($item->skor_akhir >= 60) {
                                                    $status = 'Dianjurkan Sertifikasi';
                                                    $statusClass = 'bg-dianjurkan';
                                                    $description = 'Pekebun mendekati kriteria sertifikasi ISPO, disarankan untuk melakukan beberapa perbaikan sebelum mengajukan sertifikasi.';
                                                } else {
                                                    $status = 'Perlu Perbaikan';
                                                    $statusClass = 'bg-perlu-perbaikan text-white';
                                                    $description = 'Pekebun perlu melakukan perbaikan signifikan untuk memenuhi kriteria sertifikasi ISPO.';
                                                }
                                            @endphp

                                            <div class="history-item d-flex justify-content-between align-items-center" 
                                                 data-bs-toggle="modal" data-bs-target="#detailModal"
                                                 data-title="Assessment {{ $item->user->name ?? 'Unknown User' }}"
                                                 data-score="{{ $item->skor_akhir }}"
                                                 data-date="{{ $item->tanggal_analisis->translatedFormat('d F Y H:i') }}"
                                                 data-status="{{ $status }}"
                                                 data-status-class="{{ $statusClass }}"
                                                 data-user="{{ $item->user->name ?? 'Unknown User' }}"
                                                 data-lahan="{{ $item->pemetaanLahan->id_lahan ?? 'Tidak ada lahan' }}"
                                                 data-description="{{ $description }}">
                                                <div>
                                                    <div class="history-score">{{ $item->skor_akhir }}</div>
                                                    <div class="history-title">
                                                        {{ $item->user->name ?? 'Unknown User' }}
                                                    </div>
                                                    <div class="history-date">
                                                        {{ $item->tanggal_analisis->translatedFormat('d F Y H:i') }}
                                                        @if($item->pemetaanLahan)
                                                            - {{ $item->pemetaanLahan->id_lahan }}
                                                        @endif
                                                    </div>
                                                </div>
                                                <span class="badge {{ $statusClass }}">{{ $status }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="empty-history">
                                            <i class="fas fa-inbox"></i>
                                            <h5>Belum Ada Riwayat</h5>
                                            <p class="mb-3">Belum ada pekebun yang melakukan assessment.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel">Detail Assessment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row">
            <div class="col-md-4 text-center border-end">
                <h6 class="text-muted">SKOR KESIAPAN</h6>
                <div id="modalScore" class="display-4 fw-bold text-warning">0</div>
                <span id="modalStatus" class="badge fs-6 mt-2">Status</span>
            </div>
            <div class="col-md-8">
                <h5 class="fw-bold mb-3" id="modalTitle">Nama Assessment</h5>
                <div class="mb-3">
                    <strong><i class="fas fa-user me-2"></i>Pekebun:</strong>
                    <span id="modalUser" class="ms-2">-</span>
                </div>
                <div class="mb-3">
                    <strong><i class="fas fa-map me-2"></i>Lahan:</strong>
                    <span id="modalLahan" class="ms-2">-</span>
                </div>
                <div class="mb-3">
                    <strong><i class="fas fa-calendar me-2"></i>Tanggal:</strong>
                    <span id="modalDate" class="ms-2">-</span>
                </div>
                <hr>
                <div class="mt-3">
                    <h6><i class="fas fa-info-circle me-2"></i>Status Assessment</h6>
                    <p id="modalDescription" class="text-muted">Status assessment akan muncul di sini.</p>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk chart
    @if(isset($chartData))
        const labels = @json($chartData['labels']);
        const scores = @json($chartData['scores']);
    @else
        const labels = ['Jul 2024', 'Aug 2024', 'Sep 2024', 'Okt 2024', 'Nov 2024'];
        const scores = [65, 68, 72, 75, 78];
    @endif

    const ctx = document.getElementById('progressChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rata-rata Skor ISPO',
                data: scores,
                borderColor: 'var(--secondary-color)',
                backgroundColor: 'rgba(245, 166, 35, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'var(--secondary-color)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Skor: ${context.parsed.y}%`;
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: false, 
                    min: Math.min(...scores) - 10 > 0 ? Math.min(...scores) - 10 : 0, 
                    max: Math.max(...scores) + 10 < 100 ? Math.max(...scores) + 10 : 100, 
                    grid: { color: 'rgba(0,0,0,0.05)' }, 
                    ticks: { callback: (value) => value + '%' } 
                },
                x: { grid: { display: false } }
            }
        }
    });

    // Modal functionality
    const detailModal = document.getElementById('detailModal');
    detailModal.addEventListener('show.bs.modal', event => {
        const item = event.relatedTarget;
        const title = item.getAttribute('data-title');
        const score = item.getAttribute('data-score');
        const date = item.getAttribute('data-date');
        const status = item.getAttribute('data-status');
        const statusClass = item.getAttribute('data-status-class');
        const user = item.getAttribute('data-user');
        const lahan = item.getAttribute('data-lahan');
        const description = item.getAttribute('data-description');
        
        const modalTitle = detailModal.querySelector('#detailModalLabel');
        const modalScoreEl = detailModal.querySelector('#modalScore');
        const modalStatusEl = detailModal.querySelector('#modalStatus');
        const modalTitleBody = detailModal.querySelector('#modalTitle');
        const modalUserEl = detailModal.querySelector('#modalUser');
        const modalLahanEl = detailModal.querySelector('#modalLahan');
        const modalDateEl = detailModal.querySelector('#modalDate');
        const modalDescription = detailModal.querySelector('#modalDescription');

        modalTitle.textContent = 'Detail Assessment';
        modalScoreEl.textContent = score;
        modalStatusEl.textContent = status;
        modalStatusEl.className = 'badge fs-6 mt-2 ' + statusClass;
        modalTitleBody.textContent = title;
        modalUserEl.textContent = user;
        modalLahanEl.textContent = lahan;
        modalDateEl.textContent = date;
        modalDescription.textContent = description;
    });
});
</script>
@endsection