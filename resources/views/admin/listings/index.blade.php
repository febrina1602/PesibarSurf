@extends('layouts.admin')

@section('title', 'Kelola Paket')

@section('admin_content')
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Manajemen Paket Usaha</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- CARD CONTAINER --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 border-bottom-0">
            
            {{-- TAB BAR NAVIGATION --}}
            <ul class="nav nav-tabs card-header-tabs" id="listingTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold" id="tour-tab" data-bs-toggle="tab" data-bs-target="#tour" type="button" role="tab">
                        <i class="fas fa-map-marked-alt me-1"></i> Paket Wisata
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="stay-tab" data-bs-toggle="tab" data-bs-target="#stay" type="button" role="tab">
                        <i class="fas fa-hotel me-1"></i> Penginapan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="oleh-tab" data-bs-toggle="tab" data-bs-target="#oleh" type="button" role="tab">
                        <i class="fas fa-gift me-1"></i> Oleh-oleh
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="trans-local-tab" data-bs-toggle="tab" data-bs-target="#trans-local" type="button" role="tab">
                        <i class="fas fa-motorcycle me-1"></i> Transportasi Daerah
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="trans-inter-tab" data-bs-toggle="tab" data-bs-target="#trans-inter" type="button" role="tab">
                        <i class="fas fa-bus me-1"></i> Transportasi Luar
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="listingTabsContent">
                
                {{-- TAB 1: PAKET WISATA --}}
                <div class="tab-pane fade show active" id="tour" role="tabpanel">
                    @include('admin.listings.partials.table', [
                        'data' => $tours, 
                        'type' => 'tour', 
                        'cols' => ['Nama Paket', 'Agen', 'Durasi', 'Harga/Org'],
                        'routeDelete' => 'admin.listings.tours.destroy'
                    ])
                </div>

                {{-- TAB 2: PENGINAPAN --}}
                <div class="tab-pane fade" id="stay" role="tabpanel">
                     @include('admin.listings.partials.table', [
                        'data' => $penginapan, 
                        'type' => 'stay', 
                        'cols' => ['Nama Penginapan', 'Agen', 'Lokasi', 'Harga Mulai'],
                        'routeDelete' => 'admin.listings.penginapan.destroy'
                    ])
                </div>

                {{-- TAB 3: OLEH-OLEH --}}
                <div class="tab-pane fade" id="oleh" role="tabpanel">
                    @include('admin.listings.partials.table', [
                        'data' => $olehOleh, 
                        'type' => 'oleh', 
                        'cols' => ['Nama Toko', 'Agen', 'Lokasi', 'Range Harga'],
                        'routeDelete' => 'admin.listings.oleh-oleh.destroy'
                    ])
                </div>

                {{-- TAB 4: TRANSPORT DAERAH --}}
                <div class="tab-pane fade" id="trans-local" role="tabpanel">
                    @include('admin.listings.partials.table', [
                        'data' => $transportDaerah, 
                        'type' => 'trans_local', 
                        'cols' => ['Nama Rental', 'Tipe', 'Agen', 'Tarif'],
                        'routeDelete' => 'admin.listings.transport-daerah.destroy'
                    ])
                </div>

                {{-- TAB 5: TRANSPORT LUAR --}}
                <div class="tab-pane fade" id="trans-inter" role="tabpanel">
                    @include('admin.listings.partials.table', [
                        'data' => $transportLuar, 
                        'type' => 'trans_inter', 
                        'cols' => ['Nama Travel/PO', 'Tipe', 'Agen', 'Rute/Lokasi'],
                        'routeDelete' => 'admin.listings.transport-luar.destroy'
                    ])
                </div>

            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    /* Custom Style untuk Tab agar senada */
    .nav-tabs .nav-link { color: #6c757d; }
    .nav-tabs .nav-link.active { color: #4e73df; border-bottom: 3px solid #4e73df; }
    .nav-tabs .nav-link:hover { border-color: #e9ecef #e9ecef #dee2e6; }
    .table img { object-fit: cover; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
</style>
@endpush