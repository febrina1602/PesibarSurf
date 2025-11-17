@extends('layouts.app')

@section('title', 'Transportasi Luar | PesibarSurf')

@section('content')
<div class="app-wrapper">

    {{-- HEADER --}}
    <div class="marketplace-header-img d-flex align-items-end justify-content-center pb-2">
        <h5 class="marketplace-title text-center mb-2">Transportasi Luar</h5>
    </div>

    {{-- KATEGORI: Travel & Bus --}}
    <div class="container py-3">
        @foreach ($categories as $category)
            <div class="card marketplace-card mb-3">
                <div class="card-body d-flex align-items-center">

                    {{-- Gambar kategori --}}
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
                            data-bs-target="#{{ $category['modal_id'] }}">
                            Rincian
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- BOTTOM NAV --}}
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

{{-- ================== MODAL: AGEN TRAVEL ================== --}}
<div class="modal fade" id="modalLuarTravel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden">

            {{-- Header modal --}}
            <div class="marketplace-header-img" style="height:120px;">
                <div class="w-100 text-center mb-3">
                    <div class="marketplace-title">
                        <span class="d-block">Agen Travel</span>
                    </div>
                </div>

                <button type="button"
                        class="btn-close position-absolute end-0 mt-3 me-3"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            {{-- Body modal --}}
            <div class="modal-body" style="background:#f7f7f7;">
                <div class="container py-3" style="max-width:1000px;">
                    <div class="row g-3">
                        @forelse ($travelAgents as $agent)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm border-0" style="border-radius:16px;">
                                    <img src="{{ asset($agent->image) }}"
                                         class="card-img-top"
                                         style="border-radius:16px 16px 0 0; height:150px; object-fit:cover;"
                                         alt="{{ $agent->name }}">

                                    <div class="card-body">
                                        <small class="text-muted d-block mb-1">
                                            Terverifikasi
                                            <i class="fa-solid fa-circle-check text-success ms-1"></i>
                                        </small>
                                        <h6 class="fw-semibold mb-1">{{ $agent->name }}</h6>

                                        <div class="small text-muted mb-2">
                                            <i class="fa-solid fa-location-dot me-1"></i>
                                            {{ $agent->location }}
                                        </div>

                                        <button
                                            class="btn btn-market btn-sm btn-detail-agen-luar"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetailAgenLuar"
                                            data-type="travel"
                                            data-name="{{ $agent->name }}"
                                            data-image="{{ asset($agent->image) }}"
                                            data-location="{{ $agent->location }}"
                                            data-rating="{{ $agent->rating ?? '-' }}"
                                            data-price="{{ $agent->price_range ?? '-' }}"
                                            data-description="{{ $agent->description ?? '' }}"
                                            data-whatsapp="{{ $agent->whatsapp ?? '' }}">
                                            Rincian
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">Belum ada data agen travel.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ================== MODAL: AGEN PEMESANAN BUS ================== --}}
<div class="modal fade" id="modalLuarBus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden">

            {{-- Header modal --}}
            <div class="marketplace-header-img" style="height:120px;">
                <div class="w-100 text-center mb-3">
                    <div class="marketplace-title">
                        <span class="d-block">Agen Pemesanan Bus</span>
                    </div>
                </div>

                <button type="button"
                        class="btn-close position-absolute end-0 mt-3 me-3"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            {{-- Body modal --}}
            <div class="modal-body" style="background:#f7f7f7;">
                <div class="container py-3" style="max-width:1000px;">
                    <div class="row g-3">
                        @forelse ($busAgents as $agent)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm border-0" style="border-radius:16px;">
                                    <img src="{{ asset($agent->image) }}"
                                         class="card-img-top"
                                         style="border-radius:16px 16px 0 0; height:150px; object-fit:cover;"
                                         alt="{{ $agent->name }}">

                                    <div class="card-body">
                                        <small class="text-muted d-block mb-1">
                                            Terverifikasi
                                            <i class="fa-solid fa-circle-check text-success ms-1"></i>
                                        </small>
                                        <h6 class="fw-semibold mb-1">{{ $agent->name }}</h6>

                                        <div class="small text-muted mb-2">
                                            <i class="fa-solid fa-location-dot me-1"></i>
                                            {{ $agent->location }}
                                        </div>

                                        <button
                                            class="btn btn-market btn-sm btn-detail-agen-luar"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetailAgenLuar"
                                            data-type="bus"
                                            data-name="{{ $agent->name }}"
                                            data-image="{{ asset($agent->image) }}"
                                            data-location="{{ $agent->location }}"
                                            data-rating="{{ $agent->rating ?? '-' }}"
                                            data-price="{{ $agent->price_range ?? '-' }}"
                                            data-description="{{ $agent->description ?? '' }}"
                                            data-whatsapp="{{ $agent->whatsapp ?? '' }}">
                                            Rincian
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">Belum ada data agen bus.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- =============== MODAL DETAIL AGEN LUAR (dipakai semua) =============== --}}
<div class="modal fade" id="modalDetailAgenLuar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden">

            {{-- HEADER MODAL --}}
            <div class="marketplace-header-img" style="height:120px;">
                <div class="w-100 text-center mb-3">
                    <div class="marketplace-title">
                        <span class="d-block">Detail</span>
                        <span class="d-block">Agen</span>
                    </div>
                </div>

                <button type="button"
                        class="btn-close position-absolute end-0 mt-3 me-3"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            {{-- BODY MODAL --}}
            <div class="modal-body" style="background:#f7f7f7;">
                <div class="container" style="max-width: 700px;">

                    {{-- Gambar utama --}}
                    <div class="mb-3">
                        <img id="tlDetailImage"
                             src=""
                             alt="Detail Agen"
                             style="width:100%; border-radius:20px; object-fit:cover; max-height:260px;">
                    </div>

                    {{-- Nama & info --}}
                    <h5 id="tlDetailName" class="fw-semibold mb-2">Nama Agen</h5>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3 small text-muted">
                            <span class="badge bg-info text-dark" id="tlDetailTypeLabel">Tipe</span>
                            <span>
                                <i class="fa-solid fa-location-dot me-1"></i>
                                <span id="tlDetailLocation">Lokasi</span>
                            </span>
                            <span>
                                <i class="fa-solid fa-star text-warning me-1"></i>
                                <span id="tlDetailRating">-</span>
                            </span>
                        </div>

                        <button class="btn btn-link p-0 text-muted">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                    </div>

                    {{-- Harga --}}
                    <div class="card mb-3" style="border-radius:16px;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small text-muted mb-1">Kisaran tarif</div>
                                <div id="tlDetailPrice" class="fw-semibold">-</div>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <p id="tlDetailDescription" class="small text-muted mb-4">
                        Deskripsi agen akan tampil di sini.
                    </p>

                    {{-- Tombol Hubungi --}}
                    <a id="tlDetailContact"
                       href="#"
                       target="_blank"
                       class="btn w-100"
                       style="background:linear-gradient(90deg,#F9C449,#E9A95C); color:#000; font-weight:600; border-radius:999px;">
                        <i class="fa-brands fa-whatsapp me-2"></i>
                        Hubungi via WhatsApp
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('bottom-nav')
    @include('partials.bottom-nav', ['active' => 'marketplace'])
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const detailModal = document.getElementById('modalDetailAgenLuar');

    const imgEl     = detailModal.querySelector('#tlDetailImage');
    const nameEl    = detailModal.querySelector('#tlDetailName');
    const typeEl    = detailModal.querySelector('#tlDetailTypeLabel');
    const locEl     = detailModal.querySelector('#tlDetailLocation');
    const ratingEl  = detailModal.querySelector('#tlDetailRating');
    const priceEl   = detailModal.querySelector('#tlDetailPrice');
    const descEl    = detailModal.querySelector('#tlDetailDescription');
    const contactEl = detailModal.querySelector('#tlDetailContact');

    document.querySelectorAll('.btn-detail-agen-luar').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const type     = this.dataset.type || '';
            const name     = this.dataset.name || 'Nama Agen';
            const image    = this.dataset.image || '';
            const location = this.dataset.location || '-';
            const rating   = this.dataset.rating || '-';
            const price    = this.dataset.price || '-';
            const desc     = this.dataset.description || '';
            const whatsapp = (this.dataset.whatsapp || '').replace(/[^0-9]/g, '');

            if (type === 'travel') {
                typeEl.textContent = 'Agen Travel';
            } else {
                typeEl.textContent = 'Agen Pemesanan Bus';
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