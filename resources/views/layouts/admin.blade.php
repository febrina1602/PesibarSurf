@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background-color: #f8f9fa;">
    
    {{-- HEADER --}}
    <header>
        <div class="container py-2 d-flex align-items-center justify-content-between">
            
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-decoration-none" style="min-width: 150px;">
                <img src="{{ asset('images/logo.png') }}" alt="PesibarSurf Logo"
                    style="height:42px" loading="lazy" onerror="this.style.display='none'">
                <span class="ms-2 fw-bold text-dark d-none d-md-block">PesibarSurf </span>
            </a>
            
            <div class="d-flex align-items-center" style="min-width: 150px; justify-content: flex-end;">
                @auth
                    <a href="#" class="text-dark text-decoration-none d-flex flex-column align-items-center me-3" title="Profil Admin">
                        <img src="{{ auth()->user()->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->full_name) . '&background=4E73DF&color=FFF&bold=true' }}" 
                             alt="Foto Profil" 
                             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #eee;">
                        <span class="small fw-medium">
                            {{ \Illuminate\Support\Str::limit(auth()->user()->full_name, 15) }}
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

                <a href="#" {{-- Nanti ganti ke route('admin.packages.index') --}}
                   class="nav-link-custom {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
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