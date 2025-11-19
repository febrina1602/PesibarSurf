@extends('layouts.admin')

@section('title', 'Tambah Kategori Baru - PesibarSurf')

@section('admin_content')

    <h1 class="h3 mb-4 text-gray-800">Tambah Kategori Baru</h1>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header border-0 py-3">
            <h6 class="m-0 fw-bold text-dark">Formulir Kategori Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="icon_url" class="form-label">Ikon Kategori <span class="text-danger">*</span></label>
                    <input type="file" class="form-control @error('icon_url') is-invalid @enderror" 
                           id="icon_url" name="icon_url" accept="image/jpeg,png,jpg,webp" required>
                    <div class="form-text">Wajib. (JPG, PNG, WEBP maks 2MB)</div>
                    @error('icon_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

@endsection