@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background-color: #f8f9fa;">
    
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

    {{-- NAVIGASI KHUSUS ADMIN --}}
    <nav class="nav-custom border-top bg-white shadow-sm">
        <div class="container py-0">
            <div class="d-flex gap-4 justify-content-left">
                
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                   Dashboard
                </a>
                
                <a href="{{ route('admin.users.index') }}" 
                   class="nav-link-custom {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                   Kelola Pengguna
                </a>

                <a href="{{ route('admin.agents.index') }}"
                   class="nav-link-custom {{ request()->routeIs('admin.agents.*') ? 'active' : '' }}">
                   Kelola Agen
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                   class="nav-link-custom {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                   Kelola Kategori Destinasi
                </a>

                <a href="{{ route('admin.destinations.index') }}" 
                   class="nav-link-custom {{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}">
                   Kelola Destinasi
                </a>

                <a href="{{ route('admin.listings.index') }}"
                   class="nav-link-custom {{ request()->routeIs('admin.listings.*') ? 'active' : '' }}">
                   Kelola Paket
                </a>
                
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @yield('admin_content')
    </main>

</div>
@endsection