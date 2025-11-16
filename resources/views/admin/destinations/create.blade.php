@extends('layouts.admin')

@section('title', 'Tambah Destinasi Baru - PesibarSurf')

@section('admin_content')

    <h1 class="h3 mb-4 text-gray-800">Tambah Destinasi Baru</h1>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header border-0 py-3">
            <h6 class="m-0 fw-bold text-dark">Formulir Destinasi Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Destinasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" name="address" rows="2" required>{{ old('address') }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="maps_url" class="form-label">URL Google Maps (Opsional)</label>
                    <input type="url" class="form-control @error('maps_url') is-invalid @enderror" 
                           id="maps_url" name="maps_url" value="{{ old('maps_url') }}" placeholder="Salin-tempel URL dari Google Maps untuk ambil koordinat">
                    @error('maps_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price_per_person" class="form-label">Harga Tiket per Orang <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('price_per_person') is-invalid @enderror" 
                                   id="price_per_person" name="price_per_person" value="{{ old('price_per_person', 0) }}" required>
                            @error('price_per_person') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="parking_price" class="form-label">Harga Parkir (Motor/Mobil) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('parking_price') is-invalid @enderror" 
                                   id="parking_price" name="parking_price" value="{{ old('parking_price', 0) }}" required>
                            @error('parking_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="facilities" class="form-label">Fasilitas (Opsional)</label>
                    <input type="text" class="form-control @error('facilities') is-invalid @enderror" 
                           id="facilities" name="facilities" value="{{ old('facilities') }}" placeholder="Contoh: Toilet, Mushola, Warung Makan">
                    <div class="form-text">Pisahkan dengan koma.</div>
                    @error('facilities') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="popular_activities" class="form-label">Aktivitas Populer (Opsional)</label>
                    <input type="text" class="form-control @error('popular_activities') is-invalid @enderror" 
                           id="popular_activities" name="popular_activities" value="{{ old('popular_activities') }}" placeholder="Contoh: Surfing, Foto Sunset, Berenang">
                    <div class="form-text">Pisahkan dengan koma. (Akan disimpan sebagai array)</div>
                    @error('popular_activities') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="image_url" class="form-label">Gambar Utama <span class="text-danger">*</span></label>
                    <input type="file" class="form-control @error('image_url') is-invalid @enderror" 
                           id="image_url" name="image_url" accept="image/jpeg,png,jpg,webp" required>
                    @error('image_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating Awal (0.0 - 5.0) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" max="5" class="form-control @error('rating') is-invalid @enderror" 
                                   id="rating" name="rating" value="{{ old('rating', 0) }}" required>
                            @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                Tampilkan di Halaman Depan (Featured)
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Destinasi</button>
                <a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

@endsection