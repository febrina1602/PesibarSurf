@extends('layouts.admin')

@section('title', 'Edit Kategori - PesibarSurf')

@section('admin_content')

    <h1 class="h3 mb-4 text-gray-800">Edit Kategori: {{ $category->name }}</h1>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header border-0 py-3">
            <h6 class="m-0 fw-bold text-dark">Formulir Edit Kategori</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="icon_url" class="form-label">Ganti Ikon Kategori</label>
                    <div class="my-2">
                        <img src="{{ asset('storage/' . $category->icon_url) }}" 
                             alt="{{ $category->name }}" 
                             style="width: 100px; height: auto; border-radius: 8px;"
                             onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';">
                    </div>
                    <input type="file" class="form-control @error('icon_url') is-invalid @enderror" 
                           id="icon_url" name="icon_url" accept="image/jpeg,png,jpg,webp">
                    <div class="form-text">Opsional. Kosongkan jika tidak ingin mengubah ikon.</div>
                    @error('icon_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

@endsection