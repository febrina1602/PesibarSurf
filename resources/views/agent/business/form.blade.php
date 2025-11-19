@extends('layouts.agent')

@section('title', ($data ?? false) ? 'Edit Usaha' : 'Tambah Usaha')

@push('styles')
<style>
    .btn-pesibar-grad { background: linear-gradient(to right, #FFE75D, #D19878); border: none; color: #333; font-weight: 600; }
</style>
@endpush

@section('agent_content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('agent.business.index') }}" class="btn btn-light me-3 rounded-circle shadow-sm"><i class="fas fa-arrow-left"></i></a>
                <h2 class="h4 fw-bold mb-0">{{ ($data ?? false) ? 'Edit Data Usaha' : 'Tambah Usaha Baru' }}</h2>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    {{-- ACTION FORM OTOMATIS: Jika ada $data -> Update, Jika tidak -> Store --}}
                    <form action="{{ ($data ?? false) ? route('agent.business.update', $data->id) : route('agent.business.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Kalau ada data, berarti metode update, tapi kita POST di route, jadi aman. Atau bisa tambah method --}}
                        {{-- Di route group saya pakai POST untuk update agar simple, tapi standardnya PUT --}}
                        
                        {{-- PASTE ISI FORM YANG TADI (DARI JAWABAN SEBELUMNYA) DI SINI --}}
                        {{-- Pastikan value-nya pakai null coalescing operator agar aman untuk Create --}}
                        {{-- Contoh: value="{{ old('name', $data->name ?? '') }}" --}}

                         <div class="row g-4">
                                {{-- KOLOM KIRI --}}
                                <div class="col-md-7">
                                    
                                    {{-- INPUT: TYPE (HANYA UNTUK TRANSPORT) --}}
                                    @if(in_array($agent->agent_type, ['RENTAL', 'BOTH']))
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Jenis Kendaraan <span class="text-danger">*</span></label>
                                            <select class="form-select" name="type" required>
                                                <option value="mobil" {{ (old('type', $data->type ?? '') == 'mobil') ? 'selected' : '' }}>Mobil</option>
                                                <option value="motor" {{ (old('type', $data->type ?? '') == 'motor') ? 'selected' : '' }}>Motor</option>
                                            </select>
                                        </div>
                                    @elseif(in_array($agent->agent_type, ['TRAVEL', 'BUS']))
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Jenis Layanan <span class="text-danger">*</span></label>
                                            <select class="form-select" name="type" required>
                                                <option value="travel" {{ (old('type', $data->type ?? '') == 'travel') ? 'selected' : '' }}>Travel</option>
                                                <option value="bus" {{ (old('type', $data->type ?? '') == 'bus') ? 'selected' : '' }}>Bus Antar Kota</option>
                                            </select>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Usaha / Toko <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" 
                                               value="{{ old('name', $data->name ?? '') }}" 
                                               placeholder="Contoh: Homestay Krui Indah" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Lokasi Singkat <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="location" 
                                               value="{{ old('location', $data->location ?? '') }}"
                                               placeholder="Contoh: Jl. Pantai Wisata, Krui Selatan" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Rating (0 - 5) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.1" min="0" max="5" class="form-control" name="rating" 
                                               value="{{ old('rating', $data->rating ?? 4.5) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">WhatsApp Bisnis <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="whatsapp" 
                                               value="{{ old('whatsapp', $data->whatsapp ?? $agent->user->phone_number) }}" 
                                               required>
                                    </div>

                                    {{-- HARGA --}}
                                    @if($agent->agent_type == 'PENGINAPAN')
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-primary">Harga Mulai (Rp)</label>
                                            <input type="text" class="form-control" name="price_start" 
                                                   value="{{ old('price_start', $data->price_start ?? '') }}"
                                                   placeholder="Contoh: Rp 350.000/malam">
                                        </div>
                                    @else
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-primary">Kisaran Harga</label>
                                            <input type="text" class="form-control" name="price_range" 
                                                   value="{{ old('price_range', $data->price_range ?? '') }}"
                                                   placeholder="Contoh: Mulai Rp 50.000 - Rp 150.000">
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Deskripsi Lengkap <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="description" rows="5" required>{{ old('description', $data->description ?? '') }}</textarea>
                                    </div>
                                </div>

                                {{-- KOLOM KANAN (GAMBAR) --}}
                                <div class="col-md-5">
                                    <label class="form-label fw-bold">Foto Utama</label>
                                    <div class="card bg-light border-0 mb-2 text-center overflow-hidden" style="height: 250px;">
                                        @if(($data ?? false) && $data->image)
                                            <img src="{{ asset('storage/' . $data->image) }}" class="w-100 h-100 object-fit-cover" alt="Foto Usaha">
                                        @else
                                            <div class="d-flex flex-column justify-content-center h-100 text-muted">
                                                <i class="fas fa-image fa-3x mb-2"></i>
                                                <p class="small mb-0">Belum ada foto</p>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" class="form-control" name="image" accept="image/*" {{ ($data ?? false) ? '' : 'required' }}>
                                </div>
                            </div>

                        <hr class="mt-4">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-pesibar-grad px-5 py-2 rounded-pill">
                                <i class="fas fa-save me-2"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection