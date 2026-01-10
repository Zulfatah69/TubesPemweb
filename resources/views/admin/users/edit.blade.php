@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Edit Pengguna</h4>
            <p class="text-muted small mb-0">Perbarui data atau hak akses pengguna.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-person-gear me-2"></i> Form Edit Data
                    </h6>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf 
                        @method('PUT')

                        {{-- NAMA --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        {{-- ROLE --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Role / Peran</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary"><i class="bi bi-shield-lock"></i></span>
                                <select name="role" class="form-select">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User (Pencari Kos)</option>
                                    <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner (Pemilik Kos)</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                            <div class="form-text small text-muted">
                                <i class="bi bi-info-circle me-1"></i> Perubahan role akan mengubah hak akses user.
                            </div>
                        </div>

                        <hr class="opacity-25 mb-4">

                        {{-- BUTTONS --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold py-2">
                                <i class="bi bi-save me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light text-muted">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection