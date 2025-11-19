@extends('layouts.admin')

@section('title', 'Kelola Kategori Destinasi - PesibarSurf')

@section('admin_content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Kategori Destinasi</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah Kategori Baru
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
            <h6 class="m-0 fw-bold text-dark">Daftar Kategori</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Ikon</th>
                            <th>Nama Kategori</th>
                            <th>Total Destinasi</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $category->icon_url) }}" 
                                         alt="{{ $category->name }}" 
                                         style="width: 100%; height: 50px; object-fit: cover; border-radius: 4px;"
                                         onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';">
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->destinations_count }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}?');">
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
                                <td colspan="4" class="text-center">Belum ada data kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if ($categories->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $categories->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection