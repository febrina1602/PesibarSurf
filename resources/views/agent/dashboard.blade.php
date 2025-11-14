@extends('layouts.app')

@section('title', 'Dashboard Agen - PesibarSurf')

@section('content')
<div class="min-vh-100 bg-light">
    
    {{-- HEADER --}}
    <header>
        <div class="container py-2 d-flex align-items-center justify-content-between">
            
            {{-- Logo --}}
            <a href="{{ route('agent.dashboard') }}" class="d-flex align-items-center text-decoration-none" style="min-width: 150px;">
                <img src="{{ asset('images/logo.png') }}" alt="PesibarSurf Logo"
                    style="height:42px" loading="lazy" onerror="this.style.display='none'">
                <span class="ms-2 fw-bold text-dark d-none d-md-block">PesibarSurf (Agen)</span>
            </a>

            {{-- Search Bar (Seperti di Beranda) --}}
            <form class="flex-grow-1 mx-3 mx-md-4" action="#" method="GET">
                <div class="position-relative" style="max-width: 600px; margin: 0 auto;">
                    <input type="text" class="form-control" name="search"
                        placeholder="Cari paket atau rental Anda..."
                        style="border-radius: 50px; padding-left: 2.5rem; height: 44px;">
                    <button type="submit" class="btn p-0" 
                    style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #6c757d; font-size: 1.1rem;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            {{-- Area Akun & Tombol Daftar Agen --}}
            <div class="d-flex align-items-center" style="min-width: 150px; justify-content: flex-end;">
                
                @auth
                    {{-- Tombol "Daftarkan Agen" --}}
                    <a href="{{ route('register.agent') }}" class="btn btn-danger btn-sm me-3" target="_blank">
                        <i class="fas fa-user-plus me-1"></i> Daftarkan Agen
                    </a>

                    {{-- Info Akun (Ganti link berdasarkan status profil) --}}
                    <a href="{{ $agent ? route('agent.profile.edit') : route('agent.profile.create') }}" class="text-dark text-decoration-none d-flex flex-column align-items-center me-3" title="Profil">
                        <i class="fas fa-user-circle" style="font-size: 1.75rem;"></i>
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

    {{-- NAV KHUSUS AGEN (Juga menangani jika $agent null) --}}
    <nav class="nav-custom border-top bg-white shadow-sm">
        <div class="container py-0">
            <div class="d-flex gap-4 justify-content-left">
                <a href="{{ route('agent.dashboard') }}"
                   class="nav-link-custom {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                </a>
                
                {{-- Hanya tampilkan menu Kelola jika profil sudah ada --}}
                @if ($agent)
                    <a href="{{ route('agent.profile.edit') }}" 
                       class="nav-link-custom {{ request()->routeIs('agent.profile.*') ? 'active' : '' }}">
                       <i class="fas fa-user-tie me-1"></i> Profil Agensi
                    </a>
                    <a href="{{ route('agent.packages.index') }}" 
                       class="nav-link-custom {{ request()->routeIs('agent.packages.*') ? 'active' : '' }}">
                       <i class="fas fa-box-open me-1"></i> Kelola Paket
                    </a>
                @else
                    {{-- Jika profil belum ada, tampilkan link untuk membuat --}}
                     <a href="{{ route('agent.profile.create') }}" 
                       class="nav-link-custom {{ request()->routeIs('agent.profile.*') ? 'active' : '' }}">
                       <i class="fas fa-plus-circle me-1"></i> Buat Profil Agensi
                    </a>
                @endif
            </div>
        </div>
    </nav>

    {{-- KONTEN DASHBOARD --}}
    <div class="container py-5">
    
        {{-- Tampilkan pesan sukses/info --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ======================================================= --}}
        {{-- PERBAIKAN LOGIKA UTAMA: Cek apakah $agent sudah ada --}}
        {{-- ======================================================= --}}
        
        @if ($agent)
            {{-- TAMPILAN JIKA AGEN SUDAH MENGISI PROFIL --}}
            
            <h1 class="h3 fw-bold text-dark mb-3">Dashboard Agen</h1>
            <p class="text-muted">Selamat datang kembali, {{ auth()->user()->full_name }}!</p>

            {{-- Status Verifikasi --}}
            @if ($agent->is_verified)
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    Akun Anda sudah **terverifikasi**. Paket tour Anda akan tampil di halaman publik.
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Profil agensi Anda sedang **ditinjau oleh Admin**. Mohon tunggu.
                </div>
            @endif

            <hr class="my-4">

            {{-- Menu Cepat --}}
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-user-tie fa-3x mb-3 text-primary"></i>
                            <h5 class="card-title fw-bold">Profil Agensi</h5>
                            <p class="card-text small text-muted">Perbarui nama, alamat, dan deskripsi agensi Anda.</p>
                            <a href="{{ route('agent.profile.edit') }}" class="btn btn-outline-primary mt-3">
                                Kelola Profil
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-box-open fa-3x mb-3 text-primary"></i>
                            <h5 class="card-title fw-bold">Paket Tour</h5>
                            <p class="card-text small text-muted">Tambah, edit, atau hapus paket tour yang Anda tawarkan.</p>
                            <a href="{{ route('agent.packages.index') }}" class="btn btn-primary mt-3">
                                Kelola Paket
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        @else
            {{-- TAMPILAN JIKA AGEN BELUM MENGISI PROFIL --}}
            
            <div class="card shadow-sm border-0" style="background-color: #fff8e1;">
                <div class="card-body text-center p-4 p-md-5">
                    <i class="fas fa-exclamation-circle fa-4x text-warning mb-4"></i>
                    <h1 class="h3 fw-bold text-dark mb-3">Satu Langkah Lagi, {{ auth()->user()->full_name }}!</h1>
                    <p class="text-muted fs-5">
                        Akun pengguna Anda sudah aktif. Sekarang, Anda perlu mendaftarkan profil agensi Anda.
                    </p>
                    <p class="text-muted">
                        Setelah profil agensi dibuat, Anda dapat mulai menambahkan paket tour dan layanan lainnya.
                    </p>
                    <a href="{{ route('agent.profile.create') }}" class="btn btn-danger btn-lg mt-3 fw-semibold px-5">
                        <i class="fas fa-plus-circle me-2"></i> Buat Profil Agensi Sekarang
                    </a>
                </div>
            </div>
            
        @endif

    </div>
</div>
@endsection