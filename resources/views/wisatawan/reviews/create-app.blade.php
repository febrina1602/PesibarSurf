@extends('layouts.app')

@section('content')

<header class="header-gradient shadow-sm sticky-top" style="z-index: 1030;"> 
    <div class="container py-2 d-flex align-items-center justify-content-between">
        
        <a href="{{ route('beranda.wisatawan') }}" class="d-flex align-items-center text-decoration-none" style="min-width: 150px;">
            <img src="{{ asset('images/logo.png') }}" alt="PesibarSurf Logo"
                style="height:42px" loading="lazy" onerror="this.style.display='none'">
            <span class="ms-2 fw-bold text-dark d-none d-md-block">PesibarSurf</span>
        </a>

        <form class="flex-grow-1 mx-3 mx-md-4" action="#" method="GET">
            <div class="position-relative" style="max-width: 600px; margin: 0 auto;">
                <input type="text" class="form-control" name="search"
                    placeholder="Wisata apa yang kamu cari?"
                    style="border-radius: 50px; padding-left: 2.5rem; height: 44px;">
                <button type="submit" class="btn p-0" 
                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #6c757d; font-size: 1.1rem;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        {{-- PROFILE / LOGIN --}}
        <div class="d-flex align-items-center" style="min-width: 150px; justify-content: flex-end;">
            @guest
                <a href="{{ route('login') }}" class="text-dark text-decoration-none d-flex flex-column align-items-center">
                    <i class="fas fa-user-circle" style="font-size: 1.75rem;"></i>
                    <span class="small fw-medium">Akun</span>
                </a>
            @endguest
            
            @auth
                @php
                    $user = auth()->user();
                    $profileRoute = $user->role == 'agent' ? route('agent.dashboard') : route('profile.show');
                @endphp
                <a href="{{ $profileRoute }}" class="text-dark text-decoration-none d-flex flex-column align-items-center me-3">
                    <img src="{{ $user->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->full_name) . '&background=FFD15C&color=333&bold=true' }}" 
                         alt="Foto Profil" 
                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #eee;">
                    <span class="small fw-medium">
                        {{ \Illuminate\Support\Str::limit($user->full_name ?? $user->name, 15) }}
                    </span>
                </a>
                
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger p-0" title="Logout" 
                            style="font-size: 1.6rem; line-height: 1;">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            @endauth
        </div>
    </div>
    <img src="{{ asset('images/siger-pattern.png') }}" alt="Siger Pattern" class="siger-pattern-header" loading="lazy">
</header>

<nav class="nav-custom border-top bg-white shadow-sm">
    <div class="container py-0">
        <div class="d-flex gap-4 justify-content-left overflow-auto">
            
            @auth
                @if(auth()->user()->role == 'agent')
                    {{-- === MENU UNTUK AGENT === --}}
                    <a href="{{ route('agent.dashboard') }}"
                       class="nav-link-custom {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    
                    @php $agent = auth()->user()->agent; @endphp

                    @if ($agent)
                        <a href="{{ route('agent.profile.edit') }}" 
                           class="nav-link-custom {{ request()->routeIs('agent.profile.*') ? 'active' : '' }}">
                           Profil Agensi
                        </a>
                        
                        <a href="{{ $agent->is_verified ? route('agent.packages.index') : '#' }}" 
                           class="nav-link-custom {{ request()->routeIs('agent.packages.*') ? 'active' : '' }} {{ !$agent->is_verified ? 'text-muted' : '' }}"
                           @if(!$agent->is_verified) style="pointer-events: none; opacity: 0.6;" title="Harus terverifikasi" @endif>
                           Kelola Paket Tour
                        </a>
                    @else
                         <a href="{{ route('agent.profile.create') }}" 
                            class="nav-link-custom {{ request()->routeIs('agent.profile.*') ? 'active' : '' }}">
                            Buat Profil Agensi
                        </a>
                    @endif

                @else
                    {{-- === MENU UNTUK WISATAWAN (USER BIASA) === --}}
                    <a href="{{ route('beranda.wisatawan') }}"
                       class="nav-link-custom {{ request()->routeIs('beranda.wisatawan') ? 'active' : '' }}">
                        Beranda
                    </a>

                    <a href="#" class="nav-link-custom {{ request()->routeIs('destinations.*') ? 'active' : '' }}">
                        Destinasi
                    </a>

                    <a href="{{ route('pemandu-wisata.index') }}" 
                       class="nav-link-custom {{ request()->routeIs('pemandu-wisata.*') ? 'active' : '' }} ">
                       Pemandu Wisata
                    </a>
                @endif
            @endauth

        </div>
    </div>
