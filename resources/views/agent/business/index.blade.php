@extends('layouts.agent')

@section('title', 'Daftar Usaha - PesibarSurf')

@push('styles')
<style>
    .btn-pesibar-grad { background: linear-gradient(to right, #FFE75D, #D19878); border: none; color: #333; font-weight: 600; }
    .card-hover:hover { transform: translateY(-5px); transition: 0.3s; box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>
@endpush

@section('agent_content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 fw-bold mb-1">Usaha Saya</h2>
            <p class="text-muted mb-0">Kelola semua cabang/unit usaha Anda.</p>
        </div>
        
        {{-- TOMBOL TAMBAH USAHA --}}
        <a href="{{ route('agent.business.create') }}" class="btn btn-pesibar-grad text-dark shadow-sm">
            <i class="fas fa-plus-circle me-1"></i></i> Tambah Usaha
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($businesses as $data)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 h-100 card-hover overflow-hidden">
                    <div class="position-relative" style="height: 200px;">
                        <img src="{{ asset('storage/' . $data->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $data->name }}">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i> {{ $data->rating }}</span>
                        </div>
                        @if(isset($data->type))
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-danger text-light text-uppercase shadow-sm">{{ $data->type }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="fw-bold mb-2">{{ $data->name }}</h5>
                        <p class="small text-muted mb-2"><i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ Str::limit($data->location, 30) }}</p>
                        
                        <div class="mb-3">
                            @if($agent->agent_type == 'PENGINAPAN')
                                <span class="badge bg-light text-dark border">Mulai {{ $data->price_start }}</span>
                            @else
                                <span class="badge bg-light text-dark border">{{ $data->price_range }}</span>
                            @endif
                        </div>

                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('agent.business.edit', $data->id) }}" class="btn btn-sm btn-outline-warning flex-grow-1 text-dark fw-bold">Edit</a>
                            
                            <form action="{{ route('agent.business.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Hapus usaha ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                    <i class="fas fa-store fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada usaha terdaftar.</h5>
                    <p class="text-muted small mb-4">Tambahkan penginapan, toko, atau rental Anda sekarang.</p>
                    <a href="{{ route('agent.business.create') }}" class="btn btn-danger px-4 rounded-pill">Buat Usaha Pertama</a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection