@extends('layouts.agent') 

@section('title', 'Dashboard Agen - PesibarSurf')

@push('styles')
<style>
    .card-disabled {
        background-color: #f8f9fa; border-style: dashed; opacity: 0.7;
    }
    .btn-pesibar-grad {
        background: linear-gradient(to right, #FFE75D, #D19878);
        border: none; color: #333; font-weight: 600;
    }
    .btn-pesibar-grad:hover {
        filter: brightness(0.95); color: #333;
    }
</style>
@endpush

@section('agent_content')
<div class="container py-5">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($agent) 
        
        <div class="row g-4">
            
            {{-- KOLOM KIRI: KARTU DETAIL AGEN --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 position-sticky" style="top: 2rem;">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            {{-- GAMBAR PROFIL --}}
                            <img src="{{ $agent->user->profile_picture_url ? asset(str_replace('public/', '', $agent->user->profile_picture_url)) : 'https://ui-avatars.com/api/?name=' . urlencode($agent->user->full_name) . '&background=FFD15C&color=333&bold=true' }}" 
                                 alt="Profil" class="mb-2"
                                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #eee;"
                                 onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($agent->name) }}&background=FFD15C&color=333&bold=true';">
                            
                            <h5 class="fw-bold mt-2 mb-1">{{ $agent->name }}</h5>
                            <p class="small text-muted mb-2">{{ $agent->user->email }}</p>
                            
                            @if ($agent->is_verified)
                                <span class="badge bg-success-subtle text-success-emphasis rounded-pill py-2 px-3">
                                    <i class="fas fa-check-circle me-1"></i> Terverifikasi
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill py-2 px-3">
                                    <i class="fas fa-hourglass-half me-1"></i> Menunggu Tinjauan
                                </span>
                            @endif
                        </div>
                        <hr>
                        <ul class="list-unstyled text-muted small mt-3">
                            <li class="mb-2 d-flex">
                                <i class="fas fa-phone fa-fw me-2 mt-1 text-danger"></i>
                                <span>{{ $agent->user->phone_number ?? 'Belum diisi' }}</span>
                            </li>
                            <li class="mb-2 d-flex">
                                <i class="fas fa-map-marker-alt fa-fw me-2 mt-1 text-danger"></i>
                                <span>{{ $agent->address ?? 'Belum diisi' }}</span>
                            </li>
                            <li class="mb-2 d-flex">
                                <i class="fas fa-info-circle fa-fw me-2 mt-1 text-danger"></i>
                                <span>Agen Wisata</span>
                            </li>
                        </ul>
                        <div class="d-grid mt-3">
                            <a href="{{ route('agent.profile.edit') }}" class="btn btn-pesibar-grad text-dark">
                                <i class="fas fa-edit me-1"></i> Edit Profil Agensi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- KOLOM KANAN: KONTEN DASHBOARD (HANYA PAKET WISATA) --}}
            <div class="col-lg-8">

                @if (!$agent->is_verified)
                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Profil Anda sedang ditinjau. Fitur kelola paket wisata akan aktif setelah disetujui Admin.
                    </div>
                @endif

                {{-- DAFTAR PAKET TOUR --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h4 fw-bold mb-0">Daftar Paket Tour</h2>
                    @if($agent->is_verified)
                        <a href="{{ route('agent.packages.create') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                            <i class="fas fa-plus me-1"></i> Tambah Paket
                        </a>
                    @endif
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @if(isset($tourPackages))
                                @forelse ($tourPackages as $package)
                                    <li class="list-group-item p-3 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            @php
                                                $imgSrc = asset('images/logo.png'); 
                                                if ($package->cover_image_url) {
                                                    if (Str::startsWith($package->cover_image_url, 'http')) {
                                                        $imgSrc = $package->cover_image_url;
                                                    } else {
                                                        $imgSrc = asset('storage/' . $package->cover_image_url); // Fix path storage
                                                    }
                                                }
                                            @endphp
                                            
                                            <img src="{{ $imgSrc }}" 
                                                 alt="{{ $package->name }}" 
                                                 style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px; background-color: #f8f9fa;" 
                                                 class="me-3"
                                                 onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';">
                                            
                                            <div>
                                                <h6 class="fw-bold mb-0">{{ $package->name }}</h6>
                                                <small class="text-muted">
                                                    {{ $package->duration ?? '-' }} | Rp {{ number_format($package->price_per_person, 0, ',', '.') }}
                                                </small>
                                            </div>
                                        </div>
                                        <a href="{{ route('agent.packages.edit', $package->id) }}" class="btn btn-sm btn-light border">Detail</a>
                                    </li>
                                @empty
                                    <li class="list-group-item p-5 text-center">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum Ada Paket Wisata</h5>
                                        <p class="text-muted small">Mulai tambahkan paket wisata untuk menarik wisatawan.</p>
                                    </li>
                                @endforelse
                            @else
                                <li class="list-group-item p-4 text-center text-danger">
                                    Error: Data paket tidak ditemukan. Pastikan Controller mengirimkan variabel $tourPackages.
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>

    @else
        {{-- TAMPILAN JIKA BELUM MEMBUAT PROFIL AGENSI --}}
        <div class="card shadow-sm border-0" style="background-color: #fff8e1;">
            <div class="card-body text-center p-4 p-md-5">
                <i class="fas fa-exclamation-circle fa-4x text-warning mb-4"></i>
                <h1 class="h3 fw-bold text-dark mb-3">Satu Langkah Lagi, {{ auth()->user()->full_name }}!</h1>
                <p class="text-muted fs-5">Akun pengguna Anda sudah aktif. Sekarang, Anda perlu mendaftarkan profil agensi Anda untuk mulai menawarkan paket wisata.</p>
                <a href="{{ route('agent.profile.create') }}" class="btn btn-danger btn-lg mt-3 fw-semibold px-5">
                    <i class="fas fa-plus-circle me-2"></i> Buat Profil Agensi Sekarang
                </a>
            </div>
        </div>
    @endif
</div>
@endsection