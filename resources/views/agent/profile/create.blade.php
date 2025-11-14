@extends('layouts.agent') {{-- MEWARISI LAYOUT BARU --}}

@section('title', 'Buat Profil Agensi - PesibarSurf')

@push('styles')
<style>
    .profile-card .form-control { height: 46px; border-radius: 10px; }
    .profile-card .form-label { font-weight: 600; color: #333; }
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

@section('agent_content') {{-- NAMA SECTION BARU --}}
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            @if(session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif

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
                    <h2 class="h3 fw-bold text-dark text-center mb-1">Buat Profil Agensi Anda</h2>
                    <p class="text-muted text-center mb-4">Lengkapi data di bawah ini untuk mendaftarkan agensi Anda secara resmi.</p>
                    
                    <form action="{{ route('agent.profile.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="agent_type" class="form-label">Jenis Agensi Anda</label>
                            <select class="form-select form-control" id="agent_type" name="agent_type" required>
                                <option value="" selected disabled>-- Pilih Jenis Agensi --</option>
                                <option value="TOUR" {{ old('agent_type') == 'TOUR' ? 'selected' : '' }}>Agen Tour (Paket Wisata)</option>
                                <option value="RENTAL" {{ old('agent_type') == 'RENTAL' ? 'selected' : '' }}>Rental (Mobil / Motor)</option>
                                <option value="BOTH" {{ old('agent_type') == 'BOTH' ? 'selected' : '' }}>Keduanya (Tour & Rental)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Agensi</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   placeholder="Contoh: FebrnTravel, Pesona Lampung Tour" 
                                   value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat Lengkap Agensi</label>
                            <textarea class="form-control" id="address" name="address" rows="3" 
                                      placeholder="Masukkan alamat lengkap kantor atau lokasi agensi Anda" 
                                      required>{{ old('address') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Singkat Agensi</label>
                            <textarea class="form-control" id="description" name="description" rows="4" 
                                      placeholder="Jelaskan tentang agensi Anda, layanan yang ditawarkan, dll.">{{ old('description') }}</textarea>
                        </div>

                        <hr class="my-4">
                        <h5 class="fw-bold mb-3">Berkas Kemitraan</h5>

                        <div class="mb-3">
                            <label for="banner_image" class="form-label">Upload Gambar Banner</label>
                            <input type="file" class="form-control" id="banner_image" name="banner_image" accept="image/jpeg,image/png,image/jpg">
                            <div class="form-text">Opsional. (JPG, PNG maks 2MB)</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="file_ktp" class="form-label">Upload Scan KTP Penanggung Jawab</label>
                            <input type="file" class="form-control" id="file_ktp" name="file_ktp" accept="image/jpeg,image/png,image/jpg,application/pdf" required>
                            <div class="form-text">Wajib. (PDF, JPG, PNG maks 2MB)</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="file_siup" class="form-label">Upload Scan SIUP/SKU/NIB</label>
                            <input type="file" class="form-control" id="file_siup" name="file_siup" accept="image/jpeg,image/png,image/jpg,application/pdf">
                            <div class="form-text">Opsional. (PDF, JPG, PNG maks 2MB)</div>
                        </div>

                        <div class="d-grid mt-4 pt-2">
                            <button type="submit" class="btn btn-pesibar-grad">
                                <i class="fas fa-save me-2"></i> Kirim Pengajuan Profil
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection