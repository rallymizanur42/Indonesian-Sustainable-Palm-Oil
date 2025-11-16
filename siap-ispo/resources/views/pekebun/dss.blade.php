@extends('layouts.app')

@section('content')
{{-- Menggunakan CSS yang sama persis dengan halaman Peta --}}
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
    /* Style Khusus untuk DSS */
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
</style>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card border-0 shadow-lg">
                {{-- Header Halaman DSS --}}
                <div class="card-header-pemetaan text-white">
                    <h4 class="card-title-pemetaan">
                        <i class="fas fa-certificate me-2"></i> Sistem Pendukung Keputusan ISPO
                    </h4>
                    <p class="mb-0 opacity-75 small">Evaluasi kesiapan kebun Anda berdasarkan kriteria standar ISPO.</p>
                </div>

                {{-- Konten Utama DSS --}}
                <div class="card-body p-4">
                    <div class="row g-4">
                        {{-- Kolom Kiri: Form Penilaian --}}
                        <div class="col-lg-7">
                            <div class="dss-form-section">
                                <h5><i class="fas fa-clipboard-check me-2"></i> Penilaian Kriteria ISPO</h5>
                                <form id="dssForm">
                                    <div class="mb-3">
                                        <label for="legalitas" class="form-label fw-bold">1. Legalitas (Dokumen Perusahaan & Lahan)</label>
                                        <select class="form-select" data-weight="10" id="legalitas">
                                            <option value="0">0% - Tidak memiliki dokumen legalitas</option>
                                            <option value="50">50% - Legalitas dalam proses atau tidak lengkap</option>
                                            <option value="100">100% - Dokumen legalitas lengkap dan sah</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="budidaya" class="form-label fw-bold">2. Praktik Budidaya & Penanganan Panen</label>
                                        <select class="form-select" data-weight="25" id="budidaya">
                                            <option value="0">0% - Praktik budidaya tidak sesuai standar</option>
                                            <option value="50">50% - Sebagian praktik budidaya sudah standar</option>
                                            <option value="100">100% - Seluruh praktik budidaya sesuai standar</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lingkungan" class="form-label fw-bold">3. Pengelolaan Lingkungan Hidup</label>
                                        <select class="form-select" data-weight="25" id="lingkungan">
                                            <option value="0">0% - Tidak ada pengelolaan limbah atau polusi</option>
                                            <option value="50">50% - Ada pengelolaan, tetapi belum optimal</option>
                                            <option value="100">100% - Pengelolaan limbah dan lingkungan terpadu</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sosial" class="form-label fw-bold">4. Tanggung Jawab Sosial & Ketenagakerjaan</label>
                                        <select class="form-select" data-weight="20" id="sosial">
                                            <option value="0">0% - Tidak ada program sosial & ketenagakerjaan</option>
                                            <option value="50">50% - Program ada, tetapi belum menyeluruh</option>
                                            <option value="100">100% - Program berjalan sesuai standar</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="evaluasi" class="form-label fw-bold">5. Pemantauan & Evaluasi</label>
                                        <select class="form-select" data-weight="20" id="evaluasi">
                                            <option value="0">0% - Tidak ada sistem pemantauan internal</option>
                                            <option value="50">50% - Pemantauan dilakukan secara sporadis</option>
                                            <option value="100">100% - Sistem pemantauan berkelanjutan berjalan baik</option>
                                        </select>
                                    </div>
                                    <div class="d-grid mt-4">
                                        <button type="button" class="btn btn-primary" onclick="hitungKesiapan()">
                                            <i class="fas fa-calculator me-2"></i> Hitung Kesiapan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Hasil Analisis --}}
                        <div class="col-lg-5">
                            <div class="dss-form-section">
                                <h5><i class="fas fa-chart-line me-2"></i> Hasil Analisis</h5>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Persentase Kesiapan:</label>
                                    <div class="progress" style="height: 30px;">
                                        <div id="readinessBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0">0%</div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="form-label fw-bold">Rekomendasi:</label>
                                    <div id="readinessSummary" class="alert alert-secondary" role="alert">
                                        Isi formulir dan klik "Hitung Kesiapan" untuk melihat hasil.
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
    function hitungKesiapan() {
        const criteria = [
            { id: "legalitas", weight: 10 }, { id: "budidaya", weight: 25 },
            { id: "lingkungan", weight: 25 }, { id: "sosial", weight: 20 },
            { id: "evaluasi", weight: 20 },
        ];
        let totalWeightedScore = 0;
        let totalWeight = 0;
        const needsImprovement = [];

        criteria.forEach(c => {
            const select = document.getElementById(c.id);
            const score = parseInt(select.value);
            const weight = parseInt(select.dataset.weight);
            totalWeightedScore += score * weight;
            totalWeight += weight;
            if (score < 100) {
                const label = select.parentElement.querySelector('label').textContent;
                needsImprovement.push({ name: label.substring(label.indexOf('.') + 2), score });
            }
        });

        const percentage = totalWeightedScore / totalWeight;
        updateUI(percentage, needsImprovement);
    }

    function updateUI(percentage, improvementList) {
        const bar = document.getElementById("readinessBar");
        const summary = document.getElementById("readinessSummary");
        const finalPercent = Math.round(percentage);

        bar.style.width = `${finalPercent}%`;
        bar.textContent = `${finalPercent}%`;
        bar.setAttribute("aria-valuenow", finalPercent);

        let rekomendasi = "";
        let alertClass = "";
        if (finalPercent >= 80) {
            rekomendasi = "<strong>Kesiapan sangat baik.</strong> Direkomendasikan untuk mengajukan audit sertifikasi.";
            alertClass = "alert-success";
            bar.className = "progress-bar bg-success";
        } else if (finalPercent >= 50) {
            rekomendasi = "<strong>Kesiapan cukup.</strong> Perlu fokus pada perbaikan aspek yang belum optimal.";
            alertClass = "alert-warning";
            bar.className = "progress-bar bg-warning text-dark";
        } else {
            rekomendasi = "<strong>Kesiapan masih rendah.</strong> Perlu perbaikan mendasar pada beberapa aspek penting.";
            alertClass = "alert-danger";
            bar.className = "progress-bar bg-danger";
        }

        let improvementHtml = "";
        if (improvementList.length > 0) {
            improvementHtml = `<hr><p class="mb-1"><strong>Aspek Perbaikan:</strong></p><ul class="mb-0 small ps-3">`;
            improvementList.forEach(item => {
                improvementHtml += `<li>${item.name} (${item.score}%)</li>`;
            });
            improvementHtml += `</ul>`;
        }

        summary.className = `alert ${alertClass}`;
        summary.innerHTML = `${rekomendasi}${improvementHtml}`;
    }
</script>
@endsection