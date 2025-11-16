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
    .dss-form-section h5 {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f0f0f0;
    }
    .form-select, .form-control {
        border-radius: 8px;
    }
    .form-select:focus, .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(44, 124, 61, 0.25);
    }
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        padding: 12px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #1a3e23;
        border-color: #1a3e23;
        transform: translateY(-2px);
    }
    .progress-bar {
        transition: width 0.4s ease, background-color 0.4s ease;
        font-weight: 600;
    }
    .alert {
        border-radius: 8px;
    }
    .prinsip-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        border-left: 4px solid var(--primary-color);
    }
    .kriteria-item {
        border-bottom: 1px solid #e9ecef;
        padding: 0.75rem 0;
    }
    .kriteria-item:last-child {
        border-bottom: none;
    }
    .loading-spinner {
        display: none;
        text-align: center;
        padding: 2rem;
    }

    /* ==================== STYLE MINIMALIS UNTUK KOTAK STATISTIK ==================== */
    .stat-card {
        border-radius: 12px;
        padding: 1.5rem 1rem;
        text-align: center;
        color: #333;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.8);
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        min-height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Siluet warna di latar belakang */
    .stat-card::before {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        opacity: 0.1;
        z-index: 0;
    }

    .stat-card-1::before {
        background: #667eea;
    }

    .stat-card-2::before {
        background: #f5576c;
    }

    .stat-card-3::before {
        background: #4facfe;
    }

    /* Hover effect sederhana */
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        background: rgba(255, 255, 255, 0.9);
    }

    /* Ikon Statistik */
    .stat-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
        opacity: 0.8;
    }

    .stat-card-1 .stat-icon {
        color: #667eea;
    }

    .stat-card-2 .stat-icon {
        color: #f5576c;
    }

    .stat-card-3 .stat-icon {
        color: #4facfe;
    }

    /* Angka Statistik */
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        position: relative;
        z-index: 1;
        color: #2d3748;
    }

    /* Label Statistik */
    .stat-label {
        font-size: 0.9rem;
        font-weight: 500;
        position: relative;
        z-index: 1;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Badge minimalis */
    .stat-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 12px;
        padding: 4px 10px;
        font-size: 0.7rem;
        font-weight: 600;
        z-index: 2;
        border: 1px solid rgba(0, 0, 0, 0.05);
        color: #718096;
    }

    .stat-card-1 .stat-badge {
        color: #667eea;
    }

    .stat-card-2 .stat-badge {
        color: #f5576c;
    }

    .stat-card-3 .stat-badge {
        color: #4facfe;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .stat-card {
            padding: 1.25rem 0.75rem;
            min-height: 110px;
            margin-bottom: 1rem;
        }
        
        .stat-icon {
            font-size: 1.75rem;
        }
        
        .stat-number {
            font-size: 1.75rem;
        }
        
        .stat-label {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        .stat-card {
            padding: 1rem 0.5rem;
            min-height: 100px;
        }
        
        .stat-icon {
            font-size: 1.5rem;
        }
        
        .stat-number {
            font-size: 1.5rem;
        }
        
        .stat-label {
            font-size: 0.8rem;
        }
    }

    .riwayat-item {
        border-left: 4px solid var(--primary-color);
        padding-left: 1rem;
        margin-bottom: 1rem;
    }
