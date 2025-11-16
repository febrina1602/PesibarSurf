@extends('layouts.admin')

@section('title', 'Edit Agen: ' . $agent->name) 

@section('admin_content')

    <h1 class="h3 mb-4 text-gray-800">{{ $agent->name }}</h1> 

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header border-0 py-3">
            <h6 class="m-0 fw-bold text-dark">Formulir Edit Data Agen</h6>
        </div>
        <div class="card-body">
            <p class="text-muted small">Perhatian: Form ini hanya untuk mengedit data teks. Admin tidak dapat mengubah file KTP atau berkas izin usaha milik agen.</p>
            <hr>
            
            <form action="{{ route('admin.agents.update', $agent->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Agensi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $agent->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="agent_type" class="form-label">Tipe Agen <span class="text-danger">*</span></label>
                    <select class="form-select @error('agent_type') is-invalid @enderror" id="agent_type" name="agent_type" required>
                        <option value="TOUR" {{ old('agent_type', $agent->agent_type) == 'TOUR' ? 'selected' : '' }}>TOUR</option>
                        <option value="RENTAL" {{ old('agent_type', $agent->agent_type) == 'RENTAL' ? 'selected' : '' }}>RENTAL</option>
                        <option value="BOTH" {{ old('agent_type', $agent->agent_type) == 'BOTH' ? 'selected' : '' }}>BOTH</option>
                    </select>
                    @error('agent_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" name="address" rows="3">{{ old('address', $agent->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi Agensi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="5">{{ old('description', $agent->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.agents.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

@endsection