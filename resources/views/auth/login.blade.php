<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h4 class="text-center mb-4">Masuk</h4>

                    <form method="POST" action="{{ url('/login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email / Username</label>
                            <input type="text" name="login" class="form-control" value="{{ old('login') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        <button class="btn btn-success w-100">Masuk</button>

                        <p class="text-center mt-3">
                            Belum punya akun?
                            <a href="{{ route('register') }}">Daftar</a>
                        </p>

                    </form>

                    @if($errors->any())
                        <div class="alert alert-danger mt-3">
                            {{ $errors->first() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
