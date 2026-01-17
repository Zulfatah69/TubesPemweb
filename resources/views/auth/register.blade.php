<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - KosConnect</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">

<<<<<<< HEAD
    <style>
        :root {
            --slate-800: #1e293b;
            --slate-700: #334155;
            --slate-600: #475569;
            --slate-100: #f1f5f9;
            --slate-50: #f8fafc;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--slate-50);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 0;
            background-image: radial-gradient(circle at 10% 20%, rgba(30, 41, 59, 0.03) 0%, transparent 40%),
                              radial-gradient(circle at 90% 80%, rgba(30, 41, 59, 0.03) 0%, transparent 40%);
        }

        .card-register {
            border: none;
            border-radius: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }

        .register-header-icon {
            background-color: var(--slate-800);
            color: white;
            width: 60px;
            height: 60px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(30, 41, 59, 0.2);
        }

        .form-label {
            color: var(--slate-700);
            letter-spacing: 0.025em;
            margin-bottom: 0.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .custom-input-group {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.2s ease;
            background: white;
        }

        .custom-input-group:focus-within {
            border-color: var(--slate-800);
            box-shadow: 0 0 0 4px rgba(30, 41, 59, 0.05);
        }

        .input-group-text {
            background-color: transparent;
            border: none;
            color: #94a3b8;
            padding-left: 1rem;
        }

        .form-control {
            border: none;
            padding: 12px 12px 12px 0;
            font-size: 0.95rem;
            color: var(--slate-800);
        }

        .form-control:focus {
            box-shadow: none;
        }

        /* Role Selection Styling */
        .role-option {
            cursor: pointer;
        }

        .btn-check:checked + .role-card {
            border-color: var(--slate-800);
            background-color: var(--slate-50);
        }

        .role-card {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 15px;
            transition: all 0.2s ease;
            height: 100%;
        }

        .role-card i {
            color: var(--slate-600);
            transition: all 0.2s ease;
        }

        .btn-check:checked + .role-card i {
            color: var(--slate-800);
        }

        .btn-slate {
            background-color: var(--slate-800);
            color: white;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-slate:hover {
            background-color: var(--slate-700);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30, 41, 59, 0.15);
            color: white;
        }

        .alert-custom {
            background-color: #fee2e2;
            color: #991b1b;
            border: none;
            border-radius: 12px;
        }

        .login-link {
            color: var(--slate-800);
            font-weight: 700;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="text-center mb-4">
                <div class="register-header-icon">
                    <i class="bi bi-person-plus-fill fs-3"></i>
                </div>
                <h3 class="fw-bold text-slate-800 mb-1">Bergabung Sekarang</h3>
                <p class="text-muted small">Kelola atau temukan hunian impian Anda di KosConnect</p>
            </div>

            <div class="card card-register bg-white p-4 p-md-5">
                <div class="card-body p-0">

                    <form method="POST" action="{{ url('/register') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">Daftar Sebagai</label>
                            <div class="row g-3">
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="role" id="roleUser" value="user" checked>
                                    <label class="role-card d-flex align-items-center role-option" for="roleUser">
                                        <i class="bi bi-search fs-4 me-3"></i>
                                        <div>
                                            <div class="fw-bold text-slate-800 small">Pencari Kos</div>
                                            <div class="text-muted" style="font-size: 0.65rem;">Cari & Sewa</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="role" id="roleOwner" value="owner">
                                    <label class="role-card d-flex align-items-center role-option" for="roleOwner">
                                        <i class="bi bi-house-gear fs-4 me-3"></i>
                                        <div>
                                            <div class="fw-bold text-slate-800 small">Pemilik Kos</div>
                                            <div class="text-muted" style="font-size: 0.65rem;">Kelola Properti</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Nama Anda" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Username</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text"><i class="bi bi-at"></i></span>
                                    <input type="text" name="username" class="form-control" placeholder="username" value="{{ old('username') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">No. WhatsApp</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                    <input type="text" name="phone" class="form-control" placeholder="0812..." value="{{ old('phone') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Password</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Konfirmasi</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-slate w-100 mb-4 shadow-sm">
                            Buat Akun Sekarang
                        </button>

                        <div class="text-center">
                            <p class="text-muted small mb-0">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="login-link">Masuk disini</a>
                            </p>
                        </div>

                    </form>

                    @if($errors->any())
                        <div class="alert alert-custom alert-dismissible fade show mt-4 small" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                </div>
            </div>

            <div class="text-center mt-5">
                <p class="text-muted small opacity-75">
                    &copy; {{ date('Y') }} <strong>KosConnect</strong>. <br>
                    Manajemen Properti Jadi Lebih Mudah.
                </p>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>