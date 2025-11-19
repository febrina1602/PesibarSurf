@extends('layouts.app')

@section('title', 'Pasar Digital | PesibarSurf')

@section('content')
    {{-- Gunakan wrapper yang sama dengan Beranda (bg-white) --}}
    <div class="app-wrapper bg-white">

        {{-- =============================================== --}}
        {{-- ==== 1. TAMBAHKAN HEADER DARI BERANDA.BLADE ==== --}}
        {{-- =============================================== --}}
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
                            placeholder="Cari di Pasar Digital..."
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

        {{-- ========================================================= --}}
        {{-- ==== 2. TAMBAHKAN NAVIGASI ATAS DARI BERANDA.BLADE ==== --}}
        {{-- ========================================================= --}}
        <nav class="nav-custom border-top bg-white shadow-sm">
            <div class="container py-0">
                <div class="d-flex gap-4 justify-content-left">
                    <a href="{{ route('beranda.wisatawan') }}"
                       class="nav-link-custom {{ request()->routeIs('beranda.wisatawan') ? 'active' : '' }}">
                        Beranda
                    </a>
                    
                    {{-- REVISI LINK PASAR DIGITAL: Buat 'active' jika rute adalah 'marketplace.*', 'transport.*', dll. --}}
                    <a href="{{ route('marketplace.index') }}" 
                       class="nav-link-custom {{ 
                           request()->routeIs('marketplace.*') || 
                           request()->routeIs('transport.*') || 
                           request()->routeIs('penginapan.*') || 
                           request()->routeIs('oleh.*') 
                           ? 'active' : '' 
                       }}">
                       Pasar Digital
                    </a>

                    <a href="{{ route('pemandu-wisata.index') }}" 
                       class="nav-link-custom {{ request()->routeIs('pemandu-wisata.*') ? 'active' : '' }} ">
                       Pemandu Wisata
                    </a>
                </div>
            </div>
        </nav>

        {{-- ========================================== --}}
        {{-- ==== 3. KONTEN ASLI MARKETPLACE.BLADE ==== --}}
        {{-- ========================================== --}}
        
        {{-- HEADER ASLI (marketplace-header-img) DIHAPUS --}}

        <div class="container py-4 py-md-5"> {{-- Tambahkan sedikit padding atas --}}
            
            <h4 class="fw-bold mb-4 text-center">Pasar Digital</h4>

            {{-- LOOP KATEGORI DARI DATABASE --}}
            @foreach ($categories as $category)
                <div class="card border-0 shadow-sm rounded-4 mb-4 card-hover overflow-hidden bg-white">
                    <div class="card-body p-4 d-flex align-items-start align-items-md-center gap-4">

                        {{-- 1. GAMBAR / ICON DENGAN WRAPPER --}}
                        <div class="flex-shrink-0">
                            <div class="rounded-4 d-flex align-items-center justify-content-center bg-light" 
                                style="width: 100px; height: 100px; border: 1px solid #f0f0f0;">
                                <img src="{{ asset($category->image) }}"
                                    alt="{{ $category->title }}"
                                    style="width: 70px; height: 70px; object-fit: contain;">
                            </div>
                        </div>

                        {{-- 2. KONTEN TEKS & TOMBOL --}}
                        <div class="flex-grow-1">
                            <h5 class="fw-bold text-dark mb-2">{{ $category->title }}</h5>
                            <p class="text-muted small mb-3" style="line-height: 1.6;">
                                {{ $category->description }}
                            </p>

                            {{-- 3. GROUP TOMBOL (FLEX WRAP) --}}
                            <div class="d-flex flex-wrap gap-2">
                                @if (is_array($category->buttons))
                                    @foreach ($category->buttons as $btn)
                                        @php
                                            $href = '#';
                                            if ($category->slug === 'transportasi' && $btn === 'Transportasi Daerah') {
                                                $href = route('transport.daerah');
                                            } elseif ($category->slug === 'transportasi' && $btn === 'Transportasi Luar') {
                                                $href = route('transport.luar');
                                            } elseif ($category->slug === 'penginapan' && $btn === 'Pilih Penginapan') {
                                                $href = route('penginapan.index');
                                            } elseif ($category->slug === 'oleh-oleh' && $btn === 'Pilih Oleh-oleh') {
                                                $href = route('oleh.index');
                                            }
                                        @endphp

                                        <a href="{{ $href }}" class="btn btn-market me-1 mb-1">
                                            {{ $btn }}
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    
    {{-- NAVIGASI BAWAH (bottom-nav-market) DIHAPUS --}}

    {{-- Footer dari layouts.app.blade.php akan otomatis muncul di sini --}}
@endsection

{{-- HAPUS @section('bottom-nav') KARENA SUDAH TIDAK DIPERLUKAN --}}