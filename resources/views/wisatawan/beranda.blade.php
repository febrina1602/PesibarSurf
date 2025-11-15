@extends('layouts.app')

@section('title', 'Beranda - PesibarSurf')

{{-- STYLE KHUSUS KARTU KATEGORI DESTINASI --}}
@push('styles')
<style>
    /* Kartu kategori model baru */
    .destination-card {
        padding: 0;                    /* hilangkan padding default */
        border-radius: 26px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .destination-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .destination-card-image {
        width: 100%;
        height: 150px;
        background: #ddd;
    }
    .destination-card-image img,
    .destination-card-image svg {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .destination-card-body {
        background: #ffffff;
        padding: 12px 10px 16px;
        text-align: center;
    }
    .destination-card-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #222;
        margin: 0;
    }

    /* Sedikit penyesuaian untuk mobile, kartu lebih pendek */
    @media (max-width: 576px) {
        .destination-card {
            border-radius: 22px;
        }
        .destination-card-image {
            height: 120px;
        }
        .destination-card-title {
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')
<div class="app-wrapper bg-white">

    {{-- ================= HEADER (GRADIENT + SEARCH + AKUN) ================= --}}
    <header class="shadow-sm" style="background: linear-gradient(180deg,#FFE467,#FFDFCF);">
        <div class="container py-2 py-md-1 d-flex align-items-center justify-content-between gap-2">

            {{-- Logo --}}
            <a href="{{ route('beranda.wisatawan') }}"
               class="d-flex align-items-center text-decoration-none flex-shrink-0">
                <img src="{{ asset('images/logo.png') }}"
                     alt="PesibarSurf Logo"
                     style="height:50px"
                     loading="lazy"
                     onerror="this.style.display='none'">
                <span class="ms-2 fw-bold text-dark d-none d-md-inline">
                    PesibarSurf
                </span>
            </a>

            {{-- Search bar --}}
            <form class="flex-grow-1 mx-2 mx-md-4" action="#" method="GET">
                <div class="position-relative" style="max-width: 640px; margin: 0 auto;">
                    <input type="text"
                           class="form-control"
                           name="search"
                           placeholder="Wisata apa yang ingin kamu jelajahi hari ini?"
                           style="border-radius: 999px; padding-left: 2.5rem; height: 42px; font-size: 0.9rem;">
                    <button type="submit"
                            class="btn p-0"
                            style="position:absolute; left:0.9rem; top:50%; transform:translateY(-50%); color:#6c757d; font-size:1rem;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            {{-- Akun / Profil --}}
            <div class="d-flex align-items-center justify-content-end flex-shrink-0" style="min-width: 90px;">
                @guest
                    <a href="{{ route('login') }}"
                       class="text-dark text-decoration-none d-flex flex-column align-items-center">
                        <i class="fas fa-user-circle" style="font-size: 1.7rem;"></i>
                        <span class="small fw-medium d-none d-md-block">Masuk</span>
                    </a>
                @endguest

                @auth
                    @php
                        $profileRoute = auth()->user()->role == 'agent'
                            ? route('agent.dashboard')
                            : route('profile.show');
                    @endphp

                    <a href="{{ $profileRoute }}"
                       class="text-dark text-decoration-none d-flex flex-column align-items-center me-2">
                        <img src="{{ auth()->user()->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->full_name ?? auth()->user()->name) . '&background=FFD15C&color=333&bold=true' }}"
                             alt="Foto Profil"
                             style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid #eee;">
                        <span class="small fw-medium d-none d-md-block">
                            {{ \Illuminate\Support\Str::limit(auth()->user()->full_name ?? auth()->user()->name, 14) }}
                        </span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="m-0 d-none d-md-block">
                        @csrf
                        <button type="submit"
                                class="btn btn-link text-danger p-0"
                                title="Logout"
                                style="font-size: 1.4rem; line-height: 1;">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    {{-- ================= HERO: JELAJAHI PESONA (BACKGROUND PUTIH) ================= --}}
    <section class="py-4 py-md-5 bg-white">
        <div class="container">
            <div class="row align-items-center g-3 g-md-4">
                <div class="col-12 col-md-7 text-center">
                    <h2 class="fw-bold mb-2" style="font-size:1.6rem;">
                        Jelajahi Pesona Pesisir Barat
                    </h2>
                    <p class="mb-3 mb-md-4" style="font-size:0.95rem; color:#555;">
                        Temukan destinasi pantai, spot surfing, kuliner, hingga penginapan terbaik di Pesibar,
                        semuanya dalam satu aplikasi.
                    </p>

                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <span class="badge rounded-pill bg-light text-dark border">
                            🌊 Pantai & Surfing
                        </span>
                        <span class="badge rounded-pill bg-light text-dark border">
                            🏕 Destinasi Alam
                        </span>
                        <span class="badge rounded-pill bg-light text-dark border">
                            🍤 Kuliner Lokal
                        </span>
                    </div>
                </div>

                <div class="col-12 col-md-5 d-none d-md-block">
                    <div class="rounded-4 overflow-hidden shadow-sm">
                        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&q=80"
                             alt="Pantai Pesibar"
                             style="width:100%; height:230px; object-fit:cover;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= KATEGORI DESTINASI (KARTU BARU) ================= --}}
    <section class="category-section py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Kategori Destinasi</h5>
            </div>

            {{-- Mobile: scroll horizontal --}}
            <div class="d-flex d-md-none overflow-auto pb-2 mb-2" style="gap: 10px;">
                @forelse($categories as $category)
                    <a href="{{ route('destinations.category', $category->id) }}"
                       class="text-decoration-none flex-shrink-0"
                       style="width:140px;">
                        <div class="category-card destination-card">
                            <div class="destination-card-image">
                                @if(!empty($category->icon_url))
                                    <img src="{{ asset($category->icon_url) }}"
                                         alt="{{ $category->name }}"
                                         loading="lazy">
                                @else
                                    <svg viewBox="0 0 100 100" fill="none">
                                        <circle cx="50" cy="50" r="30" fill="#FFB85C"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="destination-card-body">
                                <p class="destination-card-title text-truncate mb-0">
                                    {{ $category->name }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-secondary small mb-0">Belum ada kategori.</p>
                @endforelse
            </div>

            {{-- Desktop: grid --}}
            <div class="row g-3 d-none d-md-flex">
                @forelse($categories as $category)
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="{{ route('destinations.category', $category->id) }}"
                           class="text-decoration-none">
                            <div class="category-card destination-card">
                                <div class="destination-card-image">
                                    @if(!empty($category->icon_url))
                                        <img src="{{ asset($category->icon_url) }}"
                                             alt="{{ $category->name }}"
                                             loading="lazy">
                                    @else
                                        <svg viewBox="0 0 100 100" fill="none">
                                            <circle cx="50" cy="50" r="30" fill="#FFB85C"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="destination-card-body">
                                    <p class="destination-card-title mb-0">
                                        {{ $category->name }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center text-secondary py-4">
                        Belum ada kategori tersedia
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================= REKOMENDASI DESTINASI ================= --}}
    <section class="bg-white py-4 py-md-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Rekomendasi buat kamu!</h5>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse($recommendations as $destination)
                    <div class="col">
                        <a href="{{ route('destinations.detail', $destination->id) }}"
                           class="card h-100 shadow-sm text-decoration-none text-dark border-0 rounded-4 overflow-hidden">

                            {{-- Gambar penuh di atas card --}}
                            <img src="{{ $destination->image_url ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=400&q=80' }}"
                                 alt="{{ $destination->name }}"
                                 class="card-img-top"
                                 style="height: 220px; object-fit: cover;">

                            <div class="card-body">

                                {{-- Nama & Rating bintang --}}
                                <div class="d-flex justify-content-between text-start mb-2">
                                    <h5 class="card-title fw-bold text-dark mb-0"
                                        style="font-size:1.05rem;">
                                        {{ $destination->name }}
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        @php
                                            $rating = (int) $destination->rating;
                                            $fullStars = min(5, max(0, $rating));
                                        @endphp
                                        @for($star = 0; $star < $fullStars; $star++)
                                            <svg style="width: 1.25rem; height: 1.25rem;" class="text-warning" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endfor
                                        @for($star = $fullStars; $star < 5; $star++)
                                            <svg style="width: 1.25rem; height: 1.25rem;" class="text-muted" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>

                                {{-- Alamat --}}
                                @if($destination->address)
                                    <div class="d-flex align-items-center text-muted small mb-3">
                                        <svg style="width: 1rem; height: 1rem;" class="me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="text-truncate" style="max-width: 230px;">
                                            {{ $destination->address }}
                                        </span>
                                    </div>
                                @endif

                                {{-- Harga per orang & harga parkir --}}
                                <div class="d-flex align-items-center gap-4 mb-3 flex-wrap">
                                    @if($destination->price_per_person > 0)
                                        <div class="d-flex align-items-center text-muted small">
                                            <svg style="width: 1rem; height: 1rem;" class="me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span>Rp {{ number_format($destination->price_per_person, 0, ',', '.') }}</span>
                                        </div>
                                    @endif

                                    @if($destination->parking_price > 0)
                                        <div class="d-flex align-items-center text-muted small">
                                            <svg style="width: 1rem; height: 1rem;" class="me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                                            </svg>
                                            <span>Parkir Rp {{ number_format($destination->parking_price, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Aktivitas populer --}}
                                @if(!empty($destination->popular_activities))
                                    <div class="mb-1 text-start">
                                        <p class="small fw-semibold text-dark mb-1">Aktivitas populer:</p>
                                        @php
                                            $acts = $destination->popular_activities;
                                            if (is_string($acts)) {
                                                $json = json_decode($acts, true);
                                                if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
                                                    $acts = $json;
                                                }
                                            }
                                        @endphp
                                        <p class="small text-muted mb-0">
                                            @if(is_array($acts))
                                                {{ implode(', ', $acts) }}
                                            @else
                                                {{ $acts }}
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center text-secondary py-5">
                        <p class="fs-5 mb-2">Belum ada rekomendasi tersedia</p>
                        <p class="small">Destinasi akan muncul di sini setelah ditambahkan oleh admin.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

</div>
@endsection

@section('bottom-nav')
    @include('partials.bottom-nav', ['active' => 'home'])
@endsection
