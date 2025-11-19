@extends('layouts.app')

@section('content')
<div class="min-vh-100 bg-light">
    
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
                    <a href="{{ route('agent.profile.edit') }}" class="text-dark text-decoration-none d-flex flex-column align-items-center me-3">
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

    {{-- NAV KHUSUS AGEN --}}
    <nav class="nav-custom border-top bg-white shadow-sm">
        <div class="container py-0">
            <div class="d-flex gap-4 justify-content-left overflow-auto">
                <a href="{{ route('agent.dashboard') }}"
                   class="nav-link-custom {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                
                @php
                    $agent = auth()->user()->agent;
                @endphp

                @if ($agent)
                    <a href="{{ route('agent.profile.edit') }}" 
                       class="nav-link-custom {{ request()->routeIs('agent.profile.*') ? 'active' : '' }}">
                       Profil Agensi
                    </a>
                    
                    {{-- LOGIKA MENU 1: KELOLA PAKET (Hanya untuk TOUR & BOTH) --}}
                    @if(in_array($agent->agent_type, ['TOUR', 'BOTH']))
                        <a href="{{ $agent->is_verified ? route('agent.packages.index') : '#' }}" 
                           class="nav-link-custom {{ request()->routeIs('agent.packages.*') ? 'active' : '' }} {{ !$agent->is_verified ? 'text-muted' : '' }}"
                           @if(!$agent->is_verified) style="pointer-events: none; opacity: 0.6;" title="Harus terverifikasi" @endif>
                           Kelola Paket Tour
                        </a>
                    @endif

                    {{-- LOGIKA MENU 2: KELOLA USAHA (Hanya untuk NON-TOUR & BOTH) --}}
                    {{-- Jika tipe BUKAN 'TOUR', maka tampilkan menu ini --}}
                    @if($agent->agent_type !== 'TOUR') 
                        <a href="{{ $agent->is_verified ? route('agent.business.index') : '#' }}" 
                           class="nav-link-custom {{ request()->routeIs('agent.business.*') ? 'active' : '' }} {{ !$agent->is_verified ? 'text-muted' : '' }}"
                           @if(!$agent->is_verified) style="pointer-events: none; opacity: 0.6;" @endif>
                           Kelola Toko/Usaha
                        </a>
                    @endif

                @else
                     <a href="{{ route('agent.profile.create') }}" 
                        class="nav-link-custom {{ request()->routeIs('agent.profile.*') ? 'active' : '' }}">
                        Buat Profil Agensi
                    </a>
                @endif
            </div>
        </div>
    </nav>

    @yield('agent_content')

</div>
@endsection