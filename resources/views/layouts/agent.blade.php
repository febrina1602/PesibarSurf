@extends('layouts.app')

{{-- 
======================================================================
INI ADALAH LAYOUT MASTER UNTUK SEMUA HALAMAN AGEN
======================================================================
--}}

@section('content')
<div class="min-vh-100 bg-light">
    
    {{-- HEADER --}}
    <header>
        <div class="container py-2 d-flex align-items-center justify-content-between">
            <a href="{{ route('agent.dashboard') }}" class="d-flex align-items-center text-decoration-none" style="min-width: 150px;">
                <img src="{{ asset('images/logo.png') }}" alt="PesibarSurf Logo"
                    style="height:42px" loading="lazy" onerror="this.style.display='none'">
                <span class="ms-2 fw-bold text-dark d-none d-md-block">PesibarSurf</span>
            </a>
            <div class="d-flex align-items-center" style="min-width: 150px; justify-content: flex-end;">
                @auth
                    {{-- Foto Profil User --}}
                    <a href="{{ route('agent.profile.edit') }}" class="text-dark text-decoration-none d-flex flex-column align-items-center me-3" title="Profil">
                        <img src="{{ auth()->user()->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->full_name) . '&background=FFD15C&color=333&bold=true' }}" 
                             alt="Foto Profil" 
                             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #eee;">
                        <span class="small fw-medium">
                            {{ \Illuminate\Support\Str::limit(auth()->user()->full_name, 15) }}
                        </span>
                    </a>
                    
                    {{-- Tombol Logout --}}
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

    {{-- NAV KHUSUS AGEN --}}
    <nav class="nav-custom border-top bg-white shadow-sm">
        <div class="container py-0">
            <div class="d-flex gap-4 justify-content-left">
                <a href="{{ route('agent.dashboard') }}"
                   class="nav-link-custom {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                
                {{-- 
                  Kita definisikan $agent di sini agar semua child view punya akses
                  dan navigasinya konsisten.
                --}}
                @php
                    $agent = auth()->user()->agent;
                @endphp

                @if ($agent)
                    <a href="{{ route('agent.profile.edit') }}" 
                       class="nav-link-custom {{ request()->routeIs('agent.profile.*') ? 'active' : '' }}">
                       Profil Agensi
                    </a>
                    
                    <a href="{{ $agent->is_verified ? route('agent.packages.index') : '#' }}" 
                       class="nav-link-custom {{ request()->routeIs('agent.packages.*') ? 'active' : '' }} {{ !$agent->is_verified ? 'text-muted' : '' }}"
                       @if(!$agent->is_verified)
                           style="pointer-events: none; opacity: 0.6;" 
                           title="Harus terverifikasi"
                       @endif
                       >
                       Kelola Paket
                    </a>
                @else
                     <a href="{{ route('agent.profile.create') }}" 
                       class="nav-link-custom {{ request()->routeIs('agent.profile.*') ? 'active' : '' }}">
                       <i class="fas fa-plus-circle me-1"></i> Buat Profil Agensi
                    </a>
                @endif
            </div>
        </div>
    </nav>

    {{-- 
    ======================================================================
    KONTEN HALAMAN SPESIFIK (DASHBOARD, PROFIL, PAKET) AKAN MASUK DI SINI
    ======================================================================
    --}}
    @yield('agent_content')

</div>
@endsection