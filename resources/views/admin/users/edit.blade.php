@extends('layouts.admin')

@section('title', 'Edit Pengguna - PesibarSurf')

@section('admin_content')

    <h1 class="h3 mb-4 text-gray-800">Edit Pengguna: {{ $user->full_name }}</h1>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header border-0 py-3">
            <h6 class="m-0 fw-bold text-dark">Formulir Edit Pengguna</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT') <div class="mb-3">
                    <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                           id="full_name" name="full_name" value="{{ old('full_name', $user->full_name) }}" required>
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                           id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                    @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User (Wisatawan)</option>
                        <option value="agent" {{ old('role', $user->role) == 'agent' ? 'selected' : '' }}>Agent (Pemandu)</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Perbarui Pengguna</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

@endsection