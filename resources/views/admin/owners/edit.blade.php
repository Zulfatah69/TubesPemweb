@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container py-5">

    {{-- HEADER --}}
    <div class="row justify-content-center mb-4">
        <div class="col-md-6 col-lg-5 d-flex justify-content-between align-items-end">
            <div>
                <h4 class="fw-bold text-slate-800 mb-1">Edit Pengguna</h4>
                <p class="text-muted small mb-0">Perbarui informasi profil dan hak akses.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-link text-muted text-decoration-none small p-0 mb-1">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    {{-- FORM CARD --}}
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            {{-- ALERT ERROR --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" style="border-left: 4px solid #dc3545 !important;">
                    <div class="d-flex">
                        <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Gagal Menyimpan</h6>
                            <ul class="mb-0 ps-3 small">
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
                <div class="card-header bg-light py-3 border-bottom border-light">
                    <h6 class="mb-0 fw-bold text-slate-700">
                        <i class="bi bi-person-gear me-2"></i>Informasi Akun
                    </h6>
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-slate-600">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="name" class="form-control border-start-0 ps-0 custom-focus" 
                                       placeholder="Masukkan nama lengkap" 
                                       value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-slate-600">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control border-start-0 ps-0 custom-focus" 
                                       placeholder="nama@email.com"
                                       value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        {{-- Role --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-slate-600">Role / Peran</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted">
                                    <i class="bi bi-shield-lock"></i>
                                </span>
                                <select name="role" class="form-select border-start-0 ps-0 custom-focus" required>
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User (Pencari Kos)</option>
                                    <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner (Pemilik Kos)</option>
                                </select>
                            </div>
                            <div class="d-flex align-items-start mt-2 px-1">
                                <i class="bi bi-info-circle text-muted me-2 small"></i>
                                <span class="text-muted" style="font-size: 0.75rem;">
                                    Perubahan peran akan langsung berdampak pada fitur yang dapat diakses pengguna.
                                </span>
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        {{-- Tombol Aksi --}}
                        <div class="d-grid gap-2">
                            <button class="btn btn-dark fw-bold py-2 shadow-sm border-0" style="background-color: #334155;">
                                <i class="bi bi-check-lg me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light text-secondary py-2 border">
                                Batalkan
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small">User ID: <span class="fw-medium">#{{ $user->id }}</span> | Terdaftar pada {{ $user->created_at->format('d/m/Y') }}</p>
            </div>

        </div>
    </div>
</div>

<style>
    /* Professional Grey Palette & Form Styling */
    .text-slate-800 { color: #1e293b; }
    .text-slate-700 { color: #334155; }
    .text-slate-600 { color: #475569; }
    .bg-light { background-color: #f8fafc !important; }
    
    .form-control, .form-select, .input-group-text {
        border-color: #e2e8f0;
        padding-top: 0.6rem;
        padding-bottom: 0.6rem;
    }

    .custom-focus:focus {
        border-color: #94a3b8;
        box-shadow: 0 0 0 0.25rem rgba(148, 163, 184, 0.1);
        z-index: 3;
    }

    .btn-dark:hover {
        background-color: #1e293b !important;
    }

    .card-header {
        border-bottom: 1px solid #f1f5f9 !important;
    }
</style>
@endsection