<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>{{ $title ?? 'KosConnect' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            /* Palet Warna */
            --bs-primary: #0D6EFD;
            --bs-primary-rgb: 13, 110, 253;
            --bs-secondary: #6C757D;
            --bs-success: #198754;
            --bs-warning: #FFC107;
            --bs-danger: #DC3545;
            
            /* Warna Kustom Aplikasi */
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
            min-height: 100vh; /* Agar footer selalu di bawah */
        }

        /* Navbar Custom */
        .navbar {
            background-color: var(--bs-primary) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.2s;
        }
        
        /* Efek Hover Menu */
        .nav-link:hover {
            color: #fff !important;
            transform: translateY(-1px);
        }

        .nav-link.active {
            font-weight: 700;
            color: #fff !important;
        }

        /* Wrapper Konten Utama */
        main {
            flex: 1; /* Mengisi ruang kosong agar footer terdorong ke bawah */
        }

        /* Card Global */
        .card {
            border: 1px solid var(--kosan-border);
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            background-color: #FFFFFF;
        }

        /* Footer */
        footer {
            background-color: #FFFFFF;
            border-top: 1px solid var(--kosan-border);
            margin-top: auto;
        }
    </style>
    
    @if(file_exists(public_path('css/app.css')))
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-house-heart-fill me-1"></i> KosConnect
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    
                    @auth
                        {{-- MENU OWNER --}}
                        @if(Auth::user()->role === 'owner')
                            <li class="nav-item">
                                <a href="{{ route('owner.dashboard') }}" class="nav-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('owner.properties.index') }}" class="nav-link {{ request()->routeIs('owner.properties*') ? 'active' : '' }}">
                                    Kelola Properti
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('owner.booking.index') }}" class="nav-link {{ request()->routeIs('owner.booking*') ? 'active' : '' }}">
                                    Booking Masuk
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('owner.chats') }}" class="nav-link {{ request()->routeIs('owner.chats*') ? 'active' : '' }}">
                                    <i class="bi bi-chat-dots"></i> Chat
                                </a>
                            </li>

                        {{-- MENU USER --}}
                        @elseif(Auth::user()->role === 'user')
                            <li class="nav-item">
                                <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                                    Cari Kos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.booking.my') }}" class="nav-link {{ request()->routeIs('user.booking*') ? 'active' : '' }}">
                                    Booking Saya
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.chats') }}" class="nav-link {{ request()->routeIs('user.chats*') ? 'active' : '' }}">
                                    <i class="bi bi-chat-dots"></i> Chat
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                {{-- KANAN NAVBAR (Profile / Login) --}}
                <div class="d-flex align-items-center gap-3">
                    @auth
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle text-white fw-medium" href="#" role="button" data-bs-toggle="dropdown">
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
                        <a href="{{ route('login') }}" class="btn btn-light fw-medium text-primary px-4 shadow-sm">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            
            {{-- GLOBAL ALERTS --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
            
        </div>
    </main>

    <footer class="py-4 text-center text-muted">
        <div class="container">
            <small>&copy; {{ date('Y') }} KosConnect. All rights reserved.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- 
        CATATAN PENTING UNTUK WILAYAH JS:
        Pastikan kamu sudah memindahkan variabel 'const wilayah = [...]' yang panjang itu
        ke dalam file baru di: public/js/wilayah.js 
        Jika belum, hapus baris di bawah ini dan masukkan script wilayah di halaman yang butuh saja.
    --}}
    @if(file_exists(public_path('js/wilayah.js')))
        <script src="{{ asset('js/wilayah.js') }}"></script>
    @endif

    {{-- Slot untuk script tambahan per halaman --}}
    @stack('scripts')

</body>
</html>