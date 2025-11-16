@extends('layouts.admin')

@section('title', 'Edit Destinasi - PesibarSurf')

@section('admin_content')

    <h1 class="h3 mb-4 text-gray-800">Edit Destinasi: {{ $destination->name }}</h1>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header border-0 py-3">
            <h6 class="m-0 fw-bold text-dark">Formulir Edit Destinasi</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.destinations.update', $destination->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Destinasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $destination->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="" disabled>Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $destination->category_id) == $category->id ? 'selected' : '' }}>
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
                              id="address" name="address" rows="2" required>{{ old('address', $destination->address) }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="maps_url" class="form-label">URL Google Maps (Opsional)</label>
                    <input type="url" class="form-control @error('maps_url') is-invalid @enderror" 
                           id="maps_url" name="maps_url" value="{{ old('maps_url') }}" placeholder="Masukkan URL baru jika ingin mengubah koordinat">
                    @if($destination->latitude && $destination->longitude)
                        <div class="form-text text-success">
                            Lokasi tersimpan: {{ $destination->latitude }}, {{ $destination->longitude }}
                        </div>
                    @endif
                    @error('maps_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price_per_person" class="form-label">Harga Tiket per Orang <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('price_per_person') is-invalid @enderror" 
                                   id="price_per_person" name="price_per_person" value="{{ old('price_per_person', $destination->price_per_person) }}" required>
                            @error('price_per_person') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="parking_price" class="form-label">Harga Parkir (Motor/Mobil) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('parking_price') is-invalid @enderror" 
                                   id="parking_price" name="parking_price" value="{{ old('parking_price', $destination->parking_price) }}" required>
                            @error('parking_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="5" required>{{ old('description', $destination->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="facilities" class="form-label">Fasilitas (Opsional)</label>
                    <input type="text" class="form-control @error('facilities') is-invalid @enderror" 
                           id="facilities" name="facilities" value="{{ old('facilities', $destination->facilities) }}" placeholder="Contoh: Toilet, Mushola, Warung Makan">
                    <div class="form-text">Pisahkan dengan koma.</div>
                    @error('facilities') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="popular_activities" class="form-label">Aktivitas Populer (Opsional)</label>
                    {{-- Karena ini array, kita ubah jadi string untuk ditampilkan di input --}}
                    @php
                        $activities = is_array($destination->popular_activities) ? implode(', ', $destination->popular_activities) : $destination->popular_activities;
                    @endphp
                    <input type="text" class="form-control @error('popular_activities') is-invalid @enderror" 
                           id="popular_activities" name="popular_activities" value="{{ old('popular_activities', $activities) }}" placeholder="Contoh: Surfing, Foto Sunset, Berenang">
                    <div class="form-text">Pisahkan dengan koma.</div>
                    @error('popular_activities') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="image_url" class="form-label">Ganti Gambar Utama</label>
                    <div class="my-2">
                        <img src="{{ asset('storage/' . $destination->image_url) }}" alt="{{ $destination->name }}" style="width: 200px; height: auto; border-radius: 8px;"
                             onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';">
                    </div>
                    <input type="file" class="form-control @error('image_url') is-invalid @enderror" 
                           id="image_url" name="image_url" accept="image/jpeg,png,jpg,webp">
                    <div class_text">Opsional. Kosongkan jika tidak ingin mengubah gambar.</div>
                    @error('image_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating (0.0 - 5.0) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" max="5" class="form-control @error('rating') is-invalid @enderror" 
                                   id="rating" name="rating" value="{{ old('rating', $destination->rating) }}" required>
                            @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   {{ old('is_featured', $destination->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                Tampilkan di Halaman Depan (Featured)
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

@endsection