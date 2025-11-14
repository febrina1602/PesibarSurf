@extends('layouts.agent') {{-- MEWARISI LAYOUT BARU --}}

@section('title', 'Kelola Paket Tour - PesibarSurf')

@push('styles')
<style>
    .btn-pesibar-grad {
        background: linear-gradient(to right, #FFE75D, #D19878);
        border: none; color: #333; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .btn-pesibar-grad:hover {
        filter: brightness(0.95); color: #333; box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .package-list-item:hover {
        background-color: #fcfcfc;
    }
</style>
@endpush

@section('agent_content') {{-- NAMA SECTION BARU --}}
<div class="container py-5">

    {{-- Judul dan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 fw-bold mb-0 text-dark">Kelola Paket Tour</h1>
        <a href="{{ route('agent.packages.create') }}" 
           class="btn btn-pesibar-grad text-dark shadow-sm {{ !$agent->is_verified ? 'disabled' : '' }}"
           @if(!$agent->is_verified)
               tabindex="-1" role="button" aria-disabled="true" 
               title="Anda harus terverifikasi untuk menambah paket"
           @endif
           >
            <i class="fas fa-plus-circle me-1"></i> Tambah Paket Baru
        </a>
    </div>

    {{-- Pesan Sukses/Error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Alert jika belum verifikasi --}}
    @if (!$agent->is_verified)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Profil Anda sedang ditinjau. Anda baru bisa **menambah paket** setelah profil disetujui.
        </div>
    @endif

    {{-- Daftar Paket --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                
                @forelse ($tourPackages as $package)
                    <li class="list-group-item p-3 d-flex justify-content-between align-items-center package-list-item">
                        <div class="d-flex align-items-center">
                            <img src="{{ $package->cover_image_url ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=100&q=80' }}" 
                                 alt="{{ $package->name }}" 
                                 style="width: 100px; height: 75px; object-fit: cover; border-radius: 8px;" 
                                 class="me-3 d-none d-md-block">
                            <div>
                                <h5 class="fw-bold mb-1">{{ $package->name }}</h5>
                                <p class="small text-muted mb-1">{{ $package->duration ?? 'Durasi tidak diatur' }}</p>
                                <p class="small text-dark fw-semibold mb-0">
                                    Rp {{ number_format($package->price_per_person, 0, ',', '.') }} / orang
                                </p>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <a href="{{ route('agent.packages.edit', $package->id) }}" class="btn btn-sm btn-outline-primary px-3">
                                <i class="fas fa-pen me-1"></i> Edit
                            </a>
                            <form action="{{ route('agent.packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus paket ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100 px-3">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="list-group-item p-5 text-center">
                        <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">Anda Belum Memiliki Paket</h4>
                        
                        @if($agent->is_verified)
                            <p class="small text-muted">Klik "Tambah Paket Baru" untuk mulai menjual paket tour Anda.</p>
                            <a href="{{ route('agent.packages.create') }}" class="btn btn-pesibar-grad text-dark shadow-sm mt-2">
                                <i class="fas fa-plus-circle me-1"></i> Tambah Paket Pertama Anda
                            </a>
                        @else
                            <p class="small text-muted">Anda dapat menambahkan paket setelah profil Anda diverifikasi oleh Admin.</p>
                        @endif
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
    
</div>
@endsection