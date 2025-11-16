@extends('layouts.app')

@section('content')
<style>
    /* Style yang sama seperti sebelumnya */
    :root {
        --primary-color: #2c7c3d;
        --secondary-color: #f5a623;
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
    .card-title-pemetaan {
        font-weight: 600;
        margin: 0;
    }
    .table thead {
        background-color: var(--primary-color);
        color: white;
    }
    .table th {
        font-weight: 600;
    }
    .btn-action {
        margin: 0 2px;
    }
</style>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header-pemetaan d-flex justify-content-between align-items-center">
                    <h4 class="card-title-pemetaan">
                        <i class="fas fa-tasks me-2"></i> Manajemen Kriteria DSS
                    </h4>
                    <a href="{{ route('admin.kriteria.create') }}" class="btn btn-light">
                        <i class="fas fa-plus me-2"></i> Tambah Kriteria Baru
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Kriteria</th>
                                    <th scope="col">Indikator</th>
                                    <th scope="col">Bobot (%)</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kriteria as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $item->nama_kriteria }}</td>
                                    <td>{{ $item->indikator }}</td>
                                    <td>{{ number_format($item->bobot, 2) }}%</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.kriteria.show', $item->id) }}" 
                                           class="btn btn-sm btn-info btn-action" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.kriteria.edit', $item->id) }}" 
                                           class="btn btn-sm btn-warning btn-action" 
                                           title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.kriteria.destroy', $item->id) }}" 
                                              method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Anda yakin ingin menghapus kriteria ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger btn-action" 
                                                    title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada data kriteria. Silakan tambahkan kriteria baru.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection