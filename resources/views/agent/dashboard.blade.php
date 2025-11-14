@extends('layouts.agent') {{-- MEWARISI LAYOUT BARU --}}

@section('title', 'Dashboard Agen - PesibarSurf')

@push('styles')
<style>
    /* Style untuk card yang non-aktif */
    .card-disabled {
        background-color: #f8f9fa; border-style: dashed; opacity: 0.7;
    }
    .card-disabled .btn {
        pointer-events: none; background-color: #6c757d; border-color: #6c757d; opacity: 0.5;
    }
    .card-disabled .card-text, .card-disabled .card-title {
        color: #6c757d !important;
    }
    /* Style untuk tombol gradien */
    .btn-pesibar-grad {
        background: linear-gradient(to right, #FFE75D, #D19878);
        border: none; color: #333; font-weight: 600;
    }
    .btn-pesibar-grad:hover {
        filter: brightness(0.95); color: #333;
    }
</style>
@endpush

@section('agent_content') {{-- NAMA SECTION BARU --}}
<div class="container py-5">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- $agent otomatis ada dari layout --}}
    @if ($agent) 
        
        <div class="row g-4">
            
            {{-- KOLOM KIRI: KARTU DETAIL AGEN --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 position-sticky" style="top: 2rem;">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <img src="{{ $agent->user->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($agent->user->full_name) . '&background=FFD15C&color=333&bold=true' }}" 
                                 alt="Profil" class="mb-2"
                                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #eee;">
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
                                <span>Agen {{ $agent->agent_type }}</span>
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
            
            {{-- KOLOM KANAN: DAFTAR PAKET --}}
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h4 fw-bold mb-0">Daftar Paket Tour</h2>
                </div>

                @if (!$agent->is_verified)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Profil Anda sedang ditinjau. Anda baru bisa **menambah paket** setelah profil disetujui.
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse ($tourPackages as $package)
                                <li class="list-group-item p-3 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $package->cover_image_url ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=100&q=80' }}" 
                                             alt="{{ $package->name }}" 
                                             style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;" 
                                             class="me-3">
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ $package->name }}</h6>
                                            <small class="text-muted">
                                                {{ $package->duration ?? 'Durasi tidak diatur' }} | Rp {{ number_format($package->price_per_person, 0, ',', '.') }}
                                            </small>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item p-5 text-center">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Anda Belum Memiliki Paket</h5>
                                    @if($agent->is_verified)
                                        <p class="small text-muted">Klik "Tambah Paket Baru" untuk mulai menjual.</p>
                                    @else
                                        <p class="small text-muted">Anda dapat menambahkan paket setelah profil Anda diverifikasi.</p>
                                    @endif
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                
                @if(in_array($agent->agent_type, ['RENTAL', 'BOTH']))
                    {{-- ... (Konten Rental Anda) ... --}}
                @endif
                
            </div>
        </div>

    @else
        {{-- Fallback jika $agent null (alur "Satu Langkah Lagi") --}}
        <div class="card shadow-sm border-0" style="background-color: #fff8e1;">
            <div class="card-body text-center p-4 p-md-5">
                <i class="fas fa-exclamation-circle fa-4x text-warning mb-4"></i>
                <h1 class="h3 fw-bold text-dark mb-3">Satu Langkah Lagi, {{ auth()->user()->full_name }}!</h1>
                <p class="text-muted fs-5">Akun pengguna Anda sudah aktif. Sekarang, Anda perlu mendaftarkan profil agensi Anda.</p>
                <a href="{{ route('agent.profile.create') }}" class="btn btn-danger btn-lg mt-3 fw-semibold px-5">
                    <i class="fas fa-plus-circle me-2"></i> Buat Profil Agensi Sekarang
                </a>
            </div>
        </div>
    @endif
</div>
@endsection