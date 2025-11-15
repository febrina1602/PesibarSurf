@extends('layouts.app')

@section('title', 'Transportasi Daerah | PesibarSurf')

@section('content')
<div class="app-wrapper">

    {{-- HEADER DENGAN GRADIENT + PATTERN --}}
    <div class="marketplace-header-img">
        <div class="w-100 text-center mb-3">
            <div class="marketplace-title">
                <span class="d-block">Transportasi Daerah</span>
            </div>
        </div>
    </div>

    {{-- LIST KATEGORI TRANSPORTASI DAERAH --}}
    <div class="container py-3">

        @php
            $modalTargets = [
                '#modalAgenMobil',
                '#modalAgenMotor',
                '#modalAgenKapal',
            ];
        @endphp

        @foreach ($items as $index => $item)
            <div class="card marketplace-card mb-3">
                <div class="card-body d-flex align-items-center">

                    <img src="{{ $item['image'] }}"
                         class="me-3"
                         style="width:90px; height:auto;"
                         alt="{{ $item['title'] }}">

                    <div>
                        <h6 class="fw-semibold mb-1">{{ $item['title'] }}</h6>
                        <p class="marketplace-desc mb-2">{{ $item['description'] }}</p>

                        {{-- Tombol buka modal kategori masing-masing --}}
                        <button type="button"
                                class="btn btn-market"
                                data-bs-toggle="modal"
                                data-bs-target="{{ $modalTargets[$index] }}">
                            {{ $item['button'] }}
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>

{{-- BOTTOM NAVIGATION --}}
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

