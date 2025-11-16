@extends('layouts.admin')

@section('title', 'Admin Dashboard - PesibarSurf')

@section('admin_content')

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header border-0 py-3" style="background: linear-gradient(90deg, #D19878, #FFE75D);">
            <h6 class="m-0 fw-bold text-dark">Selamat Datang, {{ Auth::user()->full_name }}!</h6>
        </div>
    </div>

    <h3 class="h4 mb-3 text-gray-800">Statistik Sistem</h3>
    <div class="row">
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-primary shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-danger text-uppercase mb-1">
                                Total Wisatawan</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-info shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-danger text-uppercase mb-1">
                                Total Agen</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalAgents }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-success shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-danger text-uppercase mb-1">
                                Total Destinasi</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalDestinations }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-warning shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-danger text-uppercase mb-1">
                                Total Paket Tur</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalPackages }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection