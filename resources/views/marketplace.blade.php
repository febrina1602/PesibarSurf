@extends('layouts.app')

@section('title', 'Pasar Digital | PesibarSurf')

@section('content')
    <div class="app-wrapper">

        <div class="marketplace-header-img d-flex align-items-end justify-content-center pb-2">
            <h5 class="marketplace-title text-center mb-2">Pasar Digital</h5>
        </div>
        <div class="container py-3">
            {{-- Kartu kategori --}}
            <div class="card marketplace-card mb-3">
                <div class="card-body d-flex align-items-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/201/201623.png" class="me-3" alt="Transportasi">
                    <div>
                        <h6 class="fw-semibold mb-1">Transportasi</h6>
                        <p class="marketplace-desc mb-2">Dapatkan transportasi yang kamu inginkan</p>
                        <a href="{{ route('transport.daerah') }}" class="btn btn-market me-1 mb-1">
                            Transportasi Daerah
                        </a>
                        <a href="{{ route('transport.luar') }}" class="btn btn-market me-1 mb-1">
                            Transportasi Luar
                        </a>
                    </div>
                </div>
            </div>

            <div class="card marketplace-card mb-3">
                <div class="card-body d-flex align-items-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/139/139899.png" class="me-3" alt="Penginapan">
                    <div>
                        <h6 class="fw-semibold mb-1">Penginapan</h6>
                        <p class="marketplace-desc mb-2">Dapatkan penginapan yang nyaman</p>
                        <a href="#" class="btn btn-market mb-1">Pilih Penginapan</a>
                    </div>
                </div>
            </div>

            <div class="card marketplace-card mb-3">
                <div class="card-body d-flex align-items-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png" class="me-3" alt="Oleh-oleh">
                    <div>
                        <h6 class="fw-semibold mb-1">Oleh-oleh</h6>
                        <p class="marketplace-desc mb-2">Dapatkan oleh-oleh untuk kamu bawa pulang</p>
                        <a href="#" class="btn btn-market mb-1">Pilih Oleh-oleh</a>
                    </div>
                </div>
            </div>

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