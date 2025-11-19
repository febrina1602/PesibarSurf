@extends('layouts.app')

@section('title', 'Transportasi Daerah | PesibarSurf')

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
            <h5 class="fw-bold mb-0">Transportasi Daerah</h5> 
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
    
        @foreach ($categories as $category)
            <div class="card marketplace-card mb-3" style="border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: 0;">
                <div class="card-body d-flex align-items-center">

                    <img src="{{ asset($category['image']) }}"
                         class="me-3"
                         alt="{{ $category['title'] }}"
                         style="width:90px; height:90px; object-fit:cover; border-radius:16px;">

                    <div>
                        <h6 class="fw-semibold mb-1">{{ $category['title'] }}</h6>
                        <p class="marketplace-desc mb-2">{{ $category['description'] }}</p>

                        <button
                            type="button"
                            class="btn btn-market btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#{{ $category['modal_id'] }}" >
                            Rincian
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div> {{-- Tutup .app-wrapper --}}

{{-- ========================================== --}}
{{-- ==== 5. MODAL (TETAP DI LUAR WRAPPER) ==== --}}
{{-- ========================================== --}}

{{-- ================== MODAL: AGEN SEWA MOBIL ================== --}}
<div class="modal fade" id="modalDaerahMobil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="marketplace-header-img" style="height:120px;">
                <div class="w-100 text-center mb-3">
                    <div class="marketplace-title">
                        <span class="d-block">Agen Sewa Mobil</span>
                    </div>
                </div>
                <button type="button" class="btn-close position-absolute end-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background:#f7f7f7;">
                <div class="container py-3" style="max-width:1000px;">
                    <div class="row g-3">
                        @forelse ($mobilAgents as $agent)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm border-0" style="border-radius:16px;">
                                    <img src="{{ asset('storage/' .$agent->image) }}" class="card-img-top" style="border-radius:16px 16px 0 0; height:150px; object-fit:cover;" alt="{{ $agent->name }}">
                                    <div class="card-body">
                                        <small class="text-muted d-block mb-1">
                                            Terverifikasi <i class="fa-solid fa-circle-check text-success ms-1"></i>
                                        </small>
                                        <h6 class="fw-semibold mb-1">{{ $agent->name }}</h6>
                                        <div class="small text-muted mb-2">
                                            <i class="fa-solid fa-location-dot me-1"></i> {{ $agent->location }}
                                        </div>
                                        <button
                                            class="btn btn-market btn-sm btn-detail-agen-daerah"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetailAgenDaerah"
                                            data-type="mobil"
                                            data-name="{{ $agent->name }}"
                                            data-image="{{ asset('storage/' .$agent->image) }}"
                                            data-location="{{ $agent->location }}"
                                            data-rating="{{ $agent->rating ?? '-' }}"
                                            data-price="{{ $agent->price_range ?? '-' }}"
                                            data-description="{{ $agent->description ?? '' }}"
                                            data-whatsapp="{{ $agent->whatsapp ?? '' }}" >
                                            Rincian
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">Belum ada data agen sewa mobil.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================== MODAL: AGEN SEWA MOTOR ================== --}}
<div class="modal fade" id="modalDaerahMotor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="marketplace-header-img" style="height:120px;">
                <div class="w-100 text-center mb-3">
                    <div class="marketplace-title">
                        <span class="d-block">Agen Sewa Motor</span>
                    </div>
                </div>
                <button type="button" class="btn-close position-absolute end-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background:#f7f7f7;">
                <div class="container py-3" style="max-width:1000px;">
                    <div class="row g-3">
                        @forelse ($motorAgents as $agent)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm border-0" style="border-radius:16px;">
                                    <img src="{{ asset('storage/' .$agent->image) }}" class="card-img-top" style="border-radius:16px 16px 0 0; height:150px; object-fit:cover;" alt="{{ $agent->name }}">
                                    <div class="card-body">
                                        <small class="text-muted d-block mb-1">
                                            Terverifikasi <i class="fa-solid fa-circle-check text-success ms-1"></i>
                                        </small>
                                        <h6 class="fw-semibold mb-1">{{ $agent->name }}</h6>
                                        <div class="small text-muted mb-2">
                                            <i class="fa-solid fa-location-dot me-1"></i> {{ $agent->location }}
                                        </div>
                                        <button
                                            class="btn btn-market btn-sm btn-detail-agen-daerah"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetailAgenDaerah"
                                            data-type="motor"
                                            data-name="{{ $agent->name }}"
                                            data-image="{{ asset('storage/' .$agent->image) }}"
                                            data-location="{{ $agent->location }}"
                                            data-rating="{{ $agent->rating ?? '-' }}"
                                            data-price="{{ $agent->price_range ?? '-' }}"
                                            data-description="{{ $agent->description ?? '' }}"
                                            data-whatsapp="{{ $agent->whatsapp ?? '' }}" >
                                            Rincian
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">Belum ada data agen sewa motor.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================== MODAL: AGEN PENYEBERANGAN PULAU ================== --}}
<div class="modal fade" id="modalDaerahPenyeberangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="marketplace-header-img" style="height:120px;">
                <div class="w-100 text-center mb-3">
                    <div class="marketplace-title">
                        <span class="d-block">Agen Penyeberangan Pulau</span>
                    </div>
                </div>
                <button type="button" class="btn-close position-absolute end-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background:#f7f7f7;">
                <div class="container py-3" style="max-width:1000px;">
                    <div class="row g-3">
                        @forelse ($penyeberanganAgents as $agent)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm border-0" style="border-radius:16px;">
                                    <img src="{{ asset('storage/' .$agent->image) }}" class="card-img-top" style="border-radius:16px 16px 0 0; height:150px; object-fit:cover;" alt="{{ $agent->name }}">
                                    <div class="card-body">
                                        <small class="text-muted d-block mb-1">
                                            Terverifikasi <i class="fa-solid fa-circle-check text-success ms-1"></i>
                                        </small>
                                        <h6 class="fw-semibold mb-1">{{ $agent->name }}</h6>
                                        <div class="small text-muted mb-2">
                                            <i class="fa-solid fa-location-dot me-1"></i> {{ $agent->location }}
                                        </div>
                                        <button
                                            class="btn btn-market btn-sm btn-detail-agen-daerah"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetailAgenDaerah"
                                            data-type="penyeberangan"
                                            data-name="{{ $agent->name }}"
                                            data-image="{{ asset('storage/' .$agent->image) }}"
                                            data-location="{{ $agent->location }}"
                                            data-rating="{{ $agent->rating ?? '-' }}"
                                            data-price="{{ $agent->price_range ?? '-' }}"
                                            data-description="{{ $agent->description ?? '' }}"
                                            data-whatsapp="{{ $agent->whatsapp ?? '' }}" >
                                            Rincian
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">Belum ada data agen penyeberangan pulau.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- =============== MODAL DETAIL AGEN DAERAH (dipakai semua) =============== --}}
<div class="modal fade" id="modalDetailAgenDaerah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="marketplace-header-img" style="height:120px;">
                <div class="w-100 text-center mb-3">
                    <div class="marketplace-title">
                        <span class="d-block">Detail</span>
                        <span class="d-block">Agen</span>
                    </div>
                </div>
                <button type="button" class="btn-close position-absolute end-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background:#f7f7f7;">
                <div class="container" style="max-width: 700px;">
                    <div class="mb-3">
                        <img id="tdDetailImage" src="" alt="Detail Agen" style="width:100%; border-radius:20px; object-fit:cover; max-height:260px;">
                    </div>
                    <h5 id="tdDetailName" class="fw-semibold mb-2">Nama Agen</h5>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3 small text-muted">
                            <span class="badge bg-warning text-dark" id="tdDetailTypeLabel">Tipe</span>
                            <span>
                                <i class="fa-solid fa-location-dot me-1"></i>
                                <span id="tdDetailLocation">Lokasi</span>
                            </span>
                            <span>
                                <i class="fa-solid fa-star text-warning me-1"></i>
                                <span id="tdDetailRating">-</span>
                            </span>
                        </div>
                        <button class="btn btn-link p-0 text-muted">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                    </div>
                    <div class="card mb-3" style="border-radius:16px;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small text-muted mb-1">Kisaran tarif</div>
                                <div id="tdDetailPrice" class="fw-semibold">-</div>
                            </div>
                        </div>
                    </div>
                    <p id="tdDetailDescription" class="small text-muted mb-4">
                        Deskripsi agen akan tampil di sini.
                    </p>
                    <a id="tdDetailContact" href="#" target="_blank" class="btn w-100" style="background:linear-gradient(90deg,#F9C449,#E9A95C); color:#000; font-weight:600; border-radius:999px;">
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
    const detailModal = document.getElementById('modalDetailAgenDaerah');
    const imgEl     = detailModal.querySelector('#tdDetailImage');
    const nameEl    = detailModal.querySelector('#tdDetailName');
    const typeEl    = detailModal.querySelector('#tdDetailTypeLabel');
    const locEl     = detailModal.querySelector('#tdDetailLocation');
    const ratingEl  = detailModal.querySelector('#tdDetailRating');
    const priceEl   = detailModal.querySelector('#tdDetailPrice');
    const descEl    = detailModal.querySelector('#tdDetailDescription');
    const contactEl = detailModal.querySelector('#tdDetailContact');

    document.querySelectorAll('.btn-detail-agen-daerah').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const type     = this.dataset.type || '';
            const name     = this.dataset.name || 'Nama Agen';
            const image    = this.dataset.image || '';
            const location = this.dataset.location || '-';
            const rating   = this.dataset.rating || '-';
            const price    = this.dataset.price || '-';
            const desc     = this.dataset.description || '';
            const whatsapp = (this.dataset.whatsapp || '').replace(/[^0-9]/g, '');

            if (type === 'mobil') {
                typeEl.textContent = 'Agen Sewa Mobil';
            } else if (type === 'motor') {
                typeEl.textContent = 'Agen Sewa Motor';
            } else {
                typeEl.textContent = 'Agen Penyeberangan Pulau';
            }

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