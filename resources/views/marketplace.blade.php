@extends('layouts.app')

@section('title', 'Pasar Digital | PesibarSurf')

@section('content')
    <div class="app-wrapper">

        {{-- HEADER --}}
        <div class="marketplace-header-img d-flex align-items-end justify-content-center pb-2">
            <h5 class="marketplace-title text-center mb-2">Pasar Digital</h5>
        </div>

        <div class="container py-3">
            {{-- LOOP KATEGORI DARI DATABASE --}}
            @foreach ($categories as $category)
                <div class="card marketplace-card mb-3">
                    <div class="card-body d-flex align-items-center">

                        {{-- ICON IMAGE DARI DB --}}
                        <img src="{{ asset($category->image) }}"
                             class="me-3"
                             alt="{{ $category->title }}"
                             style="width:60px; height:60px; object-fit:contain;">

                        <div>
                            <h6 class="fw-semibold mb-1">{{ $category->title }}</h6>
                            <p class="marketplace-desc mb-2">{{ $category->description }}</p>

                            {{-- TOMBOL-TOMBOL DARI FIELD buttons (JSON) --}}
                            @if (is_array($category->buttons))
                                @foreach ($category->buttons as $btn)
                                    @php
                                        // default link
                                        $href = '#';

                                        // Mapping berdasarkan slug + teks tombol
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
            @endforeach

        </div>
    </div>

    {{-- Bottom navigation --}}
    <div class="bottom-nav-market d-flex justify-content-around">
        <div class="nav-item-custom">
            <i class="fa-solid fa-house"></i>
            <span>Beranda</span>
        </div>
        <div class="nav-item-custom active">
            <i class="fa-solid fa-bag-shopping"></i>
            <span>Pasar Digital</span>
        </div>
        <div class="nav-item-custom">
            <i class="fa-solid fa-bus"></i>
            <span>Pemandu Wisata</span>
        </div>
        <div class="nav-item-custom">
            <i class="fa-solid fa-user"></i>
            <span>Akun</span>
        </div>
    </div>
@endsection
