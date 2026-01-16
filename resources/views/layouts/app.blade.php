<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'KosConnect' }}</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    {{-- CSS Global --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- CSS per halaman --}}
    @stack('styles')
</head>

<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">

        {{-- BRAND --}}
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            <i class="bi bi-house-heart-fill me-1"></i> KosConnect
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">

            {{-- KIRI --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                @auth

                    {{-- OWNER --}}
                    @if(Auth::user()->role === 'owner')
                        <li class="nav-item">
                            <a href="{{ route('owner.dashboard') }}"
                               class="nav-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('owner.properties.index') }}"
                               class="nav-link {{ request()->routeIs('owner.properties*') ? 'active' : '' }}">
                                Kelola Properti
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('owner.booking.index') }}"
                               class="nav-link {{ request()->routeIs('owner.booking*') ? 'active' : '' }}">
                                Booking Masuk
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('owner.chats') }}"
                               class="nav-link {{ request()->routeIs('owner.chats*') ? 'active' : '' }}">
                                <i class="bi bi-chat-dots"></i> Chat
                            </a>
                        </li>

                    {{-- USER --}}
                    @elseif(Auth::user()->role === 'user')

                        <li class="nav-item">
                            <a href="{{ route('user.dashboard') }}"
                               class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                                Cari Kos
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.booking.my') }}"
                               class="nav-link {{ request()->routeIs('user.booking*') ? 'active' : '' }}">
                                Booking Saya
                            </a>
                        </li>

                        @if(Route::has('user.chats'))
                            <li class="nav-item">
                                <a href="{{ route('user.chats') }}"
                                   class="nav-link {{ request()->routeIs('user.chats*') ? 'active' : '' }}">
                                    <i class="bi bi-chat-dots"></i> Chat
                                </a>
                            </li>
                        @endif

                    @endif
                @endauth

            </ul>

            {{-- KANAN --}}
            <div class="d-flex align-items-center gap-3">

                @auth
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-medium"
                           href="#" role="button" data-bs-toggle="dropdown">
                            Halo, {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="btn btn-light fw-medium text-primary px-4 shadow-sm">
                        Login
                    </a>
                @endauth

            </div>
        </div>
    </div>
</nav>

{{-- CONTENT --}}
<main class="py-4">
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

{{-- FOOTER --}}
<footer class="py-4 text-center text-muted">
    <div class="container">
        <small>&copy; {{ date('Y') }} KosConnect. All rights reserved.</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
