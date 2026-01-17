<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - KosConnect</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

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
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            background-image: radial-gradient(circle at 20% 150%, rgba(51, 65, 85, 0.05) 0%, transparent 50%),
                              radial-gradient(circle at 80% -10%, rgba(51, 65, 85, 0.05) 0%, transparent 50%);
        }

        .card-login {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        .login-header-icon {
            background-color: var(--slate-800);
            color: white;
            width: 64px;
            height: 64px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(30, 41, 59, 0.25);
        }

        .form-label {
            color: var(--slate-700);
            letter-spacing: 0.025em;
            margin-bottom: 0.5rem;
        }

        .input-group {
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.2s ease;
            border: 1.5px solid #e2e8f0;
        }

        .input-group:focus-within {
            border-color: var(--slate-600);
            box-shadow: 0 0 0 4px rgba(71, 85, 105, 0.05);
        }

        .input-group-text {
            background-color: white;
            border: none;
            color: var(--slate-400);
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

        .btn-slate {
            background-color: var(--slate-800);
            color: white;
            padding: 12px;
            border-radius: 10px;
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

        .form-check-input:checked {
            background-color: var(--slate-800);
            border-color: var(--slate-800);
        }

        .register-link {
            color: var(--slate-800);
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .register-link:hover {
            color: var(--slate-600);
            text-decoration: underline;
        }

        /* Alert Styling */
        .alert-custom {
            border-radius: 10px;
            border: none;
            background-color: #fee2e2;
            color: #991b1b;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <div class="text-center mb-4">
                <div class="login-header-icon">
                    <i class="bi bi-houses-fill fs-2"></i>
                </div>
                <h3 class="fw-bold text-slate-800 mb-1">KosConnect</h3>
                <p class="text-muted small">Kelola hunian dengan lebih cerdas</p>
            </div>

            <div class="card card-login bg-white p-4 p-md-5">
                <div class="card-body p-0">

                    @if($errors->any())
                        <div class="alert alert-custom alert-dismissible fade show text-center mb-4" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Email / Username</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input type="text" name="login" class="form-control" placeholder="ID Pengguna" value="{{ old('login') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-shield-lock text-muted"></i>
                                </span>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small text-muted" for="remember">
                                    Ingat saya
                                </label>
                            </div>
                            <a href="#" class="small text-muted text-decoration-none">Lupa password?</a>
                        </div>

                        <button class="btn btn-slate w-100 mb-4 shadow-sm">
                            Masuk ke Akun
                        </button>

                        <div class="text-center">
                            <p class="text-muted small mb-0">
                                Belum punya akun? 
                                <a href="{{ route('register') }}" class="register-link">Daftar Sekarang</a>
                            </p>
                        </div>

                    </form>
                </div>
            </div>

            <div class="text-center mt-5">
                <p class="text-muted small opacity-75 mb-0">
                    &copy; {{ date('Y') }} <strong>KosConnect</strong>. <br>
                    Platform Manajemen Kos Modern.
                </p>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>