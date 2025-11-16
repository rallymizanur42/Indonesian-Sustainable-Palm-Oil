@extends('layouts.app')

@section('content')
<style>
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
                        <i class="fas fa-table me-2"></i> Data Spasial Perkebunan
                    </h4>
                    <a href="{{ route('admin.pemetaan.create') }}" class="btn btn-light">
                        <i class="fas fa-plus me-2"></i> Tambah Data Baru
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Filter -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan ID, Desa, atau Kecamatan...">
                        </div>
                        <div class="col-md-4">
                            <select id="statusFilter" class="form-select">
                                <option value="">Semua Status ISPO</option>
                                <option value="Lulus">Lulus</option>
                                <option value="Dalam Proses">Dalam Proses</option>
                                <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ID Lahan</th>
                                    <th scope="col">Tipe</th>
                                    <th scope="col">Lokasi</th>
                                    <th scope="col" class="text-center">Status ISPO</th>
                                    <th scope="col" class="text-center">Luas (ha)</th>
                                    <th scope="col" class="text-center">Pemilik</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="pemetaanTable">
                                @forelse ($perkebunans as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td class="fw-bold">{{ $item->id_lahan }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>{{ $item->desa }}, {{ $item->kecamatan }}</td>
                                    <td class="text-center">
                                        @php
                                            $badgeClass = '';
                                            if ($item->status_ispo == 'Lulus') $badgeClass = 'bg-success';
                                            elseif ($item->status_ispo == 'Dalam Proses') $badgeClass = 'bg-warning text-dark';
                                            elseif ($item->status_ispo == 'Perlu Perbaikan') $badgeClass = 'bg-danger';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $item->status_ispo }}</span>
                                    </td>
                                    <td class="text-center">{{ $item->luas_lahan }}</td>
                                    <td class="text-center">{{ $item->pekebun->name ?? 'Admin' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.pemetaan.show', $item->id) }}" class="btn btn-sm btn-info btn-action" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.pemetaan.edit', $item->id) }}" class="btn btn-sm btn-warning btn-action" title="Edit Data">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger btn-action delete-btn" 
                                                data-id="{{ $item->id }}" 
                                                data-name="{{ $item->id_lahan }}"
                                                title="Hapus Data">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
                        <div class="text-muted mb-2 mb-md-0">
                            Menampilkan <strong>{{ $perkebunans->firstItem() }}</strong> - <strong>{{ $perkebunans->lastItem() }}</strong> dari <strong>{{ $perkebunans->total() }}</strong> data
                        </div>
                        <div>
                            {{ $perkebunans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form untuk delete -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function filterTable() {
        const searchText = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const rows = document.querySelectorAll('#pemetaanTable tr');
        
        rows.forEach((row) => {
            if (row.cells.length > 1) {
                const idLahan = row.cells[1].textContent.toLowerCase();
                const lokasi = row.cells[3].textContent.toLowerCase();
                const status = row.cells[4].textContent;
                const matchesSearch = idLahan.includes(searchText) || lokasi.includes(searchText);
                const matchesStatus = statusFilter === '' || status === statusFilter;
                row.style.display = matchesSearch && matchesStatus ? '' : 'none';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('statusFilter').addEventListener('change', filterTable);

        // SweetAlert untuk konfirmasi hapus
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                const itemName = this.getAttribute('data-name');
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    html: `Data <strong>${itemName}</strong> akan dihapus permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Set form action dan submit
                        const form = document.getElementById('deleteForm');
                        form.action = `{{ url('admin/pemetaan') }}/${itemId}`;
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection