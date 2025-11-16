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
</style>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header-pemetaan d-flex justify-content-between align-items-center">
                    <h4 class="card-title-pemetaan">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Informasi Baru
                    </h4>
                    <a href="{{ route('admin.informasi.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.informasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="judul" class="form-label fw-bold">Judul *</label>
                            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required maxlength="100">
                        </div>

                        <div class="mb-3">
                            <label for="syarat_ispo" class="form-label fw-bold">Syarat ISPO</label>
                            <input type="text" class="form-control" id="syarat_ispo" name="syarat_ispo" value="{{ old('syarat_ispo') }}" maxlength="100">
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ old('deskripsi') }}" maxlength="100">
                        </div>

                        <div class="mb-3">
                            <label for="manfaat" class="form-label fw-bold">Manfaat</label>
                            <input type="text" class="form-control" id="manfaat" name="manfaat" value="{{ old('manfaat') }}" maxlength="100">
                        </div>

                        <div class="mb-3">
                            <label for="fitur" class="form-label fw-bold">Fitur</label>
                            <input type="text" class="form-control" id="fitur" name="fitur" value="{{ old('fitur') }}" maxlength="100">
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label fw-bold">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                            <div class="form-text">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color);">
                                <i class="fas fa-save me-2"></i> Simpan Informasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection