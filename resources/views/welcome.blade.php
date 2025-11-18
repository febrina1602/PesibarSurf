@extends('layouts.app')

@section('title', 'PesibarSurf | Jelajahi Pesona Lampung')

@section('content')
    <header class="header-gradient d-flex justify-content-between align-items-center px-4 py-3">
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/logo.png') }}" alt="PesibarSurf Logo"
                    style="height:42px" loading="lazy" onerror="this.style.display='none'">
                <span class="ms-2 fw-bold text-dark d-none d-md-block">PesibarSurf</span>
        </div>
        <div>
            <a href="{{ route('login') }}" class="btn-custom me-2">Masuk</a>
            <a href="{{ route('register') }}" class="btn-custom">Daftar</a>
        </div>
        {{-- TAMBAHKAN Siger Pattern --}}
        <img src="{{ asset('images/siger-pattern.png') }}" alt="Siger Pattern" class="siger-pattern-header" loading="lazy">
    </header>

    <!-- HERO -->
    <section>
        <div class="container">
            <img src="{{ asset('images/wave.png') }}" class="hero-img mb-4" alt="Pantai Surfing">
            <h4 class="fw-bold"><span class="typing">Selamat Datang di PesibarSurf!</span></h4>
            <p class="text-muted">
                Temukan pengalaman healing yang menenangkan di penjuru wilayah <br>
                provinsi Lampung. Wisata praktis, personal, dan penuh makna.
            </p>
        </div>
    </section>

    <!-- PANDUAN -->
    <section style="background-color: #ffffff;">
        <div class="container">
            <img src="{{ asset('images/beach.png') }}" class="hero-img mb-4" alt="Pantai Tropis">
            <h4 class="fw-bold">Panduan Digital Terlengkap</h4>
            <p class="text-muted">
                Akses informasi lengkap tentang tempat wisata, budaya, dan kuliner <br> 
                hanya dalam satu aplikasi.
            </p>
        </div>
    </section>

    <!-- UMKM -->
    <section style="background-color: #ffffff;">
        <div class="container">
            <img src="{{ asset('images/sunset.png') }}" class="hero-img mb-4" alt="Senja di Pantai Lampung">
            <h4 class="fw-bold">Dukung UMKM Lokal</h4>
            <p class="text-muted">
                Beli oleh-oleh dan pesan akomodasi langsung dari pelaku usaha lokal. <br>  
                Liburanmu bawa dampak nyata.
            </p>
        </div>
    </section>
@endsection