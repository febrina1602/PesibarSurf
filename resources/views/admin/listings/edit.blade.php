@extends('layouts.admin')

@section('title', 'Edit Paket Wisata')

@section('admin_content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.listings.index') }}" class="btn btn-light shadow-sm me-3 rounded-circle">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h1 class="h3 mb-0 text-gray-800">Edit Paket Wisata</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Data Paket</h6>
    </div>
    <div class="card-body">
        {{-- Route update otomatis mengarah ke tours.update sesuai controller sebelumnya --}}
        <form action="{{ route('admin.listings.tours.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- 1. NAMA PAKET --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Paket Wisata</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $data->name) }}" required>
            </div>

            <div class="row">
                {{-- 2. HARGA PER ORANG --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Harga per Orang (Rp)</label>
                    <input type="number" name="price_per_person" class="form-control" value="{{ old('price_per_person', $data->price_per_person) }}" required>
                </div>
                
                {{-- 3. DURASI --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Durasi</label>
                    <input type="text" name="duration" class="form-control" value="{{ old('duration', $data->duration) }}" placeholder="Contoh: 3 Hari 2 Malam" required>
                </div>
            </div>

            {{-- 4. DESKRIPSI --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi Paket</label>
                <textarea name="description" class="form-control" rows="5">{{ old('description', $data->description) }}</textarea>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

@endsection