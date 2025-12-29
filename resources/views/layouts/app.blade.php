<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">

<title>{{ $title ?? 'KosConnect' }}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body{ background:#f5f6fa }
    .navbar-brand{ font-weight:bold }
</style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">

        <a class="navbar-brand" href="#">
            KosConnect
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav me-auto">

                @if(Auth::user()->role=='owner')

                    <li class="nav-item">
                        <a href="{{ route('owner.dashboard') }}" class="nav-link">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('owner.properties.index') }}" class="nav-link">
                            Kelola Properti
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('owner.booking.index') }}" class="nav-link">
                            Booking Masuk
                        </a>
                    </li>

                @elseif(Auth::user()->role=='user')

                    <li class="nav-item">
                        <a href="{{ route('user.dashboard') }}" class="nav-link">
                            Cari Kos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('user.booking.my') }}" class="nav-link">
                            Booking Saya
                        </a>
                    </li>

                @endif
            </ul>

            <span class="navbar-text me-3">
                Halo, {{ Auth::user()->name }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light btn-sm">Logout</button>
            </form>

        </div>
    </div>
</nav>



<div class="container py-4">

    @yield('content')

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
