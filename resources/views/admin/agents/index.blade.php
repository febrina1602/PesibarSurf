@extends('layouts.admin')

@section('title', 'Kelola Agen & Verifikasi - PesibarSurf')

@section('admin_content')

    <h1 class="h3 mb-4 text-gray-800">Kelola Agen & Verifikasi</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header border-0 py-3">
            <h6 class="m-0 fw-bold text-dark">Daftar Agen Pemandu Wisata</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Agen</th>
                            <th>Tipe Agen</th>
                            <th>No. Telepon</th>
                            <th>Status</th>
                            <th style="width: 280px;">Aksi</th> 
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse ($agents as $agent)
                            <tr class="{{ !$agent->is_verified ? 'table-warning' : '' }}">
                                
                                <td>
                                    <strong>{{ $agent->name }}</strong>
                                </td>
                                <td>{{ $agent->agent_type }}</td>
                                <td>{{ optional($agent->user)->phone_number ?? '-' }}</td>
                                <td>
                                    @if($agent->is_verified)
                                        <span class="badge bg-success">Sudah Diverifikasi</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.agents.show', $agent->id) }}" class="btn btn-info btn-sm" title="Lihat Detail & Berkas">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    
                                    <a href="{{ route('admin.agents.edit', $agent->id) }}" class="btn btn-warning btn-sm" title="Edit Data Teks">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.agents.destroy', $agent->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('PERINGATAN: Anda akan menghapus profil agen {{ $agent->name }}. Ini tidak akan menghapus akun user-nya. Lanjutkan?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus Profil Agen">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>

                                    @if(!$agent->is_verified)
                                        <form action="{{ route('admin.agents.approve', $agent->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Anda yakin ingin memverifikasi agen {{ $agent->name }}?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm mt-1 w-100" title="Approve">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada profil agen yang terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if ($agents->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $agents->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection