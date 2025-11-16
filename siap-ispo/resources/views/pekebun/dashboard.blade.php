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
    .modal-header {
        background-color: var(--primary-color);
        color: white;
    }
    .modal-header .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
    #modalScore {
        font-size: 3rem;
        font-weight: 700;
        color: var(--secondary-color);
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
</style>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header-pemetaan text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                           <h4 class="card-title-pemetaan">
                                <i class="fas fa-tachometer-alt me-2"></i> Selamat datang, {{ Auth::user()->name }}!
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
                    <div class="row g-4">
                        <div class="col-lg-5">
                            <div class="card h-100">
                                <div class="card-header card-header-custom">
                                    <i class="fas fa-chart-line me-2"></i> Grafik Perkembangan Skor
                                </div>
                                <div class="card-body d-flex align-items-center">
                                    <canvas id="progressChart" style="max-height: 400px;"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="card h-100">
                                <div class="card-header card-header-custom">
                                    <i class="fas fa-history me-2"></i> Riwayat Penggunaan DSS
                                </div>
                                <div class="card-body" style="max-height: 420px; overflow-y: auto;">
                                    @php
                                        // Ambil riwayat terbaru dari database
                                        $riwayat = \App\Models\RiwayatDSS::with(['pemetaanLahan'])
                                            ->where('user_id', Auth::id())
                                            ->orderBy('tanggal_analisis', 'desc')
                                            ->take(10)
                                            ->get();
                                    @endphp

                                    @if($riwayat->count() > 0)
                                        @foreach($riwayat as $index => $item)
                                            @php
                                                // Tentukan status dan warna badge berdasarkan skor
                                                $status = '';
                                                $statusClass = '';
                                                $recommendation = $item->rekomendasi_text ?? 'Tidak ada rekomendasi tersedia.';
                                                
                                                if ($item->skor_akhir >= 80) {
                                                    $status = 'Siap Sertifikasi';
                                                    $statusClass = 'bg-success text-white';
                                                } elseif ($item->skor_akhir >= 60) {
                                                    $status = 'Dianjurkan Sertifikasi';
                                                    $statusClass = 'bg-warning text-dark';
                                                } else {
                                                    $status = 'Perlu Perbaikan';
                                                    $statusClass = 'bg-danger text-white';
                                                }

                                                // Format improvements dari rekomendasi text
                                                $improvements = [];
                                                if ($item->rekomendasi_text) {
                                                    $recs = explode(' | ', $item->rekomendasi_text);
                                                    foreach ($recs as $rec) {
                                                        if (strpos($rec, 'Prioritas perbaikan:') !== false) {
                                                            $improvements[] = [
                                                                'kriteria' => 'Prioritas Perbaikan',
                                                                'status' => str_replace('Prioritas perbaikan: ', '', $rec)
                                                            ];
                                                        } elseif (strpos($rec, 'Kesiapan') !== false) {
                                                            // Skip rekomendasi utama
                                                            continue;
                                                        } else {
                                                            $improvements[] = [
                                                                'kriteria' => 'Rekomendasi',
                                                                'status' => $rec
                                                            ];
                                                        }
                                                    }
                                                }

                                                // Jika tidak ada improvements, buat default
                                                if (empty($improvements)) {
                                                    $improvements = [[
                                                        'kriteria' => 'Informasi',
                                                        'status' => 'Tidak ada poin perbaikan spesifik.'
                                                    ]];
                                                }
                                            @endphp

                                            <div class="history-item d-flex justify-content-between align-items-center" 
                                                 data-bs-toggle="modal" data-bs-target="#detailModal"
                                                 data-title="{{ $index == 0 ? 'Assessment Terbaru' : 'Assessment #' . ($riwayat->count() - $index) }}"
                                                 data-score="{{ $item->skor_akhir }}"
                                                 data-date="{{ $item->tanggal_analisis->translatedFormat('d F Y') }}"
                                                 data-status="{{ $status }}"
                                                 data-status-class="{{ $statusClass }}"
                                                 data-recommendation="{{ $recommendation }}"
                                                 data-improvements='@json($improvements)'>
                                                <div>
                                                    <div class="history-score">{{ $item->skor_akhir }}</div>
                                                    <div class="history-title">
                                                        {{ $index == 0 ? 'Assessment Terbaru' : 'Assessment #' . ($riwayat->count() - $index) }}
                                                    </div>
                                                    <div class="history-date">
                                                        {{ $item->tanggal_analisis->translatedFormat('d F Y') }}
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
                                            <p class="mb-3">Anda belum melakukan analisis DSS.</p>
                                            <a href="{{ route('pekebun.dss.index') }}" class="btn btn-primary">
                                                <i class="fas fa-calculator me-2"></i> Mulai Analisis Pertama
                                            </a>
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
                <div id="modalScore">0</div>
                <span id="modalStatus" class="badge">Status</span>
            </div>
            <div class="col-md-8">
                <h5 class="fw-bold" id="modalTitle">Nama Assessment</h5>
                <p class="text-muted" id="modalDate">Tanggal</p>
                <hr>
                <h6><i class="fas fa-comment-dots me-2"></i>Rekomendasi</h6>
                <p id="modalRecommendation">Rekomendasi akan muncul di sini.</p>
                
                <h6 class="mt-4"><i class="fas fa-list-check me-2"></i>Poin Perbaikan</h6>
                <ul class="list-group list-group-flush" id="modalImprovements">
                </ul>
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
    // Data untuk chart dari riwayat
    @if($riwayat->count() > 0)
        const riwayatData = @json($riwayat->sortBy('tanggal_analisis')->values());
        const labels = riwayatData.map(item => {
            const date = new Date(item.tanggal_analisis);
            return date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' });
        });
        const scores = riwayatData.map(item => item.skor_akhir);
    @else
        // Data dummy jika tidak ada riwayat
        const labels = ['Jul 2024', 'Aug 2024', 'Sep 2024', 'Okt 2024', 'Nov 2024'];
        const scores = [55, 58, 62, 65, 70];
    @endif

    const ctx = document.getElementById('progressChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Skor DSS ISPO',
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

    const detailModal = document.getElementById('detailModal');
    detailModal.addEventListener('show.bs.modal', event => {
        const item = event.relatedTarget;
        const title = item.getAttribute('data-title');
        const score = item.getAttribute('data-score');
        const date = item.getAttribute('data-date');
        const status = item.getAttribute('data-status');
        const statusClass = item.getAttribute('data-status-class');
        const recommendation = item.getAttribute('data-recommendation');
        const improvements = JSON.parse(item.getAttribute('data-improvements'));
        const modalTitle = detailModal.querySelector('#detailModalLabel');
        const modalScoreEl = detailModal.querySelector('#modalScore');
        const modalStatusEl = detailModal.querySelector('#modalStatus');
        const modalTitleBody = detailModal.querySelector('#modalTitle');
        const modalDateEl = detailModal.querySelector('#modalDate');
        const modalRecommendationEl = detailModal.querySelector('#modalRecommendation');
        const modalImprovementsList = detailModal.querySelector('#modalImprovements');

        modalTitle.textContent = 'Detail ' + title;
        modalScoreEl.textContent = score;
        modalStatusEl.textContent = status;
        modalStatusEl.className = 'badge ' + statusClass;
        modalTitleBody.textContent = title;
        modalDateEl.textContent = date;
        modalRecommendationEl.textContent = recommendation;
        modalImprovementsList.innerHTML = '';

        if (improvements.length > 0) {
            improvements.forEach(imp => {
                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.innerHTML = `<strong>${imp.kriteria}:</strong> ${imp.status}`;
                modalImprovementsList.appendChild(li);
            });
        } else {
            const li = document.createElement('li');
            li.className = 'list-group-item';
            li.textContent = 'Tidak ada poin perbaikan spesifik.';
            modalImprovementsList.appendChild(li);
        }
    });
});
</script>
@endsection