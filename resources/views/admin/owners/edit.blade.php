@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Edit Pengguna</h4>
            <p class="text-muted small mb-0">Ubah data profil atau hak akses pengguna.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            {{-- ALERT ERROR --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i> Gagal menyimpan perubahan:
                    <ul class="mb-0 mt-2 ps-3 small">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-primary"><i class="bi bi-person-gear me-2"></i>Form Edit</h6>
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        {{-- Role --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Role / Peran</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-shield-lock"></i></span>
                                <select name="role" class="form-select" required>
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User (Pencari Kos)</option>
                                    <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner (Pemilik Kos)</option>
                                    {{-- Jika ada admin, tambahkan opsi admin di sini --}}
                                </select>
                            </div>
                            <div class="form-text small text-muted mt-1">
                                <i class="bi bi-info-circle me-1"></i> Mengubah role akan mengubah hak akses user ini.
                            </div>
                        </div>

                        <hr class="opacity-25 mb-4">

                        {{-- Tombol Aksi --}}
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary fw-bold">
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