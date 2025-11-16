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
        background: linear-gradient(135deg, #f5a623 0%, #c58a20 100%); 
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
        margin-bottom: 0.5rem;
    }
</style>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-header-pemetaan d-flex justify-content-between align-items-center">
                    <h4 class="card-title-pemetaan">
                        <i class="fas fa-pencil-alt me-2"></i> Edit Data Perkebunan: {{ $perkebunan->id_lahan }}
                    </h4>
                    <a href="{{ route('admin.pemetaan.index') }}" class="btn btn-light btn-sm">
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

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- PERBAIKAN: Gunakan parameter yang benar -->
                    <form action="{{ route('admin.pemetaan.update', $perkebunan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-4 text-primary">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                </h5>

                                <div class="mb-3">
                                    <label for="id_lahan" class="form-label">ID Lahan</label>
                                    <input type="text" class="form-control @error('id_lahan') is-invalid @enderror" 
                                           id="id_lahan" name="id_lahan" 
                                           value="{{ old('id_lahan', $perkebunan->id_lahan) }}" required>
                                    @error('id_lahan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Pemilik Lahan</label>
                                    <select class="form-select @error('user_id') is-invalid @enderror" 
                                            id="user_id" name="user_id">
                                        <option value="">Pilih Pemilik</option>
                                        @foreach($pekebuns as $pekebun)
                                            <option value="{{ $pekebun->id }}" 
                                                {{ old('user_id', $perkebunan->user_id) == $pekebun->id ? 'selected' : '' }}>
                                                {{ $pekebun->name }} ({{ $pekebun->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Kosongkan jika dimiliki oleh admin</div>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <select class="form-select @error('deskripsi') is-invalid @enderror" 
                                            id="deskripsi" name="deskripsi" required>
                                        <option value="">Pilih jenis...</option>
                                        <option value="Kebun Sawit" {{ old('deskripsi', $perkebunan->deskripsi) == 'Kebun Sawit' ? 'selected' : '' }}>Kebun Sawit</option>
                                        <option value="Titik Kumpul" {{ old('deskripsi', $perkebunan->deskripsi) == 'Titik Kumpul' ? 'selected' : '' }}>Titik Kumpul</option>
                                        <option value="Akses Jalan" {{ old('deskripsi', $perkebunan->deskripsi) == 'Akses Jalan' ? 'selected' : '' }}>Akses Jalan</option>
                                        <option value="Pabrik Pengolahan" {{ old('deskripsi', $perkebunan->deskripsi) == 'Pabrik Pengolahan' ? 'selected' : '' }}>Pabrik Pengolahan</option>
                                    </select>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="desa" class="form-label">Desa</label>
                                        <input type="text" class="form-control @error('desa') is-invalid @enderror" 
                                               id="desa" name="desa" 
                                               value="{{ old('desa', $perkebunan->desa) }}" required>
                                        @error('desa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="kecamatan" class="form-label">Kecamatan</label>
                                        <input type="text" class="form-control @error('kecamatan') is-invalid @enderror" 
                                               id="kecamatan" name="kecamatan" 
                                               value="{{ old('kecamatan', $perkebunan->kecamatan) }}" required>
                                        @error('kecamatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="mb-4 text-primary">
                                    <i class="fas fa-chart-line me-2"></i>Status & Pengukuran
                                </h5>

                                <div class="mb-3">
                                    <label for="status_ispo" class="form-label">Status ISPO</label>
                                    <select class="form-select @error('status_ispo') is-invalid @enderror" 
                                            id="status_ispo" name="status_ispo" required>
                                        <option value="">Pilih status...</option>
                                        <option value="Lulus" {{ old('status_ispo', $perkebunan->status_ispo) == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                        <option value="Dalam Proses" {{ old('status_ispo', $perkebunan->status_ispo) == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                                        <option value="Perlu Perbaikan" {{ old('status_ispo', $perkebunan->status_ispo) == 'Perlu Perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                                    </select>
                                    @error('status_ispo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tingkat_kesiapan" class="form-label">Tingkat Kesiapan</label>
                                    <select class="form-select @error('tingkat_kesiapan') is-invalid @enderror" 
                                            id="tingkat_kesiapan" name="tingkat_kesiapan" required>
                                        <option value="">Pilih tingkat...</option>
                                        <option value="Siap" {{ old('tingkat_kesiapan', $perkebunan->tingkat_kesiapan) == 'Siap' ? 'selected' : '' }}>Siap</option>
                                        <option value="Dalam Evaluasi" {{ old('tingkat_kesiapan', $perkebunan->tingkat_kesiapan) == 'Dalam Evaluasi' ? 'selected' : '' }}>Dalam Evaluasi</option>
                                        <option value="Belum Siap" {{ old('tingkat_kesiapan', $perkebunan->tingkat_kesiapan) == 'Belum Siap' ? 'selected' : '' }}>Belum Siap</option>
                                    </select>
                                    @error('tingkat_kesiapan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="luas_lahan" class="form-label">Luas Lahan (ha)</label>
                                    <input type="number" step="0.01" class="form-control @error('luas_lahan') is-invalid @enderror" 
                                           id="luas_lahan" name="luas_lahan" 
                                           value="{{ old('luas_lahan', $perkebunan->luas_lahan) }}" required>
                                    @error('luas_lahan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="geometry_type" class="form-label">Tipe Geometri</label>
                                    <select class="form-select @error('geometry_type') is-invalid @enderror" 
                                            id="geometry_type" name="geometry_type" required>
                                        <option value="">Pilih tipe...</option>
                                        <option value="polygon" {{ old('geometry_type', $perkebunan->geometry_type) == 'polygon' ? 'selected' : '' }}>Polygon</option>
                                        <option value="point" {{ old('geometry_type', $perkebunan->geometry_type) == 'point' ? 'selected' : '' }}>Point</option>
                                        <option value="polyline" {{ old('geometry_type', $perkebunan->geometry_type) == 'polyline' ? 'selected' : '' }}>Polyline</option>
                                    </select>
                                    @error('geometry_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-4 text-primary">
                                    <i class="fas fa-map-marked-alt me-2"></i>Data Spasial
                                </h5>

                                <div class="mb-3">
                                    <label for="geometry" class="form-label">Data Geometry (Format GeoJSON)</label>
                                    <textarea class="form-control @error('geometry') is-invalid @enderror" 
                                              id="geometry" name="geometry" rows="8" required
                                              placeholder='Contoh: {"type": "Point", "coordinates": [101.45, 0.51]}'>{{ old('geometry', $perkebunan->geometry ? json_encode($perkebunan->geometry, JSON_PRETTY_PRINT) : '') }}</textarea>
                                    @error('geometry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Format GeoJSON. Pastikan format JSON valid.<br>
                                        Untuk Point: {"type": "Point", "coordinates": [lng, lat]}<br>
                                        Untuk Polygon: {"type": "Polygon", "coordinates": [[[lng,lat], [lng,lat], ...]]}
                                    </div>
                                </div>

                                <div class="alert alert-warning">
                                    <small>
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Pastikan data geometry dalam format JSON yang valid. 
                                        Jika tidak yakin, salin data dari halaman detail.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('admin.pemetaan.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i> Perbarui Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Validasi form sebelum submit
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(e) {
            const geometryField = document.getElementById('geometry');
            
            try {
                // Validasi JSON
                if (geometryField.value.trim()) {
                    JSON.parse(geometryField.value);
                }
            } catch (error) {
                e.preventDefault();
                alert('Format Geometry JSON tidak valid! Silakan periksa kembali data GeoJSON.');
                geometryField.focus();
            }
        });

        // Auto-format JSON saat focus out
        document.getElementById('geometry').addEventListener('blur', function() {
            try {
                const jsonData = JSON.parse(this.value);
                this.value = JSON.stringify(jsonData, null, 2);
            } catch (error) {
                // Biarkan seperti apa adanya jika JSON invalid
                console.log('JSON tidak valid, tidak diformat ulang');
            }
        });
    });
</script>
@endsection