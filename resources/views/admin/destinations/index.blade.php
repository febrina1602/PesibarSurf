@extends('layouts.admin')

@section('title', 'Kelola Destinasi - PesibarSurf')

@section('admin_content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Destinasi</h1>
        <a href="{{ route('admin.destinations.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah Destinasi Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header border-0 py-3">
            <h6 class="m-0 fw-bold text-dark">Daftar Destinasi Wisata</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Gambar</th>
                            <th>Nama Destinasi</th>
                            <th>Kategori</th>
                            <th>Alamat</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($destinations as $destination)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $destination->image_url) }}" 
                                         alt="{{ $destination->name }}" 
                                         style="width: 100%; height: 50px; object-fit: cover; border-radius: 4px;"
                                         onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';">
                                </td>
                                <td>{{ $destination->name }}</td>
                                <td>{{ $destination->category->name ?? 'Tanpa Kategori' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($destination->address, 50) }}</td>
                                <td>
                                    <a href="{{ route('admin.destinations.edit', $destination->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.destinations.destroy', $destination->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus destinasi {{ $destination->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data destinasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if ($destinations->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $destinations->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection