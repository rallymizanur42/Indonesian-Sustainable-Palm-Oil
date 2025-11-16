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
    .form-label {
        font-weight: 600;
        color: #333;
    }
    .indikator-item {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        background-color: #f9f9f9;
    }
    .indikator-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 10px;
    }
    .btn-remove-indikator {
        background-color: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bobot-info {
        font-size: 0.875rem;
        color: #6c757d;
    }
    .indikator-preview {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 10px;
        margin-top: 10px;
    }
</style>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-header-pemetaan d-flex justify-content-between align-items-center">
                    <h4 class="card-title-pemetaan">
                        <i class="fas fa-pencil-alt me-2"></i> Edit Kriteria - {{ $kriteria->kode_kriteria }}
                    </h4>
                    <a href="{{ route('admin.kriteria.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.kriteria.update', $kriteria->id) }}" method="POST" id="kriteriaForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kode_kriteria" class="form-label">Kode Kriteria *</label>
                                    <input type="text" class="form-control @error('kode_kriteria') is-invalid @enderror" 
                                           id="kode_kriteria" name="kode_kriteria" 
                                           value="{{ old('kode_kriteria', $kriteria->kode_kriteria) }}" required readonly>
                                    @error('kode_kriteria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Kode kriteria tidak dapat diubah</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_kriteria" class="form-label">Nama Kriteria *</label>
                                    <input type="text" class="form-control @error('nama_kriteria') is-invalid @enderror" 
                                           id="nama_kriteria" name="nama_kriteria" 
                                           value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" required>
                                    @error('nama_kriteria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="prinsip" class="form-label">Prinsip *</label>
                            <select class="form-select @error('prinsip') is-invalid @enderror" 
                                    id="prinsip" name="prinsip" required>
                                <option value="">Pilih Prinsip</option>
                                <option value="Prinsip 1" {{ old('prinsip', $kriteria->prinsip) == 'Prinsip 1' ? 'selected' : '' }}>Prinsip 1</option>
                                <option value="Prinsip 2" {{ old('prinsip', $kriteria->prinsip) == 'Prinsip 2' ? 'selected' : '' }}>Prinsip 2</option>
                                <option value="Prinsip 3" {{ old('prinsip', $kriteria->prinsip) == 'Prinsip 3' ? 'selected' : '' }}>Prinsip 3</option>
                                <option value="Prinsip 4" {{ old('prinsip', $kriteria->prinsip) == 'Prinsip 4' ? 'selected' : '' }}>Prinsip 4</option>
                                <option value="Prinsip 5" {{ old('prinsip', $kriteria->prinsip) == 'Prinsip 5' ? 'selected' : '' }}>Prinsip 5</option>
                                <option value="Prinsip 6" {{ old('prinsip', $kriteria->prinsip) == 'Prinsip 6' ? 'selected' : '' }}>Prinsip 6</option>
                                <option value="Prinsip 7" {{ old('prinsip', $kriteria->prinsip) == 'Prinsip 7' ? 'selected' : '' }}>Prinsip 7</option>
                            </select>
                            @error('prinsip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis Kriteria *</label>
                            <select class="form-select @error('jenis') is-invalid @enderror" 
                                    id="jenis" name="jenis" required>
                                <option value="">Pilih Jenis</option>
                                <option value="benefit" {{ old('jenis', $kriteria->jenis) == 'benefit' ? 'selected' : '' }}>Benefit</option>
                                <option value="cost" {{ old('jenis', $kriteria->jenis) == 'cost' ? 'selected' : '' }}>Cost</option>
                            </select>
                            @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Indikator *</label>
                            <div class="alert alert-info">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    Tambahkan indikator satu per satu. Semua indikator akan digabung menjadi satu teks dengan pemisah bullet point.
                                </small>
                            </div>
                            <div id="indikator-container">
                                <!-- Indikator akan ditambahkan di sini secara dinamis -->
                                @php
                                    // Memisahkan indikator yang ada berdasarkan bullet points
                                    $existingIndikators = [];
                                    if (!empty($kriteria->indikator)) {
                                        $existingIndikators = array_filter(
                                            array_map('trim', 
                                                explode('•', $kriteria->indikator)
                                            )
                                        );
                                        // Hapus elemen kosong di awal array jika ada
                                        if (empty($existingIndikators[0])) {
                                            array_shift($existingIndikators);
                                        }
                                    }
                                    
                                    // Jika tidak ada indikator yang dipisah, gunakan indikator asli
                                    if (empty($existingIndikators)) {
                                        $existingIndikators = [$kriteria->indikator];
                                    }
                                @endphp
                                
                                @foreach($existingIndikators as $index => $indikator)
                                <div class="indikator-item">
                                    <div class="indikator-header">
                                        <h6 class="mb-0">Indikator {{ $index + 1 }}</h6>
                                        @if($index > 0)
                                        <button type="button" class="btn-remove-indikator" onclick="removeIndikator(this)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @else
                                        <button type="button" class="btn-remove-indikator" onclick="removeIndikator(this)" style="display: none;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @endif
                                    </div>
                                    <textarea class="form-control indikator-field" name="indikator_fields[]" rows="3" required placeholder="Masukkan deskripsi indikator">{{ trim($indikator) }}</textarea>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-primary mt-2" onclick="addIndikator()">
                                <i class="fas fa-plus me-1"></i> Tambah Indikator
                            </button>
                            
                            <!-- Preview bagaimana indikator akan ditampilkan -->
                            <div class="indikator-preview mt-3" id="indikatorPreview">
                                <strong>Preview Indikator:</strong>
                                <div id="previewContent" class="mt-2">
                                    @foreach($existingIndikators as $indikator)
                                    <div class="mb-1">• {{ trim($indikator) }}</div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Hidden field untuk menyimpan indikator sebagai string -->
                            <input type="hidden" name="indikator" id="indikatorHidden" value="{{ old('indikator', $kriteria->indikator) }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="verifier" class="form-label">Verifier</label>
                            <textarea class="form-control @error('verifier') is-invalid @enderror" 
                                      id="verifier" name="verifier" rows="3" placeholder="Masukkan verifikasi yang diperlukan">{{ old('verifier', $kriteria->verifier) }}</textarea>
                            @error('verifier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="bobot" class="form-label">Bobot *</label>
                            <input type="number" class="form-control @error('bobot') is-invalid @enderror" 
                                   id="bobot" name="bobot" min="0" max="100" step="0.01"
                                   value="{{ old('bobot', $kriteria->bobot) }}" required>
                            @error('bobot')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="bobot-info">
                                <i class="fas fa-info-circle me-1"></i>
                                Bobot dapat bernilai 0 hingga 100%. Nilai desimal diperbolehkan (contoh: 12.5, 7.25, dll)
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi tambahan (opsional)">{{ old('deskripsi', $kriteria->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary py-2" style="background-color: var(--primary-color); border: none;">
                                <i class="fas fa-save me-2"></i> Perbarui Kriteria
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let indikatorCount = {{ count($existingIndikators) }};
    
    function addIndikator() {
        indikatorCount++;
        const container = document.getElementById('indikator-container');
        const newIndikator = document.createElement('div');
        newIndikator.className = 'indikator-item';
        newIndikator.innerHTML = `
            <div class="indikator-header">
                <h6 class="mb-0">Indikator ${indikatorCount}</h6>
                <button type="button" class="btn-remove-indikator" onclick="removeIndikator(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <textarea class="form-control indikator-field" name="indikator_fields[]" rows="3" required placeholder="Masukkan deskripsi indikator"></textarea>
        `;
        container.appendChild(newIndikator);
        
        // Tampilkan tombol hapus pada indikator pertama jika ada lebih dari satu
        if (indikatorCount > 1) {
            const firstRemoveBtn = container.querySelector('.indikator-item:first-child .btn-remove-indikator');
            if (firstRemoveBtn) {
                firstRemoveBtn.style.display = 'block';
            }
        }
        
        // Update preview
        updateIndikatorPreview();
    }
    
    function removeIndikator(button) {
        const container = document.getElementById('indikator-container');
        const items = container.querySelectorAll('.indikator-item');
        
        if (items.length > 1) {
            button.closest('.indikator-item').remove();
            indikatorCount--;
            
            // Perbarui nomor indikator
            const remainingItems = container.querySelectorAll('.indikator-item');
            remainingItems.forEach((item, index) => {
                const header = item.querySelector('.indikator-header h6');
                header.textContent = `Indikator ${index + 1}`;
            });
            
            // Sembunyikan tombol hapus pada indikator pertama jika hanya ada satu
            if (indikatorCount === 1) {
                const firstRemoveBtn = container.querySelector('.indikator-item:first-child .btn-remove-indikator');
                if (firstRemoveBtn) {
                    firstRemoveBtn.style.display = 'none';
                }
            }
        }
        
        // Update preview
        updateIndikatorPreview();
    }
    
    function updateIndikatorPreview() {
        const indikatorFields = document.querySelectorAll('.indikator-field');
        const previewContent = document.getElementById('previewContent');
        const previewContainer = document.getElementById('indikatorPreview');
        
        let previewHTML = '';
        let combinedText = '';
        
        indikatorFields.forEach((field, index) => {
            if (field.value.trim() !== '') {
                previewHTML += `<div class="mb-1">• ${field.value}</div>`;
                combinedText += `• ${field.value}\n`;
            }
        });
        
        if (previewHTML !== '') {
            previewContent.innerHTML = previewHTML;
            previewContainer.style.display = 'block';
            
            // Update hidden field dengan teks gabungan
            document.getElementById('indikatorHidden').value = combinedText.trim();
        } else {
            previewContainer.style.display = 'none';
            document.getElementById('indikatorHidden').value = '';
        }
    }
    
    // Event listener untuk update preview saat indikator diubah
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('indikator-field')) {
            updateIndikatorPreview();
        }
    });
    
    // Validasi form sebelum submit
    document.getElementById('kriteriaForm').addEventListener('submit', function(e) {
        const bobot = parseFloat(document.getElementById('bobot').value);
        const indikatorFields = document.querySelectorAll('.indikator-field');
        let hasEmptyIndikator = false;
        
        // Validasi indikator tidak boleh kosong
        indikatorFields.forEach(field => {
            if (field.value.trim() === '') {
                hasEmptyIndikator = true;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (hasEmptyIndikator) {
            e.preventDefault();
            alert('Semua indikator harus diisi!');
            return;
        }
        
        // Validasi bobot
        if (isNaN(bobot) || bobot < 0 || bobot > 100) {
            e.preventDefault();
            alert('Bobot harus antara 0-100%!');
            return;
        }
        
        // Pastikan hidden field terisi sebelum submit
        updateIndikatorPreview();
    });

    // Initialize preview saat pertama kali load
    document.addEventListener('DOMContentLoaded', function() {
        updateIndikatorPreview();
    });
</script>
@endsection