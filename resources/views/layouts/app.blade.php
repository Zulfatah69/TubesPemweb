<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">

<title>{{ $title ?? 'KosConnect' }}</title>

<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- GOOGLE FONT : INTER -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- CSS KUSTOM -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-semibold" href="{{ url('/') }}">
            KosConnect
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav me-auto">

                {{-- MENU SAAT LOGIN --}}
                @auth

                    {{-- OWNER --}}
                    @if(Auth::user()->role === 'owner')

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

                        <li class="nav-item">
                            <a href="{{ route('owner.chats') }}" class="nav-link">
                                💬 Chat Masuk
                            </a>
                        </li>

                    {{-- USER --}}
                    @elseif(Auth::user()->role === 'user')

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

                        <li class="nav-item">
                            <a href="{{ route('user.chats') }}" class="nav-link">
                                💬 Chat Saya
                            </a>
                        </li>

                    @endif

                @endauth
            </ul>

            {{-- KANAN NAVBAR --}}
            @auth
                <span class="navbar-text me-3 text-white">
                    Halo, {{ Auth::user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-light btn-sm">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                    Login
                </a>
            @endauth

        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container py-4">
    @yield('content')
</div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
