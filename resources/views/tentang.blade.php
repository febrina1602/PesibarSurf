@extends('layouts.app')

@section('title', 'Tentang Kami - PesibarSurf')

@push('styles')
<style>
    .about-header {
        background: linear-gradient(90deg, #D19878, #FFE75D);
        padding: 60px 0;
        text-align: center;
        color: #333;
    }

    .about-header h1 {
        font-weight: 700;
        font-size: 3rem;
    }

    .about-header .lead {
        font-size: 1.25rem;
        font-weight: 600;
        color: #555;
    }

    .hero-about-img {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .feature-card {
        background: #ffffff;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        padding: 30px;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    .feature-card i {
        font-size: 48px;
        color: #dc3545; /* Warna merah primer */
        margin-bottom: 20px;
    }

    .team-card {
        text-align: center;
        padding: 20px;
    }
    .team-member-img {
        width: 120px; 
        height: 120px; 
        border-radius: 50%; 
        object-fit: cover; 
        margin-bottom: 15px;
        border: 4px solid #FFE75D; 
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .team-member-img:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }
    .team-card h5 {
        font-weight: 600;
        margin-bottom: 5px;
    }
    .team-card p {
        color: #777;
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="min-vh-100 bg-white">
    
    {{-- HEADER --}}
    <header class="header-gradient shadow-sm"> 
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

            <div class="d-flex align-items-center" style="min-width: 150px; justify-content: flex-end;">
                
                @guest
                    <a href="{{ route('login') }}" class="text-dark text-decoration-none d-flex flex-column align-items-center">
                        <i class="fas fa-user-circle" style="font-size: 1.75rem;"></i>
                        <span class="small fw-medium">Akun</span>
                    </a>
                @endguest
                
                @auth
                    @php
                        $profileRoute = auth()->user()->role == 'agent' 
                                      ? route('agent.dashboard') 
                                      : route('profile.show');
                    @endphp
                    <a href="{{ $profileRoute }}" class="text-dark text-decoration-none d-flex flex-column align-items-center me-3">
                        <img src="{{ auth()->user()->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->full_name) . '&background=FFD15C&color=333&bold=true' }}" 
                             alt="Foto Profil" 
                             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #eee;">
                        <span class="small fw-medium">
                            {{ \Illuminate\Support\Str::limit(auth()->user()->full_name ?? auth()->user()->name, 15) }}
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
    
    @auth
        
        @if(auth()->user()->role == 'user')
            <nav class="nav-custom border-top bg-white">
                <div class="container py-0">
                    <div class="d-flex gap-4 justify-content-left">
                        <a href="{{ route('beranda.wisatawan') }}"
                           class="nav-link-custom {{ request()->routeIs('beranda.wisatawan') ? 'active' : '' }}">
                            Beranda
                        </a>
                        <a href="#" class="nav-link-custom">Pasar Digital</a>
                        <a href="{{ route('pemandu-wisata.index') }}" 
                           class="nav-link-custom {{ request()->routeIs('pemandu-wisata.*') ? 'active' : '' }} ">
                           Pemandu Wisata
                        </a>
                    </div>
                </div>
            </nav>
        
        @elseif(auth()->user()->role == 'agent')
            <nav class="nav-custom border-top bg-white">
                <div class="container py-0">
                    <div class="d-flex gap-4 justify-content-left">
                        <a href="{{ route('agent.dashboard') }}"
                           class="nav-link-custom {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('agent.profile.edit') }}" 
                           class="nav-link-custom {{ request()->routeIs('agent.profile.*') ? 'active' : '' }} ">
                           Profil Agensi
                        </a>
                        <a href="{{ route('agent.packages.index') }}" 
                           class="nav-link-custom {{ request()->routeIs('agent.packages.*') ? 'active' : '' }} ">
                           Kelola Paket
                        </a>
                    </div>
                </div>
            </nav>
        @endif

    @endauth 

    <div class="about-header">
        <div class="container">
            <h1 class="display-4">Tentang PesibarSurf</h1>
            <p class="lead">"Your Digital Travel Guide to Surf & Explore"</p>
        </div>
    </div>

    <section>
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <img src="{{ asset('images/beach.png') }}" class="hero-about-img" alt="Pantai di Pesisir Barat">
                </div>
                <div class="col-lg-6 text-start">
                    <h2 class="fw-bold mb-3">Siapa Kami?</h2>
                    <p class="fs-5" style="color: #555;">
                        <strong>PesibarSurf</strong> adalah biro jasa pariwisata digital yang berdedikasi untuk memajukan potensi wisata di Lampung, khususnya Pesisir Barat.
                    </p>
                    <p class="text-muted">
                        Kami adalah platform satu atap yang menghubungkan wisatawan dengan keindahan alam, kekayaan budaya, dan pelaku UMKM lokal. Misi kami adalah menyediakan panduan perjalanan yang praktis, personal, dan penuh makna, sekaligus memberikan dampak positif bagi perekonomian lokal.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section style="background-color: #f9f9f9;">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Apa yang Kami Tawarkan?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-map-location-dot"></i>
                        <h5 class="fw-bold">Panduan Digital Terlengkap</h5>
                        <p class="text-muted">Akses informasi terkurasi tentang destinasi, kuliner, dan budaya di Pesisir Barat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-store"></i>
                        <h5 class="fw-bold">Dukung UMKM Lokal</h5>
                        <p class="text-muted">Temukan dan beli produk otentik serta pesan akomodasi langsung dari pelaku usaha lokal.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-users"></i>
                        <h5 class="fw-bold">Pemandu Wisata Tepercaya</h5>
                        <p class="text-muted">Terhubung dengan agen dan pemandu wisata lokal terverifikasi untuk pengalaman terbaik.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Tim Hebat di Balik PesibarSurf</h2>
            <p class="text-center text-muted mb-4">
                Kami adalah mahasiswa dari Universitas Lampung yang berkolaborasi dalam Program Mahasiswa Wirausaha (PMW).
            </p>
            <div class="row g-4 justify-content-center">
                {{-- Data tim diambil dari proposal --}}
                <div class="col-6 col-md-3">
                    <div class="team-card">
                        <img src="{{ asset('images/team/kinanti.jpeg') }}" alt="Foto Kinanthi Cita Laksana" class="team-member-img">
                        <h5>Kinanthi Cita Laksana</h5>
                        <p>Ketua Pengusul</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="team-card">
                        <img src="#" alt="Foto Rosdiana Septrie Lestari" class="team-member-img">
                        <h5>Rosdiana Septrie Lestari</h5>
                        <p>Anggota</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="team-card">
                        <img src="#" alt="Foto Kezia Natalia Wongkar" class="team-member-img">
                        <h5>Kezia Natalia Wongkar</h5>
                        <p>Anggota</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="team-card">
                        <img src="{{ asset('images/team/febrina.jpg') }}" alt="Foto Febrina Aulia Azahra" class="team-member-img">
                        <h5>Febrina Aulia Azahra</h5>
                        <p>Anggota</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection