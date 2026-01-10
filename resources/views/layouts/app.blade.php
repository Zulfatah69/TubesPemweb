<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KosConnect' }}</title>

    {{-- BOOTSTRAP --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- ICON --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    {{-- GLOBAL STYLE --}}
    <style>
        :root {
            --bs-primary: #0D6EFD;
            --bs-primary-rgb: 13, 110, 253;
            --bs-secondary: #6C757D;
            --bs-success: #198754;
            --bs-warning: #FFC107;
            --bs-danger: #DC3545;
            --kosan-bg-section: #F8F9FA;
            --kosan-text-main: #212529;
            --kosan-border: #DEE2E6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--kosan-bg-section);
            color: var(--kosan-text-main);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            background-color: var(--bs-primary) !important;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,.1);
        }

        .navbar-brand {
            font-weight: 700;
        }

        .nav-link {
            font-weight: 500;
        }

        main {
            flex: 1;
        }

        .card {
            border-radius: 12px;
            border: 1px solid var(--kosan-border);
            background: #fff;
        }

        footer {
            background: #fff;
            border-top: 1px solid var(--kosan-border);
            margin-top: auto;
        }
    </style>

    {{-- APP CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="
        @auth
            @if(Auth::user()->role === 'owner')
                {{ route('owner.dashboard') }}
            @elseif(Auth::user()->role === 'user')
                {{ route('user.dashboard') }}
            @elseif(Auth::user()->role === 'admin')
                {{ url('/admin/dashboard') }}
            @else
                {{ url('/') }}
            @endif
        @else
            {{ url('/') }}
        @endauth
        ">
            <i class="bi bi-house-heart-fill me-1"></i> KosConnect
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
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
                               class="nav-link {{ request()->routeIs('owner.chats') ? 'active' : '' }}">
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
                        <li class="nav-item">
                            <a href="{{ route('user.chats') }}"
                               class="nav-link {{ request()->routeIs('user.chats') ? 'active' : '' }}">
                                <i class="bi bi-chat-dots"></i> Chat
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            {{-- RIGHT --}}
            <div class="d-flex align-items-center gap-3">
                @auth
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown" href="#">
                            Halo, {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light text-primary fw-medium px-4">
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

        {{-- ALERT --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

{{-- FOOTER --}}
<footer class="py-4 text-center text-muted">
    <small>&copy; {{ date('Y') }} KosConnect</small>
</footer>

{{-- BOOTSTRAP JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- ✅ WILAYAH JS (GLOBAL, PASTI KE-LOAD) --}}
<script src="{{ asset('js/wilayah.js') }}"></script>

{{-- STACK SCRIPT LAIN --}}
@stack('scripts')

</body>
</html>
