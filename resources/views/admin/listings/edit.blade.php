@extends('layouts.admin')

@section('title', 'Edit Paket Usaha - Admin')

@section('admin_content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.listings.index') }}" class="btn btn-light shadow-sm me-3 rounded-circle">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h1 class="h3 mb-0 text-gray-800">Edit Data Paket Usaha</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Data ({{ ucfirst($type) }})</h6>
    </div>
    <div class="card-body">
        <form action="{{ route($routeUpdate, $data->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- 1. NAMA (Semua Punya) --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Usaha</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $data->name) }}" required>
            </div>

            {{-- 2. LOKASI (Semua KECUALI Tour & TransLocal) --}}
            @if(!in_array($type, ['tour', 'trans_local']))
                <div class="mb-3">
                    <label class="form-label fw-bold">Lokasi / Rute</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $data->location) }}">
                </div>
            @endif

            {{-- 3. HARGA (Nama Kolom Beda-beda) --}}
            @if($type == 'tour')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Harga per Orang (Rp)</label>
                        <input type="number" name="price_per_person" class="form-control" value="{{ old('price_per_person', $data->price_per_person) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Durasi</label>
                        <input type="text" name="duration" class="form-control" value="{{ old('duration', $data->duration) }}">
                    </div>
                </div>

            @elseif($type == 'stay')
                <div class="mb-3">
                    <label class="form-label fw-bold">Harga Mulai (Text)</label>
                    <input type="text" name="price_start" class="form-control" value="{{ old('price_start', $data->price_start) }}">
                    <small class="text-muted">Contoh: Rp 300.000 / malam</small>
                </div>

            @elseif($type == 'oleh' || $type == 'trans_local')
                <div class="mb-3">
                    <label class="form-label fw-bold">Kisaran Harga</label>
                    <input type="text" name="price_range" class="form-control" value="{{ old('price_range', $data->price_range) }}">
                </div>
            @endif

            {{-- 4. DESKRIPSI (Semua Punya) --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi</label>
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