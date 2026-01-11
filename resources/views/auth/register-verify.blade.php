@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            {{-- HEADER --}}
            <div class="text-center mb-4">
                <h4 class="fw-bold text-dark">Lengkapi Profil</h4>
                <p class="text-muted">Kode verifikasi telah dikirim ke <span class="fw-bold text-primary">{{ $email }}</span></p>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <form method="POST" action="{{ route('register.complete') }}">
                        @csrf
                        
                        {{-- HIDDEN EMAIL --}}
                        <input type="hidden" name="email" value="{{ $email }}">

                        {{-- SEKSI 1: VERIFIKASI --}}
                        <div class="mb-4 bg-light p-3 rounded-3 border border-secondary-subtle">
                            <label class="form-label fw-bold small text-muted text-uppercase">Kode Verifikasi (OTP)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-primary border-end-0">
                                    <i class="bi bi-shield-lock-fill"></i>
                                </span>
                                <input type="text" name="code" class="form-control border-start-0 ps-0 fw-bold letter-spacing-2" placeholder="Masukkan Kode" required autofocus>
                            </div>
                            <div class="form-text small">Cek inbox atau folder spam email kamu.</div>
                        </div>

                        {{-- SEKSI 2: DATA DIRI --}}
                        <h6 class="fw-bold mb-3 border-bottom pb-2">Informasi Akun</h6>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small text-muted fw-bold">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-person"></i></span>
                                    <input name="name" class="form-control border-start-0 ps-0" placeholder="Nama Kamu" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted fw-bold">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-at"></i></span>
                                    <input name="username" class="form-control border-start-0 ps-0" placeholder="username_unik" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-muted fw-bold">Nomor WhatsApp / HP</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-whatsapp"></i></span>
                                <input name="phone" type="number" class="form-control border-start-0 ps-0" placeholder="0812..." required>
                            </div>
                        </div>

                        {{-- SEKSI 3: PILIH ROLE (DESIGN BARU) --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase mb-2">Saya mendaftar sebagai</label>
                            <div class="row g-2">
                                {{-- Opsi User --}}
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="role" id="roleUser" value="user" checked>
                                    <label class="btn btn-outline-primary w-100 p-3 text-start h-100" for="roleUser">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-backpack4 fs-4 me-2"></i>
                                            <span class="fw-bold">Pencari Kos</span>
                                        </div>
                                        <small class="d-block text-muted lh-sm" style="font-size: 0.75rem;">Saya ingin mencari dan menyewa kamar kos.</small>
                                    </label>
                                </div>
                                
                                {{-- Opsi Owner --}}
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="role" id="roleOwner" value="owner">
                                    <label class="btn btn-outline-primary w-100 p-3 text-start h-100" for="roleOwner">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-building-gear fs-4 me-2"></i>
                                            <span class="fw-bold">Pemilik Kos</span>
                                        </div>
                                        <small class="d-block text-muted lh-sm" style="font-size: 0.75rem;">Saya ingin mengiklankan dan mengelola kosan.</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="role" id="roleAdmin" value="admin">
                            <label class="btn btn-outline-danger w-100 p-3 text-start h-100" for="roleAdmin">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-shield-lock fs-4 me-2"></i>
                                    <span class="fw-bold">Administrator</span>
                                </div>
                                <small class="d-block text-muted lh-sm" style="font-size: 0.75rem;">
                                    Akses penuh ke sistem (khusus setup).
                                </small>
                            </label>
                        </div>


                        {{-- SEKSI 4: KEAMANAN --}}
                        <h6 class="fw-bold mb-3 border-bottom pb-2">Keamanan</h6>

                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-muted fw-bold">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-check2-all"></i></span>
                                <input type="password" name="password_confirmation" class="form-control border-start-0 ps-0" placeholder="Ulangi password" required>
                            </div>
                        </div>

                        <button class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                            Selesaikan Pendaftaran <i class="bi bi-arrow-right-circle ms-1"></i>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling khusus untuk input kode agar hurufnya berjarak (easier to read) */
    .letter-spacing-2 {
        letter-spacing: 2px;
    }
    
    /* Styling agar input group focus terlihat rapi */
    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        border-radius: 0.375rem;
    }
    .input-group:focus-within .form-control, 
    .input-group:focus-within .input-group-text {
        border-color: var(--bs-primary);
    }
    .input-group-text {
        border-color: #dee2e6;
    }
</style>
@endsection