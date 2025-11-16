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
    .table-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }
</style>

<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header-pemetaan d-flex justify-content-between align-items-center">
                    <h4 class="card-title-pemetaan">
                        <i class="fas fa-newspaper me-2"></i> Manajemen Informasi ISPO
                    </h4>
                    <a href="{{ route('admin.informasi.create') }}" class="btn btn-light">
                        <i class="fas fa-plus me-2"></i> Tambah Informasi
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Gambar</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Syarat ISPO</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Terakhir Diperbarui</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($informasi as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>
                                        @if($item->gambar)
                                            <img src="{{ asset('storage/informasi/' . $item->gambar) }}" alt="Gambar" class="table-image">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ $item->syarat_ispo ?? '-' }}</td>
                                    <td>{{ $item->deskripsi ?? '-' }}</td>
                                    <td>{{ $item->updated_at->format('d M Y, H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.informasi.edit', $item->id) }}" class="btn btn-sm btn-warning btn-action" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.informasi.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus informasi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-action" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data informasi.</td>
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