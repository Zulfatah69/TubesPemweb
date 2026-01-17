@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            {{-- HEADER --}}
            <div class="text-center mb-5">
                <h3 class="fw-bold text-slate-800 mb-2">Lengkapi Profil Anda</h3>
                <p class="text-muted">
                    Kode keamanan telah dikirim ke 
                    <span class="badge bg-slate-100 text-slate-700 fw-bold px-2 py-1">{{ $email }}</span>
                </p>
            </div>

            @if(session('success'))
                <div class="alert alert-success-custom d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <div class="card border-0 shadow-lg p-2" style="border-radius: 24px;">
                <div class="card-body p-4 p-md-5">

                    <form method="POST" action="{{ route('register.complete') }}">
                        @csrf
                        
                        {{-- HIDDEN EMAIL --}}
                        <input type="hidden" name="email" value="{{ $email }}">

                        {{-- SEKSI 1: VERIFIKASI (OTP) --}}
                        <div class="mb-5 bg-slate-50 p-4 rounded-4 border border-dashed border-slate-300">
                            <label class="form-label fw-bold small text-slate-600 text-uppercase tracking-wider mb-3 d-block text-center">
                                Kode Verifikasi (OTP)
                            </label>
                            <div class="d-flex justify-content-center">
                                <div class="input-group custom-input-group shadow-sm" style="max-width: 300px;">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-shield-check text-slate-800"></i>
                                    </span>
                                    <input type="text" name="code" class="form-control border-start-0 ps-0 fw-bold text-center letter-spacing-4" placeholder="000000" maxlength="6" required autofocus>
                                </div>
                            </div>
                            <div class="form-text text-center mt-3 small text-muted">
                                <i class="bi bi-info-circle me-1"></i> Periksa kotak masuk atau folder spam Anda secara berkala.
                            </div>
                        </div>

                        {{-- SEKSI 2: DATA DIRI --}}
                        <div class="d-flex align-items-center mb-4">
                            <div class="section-badge me-3">1</div>
                            <h6 class="fw-bold text-slate-800 mb-0">Informasi Identitas</h6>
                            <div class="flex-grow-1 ms-3 border-bottom border-slate-100"></div>
                        </div>
                        
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small text-slate-600 fw-bold text-uppercase">Nama Lengkap</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-person"></i></span>
                                    <input name="name" class="form-control border-start-0 ps-0" placeholder="Nama Sesuai KTP" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-slate-600 fw-bold text-uppercase">Username</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-at"></i></span>
                                    <input name="username" class="form-control border-start-0 ps-0" placeholder="username_kamu" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label small text-slate-600 fw-bold text-uppercase">Nomor WhatsApp Aktif</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-whatsapp"></i></span>
                                    <input name="phone" type="number" class="form-control border-start-0 ps-0" placeholder="0812XXXXXXXX" required>
                                </div>
                            </div>
                        </div>

                        {{-- SEKSI 3: PILIH ROLE --}}
                        <div class="d-flex align-items-center mb-4">
                            <div class="section-badge me-3">2</div>
                            <h6 class="fw-bold text-slate-800 mb-0">Tipe Pengguna</h6>
                            <div class="flex-grow-1 ms-3 border-bottom border-slate-100"></div>
                        </div>

                        <div class="row g-3 mb-5">
                            <div class="col-sm-6">
                                <input type="radio" class="btn-check" name="role" id="roleUser" value="user" checked>
                                <label class="role-card btn btn-outline-slate w-100 p-4 text-start h-100 shadow-sm" for="roleUser">
                                    <div class="role-icon bg-slate-100 mb-3">
                                        <i class="bi bi-search"></i>
                                    </div>
                                    <div class="fw-bold text-slate-800 mb-1">Pencari Kos</div>
                                    <p class="small text-muted mb-0 lh-sm">Saya ingin mencari, booking, dan menyewa kamar kos dengan mudah.</p>
                                </label>
                            </div>
                            
                            <div class="col-sm-6">
                                <input type="radio" class="btn-check" name="role" id="roleOwner" value="owner">
                                <label class="role-card btn btn-outline-slate w-100 p-4 text-start h-100 shadow-sm" for="roleOwner">
                                    <div class="role-icon bg-slate-100 mb-3">
                                        <i class="bi bi-building-up"></i>
                                    </div>
                                    <div class="fw-bold text-slate-800 mb-1">Pemilik Kos</div>
                                    <p class="small text-muted mb-0 lh-sm">Saya ingin mengiklankan properti dan mengelola penyewa kos saya.</p>
                                </label>
                            </div>
                        </div>

                        {{-- SEKSI 4: KEAMANAN --}}
                        <div class="d-flex align-items-center mb-4">
                            <div class="section-badge me-3">3</div>
                            <h6 class="fw-bold text-slate-800 mb-0">Keamanan Password</h6>
                            <div class="flex-grow-1 ms-3 border-bottom border-slate-100"></div>
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label class="form-label small text-slate-600 fw-bold text-uppercase">Password</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-key"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-slate-600 fw-bold text-uppercase">Konfirmasi</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-check-lg"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-slate-800 w-100 py-3 fw-bold shadow transition-all rounded-3">
                            Konfirmasi & Selesaikan Pendaftaran <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --slate-800: #1e293b;
        --slate-700: #334155;
        --slate-600: #475569;
        --slate-100: #f1f5f9;
        --slate-50: #f8fafc;
    }

    body { background-color: var(--slate-50); }
    .text-slate-800 { color: var(--slate-800); }
    .text-slate-600 { color: var(--slate-600); }
    .bg-slate-50 { background-color: var(--slate-50); }
    .bg-slate-100 { background-color: var(--slate-100); }

    .letter-spacing-4 { letter-spacing: 4px; }
    .tracking-wider { letter-spacing: 0.05em; }

    /* Input Styling */
    .custom-input-group {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .custom-input-group:focus-within {
        border-color: var(--slate-800);
        box-shadow: 0 0 0 4px rgba(30, 41, 59, 0.08) !important;
    }
    .custom-input-group .form-control { border: none; padding: 12px; }
    .custom-input-group .input-group-text { border: none; padding-left: 15px; color: #94a3b8; }

    /* Role Cards */
    .role-card {
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        transition: all 0.2s ease;
        background: white;
    }
    .role-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.5rem;
        color: var(--slate-800);
        transition: all 0.2s ease;
    }
    .btn-check:checked + .role-card {
        border-color: var(--slate-800);
        background-color: var(--slate-50);
    }
    .btn-check:checked + .role-card .role-icon {
        background-color: var(--slate-800);
        color: white;
    }

    /* Section Badge */
    .section-badge {
        width: 28px;
        height: 28px;
        background-color: var(--slate-800);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: bold;
    }

    .btn-slate-800 {
        background-color: var(--slate-800);
        color: white;
        border: none;
    }
    .btn-slate-800:hover {
        background-color: var(--slate-700);
        color: white;
        transform: translateY(-2px);
    }

    .alert-success-custom {
        background-color: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 12px 16px;
    }

    .transition-all { transition: all 0.3s ease; }
</style>
@endsection