</nav>

<div class="min-vh-100 bg-light py-5 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    
                    {{-- HEADER KARTU --}}
                    <div class="bg-white p-4 border-bottom d-flex align-items-center gap-3">
                        <div class="bg-light rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo PesibarSurf" class="img-fluid">
                        </div>
                        <div>
                            <p class="text-muted small mb-0 text-uppercase ls-1">Ulasan Aplikasi</p>
                            <h6 class="fw-bold mb-0 text-dark">PesibarSurf</h6>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        
                        <form action="{{ route('app-reviews.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            {{-- RATING --}}
                            <div class="text-center mb-4">
                                <h5 class="fw-bold mb-3">Seberapa puas kamu dengan aplikasi ini?</h5>
                                
                                <div class="star-rating-container d-flex justify-content-center gap-2 flex-row-reverse">
                                    <input type="radio" name="rating" id="star5" value="5" class="d-none peer">
                                    <label for="star5" class="fas fa-star fs-1 cursor-pointer transition-colors"></label>
                                    
                                    <input type="radio" name="rating" id="star4" value="4" class="d-none peer">
                                    <label for="star4" class="fas fa-star fs-1 cursor-pointer transition-colors"></label>
                                    
                                    <input type="radio" name="rating" id="star3" value="3" class="d-none peer">
                                    <label for="star3" class="fas fa-star fs-1 cursor-pointer transition-colors"></label>
                                    
                                    <input type="radio" name="rating" id="star2" value="2" class="d-none peer">
                                    <label for="star2" class="fas fa-star fs-1 cursor-pointer transition-colors"></label>
                                    
                                    <input type="radio" name="rating" id="star1" value="1" class="d-none peer">
                                    <label for="star1" class="fas fa-star fs-1 cursor-pointer transition-colors"></label>
                                </div>
                                <small class="mt-2 d-block fw-bold text-dark" id="rating-text">Ketuk bintang untuk menilai</small>
                            </div>

                            {{-- KOMENTAR --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Masukan & Saran Pengembangan</label>
                                <textarea name="comment" class="form-control bg-light border-0 p-3" rows="5" 
                                    placeholder="Ceritakan pengalamanmu menggunakan aplikasi ini..." required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-pesibar-grad py-3 fw-bold rounded-pill shadow-sm">
                                    Kirim Ulasan Aplikasi
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* BUTTON GRADIENT */
    .btn-pesibar-grad {
        background: linear-gradient(to right, #FFE75D, #D19878);
        border: none;
        color: #333 !important;
        transition: all 0.3s ease;
    }
    .btn-pesibar-grad:hover {
        filter: brightness(0.95);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(209, 152, 120, 0.4);
    }

    /* STAR RATING */
    .star-rating-container label { color: #e9ecef; transition: all 0.2s ease; }
    .star-rating-container label:hover, 
    .star-rating-container label:hover ~ label { color: #ffc107; transform: scale(1.1); }
    .star-rating-container input:checked ~ label { color: #ffc107; }
    
    .cursor-pointer { cursor: pointer; }
    .border-dashed { border-style: dashed !important; }
    .upload-box:hover { background-color: #e9ecef !important; }
</style>
@endpush

@push('scripts')
<script>
    const ratingLabels = { 
        1: 'Sangat Mengecewakan', 
        2: 'Kurang Bagus', 
        3: 'Cukup', 
        4: 'Bagus', 
        5: 'Sangat Memuaskan' 
    };

    document.querySelectorAll('input[name="rating"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('rating-text').innerText = ratingLabels[this.value];
            document.getElementById('rating-text').className = 'mt-2 d-block fw-bold text-dark';
        });
    });

    function previewImages(input) {
        const container = document.getElementById('imagePreviewContainer');
        container.innerHTML = ''; 
        if (input.files) {
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgDiv = document.createElement('div');
                    imgDiv.className = 'rounded-3 border position-relative overflow-hidden flex-shrink-0';
                    imgDiv.style.width = '80px'; imgDiv.style.height = '80px';
                    const img = document.createElement('img');
                    img.src = e.target.result; 
                    img.className = 'w-100 h-100 object-fit-cover';
                    imgDiv.appendChild(img); 
                    container.appendChild(imgDiv);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>
@endpush