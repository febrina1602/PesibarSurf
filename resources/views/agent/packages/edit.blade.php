@extends('layouts.agent') {{-- Menggunakan layout agen --}}

@section('title', 'Edit Paket Tour - PesibarSurf')

@push('styles')
<style>
    /* Style untuk form agar konsisten */
    .profile-card .form-control,
    .profile-card .form-select { 
        height: 46px; border-radius: 10px; 
    }
    .profile-card .form-label { font-weight: 600; color: #333; }
    .profile-card textarea.form-control { height: auto; }
    
    /* Style tombol gradien */
    .btn-pesibar-grad {
        background: linear-gradient(to right, #FFE75D, #D19878);
        border: none; color: #333; font-weight: 600;
        height: 48px; border-radius: 12px; font-size: 1.1rem;
    }
    .btn-pesibar-grad:hover {
        filter: brightness(0.95); color: #333;
    }
</style>
@endpush

@section('agent_content') {{-- Mengisi konten layout agen --}}
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3 fw-bold mb-0 text-dark">Edit Paket Tour</h1>
                <a href="{{ route('agent.packages.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Paket
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <h5 class="alert-heading">Oops! Ada yang salah:</h5>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-4 profile-card">
                <div class="card-body p-4 p-md-5">
                    
                    {{-- Ubah action ke 'update' dan tambahkan @method('PUT') --}}
                    <form action="{{ route('agent.packages.update', $tourPackage->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <h5 class="fw-bold mb-3">Informasi Dasar</h5>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Paket</label>
                            {{-- Isi value dengan data yang ada --}}
                            <input type="text" class="form-control" id="name" name="name" 
                                   placeholder="Contoh: Trip Snorkeling Pahawang 1 Hari" 
                                   value="{{ old('name', $tourPackage->name) }}" required>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="duration" class="form-label">Durasi</label>
                                    {{-- Isi value dengan data yang ada --}}
                                    <input type="text" class="form-control" id="duration" name="duration" 
                                           placeholder="Contoh: 1 Hari, 2 Hari 1 Malam" 
                                           value="{{ old('duration', $tourPackage->duration) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="price_per_person" class="form-label">Harga per Orang (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                {{-- Isi value dengan data yang ada --}}
                                <input type="number" class="form-control" id="price_per_person" 
                                       name="price_per_person" placeholder="Contoh: 150000" 
                                       value="{{ old('price_per_person', $tourPackage->price_per_person) }}" min="0" required>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="fw-bold mb-3">Detail Paket</h5>

                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Upload Gambar Cover Baru (Opsional)</label>
                            <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/jpg">
                            <div class="form-text">Kosongkan jika tidak ingin mengubah gambar.</div>
                            {{-- Tampilkan gambar yang ada saat ini --}}
                            @if($tourPackage->cover_image_url)
                            <div class="mt-2">
                                <p class="small mb-1">Gambar Saat Ini:</p>
                                <img src="{{ $tourPackage->cover_image_url }}" alt="Cover Saat Ini" style="height: 100px; width: auto; border-radius: 8px; object-fit: cover;">
                            </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="destinations_visited" class="form-label">Destinasi yang Dikunjungi</label>
                            {{-- Isi textarea dengan data yang ada --}}
                            <textarea class="form-control" id="destinations_visited" name="destinations_visited" rows="4" 
                                      placeholder="Pisahkan dengan koma (,) atau baris baru.&#10;Contoh:&#10;- Pantai Pahawang&#10;- Gunung Rajabasa&#10;- Pulau Tegal Mas">{{ old('destinations_visited', $tourPackage->destinations_visited) }}</textarea>
                            <div class="form-text">Masukkan satu destinasi per baris, atau pisahkan dengan koma.</div>
                        </div>

                        <div class="mb-3">
                            <label for="facilities" class="form-label">Fasilitas Termasuk</label>
                            {{-- Isi textarea dengan data yang ada --}}
                            <textarea class="form-control" id="facilities" name="facilities" rows="4" 
                                      placeholder="Pisahkan dengan koma (,) atau baris baru.&#10;Contoh:&#10;- Tiket Masuk&#10;- Makan Siang&#10;- Pemandu">{{ old('facilities', $tourPackage->facilities) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Lengkap Paket</label>
                            {{-- Isi textarea dengan data yang ada --}}
                            <textarea class="form-control" id="description" name="description" rows="5" 
                                      placeholder="Jelaskan detail itinerary, apa yang dibawa, dll.">{{ old('description', $tourPackage->description) }}</textarea>
                        </div>

                        <div class="d-grid mt-4 pt-2">
                            <button type="submit" class="btn btn-pesibar-grad">
                                <i class="fas fa-save me-2"></i> Ubah Paket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection