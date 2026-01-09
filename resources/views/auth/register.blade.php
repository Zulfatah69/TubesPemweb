<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
<<<<<<< HEAD
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h4 class="text-center mb-4">Daftar Akun</h4>

                    <form method="POST" action="{{ url('/register') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Daftar Sebagai</label>
                            <select class="form-select" name="role" required>
                                <option value="user">Pengguna</option>
                                <option value="owner">Pemilik</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">Daftar</button>

                        <p class="text-center mt-3">
                            Sudah punya akun?
                            <a href="{{ route('login') }}">Masuk</a>
                        </p>
=======
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - KosConnect</title>

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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .card-register {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .form-control {
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #DEE2E6;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
            border-color: var(--bs-primary);
        }

        .input-group-text {
            background: #fff;
            border-right: none;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
            color: #6c757d;
        }
        
        .form-control-icon {
            border-left: none;
        }

        /* Styling khusus Radio Button Role */
        .btn-check:checked + .btn-outline-primary {
            background-color: rgba(13, 110, 253, 0.1);
            color: var(--bs-primary);
            border-color: var(--bs-primary);
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-person-plus-fill fs-3"></i>
                </div>
                <h4 class="fw-bold text-dark">Buat Akun Baru</h4>
                <p class="text-muted small">Bergabunglah dengan komunitas KosConnect</p>
            </div>

            <div class="card card-register bg-white p-4">
                <div class="card-body">

                    <form method="POST" action="{{ url('/register') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted mb-2">DAFTAR SEBAGAI</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="role" id="roleUser" value="user" checked>
                                    <label class="btn btn-outline-primary w-100 py-3 text-start h-100 d-flex align-items-center" for="roleUser">
                                        <i class="bi bi-backpack4 fs-4 me-3"></i>
                                        <div>
                                            <div class="fw-bold">Pencari Kos</div>
                                            <div class="small opacity-75" style="font-size: 0.7rem;">Cari & Sewa Kos</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="role" id="roleOwner" value="owner">
                                    <label class="btn btn-outline-primary w-100 py-3 text-start h-100 d-flex align-items-center" for="roleOwner">
                                        <i class="bi bi-building-gear fs-4 me-3"></i>
                                        <div>
                                            <div class="fw-bold">Pemilik Kos</div>
                                            <div class="small opacity-75" style="font-size: 0.7rem;">Kelola Properti</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                    <input type="text" name="name" class="form-control form-control-icon" placeholder="Nama Anda" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-at"></i></span>
                                    <input type="text" name="username" class="form-control form-control-icon" placeholder="username" value="{{ old('username') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control form-control-icon" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">No. Telepon (WA)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                    <input type="text" name="phone" class="form-control form-control-icon" placeholder="0812..." value="{{ old('phone') }}" required>
                                </div>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-4">

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control form-control-icon" placeholder="Minimal 8 karakter" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-check2-all"></i></span>
                                <input type="password" name="password_confirmation" class="form-control form-control-icon" placeholder="Ulangi password" required>
                            </div>
                        </div>

                        <button class="btn btn-primary w-100 py-2 fw-bold shadow-sm mb-3">
                            Daftar Sekarang
                        </button>

                        <div class="text-center">
                            <p class="text-muted small mb-0">
                                Sudah punya akun?
                                <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Masuk disini</a>
                            </p>
                        </div>
>>>>>>> zulfatah

                    </form>

                    @if($errors->any())
<<<<<<< HEAD
                        <div class="alert alert-danger mt-3">
                            <ul class="mb-0">
=======
                        <div class="alert alert-danger alert-dismissible fade show mt-4 border-0 small" role="alert">
                            <ul class="mb-0 ps-3">
>>>>>>> zulfatah
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
<<<<<<< HEAD
=======
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
>>>>>>> zulfatah
                        </div>
                    @endif

                </div>
            </div>

<<<<<<< HEAD
=======
            <div class="text-center mt-4 text-muted small opacity-50">
                &copy; {{ date('Y') }} KosConnect.
            </div>

>>>>>>> zulfatah
        </div>
    </div>
</div>

</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> zulfatah