</style>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card border-0 shadow-lg">
                {{-- Header Halaman DSS --}}
                <div class="card-header-pemetaan text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title-pemetaan">
                                <i class="fas fa-certificate me-2"></i> Sistem Pendukung Keputusan ISPO
                            </h4>
                            <p class="mb-0 opacity-75 small">Halo, {{ Auth::user()->name }}! Evaluasi kesiapan kebun Anda.</p>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-light text-dark fs-6">
                                <i class="fas fa-chart-bar me-1"></i>
                                Total Analisis: {{ $totalAnalisis }}x
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Konten Utama DSS --}}
                <div class="card-body p-4">
                    {{-- Statistik Quick --}}
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="stat-card stat-card-1">
                                <div class="stat-badge">Analisis</div>
                                <div class="stat-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <div class="stat-number">{{ $totalAnalisis }}</div>
                                <div class="stat-label">Total Analisis</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-card stat-card-2">
                                <div class="stat-badge">Lahan</div>
                                <div class="stat-icon">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                                <div class="stat-number">{{ $lahan->count() }}</div>
                                <div class="stat-label">Lahan Dimiliki</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-card stat-card-3">
                                <div class="stat-badge">Kriteria</div>
                                <div class="stat-icon">
                                    <i class="fas fa-list-check"></i>
                                </div>
                                <div class="stat-number">{{ count($kriteria->flatten()) }}</div>
                                <div class="stat-label">Kriteria ISPO</div>
                            </div>
                        </div>
                    </div>

                    {{-- Pilihan Lahan --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Pilih Lahan yang Akan Dinilai:</label>
                            <select class="form-select" id="pemetaanLahan">
                                <option value="">-- Pilih Lahan --</option>
                                @foreach($lahan as $l)
                                    <option value="{{ $l->id }}">{{ $l->id_lahan }} - {{ $l->desa }}, {{ $l->kecamatan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-4">
                        {{-- Kolom Kiri: Form Penilaian --}}
                        <div class="col-lg-8">
                            <div class="dss-form-section">
                                <h5><i class="fas fa-clipboard-check me-2"></i> Penilaian Kriteria ISPO</h5>
                                
                                <div id="loadingSpinner" class="loading-spinner">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2">Memuat kriteria penilaian...</p>
                                </div>

                                <form id="dssForm" style="display: none;">
                                    @foreach($kriteria as $prinsip => $kriteriaPrinsip)
                                    <div class="prinsip-section">
                                        <h6 class="fw-bold text-primary mb-3">
                                            <i class="fas fa-folder me-1"></i>{{ $prinsip }}
                                        </h6>
                                        
                                        @foreach($kriteriaPrinsip as $krit)
                                        <div class="kriteria-item">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <label class="form-label mb-1">
                                                        <strong>{{ $krit->kode_kriteria }}:</strong> {{ $krit->nama_kriteria }}
                                                        <br>
                                                        <small class="text-muted">{{ $krit->indikator }}</small>
                                                        <br>
                                                        <small class="text-info">
                                                            <i class="fas fa-weight-hanging"></i> Bobot: {{ $krit->bobot }}% | 
                                                            <i class="fas fa-check-circle"></i> Verifier: {{ $krit->verifier }}
                                                        </small>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-select kriteria-select" 
                                                            name="nilai[{{ $krit->id }}]" 
                                                            data-kriteria="{{ $krit->kode_kriteria }}"
                                                            data-bobot="{{ $krit->bobot }}">
                                                        <option value="0">0% - Tidak Ada</option>
                                                        <option value="25">25% - Sedikit</option>
                                                        <option value="50">50% - Cukup</option>
                                                        <option value="75">75% - Baik</option>
                                                        <option value="100">100% - Sangat Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endforeach

                                    <div class="d-grid mt-4">
                                        <button type="button" class="btn btn-primary btn-lg" onclick="hitungKesiapan()">
                                            <i class="fas fa-calculator me-2"></i> Hitung Kesiapan ISPO
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- Riwayat Analisis Terbaru --}}
                            <div class="mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="text-primary">
                                        <i class="fas fa-history me-2"></i>Riwayat Analisis Terbaru
                                    </h5>
                                    @if($riwayatTerbaru->count() > 0)
                                    <a href="{{ route('pekebun.dss.riwayat') }}" class="btn btn-sm btn-outline-primary">
                                        Lihat Semua
                                    </a>
                                    @endif
                                </div>

                                @if($riwayatTerbaru->count() > 0)
                                    @foreach($riwayatTerbaru as $index => $riwayat)
                                    <div class="riwayat-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="fw-bold mb-1">
                                                    Analisis #{{ $totalAnalisis - $index }}
                                                    <span class="badge bg-{{ $riwayat->skor_akhir >= 80 ? 'success' : ($riwayat->skor_akhir >= 60 ? 'warning' : 'danger') }} ms-2">
                                                        {{ $riwayat->skor_akhir }}%
                                                    </span>
                                                </h6>
                                                <p class="text-muted mb-1 small">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    {{ $riwayat->pemetaanLahan->id_lahan }} - {{ $riwayat->pemetaanLahan->desa }}
                                                </p>
                                                <p class="text-muted mb-1 small">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ $riwayat->tanggal_analisis->format('d F Y H:i') }}
                                                </p>
                                                <p class="mb-0 small">
                                                    Status: 
                                                    <span class="badge bg-{{ $riwayat->pemetaanLahan->status_ispo == 'Lulus' ? 'success' : ($riwayat->pemetaanLahan->status_ispo == 'Dalam Proses' ? 'warning' : 'danger') }}">
                                                        {{ $riwayat->pemetaanLahan->status_ispo }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div>
                                                <a href="{{ route('pekebun.dss.riwayat.detail', $riwayat->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Belum ada riwayat analisis. Lakukan penilaian pertama Anda!
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Kolom Kanan: Hasil Analisis --}}
                        <div class="col-lg-4">
                            <div class="dss-form-section">
                                <h5><i class="fas fa-chart-line me-2"></i> Hasil Analisis</h5>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Persentase Kesiapan:</label>
                                    <div class="progress" style="height: 35px;">
                                        <div id="readinessBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0">
                                            <span id="progressText">0%</span>
                                        </div>
                                    </div>
                                    <div class="text-center mt-2">
                                        <span id="tingkatKesiapan" class="badge bg-secondary fs-6">Belum Dinilai</span>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Rekomendasi:</label>
                                    <div id="readinessSummary" class="alert alert-secondary" role="alert">
                                        Pilih lahan dan isi formulir penilaian, kemudian klik "Hitung Kesiapan" untuk melihat hasil analisis.
                                    </div>
                                </div>

                                <div id="detailHasil" style="display: none;">
                                    <label class="form-label fw-bold">Detail Per Prinsip:</label>
                                    <div id="prinsipChart"></div>
                                    
                                    <div class="mt-3">
                                        <label class="form-label fw-bold">Informasi Analisis:</label>
                                        <div id="analisisInfo" class="small text-muted"></div>
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

<script>
    let currentLahanId = null;
    let totalAnalisis = {{ $totalAnalisis }};

    // Inisialisasi elemen saat DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DSS System Loaded');
        initializeElements();
    });

    function initializeElements() {
        // Pastikan semua elemen yang diperlukan tersedia
        window.elements = {
            readinessBar: document.getElementById('readinessBar'),
            progressText: document.getElementById('progressText'),
            tingkatKesiapan: document.getElementById('tingkatKesiapan'),
            readinessSummary: document.getElementById('readinessSummary'),
            detailHasil: document.getElementById('detailHasil'),
            analisisInfo: document.getElementById('analisisInfo'),
            prinsipChart: document.getElementById('prinsipChart'),
            loadingSpinner: document.getElementById('loadingSpinner'),
            dssForm: document.getElementById('dssForm')
        };
        
        console.log('Elemen yang diinisialisasi:', window.elements);
    }

    function getElementSafe(id) {
        const element = document.getElementById(id);
        if (!element) {
            console.warn(`Element dengan ID '${id}' tidak ditemukan`);
            return null;
        }
        return element;
    }

    document.getElementById('pemetaanLahan').addEventListener('change', function() {
        currentLahanId = this.value;
        if (currentLahanId) {
            const dssForm = getElementSafe('dssForm');
            const loadingSpinner = getElementSafe('loadingSpinner');
            
            if (dssForm) dssForm.style.display = 'block';
            if (loadingSpinner) loadingSpinner.style.display = 'none';
            
            resetHasil();
            loadPenilaianSebelumnya(currentLahanId);
        } else {
            const dssForm = getElementSafe('dssForm');
            if (dssForm) dssForm.style.display = 'none';
            resetHasil();
        }
    });

    async function loadPenilaianSebelumnya(lahanId) {
        try {
            const response = await fetch(`/pekebun/dss/penilaian-sebelumnya/${lahanId}`);
            const result = await response.json();
            
            if (result.success && result.data) {
                const selects = document.querySelectorAll('.kriteria-select');
                selects.forEach(select => {
                    const kriteriaId = select.name.match(/\[(.*?)\]/)[1];
                    if (result.data[kriteriaId]) {
                        select.value = result.data[kriteriaId].skor_kesiapan;
                    }
                });
            }
        } catch (error) {
            console.log('Tidak ada penilaian sebelumnya');
        }
    }

    async function hitungKesiapan() {
        if (!currentLahanId) {
            alert('Pilih lahan terlebih dahulu!');
            return;
        }

        const formData = new FormData();
        formData.append('pemetaan_lahan_id', currentLahanId);
        formData.append('_token', '{{ csrf_token() }}');

        const selects = document.querySelectorAll('.kriteria-select');
        let semuaTerisi = true;
        
        selects.forEach(select => {
            formData.append(`nilai[${select.name.match(/\[(.*?)\]/)[1]}]`, select.value);
            if (select.value === '0') {
                semuaTerisi = false;
            }
        });

        if (!semuaTerisi) {
            if (!confirm('Beberapa kriteria masih bernilai 0%. Lanjutkan perhitungan?')) {
                return;
            }
        }

        try {
            const loadingSpinner = getElementSafe('loadingSpinner');
            if (loadingSpinner) loadingSpinner.style.display = 'block';
            
            const response = await fetch('{{ route("pekebun.dss.hitung") }}', {
                method: 'POST',
                body: formData
            });

            const hasil = await response.json();
            console.log('Response dari server:', hasil);

            if (hasil.success) {
                updateUI(hasil);
                totalAnalisis++;
                updateTotalAnalisisDisplay();
                showSuccessMessage(`Analisis berhasil disimpan! Ini adalah analisis ke-${totalAnalisis} Anda.`);
                
                // Refresh halaman setelah 3 detik untuk update riwayat
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            } else {
                alert('Terjadi kesalahan: ' + (hasil.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghitung kesiapan: ' + error.message);
        } finally {
            const loadingSpinner = getElementSafe('loadingSpinner');
            if (loadingSpinner) loadingSpinner.style.display = 'none';
        }
    }

    function updateTotalAnalisisDisplay() {
        const badge = document.querySelector('.badge.bg-light');
        if (badge) {
            badge.innerHTML = `<i class="fas fa-chart-bar me-1"></i>Total Analisis: ${totalAnalisis}x`;
        }
    }

    function updateUI(hasil) {
        console.log('Memperbarui UI dengan hasil:', hasil);
        
        // Gunakan fungsi safe untuk mendapatkan elemen
        const bar = getElementSafe('readinessBar');
        const progressText = getElementSafe('progressText');
        const tingkatKesiapan = getElementSafe('tingkatKesiapan');
        const summary = getElementSafe('readinessSummary');
        const detailHasil = getElementSafe('detailHasil');
        const analisisInfo = getElementSafe('analisisInfo');
        const prinsipChart = getElementSafe('prinsipChart');

        // Jika elemen utama tidak ada, buat elemen sementara
        if (!bar || !progressText) {
            console.error('Elemen progress bar tidak ditemukan, membuat fallback...');
            createFallbackProgressBar(hasil);
            return;
        }

        // Update progress bar
        const finalPercent = hasil.skor_akhir || 0;
        bar.style.width = `${finalPercent}%`;
        progressText.textContent = `${finalPercent}%`;
        bar.setAttribute('aria-valuenow', finalPercent);

        // Update tingkat kesiapan
        if (tingkatKesiapan) {
            if (hasil.tingkat_kesiapan && hasil.tingkat_kesiapan.status) {
                tingkatKesiapan.textContent = hasil.tingkat_kesiapan.status;
                tingkatKesiapan.className = `badge bg-${hasil.tingkat_kesiapan.class || 'secondary'} fs-6`;
                bar.className = `progress-bar bg-${hasil.tingkat_kesiapan.class || 'secondary'}`;
            } else {
                tingkatKesiapan.textContent = 'Error';
                tingkatKesiapan.className = 'badge bg-danger fs-6';
                bar.className = 'progress-bar bg-danger';
            }
        }

        // Update rekomendasi
        if (summary) {
            let rekomendasiHtml = '';
            if (hasil.rekomendasi && Array.isArray(hasil.rekomendasi)) {
                hasil.rekomendasi.forEach(rec => {
                    rekomendasiHtml += `<p class="mb-2">${rec}</p>`;
                });
            } else {
                rekomendasiHtml = '<p>Tidak ada rekomendasi tersedia.</p>';
            }

            summary.className = `alert alert-${hasil.tingkat_kesiapan?.class || 'secondary'}`;
            summary.innerHTML = rekomendasiHtml;
        }

        // Tampilkan detail per prinsip
        if (detailHasil && prinsipChart) {
            if (hasil.skor_prinsip && Object.keys(hasil.skor_prinsip).length > 0) {
                let prinsipHtml = '';
                for (const [prinsip, skor] of Object.entries(hasil.skor_prinsip)) {
                    const persentase = Math.round(skor);
                    prinsipHtml += `
                        <div class="mb-2">
                            <div class="d-flex justify-content-between">
                                <span>${prinsip}</span>
                                <span>${persentase}%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" style="width: ${persentase}%"></div>
                            </div>
                        </div>
                    `;
                }
                prinsipChart.innerHTML = prinsipHtml;
                
                // Info analisis
                if (analisisInfo) {
                    analisisInfo.innerHTML = `
                        <div><i class="fas fa-list me-1"></i> Total Kriteria: ${hasil.total_kriteria || 0}</div>
                        <div><i class="fas fa-weight-hanging me-1"></i> Total Bobot: ${hasil.total_bobot || 0}%</div>
                        <div><i class="fas fa-clock me-1"></i> Waktu: ${new Date().toLocaleTimeString()}</div>
                    `;
                }
                
                detailHasil.style.display = 'block';
            } else {
                prinsipChart.innerHTML = '<p>Tidak ada data prinsip tersedia.</p>';
                detailHasil.style.display = 'block';
            }
        }
    }

    // Fallback function jika elemen progress bar tidak ditemukan
    function createFallbackProgressBar(hasil) {
        const finalPercent = hasil.skor_akhir || 0;
        const statusClass = hasil.tingkat_kesiapan?.class || 'secondary';
        const statusText = hasil.tingkat_kesiapan?.status || 'Tidak Diketahui';
        
        // Cari container hasil analisis
        const hasilSection = document.querySelector('.dss-form-section');
        if (!hasilSection) return;
        
        // Buat progress bar sementara
        const fallbackHTML = `
            <div class="mb-4">
                <label class="form-label fw-bold">Persentase Kesiapan:</label>
                <div class="progress" style="height: 35px;">
                    <div class="progress-bar bg-${statusClass}" role="progressbar" style="width: ${finalPercent}%;" aria-valuenow="${finalPercent}">
                        <span>${finalPercent}%</span>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <span class="badge bg-${statusClass} fs-6">${statusText}</span>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Rekomendasi:</label>
                <div class="alert alert-${statusClass}" role="alert">
                    ${hasil.rekomendasi ? hasil.rekomendasi.join('<br>') : 'Tidak ada rekomendasi tersedia.'}
                </div>
            </div>
        `;
        
        // Sisipkan di atas konten yang ada
        const existingContent = hasilSection.innerHTML;
        hasilSection.innerHTML = fallbackHTML + existingContent;
    }

    function showSuccessMessage(message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-success alert-dismissible fade show';
        alertDiv.innerHTML = `
            <i class="fas fa-check-circle me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const cardBody = document.querySelector('.card-body');
        if (cardBody) {
            cardBody.insertBefore(alertDiv, cardBody.firstChild);
        }
    }

    function resetHasil() {
        const bar = getElementSafe('readinessBar');
        const progressText = getElementSafe('progressText');
        const tingkatKesiapan = getElementSafe('tingkatKesiapan');
        const summary = getElementSafe('readinessSummary');
        const detailHasil = getElementSafe('detailHasil');

        if (bar) bar.style.width = '0%';
        if (progressText) progressText.textContent = '0%';
        if (tingkatKesiapan) {
            tingkatKesiapan.textContent = 'Belum Dinilai';
            tingkatKesiapan.className = 'badge bg-secondary fs-6';
        }
        if (summary) {
            summary.innerHTML = 'Pilih lahan dan isi formulir penilaian, kemudian klik "Hitung Kesiapan" untuk melihat hasil analisis.';
            summary.className = 'alert alert-secondary';
        }
        if (detailHasil) detailHasil.style.display = 'none';
    }
</script>
@endsection