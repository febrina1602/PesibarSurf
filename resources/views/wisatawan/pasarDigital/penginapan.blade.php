@extends('layouts.app')

@section('title', 'Penginapan | PesibarSurf')

@section('content')
<div class="app-wrapper bg-white"> {{-- 1. Wrapper standar --}}

    {{-- =============================================== --}}
    {{-- ==== 2. HEADER & NAVIGASI STANDAR ==== --}}
    {{-- =============================================== --}}
    <header class="header-gradient shadow-sm sticky-top"> 
        <div class="container py-3 d-flex align-items-center justify-content-between">
            <a href="{{ route('marketplace.index') }}" class="text-dark text-decoration-none">
                <i class="fas fa-arrow-left fa-lg"></i>
            </a>
            <h5 class="fw-bold mb-0">Penginapan</h5> 
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
                <a href="{{ route('marketplace.index') }}" class="nav-link-custom active">
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

        @forelse ($penginapans as $item)
            <div class="card marketplace-card mb-3" style="border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: 0;">
                <div class="card-body d-flex align-items-center">

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

                        @if ($item->price_start)
                            <p class="marketplace-desc mb-2">{{ $item->price_start }}</p>
                        @endif

                        <button
                            type="button"
                            class="btn btn-market btn-sm btn-detail-penginapan"
                            data-bs-toggle="modal"
                            data-bs-target="#modalDetailPenginapan"
                            data-name="{{ $item->name }}"
                            data-image="{{ asset('storage/' .$item->image) }}"
                            data-location="{{ $item->location }}"
                            data-rating="{{ $item->rating ?? '-' }}"
                            data-price="{{ $item->price_start ?? '-' }}"
                            data-description="{{ $item->description ?? '' }}"
                            data-whatsapp="{{ $item->whatsapp ?? '' }}" >
                            Rincian
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted mt-4">Belum ada data penginapan.</p>
        @endforelse

    </div>
</div> {{-- Tutup .app-wrapper --}}

{{-- ========================================== --}}
{{-- ==== 5. MODAL (TETAP DI LUAR WRAPPER) ==== --}}
{{-- ========================================== --}}
<div class="modal fade" id="modalDetailPenginapan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            {{-- HEADER MODAL --}}
            <div class="marketplace-header-img" style="height:120px;">
                <div class="w-100 text-center mb-3">
                    <div class="marketplace-title">
                        <span class="d-block">Detail</span>
                        <span class="d-block">Penginapan</span>
                    </div>
                </div>
                <button type="button" class="btn-close position-absolute end-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- BODY MODAL --}}
            <div class="modal-body" style="background:#f7f7f7;">
                <div class="container" style="max-width: 700px;">
                    <div class="mb-3">
                        <img id="pgImage" src="" alt="Detail Penginapan" style="width:100%; border-radius:20px; object-fit:cover; max-height:260px;">
                    </div>
                    <h5 id="pgName" class="fw-semibold mb-2">Nama Penginapan</h5>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3 small text-muted">
                            <span>
                                <i class="fa-solid fa-location-dot me-1"></i>
                                <span id="pgLocation">Lokasi</span>
                            </span>
                            <span>
                                <i class="fa-solid fa-star text-warning me-1"></i>
                                <span id="pgRating">-</span>
                            </span>
                        </div>
                        <button class="btn btn-link p-0 text-muted">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                    </div>
                    <div class="card mb-3" style="border-radius:16px;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small text-muted mb-1">Harga mulai dari</div>
                                <div id="pgPrice" class="fw-semibold">-</div>
                            </div>
                        </div>
                    </div>
                    <p id="pgDescription" class="small text-muted mb-4">
                        Deskripsi penginapan akan tampil di sini.
                    </p>
                    <a id="pgContact" href="#" target="_blank" class="btn w-100" style="background:linear-gradient(90deg,#F9C449,#E9A95C); color:#000; font-weight:600; border-radius:999px;">
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
    const modalEl   = document.getElementById('modalDetailPenginapan');
    const imgEl     = modalEl.querySelector('#pgImage');
    const nameEl    = modalEl.querySelector('#pgName');
    const locEl     = modalEl.querySelector('#pgLocation');
    const ratingEl  = modalEl.querySelector('#pgRating');
    const priceEl   = modalEl.querySelector('#pgPrice');
    const descEl    = modalEl.querySelector('#pgDescription');
    const contactEl = modalEl.querySelector('#pgContact');

    document.querySelectorAll('.btn-detail-penginapan').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const name      = this.dataset.name || 'Nama Penginapan';
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