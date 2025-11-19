@extends('layouts.agent') {{-- MEWARISI LAYOUT BARU --}}

@section('title', 'Edit Profil Agensi - PesibarSurf')

@push('styles')
<style>
    .profile-card .form-control { height: 46px; border-radius: 10px; }
    .profile-card .form-label { font-weight: 600; color: #333; }
    .btn-grad-agent { background: linear-gradient(90deg, #FFD15C, #FF3D3D); color: #fff; border: none; height: 48px; border-radius: 12px; font-weight: 700; font-size: 1.1rem; }
    .btn-grad-agent:hover { filter: brightness(.96); color: #fff; }
    .profile-picture-preview {
        width: 100px; height: 100px; object-fit: cover; border-radius: 50%;
        border: 4px solid #eee; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <h5 class="alert-heading">Oops! Ada yang salah:</h5>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-4 profile-card">
                <div class="card-body p-4 p-md-5">
                    <h2 class="h3 fw-bold text-dark text-center mb-3">Edit Profil Agensi</h2>
                    
                    @if ($agent->is_verified)
                        <div class="alert alert-success text-center">
                            <i class="fas fa-check-circle me-1"></i> Profil Anda sudah **Terverifikasi**.
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-hourglass-half me-1"></i> Profil Anda sedang **Ditinjau oleh Admin**.
                        </div>
                    @endif
                    
                    <form action="{{ route('agent.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 

                        <h5 class="fw-bold mb-3 mt-4">Informasi Akun</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">Foto Profil Akun</label>
                            <div class="d-flex align-items-center">
                                <img src="{{ auth()->user()->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->full_name) . '&background=FFD15C&color=333&bold=true' }}" 
                                     alt="Foto Profil" id="profileImagePreview"
                                     class="profile-picture-preview me-3">
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(event)">
                                    <div class="form-text">Kosongkan jika tidak ingin mengubah foto profil. (JPG, PNG maks 2MB)</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Akun</label>
                            <input type="email" class="form-control" id="email" 
                                   value="{{ auth()->user()->email }}" disabled readonly>
                            <div class="form-text">Email tidak dapat diubah.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Nomor Telepon (WhatsApp)</label>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                                   value="{{ old('phone_number', auth()->user()->phone_number) }}" required>
                        </div>

                        <hr class="my-4">
                        <h5 class="fw-bold mb-3">Informasi Agensi</h5>

                        <div class="mb-3">
                            <label for="agent_type" class="form-label">Jenis Agensi Anda</label>
                            <select class="form-select form-control" id="agent_type" name="agent_type" required>
                                <option value="" disabled>-- Pilih Jenis Agensi --</option>
                                
                                <optgroup label="Pemandu Wisata">
                                    <option value="TOUR" {{ old('agent_type', $agent->agent_type) == 'TOUR' ? 'selected' : '' }}>Pemandu Wisata (Tour Guide)</option>
                                </optgroup>
                                
                                <optgroup label="Pasar Digital">
                                    <option value="PENGINAPAN" {{ old('agent_type', $agent->agent_type) == 'PENGINAPAN' ? 'selected' : '' }}>Penginapan (Hotel/Homestay)</option>
                                    <option value="OLEH_OLEH" {{ old('agent_type', $agent->agent_type) == 'OLEH_OLEH' ? 'selected' : '' }}>Toko Oleh-Oleh</option>
                                    <option value="RENTAL" {{ old('agent_type', $agent->agent_type) == 'RENTAL' ? 'selected' : '' }}>Rental Kendaraan (Daerah)</option>
                                    <option value="TRAVEL" {{ old('agent_type', $agent->agent_type) == 'TRAVEL' ? 'selected' : '' }}>Agen Travel (Antar Kota)</option>
                                     <option value="BUS" {{ old('agent_type', $agent->agent_type) == 'BUS' ? 'selected' : '' }}>Agen Bus (Antar Provinsi)</option>
                                </optgroup>
                                
                                <optgroup label="Lainnya">
                                     <option value="BOTH" {{ old('agent_type', $agent->agent_type) == 'BOTH' ? 'selected' : '' }}>Kombinasi (Tour & Rental)</option>
                                </optgroup>
                            </select>
                            <div class="form-text text-warning"><i class="fas fa-info-circle"></i> Mengubah jenis agensi akan mengubah menu yang tersedia di dashboard Anda.</div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Agensi</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name', $agent->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat Lengkap Agensi</label>
                            <textarea class="form-control" id="address" name="address" rows="3" 
                                      required>{{ old('address', $agent->address) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Singkat Agensi</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $agent->description) }}</textarea>
                        </div>

                        <hr class="my-4">
                        <h5 class="fw-bold mb-3">Berkas Kemitraan</h5>

                        <div class="mb-3">
                            <label for="banner_image" class="form-label">Upload Gambar Banner Baru (Opsional)</label>
                            <input type="file" class="form-control" id="banner_image" name="banner_image" accept="image/jpeg,image/png,image/jpg">
                            @if($agent->banner_image_url)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $agent->banner_image_url) }}" target="_blank" class="small text-decoration-none"><i class="fas fa-image"></i> Lihat Banner Saat Ini</a>
                            </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="file_ktp" class="form-label">Upload Scan KTP Baru (Opsional)</label>
                            <input type="file" class="form-control" id="file_ktp" name="file_ktp" accept="image/jpeg,image/png,image/jpg,application/pdf">
                            @if($agent->file_ktp_url)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $agent->file_ktp_url) }}" target="_blank" class="small text-decoration-none"><i class="fas fa-file-alt"></i> Lihat KTP Saat Ini</a>
                            </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="file_siup" class="form-label">Upload Scan SIUP/SKU/NIB Baru (Opsional)</label>
                            <input type="file" class="form-control" id="file_siup" name="file_siup" accept="image/jpeg,image/png,image/jpg,application/pdf">
                            @if($agent->file_siup_url)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $agent->file_siup_url) }}" target="_blank" class="small text-decoration-none"><i class="fas fa-file-contract"></i> Lihat SIUP Saat Ini</a>
                            </div>
                            @endif
                        </div>

                        <div class="d-grid mt-4 pt-2">
                            <button type="submit" class="btn btn-pesibar-grad">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Script untuk preview gambar profil
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('profileImagePreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
@endsection