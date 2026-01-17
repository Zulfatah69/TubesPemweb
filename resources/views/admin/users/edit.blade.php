@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="container py-5">

    {{-- HEADER --}}
    <div class="row justify-content-center mb-4">
        <div class="col-md-6 col-lg-5 d-flex justify-content-between align-items-end">
            <div>
                <h4 class="fw-bold text-slate-800 mb-1">Pengaturan Akun</h4>
                <p class="text-muted small mb-0">Ubah kredensial dan tingkat akses pengguna.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-link text-muted text-decoration-none small p-0 mb-1">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    {{-- FORM CARD --}}
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            {{-- ALERT VALIDASI (Opsional jika belum ada di Controller) --}}
            @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4 small" style="border-left: 4px solid #dc3545 !important;">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h6 class="mb-0 fw-bold text-slate-700">
                        <i class="bi bi-person-gear me-2"></i>Detail Informasi
                    </h6>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf 
                        @method('PUT')

                        {{-- NAMA --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-slate-600">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="name" class="form-control border-start-0 ps-0 custom-focus" 
                                       value="{{ old('name', $user->name) }}" placeholder="Masukkan nama" required>
                            </div>
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-slate-600">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control border-start-0 ps-0 custom-focus" 
                                       value="{{ old('email', $user->email) }}" placeholder="email@contoh.com" required>
                            </div>
                        </div>

                        {{-- ROLE --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-slate-600">Role / Peran Sistem</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted">
                                    <i class="bi bi-shield-lock"></i>
                                </span>
                                <select name="role" class="form-select border-start-0 ps-0 custom-focus">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User (Pencari Kos)</option>
                                    <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner (Pemilik Kos)</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                                </select>
                            </div>
                            <div class="d-flex align-items-start mt-2 px-1 text-muted">
                                <i class="bi bi-info-circle me-2 small"></i>
                                <span style="font-size: 0.75rem;">Akses fitur akan langsung berubah setelah role diperbarui.</span>
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        {{-- BUTTONS --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark fw-bold py-2 shadow-sm border-0" style="background-color: #334155;">
                                <i class="bi bi-check-lg me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light text-secondary py-2 border-0">
                                Batalkan
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small">
                    Terakhir diperbarui: <span class="fw-medium text-slate-600">{{ $user->updated_at->diffForHumans() }}</span>
                </p>
            </div>

        </div>
    </div>
</div>

<style>
    /* Professional Slate Palette */
    .text-slate-800 { color: #1e293b; }
    .text-slate-700 { color: #334155; }
    .text-slate-600 { color: #475569; }
    
    /* Form Styling */
    .form-control, .form-select, .input-group-text {
        border-color: #e2e8f0;
        padding-top: 0.65rem;
        padding-bottom: 0.65rem;
    }

    .custom-focus:focus {
        border-color: #94a3b8;
        box-shadow: 0 0 0 0.25rem rgba(148, 163, 184, 0.1);
        z-index: 3;
    }

    .btn-dark:hover {
        background-color: #1e293b !important;
        transform: translateY(-1px);
        transition: all 0.2s;
    }

    .btn-light:hover {
        background-color: #f1f5f9;
        color: #1e293b !important;
    }
</style>
@endsection