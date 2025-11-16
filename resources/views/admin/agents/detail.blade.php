@extends('layouts.admin')

@section('title', 'Detail Agen: ' . $agent->name) {{-- Menggunakan 'name' --}}

@section('admin_content')

    <h1 class="h3 mb-4 text-gray-800">Detail {{ $agent->name }}</h1> {{-- Menggunakan 'name' --}}

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header border-0 py-3">
                    <h6 class="m-0 fw-bold text-dark">Banner Agensi</h6>
                </div>
                <div class="card-body text-center">
                    @if($agent->banner_image_url)
                        <img src="{{ asset('storage/' . $agent->banner_image_url) }}" 
                             alt="Banner Agensi" class="img-fluid rounded"
                             onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}'; this.alt='Gambar tidak ditemukan'">
                    @else
                        <p class="text-muted">Agen ini belum mengunggah banner.</p>
                    @endif
                </div>
            </div>
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header border-0 py-3">
                    <h6 class="m-0 fw-bold text-dark">Informasi Agen</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 30%;">Nama Agensi</th>
                            <td>{{ $agent->name }}</td> 
                        </tr>
                        <tr>
                            <th>Tipe Agen</th>
                            <td>{{ $agent->agent_type }}</td> 
                        </tr>
                        <tr>
                            <th>Status Verifikasi</th>
                            <td>
                                @if($agent->is_verified)
                                    <span class="badge bg-success">Sudah Diverifikasi</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Alamat Lengkap</th>
                            <td>{{ $agent->address ?? '-' }}</td> 
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $agent->description ?? '-' }}</td> 
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header border-0 py-3">
                    <h6 class="m-0 fw-bold text-dark">Informasi Pemilik</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 30%;">Nama Pemilik</th>
                            <td>{{ optional($agent->user)->full_name ?? 'Data User Hilang' }}</td>
                        </tr>
                        <tr>
                            <th>Email Login</th>
                            <td>{{ optional($agent->user)->email ?? 'Data User Hilang' }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>{{ optional($agent->user)->phone_number ?? 'Data User Hilang' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header border-0 py-3">
                    <h6 class="m-0 fw-bold text-dark">Berkas Verifikasi (KTP)</h6>
                </div>
                <div class="card-body text-center">
                    @if($agent->file_ktp_url)
                        @php
                            $ktpExtension = pathinfo($agent->file_ktp_url, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array(strtolower($ktpExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <img src="{{ asset('storage/' . $agent->file_ktp_url) }}" 
                                 alt="Foto KTP" class="img-fluid rounded"
                                 onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}'; this.alt='Gambar KTP tidak ditemukan'">
                        @elseif(strtolower($ktpExtension) == 'pdf')
                            <a href="{{ asset('storage/' . $agent->file_ktp_url) }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-file-pdf me-2"></i> Lihat KTP (PDF)
                            </a>
                        @else
                            <p class="text-danger">Format file tidak didukung.</p>
                        @endif
                    @else
                        <p class="text-muted">Agen ini belum mengunggah foto KTP.</p>
                    @endif
                </div>
            </div>
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header border-0 py-3">
                    <h6 class="m-0 fw-bold text-dark">Berkas Izin Usaha (SIUP/SKU/NIB)</h6>
                </div>
                <div class="card-body text-center">
                    @if($agent->file_siup_url)
                         @php
                            $siupExtension = pathinfo($agent->file_siup_url, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array(strtolower($siupExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <img src="{{ asset('storage/' . $agent->file_siup_url) }}" 
                                 alt="Foto SIUP/SKU/NIB" class="img-fluid rounded"
                                 onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}'; this.alt='Gambar izin usaha tidak ditemukan'">
                        @elseif(strtolower($siupExtension) == 'pdf')
                            <a href="{{ asset('storage/' . $agent->file_siup_url) }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-file-pdf me-2"></i> Lihat Berkas (PDF)
                            </a>
                        @else
                            <p class="text-danger">Format file tidak didukung.</p>
                        @endif
                    @else
                        <p class="text-muted">Agen ini belum mengunggah berkas izin usaha.</p>
                    @endif
                </div>
            </div>

            <div class="d-grid gap-2">
                @if(!$agent->is_verified)
                    <form action="{{ route('admin.agents.approve', $agent->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin memverifikasi agen ini?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-check me-2"></i> Approve (Verifikasi)
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.agents.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

@endsection