{{-- ================== MODAL AGEN SEWA MOBIL ================== --}}
<div class="modal fade" id="modalAgenMobil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden">

            {{-- Header modal --}}
            <div class="marketplace-header-img" style="height:120px;">
                <div class="w-100 text-center mb-3">
                    <div class="marketplace-title">
                        <span class="d-block">Agen</span>
                        <span class="d-block">Sewa Mobil</span>
                    </div>
                </div>

                <button type="button"
                        class="btn-close position-absolute end-0 mt-3 me-3"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            {{-- Body modal --}}
            <div class="modal-body" style="background:#f7f7f7;">
                <div class="container py-3" style="max-width: 1000px;">
                    <div class="row g-3">
                        @foreach ($mobilAgents as $agent)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm border-0" style="border-radius:16px;">
                                    <img src="{{ $agent['image'] }}"
                                         class="card-img-top"
                                         style="border-radius:16px 16px 0 0; height:150px; object-fit:cover;"
                                         alt="{{ $agent['name'] }}">

                                    <div class="card-body">
                                        <small class="text-muted d-block mb-1">
                                            Terverifikasi
                                            <i class="fa-solid fa-circle-check text-success ms-1"></i>
                                        </small>
                                        <h6 class="fw-semibold mb-2">{{ $agent['name'] }}</h6>

                                        <button
                                            class="btn btn-market btn-sm btn-detail-agen"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetailAgen"
                                            data-name="{{ $agent['name'] }}"
                                            data-image="{{ $agent['image'] }}"
                                            data-location="Krui"
                                            data-rating="5.0"
                                            data-agency="Agensi"
                                            data-description="Klik tombol 'Hubungi Kami' untuk melakukan pemesanan pada agensi kami."
                                            data-whatsapp="628123456789">
                                            Rincian
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ================== MODAL AGEN SEWA MOTOR ================== --}}
<div class="modal fade" id="modalAgenMotor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden">

            {{-- Header modal --}}
            <div class="marketplace-header-img" style="height:120px;">
                <div class="w-100 text-center mb-3">
                    <div class="marketplace-title">
                        <span class="d-block">Agen</span>
                        <span class="d-block">Sewa Motor</span>
                    </div>
                </div>

            <button type="button"
                    class="btn-close position-absolute end-0 mt-3 me-3"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            {{-- Body modal --}}
            <div class="modal-body" style="background:#f7f7f7;">
                <div class="container py-3" style="max-width: 1000px%;">
                    <div class="row g-3">
                        @foreach ($motorAgents as $agent)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm border-0" style="border-radius:16px;">
                                    <img src="{{ $agent['image'] }}"
                                         class="card-img-top"
                                         style="border-radius:16px 16px 0 0; height:150px; object-fit:cover;"
                                         alt="{{ $agent['name'] }}">

                                    <div class="card-body">
                                        <small class="text-muted d-block mb-1">
                                            Terverifikasi
                                            <i class="fa-solid fa-circle-check text-success ms-1"></i>
                                        </small>
                                        <h6 class="fw-semibold mb-2">{{ $agent['name'] }}</h6>

                                        <button
                                            class="btn btn-market btn-sm btn-detail-agen"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetailAgen"
                                            data-name="{{ $agent['name'] }}"
                                            data-image="{{ $agent['image'] }}"
                                            data-location="Krui"
                                            data-rating="5.0"
                                            data-agency="Agensi"
                                            data-description="Klik tombol 'Hubungi Kami' untuk melakukan pemesanan pada agensi kami."
                                            data-whatsapp="628123456789">
                                            Rincian
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ================== MODAL AGEN PENYEBERANGAN / KAPAL ================== --}}
<div class="modal fade" id="modalAgenKapal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden">

            {{-- Header modal --}}
            <div class="marketplace-header-img" style="height:120px;">
                <div class="w-100 text-center mb-3">
                    <div class="marketplace-title">
                        <span class="d-block">Agen</span>
                        <span class="d-block">Penyeberangan Pulau</span>
                    </div>
                </div>

                <button type="button"
                        class="btn-close position-absolute end-0 mt-3 me-3"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            {{-- Body modal --}}
            <div class="modal-body" style="background:#f7f7f7;">
                <div class="container py-3" style="max-width: 1000px;">
                    <div class="row g-3">
                        @foreach ($kapalAgents as $agent)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm border-0" style="border-radius:16px;">
                                    <img src="{{ $agent['image'] }}"
                                         class="card-img-top"
                                         style="border-radius:16px 16px 0 0; height:150px; object-fit:cover;"
                                         alt="{{ $agent['name'] }}">

                                    <div class="card-body">
                                        <small class="text-muted d-block mb-1">
                                            Terverifikasi
                                            <i class="fa-solid fa-circle-check text-success ms-1"></i>
                                        </small>
                                        <h6 class="fw-semibold mb-2">{{ $agent['name'] }}</h6>

                                        <button
                                            class="btn btn-market btn-sm btn-detail-agen"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetailAgen"
                                            data-name="{{ $agent['name'] }}"
                                            data-image="{{ $agent['image'] }}"
                                            data-location="Krui"
                                            data-rating="5.0"
                                            data-agency="Agensi"
                                            data-description="Klik tombol 'Hubungi Kami' untuk melakukan pemesanan pada agensi kami."
                                            data-whatsapp="628123456789">
                                            Rincian
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- =============== MODAL DETAIL AGEN (Dipakai Semua) =============== --}}
<div class="modal fade" id="modalDetailAgen" tabindex="-1" aria-hidden="true">
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
                        <img id="detailAgenImage"
                             src=""
                             alt="Detail Agen"
                             style="width:100%; border-radius:20px; object-fit:cover; max-height:260px;">
                    </div>

                    {{-- Nama & info singkat --}}
                    <h5 id="detailAgenName" class="fw-semibold mb-2">Nama Agen</h5>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center text-muted small">
                                <i class="fa-solid fa-location-dot me-1"></i>
                                <span id="detailAgenLocation">Lokasi</span>
                            </div>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="fa-solid fa-star text-warning me-1"></i>
                                <span id="detailAgenRating">5.0</span>
                            </div>
                        </div>

                        <button class="btn btn-link p-0 text-muted">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                    </div>

                    {{-- Kartu info agensi --}}
                    <div class="card mb-3" style="border-radius:16px;">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded-circle overflow-hidden" style="width:40px; height:40px;">
                                <img src="https://i.ibb.co/x5LZK6C/avatar.png"
                                     alt="Agensi"
                                     style="width:100%; height:100%; object-fit:cover;">
                            </div>
                            <div>
                                <div id="detailAgenAgency" class="fw-semibold small">Agensi</div>
                                <small class="text-muted">
                                    Terverifikasi
                                    <i class="fa-solid fa-circle-check text-success ms-1"></i>
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <p id="detailAgenDescription" class="small text-muted mb-4">
                        Klik tombol "Hubungi Kami" untuk melakukan pemesanan pada agensi kami.
                    </p>

                    {{-- Tombol Hubungi --}}
                    <a id="detailAgenContact"
                       href="#"
                       target="_blank"
                       class="btn w-100"
                       style="background:linear-gradient(90deg,#F9C449,#E9A95C); color:#000; font-weight:600; border-radius:999px;">
                        <i class="fa-brands fa-whatsapp me-2"></i>
                        Hubungi Kami
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const detailModal   = document.getElementById('modalDetailAgen');
    const imgEl         = detailModal.querySelector('#detailAgenImage');
    const nameEl        = detailModal.querySelector('#detailAgenName');
    const locEl         = detailModal.querySelector('#detailAgenLocation');
    const ratingEl      = detailModal.querySelector('#detailAgenRating');
    const agencyEl      = detailModal.querySelector('#detailAgenAgency');
    const descEl        = detailModal.querySelector('#detailAgenDescription');
    const contactBtnEl  = detailModal.querySelector('#detailAgenContact');

    document.querySelectorAll('.btn-detail-agen').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const name       = this.dataset.name || 'Nama Agen';
            const image      = this.dataset.image || '';
            const location   = this.dataset.location || '-';
            const rating     = this.dataset.rating || '-';
            const agency     = this.dataset.agency || 'Agensi';
            const desc       = this.dataset.description || '';
            const whatsapp   = (this.dataset.whatsapp || '').replace(/[^0-9]/g, '');

            nameEl.textContent    = name;
            imgEl.src             = image;
            locEl.textContent     = location;
            ratingEl.textContent  = rating;
            agencyEl.textContent  = agency;
            descEl.textContent    = desc;

            if (whatsapp) {
                contactBtnEl.href = 'https://wa.me/' + whatsapp;
            } else {
                contactBtnEl.removeAttribute('href');
            }
        });
    });
});
</script>
@endpush
