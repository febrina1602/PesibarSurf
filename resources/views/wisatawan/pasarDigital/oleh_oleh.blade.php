@extends('layouts.app')

@section('title', 'Oleh-oleh | PesibarSurf')

@section('content')
<div class="app-wrapper bg-white"> {{-- 1. Wrapper standar --}}

    {{-- =============================================== --}}
    {{-- ==== 2. HEADER & NAVIGASI STANDAR ==== --}}
    {{-- =============================================== --}}
    <header class="header-gradient shadow-sm sticky-top"> 
        <div class="container py-3 d-flex align-items-center justify-content-between">
            {{-- Tombol Kembali --}}
            <a href="{{ route('marketplace.index') }}" class="text-dark text-decoration-none">
                <i class="fas fa-arrow-left fa-lg"></i>
            </a>
            {{-- Judul Halaman --}}
            <h5 class="fw-bold mb-0">Oleh-oleh</h5> 
            {{-- Spacer --}}
            <div style="width: 24px;"></div> 
        </div>
        <img src="{{ asset('images/siger-pattern.png') }}" alt="Siger Pattern" class="siger-pattern-header" loading="lazy">
    </header>

    <nav class="nav-custom border-top bg-white shadow-sm">
        <div class="container py-0">
            <div class="d-flex gap-4 justify-content-left">
                <a href="{{ route('beranda.wisatawan') }}" class="nav-link-custom">
                    Beranda
                </a>
                <a href="{{ route('marketplace.index') }}" class="nav-link-custom active"> {{-- Set 'active' --}}
                   Pasar Digital
                </a>
                <a href="{{ route('pemandu-wisata.index') }}" class="nav-link-custom">
                   Pemandu Wisata
                </a>
            </div>
        </div>
    </nav>

    {{-- ========================================== --}}
    {{-- ==== 3. KONTEN ASLI HALAMAN ==== --}}
    {{-- ========================================== --}}
    <div class="container py-4"> {{-- 4. Container untuk konten --}}

        @forelse ($olehOlehList as $item)
            <div class="card marketplace-card mb-3" style="border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: 0;">
                <div class="card-body d-flex align-items-center">

                    {{-- Gambar toko --}}
                    <img src="{{ asset('storage/' .$item->image) }}"
                         class="me-3"
                         alt="{{ $item->name }}"
                         style="width:90px; height:90px; object-fit:cover; border-radius:16px;">

                    <div>
                        <h6 class="fw-semibold mb-1">{{ $item->name }}</h6>
                        <div class="d-flex align-items-center gap-3 mb-1 small text-muted">
                            <span>
                                <i class="fa-solid fa-location-dot me-1"></i>
                                {{ $item->location }}
                            </span>
                            @if ($item->rating)
                                <span>
                                    <i class="fa-solid fa-star text-warning me-1"></i>
                                    {{ number_format($item->rating, 1) }}
                                </span>
                            @endif
                        </div>

                        @if ($item->price_range)
                            <p class="marketplace-desc mb-2">{{ $item->price_range }}</p>
                        @endif

                        <button
                            type="button"
                            class="btn btn-market btn-sm btn-detail-oleh"
                            data-bs-toggle="modal"
                            data-bs-target="#modalDetailOleh"
                            data-name="{{ $item->name }}"
                            data-image="{{ asset('storage/' .$item->image) }}"
                            data-location="{{ $item->location }}"
                            data-rating="{{ $item->rating ?? '-' }}"
                            data-price="{{ $item->price_range ?? '-' }}"
                            data-description="{{ $item->description ?? '' }}"
                            data-whatsapp="{{ $item->whatsapp ?? '' }}">
                            Rincian
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted mt-4">Belum ada data oleh-oleh.</p>
        @endforelse

    </div>
</div> {{-- Tutup .app-wrapper --}}

{{-- ========================================== --}}
{{-- ==== 5. MODAL (TETAP DI LUAR WRAPPER) ==== --}}
{{-- ========================================== --}}
<div class="modal fade" id="modalDetailOleh" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            {{-- HEADER MODAL --}}
            <div class="marketplace-header-img" style="height:120px;">
                <div class="w-100 text-center mb-3">
                    <div class="marketplace-title">
                        <span class="d-block">Detail</span>
                        <span class="d-block">Oleh-oleh</span>
                    </div>
                </div>
                <button type="button" class="btn-close position-absolute end-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- BODY MODAL --}}
            <div class="modal-body" style="background:#f7f7f7;">
                <div class="container" style="max-width: 700px;">
                    <div class="mb-3">
                        <img id="olImage" src="" alt="Detail Oleh-oleh" style="width:100%; border-radius:20px; object-fit:cover; max-height:260px;">
                    </div>
                    <h5 id="olName" class="fw-semibold mb-2">Nama Toko</h5>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3 small text-muted">
                            <span>
                                <i class="fa-solid fa-location-dot me-1"></i>
                                <span id="olLocation">Lokasi</span>
                            </span>
                            <span>
                                <i class="fa-solid fa-star text-warning me-1"></i>
                                <span id="olRating">-</span>
                            </span>
                        </div>
                        <button class="btn btn-link p-0 text-muted">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                    </div>
                    <div class="card mb-3" style="border-radius:16px;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small text-muted mb-1">Kisaran harga</div>
                                <div id="olPrice" class="fw-semibold">-</div>
                            </div>
                        </div>
                    </div>
                    <p id="olDescription" class="small text-muted mb-4">
                        Deskripsi oleh-oleh akan tampil di sini.
                    </p>
                    <a id="olContact" href="#" target="_blank" class="btn w-100" style="background:linear-gradient(90deg,#F9C449,#E9A95C); color:#000; font-weight:600; border-radius:999px;">
                        <i class="fa-brands fa-whatsapp me-2"></i>
                        Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 6. HAPUS @section('bottom-nav') --}}
@endsection

@push('scripts')
{{-- Script JS tetap sama --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl   = document.getElementById('modalDetailOleh');
    const imgEl     = modalEl.querySelector('#olImage');
    const nameEl    = modalEl.querySelector('#olName');
    const locEl     = modalEl.querySelector('#olLocation');
    const ratingEl  = modalEl.querySelector('#olRating');
    const priceEl   = modalEl.querySelector('#olPrice');
    const descEl    = modalEl.querySelector('#olDescription');
    const contactEl = modalEl.querySelector('#olContact');

    document.querySelectorAll('.btn-detail-oleh').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const name      = this.dataset.name || 'Nama Toko';
            const image     = this.dataset.image || '';
            const location  = this.dataset.location || '-';
            const rating    = this.dataset.rating || '-';
            const price     = this.dataset.price || '-';
            const desc      = this.dataset.description || '';
            const whatsapp  = (this.dataset.whatsapp || '').replace(/[^0-9]/g, '');

            nameEl.textContent   = name;
            imgEl.src            = image;
            locEl.textContent    = location;
            ratingEl.textContent = rating;
            priceEl.textContent  = price;
            descEl.textContent   = desc || 'Klik tombol WhatsApp untuk informasi lebih lanjut.';

            if (whatsapp) {
                contactEl.href = 'https://wa.me/' + whatsapp;
            } else {
                contactEl.removeAttribute('href');
            }
        });
    });
});
</script>
@endpush