@extends('layouts.admin')

@section('title', 'Kelola Paket Wisata')

@section('admin_content')
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Manajemen Paket Wisata</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- CARD CONTAINER --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Paket Wisata</h6>
        </div>

        <div class="card-body">
            {{-- Panggil Partial Table khusus untuk Tour --}}
            @include('admin.listings.partials.table', [
                'data' => $tours, 
                'type' => 'tour', 
                'cols' => ['Nama Paket', 'Agen', 'Durasi', 'Harga/Org'],
                'routeDelete' => 'admin.listings.tours.destroy'
            ])
        </div>
    </div>

@endsection