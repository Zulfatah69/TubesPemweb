<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - KosConnect</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #0D6EFD;
            --bs-primary-rgb: 13, 110, 253;
            --kosan-bg: #F8F9FA;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--kosan-bg);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-login {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #DEE2E6;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        }

        .btn-primary {
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
        }

        .input-group-text {
            background: transparent;
            border-right: none;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }
        
        .form-control-icon {
            border-left: none;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-house-heart-fill fs-3"></i>
                </div>
                <h4 class="fw-bold text-dark">Selamat Datang</h4>
                <p class="text-muted small">Silakan masuk untuk melanjutkan</p>
            </div>

            <div class="card card-login bg-white p-4">
                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show text-center fs-6" role="alert">
                            {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Email / Username</label>
                            <div class="input-group">
                                <span class="input-group-text text-muted border-end-0">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="login" class="form-control ps-0 border-start-0" placeholder="Masukkan ID Anda" value="{{ old('login') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Password</label>
                            <div class="input-group">
                                <span class="input-group-text text-muted border-end-0">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="password" class="form-control ps-0 border-start-0" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small text-muted" for="remember">
                                    Ingat saya
                                </label>
                            </div>
                            </div>

                        <button class="btn btn-primary w-100 mb-3 shadow-sm">
                            Masuk
                        </button>

                        <div class="text-center">
                            <p class="text-muted small mb-0">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Daftar Sekarang</a>
                            </p>
                        </div>

                    </form>
                </div>
            </div>

            <div class="text-center mt-4 text-muted small opacity-50">
                &copy; {{ date('Y') }} KosConnect. All rights reserved.
            </div>

        </div>
    </div>
</div>

</body>
</html>